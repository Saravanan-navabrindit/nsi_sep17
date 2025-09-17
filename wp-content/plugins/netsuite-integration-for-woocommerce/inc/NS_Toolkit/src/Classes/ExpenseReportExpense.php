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

class ExpenseReportExpense {
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var string
	 */
	public $expenseDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $foreignAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $exchangeRate;
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
	public $memo;
	/**
	 * Var float
	 */
	public $taxRate1;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var float
	 */
	public $taxRate2;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expMediaItem;
	/**
	 * Var boolean
	 */
	public $isNonReimbursable;
	/**
	 * Var boolean
	 */
	public $corporateCreditCard;
	/**
	 * Var boolean
	 */
	public $receipt;
	/**
	 * Var integer
	 */
	public $refNumber;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expenseAccount;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'line' => 'integer',
		'expenseDate' => 'dateTime',
		'category' => 'RecordRef',
		'quantity' => 'float',
		'rate' => 'float',
		'foreignAmount' => 'float',
		'currency' => 'RecordRef',
		'exchangeRate' => 'float',
		'amount' => 'float',
		'taxCode' => 'RecordRef',
		'memo' => 'string',
		'taxRate1' => 'float',
		'tax1Amt' => 'float',
		'department' => 'RecordRef',
		'grossAmt' => 'float',
		'taxRate2' => 'float',
		'class' => 'RecordRef',
		'customer' => 'RecordRef',
		'location' => 'RecordRef',
		'isBillable' => 'boolean',
		'expMediaItem' => 'RecordRef',
		'isNonReimbursable' => 'boolean',
		'corporateCreditCard' => 'boolean',
		'receipt' => 'boolean',
		'refNumber' => 'integer',
		'taxDetailsReference' => 'string',
		'expenseAccount' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
