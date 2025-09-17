<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class CustomerDeposit extends Record {
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
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesOrder;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var float
	 */
	public $payment;
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
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var boolean
	 */
	public $ccIsPurchaseCardBin;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $ccProcessAsPurchaseCard;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var string
	 */
	public $checkNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
	/**
	 * Var string
	 */
	public $ccSecurityCode;
	/**
	 * Var string
	 */
	public $ccNumber;
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
	 * Var \NetSuite\Classes\CustomerDepositHandlingMode
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
	 * Var \NetSuite\Classes\CustomerDepositPaymentOperation
	 */
	public $paymentOperation;
	/**
	 * Var string
	 */
	public $dynamicDescriptor;
	/**
	 * Var string
	 */
	public $ccExpireDate;
	/**
	 * Var string
	 */
	public $debitCardIssueNo;
	/**
	 * Var string
	 */
	public $validFrom;
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
	public $chargeIt;
	/**
	 * Var boolean
	 */
	public $ccApproved;
	/**
	 * Var string
	 */
	public $pnRefNum;
	/**
	 * Var string
	 */
	public $authCode;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccAvsStreetMatch;
	/**
	 * Var string
	 */
	public $softDescriptor;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccAvsZipMatch;
	/**
	 * Var boolean
	 */
	public $isRecurringPayment;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccSecurityCodeMatch;
	/**
	 * Var string
	 */
	public $threeDStatusCode;
	/**
	 * Var boolean
	 */
	public $ignoreAvs;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var boolean
	 */
	public $undepFunds;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\CustomerDepositApplyList
	 */
	public $applyList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
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
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'status' => 'string',
		'customer' => 'RecordRef',
		'salesOrder' => 'RecordRef',
		'customForm' => 'RecordRef',
		'payment' => 'float',
		'currency' => 'RecordRef',
		'tranDate' => 'dateTime',
		'postingPeriod' => 'RecordRef',
		'paymentMethod' => 'RecordRef',
		'ccIsPurchaseCardBin' => 'boolean',
		'memo' => 'string',
		'ccProcessAsPurchaseCard' => 'boolean',
		'currencyName' => 'string',
		'exchangeRate' => 'float',
		'checkNum' => 'string',
		'creditCardProcessor' => 'RecordRef',
		'creditCard' => 'RecordRef',
		'ccSecurityCode' => 'string',
		'ccNumber' => 'string',
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
		'handlingMode' => 'CustomerDepositHandlingMode',
		'outputAuthCode' => 'string',
		'outputReferenceCode' => 'string',
		'paymentOperation' => 'CustomerDepositPaymentOperation',
		'dynamicDescriptor' => 'string',
		'ccExpireDate' => 'dateTime',
		'debitCardIssueNo' => 'string',
		'validFrom' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'chargeIt' => 'boolean',
		'ccApproved' => 'boolean',
		'pnRefNum' => 'string',
		'authCode' => 'string',
		'ccAvsStreetMatch' => 'AvsMatchCode',
		'softDescriptor' => 'string',
		'ccAvsZipMatch' => 'AvsMatchCode',
		'isRecurringPayment' => 'boolean',
		'ccSecurityCodeMatch' => 'AvsMatchCode',
		'threeDStatusCode' => 'string',
		'ignoreAvs' => 'boolean',
		'account' => 'RecordRef',
		'undepFunds' => 'boolean',
		'tranId' => 'string',
		'applyList' => 'CustomerDepositApplyList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
