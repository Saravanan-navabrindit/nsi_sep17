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

class CustomPurchase extends Record {
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
	public $tranType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiaryTaxRegNum;
	/**
	 * Var boolean
	 */
	public $taxRegOverride;
	/**
	 * Var boolean
	 */
	public $taxDetailsOverride;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billAddressList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
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
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $billingAddress;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entityTaxRegNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $terms;
	/**
	 * Var string
	 */
	public $dueDate;
	/**
	 * Var string
	 */
	public $discountDate;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var float
	 */
	public $userTotal;
	/**
	 * Var float
	 */
	public $discountAmount;
	/**
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var boolean
	 */
	public $paymentHold;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $tranStatus;
	/**
	 * Var float
	 */
	public $availableVendorCredit;
	/**
	 * Var \NetSuite\Classes\LandedCostMethod
	 */
	public $landedCostMethod;
	/**
	 * Var boolean
	 */
	public $landedCostPerLine;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $incoterm;
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
	 * Var string
	 */
	public $status;
	/**
	 * Var string
	 */
	public $transactionNumber;
	/**
	 * Var boolean
	 */
	public $overrideInstallments;
	/**
	 * Var \NetSuite\Classes\InstallmentList
	 */
	public $installmentList;
	/**
	 * Var \NetSuite\Classes\CustomPurchaseExpenseList
	 */
	public $expenseList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CustomPurchaseItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\PurchLandedCostList
	 */
	public $landedCostsList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $purchaseOrderList;
	/**
	 * Var \NetSuite\Classes\TaxDetailsList
	 */
	public $taxDetailsList;
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
		'tranType' => 'RecordRef',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxDetailsOverride' => 'boolean',
		'customForm' => 'RecordRef',
		'billAddressList' => 'RecordRef',
		'account' => 'RecordRef',
		'entity' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'tranDate' => 'dateTime',
		'currencyName' => 'string',
		'billingAddress' => 'Address',
		'exchangeRate' => 'float',
		'entityTaxRegNum' => 'RecordRef',
		'terms' => 'RecordRef',
		'dueDate' => 'dateTime',
		'discountDate' => 'dateTime',
		'tranId' => 'string',
		'createdFrom' => 'RecordRef',
		'userTotal' => 'float',
		'discountAmount' => 'float',
		'taxTotal' => 'float',
		'paymentHold' => 'boolean',
		'memo' => 'string',
		'tranStatus' => 'RecordRef',
		'availableVendorCredit' => 'float',
		'landedCostMethod' => 'LandedCostMethod',
		'landedCostPerLine' => 'boolean',
		'currency' => 'RecordRef',
		'incoterm' => 'RecordRef',
		'class' => 'RecordRef',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'status' => 'string',
		'transactionNumber' => 'string',
		'overrideInstallments' => 'boolean',
		'installmentList' => 'InstallmentList',
		'expenseList' => 'CustomPurchaseExpenseList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'itemList' => 'CustomPurchaseItemList',
		'landedCostsList' => 'PurchLandedCostList',
		'purchaseOrderList' => 'RecordRefList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
