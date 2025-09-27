<?php

defined('ABSPATH') || exit;

if ( ! function_exists( 'get_original_admin_id' ) ) {
    function get_original_admin_id() {
        if ( isset($_COOKIE['sac_admin_id']) ) {
            return intval($_COOKIE['sac_admin_id']);
        }
        return get_option('admin111');
    }
}

function is_switched_customer() {
    if ( isset($_COOKIE['sac_admin_id']) && intval($_COOKIE['sac_admin_id']) > 0 ) {
       return Nsi_Helper::is_admin_session_set();
    }
}

function is_manager_or_switched_manager( $current_user, $allowed_roles = [ 'shop_manager', 'dual_shop_manager' ] ) {
    $admin_id = get_original_admin_id();
    $admin_user = $admin_id ? get_userdata( $admin_id ) : null;

    $is_manager = !empty( $current_user->roles ) && in_array( $current_user->roles[0], $allowed_roles, true );

    $is_switched_manager = is_switched_customer() && $admin_user && !empty( $admin_user->roles ) && in_array( $admin_user->roles[0], $allowed_roles, true );

    return ( $is_manager || $is_switched_manager );
}

function get_selected_quote_type_id() {
    $user_id = get_current_user_id();
    $context_key = get_current_user_contextual_quote_type_key();
    $user_selected = get_user_meta($user_id, $context_key, true);
    if (!empty($user_selected) && is_array($user_selected) && isset($user_selected['id'])) {
        return (int) $user_selected['id'];
    }

    $session_selected = WC()->session ? WC()->session->get($context_key) : null;
    if (!empty($session_selected) && isset($session_selected['id'])) {
        return (int) $session_selected['id'];
    }

    return 0;
}