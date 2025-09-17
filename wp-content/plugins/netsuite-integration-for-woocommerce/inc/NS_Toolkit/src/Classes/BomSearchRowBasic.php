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

class BomSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableForAllAssemblies;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableForAllLocations;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $legacyBomForAssembly;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $restrictToAssemblies;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $restrictToLocations;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $revisionName;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiaryNoHierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useComponentYield;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $usedOnAssembly;
	public static $paramtypesmap = array(
		'availableForAllAssemblies' => 'SearchColumnBooleanField[]',
		'availableForAllLocations' => 'SearchColumnBooleanField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'includeChildren' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'legacyBomForAssembly' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'restrictToAssemblies' => 'SearchColumnSelectField[]',
		'restrictToLocations' => 'SearchColumnSelectField[]',
		'revisionName' => 'SearchColumnStringField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'subsidiaryNoHierarchy' => 'SearchColumnSelectField[]',
		'useComponentYield' => 'SearchColumnBooleanField[]',
		'usedOnAssembly' => 'SearchColumnBooleanField[]',
	);
}
