<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 * Package    ryanwinchester/netsuite-php
 * Copyright  Copyright (c) Ryan Winchester
 * License    http://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 * Link       https://github.com/netsuitephp/netsuite-php
 *
 * Original content:
 * Copyright  Copyright (c) NetSuite Inc.
 * License    https://raw.githubusercontent.com/netsuitephp/netsuite-php/master/original/NetSuite%20Application%20Developer%20License%20Agreement.txt
 * Link       http://www.netsuite.com/portal/developers/resources/suitetalk-sample-applications.shtml
 */

namespace NetSuite\Classes;

class InboundShipmentSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $actualDeliveryDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $actualShippingDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billOfLading;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expectedDeliveryDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $expectedRate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expectedShippingDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalDocumentNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $incoterm;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $itemEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $itemExchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $landedCostAllocationMethod;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $landedCostAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $landedCostCostCategory;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $landedCostCurrency;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $landedCostEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $landedCostExchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $poAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $poRate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $purchaseOrder;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityBilled;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityExpected;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityReceived;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityRemaining;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $receivingLocation;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shipmentBaseCurrency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shipmentNumber;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $totalUnitCost;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $unit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unitLandedCost;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $vendor;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $vesselNumber;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualDeliveryDate' => 'SearchDateField',
		'actualShippingDate' => 'SearchDateField',
		'billOfLading' => 'SearchStringField',
		'createdDate' => 'SearchDateField',
		'currency' => 'SearchMultiSelectField',
		'description' => 'SearchStringField',
		'expectedDeliveryDate' => 'SearchDateField',
		'expectedRate' => 'SearchDoubleField',
		'expectedShippingDate' => 'SearchDateField',
		'externalDocumentNumber' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'incoterm' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'item' => 'SearchMultiSelectField',
		'itemEffectiveDate' => 'SearchDateField',
		'itemExchangeRate' => 'SearchDoubleField',
		'landedCostAllocationMethod' => 'SearchEnumMultiSelectField',
		'landedCostAmount' => 'SearchDoubleField',
		'landedCostCostCategory' => 'SearchMultiSelectField',
		'landedCostCurrency' => 'SearchMultiSelectField',
		'landedCostEffectiveDate' => 'SearchDateField',
		'landedCostExchangeRate' => 'SearchDoubleField',
		'memo' => 'SearchStringField',
		'poAmount' => 'SearchDoubleField',
		'poRate' => 'SearchDoubleField',
		'purchaseOrder' => 'SearchMultiSelectField',
		'quantityBilled' => 'SearchDoubleField',
		'quantityExpected' => 'SearchDoubleField',
		'quantityReceived' => 'SearchDoubleField',
		'quantityRemaining' => 'SearchDoubleField',
		'receivingLocation' => 'SearchMultiSelectField',
		'shipmentBaseCurrency' => 'SearchMultiSelectField',
		'shipmentNumber' => 'SearchMultiSelectField',
		'status' => 'SearchEnumMultiSelectField',
		'totalUnitCost' => 'SearchDoubleField',
		'unit' => 'SearchMultiSelectField',
		'unitLandedCost' => 'SearchDoubleField',
		'vendor' => 'SearchMultiSelectField',
		'vesselNumber' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
