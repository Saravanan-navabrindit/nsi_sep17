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

class VendorPayment extends Record {
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
	public $apAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $voidJournal;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var boolean
	 */
	public $toAch;
	/**
	 * Var boolean
	 */
	public $toBePrinted;
	/**
	 * Var boolean
	 */
	public $printVoucher;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var string
	 */
	public $transactionNumber;
	/**
	 * Var \NetSuite\Classes\VendorPaymentApplyList
	 */
	public $applyList;
	/**
	 * Var \NetSuite\Classes\VendorPaymentCreditList
	 */
	public $creditList;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var float
	 */
	public $availableBalance;
	/**
	 * Var boolean
	 */
	public $isInTransitPayment;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nextApprover;
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
		'customForm' => 'RecordRef',
		'account' => 'RecordRef',
		'balance' => 'float',
		'apAcct' => 'RecordRef',
		'entity' => 'RecordRef',
		'tranDate' => 'dateTime',
		'voidJournal' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'currencyName' => 'string',
		'exchangeRate' => 'float',
		'toAch' => 'boolean',
		'toBePrinted' => 'boolean',
		'printVoucher' => 'boolean',
		'tranId' => 'string',
		'total' => 'float',
		'currency' => 'RecordRef',
		'department' => 'RecordRef',
		'memo' => 'string',
		'subsidiary' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'status' => 'string',
		'transactionNumber' => 'string',
		'applyList' => 'VendorPaymentApplyList',
		'creditList' => 'VendorPaymentCreditList',
		'billPay' => 'boolean',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'availableBalance' => 'float',
		'isInTransitPayment' => 'boolean',
		'approvalStatus' => 'RecordRef',
		'nextApprover' => 'RecordRef',
		'payeeAddressList' => 'RecordRef',
		'payeeAddress' => 'Address',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
