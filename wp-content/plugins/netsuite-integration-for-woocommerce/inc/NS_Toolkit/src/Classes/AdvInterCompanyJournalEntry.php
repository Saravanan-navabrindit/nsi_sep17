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

class AdvInterCompanyJournalEntry extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var string
	 */
	public $reversalDate;
	/**
	 * Var boolean
	 */
	public $reversalDefer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parentExpenseAlloc;
	/**
	 * Var boolean
	 */
	public $isBookSpecific;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $accountingBook;
	/**
	 * Var string
	 */
	public $reversalEntry;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
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
	public $subsidiary;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $approved;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var boolean
	 */
	public $performAutoBalance;
	/**
	 * Var \NetSuite\Classes\AdvInterCompanyJournalEntryLineList
	 */
	public $lineList;
	/**
	 * Var \NetSuite\Classes\AdvInterCompanyJournalEntryAccountingBookDetailList
	 */
	public $accountingBookDetailList;
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
		'postingPeriod' => 'RecordRef',
		'customForm' => 'RecordRef',
		'tranDate' => 'dateTime',
		'currency' => 'RecordRef',
		'tranId' => 'string',
		'reversalDate' => 'dateTime',
		'reversalDefer' => 'boolean',
		'parentExpenseAlloc' => 'RecordRef',
		'isBookSpecific' => 'boolean',
		'accountingBook' => 'RecordRef',
		'reversalEntry' => 'string',
		'createdFrom' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'memo' => 'string',
		'approved' => 'boolean',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'performAutoBalance' => 'boolean',
		'lineList' => 'AdvInterCompanyJournalEntryLineList',
		'accountingBookDetailList' => 'AdvInterCompanyJournalEntryAccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
