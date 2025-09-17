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

defined( 'ABSPATH' ) || exit;

global $post;
$quote_id = $post->ID;

// Update customer info.
$af_fields_obj = new AF_R_F_Q_Quote_Fields();
$quote_fields  = $af_fields_obj->afrfq_get_fields_enabled();

foreach ( $quote_fields as $key => $field ) {

	$field_id          = $field->ID;
	$afrfq_field_name  = get_post_meta( $field_id, 'afrfq_field_name', true );
	$afrfq_field_type  = get_post_meta( $field_id, 'afrfq_field_type', true );
	$afrfq_field_label = get_post_meta( $field_id, 'afrfq_field_label', true );

	if ( isset( $form_data[ $afrfq_field_name ] ) && ! empty( $form_data[ $afrfq_field_name ] ) ) {

		if ( 'file' === $afrfq_field_type ) {

			continue;
			
		} else {

			update_post_meta( $quote_id, $afrfq_field_name, $form_data[ $afrfq_field_name ] );
		}
	}
}

if ( isset( $form_data['_customer_user'] ) ) {
	update_post_meta( $quote_id, '_customer_user', $form_data['_customer_user'] );
}

$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );

$quotes = $quote_contents;
$change_status = false;
$warning_msgs = [];
$price_base_type = get_post_meta( $quote_id, '_price_base_type', true );
if ( empty($price_base_type) ) {
    $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
}

foreach ( $quote_contents as $quote_item_key => $quote_item ) {

    $min_qty = intval( get_post_meta( $quote_item['product_id'], 'min_quantity', true ) );
    if ( isset( $form_data['quote_qty'][ $quote_item_key ] ) ) {
        if ( $min_qty != 0 && $min_qty != 1 && $min_qty != $form_data['quote_qty'][ $quote_item_key ] && $form_data['quote_qty'][ $quote_item_key ] % $min_qty != 0 ) {
            $warning_msgs[] = 'Error during Quote ' . $quote_id . ' update: Minimum allowed quantity of ' . $quote_item['data']->get_data()['sku'] . ' is ' . $min_qty . '. Product quantity has to be equal to ' . $min_qty . ' or a multiple of it.';
            continue;
        }
        if ( $form_data['quote_qty'][ $quote_item_key ] != $quotes[ $quote_item_key ]['quantity'] ) {
            $change_status = true;
        }
		$quotes[ $quote_item_key ]['quantity'] = intval( $form_data['quote_qty'][ $quote_item_key ] );
	}
    if ($price_base_type === 'moq') {
        $quote_price_base = $min_qty < 1 ? 1 : $min_qty;
    } else {
        $quote_price_base = get_post_meta($quote_item['product_id'], 'ns_price_qty_multiplier', true);
        $quote_price_base = floatval($quote_price_base) > 0 ? floatval($quote_price_base) : 1;
    }
    if ( isset( $form_data['offered_price'][ $quote_item_key ] ) ) {
        if ( $form_data['offered_price'][ $quote_item_key ] != $quotes[ $quote_item_key ]['offered_price'] ) {
            $change_status = true;
        }
        $offered_price = floatval( $form_data['offered_price'][ $quote_item_key ] );
		$quotes[ $quote_item_key ]['offered_price'] = $offered_price;
		$quotes[ $quote_item_key ]['offered_price_per_each'] = $offered_price / $quote_price_base;
	}

	if ( isset( $form_data['approved_price'][ $quote_item_key ] ) ) {
        if ( $form_data['approved_price'][ $quote_item_key ] != $quotes[ $quote_item_key ]['approved_price'] ) {
            $change_status = true;
        }
        $approved_price = floatval( $form_data['approved_price'][ $quote_item_key ] );
		$quotes[ $quote_item_key ]['approved_price'] = $approved_price;
		$quotes[ $quote_item_key ]['approved_price_per_each'] = $approved_price / $quote_price_base;
	}
}

if ( !empty($warning_msgs) ) {
    update_post_meta( $quote_id, 'quote_update_warnings', json_encode( $warning_msgs ) );
}

update_post_meta( $quote_id, 'quote_contents', $quotes );

$quote_type = get_post_meta( $quote_id, 'quote_type', true );
if ( empty( $quote_type ) && isset( $form_data['quote_type'] ) ) {
    $quote_type = $form_data['quote_type'];
}

update_post_meta($quote_id, 'quote_type', $quote_type ?? '');

if ( isset( $form_data['afrfq_shipping_cost'] ) ) {
	update_post_meta( $quote_id, 'afrfq_shipping_cost', sanitize_text_field( wp_unslash( $form_data['afrfq_shipping_cost'] ) ) );
}

do_action('addify_quote_contents_updated', $quote_id );

$current_status = get_post_meta( $quote_id, 'quote_status', true );
if ( $change_status && $current_status == 'af_accepted' ) {
    update_post_meta( $quote_id, 'old_status', 'af_pending' );
    update_post_meta( $quote_id, 'quote_status', 'af_pending' );

    do_action( 'addify_rfq_quote_status_updated', $quote_id, 'af_pending', $current_status );
} else if ( isset( $form_data['quote_status'] ) ) {
	update_post_meta( $quote_id, 'old_status', $form_data['quote_status'] );
	update_post_meta( $quote_id, 'quote_status', $form_data['quote_status'] );

	do_action( 'addify_rfq_quote_status_updated', $quote_id, $form_data['quote_status'], $current_status );
}

if ( 'yes' === $form_data['afrfq_notify_customer'] ) {
	do_action( 'addify_rfq_send_quote_email_to_customer', $quote_id );
	do_action( 'addify_rfq_send_quote_email_to_admin', $quote_id );
}
