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

class Budget extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $year;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
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
	public $account;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\BudgetBudgetType
	 */
	public $budgetType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $periodAmount1;
	/**
	 * Var float
	 */
	public $periodAmount2;
	/**
	 * Var float
	 */
	public $periodAmount3;
	/**
	 * Var float
	 */
	public $periodAmount4;
	/**
	 * Var float
	 */
	public $periodAmount5;
	/**
	 * Var float
	 */
	public $periodAmount6;
	/**
	 * Var float
	 */
	public $periodAmount7;
	/**
	 * Var float
	 */
	public $periodAmount8;
	/**
	 * Var float
	 */
	public $periodAmount9;
	/**
	 * Var float
	 */
	public $periodAmount10;
	/**
	 * Var float
	 */
	public $periodAmount11;
	/**
	 * Var float
	 */
	public $periodAmount12;
	/**
	 * Var float
	 */
	public $periodAmount13;
	/**
	 * Var float
	 */
	public $periodAmount14;
	/**
	 * Var float
	 */
	public $periodAmount15;
	/**
	 * Var float
	 */
	public $periodAmount16;
	/**
	 * Var float
	 */
	public $periodAmount17;
	/**
	 * Var float
	 */
	public $periodAmount18;
	/**
	 * Var float
	 */
	public $periodAmount19;
	/**
	 * Var float
	 */
	public $periodAmount20;
	/**
	 * Var float
	 */
	public $periodAmount21;
	/**
	 * Var float
	 */
	public $periodAmount22;
	/**
	 * Var float
	 */
	public $periodAmount23;
	/**
	 * Var float
	 */
	public $periodAmount24;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	public static $paramtypesmap = array(
		'year' => 'RecordRef',
		'customer' => 'RecordRef',
		'item' => 'RecordRef',
		'class' => 'RecordRef',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'account' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'category' => 'RecordRef',
		'budgetType' => 'BudgetBudgetType',
		'currency' => 'RecordRef',
		'periodAmount1' => 'float',
		'periodAmount2' => 'float',
		'periodAmount3' => 'float',
		'periodAmount4' => 'float',
		'periodAmount5' => 'float',
		'periodAmount6' => 'float',
		'periodAmount7' => 'float',
		'periodAmount8' => 'float',
		'periodAmount9' => 'float',
		'periodAmount10' => 'float',
		'periodAmount11' => 'float',
		'periodAmount12' => 'float',
		'periodAmount13' => 'float',
		'periodAmount14' => 'float',
		'periodAmount15' => 'float',
		'periodAmount16' => 'float',
		'periodAmount17' => 'float',
		'periodAmount18' => 'float',
		'periodAmount19' => 'float',
		'periodAmount20' => 'float',
		'periodAmount21' => 'float',
		'periodAmount22' => 'float',
		'periodAmount23' => 'float',
		'periodAmount24' => 'float',
		'amount' => 'float',
		'accountingBook' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
	);
}
