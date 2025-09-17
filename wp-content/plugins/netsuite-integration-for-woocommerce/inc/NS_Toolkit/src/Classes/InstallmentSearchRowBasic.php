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

class InstallmentSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amountPaid;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $daysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxAmountPaid;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxAmountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $installmentNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amount' => 'SearchColumnDoubleField[]',
		'amountPaid' => 'SearchColumnDoubleField[]',
		'amountRemaining' => 'SearchColumnDoubleField[]',
		'daysOverdue' => 'SearchColumnLongField[]',
		'dueDate' => 'SearchColumnDateField[]',
		'fxAmount' => 'SearchColumnDoubleField[]',
		'fxAmountPaid' => 'SearchColumnDoubleField[]',
		'fxAmountRemaining' => 'SearchColumnDoubleField[]',
		'installmentNumber' => 'SearchColumnLongField[]',
		'status' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
