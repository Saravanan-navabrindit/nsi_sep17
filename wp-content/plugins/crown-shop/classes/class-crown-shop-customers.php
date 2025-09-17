<?php

use Crown\Form\Field;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Checkbox as CheckboxInput;
use Crown\ListTableColumn;
use Crown\UserSettings;
use Crown\AdminPage;

use NetSuite\NetSuiteService;
use NetSuite\Classes\Customer;
use NetSuite\Classes\UpdateRequest;
use NetSuite\Classes\AddRequest;
use NetSuite\Classes\SearchStringField;
use NetSuite\Classes\SearchMultiSelectField;
use NetSuite\Classes\SearchDateField;
use NetSuite\Classes\CustomerSearchBasic;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\StringCustomFieldRef;
use NetSuite\Classes\CustomFieldList;
use NetSuite\Classes\MultiSelectCustomFieldRef;
use NetSuite\Classes\ListOrRecordRef;
use NetSuite\Classes\SelectCustomFieldRef;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\BooleanCustomFieldRef;
use NetSuite\Classes\UpdateResponse;
use NetSuite\Classes\DateCustomFieldRef;


if ( ! class_exists( 'Crown_Shop_Customers' ) ) {

    enum Address_Type {
        case Billing;
        case Shipping;
    }

	class Crown_Shop_Customers {

		public static $init = false;

        public static $current_user;
		public static $user_settings = null;
		public static $customer_import_admin_page = null;
		public static $customer_auto_sync_data_enabled = TRUE;
		public static $customer_sync_sent_payload_enabled = FALSE;
		public static $customer_log_level = 'ERROR';
		public static $customer_prices_count_limit = 100000;
        public static string $ns_items_pricing_table_name;
        public static string $ns_groups_pricing_table_name;
        public static bool $ns_sync_customer_last_modified_date_enabled = FALSE;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			self::setPropertiesConstantsFromConfig();
            self::set_pricing_tables_names();

            add_action('plugins_loaded', array( __CLASS__, 'set_current_user' ), -2 );
            add_action( 'init', array( __CLASS__, 'setup_database_tables' ), 10 );
            add_action( 'init', array( __CLASS__, 'init_ns_inactive_customers_sync_schedule' ) );
            add_action( 'ns_inactive_customers_sync', array( __CLASS__, 'cron_ns_inactive_customers_sync' ) );
            add_action( 'after_setup_theme', array( __CLASS__, 'register_user_settings' ) );
			add_filter( 'tm_ns_customer_response', array( __CLASS__, 'filter_tm_ns_customer_response' ), 10, 3 );
            add_filter('wp_authenticate_user',  array( __CLASS__, 'restrict_inactive_users' ), 10, 1);
            add_filter('auth_cookie_expiration', array( __CLASS__, 'modify_login_session_expiration'), 10, 3);

			add_action( 'wp_ajax_tm_load_ns_price_levels', array( __CLASS__, 'sync_price_levels' ), 1 );

			add_action( 'after_setup_theme', array( __CLASS__, 'register_customer_import_admin_page' ) );
			add_action( 'admin_menu', array( __CLASS__, 'register_customer_restricted_flag_settings' ) );

            add_action( 'admin_init', array( __CLASS__, 'init_dual_shop_manager_allowed_brands_settings' ) );
			add_action( 'admin_menu', array( __CLASS__, 'init_dual_shop_manager_allowed_brands_menu_page' ) );

			add_filter( 'woocommerce_product_get_price', array( __CLASS__, 'filter_wc_get_product_price' ), 10, 2 );

			add_action( 'user_edit_form_tag', array( __CLASS__, 'user_edit_form_tag' ) );
			// add_action( 'wp_login', array( __CLASS__, 'wp_login' ), 10, 2 );
			add_action( 'set_auth_cookie', array( __CLASS__, 'set_auth_cookie' ), 10, 6 );

			add_action( 'woocommerce_before_cart', array( __CLASS__, 'auto_select_default_shipping_method' ), 10 );

			if ( class_exists( 'WP_CLI' ) ) {

				WP_CLI::add_command( 'customer sync', function( $args ) {
					global $wpdb;
					
					$ns_id = count( $args ) >= 1 ? intval( $args[0] ) : '';
					$rep_domain = count( $args ) >= 2 ? $args[1] : '';
					if ( empty( $ns_id ) ) return;

					$user_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'ns_customer_internal_id' AND meta_value = '%s' LIMIT 1", $ns_id ) );
					if ( empty( $user_id ) ) {
						$user_id = wp_create_user( $ns_id, md5( $ns_id ), 'customer-' . $ns_id . '@nsiindustries.com' );
						$user = new WP_User( $user_id );
						$user->set_role( 'customer' );
						update_user_meta( $user_id, 'ns_customer_internal_id', $ns_id );
						update_user_meta( $user_id, 'ns_customer_internal_id_imported', $ns_id );
						WP_CLI::log( 'User created' );
					}
					
					self::sync_user_ns_customer_data( $user_id );

					if ( ! empty( $rep_domain ) ) {
						update_user_meta( $user_id, 'ns_customer_rep_email_domain', $rep_domain );
					}

					WP_CLI::success( 'User synced' );

				} );

				WP_CLI::add_command( 'customer transfer', function( $args ) {
					global $wpdb;
					
					$old_rep_domain = count( $args ) >= 1 ? $args[0] : '';
					$new_rep_domain = count( $args ) >= 2 ? $args[1] : '';
					if ( empty( $old_rep_domain ) || empty( $new_rep_domain ) ) return;

					$user_ids = get_users( array(
						'fields' => 'ids',
						'meta_query' => array(
							array( 'key' => 'ns_customer_rep_email_domain', 'value' => $old_rep_domain )
						)
					) );
					
					foreach ( $user_ids as $user_id ) {
						update_user_meta( $user_id, 'ns_customer_rep_email_domain', $new_rep_domain );
					}

					WP_CLI::success( 'Users updated' );

				} );
				
			}

		}

        public static function init_ns_inactive_customers_sync_schedule() {
			if ( ! wp_next_scheduled( 'ns_inactive_customers_sync' ) ) {
				$timezone = get_option( 'timezone_string' );
				$next_sync_time = new DateTime( 'now', new DateTimeZone( $timezone ) );
				$next_sync_time->modify( 'today 11:00pm' );
				wp_schedule_event( intval( $next_sync_time->format( 'U' ) ), 'daily', 'ns_inactive_customers_sync' );
			}
		}

        public static function cron_ns_inactive_customers_sync() {
            $user_ids = get_users( array(
						'fields' => 'ids',
						'meta_query' => array(
							array( 'key' => 'inactive', 'value' => TRUE )
						)
					) );

            foreach ( $user_ids as $user_id ) {
                self::sync_user_ns_customer_data( $user_id );
            }
		}

        public static function set_current_user() {
            if( !isset( self::$current_user ) ) {
                self::$current_user = wp_get_current_user();
            }
        }

        public static function set_pricing_tables_names(): void {
            global $wpdb;
            self::$ns_items_pricing_table_name = $wpdb->prefix . 'ns_items_pricings';
            self::$ns_groups_pricing_table_name = $wpdb->prefix . 'ns_groups_pricings';
        }

        public static function setup_database_tables(): void
        {
            $were_tables_created = get_option( 'ns_pricing_tables_created' );
            if( !$were_tables_created ) {
                self::create_ns_items_pricings_table();
                self::create_ns_groups_pricings_table();
                update_option( 'ns_pricing_tables_created', true );
            }
        }

        public static function create_ns_items_pricings_table(): void
        {
            global $wpdb;
            $table_name = self::$ns_items_pricing_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `ns_internal_id` int(10) NOT NULL,
                `sku_name` varchar(100) NOT NULL,
                `price` float NOT NULL,
                `currency_id` int(11) DEFAULT NULL,
                `currency_name` varchar(100) DEFAULT NULL,
                `price_id` int(11) NOT NULL,
                `price_name` varchar(100) DEFAULT NULL,
                PRIMARY KEY (id),
                KEY user_id_name (`user_id`,`sku_name`)
			) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_ns_groups_pricings_table(): void
        {
            global $wpdb;
            $table_name = self::$ns_groups_pricing_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `user_id` int(11) NOT NULL,
                `ns_group_id` int(11) NOT NULL,
                `group_name` varchar(100) NOT NULL,
                `price_id` int(11) NOT NULL,
                `price_name` varchar(100) NOT NULL,
                PRIMARY KEY (id),
                KEY user_id_ns_group_id (`user_id`,`ns_group_id`)
			) $charset_collate;";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

		public static function register_user_settings() {
            $readonly = true;
            if ( isset( self::$current_user ) && self::$current_user->roles[0] === 'administrator' ) {
                $readonly = false;
            }
			self::$user_settings = new UserSettings( array(
				'fields' => array(
					new Field( array(
						'label' => 'NetSuite Internal ID',
						'input' => new TextInput( array( 'name' => 'ns_customer_internal_id', 'class' => 'input-medium', 'atts' => array( 'readonly' => $readonly ) ) )
					) ),
					new Field( array(
						'label' => 'Imported NetSuite Internal ID',
						'input' => new TextInput( array( 'name' => 'ns_customer_internal_id_imported', 'class' => 'input-medium', 'atts' => array( 'readonly' => $readonly ) ) )
					) ),
					new Field( array(
						'label' => 'Division',
						'input' => new TextInput( array( 'name' => 'ns_division_name', 'class' => 'input-medium', 'atts' => array( 'readonly' => 1 ) ) )
					) ),
					new Field( array(
						'label' => 'Freight Level',
						'input' => new TextInput( array( 'name' => 'ns_trans_freight_level_name', 'class' => 'input-medium', 'atts' => array( 'readonly' => 1 ) ) )
					) ),
					new Field( array(
						'label' => 'Main Location',
						'input' => new TextInput( array( 'name' => 'ns_main_location', 'class' => 'input-medium', 'atts' => array( 'readonly' => 1 ) ) ),
						'getOutputCb' => function( $field, $args ) {
                            global $profile_user;
                            $location = self::get_main_location_output( $profile_user->ID );
                            ob_start();
                            ?>
                            <tr class="crown-field">
                                <th class="label-wrap">
                                    <label>Main Location</label>
					            </th>
                                <td class="input-wrap">
                                    <label><input type="text" name="ns_main_location" value="<?php echo $location;?>" class="input-medium" readonly="1"></label>
                                </td>
			                </tr>
                            <?php
                            return ob_get_clean();
						}
					) ),
					new Field( array(
						'label' => 'Backup Location ID',
						'getOutputCb' => function( $field, $args ) {
                            global $profile_user;
                            $main_location = json_decode( get_user_meta($profile_user->ID, 'ns_main_location', true) );
                            $location = '';
                            if ( !empty($main_location->id) ) {
                                $backup_location = Crown_Shop_Products::get_backup_location_for_main_location( $main_location->id );

                                if ( !empty($backup_location) ) {
                                    $location = $backup_location[0]['backup_location'];
                                }
                            }
                            ob_start();
                            ?>
                            <tr class="crown-field">
                                <th class="label-wrap">
                                    <label>Backup Location ID</label>
					            </th>
                                <td class="input-wrap">
                                    <span><?php echo $location;?></span>
                                </td>
			                </tr>
                            <?php
                            return ob_get_clean();
						}
					) ),
					new Field( array(
						'label' => 'Price Level',
						'input' => new TextInput( array( 'name' => 'ns_price_level_name', 'class' => 'input-medium', 'atts' => array( 'readonly' => 1 ) ) )
					) ),
                    new Field( array(
						'label' => 'Parent Rep Agent / Partner',
						'input' => new TextInput( array( 'name' => 'parent_rep_agent_partner_name', 'class' => 'input-medium', 'atts' => array( 'readonly' => 1 ) ) )
					) ),
                    new Field( array(
						'label' => 'Rep Agent / Partner',
						'input' => new TextInput( array( 'name' => 'rep_agent_partner_name', 'class' => 'input-medium', 'atts' => array( 'readonly' => 1 ) ) )
					) ),
					new Field( array(
						'label' => 'Allow Restricted Items',
						'input' => new CheckboxInput( array( 'name' => 'ns_allow_restricted_items', 'class' => 'input-medium' ) ),
                        'getOutputCb' => function($field, $args) {
                            global $profile_user;
                            $is_allow_restricted_items = get_user_meta( $profile_user->ID, 'ns_allow_restricted_items', true );
                            $is_flag_sync_disabled = get_user_meta( $profile_user->ID, 'ns_disable_restricted_flag_sync', true );
                            $is_restricted_items_checkbox_disabled = !$is_flag_sync_disabled;
                            ob_start();
                            ?>
                            <tr class="crown-field">
                                <th class="label-wrap">
                                    <label>Allow Restricted Items</label>
                                </th>
                                <td class="input-wrap">
                                    <div class="checkbox-wrap"><label>
                                        <input
                                            type="checkbox" name="ns_allow_restricted_items" value="1" class="input-medium"
                                            <?php echo $is_allow_restricted_items ? ' checked' : ''; ?>
                                            <?php echo $is_restricted_items_checkbox_disabled ? ' disabled' : ''; ?>
                                        >
                                    </label></div>
                                    <p class="description"></p>
                                </td>
                            </tr>
                            <?php
                            $html = ob_get_clean();
                            return $html;
                        }
					) ),
                    new Field( array(
						'label' => 'Disable restricted flag sync with NS',
                        'input' => new CheckboxInput( array( 'name' => 'ns_disable_restricted_flag_sync', 'class' => 'input-medium', 'atts' => array( 'readonly' => $readonly ) ) )
					) ),
					new Field( array(
						'label' => 'Sales Rep Email Domain',
						'input' => new TextInput( array( 'name' => 'ns_customer_rep_email_domain', 'class' => 'input-medium', 'atts' => array( 'readonly' => $readonly ) ) ),
						'description' => 'Start domain name with @ symbol. Use comma to separate multiple values.',
					) ),
                    new Field( array(
						'label' => 'Internal Sales Rep - States',
						'input' => new TextInput( array( 'name' => 'internal_sales_rep_states', 'class' => 'input-medium', 'atts' => array( 'readonly' => $readonly ) ) )
					) ),
					new Field( array(
						'label' => 'Email for price file (switched users only)',
						'input' => new TextInput( array( 'name' => 'price_file_switched_email', 'class' => 'input-medium' ) ),
                        'getOutputCb' => function( $field, $args ) {
                            global $profile_user;
                            $price_file_email_field_readonly_attr = 'readonly';
                            $roles = (array) self::$current_user->roles;
                            if ( array_intersect(['administrator', 'branch_admin'], $roles) ) {
                                $price_file_email_field_readonly_attr = '';
                            }

                            $value = get_user_meta( $profile_user->ID, 'price_file_switched_email', true ) ?: $profile_user->user_email;
                            ob_start();
                            ?>
                            <tr class="crown-field">
                                <th class="label-wrap">
                                    <label>Email for price file (switched users only)</label>
                                </th>
                                <td class="input-wrap">
                                    <input type="text" name="price_file_switched_email" class="input-medium" value="<?php echo esc_attr($value); ?>"
                                    <?php echo $price_file_email_field_readonly_attr ?>
                                    >
                                </td>
                            </tr>
                            <?php
                            return ob_get_clean();
                        }
                    ) )
                    ),
				'listTableColumns' => array(
					new ListTableColumn( array(
						'key' => 'ns-id',
						'title' => 'NS ID',
						'position' => 4,
						'outputCb' => function( $user_id, $args ) {
							echo '<strong>' . get_user_meta( $user_id, 'ns_customer_internal_id', true ) . '</strong>';
							$imported_ns_customer_id = get_user_meta( $user_id, 'ns_customer_internal_id_imported', true );
							if ( ! empty( $imported_ns_customer_id ) ) {
								echo '<br><span style="color: #aaa">' . $imported_ns_customer_id . '</span>';
							}
						}
					) ),
					new ListTableColumn( array(
						'key' => 'ns-rep-agent',
						'title' => 'Rep Agent Domain',
						'position' => 5,
						'outputCb' => function( $user_id, $args ) {
							$domain = get_user_meta( $user_id, 'ns_customer_rep_email_domain', true );
							echo $domain;
						}
					) ),
					new ListTableColumn( array(
						'key' => 'ns-division-name',
						'title' => 'Division',
						'position' => 6,
						'outputCb' => function( $user_id ) {
							echo get_user_meta( $user_id, 'ns_division_name', true );
						}
					) ),
					new ListTableColumn( array(
						'key' => 'ns-trans-freight-level-name',
						'title' => 'Freight Level',
						'position' => 7,
						'outputCb' => function( $user_id ) {
							echo get_user_meta( $user_id, 'ns_trans_freight_level_name', true );
						}
					) ),
					new ListTableColumn( array(
						'key' => 'price-level',
						'title' => 'Price Level',
						'position' => 8,
						'outputCb' => function( $user_id, $args ) {
							echo get_user_meta( $user_id, 'ns_price_level_name', true );
						}
					) ),
					new ListTableColumn( array(
						'key' => 'main-location',
						'title' => 'Main Location',
						'position' => 9,
						'outputCb' => function( $user_id, $args ) {
                            $location = self::get_main_location_output( $user_id );
                            echo $location;
						}
					) )
				)
			) );

		}

        public static function get_main_location_output( $user_id ) {
            $main_location = json_decode( get_user_meta($user_id, 'ns_main_location', true) );

            $location = '';
            if ( $main_location && !empty($main_location->id) && !empty($main_location->name) ) {
                $location = $main_location->name . ' (' . $main_location->id . ')';
            }

            return $location;
        }

		public static function filter_tm_ns_customer_response( $ns_customer_id, $response, $user_id ) {
			if ( ! $ns_customer_id || ! $user_id ) return $ns_customer_id;
			
			$imported_ns_customer_id = get_user_meta( $user_id, 'ns_customer_internal_id_imported', true );
			if ( ! empty( $imported_ns_customer_id ) ) {
				$ns_customer_id = $imported_ns_customer_id;
			}

			return $ns_customer_id;
		}

        /**
         * Parses record and returns required pricing group data
         *
         * @param $group_pricing_record
         * @return array|null
         */
		protected static function get_group_pricing( $group_pricing_record ) {
			$group_pricing = array(
				'group_id' => '',
				'group_name' => '',
				'price_id' => null,
				'price_name' => ''
			);
			if ( is_object( $group_pricing_record ) ) {
				if ( property_exists( $group_pricing_record, 'group' ) && is_object( $group_pricing_record->group ) ) {
					if ( property_exists( $group_pricing_record->group, 'internalId' ) ) $group_pricing['group_id'] = $group_pricing_record->group->internalId;
					if ( property_exists( $group_pricing_record->group, 'name' ) ) $group_pricing['group_name'] = $group_pricing_record->group->name;
				}
				if ( property_exists( $group_pricing_record, 'level' ) && is_object( $group_pricing_record->level ) ) {
					if ( property_exists( $group_pricing_record->level, 'internalId' ) ) $group_pricing['price_id'] = $group_pricing_record->level->internalId;
					if ( property_exists( $group_pricing_record->level, 'name' ) ) $group_pricing['price_name'] = $group_pricing_record->level->name;
				}
			}
			if (
                empty( $group_pricing['group_id'] ) || empty( $group_pricing['group_name'] )
                || $group_pricing['price_id'] === null || empty( $group_pricing['price_name'] )
            ) {
                return null;
            }

			return $group_pricing;
		}

        /**
         * Parses record and returns required item pricing data
         *
         * @param $item_pricing_record
         * @return array|null
         */
		protected static function get_item_pricing( $item_pricing_record ) {
			// Customer: 7896
			$item_pricing = array(
				'id' => '',
				'name' => '',
				'price' => null,
				'currency_id' => 1,
				'currency_name' => 'US Dollar',
				'price_id' => null,
				'price_name' => ''
			);
			if ( is_object( $item_pricing_record ) ) {
				if ( property_exists( $item_pricing_record, 'item' ) && is_object( $item_pricing_record->item ) ) {
					if ( property_exists( $item_pricing_record->item, 'internalId' ) ) $item_pricing['id'] = $item_pricing_record->item->internalId;
					if ( property_exists( $item_pricing_record->item, 'name' ) ) $item_pricing['name'] = $item_pricing_record->item->name;
				}
				if ( property_exists( $item_pricing_record, 'price' ) && $item_pricing_record->price !== null ) $item_pricing['price'] = floatval( $item_pricing_record->price );
				if ( property_exists( $item_pricing_record, 'currency' ) && is_object( $item_pricing_record->currency ) ) {
					if ( property_exists( $item_pricing_record->currency, 'internalId' ) ) $item_pricing['currency_id'] = $item_pricing_record->currency->internalId;
					if ( property_exists( $item_pricing_record->currency, 'name' ) ) $item_pricing['currency_name'] = $item_pricing_record->currency->name;
				}
				if ( property_exists( $item_pricing_record, 'level' ) && is_object( $item_pricing_record->level ) ) {
					if ( property_exists( $item_pricing_record->level, 'internalId' ) ) $item_pricing['price_id'] = $item_pricing_record->level->internalId;
					if ( property_exists( $item_pricing_record->level, 'name' ) ) $item_pricing['price_name'] = $item_pricing_record->level->name;
				}
			}
			if (
                empty( $item_pricing['id'] ) || empty( $item_pricing['name'] ) || ( $item_pricing['price'] === null
                    && $item_pricing['price_id'] === null )
            ) {
                return null;
            }

			return $item_pricing;
		}


		public static function sync_price_levels() {
			if ( ! defined( 'TMWNI_DIR' ) ) return;

			require_once TMWNI_DIR . 'inc/NS_Toolkit/src/NetSuiteService.php';
			foreach (glob(TMWNI_DIR . 'inc/NS_Toolkit/src/Classes/*.php') as $filename) {
				require_once $filename;
			}
			require_once TMWNI_DIR . 'inc/common.php';
		
			$ns_service = new NetSuite\NetSuiteService();
	
			$selectedField = new NetSuite\Classes\SearchBooleanField();
			$selectedField->searchValue = false;
	
			$priceLevelSearch = new NetSuite\Classes\PriceLevelSearchBasic();
			$priceLevelSearch->isInactive = $selectedField;
	
			$request = new NetSuite\Classes\SearchRequest();
			$request->searchRecord = $priceLevelSearch;
	
			try {
				$searchResponse = $ns_service->search($request);
				$data = array();
				if ($searchResponse->searchResult->totalRecords > 0) {
					foreach ( $searchResponse->searchResult->recordList->record as $record ) {
						$data[ $record->internalId ] = array(
							'id' => $record->internalId,
							'name' => $record->name,
							'discount_pct' => $record->discountpct
						);
					}
					update_option( 'ns_price_levels', $data );
				}
			} catch (SoapFault $e) {
				
			}

		}


		public static function register_customer_import_admin_page() {

			if ( ! class_exists( 'woocommerce' ) ) return;

            $sync_all_customers_checkbox = array();
            if ( current_user_can('manage_options') ) {
                $sync_all_customers_checkbox = array(
                    'label' => 'Sync all customers',
                    'description' => 'Check this field to synchronize all customers data with NetSuite, lastModifiedDate user meta has to be removed for the users that should be synchronized.',
                    'input' => new CheckboxInput( array( 'name' => 'csc_sync_all_customers', 'class' => 'input-small', 'label' => 'Sync all customers') )
                );
            }

			self::$customer_import_admin_page = new AdminPage( array(
				'key' => 'crown-shop-customer-import',
				'parent' => 'users',
				'title' => 'Customer Import',
				'menuTitle' => 'Import Customer',
				'fields' => array(
					new Field( array(
						'label' => 'Customer NetSuite ID',
						'description' => 'Provide the NetSuite ID of the individual customer to import. For example, in the following URL, the NetSuite ID for the customer is <strong>3978</strong>:<br><a href="https://7251105.app.netsuite.com/app/common/entity/custjob.nl?id=3978" target="_blank">https://7251105.app.netsuite.com/app/common/entity/custjob.nl?id=3978</a>',
						'input' => new TextInput( array( 'name' => 'csc_import_customer_id', 'class' => 'input-small') )
					) ),
					new Field( array(
						'label' => 'Sales Rep Email Domain',
						'description' => 'Provide the the email domain of the rep organization associated with this customer, including the \'@\' symbol followed by the domain name. For example, <strong>@pacwestern.com</strong>',
						'input' => new TextInput( array( 'name' => 'csc_import_customer_rep_domain', 'class' => 'input-small') )
					) ),
                    new Field( $sync_all_customers_checkbox ),
				),
				'saveMetaCb' => function( $input, $args, $fields ) {
					global $wpdb;
					$ns_id = get_option( 'csc_import_customer_id' );
					if ( ! empty( $ns_id ) ) {
						$rep_domain = get_option( 'csc_import_customer_rep_domain' );

						$user_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'ns_customer_internal_id' AND meta_value = '%s' LIMIT 1", $ns_id ) );
						if ( empty( $user_id ) ) {
							$user_id = wp_create_user( $ns_id, md5( $ns_id ), 'customer-' . $ns_id . '@nsiindustries.com' );
							$user = new WP_User( $user_id );
							$user->set_role( 'customer' );
							update_user_meta( $user_id, 'ns_customer_internal_id', $ns_id );
							update_user_meta( $user_id, 'ns_customer_internal_id_imported', $ns_id );
						}
						
						self::sync_user_ns_customer_data( $user_id );

						if ( ! empty( $rep_domain ) ) {
							update_user_meta( $user_id, 'ns_customer_rep_email_domain', $rep_domain );
						}

						update_option( 'csc_import_customer_id', '' );
						update_option( 'csc_import_customer_rep_domain', '' );
					} else if (
                        get_option( 'csc_sync_all_customers' ) && current_user_can( 'manage_options' ) &&
                        ( $_SERVER['REQUEST_METHOD'] === 'POST' || ( isset( $_GET['csc_sync_all_customers'] ) && $_GET['csc_sync_all_customers'] === '1' ) )
                    ) {
                        //functionality that allows to sync all the customers that have ns_customer_internal_id and have no lastModifiedDate
                        $users_query =
                            "SELECT wpum1.user_id FROM `wp_usermeta` as wpum1
                                WHERE wpum1.meta_key = 'ns_customer_internal_id' AND wpum1.meta_value != '0'
                                AND NOT EXISTS (
                                    SELECT * FROM wp_usermeta as wpum2
                                    WHERE
                                    wpum1.user_id = wpum2.user_id 
                                    AND wpum2.meta_key = 'lastModifiedDate'
                                );";

                        $users_to_sync = $wpdb->get_results( $users_query );
                        if ( !empty( $users_to_sync ) ) {
                            $count = 1;
                            foreach( $users_to_sync as $user_result ) {
                                if( $count > 50 ) {
                                    break;
                                }

                                self::sync_user_ns_customer_data( $user_result->user_id, true );
                                $count++;
                            }

                            $redirect = $_SERVER['REQUEST_URI'];
                            if( !str_contains( $_SERVER['REQUEST_URI'], 'csc_sync_all_customers' ) ) {
                                $redirect .= '&csc_sync_all_customers=1';
                            }
                            header( 'location: ' . $redirect );
                            die();
                        } else {
                            update_option( 'csc_sync_all_customers', '' );
                        }

                    }
				}
			) );

		}

        public static function ns_restricted_flag_import_callback() {
            ?>
            <div class="wrap">
                <h2><span>Import restricted flag's users settings</span></h2>

                <form method="post" enctype="multipart/form-data">
                    <label>
                        CSV File with settings <input type="file" id="RestrictedFlagSettings" name="RestrictedFlagSettings" accept=".csv" />
                    </label>
                    <p>File should be in .csv format with the following values:<br />
                    - user id - user's NetSuite ID<br />
                    - allow restricted items - "true" for allowed, "false" for disallowed, empty value "" for no changes<br />
                    - disable restricted flag sync - "true" for disabled, "false" for enabled, empty value "" for no changes.
                    </p>
                    <br />
                    <input type="hidden" name="RestrictedFlagImport" value="true" />
                    <input class="button button-primary" type="submit" />
                </form>
                <?php
                if ( isset($_POST['RestrictedFlagImport']) && $_POST['RestrictedFlagImport'] == 'true' ) {
                    $file = $_FILES['RestrictedFlagSettings'] ?? false;
                    if ( !$file || empty($file['name']) ) {
                        echo '<div class="error">CSV file is missing</div>';
                        return;
                    }

                    $file_type = wp_check_filetype( $file['name'] );
                    if ( $file_type['ext'] !== 'csv' ) {
                        echo '<div class="error">Invalid file type. Please upload CSV file.</div>';
                        return;
                    }

                    $file_path = $file['tmp_name'];

                    if ( file_exists($file_path) ) {
                        $csv = fopen( $file_path, "r" );
                        $result = [];
                        while ( ($row = fgetcsv($csv, 10000, ',')) !== false ) {
                            $user_id = (int) $row[0];
                            if ( $user_id != $row[0] ) {
                                $result[] = array(
                                    'ns_id' => $row[0],
                                    'wp_id' => 'invalid user ID value',
                                    'flag' => 'invalid user ID value',
                                    'sync' => 'invalid user ID value'
                                );

                                continue;
                            }

                            $restricted_flag = trim( strtolower($row[1]) );
                            $is_sync_disabled = trim( strtolower($row[2]) );
                            $users = get_users(
								array(
									'meta_key' => 'ns_customer_internal_id',
									'meta_value' => $user_id
								)
                            );

                            $imported = false;
                            if ( empty($users) ) {
                                $ns_customer_exists = self::get_ns_customer_record( $user_id );
                                if ( $ns_customer_exists ) {
                                    $wp_user_id = wp_create_user( $user_id, md5($user_id), 'customer-' . $user_id . '@nsiindustries.com' );

                                    if ( ! $user_id || is_wp_error($user_id) ) {
                                        $result[] = array(
                                            'ns_id' => $row[0],
                                            'wp_id' => 'User not found',
                                            'flag' => 'User not found, creating new user failed',
                                            'sync' => 'User not found, creating new user failed'
                                        );

                                        continue;
                                    }

                                    $user = new WP_User( $wp_user_id );
                                    $user->set_role( 'customer' );
                                    update_user_meta( $wp_user_id, 'ns_customer_internal_id', $user_id );
                                    update_user_meta( $wp_user_id, 'ns_customer_internal_id_imported', $user_id );
                                    Crown_Shop_Customers::sync_user_ns_customer_data( $wp_user_id );
                                    $users = array( $user );
                                    $imported = true;
                                } else {
                                    $result[] = array(
                                        'ns_id' => $row[0],
                                        'wp_id' => 'User not found',
                                        'flag' => 'User not found in NetSuite',
                                        'sync' => 'User not found in NetSuite'
                                    );

                                    continue;
                                }
                            }

                            foreach ( $users as $user ) {
                                $wp_user_id = $user->ID;
                                $result_row = array(
                                    'ns_id' => $row[0],
                                    'wp_id' => $wp_user_id . ( $imported ? ' - imported' : ''),
                                    'flag' => 'no changes',
                                    'sync' => 'no changes'
                                );

                                if ( !empty($restricted_flag) ) {
                                    if ( $restricted_flag == 'true' ) {
                                        update_user_meta( $wp_user_id, 'ns_allow_restricted_items', '1');
                                        $result_row['flag'] = 'allowed';
                                    } else if ( $restricted_flag == 'false' ) {
                                        update_user_meta( $wp_user_id, 'ns_allow_restricted_items', '');
                                        $result_row['flag'] = 'disallowed';
                                    } else {
                                        $result_row['flag'] = 'unrecognized value, no changes';
                                    }
                                }
                                if ( !empty($is_sync_disabled) ) {
                                    if ( $is_sync_disabled == 'true' ) {
                                        update_user_meta( $wp_user_id, 'ns_disable_restricted_flag_sync', '1' );
                                        $result_row['sync'] = 'disabled';
                                    } else if ( $is_sync_disabled == 'false' ) {
                                        update_user_meta( $wp_user_id, 'ns_disable_restricted_flag_sync', '' );
                                        $result_row['sync'] = 'enabled';
                                    } else {
                                        $result_row['sync'] = 'unrecognized value, no changes';
                                    }
                                }

                                $result[] = $result_row;
                            }
                        }

                        if ( !empty($result) ) {
                            ?>
                            <div class="restricted-flag--import">
                                <ul>
                                    <li>NS User ID</li>
                                    <li>WP User ID</li>
                                    <li>Allow restricted items</li>
                                    <li>Disable restricted flag sync</li>
                                </ul>
                                <?php foreach( $result as $result_row ) { ?>
                                    <ul>
                                        <li><?php echo $result_row['ns_id']; ?></li>
                                        <li><?php echo $result_row['wp_id']; ?></li>
                                        <li><?php echo $result_row['flag']; ?></li>
                                        <li><?php echo $result_row['sync']; ?></li>
                                    </ul>
                                <?php } ?>
                            </div>

                            <style>
                                .restricted-flag--import {
                                    margin-top: 40px;
                                }

                                .restricted-flag--import ul {
                                   margin: 0;
                                   padding: 0;
                                   list-style-type: none;
                                   display: flex;
                                }

                                .restricted-flag--import ul:first-child li {
                                    border-top: 1px solid #ccc;
                                }

                                .restricted-flag--import ul li {
                                    margin: 0;
                                    padding: 2px;
                                    border-right: 1px solid #ccc;
                                    border-bottom: 1px solid #ccc;
                                    width: 200px;
                                }

                                .restricted-flag--import ul li:first-child {
                                    border-left: 1px solid #ccc;
                                    width: 150px;
                                }
                            </style>
                            <?php
                        }
                    }
                }
            echo '</div>';
        }

        public static function register_customer_restricted_flag_settings() {
            add_users_page(
                'Restricted flag import',
                'Restricted flag import',
                'edit_users',
                'ns-restricted-flag-import',
                array( __CLASS__, 'ns_restricted_flag_import_callback' )
            );
		}

        public static function init_dual_shop_manager_allowed_brands_settings() {
            add_settings_section(
                'dsm_allowed_brands_settings_section',
                'Dual Shop Manager settings',
                array( __CLASS__, 'dsm_allowed_brands_settings_section_cb' ),
                'dsm_allowed_brands_settings'
            );
            add_settings_field(
                'dsm_allowed_brands',
                'Allowed brands for domains',
                array( __CLASS__, 'dsm_allowed_brands_field_cb' ),
                'dsm_allowed_brands_settings',
                'dsm_allowed_brands_settings_section'
            );

            register_setting( 'dsm_allowed_brands_settings', 'dsm_allowed_brands' );
        }

        public static function dsm_allowed_brands_settings_section_cb() {
            echo '<p>Settings that allow to assign brands to Dual Shop Manager domains.</p>';
        }

        public static function dsm_allowed_brands_field_cb() {
            $dsm_allowed_brands_option = get_option( 'dsm_allowed_brands' );
            $dsm_allowed_brands = $dsm_allowed_brands_option['data'] ?? array();

            $brands = get_terms([
                'taxonomy' => 'product_brand',
                'hide_empty' => false,
            ]);

            echo '<div id="dsm-allowed-brands" class="settings-dsm-allowed-brands-holder">';
            if( !empty($dsm_allowed_brands) ){
                $rows = count( $dsm_allowed_brands['dsm-domain'] );
                for( $i = 0; $i < $rows; $i++ ) {
                    $dsm_domain = $dsm_allowed_brands['dsm-domain'][$i];
                    $dsm_brands_string = $dsm_allowed_brands['dsm-brands'][$i];
                    $dsm_brands = explode( ',', $dsm_brands_string );

                    if ( empty($dsm_domain) && empty($dsm_brands_string) ) {
                        continue;
                    }
                    ?>

                    <div class="dsm-allowed-brands--group">
                        <label class="dsm-domain">Domain<br />
                            <input type="text" name="dsm_allowed_brands[data][dsm-domain][]" placeholder="@domain.com" value="<?php echo $dsm_domain;?>" />
                        </label>
                        <div class="dsm-allowed-brands--brands">
                            <?php
                            foreach ( $brands as $brand ) { ?>
                                <div>
                                    <label>
                                        <input type="checkbox" name="dsm-brand"
                                               value="<?php echo $brand->slug ?>" <?php echo in_array($brand->slug, $dsm_brands) ? "checked" : "" ?> />
                                        <?php echo $brand->name ?>
                                    </label>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="dsm_allowed_brands[data][dsm-brands][]" value="<?php echo $dsm_brands_string;?>" />
                        </div>
                        <div class="dsm-button">
                            <button type="button" class="remove-dsm-allowed-brands-group button button-link-delete">Remove</button>
                        </div>
                    </div>
                    <?php
                }
            }

            echo '</div>';
            echo '<button type="button" class="button button-secondary" id="add-dsm-allowed-brands-group">Add Next</button>';
            ?>
                <script>
                jQuery(document).ready(function($) {
                    $('body').on('click', 'input[name="dsm-brand"]', function() {
                        let brands_selected = [];
                        let parent = $(this).parents('.dsm-allowed-brands--brands');
                        parent.find('input[type="checkbox"]').each(function(k, v){
                            if ( $(v).is(':checked') ) {
                                brands_selected.push($(v).val());
                            }
                        });
                        let brands_value = brands_selected.join(',');
                        parent.find('input[name="dsm_allowed_brands[data][dsm-brands][]"]').val(brands_value);
                    });

                    $('body').on('click', '.remove-dsm-allowed-brands-group', function() {
                        $(this).parents('.dsm-allowed-brands--group').remove();
                    });

                    $('#add-dsm-allowed-brands-group').on('click', function() {
                        let html = `<div class="dsm-allowed-brands--group">
                <label class="dsm-domain">Domain<br />
                    <input type="text" name="dsm_allowed_brands[data][dsm-domain][]" placeholder="@domain.com"/>
                </label>
                <div class="dsm-allowed-brands--brands">
                <?php
                foreach ( $brands as $brand ) { ?>
                    <div>
                        <label>
                            <input type="checkbox" name="dsm-brand"
                                   value="<?php echo $brand->slug ?>"/>
                            <?php echo $brand->name ?>
                        </label>
                    </div>
                <?php } ?>
                <input type="hidden" name="dsm_allowed_brands[data][dsm-brands][]" />
                </div>

                <div class="dsm-button">
                    <button type="button" class="remove-dsm-allowed-brands-group button button-link-delete">Remove</button>
                </div>
            </div>`;

                        $('.settings-dsm-allowed-brands-holder').append(html);
                    });
                });
            </script>
            <?php
        }

        public static function init_dual_shop_manager_allowed_brands_menu_page() {
            add_users_page(
                'Dual Shop Manager - Allowed brands',
                'Dual Shop Manager - Allowed brands',
                'edit_users',
                'dsm-allowed-brands-settings',
                array( __CLASS__, 'dsm_allowed_brands_settings_callback' )
            );
		}

        public static function dsm_allowed_brands_settings_callback() {
            echo '<form method="post" action="options.php">';
            settings_fields( 'dsm_allowed_brands_settings' );
            do_settings_sections( 'dsm_allowed_brands_settings' );
            submit_button();
            echo '</form>';
        }

        /**
         * Calculates products price
         *
         * @param $price
         * @param $product
         * @return float|int
         */
        public static function filter_wc_get_product_price( $price, $product, $user_id = null ) {
            $discount_pct = 0;
            $discount_price = null;
            $price_qty_multiplier = 1;

            if ( !is_user_logged_in() && $user_id === null ) {
                return floatval( $price );
            }

            if ( $user_id != null ) {
                $current_user_id = $user_id;
            } else {
                $current_user_id = get_current_user_id();
            }
            //1. Get currency ID
            $currency_id = get_user_meta( $current_user_id, 'ns_currency_id', true );
            if ( empty( $currency_id ) ) $currency_id = 1;

            //2. Get pricing levels for product
            $item_pricing_levels = get_post_meta( $product->get_id(), 'ns_pricing_levels', true );
            if ( empty( $item_pricing_levels ) || ! is_array( $item_pricing_levels ) ) {
                $item_pricing_levels = array();
            }

            //3. get price level id for the user
            $price_level_id = intval( get_user_meta( $current_user_id, 'ns_price_level_id', true ) );

            // adjust price to primary currency
            if ( $currency_id != 1 ) {
                if ( array_key_exists( $currency_id . '_' . $price_level_id, $item_pricing_levels ) ) {
                    $price = $item_pricing_levels[ $currency_id . '_'. $price_level_id ]['price_list'][0]['value'];
                } elseif ( array_key_exists( $currency_id . '_1', $item_pricing_levels ) ) {
                    $price = $item_pricing_levels[ $currency_id . '_1' ]['price_list'][0]['value'];
                }
            }

            //4. General price levels in _options
            $price_levels = get_option( 'ns_price_levels', array() );

            $item_pricing_row = self::get_ns_item_pricing_for_user_by_product_sku( $current_user_id, $product->get_sku() );
            $pricing_group_id = intval( get_post_meta( $product->get_id(), 'ns_item_pricing_group_id', true ) );

            //search for products discount/price values for the user in the following settings (in that order):
            //- item pricing for the user
            //- group pricing for the user
            //- product pricing levels
            //- general pricing levels

            //additional checks for null and 0 added to not overwrite already set values, in case if discount/price values can be set in different settings
            if ( !empty( $item_pricing_row ) ) {
                if ( $item_pricing_row[0]->price !== null ) {
                    $discount_price = $item_pricing_row[0]->price;
                } else if ( intval( $item_pricing_row[0]->price_id ) > 0 ) {
                    $price_level_id = $item_pricing_row[0]->price_id;
                    if ( array_key_exists( $price_level_id, $price_levels ) ) {
                        $discount_pct = floatval( $price_levels[ $price_level_id ]['discount_pct'] );
                    }
                }
            }

            if ( $pricing_group_id && ( $discount_price == null || $discount_pct == 0) ) {
                $group_pricing_row = self::get_ns_group_pricing_for_user_by_group_id( $current_user_id, $pricing_group_id );
                if ( !empty( $group_pricing_row ) ) {
                    $price_level_id = $group_pricing_row[0]->price_id;
                    if ( array_key_exists( $currency_id . '_' . $price_level_id, $item_pricing_levels ) ) {
                        $price_level = $item_pricing_levels[ $currency_id . '_' . $price_level_id ];
                        if ( ! empty( $price_level['discount_pct'] ) && $discount_pct == 0 ) {
                            $discount_pct = floatval( $price_level['discount_pct'] );
                        }
                        if ( ! empty( $price_level['price_list'] ) && $discount_price == null ) {
                            $current_price = current( $price_level['price_list'] );
                            $discount_price = $current_price['value'];
                        }
                    } else if ( array_key_exists( $price_level_id, $price_levels ) && $discount_pct == 0 ) {
                        $discount_pct = floatval( $price_levels[ $price_level_id ]['discount_pct'] );
                    }
                }
            }

            if (
                array_key_exists( $currency_id . '_' . $price_level_id, $item_pricing_levels )
                 && ( $discount_price == null || $discount_pct == 0)
            ) {
                $price_level = $item_pricing_levels[ $currency_id . '_' . $price_level_id ];
                if ( ! empty( $price_level['discount_pct'] ) && $discount_pct == 0 ) {
                    $discount_pct = floatval($price_level['discount_pct'] );
                }
                if ( ! empty( $price_level['price_list'] ) && $discount_price == null ) {
                    $current_price = current( $price_level['price_list'] );
                    $discount_price = $current_price['value'];
                }
            }

            if ( array_key_exists( $price_level_id, $price_levels ) && $discount_pct == 0 ) {
                $discount_pct = floatval( $price_levels[ $price_level_id ]['discount_pct'] );
            }

            if ( $discount_price !== null ) {
                return $discount_price * $price_qty_multiplier;
            }

            if ( $discount_pct > 0 ) {
                $discount_pct *= -1;
            }

            return ( floatval( $price ) + ( floatval( $price ) * ( $discount_pct / 100 ) ) ) * $price_qty_multiplier;
        }


		public static function user_edit_form_tag() {
			if ( self::$customer_auto_sync_data_enabled ) {
				global $profile_user;
				$user_id = $profile_user->ID;
				$prices_count = self::get_user_custom_prices_count($user_id);
				if ( $prices_count < self::$customer_prices_count_limit ) {
					self::sync_user_ns_customer_data( $user_id );
				} elseif ( in_array(self::$customer_log_level, array('DEBUG', 'LOG') ) ) {
					self::handleLog(0, $user_id, 'customer', 'User ID ' . $user_id . ' will not be synced automatically (prices count: ' . $prices_count . ', limit set: ' . self::$customer_prices_count_limit . ').');
				}
			}
		}


		public static function wp_login( $username, $user ) {
			self::sync_user_ns_customer_data( $user->ID );
		}

		public static function set_auth_cookie( $auth_cookie, $expire, $expiration, $user_id, $scheme, $token ) {
			if ( self::$customer_auto_sync_data_enabled ) {
				$prices_count = self::get_user_custom_prices_count($user_id);
				if ( $prices_count < self::$customer_prices_count_limit ) {
					self::sync_user_ns_customer_data( $user_id );
				} elseif ( in_array( self::$customer_log_level, array('DEBUG', 'LOG') ) ) {
					self::handleLog(0, $user_id, 'customer', 'User ID ' . $user_id . ' will not be synced automatically (prices count in DB: ' . $prices_count . ', limit set: ' . self::$customer_prices_count_limit . ').');
				}
			}
		}


		public static function get_ns_customer_record( $ns_customer_id = '', $customer_last_modified_date = '', $customer_name = '' ) {
			if ( ! class_exists( 'TMWNI_Settings' ) || ! TMWNI_Settings::areCredentialsDefined() || ( empty($ns_customer_id) && empty($customer_name) ) ) return null;

			$netsuite_service = new NetSuiteService( null, array( 'exceptions' => true ) );
			$netsuite_service->setSearchPreferences(false, 20);
            $is_search_based_on_ns_id = !empty( $ns_customer_id );
            $identifier_for_log = $is_search_based_on_ns_id ? $ns_customer_id : str_replace(' ', '_', $customer_name) ;
            $identifier_for_log_text = $is_search_based_on_ns_id ? ' Customer ID - ' . $ns_customer_id : ' Customer Name - "' . $customer_name . '"';

            $search = new CustomerSearchBasic();

            if ( !empty($customer_name) ) {
                $search_field_name = new SearchStringField();
                $search_field_name->operator = 'is';
                $search_field_name->searchValue = $customer_name;
                $search->companyName = $search_field_name;
            }

             if ( !empty($ns_customer_id) ) {
                $search_field_internal_id = new SearchMultiSelectField();
                $search_field_internal_id->operator = 'anyOf';
                $search_field_internal_id->searchValue = array( 'internalId' => $ns_customer_id );
                $search->internalId = $search_field_internal_id;
             }

			if ( !empty($customer_last_modified_date) && self::$ns_sync_customer_last_modified_date_enabled ) {
				$search_field_lastmodified_date = new SearchDateField();
				$search_field_lastmodified_date->operator = 'after';
				$search_field_lastmodified_date->searchValue = $customer_last_modified_date;
				$search->lastModifiedDate = $search_field_lastmodified_date;
			}
			$request = new SearchRequest();
			$request->searchRecord = $search;
			$object = 'customer';
			$date = date("Y-m-d");
			if ( self::$customer_sync_sent_payload_enabled ) {
				$payload_filename = 'tm_ns_netsuite_customer_payload-' . $identifier_for_log . '-' . $date . '.json';
				self::logNetsuiteApiError(json_encode($request), $payload_filename);
			}
			$log_filename = 'tm_ns_netsuite_customers_response-' . $date . '.log';
			if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG') ) ) {
				self::handleLog(0, $ns_customer_id, 'customer', $identifier_for_log_text . ': request for data fetch is sent to Netsuite.');
			}
			try {
				$search_response = $netsuite_service->search( $request );
				if ( $search_response->searchResult->status->isSuccess ) {
					if ( 0 != $search_response->searchResult->totalRecords ) {
						if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG') ) ) {
							self::logNetsuiteApiError( 'Response status: ' . $search_response->searchResult->status->isSuccess . $identifier_for_log_text . ' data received.', $log_filename );
						}
						if ( self::$customer_log_level === 'DEBUG' ) {
							self::handleLog(0, $ns_customer_id, $object, $search_response->searchResult->recordList->record[0]);
						}
						return $search_response->searchResult->recordList->record[0];
					} else {
						if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG', 'ERROR') ) ) {
							self::logNetsuiteApiError('Response status: ' . $search_response->searchResult->status->isSuccess . $identifier_for_log_text . ' data NOT received. See details below:', $log_filename);
							self::handleLog(0, $ns_customer_id, $object, $search_response->searchResult);
						}
					}
				} else {
					if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG', 'ERROR') ) ) {
						self::logNetsuiteApiError('RESPONSE STATUS IS EMPTY. See details below:', $log_filename);
						self::handleLog(0, $ns_customer_id, $object, $search_response, $is_search_based_on_ns_id);
					}
				}
			} catch ( SoapFault $e ) {
				$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $ns_customer_id . '. ';
				$error_msg .= $identifier_for_log_text . '. ';
				$error_msg .= 'Error Message: ' . $e->getMessage();
				if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG', 'ERROR') ) ) {
					self::logNetsuiteApiError('Error. See details below:', $log_filename);
					self::handleLog(0, $ns_customer_id, $object, $error_msg, $is_search_based_on_ns_id);
				}

				return null;
			}

			return null;
		}

        /**
         * Updates WP user data with NetSuite data
         *
         * @param $user_id
         * @return void
         */
		public static function sync_user_ns_customer_data( $user_id, $update_last_modified_date_on_no_record = false ) {
            $user_meta = get_user_meta( $user_id );
            if ( empty( $user_meta ) ) {
                return;
            }
			$ns_customer_id = $user_meta['ns_customer_internal_id'][0] ?? '';
            if ( empty( $ns_customer_id ) ) {
                return;
            }

            $ns_customer_entity_id = $user_meta['ns_customer_entity_id'][0] ?? '';
			$customer_last_modified_date = $user_meta['lastModifiedDate'][0] ?? '';
            $is_customer_inactive = $user_meta['inactive'][0] ?? '';
            $ns_customer_name = $user_meta['nickname'][0] ?? '';

            // get customer record from NetSuite
			$record = $is_customer_inactive
			    ? self::get_ns_customer_record( '', $customer_last_modified_date, $ns_customer_name )
			    : self::get_ns_customer_record( $ns_customer_id, $customer_last_modified_date );
			if ( ! $record ) {
                if ( $update_last_modified_date_on_no_record ) {
                    update_user_meta( $user_id, 'lastModifiedDate', '0' );
                }
                return;
            }

            if ( property_exists( $record, 'internalId' ) && $ns_customer_id != $record->internalId ) {
                if (!$record->isInactive) {
                    self::get_merge_previous_id_customer_with_new($ns_customer_id, $ns_customer_name, $user_id);
                }
                update_user_meta( $user_id, 'ns_customer_internal_id', $record->internalId );
                $ns_customer_id = $record->internalId;
            }
            if ( property_exists( $record, 'entityId' ) && $ns_customer_entity_id != $record->entityId ) {
                update_user_meta( $user_id, 'ns_customer_entity_id', $record->entityId );
            }

			if ( property_exists( $record, 'lastModifiedDate' ) ) {
				$ns_last_modified_date = $record->lastModifiedDate;
			} else {
				$currentDate = new DateTime();
				$ns_last_modified_date = $currentDate->format(DateTime::ATOM);
			}

			if ( defined('NS_SYNC_CUSTOMER_LAST_MODIFIED_DATE_ENABLED') && NS_SYNC_CUSTOMER_LAST_MODIFIED_DATE_ENABLED && !empty($customer_last_modified_date) && $customer_last_modified_date >= $ns_last_modified_date ) {
				if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG') ) ) {
					self::handleLog(0, $ns_customer_id, 'customer', 'Customer ID ' . $ns_customer_id . ' is already updated. Last modified date: ' . $customer_last_modified_date);
				}
				return;
			}

			update_user_meta( $user_id, 'lastModifiedDate', $ns_last_modified_date );
			$company_name = property_exists( $record, 'companyName' ) ? $record->companyName : null;

            self::check_scope_and_update_inactive_flag($user_id, $record);
            self::create_or_update_customer($user_id, $company_name, $record);
            self::update_company_name($company_name, $user_id);
            self::update_currency_and_shipping_method($record, $user_id);
			self::update_customer_custom_fields($record, $user_id);
			self::update_pricing_level($record, $user_id);
            self::update_agents($record, $user_id);
            if ( strtolower(get_user_meta($user_id, 'ns_division_name', true)) == 'electrical' ) {
                self::update_main_location( $record, $user_id );
            }

			if ( in_array(self::$customer_log_level, array('DEBUG', 'LOG') ) ) {
				self::handleLog(0, $ns_customer_id, 'customer', 'Customer ID ' . $ns_customer_id . ' data updated.');
			}

		}


		public static function auto_select_default_shipping_method() {

			if ( isset(WC()->session) && ! WC()->session->has_session() ) {
				WC()->session->set_customer_session_cookie( true );
			}

			// print_r(WC()->session->get('chosen_shipping_methods')); die;

			$shipping_methods = array_map( function( $n ) { return $n->get_label(); }, WC()->session->get('shipping_for_package_0')['rates'] );
			$shipping_method = null;

			$default_shipping_method = 6173;
			if ( ( $id = array_search( $default_shipping_method, $shipping_methods ) ) ) {
				$shipping_method = $id;
			}

			if ( ( $preferred_shipping_method = get_user_meta( get_current_user_id(), 'ns_shipping_method', true ) ) && ! empty( $preferred_shipping_method ) ) {
				if ( ( $id = array_search( $preferred_shipping_method, $shipping_methods ) ) ) {
					$shipping_method = $id;
				}
			}

			if ( ! empty( $shipping_method ) ) {
				WC()->session->set( 'chosen_shipping_methods', array( $shipping_method ) );
			}
			
		}

		public static function handleLog( $status, $object_id, $object, $search_response, $push_to_db = FALSE) {
			if ( is_object( $search_response ) ) {
				if ( !empty ( $search_response->detail ) ) {
					$log_message = serialize($search_response->detail);
				} else {
					$log_message = serialize($search_response);
				}
			} elseif (is_string($search_response)) {
				$log_message = $search_response;
			} else {
				$log_message = 'Response wasn\'t received';
			}
			if ($push_to_db) {
				self::writeLogtoDB($status, $object_id, $object, $log_message);
			}
			if (0 == $status) {
				$date = date("Y-m-d");
				$log_filename = 'tm_ns_netsuite_customers_response-' . $date . '.log';
				self::logNetsuiteApiError($log_message, $log_filename);
			}
		}

		public static function writeLogtoDB( $status, $object_id, $object, $error = '') {
			global $wpdb;
			$query_array = ['status' => $status, 'woo_object_id' => $object_id, 'operation' => $object];
			$query_array['notes'] = $error;
			$wpdb->insert($wpdb->prefix . 'tm_woo_netsuite_logs', $query_array);
			return false;
		}
		/**
		 * API Error logging function
		 */
		public static function logNetsuiteApiError( $error, $filename ) {
			$uploads 		= wp_upload_dir();
			$folder_name 	= 'netsuite-customer-logs';
			$path_folder 	= $uploads['basedir'] . '/' . $folder_name;
			$file 			= $path_folder . '/' . $filename;

			if ( !file_exists($path_folder)) {
				mkdir( $path_folder, 0755 );
			}

			if (!file_exists($file)) {
				$log_file = fopen($file, 'w');
				chmod($file, 0777);
				fclose($log_file);
			}

			if (!is_writable($file)) {
				chmod($file, 0777);
			}
			$error = "\n" . gmdate('Y-m-d H:i:s') . '->' . $error . ' ;';
			file_put_contents($file, $error, FILE_APPEND);
		}

        //TODO item/group pricings were rewritten strictly for performance improvements, this is probably not needed anymore
		protected static function get_user_custom_prices_count($user_id) {
			global $wpdb;

			$query = $wpdb->prepare(
				"SELECT COUNT(meta_key) as meta_count
						FROM {$wpdb->usermeta}
       					WHERE meta_key IN ('ns_group_pricing', 'ns_item_pricing')
						AND user_id = %d",
						$user_id
			);

			$result = $wpdb->get_var($query);

			return (int) $result;
		}

        /**
         * Creates new item_pricing entry in database
         *
         * @param $ns_item_pricing_values
         * @return void
         */
        protected static function insert_ns_item_pricing_into_db( $ns_item_pricing_values, $placeholders ): void
        {
            global $wpdb;
            $ns_items_pricing_table_name = self::$ns_items_pricing_table_name;

            $query_ns_item_pricing_insert = $wpdb->prepare( "INSERT INTO `{$ns_items_pricing_table_name}` 
                (`user_id`, `ns_internal_id`, `sku_name`, `price`, `currency_id`, `currency_name`, `price_id`, `price_name`) 
                VALUES " . implode( ',', $placeholders ),
                $ns_item_pricing_values
            );

            $wpdb->query( $query_ns_item_pricing_insert );
        }

        /**
         * Clears all items_pricings for the given user
         *
         * @param $user_id
         * @return void
         */
        protected static function delete_ns_item_pricing_for_user( $user_id ): void
        {
            global $wpdb;
            $ns_items_pricing_table_name = self::$ns_items_pricing_table_name;
            $wpdb->query( $wpdb->prepare( "DELETE FROM `{$ns_items_pricing_table_name}` WHERE user_id = %d ", $user_id ) );
        }

        /**
         * Gets items_pricings for the user-product combination
         *
         * @param $user_id
         * @param $product_sku
         * @return array|object|stdClass[]|null
         */
        protected static function get_ns_item_pricing_for_user_by_product_sku( $user_id, $product_sku_name ) {
            global $wpdb;
            $ns_items_pricing_table_name = self::$ns_items_pricing_table_name;
            $item_result = $wpdb->get_results( $wpdb->prepare("SELECT * FROM `{$ns_items_pricing_table_name}` WHERE user_id = %d and sku_name = %s",
                $user_id, $product_sku_name ) );

            return $item_result;
        }

        /**
         * Creates new group_pricing entry in database
         *
         * @param $ns_group_pricing_values
         * @return void
         */
        protected static function insert_ns_group_pricing_into_db( $ns_group_pricing_values, $placeholders ): void
        {
            global $wpdb;
            $ns_groups_pricing_table_name = self::$ns_groups_pricing_table_name;

            $query_ns_group_pricing_insert = $wpdb->prepare( "INSERT INTO `{$ns_groups_pricing_table_name}` 
                (`user_id`, `ns_group_id`, `group_name`, `price_id`, `price_name`) 
                VALUES " . implode( ',', $placeholders ),
                $ns_group_pricing_values
            );

            $wpdb->query( $query_ns_group_pricing_insert );
        }

        /**
         * Clears all groups_pricings for the given user
         *
         * @param $user_id
         * @return void
         */
        protected static function delete_ns_group_pricing_for_user( $user_id ): void
        {
            global $wpdb;
            $ns_groups_pricing_table_name = self::$ns_groups_pricing_table_name;
            $wpdb->query( $wpdb->prepare( "DELETE FROM `{$ns_groups_pricing_table_name}` WHERE user_id = %d ", $user_id ) );
        }

        /**
         * Gets group_pricings for the user-group combination
         *
         * @param $user_id
         * @param $group_id
         * @return array|object|stdClass[]|null
         */
        protected static function get_ns_group_pricing_for_user_by_group_id( $user_id, $group_id ) {
            global $wpdb;
            $ns_groups_pricing_table_name = self::$ns_groups_pricing_table_name;
            $group_result = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `{$ns_groups_pricing_table_name}` WHERE user_id = %d and ns_group_id = %d",
                $user_id, $group_id ) );

            return $group_result;
        }


        public static function setPropertiesConstantsFromConfig() {
            if (defined( 'NS_AUTO_SYNC_CUSTOMER_DATA_ENABLED' ) ) {
                self::$customer_auto_sync_data_enabled = NS_AUTO_SYNC_CUSTOMER_DATA_ENABLED;
                    }
            if ( defined( 'NS_CUSTOMER_PRICES_COUNT_LIMIT' ) ) {
                self::$customer_prices_count_limit = NS_CUSTOMER_PRICES_COUNT_LIMIT;
            }
            if ( defined( 'NS_CUSTOMER_LOG_LEVEL' ) ) {
                self::$customer_log_level = NS_CUSTOMER_LOG_LEVEL;
            }
            if ( defined( 'NS_CUSTOMER_SYNC_SENT_PAYLOAD_ENABLED' ) ) {
                self::$customer_sync_sent_payload_enabled = NS_CUSTOMER_SYNC_SENT_PAYLOAD_ENABLED;
            }
            if ( defined( 'NS_SYNC_CUSTOMER_LAST_MODIFIED_DATE_ENABLED' ) ) {
                self::$ns_sync_customer_last_modified_date_enabled = NS_SYNC_CUSTOMER_LAST_MODIFIED_DATE_ENABLED;
            }
        }

        public static function apply_nsi_rules_and_set_country(mixed $address_record,WC_Customer $customer, Address_Type $address_type):void {
            $country = $address_record->addressbookAddress->country;
            $state = $address_record->addressbookAddress->state;

            $country_code = match($country) {
                '_unitedStates' => match($state) {
                    'PR' => 'PR',
                    'GU' => 'GU',
                    default => 'US',
                },
                '_puertoRico' => 'PR',
                '_canada'=>'CA',
                '_virginIslandsUSA'=>'VI',
                '_guam'=>'GU',
                default=>'',
                };

            //Legacy compatibility
            if ($address_type == Address_Type::Billing) {
                $customer->set_billing_country($country_code);
                if ($country_code == 'PR') {
                    $customer->set_billing_state('PR');
                }
            } else {
                $customer->set_shipping_country($country_code);
                if ($country_code == 'PR') {
                    $customer->set_shipping_state('PR');
                }
            }
        }

        public static function merge_users( $new_user_id, $old_user_id, $transfer_user_meta = false ) {

            if ($transfer_user_meta) {
                $meta_data = get_user_meta( $old_user_id );
                foreach ( $meta_data as $meta_key => $meta_values ) {
                    foreach ( $meta_values as $meta_value ) {
                        add_user_meta( $new_user_id, $meta_key, maybe_unserialize( $meta_value ) );
                    }
                }
            }

            wp_delete_user( $old_user_id, $new_user_id );

            if ( in_array( self::$customer_log_level, array( 'DEBUG', 'LOG' ) ) ) {
                self::handleLog( 0, $new_user_id, 'customer', 'Merged user ID ' . $old_user_id . ' into user ID ' . $new_user_id );
            }
        }


        public static function restrict_inactive_users($user) {
            $is_inactive = get_user_meta($user->ID, 'inactive', true);
            return $is_inactive
                ? new WP_Error('inactive_user', __('Your account is inactive. Please contact the administrator.'))
                : $user;
        }

        public static function modify_login_session_expiration($expiration, $user_id, $remember) {
            if (defined('NSI_DEFAULT_USER_SESSION_EXPIRATION') && !$remember) {
                return NSI_DEFAULT_USER_SESSION_EXPIRATION;
            }
            if (defined('NSI_REMEMBER_ME_SESSION_EXPIRATION') && $remember) {
                return NSI_REMEMBER_ME_SESSION_EXPIRATION;
            }
            return $expiration;
        }

        public static function update_pricing_level(mixed $record, $user_id):void {
			$price_level_id = '';
			$price_level_name = '';
			if ( property_exists( $record, 'priceLevel' ) && is_object( $record->priceLevel ) ) {
				if ( property_exists( $record->priceLevel, 'internalId' ) ) {
					$price_level_id = $record->priceLevel->internalId;
				}
				if ( property_exists( $record->priceLevel, 'name' ) ) {
					$price_level_name = $record->priceLevel->name;
				}
			}
			update_user_meta( $user_id, 'ns_price_level_id', $price_level_id );
			update_user_meta( $user_id, 'ns_price_level_name', $price_level_name );

            self::delete_ns_item_pricing_for_user( $user_id );
            if (
                property_exists( $record, 'itemPricingList' ) && is_object( $record->itemPricingList )
                && property_exists( $record->itemPricingList, 'itemPricing' )
                && is_array( $record->itemPricingList->itemPricing )
            ) {
                $ns_item_pricing_counter = 0;
                $ns_item_pricing_limit = 100;
                $values_ns_item_pricing_to_insert = [];
                $placeholders_format = '(%d, %d, "%s", %f, %d, "%s", %d, "%s")';
                $placeholders = [];

                foreach ( $record->itemPricingList->itemPricing as $item_pricing_record ) {
                    $item_pricing = self::get_item_pricing( $item_pricing_record );
                    if ( $item_pricing ) {
                        $placeholders[] = $placeholders_format;

                        $values_ns_item_pricing_to_insert[] = $user_id;
                        $values_ns_item_pricing_to_insert[] = $item_pricing['id'];
                        $values_ns_item_pricing_to_insert[] = $item_pricing['name'];
                        $values_ns_item_pricing_to_insert[] = $item_pricing['price'];
                        $values_ns_item_pricing_to_insert[] = $item_pricing['currency_id'];
                        $values_ns_item_pricing_to_insert[] = $item_pricing['currency_name'];
                        $values_ns_item_pricing_to_insert[] = $item_pricing['price_id'];
                        $values_ns_item_pricing_to_insert[] = $item_pricing['price_name'];
                        $ns_item_pricing_counter++;

                        //inserting values in chunks up to 100records per insert
                        if( $ns_item_pricing_counter > $ns_item_pricing_limit ) {
                            self::insert_ns_item_pricing_into_db( $values_ns_item_pricing_to_insert, $placeholders );
                            $values_ns_item_pricing_to_insert = [];
                            $placeholders = [];
                            $ns_item_pricing_counter = 0;
                        }
                    }
                }

                //inserting rest of the values
                if( count( $values_ns_item_pricing_to_insert ) > 0 ) {
                    self::insert_ns_item_pricing_into_db( $values_ns_item_pricing_to_insert, $placeholders );
                    unset( $values_ns_item_pricing_to_insert );
                    unset( $placeholders );
                }
            }

            self::delete_ns_group_pricing_for_user( $user_id );
            if (
                property_exists( $record, 'groupPricingList' ) && is_object( $record->groupPricingList )
                && property_exists( $record->groupPricingList, 'groupPricing' )
                && is_array( $record->groupPricingList->groupPricing )
            ) {
                $ns_group_pricing_counter = 0;
                $ns_group_pricing_limit = 100;
                $values_ns_group_pricing_to_insert = [];
                $group_placeholder_format = '(%d, %d, "%s", %d, "%s")';
                $group_placeholders = [];

                foreach ( $record->groupPricingList->groupPricing as $group_pricing_record ) {
                    $group_pricing = self::get_group_pricing( $group_pricing_record );
                    if ( $group_pricing ) {
                        $values_ns_group_pricing_to_insert[] = $user_id;
                        $values_ns_group_pricing_to_insert[] = $group_pricing['group_id'];
                        $values_ns_group_pricing_to_insert[] = $group_pricing['group_name'];
                        $values_ns_group_pricing_to_insert[] = $group_pricing['price_id'];
                        $values_ns_group_pricing_to_insert[] = $group_pricing['price_name'];
                        $group_placeholders[] = $group_placeholder_format;
                        $ns_group_pricing_counter++;

                        //inserting values in chunks up to 100records per insert
                        if( $ns_group_pricing_counter > $ns_group_pricing_limit ) {
                            self::insert_ns_group_pricing_into_db( $values_ns_group_pricing_to_insert, $group_placeholders );
                            $values_ns_group_pricing_to_insert = [];
                            $ns_group_pricing_counter = 0;
                        }
                    }
                }

                //inserting rest of the values
                if( count( $values_ns_group_pricing_to_insert ) > 0 ) {
                    self::insert_ns_group_pricing_into_db( $values_ns_group_pricing_to_insert, $group_placeholders );
                    unset( $values_ns_group_pricing_to_insert );
                    unset( $group_placeholders );
                }
            }
        }

        public static function update_main_location( $record, $user_id ) {
			if (
				property_exists( $record, 'customFieldList' )
				&& is_object( $record->customFieldList )
				&& property_exists( $record->customFieldList, 'customField' )
				&& is_array( $record->customFieldList->customField )
			) {
				foreach ( $record->customFieldList->customField as $custom_field_record ) {
					if (
						is_object( $custom_field_record )
						&& $custom_field_record->scriptId === 'custentity_nsi_location'
						&& property_exists( $custom_field_record, 'value' )
					) {
						$main_location_id = $custom_field_record->value->internalId;
						$main_location_name = $custom_field_record->value->name;
						break;
					}
				}
			}

            update_user_meta( $user_id, 'ns_main_location', json_encode(array(
                'id' => $main_location_id ?? '',
                'name' => $main_location_name ?? ''
            )) );
        }

        public static function update_customer_custom_fields(mixed $record,$user_id):void {
			$division_id = '';
			$division_name = '';
            $ns_bridgeport_customer_id = '';
			$allow_restricted_items = false;
            $trans_freight_level_id = '';
			$trans_freight_level_name = '';
			if (
				property_exists( $record, 'customFieldList' )
				&& is_object( $record->customFieldList )
				&& property_exists( $record->customFieldList, 'customField' )
				&& is_array( $record->customFieldList->customField )
			) {
				foreach ( $record->customFieldList->customField as $custom_field_record ) {
					// Update restriction flag.
					if (
						is_object( $custom_field_record )
						&& $custom_field_record->scriptId === 'custentity_nsi_allow_rest_items'
						&& property_exists( $custom_field_record, 'value' )
					) {
						$allow_restricted_items = $custom_field_record->value;
						continue;
					}

                    // Update Bridgeport customer id.
					if (
						is_object( $custom_field_record )
						&& $custom_field_record->scriptId === 'custentity_nsi_bridgeport_customer_id'
						&& property_exists( $custom_field_record, 'value' )
					) {
						$ns_bridgeport_customer_id = $custom_field_record->value;
						continue;
					}

                    // Update customer freight level.
                    if (
						is_object( $custom_field_record )
						&& $custom_field_record->scriptId === 'custentityentity_freight_level'
						&& property_exists( $custom_field_record, 'value' )
						&& is_object( $custom_field_record->value )
					) {
                        if ( property_exists( $custom_field_record->value, 'internalId' ) ) {
						    $trans_freight_level_id = $custom_field_record->value->internalId;
					    }
					    if ( property_exists( $custom_field_record->value, 'name' ) ) {
						    $trans_freight_level_name = $custom_field_record->value->name;
					    }
						continue;
					}

					if (
						! is_object( $custom_field_record )
						|| $custom_field_record->scriptId !== 'custentity_division'
						|| ! property_exists( $custom_field_record, 'value' )
						|| ! is_object( $custom_field_record->value )
					) {
						continue;
					}
					if ( property_exists( $custom_field_record->value, 'internalId' ) ) {
						$division_id = $custom_field_record->value->internalId;
					}
					if ( property_exists( $custom_field_record->value, 'name' ) ) {
						$division_name = $custom_field_record->value->name;
					}
				}
			}
            $is_flag_sync_disabled = get_user_meta( $user_id, 'ns_disable_restricted_flag_sync', true );
            if ( !$is_flag_sync_disabled ) {
			update_user_meta( $user_id, 'ns_bridgeport_customer_id', $ns_bridgeport_customer_id );
                update_user_meta( $user_id, 'ns_allow_restricted_items', $allow_restricted_items );
            }
			update_user_meta( $user_id, 'ns_bridgeport_customer_id', $ns_bridgeport_customer_id );
            update_user_meta( $user_id, 'ns_trans_freight_level_id', $trans_freight_level_id );
			update_user_meta( $user_id, 'ns_trans_freight_level_name', $trans_freight_level_name );
			update_user_meta( $user_id, 'ns_division_id', $division_id );
			update_user_meta( $user_id, 'ns_division_name', $division_name );
        }

        public static function update_currency_and_shipping_method(mixed $record,$user_id):void {
			$currency_id = 1;
			$currency_name = 'US Dollar';
			if ( property_exists( $record, 'currency' ) && is_object( $record->currency ) ) {
				if ( property_exists( $record->currency, 'internalId' ) ) {
					$currency_id = $record->currency->internalId;
				}
				if ( property_exists( $record->currency, 'name' ) ) {
					$currency_name = $record->currency->name;
				}
			}
			update_user_meta( $user_id, 'ns_currency_id', $currency_id );
			update_user_meta( $user_id, 'ns_currency_name', $currency_name );
            if ( property_exists( $record, 'shippingItem' ) && is_object( $record->shippingItem ) ) {
				if ( property_exists( $record->shippingItem, 'internalId' ) ) {
					update_user_meta( $user_id, 'ns_shipping_method', $record->shippingItem->internalId );
				}
			}
        }

        public static function create_or_update_customer($user_id,$company_name,mixed $record):void {
            $customer = new WC_Customer( $user_id );
			if ( $company_name ) {
                $customer->set_first_name( $company_name );
                $customer->set_billing_first_name( $company_name );
                $customer->set_billing_last_name( 'Company' );
                $customer->set_billing_company( $company_name );
                $customer->set_shipping_first_name( $company_name );
                $customer->set_shipping_last_name( 'Company' );
                $customer->set_shipping_company( $company_name );
			}

			$email = property_exists( $record, 'email' ) ? $record->email : null;
			if ( $email && ! empty( $email ) ) {
                $customer->set_billing_email( $email );
			} else {
                $customer->set_billing_email( '' );
			}

			$phone = property_exists( $record, 'phone' ) ? $record->phone : null;
			if ( $phone && ! empty( $phone ) ) {
                $customer->set_billing_phone( $phone );
                $customer->set_shipping_phone( $phone );
			}

			if ( property_exists( $record, 'addressbookList' ) && is_object( $record->addressbookList ) && property_exists( $record->addressbookList, 'addressbook' ) && is_array( $record->addressbookList->addressbook ) ) {
				foreach ( $record->addressbookList->addressbook as $address_record ) {
					if ( ! is_object( $address_record ) || ! property_exists( $address_record, 'addressbookAddress' ) || ! is_object( $address_record->addressbookAddress ) ) continue;

                    if ( boolval( $address_record->defaultShipping ) ) {
                        $customer->set_shipping_address_1( $address_record->addressbookAddress->addr1 ?? '' );
                        $customer->set_shipping_address_2( $address_record->addressbookAddress->addr2 ?? '' );
                        $customer->set_shipping_city( $address_record->addressbookAddress->city ?? '' );
                        $customer->set_shipping_state( $address_record->addressbookAddress->state ?? '' );
                        $customer->set_shipping_postcode( str_pad( $address_record->addressbookAddress->zip, 5, '0', STR_PAD_LEFT ) ?? '' );
                        self::apply_nsi_rules_and_set_country($address_record, $customer, Address_Type::Shipping);

                   }
                    if ( boolval( $address_record->defaultBilling ) ) {
                        $customer->set_billing_address_1( $address_record->addressbookAddress->addr1 ?? '' );
                        $customer->set_billing_address_2( $address_record->addressbookAddress->addr2 ?? '' );
                        $customer->set_billing_city( $address_record->addressbookAddress->city ?? '' );
                        $customer->set_billing_state( $address_record->addressbookAddress->state ?? '' );
                        $customer->set_billing_postcode( str_pad( $address_record->addressbookAddress->zip, 5, '0', STR_PAD_LEFT ) ?? '' );
                        self::apply_nsi_rules_and_set_country($address_record, $customer, Address_Type::Billing);
                    }

				}
			}
            $customer->save();
        }
        public static function update_company_name($company_name,$user_id):void {
            if ( $company_name ) {
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => $company_name
                ]);
                update_user_meta( $user_id, 'nickname', $company_name );
            }
        }

        public static function get_merge_previous_id_customer_with_new(mixed $ns_customer_id,mixed $ns_customer_name,$user_id):void {
            $previous_ns_customer_id = $ns_customer_id;
            $user_id_by_ns_id =  get_users(
                [
                    'meta_query' => [
                        'relation' => 'AND',
                        [
                            'key' => 'ns_customer_internal_id',
                            'value' => $previous_ns_customer_id,
                            'compare' => '='
                        ],
                        [
                            'key' => 'nickname',
                            'value' => $ns_customer_name,
                            'compare' => '='
                        ]
                    ],
                    'fields' => 'ID'
                ]
             );

            if ( !empty( $user_id_by_ns_id ) ) {
                foreach ( $user_id_by_ns_id as $user_id_to_merge ) {
                    if ( $user_id_to_merge != $user_id ) {
                        self::merge_users( $user_id, $user_id_to_merge );
                    }
                }
            }
        }
        public static function check_scope_and_update_inactive_flag($user_id,mixed $record):void {
            $user_roles = get_userdata($user_id)->roles;
            $user_role_to_include = 'customer';
            if (in_array($user_role_to_include, $user_roles)) {
                $is_inactive = property_exists( $record, 'isInactive' ) ? $record->isInactive : false;
                update_user_meta( $user_id, 'inactive', $is_inactive );
            }
        }

        public static function update_agents( $record, $user_id ) {
            if ( property_exists( $record, 'partnersList' ) && is_object( $record->partnersList ) ) {
				$rep_agent_partner_name = $record->partnersList->partners[0]->partner->name ?? '';
				$rep_agent_partner_internal_id = $record->partnersList->partners[0]->partner->internalId ?? '';
                update_user_meta( $user_id, 'rep_agent_partner_name', $rep_agent_partner_name );
                update_user_meta( $user_id, 'rep_agent_partner_internal_id', $rep_agent_partner_internal_id );
			}

            if ( property_exists( $record, 'parent' ) && is_object( $record->parent ) ) {
				$parent_rep_agent_partner_name = $record->parent->name ?? '';
				$parent_rep_agent_partner_internal_id = $record->parent->internalId ?? '';
                update_user_meta( $user_id, 'parent_rep_agent_partner_name', $parent_rep_agent_partner_name );
                update_user_meta( $user_id, 'parent_rep_agent_partner_internal_id', $parent_rep_agent_partner_internal_id );
			}
        }

   }
}