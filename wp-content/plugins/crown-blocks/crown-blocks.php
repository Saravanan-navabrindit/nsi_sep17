<?php
/**
 * Plugin Name:       Crown Blocks
 * Description:       Custom WordPress blocks created by Jordan Crown
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.7.0
 * Author:            Jordan Crown
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       crown-blocks
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once( plugin_dir_path( __FILE__ ) . 'classes/class-crown-block.php' );

if ( ! class_exists( 'CrownBlocks' ) ) {
	class CrownBlocks {

		public static $init = false;
		
		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			// Get array of block directory paths
			$blockPaths = glob(__DIR__ . '/blocks/*' , GLOB_ONLYDIR);

			foreach ( $blockPaths as $path ) {
				if ( ! file_exists($path.'/block.php') ) {
					continue;
				}
				
				// Load block registration files. 
				include_once( $path.'/block.php' );
			}

			add_action( 'admin_enqueue_scripts', array(__CLASS__, 'admin_enqueue_styles') );

		}

		public static function admin_enqueue_styles() {
			$style_local_path =  '/crown-blocks/crown-blocks-admin.css';
			wp_enqueue_style( 'crown-blocks-admin-css', WP_PLUGIN_URL . $style_local_path, array(), filemtime( __DIR__ . '/crown-blocks-admin.css' ) );
			
		}

	}
}
\CrownBlocks::init();
