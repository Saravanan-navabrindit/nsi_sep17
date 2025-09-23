<?php

use Crown\Form\Field;
use Crown\Form\Input\Text as TextInput;
use Crown\ListTableColumn;
use Crown\UserSettings;
use Dompdf\Dompdf;
use Dompdf\Options;
use NetSuite\Classes\SearchMoreWithIdRequest;
use PhpOffice\PhpSpreadsheet\IOFactory;

use NetSuite\Classes\RecordRef;

use NetSuite\Classes\TransactionSearchAdvanced;
use NetSuite\NetSuiteService;
use NetSuite\Classes\Customer;
use NetSuite\Classes\UpdateRequest;
use NetSuite\Classes\AddRequest;
use NetSuite\Classes\SearchStringField;
use NetSuite\Classes\SearchMultiSelectField;
use NetSuite\Classes\TransactionSearchBasic;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\StringCustomFieldRef;
use NetSuite\Classes\CustomFieldList;
use NetSuite\Classes\MultiSelectCustomFieldRef;
use NetSuite\Classes\ListOrRecordRef;
use NetSuite\Classes\SelectCustomFieldRef;
use NetSuite\Classes\BooleanCustomFieldRef;
use NetSuite\Classes\UpdateResponse;
use NetSuite\Classes\DateCustomFieldRef;

enum Prev_Sku_State: int {
    case NONE = 0;
    case FETCHED = 1;
    case PROMOTION = 2;
    case ERRORED_OR_SKIPPED = 3;
}

if ( ! class_exists( 'Crown_Shop_Orders' ) ) {
	class Crown_Shop_Orders {

        const APPLY_THESE_RULES_HTML_BLOCK = "<p>To apply these rules after saving you need to go to the <a href='/wp-admin/admin.php?page=custom-shipping-settings&tab=change_min_amount_all_customer'><b>Apply changes to all customers tab</b></a>.</p>";
        const YOU_CAN_SEE_RESULTS_HTML_BLOCK = "<p>A function has been launched that changes the minimum price for each client based on the rules."
                                            . " Please wait a few minutes to get that done.</p>"
                                            . "<p>To check the results after applying rules you can go to the <a href='/wp-admin/users.php?role=customer'><b>Users admin section</b></a></p>";
        public static array $ns_order_sync_sku_errors_to_skip = [];
        public static bool $ns_order_sync_sku_errors_strict_match = false;
        public static $init = false;

        public static string $ns_orders_fetch_from_netsuite_search_id;
        public static int $order_max_rows_allowed = 200;
        public static string $ns_orders_fetch_from_netsuite_update_id;
        public static int $cron_fetch_ns_orders_updates_timeout = 300;
        public static int $cron_fetch_ns_pages_delay_time = 180;
        public static string $tm_ns_fetch_new_orders_table_name;
        public static string $tm_ns_fetch_orders_updates_table_name;
        public static string $tm_ns_fetch_invoices_table_name;
        public static string $ns_invoices_fetch_from_netsuite_search_id;
        public static int $ns_search_preferences_page_size = 150;
        public static int $ns_sync_max_pages_limit = 1;
        public static int $ns_sync_page_to_dispatch_bg_process = 3;
        protected static $ns_new_orders_import_bg_process = null;
        protected static $ns_orders_updates_import_bg_process = null;
        protected static $ns_invoices_import_bg_process = null;
        protected static $ns_display_order_documents_start_date = null;

        private static $skipped_sku_items = array();

		public static function init() {
			if( self::$init ) return;
			self::$init = true;

            global $wpdb;
            self::$tm_ns_fetch_new_orders_table_name = $wpdb->prefix . 'tm_ns_fetch_new_orders';
            self::$tm_ns_fetch_orders_updates_table_name = $wpdb->prefix . 'tm_ns_fetch_orders_updates';
            self::$tm_ns_fetch_invoices_table_name = $wpdb->prefix . 'tm_ns_fetch_invoices';

            if ( defined( 'NS_ORDERS_FETCH_FROM_NETSUITE_SEARCH_ID' ) ) {
                self::$ns_orders_fetch_from_netsuite_search_id = NS_ORDERS_FETCH_FROM_NETSUITE_SEARCH_ID;
            }
            if ( defined( 'NS_ORDER_SYNC_SKU_ERRORS' ) ) {
                self::$ns_order_sync_sku_errors_to_skip = NS_ORDER_SYNC_SKU_ERRORS;
            }
            if ( defined( 'NS_ORDER_SYNC_SKU_ERRORS_STRICT_MATCH' ) ) {
                self::$ns_order_sync_sku_errors_strict_match = NS_ORDER_SYNC_SKU_ERRORS_STRICT_MATCH;
            }
            if ( defined( 'NS_ORDERS_FETCH_FROM_NETSUITE_UPDATE_ID' ) ) {
                self::$ns_orders_fetch_from_netsuite_update_id = NS_ORDERS_FETCH_FROM_NETSUITE_UPDATE_ID;
            }
            if ( defined( 'CRON_FETCH_NS_ORDERS_UPDATES_TIMEOUT' ) ) {
                self::$cron_fetch_ns_orders_updates_timeout = CRON_FETCH_NS_ORDERS_UPDATES_TIMEOUT;
            }
            if ( defined( 'CRON_FETCH_NS_PAGES_DELAY_TIME' ) ) {
                self::$cron_fetch_ns_pages_delay_time = CRON_FETCH_NS_PAGES_DELAY_TIME;
            }
            if ( defined( 'NS_INVOICES_FETCH_FROM_NETSUITE_SEARCH_ID' ) ) {
                self::$ns_invoices_fetch_from_netsuite_search_id = NS_INVOICES_FETCH_FROM_NETSUITE_SEARCH_ID;
            }
            if ( defined('NS_DISPLAY_ORDER_DOCUMENTS_START_DATE') ) {
                self::$ns_display_order_documents_start_date = new DateTime( NS_DISPLAY_ORDER_DOCUMENTS_START_DATE );
            }
            if ( defined( 'NS_SEARCH_PREFERENCES_PAGE_SIZE' ) ) {
                self::$ns_search_preferences_page_size = NS_SEARCH_PREFERENCES_PAGE_SIZE;
            }
            if ( defined( 'NS_SYNC_MAX_PAGES_LIMIT' ) ) {
                self::$ns_sync_max_pages_limit = NS_SYNC_MAX_PAGES_LIMIT;
            }
            if ( defined( 'NS_SYNC_PAGE_TO_DISPATCH_BG_PROCESS' ) ) {
                self::$ns_sync_page_to_dispatch_bg_process = NS_SYNC_PAGE_TO_DISPATCH_BG_PROCESS;
            }
            if ( defined('ORDER_MAX_ROWS_ALLOWED') ) {
                self::$order_max_rows_allowed = ORDER_MAX_ROWS_ALLOWED;
            }

			add_action( 'admin_menu', array( __CLASS__, 'custom_wocommerce_settings_pages' ) );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ));
			add_filter( 'woocommerce_shop_order_search_fields', array( __CLASS__, 'filter_woocommerce_shop_order_search_fields' ), 10, 1 );
			add_filter( 'woocommerce_add_to_cart_validation', array( __CLASS__, 'limit_cart_items_count' ), 10, 2 );
			add_filter( 'woocommerce_ajax_add_order_item_validation', array( __CLASS__, 'limit_order_items_count' ), 10, 4 );

			add_filter( 'manage_edit-shop_order_columns', array( __CLASS__, 'remove_order_columns' ), 20 );
			// add_filter( 'tm_add_request_order_data', array( __CLASS__, 'filter_tm_add_request_order_data' ), 10, 2 );
			add_filter( 'tm_add_request_order_data', array( __CLASS__, 'add_request_order_data' ), 10, 2 );
			add_filter( 'tm_ns_order_item', array( __CLASS__, 'add_request_order_item_data' ), 10, 4 );
			add_filter( 'woocommerce_shipping_instance_form_fields_flat_rate', array( __CLASS__, 'filter_shipping_instance_form_fields_flat_rate' ), 10, 1 );
            add_filter( 'woocommerce_form_field_email', array( __CLASS__, 'filter_checkout_email_address' ), 10, 4 );

			add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_box' ) );
			add_action( 'tm_netsuite_after_order_update', array( __CLASS__, 'sync_order_ns_sales_order_data' ), 10, 3 );
			add_action( 'tm_netsuite_after_order_add', array( __CLASS__, 'sync_order_ns_sales_order_data' ), 10, 3 );
			add_filter( 'woocommerce_order_number', array( __CLASS__, 'filter_woocommerce_order_number' ), 10, 2 );
			add_filter( 'woocommerce_admin_order_buyer_name', array( __CLASS__, 'filter_woocommerce_admin_order_buyer_name' ), 10, 2 );
            add_action( 'woocommerce_checkout_update_customer', array( __CLASS__, 'prevent_address_update_to_db_from_checkout_form'), 10 , 2 );
            add_filter( 'woocommerce_order_data_store_cpt_get_orders_query', array( __CLASS__, 'handle_custom_query_var'), 10, 2 );
			add_action( 'pre_get_posts', array( __CLASS__, 'filter_admin_order_query' ), 10, 1 );
			add_action( 'woocommerce_checkout_order_created', array( __CLASS__, 'add_dual_shop_manager_order_metadata' ) );
			add_action( 'addify_rfq_quote_converted_to_order', array( __CLASS__, 'add_dual_shop_manager_quote_metadata' ), 10, 2 );
			add_filter( 'woocommerce_package_rates', array( __CLASS__, 'filter_woocommerce_package_rates' ), 10, 2 );

            self::setup_database_tables();
            self::init_crons();
            self::add_cron_actions();
            self::init_bg_process_vars();

			add_action( 'init', array( __CLASS__, 'register_new_order_statuses' ) );
            add_action( 'woocommerce_before_order_details', array( __CLASS__, 'display_order_documents' ) );
            add_action( 'wp_ajax_get_order_pdf_document', array( __CLASS__, 'get_order_pdf_document' ) );
            add_action( 'woocommerce_admin_order_data_after_order_details', array( __CLASS__, 'display_customer_data' ) );

			add_filter( 'wc_order_statuses', array( __CLASS__, 'filter_wc_order_statuses' ), 10, 1 );
            add_filter( 'tm_netsuite_order_sync_status', array( __CLASS__, 'add_order_sync_in_progress' ), 10, 2 );

			add_filter( 'woocommerce_email_headers', array( __CLASS__, 'filter_wc_email_headers' ), 10, 4 );
			add_filter( 'pre_wp_mail', array( __CLASS__, 'filter_pre_wp_mail' ), 10, 2 );

			add_filter( 'woocommerce_structured_data_product_offer', array( __CLASS__, 'filter_wc_remove_price_offer_from_markup' ), 10 , 1);

			add_action( 'admin_init', array( __CLASS__, 'custom_shipping_settings_init' ) );
			add_action( 'admin_init', array( __CLASS__, 'custom_order_settings_init' ) );
            add_action( 'wp_ajax_cart_data_import', array( __CLASS__, 'cart_data_import' ) );
			add_action( 'wp_ajax_search_customers', array( __CLASS__, 'search_customers_callback' ) );

			add_action( 'show_user_profile',  array( __CLASS__, 'add_custom_user_profile_fields' ) );
			add_action( 'edit_user_profile',  array( __CLASS__, 'add_custom_user_profile_fields' ) );

			add_action( 'rest_api_init', array( __CLASS__, 'register_rest_api_apply_changes_to_all_customers' ), 20);

            add_action( 'woocommerce_admin_order_item_headers', array( __CLASS__, 'admin_order_add_shipped_qty_column_header' ) );
            add_action( 'woocommerce_admin_order_item_values', array( __CLASS__, 'admin_order_add_shipped_qty_column_content' ), 10, 3 );

            add_filter('woocommerce_email_classes', array( __CLASS__, 'disable_ns_imported_orders_mailing'), 1000);

            add_action('woocommerce_checkout_create_order', function ($order, $data) {
                if (!empty($data['po_number'])) {
                    Crown_Shop_Rfq::validate_po_number($order->get_customer_id(), $data['po_number']);
                }
            }, 10, 2);

            add_action( 'admin_footer', array(__CLASS__, 'disable_ns_sourced_order_fields_editing') );

            if ( class_exists( 'WP_CLI' ) ) {
				WP_CLI::add_command( 'order sync all', function( $args ) {
					$status = count( $args ) >= 1 ? $args[0] : '';
					$page = count( $args ) >= 2 ? $args[1] : 1;
					$date = count( $args ) >= 3 ? $args[2] : '';

                    if ( !empty($date) ) {
                        $date = date( DATE_ATOM, strtotime($date) );
                    }

					if ( count( $args ) == 1 && intval( $status ) != 0 ) {
						$page = $status;
						$status = '';
					}
					self::sync_order_statuses( array(
						'page' => $page,
						'status' => $status ? array( $status ) : array( 'on-hold', 'processing', 'partially-fulfill', 'pending-billing', 'pending-approval', 'pending-fulfill' ),
                        'search_date' => $date
					) );
				} );

                /**
                 * WP_CLI order type update allows to update orders type.
                 *
                 * Usage:
                 * wp order type update products --orders=ID1,ID2 --type=woocommerce_order
                 */
                WP_CLI::add_command( 'order type update', function( $args, $assoc_args ) {
                    $order_ids = isset( $assoc_args['orders'] ) ? array_map('trim', explode(',', $assoc_args['orders'])) : array();
                    $order_type = $assoc_args['type'] ?? '';

                    if( empty( $order_ids ) || empty( $order_type ) ) {
                        WP_CLI::log( 'Order IDs and order type have to be provided!' );
                        return;
                    }
                    $order_types = Crown_Order_Types::get_available_order_types('ns_custom_value');
                    if ( ! isset( $order_types[$order_type] ) ) {
                        WP_CLI::log( 'Order type ' . $order_type . ' is not available.' );
                        return;
                    }

                    WP_CLI::log( 'Processing order types updates...' );
                    $skipped = 0;
                    $wc_order_ids = $ns_order_ids = array();
                    foreach ( $order_ids as $order_id ) {
                        if ( strpos( $order_id, "SO" ) === 0 ) {
                            $ns_order_ids[] = $order_id;
                        } else {
                            $wc_order_ids[] = $order_id;
                        }
                    }
                    if ( ! empty( $ns_order_ids ) ) {
                        global $wpdb;

                        $placeholders = implode(',', array_fill(0, count( $ns_order_ids ), '%s'));

                        $results = $wpdb->get_results( $wpdb->prepare("
                            SELECT post_id, meta_value 
                            FROM {$wpdb->postmeta} 
                            WHERE meta_key = 'ns_order_tran_id' 
                            AND meta_value IN ( $placeholders )
                            ", ...$ns_order_ids ), ARRAY_A );

                        $ns_to_wc_ids = array_column($results, 'post_id', 'meta_value');
                        foreach ( $ns_order_ids as $ns_order_id ) {
                            if ( ! isset( $ns_to_wc_ids[$ns_order_id] ) ) {
                                WP_CLI::log( 'Order ' . $ns_order_id . ' is not available. Skipped.' );
                                $skipped++;
                                continue;
                            }
                            if ( ! in_array( $ns_to_wc_ids[$ns_order_id], $wc_order_ids ) ) {
                                $wc_order_ids[] = $ns_to_wc_ids[$ns_order_id];
                            }
                        }
                    }
                    foreach ( $wc_order_ids as $order_id ) {
                        if ( ! wc_get_order( $order_id ) ) {
                            WP_CLI::log( 'Order ' . $order_id . ' is not available. Skipped.' );
                            $skipped++;
                        }
                        Crown_Order_Types::set_order_type($order_id, $order_types[$order_type]->id, $order_types[$order_type]->order_type);
                    }

                    WP_CLI::log( 'Finished processing order types change. ' . count( $order_ids ) - $skipped . ' processed, ' . $skipped . ' skipped.' );
                } );
			}

			add_action( 'cs_sync_orders', function( $order_ids, $search_date = '' ) {
				require_once TMWNI_DIR . 'inc/orderTracking.php';
				$netsuiteOrderTrackingClient = new OrdertrackingClient();
				$netsuiteOrderTrackingClient->syncOrders( $order_ids, $search_date );
			} );

		}

        public static function admin_order_add_shipped_qty_column_header() {
            echo '<th class="header-shipped-qty sortable" data-sort="int">Shipped Qty</th>';
        }

        /**
         * @param $product WC_Product
         * @param $item WC_Order_Item_Product
         * @param $item_id
         * @return void
         */
        public static function admin_order_add_shipped_qty_column_content( $product, $item, $item_id ) {
            if ( !isset($product) ) {
                echo '<td class="value-shipped-qty">&nbsp;</td>';
                return;
            }

            $order_id = $item->get_order_id();
            $shipping_data = get_post_meta( $order_id, 'shipping_data', true );
            if ( !$shipping_data ) {
                echo '<td class="value-shipped-qty" data-sort-value="0"><small class="times">×</small>0</td>';
            }

            if ( $shipping_data ) {
                $shipping_data = json_decode( $shipping_data, true );
                $quantity = $shipping_data[$product->get_sku()]['quantity_billed'] ?? 0;
                echo '<td class="value-shipped-qty" data-sort-value="' . $quantity . '"><small class="times">×</small>' . $quantity . '</td>' ;
            }
        }

        public static function disable_ns_imported_orders_mailing($email_classes) {
            foreach ( $email_classes as $email_class ) {
                if ( $email_class instanceof \WC_Email ) {
                    add_filter("woocommerce_email_recipient_{$email_class->id}",array( __CLASS__, 'filter_woocommerce_email_recipient'), 10, 3);
                }
            }
            return $email_classes;
        }


        public static function setup_database_tables() {
            add_action( 'init', array( __CLASS__, 'setup_tm_ns_fetch_new_orders_table' ), 10 );
            add_action( 'init', array( __CLASS__, 'setup_tm_ns_fetch_orders_updates_table' ), 10 );
            add_action( 'init', array( __CLASS__, 'setup_tm_ns_fetch_invoices_table' ), 10 );
        }

        public static function init_crons() {
            add_action( 'init', array( __CLASS__, 'init_ns_to_woo_orders_sync' ) );
            add_action( 'init', array( __CLASS__, 'init_ns_to_woo_orders_update' ) );
            add_action( 'init', array( __CLASS__, 'init_ns_invoices_fetch' ) );
        }

        public static function add_cron_actions() {
            add_action( 'tm_ns_fetch_new_orders_created', array( __CLASS__, 'cron_fetch_new_orders_created' ), 10, 2 );
            add_action( 'tm_ns_fetch_orders_updates_action', array( __CLASS__, 'cron_fetch_orders_updates' ), 10, 2 );
            add_action( 'tm_ns_invoices_fetch', array( __CLASS__, 'cron_tm_ns_invoices_fetch' ), 10, 2 );
        }

        public static function init_bg_process_vars() {
            add_action( 'woocommerce_loaded', array( __CLASS__, 'init_ns_new_orders_import_bg_process' ), 1000 );
            add_action( 'woocommerce_loaded', array( __CLASS__, 'init_ns_fetch_orders_updates_bg_process' ), 1000 );
            add_action( 'woocommerce_loaded', array( __CLASS__, 'init_ns_fetch_invoices_bg_process' ), 1000 );
        }

        public static function setup_tm_ns_fetch_new_orders_table() {
            if( !get_option( 'tm_ns_fetch_new_orders_table_created' ) ) {
                self::create_tm_ns_fetch_new_orders_table();
                update_option( 'tm_ns_fetch_new_orders_table_created', true );
            }
        }

        public static function setup_tm_ns_fetch_orders_updates_table() {
            if( !get_option( 'tm_ns_fetch_orders_updates_table_created' ) ) {
                self::create_tm_ns_fetch_orders_updates_table();
                update_option( 'tm_ns_fetch_orders_updates_table_created', true );
            }
        }

        public static function setup_tm_ns_fetch_invoices_table() {
            if( !get_option( 'tm_ns_fetch_invoices_table_created' ) ) {
                self::create_tm_ns_fetch_invoices_table();
                update_option( 'tm_ns_fetch_invoices_table_created', true );
            }
        }

        public static function init_ns_to_woo_orders_sync() {
            $args = array( 1, '' );
            if (defined('NS_ORDERS_FETCH_FROM_NETSUITE_ENABLED') && NS_ORDERS_FETCH_FROM_NETSUITE_ENABLED) {
                if ( ! as_next_scheduled_action( 'tm_ns_fetch_new_orders_created', $args ) ) {
                    as_schedule_recurring_action( time(), MINUTE_IN_SECONDS * 30, 'tm_ns_fetch_new_orders_created', $args );
                }
            } else {
                if ( as_next_scheduled_action( 'tm_ns_fetch_new_orders_created', $args ) ) {
                    as_unschedule_all_actions( 'tm_ns_fetch_new_orders_created', $args );
                }
            }
        }

        public static function init_ns_to_woo_orders_update() {
            $args = array( 1, '' );
            if ( defined('NS_ORDERS_UPDATE_FETCH_FROM_NETSUITE_ENABLED') && NS_ORDERS_UPDATE_FETCH_FROM_NETSUITE_ENABLED ) {
                if ( ! as_next_scheduled_action( 'tm_ns_fetch_orders_updates_action', $args ) ) {
                    as_schedule_recurring_action( time(), MINUTE_IN_SECONDS * 30, 'tm_ns_fetch_orders_updates_action', $args );
                }
            } else {
                if ( as_next_scheduled_action( 'tm_ns_fetch_orders_updates_action', $args ) ) {
                    as_unschedule_all_actions( 'tm_ns_fetch_orders_updates_action', $args );
                }
            }
        }

        public static function init_ns_invoices_fetch() {
            $args = array( 1, '' );
            if ( defined('NS_INVOICES_FETCH_ENABLED') && NS_INVOICES_FETCH_ENABLED ) {
                if ( ! as_next_scheduled_action( 'tm_ns_invoices_fetch', $args ) ) {
                    as_schedule_recurring_action( time(), MINUTE_IN_SECONDS * 30, 'tm_ns_invoices_fetch', $args );
                }
            } else {
                if ( as_next_scheduled_action( 'tm_ns_invoices_fetch', $args ) ) {
                    as_unschedule_all_actions( 'tm_ns_invoices_fetch', $args );
                }
            }
        }

        public static function filter_checkout_email_address($field, $key, $args, $value) {
            if ( defined('DISABLE_AUTOMATIC_CUSTOMER_EMAIL_POPULATION') && DISABLE_AUTOMATIC_CUSTOMER_EMAIL_POPULATION ) {
                $field = str_replace($value, '', $field);
            }

            return $field;
        }


		public static function sync_order_statuses( $args = array() ) {
			$args = array_merge( array(
				'count' => 500,
				'page' => 1,
				'order' => 'DESC',
				'status' => array( 'on-hold', 'processing', 'partially-fulfill', 'pending-billing', 'pending-approval', 'pending-fulfill' )
			), $args );
            $search_date = $args['search_date'] ?? '';

			if ( function_exists( 'as_enqueue_async_action' ) ) {
				as_unschedule_all_actions( 'cs_sync_orders' );
				$args = array(
					'status' => $args['status'],
					'limit' => 100,
					'order' => $args['order'],
					'paged' => intval( $args['page'] ),
					'meta_key'     => 'ns_order_internal_id', // The postmeta key field
					'meta_compare' => 'EXISTS',
					'return' => 'ids'
				);
				$order_ids = wc_get_orders( $args );
				while ( ! empty( $order_ids ) ) {
					if ( class_exists( 'WP_CLI' ) ) WP_CLI::log( 'Queueing up ' . count( $order_ids ) . ' orders' );
					as_enqueue_async_action( 'cs_sync_orders', array( 'order_ids' => $order_ids, 'search_date' => $search_date ) );
					$args['paged'] += 1;
					$order_ids = wc_get_orders( $args );
				}
			} else {
				require_once TMWNI_DIR . 'inc/orderTracking.php';
				$netsuiteOrderTrackingClient = new OrdertrackingClient();
                if ( class_exists( 'WP_CLI' ) ) WP_CLI::log( '==== Syncing page ' . $args['page'] . ' ============' );
				$order_count = $netsuiteOrderTrackingClient->getProcessingOrders( $args, $search_date );
				while ( $order_count != 0 ) {
                    $args['page']++;
                    if ( class_exists( 'WP_CLI' ) ) WP_CLI::log( '==== Syncing page ' . $args['page'] . ' ============' );
					$order_count = $netsuiteOrderTrackingClient->getProcessingOrders( $args, $search_date );
				}
			}
		}


		public static function filter_woocommerce_shop_order_search_fields( $fields ) {
			$fields = array_merge( $fields, array(
				'ns_order_tran_id',
				'_billing_company',
				'af_c_f_47165', // po number (test)
				'af_c_f_4432739' // po number (prod)
			) );
			return $fields;
		}

		public static function attach_pdf_to_email($attachments, $email_id, $order, $email) {
            $content = $email->get_content();
            $styled_content = $email->style_inline( $content );

    		$dompdf = new Dompdf();
			$dompdf->loadHtml($styled_content);
			$dompdf->render();

			$pdf_file_path = sys_get_temp_dir() . '/order_' . $order->get_id() . '.pdf';
			file_put_contents($pdf_file_path, $dompdf->output());

			$attachments[] = $pdf_file_path;

			return $attachments;
		}

		public static function filter_tm_add_request_order_data( $so, $order_id ) {
			
			$so->location = new RecordRef();
			$so->location->internalId = 15;

			return $so;
		}

		public static function add_request_order_data( $so, $order_id ) {
            $order = wc_get_order( $order_id );

            $user_id = $order->get_user_id();
            if ( $user_id ) {
                if ( defined( 'NS_DIVISION_PUSH' ) && NS_DIVISION_PUSH === true) {
                    $so->custbody_ns_division = new RecordRef();
                    $so->custbody_ns_division->internalId = get_user_meta( $user_id, 'ns_division_id', true );
                }
                if ( defined( 'NS_TRANS_FREIGHT_LEVEL_PUSH' ) && NS_TRANS_FREIGHT_LEVEL_PUSH === true) {
                    $so->custbody_trans_freight_level = new RecordRef();
                    $so->custbody_trans_freight_level->internalId = get_user_meta( $user_id, 'ns_trans_freight_level_id', true );
                }
            }

			return $so;
		}

		public static function add_request_order_item_data( $items, $order_data_items, $shipping, $order_id ) {
			if ( defined( 'NS_DIVISION_PUSH' ) && NS_DIVISION_PUSH === true) {
				$order = wc_get_order( $order_id );

				$user_id = $order->get_user_id();
				if ( $user_id ) {
					foreach ( $items as &$item ) {
						$item->custcol_ns_division = new RecordRef();
						$item->custcol_ns_division->internalId = get_user_meta( $user_id, 'ns_division_id', true );
					}
				}
            }

			return $items;
		}

		public static function display_customer_data ( $order ) {
			if ( ! $order instanceof WC_Order || ! $order->get_id() ) {
				return;
			}

			$division_name = get_user_meta( $order->get_user_id(), 'ns_division_name', true );
			if ( $division_name ) {
				?>
				<p class="form-field form-field-wide">
				<?php esc_html_e( "Division: ", 'woocommerce' );	?>
					<span class="order_data_column_wc-customer-division__color">
						<?php esc_html_e( "$division_name", 'woocommerce' ); ?>
					</span>
				</p>
				<?php
			}
            $trans_freight_level_name = get_user_meta( $order->get_user_id(), 'ns_trans_freight_level_name', true );
			if ( $trans_freight_level_name ) {
				?>
				<p class="form-field form-field-wide">
				<?php esc_html_e( "Freight Level: ", 'woocommerce' );	?>
					<span class="order_data_column_wc-customer-trans-freight-level">
						<?php esc_html_e( "$trans_freight_level_name", 'woocommerce' ); ?>
					</span>
				</p>
				<?php
			}

            if ( ! self::allowed_order_documents_display( $order ) ) {
                return;
            }

            $order_id = $order->get_id();
            $invoice_tran_ids = self::get_invoice_tran_ids($order_id);
            ?>
            <div class="order_data_column" style="width: 100%;">
                <h3><?php esc_html_e( 'Order documents', 'woocommerce' ); ?></h3>
                <table style="width: 100%;">
                    <tbody>
                    <tr style="border-color: rgb(128, 128, 128);">
                        <td style="width: 33%;"><?php esc_html_e( 'Order acknowledgement', 'woocommerce' ); ?></td>
                        <td><button type="button" data-order-id="<?php echo $order_id;?>" class="button grant_access  order-acknowledgement"><?php esc_html_e( 'View document', 'woocommerce' ); ?></button></td>
                    </tr>
                    <?php foreach ($invoice_tran_ids as $invoice_tran_id) { ?>
                        <tr style="border-color: rgb(128, 128, 128);">
                            <td><?php esc_html_e( 'Invoice ' . $invoice_tran_id, 'woocommerce' ); ?></td>
                            <td><button type="button" data-order-id="<?php echo $order_id;?>" data-invoice-tran-id="<?php echo $invoice_tran_id;?>" class="button grant_access order-invoice"><?php esc_html_e( 'View document', 'woocommerce' ); ?></button></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php }


		public static function display_order_documents ( $order ) {
			if ( ! $order instanceof WC_Order || ! $order->get_id() ) {
				return;
			}
            if ( ! self::allowed_order_documents_display( $order ) ) {
                return;
            }

            $order_id = $order->get_id();
            $invoice_tran_ids = self::get_invoice_tran_ids($order_id);
            ?>
            <section class="woocommerce-order-details woocommerce-order-documents">
                <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order documents', 'woocommerce' ); ?></h2>
                <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                    <tbody>
                    <tr class="woocommerce-table__line-item order_item">
                        <td class="woocommerce-table__product-name product-name">
                            <span><?php esc_html_e( 'Order acknowledgement', 'woocommerce' ); ?></span>
                        </td>
                        <td class="woocommerce-table__product-total product-total">
                            <button type="submit" class="btn btn-primary order-acknowledgement" data-order-id="<?php echo $order_id;?>"><?php esc_html_e( 'View document', 'woocommerce' ); ?></button>
                        </td>
                    </tr>
                    <?php foreach ($invoice_tran_ids as $invoice_tran_id) { ?>
                        <tr class="woocommerce-table__line-item order_item">
                            <td class="woocommerce-table__product-name product-name">
                                <span><?php esc_html_e( 'Invoice ' . $invoice_tran_id, 'woocommerce' ); ?></span>
                            </td>
                            <td class="woocommerce-table__product-total product-total">
                                <button type="submit" class="btn btn-primary order-invoice" data-order-id="<?php echo $order_id;?>" data-invoice-tran-id="<?php echo $invoice_tran_id;?>"><?php esc_html_e( 'View document', 'woocommerce' ); ?></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </section>
        <?php }

        public static function allowed_order_documents_display( $order ) {
            $order_id = $order->get_id();
            $order_date = DateTime::createFromFormat('d.m.Y', get_the_date('d.m.Y', $order_id) );
            if ( empty( self::$ns_display_order_documents_start_date ) || $order_date < self::$ns_display_order_documents_start_date || $order->get_status() === 'on-hold' ) {
                return false;
            }

            $division_name = '';
            $user_id = $order->get_user_id();
            if ( $user_id ) {
                $division_name = get_user_meta( $user_id, 'ns_division_name', true );
            }
            if ( empty( $division_name ) || $division_name === 'HVAC') {
                return false;
            }
            return true;
        }

		public static function filter_shipping_instance_form_fields_flat_rate( $fields ) {
			$fields['title_override'] = array(
				'title'       => 'Title Override',
				'type'        => 'text',
				'description' => '',
				'default'     => '',
				'desc_tip'    => false,
			);
			return $fields;
		}


		public static function get_ns_sales_order_record( $ns_sales_order_id ) {

			if ( ! class_exists( 'TMWNI_Settings' ) || ! TMWNI_Settings::areCredentialsDefined() ) return null;

			$netsuite_service = new NetSuiteService( null, array( 'exceptions' => true ) );
			$netsuite_service->setSearchPreferences(false, 20);
	
			$search_field = new SearchMultiSelectField();
			$search_field->operator = 'anyOf';
			$search_field->searchValue = array( 'internalId' => $ns_sales_order_id );
			$search = new TransactionSearchBasic();
			$search->internalId = $search_field;

			$request = new SearchRequest();
			$request->searchRecord = $search;

			try {
				$search_response = $netsuite_service->search( $request );
				if ( $search_response->searchResult->status->isSuccess ) {
					if ( 0 != $search_response->searchResult->totalRecords ) {
						return $search_response->searchResult->recordList->record[0];
					}
				}
			} catch ( SoapFault $e ) {
				
			}

		}

        /**
         * Creates the tm_ns_fetch_new_orders table in the WordPress database.
         *
         * This function creates a table named 'tm_ns_fetch_new_orders' if it doesn't already exist.
         * The table has the following columns:
         * - id: mediumint(9) NOT NULL AUTO_INCREMENT
         * - ns_order_id: VARCHAR(255) NOT NULL
         * - ns_order_data: VARCHAR(255) NOT NULL
         * - fetch_date: DATETIME NOT NULL
         *
         * @global wpdb $wpdb The WordPress database object.
         */
        public static function create_tm_ns_fetch_new_orders_table(){
            global $wpdb;
            $table_name = self::$tm_ns_fetch_new_orders_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				ns_order_id VARCHAR(255) NOT NULL,
				ns_order_data LONGTEXT NOT NULL,
				fetch_date DATETIME NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_tm_ns_fetch_orders_updates_table() {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_orders_updates_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				ns_order_id VARCHAR(50) NOT NULL,
				item_sku VARCHAR(100) NULL,
				ns_order_data LONGTEXT NOT NULL,
				fetch_date DATETIME NOT NULL,
				PRIMARY KEY (id),
                UNIQUE KEY unique_order_sku (`ns_order_id`, `item_sku`)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function create_tm_ns_fetch_invoices_table() {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_invoices_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				ns_invoice_id VARCHAR(255) NOT NULL,
				ns_invoice_data LONGTEXT NOT NULL,
				fetch_date DATETIME NOT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function init_ns_new_orders_import_bg_process() {
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                include( dirname( __FILE__ ) . '/class-ns-new-orders-import.php' );
                self::$ns_new_orders_import_bg_process = new NS_new_orders_import();
            }
        }

        public static function init_ns_fetch_orders_updates_bg_process() {
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                include( dirname( __FILE__ ) . '/class-ns-orders-updates-import.php' );
                self::$ns_orders_updates_import_bg_process = new NS_orders_updates_import();
            }
        }

        public static function init_ns_fetch_invoices_bg_process() {
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                include( dirname( __FILE__ ) . '/class-ns-invoices-import.php' );
                self::$ns_invoices_import_bg_process = new NS_invoices_import();
            }
        }

        public static function create_ns_sync_log_file( $log_file_name, $sub_folder ) {
            $files_limit = defined( 'NS_SYNC_STORED_LOG_FILES_LIMIT' ) ? NS_SYNC_STORED_LOG_FILES_LIMIT : 20;
            $file_dir 		= wp_upload_dir();
            $folder_name 	= 'netsuite-sync-logs/' . $sub_folder;
            $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
            $file_name 		= $folder_path . '/' . $log_file_name;

            if ( !file_exists($folder_path)) {
                mkdir( $folder_path, 0755, true );
            }

            if ( !file_exists($file_name)){
                $log_file = fopen($file_name, 'w');
                chmod($file_name, 0664);
                fclose($log_file);
            }

            $files = scandir($folder_path);
            $files = array_filter($files, function($file) use ($folder_path) {
                return is_file($folder_path . '/' . $file);
            });

            usort($files, function($a, $b) use ($folder_path) {
                return filemtime($folder_path . '/' . $a) > filemtime($folder_path . '/' . $b);
            });

            while (count($files) > $files_limit) {
                unlink($folder_path . '/' . $files[0]);
                array_shift($files);
            }

            return $file_name;
        }

        public static function cron_fetch_new_orders_created( $page = 1, $search_id = '' ) {
            $search_type = 'new';
            $hook = 'tm_ns_fetch_new_orders_created';
            $transient_key = 'cron_fetch_ns_new_orders';
            if ( $page == 1 ) {
                if ( get_transient( $transient_key ) ) {
                    return;
                }
                update_option( 'ns_sync_max_pages_limit_' . $search_type, 1, false );
            }
            set_transient( $transient_key, true, self::$cron_fetch_ns_orders_updates_timeout );
            $date 	        = date( "Y-m-d" );
            $datetime = date( "Y-m-d H:i:s" );
            $file_name = self::create_ns_sync_log_file( 'fetch-orders-' . $date . '.log', 'fetch-orders' );
            file_put_contents( $file_name, '[' . $datetime . '] Start fetch of NS Orders ( page ' . $page . ' )' . PHP_EOL, FILE_APPEND );
            $log_file_content = '';
            $order_items_to_sync = array();
            if ( $page == 1 ) {
                $order_items_to_sync = self::get_items_records_from_ns( $log_file_content, $hook, $search_type );
            } elseif ( $page > 1 && ! empty( $search_id ) ) {
                $order_items_to_sync = self::get_paged_items_records_from_ns( $search_type, $hook, $search_id, $page, $log_file_content );
            }
            if ( !empty( $order_items_to_sync ) ) {
                $fetched_orders_data = $fetched_orders_data_ids = $discount_orders = $skipped_order_ids = $fetching_order_ids = array();
                $placeholders = $errors = array();
                $prev_sku_state = Prev_Sku_State::NONE;
                foreach ( $order_items_to_sync as $order_item ) {
                    $ns_order_id = $order_item['basic']['internalId'][0]->searchValue->internalId;
                    if ( empty( $ns_order_id )  || ! empty( self::get_tm_ns_fetched_order_item( $ns_order_id ) ) ) continue;

                    if ( !in_array($ns_order_id, $fetching_order_ids) ) {
                        $log_file_content .= 'Started fetching NS Order ID: ' . $ns_order_id . PHP_EOL;
                        $fetching_order_ids[] = $ns_order_id;
                    }

                    $item_sku = $order_item['item_join']['itemId'][0]->searchValue ?? '';
                    $amount = $order_item['basic']['amount'][0]->searchValue ?? 0;
                    $item_sku_low_str = strtolower($item_sku);
                    $is_errored_sku_skipped = !($prev_sku_state == Prev_Sku_State::FETCHED && str_contains($item_sku_low_str, 'promotion')) && self::is_errored_sku_skipped($item_sku);
                    if ( $amount >= 0
                        && ( empty( $item_sku ) || ( !$is_errored_sku_skipped && ! wc_get_product_id_by_sku( $item_sku )))
                    ) {
                        $sku_not_found_message = 'SKU item "' . $item_sku . '" not found.';
                        if ( ! in_array($ns_order_id, $skipped_order_ids) ) {
                            $log_file_content .= 'Skipped NS Order ID: ' . $ns_order_id . '. Items missing:' . PHP_EOL;
                            $skipped_order_ids[] = $ns_order_id;
                        }
                        $log_file_content .= $sku_not_found_message . PHP_EOL;
                        $errors[$ns_order_id][] = $sku_not_found_message;
                        $prev_sku_state = Prev_Sku_State::ERRORED_OR_SKIPPED;
                        continue;
                    }
                    if ( $is_errored_sku_skipped ) {
                        $log_file_content .= 'NS Order ID: '. $ns_order_id . ' | SKU fetching is skipped due to matching accepted error code: ' . $item_sku . PHP_EOL;
                        $prev_sku_state = Prev_Sku_State::ERRORED_OR_SKIPPED;
                        continue;
                    }
                    if ( $amount < 0 ) {
                        $is_transaction_discount = $order_item['basic']['transactionDiscount'][0]->searchValue ?? false;
                        $prev_sku_state = $is_transaction_discount ? Prev_Sku_State::PROMOTION : Prev_Sku_State::ERRORED_OR_SKIPPED;
                        if ( ! array_key_exists( $ns_order_id, $discount_orders ) ) {
                            $discount_orders[ $ns_order_id ] = $is_transaction_discount;
                        } elseif ( $discount_orders[ $ns_order_id ] !== $is_transaction_discount ) {
                            $skipped_order_ids[] = $ns_order_id;
                            $errors[$ns_order_id][] = 'Both types of discounts (order-level and line-level) have been applied.';
                            continue;
                        }
                    }

                    $placeholders[$ns_order_id][] = "(%s, %s, %s)";
                    $fetched_orders_data[$ns_order_id][] = $ns_order_id;
                    $fetched_orders_data[$ns_order_id][] = maybe_serialize($order_item);
                    $fetched_orders_data[$ns_order_id][] = date('Y-m-d H:i:s');
                    $prev_sku_state = $prev_sku_state !== Prev_Sku_State::PROMOTION ? Prev_Sku_State::FETCHED : Prev_Sku_State::PROMOTION;

                    if ( !in_array($ns_order_id, $fetched_orders_data_ids) ) {
                        $log_file_content .= 'Fetched NS Order ID: ' . $ns_order_id . PHP_EOL;
                        $fetched_orders_data_ids[] = $ns_order_id;
                    }
                }
                if ( ! empty( $skipped_order_ids ) ) {
                    foreach ( $skipped_order_ids as $skipped_order_id ) {
                        if ( array_key_exists( $skipped_order_id, $placeholders ) ) {
                            unset( $placeholders[ $skipped_order_id ] );
                        }
                        if ( array_key_exists( $skipped_order_id, $fetched_orders_data ) ) {
                            unset( $fetched_orders_data[ $skipped_order_id ] );
                        }
                        $fetched_orders_data_ids = array_filter($fetched_orders_data_ids, function($fetched_orders_data_id) use ($skipped_order_id) {
                            return $fetched_orders_data_id !== $skipped_order_id;
                        });
                        $fetched_orders_data_ids = array_values($fetched_orders_data_ids);
                        $error_msg = isset ( $errors[ $skipped_order_id ] ) ? implode( ' ', $errors[ $skipped_order_id ] ) : 'Some SKUs not found.';
                        Crown_Order_Types::update_ns_order_custbody_values( $skipped_order_id, '', FALSE, $error_msg );
                    }
                }
                $placeholders = array_merge(...array_values($placeholders));
                $fetched_orders_data = array_merge(...array_values($fetched_orders_data));
                if ( ! empty($fetched_orders_data) && !empty($fetched_orders_data_ids) ) {
                    self::insert_item_to_tm_ns_fetch_new_orders_table($fetched_orders_data, $placeholders);
                    foreach ( $fetched_orders_data_ids as $fetched_orders_data_id ) {
                        self::$ns_new_orders_import_bg_process->push_to_queue( $fetched_orders_data_id );
                    }
                    $log_file_content .= 'Orders fetched. Dispatching import.' . PHP_EOL;
                    self::$ns_new_orders_import_bg_process->save();
                }
                file_put_contents($file_name, $log_file_content, FILE_APPEND);
            } else {
                $log_file_content .= 'No orders found.' . PHP_EOL;
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            }
            self::dispatch_ns_sync_bg_process($search_type, $page, $file_name);
            file_put_contents($file_name, 'Fetch finished ( page ' . $page . ' ).' . PHP_EOL . PHP_EOL, FILE_APPEND);
        }

        public static function get_items_records_from_ns( &$log_file_content, $hook, $search_type = 'new' ) {
            if (
                ! class_exists( 'TMWNI_Settings' ) || ! TMWNI_Settings::areCredentialsDefined()
                || ( $search_type == 'new' && empty(self::$ns_orders_fetch_from_netsuite_search_id) )
                || ( $search_type == 'update' && empty(self::$ns_orders_fetch_from_netsuite_update_id) )
                || ( $search_type == 'invoices' && empty(self::$ns_invoices_fetch_from_netsuite_search_id) )
                || ( $search_type == 'returns_update' && empty(NSI_NS_API::$ns_returns_update_fetch_from_netsuite_search_id) )
            ) {
                return null;
            }
            $netsuite_service = new NetSuiteService( null, array( 'exceptions' => true ) );
            $netsuite_service->setPreferences( false, false, false,true, false );
            $netsuite_service->setSearchPreferences( false, self::$ns_search_preferences_page_size );

            $search = new TransactionSearchAdvanced();
            if ( $search_type == 'new' ) {
                $search->savedSearchId = self::$ns_orders_fetch_from_netsuite_search_id;
            } else if ( $search_type == 'update' ) {
                $search->savedSearchId = self::$ns_orders_fetch_from_netsuite_update_id;
            } else if ( $search_type == 'invoices' ) {
                $search->savedSearchId = self::$ns_invoices_fetch_from_netsuite_search_id;
            } else if ( $search_type == 'returns_update' ) {
                $search->savedSearchId = NSI_NS_API::$ns_returns_update_fetch_from_netsuite_search_id;
            } else {
                return null;
            }

            $request = new SearchRequest();
            $request->searchRecord = $search;

            try {
                $results = array();
                $search_response = $netsuite_service->search( $request );
                if ( $search_response->searchResult->status->isSuccess ) {
                    if ( 0 != $search_response->searchResult->totalRecords && is_array( $search_response->searchResult->searchRowList->searchRow ) ) {
                        $results = $search_response->searchResult->searchRowList->searchRow;
                        $total_pages = $search_response->searchResult->totalPages;
                        $log_file_content .= 'Number of pages available for sync: ' . $total_pages . '. Limit: ' . self::$ns_sync_max_pages_limit . '.' . PHP_EOL;
                        if ( $total_pages > 1 ) {
                            $args = array( 2, $search_response->searchResult->searchId );
                            $page_limit = $total_pages > self::$ns_sync_max_pages_limit ? self::$ns_sync_max_pages_limit : $total_pages;
                            update_option( 'ns_sync_max_pages_limit_' . $search_type, $page_limit, false );
                            if ( ! as_next_scheduled_action( $hook, $args ) ) {
                                as_schedule_single_action( time()  + self::$cron_fetch_ns_pages_delay_time, $hook, $args );
                            }
                        }
                    }
                } else {
                    if ( $search_response instanceof SoapFault) {
                        $err_message = $search_response->getMessage();
                    } else {
                        $err_message = $search_response->searchResult->status->statusDetail[0]->message ?? '';
                    }
                    $log_file_content .= "'Saved Search' operation failed. Error Message: " . $err_message . '.'  . PHP_EOL;
                    return null;
                }
            } catch ( \Exception $e ) {
                $log_file_content .= "'Saved Search' operation failed. Error Message: " . $e->getMessage() . '.' . PHP_EOL;
                return null;
            }

            return self::get_ns_response_fetched_data_array($results);
        }

        public static function get_paged_items_records_from_ns( $search_type, $hook, $search_id, $page, &$log_file_content ) {
            $netsuite_service = new NetSuiteService( null, array( 'exceptions' => true ) );
            $netsuite_service->setPreferences( false, false, false,true, false );
            $netsuite_service->setSearchPreferences( false, self::$ns_search_preferences_page_size );

            $searchMoreRequest = new SearchMoreWithIdRequest();
            $searchMoreRequest->pageIndex = $page;
            $searchMoreRequest->searchId = $search_id;
            $results = array();
            try {
                $search_response = $netsuite_service->searchMoreWithId($searchMoreRequest);

                if ( $search_response->searchResult->status->isSuccess ) {
                    if ( 0 != $search_response->searchResult->totalRecords && is_array( $search_response->searchResult->searchRowList->searchRow ) ) {
                        $results = $search_response->searchResult->searchRowList->searchRow;
                        $total_pages = $search_response->searchResult->totalPages;
                        $page_limit = $total_pages > self::$ns_sync_max_pages_limit ? self::$ns_sync_max_pages_limit : $total_pages;
                        $args = array( $page + 1, $search_response->searchResult->searchId );
                        if ( $total_pages > 1 && $page < $page_limit && ! as_next_scheduled_action( $hook, $args ) ) {
                            as_schedule_single_action( time() + self::$cron_fetch_ns_pages_delay_time, $hook, $args );
                        }
                    } else {
                        $log_file_content .= "'Saved Search' operation for page ' . $page . ' did not return any records.'"  . PHP_EOL;
                    }
                } else {
                    if ( $search_response instanceof SoapFault) {
                        $err_message = $search_response->getMessage();
                    } else {
                        $err_message = $search_response->searchResult->status->statusDetail[0]->message ?? '';
                    }
                    $log_file_content .= "'Saved Search' operation for page ' . $page . ' failed. Error Message: " . $err_message . '.'  . PHP_EOL;
                }
            } catch ( \Exception $e ) {
                $log_file_content .= "'Saved Search' operation for page ' . $page . ' failed. Error Message: " . $e->getMessage() . '.' . PHP_EOL;
                update_option( 'ns_sync_max_pages_limit_' . $search_type, 1, false );
                return null;
            }

            if ( empty( $results ) ) {
                update_option( 'ns_sync_max_pages_limit_' . $search_type, 1, false );
                return null;
            } else {
                return self::get_ns_response_fetched_data_array($results);
            }
        }

        protected static function insert_item_to_tm_ns_fetch_new_orders_table( $ns_new_order_values, $placeholders ) {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_new_orders_table_name;
            $query_ns_item_pricing_insert = $wpdb->prepare( "INSERT INTO `{$table_name}` 
                (`ns_order_id`, `ns_order_data`, `fetch_date`) 
                VALUES " . implode(', ', $placeholders),
                $ns_new_order_values
            );

            $wpdb->query( $query_ns_item_pricing_insert );
        }

        protected static function save_item_to_tm_ns_fetch_orders_updates_table( $ns_orders_updates, $placeholders ) {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_orders_updates_table_name;
            $query = $wpdb->prepare( "INSERT INTO `{$table_name}`
                (`ns_order_id`, `item_sku`, `ns_order_data`, `fetch_date`)
                VALUES " . implode(', ', $placeholders) .
                "ON DUPLICATE KEY UPDATE
                    ns_order_data = VALUES(ns_order_data),
                    fetch_date = VALUES(fetch_date)",
                ...$ns_orders_updates
            );

            $wpdb->query( $query );
        }

        protected static function insert_item_to_tm_ns_fetch_invoices_updates_table( $fetched_invoices_data, $placeholders ) {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_invoices_table_name;
            $query = $wpdb->prepare( "INSERT INTO `{$table_name}` 
                (`ns_invoice_id`, `ns_invoice_data`, `fetch_date`) 
                VALUES " . implode(', ', $placeholders),
                $fetched_invoices_data
            );

            $wpdb->query( $query );
        }

        public static function get_invoice_tran_ids(int $order_id) {
            $invoice_tran_ids = array();
            $order_items_data = get_post_meta($order_id, 'order_items_data', true);
            // Make sure that order synced before invoices as there is a dependency on some order data.
            if (!empty($order_items_data)) {
                $invoice_tran_ids = get_post_meta($order_id, 'ns_invoice_tran_ids');
                if (!empty($invoice_tran_ids)) {
                    $invoice_tran_ids = reset($invoice_tran_ids);
                }
            }
            return $invoice_tran_ids;
        }

        protected static function get_ns_response_fetched_data_array(array $results) {
            $fetched_data = array();
            foreach ($results as $result) {
                $fetched_data_details = array();
                foreach ($result->basic ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['basic'][$key] = $detail;
                    }
                }

                foreach ($result->customerJoin ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['customer_join'][$key] = $detail;
                    }
                }

                foreach ($result->customerMainJoin ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['customer_main_join'][$key] = $detail;
                    }
                }

                foreach ($result->itemJoin ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['item_join'][$key] = $detail;
                    }
                }

                foreach ($result->applyingTransactionJoin ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['transaction_join'][$key] = $detail;
                    }
                }

                foreach ($result->subsidiaryJoin ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['subsidiary_join'][$key] = $detail;
                    }
                }

                foreach ($result->partnerJoin ?? [] as $key => $detail) {
                    if (!is_null($detail)) {
                        $fetched_data_details['partner_join'][$key] = $detail;
                    }
                }
                $fetched_data[] = $fetched_data_details;
            }

            return $fetched_data;
        }

        public static function dispatch_ns_sync_bg_process($search_type, $page, $file_name) {
            switch ( $search_type ) {
                case 'new':
                    $bg_process = self::$ns_new_orders_import_bg_process;
                    break;
                case 'update':
                    $bg_process = self::$ns_orders_updates_import_bg_process;
                    break;
                case 'invoices':
                    $bg_process = self::$ns_invoices_import_bg_process;
                    break;
                default:
                    $bg_process = '';
                    break;
            }
            if ( ! $bg_process instanceof WP_Background_Process ) {
                return;
            }
            $pages_limit = (int)get_option('ns_sync_max_pages_limit_' . $search_type);
            if ( $page >= $pages_limit || $page >= self::$ns_sync_page_to_dispatch_bg_process ) {
                if ( ! method_exists( $bg_process, 'is_running' ) || ! method_exists( $bg_process, 'is_queue_has_items' ) ) {
                    file_put_contents( $file_name, 'Dispatching import.' . PHP_EOL, FILE_APPEND );
                    $bg_process->dispatch();
                } elseif ( ! $bg_process->is_running() && $bg_process->is_queue_has_items() ) {
                    file_put_contents( $file_name, 'Dispatching import.' . PHP_EOL, FILE_APPEND );
                    $bg_process->dispatch();
                }
            }
        }

        public static function is_errored_sku_skipped(string $item_sku): bool {
            return self::$ns_order_sync_sku_errors_strict_match ?
                in_array( $item_sku, self::$ns_order_sync_sku_errors_to_skip ) :
                !empty(array_filter(self::$ns_order_sync_sku_errors_to_skip, fn($sku_error_to_skip) => str_contains($item_sku, $sku_error_to_skip)));
        }

        public static function get_email_domain($user) {
            $user_email = $user->user_email;
            $user_email_domain = '';
            if (preg_match('/(@[^,;\s]+)/', $user_email, $matches)) {
                $user_email_domain = $matches[1];
            }
            return $user_email_domain;
        }

        protected static function delete_item_from_tm_ns_fetch_new_orders_table( $ns_order_id ) {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_new_orders_table_name;
            $wpdb->query( $wpdb->prepare( "DELETE FROM `{$table_name}` WHERE ns_order_id = %s ", $ns_order_id ) );
        }

        protected static function get_tm_ns_fetched_order_item( $ns_order_id ) {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_new_orders_table_name;
            $item_result = $wpdb->get_results( $wpdb->prepare("SELECT * FROM `{$table_name}` WHERE ns_order_id = %s",
                $ns_order_id ) );

            return $item_result;
        }

		public static function sync_order_ns_sales_order_data( $order_data, $customer_internal_id, $order_internal_id ) {

			$order_id = $order_data['order_id'];

			// get sales order record from NetSuite
			$record = self::get_ns_sales_order_record( $order_internal_id );
			if ( ! $record ) return;

			$tran_id = property_exists( $record, 'tranId' ) ? $record->tranId : null;
			if ( $tran_id && ! empty( $tran_id ) ) {
				update_post_meta( $order_id, 'ns_order_tran_id', $tran_id );
			} else {
				update_post_meta( $order_id, 'ns_order_tran_id', '' );
			}
		}

		public static function add_meta_box() {
			global $post;
			global $wpdb;
			$wpdb->netsuite_order_logs = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';

			$order_data = $wpdb->get_results($wpdb->prepare(" SELECT * FROM {$wpdb->netsuite_order_logs} WHERE woo_object_id = %d AND ns_order_status = 'Not Sync'", $post->ID), OBJECT);
			if (empty($order_data)) {
				return false;
			} else {
				add_meta_box(
					'netsuite_error_metabox',
					__('NetSuite Error Messages', 'woocommerce-netsuite-order-sync'),
					array(__CLASS__, 'display_netsuite_errors'),
					'shop_order',
					'normal',
					'high',
					array(
						'messages'   => $order_data,
					)
				);
			}
		}

        public static function cron_fetch_orders_updates( $page = 1, $search_id = '' ) {
            $search_type = 'update';
            $hook = 'tm_ns_fetch_orders_updates_action';
            $transient_key = 'cron_fetch_ns_orders_updates';
            if ( $page == 1 ) {
                if ( get_transient( $transient_key ) ) {
                    return;
                }
                update_option( 'ns_sync_max_pages_limit_' . $search_type, 1, false );
            }
            set_transient( $transient_key, true, self::$cron_fetch_ns_orders_updates_timeout );
            $date 	        = date( "Y-m-d" );
            $datetime = date( "Y-m-d H:i:s" );
            $file_name = self::create_ns_sync_log_file( 'fetch-updates-' . $date . '.log', 'fetch-updates' );
            file_put_contents( $file_name, '[' . $datetime . '] Start fetch of NS Orders Update ( page ' . $page . ' )' . PHP_EOL, FILE_APPEND );
            $log_file_content = '';
            $order_updates = array();
            if ( $page == 1 ) {
                $order_updates = self::get_items_records_from_ns( $log_file_content, $hook, $search_type );
            } elseif ( $page > 1 && ! empty( $search_id ) ) {
                $order_updates = self::get_paged_items_records_from_ns( $search_type, $hook, $search_id, $page, $log_file_content );
            }
            if ( !empty( $order_updates ) ) {
                $fetched_orders_data = $fetched_ids = $placeholders = $orders_to_clear = array();
                foreach ( $order_updates as $order_item ) {
                    $ns_order_id = $order_item['basic']['internalId'][0]->searchValue->internalId;

                    if ( empty( $ns_order_id ) || in_array($ns_order_id, $orders_to_clear) ) {
                        continue;
                    }

                    if ( ! in_array($ns_order_id, $fetched_ids) && empty( self::check_if_ns_order_internal_id_exists( $ns_order_id ) ) ) {
                        $log_file_content .= 'NS Order ID not found: ' . $ns_order_id . ', skipping' . PHP_EOL;
                        $orders_to_clear[] = $ns_order_id;
                        continue;
                    }

                    $item_sku = $order_item['item_join']['itemId'][0]->searchValue ?? '';

                    $placeholders[$ns_order_id][] = "(%s, %s, %s, %s)";
                    $fetched_orders_data[$ns_order_id][] = $ns_order_id;
                    $fetched_orders_data[$ns_order_id][] = $item_sku;
                    $fetched_orders_data[$ns_order_id][] = maybe_serialize( $order_item );
                    $fetched_orders_data[$ns_order_id][] = date( 'Y-m-d H:i:s' );
                    if ( !in_array($ns_order_id, $fetched_ids) ) {
                        $log_file_content .= 'Fetched NS Order ID: ' . $ns_order_id . PHP_EOL;
                        $fetched_ids[] = $ns_order_id;
                    }
                }

                foreach ( $orders_to_clear as $order_id ) {
                    Crown_Order_Types::update_ns_order_custbody_values( $order_id, null, FALSE, null );
                }

                $placeholders = array_merge( ...array_values($placeholders) );
                $fetched_orders_data = array_merge( ...array_values($fetched_orders_data) );
                if ( ! empty($fetched_orders_data) && !empty($fetched_ids) ) {
                    self::save_item_to_tm_ns_fetch_orders_updates_table( $fetched_orders_data, $placeholders );
                    $queued_items = self::get_ns_ids_already_in_process_queue( $search_type );
                    $ids_to_queue = array_diff($fetched_ids, $queued_items);
                    if ( !empty($ids_to_queue) ) {
                        foreach ( $ids_to_queue as $id_to_queue ) {
                            self::$ns_orders_updates_import_bg_process->push_to_queue( $id_to_queue );
                        }
                        self::$ns_orders_updates_import_bg_process->save();
                    } else {
                        $log_file_content .= 'Updates fetched. All orders were already added to queue.' . PHP_EOL;
                    }
                }
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            } else {
                $log_file_content .= 'No updates found.' . PHP_EOL;
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            }
            self::dispatch_ns_sync_bg_process($search_type, $page, $file_name);
            file_put_contents( $file_name, 'Fetch finished ( page ' . $page . ' ).' . PHP_EOL . PHP_EOL, FILE_APPEND );
        }

        public static function cron_tm_ns_invoices_fetch( $page = 1, $search_id = '' ) {
            $transient_key = 'cron_fetch_ns_invoices';
            $search_type = 'invoices';
            $hook = 'tm_ns_invoices_fetch';
            if ( $page == 1 ) {
                if ( get_transient( $transient_key ) ) {
                    return;
                }
                update_option( 'ns_sync_max_pages_limit_' . $search_type, 1, false );
            }
            set_transient($transient_key, true, self::$cron_fetch_ns_orders_updates_timeout);
            $date 	        = date( "Y-m-d" );
            $datetime = date( "Y-m-d H:i:s" );
            $file_name = self::create_ns_sync_log_file( 'fetch-invoices-' . $date . '.log', 'fetch-invoices' );
            file_put_contents( $file_name, '[' . $datetime . '] Start fetch of NS Invoices ( page ' . $page . ' )' . PHP_EOL, FILE_APPEND );
            $log_file_content = '';
            $invoices = array();
            if ( $page == 1 ) {
                $invoices = self::get_items_records_from_ns( $log_file_content, $hook, $search_type );
            } elseif ( $page > 1 && ! empty( $search_id ) ) {
                $invoices = self::get_paged_items_records_from_ns( $search_type, $hook, $search_id, $page, $log_file_content );
            }
            if ( !empty( $invoices ) ) {
                $fetched_invoices_data = $fetched_ids = $placeholders = array();
                foreach ( $invoices as $invoice_item ) {
                    $ns_invoice_id = $invoice_item['basic']['internalId'][0]->searchValue->internalId;

                    if ( empty( $ns_invoice_id ) ) {
                        continue;
                    }

                    $placeholders[$ns_invoice_id][] = "(%s, %s, %s)";
                    $fetched_invoices_data[$ns_invoice_id][] = $ns_invoice_id;
                    $fetched_invoices_data[$ns_invoice_id][] = maybe_serialize( $invoice_item );
                    $fetched_invoices_data[$ns_invoice_id][] = date( 'Y-m-d H:i:s' );
                    if ( !in_array($ns_invoice_id, $fetched_ids) ) {
                        $log_file_content .= 'Fetched NS Invoice ID: ' . $ns_invoice_id . PHP_EOL;
                        $fetched_ids[] = $ns_invoice_id;
                    }
                }

                $placeholders = array_merge( ...array_values($placeholders) );
                $fetched_invoices_data = array_merge( ...array_values($fetched_invoices_data) );
                if ( ! empty($fetched_invoices_data) && !empty($fetched_ids) ) {
                    self::insert_item_to_tm_ns_fetch_invoices_updates_table( $fetched_invoices_data, $placeholders );
                    $queued_items = self::get_ns_ids_already_in_process_queue( $search_type );
                    $ids_to_queue = array_diff($fetched_ids, $queued_items);
                    if ( !empty($ids_to_queue) ) {
                        foreach ( $ids_to_queue as $id_to_queue ) {
                            self::$ns_invoices_import_bg_process->push_to_queue( $id_to_queue );
                        }
                        self::$ns_invoices_import_bg_process->save();
                    } else {
                        $log_file_content .= 'All invoices were already added to queue.' . PHP_EOL;
                    }
                }
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            } else {
                $log_file_content .= 'No invoices found.' . PHP_EOL;
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            }
            self::dispatch_ns_sync_bg_process($search_type, $page, $file_name);
            file_put_contents( $file_name, 'Fetch finished ( page ' . $page . ' ).' . PHP_EOL . PHP_EOL, FILE_APPEND );
        }

        public static function get_ns_ids_already_in_process_queue( $search_type ) {
            global $wpdb;

            switch ( $search_type ) {
                case 'update':
                    $option_name_like = '%ns_orders_updates_import_batch%';
                    break;
                case 'invoices':
                    $option_name_like = '%tm_ns_invoices_fetch_batch%';
                    break;
                default:
                    $option_name_like = '';
                    break;
            }
            if ( empty( $option_name_like ) ) {
                return array();
            }
            $batch_options = $wpdb->get_results(
                $wpdb->prepare(
                        "SELECT option_value 
                        FROM {$wpdb->options} 
                        WHERE option_name LIKE %s",
                    $option_name_like
                )
            );

            $queued_items = array();

            foreach ( $batch_options as $row ) {
                $batch = maybe_unserialize( $row->option_value );

                if ( is_array($batch) ) {
                    foreach ( $batch as $item ) {
                        $queued_items[] = $item;
                    }
                }
            }
            return $queued_items;
        }

        protected static function check_if_ns_order_internal_id_exists( $ns_order_id ) {
            global $wpdb;

            $table_name = $wpdb->postmeta;
            $order_result = $wpdb->get_results( $wpdb->prepare(
                "SELECT * FROM `{$table_name}` WHERE meta_key = 'ns_order_internal_id' and meta_value = %s",
                $ns_order_id ) );

            return $order_result;
        }

		public static function display_netsuite_errors($post, $args)
		{
			?>
			<div class="woocommerce">
				<?php foreach($args['args']['messages'] as $message) { ?>
				<p><?php esc_html_e("$message->notes", 'woocommerce'); ?></p>
				<?php } ?>
			</div>
			<?php
		}

		public static function filter_woocommerce_order_number( $order_id, $order ) {
			$tran_id = get_post_meta( $order_id, 'ns_order_tran_id', true );
			if ( ! empty( $tran_id ) ) $order_id = $tran_id;
			return $order_id;
		}


		public static function filter_woocommerce_admin_order_buyer_name( $buyer, $order ) {
			$po_no = get_post_meta( $order->get_id(), 'af_c_f_4432739', true );
			if ( empty( $po_no ) ) $po_no = get_post_meta( $order->get_id(), 'af_c_f_47165', true );
            if ( empty( $buyer ) ) {
                $user  = get_user_by( 'id', $order->get_customer_id() );
                $buyer = ucwords( $user->display_name );
            }
			if ( ! empty( $po_no ) ) {
				$buyer .= ' (' . $po_no . ')';
			}
			return $buyer;
		}

        public static function add_dual_shop_manager_quote_metadata( $order_id, $quote_id ) {
            $order = wc_get_order( $order_id );
            if ( $order ) {
                self::add_dual_shop_manager_order_metadata( $order );
            }
        }

        public static function add_dual_shop_manager_order_metadata($order) {
            $user = wp_get_current_user();
            if ( empty( $user) ) {
                return;
            }
            $order_id = $order->get_id();
            if ( in_array( 'dual_shop_manager', (array) $user->roles, true ) ) {
                $current_user_email_domain = self::get_email_domain( $user );
                update_post_meta( $order_id, '_created_by_dual_shop_manager', true );
                update_post_meta( $order_id, '_sales_rep_domain', $current_user_email_domain );
            } else {
                $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
                $admin_user = get_user_by( 'id', $admin_id );
                if (
                    Nsi_Helper::is_admin_session_set()
                    && $user->ID != $admin_id && $admin_id != 0
                    && isset( $admin_user->roles[0] ) && $admin_user->roles[0] === 'dual_shop_manager'
                ) {
                    $current_user_email_domain = self::get_email_domain( $admin_user );
                    update_post_meta( $order_id, '_created_by_dual_shop_manager', true );
                    update_post_meta( $order_id, '_sales_rep_domain', $current_user_email_domain );
                }
            }
        }

		public static function filter_admin_order_query( $query ) {
			if ( ! $query->is_main_query() ) return;
			if ( ! is_admin() ) return;
			if ( basename( $_SERVER['SCRIPT_FILENAME'] ) != 'edit.php' ) return;
			if ( $query->get('post_type') != 'shop_order' ) return;

			$current_user = wp_get_current_user();
			$roles = ( array ) $current_user->roles;
			if ( ! in_array( 'shop_manager', $roles ) && ! in_array( 'dual_shop_manager', $roles ) ) return;

            $current_user_email_domain = self::get_email_domain( $current_user );
			$customer_ids = Crown_Shop_Custom_Roles::get_sales_rep_customer_ids( $current_user_email_domain );

			$queried_customer_user = isset( $_GET['_customer_user'] ) ? intval( $_GET['_customer_user'] ) : 0;
			if ( ! empty( $queried_customer_user ) && in_array( $queried_customer_user, $customer_ids ) ) {
				$customer_ids = array( $queried_customer_user );
			}
            $meta_query = array();
			if ( ! empty( $customer_ids ) ) {
                $meta_query[] = array(
                    'key' => '_customer_user',
                    'value' => $customer_ids,
                    'compare' => 'IN',
                );
			} else {
                $meta_query[] = array( 'key' => '_customer_user', 'value' => 0 );
			}

            if ( ! empty( $meta_query ) && in_array( 'shop_manager', $roles ) ) {
                $query->set( 'meta_query', $meta_query );
            }

            if ( in_array( 'dual_shop_manager', $roles ) ) {
                $dual_shop_manager_orders_ids = Crown_Shop_Custom_Roles::get_dual_shop_manager_order_ids( $customer_ids, true );

                if ( empty( $dual_shop_manager_orders_ids ) ) {
                    $dual_shop_manager_orders_ids = array(0);
                }

                $query->set( 'post__in', $dual_shop_manager_orders_ids );
            }

		}

        public static function handle_custom_query_var( $query, $query_vars ) {
            if ( ! empty( $query_vars['_created_by_dual_shop_manager'] ) ) {
                $query['meta_query'][] = array(
                    'key' => '_created_by_dual_shop_manager',
                    'value' => esc_attr( $query_vars['_created_by_dual_shop_manager'] ),
                );
            }
            if ( ! empty( $query_vars['_sales_rep_domain'] ) ) {
                $query['meta_query'][] = array(
                    'key' => '_sales_rep_domain',
                    'value' => esc_attr( $query_vars['_sales_rep_domain'] ),
                );
            }

            return $query;
        }

		public static function custom_wocommerce_settings_pages() {
			add_submenu_page(
				'woocommerce',
				esc_html__( 'Customer Shipping Settings' ),
				esc_html__( 'Customer Shipping Settings' ),
				'administrator',
				'custom-shipping-settings',
				array( __CLASS__, 'custom_shipping_settings_page_display' )
			);
            add_submenu_page(
				'woocommerce',
				esc_html__( 'Orders Settings' ),
				esc_html__( 'Orders Settings' ),
				'administrator',
				'custom-order-settings',
				array( __CLASS__, 'custom_order_settings_page_display' )
			);
		}

		public static function custom_shipping_settings_page_display() {
			if ( !defined( 'ABSPATH' ) ) { exit; }

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );

			$active_tab 	= isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main_settings';
			$main_slug_page = 'custom-shipping-settings';

			$list_tabs = [
				'main_settings' => [
					'title' 				=> esc_html__( 'Main settings' ),
					'slug'					=> 'main_settings',
					'settings_fields' 		=> 'custom_shipping_settings',
					'do_settings_sections' 	=> 'custom-shipping-settings'
				],
				'customer_specific_order' => [
					'title' 				=> esc_html__( 'Customer specific order' ),
					'slug'					=> 'customer_specific_order',
					'settings_fields' 		=> 'customer_specific_order_settings',
					'do_settings_sections' 	=> 'customer_specific_order_settings'
				],
				'suffix_prefix_specific_order' => [
					'title' 				=> esc_html__( 'Suffix/Prefix' ),
					'slug'					=> 'suffix_prefix_specific_order',
					'settings_fields' 		=> 'suffix_prefix_specific_order_settings',
					'do_settings_sections' 	=> 'suffix_prefix_specific_order_settings'
				],
				'state_specific_order' => [
					'title' 				=> esc_html__( 'State specific order' ),
					'slug'					=> 'state_specific_order',
					'settings_fields' 		=> 'state_specific_order_settings',
					'do_settings_sections' 	=> 'state_specific_order_settings'
				],
				'city_specific_order' => [
					'title' 				=> esc_html__( 'City specific order' ),
					'slug'					=> 'city_specific_order',
					'settings_fields' 		=> 'city_specific_order_settings',
					'do_settings_sections' 	=> 'city_specific_order_settings'
				],
				'change_min_amount_all_customer' => [
					'title' 				=> esc_html__( 'Apply changes to all customers' ),
					'slug'					=> 'change_min_amount_all_customer',
					'settings_fields' 		=> 'change_min_amount_all_customer_settings',
					'do_settings_sections' 	=> 'change_min_amount_all_customer_settings'
				],
			];
			
			echo '<div class="wrap">';
				echo '<h2>';
					esc_html_e( 'Custom Shipping Settings' );
				echo '</h2>';
				?>

				<!-- Display the tabs -->
				<?php if( !empty( $list_tabs ) ): ?>
					<h2 class="nav-tab-wrapper">
						<?php foreach( $list_tabs as $slug => $data_tab ): ?>
							<a id="tab-<?= $slug ?>" href="?page=<?= $main_slug_page ?>&tab=<?= $slug ?>"
								class="nav-tab <?= $active_tab == $slug ? 'nav-tab-active' : ''; ?>">
								<?= $data_tab[ 'title' ] ?>
							</a>
						<?php endforeach; ?>
					</h2>
				<?php endif; ?>
            </div>
			<?php
				// Display the content of the tab
				self::display_content_tab( $list_tabs[ $active_tab ] );
		}

		public static function custom_order_settings_page_display() {
			if ( !defined( 'ABSPATH' ) ) { exit; }

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-core' );

			?>
            <div class="wrap">
                <h2><?php esc_html_e('Orders Settings'); ?></h2>
                <form method="post" action="options.php">
					<?php
					settings_fields('custom_order_settings');
					do_settings_sections('custom-order-settings');
					submit_button();
					?>
                </form>
            </div>
			<?php
		}

		/**
		 * Display the content tab based on the active tab.
		 *
		 * @param string $active_tab The slug of the active tab.
		 * @return void
		 */
		public static function display_content_tab( $active_tab ) {
			echo '<div id="' . $active_tab[ 'slug' ] . '" class="tab-content">';
			if( $active_tab[ 'slug' ] != 'change_min_amount_all_customer' ) {
				echo '<form method="post" action="options.php">';
					settings_fields( $active_tab[ 'settings_fields' ] );
					do_settings_sections( $active_tab[ 'do_settings_sections' ] );
					submit_button();
				echo '</form>';
			} else {

				// Display the content for the change_min_amount_all_customer tab
				self::content_for_change_min_amount_all_customer_tab();
				
			}
			echo '</div>';
		}

		public static function content_for_change_min_amount_all_customer_tab(){

			echo self::YOU_CAN_SEE_RESULTS_HTML_BLOCK;
			
			// Change the minimum order amount for all customers
			$page_slug 		= $_GET[ 'page' ];
			$request_url 	= get_site_url() . '/wp-json/custom-shipping-settings/v2/apply-changes-to-all-customers?pageSlug=' . $page_slug;

			$response = wp_remote_get( $request_url, array(
				'headers' => array(
					'Accept-Language' => 'en-US'
				),
				'timeout' 		=> 30,
				'redirection' 	=> 5,
				'httpversion' 	=> '1.1',
				'sslverify' 	=> false
			));
		}

		// Main settings
		public static function custom_shipping_settings_init(): void
        {
			add_settings_section(
				'custom_shipping_settings_section',
				'Customer Specific Minimum Order Amounts',
				array( __CLASS__, 'custom_shipping_settings_section_cb' ),
				'custom-shipping-settings'
			);
			add_settings_field(
				'custom_shipping_default_order_value',
				'Default order amount for Free Shipping (in USD)',
				array( __CLASS__, 'custom_shipping_default_order_value_field_cb' ),
				'custom-shipping-settings',
				'custom_shipping_settings_section'
			);
			register_setting( 'custom_shipping_settings', 'custom_shipping_default_order_value' );

			// Customer specific order Tab
			add_settings_section(
				'customer_order_settings_section',
				'Customer specific order',
				array( __CLASS__, 'customer_order_settings_section_cb' ),
				'customer_specific_order_settings'
			);

			add_settings_field(
				'custom_shipping_user_data',
				'Customer specific order amount for Free Shipping',
				array( __CLASS__, 'custom_shipping_user_data_field_cb' ),
				'customer_specific_order_settings',
				'customer_order_settings_section'
			);

			register_setting( 'customer_specific_order_settings', 'custom_shipping_settings' );

			// City specific order Tab
			add_settings_section(
				'city_order_settings_section',
				'City specific order',
				array( __CLASS__, 'city_order_settings_section_cb' ),
				'city_specific_order_settings'
			);

			add_settings_field(
				'city_order_user_data',
				'City specific order amount for Free Shipping',
				array( __CLASS__, 'city_order_data_field_cb' ),
				'city_specific_order_settings',
				'city_order_settings_section'
			);

			register_setting( 'city_specific_order_settings', 'city_order_settings' );

			// State specific order Tab
			add_settings_section(
				'state_order_settings_section',
				'State specific order',
				array( __CLASS__, 'state_order_settings_section_cb' ),
				'state_specific_order_settings'
			);

			add_settings_field(
				'state_order_user_data',
				'State specific order amount for Free Shipping',
				array( __CLASS__, 'state_order_data_field_cb' ),
				'state_specific_order_settings',
				'state_order_settings_section'
			);

			register_setting( 'state_specific_order_settings', 'state_order_settings' );

			// Suffix/Prefix specific order Tab
			add_settings_section(
				'suffix_prefix_order_settings_section',
				'Suffix/Prefix specific order',
				array( __CLASS__, 'suffix_prefix_order_settings_section_cb' ),
				'suffix_prefix_specific_order_settings'
			);

			add_settings_field(
				'suffix_prefix_order_user_data',
				'Suffix/Prefix specific order amount for Free Shipping',
				array( __CLASS__, 'suffix_prefix_order_data_field_cb' ),
				'suffix_prefix_specific_order_settings',
				'suffix_prefix_order_settings_section'
			);

			register_setting( 'suffix_prefix_specific_order_settings', 'suffix_prefix_order_settings',array(
				'sanitize_callback' => array( __CLASS__, 'suffix_prefix_sanitize' ),
			) );
		}

        public static function custom_order_settings_init(): void {
			add_settings_section(
				'custom_order_settings_section',
				'Main Settings',
				array( __CLASS__, 'custom_order_settings_section_cb' ),
				'custom-order-settings'
			);

			// Allowed order amount for place order tab
            add_settings_field(
                'custom_settings_default_minimum_order_amount',
                'Allowed order amount for place order',
                array( __CLASS__, 'custom_settings_default_minimum_order_amount_field_cb' ),
                'custom-order-settings',
                'custom_order_settings_section'
            );
            register_setting( 'custom_order_settings', 'custom_settings_default_minimum_order_amount' );

            add_settings_section(
                'subsidiary_order_settings_section',
                'Subsidiary data for order documents',
                array( __CLASS__, 'subsidiary_order_settings_section_cb' ),
                'custom-order-settings'
            );

            add_settings_field(
                'subsidiary_settings_address',
                'Subsidiary address',
                array( __CLASS__, 'subsidiary_settings_address_cb' ),
                'custom-order-settings',
                'subsidiary_order_settings_section'
            );
            add_settings_field(
                'subsidiary_settings_email',
                'Subsidiary email',
                array( __CLASS__, 'subsidiary_settings_email_cb' ),
                'custom-order-settings',
                'subsidiary_order_settings_section'
            );
            add_settings_field(
                'subsidiary_settings_phone',
                'Subsidiary phone',
                array( __CLASS__, 'subsidiary_settings_phone_cb' ),
                'custom-order-settings',
                'subsidiary_order_settings_section'
            );
            register_setting( 'custom_order_settings', 'subsidiary_settings_address' );
            register_setting( 'custom_order_settings', 'subsidiary_settings_email' );
            register_setting( 'custom_order_settings', 'subsidiary_settings_phone' );
		}

		public static function custom_order_settings_section_cb() {
			echo '<p>Specify minimum allowed amount to place the order.</p>';
		}

		public static function subsidiary_order_settings_section_cb() {
			echo '<p>Specify subsidiary data that need to be printed on order documents.</p>';
		}

		public static function custom_shipping_settings_section_cb() {
			wp_enqueue_script( 'user-suggest' );
			echo '<p>Specify default minimum order amounts for free shipping.</p>';
			echo self::APPLY_THESE_RULES_HTML_BLOCK;
		}

		public static function customer_order_settings_section_cb() {
			wp_enqueue_script( 'user-suggest' );
			echo '<p>Specify customers and their corresponding minimum order amounts for free shipping.</p>';
			echo self::APPLY_THESE_RULES_HTML_BLOCK;
		}

		public static function city_order_settings_section_cb() {
			wp_enqueue_script( 'user-suggest' );
			echo '<p>Specify city and their corresponding minimum order amounts for free shipping.</p>';
			echo self::APPLY_THESE_RULES_HTML_BLOCK;
		}

		public static function state_order_settings_section_cb() {
            [$usa_states_in_string, $canada_states_in_string] = self::get_usa_and_canada_states_lists();

            wp_enqueue_script( 'user-suggest' );
			echo '<p>Comma-separated list of state/province abbreviations which this sales manager represents.</p>';
            echo '<p><em>Possible USA states list: </em>' . $usa_states_in_string . ' </p>';
            echo '<p><em>Possible Canada states list: </em>' . $canada_states_in_string . ' </p>';
			echo self::APPLY_THESE_RULES_HTML_BLOCK;
		}

		public static function suffix_prefix_order_settings_section_cb() {
			wp_enqueue_script( 'user-suggest' );
			echo '<p>Specify customers by suffix and prefix.</p>';
			echo self::APPLY_THESE_RULES_HTML_BLOCK;
		}

		public static function custom_shipping_default_order_value_field_cb() {
			$default_order_amount = get_option( 'custom_shipping_default_order_value' ) ?? 250;
			$default_order_amount = esc_attr( $default_order_amount );

			echo '<div class="custom-shipping-default-order-amount">';
				echo "<input type='number' name='custom_shipping_default_order_value' value='$default_order_amount' />";
			echo '</div>';
		}

        public static function custom_settings_default_minimum_order_amount_field_cb(): void
        {
            $default_order_amount_place_order = get_option( 'custom_settings_default_minimum_order_amount', 100 );
            $default_order_amount_place_order = esc_attr( $default_order_amount_place_order );

            echo '<div class="custom-settings-default-order-amount-place-order">';
				echo "<input type='number' name='custom_settings_default_minimum_order_amount' value='$default_order_amount_place_order' />";
            echo '</div>';
        }

        public static function subsidiary_settings_address_cb() {
            $default_subsidiary_settings_address = get_option( 'subsidiary_settings_address', "PO Box 842924\r\nDallas, TX 75284-2924" );
            $default_subsidiary_settings_address = esc_attr( $default_subsidiary_settings_address );

            echo '<div class="subsidiary-settings">';
				echo "<textarea id='subsidiary_settings_address' name='subsidiary_settings_address' rows='3'>$default_subsidiary_settings_address</textarea>";
            echo '</div>';
        }

        public static function subsidiary_settings_email_cb() {
            $default_subsidiary_settings_email = get_option( 'subsidiary_settings_email', "AR@nsiindustries.com" );
            $default_subsidiary_settings_email = esc_attr( $default_subsidiary_settings_email );

            echo '<div class="subsidiary-settings">';
				echo "<input type='email' name='subsidiary_settings_email' value='$default_subsidiary_settings_email' />";
            echo '</div>';
        }

        public static function subsidiary_settings_phone_cb() {
            $default_subsidiary_settings_phone = get_option( 'subsidiary_settings_phone', "704-439-2420" );
            $default_subsidiary_settings_phone = esc_attr( $default_subsidiary_settings_phone );

            echo '<div class="subsidiary-settings">';
				echo "<input type='text' name='subsidiary_settings_phone' value='$default_subsidiary_settings_phone' />";
            echo '</div>';
        }

		public static function suffix_prefix_order_data_field_cb() {
			$options 				= get_option( 'suffix_prefix_order_settings' );
			$suffix_prefix_data 	= $options[ 'suffix_prefix_data' ] ?? [];

			echo '<div id="prefix-suffix-order-fields">';
				$index = 0;
				if( !empty( $suffix_prefix_data ) ){
					foreach ( $suffix_prefix_data as $data ) {
						if( !empty( $data ) ){
							echo '<div class="prefix-suffix-order-field-group">';
							$prefix_name = esc_attr( $data[ 'name-prefix' ] ?? '' );
							$suffix_name = esc_attr( $data[ 'name-suffix' ] ?? '' );
							$min_order 	 = esc_attr( $data[ 'min_order' ] ?? '' );
	
							echo "<input type='text' class='prefix' name='suffix_prefix_order_settings[suffix_prefix_data][$index][name-prefix]' placeholder='Prefix ...' value='$prefix_name' />";
							echo "<input type='text' class='suffix' name='suffix_prefix_order_settings[suffix_prefix_data][$index][name-suffix]' placeholder='Suffix ...' value='$suffix_name' />";
							echo "<input required type='number' name='suffix_prefix_order_settings[suffix_prefix_data][$index][min_order]' value='$min_order' placeholder='Min order amount ($)' />";
							echo "<button type='button' class='remove--prefix-suffix-order__field-group'>Remove</button>";
						echo '</div>';
						$index++;
						}
					}
				}
			echo '</div>';
			echo '<button type="button" id="add-more-prefix-suffix">Add More</button>';
		}

		public static function custom_shipping_user_data_field_cb() {
			$options 	= get_option( 'custom_shipping_settings' );
			$user_data 	= $options[ 'user_data' ] ?? [];

			echo '<div id="custom-shipping-user-fields">';
				$index = 0;
				foreach ( $user_data as $data ) {
					echo '<div class="custom-shipping-user-field-group">';
					// User autocomplete field
					$user_name = esc_attr( $data[ 'user_name' ] ?? '' );
					$user_id = esc_attr( $data[ 'user_id' ] ?? '' );
					echo "<input required type='text' class='customer-autocomplete' name='custom_shipping_settings[user_data][$index][user_name]' placeholder='Type to search customers...' value='$user_name'  />";
					echo "<input type='hidden' class='customer-id-hidden-input' name='custom_shipping_settings[user_data][$index][user_id]' value='$user_id'  />";

					// Minimum order input field
					$min_order = esc_attr( $data[ 'min_order' ] ?? '' );
					echo "<input required type='number' name='custom_shipping_settings[user_data][$index][min_order]' value='$min_order' placeholder='Min order amount ($)' />";
					echo "<button type='button' class='remove-custom-shipping-user-field-group'>Remove</button>";
					echo '</div>';
					$index++;
				}
			echo '</div>';
			echo '<button type="button" id="add-more-users">Add More</button>';
		}

		public static function city_order_data_field_cb() {
			$options 	= get_option( 'city_order_settings' );
			$city_data 	= $options[ 'city_data' ] ?? [];

            $trimmed_city_data = array_map(function($item) {
                return is_string($item) ? trim($item) : $item;
            }, $city_data);

            echo '<div id="city-order-fields">';
				$index = 0;
				foreach ( $trimmed_city_data as $data ) {
					echo '<div class="city-order-field-group">';
						
						$city_name = esc_attr( $data[ 'city_name' ] ?? '' );
						echo "<input required type='text' class='' name='city_order_settings[city_data][$index][city_name]' placeholder='Write city...' value='$city_name'  />";

						// Minimum order input field
						$min_order = esc_attr( $data[ 'min_order' ] ?? '' );
						echo "<input required type='number' name='city_order_settings[city_data][$index][min_order]' value='$min_order' placeholder='Min order amount ($)' />";
						echo "<button type='button' class='remove-city-order-field-group'>Remove</button>";
					echo '</div>';
					$index++;
				}
			echo '</div>';
			echo '<button type="button" id="add-more-city">Add More</button>';
		}

		public static function state_order_data_field_cb() {
			$options 	= get_option( 'state_order_settings' );
			$state_data = $options[ 'state_data' ] ?? [];

            $trimmed_state_data = array_map(function($item) {
                return is_string($item) ? trim($item) : $item;
            }, $state_data);

            echo '<div id="state-order-fields">';
				$index = 0;
				foreach ( $trimmed_state_data as $data ) {
					echo '<div class="state-order-field-group">';

						$state_name = esc_attr( $data[ 'state_name' ] ?? '' );
						echo "<input required type='text' class='state-autocomplete' name='state_order_settings[state_data][$index][state_name]' placeholder='Write state...' value='$state_name'  />";

						// Minimum order input field
						$min_order = esc_attr( $data[ 'min_order' ] ?? '' );
						echo "<input required type='number' name='state_order_settings[state_data][$index][min_order]' value='$min_order' placeholder='Min order amount ($)' />";
						echo "<button type='button' class='remove-state-order-field-group'>Remove</button>";
					echo '</div>';
					$index++;
				}
			echo '</div>';
			echo '<button type="button" id="add-more-state">Add More</button>';
		}

		public static function enqueue_admin_scripts() {
            global $pagenow, $post;
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'custom-shipping-settings-script', plugin_dir_url( __FILE__ ) . '/../../assets/src/js/custom-shipping-settings.js', array( 'jquery', 'jquery-ui-autocomplete' ), null, true);

            if ($pagenow === 'post.php' && get_post_type($post) === 'shop_order') {
                wp_enqueue_script('add-order-line-validation', plugin_dir_url(__FILE__) . '/../../assets/src/js/add-order-line-validation.js', array('jquery'), null, true);
                wp_localize_script('add-order-line-validation', 'order_params', array(
                    'order_lines_limit' => defined('ORDER_MAX_ROWS_ALLOWED') ? ORDER_MAX_ROWS_ALLOWED : 200,
                ));
            }
			// Localize script for AJAX URL
			wp_localize_script( 'custom-shipping-settings-script', 'csSettings', array(
				'ajax_url' 	=> admin_url( 'admin-ajax.php' ),
				'nonce' 	=> wp_create_nonce( 'custom_shipping_nonce' ),
			) );
		}

        public static function cart_data_import() {
            if ( !isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'cart_data_import_nonce') ) {
                wp_send_json_error( array('message' => 'Nonce verification failed.', 'code' => 'nonce_error') );
            }

            if ( !isset($_POST['datatype']) || empty($_POST['datatype']) ) {
                wp_send_json_error( array('message' => 'Import type missing.') );
            }
            $warning_messages = array();
            $type = $_POST['datatype'];
            $order_data = array();
            if ( $type == 'file' ) {
                $file = isset( $_FILES['import_cart_xls_file'] ) ? $_FILES['import_cart_xls_file'] : null;
                if ( !$file || empty($file['name']) ) {
                    wp_send_json_error( array('message' => 'No file uploaded.', 'code' => 'no_file_error') );
                }

                $file_type = wp_check_filetype( $file['name'] );
                if ( !in_array($file_type['ext'], array('xls', 'xlsx')) ) {
                    wp_send_json_error( array('message' => 'Invalid file type. Please upload a valid XLS or XLSX file.', 'code' => 'invalid_file_type') );
                }
                $tmp_file_path = $file['tmp_name'];
                if ( !$tmp_file_path ) {
                    wp_send_json_error( array('message' => 'Failed to access uploaded file.', 'code' => 'file_access_error') );
                }

                $order_data = self::parse_imported_xls( $tmp_file_path, $warning_messages );

                if ( empty($order_data) ) {
                    wp_send_json_error( array('message' => 'Failed to parse the file data.', 'code' => 'file_parsing_error') );
                }
            } else if ( $type == 'copypaste' ) {
                if ( !isset($_POST['import_data']) || empty($_POST['import_data']) ) {
                    wp_send_json_error( array('message' => 'Order data missing.') );
                }

                $lines = preg_split( '/\r\n|\r|\n/', $_POST['import_data'] );
                foreach( $lines as $line ) {
                    $line = trim( preg_replace( '/\s+/', ' ', $line) );
                    $line_parts = explode( ' ', $line );
                    $order_data[] = [
                        'sku' => $line_parts[0] ?? '',
                        'quantity' => intval( $line_parts[1] ) ?? 0
                    ];
                }

                if ( empty($order_data) ) {
                    wp_send_json_error( array('message' => 'Failed to parse the data.', 'code' => 'copypaste_parsing_error') );
                }
            }

            $current_product_ids = array();
            $cart_items = WC()->cart->get_cart() ?: array();

            foreach ( $cart_items as $cart_item ) {
                $current_product_ids[] = $cart_item['product_id'];
            }

            $order_line_items_count = count( WC()->cart->get_cart() );
            $imported_count = 0;
            $imported_skus = [];
            foreach ( $order_data as $item ) {
                if ( $order_line_items_count + $imported_count >= self::$order_max_rows_allowed ) {
                    $warning_messages[] = '<p><b>Warning</b>: Only ' . self::$order_max_rows_allowed . ' valid items can be displayed in the Cart.</p>';
                    break;
                }

                $sku = isset( $item['sku'] ) ? sanitize_text_field( wp_unslash($item['sku']) ) : '';
                $quantity = $item['quantity'];
                $product_id = wc_get_product_id_by_sku( $sku );
                $product = wc_get_product($product_id);
                $data_validated = self::validate_parsed_quote_data( $sku, $product, $product_id, $current_product_ids, $quantity, $imported_skus );
                if ( $data_validated ) {
                    $cart_item_key = WC()->cart->generate_cart_id( $product_id );
                    if ( !$cart_item_key ) {
                        self::$skipped_sku_items['skus_failed'][] = $sku;
                        continue;
                    }
                    $cart_items[ $cart_item_key ] = [
                        'product_id' => $product_id,
                        'quantity'   => $quantity,
                        'variation_id' => 0,
                        'variation'   => [],
                        'data'          => $product,
                    ];
                    $imported_skus[]= $sku;
                    $imported_count++;
                }

            }
            WC()->cart->set_cart_contents( $cart_items );
            WC()->cart->calculate_totals();

            self::get_xls_to_cart_messages( $warning_messages );

            if ( !empty($warning_messages) ) {
                wc_add_notice( implode(' ', $warning_messages), 'error' );
            }

            wc_add_notice( 'Data processed successfully. ' . $imported_count . '/' . count($order_data) . ' products added to cart.' );
            wp_send_json_success();
        }

        public static function parse_imported_xls($file_path, &$warning_messages) {
            try {
                $spreadsheet = IOFactory::load($file_path);
                $worksheet = $spreadsheet->getActiveSheet();

                $parsed_data = array();
                $isFirstRow = true;
                $rowCount = 0;

                $maxRows = defined('CART_MAX_XLS_ROWS') ? CART_MAX_XLS_ROWS : 1000;
                foreach ($worksheet->getRowIterator() as $row) {
                    if ($isFirstRow) {
                        $isFirstRow = false;
                        continue;
                    }
                    if ($rowCount >= $maxRows) {
                        $warning_messages[] = '<p><b>Warning</b>: Processing the first ' . $maxRows . ' rows. Only ' . self::$order_max_rows_allowed . ' valid items can be displayed in the Cart.</p>';
                        break;
                    }
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);

                    $rowData = array();
                    foreach ($cellIterator as $cell) {
                        $value = $cell->getValue();
                        $rowData[] = sanitize_text_field($value);
                    }

                    if (empty($rowData[0])) {
                        break;
                    }

                    $parsed_data[] = array(
                        'sku' => $rowData[0],
                        'quantity' => intval($rowData[1]),
                    );
                    $rowCount++;
                }
                return $parsed_data;
            } catch (Exception $e) {
                return array();
            }
        }

        public static function validate_parsed_quote_data($sku, $product, $product_id, $current_product_ids, &$quantity, $imported_skus) {
            if ( ! $product_id ) {
                self::$skipped_sku_items['not_available_sku'][] = $sku;
                return false;
            }

            if ( $quantity <= 0 ) {
                self::$skipped_sku_items['empty_values'][] = $sku;
                return false;
            }

            if ( empty( $product ) || ! $product->is_purchasable() || 'trash' === $product->get_status()) {
                self::$skipped_sku_items['not_available_sku'][] = $sku;
                return false;
            }

            $min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
            if ( $quantity < $min_qty ) {
                self::$skipped_sku_items['skus_below_minimum'][] = $sku;
                return false;
            }

            if ( in_array($product_id, $current_product_ids) ) {
                self::$skipped_sku_items['exist_in_current_cart'][] = $sku;
                return false;
            }

            $product_step = intval( get_post_meta( $product_id, 'product_step', true ) );
            if ( $product_step > 1 && $quantity % $product_step != 0 ) {
                $quantity = ceil($quantity / $product_step) * $product_step;
                self::$skipped_sku_items['skus_step_quantity_up'][] = $sku;
            }

            if ( in_array( $sku, $imported_skus ) ) {
                self::$skipped_sku_items['duplicated_sku'][] = $sku;
                return false;
            }
            return true;
        }

        public static function get_xls_to_cart_messages( &$warning_messages ) {
            if (!empty(self::$skipped_sku_items['exist_in_current_cart'])) {
                $exist_in_current_cart_msg = '<p><b>Warning</b>: These SKUs are already added to cart: ' . implode(', ', self::$skipped_sku_items['exist_in_current_cart']) . '.</p>';
                $warning_messages[] = $exist_in_current_cart_msg;
            }
            if (!empty(self::$skipped_sku_items['not_available_sku'])) {
                $not_available_sku_msg = '<p><b>Warning</b>: There are no products with SKUs ' . implode(', ', self::$skipped_sku_items['not_available_sku']) . ' or products are not purchasable.</p>';
                $warning_messages[] = $not_available_sku_msg;
            }
            if (!empty(self::$skipped_sku_items['empty_values'])) {
                $empty_values_msg = '<p><b>Warning</b>: Quantity must be a positive value. Affected SKUs: ' . implode(', ', self::$skipped_sku_items['empty_values']) . '.</p>';
                $warning_messages[] = $empty_values_msg;
            }
            if (!empty(self::$skipped_sku_items['skus_below_minimum'])) {
                $skus_below_minimum_msg = '<p><b>Warning</b>: Quantity is below minimum for SKUs: ' . implode(', ', self::$skipped_sku_items['skus_below_minimum']) . '.</p>';
                $warning_messages[] = $skus_below_minimum_msg;
            }
            if (!empty(self::$skipped_sku_items['skus_step_quantity_up'])) {
                $skus_step_quantity_up_msg = '<p><b>Warning</b>: Quantity for SKUs ' . implode(', ', self::$skipped_sku_items['skus_step_quantity_up']) . ' was rounded up according to the next sales unit of measure.</p>';
                $warning_messages[] = $skus_step_quantity_up_msg;
            }
            if (!empty(self::$skipped_sku_items['skus_failed'])) {
                $skus_failed_msg = '<p><b>Warning</b>: Failed adding SKUs to cart: ' . implode(', ', self::$skipped_sku_items['skus_failed']) . '.</p>';
                $warning_messages[] = $skus_failed_msg;
            }
            if (!empty(self::$skipped_sku_items['duplicated_sku'])) {
                $skus_duplicated_msg = '<p><b>Warning</b>: Duplicated SKUs found in the file: ' . implode(', ', self::$skipped_sku_items['duplicated_sku']) . '.</p>';
                $warning_messages[] = $skus_duplicated_msg;
            }
        }

		public static function search_customers_callback() {
			check_ajax_referer( 'custom_shipping_nonce', 'nonce' );

			$term = isset( $_POST[ 'term' ] ) ? trim( wp_unslash( $_POST[ 'term' ] ) ) : '';

			$user_query = new WP_User_Query( array(
				'search'         => '*' . esc_attr( $term ) . '*',
				'search_columns' => array( 'user_login', 'user_nicename' ),
				'role' 			 => 'customer',
				'number' 		 => 20,
				'fields'         => array( 'ID', 'display_name' ),
			) );

			$results = array();
			foreach ( $user_query->get_results() as $user ) {
				$results[] = array(
					'label' => $user->display_name,
					'value' => $user->ID,
				);
			}

			wp_send_json( $results );
		}

		/**
		 * Changes the minimum order amounts for all customers on the custom shipping settings page.
		 *
		 * This function is called when the 'change_min_order_amounts_by_all_customers' action is triggered.
		 * It retrieves all customers with the 'customer' role and updates their minimum order amount to 250.
		 *
		 * @param WP_REST_Request $request The REST request object.
		 * @return void
		 */
		public static function change_free_shipping_min_order_amounts_by_all_customers($request ){
			$screen = ( !empty( $request[ 'pageSlug' ] ) ) ? $request[ 'pageSlug' ] : '';

			if( !empty( $screen ) && $screen == 'custom-shipping-settings' ){
				$user_query = new WP_User_Query( array(
					'role'   => 'customer',
					'fields' => 'ID',
				) );
				
				$customers = $user_query->get_results();
	
				if(!empty($customers)){
					foreach( $customers as $customer_id ) {
                        $min_order 	= self::get_customer_min_order_free_shipping_amounts( $customer_id );
                        if ($min_order) {
                            update_user_meta( $customer_id, 'min_order', $min_order );
                        }
					}
				}
			}
		}

		/**
		 * Retrieves the minimum free shipping order amount for a customer.
		 *
		 * This function retrieves the minimum free shipping order amount for a customer based on various settings and configurations.
		 *
		 * @param int $user_id The ID of the user/customer.
		 * @return float The minimum order amount for the customer.
		 */
		public static function get_customer_min_order_free_shipping_amounts( $user_id ) {
			if ( empty ( $user_id ) ) {
               return false;
            }
			$minimum_order_amount = get_option( 'custom_shipping_default_order_value', 250 );

			[ $minimum_order_amount, $is_amount_updated ] = self::get_customer_order_shipping_settings( $user_id, $minimum_order_amount );

			if ( ! $is_amount_updated ) {
				[ $minimum_order_amount, $is_amount_updated ] = self::get_suffix_prefix_order_shipping_settings( $user_id, $minimum_order_amount );
			}

			if ( ! $is_amount_updated ) {
				[ $minimum_order_amount, $is_amount_updated ] = self::get_state_order_shipping_settings( $user_id, $minimum_order_amount );
			}

			if ( ! $is_amount_updated ) {
				$minimum_order_amount = self::get_city_order_shipping_settings( $user_id, $minimum_order_amount );
			}

			return $minimum_order_amount;
		}

		/**
		 * Filters the WooCommerce package rates based on the minimum order amount.
		 *
		 * @param array $rates    The array of shipping rates.
		 * @param array $package  The package details.
		 * @return array          The filtered array of shipping rates.
		 */
		public static function filter_woocommerce_package_rates( $rates, $package ) {
			$minimum_order_amount 	= 250;

			if ( is_user_logged_in() ) {
				$user_id 				= get_current_user_id();
				$minimum_order_amount 	= get_user_meta( $user_id, 'min_order', true );
			}

			if ( $package[ 'cart_subtotal' ] <= $minimum_order_amount ) {
				foreach ( $rates as $rate_index => $rate ) {
					if ( $rate->get_label() == 6173 ) {
						$method_settings = get_option( 'woocommerce_' . $rate->get_method_id() . '_' . $rate->get_instance_id() . '_settings', array() );
						if ( array_key_exists( 'title_override', $method_settings ) && $method_settings[ 'title_override' ] == 'Free Standard Shipping' ) {
							unset( $rates[ $rate_index ] );
						}
					}
				}
			}
			return $rates;
		}


		protected static function get_custom_order_statuses() {
			$statuses = array(
				'wc-pending-approval' 	=> 'Pending Approval',
				'wc-pending-billing' 	=> 'Pending Billing',
				'wc-pending-fulfill' 	=> 'Pending Fulfillment',
				'wc-partially-fulfill' 	=> 'Partially Fulfilled'
			);
			return $statuses;
		}


		public static function register_new_order_statuses() {
			foreach ( self::get_custom_order_statuses() as $k => $v ) {
				register_post_status( $k, array(
					'label'                     => $v,
					'public'                    => true,
					'show_in_admin_status_list' => true,
					'show_in_admin_all_list'    => true,
					'exclude_from_search'       => false,
					'label_count'               => _n_noop( $v . ' <span class="count">(%s)</span>', $v . ' <span class="count">(%s)</span>' )
				) );
			}
		}


		public static function filter_wc_order_statuses( $order_statuses ) {
			$new_order_statuses = array();
			foreach ( $order_statuses as $key => $status ) {
				$new_order_statuses[ $key ] = $status;
				if ( 'wc-processing' === $key ) {
					foreach ( self::get_custom_order_statuses() as $k => $v ) {
						$new_order_statuses[ $k ] = $v;
					}
				}
			}
			return $new_order_statuses;
		}


		public static function filter_wc_email_headers( $header, $email_id, $object, $email ) {
			if ( ! empty( $email ) && is_object( $email ) && method_exists( $email, 'is_customer_email' ) && $email->is_customer_email() ) {
				$cc_addresses = get_post_meta( $object->get_id(), 'af_c_f_5037400', true );
				$cc_addresses = array_filter( array_map( 'trim', explode( ',', $cc_addresses ) ), function( $n ) { return ! empty( $n ); } );
				foreach ( $cc_addresses as $cc_address ) {
					$header .= 'Cc: ' . $cc_address. "\r\n";
				}
			}
			return $header;
		}


		public static function filter_pre_wp_mail( $null_to_send, $atts ) {

			$disable_for_emails = array(
				'atrisket@imarkgroup.com'
			);

			if ( isset( $atts['to'] ) ) {
				$to = ! is_array( $atts['to'] ) ? array_map( 'trim', explode( ',', $atts['to'] ) ) : $atts['to'];
				if ( count( $to ) == 1 && in_array( $to[0], $disable_for_emails ) ) {
					$null_to_send = false;
				}
			}

			return $null_to_send;
		}


		public static function filter_wc_cart_product_price( $product_price, $product ) {
			$product_price = wc_get_price_excluding_tax( $product );

			$price_qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
			$price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
			// if ( ! in_array( get_current_user_id(), array( 2, 10236, 10445, 10446, 3125 ) ) ) $price_qty_multiplier = 1;

			$product_price *= $price_qty_multiplier;

			return wc_price( $product_price );
		}

		public static function filter_wc_remove_price_offer_from_markup ( $markup ) {
			$markup = array();
			return $markup;
		} 


		public static function filter_wc_cart_product_subtotal( $product_subtotal, $product, $quantity, $cart ) {

			$price_qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
			$price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
			// if ( ! in_array( get_current_user_id(), array( 2, 10236, 10445, 10446, 3125 ) ) ) $price_qty_multiplier = 1;

			$price = $product->get_price();
			$row_price = $price * $quantity / $price_qty_multiplier;
			$product_subtotal = wc_price( $row_price );

			return $product_subtotal;
		}

		public static function remove_order_columns( $columns ) {
			if ( isset( $columns[ 'origin' ] ) ) {
				unset( $columns[ 'origin' ] );
			}

			return $columns;
		}

		/**
		 * Adds custom user profile fields for customers.
		 *
		 * This function is responsible for adding custom user profile fields for customers.
		 * It checks if the user has the 'customer' role and retrieves the minimum order value
		 * from the user meta. If the minimum order value is empty or zero, it sets it to the
		 * default order amount retrieved from the options. It then displays the minimum order
		 * value in the user profile form.
		 *
		 * @param WP_User $user The user object.
		 * @return void
		 */
		public static function add_custom_user_profile_fields( $user ) {
			if ( in_array( 'customer', $user->roles ) ) {
				$min_order 			  = get_user_meta( $user->ID, 'min_order', true );
				$default_order_amount = get_option( 'custom_shipping_default_order_value' ) ?? 250;
				$default_order_amount = esc_attr( $default_order_amount );
			
				if( empty( $min_order ) || $min_order == 0 ){
					$min_order = $default_order_amount;
				}
				?>
				<table class="form-table">
					<tr>
						<th>
							<label for="min_order">
								<?php _e( 'Minimum Order: ' ); ?>
							</label>
						</th>
						<td>$<?= esc_attr( $min_order ); ?><br />
							<span class="description">
								<?php _e( 'Free shipping Min. Order Amount' ) ?>
							</span>
						</td>
					</tr>
				</table>
				<?php
			}
		}

		/**
		 * Registers a REST API route to apply changes to all customers.
		 *
		 * @return void
		 */
		public static function register_rest_api_apply_changes_to_all_customers(): void
		{
			//path= /wp-json/custom-shipping-settings/v2/apply-changes-to-all-customers?pageSlug=custom-shipping-settings
			register_rest_route( 'custom-shipping-settings/v2', 'apply-changes-to-all-customers', [
				'methods' => 'GET',
				'callback' => array( __CLASS__, 'change_free_shipping_min_order_amounts_by_all_customers'),
				'args' => [
                    'pageSlug' => [ 'custom-shipping-settings' ],
					'data' => [ ],
                ],
			] );
		}

        public static function get_usa_and_canada_states_lists(): array {
            $countries_obj = new WC_Countries();
            $usa_states = $countries_obj->get_states('US');
            $canada_states = $countries_obj->get_states('CA');

            [$usa_states_in_string] = self::get_states_list($usa_states);
            [$canada_states_in_string] = self::get_states_list($canada_states);
            return array($usa_states_in_string, $canada_states_in_string);
        }

        public static function get_states_list(bool|array $states): array {
            $states_in_string = '';
            $states_keys = array_keys($states);
            $last_key = end($states_keys);

            foreach ($states_keys as $state) {
                    $separator = $state == $last_key ? '' : ', ';
                    $states_in_string .= $state . $separator;
            }
            return array($states_in_string);
        }

		protected static function get_suffix_prefix_order_shipping_settings( int $user_id, mixed $minimum_order_amount ) {
			$is_amount_updated = FALSE;
            $suffix_prefix_order_settings = get_option( 'suffix_prefix_order_settings' );
			if ( ! empty( $suffix_prefix_order_settings ) ) {
				$suffix_prefix_user_data = $suffix_prefix_order_settings['suffix_prefix_data'] ?? [];
                $user_name = get_user_meta($user_id, 'nickname', true);
				if ( ! $user_name) {
					return array( $minimum_order_amount, FALSE );
				}

				foreach ( $suffix_prefix_user_data as $data ) {
					if ( ( ! empty( $data['name-prefix'] ) || ! empty( $data['name-suffix'] ))
                        && ! empty( $data['min_order'] )
                        && self::is_user_nickname_match_with_keywords( $user_name, $data['name-prefix'], $data['name-suffix'] )
                    ) {
						$minimum_order_amount = $data['min_order'];
						$is_amount_updated = TRUE;
					}
				}
			}
			return array( $minimum_order_amount, $is_amount_updated );
		}

		protected static function get_state_order_shipping_settings( int $user_id, mixed $minimum_order_amount ) {
			$is_amount_updated = FALSE;
            $state_order_settings = get_option( 'state_order_settings' );
			if ( ! empty( $state_order_settings ) ) {
				$state_order_data = $state_order_settings['state_data'] ?? [];
				$user_state = get_user_meta( $user_id, 'shipping_state', TRUE );
				foreach ( $state_order_data as $data_state ) {
					if ( ! empty( $data_state['state_name'] ) ) {
						$arr_state = explode( ', ', $data_state['state_name'] );

						foreach ( $arr_state as $state ) {
							if ( ! empty( $state ) && ! empty( $data_state['min_order'] ) && $state == $user_state ) {
								$minimum_order_amount = $data_state['min_order'];
								$is_amount_updated = TRUE;
							}
						}
					}
				}
			}
			return array( $minimum_order_amount, $is_amount_updated );
		}

		protected static function get_city_order_shipping_settings( int $user_id, mixed $minimum_order_amount ) {
			$city_order_settings = get_option( 'city_order_settings' );
			if ( ! empty( $city_order_settings ) ) {
				$city_order_data = $city_order_settings['city_data'] ?? [];
				$user_city = get_user_meta( $user_id, 'shipping_city', TRUE );
				foreach ( $city_order_data as $data_city ) {
					if ( ! empty( $data_city['city_name'] ) && ! empty( $data_city['min_order'] ) && $user_city == $data_city['city_name'] ) {
						$minimum_order_amount = $data_city['min_order'];
					}
				}
			}
			return $minimum_order_amount;
		}

		protected static function get_customer_order_shipping_settings( int $user_id, mixed $minimum_order_amount ) {
			$is_amount_updated = FALSE;
            $custom_shipping_settings = get_option( 'custom_shipping_settings' );
			if ( ! empty( $custom_shipping_settings ) ) {
				$user_data = $custom_shipping_settings['user_data'] ?? [];

				foreach ( $user_data as $config ) {
					if ( isset( $config['user_id'] ) && isset( $config['min_order'] ) && $config['user_id'] == $user_id ) {
						$minimum_order_amount = $config['min_order'];
						$is_amount_updated = TRUE;
					}
				}
			}
			return array( $minimum_order_amount, $is_amount_updated );
		}

        public static function filter_woocommerce_email_recipient( $recipient, $order, $email ) {
            if ( $order && is_a( $order, 'WC_Order' ) && in_array( get_post_meta($order->get_id(), 'ns_order_type', true), [2,4] ) ) {
                $recipient = '';
            }
            return $recipient;
        }

        protected static function is_user_nickname_match_with_keywords($user_name, $prefix = '', $suffix = '') {
			$prefix_defined = ! empty( $prefix );
			$suffix_defined = ! empty( $suffix );
            $has_prefix = $prefix_defined && str_starts_with( strtolower(trim($user_name)), strtolower(trim($prefix)) );
			$has_suffix = $suffix_defined && str_ends_with( strtolower(trim($user_name)), strtolower(trim($suffix)) );

			if ($prefix_defined && $suffix_defined) {
				return $has_prefix && $has_suffix;
			}

			if ($prefix_defined) {
				return $has_prefix;
			}

			if ($suffix_defined) {
				return $has_suffix;
			}

			return FALSE;
		}

        public static function suffix_prefix_sanitize( $options ) {
            if ( ! empty( $options['suffix_prefix_data'] ) ) {
                $values_to_esc = array(
                        'name-prefix',
                        'name-suffix',
                    );

                foreach ( $options['suffix_prefix_data'] as &$suffix_prefix_data ) {
                    foreach ( $suffix_prefix_data as $key => $data ) {
                        if ( in_array( $key, $values_to_esc ) ) {
                            $suffix_prefix_data[$key] = esc_attr( $data );
                        }
                    }
                }
            }

			return $options;
        }

        public static function prevent_address_update_to_db_from_checkout_form(WC_Customer $customer, $data ) {

            $changes = $customer->get_changes();

            $billing_changes = array_filter(array_keys($changes), fn($key) => str_starts_with($key, 'billing'));
            $shipping_changes = array_filter(array_keys($changes), fn($key) => str_starts_with($key, 'shipping'));

            if ($billing_changes && $shipping_changes) {
                $shipping = $customer->get_data()['shipping'];
                $billing = $customer->get_data()['billing'];
                self::set_initial_db_address($customer, $shipping, 'shipping');
                self::set_initial_db_address($customer, $billing, 'billing');
            } elseif ($billing_changes) {
                $billing = $customer->get_data()['billing'];
                self::set_initial_db_address($customer, $billing, 'billing');
            } elseif ($shipping_changes) {
                $shipping = $customer->get_data()['shipping'];
                self::set_initial_db_address($customer, $shipping,  'shipping');
            }
        }

        protected static function set_initial_db_address(WC_Customer $customer, mixed $init_address, $type_of_address): void {
            if (empty($init_address) ||  is_null($type_of_address)) {
                return;
            }
            if ( $type_of_address == 'shipping') {
                $customer->set_shipping_location($init_address['country'], $init_address['state'], $init_address['postcode'], $init_address['city']);
                $customer->set_shipping_address_1($init_address['address_1']);
                $customer->set_shipping_address_2($init_address['address_2']);
                $customer->set_shipping_company($init_address['company']);
                $customer->set_shipping_first_name($init_address['first_name']);
                $customer->set_shipping_last_name($init_address['last_name']);
                $customer->set_shipping_phone($init_address['phone']);
            } elseif ($type_of_address == 'billing') {
                $customer->set_billing_location($init_address['country'], $init_address['state'], $init_address['postcode'], $init_address['city']);
                $customer->set_billing_address_1($init_address['address_1']);
                $customer->set_billing_address_2($init_address['address_2']);
                $customer->set_billing_company($init_address['company']);
                $customer->set_billing_first_name($init_address['first_name']);
                $customer->set_billing_last_name($init_address['last_name']);
                $customer->set_billing_phone($init_address['phone']);
            }
        }

        public static function limit_cart_items_count($passed, $product_id) {
            $cart_limit = defined('ORDER_MAX_ROWS_ALLOWED') ? ORDER_MAX_ROWS_ALLOWED : 200;
            $line_items_count = count(WC()->cart->get_cart());
            if ( $line_items_count >= $cart_limit ) {
                wc_add_notice( sprintf( 'You can only add up to %d different SKUs to your cart.', $cart_limit ), 'error' );
                return false;
            }

            return $passed;
        }

        public static function limit_order_items_count($validation_error, $product, $order, $qty) {
            $order_limit = defined('ORDER_MAX_ROWS_ALLOWED') ? ORDER_MAX_ROWS_ALLOWED : 200;
            $line_items_count = count($order->get_items());

            if ( $line_items_count >= $order_limit ) {
                $validation_error->add( 'order_item_limit', sprintf( __( 'You can only add up to %d different SKUs to the order.', 'woocommerce' ), $order_limit ) );
            }

            return $validation_error;
        }

        public static function disable_ns_sourced_order_fields_editing() {
            global $pagenow;

            if ( $pagenow != 'post.php' || get_post_type($_GET['post']) != 'shop_order' ) {
                return;
            }

            $ns_order_id = get_post_meta( get_the_id(), 'ns_order_internal_id', true );
            if ( $ns_order_id ) {
                ?>
                <script>
                    jQuery(document).ready(function($) {
                        $('.order_data_column_container input, .order_data_column_container .select2, .order_data_column_container a.edit_address')
                            .css('pointer-events', 'none');
                        $('.edit_address').css('display', 'none');
                        $('.order_data_column_container .date-picker').attr('disabled', 'disabled').attr('readonly', 'readonly');
                        $('.order_data_column_container input').attr('readonly', 'readonly');
                        $('#customer_user, #order_status').select2({disabled:'readonly'});
                    });
                </script>
                <?php
            }
        }

        public static function get_order_pdf_document() {
            $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
            $nonce = isset($_POST['security']) ? $_POST['security'] : '';

            if ( ! $order_id || ! wp_verify_nonce( $nonce, 'order_documents_nonce_' . $order_id ) ) {
                header('Content-Type: application/json');
                echo json_encode(array('message' => 'Unauthorized request'));
                exit;
            }

            add_filter('woocommerce_order_formatted_billing_address', array( __CLASS__, 'unset_first_last_name' ), 10, 2);
            add_filter('woocommerce_order_formatted_shipping_address', array( __CLASS__, 'unset_first_last_name' ), 10, 2);

            $order_data = self::get_order_template_data( $order_id );
            if ( ! empty($_POST['invoice_tran_id']) ) {
                $invoice_tran_id = sanitize_text_field($_POST['invoice_tran_id']);
                $order_invoices = maybe_unserialize( get_post_meta( $order_id, 'ns_invoice_tran_ids', true ) );
                $order_invoices = is_array( $order_invoices ) ? $order_invoices : array();
                if ( ! in_array( $invoice_tran_id, $order_invoices ) ) {
                    header('Content-Type: application/json');
                    echo json_encode(array('message' => 'Unauthorized request'));
                    exit;
                }
                $invoice_data = self::get_invoice_data( $invoice_tran_id );
                $document_html = self::get_invoice_document_template( $order_id, $order_data, $invoice_tran_id, $invoice_data );
            } else {
                $document_html = self::get_order_document_template( $order_id, $order_data );
            }

            remove_filter( 'woocommerce_order_formatted_billing_address', array( __CLASS__, 'unset_first_last_name' ), 10 );
            remove_filter( 'woocommerce_order_formatted_shipping_address', array( __CLASS__, 'unset_first_last_name' ), 10 );

            $options = new Options();
            $options->set('isRemoteEnabled', true);
            $options->set('isHtml5ParserEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($document_html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf_output = $dompdf->output();
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="order-' . $order_id . '.pdf"');
            header('Content-Length: ' . strlen($pdf_output));

            echo $pdf_output;
            wp_die();
        }

        public static function unset_first_last_name ($address, $order) {
            if (!is_array($address)) {
                return $address;
            }

            unset($address['first_name']);
            unset($address['last_name']);

            return $address;
        }

        protected static function get_order_document_template( $order_id, $order_data ) {
            ob_start();
            wc_get_template(
                'order-document.php',
                array(
                    'order_id' => $order_id,
                    'order_data' => $order_data,
                ),
                '/woocommerce/order/',
                plugin_dir_path( __FILE__ ) . '../templates/'
            );
            $html = ob_get_clean();
            return $html;
        }

        protected static function get_invoice_document_template( $order_id, $order_data, $invoice_tran_id, $invoice_data ) {
            ob_start();
            wc_get_template(
                'invoice-document.php',
                array(
                    'order_id' => $order_id,
                    'order_data' => $order_data,
                    'invoice_tran_id' => $invoice_tran_id,
                    'invoice_data' => $invoice_data,
                ),
                '/woocommerce/order/',
                plugin_dir_path( __FILE__ ) . '../templates/'
            );
            $html = ob_get_clean();
            return $html;
        }

        protected static function get_order_template_data( $order_id ) {
            $order = wc_get_order( $order_id );
            $order_meta = get_post_meta( $order_id );
            $subsidiary_email = $order_meta['ns_order_subsidiary_email'][0] ?? '';
            $customer_name = $division_name = '';
            $user_id = $order->get_user_id();
            if ( $user_id ) {
                $user_info = get_userdata($user_id);
                $ns_customer_entity_id = get_user_meta($user_id, 'ns_customer_entity_id', true);
                $customer_name = $ns_customer_entity_id . ' ' . $user_info->display_name;
                $ns_parent_customer_id = $order_meta['ns_parent_customer_id'][0] ?? '';
                if ( ! empty( $ns_parent_customer_id ) ) {
                    $users = get_users(
                        array(
                            'meta_key' => 'ns_customer_internal_id',
                            'meta_value' => $ns_parent_customer_id
                        )
                    );

                    if ( ! empty( $users ) ) {
                        $customer_name = $ns_customer_entity_id . ' ' . $users[0]->display_name . ' : ' . $user_info->display_name;
                    }
                }
                $division_name = get_user_meta( $user_id, 'ns_division_name', true );
                if ( $division_name === 'Electrical') {
                    $subsidiary_email = get_option( 'subsidiary_settings_email', "AR@nsiindustries.com" );
                }
            }
            $countries = WC()->countries->get_countries();
            $billling_country_name = $order->get_billing_country();
            $shipping_country_name = $order->get_shipping_country();
            $billling_country_name = trim(preg_replace('/\s*\(.*\)$/', '', $countries[$billling_country_name] ?? ''));
            $shipping_country_name = trim(preg_replace('/\s*\(.*\)$/', '', $countries[$shipping_country_name] ?? ''));
            $billing_address = ! empty($order_meta['doc_billing_address'][0]) ? nl2br($order_meta['doc_billing_address'][0]) : $order->get_formatted_billing_address() . '<br/>' . $billling_country_name;
            $shipping_address = ! empty($order_meta['doc_shipping_address'][0]) ? nl2br($order_meta['doc_shipping_address'][0]) : $order->get_formatted_shipping_address() . '<br/>' . $shipping_country_name;
            $order_items_details = maybe_unserialize( $order_meta['order_items_data'][0] ?? '' );
            $order_data = array(
                'order_id' => $order_id,
                'order' => $order,
                'order_tran_id' => $order_meta['ns_order_tran_id'][0] ?? '',
                'customer_name' => $customer_name,
                'division_name' => $division_name,
                'subsidiary_email' => $subsidiary_email,
                'subsidiary_name' => $order_meta['ns_order_subsidiary_name'][0] ?? 'NSI Industries, LLC',
                'partner'=> $order_meta['ns_order_partner_name'][0] ?? '',
                'billing_address' => $billing_address,
                'shipping_address' => $shipping_address,
                'customer_po' => $order_meta['af_c_f_4432739'][0] ?? '',
                'shipping_carrier' => $order_meta['ns_order_shipping_courier'][0] ?? '',
                'terms_id' => $order_meta['ns_order_terms_id'][0] ?? '',
                'terms' => $order_meta['ns_order_terms'][0] ?? '',
                'tracking_no' => str_replace(',', ', ', $order_meta['ns_tracking_number'][0] ?? ''),
                'order_items_details' => $order_items_details,
            );
            if ( ! empty( $order->get_total_discount() ) ) {
                $order_data['discount_label'] = $order_meta['ns_promo_code_label'][0] ?? '';
                $order_data['total_discount'] = '( ' . wc_price( $order->get_total_discount() ) . ' )';
            }
            return $order_data;
        }

        protected static function get_invoice_data($invoice_tran_id) {
            global $wpdb;

            $table_name = $wpdb->prefix . 'tm_ns_invoices_data';
            $invoice_data = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE tran_id = %s", $invoice_tran_id ), ARRAY_A );
            return $invoice_data;
        }

        public static function add_order_sync_in_progress($order_sync_status, $order_data) {
            $order_id = $order_data['order_id'];
            if ( get_post_meta( $order_id, 'add_order_sync_in_progress', true ) === 'yes' ) {
                return false;
            }

            update_post_meta( $order_id, 'add_order_sync_in_progress', 'yes' );
            return $order_sync_status;
        }

    }
}
