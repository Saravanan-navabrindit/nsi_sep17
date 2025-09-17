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

class ItemDemandPlanSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $alternateSourceItem;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $analysisDuration;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $demandDate;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $projectionDuration;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $projectionInterval;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $projectionMethod;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $projectionStartDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'alternateSourceItem' => 'SearchMultiSelectField',
		'analysisDuration' => 'SearchLongField',
		'demandDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'item' => 'SearchMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'location' => 'SearchMultiSelectField',
		'memo' => 'SearchStringField',
		'projectionDuration' => 'SearchLongField',
		'projectionInterval' => 'SearchMultiSelectField',
		'projectionMethod' => 'SearchEnumMultiSelectField',
		'projectionStartDate' => 'SearchDateField',
		'quantity' => 'SearchDoubleField',
		'subsidiary' => 'SearchMultiSelectField',
		'units' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
