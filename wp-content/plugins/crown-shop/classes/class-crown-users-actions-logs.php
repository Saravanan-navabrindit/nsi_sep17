<?php

if ( ! class_exists( 'Crown_Shop_NSI_Users_Actions_Logs' ) ) {
    class Crown_Shop_NSI_Users_Actions_Logs
    {
        public static bool $init = false;
        public static string $log_file;
        public static array $roles_to_log_activity;

        public static function init(): void
        {
            if ( self::$init ) return;
            self::$init = true;

            self::set_roles_to_log_activity();
            add_action( 'wp_login', array( __CLASS__, 'log_login_activity' ), 10, 2 );
            add_action( 'save_post', array( __CLASS__, 'log_save_post_activity' ), 10, 3 );
            add_action( 'acf/save_post', array( __CLASS__, 'log_acf_update_activity' ), 10, 1 );

            add_action( 'activated_plugin', array( __CLASS__, 'log_activated_plugin' ), 10, 2 );
            add_action( 'deactivated_plugin', array( __CLASS__, 'log_deactivated_plugin' ), 10, 2 );
            add_action( 'deleted_plugin', array( __CLASS__, 'log_deleted_plugin' ), 10, 2 );

            add_action( 'crontrol/ran_event', array( __CLASS__, 'log_cron_started_manually' ), 10, 1 );

            add_action( 'upgrader_process_complete', array( __CLASS__, 'log_plugin_core_theme_update_action' ), 10, 2 );

            add_action( 'set_user_role', array( __CLASS__, 'log_user_role_update_action' ), 10, 3 );
            add_action( 'update_post_meta', array( __CLASS__, 'log_po_number_change' ), 10, 4 );
            add_action( 'update_user_meta', array( __CLASS__, 'log_user_ns_id_change' ), 10, 4 );
            add_action( 'fme_switch_to_log_the_action', array( __CLASS__, 'log_switch_to_customer_actions' ), 10, 2 );

            self::add_update_options_log_actions();
        }

        //TODO: extend options changing tracking (wp_options)
        //TODO: users changing (it is enough to track role granting, revoking, changing) wp_users and wp_usermeta
        //TODO: optional - refactor index.php to be reused for all logdirs instead of being called from each of folder.

        public static function log_po_number_change( $meta_id, $object_id, $meta_key, $meta_value ) {
            $user = self::get_current_user();
            if ( $meta_key === 'af_c_f_4432739' && $user ) {
                $log_content = 'Order ' . $object_id . ' - updated PO Number to ' . $meta_value .
                    ' - ' . $user->user_login . ' (' . $user->user_email . ')';

                self::write_to_log( $log_content );
            }
        }

        public static function log_user_ns_id_change( $meta_id, $object_id, $meta_key, $meta_value ) {
            $user = self::get_current_user();
            if ( $meta_key === 'ns_customer_internal_id' && $user ) {
                $log_content = 'User ' . $object_id . ' - updated ns_customer_internal_id ' . $meta_value .
                    ' - ' . $user->user_login . ' (' . $user->user_email . ')';

                self::write_to_log( $log_content );
            }
        }

        private static function set_log_file(): void
        {
            $file_dir 		= wp_upload_dir();
            $date_current 	= date("Y-m-d");
            $folder_name 	= 'users-actions-logs';
            $path_folder 	= $file_dir['basedir'] . '/' . $folder_name;
            $log_file 		= $path_folder . '/users-actions-'.$date_current.'.log';

            if ( !file_exists( $path_folder ) ) {
                mkdir( $path_folder, 0775 );
            }

            self::$log_file = $log_file;

            $today = date( 'Y-m-d' );
            $last_cleanup_date = get_option( 'users_actions_logs_last_cleanup_date' );
            if( $last_cleanup_date !== false && $last_cleanup_date >= $today ) {
               return;
            }

            $files = scandir($path_folder);
            $remove_before_date = date( 'Y-m-d', strtotime('-2 weeks') );

            foreach ( $files as $file ) {
                if ( str_starts_with( $file, 'users-actions' ) ) {
                    $file_date = date( 'Y-m-d', filemtime( $path_folder . '/' . $file ) );

                    if ( $file_date < $remove_before_date ) {
                        unlink( $path_folder . '/' . $file );
                    }
                }
            }

            update_option( 'users_actions_logs_last_cleanup_date', $today );
        }

        private static function write_to_log( string $content ): void
        {
            self::set_log_file();
            $date = date("Y-m-d H:i:s");
            $output = file_get_contents( self::$log_file );
            $output .= '[' . $date . '] - ' . $content . "\n";
            file_put_contents( self::$log_file, $output );
        }

        private static function set_roles_to_log_activity(): void
        {
            self::$roles_to_log_activity = ( defined('ROLES_TO_LOG_ACTIVITY') && ROLES_TO_LOG_ACTIVITY )
                ? ROLES_TO_LOG_ACTIVITY
                : array('administrator', 'pricing', 'editor', 'dual_shop_manager');
        }

        public static function log_login_activity( string $user_login, WP_User $user ): void
        {
            $user_role = $user->roles[0] ?? '';
            if ( !in_array( $user_role, self::$roles_to_log_activity ) ) {
                return;
            }

            $user_email = $user->user_email;
            $log_content = 'User logged in - ' . $user_login . ' (' . $user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function log_save_post_activity( int $post_id, WP_Post $post, bool $update ): void
        {
            $action_performed = $update ? 'updated' : 'created';
            $user = self::get_current_user();
            if( $user && $post->post_type !== 'product_import' ) {
                $log_content = 'Post ' . $post_id . ' (' . $post->post_type . ') ' . $action_performed .
                    ' - ' . $user->user_login . ' (' . $user->user_email . ')';

                $switched_user = Crown_Shop_Display::get_original_switched_user( $user->ID );
                if ( $switched_user && $switched_user instanceof WP_User ) {
                    $log_content .= '. Done by switched user: ' . $switched_user->user_login . ' (' . $switched_user->user_email . ')';
                }

                self::write_to_log( $log_content );
            }
        }

        public static function log_acf_update_activity( $post_id ): void
        {
            $user = wp_get_current_user();
            $page = $_GET['page'];
            $acf_data = json_encode( $_POST['acf'] );

            $log_content = 'ACF "' . $post_id . '" updated - page: ' . $page .
                ', user: ' . $user->user_login . ' (' . $user->user_email . '), new values: ' . $acf_data;
            self::write_to_log( $log_content );
        }

        public static function log_activated_plugin( string $plugin, bool $network_wide ): void
        {
            $user = wp_get_current_user();
            $log_content = '"' . $plugin . '" plugin activated - ' . $user->user_login . ' (' . $user->user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function log_deactivated_plugin( string $plugin, bool $network_wide ): void
        {
            $user = wp_get_current_user();

            $log_content = '"' . $plugin . '" plugin deactivated - ' . $user->user_login . ' (' . $user->user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function log_deleted_plugin( string $plugin, bool $deleted ): void
        {
            $user = wp_get_current_user();
            $log_content = '"' . $plugin . '" plugin deletion attempt - ' . ( $deleted ? 'successful' : 'failed' ) . ' - ' .
                $user->user_login . ' (' . $user->user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function log_cron_started_manually( stdClass $event ): void
        {
            $user = wp_get_current_user();
            $log_content = 'Cron "' . $event->hook . '" started manually - ' .
                $user->user_login . ' (' . $user->user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function log_plugin_core_theme_update_action( WP_Upgrader $upgrader, array $hook_extra ): void
        {
            $user = wp_get_current_user();
            $hook_data = json_encode( $hook_extra );
            $log_content = 'Update action - ' . $user->user_login . ' (' . $user->user_email . ') - details: ' .
                $hook_data;
            self::write_to_log( $log_content );
        }


        public static function log_user_role_update_action( $user_id, $new_role, $old_roles ): void
        {
            $user = wp_get_current_user();
            $log_content = 'User ID "' . $user_id . '" role changed from "' . implode( ', ', $old_roles ) . '" to "' . $new_role .
                '" by ' . $user->user_login . ' (' . $user->user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function add_update_options_log_actions() {
            $options_to_log_data = array(
                //Import collections
                'cspi_import_collection_id',
                //Users import/sync
                'csc_import_customer_id', 'csc_import_customer_rep_domain', 'csc_sync_all_customers',
                //Addify RFQ - General
                'enable_o_o_s_products', 'quote_menu', 'afrfq_customer_roles', 'afrfq_basket_option', 'enable_ajax_product',
                'enable_ajax_shop', 'afrfq_redirect_to_quote', 'afrfq_redirect_after_submission', 'afrfq_redirect_url',
                //Addify RFQ - Custom Messages
                'afrfq_success_message', 'afrfq_view_button_message',
                //Addify RFQ - Emails
                'afrfq_admin_email', 'afrfq_emails',
                //Addify RFQ - Google captcha
                'afrfq_enable_captcha', 'afrfq_site_key', 'afrfq_secret_key',
                //Addify RFQ - Page builders
                'afrfq_enable_elementor_compt', 'afrfq_enable_divi_compt', 'afrfq_enable_solution2',
                //Addify RFQ - Quote
                'afrfq_enable_pro_price', 'afrfq_enable_off_price', 'afrfq_enable_off_price_increase', 'afrfq_enable_tax',
                'afrfq_enable_convert_order', 'afrfq_enable_converted_by',
                //Addify RFQ - Quote buttons
                'afrfq_submit_button_text', 'afrfq_submit_button_bg_color', 'afrfq_submit_button_fg_color', 'afrfq_update_button_text',
                'afrfq_update_button_bg_color', 'afrfq_update_button_fg_color',
                //Settings - contact info
                'theme_config_contact_address', 'theme_config_contact_email', 'theme_config_contact_phone',
                //Quote email mapping
                'csrfq_contacts',
                //Browser caching
                'prevent_browser_caching_options',
                //general settings
                'siteurl', 'home', 'blogname', 'admin_email', 'users_can_register', 'timezone_string', 'permalink_structure',
                'default_comment_status', 'default_ping_status', 'template',
                //Quote notification settings
                'rfq_address_preference', 'rfq_custom_money_threshold_rvp', 'rfq_custom_money_threshold_evp', 'rfq_extra_recipients',
                //Order settings
                'custom_settings_default_minimum_order_amount',
                //Custom Shipping Settings
                'custom_shipping_default_order_value','prefix_order_settings', 'suffix_order_settings', 'suffix_prefix_order_settings', 'state_order_settings', 'city_order_settings', 'custom_shipping_settings',
                //Settings Expired status
                'options_acf_expired_to_quote',
            );

            foreach( $options_to_log_data as $field ) {
                $option_name = 'pre_update_option_' . $field;
                add_filter( $option_name, array( __CLASS__, 'log_option_update' ), 10, 3 );
            }
        }

        public static function log_option_update( $new_value, $old_value, $option) {
            $user = self::get_current_user();
            if( $user ) {
                $save_new_value = is_array( $new_value ) ? json_encode( $new_value ) : $new_value;
                $save_old_value = is_array( $new_value ) ? json_encode( $old_value ) : $old_value;
                $log_content = 'Option ' . $option . ' updated by ' . $user->user_login . ' (' . $user->user_email . ')' .
                    ', old value: ' . $save_old_value . ', new value: ' . $save_new_value;
                self::write_to_log( $log_content );
            }

            return $new_value;
        }

        public static function log_switch_to_customer_actions( $original_user_meta, $switched_to_meta )
        {
            $log_content = 'Switch To action - ' . $original_user_meta->user_login . ' (' . $original_user_meta->user_email . ') switched to ' .
                $switched_to_meta->user_login . ' (' . $switched_to_meta->user_email . ')';
            self::write_to_log( $log_content );
        }

        public static function get_current_user() {
            $user = wp_get_current_user();

            return ($user && $user->ID !== 0) ? $user : false;
        }
    }
}