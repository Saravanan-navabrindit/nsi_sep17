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

class UnitsTypeSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $abbreviation;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $baseUnit;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $conversionRate;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInActive;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $pluralAbbreviation;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $pluralName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $unitName;
	public static $paramtypesmap = array(
		'abbreviation' => 'SearchStringField',
		'baseUnit' => 'SearchBooleanField',
		'conversionRate' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInActive' => 'SearchBooleanField',
		'name' => 'SearchStringField',
		'pluralAbbreviation' => 'SearchStringField',
		'pluralName' => 'SearchStringField',
		'unitName' => 'SearchStringField',
	);
}
