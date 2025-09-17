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

class Check extends Record {
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
	 * Var float
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $voidJournal;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var boolean
	 */
	public $toBePrinted;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var float
	 */
	public $userTotal;
	/**
	 * Var \NetSuite\Classes\LandedCostMethod
	 */
	public $landedCostMethod;
	/**
	 * Var boolean
	 */
	public $landedCostPerLine;
	/**
	 * Var string
	 */
	public $transactionNumber;
	/**
	 * Var \NetSuite\Classes\CheckExpenseList
	 */
	public $expenseList;
	/**
	 * Var \NetSuite\Classes\CheckItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CheckLandedCostList
	 */
	public $landedCostsList;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $payeeAddressList;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $payeeAddress;
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
		'balance' => 'float',
		'entity' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'tranDate' => 'dateTime',
		'currency' => 'RecordRef',
		'voidJournal' => 'RecordRef',
		'exchangeRate' => 'float',
		'toBePrinted' => 'boolean',
		'tranId' => 'string',
		'memo' => 'string',
		'department' => 'RecordRef',
		'taxTotal' => 'float',
		'class' => 'RecordRef',
		'tax2Total' => 'float',
		'location' => 'RecordRef',
		'userTotal' => 'float',
		'landedCostMethod' => 'LandedCostMethod',
		'landedCostPerLine' => 'boolean',
		'transactionNumber' => 'string',
		'expenseList' => 'CheckExpenseList',
		'itemList' => 'CheckItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'landedCostsList' => 'CheckLandedCostList',
		'billPay' => 'boolean',
		'payeeAddressList' => 'RecordRef',
		'payeeAddress' => 'Address',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
