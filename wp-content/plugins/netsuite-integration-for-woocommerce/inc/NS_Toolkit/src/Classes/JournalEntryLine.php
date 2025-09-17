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

class JournalEntryLine {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var float
	 */
	public $debit;
	/**
	 * Var float
	 */
	public $credit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $lineTaxCode;
	/**
	 * Var float
	 */
	public $lineTaxRate;
	/**
	 * Var float
	 */
	public $debitTax;
	/**
	 * Var float
	 */
	public $creditTax;
	/**
	 * Var float
	 */
	public $taxBasis;
	/**
	 * Var float
	 */
	public $totalAmount;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revenueRecognitionRule;
	/**
	 * Var boolean
	 */
	public $eliminate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $schedule;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $residual;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $scheduleNum;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $tax1Acct;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'account' => 'RecordRef',
		'line' => 'integer',
		'debit' => 'float',
		'credit' => 'float',
		'taxAccount' => 'RecordRef',
		'lineTaxCode' => 'RecordRef',
		'lineTaxRate' => 'float',
		'debitTax' => 'float',
		'creditTax' => 'float',
		'taxBasis' => 'float',
		'totalAmount' => 'float',
		'taxCode' => 'RecordRef',
		'memo' => 'string',
		'taxRate1' => 'float',
		'entity' => 'RecordRef',
		'grossAmt' => 'float',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'revenueRecognitionRule' => 'RecordRef',
		'eliminate' => 'boolean',
		'schedule' => 'RecordRef',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'residual' => 'string',
		'scheduleNum' => 'RecordRef',
		'tax1Amt' => 'float',
		'tax1Acct' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
