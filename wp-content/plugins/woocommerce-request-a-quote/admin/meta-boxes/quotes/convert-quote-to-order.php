<?php
/**
 * Customer information table for email.
 *
 * The WooCommerce quote class stores quote data and maintain session of quotes.
 * The quote class also has a price calculation function which calls upon other classes to calculate totals.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

use Crown\Exceptions\DuplicatePONumberException;
use Crown\Exceptions\EmptyPONumberException;

defined( 'ABSPATH' ) || exit;

global $post;

$quote_contents = get_post_meta( $post->ID, 'quote_contents', true );
$quotes         = $quote_contents;
$customer_id    = get_post_meta( $post->ID, '_customer_user', true );

try {
    $po_number = get_post_meta($post->ID, 'afrfq_field_6453540', true);
    Crown_Shop_Rfq::validate_po_number($customer_id, $po_number);
} catch (DuplicatePONumberException|EmptyPONumberException $exc) {
    Crown_Shop_Rfq::render_error_exception($exc->getMessage(), 'addify_rfq');
    wp_safe_redirect(wp_get_referer());
    return;
}

$quote_order    = wc_create_order();

foreach ( $quote_contents as $quote_item_key => $quote_item ) {


	if ( isset( $quote_item['data'] ) ) {
		$product = $quote_item['data'];
	} else {
		continue;
	}

	if ( ! is_object( $product ) ) {
		continue;
	}
    $price_qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
    $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;

	$price         = $product->get_price();
    $price         = $price * $price_qty_multiplier;
	$qty_display   = $quote_item['quantity'];
	$offered_price = isset( $quote_item['offered_price'] ) ? floatval( $quote_item['offered_price'] ) : $price;
	$approved_price = isset( $quote_item['approved_price'] ) ? floatval( $quote_item['approved_price'] ) : $offered_price;

    $product->set_price( $approved_price / $price_qty_multiplier );

	$item_id = $quote_order->add_product( $product, $qty_display );
	$item    = $quote_order->get_item( $item_id );

	if ( method_exists( $item, 'set_subtotal' ) ) $item->set_subtotal( ( $approved_price / $price_qty_multiplier ) * $qty_display );
	if ( method_exists( $item, 'set_total' ) ) $item->set_total( ( $approved_price / $price_qty_multiplier ) * $qty_display );
	$item->save();
	$quote_order->add_item( $item );

	if ( ! empty( $quote_item['addons'] ) && class_exists('WC_Product_Addons_Helper') ) {
		foreach ( $quote_item['addons'] as $addon ) {
			$key           = $addon['name'];
			$price_type    = $addon['price_type'];
			$product       = $item->get_product();
			$product_price = $product->get_price();

			/*
			 * For percentage based price type we want
			 * to show the calculated price instead of
			 * the price of the add-on itself and in this
			 * case its not a price but a percentage.
			 * Also if the product price is zero, then there
			 * is nothing to calculate for percentage so
			 * don't show any price.
			 */
			if ( $addon['price'] && 'percentage_based' === $price_type && 0 != $product_price ) {
				$addon_price = $product_price * ( $addon['price'] / 100 );
			} else {
				$addon_price = $addon['price'];
			}
			$price = html_entity_decode(
				wp_strip_all_tags( wc_price( WC_Product_Addons_Helper::get_product_addon_price_for_display( $addon_price, $product ) ) ),
				ENT_QUOTES,
				get_bloginfo( 'charset' )
			);

			/*
			 * If there is an add-on price, add the price of the add-on
			 * to the label name.
			 */
			if ( $addon['price'] && apply_filters( 'woocommerce_addons_add_price_to_name', true ) ) {
				$key .= ' (' . $price . ')';
			}

			if ( 'custom_price' === $addon['field_type'] ) {
				$addon['value'] = $addon['price'];
			}

			$item->add_meta_data( $key, $addon['value'] );
			$item->save();
		}
	}
}

$customer_name  = $post->afrfq_name_field;
$customer_email = $post->afrfq_email_field;

$quote_user = get_user_by( 'id', $customer_id );

$af_fields_obj = new AF_R_F_Q_Quote_Fields();

$billing_address  = $af_fields_obj->afrfq_get_billing_data( $post->ID );
$shipping_address = $af_fields_obj->afrfq_get_shipping_data( $post->ID );

$quote_order->set_address( $billing_address, 'billing' );
$quote_order->set_address( $shipping_address, 'shipping' );
$quote_order->set_customer_id( intval( $customer_id ) );

$quote_order->calculate_totals(); // updating totals.

$quote_order->save(); // Save the order data.

$current_admin = wp_get_current_user();

$current_admin = isset( $current_admin->ID ) ? (string) $current_admin->user_login : 'Admin';

update_post_meta( $post->ID, 'quote_status', 'af_converted' );
update_post_meta( $post->ID, 'converted_by_user', $current_admin );
update_post_meta( $post->ID, 'converted_by', __( 'Administrator', 'addify_rfq' ) );

do_action('addify_rfq_quote_converted_to_order', $quote_order->get_id(), $post->ID );

do_action( 'addify_rfq_send_quote_email_to_customer', $post->ID );
do_action( 'addify_rfq_send_quote_email_to_admin', $post->ID );

wp_safe_redirect( $quote_order->get_edit_order_url() );
exit;
