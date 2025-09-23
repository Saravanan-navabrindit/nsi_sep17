<?php


use CrownShop\Enums\LogWooErrorType;

if ( ! class_exists('Nsi_Helper') ) {
	class Nsi_Helper {

        public static $init = false;
        public static $ns_sync_log_file;

        public static function init(): void {
            if (self::$init) return;
            self::$init = true;

        }

        /**
         * Get unique objects by a specific property.
         *
         * @param array $objects Array of objects to filter.
         * @param string $property The property to check for uniqueness.
         * If the property does not exist, it will try to call a getter method named 'get_property'.
         * @return array Array of unique objects based on the specified property.
         */
        public static function get_unique_objects_by_property(array $objects, string $property): array {
            $unique = [];
            $handled = [];
            foreach ($objects as $obj) {
                if (is_object($obj)) {
                    if (property_exists($obj, $property)) {
                        $value = $obj->$property;
                    } elseif (method_exists($obj, 'get_' . strtolower($property))) {
                        $getter = 'get_' . $property;
                        $value = $obj->$getter();
                    } else {
                        continue;
                    }
                    if (is_object($obj) && !in_array($value, $handled, true)) {
                        $handled[] = $value;
                        $unique[] = $obj;
                    }
                }
            }
            return $unique;
        }

        public static function get_orders_for_dsm_sql_query_raw( $dsm_users_ids, $current_user_email_domain, $post_status = '', $post_type = '' )
        {
            global $wpdb;
            $placeholders = implode( ',', array_fill(0, count($dsm_users_ids), '%d') );
            $params = array_merge( $dsm_users_ids, array('1', $current_user_email_domain) );

            if ( empty($post_status) ) {
                $post_status_where = "IN ('wc-pending', 'wc-processing', 'wc-on-hold', 'wc-completed', 'wc-cancelled', 'wc-refunded', 'wc-failed', 'wc-checkout-draft', 'wc-pending-approval', 'wc-pending-billing', 'wc-pending-fulfill', 'wc-partially-fulfill')";
            } else {
                $post_status_where = '= %s';
                $params = array_merge( array($post_status), $params );
            }
            $post_type_where = empty($post_type) ? "IN ('shop_order', 'shop_order_refund')" : "= '$post_type'";

            $orders_ids_query = $wpdb->prepare(
                "SELECT wp_posts.ID
                FROM wp_posts
                WHERE wp_posts.post_type " . $post_type_where . "
                  AND wp_posts.post_status " . $post_status_where . "
                  AND EXISTS (
                    SELECT 1 FROM wp_postmeta
                    WHERE wp_postmeta.post_id = wp_posts.ID
                      AND wp_postmeta.meta_key = '_customer_user'
                      AND wp_postmeta.meta_value IN ( $placeholders )
                  )
                  AND EXISTS (
                    SELECT 1 FROM wp_postmeta
                    WHERE wp_postmeta.post_id = wp_posts.ID
                      AND wp_postmeta.meta_key = '_created_by_dual_shop_manager'
                      AND wp_postmeta.meta_value = %s
                  )
                  AND EXISTS (
                    SELECT 1 FROM wp_postmeta
                    WHERE wp_postmeta.post_id = wp_posts.ID
                      AND wp_postmeta.meta_key = '_sales_rep_domain'
                      AND wp_postmeta.meta_value = %s
                  )
                ORDER BY wp_posts.post_date DESC;",
                ...$params
            );

            $orders_ids = $wpdb->get_col( $orders_ids_query );
            return $orders_ids;
        }

        public static function prepare_log_file($log_name, $folder_name, $sub_folder = '', $files_limit = 7) {
            $file_dir 		= wp_upload_dir();
            $date 	        = date("Y-m-d");
            if ( ! empty( $sub_folder ) ) {
                $folder_name .= '/' . $sub_folder;
            }
            $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
            $file_name 		= $folder_path . '/' . $log_name . '-' . $date . '.log';

            if ( !file_exists($folder_path)) {
                mkdir( $folder_path, 0755, true );
            }

            if(!file_exists($file_name)){
                $log_file = fopen($file_name, 'w');
                chmod($file_name, 0664);
                fclose($log_file);
            }
            self::rotate_logs( $folder_path, $log_name, $files_limit );

            return $file_name;
        }

        public static function set_ns_sync_log_file( $log_file ) {
            self::$ns_sync_log_file = $log_file;
        }

        public static function get_ns_sync_log_file() {
            if ( isset(self::$ns_sync_log_file) && !empty(self::$ns_sync_log_file) ) {
                return self::$ns_sync_log_file;
            }

            return false;
        }

        public static function rotate_logs($folder_path, $log_name, $files_limit) {
            $files = scandir( $folder_path );
            $log_files = array_filter( $files, function ($file) use ( $folder_path, $log_name ) {
                return is_file( $folder_path . '/' . $file ) && str_contains( $file, $log_name );
            } );

            usort( $log_files, function ($a, $b) use ( $folder_path ) {
                return filemtime( $folder_path . '/' . $a ) > filemtime( $folder_path . '/' . $b );
            } );

            while ( count( $log_files ) > $files_limit ) {
                unlink( $folder_path . '/' . $log_files[0] );
                array_shift( $log_files );
            }
        }

        public static function update_addify_quote_user_meta( $quote_contents ) {
            if ( ! $quote_contents ) {
                return;
            }
            $user_id = get_current_user_id();
            if ( Crown_Shop_Custom_Roles::is_switched_user() ) {
                $id_for_usermeta = Eleks_Carts_Management::get_user_unique_session_id( $user_id );
            } else {
                $id_for_usermeta = $user_id;
                update_user_meta( $user_id, 'addify_quote', $quote_contents );
            }
            $quote_data = array(
                'quotes' => $quote_contents,
                'timestamp' => time()
            );
            update_user_meta($user_id, '_addify_quote-cart_' . $id_for_usermeta, $quote_data);
        }

        /**
         * Log the error as WooCommerce error to the wc-logs folder.
         *
         * @param Throwable|Exception $e
         * @param int $post_id
         * @param  LogWooErrorType $logging_error_type will name the log file in wc-logs
         * for example: LogWooErrorType::HANDLED_FATAL will create handled-fatal-errors-YYYY-MM-DD-[HASH].log file
         * @return void
         */
        public static function log_wc_error(Throwable|Exception $e, int $post_id, LogWooErrorType $logging_error_type): void {
            if (class_exists('WC_Logger')) {
                $logger = wc_get_logger();
                $logger->error('Handled FATAL: ' . $e->getMessage() . ' | Affected post ID: ' . $post_id, ['source' => $logging_error_type->value]);
            }
        }

        public static function is_admin_session_set() {
            $admin_session = WC()->session ? WC()->session->get( 'admin', null ) : null;
            if ( isset( $admin_session ) && $admin_session === 'adminisloggedin' ) return true;
            return false;
        }

    }
}
