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

require_once 'SearchRecordBasic.php';

class AccountSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingContext;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $cashFlowRateType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $category1099Misc;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $displayName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $generalRateType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $legalName;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locale;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $localizedLegalName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $localizedName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $localizedNumber;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountingContext' => 'SearchMultiSelectField',
		'balance' => 'SearchDoubleField',
		'cashFlowRateType' => 'SearchEnumMultiSelectField',
		'category1099Misc' => 'SearchMultiSelectField',
		'description' => 'SearchStringField',
		'displayName' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'generalRateType' => 'SearchEnumMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'legalName' => 'SearchStringField',
		'locale' => 'SearchEnumMultiSelectField',
		'localizedLegalName' => 'SearchStringField',
		'localizedName' => 'SearchStringField',
		'localizedNumber' => 'SearchStringField',
		'name' => 'SearchStringField',
		'number' => 'SearchStringField',
		'parent' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'type' => 'SearchEnumMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
