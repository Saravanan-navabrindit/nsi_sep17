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

class BomSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $availableForAllAssemblies;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $availableForAllLocations;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $includeChildren;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $legacyBomForAssembly;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $restrictToAssemblies;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $restrictToLocations;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useComponentYield;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $usedOnAssembly;
	public static $paramtypesmap = array(
		'availableForAllAssemblies' => 'SearchBooleanField',
		'availableForAllLocations' => 'SearchBooleanField',
		'createdDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'includeChildren' => 'SearchBooleanField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'legacyBomForAssembly' => 'SearchMultiSelectField',
		'memo' => 'SearchStringField',
		'name' => 'SearchStringField',
		'restrictToAssemblies' => 'SearchMultiSelectField',
		'restrictToLocations' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'useComponentYield' => 'SearchBooleanField',
		'usedOnAssembly' => 'SearchBooleanField',
	);
}
