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

class CashRefundItem {
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
	 * Var integer
	 */
	public $orderLine;
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
	public $binNumbers;
	/**
	 * Var string
	 */
	public $serialNumbers;
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
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var string
	 */
	public $taxRate1;
	/**
	 * Var string
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $catchUpPeriod;
	/**
	 * Var boolean
	 */
	public $deferRevRec;
	/**
	 * Var string
	 */
	public $giftCertFrom;
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
		'orderLine' => 'integer',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'binNumbers' => 'string',
		'serialNumbers' => 'string',
		'description' => 'string',
		'price' => 'RecordRef',
		'rate' => 'string',
		'amount' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'string',
		'taxRate2' => 'string',
		'tax1Amt' => 'float',
		'grossAmt' => 'float',
		'isTaxable' => 'boolean',
		'options' => 'CustomFieldList',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'catchUpPeriod' => 'RecordRef',
		'deferRevRec' => 'boolean',
		'giftCertFrom' => 'string',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'taxDetailsReference' => 'string',
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
		'chargeType' => 'RecordRef',
		'chargesList' => 'RecordRefList',
		'customFieldList' => 'CustomFieldList',
	);
}
