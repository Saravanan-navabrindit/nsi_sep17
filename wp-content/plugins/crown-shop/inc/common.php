<?php

function product_purchase_disable($product_id) {
	update_post_meta( $product_id, '_disable_purchase', 'yes' );
}

function product_purchase_enable($product_id) {
	update_post_meta( $product_id, '_disable_purchase', 'no' );
}

function disable_product($product_id) {
	product_purchase_disable($product_id);
	wp_update_post( array(
		'ID'            => $product_id,
		'post_status'   => 'draft',
	) );
}

function enable_product($product_id, $purchasable = TRUE) {
	if ($purchasable) {
		product_purchase_enable($product_id);
	} else {
		product_purchase_disable($product_id);
	}
	wp_update_post( array(
		'ID'            => $product_id,
		'post_status'   => 'publish',
	) );
}

function array_key_exists_ci($key, $array) {
	$keys = array_keys($array);
	$lowercase_keys = array_map('strtolower', $keys);
	return in_array(strtolower($key), $lowercase_keys);
}

function get_value_by_label_ci($label, $record) {
	$label = strtolower($label);
	foreach ($record as $k => $data) {
		if (strtolower($k) === $label) {
			if (is_array($data) && array_key_exists('value', $data)) {
				return $data['value'];
			}
			return $data;
		}
	}
	return null;
}
function get_value_by_key_ci($key, $record) {
	foreach ($record as $data) {
		if (is_array($data) && array_key_exists('id', $data) && $data['id'] == $key) {
			return $data['value'];
		}
	}
	return null;
}