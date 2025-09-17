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

class CheckItem {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var string
	 */
	public $vendorName;
	/**
	 * Var integer
	 */
	public $line;
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
	public $expirationDate;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var float
	 */
	public $taxRate1;
	/**
	 * Var float
	 */
	public $taxRate2;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 *Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\LandedCost
	 */
	public $landedCost;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'vendorName' => 'string',
		'line' => 'integer',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'description' => 'string',
		'binNumbers' => 'string',
		'serialNumbers' => 'string',
		'expirationDate' => 'dateTime',
		'rate' => 'string',
		'taxCode' => 'RecordRef',
		'amount' => 'float',
		'options' => 'CustomFieldList',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'department' => 'RecordRef',
		'grossAmt' => 'float',
		'class' => 'RecordRef',
		'tax1Amt' => 'float',
		'location' => 'RecordRef',
		'customer' => 'RecordRef',
		'isBillable' => 'boolean',
		'landedCost' => 'LandedCost',
		'customFieldList' => 'CustomFieldList',
	);
}
