<?php
defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
    include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

class NS_orders_updates_import extends NS_new_orders_import {

	protected $action = 'ns_orders_updates_import';

    protected function task( $item ) {
        $file_name = $this->prepare_log_file('/update-orders-', 'update-orders');
        $datetime = date( 'Y-m-d H:i:s' );
        $this->set_ns_order_internal_id( $item );

        $log_file_content = '[' . $datetime . '] Start update of NS Order ID ' . $this->ns_order_internal_id . PHP_EOL;

        $orders_data = $this->get_order_update_data( $this->ns_order_internal_id );
        if ( empty($orders_data) ) {
            $log_file_content .= 'Order update data not found' . PHP_EOL;
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            return false;
        }

        $order_id = $this->get_wc_order_id_for_ns_order_id( $this->ns_order_internal_id );
        if ( !$order_id ) {
            $log_file_content .= 'Order NS ID ' . $this->ns_order_internal_id . ' not found in WordPress.';
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            $this->remove_tm_ns_order_update_item_data( $this->ns_order_internal_id );
            Crown_Order_Types::update_ns_order_custbody_values( $this->ns_order_internal_id, null, FALSE, null );
            return false;
        }

        try {
            $this->update_order_with_data_fetched($order_id, $orders_data, $log_file_content);
        } catch ( \Throwable $e ) {
            $log_file_content .= 'Order NS ID ' . $this->ns_order_internal_id . ' not synced due to internal error. Error Message: ' . $e->getMessage();
            file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
            $this->remove_tm_ns_order_update_item_data( $this->ns_order_internal_id );
            return false;
        }
        file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
        $this->remove_tm_ns_order_update_item_data( $item );
        return false;
	}

    public function update_order_with_data_fetched($order_id, $orders_data, &$log_file_content) {
        $shipping_data = $items_data = array();
        $first_row = true;
        $order = new WC_Order( $order_id );
        $order_meta = get_post_meta( $order_id );
        $ns_shipping_methods = Crown_Shop_Products::get_ns_shipping_methods_from_db();
        $coupon_codes = $updated_sku_items = array();
        $product_qty = 1;
        foreach ( $orders_data as $order_data ) {
            $is_transaction_discount = false;
            $order_data_array = unserialize($order_data->ns_order_data);

            if ( $first_row ) {
                $this->update_shipping_date( $order_data_array, $order_id, $order_meta, $log_file_content );
                $this->update_order_status( $order_data_array, $order_id, $order_meta, $log_file_content );
                $email = $order_data_array['basic']['email'][0]->searchValue ?? '';
                $email = preg_split('/[\s,]+/', $email)[0] ?? '';
                $current_datetime = date('Y-m-d H:i:s');
                $partner_id = $order_data_array['partner_join']['entityId'][0]->searchValue ?? '';
                $partner_name = $order_data_array['partner_join']['altName'][0]->searchValue ?? '';
                $order_base_data = array(
                    'date_created' => $order_data_array['basic']['dateCreated'][0]->searchValue ?? $current_datetime,
                    'date_modified' => $order_data_array['basic']['lastModifiedDate'][0]->searchValue ?? $current_datetime,
                    'billing_address' => $this->get_billing_address_data($order_data_array['basic'], $email),
                    'shipping_address' => $this->get_shipping_address_data($order_data_array['basic'], $email),
                    'doc_billing_address' => $order_data_array['basic']['billAddress'][0]->searchValue ?? '',
                    'doc_shipping_address' => $order_data_array['basic']['shipAddress'][0]->searchValue ?? '',
                    'ns_parent_customer_id' => $order_data_array['customer_join']['parent'][0]->searchValue->internalId ?? '',
                    'subsidiary_email' => $order_data_array['subsidiary_join']['email'][0]->searchValue ?? '',
                    'subsidiary_name' => $order_data_array['subsidiary_join']['legalName'][0]->searchValue ?? '',
                    'customer_note' => $order_data_array['basic']['memo'][0]->searchValue ?? '',
                    'shipping_cost' => $order_data_array['basic']['shippingAmount'][0]->searchValue ?? 0,
                    'terms_id' => $order_data_array['basic']['terms'][0]->searchValue->internalId ?? '',
                    'promo_code' => $order_data_array['basic']['promoCode'][0]->searchValue->internalId ?? '',
                    'partner_name' => $partner_id . ' ' . $partner_name,
                );
                $this->set_order_base_data( $order_base_data );
                $this->update_order_metadata($order, $order_data_array, $log_file_content);
                $this->update_order_shipping_cost($order);
            }
            $this->update_shipping_carrier( $order_data_array, $order_id, $ns_shipping_methods, $log_file_content );
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
            if ( !empty($item_sku) ) {
                $quantity_billed = $order_data_array['basic']['quantityBilled'][0]->searchValue ?? 0;
                $shipping_data[$item_sku] = [
                    'quantity_billed' => $quantity_billed,
                ];
                $log_file_content .= 'Item ' . $item_sku . ' quantity billed: ' . $quantity_billed . PHP_EOL;
                $items_data[$item_sku] = $this->get_items_updated_data( $order_data_array, $qty );
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
        update_post_meta( $order_id, 'shipping_data', json_encode($shipping_data) );
        update_post_meta( $order_id, 'order_items_data', $items_data );
        if ( !empty($order_data_array) ) {
            $this->update_tracking_number( $order_data_array, $order_id, $order_meta, $log_file_content );
        }

        $this->cleanup_unmatched_line_items($order, $updated_sku_items, $log_file_content);
        $this->apply_order_coupons($order, $coupon_codes, $log_file_content);
        $order->calculate_totals();
        $order->save();
        $this->update_order_date($order_id);

        Crown_Order_Types::update_ns_order_custbody_values($this->ns_order_internal_id, null, FALSE, null);
        $log_file_content .= 'Order ID ' . $order_id . ' successfully updated' . PHP_EOL;
    }

    protected function update_order_metadata(&$order, $order_data_array, &$log_file_content) {
        $order_id = $order->get_id();
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
        if (!empty($this->order_base_data['subsidiary_email'])) {
            update_post_meta($order_id, 'ns_order_subsidiary_email', $this->order_base_data['subsidiary_email']);
        }
        if (!empty($this->order_base_data['subsidiary_name'])) {
            update_post_meta($order_id, 'ns_order_subsidiary_name', $this->order_base_data['subsidiary_name']);
        }
        if (!empty($this->order_base_data['terms_id'])) {
            $ns_terms_label = $this->get_terms_label_by_id($this->order_base_data['terms_id']) ?? '';
            update_post_meta($order_id, 'ns_order_terms', $ns_terms_label);
        }
        if (!empty($this->order_base_data['promo_code'])) {
            $ns_promo_code_label = $this->get_promo_label_by_id($this->order_base_data['promo_code']) ?? '';
            update_post_meta($order_id, 'ns_promo_code_label', $ns_promo_code_label);
        }
        if (!empty($this->order_base_data['partner_name'])) {
            update_post_meta($order_id, 'ns_order_partner_name', $this->order_base_data['partner_name']);
        }
        if (!empty($this->order_base_data['ns_parent_customer_id'])) {
            update_post_meta($order_id, 'ns_parent_customer_id', $this->order_base_data['ns_parent_customer_id']);
        }
    }

    protected function remove_tm_ns_order_update_item_data( $ns_order_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_orders_updates';
        $wpdb->query( $wpdb->prepare("DELETE FROM `{$table_name}` WHERE ns_order_id = %s ", $ns_order_id) );
    }

    protected function get_order_update_data( $ns_order_id ) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'tm_ns_fetch_orders_updates';
        $orders_data = $wpdb->get_results( $wpdb->prepare("SELECT ns_order_data FROM `{$table_name}` WHERE ns_order_id = %s",
            $ns_order_id
        ) );

        return $orders_data;
    }

    protected function get_wc_order_id_for_ns_order_id( $ns_order_id ) {
        global $wpdb;
        $order_id_query = $wpdb->get_results( $wpdb->prepare("SELECT post_id FROM `wp_postmeta` WHERE meta_key = 'ns_order_internal_id' and meta_value = %s",
            $ns_order_id,
        ) );

        return $order_id_query[0]->post_id ?? false;
    }

    protected function update_order_status( $order_data_array, $order_id, $order_meta, &$log_file_content ) {
        global $TMWNI_OPTIONS;
        if (
            ! empty( $order_data_array['basic']['status'][0]->searchValue )
            && isset( $TMWNI_OPTIONS['ns_order_auto_complete'] ) && ! empty( $TMWNI_OPTIONS['ns_order_auto_complete'] )
        ) {
            $status = $order_data_array['basic']['status'][0]->searchValue;
            $order_status = $order_meta['ns_order_status'][0] ?? '';
            if ( $order_status != $status ) {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_status', $status );
                $log_file_content .= 'NS order status: from ' . $order_status . ' to ' . $status . PHP_EOL;
                $order = new WC_Order( $order_id );
                if ( $status == 'fullyBilled' || $status == 'billed' || $status == 'closed' ) {
                    $order->update_status( 'completed' );
                } else if ( $status == 'partiallyFulfilled' ) {
                    $order->update_status( 'partially-fulfill' );
                } else if ( $status == 'cancelled' ) {
                    $order->update_status( 'cancelled' );
                } else if ( $status == 'pendingBilling' ) {
                    $order->update_status( 'pending-billing' );
                } else if ( $status == 'pendingFulfillment' || $status == 'pendingBillingPartFulfilled' ) {
                    $order->update_status( 'pending-fulfill' );
                } else {
                    // default to pending approval
                    $order->update_status( 'pending-approval' );
                }
            }
        }
    }

}
