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

class ExpenseCategory extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expenseAcct;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $rateRequired;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var float
	 */
	public $defaultRate;
	/**
	 * Var \NetSuite\Classes\ExpenseCategoryRatesList
	 */
	public $ratesList;
	/**
	 * Var \NetSuite\Classes\TranslationList
	 */
	public $translationsList;
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
		'name' => 'string',
		'description' => 'string',
		'expenseAcct' => 'RecordRef',
		'isInactive' => 'boolean',
		'rateRequired' => 'boolean',
		'subsidiaryList' => 'RecordRefList',
		'defaultRate' => 'float',
		'ratesList' => 'ExpenseCategoryRatesList',
		'translationsList' => 'TranslationList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
