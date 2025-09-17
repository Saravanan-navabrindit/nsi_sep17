<?php

/**
 * This class handles all API operations related to creating and updating customer 
 * on Netsuite
 * API Ref : http://tellsaqib.github.io/NSPHP-Doc/index.html
 *
 * Author : Manish Gautam
 */

// Including development toolkit provided by Netsuite
require_once(TMWNI_DIR . 'inc/NS_Toolkit/src/NetSuiteService.php');
require_once TMWNI_DIR . 'inc/common.php';
foreach (glob(TMWNI_DIR . 'inc/NS_Toolkit/src/Classes/*.php') as $filename) {
	require_once $filename;
}

use NetSuite\NetSuiteService;
use NetSuite\Classes\ReturnAuthorization;
use NetSuite\Classes\ReturnAuthorizationItemList;
use NetSuite\Classes\ReturnAuthorizationItem;
use NetSuite\Classes\AddRequest;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\SearchMultiSelectField;
use NetSuite\Classes\RecordType;
use NetSuite\Classes\SEARCHENUMMULTISELECTFIELDOPERATOR;
use NetSuite\Classes\TransactionSearchBasic;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\SearchStringField;
use NetSuite\Classes\SearchStringFieldOperator;
use NetSuite\Classes\GetRequest;
use NetSuite\Classes\SearchEnumMultiSelectField;







class OrderRefund extends CommonIntegrationFunctions {

	public $netsuiteService;
	public $object_id;	
	public $user_id;
	public $custFields = array();

			//public $service = new NetSuiteService();


	public function __construct() {
		//set netsuite API client object
		if (TMWNI_Settings::areCredentialsDefined()) {
			$this->netsuiteService = new NetSuiteService(null, array('exceptions' => true));
		}
	}


	public function create_nd_refund( $order_id, $refund_id, $order_ns_internal_id) {
		$this->object_id = $order_id;
		
		$customer_internal_id = get_post_meta($order_id, TMWNI_Settings::$ns_order_customer_id, true);

		$refund = new WC_Order_Refund($refund_id);
		if (!$refund->get_items()) {
			$refund_order = new WC_Order($refund->get_parent_id());
			$refund = $refund_order;
		}




		$ReturnAuthorization = new ReturnAuthorization();
		
		$ReturnAuthorization->entity = new RecordRef();
		$ReturnAuthorization->entity->internalId = $customer_internal_id;


		$ReturnAuthorization->createdFrom = new RecordRef();
		$ReturnAuthorization->createdFrom->internalId = $order_ns_internal_id;




		$ReturnAuthorization->itemList = new ReturnAuthorizationItemList();

		$items = $this->_setRefundItems($refund->get_items());

		$ReturnAuthorization->itemList->item = $items;

		$request = new AddRequest();
		$request->record = $ReturnAuthorization;
		//pr($ReturnAuthorization);
		try {

			$addResponse = $this->netsuiteService->add($request);
			 //pr($addResponse); die('abcd');
			return $this->handleAPIAddResponse($addResponse, 'order_refund');
		} catch (SoapFault $e) {
			$object = 'order_refund';

			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Add' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Error Message: ' . $e->getMessage();

			$this->handleLog(0, $this->object_id, $object, $error_msg);

			return 0;
		}




	}


	public static function _setRefundItems( $refund_items) {
		$key=0;
		foreach ($refund_items as $item_key => $item) {
			$total_price = abs($item->get_total());

			$unit_price = round(number_format((float) ( $total_price / abs($item->get_quantity()) ) , 2, '.', ''));

			$ns_product_id 		= get_post_meta($item->get_product_id(), TMWNI_Settings::$ns_product_id, true);
			$soi[$key] = new ReturnAuthorizationItem();
			$soi[$key]->item = new RecordRef();
			$soi[$key]->item->internalId = $ns_product_id;
			$soi[$key]->quantity = absint($item->get_quantity());
			$soi[$key]->price = $unit_price;
			$key++;


		}

		return $soi; 

	} 


	public static function get_refund_order() {
		global $TMWNI_OPTIONS;



		$args = array(
			'status' => 'processing',
			'limit' => 1000,
			'meta_key'     => 'ns_order_internal_id', // The postmeta key field
			'meta_compare' => 'EXISTS',

		);

		$orders = wc_get_orders( $args );

		$internalIds_array = array();
		$order_internalIds_array = array();
		foreach ($orders as $key => $order) {
			$order_id = $order->get_id();
			$netSuiteSOInternalID = get_post_meta($order_id, 'ns_order_internal_id', true);
			//$netSuiteSOInternalID = 271222;
			$searchValue = new RecordRef();
			$searchValue->internalId = $netSuiteSOInternalID;	
			$internalIds_array[] = 	$searchValue;
			$order_internalIds_array[$netSuiteSOInternalID] = $order_id;	

		}


		if (!empty($internalIds_array)) {
			$ns_service = new NetSuiteService();

			$selectedField = new SearchMultiSelectField();
			$selectedField->searchValue = $internalIds_array;
			//$selectedField->type = RecordType::RETURNAUTHORIZATION;
			$selectedField->operator = SEARCHENUMMULTISELECTFIELDOPERATOR::ANYOF;


			$RecordType = new SearchStringField();
			$RecordType->searchValue = RecordType::RETURNAUTHORIZATION;
			$RecordType->operator = SearchStringFieldOperator::IS;

			$tranSearch = new TransactionSearchBasic();
			$tranSearch->createdFrom = $selectedField;
			$tranSearch->recordType = $RecordType;

			if (isset($TMWNI_OPTIONS['ns_order_refund_status']) && 'All' != $TMWNI_OPTIONS['ns_order_refund_status']) {


				$statusField = new SearchEnumMultiSelectField();
				$statusField->searchValue = $TMWNI_OPTIONS['ns_order_refund_status'];
				//$selectedField->type = RecordType::RETURNAUTHORIZATION;
				$statusField->operator = 'anyOf';
				$tranSearch->status = $statusField;

			}
			



			


			$request = new SearchRequest();
			$request->searchRecord = $tranSearch;
			try {
				$searchResponse = $ns_service->search($request);
				if (isset($searchResponse->searchResult->status->isSuccess) && 1 == $searchResponse->searchResult->status->isSuccess) {

					$records = $searchResponse->searchResult->recordList->record;
					foreach ($records as $key => $record) {
						$order_internal_id = $record->createdFrom->internalId;
						if (isset($order_internalIds_array[$order_internal_id])) {
							$order_refund_id = $record->internalId;
							$ReturnAuthorization = self::getRefundAuthorization($order_refund_id);
							if (empty($ReturnAuthorization)) {
								return;
							}
							$items = self::getRefundItems($ReturnAuthorization);
							$discountTotal = self::getReturnAuthorizationDiscount($ReturnAuthorization);
							$discountTotal = abs($discountTotal);

							if (!empty($items)) {
								// if($order_internalIds_array[$order_internal_id] != '2103'){
								// 	continue;
								// }

								self::orderRefundWoo($items, $order_internalIds_array[$order_internal_id], $order_refund_id, $discountTotal);

							}
						}

					}

				}

			} catch (SoapFault $e) {
				return 0;
			}
			
		}

	}

	public static function getRefundAuthorization( $order_refund_id) {
		$ns_service = new NetSuiteService();

		$request = new GetRequest();
		$request->baseRef = new RecordRef();
		$request->baseRef->internalId = $order_refund_id; //<< REPLACE THIS WITH YOUR INTERNAL ID
		$request->baseRef->type = RecordType::RETURNAUTHORIZATION;
		try {
			$getResponse = $ns_service->get($request);
			if (isset($getResponse->readResponse->status->isSuccess) && 1 == $getResponse->readResponse->status->isSuccess ) {
				return $getResponse;
			}
		} catch (SoapFault $e) {
			return 0;
		}

		return 0;

	} 

	public static function getRefundItems( $getResponse) {
		if (isset($getResponse->readResponse->record->itemList->item) && !empty($getResponse->readResponse->record->itemList->item)) {
			$items = $getResponse->readResponse->record->itemList->item;
			return $items;
		}

					return 0;

	}

	public static function getReturnAuthorizationDiscount( $getResponse) {
		if (isset($getResponse->readResponse->record->discountTotal) && !empty($getResponse->readResponse->record->discountTotal)) {
			return $getResponse->readResponse->record->discountTotal;
		}

				return 0;

	}

	public static function orderRefundWoo( $items, $order_id, $order_refund_id, $discountTotal) {

		$order  = wc_get_order( $order_id );
		$line_items = array();
		$inv_lines = array();


		if ( 'refunded' == $order_id ) {
			return false;
		}

		// if (count($order->get_refunds()) > 0) {
		// 	return false;
		// }

		foreach ($items as $ilkey => $item) {
			if (isset($item->item->internalId)) {
				$product_id = self::get_post_id_by_meta_key_and_value(TMWNI_Settings::$ns_product_id, $item->item->internalId);
				if ($product_id) {
					$items[$product_id] = $item;
				}
			}
		}



		$woo_order_items   = $order->get_items();
		$refund_amount = 0;
		if ( $woo_order_items ) {
			foreach ($woo_order_items as $woo_order_item_id => $woo_order_item ) {
				$product_id = $woo_order_item->get_product_id();


				if (isset($items[$product_id])) {
					$item = $items[$product_id];
					$item_qty_refunded = abs($order->get_qty_refunded_for_item($woo_order_item_id)); // Get the refunded amount for a line item.
					if ($item_qty_refunded != $item->quantity) {
						$item_meta 	= $order->get_item_meta( $woo_order_item_id );

						$quantity = ( $item->quantity - $item_qty_refunded );

						$item_total = $item->rate * $quantity;
						$refund_total = $item_total - $discountTotal;
						$refund_tax = $item->taxAmount;


						$refund_amount = round( $refund_amount ) + round( $refund_total + $refund_tax );



						$line_items[ $woo_order_item_id ] = array( 
							'qty' => $quantity,
							'refund_total' => round($refund_total),
							'refund_tax' =>  $refund_tax,
						);
					}
				}




			}

			if (!empty($line_items)) {
				// die('one');
				$refund_data = array(
					'amount'         => $refund_amount,
					'reason'         => 'NetSuite Refund',
					'order_id'       => $order_id,
					'line_items'     => $line_items,
					'refund_payment' => false
				);




				$refund = wc_create_refund( $refund_data );
				


				if (!is_wp_error($refund)) {
					update_post_meta($order_id, TMWNI_Settings::$ns_order_refund_internal_id, $order_refund_id);
				}
			}



		}



		





	}	


	


	

}
