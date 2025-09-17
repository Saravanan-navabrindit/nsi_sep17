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

class InstallmentSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountPaid;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $daysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxAmountPaid;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxAmountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $installmentNumber;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amount' => 'SearchDoubleField',
		'amountPaid' => 'SearchDoubleField',
		'amountRemaining' => 'SearchDoubleField',
		'daysOverdue' => 'SearchLongField',
		'dueDate' => 'SearchDateField',
		'fxAmount' => 'SearchDoubleField',
		'fxAmountPaid' => 'SearchDoubleField',
		'fxAmountRemaining' => 'SearchDoubleField',
		'installmentNumber' => 'SearchLongField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
