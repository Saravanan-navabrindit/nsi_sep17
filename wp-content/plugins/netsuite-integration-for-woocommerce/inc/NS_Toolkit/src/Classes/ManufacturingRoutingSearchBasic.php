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

class ManufacturingRoutingSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $autoCalculateLag;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billOfMaterials;
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
	public $isDefault;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $lagAmount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $lagType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $lagUnits;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $manufacturingCostTemplate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $manufacturingWorkCenter;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $operationName;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $operationYield;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $runRate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $sequence;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $setupTime;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'autoCalculateLag' => 'SearchBooleanField',
		'billOfMaterials' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isDefault' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'lagAmount' => 'SearchDoubleField',
		'lagType' => 'SearchEnumMultiSelectField',
		'lagUnits' => 'SearchStringField',
		'location' => 'SearchMultiSelectField',
		'manufacturingCostTemplate' => 'SearchMultiSelectField',
		'manufacturingWorkCenter' => 'SearchMultiSelectField',
		'memo' => 'SearchStringField',
		'name' => 'SearchStringField',
		'operationName' => 'SearchStringField',
		'operationYield' => 'SearchDoubleField',
		'runRate' => 'SearchDoubleField',
		'sequence' => 'SearchLongField',
		'setupTime' => 'SearchDoubleField',
		'subsidiary' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
