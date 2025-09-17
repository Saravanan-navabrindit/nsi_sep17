<?php
/*
Plugin Name: Schedule Maintenance Mode
Description: Enable Maintenance page for any specific interval time or specified by you. 
Author: Geek Code Lab
Version: 2.0.1
Author URI: https://geekcodelab.com/
Text Domain: schedule-maintenance-mode
*/
if ( ! defined( 'ABSPATH' ) ) exit;
define('SMMGK_BUILD', "2.0.1");
define('SMMGK_PATH', plugin_dir_path(__FILE__));
define('SMMGK_URL', plugins_url() . '/'.  basename(dirname(__FILE__)));
require_once SMMGK_PATH . 'functions.php';

/**
 * Plugin setting links
 */
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'smmgk_plugin_add_settings_link');
function smmgk_plugin_add_settings_link( $links ) { 
	$support_link = '<a href="https://geekcodelab.com/contact/"  target="_blank" >' . __( 'Support', 'schedule-maintenance-mode' ) . '</a>';
	array_unshift( $links, $support_link );

	$settings_link = '<a href="'.admin_url('').'/options-general.php?page=smmgk-schedule-maintenance-mode">' . __( 'Settings', 'schedule-maintenance-mode' ) . '</a>';
	array_unshift( $links, $settings_link );

	return $links;	
}

/**
 * On register activation
 */
register_activation_hook(__FILE__, 'smmgk_schedule_maintenance_plugin_active');
function smmgk_schedule_maintenance_plugin_active()
{
	$options= get_option('smmgk_schedule_maintenance',array());
	if(!isset($options['headline'])) {
		$options['headline']= "Website is under construction";
		update_option('smmgk_schedule_maintenance',$options);
	}

	if(!isset($options['maintenance_content'])) {
		$options['maintenance_content']= "We'll be back with a newly updated website shortly!";
		update_option('smmgk_schedule_maintenance',$options);
	}
}

/**
 * Enqueue admin scripts
 */
add_action('admin_enqueue_scripts', 'smmgk_admin_scripts');
function smmgk_admin_scripts($hook) {
    if( $hook == 'settings_page_smmgk-schedule-maintenance-mode' ) {
		$css= SMMGK_URL. "/assets/css/admin.css";               
		wp_enqueue_style( 'smmgk-main-admin-css', $css, array(), SMMGK_BUILD );
		wp_enqueue_style( 'wp-color-picker');

		wp_enqueue_script( 'wp-color-picker');
		wp_register_script('smmgk_upload_media_script', SMMGK_URL.'/assets/js/upload_media_script.js', array('jquery','media-upload'), SMMGK_BUILD);
		wp_enqueue_script('smmgk_upload_media_script');
		wp_enqueue_media();
	}
}

/**
 * Admin menu for plugin settings
 */
add_action('admin_menu', 'smmgk_admin_menu_maintenance');
function smmgk_admin_menu_maintenance() {
	add_options_page('Schedule Maintenance Mode', 'Schedule Maintenance Mode', 'manage_options', 'smmgk-schedule-maintenance-mode', 'smmgk_options_menu_view'  );
}
function smmgk_options_menu_view() {
	include( SMMGK_PATH . 'admin/options.php' );
}

/** Schedule start / end maintenance mode */
add_action('smmgk_start_shedule_maitenance', 'smmgk_start_schedule_event');
add_action('smmgk_end_shedule_maitenance', 'smmgk_end_schedule_event');

function smmgk_start_schedule_event() {
	$smmgk_options= smmgk_get_options();
	$smmgk_options['maintenance_mode']=1;
	update_option('smmgk_schedule_maintenance',$smmgk_options);
}

function smmgk_end_schedule_event() {	
	$smmgk_options= smmgk_get_options();
	$smmgk_options['maintenance_mode']=0;
	$smmgk_options['status']=0;
	update_option('smmgk_schedule_maintenance',$smmgk_options);
}

// If u want to load a function only in the front end.
add_action( 'template_redirect', 'smmgk_front_end_maintenance');
function smmgk_front_end_maintenance() {
	if(isset($_REQUEST['smmgk_preview'])) {
		include_once( SMMGK_PATH . 'theme/index.php' );
		die;
	}

    if ( !is_admin() ) {
		$current_role = (is_user_logged_in()) ? wp_get_current_user()->roles[0] : ''; 		
		
		if($current_role!="administrator") {
			$smmgk_options= smmgk_get_options();			
			if(isset($smmgk_options['maintenance_mode']) && $smmgk_options['status']) {
				if($smmgk_options['maintenance_mode']==1 && $smmgk_options['status']==1) {
					include_once( SMMGK_PATH . 'theme/index.php' );
					die;
				}			
			}
		}
       
    }
}