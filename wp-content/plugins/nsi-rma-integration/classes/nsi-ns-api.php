<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\SEARCHENUMMULTISELECTFIELDOPERATOR;
use NetSuite\Classes\SearchMultiSelectField;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\TransactionSearchBasic;
use NetSuite\NetSuiteService;

if ( ! class_exists( 'NSI_NS_API' ) ) {

    class NSI_NS_API {
        public static bool $init = false;
        public static string $ns_returns_update_fetch_from_netsuite_search_id;
        public static string $tm_ns_fetch_returns_updates_table_name;
        public static int $cron_fetch_ns_returns_updates_timeout = 300;
        protected static $ns_returns_updates_import_bg_process = null;
        public static int $ns_sync_page_to_dispatch_bg_process = 3;


        public static function init() {
            if ( self::$init ) {
                return true;
            }

            global $wpdb;
            self::$tm_ns_fetch_returns_updates_table_name = $wpdb->prefix . 'tm_ns_fetch_returns_updates';

            if ( defined( 'NS_RETURNS_UPDATE_FETCH_FROM_NETSUITE_SEARCH_ID' ) ) {
                self::$ns_returns_update_fetch_from_netsuite_search_id = NS_RETURNS_UPDATE_FETCH_FROM_NETSUITE_SEARCH_ID;
            }
            if ( defined( 'CRON_FETCH_NS_ORDERS_UPDATES_TIMEOUT' ) ) {
                self::$cron_fetch_ns_returns_updates_timeout = CRON_FETCH_NS_ORDERS_UPDATES_TIMEOUT;
            }

            add_action( 'init', array( __CLASS__, 'setup_tm_ns_fetch_returns_updates_table' ), 10 );
            add_action( 'init', array( __CLASS__, 'init_ns_to_woo_returns_sync' ) );
            add_action( 'tm_ns_fetch_returns_updates_action', array( __CLASS__, 'cron_fetch_returns_updates' ), 10, 2 );
            add_action( 'woocommerce_loaded', array( __CLASS__, 'init_ns_fetch_returns_updates_bg_process' ), 1000 );

            add_action( 'wp_ajax_nsi_rma_retry_ns_sync', array( __CLASS__, 'retry_ns_sync' ) );
            add_action( 'wp_ajax_nsi_rma_get_return_document', array( __CLASS__, 'get_return_document' ) );
        }

        public static function send_return_to_ns( $wc_return_id ) {
            global $TMWNI_OPTIONS;
            $file_name = self::prepare_log_file('/create-returns-', 'create-returns');
            $datetime = date( 'Y-m-d H:i:s' );
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
                'base_uri' => $TMWNI_OPTIONS['ns_host'] . '/',
                'handler' => $stack
            ]);

            $return_post_meta = get_post_meta( $wc_return_id );
            $order_id = $return_post_meta['order_id'][0] ?? '';
            $order = wc_get_order( $order_id );
            if( !$order ) {
                $log_file_content = '[' . $datetime . '] WC Order ID not found.' . PHP_EOL;
                file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
                update_post_meta( $wc_return_id, 'ns_rma_api_error', 'WC Order ID not found.' );
                return false;
            }
            $order_items = $order->get_items();
            $return_items = maybe_unserialize( $return_post_meta['items'][0] ) ?? array();
            $return_reason = $return_post_meta['order_return_reason'][0] ?? '';
            $customer_note = $return_post_meta['customer_note'][0] ?? '';
            $ns_order_internal_id = get_post_meta( $order_id, 'ns_order_internal_id', true );

            $order_customer = $order->get_customer_id();
            $customer_ns_internal_id = get_user_meta( $order_customer, 'ns_customer_internal_id', true );
            $items = array( 'items' => array() );

            $items_positions = self::get_items_line_positions_in_order( $ns_order_internal_id );

            foreach( $order_items as $item_id => $item ) {
                if ( !array_key_exists($item_id, $return_items) ) {
                    continue;
                }

                $item_ns_id = get_post_meta ( $item->get_product_id(), 'ns_product_internal_id', true );
                $item_position = $items_positions[$item_ns_id] ?? 0;
                $items['items'] []= array(
                    'item' => array( 'id' => $item_ns_id ),
                    'quantity' => $return_items[$item_id]['qty'],
                    'rate' => $return_items[$item_id]['rate'],
                    'orderDoc' => array( 'id' => $ns_order_internal_id ),
                    'orderLine' => $item_position,
                    'custcol_atlas_rc_so' => array( 'id' => $return_reason ),
                    'custcol_sps_ccg_noteinformationfield' => $customer_note
                );
            }

            $data = array(
                'entity' => array( 'id' => $customer_ns_internal_id ),
                'orderId' => array( 'id' => $ns_order_internal_id ),
                'custbody3' => array( 'id' => $return_reason ),
                'item' => $items,
                'custbody_nsi_woo_comm_id' => $wc_return_id,
                'externalId' => $wc_return_id,
            );
            if ( defined('NS_RMA_SYNC_SENT_PAYLOAD_ENABLED') && NS_RMA_SYNC_SENT_PAYLOAD_ENABLED ) {
                $log_file_content = '[' . $datetime . '] Return request data to be sent: ' . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
            } else {
                $log_file_content = '';
            }

            try {
                $res = $client->post( "services/rest/record/v1/salesOrder/$ns_order_internal_id/!transform/returnAuthorization?replace=item", array(
                    'auth' => 'oauth',
                    'headers' => array(
                        'Content-type' => 'application/json'
                    ),
                    'json' => $data
                ) );

                $header_location = $res->getHeader('Location');
                $header_location_parts = explode( '/', $header_location[0] );
                $netsuite_return_id = end( $header_location_parts );
                if ( empty($netsuite_return_id) ) {
                    $log_file_content .= '[' . $datetime . '] Missing NetSuite RMA ID.' . PHP_EOL;
                    file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
                    update_post_meta( $wc_return_id, 'ns_rma_api_error', 'Missing NetSuite RMA ID.' );
                    return false;
                }

                update_post_meta( $wc_return_id, 'ns_return_internal_id', $netsuite_return_id );
                wp_update_post([
                    'ID'           => $wc_return_id,
                    'post_excerpt' => 'Return Confirmation#: ' . $netsuite_return_id,
                ]);

                $is_error = get_post_meta( $wc_return_id, 'ns_rma_api_error', true );
                if ( !empty($is_error) ) {
                    update_post_meta( $wc_return_id, 'ns_rma_api_error', '' );
                }
                $log_file_content .= '[' . $datetime . '] RMA ' . $wc_return_id . ' synced to NetSuite (ID: ' . $netsuite_return_id . ').' . PHP_EOL;
                file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
                return true;
            } catch( Exception $e ) {
                $error = $e->getMessage();
                update_post_meta( $wc_return_id, 'ns_rma_api_error', $error );
                $log_file_content .= '[' . $datetime . '] There was an error during RMA sync to Netsuite: ' . $error . PHP_EOL;
                file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
                return false;
            }
        }

        public static function setup_tm_ns_fetch_returns_updates_table() {
            if( !get_option( 'tm_ns_fetch_returns_updates_table_created' ) ) {
                self::create_tm_ns_fetch_returns_updates_table();
                update_option( 'tm_ns_fetch_returns_updates_table_created', true );
            }
        }

        public static function create_tm_ns_fetch_returns_updates_table(){
            global $wpdb;
            $table_name = self::$tm_ns_fetch_returns_updates_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				ns_return_id VARCHAR(255) NOT NULL,
				ns_return_data LONGTEXT NOT NULL,
				fetch_date DATETIME NOT NULL,
				PRIMARY KEY  (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function init_ns_to_woo_returns_sync() {
            $args = array( 1, '' );
            if ( defined('NS_RETURNS_UPDATE_FETCH_FROM_NETSUITE_ENABLED') && NS_RETURNS_UPDATE_FETCH_FROM_NETSUITE_ENABLED ) {
                if ( ! as_next_scheduled_action( 'tm_ns_fetch_returns_updates_action', $args ) ) {
                    as_schedule_recurring_action( time(), MINUTE_IN_SECONDS * 30, 'tm_ns_fetch_returns_updates_action', $args );
                }
            } else {
                if ( as_next_scheduled_action( 'tm_ns_fetch_returns_updates_action', $args ) ) {
                    as_unschedule_all_actions( 'tm_ns_fetch_returns_updates_action', $args );
                }
            }
        }

        public static function init_ns_fetch_returns_updates_bg_process() {
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                include( dirname( __FILE__ ) . '/nsi-returns-updates-import.php' );
                self::$ns_returns_updates_import_bg_process = new NS_Returns_Updates_Import();
            }
        }

        public static function cron_fetch_returns_updates( $page = 1, $search_id = '' ) {
            $transient_key = 'cron_fetch_ns_returns_updates';
            $search_type = 'returns_update';
            $hook = 'tm_ns_fetch_returns_updates_action';
            if ( $page == 1 ) {
                if ( get_transient( $transient_key ) ) {
                    return;
                }
                update_option( 'ns_sync_max_pages_limit_' . $search_type, 1, false );
            }
            set_transient($transient_key, true, self::$cron_fetch_ns_returns_updates_timeout);
            $return_updates = array();
            $date 	        = date( "Y-m-d" );
            $datetime = date( "Y-m-d H:i:s" );
            $log_file_content = '';
            $file_name = Crown_Shop_Orders::create_ns_sync_log_file( 'fetch-return-updates-' . $date . '.log', 'fetch-return-updates' );
            file_put_contents( $file_name, '[' . $datetime . '] Start fetch of NS Return updates ( page ' . $page . ' )' . PHP_EOL, FILE_APPEND );
            if ( $page == 1 ) {
                $return_updates = Crown_Shop_Orders::get_items_records_from_ns( $log_file_content, $hook, $search_type );
            } elseif ( $page > 1 && ! empty( $search_id ) ) {
                $return_updates = Crown_Shop_Orders::get_paged_items_records_from_ns( $search_type, $hook, $search_id, $page, $log_file_content );
            }
            if ( !empty( $return_updates ) ) {
                $fetched_returns_data = $fetched_ids = $placeholders = $returns_to_clear = array();
                foreach ( $return_updates as $return_item ) {
                    $ns_return_id = $return_item['basic']['internalId'][0]->searchValue->internalId;

                    if ( empty( $ns_return_id ) || in_array($ns_return_id, $returns_to_clear) ) {
                        continue;
                    }

                    if ( ! in_array($ns_return_id, $fetched_ids) && empty( self::check_if_ns_return_exists( $ns_return_id ) ) ) {
                        $log_file_content .= 'NS Return ID not found: ' . $ns_return_id . ', skipping' . PHP_EOL;
                        $returns_to_clear[] = $ns_return_id;
                        continue;
                    }

                    $placeholders[$ns_return_id][] = "(%s, %s, %s)";
                    $fetched_returns_data[$ns_return_id][] = $ns_return_id;
                    $fetched_returns_data[$ns_return_id][] = maybe_serialize( $return_item );
                    $fetched_returns_data[$ns_return_id][] = date( 'Y-m-d H:i:s' );
                    if ( !in_array($ns_return_id, $fetched_ids) ) {
                        $log_file_content .= 'Fetched NS Return ID: ' . $ns_return_id . PHP_EOL;
                        $fetched_ids[] = $ns_return_id;
                    }
                }

                foreach ( $returns_to_clear as $ns_return_id ) {
                    Crown_Order_Types::update_ns_order_custbody_values( $ns_return_id, null, FALSE, null, 'return_authorization' );
                }

                $placeholders = array_merge( ...array_values($placeholders) );
                $fetched_returns_data = array_merge( ...array_values($fetched_returns_data) );
                if ( ! empty($fetched_returns_data) && !empty($fetched_ids) ) {
                    self::insert_item_to_fetch_returns_updates_table( $fetched_returns_data, $placeholders );
                    $queued_items = self::get_return_ids_already_in_process_queue();
                    $ids_to_queue = array_diff($fetched_ids, $queued_items);
                    if ( !empty($ids_to_queue) ) {
                        foreach ( $ids_to_queue as $id_to_queue ) {
                            self::$ns_returns_updates_import_bg_process->push_to_queue( $id_to_queue );
                        }
                        self::$ns_returns_updates_import_bg_process->save();
                    } else {
                        $log_file_content .= 'Updates fetched. All returns were already added to queue.' . PHP_EOL;
                    }
                }
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            } else {
                $log_file_content .= 'No updates found.' . PHP_EOL;
                file_put_contents( $file_name, $log_file_content, FILE_APPEND );
            }
            self::dispatch_returns_sync_bg_process( $page, $file_name );
            file_put_contents( $file_name, 'Fetch finished ( page ' . $page . ' ).' . PHP_EOL . PHP_EOL, FILE_APPEND );
        }

        protected static function check_if_ns_return_exists( $ns_return_id ) {
            global $wpdb;

            $table_name = $wpdb->postmeta;
            $return_result = $wpdb->get_results( $wpdb->prepare(
                "SELECT * FROM `{$table_name}` WHERE meta_key = 'ns_return_internal_id' and meta_value = %s",
                $ns_return_id ) );

            return $return_result;
        }

        protected static function insert_item_to_fetch_returns_updates_table( $fetched_returns_data, $placeholders ) {
            global $wpdb;
            $table_name = self::$tm_ns_fetch_returns_updates_table_name;
            $query = $wpdb->prepare( "INSERT INTO `{$table_name}` 
                (`ns_return_id`, `ns_return_data`, `fetch_date`) 
                VALUES " . implode(', ', $placeholders),
                $fetched_returns_data
            );

            $wpdb->query( $query );
        }

        public static function get_return_ids_already_in_process_queue() {
            global $wpdb;
            $option_name_like = '%ns_returns_updates_import_batch%';
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

        public static function dispatch_returns_sync_bg_process( $page, $file_name) {
            $pages_limit = (int)get_option('ns_sync_max_pages_limit_returns_update');
            if ( $page >= $pages_limit || $page >= self::$ns_sync_page_to_dispatch_bg_process ) {
                if ( ! method_exists( self::$ns_returns_updates_import_bg_process, 'is_running' ) || ! method_exists( self::$ns_returns_updates_import_bg_process, 'is_queue_has_items' ) ) {
                    file_put_contents( $file_name, 'Dispatching import.' . PHP_EOL, FILE_APPEND );
                    self::$ns_returns_updates_import_bg_process->dispatch();
                } elseif ( ! self::$ns_returns_updates_import_bg_process->is_running() && self::$ns_returns_updates_import_bg_process->is_queue_has_items() ) {
                    file_put_contents( $file_name, 'Dispatching import.' . PHP_EOL, FILE_APPEND );
                    self::$ns_returns_updates_import_bg_process->dispatch();
                }
            }
        }

        public static function retry_ns_sync() {
            check_ajax_referer( 'nsi_rma_integration_nonce', 'nonce' );
            if ( !isset($_POST['return_id']) || empty($_POST['return_id']) ) {
                echo json_encode( array('status' => 'error', 'message' => 'Missing Return ID') );
                die();
            }

            $return_id = $_POST['return_id'];
            $is_success = self::send_return_to_ns( $return_id );

            if ( !$is_success ) {
                $error = get_post_meta( $return_id, 'ns_rma_api_error', true );
                echo json_encode( array('status' => 'error', 'message' => $error) );
            } else {
                echo json_encode( array('status' => 'success', 'message' => 'Return successfully synchronized with NetSuite') );
            }

            die();
        }

        public static function get_return_document() {
            if ( !isset($_POST['wc_return_id']) || empty($_POST['wc_return_id']) ) {
                header('Content-Type: application/json');
                echo json_encode( array('message' => 'Missing WooCommerce Return ID') );
                die();
            }

            $wc_return_id = intval( $_POST['wc_return_id'] );

            $nonce = isset( $_POST['rma_pdf_nonce'] ) ? $_POST['rma_pdf_nonce'] : '';
            if ( !wp_verify_nonce( $nonce, 'rma_pdf_nonce_' . $wc_return_id ) ) {
                header('Content-Type: application/json');
                echo json_encode( array('message' => 'Unauthorized request') );
                die();
            }

            $ns_return_id = get_post_meta( $wc_return_id, 'ns_return_internal_id', true );
            if ( empty($ns_return_id) ) {
                header('Content-Type: application/json');
                echo json_encode( array('message' => 'Missing NetSuite Return ID') );
                die();
            }

            $return_doc = get_post_meta( $wc_return_id, 'ns_rma_doc', true );
            if ( empty( $return_doc ) ) {
                $return_doc = self::get_return_document_from_ns( $wc_return_id, $ns_return_id );
            }

            if ( !$return_doc ) {
                header('Content-Type: application/json');
                $error = get_post_meta( $wc_return_id, 'ns_rma_doc_api_error', true );
                echo json_encode( array('status' => 'error', 'message' => $error) );
                die();
            }

            $file_dir = wp_upload_dir();
            $folder_name = 'rma-pdf';
            $folder_path = $file_dir['basedir'] . '/' . $folder_name;
            $pdf_file_path = $folder_path . '/' . $return_doc;

            $pdf = fopen( $pdf_file_path, 'r' );
            if ( !$pdf ) {
                header('Content-Type: application/json');
                echo json_encode( array('message' => 'Document not found') );
                die();
            }

            $file_size = filesize( $pdf_file_path );
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="return_' . $wc_return_id . '.pdf"');
            header('Content-Length: ' . $file_size);
            echo fread( $pdf, $file_size );
            die();
        }

        public static function get_return_document_from_ns( $wc_return_id, $ns_return_id ) {
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

            $rma_pdf_script_id = $TMWNI_OPTIONS['ns_rma_pdf_fetch_script_id'];
            try {
                $res = $client->get( 'app/site/hosting/restlet.nl?script=' . $rma_pdf_script_id . '&deploy=1&custscript_nsi_order_id=' . $ns_return_id, [
                    'auth' => 'oauth',
                    'headers' => [
                        'Content-type' => 'application/json'
                    ]
                ] );

                $response_body = json_decode( $res->getBody() );
                $file_dir = wp_upload_dir();
                $folder_name = 'rma-pdf';
                $folder_path = $file_dir['basedir'] . '/' . $folder_name;
                if ( !file_exists($folder_path) ) {
                    mkdir( $folder_path, 0755, true );
                }

                foreach ( $response_body->rmapdf ?? [] as $pdf ) {
                    if ( $pdf->rmafile->fileType == 'PDF' ) {
                        $pdf_name = $pdf->rmafile->name;
                        $pdf_encoded = $pdf->rmapdf;
                        $pdf_content = base64_decode( $pdf_encoded );
                        $pdf_save_filename = $folder_path . '/' . $pdf_name;
                        file_put_contents( $pdf_save_filename, $pdf_content );

                        $is_error = get_post_meta( $wc_return_id, 'ns_rma_doc_api_error', true );
                        if ( !empty($is_error) ) {
                            delete_post_meta( $wc_return_id, 'ns_rma_doc_api_error', '' );
                        }

                        update_post_meta( $wc_return_id, 'ns_rma_doc', $pdf_name );
                        return $pdf_name;
                    }
                }

                update_post_meta( $wc_return_id, 'ns_rma_doc_api_error', 'No documents found for this return' );
                return false;
            } catch( Exception $e ) {
                $error = $e->getMessage();
                update_post_meta( $wc_return_id, 'ns_rma_doc_api_error', $error );
                return false;
            }
        }

        public static function get_items_line_positions_in_order( $ns_order_id ) {
            if ( empty($ns_order_id) ) {
                return array();
            }

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

            $items_positions_script_id = $TMWNI_OPTIONS['ns_rma_fetch_items_positions_in_order'];
            try {
                $res = $client->get( 'app/site/hosting/restlet.nl?script=' . $items_positions_script_id . '&deploy=1&custscript_nsi_order_num=' . $ns_order_id, [
                    'auth' => 'oauth',
                    'headers' => [
                        'Content-type' => 'application/json'
                    ]
                ] );

                $response_body = json_decode( $res->getBody() );
                $items_positions = array();
                foreach ( $response_body->line_details ?? [] as $line_item ) {
                    $items_positions[$line_item->item_internalid] = (int) $line_item->line_id;
                }

                return $items_positions;
            } catch( Exception $e ) {
                return array();
            }
        }

        protected static function prepare_log_file($file_prefix, $sub_folder) {
            $files_limit = defined( 'NS_SYNC_STORED_LOG_FILES_LIMIT' ) ? NS_SYNC_STORED_LOG_FILES_LIMIT : 20;
            $file_dir 		= wp_upload_dir();
            $date 	        = date("Y-m-d");
            $folder_name 	= 'netsuite-sync-logs/' . $sub_folder;
            $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
            $file_name 		= $folder_path . $file_prefix . $date . '.log';

            if ( !file_exists($folder_path)) {
                mkdir( $folder_path, 0755, true );
            }

            if(!file_exists($file_name)){
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
    }
}

NSI_NS_API::init();