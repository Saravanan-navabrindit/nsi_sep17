<?php
/**
 * Plugin Name: Crown Resources
 * Description: Adds support for managing Resources in Resources library.
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

Crown_Resources::init();