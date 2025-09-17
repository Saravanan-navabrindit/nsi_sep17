<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

Log_Explorer::check_authorized_access();

$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$directory = Log_Explorer::get_active_directory($current_url);

Log_Explorer::render_log_dirs($directory);

?>