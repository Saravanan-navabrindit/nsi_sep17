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

require_once 'Record.php';
class Account extends Record {
	/**
	 * Var \NetSuite\Classes\AccountType
	 */
	public $acctType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unit;
	/**
	 * Var string
	 */
	public $acctNumber;
	/**
	 * Var string
	 */
	public $acctName;
	/**
	 * Var string
	 */
	public $legalName;
	/**
	 * Var boolean
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var string
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\ConsolidatedRate
	 */
	public $generalRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\ConsolidatedRate
	 */
	public $cashFlowRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billableExpensesAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $deferralAcct;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var integer
	 */
	public $curDocNum;
	/**
	 * Var boolean
	 */
	public $isInactive;
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
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $restrictToAccountingBookList;
	/**
	 * Var boolean
	 */
	public $inventory;
	/**
	 * Var boolean
	 */
	public $eliminate;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category1099misc;
	/**
	 * Var \NetSuite\Classes\AccountLocalizationsList
	 */
	public $localizationsList;
	/**
	 * Var float
	 */
	public $openingBalance;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var boolean
	 */
	public $revalue;
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
		'acctType' => 'AccountType',
		'unitsType' => 'RecordRef',
		'unit' => 'RecordRef',
		'acctNumber' => 'string',
		'acctName' => 'string',
		'legalName' => 'string',
		'includeChildren' => 'boolean',
		'currency' => 'RecordRef',
		'exchangeRate' => 'string',
		'generalRate' => 'ConsolidatedRate',
		'parent' => 'RecordRef',
		'cashFlowRate' => 'ConsolidatedRate',
		'billableExpensesAcct' => 'RecordRef',
		'deferralAcct' => 'RecordRef',
		'description' => 'string',
		'curDocNum' => 'integer',
		'isInactive' => 'boolean',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'restrictToAccountingBookList' => 'RecordRefList',
		'inventory' => 'boolean',
		'eliminate' => 'boolean',
		'subsidiaryList' => 'RecordRefList',
		'category1099misc' => 'RecordRef',
		'localizationsList' => 'AccountLocalizationsList',
		'openingBalance' => 'float',
		'tranDate' => 'dateTime',
		'revalue' => 'boolean',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
