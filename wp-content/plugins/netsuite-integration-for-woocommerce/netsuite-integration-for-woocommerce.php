<?php

/**
 * Plugin Name: NSI Industries - NetSuite Integration for WooCommerce
 * Description: Plugin will be used to add/update woocommerce orders and customers to Netsuite.
 * Version: 1000.2.7
 * Author: Manish Gautam
 * Text Domain: TMWNI
 * WC requires at least: 2.2
 * WC tested up to: 5.6
 * Woo: 8277071:774402b21708c84be5bee56906b069f1

 */

defined( 'ABSPATH' ) || exit;

// Required functions
if ( ! function_exists( 'woothemes_queue_update' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'woo-includes/woo-functions.php' );
}

// Plugin updates
woothemes_queue_update( plugin_basename( __FILE__ ), '774402b21708c84be5bee56906b069f1', '8277071' );

// WC active check
if ( ! is_woocommerce_active() ) {
	return;
}

if (!function_exists('pr')) {
	function pr( $data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}






	// Put your plugin code here
add_action('plugins_loaded', 'init_tm_netsuite_integration', 1);

function init_tm_netsuite_integration() {
	$plugin_data = get_file_data(__FILE__, array('Version' => 'Version'), false);
	$plugin_version = isset($plugin_data['Version']) ? $plugin_data['Version'] : '1.5.1';

	define( 'WC_TM_NETSUITE_INTEGRATION_INIT_VERSION', $plugin_version );




	if (is_multisite()) {
		$active_plugins = get_site_option( 'active_sitewide_plugins' );
		if ( !isset( $active_plugins[ 'woocommerce/woocommerce.php' ] ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( '/netsuite-integration-for-woocommerce/netsuite-integration-for-woocommerce.php', true );
		}
	} else {
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins( '/netsuite-integration-for-woocommerce/netsuite-integration-for-woocommerce.php', true );
		}
	}

	
	define('TMWNI_DIR', plugin_dir_path(__FILE__));
	define('TMWNI_URL', plugin_dir_url(__FILE__));



	require_once plugin_dir_path(__FILE__) . 'inc/tmwni-settings.php';

	$TMWNI_OPTIONS = TMWNI_Settings::getTabSettings();
	$GLOBALS['TMWNI_OPTIONS'] = $TMWNI_OPTIONS;

	if (is_admin()) {
		require_once TMWNI_DIR . 'inc/admin/admin-loader.php';
	}

	if (!empty($TMWNI_OPTIONS)) {
		//load the main file
		require_once plugin_dir_path(__FILE__) . 'inc/loader.php';
		// // Global for backwards compatibility.
		$GLOBALS['TMWNI_Loader'] = TMWNI_Loader();
	}


	do_action('tm_netsuite_loaded');
}



	// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'install_tm_netsuite_integration_plugin');
register_deactivation_hook( __FILE__, 'deactivate_events' );




	// function for creating log table "in8sync_log"
function install_tm_netsuite_integration_plugin() {
	// deactivate_events_on_active_plugin();
	if (is_multisite()) {
		$active_plugins = get_site_option( 'active_sitewide_plugins' );
			// echo "<pre>";
			// print_r($active_plugins);
			// die('&&*!');
			// if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', $active_plugins ) ) ) {
		if ( isset( $active_plugins[ 'woocommerce/woocommerce.php' ] ) ) {
				//create log database table
			global $wpdb;
			$table_name = $wpdb->prefix . 'tm_woo_netsuite_logs';
			$charset_collate = '';

			if (!empty($wpdb->charset)) {
				$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
			}

			if (!empty($wpdb->collate)) {
				$charset_collate .= " COLLATE {$wpdb->collate}";
			}
				// check if table emopty
			if ($wpdb->get_var($wpdb->prepare('show tables like %s', $table_name)) != $table_name) {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				$sql = 'CREATE TABLE `' . $table_name . "` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					`operation` varchar(100) NOT NULL,
					`status` tinyint(4) NOT NULL,
					`notes` text NOT NULL,
					`woo_object_id` int(11) NULL,
					PRIMARY KEY (`id`)
				) $charset_collate;";
				dbDelta($sql);
			}


			$dashboard_table_name = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';
		// Check if table empty
			if ($wpdb->get_var($wpdb->prepare('show tables like %s', $dashboard_table_name)) != $dashboard_table_name) {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				$sql = 'CREATE TABLE `' . $dashboard_table_name . "` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					`operation` varchar(100) NOT NULL,
					`status` tinyint(4) NOT NULL,
					`notes` text  NULL,
					`woo_object_id` int(11) NOT NULL,
					`ns_order_internal_id` int(11) NULL,
					`ns_order_status` varchar(100) NULL,
					PRIMARY KEY (`id`)
				) $charset_collate;";
				dbDelta($sql);
			}
		} else {
			die('Your store needs to be Woocomerce ready to activate this plugin.');
		}
	} else {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		//create log database table
			global $wpdb;
			$table_name = $wpdb->prefix . 'tm_woo_netsuite_logs';
			$charset_collate = '';

			if (!empty($wpdb->charset)) {
				$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
			}

			if (!empty($wpdb->collate)) {
				$charset_collate .= " COLLATE {$wpdb->collate}";
			}
		// Check if table empty
			if ($wpdb->get_var($wpdb->prepare('show tables like %s', $table_name)) != $table_name) {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				$sql = 'CREATE TABLE `' . $table_name . "` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					`operation` varchar(100) NOT NULL,
					`status` tinyint(4) NOT NULL,
					`notes` text NOT NULL,
					`woo_object_id` int(11) NULL,
					PRIMARY KEY (`id`)
				) $charset_collate;";
				dbDelta($sql);
			}

			$dashboard_table_name = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';
		// Check if table empty
			if ($wpdb->get_var($wpdb->prepare('show tables like %s', $dashboard_table_name)) != $dashboard_table_name) {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				$sql = 'CREATE TABLE `' . $dashboard_table_name . "` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					`operation` varchar(100) NOT NULL,
					`status` tinyint(4) NOT NULL,
					`notes` text  NULL,
					`woo_object_id` int(11) NOT NULL,
					`ns_order_internal_id` int(11) NULL,
					`ns_order_status` varchar(100) NULL,
					PRIMARY KEY (`id`)
				) $charset_collate;";
				dbDelta($sql);
			}
		} else {
			die('Your store needs to be Woocomerce ready to activate this plugin.');
		}
	}

}
