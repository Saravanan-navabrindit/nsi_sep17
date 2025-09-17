<?php
/**
 * Plugin Name: Crown Shop
 * Description: Extends WooCommerce functionality.
 * Version: 1.0.0
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

include_once ( dirname( __FILE__ ) . '/vendor/autoload.php' );

$file_path = plugin_dir_path(__FILE__) . 'inc/cliSynchronization.php';

if (file_exists($file_path)) {
    include $file_path;
} else {
    echo "Class cliSynchronization not found.";
}


$class_files_dir = dirname( __FILE__ ) . '/classes';
$enums_files_dir = dirname(__FILE__) . '/enums';
$exceptions_files_dir = dirname(__FILE__) . '/exceptions';

foreach ([$class_files_dir, $enums_files_dir, $exceptions_files_dir] as $dir) {
    load_class_files($dir);
}

function load_class_files(string $dir): void {
    if (is_dir($dir)) {
        foreach (scandir($dir) as $file) {
            if (preg_match('/^[^\.]+\.php$/', $file)) {
                include_once($dir . '/' . $file);
            }
        }
    }
}

Crown_Shop_NSI_Users_Actions_Logs::init();
Crown_Shop_Customers::init();
Crown_Shop_Branches::init();
Crown_Shop_Display::init();
Crown_Shop_Orders::init();
Crown_Shop_Products::init();
Crown_Shop_Products_Import::init();
Crown_Shop_Rfq::init();
Crown_Shop_Custom_Roles::init();
Eleks_Carts_Management::init();
Crown_Shop_Pricefile::init();