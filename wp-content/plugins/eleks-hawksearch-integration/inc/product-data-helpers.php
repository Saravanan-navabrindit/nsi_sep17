<?php

require_once HAWKSEARCH_PLUGIN_DIR . '/inc/constants.php';
function get_product_indexing_data($product_id) {
	$product = wc_get_product($product_id);
	$image_src = get_product_image_src($product_id);
	$brand = wp_get_post_terms( $product_id, 'product_brand', array( 'number' => 1, 'fields' => 'names' ) );
	$primary_category = get_product_primary_category($product_id);
    $categories = empty($primary_category) ? array() : get_product_categories( $primary_category );
	$min_qty = intval( get_post_meta( $product->get_id(), 'min_quantity', true ) );
	$min_qty = $min_qty < 1 ? 1 : $min_qty;
	$product_data = array(
		'sku' => array( $product->get_sku() ),
		'key' => array( $product_id ),
		'title' => array( $product->get_name() ),
		'description' => array( $product->get_description() ),
		'image' => array( $image_src ),
		'url' => array( get_permalink($product_id) ),
		'price' => array( $product->get_price() ),
		'category' => $categories,
		'brand' => $brand,
		'min_quantity' => array( $min_qty ),
	);
	$product_data = array_merge($product_data, get_product_meta_data($product_id));
	return (object) $product_data;
}

function get_product_categories( $primary_category ) {
    $parent_categories = get_ancestors( $primary_category, 'product_cat' );
    $parent_categories[] = $primary_category;
    return $parent_categories;
}

function get_product_meta_data($product_id) {
	$product_id = intval($product_id);
	$product_meta_array = [];
	$meta_data = get_post_meta($product_id);

	if (is_array($meta_data)) {
		$indexing_attributes = get_indexing_attribute_names();
		foreach ($meta_data as $key => $value) {
			if ( !is_empty_null_or_zero($value) && in_array($key, $indexing_attributes) ) {
				if (is_array($value)) {
					$value = maybe_unserialize(reset($value));
				} else {
					$value = maybe_unserialize($value);
				}
				$product_meta_array[$key] = is_numeric_attribute($key) ? array( convert_to_numeric($value) ) : array( $value );
			}
		}
	}

	return $product_meta_array;
}

function is_empty_null_or_zero(mixed $value): bool {
    return $value === '' || $value === 0 || $value === '0' || $value === null
                         || (is_array($value) && in_array($value[0], ['', 0, '0'], true));
}

function get_product_image_src($product_id) {
	$image_srcs = get_post_meta( $product_id, '__product_image_srcs', false ) ?? '';
	if ( is_array( $image_srcs ) && ! empty( $image_srcs ) ) {
		$image_src = esc_attr( $image_srcs[0] );
	}
	return $image_src;
}

function get_product_primary_category ($product_id) {
	$primary_category = '';
	$primary_category_id = get_post_meta( $product_id, '_primary_term_product_cat', true );
	$categories = wp_get_post_terms( $product_id, 'product_cat' );

	if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
		if ( ! empty( $primary_category_id ) ) {
			foreach ( $categories as $category ) {
				if ( $category->term_id == $primary_category_id ) {
					$primary_category = $category->term_id;
					break;
				}
			}
		}
		if ( ! $primary_category ) $primary_category = $categories[0]->term_id;
	}
	return $primary_category;
}

function get_indexing_attribute_names(): array {
    return INDEXING_ATTRIBUTE_NAMES;
}

function is_numeric_attribute($attribute_name): bool {
    return in_array($attribute_name, NUMERIC_ATTRIBUTE_NAMES);
}

function convert_to_numeric($value) {
	if (strpos($value, '.') !== false) {
		return (float) $value;
	} else {
		return (int) $value;
	}
}
