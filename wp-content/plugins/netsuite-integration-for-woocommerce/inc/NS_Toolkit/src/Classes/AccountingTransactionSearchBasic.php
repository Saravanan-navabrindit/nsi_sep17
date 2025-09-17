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

class AccountingTransactionSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $altSalesAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $altSalesNetAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $bookSpecificTransaction;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $catchUpPeriod;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $creditAmount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $customGL;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $debitAmount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $grossAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $multiSubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $netAmount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $posting;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityRevCommitted;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $recognizedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $revCommitStatus;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $revenueStatus;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $revRecEndDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $revRecOnRevCommitment;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $revRecStartDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $tranIsVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vsoeAllocation;
	public static $paramtypesmap = array(
		'account' => 'SearchMultiSelectField',
		'accountingBook' => 'SearchMultiSelectField',
		'accountType' => 'SearchMultiSelectField',
		'altSalesAmount' => 'SearchDoubleField',
		'altSalesNetAmount' => 'SearchDoubleField',
		'amount' => 'SearchDoubleField',
		'bookSpecificTransaction' => 'SearchBooleanField',
		'catchUpPeriod' => 'SearchMultiSelectField',
		'creditAmount' => 'SearchDoubleField',
		'customGL' => 'SearchBooleanField',
		'debitAmount' => 'SearchDoubleField',
		'deferRevRec' => 'SearchBooleanField',
		'exchangeRate' => 'SearchDoubleField',
		'grossAmount' => 'SearchDoubleField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'multiSubsidiary' => 'SearchBooleanField',
		'netAmount' => 'SearchDoubleField',
		'posting' => 'SearchBooleanField',
		'quantityRevCommitted' => 'SearchDoubleField',
		'recognizedRevenue' => 'SearchDoubleField',
		'revCommitStatus' => 'SearchEnumMultiSelectField',
		'revenueStatus' => 'SearchEnumMultiSelectField',
		'revRecEndDate' => 'SearchDateField',
		'revRecOnRevCommitment' => 'SearchBooleanField',
		'revRecStartDate' => 'SearchDateField',
		'subsidiary' => 'SearchMultiSelectField',
		'tranIsVsoeBundle' => 'SearchBooleanField',
		'type' => 'SearchEnumMultiSelectField',
		'vsoeAllocation' => 'SearchDoubleField',
	);
}
