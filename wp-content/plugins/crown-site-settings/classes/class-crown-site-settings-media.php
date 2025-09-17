<?php


if ( ! class_exists( 'Crown_Site_Settings_Media' ) ) {
	class Crown_Site_Settings_Media {

		public static $init = false;


		public static function init() {
			if( self::$init ) return;
			self::$init = true;

			add_filter( 'upload_mimes', array(  __CLASS__, 'filter_upload_mimes' ) );
			add_filter( 'wp_check_filetype_and_ext', array(  __CLASS__, 'filter_check_filetype_and_ext' ), 10, 4 );

		}


		public static function filter_upload_mimes( $mimes ) {

			$mimes['svg'] = 'image/svg+xml';
			
			return $mimes;
		}
	
	
		public static function filter_check_filetype_and_ext( $check_filetype_and_ext, $file, $filename, $mimes ) {

			// If the content was already okay
			if ( $check_filetype_and_ext['ext'] && $check_filetype_and_ext['type'] ) {
				return $check_filetype_and_ext;
			}
	
			// If wp_check_filetype can establish the mime type from the upload_mimes filter, merge it into the result
			return array_merge( $check_filetype_and_ext, wp_check_filetype( $filename, apply_filters('upload_mimes', array() ) ) );

		}


	}
}