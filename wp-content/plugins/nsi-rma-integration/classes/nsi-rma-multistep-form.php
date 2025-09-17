<?php
if ( !defined('ABSPATH') ) exit;

if ( ! class_exists( 'NSI_RMA_Multistep_Form' ) ) {
    class NSI_RMA_Multistep_Form {
        public static $init = false;
        public static $rma_disclaimer_settings = array(
            'item_returned' => 'Item Returned',
            'item_discontinued' => 'Item Discontinued',
            'item_not_returnable' => 'Item Not Returnable',
            'item_not_shipped' => 'Item Not Shipped',
            'order_returned' => 'Order Not Available for Return',
            'return_fees_notice' => 'Re-stocking fees may apply as per the Return Policy.',
        );

        public static array $returned_items = array();

        public static function init() {
            if( self::$init ) {
                return;
            }
            self::$init = true;

            self::get_rma_configured_disclaimer_settings();
            add_action( 'init', array(  __CLASS__, 'rma_add_endpoints' ) );
            add_action( 'woocommerce_account_initiate-rma_endpoint', array(  __CLASS__, 'initiate_rma_endpoint_url' ) );
            add_shortcode('initiate_rma_form', array(  __CLASS__, 'initiate_rma_form_shortcode') );
        }

        public static function rma_add_endpoints() {
            add_rewrite_endpoint('initiate-rma', EP_ROOT | EP_PAGES);
        }

        public static function initiate_rma_endpoint_url() {
            echo do_shortcode('[initiate_rma_form]');
        }

        public static function initiate_rma_form_shortcode() {
            if (!is_user_logged_in()) return '<p>' . __( 'You must be logged in to view this page.', 'nsi-rma' ) . '</p>';
            $step = isset($_GET['step']) ? intval($_GET['step']) : 1;

            if ($step === 2) {
                $form = self::get_order_items_selector_form();
            } elseif ($step === 3) {
                $form = self::get_rma_confirmation_form();
            } else {
                $form = self::get_order_selector_form();
            }
            return $form;
        }

        public static function is_rma_form() {
            return get_query_var('initiate-rma', false) !== false;
        }

        public static function get_rma_configured_disclaimer_settings() {
            $disclaimer_settings = get_option( 'returns_settings_disclaimers', array() );
            foreach ( $disclaimer_settings as $key => $value ) {
                if ( ! empty( $value ) ) {
                    self::$rma_disclaimer_settings[$key] = $value;
                }
            }
        }

        public static function get_order_selector_form() {
            $data = WC()->session->get('return_request_data') ?: [];
            self::handle_order_selector_form_submission( $data );
            $user_id = get_current_user_id();
            $months_for_return = self::get_months_for_orders_returns( $user_id );
            $order_period_limit = (new DateTime())->sub(new DateInterval('P' . $months_for_return . 'M'))->format('Y-m-d H:i:s');
            $customer_orders = wc_get_orders(
                apply_filters(
                    'woocommerce_my_account_my_orders_query',
                    array(
                        'customer' => $user_id,
                        'limit'       => -1,
                        'orderby'     => 'date',
                        'order'       => 'DESC',
                        'date_created'  => '>' . $order_period_limit,
                    )
                )
            );

            $has_orders = ! empty( $customer_orders );

            ob_start();

            wc_print_notices();
            do_action( 'woocommerce_before_account_orders', $has_orders );
            if ( ! $has_orders ) {
                echo '<p>' . __( 'There are no orders to request a return for.', 'nsi-rma' ) . '</p>';
                return ob_get_clean();
            }
            add_filter('woocommerce_my_account_my_orders_columns', array(  __CLASS__, 'remove_order_actions_column'), 20);

            wc_get_template('rma-order-select-form.php',
                array(
                    'has_orders'      => $has_orders,
                    'customer_orders' => $customer_orders,
                    'tooltip_text' => self::$rma_disclaimer_settings['order_returned'],
                    'current_user' => wp_get_current_user(),
                    'order_count' => -1,
                ),
                '/woocommerce/rma/',
                plugin_dir_path( __FILE__ ) . '../templates/forms/');

            return ob_get_clean();
        }

        public static function get_order_items_selector_form() {
            $data = WC()->session->get('return_request_data') ?: [];
            self::handle_order_items_selector_form_submission( $data );

            $order_id = $data['order_id'] ?? 0;
            $order = wc_get_order($order_id);

            if (!$order || $order->get_user_id() !== get_current_user_id()) {
                return '<p>' . __( 'Invalid order selected.', 'nsi-rma' ) . '</p>';
            }
            $selected_items = $data['items'] ?? [];
            $order_return_reason = $data['order_return_reason'] ?? '';
            $customer_note = $data['customer_note'] ?? '';
            $shipping_data = get_post_meta( $order_id, 'shipping_data', true );
            $shipping_data = json_decode( $shipping_data, true );
            self::$returned_items = self::get_order_items_returned( $order_id );
            ob_start();

            wc_get_template('rma-order-items-selector-form.php',
                array(
                    'order'      => $order,
                    'selected_items' => $selected_items,
                    'shipping_data' => $shipping_data,
                    'order_return_reason' => $order_return_reason,
                    'customer_note' => $customer_note,
                ),
                '/woocommerce/rma/',
                plugin_dir_path( __FILE__ ) . '../templates/forms/');

            return ob_get_clean();
        }

        public static function get_rma_confirmation_form() {
            $data = WC()->session->get('return_request_data') ?: [];
            self::handle_rma_confirmation_form_submission( $data );

            $order_id = $data['order_id'] ?? 0;
            $order = wc_get_order($order_id);

            if (!$order || $order->get_user_id() !== get_current_user_id()) {
                return '<p>' . __( 'Invalid order selected.', 'nsi-rma' ) . '</p>';
            }

            $reason_label = ! empty( $data['order_return_reason'] ) ? self::get_return_reason_label( $data['order_return_reason'] ) : '';
            ob_start();

            wc_get_template('rma-confirmation-form.php',
                array(
                    'order_id'            => $order_id,
                    'order'               => $order,
                    'return_reason'       => $reason_label,
                    'data'                => $data,
                    'return_policy_url'   => self::get_return_policy_url(),
                ),
                '/woocommerce/rma/',
                plugin_dir_path( __FILE__ ) . '../templates/forms/');

            return ob_get_clean();
        }

        public static function handle_order_selector_form_submission( $data ) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['selected_order'])) {
                return;
            }

            if ( !isset($_POST['rma_order_selection_nonce']) || !wp_verify_nonce($_POST['rma_order_selection_nonce'], 'rma_order_selection_nonce') ) {
                return;
            }
            if ( ! isset($data['order_id']) || $data['order_id'] != $_POST['selected_order'] ) {
                WC()->session->set('return_request_data', array(
                    'order_id' => absint($_POST['selected_order']),
                ));
            }
            wp_redirect(add_query_arg(['step' => 2]));
            exit;
        }

        public static function handle_order_items_selector_form_submission( $data ) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['next_step'])) {
                return;
            }

            if ( !isset($_POST['rma_order_items_selection_nonce']) || !wp_verify_nonce($_POST['rma_order_items_selection_nonce'], 'rma_order_items_selection_nonce') ) {
                return;
            }
            $data['items'] = $_POST['selected_items'] ?? [];
            $data['order_return_reason'] = sanitize_text_field($_POST['order_return_reason']);
            $data['customer_note'] = sanitize_textarea_field($_POST['customer_note']);
            WC()->session->set('return_request_data', $data);
            wp_redirect(add_query_arg(['step' => 3]));
            exit;
        }

        public static function handle_rma_confirmation_form_submission( $data ) {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST'
                || !isset($_POST['rma_submission_token'])
                || !isset($_POST['rma_confirmation_nonce'])
            ) {
                return;
            }
            if ( !wp_verify_nonce($_POST['rma_confirmation_nonce'], 'rma_confirmation_nonce') ) {
                return;
            }

            $user_id = get_current_user_id();
            $submitted_token = sanitize_text_field($_POST['rma_submission_token']);

            if ( get_transient( 'rma_form_token_' . $user_id ) !== $submitted_token ) {
                return;
            }

            delete_transient( 'rma_form_token_' . $user_id );

            $order_id = $data['order_id'] ?? 0;
            if ( ! empty( $order_id ) && !empty( $data['items'] ) ) {
                $user_id = get_current_user_id();
                $ns_order_tran_id = get_post_meta( $order_id, 'ns_order_tran_id', true );
                $po_number = get_post_meta( $order_id, 'af_c_f_4432739', true );

                $post_id = wp_insert_post([
                    'post_type'    => 'rma',
                    'post_status'  => 'publish',
                    'post_title'   => 'Return Request for Order #' . $order_id . ' (' . $ns_order_tran_id . ' / ' . $po_number . ')',
                    'post_author'  => $user_id,
                ]);

                if ( ! is_wp_error( $post_id ) ) {
                    $order = wc_get_order( $order_id );
                    $order_meta = get_post_meta( $order_id );
                    $ns_order_customer_id = $order_meta['ns_order_customer_id'][0] ?? '';
                    $items_data = self::get_returned_items_data($order, $data['items']);
                    $return_reason_id = $data['order_return_reason'];
                    $reason_label = self::get_return_reason_label( $return_reason_id );
                    $rma_postmeta = array(
                        'rma_status' => 'pendingApproval',
                        'ns_customer_entity_id' => $ns_order_customer_id,
                        'order_id' => $order_id,
                        'ns_order_tran_id' => $ns_order_tran_id,
                        'customer_po_number' => $po_number,
                        'order_currency' => $order->get_currency(),
                        'items' => $items_data,
                        'order_return_reason' => $return_reason_id,
                        'order_return_reason_label' => $reason_label,
                        'customer_note' => $data['customer_note'],
                    );
                    foreach ( $rma_postmeta as $meta_key => $meta_value ) {
                        update_post_meta($post_id, $meta_key, $meta_value);
                    }

                    WC()->session->__unset('return_request_data');

                    wc_add_notice('Your Return Request has been submitted.', 'success');
                    $is_success = NSI_NS_API::send_return_to_ns( $post_id );
                    wp_safe_redirect(wc_get_account_endpoint_url('dashboard'));
                    exit;
                } else {
                    wc_add_notice('Error: Failed to create return request.', 'error');
                }
            } else {
                wc_add_notice('Please complete all required fields before submitting.', 'error');
            }
        }

        public static function remove_order_actions_column($columns) {
            if ( ! ( is_account_page() && self::is_rma_form() ) ) return $columns;

            if (isset($columns['order-actions'])) {
                unset($columns['order-actions']);
            }

            return $columns;
        }

        public static function get_order_items_returned( $order_id ) {
            global $wpdb;

            if (empty($order_id)) {
                return array();
            }

            $results = $wpdb->get_col($wpdb->prepare(
                "SELECT pm.meta_value
                        FROM {$wpdb->posts} p
                        INNER JOIN {$wpdb->postmeta} pm_order 
                            ON p.ID = pm_order.post_id AND pm_order.meta_key = 'order_id'
                        INNER JOIN {$wpdb->postmeta} pm 
                            ON p.ID = pm.post_id AND pm.meta_key = 'items'
                        WHERE p.post_type = %s
                        AND p.post_status = 'publish'
                        AND pm_order.meta_value = %s",
                'rma',
                $order_id
            ));

            $returned_items = array();

            foreach ($results as $result) {
                $items = maybe_unserialize($result);
                if (is_array($items)) {
                    $returned_items = array_merge($returned_items, array_keys($items));
                }
            }

            return array_values( array_unique( $returned_items ) );
        }

        public static function is_order_available_for_return($order) {
            $order_id = $order->ID;
            $order_items_returned = self::get_order_items_returned( $order_id );
            $shipping_data = get_post_meta( $order_id, 'shipping_data', true );
            $shipping_data = json_decode( $shipping_data, true );
            foreach ($order->get_items() as $item_id => $item) {
                if ( in_array( $item_id, $order_items_returned ) ) {
                    continue;
                }
                $product = $item->get_product();
                if ( ! $product || ! $product->exists() ) {
                    continue;
                }
                if ( ! self::is_item_shipped($product, $item->get_quantity(), $shipping_data) ) {
                    continue;
                }
                $discontinued = get_post_meta( $product->get_id(), 'ns_discontinued_item_flag', true ) ?? 'no';
                if ($discontinued === 'yes') {
                    continue;
                }
                $returnable = get_post_meta( $product->get_id(), 'ns_returnable_item_flag', true ) ?? 'yes';
                if ($returnable === 'no') {
                    continue;
                }
                return true;
            }
            return false;
        }

        public static function is_item_shipped($product, $ordered_qty, $shipping_data) {
            $quantity_billed = 0;
            if ( ! empty( $shipping_data ) && isset( $shipping_data[$product->get_sku()]['quantity_billed'] ) ) {
                $quantity_billed = $shipping_data[$product->get_sku()]['quantity_billed'];
            }
            if ( $quantity_billed < $ordered_qty ) {
                return false;
            }
            return true;
        }

        public static function get_tooltip_attr_if_item_disabled( $item_id, $product, $quantity, $shipping_data ) {
            $tooltip = '';

            if ( in_array( $item_id, self::$returned_items ) ) {
                return self::$rma_disclaimer_settings['item_returned'];
            }

            $discontinued = get_post_meta( $product->get_id(), 'ns_discontinued_item_flag', true ) ?? 'no';
            if ($discontinued === 'yes') {
                return self::$rma_disclaimer_settings['item_discontinued'];
            }

            $returnable = get_post_meta( $product->get_id(), 'ns_returnable_item_flag', true ) ?? 'yes';
            if ($returnable === 'no') {
                return self::$rma_disclaimer_settings['item_not_returnable'];
            }

            if ( ! self::is_item_shipped($product, $quantity, $shipping_data)) {
                return self::$rma_disclaimer_settings['item_not_shipped'];
            }
            return $tooltip;
        }

        public static function get_months_for_orders_returns($user_id) {
            $months_for_return = get_option('returns_settings_months_for_return', 12);
            $option_value = get_option('returns_settings_months_for_return_customers');
            $months_for_return_customers = $option_value['data'] ?? array();
            if ( ! empty( $months_for_return_customers ) ) {
                $rows = count( $months_for_return_customers['customer-prefix'] );
                for ( $i = 0; $i <= $rows; $i++ ) {
                    $prefix = $months_for_return_customers['customer-prefix'][$i];
                    $user_name = get_user_meta($user_id, 'nickname', true);
                    if ( str_starts_with( strtolower( trim( $user_name ) ), strtolower( trim( $prefix ) ) ) ) {
                        $months_for_return = $months_for_return_customers['customer-months'][$i] ?? $months_for_return;
                        break;
                    }
                }
            }
            return $months_for_return;
        }

        public static function get_return_policy_url() {
            $return_policy_url = '#';
            $return_policy_page_id = get_option('returns_settings_return_policy_page', '');
            if ($return_policy_page_id) {
                $return_policy_url = get_permalink($return_policy_page_id);
            }
            return $return_policy_url;
        }

        public static function get_returned_items_data($order, $returned_items) {
            $items_data = array();
            foreach ($order->get_items() as $item_id => $item) {
                if (!in_array($item_id, $returned_items)) continue;
                $product = $item->get_product();
                if (!$product || !$product->exists()) {
                    continue;
                }
                $qty = $item->get_quantity() ?? 1;
                $total = $item->get_total() ?? 0;
                $items_data[$item_id] = array(
                    'sku' => $product->get_sku() ?? '',
                    'name' => $product->get_name() ?? '',
                    'qty' => $qty,
                    'rate' => $total / $qty,
                    'subtotal' => $total,
                    'product_id' => $product->get_id(),
                );
            }
            return $items_data;
        }

        public static function get_return_reason_label($return_reason) {
            $reason_label = '';
            $reasons_settings = get_option('returns_settings_reasons');
            $returns_reasons = $reasons_settings['data'] ?? array();
            foreach ($returns_reasons['reason-key'] as $id => $reason_key) {
                if ($reason_key == $return_reason) {
                    $reason_label = $returns_reasons['reason-label'][$id];
                }
            }
            return $reason_label;
        }
    }
}

NSI_RMA_Multistep_Form::init();