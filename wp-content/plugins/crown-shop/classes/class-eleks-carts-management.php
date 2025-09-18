<?php


if ( ! class_exists( 'Eleks_Carts_Management' ) ) {
	class Eleks_Carts_Management {

        public static $init = false;
        private static int $expiration_shopping_cart_time;
        private static int $expiration_afrfq_cart_time;

        public static function init(): void {
            if (self::$init) return;
            self::$init = true;

            add_action('init', array(__CLASS__, 'add_cron_for_carts_clearing'), 40);
            add_action('init', array(__CLASS__, 'add_cron_for_quotes_clearing'), 50);
            add_action('clear_shopping_carts_cron', array(__CLASS__, 'clear_shopping_carts_cron_handler'));
            add_action('clear_quotes_carts_cron', array(__CLASS__, 'clear_quotes_carts_cron_handler'));
            add_action('wp_ajax_clear_shopping_carts', array(__CLASS__, 'handle_clear_shopping_cart_button'));
            add_action('woocommerce_init', function() {
                add_action('woocommerce_new_order', array(__CLASS__, 'clear_cart_after_new_order'), 999, 1);
            });

            self::$expiration_shopping_cart_time = defined('SHOPPING_CART_EXPIRATION_TIME_SEC') ? SHOPPING_CART_EXPIRATION_TIME_SEC : 0;
            self::$expiration_afrfq_cart_time = defined('AFRFQ_CART_EXPIRATION_TIME_SEC') ? AFRFQ_CART_EXPIRATION_TIME_SEC : 0;

        }

        public static function clear_cart_after_new_order( $order_id ) {
            if (function_exists('WC') && WC()->cart) {
                WC()->cart->empty_cart();
            }
        }

        public static function add_cron_for_carts_clearing(): void {

            if (!wp_next_scheduled('clear_shopping_carts_cron')) {
                $midnight_UTC = new DateTime('tomorrow midnight', new DateTimeZone('UTC'));
                wp_schedule_event($midnight_UTC->getTimestamp(), 'twicedaily', 'clear_shopping_carts_cron');            }
        }

        public static function add_cron_for_quotes_clearing(): void {
            if (!wp_next_scheduled('clear_quotes_carts_cron')) {
                $midnight_UTC = new DateTime('tomorrow midnight', new DateTimeZone('UTC'));
                wp_schedule_event($midnight_UTC->getTimestamp(), 'twicedaily', 'clear_quotes_carts_cron');
            }
        }

        public static function clear_shopping_carts_cron_handler(): void {
            self::clear_shopping_carts(self::$expiration_shopping_cart_time);
        }

        public static function clear_quotes_carts_cron_handler(): void {
            self::clear_quotes_carts(self::$expiration_afrfq_cart_time);
        }

        private static function clear_shopping_carts($exp_time = 0, $unique_id = ''): int {
            $cleared_count = 0;
            $cleared_count += self::clear_shopping_session_carts($exp_time, $unique_id);
            $cleared_count += self::clear_shopping_persistent_carts($exp_time, $unique_id);
            return $cleared_count;
        }

        public static function clear_quotes_carts($exp_time = 0, $unique_id = ''): int {
            $cleared_count = 0;
            $cleared_count += self::clear_quotes_session_carts($exp_time, $unique_id);
            $persistant_arfq_clear_result = self::clear_quotes_persistent_carts($exp_time, $unique_id);
            $cleared_count += $persistant_arfq_clear_result['count'];
            $cleared_count += self::clear_addify_quote_meta($persistant_arfq_clear_result['user_ids']);
            return $cleared_count;
        }

        private static function clear_shopping_session_carts($exp_time = 0, $unique_id = ''): int {
            global $wpdb;
            $cleared_count = 0;

            $query_to_get_all_sessions = "SELECT session_key, session_value, session_expiry FROM {$wpdb->prefix}woocommerce_sessions";
            $where_conditions = [];
            $query_args = [];

            if ($exp_time > 0) {
                $expired_time = time() - $exp_time;
                $where_conditions[] = "session_expiry < %d";
                $query_args[] = $expired_time;
            }

            if (!empty($unique_id)) {
                $where_conditions[] = "session_key = '%s'";
                $query_args[] = $unique_id;
            }

            if (!empty($where_conditions)) {
                $query_to_get_all_sessions .= " WHERE " . implode(' AND ', $where_conditions);
            }

            if (!empty($query_args)) {
                $query_to_get_all_sessions = $wpdb->prepare($query_to_get_all_sessions, $query_args);
            }

            $sessions = $wpdb->get_results($query_to_get_all_sessions);

            if (!empty($sessions)) {
                foreach ($sessions as $session) {
                    $session_data = maybe_unserialize($session->session_value);
                    if (!$session_data || empty($session_data['cart'])) {
                        continue;
                    }
                    $session_data['cart'] = [];
                    $session_data['cart_totals'] = [];
                    $updated_session = maybe_serialize($session_data);

                    $updated = $wpdb->update(
                        "{$wpdb->prefix}woocommerce_sessions",
                        ['session_value' => $updated_session],
                        ['session_key' => $session->session_key]
                    );
                    if ($updated) {
                        $cleared_count++;
                    }
                }
            }

            return $cleared_count;
        }

        private static function clear_shopping_persistent_carts($exp_time = 0, $unique_id = ''): int {
            global $wpdb;
            $cleared_count = 0;
            $query_args = '';
            if( ! empty( $unique_id ) ){
                $query_args = '_woocommerce_persistent_cart_' . $unique_id;
                $meta_query = "SELECT user_id, meta_key, meta_value FROM {$wpdb->usermeta} WHERE meta_key = %s";
            } else {
                $meta_query = "SELECT user_id, meta_key, meta_value FROM {$wpdb->usermeta} WHERE meta_key LIKE '_woocommerce_persistent_cart_%'";
            }
            if (!empty($query_args)) {
                $meta_query = $wpdb->prepare($meta_query, $query_args);
            }

            $persistent_carts = $wpdb->get_results($meta_query);

            if (!empty($persistent_carts)) {
                foreach ($persistent_carts as $cart_entry) {
                    $cart_data = maybe_unserialize($cart_entry->meta_value);

                    if (!$cart_data || empty($cart_data['cart'])) {
                        continue;
                    }

                    if ($exp_time > 0 && isset($cart_data['timestamp'])) {
                        $cart_time = $cart_data['timestamp'];
                        if (time() - $cart_time < $exp_time) {
                            continue;
                        }
                    }

                    $empty_cart = ['cart' => []];
                    if (isset($cart_data['timestamp'])) {
                        $empty_cart['timestamp'] = $cart_data['timestamp'];
                    }

                    $updated = update_user_meta($cart_entry->user_id, $cart_entry->meta_key, $empty_cart);
                    if ($updated) {
                        $cleared_count++;
                    }
                }
            }
            return $cleared_count;
        }

        private static function clear_quotes_session_carts($exp_time = 0, $unique_id = ''): int {
            global $wpdb;
            $cleared_count = 0;
            $query = "SELECT session_key, session_value, session_expiry FROM {$wpdb->prefix}woocommerce_sessions";
            $where_conditions = [];
            $query_args = [];

            if ($exp_time > 0) {
                $expired_time = time() - $exp_time;
                $where_conditions[] = "session_expiry < %d";
                $query_args[] = $expired_time;
            }
            if (!empty($unique_id)) {
                $where_conditions[] = "session_key = '%s'";
                $query_args[] = $unique_id;
            }
            if (!empty($where_conditions)) {
                $query .= " WHERE " . implode(' AND ', $where_conditions);
            }
            if (!empty($query_args)) {
                $query = $wpdb->prepare($query, $query_args);
            }
            $sessions = $wpdb->get_results($query);
            // fetching current user context key(selected_quote_type) for removing it from session value
            $context_key = get_current_user_contextual_quote_type_key();
            if (!empty($sessions)) {
                foreach ($sessions as $session) {
                    $session_data = maybe_unserialize($session->session_value);
                    if (!$session_data || empty($session_data['quotes'])) {
                        continue;
                    }
                    $session_data['quotes'] = [];
                    // Remove selected quote type from session table if applicable
                    if (isset($session_data[$context_key])) {
                        unset($session_data[$context_key]);
                    }
                    $updated_session = maybe_serialize($session_data);
                    $updated = $wpdb->update(
                        "{$wpdb->prefix}woocommerce_sessions",
                        ['session_value' => $updated_session],
                        ['session_key' => $session->session_key]
                    );
                    if ($updated) {
                        $cleared_count++;
                    }
                }
            }
            return $cleared_count;
        }

        private static function clear_quotes_persistent_carts($exp_time = 0, $unique_id = ''): array {
            global $wpdb;
            $cleared_count = 0;
            $affected_user_ids = [];
            $query_args = '';

            if( ! empty( $unique_id ) ){
                $query_args = '_addify_quote-cart_' . $unique_id;
                $meta_query = "SELECT user_id, meta_key, meta_value FROM {$wpdb->usermeta} WHERE meta_key = %s";
            } else {
                $meta_query = "SELECT user_id, meta_key, meta_value FROM {$wpdb->usermeta} WHERE meta_key LIKE '_addify_quote-cart_%'";
            }
            if (!empty($query_args)) {
                $meta_query = $wpdb->prepare($meta_query, $query_args);
            }
            $persistent_quotes = $wpdb->get_results($meta_query);

            if (!empty($persistent_quotes)) {
                foreach ($persistent_quotes as $entry) {
                    $quote_data = maybe_unserialize($entry->meta_value);
                    if (!$quote_data || empty($quote_data['quotes'])) {
                        continue;
                    }
                    if ($exp_time > 0 && isset($quote_data['timestamp'])) {
                        $quote_time = $quote_data['timestamp'];
                        if (time() - $quote_time < $exp_time) {
                            continue;
                        }
                    }
                    $empty_quote = ['quotes' => []];
                    if (isset($quote_data['timestamp'])) {
                        $empty_quote['timestamp'] = $quote_data['timestamp'];
                    }
                    $updated = update_user_meta($entry->user_id, $entry->meta_key, $empty_quote);
                    if ($updated) {
                        $cleared_count++;
                        $affected_user_ids[] = $entry->user_id;
                    }
                }
            }
            return ['count' => $cleared_count, 'user_ids' => $affected_user_ids];
        }

        private static function clear_addify_quote_meta($user_ids = []): int {
            global $wpdb;
            $cleared_count = 0;
            $meta_query = "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = 'addify_quote'";
            if (!empty($user_ids)) {
                $placeholders = implode(',', array_fill(0, count($user_ids), '%d'));
                $meta_query .= " AND user_id IN ($placeholders)";
                $meta_query = $wpdb->prepare($meta_query, $user_ids);
            }
            $users = $wpdb->get_results($meta_query);
            foreach ($users as $user) {
                $deleted = delete_user_meta($user->user_id, 'addify_quote');
                if ($deleted) {
                    $cleared_count++;
                }
            }
            return $cleared_count;
        }


        public static function save_shopping_cart_to_db($from_user_id = null):void {
            if (!$from_user_id) {
                $from_user_id = get_current_user_ID();
            }
            $id = self::get_user_unique_session_id($from_user_id);
            $cart_key = '_woocommerce_persistent_cart_' . $id;
            $current_cart = WC()->cart->get_cart();

            if ($current_cart) {
                $cart_data = array(
                    'cart' => $current_cart,
                    'timestamp' => time()
                );
                update_user_meta($from_user_id, $cart_key, $cart_data);
            }
        }

        public static function restore_shopping_cart_from_db( $user_id ):void {
            $id = self::get_user_unique_session_id($user_id);
            $cart_key = '_woocommerce_persistent_cart_' . $id;
            $cart = get_user_meta($user_id, $cart_key, true);
            WC()->cart->empty_cart();
            if ($cart && isset($cart['cart'])) {
                foreach ($cart['cart'] as $item) {
                    WC()->cart->add_to_cart($item['product_id'], $item['quantity']);
                }
            }
            do_action('woocommerce_cart_loaded_from_session');
        }

        public static function save_quotes_cart_to_db( $user_id = null):void {
            if (!$user_id) {
                $user_id = get_current_user_ID();
            }
            $id = self::get_user_unique_session_id($user_id);
            $quote_key = '_addify_quote-cart_' . $id;
            $quote_contents = wc()->session->get('quotes');
            if ($quote_contents) {
                $quote_data = array(
                    'quotes' => $quote_contents,
                    'timestamp' => time()
                );
                update_user_meta($user_id, $quote_key, $quote_data);
            }
        }

        public static function restore_quotes_cart_from_db($user_id) {
            $id = self::get_user_unique_session_id($user_id);
            $quote_key = '_addify_quote-cart_' . $id;
            $quote_contents = get_user_meta($user_id, $quote_key, true);

            if ($quote_contents) {
                WC()->session->destroy_session();
                WC()->session->set_customer_session_cookie(true);

                $quote_contents = $quote_contents['quotes'] ?? $quote_contents;
                wc()->session->set('quotes', $quote_contents);
            }
        }

        public static function handle_clear_shopping_cart_button() {
            check_ajax_referer('clear_shopping_cart', 'nonce');
            $unique_id = self::get_user_unique_session_id(get_current_user_id());
            self::clear_shopping_carts(0, $unique_id);
            wp_send_json_success();
        }

        public static function get_user_unique_session_id($user_id) {
            $id = $user_id;
            $admin_id = isset($_COOKIE['sac_admin_id']) ? $_COOKIE['sac_admin_id'] : 0;
            if ($user_id != $admin_id && $admin_id != 0) {
                $id .= '_' . $admin_id;
            }
            return $id;
        }
    }
}