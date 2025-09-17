<?php

/**
 * This class handles all API operations related to fetching tracking information for orders 
 * on Netsuite
 * API Ref : http://tellsaqib.github.io/NSPHP-Doc/index.html
 *
 * Author : Manish Gautam
 */
// including development toolkit provided by Netsuite
require_once TMWNI_DIR . 'inc/NS_Toolkit/src/NetSuiteService.php';
require_once TMWNI_DIR . 'inc/common.php';
foreach (glob(TMWNI_DIR . 'inc/NS_Toolkit/src/Classes/*.php') as $filename) {
	require_once $filename;
}

use NetSuite\NetSuiteService;
use NetSuite\Classes\GetRequest;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\SearchStringField;
use NetSuite\Classes\SearchMultiSelectField;
use NetSuite\Classes\SEARCHENUMMULTISELECTFIELDOPERATOR;
use NetSuite\Classes\TransactionSearchBasic;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\SearchDateField;

class OrdertrackingClient extends CommonIntegrationFunctions {


	public $netsuiteService;
	public $object_id;


	public function __construct() {
		//set netsuite API client object
		if (TMWNI_Settings::areCredentialsDefined()) {
			$this->netsuiteService = new NetSuiteService();
		}
	}


	/**
	 * Search orders within woocommerce 
	 * with status processing and fetches there tracking info. from NetSuite 
	 */

	public function getProcessingOrders( $order_args = array(), $search_date = '' ) {
		global $TMWNI_OPTIONS;

		$order_args = array_merge( array(
			'count' => 500,
			'page' => 1,
			'order' => 'DESC',
			'status' => array( 'on-hold', 'processing', 'partially-fulfill', 'pending-billing', 'pending-approval', 'pending-fulfill' ),
		), $order_args );

		$internalIds_array = array();

		$args = array(
			'status' => $order_args['status'],
			'limit' => $order_args['count'],
			'order' => $order_args['order'],
			'paged' => $order_args['page'],
			'meta_key'     => 'ns_order_internal_id', // The postmeta key field
			'meta_compare' => 'EXISTS',
		);

		if ( isset( $_GET['fetchOrderTrackingInfo'] ) && intval( $_GET['fetchOrderTrackingInfo'] ) > 0 ) {
			$args['paged'] = intval( $_GET['fetchOrderTrackingInfo'] );
		}

		$order_ids = wc_get_orders( array_merge( $args, array( 'return' => 'ids' ) ) );

		return $this->syncOrders( $order_ids, $search_date );

		if ( empty( $orders ) ) return 0;

		foreach ($orders as $key => $order) {
			$order_id = $order->get_id();
			$netSuiteSOInternalID = get_post_meta($order_id, 'ns_order_internal_id', true);
			$order_status = $order->get_status();
			if ( in_array( $order_status, $order_args['status'] ) ) {
				$searchValue = new RecordRef();
				$searchValue->internalId = $netSuiteSOInternalID;	
				$internalIds_array[] = 	$searchValue;	
			}
		}

		if (!empty($internalIds_array)) {
			$ns_service = new NetSuiteService();

			$selectedField = new SearchMultiSelectField();
			$selectedField->searchValue = $internalIds_array;
			$selectedField->type = 'salesOrder';
			$selectedField->operator = SEARCHENUMMULTISELECTFIELDOPERATOR::ANYOF;


			$tranSearch = new TransactionSearchBasic();
			$tranSearch->internalId = $selectedField;


			$request = new SearchRequest();
			$request->searchRecord = $tranSearch;


			try {
				$searchResponse = $ns_service->search($request);
				if (isset($searchResponse->searchResult->status->isSuccess) && 1 == $searchResponse->searchResult->status->isSuccess) {
					$records = $searchResponse->searchResult->recordList->record;
					if ( empty( $records ) ) return -1;
					foreach ($records as $key => $record) {
						if ( class_exists( 'WP_CLI' ) ) WP_CLI::log( 'Syncing order ' . ( isset( $record->tranId ) ? $record->tranId : $record->internalId ) );
						$this->updateFulFillment($record);
					}
					return count( $records );
				}

			} catch (SoapFault $e) {
				return 0;
			}
			
		}

	}

	public function syncOrders( $order_ids, $search_date = '' ) {
		$syncable_statuses = array( 'on-hold', 'processing', 'partially-fulfill', 'pending-billing', 'pending-approval', 'pending-fulfill' );

		if ( empty( $order_ids ) ) return 0;

		foreach ($order_ids as $order_id) {
			$order = wc_get_order( $order_id );
			$netSuiteSOInternalID = get_post_meta($order_id, 'ns_order_internal_id', true);
			$order_status = $order->get_status();
			if ( in_array( $order_status, $syncable_statuses ) ) {
				$searchValue = new RecordRef();
				$searchValue->internalId = $netSuiteSOInternalID;	
				$internalIds_array[] = $searchValue;	
			}
		}

		if (!empty($internalIds_array)) {
			$ns_service = new NetSuiteService();

			$selectedField = new SearchMultiSelectField();
			$selectedField->searchValue = $internalIds_array;
			$selectedField->type = 'salesOrder';
			$selectedField->operator = SEARCHENUMMULTISELECTFIELDOPERATOR::ANYOF;

			$tranSearch = new TransactionSearchBasic();
			$tranSearch->internalId = $selectedField;

            if ( !empty($search_date) ) {
                $search_field_lastmodified_date = new SearchDateField();
                $search_field_lastmodified_date->operator = 'after';
                $search_field_lastmodified_date->searchValue = $search_date;
                $tranSearch->lastModifiedDate = $search_field_lastmodified_date;
            }

			$request = new SearchRequest();
			$request->searchRecord = $tranSearch;

			try {
				$searchResponse = $ns_service->search($request);
				if (isset($searchResponse->searchResult->status->isSuccess) && 1 == $searchResponse->searchResult->status->isSuccess) {
					$records = $searchResponse->searchResult->recordList->record;
					if ( empty( $records ) ) return -1;
					foreach ($records as $key => $record) {
						// print_r($record); die;
						$this->updateFulFillment($record);
					}
					return count( $records );
				}

			} catch (SoapFault $e) {
				return 0;
			}
			
		}

	}

	public static function updateFulFillment( $record) {
		global $TMWNI_OPTIONS;

        $file_dir 		= wp_upload_dir();
        $date 	        = date("Y-m-d");
        $folder_name 	= 'netsuite-sync-logs';
        $folder_path 	= $file_dir['basedir'] . '/' . $folder_name;
        $file_name 		= $folder_path . '/sync-orders-' . $date . '.log';

        if ( !file_exists($folder_path)) {
            mkdir( $folder_path, 0755, true );
        }

        $datetime = date('Y-m-d H:i:s');

		$order_internal_id = $record->internalId;
		$args = array(
			'meta_key'     => 'ns_order_internal_id', // The postmeta key field
			'meta_value' => $order_internal_id,

		);

		$order = wc_get_orders($args);
		$order_id = $order[0]->get_id();
        $order_meta = get_post_meta( $order_id );

        $log_file_content = '[' . $datetime . '] Sync of WC Order ' . $order_id . ' / NS Order Internal ID: ' . $order_internal_id . PHP_EOL;

        /**
         * Order updates turned off, as the process was moved to @see NS_orders_updates_import
         */
		/*$tracking_number = null;
		if ( isset( $record->customFieldList ) && isset( $record->customFieldList->customField ) && is_array( $record->customFieldList->customField ) ) {
			foreach ( $record->customFieldList->customField as $custom_field ) {
				if ( isset( $custom_field->scriptId ) && $custom_field->scriptId == 'custbody_softeon_tracking_number' ) {
					$tracking_number = isset( $custom_field->value ) ? $custom_field->value : $tracking_number;
				}
			}
		}

		if ( $tracking_number ) {
			$trackingNo = $tracking_number;
			$is_new_tracking_no = false;
			if (isset($TMWNI_OPTIONS['ns_order_tracking_number']) && !empty($TMWNI_OPTIONS['ns_order_tracking_number'])) {
                $existing_tracking_no = $order_meta[$TMWNI_OPTIONS['ns_order_tracking_number']][0] ?? '';
				if ( ! empty( $trackingNo ) && $existing_tracking_no != $trackingNo ) {
					$is_new_tracking_no = true;
				}
				update_post_meta($order_id, $TMWNI_OPTIONS['ns_order_tracking_number'], $trackingNo);
                $log_file_content .= 'Tracking number: ' . $trackingNo . PHP_EOL;
			}
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_tracking_code', $trackingNo );
            Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_picked_up', 'on' );

			if (empty(get_post_meta($order_id, 'trackingno_email_sent', true)) || $is_new_tracking_no) {
				if (isset($TMWNI_OPTIONS['ns_order_tracking_email']) && !empty($TMWNI_OPTIONS['ns_order_tracking_email'])) {
					$wc_emails = WC()->mailer()->get_emails();
					$wc_emails['WC_NetSuite_Order_Tracking_No']->trigger($order_id);
					update_post_meta($order_id, 'trackingno_email_sent', 'sent');
                    $log_file_content .= 'Tracking email sent' . PHP_EOL;
				}
			}

		}

		if (isset($record->shipMethod) && !empty($record->shipMethod)) {

			$ShippingCarrier = $record->shipMethod->name;
            $log_file_content .= 'Shipping Carrier: ' . $ShippingCarrier . PHP_EOL;
			if (isset($TMWNI_OPTIONS['ns_order_shipping_courier']) && !empty($TMWNI_OPTIONS['ns_order_shipping_courier'])) {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_shipping_courier', $ShippingCarrier );
			} else {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_carrier_name', $ShippingCarrier );
			}

		}

		if (isset($record->shipDate) && !empty($record->shipDate)) {

			$ShipDate = gmdate('Y-m-d', strtotime($record->shipDate));
            $log_file_content .= 'Shipping Date: ' . $ShipDate . PHP_EOL;
			if (isset($TMWNI_OPTIONS['ns_order_pickup_date']) && !empty($TMWNI_OPTIONS['ns_order_pickup_date'])) {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_pickup_date', $ShipDate );
			} else {
                Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ywot_pick_up_date', $ShipDate );
			}
		}

		if ( ! empty( $record->orderStatus ) || ! empty( $record->status ) ) {
			if ( ! empty( $record->status ) && isset( $TMWNI_OPTIONS['ns_order_auto_complete'] ) && ! empty( $TMWNI_OPTIONS['ns_order_auto_complete'] ) ) {
				$order_status = $order_meta['ns_order_status'][0] ?? '';
				if ( $order_status != $record->status ) {
                    Crown_Shop_Products::maybe_update_postmeta( $order_id, $order_meta, 'ns_order_status', $record->status );
                    $log_file_content .= 'NS order status: ' . $record->status . PHP_EOL;
					$order = new WC_Order( $order_id );
					if ( $record->status == 'Billed' || $record->status == 'Closed' ) {
						$order->update_status( 'completed' );
					} else if ( $record->status == 'Partially Fulfilled' ) {
						$order->update_status( 'partially-fulfill' );
					} else if ( $record->status == 'Cancelled' ) {
						$order->update_status( 'cancelled' );
					} else if ( $record->status == 'Pending Billing' ) {
						$order->update_status( 'pending-billing' );
					} else if ( $record->status == 'Pending Fulfillment' ) {
						$order->update_status( 'pending-fulfill' );
					} else {
						// default to pending approval
						$order->update_status( 'pending-approval' );
					}
				}
			}
		}*/

        file_put_contents( $file_name, $log_file_content . PHP_EOL, FILE_APPEND );
	}

}
