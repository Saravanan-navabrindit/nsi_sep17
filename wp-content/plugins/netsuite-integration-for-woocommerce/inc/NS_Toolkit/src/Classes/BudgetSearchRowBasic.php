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

class BudgetSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $classnohierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $departmentnohierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $global;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $locationnohierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $subsidiarynohierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $year;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $year2;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'account' => 'SearchColumnStringField[]',
		'accountingBook' => 'SearchColumnStringField[]',
		'amount' => 'SearchColumnDoubleField[]',
		'category' => 'SearchColumnStringField[]',
		'class' => 'SearchColumnStringField[]',
		'classnohierarchy' => 'SearchColumnStringField[]',
		'currency' => 'SearchColumnStringField[]',
		'customer' => 'SearchColumnStringField[]',
		'department' => 'SearchColumnStringField[]',
		'departmentnohierarchy' => 'SearchColumnStringField[]',
		'global' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnStringField[]',
		'location' => 'SearchColumnStringField[]',
		'locationnohierarchy' => 'SearchColumnStringField[]',
		'subsidiary' => 'SearchColumnStringField[]',
		'subsidiarynohierarchy' => 'SearchColumnStringField[]',
		'year' => 'SearchColumnStringField[]',
		'year2' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
