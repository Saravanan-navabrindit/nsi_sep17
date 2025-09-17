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

class Vendor extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $entityId;
	/**
	 * Var string
	 */
	public $altName;
	/**
	 * Var boolean
	 */
	public $isPerson;
	/**
	 * Var string
	 */
	public $phoneticName;
	/**
	 * Var string
	 */
	public $salutation;
	/**
	 * Var string
	 */
	public $firstName;
	/**
	 * Var string
	 */
	public $middleName;
	/**
	 * Var string
	 */
	public $lastName;
	/**
	 * Var string
	 */
	public $companyName;
	/**
	 * Var string
	 */
	public $phone;
	/**
	 * Var string
	 */
	public $fax;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var string
	 */
	public $url;
	/**
	 * Var string
	 */
	public $defaultAddress;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var string
	 */
	public $printOnCheckAs;
	/**
	 * Var string
	 */
	public $altPhone;
	/**
	 * Var string
	 */
	public $homePhone;
	/**
	 * Var string
	 */
	public $mobilePhone;
	/**
	 * Var string
	 */
	public $altEmail;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\GlobalSubscriptionStatus
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $image;
	/**
	 * Var \NetSuite\Classes\EmailPreference
	 */
	public $emailPreference;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $representingSubsidiary;
	/**
	 * Var string
	 */
	public $accountNumber;
	/**
	 * Var string
	 */
	public $legalName;
	/**
	 * Var string
	 */
	public $vatRegNumber;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expenseAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $payablesAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $terms;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $incoterm;
	/**
	 * Var float
	 */
	public $creditLimit;
	/**
	 * Var float
	 */
	public $balancePrimary;
	/**
	 * Var float
	 */
	public $openingBalance;
	/**
	 * Var string
	 */
	public $openingBalanceDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $openingBalanceAccount;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var float
	 */
	public $unbilledOrdersPrimary;
	/**
	 * Var string
	 */
	public $bcn;
	/**
	 * Var float
	 */
	public $unbilledOrders;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var boolean
	 */
	public $is1099Eligible;
	/**
	 * Var boolean
	 */
	public $isJobResourceVend;
	/**
	 * Var float
	 */
	public $laborCost;
	/**
	 * Var float
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var float
	 */
	public $purchaseOrderAmount;
	/**
	 * Var float
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var float
	 */
	public $receiptQuantity;
	/**
	 * Var float
	 */
	public $receiptAmount;
	/**
	 * Var float
	 */
	public $receiptQuantityDiff;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workCalendar;
	/**
	 * Var string
	 */
	public $taxIdNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxItem;
	/**
	 * Var boolean
	 */
	public $giveAccess;
	/**
	 * Var boolean
	 */
	public $sendEmail;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var boolean
	 */
	public $isAccountant;
	/**
	 * Var string
	 */
	public $password;
	/**
	 * Var string
	 */
	public $password2;
	/**
	 * Var boolean
	 */
	public $requirePwdChange;
	/**
	 * Var boolean
	 */
	public $eligibleForCommission;
	/**
	 * Var boolean
	 */
	public $emailTransactions;
	/**
	 * Var boolean
	 */
	public $printTransactions;
	/**
	 * Var boolean
	 */
	public $faxTransactions;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\VendorPricingScheduleList
	 */
	public $pricingScheduleList;
	/**
	 * Var \NetSuite\Classes\SubscriptionsList
	 */
	public $subscriptionsList;
	/**
	 * Var \NetSuite\Classes\VendorAddressbookList
	 */
	public $addressbookList;
	/**
	 * Var \NetSuite\Classes\VendorCurrencyList
	 */
	public $currencyList;
	/**
	 * Var \NetSuite\Classes\VendorRolesList
	 */
	public $rolesList;
	/**
	 * Var \NetSuite\Classes\VendorTaxRegistrationList
	 */
	public $taxRegistrationList;
	/**
	 * Var integer
	 */
	public $predictedDays;
	/**
	 * Var float
	 */
	public $predConfidence;
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
		'customForm' => 'RecordRef',
		'entityId' => 'string',
		'altName' => 'string',
		'isPerson' => 'boolean',
		'phoneticName' => 'string',
		'salutation' => 'string',
		'firstName' => 'string',
		'middleName' => 'string',
		'lastName' => 'string',
		'companyName' => 'string',
		'phone' => 'string',
		'fax' => 'string',
		'email' => 'string',
		'url' => 'string',
		'defaultAddress' => 'string',
		'isInactive' => 'boolean',
		'lastModifiedDate' => 'dateTime',
		'dateCreated' => 'dateTime',
		'category' => 'RecordRef',
		'title' => 'string',
		'printOnCheckAs' => 'string',
		'altPhone' => 'string',
		'homePhone' => 'string',
		'mobilePhone' => 'string',
		'altEmail' => 'string',
		'comments' => 'string',
		'globalSubscriptionStatus' => 'GlobalSubscriptionStatus',
		'image' => 'RecordRef',
		'emailPreference' => 'EmailPreference',
		'subsidiary' => 'RecordRef',
		'representingSubsidiary' => 'RecordRef',
		'accountNumber' => 'string',
		'legalName' => 'string',
		'vatRegNumber' => 'string',
		'expenseAccount' => 'RecordRef',
		'payablesAccount' => 'RecordRef',
		'terms' => 'RecordRef',
		'incoterm' => 'RecordRef',
		'creditLimit' => 'float',
		'balancePrimary' => 'float',
		'openingBalance' => 'float',
		'openingBalanceDate' => 'dateTime',
		'openingBalanceAccount' => 'RecordRef',
		'balance' => 'float',
		'unbilledOrdersPrimary' => 'float',
		'bcn' => 'string',
		'unbilledOrders' => 'float',
		'currency' => 'RecordRef',
		'is1099Eligible' => 'boolean',
		'isJobResourceVend' => 'boolean',
		'laborCost' => 'float',
		'purchaseOrderQuantity' => 'float',
		'purchaseOrderAmount' => 'float',
		'purchaseOrderQuantityDiff' => 'float',
		'receiptQuantity' => 'float',
		'receiptAmount' => 'float',
		'receiptQuantityDiff' => 'float',
		'workCalendar' => 'RecordRef',
		'taxIdNum' => 'string',
		'taxItem' => 'RecordRef',
		'giveAccess' => 'boolean',
		'sendEmail' => 'boolean',
		'billPay' => 'boolean',
		'isAccountant' => 'boolean',
		'password' => 'string',
		'password2' => 'string',
		'requirePwdChange' => 'boolean',
		'eligibleForCommission' => 'boolean',
		'emailTransactions' => 'boolean',
		'printTransactions' => 'boolean',
		'faxTransactions' => 'boolean',
		'defaultTaxReg' => 'RecordRef',
		'pricingScheduleList' => 'VendorPricingScheduleList',
		'subscriptionsList' => 'SubscriptionsList',
		'addressbookList' => 'VendorAddressbookList',
		'currencyList' => 'VendorCurrencyList',
		'rolesList' => 'VendorRolesList',
		'taxRegistrationList' => 'VendorTaxRegistrationList',
		'predictedDays' => 'integer',
		'predConfidence' => 'float',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
