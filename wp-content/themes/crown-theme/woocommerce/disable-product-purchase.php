<?php

defined('ABSPATH') || exit;

// display checkbox
add_action(
    'woocommerce_product_options_general_product_data',
    'add_disable_purchase_product_checkbox'
);

if (class_exists('WP_CLI')) {
    WP_CLI::add_command('disable products', function ($args) {
        $search_value = [];
        $error_msg = 'Disabling skipped - brand or sku should be specified.';
        if (count($args) < 1) {
            WP_CLI::log($error_msg);
            return;
        }
        if ($args[0] == 'brand') {
            $method_usage = 'brand';
            $search_key = 'product_brand';
            $search_value = [$args[1]];
        } else if ($args[0] == 'sku') {
            $method_usage = 'SKU';
            $search_key = 'product_sku';
            $search_value = array_slice($args, 1);
        } else {
            WP_CLI::log($error_msg);
            return;
        }
        $post_ids = get_posts(array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => $search_key,
                    'value' => $search_value,
                    'compare' => 'IN',),
            ),
        ));
        disable_products_purchase($post_ids);
        WP_CLI::log('Disabled ' . count($post_ids) . ' products' . "\nMethod usage: " . $method_usage);
    });

    WP_CLI::add_command('disable inactive flag sync', function ($args) {
        $search_value = [];
        $error_msg = 'Disabling skipped - brand or sku should be specified.';
        if (count($args) < 1) {
            WP_CLI::log($error_msg);
            return;
        }
        if ($args[0] == 'brand') {
            $method_usage = 'brand';
            $search_key = 'product_brand';
            $search_value = [$args[1]];
        } else if ($args[0] == 'sku') {
            $method_usage = 'SKU';
            $search_key = 'product_sku';
            $search_value = array_slice($args, 1);
        } else {
            WP_CLI::log($error_msg);
            return;
        }
        $post_ids = get_posts(array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => $search_key,
                    'value' => $search_value,
                    'compare' => 'IN',),
            ),
        ));
        disable_inactive_flag_sync($post_ids);
        WP_CLI::log('Disabled inactive flag sync for ' . count($post_ids) . ' products' . "\nMethod usage: " . $method_usage);
    });
}

function add_disable_purchase_product_checkbox()
{
    global $product_object;

    echo '<div class="options_group">';
    woocommerce_wp_checkbox([
        'id' => '_disable_purchase',
        'wrapper_class' => '',
        'label' => 'Disable product purchase',
    ]);
    echo '</div>';
}

// save checkbox value
add_action(
    'woocommerce_admin_process_product_object',
    'save_disable_purchase_product_checkbox',
    10
);

function save_disable_purchase_product_checkbox($product)
{
    $value = isset($_POST['_disable_purchase']) ? 'yes' : 'no';
    $product->update_meta_data('_disable_purchase', $value);
}

add_action(
    'woocommerce_product_options_general_product_data',
    'add_disable_inactive_flag_sync_checkbox'
);

function add_disable_inactive_flag_sync_checkbox() {
    global $product_object;

    echo '<div class="options_group">';
    woocommerce_wp_checkbox([
        'id' => '_disable_inactive_flag_sync',
        'wrapper_class' => '',
        'label' => 'Disable Inactive flag synchronization',
    ]);
    echo '</div>';
}

add_action(
    'woocommerce_admin_process_product_object',
    'save_disable_inactive_flag_sync_checkbox',
    10
);

function save_disable_inactive_flag_sync_checkbox($product) {
    $value = isset($_POST['_disable_inactive_flag_sync']) ? 'yes' : 'no';
    $product->update_meta_data('_disable_inactive_flag_sync', $value);
}

// add column to product list
add_filter('manage_edit-product_columns', 'add_purchase_disabled_column');
function add_purchase_disabled_column($columns)
{
    $columns['disable_purchase'] = 'Purchase disabled';
    return $columns;
}

// Make the 'Purchase disabled' column sortable
add_filter('manage_edit-product_sortable_columns', 'make_purchase_disabled_column_sortable');
function make_purchase_disabled_column_sortable($columns)
{
    $columns['disable_purchase'] = 'disable_purchase';
    return $columns;
}

// Define the custom sorting logic
add_action('pre_get_posts', 'purchase_disabled_column_orderby');
function purchase_disabled_column_orderby($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if($query->get('orderby') === 'disable_purchase' && $_GET['order'] == 'desc'){
		$query->set('meta_key', '_disable_purchase');
		$query->set('orderby', 'meta_value');
	}
}

// display checkbox value in the column
add_action('manage_product_posts_custom_column', 'display_disable_purchase_column', 10, 2);
function display_disable_purchase_column($column, $post_id)
{
    if ($column == 'disable_purchase') {
        $value = get_post_meta($post_id, '_disable_purchase', true);

        echo $value === 'yes' ? '<span style="color:green;">Yes</span>' : '<span style="color:red;">No</span>';
    }
}

add_filter(
    'woocommerce_is_purchasable',
    'disable_product_purchase',
    10,
    2
);

// hide checkout button
function disable_product_purchase($is_purchasable, $product)
{
    if ($product->get_meta('_disable_purchase') == 'yes') {
        return false;
    }

    return $is_purchasable;
}

// add bulk actions to dropdown menu
add_filter('bulk_actions-edit-product', 'register_toggle_purchasing_bulk_actions');

function register_toggle_purchasing_bulk_actions($bulk_actions)
{
    $bulk_actions['disable_purchase'] = 'Disable Purchase';
    $bulk_actions['enable_purchase'] = 'Enable Purchase';
    return $bulk_actions;
}

// handle bulk action form submit
add_filter('handle_bulk_actions-edit-product', 'toggle_purchasing_bulk_action_handler', 10, 3);

function toggle_purchasing_bulk_action_handler($redirect_to, $doaction, $post_ids)
{
    if ($doaction === 'disable_purchase') {
		disable_products_purchase( $post_ids );

		$redirect_to = add_query_arg(
            'bulk_disabled_purchases',
            count($post_ids),
            $redirect_to
        );
    } elseif ($doaction === 'enable_purchase') {
		enable_products_purchase( $post_ids );

		$redirect_to = add_query_arg(
            'bulk_enabled_purchases',
            count($post_ids),
            $redirect_to
        );
    }

    return $redirect_to;
}

/**
 * @param $post_ids
 */
function enable_products_purchase( $post_ids ) {
	foreach ( $post_ids as $post_id ) {
		update_post_meta( $post_id, '_disable_purchase', 'no' );
		add_attribute_to_product( wc_get_product( $post_id ), 'Purchasable', 'true' );
	}
}

/**
 * @param $post_ids
 */
function disable_products_purchase( $post_ids ) {
	foreach ( $post_ids as $post_id ) {
		update_post_meta( $post_id, '_disable_purchase', 'yes' );
		add_attribute_to_product( wc_get_product( $post_id ), 'Purchasable', 'false' );
	}
}

function disable_inactive_flag_sync( $post_ids ) {
	foreach ( $post_ids as $post_id ) {
		update_post_meta( $post_id, '_disable_inactive_flag_sync', 'yes' );
	}
}

// show notice
add_action('admin_notices', 'toggle_purchasing_bulk_action_admin_notice');

function toggle_purchasing_bulk_action_admin_notice()
{
    if (!empty($_REQUEST['bulk_disabled_purchases'])) {
        $disabled_count = intval($_REQUEST['bulk_disabled_purchases']);
        echo '<div id="message" class="updated fade">';
        echo "Disabled purchase for $disabled_count products.</div>";
        $_SERVER['REQUEST_URI'] = remove_query_arg('bulk_disabled_purchases', $_SERVER['REQUEST_URI']);
    }

    if (!empty($_REQUEST['bulk_enabled_purchases'])) {
        $enabled_count = intval($_REQUEST['bulk_enabled_purchases']);
        echo '<div id="message" class="updated fade">';
        echo "Enabled purchase for $enabled_count products.</div>";
        $_SERVER['REQUEST_URI'] = remove_query_arg('bulk_enabled_purchases', $_SERVER['REQUEST_URI']);
    }
}

add_action('extra_save_disable_purchase_product_checkbox', 'add_attribute_to_product', 10, 3);
function add_attribute_to_product(WC_Product $product, string $attribute_name, string $tag_value)
{
    $product_id = $product->get_id();
    $product_attributes = get_post_meta($product_id, '_product_attributes', true);
    $is_product_attributes_empty = empty($product_attributes);
    $position = $is_product_attributes_empty ? 0 : count($product_attributes);
    if ($position > 0 && !empty($product_attributes['pa_' . $attribute_name])) {
        $position = $product_attributes['pa_' . $attribute_name]['position'];
    } else if ($position == 0) {
        $product_attributes = $is_product_attributes_empty ? [] : $product_attributes;
        array_push($product_attributes, ('pa_'. $attribute_name));
    }

    $product_attributes['pa_'. $attribute_name] = array(
        'name' => $attribute_name,
        'value' => $tag_value,
        'position' => $position,
        'is_visible' => 1,
        'is_variation' => 0,
        'is_taxonomy' => 0
    );
    
    update_post_meta($product_id, '_product_attributes', $product_attributes);
    $updated_product = wc_get_product($product_id);
    $updated_product_attributes = $updated_product->get_attributes();
    $product->set_attributes($updated_product_attributes);
}

function add_custom_checkbox_to_woocommerce_settings( $settings ) {
    $new_checkbox = array(
        'title'         => __( 'Hide add to cart button', 'woocommerce' ),
        'desc'          => __( 'Hide add to cart button if product price 0', 'woocommerce' ),
        'id'            => 'hide_add_to_cart_button',
        'default'       => 'no',
        'type'          => 'checkbox',
        'checkboxgroup' => 'start',
    );

    $section_end_index = array_search( array( 'type' => 'sectionend', 'id' => 'catalog_options' ), $settings );

    array_splice( $settings, $section_end_index, 0, array( $new_checkbox ) );

    return $settings;
}
add_filter( 'woocommerce_products_general_settings', 'add_custom_checkbox_to_woocommerce_settings' );

function remove_add_to_cart_button($is_purchasable, $product ){
    $is_hide_add_to_cart = get_option( 'hide_add_to_cart_button' );
    if ($is_hide_add_to_cart === 'yes') {
        if( $product->get_price() == 0 )
            $is_purchasable = false;
    }

    return $is_purchasable;
}
add_filter( 'woocommerce_is_purchasable', 'remove_add_to_cart_button', 10, 2 );

function disable_checkout_button_no_shipping(): void
{
    global $minimum_order_amount_allowed;
    if ( WC()->cart->total < $minimum_order_amount_allowed ) {
        remove_action('woocommerce_proceed_to_checkout',
            'woocommerce_button_proceed_to_checkout', 20 );
        echo '<a href="#" class="checkout-button button alt wc-forward disabled">
         Proceed to checkout</a>';
        echo '<p class="required-amount-notice">A minimum order amount of $' . $minimum_order_amount_allowed. ' is required to place this order.</p>';
    }
}
add_action( 'woocommerce_proceed_to_checkout','disable_checkout_button_no_shipping', 5 );