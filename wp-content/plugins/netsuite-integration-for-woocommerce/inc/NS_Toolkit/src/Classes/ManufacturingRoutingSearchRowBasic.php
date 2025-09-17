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

class ManufacturingRoutingSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $autoCalculateLag;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billOfMaterials;
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
	public $isDefault;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $lagAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $lagType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $lagUnits;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $manufacturingCostTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $manufacturingWorkCenter;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $operationName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $operationYield;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $runRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $sequence;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $setupTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'autoCalculateLag' => 'SearchColumnBooleanField[]',
		'billOfMaterials' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isDefault' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'item' => 'SearchColumnSelectField[]',
		'lagAmount' => 'SearchColumnDoubleField[]',
		'lagType' => 'SearchColumnEnumSelectField[]',
		'lagUnits' => 'SearchColumnStringField[]',
		'location' => 'SearchColumnSelectField[]',
		'manufacturingCostTemplate' => 'SearchColumnSelectField[]',
		'manufacturingWorkCenter' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'operationName' => 'SearchColumnStringField[]',
		'operationYield' => 'SearchColumnDoubleField[]',
		'runRate' => 'SearchColumnDoubleField[]',
		'sequence' => 'SearchColumnLongField[]',
		'setupTime' => 'SearchColumnDoubleField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
