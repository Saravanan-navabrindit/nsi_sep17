<?php

if ( ! class_exists( 'Crown_Amplifi_Api' ) ) {
	class Crown_Amplifi_Api {

		public static $init = false;

		protected static $api_uri = 'https://entapi.amplifi.io/v2/';
		protected static $client_id = null;
		protected static $client_secret = null;
		protected static $access_token = null;
		public static $amplifi_api_requests_logs_enabled = FALSE;

		public static function init() {
			if ( self::$init ) return;
			self::$init = true;
			if ( defined( 'AMPLIFI_API_REQUESTS_LOGS_ENABLED' ) ) self::$amplifi_api_requests_logs_enabled = AMPLIFI_API_REQUESTS_LOGS_ENABLED;
			if ( defined( 'AMPLIFI_CLIENT_ID' ) ) self::$client_id = AMPLIFI_CLIENT_ID;
			if ( defined( 'AMPLIFI_CLIENT_SECRET' ) ) self::$client_secret = AMPLIFI_CLIENT_SECRET;

			self::generate_access_token();
		}

		public static function get_collections( $args = array() ) {
			$response = self::query( 'collection', $args );
			return $response;
		}

		public static function get_collection( $id, $args = array() ) {
			$response = self::query( 'collection/' . $id, $args );
			return $response;
		}

		public static function get_collection_files( $id, $args = array() ) {
			$response = self::query( 'collection/' . $id . '/files', $args );
			return $response;
		}

		public static function get_categories( $args = array() ) {
			$response = self::query( 'category', $args );
			return $response;
		}

		public static function get_attributes() {
			$response = self::query( 'attribute');
			return $response;
		}

		public static function get_attribute( $id ) {
			$response = self::query( 'attribute/' . $id);
			return $response;
		}

		protected static function generate_access_token() {
			
			$access_token = get_transient( 'crown_amplifi_api_access_token' );

			if ( ! $access_token ) {

				$url = self::$api_uri . 'oauth/authorize';
				$headers = array(
					'Content-Type' => 'application/json'
				);

				$ch = curl_init();
				curl_setopt( $ch, CURLOPT_URL, $url );
				curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
				curl_setopt( $ch, CURLOPT_TIMEOUT, 30 );
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
				curl_setopt( $ch, CURLOPT_HEADER, 0 );
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );
				curl_setopt( $ch, CURLOPT_USERPWD, self::$client_id . ':' . self::$client_secret );
				curl_setopt( $ch, CURLOPT_POST, 1 );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( array( 'grant_type' => 'client_credentials' ) ) );
				if ( ! empty( $headers ) ) {
					$http_headers = array();
					foreach ( $headers as $k => $v ) $http_headers[] = $k . ': ' . $v;
					curl_setopt( $ch, CURLOPT_HTTPHEADER, $http_headers );
				}

				$response = json_decode( curl_exec( $ch ) );
				curl_close( $ch );
				unset( $ch );

				if ( is_object( $response ) && property_exists( $response, 'access_token' ) ) {
					$access_token = $response->access_token;
					set_transient( 'crown_amplifi_api_access_token', $access_token, DAY_IN_SECONDS * 360 );
				}

			}

			if ( $access_token ) {
				self::$access_token = $access_token;
			}

		}

		protected static function query( $endpoint, $query_args = array(), $method = 'get' ) {
			self::init();

			if ( empty( self::$access_token ) ) return null;

			$query_string = '';

			$headers = array(
				'Authorization' => 'Bearer ' . self::$access_token
			);

			if ( $method == 'get' ) {
				$query_args = array_combine( array_keys( $query_args ), array_map( function($n) { return urlencode( is_object( $n ) || is_array( $n ) ? json_encode( $n ) : $n ); }, $query_args ) );
				$query_params = array();
				foreach ( $query_args as $k => $v ) $query_params[] = $k . '=' . $v;
				$query_string = implode('&', $query_params);
			}

			$url = self::$api_uri . $endpoint . ( ! empty( $query_string ) ? '?' . $query_string : '' );

			if ( self::$amplifi_api_requests_logs_enabled ) {
				$get_requests_query = get_option('requests_query');
				$get_requests_query[] = [
					'url' => $url,
					'date' => date("Y-m-d H:i:s"),
				];
				update_option('requests_query', $get_requests_query);
			}

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, true );

			if ( $method == 'post' ) {
				$headers['Content-Type'] = 'application/json';
				curl_setopt( $ch, CURLOPT_POST, 1 );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $query_args ) );
			}

			if ( ! empty( $headers ) ) {
				$http_headers = array();
				foreach ( $headers as $k => $v ) $http_headers[] = $k . ': ' . $v;
				curl_setopt( $ch, CURLOPT_HTTPHEADER, $http_headers );
			}

			$response = curl_exec( $ch );

			// Check for errors and handle them
			$response = curl_error($ch) ?: json_decode( $response );

			curl_close( $ch );
			unset( $ch );

			return $response;

		}

	}
}