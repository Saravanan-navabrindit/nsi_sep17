<?php
require_once HAWKSEARCH_PLUGIN_DIR . '/inc/product-data-helpers.php';

class Hawksearch_indexing_API extends Hawksearch_base_API  {

    private static WC_Logger $wc_logger;
    protected string $api_url = '';

	public function __construct() {
		parent::__construct();
		if ( defined( 'HAWKSEARCH_API_INDEXING_URL' ) ) $this->api_url = HAWKSEARCH_API_INDEXING_URL . '/';
        self::$wc_logger = wc_get_logger();
    }

	public function delete_single_product_from_index($product_id) {
		$current_index = $this->get_current_index();
		if (!$current_index) {
			return;
		}

		$data = array(
			'IndexName' => $current_index,
			'Id' => $product_id,
		);

		$this->request('delete', 'POST', $data);
		$this->rebuild_all($current_index);
	}

    public function sync_single_product_to_hawksearch($product_id) {
		$current_index = $this->get_current_index();
		if (!$current_index) {
			return;
		}

		$data = array(
			'IndexName' => $current_index,
			'Items' => array( get_product_indexing_data($product_id) ),
		);

		$this->request('index-items', 'POST', $data);
		$this->rebuild_all($current_index);
	}

	public function sync_products_banch_to_hawksearch($products, $index) {
		$data = array(
			'IndexName' => $index,
			'Items' => array()
		);
		foreach ($products as $product_id) {
			$data['Items'][] = get_product_indexing_data($product_id);
		}

		$this->request('index-items', 'POST', $data);
	}

	public function get_current_index() {
		$response = $this->request('current');
		if (array_key_exists('body', $response)) {
			$response_body = json_decode($response['body']);
			if (is_object($response_body) && property_exists($response_body, 'IndexName')) {
                $index_name = $response_body->IndexName;
                self::$wc_logger->info('Hawksearch API get current index DONE, indexName: ' . $index_name, array('source' => 'hawksearch'));
                return $response_body->IndexName;
			} else {
                $formatted_message = self::get_formatted_response($response);
                self::$wc_logger->error('Hawksearch API response of get current index: ' . $formatted_message, array('source' => 'hawksearch'));
            }
		}
		return FALSE;
	}

	public function get_all_indexes() {
		$response = $this->request('');
		if (array_key_exists('body', $response)) {
			$response_body = json_decode($response['body']);
			if (is_object($response_body) && property_exists($response_body, 'IndexNames')) {
                self::$wc_logger->info('Hawksearch API get all indexes DONE', array('source' => 'hawksearch'));
                return $response_body->IndexNames;
			} else {
                $formatted_message = self::get_formatted_response($response);
                self::$wc_logger->error('Hawksearch API response of get all indexes: ' . $formatted_message, array('source' => 'hawksearch'));
            }
		}
		return FALSE;
	}

	public function create_index() {
		$response = $this->request('create', 'POST');
		if (array_key_exists('body', $response)) {
			$response_body = json_decode($response['body']);
			if (is_object($response_body) && property_exists($response_body, 'IndexName')) {
                $index_name = $response_body->IndexName;
                self::$wc_logger->info('Hawksearch API create index DONE, the INDEX name: ' . $index_name, array('source' => 'hawksearch'));
                return $index_name;
			}
		} else {
            $formatted_message = self::get_formatted_response($response);
            self::$wc_logger->error('Hawksearch API response of create index: ' . $formatted_message, array('source' => 'hawksearch'));
        }
        return FALSE;
	}

	public function delete_index($index) {
		$data = array( 'IndexName' => $index );
		$this->request('delete-index', 'POST', $data);
	}

	public function rebuild_all($index) {
		$data = array( 'IndexName' => $index );
		$response = $this->request('rebuild-all', 'POST', $data);
		if (array_key_exists('response', $response) && isset($response['response']['code']) && $response['response']['code'] == 200) {
            self::$wc_logger->info('Hawksearch API rebuild all DONE', array('source' => 'hawksearch'));
            return TRUE;
		} else {
            $formatted_message = self::get_formatted_response($response);
            self::$wc_logger->error('Hawksearch API rebuild all: ' . $formatted_message, array('source' => 'hawksearch'));
        }
		return FALSE;
	}

	public function set_current_index($index) {
		$data = array( 'IndexName' => $index );
		$this->request('set-current', 'POST', $data);
	}

    public static function get_formatted_response(WP_Error|array $response): string
    {
        if (is_wp_error($response)) {
            $formatted_message = 'error_message' . $response->get_error_message();
        } else if (is_array($response)) {
            $message = isset( $response['body'] ) ? $response['body'] : 'Please check Hawksearch admin panel for error logs.';
            $formatted_message = 'Hawksearch error: ' . $message;
        } else {
            $formatted_message = $response;
        }
        return $formatted_message;
    }
}