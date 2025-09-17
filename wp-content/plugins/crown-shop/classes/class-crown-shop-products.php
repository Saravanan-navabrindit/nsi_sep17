<?php

use Crown\Form\Field;
use Crown\Form\Input\Text as TextInput;
use Crown\Form\Input\Media as MediaInput;
use Crown\Form\Input\Select;
use Crown\Post\Taxonomy;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

if ( ! class_exists( 'Crown_Shop_Products' ) ) {
	class Crown_Shop_Products {

		public static $init = false;

		public static $APP_BOTS = array();

		public static $product_post_type = null;
		public static $product_cat_taxonomy = null;
		public static $product_industry_taxonomy = null;
		public static $product_brand_taxonomy = null;
        public static string $dropship_inventory_table_name;
        public static string $backup_locations_table_name;
        public static string $ns_shipping_methods_table_name;
        public static string $promotion_codes_table_name;
        public static string $terms_labels_table_name;
        public static string $currency_labels_table_name;
        public static $dropship_inventory_extended_logs_enabled = FALSE;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;
			require_once __DIR__ . '/../data/app-bots.php';

			$plugin_file = preg_replace( '/\/classes$/', '', dirname( __FILE__ ) ) . '/plugin.php';
			register_activation_hook( $plugin_file, array( __CLASS__, 'activate' ));
			register_deactivation_hook( $plugin_file, array( __CLASS__, 'deactivate' ));

            self::set_table_names();
            if ( defined( 'DROPSHIP_INVENTORY_EXTENDED_LOGS_ENABLED' ) ) {
                self::$dropship_inventory_extended_logs_enabled = DROPSHIP_INVENTORY_EXTENDED_LOGS_ENABLED;
            }

			add_filter('-1_memory_limit', array( __CLASS__, 'raise_inventory_update_memory_limit' ), 10);
			add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'disable_bots_transients_creation' ), 10 );

			add_action( 'init', array( __CLASS__, 'tm_ns_inventory_auto_sync_disable' ), 1000 );
			add_action( 'init', array( __CLASS__, 'init_tm_ns_inventory_auto_sync_schedule' ) );
			add_action('woocommerce_single_product_summary', array( __CLASS__, 'add_zero_price_notification'), 60 );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_post_type' ), 100 );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_cat_taxonomy' ), 100 );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_industry_taxonomy' ), 100 );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_brand_taxonomy' ), 100 );
			add_action( 'after_setup_theme', array( __CLASS__, 'register_product_attribute_taxonomies' ), 100 );

			add_action( 'crown_tm_ns_process_inventories_sync_price', array( __CLASS__, 'cron_tm_ns_process_inventories_sync_price' ) );
			add_action( 'crown_tm_ns_process_inventories_sync_stock_quant', array( __CLASS__, 'cron_tm_ns_process_inventories_sync_stock_quant' ) );

            add_action( 'tm_ns_process_inventories_price', array( __CLASS__, 'disable_object_cache' ), 1 );
            add_action( 'tm_ns_process_inventories_stock_quant', array( __CLASS__, 'disable_object_cache' ), 1 );

			add_action( 'tm_ns_after_update_item_data', array( __CLASS__, 'tm_ns_after_update_item_data_single_wrapper' ), 10, 2 );
			add_action( 'tm_ns_after_update_kit_item_data', array( __CLASS__, 'tm_ns_after_update_item_data_single_wrapper' ), 10, 2 );
			add_action( 'tm_ns_after_update_item_data_bulk', array( __CLASS__, 'tm_ns_after_update_item_data_bulk_wrapper' ), 10, 2 );
            add_action( 'tm_ns_after_update_kit_item_data_bulk', array( __CLASS__, 'tm_ns_after_update_item_data_bulk_wrapper' ), 10, 2 );
            add_action( 'updated_post_meta', array( __CLASS__, 'log_disable_purchase_product_meta_change' ), 10, 4 );

			add_action( 'template_redirect', array( __CLASS__, 'redirect_sku_request' ) );

			if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'product ns_inventory_sync disable', function( $args ) {
					update_option( 'ns_inventory_sync_disabled', true );
                    //leaving it so already existing crons can be stopped
					wp_clear_scheduled_hook( 'tm_ns_process_inventories' );
					wp_clear_scheduled_hook( 'tm_ns_process_inventories_2' );
					wp_clear_scheduled_hook( 'tm_ns_process_inventories_3' );

                    wp_clear_scheduled_hook( 'tm_ns_process_inventories_price' );
                    wp_clear_scheduled_hook( 'tm_ns_process_inventories_stock_quant' );
					WP_CLI::success( 'NetSuite inventory syncing disabled.' );
				} );
				WP_CLI::add_command( 'product ns_inventory_sync enable', function( $args ) {
					update_option( 'ns_inventory_sync_disabled', false );
					WP_CLI::success( 'NetSuite inventory syncing enabled.' );
				} );
                WP_CLI::add_command('sync dropship inventory', function( $args ) {
                    $result = self::sync_local_dropship_inventory_data_with_external_source();
                    if ( $result ) {
                        WP_CLI::success( 'Dropship inventory synchronized' );
                    } else {
                        WP_CLI::error( 'Something went wrong during sync' );
                    }
                });
			}

            add_action( 'init', array( __CLASS__, 'setup_mappings_libraries_tables' ), 10 );
            add_action( 'init', array( __CLASS__, 'init_get_ns_objects_dictionary_mapping_cron' ) );
            add_action( 'tm_ns_get_ns_objects_dictionary_mapping', array( __CLASS__, 'tm_ns_get_ns_objects_dictionary_mapping_wrapper' ), 10 );

            add_filter( 'cron_schedules', array( __CLASS__, 'add_cron_schedule_three_times_a_day' ) );
            add_action( 'init', array( __CLASS__, 'init_sync_inventory_data_from_azure' ) );
            add_action( 'sync_inventory_data_from_azure', array( __CLASS__, 'cron_sync_inventory_data_from_azure') );
		}

        public static function add_cron_schedule_three_times_a_day( $schedules ) {
            $schedules[ 'threetimesaday' ] = array(
                'interval' => 8 * HOUR_IN_SECONDS,
                'display' => 'Three times a day',
            );

            return $schedules;
        }


		public static function activate() {
			global $wp_roles;

			foreach ( $wp_roles->role_objects as $role ) {
				foreach ( array( 'manage', 'edit', 'delete' ) as $cap ) {
					if ( $role->has_cap( 'manage_categories' ) ) {
						$role->add_cap( $cap . '_product_industries' );
						$role->add_cap( $cap . '_product_brands' );
					}
				}
				if ( $role->has_cap( 'edit_posts' ) ) {
					$role->add_cap( 'assign_product_industries' );
					$role->add_cap( 'assign_product_brands' );
				}
			}

			$attribute_ids = array_map( 'absint', wp_list_pluck( wc_get_attribute_taxonomies(), 'attribute_id', 'attribute_name' ) );

			$map_file = dirname( __FILE__ ) . '/../data/amplifi-product-field-map.json';
			if ( ! file_exists( $map_file ) ) return false;
			$config = json_decode( file_get_contents( $map_file ), true );
			$fields_map = is_array( $config ) && array_key_exists( 'fields', $config ) ? $config['fields'] : null;
			if ( $fields_map ) {

				foreach ( $fields_map as $field_map ) {
					$taxonomy_map = array_merge( array(
						'name' => '',
						'label' => ''
					), array_key_exists( 'taxonomy', $field_map ) ? $field_map['taxonomy'] : array() );
					$field_type = array_key_exists( 'type', $field_map ) ? $field_map['type'] : 'string';
					if ( empty( $taxonomy_map['name'] ) ) continue;
					if ( preg_match( '/^pa_(.+)/', $taxonomy_map['name'], $matches ) ) {
						$tax_args = array(
							'slug' => $matches[1],
							'name' => $matches[1]
						);
						if ( ! empty( $taxonomy_map['label'] ) ) $tax_args['name'] = $taxonomy_map['label'];
						if ( in_array( $field_type, array( 'int', 'float' ) ) ) {
							$tax_args['order_by'] = 'name_num';
						} else {
							$tax_args['order_by'] = 'name';
						}
						if ( ! array_key_exists( $tax_args['slug'], $attribute_ids ) ) {
							wc_create_attribute( $tax_args );
						} else {
							wc_update_attribute( $attribute_ids[ $tax_args['slug'] ], $tax_args );
						}
					}
				}

			}

			// $data = array();
			// foreach ( $fields_map as $field_map ) {
			// 	$field_map = array_merge( array(
			// 		'column' => '',
			// 		'meta_key' => '',
			// 		'type' => 'string',
			// 		'delimiter' => ','
			// 	), $field_map );
			// 	if ( empty( $field_map['column'] ) || empty( $field_map['meta_key'] ) ) continue;
			// }
			// return $data;

			// $attributes = wc_get_attribute_taxonomies();
			// $slugs = wp_list_pluck( $attributes, 'attribute_name' );
			// foreach ( $new_attributes as $slug => $name ) {
			// 	if ( ! in_array( $slug, $slugs ) ) {
			// 		$args = array(
			// 			'slug' => $slug,
			// 			'name' => $name
			// 		);
			// 		if ( in_array( $slug, array( 'weight', 'width', 'length', 'height', 'depth' ) ) ) $args['order_by'] = 'name_num';
			// 		wc_create_attribute( $args );
			// 	}
			// }

			flush_rewrite_rules();
		}


		public static function deactivate() {
			global $wp_roles;

			foreach ( $wp_roles->role_objects as $role ) {
				// foreach ( array( 'publish', 'delete', 'delete_others', 'delete_private', 'delete_published', 'edit', 'edit_others', 'edit_private', 'edit_published', 'read_private' ) as $cap ) {
				// 	$role->remove_cap( $cap . '_products' );
				// }
				foreach ( array( 'manage', 'edit', 'delete', 'assign' ) as $cap ) {
					$role->remove_cap ( $cap . '_product_industries' );
					$role->remove_cap ( $cap . '_product_brands' );
				}
			}

			flush_rewrite_rules();
		}


		public static function register_product_post_type() {

		}


		public static function register_product_cat_taxonomy() {

			self::$product_cat_taxonomy = new Taxonomy( array(
				'name' => 'product_cat',
				'postTypes' => array( 'product' ),
				'fields' => array(
					new Field( array(
						'label' => 'Header Image',
						'input' => new MediaInput( array( 'name' => 'product_cat_header_image', 'mimeType' => 'image' ) )
					) ),
					new Field( array(
						'label' => 'Marketing Page URL',
						'input' => new TextInput( array( 'name' => 'product_cat_marketing_page_url', 'placeholder' => 'https://' ) )
					) )
				)
			) );

		}


		public static function register_product_brand_taxonomy() {

			self::$product_brand_taxonomy = new Taxonomy( array(
				'name' => 'product_brand',
				'singularLabel' => 'Product Brand',
				'pluralLabel' => 'Product Brands',
				'postTypes' => array( 'product' ),
				'settings' => array(
					'hierarchical' => true,
					'public' => true,
					'rewrite' => array( 'slug' => 'product-brands', 'with_front' => false ),
					'show_in_nav_menus' => true,
					'publicly_queryable' => true,
					'show_in_rest' => true,
					'query_var' => true,
					'labels' => array(
						'menu_name' => 'Brands',
						'all_items' => 'All Brands'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_product_brands',
						'edit_terms' => 'manage_product_brands',
						'delete_terms' => 'manage_product_brands',
						'assign_terms' => 'manage_product_brands'
					)
				),
				'fields' => array(
					new Field( array(
						'label' => 'Header Image',
						'input' => new MediaInput( array( 'name' => 'product_brand_header_image', 'mimeType' => 'image' ) )
					) ),
					new Field( array(
						'label' => 'Marketing Page URL',
						'input' => new TextInput( array( 'name' => 'product_brand_marketing_page_url', 'placeholder' => 'https://' ) )
					) )
				)
			) );

		}


		public static function register_product_industry_taxonomy() {

			self::$product_industry_taxonomy = new Taxonomy( array(
				'name' => 'product_industry',
				'singularLabel' => 'Product Industry',
				'pluralLabel' => 'Product Industries',
				'postTypes' => array( 'product' ),
				'settings' => array(
					'hierarchical' => true,
					'rewrite' => array( 'slug' => 'product-industries', 'with_front' => false ),
					'show_in_nav_menus' => true,
					'publicly_queryable' => true,
					'labels' => array(
						'menu_name' => 'Industries',
						'all_items' => 'All Industries'
					),
					'capabilities' => array(
						'manage_terms' => 'manage_product_industries',
						'edit_terms' => 'manage_product_industries',
						'delete_terms' => 'manage_product_industries',
						'assign_terms' => 'manage_product_industries'
					)
				),
				'fields' => array(
					new Field( array(
						'label' => 'Header Image',
						'input' => new MediaInput( array( 'name' => 'product_industry_header_image', 'mimeType' => 'image' ) )
					) ),
					new Field( array(
						'label' => 'Marketing Page URL',
						'input' => new TextInput( array( 'name' => 'product_industry_marketing_page_url', 'placeholder' => 'https://' ) )
					) ),
					new Field( array(
						'label' => 'Related Categories',
						'input' => new Select( array( 'name' => 'product_industry_product_categories', 'multiple' => true, 'select2' => array( 'sortable' => true ) ) ),
						'getOutputCb' => array( __CLASS__, 'set_tl_product_category_select_input_options' )
					) ),
				)
			) );

		}


		public static function set_tl_product_category_select_input_options( $field, $args ) {
			$options = array();
			$terms = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'orderby' => 'name', 'order' => 'ASC' ) );
			foreach ( $terms as $term ) {
				$options[] = array( 'value' => $term->term_id, 'label' => $term->name );
			}
			$field->getInput()->setOptions( $options );
		}


		public static function register_product_attribute_taxonomies() {

			// $new_attributes = array(
			// 	'color' => 'Color',
			// 	'weight' => 'Weight',
			// 	'width' => 'Width',
			// 	'length' => 'Length',
			// 	'height' => 'Height',
			// 	'depth' => 'Depth'
			// );

			// $attributes = wc_get_attribute_taxonomies();
			// $slugs = wp_list_pluck( $attributes, 'attribute_name' );
			// foreach ( $new_attributes as $slug => $name ) {
			// 	if ( ! in_array( $slug, $slugs ) ) {
			// 		wc_create_attribute( array(
			// 			'slug' => $slug,
			// 			'name' => $name
			// 		) );
			// 	}
			// }

		}


		public static function disable_object_cache() {
			if ( function_exists( 'wpe_disable_object_cache' ) ) wpe_disable_object_cache();
		}

        public static function tm_ns_after_update_item_data_single_wrapper( $search_response, $product_id ) {
            $record = $search_response->searchResult->recordList->record[0];
            self::tm_ns_after_update_item_data( $record, $product_id );
        }

        public static function tm_ns_after_update_item_data_bulk_wrapper( $record, $product_id ) {
            self::tm_ns_after_update_item_data( $record, $product_id );
        }

		public static function tm_ns_after_update_item_data( $record, $product_id ) {
            $product_post_meta = get_post_meta( $product_id, '', true );

			$pricing_group_id = '';
			$pricing_group_name = '';
			$pricing_group = property_exists( $record, 'pricingGroup' ) && is_object( $record->pricingGroup ) ? $record->pricingGroup : null;
			if ( $pricing_group ) {
				$pricing_group_id = property_exists( $pricing_group, 'internalId' ) ? $pricing_group->internalId : $pricing_group_id;
				$pricing_group_name = property_exists( $pricing_group, 'name' ) ? $pricing_group->name : $pricing_group_name;
			}

            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_item_pricing_group_id', $pricing_group_id );
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_item_pricing_group_name', $pricing_group_name );

			$pricing_levels = array();
			if ( property_exists( $record, 'pricingMatrix' ) && is_object( $record->pricingMatrix ) && property_exists( $record->pricingMatrix, 'pricing' ) && is_array( $record->pricingMatrix->pricing ) ) {
				foreach ( $record->pricingMatrix->pricing as $pricing_level_record ) {
					$pricing_level = self::get_pricing_level( $pricing_level_record );
					if ( $pricing_level ) {
                        if ( isset( $pricing_level['price_list'] ) ) {
                            ksort( $pricing_level['price_list'] );
                        }
						$pricing_levels[ $pricing_level['currency_id'] . '_' . $pricing_level['id'] ] = $pricing_level;
					}
				}
			}
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_pricing_levels', $pricing_levels );

			$price_qty_multiplier = 1;
            $upc_code_w_check_digit = '';
			if ( property_exists( $record, 'customFieldList' ) && is_object( $record->customFieldList ) && property_exists( $record->customFieldList, 'customField' ) && is_array( $record->customFieldList->customField ) ) {
				foreach ( $record->customFieldList->customField as $field ) {
					if ( ! is_object( $field ) ) continue;
					$field_name = property_exists( $field, 'scriptId' ) ? $field->scriptId : '';
					$value = property_exists( $field, 'value' ) ? $field->value : null;
					if ( $field_name == 'custitem_nsi_industry_standard' && floatval( $value ) > 0 ) {
						$price_qty_multiplier = floatval( $value );
					}

                    if ( $field_name == 'custitem_nsi_fullupccode' && !empty( $value ) ) {
                        $upc_code_w_check_digit = $value;
                    }
				}
			}
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_price_qty_multiplier', $price_qty_multiplier );

            if ( !empty($upc_code_w_check_digit) ) {
                self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_upc_code', $upc_code_w_check_digit );
            }

            if ( property_exists( $record, 'isInactive' )) {
                $inactive_flag_sync_disabled = get_post_meta( $product_id, '_disable_inactive_flag_sync', true );
                if ( $inactive_flag_sync_disabled !== 'yes' ) {
                    $disable_purchase = $record->isInactive ? 'yes' : 'no';
                    self::maybe_update_postmeta( $product_id, $product_post_meta, '_disable_purchase', $disable_purchase );
                }
			}

			$restricted_item_flag = self::tm_ns_get_custom_field_item_flag( $record, 'custitem_nsi_restricted_item_flag' );
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_restricted_item_flag', $restricted_item_flag );

			$discontinued_item_flag = self::tm_ns_get_custom_field_item_flag( $record, 'custitem_nsi_discontinued' );
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_discontinued_item_flag', $discontinued_item_flag );

			$returnable_item_flag = self::tm_ns_get_custom_field_item_flag( $record, 'custitem3' );
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_returnable_item_flag', $returnable_item_flag );

			$dropship_item_flag = $record->isDropShipItem ? 'yes' : 'no';
            self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_dropship_item_flag', $dropship_item_flag );

            if ( isset($record->salesDescription) ) {
                $sales_desc = $record->salesDescription;
                if ( !empty($sales_desc) ) {
                    self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_sales_desc', $sales_desc );
                }
            } else if ( isset($record->description) ) {
                $sales_desc = $record->description;
                if ( !empty($sales_desc) ) {
                    self::maybe_update_postmeta( $product_id, $product_post_meta, 'ns_sales_desc', $sales_desc );
                }
            }
		}

        public static function maybe_update_postmeta( $product_id, $product_post_meta, $meta_name, $meta_value ) {
            if ( !isset($product_post_meta[$meta_name][0]) || $product_post_meta[$meta_name][0] != $meta_value ) {
                if ( $meta_name == '_disable_purchase' ) {
                    $log_file = Nsi_Helper::get_ns_sync_log_file();
                    if ( $log_file ) {
                        $log_content = '<p><b>_disable_purchase meta updated, new value: ' . $meta_value . '</b></p>';
                        file_put_contents( $log_file, $log_content . PHP_EOL, FILE_APPEND );
                    }
                }
                update_post_meta( $product_id, $meta_name, $meta_value );
            }
        }

		protected static function get_pricing_level( $record ) {
			// if ( ! property_exists( $record, 'currency' ) || ! is_object( $record->currency ) || ! property_exists( $record->currency, 'name' ) || $record->currency->name != 'US Dollar' ) return null;
			$pricing_level = array(
				'id' => '',
				'name' => '',
				'discount_pct' => null,
				'price_list' => array(),
				'currency_id' => 1,
				'currency_name' => 'US Dollar'
			);
			if ( is_object( $record ) ) {
				if ( property_exists( $record, 'priceLevel' ) && is_object( $record->priceLevel ) ) {
					if ( property_exists( $record->priceLevel, 'internalId' ) ) $pricing_level['id'] = $record->priceLevel->internalId;
					if ( property_exists( $record->priceLevel, 'name' ) ) $pricing_level['name'] = $record->priceLevel->name;
				}
				if ( property_exists( $record, 'discount' ) ) $pricing_level['discount_pct'] = $record->discount;
				if ( property_exists( $record, 'priceList' ) && is_object( $record->priceList ) && property_exists( $record->priceList, 'price' ) && is_array( $record->priceList->price ) ) {
					foreach ( $record->priceList->price as $price_record ) {
						if ( is_object( $price_record ) && property_exists( $price_record, 'value' ) && property_exists( $price_record, 'quantity' ) ) {
							$price = array(
								'value' => $price_record->value,
								'qty' => $price_record->quantity
							);
							$pricing_level['price_list'][ $price['qty'] ] = $price;
						}
					}
				}
				if ( property_exists( $record, 'currency' ) && is_object( $record->currency ) ) {
					if ( property_exists( $record->currency, 'internalId' ) ) $pricing_level['currency_id'] = $record->currency->internalId;
					if ( property_exists( $record->currency, 'name' ) ) $pricing_level['currency_name'] = $record->currency->name;
				}
			}
			if ( empty( $pricing_level['id'] ) || empty( $pricing_level['name'] ) || ( $pricing_level['discount_pct'] === null && empty( $pricing_level['price_list'] ) ) ) return null;
			return $pricing_level;
		}


		public static function redirect_sku_request() {
			if ( ! is_shop() ) return;
			$sku = isset( $_GET['sku'] ) ? trim( $_GET['sku'] ) : '';
			if ( ! empty( $sku ) ) {
				$product_id = self::get_product_id_by_sku( $sku );
				if ( $product_id ) {
					wp_redirect( get_permalink( $product_id ) );
					die;
				}
			}
		}

		protected static function get_product_id_by_sku( $sku ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT
						p.ID AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->wc_product_meta_lookup pm1 ON (pm1.product_id = p.ID)
					WHERE p.post_type = 'product'
					AND pm1.sku = %s
				", $sku ) );
			return $result ? intval( $result ) : $result;
		}

		public static function raise_inventory_update_memory_limit( $filtered_limit ) {
            return defined('MEMORY_LIMIT_NS_SYNC') ? MEMORY_LIMIT_NS_SYNC : '8192M';
		}

		public static function init_tm_ns_inventory_auto_sync_schedule() {
			if ( ! wp_next_scheduled( 'crown_tm_ns_process_inventories_sync_price' ) ) {
				$timezone = get_option( 'timezone_string' );
				$next_sync_time = new DateTime( 'now', new DateTimeZone( $timezone ) );
				$next_sync_time->modify( 'today 5:30pm' );
				wp_schedule_event( intval( $next_sync_time->format( 'U' ) ), 'hourly', 'crown_tm_ns_process_inventories_sync_price' );
			}

            if ( ! wp_next_scheduled( 'crown_tm_ns_process_inventories_sync_stock_quant' ) ) {
				$timezone = get_option( 'timezone_string' );
				$next_sync_time = new DateTime( 'now', new DateTimeZone( $timezone ) );
				$next_sync_time->modify( 'tomorrow 10pm' );
				wp_schedule_event( intval( $next_sync_time->format( 'U' ) ), 'hourly', 'crown_tm_ns_process_inventories_sync_stock_quant' );
			}
		}

        public static function cron_tm_ns_process_inventories_sync_price() {
            do_action('tm_ns_process_inventories_price');
		}

        public static function cron_tm_ns_process_inventories_sync_stock_quant() {
            do_action('tm_ns_process_inventories_stock_quant');
		}

		public static function tm_ns_inventory_auto_sync_disable() {
            $crons_to_disable = array(
                'tm_ns_process_inventories', 'tm_ns_process_inventories_2', 'tm_ns_process_inventories_3',
                'tm_ns_process_inventories_price',
                'tm_ns_process_inventories_stock_quant',
            );

            foreach( $crons_to_disable as $cron_to_disable ) {
                if ( wp_next_scheduled( $cron_to_disable ) ) {
                    wp_clear_scheduled_hook($cron_to_disable);
                }
            }
		}

		private static function tm_ns_get_custom_field_item_flag( $record, $field_name ) {
			$item_flag = 'no';
			if (
				property_exists( $record, 'customFieldList' )
				&& is_object( $record->customFieldList )
				&& property_exists( $record->customFieldList, 'customField' )
				&& is_array( $record->customFieldList->customField )
			) {
				foreach ( $record->customFieldList->customField as $custom_field_record ) {
					// Update flag value.
					if (
						is_object( $custom_field_record )
						&& $custom_field_record->scriptId === $field_name
						&& property_exists( $custom_field_record, 'value' )
					) {
						$item_flag = $custom_field_record->value ? 'yes' : 'no';
                        break;
					}
				}
			}
			return $item_flag;
		}

		public static function add_zero_price_notification() {
			global $product;

			if (is_user_logged_in() && !$product->is_purchasable() && $product->get_price() == 0) {
				echo '<p class="zero-price-notice">Please contact the pricing team.</p>';
			}
		}

		public static function disable_bots_transients_creation() {
			$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : '';

			foreach (self::$APP_BOTS as $item) {
				if (preg_match($item['regexp'], $user_agent)) {
					remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
					break;
				}
			}

		}

        public static function set_table_names() {
            global $wpdb;
            self::$dropship_inventory_table_name = $wpdb->prefix . 'dropship_inventory';
            self::$backup_locations_table_name = $wpdb->prefix . 'ns_backup_locations';
            self::$ns_shipping_methods_table_name = $wpdb->prefix . 'ns_shipping_methods';
            self::$promotion_codes_table_name = $wpdb->prefix . 'ns_promotion_codes';
            self::$terms_labels_table_name = $wpdb->prefix . 'ns_terms_labels';
            self::$currency_labels_table_name = $wpdb->prefix . 'ns_currency_labels';
        }

        public static function setup_mappings_libraries_tables() {
            if( !get_option('dropship_inventory_table_created') ) {
                self::create_dropship_inventory_table();
                update_option( 'dropship_inventory_table_created', true );
            }
            if( !get_option('backup_locations_table_created') ) {
                self::create_backup_locations_table();
                update_option( 'backup_locations_table_created', true );
            }
            if( !get_option('ns_shipping_methods_table_created') ) {
                self::create_ns_shipping_methods_table();
                update_option( 'ns_shipping_methods_table_created', true );
            }
            if( !get_option('promotion_codes_table_created') ) {
                self::create_ns_promotion_codes_table();
                update_option( 'promotion_codes_table_created', true );
            }
            if( !get_option('terms_labels_table_created') ) {
                self::create_ns_terms_labels_table();
                update_option( 'terms_labels_table_created', true );
            }
            if( !get_option('currency_labels_table_created') ) {
                self::create_ns_currency_labels_table();
                update_option( 'currency_labels_table_created', true );
            }
        }

        public static function create_dropship_inventory_table() {
            global $wpdb;
            $table_name = self::$dropship_inventory_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				sku VARCHAR(255) NOT NULL,
				location_name VARCHAR(255) NOT NULL,
				stock_quantity INT DEFAULT 0,
				PRIMARY KEY (id),
                UNIQUE KEY sku_unique (`sku`)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_backup_locations_table() {
            global $wpdb;
            $table_name = self::$backup_locations_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				main_location int(4) UNSIGNED NOT NULL,
				backup_location int(4) UNSIGNED NOT NULL,
				priority int(4) NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_ns_shipping_methods_table() {
            global $wpdb;
            $table_name = self::$ns_shipping_methods_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id int(10) UNSIGNED NOT NULL,
				name varchar(255) NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_ns_promotion_codes_table() {
            global $wpdb;
            $table_name = self::$promotion_codes_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				ns_promo_id int(11) UNSIGNED NOT NULL,
				promo_name VARCHAR(255) NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_ns_terms_labels_table() {
            global $wpdb;
            $table_name = self::$terms_labels_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				ns_terms_id int(11) UNSIGNED NOT NULL,
				terms_name VARCHAR(255) NOT NULL,
				terms_discount_date  VARCHAR(10) NOT NULL,
				terms_discount_expire  VARCHAR(10) NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_ns_currency_labels_table() {
            global $wpdb;
            $table_name = self::$currency_labels_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				ns_currency_id int(11) UNSIGNED NOT NULL,
				currency_name VARCHAR(255) NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function init_get_ns_objects_dictionary_mapping_cron() {
            if ( ! wp_next_scheduled('tm_ns_get_ns_objects_dictionary_mapping') ) {
                wp_schedule_event( time(), 'daily', 'tm_ns_get_ns_objects_dictionary_mapping' );
            }
        }

        public static function tm_ns_get_ns_objects_dictionary_mapping_wrapper() {
            global $TMWNI_OPTIONS;
            $stack = HandlerStack::create();
            $oauth = new Oauth1([
                'consumer_key'     => $TMWNI_OPTIONS['ns_consumer_key'],
                'consumer_secret'  => $TMWNI_OPTIONS['ns_consumer_secret'],
                'token'            => $TMWNI_OPTIONS['ns_token_id'],
                'token_secret'     => $TMWNI_OPTIONS['ns_token_secret'],
                'signature_method' => $TMWNI_OPTIONS['hma_algorithm_method'],
                'realm'            => $TMWNI_OPTIONS['ns_account'],
            ]);
            $stack->push( $oauth );
            $client = new Client([
                'base_uri' => $TMWNI_OPTIONS['ns_restlet_host'] . '/',
                'handler' => $stack
            ]);

            try {
                $res = $client->get( $TMWNI_OPTIONS['ns_mappings_libraries_query'], [
                    'auth' => 'oauth',
                    'headers' => [
                        'Content-type' => 'application/json'
                    ]
                ] );
                $response_body = json_decode( $res->getBody(), true );
            } catch( Exception $e ) {
                error_log( $e->getMessage() );
                return;
            }
            if ( empty($response_body) ) {
                return;
            }

            if ( isset($response_body['Backuplocation']) ) {
                $locations_data = self::get_backup_locations_from_db();
                self::insert_or_update_backup_locations( $response_body['Backuplocation'], $locations_data );
                self::remove_redundant_locations( $response_body['Backuplocation'], $locations_data );
            }

            if ( isset($response_body['ShippingMethod']) ) {
                $ns_shipping_methods_data = self::get_ns_shipping_methods_from_db();
                $api_shipping_methods = self::parse_ns_shipping_methods( $response_body['ShippingMethod'] );
                self::insert_or_update_ns_shipping_methods( $api_shipping_methods, $ns_shipping_methods_data );
                self::remove_redundant_ns_shipping_methods( $api_shipping_methods, $ns_shipping_methods_data );
            }

            if ( isset($response_body['PromotionCode']) ) {
                $promo_codes_data = self::get_ns_promotion_codes_from_db();
                self::insert_or_update_ns_promotion_codes( $response_body['PromotionCode'], $promo_codes_data );
            }
            if ( isset($response_body['Terms']) ) {
                $terms_labels_data = self::get_ns_terms_labels_from_db();
                self::insert_or_update_ns_terms_labels( $response_body['Terms'], $terms_labels_data );
            }
            if ( isset($response_body['Currency']) ) {
                $currency_labels_data = self::get_ns_currency_labels_from_db();
                self::insert_or_update_ns_currency_labels( $response_body['Currency'], $currency_labels_data );
            }
        }

        public static function insert_or_update_backup_locations( $locations_api, $locations_db ) {
            foreach ( $locations_api as $location_api ) {
                $main_location = $location_api['parent_location'];
                $backup_location = $location_api['backup_location'];
                $priority = $location_api['backup_seq'];

                $found = false;
                foreach ( $locations_db as $location_db ) {
                    if ( $location_db['main_location'] == $main_location && $location_db['backup_location'] == $backup_location ) {
                        $found = true;
                        if ( $location_db['priority'] != $priority ) {
                            self::update_backup_location_priority( $priority, $location_db['id'] );
                        }
                        break;
                    }
                }

                if ( !$found ) {
                    self::insert_backup_location( $main_location, $backup_location, $priority );
                }
            }
        }

        public static function insert_or_update_ns_promotion_codes( $ns_promo_codes, $db_promo_codes ) {
            foreach ( $ns_promo_codes as $ns_promo_code ) {
                $ns_promo_id = $ns_promo_code['internalid'];
                $promo_name = $ns_promo_code['name'];

                if (array_key_exists( $ns_promo_id, $db_promo_codes )  ) {
                    if ( $db_promo_codes[$ns_promo_id] != $promo_name ) {
                        self::update_ns_promotion_code_name( $ns_promo_id, $promo_name );
                    }
                } else {
                    self::insert_ns_promotion_code( $ns_promo_id, $promo_name );
                }
            }
        }

        public static function insert_or_update_ns_terms_labels( $ns_terms_labels, $db_terms_labels ) {
            foreach ( $ns_terms_labels as $ns_terms_label ) {
                $ns_terms_id = $ns_terms_label['internalid'];
                $terms_name = $ns_terms_label['name'];
                $terms_discount_date = $ns_terms_label['discountdate'];
                $terms_discount_expire = $ns_terms_label['discountexpire'];

                if (array_key_exists( $ns_terms_id, $db_terms_labels )  ) {
                    if ( $db_terms_labels[$ns_terms_id]['terms_name'] != $terms_name
                        || $db_terms_labels[$ns_terms_id]['terms_discount_date'] != $terms_discount_date
                        || $db_terms_labels[$ns_terms_id]['terms_discount_expire'] != $terms_discount_expire ) {
                        self::update_ns_terms_label( $ns_terms_id, $terms_name, $terms_discount_date, $terms_discount_expire );
                    }
                } else {
                    self::insert_ns_terms_label( $ns_terms_id, $terms_name, $terms_discount_date, $terms_discount_expire );
                }
            }
        }

        public static function insert_or_update_ns_currency_labels( $ns_currency_labels, $db_currency_labels ) {
            foreach ( $ns_currency_labels as $ns_currency_label ) {
                $ns_currency_id = $ns_currency_label['internalid'];
                $currency_name = $ns_currency_label['name'];

                if (array_key_exists( $ns_currency_id, $db_currency_labels )  ) {
                    if ( $db_currency_labels[$ns_currency_id] != $currency_name ) {
                        self::update_ns_currency_label( $ns_currency_id, $currency_name );
                    }
                } else {
                    self::insert_ns_currency_label( $ns_currency_id, $currency_name );
                }
            }
        }

        public static function remove_redundant_locations( $locations_api, $locations_db ) {
            foreach ( $locations_db as $location_db ) {
                $found = false;
                foreach ( $locations_api as $location_api ) {
                    if (
                        $location_db['main_location'] == $location_api['parent_location'] &&
                        $location_db['backup_location'] == $location_api['backup_location']
                    ) {
                        $found = true;
                        break;
                    }
                }

                if ( !$found ) {
                    self::remove_backup_location( $locations_db['id'] );
                }
            }
        }

        public static function get_backup_locations_from_db() {
            global $wpdb;
            $table_name = self::$backup_locations_table_name;

            $backup_locations_result = $wpdb->get_results(
                "SELECT * FROM $table_name", ARRAY_A
            );

            return $backup_locations_result ?? [];
        }

        public static function get_ns_promotion_codes_from_db() {
            global $wpdb;
            $table_name = self::$promotion_codes_table_name;

            $ns_promotion_codes = $wpdb->get_results(
                "SELECT ns_promo_id, promo_name FROM $table_name", ARRAY_A
            );

            return array_column( $ns_promotion_codes, 'promo_name', 'ns_promo_id' ) ?? array();
        }

        public static function insert_ns_promotion_code( $ns_promo_id, $promo_name ) {
            global $wpdb;
            $table_name = self::$promotion_codes_table_name;

            $query_insert = $wpdb->prepare( "INSERT INTO $table_name 
                (`ns_promo_id`, `promo_name`) 
                VALUES (%d, %s)",
                $ns_promo_id, $promo_name
            );

            $wpdb->query( $query_insert );
        }

        public static function update_ns_promotion_code_name( $ns_promo_id, $promo_name ) {
            global $wpdb;
            $table_name = self::$promotion_codes_table_name;

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET promo_name = %s WHERE ns_promo_id = %d",
                $promo_name, $ns_promo_id
            );
            $wpdb->query( $update_query );
        }

        public static function get_ns_terms_labels_from_db() {
            global $wpdb;
            $table_name = self::$terms_labels_table_name;

            $ns_terms_labels = $wpdb->get_results(
                "SELECT ns_terms_id, terms_name, terms_discount_date, terms_discount_expire FROM $table_name", ARRAY_A
            );

            return array_column( $ns_terms_labels, NULL, 'ns_terms_id' ) ?? array();
        }

        public static function insert_ns_terms_label( $ns_terms_id, $terms_name, $terms_discount_date, $terms_discount_expire ) {
            global $wpdb;
            $table_name = self::$terms_labels_table_name;

            $query_insert = $wpdb->prepare( "INSERT INTO $table_name 
                (`ns_terms_id`, `terms_name`, `terms_discount_date`, `terms_discount_expire`) 
                VALUES (%d, %s, %s, %s)",
                $ns_terms_id, $terms_name, $terms_discount_date, $terms_discount_expire
            );

            $wpdb->query( $query_insert );
        }

        public static function update_ns_terms_label( $ns_terms_id, $terms_name, $terms_discount_date, $terms_discount_expire  ) {
            global $wpdb;
            $table_name = self::$terms_labels_table_name;

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET terms_name = %s, terms_discount_date = %s, terms_discount_expire = %s  WHERE ns_terms_id = %d",
                $terms_name, $terms_discount_date, $terms_discount_expire, $ns_terms_id
            );
            $wpdb->query( $update_query );
        }

        public static function get_ns_currency_labels_from_db() {
            global $wpdb;
            $table_name = self::$currency_labels_table_name;

            $ns_currency_labels = $wpdb->get_results(
                "SELECT ns_currency_id, currency_name FROM $table_name", ARRAY_A
            );

            return array_column( $ns_currency_labels, 'currency_name', 'ns_currency_id' ) ?? array();
        }

        public static function insert_ns_currency_label( $ns_currency_id, $currency_name ) {
            global $wpdb;
            $table_name = self::$currency_labels_table_name;

            $query_insert = $wpdb->prepare( "INSERT INTO $table_name 
                (`ns_currency_id`, `currency_name`) 
                VALUES (%d, %s)",
                $ns_currency_id, $currency_name
            );

            $wpdb->query( $query_insert );
        }

        public static function update_ns_currency_label( $ns_currency_id, $currency_name ) {
            global $wpdb;
            $table_name = self::$currency_labels_table_name;

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET currency_name = %s WHERE ns_currency_id = %d",
                $currency_name, $ns_currency_id
            );
            $wpdb->query( $update_query );
        }

        public static function update_backup_location_priority( $priority, $row_id ) {
            global $wpdb;
            $table_name = self::$backup_locations_table_name;

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET priority = %d WHERE id = %d",
                $priority, $row_id
            );
            $wpdb->query( $update_query );
        }

        public static function insert_backup_location( $main_location, $backup_location, $priority ) {
            global $wpdb;
            $table_name = self::$backup_locations_table_name;

            $query_insert = $wpdb->prepare( "INSERT INTO $table_name 
                (`main_location`, `backup_location`, `priority`) 
                VALUES (%d, %d, %d)",
                $main_location, $backup_location, $priority
            );

            $wpdb->query( $query_insert );
        }

        public static function remove_backup_location( $row_id ) {
            global $wpdb;
            $table_name = self::$backup_locations_table_name;
            $wpdb->query( $wpdb->prepare("DELETE FROM $table_name WHERE id = %d ", $row_id) );
        }

        public static function get_backup_location_for_main_location( $main_location ) {
            global $wpdb;
            $table_name = self::$backup_locations_table_name;

            $backup_location_result = $wpdb->get_results(
                $wpdb->prepare( "SELECT * FROM $table_name WHERE main_location = %d ORDER BY priority LIMIT 1", $main_location ),
                ARRAY_A
            );

            return $backup_location_result ?? [];
        }


        public static function parse_ns_shipping_methods( $ns_shipping_methods_api ) {
            $ns_shipping_methods = array();
            foreach ( $ns_shipping_methods_api ?? [] as $shipping_method ) {
                $ns_shipping_methods[$shipping_method['internalid']] = $shipping_method['name'];
            }
            ksort( $ns_shipping_methods );
            return $ns_shipping_methods;
        }

        public static function insert_or_update_ns_shipping_methods( $api_shipping_methods, $ns_shipping_methods_db ) {
            foreach ( $api_shipping_methods ?? [] as $api_shipping_method_id => $api_shipping_method_name ) {
                if ( array_key_exists( $api_shipping_method_id, $ns_shipping_methods_db ) ) {
                    if ( $api_shipping_method_name != $ns_shipping_methods_db[$api_shipping_method_id] ) {
                        self::update_ns_shipping_method_name( $api_shipping_method_id, $api_shipping_method_name );
                    }
                } else {
                    self::insert_ns_shipping_method( $api_shipping_method_id, $api_shipping_method_name );
                }
            }
        }

        public static function remove_redundant_ns_shipping_methods( $api_shipping_methods, $ns_shipping_methods_db ) {
            foreach ( $ns_shipping_methods_db as $ns_shipping_method_id => $ns_shipping_method_name ) {
                if ( !array_key_exists( $ns_shipping_method_id, $api_shipping_methods ) ) {
                    self::remove_ns_shipping_method( $ns_shipping_method_id );
                }
            }
        }

        public static function get_ns_shipping_methods_from_db() {
            global $wpdb;
            $table_name = self::$ns_shipping_methods_table_name;

            $ns_shipping_methods_result = $wpdb->get_results(
                "SELECT * FROM $table_name", ARRAY_A
            );

            $ns_shipping_methods = array();

            foreach ( $ns_shipping_methods_result ?? [] as $result ) {
                $ns_shipping_methods[$result['id']] = $result['name'];
            }

            return $ns_shipping_methods;
        }

        public static function update_ns_shipping_method_name( $ns_shipping_method_id, $ns_shipping_method_name ) {
            global $wpdb;
            $table_name = self::$ns_shipping_methods_table_name;

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET name = %s WHERE id = %d",
                $ns_shipping_method_name, $ns_shipping_method_id
            );
            $wpdb->query( $update_query );
        }

        public static function insert_ns_shipping_method( $ns_shipping_method_id, $ns_shipping_method_name ) {
            global $wpdb;
            $table_name = self::$ns_shipping_methods_table_name;

            $query_insert = $wpdb->prepare( "INSERT INTO $table_name 
                (`id`, `name`) 
                VALUES (%d, %s)",
                $ns_shipping_method_id, $ns_shipping_method_name
            );

            $wpdb->query( $query_insert );
        }

        public static function remove_ns_shipping_method( $ns_shipping_method_id )
        {
            global $wpdb;
            $table_name = self::$ns_shipping_methods_table_name;
            $wpdb->query( $wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $ns_shipping_method_id) );
        }

        public static function init_sync_inventory_data_from_azure() {
            if ( defined('SYNC_INVENTORY_DATA_FROM_AZURE') && SYNC_INVENTORY_DATA_FROM_AZURE ) {
                if ( ! wp_next_scheduled( 'sync_inventory_data_from_azure' ) ) {
                    $cron_time_ET = new DateTime('tomorrow 3AM', new DateTimeZone('America/New_York'));
                    wp_schedule_event( $cron_time_ET->getTimestamp(), 'daily', 'sync_inventory_data_from_azure' );
                }
            } else {
                if ( wp_next_scheduled( 'sync_inventory_data_from_azure' ) ) {
                    wp_clear_scheduled_hook( 'sync_inventory_data_from_azure' );
                }
            }
        }

        public static function cron_sync_inventory_data_from_azure()
        {
            self::sync_local_dropship_inventory_data_with_external_source();
        }

        public static function sync_local_dropship_inventory_data_with_external_source() {
            $log_file = Nsi_Helper::prepare_log_file('dropship-inventory-sync', 'dropship-inventory-logs');
            $datetime = date('Y-m-d H:i:s');
            $log_file_content = '[' . $datetime . '] Start fetching of dropship items inventory.' . PHP_EOL;
            $external_inventory_data = self::get_dropship_inventory_data_from_external_source();
            if ( $external_inventory_data === false ) {
                $log_file_content .= 'There was an error while connecting to MSSQL dropship inventory database. Check wc-logs for more information.' . PHP_EOL;
                file_put_contents( $log_file, $log_file_content . PHP_EOL, FILE_APPEND );
                return false;
            }

            $local_inventory_data = self::get_dropship_inventory_skus_from_db();

            self::insert_or_update_dropship_inventory( $external_inventory_data, $local_inventory_data, $log_file_content );
            self::remove_redundant_dropship_inventories( $external_inventory_data, $local_inventory_data, $log_file_content );
            file_put_contents( $log_file, $log_file_content . PHP_EOL, FILE_APPEND );
            return true;
        }

        public static function get_dropship_inventory_data_from_external_source() {
            $host = defined('MSSQL_EXTERNAL_INVENTORY_DATA_HOST') ? MSSQL_EXTERNAL_INVENTORY_DATA_HOST : 'host';;
            $schema = defined('MSSQL_EXTERNAL_INVENTORY_DATA_SCHEMA') ? MSSQL_EXTERNAL_INVENTORY_DATA_SCHEMA : 'db';
            $username = defined('MSSQL_EXTERNAL_INVENTORY_DATA_USER') ? MSSQL_EXTERNAL_INVENTORY_DATA_USER : 'user';
            $password = defined('MSSQL_EXTERNAL_INVENTORY_DATA_PASSWORD') ? MSSQL_EXTERNAL_INVENTORY_DATA_PASSWORD : 'password';
            $mode = defined('MSSQL_MODE') ? MSSQL_MODE : 'Linux';

            $prepared_query = 'SELECT * FROM woo.InventoryAvailable';
            try {
                $connector = MSSQLConnector::get_instance( $host, $username, $password, $schema, $mode );
                $connector->connect();
                $dropship_inventory_ext_result = $connector->query_execute( $prepared_query )  ?? array();
                $connector->close();

                $result = array();
                foreach ( $dropship_inventory_ext_result as $row ) {
                    $result[ $row['ProductID'] ] = [
                        'sku' => $row['ProductID'],
                        'location_name' => $row['PrimaryLocationName'],
                        'stock_quantity' => $row['AvailableQty']
                    ];
                }

                return $result;
            } catch( Exception $e ) {
                $logger = wc_get_logger();
                $logger->critical(
                    'Error while connecting to MSSQL dropship inventory database: ' . $e->getMessage(), array());

                return false;
            }
        }

        public static function get_dropship_inventory_skus_from_db() {
            global $wpdb;
            $table_name = self::$dropship_inventory_table_name;

            $dropship_inventory = $wpdb->get_results(
                "SELECT sku FROM $table_name", ARRAY_A
            );

            $result = array();
            foreach ( $dropship_inventory ?? [] as $row ) {
                $result[] = $row['sku'];
            }

            return $result;
        }

        public static function get_dropship_inventory_by_sku( $sku ) {
            global $wpdb;
            $table_name = self::$dropship_inventory_table_name;

            $dropship_inventory_result = $wpdb->get_row(
                $wpdb->prepare( "SELECT * FROM $table_name WHERE sku = %s", $sku ),
                ARRAY_A
            );

            return $dropship_inventory_result ?? [];
        }

        public static function insert_or_update_dropship_inventory( $api_dropship_skus, $nsi_db_dropship_skus, &$log_file_content ) {
            $count_updated = $count_inserted = 0;
            foreach ( $api_dropship_skus ?? [] as $api_dropship_sku => $api_dropship_sku_data ) {
                $location = $api_dropship_sku_data['location_name'];
                $qty = $api_dropship_sku_data['stock_quantity'];
                if ( in_array( $api_dropship_sku, $nsi_db_dropship_skus ) ) {
                    self::update_dropship_inventory( $api_dropship_sku, $location, $qty );
                    $count_updated ++;
                    if ( self::$dropship_inventory_extended_logs_enabled ) {
                        $log_file_content .= 'Item ' . $api_dropship_sku . ' UPDATED. Location: ' . $location . '. Inventory: ' . $qty . PHP_EOL;
                    }
                } else {
                    self::insert_dropship_inventory( $api_dropship_sku, $location, $qty );
                    $count_inserted ++;
                    if ( self::$dropship_inventory_extended_logs_enabled ) {
                        $log_file_content .= 'Item ' . $api_dropship_sku . ' ADDED. Location: ' . $location . '. Inventory: ' . $qty . PHP_EOL;
                    }
                }
            }
            $log_file_content .= $count_updated . ' dropship items updated. ' . $count_inserted . ' dropship items added. ' . PHP_EOL;
        }

        public static function remove_redundant_dropship_inventories( $api_dropship_skus, $nsi_db_dropship_skus, &$log_file_content ) {
            $count_removed = 0;
            foreach ( $nsi_db_dropship_skus as $nsi_db_dropship_sku ) {
                if ( !array_key_exists( $nsi_db_dropship_sku, $api_dropship_skus ) ) {
                    self::remove_dropship_inventory( $nsi_db_dropship_sku );
                    $count_removed ++;
                    if ( self::$dropship_inventory_extended_logs_enabled ) {
                        $log_file_content .= 'Item ' . $nsi_db_dropship_sku . ' REMOVED as it is not available in MSSQL dropship inventory database.' . PHP_EOL;
                    }
                }
            }
            $log_file_content .= $count_removed . ' dropship items removed. ' . PHP_EOL;
        }

        public static function update_dropship_inventory( $sku, $location, $qty ) {
            global $wpdb;
            $table_name = self::$dropship_inventory_table_name;

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET location_name = %s, stock_quantity = %d WHERE sku = %s",
                $location, $qty, $sku
            );
            $wpdb->query( $update_query );
        }

        public static function insert_dropship_inventory( $sku, $location, $qty ) {
            global $wpdb;
            $table_name = self::$dropship_inventory_table_name;

            $query_insert = $wpdb->prepare( "INSERT INTO $table_name 
                (`sku`, `location_name`, `stock_quantity`)
                VALUES (%s, %s, %d)",
                $sku, $location, $qty
            );

            $wpdb->query( $query_insert );
        }

        public static function remove_dropship_inventory( $sku ) {
            global $wpdb;
            $table_name = self::$dropship_inventory_table_name;
            $wpdb->query( $wpdb->prepare("DELETE FROM $table_name WHERE sku = %s", $sku) );
        }

        public static function log_disable_purchase_product_meta_change( $meta_id, $object_id, $meta_key, $_meta_value ) {
            if ( $meta_key == '_disable_purchase' ) {
                $log_content = 'Product ID ' . $object_id . ' - _disable_purchase updated. New Value: ' . $_meta_value . '.';
                if ( is_user_logged_in() && !wp_doing_cron() ) {
                    $user = wp_get_current_user();
                    $id = $user->ID;
                    $email = $user->user_email;
                    $log_content .= ' Change made by WP User ID ' . $id . ' (' . $email . ').';
                } else {
                    $log_content .= ' User not logged in (possibly cron change).';
                }

                $disable_purchase_log_files_limit = defined( 'ADDITIONAL_LOGS_DISABLE_PURCHASE_FILES_LIMIT' ) ? ADDITIONAL_LOGS_DISABLE_PURCHASE_FILES_LIMIT : 14;
                $log_file = Nsi_Helper::prepare_log_file('product-disable-purchase', 'extra-logs', '', $disable_purchase_log_files_limit);
                file_put_contents( $log_file, '[' . date('Y-m-d H:i:s') . '] ' . $log_content . PHP_EOL, FILE_APPEND );
            }
        }

    }
}