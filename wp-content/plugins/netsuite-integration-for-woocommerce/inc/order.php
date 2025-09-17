<?php

/**
 * This class handles all API operations related to creating sales order on Netsuite
 * API Ref : http://tellsaqib.github.io/NSPHP-Doc/index.html
 *
 * Author : Manish Gautam
 */
// Including development toolkit provided by Netsuite
require_once TMWNI_DIR . 'inc/NS_Toolkit/src/NetSuiteService.php';
require_once TMWNI_DIR . 'inc/NS_Toolkit/src/includes/functions.php';

require_once TMWNI_DIR . 'inc/common.php';
foreach (glob(TMWNI_DIR . 'inc/NS_Toolkit/src/Classes/*.php') as $filename) {
	require_once $filename;
}






use NetSuite\NetSuiteService;
use NetSuite\Classes\SearchStringField;
use NetSuite\Classes\ItemSearchBasic;
use NetSuite\Classes\SearchRequest;
use NetSuite\Classes\SalesOrder;
use NetSuite\Classes\RecordRef;
use NetSuite\Classes\Address;
use NetSuite\Classes\SalesOrderItemList;
use NetSuite\Classes\SalesOrderItem;
use NetSuite\Classes\UpdateRequest;
use NetSuite\Classes\AddRequest;
use NetSuite\Classes\PromotionsList;
use NetSuite\Classes\Promotions;
use NetSuite\Classes\PromotionCodeUseType;
use NetSuite\Classes\PromotionCode;
use NetSuite\Classes\PromotionCodeSearchBasic;
use NetSuite\Classes\DeleteRequest;
use NetSuite\Classes\CustomFieldList;
use NetSuite\Classes\StringCustomFieldRef;
use NetSuite\Classes\SelectCustomFieldRef;
use NetSuite\Classes\ListOrRecordRef;
use NetSuite\Classes\MultiSelectCustomFieldRef;
use NetSuite\Classes\BooleanCustomFieldRef;
use NetSuite\Classes\DoubleCustomFieldRef;
use Netsuite\Classes\SearchCustomFieldList;
use NetSuite\Classes\SearchCustomField;
use NetSuite\Classes\SearchStringCustomField;













class OrderClient extends CommonIntegrationFunctions {

	public $netsuiteService;
	public $object_id;
	public $custFields = array();
	public $user_id = 0;

	public function __construct() {
		//set netsuite API client object
		if (TMWNI_Settings::areCredentialsDefined()) {
			$this->netsuiteService = new NetSuiteService();
		}
	}

	/**
	 * Search item using woocommerce product SKU
	 * ref: samples provided in Netsuite API toolkit
	 */
	public function searchItem( $item_sku, $product_id = 0, $variation_id = 0) {

		$this->netsuiteService->setSearchPreferences(false, 20);

		global $TMWNI_OPTIONS;

		$SearchField = new SearchStringField();
		$SearchField->operator = 'is';
		$SearchField->searchValue = $item_sku;
		$search = new ItemSearchBasic();

		if (!isset($TMWNI_OPTIONS['sku_mapping_field']) || empty($TMWNI_OPTIONS['sku_mapping_field']) ) {

			$search->itemId = $SearchField;

		} elseif ('customFieldList' == $TMWNI_OPTIONS['sku_mapping_field']) {

			$search->{$TMWNI_OPTIONS['sku_mapping_field']} = $this->customSearchField($TMWNI_OPTIONS['sku_mapping_custom_field'], $item_sku);

		} else {

			$search->{$TMWNI_OPTIONS['sku_mapping_field']} = $SearchField;

		}


		$search = apply_filters('tm_ns_order_search_item', $search, $item_sku, $product_id);
		$request = new SearchRequest();
		$request->searchRecord = $search;
		$item_internal_id = 0;
		if (!empty($variation_id)) {
			$object_id = $variation_id;
			$object = 'order product_variation search';
		} else {
			$object_id = $product_id;
			$object = 'order product search';
		}
		// pr($search);
		// die('**');
		try {
			$searchResponse = $this->netsuiteService->search($request);
			if (!$searchResponse->searchResult->status->isSuccess) {
				$error_msg = "'" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $object_id . '. ';
				$error_msg .= 'Search Keyword:' . $item_sku . '. ';
				$error_msg .= 'Error Message : ' . $response->writeResponse->status->statusDetail[0]->message;
				$this->handleLog(0, $object_id, $object, $error_msg);
			} else {
				//check if search record found
				if (1 == $searchResponse->searchResult->status->isSuccess) {

					apply_filters('tm_ns_after_search_item', $searchResponse, $item_sku, $product_id);
					//get items location id 
					$item_internal_id = $searchResponse->searchResult->recordList->record[0]->internalId;
					// pr($searchResponse);
					// pr($item_internal_id);die('!**');
					if (!empty($variation_id)) {
						update_post_meta($variation_id, TMWNI_Settings::$ns_product_id, $item_internal_id);
					} else {
						update_post_meta($product_id, TMWNI_Settings::$ns_product_id, $item_internal_id);
					}
					//get items location id 
					$item_location_id = isset($searchResponse->searchResult->recordList->record[0]->location->internalId) ? $searchResponse->searchResult->recordList->record[0]->location->internalId : '' ;
					if (!empty($item_location_id)  || !is_null($item_location_id)) { 
						if (!empty($variation_id)) {
							update_post_meta($variation_id, 'ns_item_location_id', $item_location_id);
						} else {
							update_post_meta($product_id, 'ns_item_location_id', $item_location_id);
						}
					}
					$this->handleLog(1, $object_id, $object);
				}
				return $item_internal_id;
			}
		} catch (SoapFault $e) {
			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $object_id . '. ';
			if (!empty($variation_id)) {
				$error_msg .= 'Product ID: ' . $product_id . '. ';
			}
			$error_msg .= 'SKU: ' . $item_sku . '. ';
			$error_msg .= 'Error Message: ' . $e->getMessage();
			$this->handleLog(0, $object_id, $object, $error_msg);
			return 0;
		}
	}


	/**
	 * Adding sales order to Netsuite
	 */
	public function addOrder( $order_data, $customer_internal_id) {
		$order_sync_status = true;
		$order_sync_status  = apply_filters('tm_netsuite_order_sync_status', $order_sync_status, $order_data);
		if (false != $order_sync_status) {
			global $TMWNI_OPTIONS;

			$order = $order_data['order'];

			$this->object_id = $order_data['order_id'];
			$so = new SalesOrder();

		//order customer
			$so->entity = new RecordRef();
			$so->entity->internalId = $customer_internal_id;

			$this->salesOrderConditionalMapping($order_data, $order);

			$this->createRequest($so, $order_data);

		//currency
			$order_currency = $order_data['order_currency'];
			if (isset($TMWNI_OPTIONS['ns_order_woo_currency']) && !empty($TMWNI_OPTIONS['ns_order_woo_currency'])) {
				$saved_order_currency = array_combine($TMWNI_OPTIONS['ns_order_woo_currency'], $TMWNI_OPTIONS['ns_order_netsuite_currency_internal_id']);
				if (isset($saved_order_currency[$order_currency]) && !empty($saved_order_currency[$order_currency])) {
					$so->currency = $saved_order_currency[$order_currency];
				}
			}

			if (isset($order_data['billing_address']['country']) && !empty($order_data['billing_address']['country'])) {
				$ns_billing_country = $order_data['billing_address']['country'];
			} else {
				$ns_billing_country = '';
			}
		//set po field 
			$so->billingAddress = new Address();
			$so->billingAddress->addr1 = $order_data['billing_address']['address_1'];
			$so->billingAddress->addr2 = $order_data['billing_address']['address_2'];
			$so->billingAddress->attention = $order_data['billing_address']['first_name'] . ' ' . $order_data['billing_address']['last_name'];
			$so->billingAddress->addressee = $order_data['billing_address']['company'];
			$so->billingAddress->city = $order_data['billing_address']['city'];
			$so->billingAddress->state = $order_data['billing_address']['state'];
			$so->billingAddress->zip = $order_data['billing_address']['postcode'];
			$so->billingAddress->country = $ns_billing_country;
			$so->billingAddress->addrPhone = $order_data['billing_address']['phone'];



			if (isset($order_data['shipping_address']['country']) && !empty($order_data['shipping_address']['country'])) {
				$ns_shipping_country = $order_data['shipping_address']['country'];
			} else {
				$ns_shipping_country = '';
			}
			$so->shippingAddress = new Address();
			$so->shippingAddress->addr1 = $order_data['shipping_address']['address_1'];
			$so->shippingAddress->addr2 = $order_data['shipping_address']['address_2'];
			$so->shippingAddress->attention = $order_data['shipping_address']['first_name'] . ' ' . $order_data['shipping_address']['last_name'];
			$so->shippingAddress->addressee = $order_data['shipping_address']['company'];
			$so->shippingAddress->city = $order_data['shipping_address']['city'];
			$so->shippingAddress->state = $order_data['shipping_address']['state'];
			$so->shippingAddress->zip = $order_data['shipping_address']['postcode'];
			$so->shippingAddress->country = $ns_shipping_country;

			$order_payment_method = $order_data['order_payment_method'];
			if (isset($TMWNI_OPTIONS['ns_order_woo_payment_method']) && !empty($TMWNI_OPTIONS['ns_order_woo_payment_method'])) {
				$saved_order_payment_method = array_combine($TMWNI_OPTIONS['ns_order_woo_payment_method'], $TMWNI_OPTIONS['ns_order_netsuite_payment_method']);
				if (isset($saved_order_payment_method[$order_payment_method]) && !empty($saved_order_payment_method[$order_payment_method])) {
					$so->paymentMethod = new RecordRef();
					$so->paymentMethod->internalId = $saved_order_payment_method[$order_payment_method];
				}
			}

			$so->itemList = new SalesOrderItemList();


			$quote_id = get_post_meta( $order_data['order_id'], 'converted_quote_id', true );
			$items = $this->_setOrderItems($order_data['items'], $order_data['total_shipping'], ! empty( $quote_id ) );

			$so->itemList->item = $items;			
			$so->itemList->item = apply_filters('tm_ns_order_item', $items, $order_data['items'], $order_data['total_shipping'], $order_data['order_id']);



			if (isset($TMWNI_OPTIONS['ns_coupon_netsuite_sync']) && !empty($TMWNI_OPTIONS['ns_coupon_netsuite_sync'])) {

				$promoCodes = array();

				$order = new WC_Order($order_data['order_id']);

				$applied_coupons = $order->get_coupon_codes();

				if (!empty($applied_coupons)) {
					foreach ( $applied_coupons as $key => $value) {
						if (isset($TMWNI_OPTIONS['ns_promo_discount_id']) && !empty($TMWNI_OPTIONS['ns_promo_discount_id']) ) {
							$promoCodes[] = $this->_addNSpromo($value, $TMWNI_OPTIONS['ns_promo_discount_id']);
						} else {
							$promoCodes[] = $this->_addNSpromo($value);
						}
					}
				}

				if ( isset($promoCodes) && !empty($promoCodes) ) {

					$so->canHaveStackable = 1;

					$promoListObj = new PromotionsList();
					$promoListObj->promotions = array();
					foreach ($promoCodes as $codeKey => $codeValue) {

						$recRef = new RecordRef();
						$recRef->internalId = $codeValue;
						$promoListObj->promotions[$codeKey] = new Promotions();
						$promoListObj->promotions[$codeKey]->promoCode = $recRef;
					}

					$so->promotionsList = $promoListObj;

				}
			}


			if (isset($TMWNI_OPTIONS['ns_order_prefix']) && !empty($TMWNI_OPTIONS['ns_order_prefix'])) {
				$ns_public_order_id = $TMWNI_OPTIONS['ns_order_prefix'] . $order_data['order_id'];
			} else {
				$ns_public_order_id = $order_data['order_id'];
			}

			update_post_meta($order_data['order_id'], TMWNI_Settings::$ns_external_order_id, $ns_public_order_id);


			$so = apply_filters('tm_add_request_order_data', $so, $order_data['order_id']);		
			$request = new AddRequest();
			$request->record = $so;

			$uploads 		= wp_upload_dir();
			$date 			= date("Y-m-d");
			$folder_name 	= 'manual-sync-ns-logs';
			$path_folder 	= $uploads['basedir'] . '/' . $folder_name;
			$filename 		= 'tm_ns_netsuite_order_log-'.$date.'.log'; 
			$file 			= $path_folder . '/' . $filename;

			if ( !file_exists($path_folder)) {
				mkdir( $path_folder, 0755 );       
			} 

			if(!file_exists($file)){
				fopen($file, 'w');
				chmod($file, 0777);
			}  

			// @TODO move this outside this plugin
			if ( defined( 'NS_ORDERS_SYNC_PAYLOAD_ENABLED' ) && NS_ORDERS_SYNC_PAYLOAD_ENABLED ) {
				$payload_filename 		= 'tm_ns_netsuite_order_payload-' . $order_data['order_id'] . '-' . $date . '.json';
				$payload_file 			= $path_folder . '/' . $payload_filename;

				if(!file_exists($payload_file)){
					$payload_log_file = fopen($payload_file, 'w');
					chmod($payload_file, 0777);
					fclose($payload_log_file);
				}

				file_put_contents($payload_file, json_encode($request), FILE_APPEND);

			}
			try {

				$addResponse = $this->netsuiteService->add($request);
				//pr($addResponse); die;
				if (1 == $addResponse->writeResponse->status->isSuccess) {
					update_post_meta($order_data['order_id'], TMWNI_Settings::$ns_order_customer_id, $customer_internal_id);
					$order_internal_id = $addResponse->writeResponse->baseRef->internalId;
					do_action('tm_netsuite_after_order_add', $order_data, $customer_internal_id, $order_internal_id);

					if(file_exists($file)){
						// Date
						$micro_date = microtime();
						$date_array = explode(" ",$micro_date);
						$date = date("Y-m-d H:i:s", $date_array[1]);
		
						file_put_contents($file, '[ '.$date.' ]' . '.' . $date_array[1] . ';' . $order_data['order_id'] . ';' . print_r($so, true) . ';', FILE_APPEND);
					}
				}

				return $this->handleAPIAddResponse($addResponse, 'order');
			} catch (SoapFault $e) {
				$object = 'order';

				$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Add' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
				$error_msg .= 'Error Message: ' . $e->getMessage();

				$this->handleLog(0, $this->object_id, $object, $error_msg);

				if(file_exists($file)){
					// Date
					$micro_date = microtime();
					$date_array = explode(" ",$micro_date);
					$date = date("Y-m-d H:i:s", $date_array[1]);
	
					file_put_contents($file, '[ '.$date.' ]' . '.' . $date_array[1] . ';' . $order_data['order_id'] . '; Error Message: ' . $e->getMessage() . ';', FILE_APPEND);
				}
				return 0;
			}
		}	
	}

	/**
	 * Update Order
	 *
	*/ 
	public function updateOrder( $order_data, $customer_internal_id, $order_internal_id) {
		global $TMWNI_OPTIONS;
		// pr($order_data); die;

		$order_sync_status = true;

		$order_sync_status  = apply_filters('tm_netsuite_order_update_status', $order_sync_status, $order_data, $order_sync_status);

		if (false != $order_sync_status) {


			$order = $order_data['order'];

			$this->object_id = $order_data['order_id'];

			$so = new SalesOrder();

			$this->salesOrderConditionalMapping($order_data, $order, $order_internal_id);

			$this->createRequest($so, $order_data);

			if (isset($order_data['billing_address']['country']) && !empty($order_data['billing_address']['country'])) {
				$ns_billing_country = $order_data['billing_address']['country'];
				;
			} else {
				$ns_billing_country = '';
			}


		//set po field 
			$so->billingAddress = new Address();
			$so->billingAddress->addr1 = $order_data['billing_address']['address_1'];
			$so->billingAddress->addr2 = $order_data['billing_address']['address_2'];
			$so->billingAddress->attention = $order_data['billing_address']['first_name'] . ' ' . $order_data['billing_address']['last_name'];
			$so->billingAddress->addressee = $order_data['billing_address']['company'];
			$so->billingAddress->city = $order_data['billing_address']['city'];
			$so->billingAddress->state = $order_data['billing_address']['state'];
			$so->billingAddress->zip = $order_data['billing_address']['postcode'];
			$so->billingAddress->country = $ns_billing_country;
			$so->billingAddress->addrPhone = $order_data['billing_address']['phone'];


			if (isset($order_data['shipping_address']['country']) && !empty($order_data['shipping_address']['country'])) {
				$ns_shipping_country = $order_data['shipping_address']['country'];
			} else {
				$ns_shipping_country = '';
			}
			$so->shippingAddress = new Address();
			$so->shippingAddress->addr1 = $order_data['shipping_address']['address_1'];
			$so->shippingAddress->addr2 = $order_data['shipping_address']['address_2'];
			$so->shippingAddress->attention = $order_data['shipping_address']['first_name'] . ' ' . $order_data['shipping_address']['last_name'];
			$so->shippingAddress->addressee = $order_data['shipping_address']['company'];
			$so->shippingAddress->city = $order_data['shipping_address']['city'];
			$so->shippingAddress->state = $order_data['shipping_address']['state'];
			$so->shippingAddress->zip = $order_data['shipping_address']['postcode'];
			$so->shippingAddress->country = $ns_shipping_country;

			$so->itemList = new SalesOrderItemList();


			$items = $this->_setOrderItems($order_data['items'], $order_data['total_shipping']);

			$so->itemList->item = $items;
			
			$so->itemList->item = apply_filters('tm_ns_order_item', $items, $order_data['items'], $order_data['total_shipping'], $order_data['order_id']);

			if (isset($TMWNI_OPTIONS['ns_coupon_netsuite_sync']) && !empty($TMWNI_OPTIONS['ns_coupon_netsuite_sync'])) {

				$promoCodes = array();

				$order = new WC_Order($order_data['order_id']);

				$applied_coupons = $order->get_coupon_codes();

				if (!empty($applied_coupons)) {
					foreach ( $applied_coupons as $key => $value) {
						if (isset($TMWNI_OPTIONS['ns_promo_discount_id']) && !empty($TMWNI_OPTIONS['ns_promo_discount_id']) ) {
							$promoCodes[] = $this->_addNSpromo($value, $TMWNI_OPTIONS['ns_promo_discount_id']);
						} else {
							$promoCodes[] = $this->_addNSpromo($value);
						}
					}
				}

				if ( isset($promoCodes) && !empty($promoCodes) ) {

					$so->canHaveStackable = 1;

					$promoListObj = new PromotionsList();
					$promoListObj->promotions = array();
					foreach ($promoCodes as $codeKey => $codeValue) {

						$recRef = new RecordRef();
						$recRef->internalId = $codeValue;

					// $recRef->internalId = 3842;
						$promoListObj->promotions[$codeKey] = new Promotions();
						$promoListObj->promotions[$codeKey]->promoCode = $recRef;
					}

					$so->promotionsList = $promoListObj;

				}
			}

			$so->internalId = $order_internal_id;

			$so = apply_filters('tm_update_request_order_data', $so, $order_data['order_id']);


			$request = new UpdateRequest();
			$request->record = $so;

			
			try {
				$updateResponse = $this->netsuiteService->update($request);
				// pr($updateResponse); die;
				if (isset($updateResponse->writeResponse->status->isSuccess) && 1 == $updateResponse->writeResponse->status->isSuccess) {
					do_action('tm_netsuite_after_order_update', $order_data, $customer_internal_id, $order_internal_id);
				}
				return $this->handleAPIAddResponse($updateResponse, 'order');
			} catch (SoapFault $e) {
				$object = 'order';
				$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Add' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
				$error_msg .= 'Error Message: ' . $e->getMessage();

				$this->handleLog(0, $this->object_id, $object, $error_msg);

				return 0;
			}
		}

	}



	/**
	 * Setting sales order items
	 */
	private function _setOrderItems( $order_items, $shipping_cost, $order_from_quote = false) {
		global $TMWNI_OPTIONS;
		$soi = array();
		if (!empty($order_items)) {
			foreach ($order_items as $key => $item) {

				$soi[$key] = new SalesOrderItem();
				$soi[$key]->item = new RecordRef();
				$soi[$key]->item->internalId = $item['internalId'];
				$soi[$key]->quantity = $item['qty'];
				// $soi[$key]->taxcode = NS_ITEM_TAX_CODE;

				if (isset($TMWNI_OPTIONS['order_item_location']) && !empty($TMWNI_OPTIONS['order_item_location'])) {
					if (3 == $TMWNI_OPTIONS['order_item_location'] && isset($TMWNI_OPTIONS['order_item_location_value']) && !empty($TMWNI_OPTIONS['order_item_location_value'])) {

						$soi[$key]->location = new RecordRef();
						$soi[$key]->location->internalId = $TMWNI_OPTIONS['order_item_location_value'];
					}

					if (2 == $TMWNI_OPTIONS['order_item_location'] && ( isset($item['locationId']) && !empty($item['locationId']) )) {
						 //get items location id 
						$item_location_id = $item['locationId'];
						$soi[$key]->location = new RecordRef();
						$soi[$key]->location->internalId = $item_location_id;
					}
				}

				$soi[$key]->amount = $item['subtotal'];

				if ( $order_from_quote ) {
					$soi[$key]->price = new RecordRef();
					$soi[$key]->price->internalId = -1;
					$soi[$key]->rate = $item['subtotal'] / $item['qty'];
					$soi[$key]->priceLevel = "Custom";
					$soi[$key]->priceLevel = new RecordRef();
					$soi[$key]->priceLevel->internalId = -1;
				}

			}

			if (isset($TMWNI_OPTIONS['ns_order_shiping_line_item']) && !empty($TMWNI_OPTIONS['ns_order_shiping_line_item']) && isset($TMWNI_OPTIONS['ns_order_shiping_line_item_enable']) && !empty($TMWNI_OPTIONS['ns_order_shiping_line_item_enable']) ) {
				$key = ++$key;
				$soi[$key] = new SalesOrderItem();
				$soi[$key]->item = new RecordRef();
				$soi[$key]->item->internalId = $TMWNI_OPTIONS['ns_order_shiping_line_item'];
				$soi[$key]->quantity = 1;
				// $soi[$key]->taxcode = NS_SHIPPING_TAX_CODE;
				$soi[$key]->price = $shipping_cost;
				$soi[$key]->amount = $shipping_cost;
			}
		}
		return $soi;
	}


	/**
	 * Add order promo to NetSuite
	 */
	public function _addNSpromo( $value, $discount_internal_id = 0) {

		global $TMWNI_OPTIONS;

		$promoInternalID = $this->searchPromoCode($value);


		if (0 == $promoInternalID) {

			$coupon_post_obj = get_page_by_title($value, OBJECT, 'shop_coupon');

			$coupon_meta = get_metadata( 'post', $coupon_post_obj->ID);

			if ('fixed_cart' == $coupon_meta['discount_type'][0] || 'fixed_product'  == $coupon_meta['discount_type'][0] ) {
				$discountRate = $coupon_meta['coupon_amount'][0];
			} elseif ('percent' == $coupon_meta['discount_type'][0]) {
				$discountRate = $coupon_meta['coupon_amount'][0] . '%';
			}

			//Set Coupon code Use Type 
			$couponUseType = new PromotionCodeUseType();

			if ($coupon_meta['limit_usage_to_x_items'][0] > 0) {
				$usetype = $couponUseType::_MULTIPLEUSES;
			} else {
				$usetype = $couponUseType::_SINGLEUSE;
			}

			$coupan_expiry = '';

			if (!empty($coupon_meta['date_expires'][0])) {
				$coupan_expiry = gmdate(DATE_ATOM, $coupon_meta['date_expires'][0]);
			}

			$add_coupon = new PromotionCode();

			$discRef = new RecordRef();

			$discRef->internalId = $discount_internal_id;

			$customForm = new RecordRef();

			if (isset($TMWNI_OPTIONS['ns_promo_custform_id']) && !empty($TMWNI_OPTIONS['ns_promo_custform_id']) ) {
				$customForm->internalId = $TMWNI_OPTIONS['ns_promo_custform_id'];
			}

			$fieldsArray = array(
				'customForm' => $customForm,
				'name' => $coupon_post_obj->post_name, 
				'code' => $coupon_post_obj->post_title, 
						//"discount" => $this->createRecordRef($discount_internal_id),   //Uncomment if discount internal id is availble (Use 1701 for testing)
				'discount' => $discRef,
						'rate' => $discountRate,                                               //Uncomment if "discount" field is active
						//"useType" => $usetype,                                               //INSUFFICIENT_PERMISSION or Readonly field
						'description' => $coupon_post_obj->post_excerpt,
						'startDate' => gmdate(DATE_ATOM, strtotime($coupon_post_obj->post_date)),
						'endDate' => $coupan_expiry
					);

			setFields($add_coupon, $fieldsArray);

			try {

				$netsuitePromo = new AddRequest();
				$netsuitePromo->record = $add_coupon;
				$writeResponse = $this->netsuiteService->add($netsuitePromo);
				$this->handleAPIAddResponse($writeResponse, 'coupon');

				if (isset($writeResponse->writeResponse->status->isSuccess) && 1 == $writeResponse->writeResponse->status->isSuccess && isset($writeResponse->writeResponse->baseRef->internalId) && !empty($writeResponse->writeResponse->baseRef->internalId) ) {
					return $writeResponse->writeResponse->baseRef->internalId;
				} else {
					return 0;
				}
			} catch (SoapFault $exc) {
				$object = 'coupon';
				$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Add' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
				$error_msg .= 'Error Message: ' . $exc->getMessage();

				$this->handleLog(0, $this->object_id, $object, $error_msg);

				return 0;
			}
		} else {
			return $promoInternalID;
		}
	}


	/**
	 * Search order promo on NetSuite
	 */
	public function searchPromoCode( $PromotionCode) {


		$this->netsuiteService->setSearchPreferences(false, 20);

		$SearchCoupon = new SearchStringField();

		$SearchCoupon->operator = 'is';

		$SearchCoupon->searchValue = $PromotionCode;


		$search = new PromotionCodeSearchBasic();

		$search->code = $SearchCoupon;


		$request = new SearchRequest();
		$request->searchRecord = $search;

		try {
			$searchResponse = $this->netsuiteService->search($request);
			$this->handleAPISearchResponse($searchResponse, 'coupon', $PromotionCode);
			if (isset($searchResponse->searchResult->status->isSuccess) && 1 == $searchResponse->searchResult->status->isSuccess && isset($searchResponse->searchResult->recordList->record[0]->internalId) && !empty($searchResponse->searchResult->recordList->record[0]->internalId)) {
				return $searchResponse->searchResult->recordList->record[0]->internalId;
			} else {
				return 0;
			}
		} catch (SoapFault $exc) {
			$object = 'coupon';
			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Add' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Error Message: ' . $exc->getMessage();

			$this->handleLog(0, $this->object_id, $object, $error_msg);

			return 0;

		}

	}


	/**
	 * Delete Order
	 *
	*/ 
	public function deleteOrder( $nsOrderInternalId) {

		$nsSalesOrder = new RecordRef();
		$nsSalesOrder->type = 'salesOrder';
		$nsSalesOrder->internalId = $nsOrderInternalId;

		$deleteOrder = new DeleteRequest();
		$deleteOrder->baseRef = $nsSalesOrder;
		// $deleteOrder->deletionReason = "Trashed from the store";

		try {
			$delResponse = $this->netsuiteService->delete($deleteOrder);
			return $this->handleAPIAddResponse($delResponse, 'order');
		} catch (SoapFault $e) {
			$object = 'order';
			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Add' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Error Message: ' . $e->getMessage();
			$this->handleLog(0, $this->object_id, $object, $error_msg);
			return 0;
		}     

	}

	/**
	 * Create mapping Request
	 *
	*/ 
	public function createRequest( &$so, $order_data) {
		foreach ($order_data['ns_salesorder_fields'] as $nsfield => $value) {

			if ( isset($value['type']) && 'string' == $value['type'] || 'float' == $value['type'] || 'integer' == $value['type']) {

				if ('phone'==$nsfield && strlen($value['value']) > 6) {
					$so->$nsfield = $value['value'];
				} else {
					$so->$nsfield = $value['value'];

				}

			} elseif ( isset($value['type']) && 'dateTime' == $value['type']) {

				$so->$nsfield = gmdate(DATE_ATOM, strtotime($value['value']));

			} elseif ( isset($value['type']) && 'boolean' == $value['type']) {

				$so->$nsfield = $value['value'];

			} elseif ( isset($value['type']) && 'RecordRef' == $value['type']) {

				$so->$nsfield = new RecordRef();

				$so->$nsfield->internalId = $value['value'];

			} elseif ( isset($value['type']) && 'customboolean' == $value['type']) {

				$so->customFieldList = $this->customFieldboolean($nsfield, $value['value']);

			} elseif ( isset($value['type']) && 'customstringfield' == $value['type']) {

				$so->customFieldList = $this->customField($nsfield, $value['value']);

			} elseif ( isset($value['type']) && 'customselectfield' == $value['type']) {

				$so->customFieldList = $this->customFieldSelect($nsfield, $value['value']);

			} elseif ( isset($value['type']) && 'custommultiselectfield' == $value['type']) {

				$multiselectvalues = explode(',', $value['value']);

				$so->customFieldList = $this->customFieldMultiSelect($nsfield, $multiselectvalues);

			} elseif ( isset($value['type']) && 'customrecordref' == $value['type']) {

				$so->customFieldList = $this->customRecordRefField($nsfield, $value);

			} elseif ( isset($value['type']) && 'customcurrdatefield' == $value['type']) {

				$so->customFieldList = $this->customField($nsfield, gmdate('d/m/Y H:i:s'));

			} elseif ( isset($value['type']) &&  'customdateTime' == $value['type']) {

				$so->customFieldList = $this->customField($nsfield, $value['value']);

			}


		}
	}


	/**
	 * Creating custom field list array.
	 */
	public function customFieldList( $custfield) {
		$this->custFields[] = $custfield;
		$customFieldList = new customFieldList();
		$customFieldList->customField = $this->custFields;
		return $customFieldList;
	}


	/**
	 * Creating custom string field instance.
	 */
	public function customField( $scriptId, $value) {
		$custfield = new StringCustomFieldRef();
		$custfield->scriptId = $scriptId;
		$custfield->value = $value;
		return $this->customFieldList($custfield);
	}

	/**
	 * Creating custom string field instance.
	 */
	public function customRecordRefField( $scriptId, $value) {
		$custfield = new StringCustomFieldRef();
		$custfield->scriptId = $scriptId;
		$custfield->value = new RecordRef();
		$custfield->value->internalId = $value;
		return $this->customFieldList($custfield);
	}

	/**
	 * Creating custom select field instance.
	 */
	public function customFieldSelect( $scriptId, $value) {
		$custfieldselect = new SelectCustomFieldRef();
		$custfieldselect->scriptId = $scriptId;
		$recref = new ListOrRecordRef();
		$recref->internalId = $value;
		$custfieldselect->value = $recref;
		return $this->customFieldList($custfieldselect);
	}


	/**
	 * Creating custom multiselect field instance.
	 */
	public function customFieldMultiSelect( $scriptId, array $value) {
		$multivalues = array();
		$custfieldmultiselect = new MultiSelectCustomFieldRef();
		$custfieldmultiselect->scriptId = $scriptId;
		foreach ($value as $key => $item) {
			$recref = new ListOrRecordRef();
			$recref->name = $item;
			$multivalues[] = $recref;
		}
		$custfieldmultiselect->value = $multivalues;
		return $this->customFieldList($custfieldmultiselect);
	}


	/**
	 * Creating custom boolean field instance.
	 */
	public function customFieldboolean( $scriptId, $value) {
		$custfieldselect = new BooleanCustomFieldRef();
		$custfieldselect->scriptId = $scriptId;
		$custfieldselect->value = $value;
		return $this->customFieldList($custfieldselect);
	}


	/**
	 * Creating custom field list array.
	 */
	public function customSearchFieldList( $custfield) {
		$customFieldList = new SearchCustomFieldList();
		$customFieldList->customField = [$custfield];
		return $customFieldList;
	}


	/**
	 * Creating custom string field instance.
	 */
	public function customSearchField( $scriptId, $value) {
		$custfield = new SearchStringCustomField();
		$custfield->scriptId = $scriptId;
		$custfield->searchValue = $value;
		$custfield->operator = 'is';
		return $this->customSearchFieldList($custfield);
	}

	/**
	 * Creating conditional mapping for orders.
	 */
	public function salesOrderConditionalMapping( &$order_data, $order, $order_internal_id = 0) {
		$order_data['ns_salesorder_fields']=array();
		if (!empty($order->get_user_id())) {
			$this->user_id = $order->get_user_id();
		}
		$cm_options = get_option('order_cm_options');
		if (!empty($cm_options)) {
			foreach ($cm_options as $key => $mapping) {
				if (0 != $order_internal_id && isset($mapping['exlcude_in_update']) && 'on'  == $mapping['exlcude_in_update']) { //skip if admin wants to exlcude this update request
					continue;
				}
				$saved_value = '';
				switch ($mapping['operator']) {
					case 1:
						if ('' != $mapping['wc_field_key'] && '' != $mapping['wc_field_value'] && '' != $mapping ['ns_field_key'] && '' != $mapping['ns_field_value']) {
							if (1 == $mapping['type']) {
								// pr($mapping['wc_field_key']);//die('*');
								if ('user_id' == $mapping['wc_field_key']) {
									$saved_value = $this->user_id;
								} elseif ('email' == $mapping['wc_field_key']) {
									$saved_value = $order_data['customer_email'];
								} else {
									//woo default  ////
									$saved_value = get_user_meta($this->user_id, ( false === strstr($mapping['wc_field_key'], 'shipping_') ? 'billing_' : '' ) . $mapping ['wc_field_key'], true);
								}
							
							} else if (2 == $mapping['type']) {
								$saved_value = get_user_meta($this->user_id, $mapping['wc_field_key'], true);
							} else if (3 == $mapping['type']) {

								if (!empty($order)) {
									if ('memo' == $mapping['wc_field_key'] || 'customer_note' == $mapping['wc_field_key']) {
										$saved_value = $order->get_customer_note();
									}
								
									if ('id' == $mapping['wc_field_key']) {
										$saved_value = $order->get_id();
									}

									if ('shipping_method' == $mapping['wc_field_key']) {
										$saved_value = $order->get_shipping_method();
									}

									if ('billing_address_2' == $mapping['wc_field_key']) {
										$saved_value = $order->billing_address_2;
									}

									if ('shipping_address_2' == $mapping['wc_field_key']) {
										$saved_value = $order->shipping_address_2;
									}

									if (!empty(get_post_meta($order->get_id(), '_' . $mapping['wc_field_key'], true))) {
										$saved_value = get_post_meta($order->get_id(), '_' . $mapping['wc_field_key'], true);
									}
								}
							} else if (4 == $mapping ['type']) {
								if (!empty($order)) {
									$saved_value = get_post_meta($order->get_id(), $mapping ['wc_field_key'], true);
								}
							}
						

							if ('contains'  == $mapping['wc_where_op'] ) {
								if (false !== strpos(strtolower($saved_value), strtolower($mapping['wc_field_value']))) {
									$order_data['ns_salesorder_fields'][trim($mapping['ns_field_key'])] = array('type'=>trim($mapping['ns_field_type_value']),'value'=>$mapping['ns_field_value']);
								}
							} elseif ('doesnotcontain' == $mapping['wc_where_op']) {
								if (false === strpos(strtolower($saved_value), strtolower($mapping['wc_field_value']))) {
									$order_data['ns_salesorder_fields'][trim($mapping['ns_field_key'])] = array('type'=>trim($mapping['ns_field_type_value']),'value'=>$mapping['ns_field_value']);
								}
							} elseif ('is' == $mapping['wc_where_op']) {
								if (html_entity_decode(strtolower($mapping['wc_field_value']))  == html_entity_decode(strtolower($saved_value))) {
									$order_data['ns_salesorder_fields'][trim($mapping['ns_field_key'])] = array('type'=>trim($mapping['ns_field_type_value']),'value'=>$mapping['ns_field_value']);

								}
							} elseif ('isnot' == $mapping['wc_where_op']) {
								if ( strtolower($saved_value) != strtolower($mapping['wc_field_value'])) {
									$order_data['ns_salesorder_fields'][trim($mapping['ns_field_key'])] = array('type'=>trim($mapping['ns_field_type_value']),'value'=>$mapping['ns_field_value']);
								}
							}
						}
						break;
					case 2:
						if ('' != $mapping['ns_field_key'] && '' != $mapping['ns_field_value']) {
							$order_data['ns_salesorder_fields'][trim($mapping['ns_field_key'])] = array('type'=>trim($mapping['ns_field_type_value']),'value'=>$mapping['ns_field_value']);
						}
						break;
					case 3:
						if ('' != $mapping['wc_field_key'] && '' != $mapping['ns_field_key']) {
							$prefix = isset($mapping['wc_field_value_prefix']) ? $mapping['wc_field_value_prefix'] : '';
							if (1 == $mapping['type']) {
								if ('user_id' == $mapping['wc_field_key']) {
									$saved_value = $this->user_id;
								} elseif ('email' == $mapping['wc_field_key']) {
									$saved_value = $order_data['customer_email'];
								} else {
									//woo default
									$saved_value = get_user_meta($this->user_id, ( false === strstr($mapping['wc_field_key'], 'shipping_') ? 'billing_' : '' ) . $mapping ['wc_field_key'], true);
								}
							} else if (2 == $mapping['type']) {
								$saved_value = get_user_meta($this->user_id, $mapping['wc_field_key'], true);
							} else if (3 == $mapping['type']) {
								if (!empty($order)) {
									if ('memo' == $mapping['wc_field_key'] || 'customer_note' == $mapping['wc_field_key']) {
										$saved_value = $order->get_customer_note();
									}
								
									if ('id' == $mapping['wc_field_key']) {
										$saved_value = $order->get_id();
									}

									if ('shipping_method' == $mapping['wc_field_key']) {
										$saved_value = $order->get_shipping_method();
									}

									if ('billing_address_2' == $mapping['wc_field_key']) {
										$saved_value = $order->billing_address_2;
									}

									if ('shipping_address_2' == $mapping['wc_field_key']) {
										$saved_value = $order->shipping_address_2;
									}

									if (!empty(get_post_meta($order->get_id(), '_' . $mapping['wc_field_key'], true))) {
										$saved_value = get_post_meta($order->get_id(), '_' . $mapping['wc_field_key'], true);
									}
								}
							} else if (4 == $mapping ['type']) {
								if (!empty($order)) {
									$saved_value = get_post_meta($order->get_id(), $mapping ['wc_field_key'], true);
								}
							}
							if (isset($saved_value) && !empty($saved_value)) {
								$order_data['ns_salesorder_fields'][trim($mapping['ns_field_key'])] = array('type'=>trim($mapping['ns_field_type_value']),'value'=>$prefix . $saved_value);
							}
						}
						break;
					default:
						break;
				}
			}
		}
		return true;
		
	}

}
