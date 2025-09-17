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

class CustomerPayment extends Record {
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
	public $arAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var float
	 */
	public $pending;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $payment;
	/**
	 * Var boolean
	 */
	public $autoApply;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var string
	 */
	public $tranId;
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
	public $checkNum;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
	/**
	 * Var boolean
	 */
	public $chargeIt;
	/**
	 * Var string
	 */
	public $ccNumber;
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
	 * Var string
	 */
	public $authCode;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccAvsStreetMatch;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccAvsZipMatch;
	/**
	 * Var boolean
	 */
	public $isRecurringPayment;
	/**
	 * Var string
	 */
	public $ccSecurityCode;
	/**
	 * Var boolean
	 */
	public $ignoreAvs;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccSecurityCodeMatch;
	/**
	 * Var string
	 */
	public $threeDStatusCode;
	/**
	 * Var string
	 */
	public $pnRefNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var string
	 */
	public $debitCardIssueNo;
	/**
	 * Var string
	 */
	public $validFrom;
	/**
	 * Var boolean
	 */
	public $undepFunds;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var float
	 */
	public $applied;
	/**
	 * Var float
	 */
	public $unapplied;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
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
	 * Var \NetSuite\Classes\CustomerPaymentHandlingMode
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
	 * Var \NetSuite\Classes\CustomerPaymentPaymentOperation
	 */
	public $paymentOperation;
	/**
	 * Var string
	 */
	public $dynamicDescriptor;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\CustomerPaymentApplyList
	 */
	public $applyList;
	/**
	 * Var \NetSuite\Classes\CustomerPaymentCreditList
	 */
	public $creditList;
	/**
	 * Var \NetSuite\Classes\CustomerPaymentDepositList
	 */
	public $depositList;
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
		'customForm' => 'RecordRef',
		'arAcct' => 'RecordRef',
		'customer' => 'RecordRef',
		'balance' => 'float',
		'pending' => 'float',
		'currency' => 'RecordRef',
		'payment' => 'float',
		'autoApply' => 'boolean',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'postingPeriod' => 'RecordRef',
		'paymentMethod' => 'RecordRef',
		'ccIsPurchaseCardBin' => 'boolean',
		'memo' => 'string',
		'ccProcessAsPurchaseCard' => 'boolean',
		'checkNum' => 'string',
		'currencyName' => 'string',
		'exchangeRate' => 'float',
		'creditCard' => 'RecordRef',
		'chargeIt' => 'boolean',
		'ccNumber' => 'string',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'ccApproved' => 'boolean',
		'authCode' => 'string',
		'ccAvsStreetMatch' => 'AvsMatchCode',
		'ccAvsZipMatch' => 'AvsMatchCode',
		'isRecurringPayment' => 'boolean',
		'ccSecurityCode' => 'string',
		'ignoreAvs' => 'boolean',
		'ccSecurityCodeMatch' => 'AvsMatchCode',
		'threeDStatusCode' => 'string',
		'pnRefNum' => 'string',
		'creditCardProcessor' => 'RecordRef',
		'debitCardIssueNo' => 'string',
		'validFrom' => 'dateTime',
		'undepFunds' => 'boolean',
		'account' => 'RecordRef',
		'total' => 'float',
		'subsidiary' => 'RecordRef',
		'applied' => 'float',
		'unapplied' => 'float',
		'class' => 'RecordRef',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'paymentOption' => 'RecordRef',
		'inputAuthCode' => 'string',
		'inputReferenceCode' => 'string',
		'checkNumber' => 'string',
		'paymentCardCsc' => 'string',
		'paymentProcessingProfile' => 'RecordRef',
		'handlingMode' => 'CustomerPaymentHandlingMode',
		'outputAuthCode' => 'string',
		'outputReferenceCode' => 'string',
		'paymentOperation' => 'CustomerPaymentPaymentOperation',
		'dynamicDescriptor' => 'string',
		'status' => 'string',
		'applyList' => 'CustomerPaymentApplyList',
		'creditList' => 'CustomerPaymentCreditList',
		'depositList' => 'CustomerPaymentDepositList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
