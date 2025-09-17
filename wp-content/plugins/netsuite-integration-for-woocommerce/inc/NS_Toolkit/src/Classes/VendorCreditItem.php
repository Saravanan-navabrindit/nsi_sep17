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

class VendorCreditItem {
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
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $serialNumbersList;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var string
	 */
	public $binNumbers;
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
	public $grossAmt;
	/**
	 * Var float
	 */
	public $tax1Amt;
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
	public $customer;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $amortizationSched;
	/**
	 * Var string
	 */
	public $amortizStartDate;
	/**
	 * Var string
	 */
	public $amortizationEndDate;
	/**
	 * Var string
	 */
	public $amortizationResidual;
	/**
	 * Var float
	 */
	public $taxAmount;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'vendorName' => 'string',
		'line' => 'integer',
		'orderLine' => 'integer',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbersList' => 'RecordRefList',
		'description' => 'string',
		'rate' => 'string',
		'amount' => 'float',
		'binNumbers' => 'string',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'grossAmt' => 'float',
		'tax1Amt' => 'float',
		'options' => 'CustomFieldList',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'customer' => 'RecordRef',
		'isBillable' => 'boolean',
		'amortizationSched' => 'RecordRef',
		'amortizStartDate' => 'dateTime',
		'amortizationEndDate' => 'dateTime',
		'amortizationResidual' => 'string',
		'taxAmount' => 'float',
		'taxDetailsReference' => 'string',
		'customFieldList' => 'CustomFieldList',
	);
}
