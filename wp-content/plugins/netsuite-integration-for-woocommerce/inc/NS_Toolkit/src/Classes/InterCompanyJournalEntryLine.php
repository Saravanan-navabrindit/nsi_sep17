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

class InterCompanyJournalEntryLine {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $lineSubsidiary;
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
	public $schedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var string
	 */
	public $endDate;
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
	 * Var string
	 */
	public $residual;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $amortizationSched;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $scheduleNum;
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
		'lineSubsidiary' => 'RecordRef',
		'account' => 'RecordRef',
		'line' => 'integer',
		'debit' => 'float',
		'credit' => 'float',
		'taxCode' => 'RecordRef',
		'memo' => 'string',
		'taxRate1' => 'float',
		'entity' => 'RecordRef',
		'grossAmt' => 'float',
		'schedule' => 'RecordRef',
		'department' => 'RecordRef',
		'startDate' => 'dateTime',
		'class' => 'RecordRef',
		'endDate' => 'dateTime',
		'location' => 'RecordRef',
		'revenueRecognitionRule' => 'RecordRef',
		'eliminate' => 'boolean',
		'residual' => 'string',
		'amortizationSched' => 'RecordRef',
		'scheduleNum' => 'RecordRef',
		'amortizStartDate' => 'dateTime',
		'amortizationEndDate' => 'dateTime',
		'amortizationResidual' => 'string',
		'tax1Amt' => 'float',
		'tax1Acct' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
