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

class Bom extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var boolean
	 */
	public $usedOnAssembly;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $useComponentYield;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $legacyBomForAssembly;
	/**
	 * Var boolean
	 */
	public $availableForAllAssemblies;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $restrictToAssembliesList;
	/**
	 * Var boolean
	 */
	public $availableForAllLocations;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $restrictToLocationsList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var boolean
	 */
	public $includeChildren;
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
		'usedOnAssembly' => 'boolean',
		'createdDate' => 'dateTime',
		'isInactive' => 'boolean',
		'useComponentYield' => 'boolean',
		'memo' => 'string',
		'legacyBomForAssembly' => 'RecordRef',
		'availableForAllAssemblies' => 'boolean',
		'restrictToAssembliesList' => 'RecordRefList',
		'availableForAllLocations' => 'boolean',
		'restrictToLocationsList' => 'RecordRefList',
		'subsidiaryList' => 'RecordRefList',
		'includeChildren' => 'boolean',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
