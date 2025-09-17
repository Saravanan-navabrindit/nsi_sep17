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

class AccountingTransactionSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accountType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $altSalesAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $altSalesNetAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $baseCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $catchUpPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $creditAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $customGL;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $debitAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $grossAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $multiSubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $netAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $posting;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityRevCommitted;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recognizedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $revCommitStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $revenueStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $revRecEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $revRecOnRevCommitment;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $revRecStartDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $tranIsVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vsoeAllocation;
	public static $paramtypesmap = array(
		'account' => 'SearchColumnSelectField[]',
		'accountingBook' => 'SearchColumnSelectField[]',
		'accountType' => 'SearchColumnStringField[]',
		'altSalesAmount' => 'SearchColumnDoubleField[]',
		'altSalesNetAmount' => 'SearchColumnDoubleField[]',
		'amount' => 'SearchColumnDoubleField[]',
		'baseCurrency' => 'SearchColumnStringField[]',
		'catchUpPeriod' => 'SearchColumnStringField[]',
		'creditAmount' => 'SearchColumnDoubleField[]',
		'customGL' => 'SearchColumnBooleanField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'debitAmount' => 'SearchColumnDoubleField[]',
		'deferRevRec' => 'SearchColumnBooleanField[]',
		'exchangeRate' => 'SearchColumnDoubleField[]',
		'fxAmount' => 'SearchColumnDoubleField[]',
		'grossAmount' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'multiSubsidiary' => 'SearchColumnBooleanField[]',
		'netAmount' => 'SearchColumnDoubleField[]',
		'posting' => 'SearchColumnBooleanField[]',
		'quantityRevCommitted' => 'SearchColumnDoubleField[]',
		'recognizedRevenue' => 'SearchColumnDoubleField[]',
		'revCommitStatus' => 'SearchColumnEnumSelectField[]',
		'revenueStatus' => 'SearchColumnEnumSelectField[]',
		'revRecEndDate' => 'SearchColumnDateField[]',
		'revRecOnRevCommitment' => 'SearchColumnBooleanField[]',
		'revRecStartDate' => 'SearchColumnDateField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'tranIsVsoeBundle' => 'SearchColumnBooleanField[]',
		'vsoeAllocation' => 'SearchColumnDoubleField[]',
	);
}
