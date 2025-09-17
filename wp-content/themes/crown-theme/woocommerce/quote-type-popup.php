<?php

defined('ABSPATH') || exit;

add_action( 'woocommerce_after_account_navigation', 'addify_render_quote_type_popup' );

function addify_render_quote_type_popup() {
    get_template_part( 'woocommerce/addify/rfq/my-account/select-quote-type' );
}

add_action( 'wp_ajax_set_selected_quote_type', 'my_set_selected_quote_type' );

function my_set_selected_quote_type() {
     if ( ! isset( $_POST['id'], $_POST['title'] ) || ! WC()->session ) {
        wp_send_json_error( array( 'message' => 'Missing data or session.' ) );
        return;
    }
            
    $new_quote_type_id = sanitize_text_field( $_POST['id'] );
    $new_quote_type_title = sanitize_text_field( $_POST['title'] );
    $context_key = get_current_user_contextual_quote_type_key();
    $user_id = get_current_user_id();

    $existing_quote_type = WC()->session->get( $context_key );
    if ( ! $existing_quote_type && $user_id ) {
        $existing_quote_type = get_user_meta( $user_id, $context_key, true );
    }
    
    if ( $existing_quote_type && isset($existing_quote_type['id']) ) {
        wp_send_json_error( array( 'code' => 'type_already_selected' ) );
        die();
    }

    WC()->session->set( $context_key, array(
        'id'    => $new_quote_type_id,
        'title' => $new_quote_type_title,
    ) );

    update_user_meta( $user_id, $context_key, array(
        'id'    => $new_quote_type_id,
        'title' => $new_quote_type_title,
    ) );

    wp_send_json_success( array(
        'status' => 'stored',
        'stored' => WC()->session->get($context_key)
    ) );
}

add_action( 'wp_ajax_nopriv_set_selected_quote_type', 'my_set_selected_quote_type' );

add_action( 'wp_ajax_unset_selected_quote_type', 'my_unset_selected_quote_type' );
add_action( 'wp_ajax_nopriv_unset_selected_quote_type', 'my_unset_selected_quote_type' );

function my_unset_selected_quote_type() {  
    if ( ! WC()->session ) {
        wp_send_json_error( array( 'message' => 'WooCommerce session not available.' ) );
        return;
    }

    $context_key = get_current_user_contextual_quote_type_key();
    $user_id = get_current_user_id();

    WC()->session->__unset( $context_key );
    update_user_meta( $user_id, $context_key, null );

    wp_send_json_success( array( 'removed' => true ) );
}


add_action('wp_ajax_get_selected_quote_type', 'my_get_selected_quote_type');
add_action('wp_ajax_nopriv_get_selected_quote_type', 'my_get_selected_quote_type');

function my_get_selected_quote_type() {
    $data = null;
    $context_key = get_current_user_contextual_quote_type_key();
    if (function_exists('WC') && WC()->session) {
        $user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key);
		$session_selected_quote_type = WC()->session->get( $context_key );
		if(!null == $user_selected_quote_type){
			$data = $user_selected_quote_type[0];
        }else {
            $data = WC()->session->get($context_key);
        }

    }
    wp_send_json_success($data);
}

function my_theme_enqueue_scripts() {
    // Enqueue the JS
    wp_enqueue_script(
        'my-theme-custom',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0',
        true
    );

    // Localize for AJAX
    wp_localize_script(
        'my-theme-custom',
        'my_ajax_obj',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

add_filter('script_loader_tag', function($tag, $handle, $src) {
    if ($handle === 'my-main-js') {
        return '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}, 10, 3);

wp_localize_script('my-theme-custom', 'my_ajax_obj', [
    'ajax_url' => admin_url('admin-ajax.php')
]);

add_action('wp_ajax_check_quote_type_exists', 'check_quote_type_exists');
add_action('wp_ajax_nopriv_check_quote_type_exists', 'check_quote_type_exists');
function check_quote_type_exists() {
    $context_key = get_current_user_contextual_quote_type_key();
    $user_id = get_current_user_id();
    $session_type = WC()->session->get($context_key);
    $usermeta_type = get_user_meta($user_id, $context_key, true);
    $exists = !empty($session_type) || !empty($usermeta_type);

    wp_send_json([ 'exists' => $exists ]);
}

/**
 * Returns the correct session and meta key for the current user context.
 *
 * @return string The key to use (e.g., 'selected_quote_type' or 'selected_quote_type_123').
 */
function get_current_user_contextual_quote_type_key() {
    $base_key = 'selected_quote_type';
    $user_id = get_current_user_id();
    // Check if the current user is a switched-in admin/manager
    if ( function_exists('is_switched_customer') && is_switched_customer() ) {
        $admin_id = function_exists('get_original_admin_id') ? get_original_admin_id() : 0;
        if ( $admin_id && ($user_id !== $admin_id)) {
            return $base_key . '_' . $user_id . '_' . $admin_id;
        }
    }

    return $base_key;
}

/**
 * Gets the selected quote type for the current user context.
 * It correctly handles normal customers and switched admins.
 *
 * @return array|null An array with 'id' and 'title', or null if not set.
 */
function get_current_user_quote_type_value() {
    $current_user_id = get_current_user_id();
    if ( ! $current_user_id || ! WC()->session ) {
        return null;
    }

    $context_key = get_current_user_contextual_quote_type_key();

    if ( WC()->session->get( $context_key ) ) {
        return WC()->session->get( $context_key );
    }

    $quote_type_data = get_user_meta( $current_user_id, $context_key, true );

    return ! empty( $quote_type_data ) && is_array( $quote_type_data ) ? $quote_type_data : null;
}

add_action( 'template_redirect', 'restrict_url_based_on_session' );

function restrict_url_based_on_session() {
    $context_key = get_current_user_contextual_quote_type_key();
    $user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key);
    $session_selected_quote_type = WC()->session->get( $context_key );
    if(!null == $user_selected_quote_type){
        $selected_quote_type = $user_selected_quote_type[0]['id'];
    } else {
        !empty($session_selected_quote_type) === $selected_quote_type = $session_selected_quote_type['id'] ? : 0;
    }
    $selected_quote_type_id = $selected_quote_type;
    // The URL (slug or path) you want to restrict
    $restricted_slug = 'request-a-quote'; 
    
    // Get current page slug
    global $wp;
    $current_slug = $wp->request;

    // Check if we are on the restricted page
    if ( $current_slug === $restricted_slug ) {
        
        // Get session data
        $session_value = $selected_quote_type_id;

        // If session does not exist or is empty, redirect
        if ( empty( $session_value ) ) {
            wp_redirect( home_url( '/my-account/' ) ); 
            exit;
        }
    }
}

// AJAX action to dynamically check the current quote status for hawksearch plp popup.
add_action('wp_ajax_check_hawksearch_plp_current_quote_status', 'ajax_check_hawksearch_plp_current_quote_status_callback');
function ajax_check_hawksearch_plp_current_quote_status_callback() {
    check_ajax_referer('quote_status_nonce', 'nonce');

    $response = array('has_quote_type' => false);
    $context_key = get_current_user_contextual_quote_type_key();
    
    $selected_quote_type = WC()->session->get($context_key);
    if (empty($selected_quote_type['id']) && is_user_logged_in()) {
        $selected_quote_type = get_user_meta(get_current_user_id(), $context_key, true);
    }

    if (!empty($selected_quote_type['id'])) {
        $quote_type_id = intval($selected_quote_type['id']);
        $response['has_quote_type'] = true;
        $response['is_bridgeport_only'] = (get_post_meta($quote_type_id, 'quote_type_bridgeport_brand', true) === 'yes');
        $response['is_discount_type'] = (get_post_meta($quote_type_id, 'quote_type_discount_rules', true) === 'yes');
    }

    wp_send_json_success($response);
}

add_action('wp_enqueue_scripts', 'hawksearch_plp_quote_scripts');
function hawksearch_plp_quote_scripts() {
    wp_localize_script('hawksearch-main', 'plp_quote_vars', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('quote_status_nonce')
    ));
}

function sort_quote_types_with_job_request_first( $quote_types ) {
    if ( ! is_array( $quote_types ) || empty( $quote_types ) ) {
        return $quote_types;
    }
    usort($quote_types, function($a, $b) {
        $target_title = 'Job Quote Request';
        if (isset($a->post_title) && $a->post_title === $target_title) {
            return -1;
        }
        if (isset($b->post_title) && $b->post_title === $target_title) {
            return 1;
        }
        return strcmp( $a->post_title ?? '', $b->post_title ?? '' );
    });

    return $quote_types;
}