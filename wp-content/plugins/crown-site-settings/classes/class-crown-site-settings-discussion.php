<?php


if ( ! class_exists( 'Crown_Site_Settings_Discussion' ) ) {
	class Crown_Site_Settings_Discussion {

		public static $init = false;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_filter( 'pings_open', '__return_false' );
			add_action( 'init', array( __CLASS__, 'remove_comment_support' ), 100 );

		}


		public static function remove_comment_support() {
			remove_post_type_support( 'post', 'comments' );
			remove_post_type_support( 'page', 'comments' );
		}


	}
}