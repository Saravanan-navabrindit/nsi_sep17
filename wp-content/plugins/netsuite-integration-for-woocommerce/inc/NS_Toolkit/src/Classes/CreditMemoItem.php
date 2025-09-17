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

class CreditMemoItem {
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
	public $orderLine;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var string
	 */
	public $description;
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
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\ShippingCarrier
	 */
	public $shipCarrier;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
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
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var float
	 */
	public $grossAmt;
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
	 * Var boolean
	 */
	public $deferRevRec;
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
	public $catchUpPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subscriptionLine;
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
		'orderLine' => 'integer',
		'line' => 'integer',
		'quantity' => 'float',
		'description' => 'string',
		'binNumbers' => 'string',
		'price' => 'RecordRef',
		'rate' => 'string',
		'amount' => 'float',
		'isTaxable' => 'boolean',
		'options' => 'CustomFieldList',
		'shipAddress' => 'RecordRef',
		'shipCarrier' => 'ShippingCarrier',
		'shipMethod' => 'RecordRef',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'tax1Amt' => 'float',
		'grossAmt' => 'float',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'taxDetailsReference' => 'string',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecTermInMonths' => 'integer',
		'revRecEndDate' => 'dateTime',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbers' => 'string',
		'deferRevRec' => 'boolean',
		'giftCertFrom' => 'string',
		'giftCertRecipientName' => 'string',
		'giftCertRecipientEmail' => 'string',
		'giftCertMessage' => 'string',
		'taxAmount' => 'float',
		'giftCertNumber' => 'string',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'vsoeIsEstimate' => 'boolean',
		'vsoePrice' => 'float',
		'vsoeAmount' => 'float',
		'vsoeAllocation' => 'float',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'catchUpPeriod' => 'RecordRef',
		'chargeType' => 'RecordRef',
		'subscriptionLine' => 'RecordRef',
		'chargesList' => 'RecordRefList',
		'customFieldList' => 'CustomFieldList',
	);
}
