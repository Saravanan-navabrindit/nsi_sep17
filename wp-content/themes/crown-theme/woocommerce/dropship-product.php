<?php

defined('ABSPATH') || exit;

// Display checkbox.
add_action( 'woocommerce_product_options_general_product_data', 'add_dropship_product_checkbox' );
function add_dropship_product_checkbox() {
	echo '<div class="options_group">';
	woocommerce_wp_checkbox([
		'id' => 'ns_dropship_item_flag',
		'wrapper_class' => '',
		'custom_attributes' => array(
			'disabled' => 'true',
		),
		'label' => 'Dropshipped item',
	]);
	echo '</div>';
}

// Add column to product list.
add_filter('manage_edit-product_columns', 'add_dropship_item_column');
function add_dropship_item_column($columns) {
    $columns['dropship_item'] = 'Dropshipped item';
    return $columns;
}

// Make the 'Dropshipped item' column sortable.
add_filter('manage_edit-product_sortable_columns', 'make_dropship_item_column_sortable');
function make_dropship_item_column_sortable($columns) {
    $columns['dropship_item'] = 'dropship_item';
    return $columns;
}

// Define the custom sorting logic.
add_action('pre_get_posts', 'dropship_item_column_orderby');
function dropship_item_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if($query->get('orderby') === 'dropship_item' && $_GET['order'] == 'desc') {
		$query->set('meta_key', 'ns_dropship_item_flag');
		$query->set('orderby', 'meta_value');
		$query->set('order', 'desc');
	} elseif ($query->get('orderby') === 'dropship_item' && $_GET['order'] == 'asc') {
		$query->set('meta_key', 'ns_dropship_item_flag');
		$query->set('orderby', 'meta_value');
		$query->set('order', 'asc');
	}
}

// Display checkbox value in the column.
add_action('manage_product_posts_custom_column', 'display_dropship_item_column', 10, 2);
function display_dropship_item_column($column, $post_id) {
    if ($column == 'dropship_item') {
        $value = get_post_meta($post_id, 'ns_dropship_item_flag', true);

        echo $value === 'yes' ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>';
    }
}
