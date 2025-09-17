<?php
class CommonIntegrationFunctions {
	/**
	 * Handling API response for ADD operations
	 */
	public function handleAPIAddResponse( $response, $object) {
		if (!$response->writeResponse->status->isSuccess) {
			$error_msg = ucfirst($object) . ' Add operation failed for WooCommerce ' . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Error Message : ' . $response->writeResponse->status->statusDetail[0]->message;

			$this->handleLog(0, $this->object_id, $object, $error_msg);
			if ('order' == $object) {
				$this->netsuiteAutoSyncOrderStatus(0, $this->object_id, 'order Add', $error_msg, 'Not Sync', '');
			}
			return 0;
		} else {
			$internalId = $response->writeResponse->baseRef->internalId;

			if ('order' == $object) {
			$this->netsuiteAutoSyncOrderStatus(1, $this->object_id, 'order Add', $error_msg, 'Sync', $response->writeResponse->baseRef->internalId);
			}
			$this->handleLog(1, $this->object_id, $object);

			

			return $internalId;
		}
	}
	 //Handling API "update operation" response 
	public function handleAPIUpdateResponse( $response, $object) {
		if (!$response->writeResponse->status->isSuccess) {
			$error_msg = ( $object ) . ' Update operation failed for WooCommerce ' . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Error Message : ' . $response->writeResponse->status->statusDetail[0]->message;

			$this->handleLog(0, $this->object_id, $object, $error_msg);

			return 0;
		} else {
			$this->handleLog(1, $this->object_id, $object);
			return $response->writeResponse->baseRef->internalId;
		}
	}

	/**
	 * Handling API response for search operations
	 */
	public function handleAPISearchResponse( $response, $object, $search_keyword = '') {
		if (!$response->searchResult->status->isSuccess) {
			$error_msg = "'" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			if (!empty($search_keyword)) {
				$error_msg .= 'Search Keyword:' . $search_keyword;
			}

			$error_msg .= 'Error Message : ' . $response->writeResponse->status->statusDetail[0]->message;

			$this->handleLog(0, $this->object_id, $object, $error_msg);
		} else {
			if (0 == $response->searchResult->totalRecords) {
				$error_msg = "'" . ucfirst($object) . " Search' operation returned no results for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
				if (!empty($search_keyword)) {
					$error_msg .= 'Search Keyword:' . $search_keyword;
				}

				$this->handleLog(1, $this->object_id, $object, $error_msg);
				
				return 0;
			} else {
				$this->handleLog(1, $this->object_id, $object);
				
				return $response->searchResult->recordList->record[0]->internalId;
			}
		}
	}

	public function handleLog( $status, $object_id, $object, $error = '') {
		$this->writeLogtoDB($status, $object_id, $object, $error);
		if (0 == $status) {
			$this->logNetsuiteApiError($error);
		}
	}

	public function writeLogtoDB( $status, $object_id, $object, $error = '') {
		global $wpdb;
		$query_array = ['status' => $status, 'woo_object_id' => $object_id, 'operation' => $object];
		$query_array['notes'] = $error;
		$wpdb->insert($wpdb->prefix . 'tm_woo_netsuite_logs', $query_array);
		return false;
	}
	/**
	 * API Error logging function
	 */
	public function logNetsuiteApiError( $error) {
		$error_log_file = wc_get_log_file_path('netsuite_errors.log');

		if (!file_exists($error_log_file)) {
			fopen($error_log_file, 'w');
			chmod($error_log_file, 0777); 
		}
		
		if (!is_writable($error_log_file)) {
			chmod($error_log_file, 0777);
		}
		$error = "\n" . gmdate('Y-m-d H:i:s') . '->' . $error . ' ;';
		file_put_contents($error_log_file, $error, FILE_APPEND);
	}

	//order sync logs
	public function netsuiteAutoSyncOrderStatus( $status, $object_id, $object, $error, $ns_status, $ns_order_internal_id) {
		global $wpdb;
		$wpdb->netsuite_order_logs = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';


		$order_data_logs = $wpdb->get_results($wpdb->prepare(" SELECT DISTINCT id FROM {$wpdb->netsuite_order_logs} WHERE woo_object_id = %d ", $object_id, OBJECT)); 

		$query_array = ['operation' => $object, 'status' => $status, 'ns_order_internal_id' => $ns_order_internal_id,'woo_object_id' => $object_id,'ns_order_status'=>$ns_status];
		
		$query_array['notes'] = $error;
		
		if (empty($order_data_logs)) {
			$wpdb->insert($wpdb->netsuite_order_logs, $query_array);
		} else {
			$r = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->netsuite_order_logs} SET notes = %s, ns_order_status = %s WHERE woo_object_id = %d", $error, $ns_status, $object_id) );

		}
		return false;
	}

	public function getNetsuiteCustomerSync() {
		global $wpdb;
		$customer_sync = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_usermeta WHERE meta_key = "ns_customer_internal_id"', OBJECT );
		return $customer_sync; 
	}

	public function getNetsuiteGuestCustomerSync() {
		global $wpdb;
		$customer_sync = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = "ns_guest_customer_internal_id"', OBJECT );
		return $customer_sync; 
	}

	public function getNetsuiteOrderSync() {
		global $wpdb;
		$order_sync = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key = "ns_order_internal_id"', OBJECT );
		return $order_sync; 
	}

	public function getOrderSyncLogs() {
		global $wpdb;
		$wpdb->netsuite_order_logs = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';
		$order_sync_data = $wpdb->get_results( "SELECT * FROM $wpdb->netsuite_order_logs"); 
		return $order_sync_data; 
	}

	public function getOrderLogByOrderId( $order_id) {
		global $wpdb;
		$wpdb->netsuite_order_logs = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';
		$order_sync_log = $wpdb->get_results($wpdb->prepare( "SELECT * FROM $wpdb->netsuite_order_logs WHERE woo_object_id = %d", $order_id));

		return $order_sync_log; 
	}

	public function getNetSuiteSaveSettings() {
		global $wpdb; 

		// $all_setting = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->options}` WHERE (`option_name` LIKE '%tmwni_%'   OR `option_name` LIKE '%netstuite_%' OR `option_name` LIKE '%_cm_options%') "));


		$all_setting = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->options}` WHERE (`option_name` LIKE %s   OR `option_name` LIKE %s OR `option_name` LIKE %s) ", '%tmwni_%' , '%netstuite_%' , '%_cm_options%' ));

		return $all_setting; 

	}

	public static function get_post_id_by_meta_key_and_value( $key, $value) {
			global $wpdb;
			$meta = $wpdb->get_results('SELECT post_id FROM `' . $wpdb->postmeta . "` WHERE meta_key='" . esc_sql($key) . "' AND meta_value='" . esc_sql($value) . "'");
		if (is_array($meta) && !empty($meta) && isset($meta[0])) {
			$meta = $meta[0];
		}   
		if (is_object($meta)) {
			return $meta->post_id;
		} else {
			return false;
		}
	}



}

