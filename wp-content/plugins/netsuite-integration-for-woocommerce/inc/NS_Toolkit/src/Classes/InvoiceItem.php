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

class InvoiceItem {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subscriptionLine;
	/**
	 * Var boolean
	 */
	public $deferRevRec;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var float
	 */
	public $currentPercent;
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
	public $serialNumbers;
	/**
	 * Var string
	 */
	public $binNumbers;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $price;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $percentComplete;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var float
	 */
	public $quantityOrdered;
	/**
	 * Var float
	 */
	public $quantityRemaining;
	/**
	 * Var float
	 */
	public $quantityFulfilled;
	/**
	 * Var float
	 */
	public $amountOrdered;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var integer
	 */
	public $orderLine;
	/**
	 * Var string
	 */
	public $licenseCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var string
	 */
	public $revRecStartDate;
	/**
	 * Var string
	 */
	public $revRecEndDate;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var \NetSuite\Classes\ItemCostEstimateType
	 */
	public $costEstimateType;
	/**
	 * Var float
	 */
	public $costEstimate;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var boolean
	 */
	public $excludeFromRateRequest;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $catchUpPeriod;
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
	 * Var float
	 */
	public $taxAmount;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $chargesList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'job' => 'RecordRef',
		'item' => 'RecordRef',
		'line' => 'integer',
		'description' => 'string',
		'amount' => 'float',
		'isTaxable' => 'boolean',
		'options' => 'CustomFieldList',
		'subscriptionLine' => 'RecordRef',
		'deferRevRec' => 'boolean',
		'quantity' => 'float',
		'currentPercent' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbers' => 'string',
		'binNumbers' => 'string',
		'price' => 'RecordRef',
		'rate' => 'string',
		'percentComplete' => 'float',
		'quantityOnHand' => 'float',
		'quantityAvailable' => 'float',
		'quantityOrdered' => 'float',
		'quantityRemaining' => 'float',
		'quantityFulfilled' => 'float',
		'amountOrdered' => 'float',
		'department' => 'RecordRef',
		'orderLine' => 'integer',
		'licenseCode' => 'string',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'grossAmt' => 'float',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'taxDetailsReference' => 'string',
		'excludeFromRateRequest' => 'boolean',
		'catchUpPeriod' => 'RecordRef',
		'tax1Amt' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'giftCertFrom' => 'string',
		'giftCertRecipientName' => 'string',
		'giftCertRecipientEmail' => 'string',
		'giftCertMessage' => 'string',
		'taxAmount' => 'float',
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
		'chargeType' => 'RecordRef',
		'chargesList' => 'RecordRefList',
		'customFieldList' => 'CustomFieldList',
	);
}
