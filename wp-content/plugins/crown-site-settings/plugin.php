<?php
/**
 * Plugin Name: Crown Site Settings
 * Description: Adds basic configuration options for site.
 * Version: 1.0.0
 * Author: Jordan Crown
 * Author URI: http://www.jordancrown.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */


// load required class files
$class_files_dir = dirname( __FILE__ ) . '/classes';
foreach ( scandir( $class_files_dir ) as $file) {
	if ( preg_match( '/^[^\.]+\.php$/', $file ) ) {
		include_once( $class_files_dir . '/' . $file );
	}
}

Crown_Site_Settings_Admin::init();
Crown_Site_Settings_Contact::init();
Crown_Site_Settings_Discussion::init();
Crown_Site_Settings_Media::init();
Crown_Site_Settings_Pages::init();
// Crown_Site_Settings_Posts::init();
Crown_Site_Settings_Scripts::init();
Crown_Site_Settings_Shortcodes::init();
// Crown_Site_Settings_Signup::init();
Crown_Site_Settings_Social_Media::init();
Crown_Site_Settings_Site_Announcement::init();
Crown_Site_Settings_Theme_Configuration::init();
// Crown_Site_Settings_Theme_Mega_Menu::init();