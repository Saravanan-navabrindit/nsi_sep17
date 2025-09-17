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

class UnitsTypeSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $abbreviation;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $baseUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $conversionRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInActive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pluralAbbreviation;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pluralName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $unitName;
	public static $paramtypesmap = array(
		'abbreviation' => 'SearchColumnStringField[]',
		'baseUnit' => 'SearchColumnBooleanField[]',
		'conversionRate' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInActive' => 'SearchColumnBooleanField[]',
		'name' => 'SearchColumnStringField[]',
		'pluralAbbreviation' => 'SearchColumnStringField[]',
		'pluralName' => 'SearchColumnStringField[]',
		'unitName' => 'SearchColumnStringField[]',
	);
}
