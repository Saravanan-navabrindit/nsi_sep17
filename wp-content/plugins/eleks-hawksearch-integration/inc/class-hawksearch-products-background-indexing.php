<?php

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'woocommerce' ) ) return;
if ( ! class_exists( 'WP_Async_Request', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-async-request.php';
}

if ( ! class_exists( 'WP_Background_Process', false ) ) {
	include_once dirname( WC_PLUGIN_FILE ) . '/includes/libraries/wp-background-process.php';
}

class Hawksearch_Products_Background_Indexing extends WP_Background_Process {

	
	protected $action = 'hawksearch_products_indexing';
	protected $hawksearch_indexing_api;

	protected $new_index = FALSE;

	protected $index_name;

	public function __construct() {
		parent::__construct();

		$this->hawksearch_indexing_api = new Hawksearch_indexing_API();
	}

	protected function task( $item ) {
		if ( function_exists('wp_load_alloptions') ) {
			wp_load_alloptions();
		}
		$products = $item['products'];
		$this->index_name = $item['index_name'];
		$this->new_index = $item['new_index'];
		$this->hawksearch_indexing_api->sync_products_banch_to_hawksearch($products, $this->index_name);
		return false;
	}

	protected function complete() {
		parent::complete();
		$response = $this->hawksearch_indexing_api->rebuild_all($this->index_name);
		if ($response && $this->new_index) {
			$this->hawksearch_indexing_api->set_current_index($this->index_name);
		}
	}

}
