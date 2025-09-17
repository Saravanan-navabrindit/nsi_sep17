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

class VendorSubsidiaryRelationshipSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $balanceBase;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $baseCurrency;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $creditLimit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $inTransitBalance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $inTransitBalanceBase;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPrimarySub;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $primaryCurrency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxItem;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unbilledOrdersBase;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'balance' => 'SearchDoubleField',
		'balanceBase' => 'SearchDoubleField',
		'baseCurrency' => 'SearchMultiSelectField',
		'creditLimit' => 'SearchDoubleField',
		'entity' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'inTransitBalance' => 'SearchDoubleField',
		'inTransitBalanceBase' => 'SearchDoubleField',
		'isPrimarySub' => 'SearchBooleanField',
		'primaryCurrency' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'taxItem' => 'SearchMultiSelectField',
		'unbilledOrders' => 'SearchDoubleField',
		'unbilledOrdersBase' => 'SearchDoubleField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
