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

class VendorReturnAuthorization extends Record {
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
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\VendorReturnAuthorizationOrderStatus
	 */
	public $orderStatus;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var float
	 */
	public $userTotal;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $billingAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billAddressList;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entityTaxRegNum;
	/**
	 * Var string
	 */
	public $taxPointDate;
	/**
	 * Var float
	 */
	public $userTaxTotal;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoTransaction;
	/**
	 * Var \NetSuite\Classes\IntercoStatus
	 */
	public $intercoStatus;
	/**
	 * Var \NetSuite\Classes\VendorReturnAuthorizationExpenseList
	 */
	public $expenseList;
	/**
	 * Var \NetSuite\Classes\VendorReturnAuthorizationItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
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
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxDetailsOverride' => 'boolean',
		'customForm' => 'RecordRef',
		'tranId' => 'string',
		'createdFrom' => 'RecordRef',
		'entity' => 'RecordRef',
		'orderStatus' => 'VendorReturnAuthorizationOrderStatus',
		'tranDate' => 'dateTime',
		'userTotal' => 'float',
		'currency' => 'RecordRef',
		'currencyName' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'memo' => 'string',
		'exchangeRate' => 'float',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'userTaxTotal' => 'float',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'intercoTransaction' => 'RecordRef',
		'intercoStatus' => 'IntercoStatus',
		'expenseList' => 'VendorReturnAuthorizationExpenseList',
		'itemList' => 'VendorReturnAuthorizationItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
