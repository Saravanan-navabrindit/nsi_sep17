<?php
/**
 * Save Quote Type Attributes.
 *
 * Handles saving the quote type attributes.  Assumes nonce and sanitization have already been done.
 *
 * @package addify-request-a-quote
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$post_title = get_the_title( $post_id );

if ( ! empty( $post_title ) ) {
    update_post_meta( $post_id, 'quote_type_name', sanitize_text_field( $post_title ) );
}

if (isset($form_data['quote_type_is_enabled'])) {
    update_post_meta($post_id, 'quote_type_is_enabled', 'yes');
} else {
    update_post_meta($post_id, 'quote_type_is_enabled', 'no');
}

if (isset($form_data['quote_type_disable_convert_order'])) {
    update_post_meta($post_id, 'quote_type_disable_convert_order', 'yes');
} else {
    update_post_meta($post_id, 'quote_type_disable_convert_order', 'no');
}

if (isset($form_data['quote_type_discount_rules'])) {
    update_post_meta($post_id, 'quote_type_discount_rules', 'yes');
} else {
    update_post_meta($post_id, 'quote_type_discount_rules', 'no');
}

if (isset($form_data['quote_type_min_value_restrictions'])) {
    update_post_meta($post_id, 'quote_type_min_value_restrictions', 'yes');
} else {
    update_post_meta($post_id, 'quote_type_min_value_restrictions', 'no');
}

if (isset($form_data['quote_type_min_value_restrictions'])) {
    update_post_meta($post_id, 'quote_type_min_value_restrictions', 'yes');

    if (isset($form_data['quote_type_min_value_number']) && $form_data['quote_type_min_value_number'] !== '') {
        update_post_meta($post_id, 'quote_type_min_value_number', floatval($form_data['quote_type_min_value_number']));
    } else {
        delete_post_meta($post_id, 'quote_type_min_value_number');
    }
} else {
    update_post_meta($post_id, 'quote_type_min_value_restrictions', 'no');
    delete_post_meta($post_id, 'quote_type_min_value_number');
}

if (isset($form_data['quote_type_bridgeport_brand'])) {
    update_post_meta($post_id, 'quote_type_bridgeport_brand', 'yes');
} else {
    update_post_meta($post_id, 'quote_type_bridgeport_brand', 'no');
}

if (isset($form_data['default_quote_expiry_date'])) {
    update_post_meta($post_id, 'default_quote_expiry_date', 'yes');
} else {
    update_post_meta($post_id, 'default_quote_expiry_date', 'no');
}
