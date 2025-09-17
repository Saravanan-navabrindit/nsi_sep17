<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
check_authorized_access();
phpinfo();
function check_authorized_access(): void
{
    if (!current_user_can('manage_options')) {
        wp_redirect(home_url());
        exit;
    } else {
        echo '<h2>Admin only access</h2>';
    }
}
?>