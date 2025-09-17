<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ( ! class_exists( 'Crown_Shop_Pricefile' ) ) {

    class Crown_Shop_Pricefile
    {
        public static bool $init = false;
        public static string $pricefile_table_name;
        protected static $ns_generate_price_file_bg_process = null;
        public static $minutes_for_price_file_generation;

        public static $switch_roles_allowed_for_price_file = array( 'administrator', 'pricing', 'internal_sales_rep', 'branch_admin', 'branch_employee', 'shop_manager' );

        public static function init()
        {
            if ( self::$init ) {
                return;
            }

            global $wpdb;
            self::$init = true;
            self::$pricefile_table_name = $wpdb->prefix . 'ns_price_file_queue';
            self::$minutes_for_price_file_generation = defined( 'PRICE_FILE_GENERATION_TIME_IN_MINUTES' ) ? PRICE_FILE_GENERATION_TIME_IN_MINUTES : 45;

            add_action( 'init', array( __CLASS__, 'setup_ns_price_file_queue_table' ), 10 );
            add_action( 'init', array( __CLASS__, 'init_generate_user_price_file' ) );

            add_filter( 'woocommerce_account_menu_items', array( __CLASS__, 'add_price_file_menu_item' ), 11 );
            add_action( 'woocommerce_get_endpoint_url', array( __CLASS__, 'get_price_file_endpoint_url' ), 10, 4 );
            add_action( 'tm_generate_user_price_file', array( __CLASS__, 'cron_tm_generate_user_price_file' ) );
            add_action( 'woocommerce_loaded', array( __CLASS__, 'init_generate_user_price_file_bg_process' ), 1000 );

            if ( isset($_GET['nsi_generate']) && $_GET['nsi_generate'] == 'price_file' ) {
                add_action( 'init', array( __CLASS__, 'add_user_to_price_file_queue' ), 1000 );
            }

            add_action( 'woocommerce_after_my_account', array( __CLASS__, 'add_price_file_time_estimation_info' ) );
        }

        public static function add_price_file_time_estimation_info() {
            $user_id = get_current_user_id();

            if ( self::is_user_in_price_file_queue($user_id) ) {
                $position_in_queue = self::calculate_user_position_in_queue( $user_id );
                if ( $position_in_queue > 0 ) {
                    $time_to_cron_start = self::get_minutes_to_cron_start();
                    $current_queue_minutes_running = self::current_queue_time_running();
                    $estimated_time_in_minutes = ($position_in_queue * self::$minutes_for_price_file_generation) - $current_queue_minutes_running + $time_to_cron_start;
                    $estimated_time_in_minutes = ceil( $estimated_time_in_minutes / 10 ) * 10;
                    $hours = floor( $estimated_time_in_minutes / 60 );
                    $minutes = $estimated_time_in_minutes % 60;

                    $estimated_time_text = 'Estimated waiting time for Price File: below';
                    if ( $hours > 0 ) {
                        $estimated_time_text .= ' ' . $hours . 'h';
                    }

                    if ( $minutes > 0 ) {
                        $estimated_time_text .= ' ' . $minutes . 'min';
                    } else if ( $minutes == 0 && $hours == 0 ) {
                        $estimated_time_text .= ' 10min';
                    }
                    echo '<h5>Price file</h5>';
                    echo '<p>You are currently in the queue for Price File generation, your position in queue: ' . $position_in_queue . '<br />';
                    echo $estimated_time_text . '</p>';
                }
            }
        }

        public static function calculate_user_position_in_queue( $user_id ) {
            global $wpdb;

            $price_file_queue_table_name = self::$pricefile_table_name;
            $query = $wpdb->prepare( "SELECT user_id FROM `{$price_file_queue_table_name}` WHERE finished_at IS NULL ORDER BY id" );
            $users_in_queue = $wpdb->get_results( $query, ARRAY_A );

            foreach ( $users_in_queue ?? [] as $place => $row ) {
                if ( $row['user_id'] == $user_id ) {
                    return $place + 1;
                }
            }

            return 0;
        }

        public static function current_queue_time_running() {
            global $wpdb;

            $price_file_queue_table_name = self::$pricefile_table_name;
            $query = $wpdb->prepare( "SELECT * FROM `{$price_file_queue_table_name}` WHERE started_at IS NOT NULL AND finished_at IS NULL ORDER BY id LIMIT 1" );
            $current_queue = $wpdb->get_results( $query, ARRAY_A );

            foreach ( $current_queue ?? [] as $row ) {
                $date_start = new DateTime( $row['started_at'] );
                $date_now = new DateTime( date('Y-m-d H:i:s') );
                $dates_diff = date_diff( $date_now, $date_start );
                $hours_diff = $dates_diff->h;
                $minutes_diff = $dates_diff->i;

                if ( $hours_diff > 0 || $minutes_diff > self::$minutes_for_price_file_generation ) {
                    return self::$minutes_for_price_file_generation;
                }

                return $minutes_diff;
            }

            return 0;
        }

        public static function get_minutes_to_cron_start() {
            $time_to_cron_start = 0;
            if ( !get_site_transient('wp_generate_price_file_process_lock') ) {
                $cron_timestamp = wp_next_scheduled( 'tm_generate_user_price_file' );
                if ( !$cron_timestamp ) {
                    return $time_to_cron_start;
                }

                $scheduled_start = new DateTime( date('Y-m-d H:i:s', $cron_timestamp) );
                $date_now = new DateTime( date('Y-m-d H:i:s') );
                $dates_diff = date_diff( $date_now, $scheduled_start );
                $hours_diff = $dates_diff->h;
                $time_to_cron_start = $dates_diff->i;

                if ( $hours_diff > 0 || $time_to_cron_start > 30 ) {
                    return 30;
                }
            }

            return $time_to_cron_start;
        }

        public static function add_price_file_menu_item( $items ) {
            if ( !self::is_user_allowed_for_price_file() ) {
                return $items;
            }

            $logout = $items['customer-logout'];
            unset( $items['customer-logout'] );
            $items['price-file'] = 'Price File';
            $items['customer-logout'] = $logout;
            return $items;
        }

        public static function is_user_allowed_for_price_file() {
            $current_user = wp_get_current_user();
            $role = $current_user->roles[0];

            if ( $role != 'customer' ) {
                return false;
            }

            $switched_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
            $switched_user = get_user_by( 'id', $switched_id );

            if ( ( $switched_id == 0 ) ||
                ( isset( $_SESSION['admin'] ) && 'adminisloggedin' == $_SESSION['admin']
                && $current_user->ID != $switched_id && $switched_id != 0
                && isset( $switched_user->roles[0] ) && in_array( $switched_user->roles[0], self::$switch_roles_allowed_for_price_file ) )
            ) {
                return true;
            } else {
                return false;
            }
        }

        public static function get_price_file_endpoint_url( $url, $endpoint, $value, $permalink )
        {
            if ( $endpoint === 'price-file' ) {
                $my_acc_page = get_permalink( get_option('woocommerce_myaccount_page_id') );
                $my_acc_page .= '?nsi_generate=price_file';
                return $my_acc_page;
            }

            return $url;
        }

        public static function add_user_to_price_file_queue() {
            if ( !is_user_logged_in() || !self::is_user_allowed_for_price_file() ) {
                return;
            }

            $user_id = get_current_user_id();
            if ( !self::is_user_in_price_file_queue($user_id) ) {
                self::add_pricefile_queue_entry( $user_id );
                wc_add_notice( esc_html__( 'Added to the price file queue.', 'addify_rfq' ), 'success' );
            } else {
                wc_add_notice( esc_html__( 'You are already in the price file queue.', 'addify_rfq' ), 'notice' );
            }
        }

        public static function add_pricefile_queue_entry( $user_id ) {
            global $wpdb;

            $price_file_queue_table_name = self::$pricefile_table_name;
            if ( Crown_Shop_Custom_Roles::is_switched_user() ) {
                $switched_user_id = $_COOKIE['sac_admin_id'];
                $email = get_user_meta( $switched_user_id, 'price_file_switched_email', true );

                if ( empty( $email ) ) {
                    $user = get_userdata( $switched_user_id );
                    $email = $user ? $user->user_email : '';
                }
                if ( !empty($email)) {
                 $query_price_file_queue = $wpdb->prepare( "INSERT INTO `{$price_file_queue_table_name}` 
                        (`user_id`, `email_address`) 
                        VALUES (%d, %s)",
                        $user_id, $email
                    );
                    $wpdb->query( $query_price_file_queue );
                    return;
                }
            }

            $query_price_file_queue = $wpdb->prepare( "INSERT INTO `{$price_file_queue_table_name}` 
                (`user_id`) 
                VALUES (%d)",
                $user_id
            );

            $wpdb->query( $query_price_file_queue );
        }

        public static function is_user_in_price_file_queue( $user_id ) {
            global $wpdb;

            $price_file_queue_table_name = self::$pricefile_table_name;
            $query = $wpdb->prepare( "SELECT * FROM `{$price_file_queue_table_name}` WHERE `user_id` = %d AND finished_at IS NULL", $user_id );
            $price_file_queue_results = $wpdb->get_results( $query );

            return !empty( $price_file_queue_results );
        }

        public static function setup_ns_price_file_queue_table() {
            if( !get_option('ns_price_file_queue_table_created') ) {
                self::create_price_file_queue_table();
                update_option( 'ns_price_file_queue_table_created', true );
            }
        }

        public static function create_price_file_queue_table() {
            global $wpdb;
            $table_name = self::$pricefile_table_name;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				user_id int(11) NOT NULL,
				started_at DATETIME DEFAULT NULL,
				finished_at DATETIME DEFAULT NULL,
				price_file_name varchar(255),
				email_sent tinyint(4) DEFAULT NULL,
				email_address varchar(255) DEFAULT NULL,
				PRIMARY KEY (id)
			) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        public static function init_generate_user_price_file() {
            if ( defined('GENERATE_USER_PRICE_FILE_ENABLED') && GENERATE_USER_PRICE_FILE_ENABLED ) {
                if ( ! wp_next_scheduled('tm_generate_user_price_file') ) {
                    wp_schedule_event( time(), '30min', 'tm_generate_user_price_file' );
                }
            } else {
                if ( wp_next_scheduled('tm_generate_user_price_file') ) {
                    wp_clear_scheduled_hook( 'tm_generate_user_price_file' );
                }
            }
        }

        public static function init_generate_user_price_file_bg_process() {
            $active_plugins = (array) get_option( 'active_plugins', array() );
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                include( dirname( __FILE__ ) . '/class-crown-generate-price-file.php' );
                self::$ns_generate_price_file_bg_process = new Generate_Price_File();
            }
        }

        public static function initiate_pricefile_xls( $user_id ) {
            $user = get_user_by( 'id', $user_id );

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $date = date( 'Y-m-d H:i:s' );
            $price_file_name = 'Price_file_' . $user_id . '_' . str_replace(['-', ':', ' '], '', $date);
            $sheet->setTitle( $price_file_name );
            $parent_rep_agent = get_user_meta( $user_id, 'parent_rep_agent_partner_name', true );
            $rep_agent = get_user_meta( $user_id, 'rep_agent_partner_name', true );

            $sheet->setCellValue( 'A1', 'NSI Industries, LLC' );
            $sheet->setCellValue( 'B2', 'Price List' );
            $sheet->setCellValue( 'A3', 'Date' );
            $sheet->setCellValue( 'B3', $date );
            $sheet->setCellValue( 'A4', 'Customer Name' );
            $sheet->setCellValue( 'B4', $user->first_name );
            $sheet->setCellValue( 'A5', 'Parent Rep Agent/Partner' );
            $sheet->setCellValue( 'B5', $parent_rep_agent );
            $sheet->setCellValue( 'A6', 'Rep Agent/Partner' );
            $sheet->setCellValue( 'B6', $rep_agent );

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $sheet1 = $spreadsheet->getActiveSheet();

            $header_row = array(
                'A' => 'Pricing Group',
                'B' => 'Product Category',
                'C' => 'Item',
                'D' => 'Description',
                'E' => 'List/Trade Price Per',
                'F' => 'BBD/EEE Price Per',
                'G' => 'Dist. Price Per',
                'H' => 'Price Per',
                'I' => 'Min Order Qty',
                'J' => 'List/Trade Price Each',
                'K' => 'Dist. Price Each',
                'L' => 'UPC Code w/ Check Digit',
            );

            foreach ( $header_row as $column => $title ) {
                $sheet1->setCellValue( $column . '1', $title );
            }

            $writer = new Xlsx( $spreadsheet );
            $save_dir = wp_upload_dir();
            $folder_name = 'price-files';
            $folder_path = $save_dir['basedir'] . '/' . $folder_name;
            $save_filename = $folder_path . '/' . $price_file_name . '.xlsx';
            $writer->save( $save_filename );

            return $save_filename;
        }

        public static function initiate_pricefile_csv( $user_id ) {
            $header_row_csv = array(
                'Pricing Group',
                'Product Category',
                'Item',
                'Description',
                'List/Trade Price Per',
                'BBD/EEE Price Per',
                'Dist. Price Per',
                'Price Per',
                'Min Order Qty',
                'List/Trade Price Each',
                'Dist. Price Each',
                'UPC Code w/ Check Digit',
            );

            $date = date( 'Y-m-d H:i:s' );
            $price_file_name = 'Price_file_' . $user_id . '_' . str_replace(['-', ':', ' '], '', $date);
            $save_dir = wp_upload_dir();
            $folder_name = 'price-files';
            $folder_path = $save_dir['basedir'] . '/' . $folder_name;
            $save_filename = $folder_path . '/' . $price_file_name . '.csv';

            $fp = fopen( $save_filename, 'w' );
            fputcsv( $fp, $header_row_csv );
            fclose( $fp );

            return $save_filename;
        }

        public static function cron_tm_generate_user_price_file() {
            $file_name = self::prepare_log_file();
            require_once( dirname( __FILE__ ) . '/class-crown-generate-price-file.php' );
            $datetime = date('Y-m-d H:i:s');
            file_put_contents( $file_name, '[' . $datetime . '] Start CRON' . PHP_EOL, FILE_APPEND );

            $users_for_pricefile = self::get_users_for_price_file();
            $products_ids = null;
            foreach ( $users_for_pricefile as $user ) {
                $user_id = $user['user_id'];
                self::user_queue_set_start_date( $user_id );

                if ( $products_ids == null ) {
                    $products_ids = self::get_products_for_pricefile();
                    $limit = 50;
                    $all_products_for_pricefile = array_chunk( $products_ids, $limit, true );
                    $total_loop_pages = count( $all_products_for_pricefile );
                }

                file_put_contents( $file_name, 'Creating batches for user: ' . $user_id . '. Products found: ' . count($products_ids) . PHP_EOL, FILE_APPEND );

                $count_batch_items = 0;
                $save_filename = self::initiate_pricefile_csv( $user_id );
//                $save_filename = self::initiate_pricefile_xls( $user_id );
                $generate_price_file = new Generate_Price_File();

                for( $i = 0; $i <= $total_loop_pages; $i++ ) {
                    if( $count_batch_items == 100 ) {
                        $generate_price_file = new Generate_Price_File();
                        $count_batch_items = 0;
                    }

                    $products_for_pricefile = $all_products_for_pricefile[$i] ?? array();
                    if( !empty($products_for_pricefile) ) {
                        $generate_price_file->push_to_queue(array('user_id' => $user_id, 'products_for_pricefile' => $products_for_pricefile, 'filename' => $save_filename));
                        $count_batch_items++;
                    }

                    if( $count_batch_items == 100 ) {
                        $generate_price_file->save();
                        file_put_contents( $file_name, '[' . date('Y-m-d H:i:s') . '] Batch saved' . PHP_EOL, FILE_APPEND );
                    }
                }

                if( $count_batch_items < 100 ) {
                    $generate_price_file->save();
                    file_put_contents( $file_name, '[' . date('Y-m-d H:i:s') . '] Batch saved' . PHP_EOL, FILE_APPEND );
                }
            }

            file_put_contents( $file_name, '[' . date('Y-m-d H:i:s') . '] Background process dispatched [2]' . PHP_EOL, FILE_APPEND );
            $generate_price_file = new Generate_Price_File();
            $generate_price_file->dispatch();
        }

        public static function is_price_file_generation_running() {
            global $wpdb;
            $price_file_queue_table_name = $wpdb->prefix . 'ns_price_file_queue';

            $query = "SELECT * FROM `{$price_file_queue_table_name}` WHERE `started_at` IS NOT NULL AND `finished_at` IS NULL";
            $price_file_queue_results = $wpdb->get_results( $query );

            return !empty( $price_file_queue_results );
        }

        public static function get_users_for_price_file() {
            global $wpdb;
            $price_file_queue_table_name = $wpdb->prefix . 'ns_price_file_queue';

            $query = $wpdb->prepare( "SELECT * FROM `{$price_file_queue_table_name}` WHERE started_at IS NULL" );
            $price_file_users = $wpdb->get_results( $query, ARRAY_A );

            return $price_file_users ?? [];
        }

        public static function prepare_log_file() {
            $file_dir 		= wp_upload_dir();
            $date 	        = date("Y-m-d");
            $folder_name 	= 'price-files';
            $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
            $file_name 		= $folder_path . '/generate-pricefile-' . $date . '.log';
            $log_files_amount_limit = defined( 'NS_PRICE_FILE_LOG_FILES_LIMIT' ) ? NS_PRICE_FILE_LOG_FILES_LIMIT : 20;
            $price_files_days_limit = defined( 'NS_PRICE_FILE_DAYS_LIMIT' ) ? NS_PRICE_FILE_DAYS_LIMIT : 14;

            if ( !file_exists($folder_path) ) {
                mkdir( $folder_path, 0755, true );
            }

            if( !file_exists($file_name) ) {
                $log_file = fopen( $file_name, 'w' );
                chmod( $file_name, 0664 );
                fclose( $log_file );
            }

            $files = scandir( $folder_path );
            $log_files = array_filter( $files, function($file) use ($folder_path) {
                return is_file( $folder_path . '/' . $file ) && str_contains( $file, 'generate-pricefile' );
            } );

            usort( $log_files, function($a, $b) use ($folder_path) {
                return filemtime( $folder_path . '/' . $a ) > filemtime( $folder_path . '/' . $b );
            } );

            while( count($log_files) > $log_files_amount_limit ) {
                unlink( $folder_path . '/' . $log_files[0] );
                array_shift( $log_files );
            }

            $price_files = array_filter( $files, function($file) use ($folder_path) {
                return is_file( $folder_path . '/' . $file ) && str_contains( $file, 'Price_file_' );
            } );

            $delete_before_date = strtotime( $price_files_days_limit . ' days ago' );

            foreach ( $price_files as $file ) {
                if ( filemtime($folder_path . '/' . $file) < $delete_before_date ) {
                    unlink( $folder_path . '/' . $file );
                }
            }

            return $file_name;
        }

        public static function get_products_for_pricefile() {
            global $wpdb;
            $products = $wpdb->get_results($wpdb->prepare(
                "SELECT posts.ID, term.name AS product_category
FROM wp_posts posts
LEFT JOIN wp_postmeta pm ON pm.post_id = posts.ID
LEFT JOIN wp_term_relationships AS tr ON tr.object_id = posts.ID
JOIN wp_term_taxonomy AS tt ON tt.taxonomy = 'product_cat' AND tt.term_taxonomy_id = tr.term_taxonomy_id 
JOIN wp_terms AS term ON term.term_id = tt.term_id
WHERE posts.post_type='product' AND posts.post_status='publish' AND posts.ID = pm.post_id 
AND pm.meta_key = '_regular_price' AND pm.meta_value > 0 
ORDER BY product_category"));

            $products_ids = [];
            foreach ( $products as $product ) {
                $products_ids[] = $product->ID;
            }

            return $products_ids;
        }

        public static function user_queue_set_start_date( $user_id ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'ns_price_file_queue';
            $date = date('Y-m-d H:i:s');

            $update_query = $wpdb->prepare(
                "UPDATE $table_name SET started_at = %s WHERE user_id = %d and started_at IS NULL",
                $date, $user_id
            );
            $wpdb->query( $update_query );
        }
    }
}