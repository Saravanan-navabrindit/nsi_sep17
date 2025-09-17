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

class VendorSubsidiaryRelationshipSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $balancebase;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $baseCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $creditlimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $inTransitBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $inTransitBalanceBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isprimarysub;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $primaryCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxitem;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unbilledorders;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unbilledordersbase;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'balance' => 'SearchColumnDoubleField[]',
		'balancebase' => 'SearchColumnDoubleField[]',
		'baseCurrency' => 'SearchColumnSelectField[]',
		'creditlimit' => 'SearchColumnDoubleField[]',
		'entity' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'inTransitBalance' => 'SearchColumnDoubleField[]',
		'inTransitBalanceBase' => 'SearchColumnDoubleField[]',
		'isprimarysub' => 'SearchColumnBooleanField[]',
		'primaryCurrency' => 'SearchColumnSelectField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'taxitem' => 'SearchColumnSelectField[]',
		'unbilledorders' => 'SearchColumnDoubleField[]',
		'unbilledordersbase' => 'SearchColumnDoubleField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
