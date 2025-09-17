<?php

class Hawksearch_base_API {

	protected string $api_key = '';

	protected string $api_url = '';

	protected string $client_guid = '';

	public function __construct() {
		if ( defined( 'HAWKSEARCH_API_KEY' ) ) $this->api_key = HAWKSEARCH_API_KEY;
		if ( defined( 'HAWKSEARCH_CLIENT_GUID' ) ) $this->client_guid = HAWKSEARCH_CLIENT_GUID;
	}

	protected function request($action, $method = 'GET', $params = array()) {
		$response = wp_remote_post($this->api_url . $action, array(
			'method' => $method,
			'headers' => array(
				'Content-Type' => 'application/json',
				'X-HawkSearch-ApiKey' => $this->api_key,
			),
			'body' => !empty($params)? json_encode($params) : $params,
			'timeout' => 120,
		));

		if (is_wp_error($response)) {
			error_log('Hawksearch API error: ' . $response->get_error_message());
			return [];
		}
		return $response;
	}
}