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

class CustomerRefund extends Record {
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
	 * Var string
	 */
	public $transactionNumber;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $arAcct;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
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
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
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
	public $debitCardIssueNo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var boolean
	 */
	public $chargeIt;
	/**
	 * Var string
	 */
	public $pnRefNum;
	/**
	 * Var string
	 */
	public $validFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
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
	public $paymentOption;
	/**
	 * Var string
	 */
	public $inputAuthCode;
	/**
	 * Var string
	 */
	public $inputReferenceCode;
	/**
	 * Var string
	 */
	public $checkNumber;
	/**
	 * Var string
	 */
	public $paymentCardCsc;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentProcessingProfile;
	/**
	 * Var \NetSuite\Classes\CustomerRefundHandlingMode
	 */
	public $handlingMode;
	/**
	 * Var string
	 */
	public $outputAuthCode;
	/**
	 * Var string
	 */
	public $outputReferenceCode;
	/**
	 * Var \NetSuite\Classes\CustomerRefundPaymentOperation
	 */
	public $paymentOperation;
	/**
	 * Var string
	 */
	public $dynamicDescriptor;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
	/**
	 * Var boolean
	 */
	public $ccIsPurchaseCardBin;
	/**
	 * Var string
	 */
	public $ccNumber;
	/**
	 * Var boolean
	 */
	public $ccProcessAsPurchaseCard;
	/**
	 * Var string
	 */
	public $ccExpireDate;
	/**
	 * Var string
	 */
	public $ccName;
	/**
	 * Var string
	 */
	public $ccStreet;
	/**
	 * Var string
	 */
	public $ccZipCode;
	/**
	 * Var boolean
	 */
	public $ccApproved;
	/**
	 * Var \NetSuite\Classes\CustomerRefundApplyList
	 */
	public $applyList;
	/**
	 * Var \NetSuite\Classes\CustomerRefundDepositList
	 */
	public $depositList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
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
		'transactionNumber' => 'string',
		'customer' => 'RecordRef',
		'customForm' => 'RecordRef',
		'balance' => 'float',
		'arAcct' => 'RecordRef',
		'currencyName' => 'string',
		'exchangeRate' => 'float',
		'total' => 'float',
		'currency' => 'RecordRef',
		'tranDate' => 'dateTime',
		'voidJournal' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'memo' => 'string',
		'paymentMethod' => 'RecordRef',
		'account' => 'RecordRef',
		'toBePrinted' => 'boolean',
		'tranId' => 'string',
		'debitCardIssueNo' => 'string',
		'creditCardProcessor' => 'RecordRef',
		'chargeIt' => 'boolean',
		'pnRefNum' => 'string',
		'validFrom' => 'dateTime',
		'subsidiary' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'paymentOption' => 'RecordRef',
		'inputAuthCode' => 'string',
		'inputReferenceCode' => 'string',
		'checkNumber' => 'string',
		'paymentCardCsc' => 'string',
		'paymentProcessingProfile' => 'RecordRef',
		'handlingMode' => 'CustomerRefundHandlingMode',
		'outputAuthCode' => 'string',
		'outputReferenceCode' => 'string',
		'paymentOperation' => 'CustomerRefundPaymentOperation',
		'dynamicDescriptor' => 'string',
		'creditCard' => 'RecordRef',
		'ccIsPurchaseCardBin' => 'boolean',
		'ccNumber' => 'string',
		'ccProcessAsPurchaseCard' => 'boolean',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'ccApproved' => 'boolean',
		'applyList' => 'CustomerRefundApplyList',
		'depositList' => 'CustomerRefundDepositList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'payeeAddressList' => 'RecordRef',
		'payeeAddress' => 'Address',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
