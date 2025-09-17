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

class ExpenseReport extends Record {
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expenseReportCurrency;
	/**
	 * Var float
	 */
	public $expenseReportExchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var string
	 */
	public $taxPointDate;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $acctCorpCardExp;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var string
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approvalStatus;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nextApprover;
	/**
	 * Var float
	 */
	public $advance;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $complete;
	/**
	 * Var boolean
	 */
	public $supervisorApproval;
	/**
	 * Var boolean
	 */
	public $accountingApproval;
	/**
	 * Var boolean
	 */
	public $useMultiCurrency;
	/**
	 * Var float
	 */
	public $tax2Amt;
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
	 * Var \NetSuite\Classes\ExpenseReportExpenseList
	 */
	public $expenseList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\TaxDetailsList
	 */
	public $taxDetailsList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiaryTaxRegNum;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'status' => 'string',
		'customForm' => 'RecordRef',
		'account' => 'RecordRef',
		'entity' => 'RecordRef',
		'expenseReportCurrency' => 'RecordRef',
		'expenseReportExchangeRate' => 'float',
		'subsidiary' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'tranId' => 'string',
		'acctCorpCardExp' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'tranDate' => 'dateTime',
		'dueDate' => 'dateTime',
		'approvalStatus' => 'RecordRef',
		'total' => 'float',
		'nextApprover' => 'RecordRef',
		'advance' => 'float',
		'tax1Amt' => 'float',
		'amount' => 'float',
		'memo' => 'string',
		'complete' => 'boolean',
		'supervisorApproval' => 'boolean',
		'accountingApproval' => 'boolean',
		'useMultiCurrency' => 'boolean',
		'tax2Amt' => 'float',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'expenseList' => 'ExpenseReportExpenseList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'taxDetailsList' => 'TaxDetailsList',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
