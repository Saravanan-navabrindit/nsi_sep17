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

class InboundShipmentSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $actualDeliveryDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $actualShippingDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billOfLading;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expectedDeliveryDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $expectedRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expectedShippingDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $externalDocumentNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $incoterm;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $itemEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $itemExchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $landedCostAllocationMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $landedCostAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $landedCostCostCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $landedCostCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $landedCostEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $landedCostExchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $poAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $poRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $purchaseOrder;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityBilled;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityExpected;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityReceived;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityRemaining;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $receivingLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $shipmentBaseCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipmentNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $totalUnitCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $unit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitLandedCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $vendor;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $vesselNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualDeliveryDate' => 'SearchColumnDateField[]',
		'actualShippingDate' => 'SearchColumnDateField[]',
		'billOfLading' => 'SearchColumnStringField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'currency' => 'SearchColumnSelectField[]',
		'description' => 'SearchColumnStringField[]',
		'expectedDeliveryDate' => 'SearchColumnDateField[]',
		'expectedRate' => 'SearchColumnDoubleField[]',
		'expectedShippingDate' => 'SearchColumnDateField[]',
		'externalDocumentNumber' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'incoterm' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'itemEffectiveDate' => 'SearchColumnDateField[]',
		'itemExchangeRate' => 'SearchColumnDoubleField[]',
		'landedCostAllocationMethod' => 'SearchColumnEnumSelectField[]',
		'landedCostAmount' => 'SearchColumnDoubleField[]',
		'landedCostCostCategory' => 'SearchColumnSelectField[]',
		'landedCostCurrency' => 'SearchColumnSelectField[]',
		'landedCostEffectiveDate' => 'SearchColumnDateField[]',
		'landedCostExchangeRate' => 'SearchColumnDoubleField[]',
		'memo' => 'SearchColumnStringField[]',
		'poAmount' => 'SearchColumnDoubleField[]',
		'poRate' => 'SearchColumnDoubleField[]',
		'purchaseOrder' => 'SearchColumnSelectField[]',
		'quantityBilled' => 'SearchColumnDoubleField[]',
		'quantityExpected' => 'SearchColumnDoubleField[]',
		'quantityReceived' => 'SearchColumnDoubleField[]',
		'quantityRemaining' => 'SearchColumnDoubleField[]',
		'receivingLocation' => 'SearchColumnSelectField[]',
		'shipmentBaseCurrency' => 'SearchColumnSelectField[]',
		'shipmentNumber' => 'SearchColumnStringField[]',
		'status' => 'SearchColumnStringField[]',
		'totalUnitCost' => 'SearchColumnDoubleField[]',
		'unit' => 'SearchColumnSelectField[]',
		'unitLandedCost' => 'SearchColumnDoubleField[]',
		'vendor' => 'SearchColumnSelectField[]',
		'vesselNumber' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
