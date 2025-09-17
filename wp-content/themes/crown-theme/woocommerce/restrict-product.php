<?php

defined('ABSPATH') || exit;

// Display checkbox.
add_action( 'woocommerce_product_options_general_product_data', 'add_restrict_product_checkbox' );
function add_restrict_product_checkbox() {
	echo '<div class="options_group">';
	woocommerce_wp_checkbox([
		'id' => 'ns_restricted_item_flag',
		'wrapper_class' => '',
		'custom_attributes' => array(
			'disabled' => 'true',
		),
		'label' => 'Restricted item',
	]);
	echo '</div>';
}

// Add column to product list.
add_filter('manage_edit-product_columns', 'add_restricted_item_column');
function add_restricted_item_column($columns) {
    $columns['restricted_item'] = 'Restricted item';
    return $columns;
}

// Make the 'Restricted item' column sortable.
add_filter('manage_edit-product_sortable_columns', 'make_restricted_item_column_sortable');
function make_restricted_item_column_sortable($columns) {
    $columns['restricted_item'] = 'restricted_item';
    return $columns;
}

// Define the custom sorting logic.
add_action('pre_get_posts', 'restricted_item_column_orderby');
function restricted_item_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if($query->get('orderby') === 'restricted_item' && $_GET['order'] == 'desc') {
		$query->set('meta_key', 'ns_restricted_item_flag');
		$query->set('orderby', 'meta_value');
		$query->set('order', 'desc');
	} elseif ($query->get('orderby') === 'restricted_item' && $_GET['order'] == 'asc') {
		$query->set('meta_key', 'ns_restricted_item_flag');
		$query->set('orderby', 'meta_value');
		$query->set('order', 'asc');
	}
}

// Display checkbox value in the column.
add_action('manage_product_posts_custom_column', 'display_restricted_item_column', 10, 2);
function display_restricted_item_column($column, $post_id) {
    if ($column == 'restricted_item') {
        $value = get_post_meta($post_id, 'ns_restricted_item_flag', true);

        echo $value === 'yes' ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>';
    }
}
// Hide checkout button.
add_filter( 'woocommerce_is_purchasable', 'disable_restricted_product_purchase', 10, 2 );
function disable_restricted_product_purchase($is_purchasable, $product) {
    $user_id = get_current_user_id();
    return is_allowed_restricted_product_purchase($is_purchasable, $product, $user_id);
}

function is_allowed_restricted_product_purchase($is_purchasable, $product, $user_id) {
    if ($is_purchasable && $product->get_meta('ns_restricted_item_flag') === 'yes') {
        $allow_restricted_items = get_user_meta( $user_id, 'ns_allow_restricted_items', true );
        if ($allow_restricted_items) {
            return true;
        } else {
            return false;
        }
    }

    return $is_purchasable;
}
