<?php

/**
 * This class handles all API operations related to creating inventory update CRON
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

use NetSuite\Classes\RecordType;
use NetSuite\NetSuiteService;
use Netsuite\Classes\SearchStringField;
use Netsuite\Classes\ItemSearchBasic;
use Netsuite\Classes\SearchRequest;
use Netsuite\Classes\AssemblyItem;
use Netsuite\Classes\SearchMultiSelectField;
use Netsuite\Classes\RecordRef;
use Netsuite\Classes\ItemAvailabilityFilter;
use Netsuite\Classes\RecordRefList;
use Netsuite\Classes\GetItemAvailabilityRequest;
use Netsuite\Classes\SearchCustomFieldList;
use NetSuite\Classes\SearchCustomField;
use NetSuite\Classes\SearchStringCustomField;




class ItemClient extends CommonIntegrationFunctions {

	public $netsuiteService = '';
	public $object_id;
    public $log_file_name;
    private $processed_skus_success = 0;
    private $processed_skus_error = 0;
    private $processed_line_no = 0;

    public $price_inventory_sync_logs_rows_limit = 100000;

	public function __construct() {

		if (empty($this->netsuiteService)) {
			//intialising netsuite service
			if (TMWNI_Settings::areCredentialsDefined()) {
				$this->netsuiteService = new NetSuiteService(null, array('exceptions' => true));
			}
		}
        if (defined('PRICE_INVENTORY_SYNC_LOGS_ROWS_LIMIT')) {
            $this->price_inventory_sync_logs_rows_limit = PRICE_INVENTORY_SYNC_LOGS_ROWS_LIMIT;
        }
	}

    public function set_log_file_name( $name )
    {
        $file_dir = wp_upload_dir();
        $log_file = $file_dir['basedir'] . '/' . $name . '-' . TMWNI_Settings::$ns_inventory_log_file;
        $this->log_file_name = $log_file;
    }

    public function get_log_file_name() {
        if ( isset( $this->log_file_name ) ) {
            $log_file = $this->log_file_name;
        } else {
            $file_dir = wp_upload_dir();
            $log_file = $file_dir['basedir'] . '/' . TMWNI_Settings::$ns_inventory_log_file;
        }

        return $log_file;
    }

    public function getProcessedSkusInfo() {
        return array(
            'success' => $this->processed_skus_success,
            'error' => $this->processed_skus_error,
            'total' => $this->processed_line_no,
        );
    }

	/**
	 * Get Product From NS
	 *
	*/ 
	public function getList() {

		//search preference
		$this->netsuiteService->setSearchPreferences(false, 1000, true);

		$SearchField = new SearchMultiSelectField();
		$SearchField->operator = 'anyOf';

		$SearchField->searchValue = array('internalId' => 2);

		//search on items
		$search = new ItemSearchBasic();
		$search->department = $SearchField;

		//set search request
		$request = new SearchRequest();
		$request->searchRecord = $search;
		//perofrm search request
		$searchResponse = $this->netsuiteService->search($request);
		$i = 1;
		if ($searchResponse->searchResult->status->isSuccess) {
			$file_name = __DIR__ . '/product_data_' . $i . '.json';
			touch($file_name);
			file_put_contents($file_name, json_encode($searchResponse->searchResult->recordList->record));

			for ($i = 2; $i <= $searchResponse->searchResult->totalPages; $i++) {
				$file_name = __DIR__ . '/product_data_' . $i . '.json';
				touch($file_name);

				$searchMoreRequest = new SearchMoreWithIdRequest();
				$searchMoreRequest->pageIndex = $i;
				$searchMoreRequest->searchId = $searchResponse->searchResult->searchId;
				$moreResults = $this->netsuiteService->searchMoreWithId($searchMoreRequest);

				if ($moreResults->searchResult->status->isSuccess) {
					file_put_contents($file_name, json_encode($moreResults->searchResult->recordList->record));
				}
			}
		}

		// pr($moreResults);die;
	}

	/**
	 * Search Product From NS By Sku and Update Internal Id
	 *
	*/ 
	public function searchItemUpdateInternalID( $item_sku, $product_id) {
		$response = $this->_searchItem($item_sku, $product_id);
		if ($response['status']) {
			$searchResponse = $response['search_response'];
			$item_internal_id = $searchResponse->searchResult->recordList->record[0]->internalId;
			update_post_meta($product_id, TMWNI_Settings::$ns_product_id, $item_internal_id);

			$item_location_id = $searchResponse->searchResult->recordList->record[0]->location->internalId;

			if (!empty($item_location_id)  || !is_null($item_location_id)) { 
				update_post_meta($product_id, 'ns_item_location_id', $item_location_id);
			}			
		}
	}




	public function searchItemBySkuUpdateInventory($item_sku, $product_id, $type = null) {
		$this->object_id = $product_id;
		$kit_item_sync_status = true;
		$item_sync_status  = true;

		if ( get_option( 'ns_inventory_sync_disabled', false ) ) {
            return;
        }

        $log_file = $this->get_log_file_name();
        Nsi_Helper::set_ns_sync_log_file( $log_file );

		if (empty($item_sku)) {
			$empty_skus = get_option('empty_skus');

			$empty_skus[] = $product_id;
			update_option('empty_skus', array_unique($empty_skus));
			$content = '<p><b>SKU Missing for Product ID ' . $product_id . '</b></p>';
			$content .= '<p><b>Skipped</b></p>';
			file_put_contents($log_file, $content . PHP_EOL, FILE_APPEND);
			return;

		}

		$content = '<p>Product SKU ' . $item_sku . '</p>';
        $update_type = $type ?? 'all';
		$content .= '<p><b>Action: Inventory Update [' . $update_type .'] (' . date( 'Y-m-d H:i:s' ) . ')</b></p>';
		file_put_contents($log_file, $content . PHP_EOL, FILE_APPEND);
		
		$response = $this->_searchItem($item_sku, $product_id);

		if ($response['status']) {
			$searchResponse = $response['search_response'];

			//NetSuite item internal id
			$item_internal_id = $searchResponse->searchResult->recordList->record[0]->internalId;
			update_post_meta($product_id, TMWNI_Settings::$ns_product_id, $item_internal_id);

            if( defined('NS_INVENTORY_SYNC_DEBUG_SKU' )
                && in_array($item_sku, NS_INVENTORY_SYNC_DEBUG_SKU, true)) {
                $this->log_inventory_debug($item_sku, $searchResponse->searchResult->recordList->record[0]);
            }

			$item_location_id = '';
			if (isset($searchResponse->searchResult->recordList->record[0]->location->internalId)) {
				$item_location_id = $searchResponse->searchResult->recordList->record[0]->location->internalId;
				if (!empty($item_location_id)  || !is_null($item_location_id)) {
					update_post_meta($product_id, 'ns_item_location_id', $item_location_id);
				}
			}

            if (
                property_exists( $searchResponse->searchResult->recordList->record[0], 'isInactive' )
                && $searchResponse->searchResult->recordList->record[0]->isInactive
            ) {
                $inactiveFlagLog = '<p><b>Inactive Flag status: true</b></p>';
            } else {
                $inactiveFlagLog = '<p><b>Inactive Flag status: false / doesn\'t exist</b></p>';
            }
            file_put_contents($log_file, $inactiveFlagLog . PHP_EOL, FILE_APPEND);

			$kit_item_sync_status = apply_filters('tm_ns_kit_item_status', $kit_item_sync_status, $searchResponse);
			$item_sync_status = apply_filters('tm_ns_item_status', $item_sync_status, $searchResponse);	
			$class = get_class($searchResponse->searchResult->recordList->record[0]);
			$pieces = explode('\\', $class);
			$item_type = end($pieces);

			if ('KitItem' == $item_type) {
				if (false != $kit_item_sync_status) {
					$this->_updatekitItemData($searchResponse, $product_id, $item_location_id, $type);
					do_action('tm_ns_after_update_kit_item_data', $searchResponse, $product_id);
				}					
			} else {
				if (false != $item_sync_status) {
					$this->_updateItemData($searchResponse, $product_id, $item_location_id, $type);
					do_action('tm_ns_after_update_item_data', $searchResponse, $product_id);		
				}
			}
		} else {
			
			$content = '<p><b>Item Number/SKU not found on NetSuite</b></p>';
			file_put_contents($log_file, $content . PHP_EOL, FILE_APPEND);
		}

	}

    public function searchItemsByInternalIdsUpdateInventory( $products, $type = null ) {
		$kit_item_sync_status = true;
		$item_sync_status  = true;

		if ( get_option( 'ns_inventory_sync_disabled', false ) ) {
            return;
        }

        $log_file = $this->get_log_file_name();
        Nsi_Helper::set_ns_sync_log_file( $log_file );

        $response = array();
        $response['status'] = 0;
        global $TMWNI_OPTIONS;
        $this->netsuiteService->setSearchPreferences( false );
        $search = new ItemSearchBasic();
        $search->internalId = new SearchMultiSelectField();
        $search->internalId->operator = 'anyOf';
        $updated_products = array();

        foreach( $products as $product ) {
            if ( empty($product['sku']) ) {
                if ( !isset( $empty_skus ) ) {
                    $empty_skus = get_option('empty_skus');
                }

                $this->processed_line_no++;
                $this->processed_skus_error++;
                $empty_skus[] = $product['wp_product_id'];
                $content = '<p><b>#' . $this->processed_line_no . ' - SKU Missing for Product ID ' . $product['wp_product_id'] . '. Skipped.</b></p>';
                file_put_contents($log_file, $content . PHP_EOL, FILE_APPEND);
                continue;
            }

            $field = new RecordRef();
            $field->internalId = $product['internal_id'];
            $field->type = RecordType::INVENTORYITEM;
            $search->internalId->searchValue[] = $field;
        }

        if ( isset( $empty_skus ) ) {
            update_option('empty_skus', array_unique($empty_skus));
        }

        if ( empty($search->internalId->searchValue) ) {
            return $updated_products;
        }
        $request = new SearchRequest();
        $request->searchRecord = $search;
        $searchResponse = $this->netsuiteService->search($request);

		if ( !$searchResponse->searchResult->status->isSuccess ) {
            $not_updated_products = [];
            $this->processed_line_no++;
            $log_fetch_error_lines = '#' . ($this->processed_line_no + 1);
            foreach( $products as $product ) {
                $object = 'multiple_internal_ids';
                $error_msg = "'" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object;
                if ( isset($searchResponse->searchResult->status->statusDetail[0]->message) && !empty($searchResponse->searchResult->status->statusDetail[0]->message) ) {
                    $error_msg .= 'Error Message : ' . $searchResponse->searchResult->status->statusDetail[0]->message;
                } elseif ( isset( $searchResponse->message ) && !empty( $searchResponse->message ) ) {
                    $error_msg .= 'Error Message : ' . print_r($searchResponse->message, true);
                } else {
                    $error_msg .= 'Error Message : ' . print_r($searchResponse->searchResult, true);
                }
                $this->handleLog(0, $product['wp_product_id'], $object, $error_msg);
                $not_updated_products []= $product['wp_product_id'];
                $this->processed_line_no++;
                $this->processed_skus_error++;
            }
            $log_fetch_error_lines .= ' - #' . ($this->processed_line_no + 1) . ' - ';

            if ( isset($searchResponse->searchResult->status->statusDetail[0]->message) && !empty($searchResponse->searchResult->status->statusDetail[0]->message) ) {
                $log_fetch_error = '<p><b>Error occurred while fetching products data from NS:</b> ' .  $searchResponse->searchResult->status->statusDetail[0]->message . '</p>' . PHP_EOL;
            } else {
                $log_fetch_error = '<p><b>Error occurred while fetching products data from NS:</b> ' .  print_r($searchResponse->searchResult, true) . '</p>' . PHP_EOL;
            }
            $log_fetch_error .= '<p><b>' . $log_fetch_error_lines . 'Following WordPress ID products were not updated:</b> ' . implode(', ', $not_updated_products) . '</p>' . PHP_EOL;
            file_put_contents($log_file, $log_fetch_error, FILE_APPEND);
        } else {
            if ( $searchResponse->searchResult->totalRecords > 0 ) {
                foreach ( $searchResponse->searchResult->recordList->record as $record ) {
                    $ns_internal_id = $record->internalId;
                    $record_sku = $products[$ns_internal_id]['sku'];

                    if (
                        defined('NS_INVENTORY_SYNC_DEBUG_SKU')
                        && in_array($record_sku, NS_INVENTORY_SYNC_DEBUG_SKU, true)
                    ) {
                        $this->log_inventory_debug($record_sku, $record);
                    }

                    $this->processed_line_no++;
                    $wp_product_id = $products[$ns_internal_id]['wp_product_id'];
                    $product_meta = get_post_meta( $wp_product_id );
                    $log_content = '<p>#' . $this->processed_line_no . ' -  Product SKU ' . $record_sku . '</p>';
                    $update_type = $type ?? 'all';
                    $log_content .= '<p><b>Action: Inventory Update [' . $update_type .'] (' . date( 'Y-m-d H:i:s' ) . ')</b></p>' . PHP_EOL;
                    file_put_contents($log_file, $log_content, FILE_APPEND);

                    $is_ns_item_discontinued = self::is_ns_item_field_checked( $record, 'custitem_nsi_discontinued' );
                    if ( $is_ns_item_discontinued ) {
                        $log_content = '<p>NS internal product ID <b>' . $ns_internal_id . '</b> discontinued. Starting SKU-based update for SKU: ' . $products[$ns_internal_id]['sku'] . '</p>' . PHP_EOL;
                        file_put_contents( $log_file, $log_content, FILE_APPEND );
                        $this->searchItemBySkuUpdateInventory( $products[$ns_internal_id]['sku'], $wp_product_id );
                        continue;
                    }

                    $item_location_id = '';
                    if ( isset($record->location->internalId) ) {
                        $item_location_id = $record->location->internalId;
                        if ( !empty($item_location_id)  || !is_null($item_location_id) ) {
                            Crown_Shop_Products::maybe_update_postmeta( $wp_product_id, $product_meta, 'ns_item_location_id', $item_location_id );
                        }
                    }

                    if ( property_exists( $record, 'isInactive' ) && $record->isInactive) {
                        $inactiveFlagLog = '<p><b>Inactive Flag status: true</b></p>';
                    } else {
                        $inactiveFlagLog = '<p><b>Inactive Flag status: false / doesn\'t exist</b></p>';
                    }
                    file_put_contents($log_file, $inactiveFlagLog . PHP_EOL, FILE_APPEND);

                    $kit_item_sync_status = apply_filters('tm_ns_kit_item_status', $kit_item_sync_status, $record);
                    $item_sync_status = apply_filters('tm_ns_item_status', $item_sync_status, $record);
                    $class = get_class($record);
                    $pieces = explode('\\', $class);
                    $item_type = end($pieces);
                    if ('KitItem' == $item_type) {
                        if ($kit_item_sync_status) {
                            $this->_updatekitItemDataBulk($record, $wp_product_id, $item_location_id, $type, $product_meta);
                            do_action('tm_ns_after_update_kit_item_data_bulk', $record, $wp_product_id);
                        }
                    } else {
                        if ($item_sync_status) {
                            $this->_updateItemDataBulk($record, $wp_product_id, $item_location_id, $type, $product_meta);
                            do_action('tm_ns_after_update_item_data_bulk', $record, $wp_product_id);
                        }
                    }

                    $updated_products[] = [
                        'sku' => $record_sku,
                        'product_id' => $products[$ns_internal_id]['wp_product_id'],
                    ];
                    $this->processed_skus_success++;
                }
            }
		}

        $log_contents = file($log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (count($log_contents) > $this->price_inventory_sync_logs_rows_limit) {
            $log_contents = array_slice($log_contents, -$this->price_inventory_sync_logs_rows_limit);
            file_put_contents($log_file, implode(PHP_EOL, $log_contents) . PHP_EOL);
        }
        return $updated_products;
	}

    public static function is_ns_item_field_checked( $record, $search_field ) {
        if ( property_exists( $record, 'customFieldList' ) && is_object( $record->customFieldList ) && property_exists( $record->customFieldList, 'customField' ) && is_array( $record->customFieldList->customField ) ) {
            foreach ( $record->customFieldList->customField as $field ) {
                if ( ! is_object( $field ) ) continue;
                $field_name = property_exists( $field, 'scriptId' ) ? $field->scriptId : '';
                $value = property_exists( $field, 'value' ) ? $field->value : null;
                if ( $field_name == $search_field && $value === true ) {
                    return true;
                }
            }
        }

        return false;
    }


	/**
	 * Earch Product From NS By Sku and Update Inventory
	 *
	*/ 
	private function _searchItem( $item_sku, $product_id) {
		//pr($item_sku); die('zzzz');
		//$item_sku = 'test store';

		$response = array();
		$response['status'] = 0;
		global $TMWNI_OPTIONS;


		//search preference
		$this->netsuiteService->setSearchPreferences(false, 20);
		//set search field
		$SearchField = new SearchStringField();
		$SearchField->operator = 'is';
		$SearchField->searchValue = $item_sku;


		//search on items
		$search = new ItemSearchBasic();

		if (!isset($TMWNI_OPTIONS['sku_mapping_field']) || empty($TMWNI_OPTIONS['sku_mapping_field']) ) {
			$search->itemId = $SearchField;
		} elseif ('customFieldList' == $TMWNI_OPTIONS['sku_mapping_field']) {
			$search->{$TMWNI_OPTIONS['sku_mapping_field']} = $this->customSearchStringField($TMWNI_OPTIONS['sku_mapping_custom_field'], $item_sku);
		} else {
			$search->{$TMWNI_OPTIONS['sku_mapping_field']} = $SearchField;
		}

		//set search request
		$search = apply_filters('tm_ns_search_item', $search, $item_sku, $product_id);
		$request = new SearchRequest();
		$request->searchRecord = $search;
		$quantity = false;

		// die('*!*');

		try {
			//perofrm search request
			$searchResponse = $this->netsuiteService->search($request);

			apply_filters('tm_ns_search_item_response', $searchResponse, $product_id);
			if (!$searchResponse->searchResult->status->isSuccess) {

				$object = 'inventory_item';
				$error_msg = "'" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $product_id . '. ';

				$error_msg .= 'Search Keyword:' . $item_sku . '. ';

				$error_msg .= 'Error Message : ' . $response->writeResponse->status->statusDetail[0]->message;
				$this->handleLog(0, $product_id, $object, $error_msg);
			} else {

				if ( $searchResponse->searchResult->totalRecords > 1 ) {
					foreach ( $searchResponse->searchResult->recordList->record as $record ) {
						if ( ! property_exists( $record, 'isInactive' ) || ! boolval( $record->isInactive ) ) {
							$searchResponse->searchResult->recordList->record = array( $record );
							$searchResponse->searchResult->totalRecords = 1;
							break;
						}
					}
				}

				//Check if search record found
				if (1 == $searchResponse->searchResult->totalRecords) {

					do_action('tm_ns_search_item_after', $product_id, $searchResponse);

					$response['status'] = 1;
					$response['search_response'] = $searchResponse;
				}
			}
		} catch (SoapFault $e) {

			$object = 'inventory_item';
			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Search Keyword: ' . $item_sku . '. ';
			$error_msg .= 'Error Message: ' . $e->getMessage();

			$this->handleLog(0, $product_id, $object, $error_msg);

		}
		return $response;
	}



	/**
	 * Earch Product From NS By Internal Id
	 *
	*/ 
	private function _searchItemByInternalId( $internalId, $product_id) {
		// $item_sku = 'MISCBOTTLESFLINT';

		$response = array();
		$response['status'] = 0;
		global $TMWNI_OPTIONS;

		//search preference
		$this->netsuiteService->setSearchPreferences(false, 20);
		//set search field
		$SearchField = new SearchMultiSelectField();
		$SearchField->operator = 'anyOf';
		$SearchField->searchValue = array('internalId' => $internalId);


		//search on items
		$search = new ItemSearchBasic();
		$search->internalId = $SearchField;

		//set search request
		$request = new SearchRequest();
		$request->searchRecord = $search;

		try {
			//perofrm search request

			$searchResponse = $this->netsuiteService->search($request);
			apply_filters('tm_ns_search_item_response', $searchResponse, $product_id);

			if (!$searchResponse->searchResult->status->isSuccess) {

				$object = 'inventory_item';
				$error_msg = "'" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $product_id . '. ';

				$error_msg .= 'Search Keyword:' . $item_sku . '. ';

				$error_msg .= 'Error Message : ' . $response->writeResponse->status->statusDetail[0]->message;
				$this->handleLog(0, $product_id, $object, $error_msg);
			} else {

				//Check if search record found
				if (1 == $searchResponse->searchResult->totalRecords) {
					$response['status'] = 1;
					$response['search_response'] = $searchResponse;
				}
			}
		} catch (SoapFault $e) {

			$object = 'inventory_item';
			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Search Keyword: ' . $item_sku . '. ';
			$error_msg .= 'Error Message: ' . $e->getMessage();

			$this->handleLog(0, $product_id, $object, $error_msg);

		}
		return $response;
	}

	/**
	 * Select item quantity based on default location
	 *
	 * Param type $item_location_id int
	 * Param type $item_locations object of all item locations
	 */
	public function getNetSuiteProductPrices( $searchResponse) {
		global $TMWNI_OPTIONS; 
		if (isset($searchResponse->searchResult->recordList->record[0]->pricingMatrix)) {
			$product = $searchResponse->searchResult->recordList->record[0]->pricingMatrix;
			foreach ($product->pricing as $pricing) {
				$name = $pricing->priceLevel->name;
				if (isset($TMWNI_OPTIONS['price_level_name']) && !empty($TMWNI_OPTIONS['price_level_name'])) {
					$price_level_name = $TMWNI_OPTIONS['price_level_name']; 
				} else {
					$price_level_name = TMWNI_Settings::$pricing_group;
				}
				if ($price_level_name == $name && $pricing->currency->name == 'US Dollar') {
					return $pricing->priceList->price;
				}
			}
		}

		return array();
	}

    public function getNetSuiteProductPricesBulk( $record ) {
		global $TMWNI_OPTIONS;
		if ( isset($record->pricingMatrix) ) {
			$product = $record->pricingMatrix;
			foreach ( $product->pricing as $pricing ) {
				$name = $pricing->priceLevel->name;
				if ( isset($TMWNI_OPTIONS['price_level_name']) && !empty($TMWNI_OPTIONS['price_level_name']) ) {
					$price_level_name = $TMWNI_OPTIONS['price_level_name'];
				} else {
					$price_level_name = TMWNI_Settings::$pricing_group;
				}
				if ( $price_level_name == $name && $pricing->currency->name == 'US Dollar' ) {
					return $pricing->priceList->price;
				}
			}
		}

		return array();
	}

	

	//update kit item data
	public function _updatekitItemData( $searchResponse, $product_id, $item_location_id, $type = null) {
		global $TMWNI_OPTIONS;
        if ( isset($TMWNI_OPTIONS['enablePriceSync']) && 'on' == $TMWNI_OPTIONS['enablePriceSync']
            && ( $type == 'price' || $type == 'all' || !isset( $type ) )
        ) {
			$prices = $this->getNetSuiteProductPrices($searchResponse);
			$this->_updateWooPrice($prices, $product_id);				
		}

        if ( isset($TMWNI_OPTIONS['enableInventorySync']) && 'on' == $TMWNI_OPTIONS['enableInventorySync']
            && ( $type == 'inventory' || $type == 'all' || !isset( $type ) )
        ) {
			$item_members = $searchResponse->searchResult->recordList->record[0]->memberList->itemMember;
			$last_quantity = 0;

			foreach ($item_members as $key => $item_member) {
				$child_item_internal_id = $item_member->item->internalId;
				$response = $this->_searchItemByInternalId($child_item_internal_id, $product_id);
				if (1 == $response['status']) {
					$searchResponse = $response['search_response'];
					$quantity = $this->getItemQuantity($searchResponse, $item_location_id, $product_id, $child_item_internal_id);

					$quantity = apply_filters('tm_ns_kit_item_quantity', $quantity, $searchResponse, $item_location_id, $product_id, $child_item_internal_id);

					$last_quantity += $quantity['quantity'];
				}

			}

            $this->updateWooQuantity($product_id, array( 'quantity' => $last_quantity, 'locations' => $quantity['locations'] ) ?? array() );
				

		}

	}

    public function _updatekitItemDataBulk( $record, $product_id, $item_location_id, $type = null, $product_meta) {
		global $TMWNI_OPTIONS;
        if ( isset($TMWNI_OPTIONS['enablePriceSync']) && 'on' == $TMWNI_OPTIONS['enablePriceSync']
            && ( $type == 'price' || $type == 'all' || !isset( $type ) )
        ) {
			$prices = $this->getNetSuiteProductPricesBulk($record);
			$this->_updateWooPrice($prices, $product_id, $product_meta);
		}

        if ( isset($TMWNI_OPTIONS['enableInventorySync']) && 'on' == $TMWNI_OPTIONS['enableInventorySync']
            && ( $type == 'inventory' || $type == 'all' || !isset( $type ) )
        ) {
			$item_members = $record->memberList->itemMember;
			$last_quantity = 0;

			foreach ( $item_members as $key => $item_member ) {
				$child_item_internal_id = $item_member->item->internalId;
				$response = $this->_searchItemByInternalId($child_item_internal_id, $product_id);
				if ( 1 == $response['status'] ) {
					$searchResponse = $response['search_response'];
					$quantity = $this->getItemQuantity($searchResponse, $item_location_id, $product_id, $child_item_internal_id);

					$quantity = apply_filters('tm_ns_kit_item_quantity', $quantity, $searchResponse, $item_location_id, $product_id, $child_item_internal_id);

					$last_quantity += $quantity['quantity'];
				}
			}

            $this->updateWooQuantity($product_id, array( 'quantity' => $last_quantity, 'locations' => $quantity['locations'] ?? array() ), $product_meta);
		}
	}

	//update  item data
	public function _updateItemData( $searchResponse, $product_id, $item_location_id, $type = null) {
		global $TMWNI_OPTIONS;
		if ( isset($TMWNI_OPTIONS['enablePriceSync']) && 'on' == $TMWNI_OPTIONS['enablePriceSync']
            && ( $type == 'price' || $type == 'all' || !isset( $type ) )
        ) {
			$prices = $this->getNetSuiteProductPrices($searchResponse);	
			$this->_updateWooPrice($prices, $product_id);
		}	

		if ( isset($TMWNI_OPTIONS['enableInventorySync']) && 'on' == $TMWNI_OPTIONS['enableInventorySync']
            && ( $type == 'inventory' || $type == 'all' || !isset( $type ) )
        ) {
            //min_quantity and product_step were previously in Price sync if condition, shouldnt it be related to quantity/stock? - it was already in quantity/stock section in _updatekitItemData func
            $min_qty = property_exists( $searchResponse->searchResult->recordList->record[0], 'minimumQuantity' ) ? intval( $searchResponse->searchResult->recordList->record[0]->minimumQuantity ) : 1;
            if ( empty( $min_qty ) ) {
                $min_qty = 1;
            }
            update_post_meta( $product_id, 'min_quantity', $min_qty );
            update_post_meta( $product_id, 'product_step', $min_qty );

			$item_internal_id = $searchResponse->searchResult->recordList->record[0]->internalId;
			$quantity = $this->getItemQuantity($searchResponse, $item_location_id, $product_id, $item_internal_id);
			$quantity = apply_filters('tm_ns_item_quantity', $quantity, $searchResponse, $item_location_id, $product_id, $item_internal_id);
            $this->updateWooQuantity($product_id, $quantity);
		}
	}

    public function _updateItemDataBulk( $record, $product_id, $item_location_id, $type = null, $product_meta = [] ) {
		global $TMWNI_OPTIONS;
		if ( isset($TMWNI_OPTIONS['enablePriceSync']) && 'on' == $TMWNI_OPTIONS['enablePriceSync']
            && ( $type == 'price' || $type == 'all' || !isset( $type ) )
        ) {
			$prices = $this->getNetSuiteProductPricesBulk($record);
			$this->_updateWooPrice($prices, $product_id, $product_meta);
		}

		if ( isset($TMWNI_OPTIONS['enableInventorySync']) && 'on' == $TMWNI_OPTIONS['enableInventorySync']
            && ( $type == 'inventory' || $type == 'all' || !isset( $type ) )
        ) {
            //min_quantity and product_step were previously in Price sync if condition, shouldnt it be related to quantity/stock? - it was already in quantity/stock section in _updatekitItemData func
            $min_qty = property_exists( $record, 'minimumQuantity' ) ? intval( $record->minimumQuantity ) : 1;
            if ( empty($min_qty) ) {
                $min_qty = 1;
            }
            Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, 'min_quantity', $min_qty );
            Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, 'product_step', $min_qty );

			$item_internal_id = $record->internalId;
			$quantity = $this->getItemQuantityBulk($record, $item_location_id, $product_id, $item_internal_id);
			$quantity = apply_filters('tm_ns_item_quantity', $quantity, $record, $item_location_id, $product_id, $item_internal_id);
            $this->updateWooQuantity($product_id, $quantity, $product_meta);
		}
	}

	//update woo price
	public function _updateWooPrice( $prices, $product_id, $product_meta = [] ) {
		
		if (!empty($prices) && isset($prices[0]->value)) {
			$main_price = $prices[0]->value;
            Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_regular_price', $main_price );
            Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_price', $main_price );

			$content = '<p><b>Action: Price updated (' . $main_price . ')</b></p>';
			if (( isset($TMWNI_OPTIONS['enableInventorySync']) && 'on' == $TMWNI_OPTIONS['enableInventorySync'] )) {
				$new_count = 0;
			} else {
				$old_count = get_option('updated_products_count');
				$new_count = $old_count + 1;
			}
			$this->updateLogFileContent($content, $new_count);
		}

	}


	private function getItemQuantity( $searchResponse, $item_location_id, $product_id, $item_internal_id) {
		global $TMWNI_OPTIONS;	
		if (!empty($searchResponse->searchResult->recordList->record[0]->locationsList)) {
			$item_locations = $searchResponse->searchResult->recordList->record[0]->locationsList->locations;
		}	
		if (isset($item_locations) && !empty($item_locations)) {
			$quantity = $this->_getItemQuantityfromLocations($item_locations, $item_location_id);

		} else {
			$item_availabitliy = $this->tm_item_availabitlity_search_on_netsuite($product_id, $item_internal_id);
			$quantity = $this->_getItemQuantityfromLocations($item_availabitliy, $item_location_id);
		}

		return $quantity; 
		
	}

    private function getItemQuantityBulk( $record, $item_location_id, $product_id, $item_internal_id) {
		global $TMWNI_OPTIONS;
		if ( !empty($record->locationsList) ) {
			$item_locations = $record->locationsList->locations;
		}
		if ( isset($item_locations) && !empty($item_locations) ) {
			$quantity = $this->_getItemQuantityfromLocations($item_locations, $item_location_id);

		} else {
			$item_availabitliy = $this->tm_item_availabitlity_search_on_netsuite($product_id, $item_internal_id);
			$quantity = $this->_getItemQuantityfromLocations($item_availabitliy, $item_location_id);
		}

		return $quantity;

	}


	private function _getItemQuantityfromLocations( $item_locations, $item_location_id) {
		global $TMWNI_OPTIONS;

		if (isset($TMWNI_OPTIONS['inventorySyncField']) && !empty($TMWNI_OPTIONS['inventorySyncField'])) {
			$quantityField = $TMWNI_OPTIONS['inventorySyncField'];
		} else {
			$quantityField = 'quantityAvailable';
		}

        $locations = [];
        $quantity = 0;
		if (isset($TMWNI_OPTIONS['inventoryDefaultLocation']) && ( 'on' == $TMWNI_OPTIONS['inventoryDefaultLocation'] || 2 == $TMWNI_OPTIONS['inventoryDefaultLocation'] )) {
			if (isset($item_location_id) && !empty($item_location_id)) {
				foreach ($item_locations as $item_location) {
					if ($item_location_id == $item_location->locationId->internalId && !is_null($item_location->$quantityField)) {
						$quantity = (int) $item_location->$quantityField;
                        $locations[$item_location->locationId->internalId] = [
                            'location_id' => $item_location->locationId->internalId ?? '',
                            'location_name' => $item_location->location ?? '',
                            'location_quantity' => (int) $item_location->$quantityField,
                            'location_reorder' => (int) $item_location->reorderPoint ?? '',
                        ];
					}
				}
			} else {
				foreach ($item_locations as $item_location) {
					if (!is_null($item_location->$quantityField)) {
						$quantity += (int) $item_location->$quantityField;
                        $locations[$item_location->locationId->internalId] = [
                            'location_id' => $item_location->locationId->internalId ?? '',
                            'location_name' => $item_location->location ?? '',
                            'location_quantity' => (int) $item_location->$quantityField,
                            'location_reorder' => (int) $item_location->reorderPoint ?? '',
                        ];
					}
				}

			}
		} elseif (!isset($TMWNI_OPTIONS['inventoryDefaultLocation']) || 1 == $TMWNI_OPTIONS['inventoryDefaultLocation'] ) {
			foreach ($item_locations as $item_location) {
				if (!is_null($item_location->$quantityField)) {
					$quantity += (int) $item_location->$quantityField;
                    $locations[$item_location->locationId->internalId] = [
                        'location_id' => $item_location->locationId->internalId ?? '',
                        'location_name' => $item_location->location ?? '',
                        'location_quantity' => (int) $item_location->$quantityField,
                        'location_reorder' => (int) $item_location->reorderPoint ?? '',
                    ];
				}
			}
		} elseif (isset($TMWNI_OPTIONS['inventoryDefaultLocation']) || 3 == $TMWNI_OPTIONS['inventoryDefaultLocation'] ) {
			foreach ($item_locations as $item_location) {
				if (!is_null($item_location->$quantityField)) {
					if (in_array($item_location->locationId->internalId, $TMWNI_OPTIONS['netstuite_locations'] )) {
						$quantity += (int) $item_location->$quantityField;
                        $locations[$item_location->locationId->internalId] = [
                            'location_id' => $item_location->locationId->internalId ?? '',
                            'location_name' => $item_location->location ?? '',
                            'location_quantity' => (int) $item_location->$quantityField,
                            'location_reorder' => (int) $item_location->reorderPoint ?? '',
                        ];
					}
				}
			}
		}

		return array(
            'quantity' => $quantity,
            'locations' => $locations
        );
	}


	private function updateWooQuantity( $product_id, $quantity, $product_meta = [] ) {
		global $TMWNI_OPTIONS;
        Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_stock', $quantity['quantity'] );
        Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, 'locations_stock', $quantity['locations'] );

		if ( isset($TMWNI_OPTIONS['overrideManageStock']) && 'on' == $TMWNI_OPTIONS['overrideManageStock'] ) {
            Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_manage_stock', 'yes' );
		}
			
		if ('no' != $TMWNI_OPTIONS['updateStockStatus']) {
			$this->updateStock($product_id, $quantity['quantity'], $product_meta);
		}	

        $old_count = get_option('updated_products_count');
        $new_count = $old_count + 1;
        $locations_info = '';
        if ( isset($quantity['locations']) && !empty($quantity['locations']) ) {
            $locations_info = ', locations: ';
            foreach($quantity['locations'] as $location) {
                $locations_info .= $location['location_name'] . ': ' . $location['location_quantity'] . ', ';
            }
            $locations_info = rtrim($locations_info, ', ');
        }
        $content = '<p><b>Action: Inventory updated (quantity: ' . $quantity['quantity'] . $locations_info . ')</b></p>';
        $this->updateLogFileContent($content, $new_count);
	}


	private function updateStock( $product_id, $quantity, $product_meta = [] ) {
        if ($quantity > 0) {
            Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_stock_status', 'instock' );
        } else {
            if ( in_array( get_post_meta($product_id, '_backorders', true), array( 'yes', 'notify' ) ) ) {
                Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_stock_status', 'onbackorder' );
            } else {
                Crown_Shop_Products::maybe_update_postmeta( $product_id, $product_meta, '_stock_status', 'outofstock' );
            }
        }
	}

	public function tm_item_availabitlity_search_on_netsuite( $product_id, $item_internal_id) {
		global $TMWNI_OPTIONS;
		//search preference
		$this->netsuiteService->setSearchPreferences(false, 20);



		$ItemRecordRef = new RecordRef();
		$ItemRecordRef->internalId = $item_internal_id;
		//$ItemRecordRef->type = 'lotNumberedAssemblyItem';

		$filter = new ItemAvailabilityFilter();
		$filter->item = new RecordRefList();
		$filter->item->recordRef =  array($ItemRecordRef);



		$search = new GetItemAvailabilityRequest();
		$search->itemAvailabilityFilter = $filter;

		try {
			//perofrm search request
			$getResponse = $this->netsuiteService->getItemAvailability($search);
			apply_filters('tm_ns_item_availability_response', $getResponse, $product_id, $item_internal_id);
			if (1 == $getResponse->getItemAvailabilityResult->status->isSuccess) {
				if (isset($getResponse->getItemAvailabilityResult->itemAvailabilityList->itemAvailability)) {
					$item_locations_inventory = $getResponse->getItemAvailabilityResult->itemAvailabilityList->itemAvailability;
					return $item_locations_inventory; 
				}
			}

		} catch (SoapFault $e) {
			$object = 'item_locations';
			$error_msg = "SOAP API Error occured on '" . ucfirst($object) . " Search' operation failed for WooCommerce " . $object . ', ID = ' . $this->object_id . '. ';
			$error_msg .= 'Search Keyword: ' . $internal_id . '. ';
			$error_msg .= 'Error Message: ' . $e->getMessage();

			$this->handleLog(0, $this->object_id, $object, $error_msg);

			return 0;

		}
		
	}


	public function updateLogFileContent( $content, $new_count) {
        $log_file = $this->get_log_file_name();
		file_put_contents($log_file, $content . PHP_EOL, FILE_APPEND);
		if (0 != $new_count) {
			update_option('updated_products_count', $new_count);
		}
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
		$custfield = new SearchCustomField();
		$custfield->internalId = $scriptId;
		$custfield->value = $value;
		return $this->customSearchFieldList($custfield);
	}

	/**
	 * Creating custom string field instance.
	 */
	public function customSearchStringField( $scriptId, $value) {		
		$custfield = new SearchStringCustomField();
		$custfield->scriptId = $scriptId;
		$custfield->searchValue = $value;
		$custfield->operator = 'is';
		return $this->customSearchFieldList($custfield);
	}

    public function log_inventory_debug(string $record_sku, mixed $record): void {
        $log_debug_file = Nsi_Helper::prepare_log_file('inventory-debug', 'extra-logs');
        $log_debug_content = "=== DEBUG SKU: $record_sku ===\n" . print_r($record, true) . "\n";
        file_put_contents($log_debug_file, $log_debug_content, FILE_APPEND);
    }


}
