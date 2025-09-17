<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class SalesOrderItem {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var boolean
	 */
	public $expandItemGroup;
	/**
	 * Var integer
	 */
	public $lineUniqueKey;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $price;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\SalesOrderItemCommitInventory
	 */
	public $commitInventory;
	/**
	 * Var float
	 */
	public $orderPriority;
	/**
	 * Var string
	 */
	public $licenseCode;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SalesOrderItemCreatePo
	 */
	public $createPo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdPo;
	/**
	 * Var float
	 */
	public $altSalesAmt;
	/**
	 * Var boolean
	 */
	public $createWo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $poVendor;
	/**
	 * Var string
	 */
	public $poCurrency;
	/**
	 * Var float
	 */
	public $poRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var string
	 */
	public $revRecStartDate;
	/**
	 * Var integer
	 */
	public $revRecTermInMonths;
	/**
	 * Var string
	 */
	public $revRecEndDate;
	/**
	 * Var boolean
	 */
	public $deferRevRec;
	/**
	 * Var boolean
	 */
	public $isClosed;
	/**
	 * Var \NetSuite\Classes\SalesOrderItemFulfillmentChoice
	 */
	public $itemFulfillmentChoice;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $catchUpPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var boolean
	 */
	public $fromJob;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var float
	 */
	public $taxAmount;
	/**
	 * Var boolean
	 */
	public $excludeFromRateRequest;
	/**
	 * Var boolean
	 */
	public $isEstimate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $inventoryLocation;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $inventorySubsidiary;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var float
	 */
	public $percentComplete;
	/**
	 * Var \NetSuite\Classes\ItemCostEstimateType
	 */
	public $costEstimateType;
	/**
	 * Var float
	 */
	public $costEstimate;
	/**
	 * Var float
	 */
	public $quantityBackOrdered;
	/**
	 * Var float
	 */
	public $quantityBilled;
	/**
	 * Var float
	 */
	public $quantityCommitted;
	/**
	 * Var float
	 */
	public $quantityFulfilled;
	/**
	 * Var float
	 */
	public $quantityPacked;
	/**
	 * Var float
	 */
	public $quantityPicked;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var float
	 */
	public $taxRate1;
	/**
	 * Var float
	 */
	public $taxRate2;
	/**
	 * Var string
	 */
	public $giftCertFrom;
	/**
	 * Var string
	 */
	public $giftCertRecipientName;
	/**
	 * Var string
	 */
	public $giftCertRecipientEmail;
	/**
	 * Var string
	 */
	public $giftCertMessage;
	/**
	 * Var string
	 */
	public $giftCertNumber;
	/**
	 * Var integer
	 */
	public $shipGroup;
	/**
	 * Var boolean
	 */
	public $itemIsFulfilled;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
	/**
	 * Var \NetSuite\Classes\VsoeSopGroup
	 */
	public $vsoeSopGroup;
	/**
	 * Var boolean
	 */
	public $vsoeIsEstimate;
	/**
	 * Var float
	 */
	public $vsoePrice;
	/**
	 * Var float
	 */
	public $vsoeAmount;
	/**
	 * Var float
	 */
	public $vsoeAllocation;
	/**
	 * Var \NetSuite\Classes\VsoeDeferral
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\VsoePermitDiscount
	 */
	public $vsoePermitDiscount;
	/**
	 * Var boolean
	 */
	public $vsoeDelivered;
	/**
	 * Var string
	 */
	public $expectedShipDate;
	/**
	 * Var boolean
	 */
	public $noAutoAssignLocation;
	/**
	 * Var boolean
	 */
	public $locationAutoAssigned;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $orderAllocationStrategy;
	/**
	 * Var string
	 */
	public $requestedDate;

	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'job' => 'RecordRef',
		'subscription' => 'RecordRef',
		'item' => 'RecordRef',
		'quantityAvailable' => 'float',
		'expandItemGroup' => 'boolean',
		'lineUniqueKey' => 'integer',
		'quantityOnHand' => 'float',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'description' => 'string',
		'price' => 'RecordRef',
		'rate' => 'string',
		'serialNumbers' => 'string',
		'amount' => 'float',
		'isTaxable' => 'boolean',
		'commitInventory' => 'SalesOrderItemCommitInventory',
		'orderPriority' => 'float',
		'licenseCode' => 'string',
		'options' => 'CustomFieldList',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'createPo' => 'SalesOrderItemCreatePo',
		'createdPo' => 'RecordRef',
		'altSalesAmt' => 'float',
		'createWo' => 'boolean',
		'poVendor' => 'RecordRef',
		'poCurrency' => 'string',
		'poRate' => 'float',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecTermInMonths' => 'integer',
		'revRecEndDate' => 'dateTime',
		'deferRevRec' => 'boolean',
		'isClosed' => 'boolean',
		'itemFulfillmentChoice' => 'SalesOrderItemFulfillmentChoice',
		'catchUpPeriod' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'fromJob' => 'boolean',
		'grossAmt' => 'float',
		'taxAmount' => 'float',
		'excludeFromRateRequest' => 'boolean',
		'isEstimate' => 'boolean',
		'inventoryLocation' => 'RecordRef',
		'inventorySubsidiary' => 'RecordRef',
		'line' => 'integer',
		'percentComplete' => 'float',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'quantityBackOrdered' => 'float',
		'quantityBilled' => 'float',
		'quantityCommitted' => 'float',
		'quantityFulfilled' => 'float',
		'quantityPacked' => 'float',
		'quantityPicked' => 'float',
		'tax1Amt' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'giftCertFrom' => 'string',
		'giftCertRecipientName' => 'string',
		'giftCertRecipientEmail' => 'string',
		'giftCertMessage' => 'string',
		'giftCertNumber' => 'string',
		'shipGroup' => 'integer',
		'itemIsFulfilled' => 'boolean',
		'shipAddress' => 'RecordRef',
		'shipMethod' => 'RecordRef',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'vsoeIsEstimate' => 'boolean',
		'vsoePrice' => 'float',
		'vsoeAmount' => 'float',
		'vsoeAllocation' => 'float',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'expectedShipDate' => 'dateTime',
		'noAutoAssignLocation' => 'boolean',
		'locationAutoAssigned' => 'boolean',
		'taxDetailsReference' => 'string',
		'chargeType' => 'RecordRef',
		'orderAllocationStrategy' => 'RecordRef',
		'requestedDate' => 'dateTime',
		'customFieldList' => 'CustomFieldList',
		'priceLevel' => 'RecordRef',
	);
}
