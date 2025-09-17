<?php

/**
 * Plugin Name:       Shipping Method Display Style for WooCommerce
 * Plugin URI:        https://wordpress.org/plugins/woo-shipping-display-mode/
 * Description:       This plugin provides a configuration to display shipping methods as Radio button or select box on the checkout page.
 * Version:           3.8.0
 * Author:            theDotstore
 * Author URI:        https://www.thedotstore.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-shipping-display-mode
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 * 
 * WC requires at least:4.5
 * WP tested up to:     6.8.2
 * WC tested up to:     10.1.0
 * Requires PHP:        7.2
 * Requires at least:   5.0
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
if ( function_exists( 'wsdm_fs' ) ) {
    wsdm_fs()->set_basename( false, __FILE__ );
    return;
}
if ( !function_exists( 'wsdm_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wsdm_fs() {
        global $wsdm_fs;
        if ( !isset( $wsdm_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $wsdm_fs = fs_dynamic_init( array(
                'id'             => '4753',
                'slug'           => 'woo-shipping-display-mode',
                'type'           => 'plugin',
                'public_key'     => 'pk_3004a64759ed9ac7042e91bf71969',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => false,
                'menu'           => array(
                    'first-path' => 'admin.php?page=wc-settings&tab=shipping_mode',
                    'support'    => false,
                ),
                'is_live'        => true,
            ) );
        }
        return $wsdm_fs;
    }

    // Init Freemius.
    wsdm_fs();
    // Signal that SDK was initiated.
    do_action( 'wsdm_fs_loaded' );
    wsdm_fs()->add_action( 'after_uninstall', 'wsdm_fs_uninstall_cleanup' );
}
if ( !defined( 'WSDM_PLUGIN_URL' ) ) {
    define( 'WSDM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WSDM_PLUGIN_BASENAME' ) ) {
    define( 'WSDM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-shipping-display-mode-activator.php
 */
function activate_woo_shipping_display_mode() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-shipping-display-mode-activator.php';
    Woo_Shipping_Display_Mode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-shipping-display-mode-deactivator.php
 */
function deactivate_woo_shipping_display_mode() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-shipping-display-mode-deactivator.php';
    Woo_Shipping_Display_Mode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_shipping_display_mode' );
register_deactivation_hook( __FILE__, 'deactivate_woo_shipping_display_mode' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-shipping-display-mode.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_shipping_display_mode() {
    $plugin = new Woo_Shipping_Display_Mode();
    $plugin->run();
}

run_woo_shipping_display_mode();
/**
 * Plugin compability with WooCommerce HPOS
 *
 * @since 3.9.4
 */
add_action( 'before_woocommerce_init', function () {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );