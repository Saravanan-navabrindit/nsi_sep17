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

require_once 'SearchRowBasic.php';


class AccountSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accountingContext;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $cashFlowRateType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $category1099Misc;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $displayName;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $generalRateType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $legalName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $locale;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $localizedLegalName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $localizedName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $localizedNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountingContext' => 'SearchColumnStringField[]',
		'balance' => 'SearchColumnDoubleField[]',
		'cashFlowRateType' => 'SearchColumnEnumSelectField[]',
		'category1099Misc' => 'SearchColumnSelectField[]',
		'description' => 'SearchColumnStringField[]',
		'displayName' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'generalRateType' => 'SearchColumnEnumSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'legalName' => 'SearchColumnStringField[]',
		'locale' => 'SearchColumnStringField[]',
		'localizedLegalName' => 'SearchColumnStringField[]',
		'localizedName' => 'SearchColumnStringField[]',
		'localizedNumber' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'number' => 'SearchColumnStringField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'type' => 'SearchColumnEnumSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
