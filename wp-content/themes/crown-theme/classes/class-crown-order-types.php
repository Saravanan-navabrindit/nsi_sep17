<?php

use NetSuite\Classes\Invoice;
use NetSuite\Classes\ReturnAuthorization;
use \NetSuite\NetSuiteService;
use \NetSuite\Classes\SalesOrder;
use \NetSuite\Classes\CustomFieldList;
use \NetSuite\Classes\StringCustomFieldRef;
use \NetSuite\Classes\BooleanCustomFieldRef;
use \NetSuite\Classes\UpdateListRequest;

if (!class_exists('Crown_Order_Types')) {
    class Crown_Order_Types
    {
        public static bool $init = false;
        public static string $types_table_name;
        public static string $types_lookup_table_name;
        public static string $woocommerce_order_type = "woocommerce_order";
        public static int $ns_orders_error_message_characters_limit = 300;

        public static function init(): void
        {
            if ( self::$init ) {
                return;
            }

            self::$init = true;
            self::set_table_names();
            self::setup_order_types_tables();
            if ( defined( 'NS_ORDERS_ERROR_MESSAGE_CHARACTERS_LIMIT' ) ) {
                self::$ns_orders_error_message_characters_limit = NS_ORDERS_ERROR_MESSAGE_CHARACTERS_LIMIT;
            }
            add_filter( 'manage_shop_order_posts_columns', array( __CLASS__, 'add_order_type_column' ), 99 );
            add_filter( 'manage_shop_order_posts_custom_column', array( __CLASS__, 'set_order_type_column_value' ), 10, 2 );
            add_filter( 'manage_edit-shop_order_sortable_columns', array( __CLASS__, 'set_order_type_column_sortable' ) );
            add_filter( 'restrict_manage_posts', array( __CLASS__, 'add_order_type_filter' ), 10, 2 );
            add_action( 'woocommerce_admin_order_data_after_payment_info', array( __CLASS__, 'display_order_type_in_order_edit_view' ), 10, 1 );
            add_filter( 'posts_clauses', array( __CLASS__, 'sort_by_order_type' ), 99, 2);
            add_filter( 'parse_query', array( __CLASS__, 'filter_query_by_order_type' ) );
            add_action( 'woocommerce_new_order', array( __CLASS__, 'set_order_type_woocommerce' ), 10, 1 );
            add_action( 'admin_menu', array( __CLASS__, 'init_admin_menu_order_type_pages' ) );
            add_filter( 'woocommerce_account_orders_columns', array( __CLASS__, 'add_user_profile_order_type_column' ), 99 );
        }

        public static function set_table_names(): void
        {
            global $wpdb;
            self::$types_table_name = $wpdb->prefix . "ns_order_types";
            self::$types_lookup_table_name = $wpdb->prefix . "ns_order_types_lookup";
        }

        public static function setup_order_types_tables(): void
        {
            global $wpdb;

            $types_tables_created = get_option( 'ns_order_types_tables_created' );
            if( !$types_tables_created ) {
                $charset_collate = $wpdb->get_charset_collate();

                $sql_types = "CREATE TABLE IF NOT EXISTS " . self::$types_table_name . " (
                    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `ns_custom_value` varchar(255) NOT NULL,
                    `order_type` varchar(100) NOT NULL,
                    PRIMARY KEY (id),
                    KEY id_order_type (`id`,`order_type`)
                ) $charset_collate;";

                $sql_lookup = "CREATE TABLE IF NOT EXISTS " . self::$types_lookup_table_name . " (
                    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `order_id` int(11) NOT NULL,
                    `order_type_id` int(10) NOT NULL,
                    `order_type_name` varchar(100) NOT NULL,
                    PRIMARY KEY (id),
                    KEY order_id_roder_type_name (`order_id`,`order_type_name`)
                ) $charset_collate;";

                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql_types );
                dbDelta( $sql_lookup );
                update_option( 'ns_order_types_tables_created', true );
            }
        }

        public static function add_new_order_type( $ns_custom_value, $type ): void
        {
            global $wpdb;
            $types_table_name = self::$types_table_name;
            $sql = $wpdb->prepare( "INSERT INTO `{$types_table_name}` 
                (`ns_custom_value`, `order_type`) VALUES ('%s', '%s')",
                $ns_custom_value, $type
            );

            $wpdb->query( $sql );
        }

        public static function set_order_type( $order_id, $type_id, $type_name ): void
        {
            global $wpdb;

            update_post_meta( $order_id, 'ns_order_type', $type_id );

            $types_lookup_table_name = self::$types_lookup_table_name;
            if ( !self::get_order_type_from_lookup($order_id) ) {
                $sql = $wpdb->prepare( "INSERT INTO `{$types_lookup_table_name}` 
                    (`order_id`, `order_type_id`, `order_type_name`) 
                    VALUES (%d, %d, '%s')",
                    $order_id, $type_id, $type_name
                );
            } else {
                $sql = $wpdb->prepare("UPDATE `{$types_lookup_table_name}` 
                    SET order_type_id = %d, order_type_name = '%s' 
                    WHERE order_id = %d",
                    $type_id, $type_name, $order_id
                );
            }

            $wpdb->query( $sql );
        }

        public static function get_available_order_types( $array_key = 'id' ): array
        {
            global $wpdb;
            $order_types_table_name = self::$types_table_name;
            $types = $wpdb->get_results("SELECT * FROM $order_types_table_name");

            if ( !in_array($array_key, array('id', 'ns_custom_value', 'order_type')) ) {
                $array_key = 'id';
            }

            $return = array();
            foreach( $types as $type ) {
                $return[$type->$array_key] = $type;
            }

            return $return;
        }

        public static function get_order_type_from_lookup( $order_id ): array|bool
        {
            global $wpdb;
            $types_lookup_table_name = self::$types_lookup_table_name;

            $type = $wpdb->get_results($wpdb->prepare("SELECT * FROM $types_lookup_table_name where order_id = '%s'", $order_id));

            if ( count($type) > 0 ) {
                return [
                    'id' => $type[0]->order_type_id,
                    'name' => $type[0]->order_type_name,
                ];
            }

            return false;
        }

        public static function add_order_type_column( $columns ) {
            $columns['order_type'] = 'Order type';
            return $columns;
        }

        public static function add_user_profile_order_type_column( $columns ) {
            $new_columns = [];
            $inserted = false;

            foreach ( $columns as $key => $val ) {
                if ( $key === 'order-status' ) {
                    $new_columns['order-type'] = 'Order type';
                    $inserted = true;
                }

                $new_columns[$key] = $val;
            }

            if ( !$inserted ) {
                $new_columns['order-type'] = 'Order type';
            }

            return $new_columns;
        }

        public static function set_order_type_column_value( $column_key, $post_id ): void
        {
            if ( $column_key == 'order_type' ) {
                $order_type = self::get_order_type( $post_id );
                if ( $order_type ) {
                    echo $order_type['name'];
                }
            }
        }

        public static function add_order_type_filter( $post_type, $which ): void
        {
            if ( $post_type == 'shop_order' ) {
                global $wpdb;
                $order_types_table_name = self::$types_table_name;
                $types = $wpdb->get_results("SELECT * FROM $order_types_table_name");
                $return = '<select name="order_type" id="order_type" class="postform">';
                $return .= '<option value="">Select Order Type</option>';
                foreach ( $types as $type ) {
                    $selected = '';
                    if ( isset($_GET['order_type']) && $_GET['order_type'] == $type->id ) {
                        $selected = ' selected="selected"';
                    }
                    $return .= '<option value="' . $type->id . '"' . $selected .'>' . $type->order_type . '</option>';
                }
                $return .= '</select>';

                echo $return;
            }
        }

        public static function filter_query_by_order_type( $query ): void
        {
            global $pagenow;
            if ( !is_admin() || $pagenow !== 'edit.php' || !isset($_GET['post_type']) || $_GET['post_type'] !== 'shop_order' ) {
                return;
            }

            $order_type = $_GET['order_type'] ?? '';

            if ( !empty($order_type) ) {
                $query->query_vars['meta_key'] = 'ns_order_type';
                $query->query_vars['meta_value'] = $order_type;

                //order type can not be filtered and sorted at the same time
                remove_filter( 'posts_clauses', array( __CLASS__, 'sort_by_order_type' ), 99, 2);
            }
        }

        public static function display_order_type_in_order_edit_view( $order ): void
        {
            $order_type = self::get_order_type( $order->ID );
            if ( $order_type ) {
                echo '<h4>Order type: ' . $order_type['name'] . '</h4>';
            }
        }

        public static function get_order_type( $order_id ): array|bool
        {
            global $wpdb;
            $order_type_table = $wpdb->prefix . 'ns_order_types';
            $query = $wpdb->prepare(
                "SELECT wppm.meta_value, ot.order_type FROM $wpdb->postmeta wppm
                    LEFT JOIN $order_type_table ot ON wppm.meta_value = ot.id
                    WHERE wppm.post_id = %d AND meta_key = 'ns_order_type'",
                $order_id
            );

            $result = $wpdb->get_results( $query );
            if ( count($result) > 0 ) {
                return [
                    'id' => $result[0]->meta_value,
                    'name' => $result[0]->order_type,
                ];
            }

            return false;
        }

        public static function sort_by_order_type( $clauses, $query )
        {
            $orderby = $query->get( 'orderby' );
            $post_type = $query->get( 'post_type' );
            if ( 'order_type' == $orderby && $post_type == 'shop_order' ) {
                $order = $_GET['order'] ?? '';
                $clauses['join'] = "
                LEFT JOIN wp_postmeta wppm ON wp_posts.ID = wppm.post_id AND wppm.meta_key = 'ns_order_type'
                LEFT JOIN wp_ns_order_types WPOT ON wppm.meta_value = WPOT.id
                ";
                $clauses['orderby'] = " WPOT.order_type " . $order ;
            }

            return $clauses;
        }

        public static function set_order_type_column_sortable( $columns ) {
            $columns['order_type'] = 'order_type';
            return $columns;
        }

        public static function set_order_type_woocommerce( $order_id ): void
        {
            $order_types = self::get_available_order_types( 'ns_custom_value' );
            if ( isset($order_types[self::$woocommerce_order_type]) ) {
                self::set_order_type( $order_id, $order_types[self::$woocommerce_order_type]->id, $order_types[self::$woocommerce_order_type]->order_type );
            }
        }

        public static function init_admin_menu_order_type_pages(): void
        {
            if ( is_user_logged_in() && wp_get_current_user()->roles[0] === 'administrator' ) {
                add_submenu_page(
                    'woocommerce',
                    'Order types',
                    'Order types',
                    'edit_posts',
                    'edit_order_types',
                    array( __CLASS__, 'edit_order_types_callback' ),
                    99
                );
            }
        }

        public static function update_ns_order_custbody_values( $internal_id, $woo_order_id = null, $is_success = null, $error_message = null, $record_type = 'sales_order' )
        {
            $file_dir = wp_upload_dir();
            $date = date("Y-m-d");
            $folder_name = 'netsuite-sync-logs';
            $folder_path = $file_dir['basedir'] . '/' . $folder_name;
            $file_name = $folder_path . '/update-ns-' . $date . '.log';

            if (!file_exists($folder_path)) {
                mkdir($folder_path, 0755, true);
            }

            $datetime = date('Y-m-d H:i:s');

            $ns_service = new NetSuiteService();
            if ( $record_type === 'invoice' ) {
                $record = new Invoice();
                $log_file_content = '[' . $datetime . '] Update custbody values in NetSuite - WC Order ' . $woo_order_id . ' / NS Invoice ID: ' . $internal_id . PHP_EOL;
            } elseif ( $record_type === 'return_authorization' ) {
                $record = new ReturnAuthorization();
                $log_file_content = '[' . $datetime . '] Update custbody values in NetSuite - NS Return Authorization ID: ' . $internal_id . PHP_EOL;
            }else {
                $record = new SalesOrder();
                $log_file_content = '[' . $datetime . '] Update custbody values in NetSuite - WC Order ' . $woo_order_id . ' / NS Order Internal ID: ' . $internal_id . PHP_EOL;
            }
            $custom_field_list = new CustomFieldList();

            if ( $woo_order_id !== null ) {
                $field_woo_id = new StringCustomFieldRef();
                $field_woo_id->scriptId = 'custbody_nsi_woo_comm_id';
                $field_woo_id->value = $woo_order_id;
                $custom_field_list->customField[] = $field_woo_id;
                $log_file_content .= 'custbody_nsi_woo_comm_id set to ' . $woo_order_id . PHP_EOL;
            }

            if ( $is_success !== null ) {
                //true = available in search results, false = not displayed in search results
                $field_is_error = new BooleanCustomFieldRef();
                $field_is_error->scriptId = 'custbody_nsi_woo_comm_int';
                $field_is_error->value = $is_success;
                $custom_field_list->customField[] = $field_is_error;
                $log_value = $is_success ? 'TRUE' : 'FALSE';
                $log_file_content .= 'custbody_nsi_woo_comm_int set to ' . $log_value . PHP_EOL;
            }

            if ( $error_message !== null ) {
                if ( mb_strlen( $error_message ) > self::$ns_orders_error_message_characters_limit) {
                    $error_message = mb_substr( $error_message, 0, self::$ns_orders_error_message_characters_limit - 3 ) . '...';
                }
                $field_err_msg = new StringCustomFieldRef();
                $field_err_msg->scriptId = 'custbody_nsi_woo_comm_err_log';
                $field_err_msg->value = $error_message;
                $custom_field_list->customField[] = $field_err_msg;
                $log_file_content .= 'custbody_nsi_woo_comm_err_log set to ' . $error_message . PHP_EOL;
            }

            $record->internalId = $internal_id;
            $record->customFieldList = $custom_field_list;

            $updateRequest = new UpdateListRequest();
            $updateRequest->record = $record;

            try {
                $requestResponse = $ns_service->updateList($updateRequest);
                $result = $requestResponse->writeResponseList->writeResponse[0]->status->isSuccess;
                $log_file_content .= 'update result: ' . ($result ? 'success' : 'error');
                if ( !$result && isset($requestResponse->writeResponseList->writeResponse[0]->status->statusDetail[0]->message) ) {
                    $log_file_content .= 'error message: ' . $requestResponse->writeResponseList->writeResponse[0]->status->statusDetail[0]->message . PHP_EOL;
                }

                file_put_contents( $file_name, $log_file_content . PHP_EOL . PHP_EOL, FILE_APPEND );
                return $result;
            } catch( Exception $e ) {
                $log_file_content .= 'error during update: ' . $e->getMessage() . PHP_EOL;
                file_put_contents( $file_name, $log_file_content . PHP_EOL . PHP_EOL, FILE_APPEND );
                return false;
            }
        }

        public static function set_order_type_name( $order_type_id, $order_type_name )
        {
            global $wpdb;
            $types_table_name = self::$types_table_name;
            $wpdb->query( $wpdb->prepare( "UPDATE $types_table_name SET order_type = %s WHERE ID = %d",
                $order_type_name, $order_type_id )
            );
        }

        public static function edit_order_types_callback()
        {
            if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save-order-types-action']) && isset($_POST['order_type_ids']) ) {
                foreach ( $_POST['order_type_ids'] as $id => $name ) {
                    self::set_order_type_name( $id, $name );
                }
            }

            $order_types = self::get_available_order_types();
            ?>
            <div class="wrap">
                <h1>Order types</h1>
                <div class="page--edit-order-types">
                    <form method="post" action="">
                        <ul class="row row--header">
                            <li class="col--id">ID</li>
                            <li class="col--ns-value">NetSuite value</li>
                            <li class="col--nicename">Display name</li>
                        </ul>

                        <?php
                        foreach ( $order_types as $order_type ) { ?>
                            <ul class="row">
                                <li class="col--id"><?php echo $order_type->id;?></li>
                                <li class="col--ns-value"><?php echo $order_type->ns_custom_value;?></li>
                                <li class="col--nicename">
                                    <input type="text" name="order_type_ids[<?php echo $order_type->id;?>]" value="<?php echo $order_type->order_type;?>" />
                                </li>
                            </ul>
                        <?php } ?>

                        <input type="submit" name="save-order-types-action" id="submit" class="button button-primary" value="Save order types">
                    </form>
                </div>
            </div>
            <?php
        }
    }

}
