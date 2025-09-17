<?php
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

class NS_new_orders_import extends WP_Background_Process {
	
	protected $action = 'ns_new_orders_import';

    protected $ns_order_internal_id;
    protected $order_base_data;

    protected function task( $item ) {
        $orders_data = $this->get_tm_ns_order_item_data( $item );
        if ( empty($orders_data) ) {
            return false;
        }

        global $wpdb;
        $this->set_ns_order_internal_id( $item );
        $this->set_order_base_data();
        $file_name = $this->prepare_log_file('/import-orders-', 'import-orders');
        $datetime = date('Y-m-d H:i:s');
        $log_file_content = '[' . $datetime . '] Start import of NS Order ID ' . $item . PHP_EOL;

        $order_lines_limit = defined('ORDER_MAX_ROWS_ALLOWED') ? ORDER_MAX_ROWS_ALLOWED : 200;
        $line_items_count = count($orders_data);
        if ( $line_items_count > $order_lines_limit ) {
            $error_msg = 'Order lines limit exceeded (max: ' . $order_lines_limit . ').';
            $log_file_content .= 'NS Order could not be imported - NS Order ID: ' . $item . '. ' . $error_msg . PHP_EOL;
            Crown_Order_Types::update_ns_order_custbody_values( $item, '', FALSE, $error_msg );
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            $this->remove_tm_ns_order_item_data($item);
            return false;
        }

        try {
            $this->import_fetched_orders_data($item, $orders_data, $wpdb, $log_file_content);
        } catch ( \Throwable $e ) {
            $log_file_content .= 'Order NS ID ' . $this->ns_order_internal_id . ' not synced due to internal error. Error Message: ' . $e->getMessage();
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            $this->remove_tm_ns_order_item_data($item);
            return false;
        }
        file_put_contents($file_name, $log_file_content . PHP_EOL, FILE_APPEND);
        $this->remove_tm_ns_order_item_data($item);
        return false;
    }

    protected function set_ns_order_internal_id($item) {
        $this->ns_order_internal_id = $item;
    }

    protected function set_order_base_data($args = array()) {
        $this->order_base_data = $args;
    }

    public function import_fetched_orders_data($item, $orders_data, $wpdb, &$log_file_content) {
        $errors = array();
        $coupon_codes = $updated_sku_items = array();
        $product_id = $item_id = 0;
        $product_qty = 1;
        $shipping_data = $items_data = array();
        $ns_shipping_methods = Crown_Shop_Products::get_ns_shipping_methods_from_db();
        $first_row = true;
        $skipped_sku_errors = array();
        foreach ( $orders_data as $order_data ) {
            $is_transaction_discount = false;
            $order_data_array = unserialize($order_data->ns_order_data);
            if ( $first_row ) {
                $ns_customer_id = $order_data_array['customer_join']['internalId'][0]->searchValue->internalId ?? '';
                $ns_parent_customer_id = $order_data_array['customer_join']['parent'][0]->searchValue->internalId ?? '';
                $user_id = $this->get_user_id_by_ns_customer_id($ns_customer_id, $log_file_content);
                $email = $this->get_email($order_data_array, $user_id);
                $current_datetime = date('Y-m-d H:i:s');
                $partner_id = $order_data_array['partner_join']['entityId'][0]->searchValue ?? '';
                $partner_name = $order_data_array['partner_join']['altName'][0]->searchValue ?? '';
                $order_base_data = array(
                    'email' => $email,
                    'date_created' => $order_data_array['basic']['dateCreated'][0]->searchValue ?? $current_datetime,
                    'date_modified' => $order_data_array['basic']['lastModifiedDate'][0]->searchValue ?? $current_datetime,
                    'billing_address' => $this->get_billing_address_data($order_data_array['basic'], $email),
                    'shipping_address' => $this->get_shipping_address_data($order_data_array['basic'], $email),
                    'doc_billing_address' => $order_data_array['basic']['billAddress'][0]->searchValue ?? '',
                    'doc_shipping_address' => $order_data_array['basic']['shipAddress'][0]->searchValue ?? '',
                    'status' => $order_data_array['basic']['status'][0]->searchValue ?? '',
                    'po_number' => $order_data_array['basic']['otherRefNum'][0]->searchValue ?? '',
                    'transaction_id' => $order_data_array['basic']['tranId'][0]->searchValue ?? '',
                    'ns_customer_id' => $ns_customer_id,
                    'ns_parent_customer_id' => $ns_parent_customer_id,
                    'subsidiary_email' => $order_data_array['subsidiary_join']['email'][0]->searchValue ?? '',
                    'subsidiary_name' => $order_data_array['subsidiary_join']['legalName'][0]->searchValue ?? '',
                    'shipping_cost' => $order_data_array['basic']['shippingAmount'][0]->searchValue ?? 0,
                    'order_type' => $this->get_ns_order_type( $order_data_array['basic']['customFieldList'] ),
                    'user_id' => $user_id,
                    'customer_note' => $order_data_array['basic']['memo'][0]->searchValue ?? '',
                    'terms_id' => $order_data_array['basic']['terms'][0]->searchValue->internalId ?? '',
                    'promo_code' => $order_data_array['basic']['promoCode'][0]->searchValue->internalId ?? '',
                    'partner_name' => $partner_id . ' ' . $partner_name,
                );
                $this->set_order_base_data( $order_base_data );
            }

            $amount = $order_data_array['basic']['amount'][0]->searchValue ?? 0;
            $is_discount_line = $amount < 0 ? true : false;
            if ($is_discount_line) {
                $is_transaction_discount = $order_data_array['basic']['transactionDiscount'][0]->searchValue ?? false;
            }
            $amount = abs($amount);
            $price = $order_data_array['basic']['rate'][0]->searchValue ?? 0;
            $qty = $order_data_array['basic']['quantity'][0]->searchValue ?? 0;
            $qty = $qty < 1 ? 1 : $qty;
            $item_sku = $order_data_array['item_join']['itemId'][0]->searchValue ?? '';
            if ( $first_row ) {
                $this->validate_order_base_data( $errors );
            }

            if ( ! class_exists( 'Crown_Shop_Orders' ) ) {
                require_once WP_PLUGIN_DIR . '/crown-shop/classes/class-crown-shop-orders.php';
                Crown_Shop_Orders::init();
            }

            if ( empty($item_sku) ) {
                $errors[] = 'Order item ' . $item_sku . ' missing.';
            } elseif ( ! $is_discount_line && Crown_Shop_Orders::is_errored_sku_skipped($item_sku) ) {
                $skipped_sku_errors[] = $item_sku;
                $log_file_content .= 'SKU importing is skipped due to matching accepted error code: ' . $item_sku . PHP_EOL;
                continue;
            } else {
                $quantity_billed = $order_data_array['basic']['quantityBilled'][0]->searchValue ?? 0;
                $shipping_data[$item_sku] = [
                    'quantity_billed' => $quantity_billed,
                ];
                $log_file_content .= 'Item ' . $item_sku . ' quantity billed: ' . $quantity_billed . PHP_EOL;
                $items_data[$item_sku] = $this->get_items_updated_data( $order_data_array, $qty );
            }
            if ( ( ! $is_discount_line && $price <= 0 ) || ( $is_discount_line && $first_row) ) {
                $errors[] = 'Item price could not be zero or less.';
            }
            if ( ! empty($errors) ) {
                $first_row = false;
                continue;
            }
            $order_id_query = $wpdb->get_results( $wpdb->prepare("SELECT post_id FROM `wp_postmeta` WHERE meta_key = 'ns_order_tran_id' and meta_value = %s",
                $this->order_base_data['transaction_id'],
            ) );

            if ( !empty($order_id_query) ) {
                $order_id = $order_id_query[0]->post_id;
            }
            if ( !empty($order_id) ) {
                $order = new WC_Order( $order_id );
                if ( $first_row ) {
                    $log_file_content .= 'Order already exists in WooCommerce, updating order data instead of creating a new order' . PHP_EOL;
                }
            } else {
                $args = array(
                    'customer_id' => $this->order_base_data['user_id'],
                );
                $order = wc_create_order($args);
                $order_id = $order->get_id();
            }

            if ( $first_row ) {
                $this->update_order_metadata($order, $order_data_array, $log_file_content);
                $this->update_shipping_carrier( $order_data_array, $order_id, $ns_shipping_methods, $log_file_content );
                $this->update_order_shipping_cost($order);
            }
            $order_has_sku = false;
            if ( ! $is_discount_line ) {
                $order_items = $order->get_items();
                foreach ( $order_items ?? [] as $order_item_id => $order_item ) {
                    $product = wc_get_product( $order_item->get_product_id() );
                    if ( ! is_object( $product ) ) {
                        continue;
                    }
                    $sku = $product->get_sku();

                    if ( $sku == $item_sku ) {
                        $order_item->set_props(array('quantity' => $qty));
                        $order_item->set_subtotal($amount);
                        $order_item->set_total($amount);
                        $order_item->save();
                        $order_has_sku = true;
                        $updated_sku_items[] = $item_sku;
                        $item_id = $order_item_id;
                        $product_id = $product->get_id();
                        $product_qty = $qty;
                        $log_file_content .= 'Item ' . $item_sku . ' updated, price: ' . $price . PHP_EOL;
                    }
                }
            }
            if ( !$order_has_sku ) {
                if ( $is_discount_line ) {
                    if ( $is_transaction_discount ) {
                        $price = abs($price);
                        $coupon_code = sanitize_title($this->ns_order_internal_id . '-' . $item_sku);
                        if ( array_key_exists($coupon_code, $coupon_codes) ) {
                            $coupon_codes[$coupon_code]['amount'] += $price;
                        } else {
                            $coupon_codes[$coupon_code] = array(
                                'discount_type' => 'percent',
                                'amount' => $price,
                            );
                        }
                    } else {
                        $coupon_code = sanitize_title($this->ns_order_internal_id . '-' . $item_id . '-' . $item_sku);
                        $coupon_codes[$coupon_code] = array(
                            'discount_type' => 'fixed_product',
                            'amount' => $amount / $product_qty,
                            'product_ids' => array($product_id),
                        );
                    }
                } else {
                    $product_id = wc_get_product_id_by_sku( $item_sku );
                    $order_product = wc_get_product( $product_id );
                    if ( ! is_object( $order_product ) ) {
                        $log_file_content .= 'Item "' . $item_sku . '" not found in WooCommerce' . PHP_EOL;
                        $first_row = false;
                        continue;
                    }

                    $order_product->set_price($price);
                    $item_id = $order->add_product( $order_product, $qty );
                    $new_item = $order->get_item( $item_id );
                    $product_qty = $qty;

                    if ( method_exists( $new_item, 'set_subtotal' ) ) $new_item->set_subtotal( $amount );
                    if ( method_exists( $new_item, 'set_total' ) ) $new_item->set_total( $amount );
                    $new_item->save();
                    $order->add_item( $new_item );
                    $updated_sku_items[] = $item_sku;
                    $log_file_content .= 'Item ' . $item_sku . ' imported, price: ' . $price . PHP_EOL;
                }
            }
            $first_row = false;
        }

        if (!empty($skipped_sku_errors)) {
            $this->order_base_data['ns_order_skipped_sku_errors'] = $skipped_sku_errors;
        }

        if ( empty($errors) ) {
            $order_meta = get_post_meta( $order_id );
            update_post_meta( $order_id, 'shipping_data', json_encode($shipping_data) );
            update_post_meta( $order_id, 'order_items_data', $items_data );
            $this->update_tracking_number( $order_data_array, $order_id, $order_meta, $log_file_content );
            $this->cleanup_unmatched_line_items($order, $updated_sku_items, $log_file_content);
            $this->apply_order_coupons($order, $coupon_codes, $log_file_content);
            $order->calculate_totals();
            $order->save();
            $this->update_order_date($order_id);

            Crown_Order_Types::update_ns_order_custbody_values( $this->ns_order_internal_id, $order_id, FALSE, '' );
            $log_file_content .= 'NS Order ' . $item . ' successfully imported, Woo Order ID: ' . $order_id . PHP_EOL;
        } else {
            $error_msg = implode( ' ', $errors );
            $log_file_content .= 'NS Order could not be imported - NS Order ID: ' . $item . ' / Transaction ID: ' . ($this->order_base_data['transaction_id'] ?? 'missing') . PHP_EOL;
            $log_file_content .= 'Errors: ' . $error_msg . PHP_EOL;
            Crown_Order_Types::update_ns_order_custbody_values( $item, '', FALSE, $error_msg );
        }
    }

    protected function get_email($order_data_array, $user_id) {
        $email = $order_data_array['basic']['email'][0]->searchValue ?? '';
        $email = preg_split('/[\s,]+/', $email)[0] ?? '';
        if (empty($email)) {
            $user = get_userdata($user_id);
            $email = $user ? $user->user_email : '';
        }
        return $email;
    }

    protected function get_shipping_address_data($order_data, string $email) {
        $shipping_addressee = $order_data['shipAddressee'][0]->searchValue ?? '';
        $shipping_addressee_parts = explode(' ', $shipping_addressee, 2);
        $shipping_first_name = $shipping_addressee_parts[0] ?? '';
        $shipping_last_name = $shipping_addressee_parts[1] ?? '';
        $shipping_state = $order_data['shipState'][0]->searchValue ?? '';
        $shipping_country = $order_data['shipCountry'][0]->searchValue ?? '';
        $shipping_address = [
            'first_name' => $shipping_first_name,
            'last_name' => $shipping_last_name,
            'company' => $shipping_first_name . ' ' . $shipping_last_name,
            'email' => $email,
            'phone' => $order_data['shipPhone'][0]->searchValue ?? '',
            'address_1' => $order_data['shipAddress1'][0]->searchValue ?? '',
            'address_2' => $order_data['shipAddress2'][0]->searchValue ?? '',
            'city' => $order_data['shipCity'][0]->searchValue ?? '',
            'state' => $shipping_state,
            'postcode' => $order_data['shipZip'][0]->searchValue ?? '',
            'country' => $this->get_country_code($shipping_country, $shipping_state),
        ];
        return $shipping_address;
    }

    protected function get_billing_address_data($order_data, $email) {
        $billing_addressee = $order_data['billAddressee'][0]->searchValue ?? '';
        $billing_addressee_parts = explode(' ', $billing_addressee, 2);
        $billing_fist_name = $billing_addressee_parts[0] ?? '';
        $billing_last_name = $billing_addressee_parts[1] ?? '';
        $billing_state = $order_data['billState'][0]->searchValue ?? '';
        $billing_country = $order_data['billCountry'][0]->searchValue ?? '';
        $billing_address = [
            'first_name' => $billing_fist_name,
            'last_name' => $billing_last_name,
            'company' => $billing_fist_name . ' ' . $billing_last_name,
            'email' => $email,
            'phone' => $order_data['billPhone'][0]->searchValue ?? '',
            'address_1' => $order_data['billAddress1'][0]->searchValue ?? '',
            'address_2' => $order_data['billAddress2'][0]->searchValue ?? '',
            'city' => $order_data['billCity'][0]->searchValue ?? '',
            'state' => $billing_state,
            'postcode' => $order_data['billZip'][0]->searchValue ?? '',
            'country' => $this->get_country_code($billing_country, $billing_state),
        ];
        return $billing_address;
    }

    protected function get_tm_ns_order_item_data( $ns_order_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_new_orders';
        $order_item = $wpdb->get_results( $wpdb->prepare("SELECT ns_order_data FROM `{$table_name}` WHERE ns_order_id = %s",
            $ns_order_id ) );

        return $order_item;
    }

    protected function get_country_code($country, $state) {
        $country_code = match($country) {
            '_unitedStates','_puertoRico'=>($state == 'PR' || $country == '_puertoRico') ? 'PR' : 'US',
            '_canada'=>'CA',
            '_virginIslandsUSA'=>'VI',
            default=>'',
        };

        return $country_code;
    }

    public function set_order_status($order,  $status) {
        if ( in_array( $status,  array('fullyBilled', 'billed', 'closed') ) ) {
            $order->update_status('completed');
        } else if ($status == 'partiallyFulfilled') {
            $order->update_status('partially-fulfill');
        } else if ($status == 'cancelled') {
            $order->update_status('cancelled');
        } else if ($status == 'pendingBilling') {
            $order->update_status('pending-billing');
        } else if ($status == 'pendingFulfillment' || $status == 'pendingBillingPartFulfilled') {
            $order->update_status('pending-fulfill');
        } else {
            $order->update_status('pending-approval');
        }
    }

    protected function get_ns_order_type($customFieldList) {
        $acceptable_order_types = array(
            'custbody_nsi_spsoriginated',
            'custbody_manual_orders',
            'custbody_nsi_woocommerce',
        );

        foreach ($customFieldList->customField as $customField) {
            if (in_array($customField->scriptId, $acceptable_order_types) && $customField->searchValue === true) {
                $order_type = $customField->scriptId;
            }
        }

        if (empty($order_type)) {
            $order_type = 'custbody_manual_orders';
        }
        return $order_type;
    }

    protected function set_ns_order_type($order_id, $order_type, &$log_file_content) {
        $order_types = Crown_Order_Types::get_available_order_types('ns_custom_value');
        if (!isset($order_types[$order_type])) {
            Crown_Order_Types::add_new_order_type($order_type, $order_type);
            $order_types = Crown_Order_Types::get_available_order_types('ns_custom_value');
        }

        Crown_Order_Types::set_order_type($order_id, $order_types[$order_type]->id, $order_types[$order_type]->order_type);
        update_post_meta($order_id, 'ns_order_type', $order_types[$order_type]->id);
        $log_file_content .= 'Order Type: ' . $order_type . PHP_EOL;
    }

    protected function get_user_id_by_ns_customer_id($ns_customer_id, &$log_file_content) {
        $user_id = '';
        $users = get_users(
            array(
                'meta_key' => 'ns_customer_internal_id',
                'meta_value' => $ns_customer_id
            )
        );

        if (!empty($users)) {
            $user_id = $users[0]->ID;
            $log_file_content .= 'User ID: ' . $user_id . PHP_EOL;
        } else {
            $user_id = $this->import_ns_customer($ns_customer_id);
            $log_file_content .= 'User not found, importing user. Imported user ID: ' . $user_id . PHP_EOL;
        }

        return $user_id;
    }

    protected function import_ns_customer( $ns_customer_id ) {
        $user_id = wp_create_user( $ns_customer_id, md5( $ns_customer_id ), 'customer-' . $ns_customer_id . '@nsiindustries.com' );
        $user = new WP_User( $user_id );
        $user->set_role( 'customer' );
        update_user_meta( $user_id, 'ns_customer_internal_id', $ns_customer_id );
        update_user_meta( $user_id, 'ns_customer_internal_id_imported', $ns_customer_id );

        Crown_Shop_Customers::sync_user_ns_customer_data( $user_id );
        return $user_id;
    }

    protected function validate_order_base_data(&$errors) {
        if (empty($this->order_base_data['email'])) {
            $errors[] = 'Email missing.';
        }

        if (!is_email($this->order_base_data['email'])) {
            $errors[] = 'Invalid email address.';
        }

        if (empty($this->order_base_data['status'])) {
            $errors[] = 'Order status missing.';
        }

        if (empty($this->order_base_data['po_number'])) {
            $errors[] = 'PO number missing.';
        }

        if ($this->po_number_exists($this->order_base_data['user_id'], $this->order_base_data['po_number'])) {
            $errors[] = 'PO number already used.';
        }

        if (empty($this->order_base_data['transaction_id'])) {
            $errors[] = 'Transaction ID missing.';
        }

        if (empty($this->ns_order_internal_id)) {
            $errors[] = 'Order ID missing.';
        }

        if (empty($this->order_base_data['ns_customer_id'])) {
            $errors[] = 'Customer missing.';
        }

        if ($this->order_base_data['order_type'] === 'custbody_nsi_woocommerce') {
            $errors[] = 'This order has been created in WooCommerce. Please remove from Manual/EDI orders sync queue.';
        }

        if (empty($this->order_base_data['user_id'])) {
            $errors[] = 'Customer not found and failed to be imported.';
        }
        return $errors;
    }

    protected function get_items_updated_data( $order_data_array, $qty ) {
        $description = $order_data_array['item_join']['salesDescription'][0]->searchValue ?? '';
        $quantity_billed = $order_data_array['basic']['quantityBilled'][0]->searchValue ?? 0;
        $quantity_committed = $order_data_array['basic']['quantityCommitted'][0]->searchValue ?? 0;
        $rate = $order_data_array['basic']['rate'][0]->searchValue ?? 1;
        $item_amount = $order_data_array['basic']['amount'][0]->searchValue ?? 1;

        $item_data = [
            'description' => $description,
            'quantity' => $qty,
            'quantity_billed' => $quantity_billed,
            'quantity_committed' => $quantity_committed,
            'rate' => $rate,
            'item_amount' => $item_amount,
        ];
        return $item_data;
    }

    protected function po_number_exists($customer_id, $po_number) {
        if ( empty($po_number) || empty($customer_id) ) {
            return false;
        }
        $query = new WC_Order_Query([
            'limit' 		=> -1,
            'orderby' 		=> 'date',
            'order' 		=> 'DESC',
            'customer_id'   => $customer_id,
            'meta_key'      => 'af_c_f_4432739',
            'meta_value'    => $po_number,
            'meta_compare'  => '=',
            'return'        => 'ids'
        ]);

        return !empty($query->get_orders());
    }

    protected function update_order_metadata(&$order, $order_data_array, &$log_file_content) {
        $order_id = $order->get_id();
        $order_meta = get_post_meta( $order_id );
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_internal_id', $this->ns_order_internal_id );
        if (isset($this->order_base_data['order_type'])) {
            $this->set_ns_order_type($order_id, $this->order_base_data['order_type'], $log_file_content);
        }
        $order->set_address($this->order_base_data['billing_address'], 'billing');
        $order->set_address($this->order_base_data['shipping_address'], 'shipping');
        if (!empty($this->order_base_data['doc_billing_address'])) {
            update_post_meta($order_id, 'doc_billing_address', $this->order_base_data['doc_billing_address']);
        }
        if (!empty($this->order_base_data['doc_shipping_address'])) {
            update_post_meta($order_id, 'doc_shipping_address', $this->order_base_data['doc_shipping_address']);
        }
        if (!empty($this->order_base_data['customer_note'])) {
            $order->set_customer_note($this->order_base_data['customer_note']);
        }
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_tran_id', $this->order_base_data['transaction_id'] );
        update_post_meta( $order_id, 'trackingno_email_sent', 'sent' );
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'af_c_f_4432739', $this->order_base_data['po_number'] );
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_status', $this->order_base_data['status'] );
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_external_id', $order_id );
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_customer_id', $this->order_base_data['ns_customer_id'] );
        Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_parent_customer_id', $this->order_base_data['ns_parent_customer_id'] );
        if (!empty($this->order_base_data['ns_order_skipped_sku_errors'])) {
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_skipped_sku_errors', $this->order_base_data['ns_order_skipped_sku_errors'] );
        }
        $this->update_shipping_date( $order_data_array, $order_id, $order_meta, $log_file_content );
        $this->set_order_status($order, $this->order_base_data['status']);
        if (!empty($this->order_base_data['subsidiary_email'])) {
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_subsidiary_email', $this->order_base_data['subsidiary_email'] );
        }
        if (!empty($this->order_base_data['subsidiary_name'])) {
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_subsidiary_name', $this->order_base_data['subsidiary_name'] );
        }
        if (!empty($this->order_base_data['terms_id'])) {
            $ns_terms_label = $this->get_terms_label_by_id($this->order_base_data['terms_id']) ?? '';
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_terms', $ns_terms_label );
        }
        if (!empty($this->order_base_data['promo_code'])) {
            $ns_promo_code_label = $this->get_promo_label_by_id($this->order_base_data['promo_code']) ?? '';
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_promo_code_label', $ns_promo_code_label );
        }
        if (!empty($this->order_base_data['partner_name'])) {
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_partner_name', $this->order_base_data['partner_name'] );
        }
    }

    protected function update_shipping_date( $order_data_array, $order_id, $order_meta, &$log_file_content ) {
        global $TMWNI_OPTIONS;
        if ( !empty($order_data_array['basic']['shipDate']) ) {
            $shipping_date = gmdate('Y-m-d', strtotime($order_data_array['basic']['shipDate'][0]->searchValue));
            $log_file_content .= 'Shipping Date: ' . $shipping_date . PHP_EOL;
            if (isset($TMWNI_OPTIONS['ns_order_pickup_date']) && !empty($TMWNI_OPTIONS['ns_order_pickup_date'])) {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_pickup_date', $shipping_date );
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, $TMWNI_OPTIONS['ns_order_pickup_date'], $shipping_date );
            } else {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_pick_up_date', $shipping_date );
            }
        }
    }

    protected function update_order_shipping_cost(&$order) {
        foreach ( $order->get_items( 'shipping' ) as $item_id => $shipping_item ) {
            $order->remove_item( $item_id );
        }
        $shipping_item = new WC_Order_Item_Shipping();
        $shipping_item->set_method_title( 'Shipping cost' );
        $shipping_item->set_method_id( 'ns_shipping' );
        $shipping_item->set_total( floatval( $this->order_base_data['shipping_cost'] ) );
        $order->add_item( $shipping_item );
    }

    protected function update_shipping_carrier( $order_data_array, $order_id, $ns_shipping_methods, &$log_file_content ) {
        global $TMWNI_OPTIONS;

        if ( !empty($order_data_array['transaction_join']['shipMethod']) ) {
            foreach ( $order_data_array['transaction_join']['shipMethod'] as $ship_method ) {
                $shipping_method_ns_id = $ship_method->searchValue->internalId ?? '';
                if ( empty($shipping_method_ns_id) || !isset($ns_shipping_methods[$shipping_method_ns_id]) ) {
                    return;
                }

                $shipping_method = $ns_shipping_methods[$shipping_method_ns_id];

                if ( isset($TMWNI_OPTIONS['ns_order_shipping_courier']) && !empty($TMWNI_OPTIONS['ns_order_shipping_courier']) ) {
                    $existing_shipping_courier = get_post_meta( $order_id, $TMWNI_OPTIONS['ns_order_shipping_courier'], true );
                    if ( !str_contains($existing_shipping_courier, $shipping_method) ) {
                        $log_file_content .= 'New Shipping Carrier: ' . $shipping_method . PHP_EOL;
                        $existing_shipping_courier .= empty($existing_shipping_courier) ? $shipping_method : ', ' . $shipping_method;
                        update_post_meta( $order_id, 'ns_order_shipping_courier', $existing_shipping_courier );
                        update_post_meta( $order_id, $TMWNI_OPTIONS['ns_order_shipping_courier'], $existing_shipping_courier );
                    }
                } else {
                    $existing_shipping_courier = get_post_meta( $order_id, 'ywot_carrier_name', true );
                    if ( !str_contains($existing_shipping_courier, $shipping_method) ) {
                        $log_file_content .= 'New Shipping Carrier: ' . $shipping_method . PHP_EOL;
                        $existing_shipping_courier .= empty($existing_shipping_courier) ? $shipping_method : ', ' . $shipping_method;
                        update_post_meta( $order_id, 'ywot_carrier_name', $existing_shipping_courier );
                    }
                }
            }
        }
    }

    protected function update_tracking_number( $order_data_array, $order_id, $order_meta, &$log_file_content ) {
        global $TMWNI_OPTIONS;
        $tracking_number = '';
        if (
            isset( $order_data_array['basic']['customFieldList']->customField )
            && is_array( $order_data_array['basic']['customFieldList']->customField )
        ) {
            foreach ( $order_data_array['basic']['customFieldList']->customField as $custom_field ) {
                if ( isset( $custom_field->scriptId ) && $custom_field->scriptId == 'custbody_softeon_tracking_number' ) {
                    $tracking_number = $custom_field->searchValue ?? '';
                    break;
                }
            }
        }

        if ( !empty($tracking_number) ) {
            $is_new_tracking_no = false;
            if ( isset($TMWNI_OPTIONS['ns_order_tracking_number']) && !empty($TMWNI_OPTIONS['ns_order_tracking_number']) ) {
                $existing_tracking_no = $order_meta[$TMWNI_OPTIONS['ns_order_tracking_number']][0] ?? '';
                if ( $existing_tracking_no != $tracking_number ) {
                    $is_new_tracking_no = true;
                    $log_file_content .= 'New tracking number: ' . $tracking_number . PHP_EOL;
                    update_post_meta( $order_id, $TMWNI_OPTIONS['ns_order_tracking_number'], $tracking_number );
                }
            }

            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_tracking_code', $tracking_number );
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_picked_up', 'on' );

            if ( empty(get_post_meta($order_id, 'trackingno_email_sent', true)) || $is_new_tracking_no ) {
                if ( isset($TMWNI_OPTIONS['ns_order_tracking_email']) && !empty($TMWNI_OPTIONS['ns_order_tracking_email']) ) {
                    $wc_emails = WC()->mailer()->get_emails();
                    $wc_emails['WC_NetSuite_Order_Tracking_No']->trigger( $order_id );
                    update_post_meta( $order_id, 'trackingno_email_sent', 'sent' );
                    $log_file_content .= 'Tracking email sent' . PHP_EOL;
                }
            }
        }

    }

    protected function get_terms_label_by_id( $terms_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_terms_labels';

        $terms_label = $wpdb->get_var( $wpdb->prepare("SELECT terms_name FROM `{$table_name}` WHERE ns_terms_id = %s",
            $terms_id ) );

        return $terms_label;
    }

    protected function get_promo_label_by_id( $promo_code_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'ns_promotion_codes';

        $promo_code_label = $wpdb->get_var( $wpdb->prepare("SELECT promo_name FROM `{$table_name}` WHERE ns_promo_id = %s",
            $promo_code_id ) );

        return $promo_code_label;
    }

    protected function remove_tm_ns_order_item_data( $ns_order_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_new_orders';
        $wpdb->query( $wpdb->prepare( "DELETE FROM `{$table_name}` WHERE ns_order_id = %s ", $ns_order_id ) );
    }

    protected function apply_order_coupons($order, $coupon_codes, &$log_file_content) {
        $wc_calc_discounts_changed = false;
        $order_coupon_codes_applied = $order->get_coupon_codes();
        foreach ($order_coupon_codes_applied as $current_coupon_code) {
            if (!empty($coupon_codes) && !isset($coupon_codes[$current_coupon_code])) {
                $order->remove_coupon($current_coupon_code);
                $coupon = new WC_Coupon($current_coupon_code);
                if ($coupon->get_id()) {
                    wp_delete_post($coupon->get_id(), true);
                }
            }
        }

        foreach ($coupon_codes as $coupon_code => $coupon_code_data) {
            if (in_array($coupon_code, $order_coupon_codes_applied)) {
                $coupon = new WC_Coupon($coupon_code);
                if ($coupon->get_id()) {
                    $product_ids = $coupon_code_data['product_ids'] ?? array();
                    $coupon->set_discount_type( $coupon_code_data['discount_type'] );
                    $coupon->set_amount($coupon_code_data['amount']);
                    $coupon->set_product_ids( $product_ids );
                    $coupon->save();
                }
                $this->update_order_coupon_properties($order, $coupon_code, $coupon_code_data);
            } else {
                $coupon_code_id = $this->add_new_discount($coupon_code, $coupon_code_data);
                if ($coupon_code_id) {
                    $applied = $order->apply_coupon($coupon_code);
                    if (is_wp_error($applied)) {
                        $log_file_content .= 'There was an issue with adding coupon "' . $coupon_code . '" to the order.' . PHP_EOL;
                    }
                } else {
                    $log_file_content .= 'There was an issue with adding coupon "' . $coupon_code . '" to the order.' . PHP_EOL;
                }
            }
        }
        $order->recalculate_coupons();
    }

    protected function update_order_coupon_properties($order, $coupon_code, $coupon_code_data) {
        $coupon_items = $order->get_items( 'coupon' );
        foreach ( $coupon_items as $item ) {
            if ( $item->get_code() === $coupon_code ) {
                $args = array(
                    'discount_type' => $coupon_code_data['discount_type'],
                    'discount_amount' => $coupon_code_data['amount'],
                );
                if ( isset( $coupon_code_data['product_ids'] ) ) {
                    $args['product_ids'] = $coupon_code_data['product_ids'];
                } else {
                    $args['product_ids'] = array();
                }
                $order->update_coupon( $item, $args );
            }
        }
    }

    protected function add_new_discount($coupon_code, $coupon_code_data) {
        $coupon = new WC_Coupon();
        $coupon->set_code( $coupon_code );
        $coupon->set_discount_type( $coupon_code_data['discount_type'] );
        $coupon->set_amount( $coupon_code_data['amount'] );
        if ( isset( $coupon_code_data['product_ids'] ) ) {
            $coupon->set_product_ids( $coupon_code_data['product_ids'] );
        }
        $coupon->set_usage_limit( 1 );

        $coupon->save();
        return $coupon->get_code();
    }

    protected function update_order_date($order_id) {
        global $wpdb;
        $date_created = gmdate( 'Y-m-d H:i:s', wc_string_to_timestamp( $this->order_base_data['date_created'] ) );
        $date_modified = gmdate( 'Y-m-d H:i:s', wc_string_to_timestamp( $this->order_base_data['date_modified'] ) );
        $wpdb->update(
            $wpdb->posts,
            array( 'post_date' => $date_created,
                'post_date_gmt' => get_gmt_from_date( $date_created ),
                'post_modified' => $date_modified,
                'post_modified_gmt' => get_gmt_from_date( $date_modified ),
            ),
            array( 'ID' => $order_id )
        );
    }

    protected function cleanup_unmatched_line_items($order, $updated_sku_items, &$log_file_content) {
        $order_items = $order->get_items();
        foreach ( $order_items ?? [] as $item_id => $order_item ) {
            $product_id = $order_item->get_product_id();
            $product = wc_get_product( $product_id );
            if ( ! is_object( $product ) ) {
                $order->remove_item($item_id);
                $log_file_content .= 'Product ID "' . $product_id . '" not found in WooCommerce and was removed from the order.' . PHP_EOL;
                continue;
            }
            $sku = $product->get_sku();

            if ( !in_array($sku, $updated_sku_items) ) {
                $order->remove_item($item_id);
                $log_file_content .= 'Item ' . $sku . ' was removed from the order.' . PHP_EOL;
            }
        }
    }

    public function is_queue_has_items() {
        return false === $this->is_queue_empty();
    }

    public function is_running() {
        return $this->is_process_running();
    }

    protected function prepare_log_file($file_prefix, $sub_folder) {
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
