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
        if ( isset($_SESSION['admin']) && $_SESSION['admin'] === 'adminisloggedin' ) {
            return true;
        }
    }
    return false;
}
