<?php

if ( ! class_exists( 'Crown_Theme_Block_Editor' ) ) {
	class Crown_Theme_Block_Editor {


		public static function init() {

			add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_scripts' ) );
			add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_block_editor_styles' ) );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_styles' ) );

		}


		public static function enqueue_block_editor_scripts() {

			wp_enqueue_script(
				'crown-theme-block-editor',
				Crown_Theme::get_uri() . '/assets/js/block-editor' . (( defined('JS_CSS_MODE_MIN') && JS_CSS_MODE_MIN ) ? '.min' : '' ) . '.js',
				array( 'wp-blocks', 'wp-dom', 'jquery' ),
				filemtime( Crown_Theme::get_dir() . '/assets/js/block-editor' . (( defined('JS_CSS_MODE_MIN') && JS_CSS_MODE_MIN ) ? '.min' : '' ) . '.js' ),
				true
			);

		}


		public static function enqueue_block_editor_styles() {

			// wp_enqueue_style(
			// 	'google-fonts',
			// 	'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap',
			// 	array(),
			// 	null
			// );

			// wp_enqueue_style(
			// 	'typekit',
			// 	'https://use.typekit.net/ejb7dnd.css',
			// 	array(),
			// 	null
			// );

		}


		public static function enqueue_admin_styles( $hook ) {
			
			$screen = get_current_screen();
			if ( $screen->base == 'post' ) {

				// wp_enqueue_style(
				// 	'crown-theme-icons-ss-gizmo',
				// 	Crown_Theme::get_uri() . '/assets/fonts/ss-gizmo/ss-gizmo.css',
				// 	array(),
				// 	null
				// );

			}

		}


	}
}