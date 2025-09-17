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

class EstimateItem {
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
	 * Var boolean
	 */
	public $expandItemGroup;
	/**
	 * Var float
	 */
	public $quantityAvailable;
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
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $serialNumbers;
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
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var integer
	 */
	public $revRecTermInMonths;
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
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var float
	 */
	public $altSalesAmt;
	/**
	 * Var float
	 */
	public $taxAmount;
	/**
	 * Var boolean
	 */
	public $fromJob;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var boolean
	 */
	public $isEstimate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subscription;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var \NetSuite\Classes\ItemCostEstimateType
	 */
	public $costEstimateType;
	/**
	 * Var float
	 */
	public $costEstimate;
	/**
	 * Var boolean
	 */
	public $excludeFromRateRequest;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var float
	 */
	public $taxRate1;
	/**
	 * Var float
	 */
	public $taxRate2;
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
	 * Var string
	 */
	public $expectedShipDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'job' => 'RecordRef',
		'item' => 'RecordRef',
		'line' => 'integer',
		'expandItemGroup' => 'boolean',
		'quantityAvailable' => 'float',
		'quantityOnHand' => 'float',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'description' => 'string',
		'serialNumbers' => 'string',
		'price' => 'RecordRef',
		'rate' => 'string',
		'amount' => 'float',
		'options' => 'CustomFieldList',
		'revRecTermInMonths' => 'integer',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'isTaxable' => 'boolean',
		'altSalesAmt' => 'float',
		'taxAmount' => 'float',
		'fromJob' => 'boolean',
		'grossAmt' => 'float',
		'isEstimate' => 'boolean',
		'subscription' => 'RecordRef',
		'tax1Amt' => 'float',
		'taxCode' => 'RecordRef',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'excludeFromRateRequest' => 'boolean',
		'taxDetailsReference' => 'string',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'shipGroup' => 'integer',
		'itemIsFulfilled' => 'boolean',
		'shipAddress' => 'RecordRef',
		'shipMethod' => 'RecordRef',
		'expectedShipDate' => 'dateTime',
		'chargeType' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
