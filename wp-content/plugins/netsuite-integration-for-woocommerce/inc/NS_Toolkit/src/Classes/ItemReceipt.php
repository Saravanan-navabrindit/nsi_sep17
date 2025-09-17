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

class ItemReceipt extends Record {
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
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $inboundShipment;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemFulfillment;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\LandedCostMethod
	 */
	public $landedCostMethod;
	/**
	 * Var boolean
	 */
	public $landedCostPerLine;
	/**
	 * Var \NetSuite\Classes\ItemReceiptItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\ItemReceiptExpenseList
	 */
	public $expenseList;
	/**
	 * Var \NetSuite\Classes\PurchLandedCostList
	 */
	public $landedCostsList;
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
		'exchangeRate' => 'float',
		'entity' => 'RecordRef',
		'currencyName' => 'string',
		'subsidiary' => 'RecordRef',
		'createdFrom' => 'RecordRef',
		'tranDate' => 'dateTime',
		'partner' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'tranId' => 'string',
		'inboundShipment' => 'RecordRef',
		'memo' => 'string',
		'itemFulfillment' => 'RecordRef',
		'currency' => 'RecordRef',
		'landedCostMethod' => 'LandedCostMethod',
		'landedCostPerLine' => 'boolean',
		'itemList' => 'ItemReceiptItemList',
		'expenseList' => 'ItemReceiptExpenseList',
		'landedCostsList' => 'PurchLandedCostList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
