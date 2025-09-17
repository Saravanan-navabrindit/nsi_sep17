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

class PaycheckJournal extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employee;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
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
	 * Var \NetSuite\Classes\PaycheckJournalCompanyContributionList
	 */
	public $companyContributionList;
	/**
	 * Var \NetSuite\Classes\PaycheckJournalDeductionList
	 */
	public $deductionList;
	/**
	 * Var \NetSuite\Classes\PaycheckJournalEmployeeTaxList
	 */
	public $employeeTaxList;
	/**
	 * Var \NetSuite\Classes\PaycheckJournalCompanyTaxList
	 */
	public $companyTaxList;
	/**
	 * Var \NetSuite\Classes\PaycheckJournalEarningList
	 */
	public $earningList;
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
		'subsidiary' => 'RecordRef',
		'currency' => 'RecordRef',
		'exchangeRate' => 'float',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'customForm' => 'RecordRef',
		'tranId' => 'string',
		'employee' => 'RecordRef',
		'tranDate' => 'dateTime',
		'postingPeriod' => 'RecordRef',
		'account' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'companyContributionList' => 'PaycheckJournalCompanyContributionList',
		'deductionList' => 'PaycheckJournalDeductionList',
		'employeeTaxList' => 'PaycheckJournalEmployeeTaxList',
		'companyTaxList' => 'PaycheckJournalCompanyTaxList',
		'earningList' => 'PaycheckJournalEarningList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
