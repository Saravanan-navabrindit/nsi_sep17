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

class ItemDemandPlanSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $alternateSourceItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $analysisDuration;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $demandDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $projectionDuration;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $projectionInterval;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $projectionMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $projectionStartDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityUom;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'alternateSourceItem' => 'SearchColumnSelectField[]',
		'analysisDuration' => 'SearchColumnLongField[]',
		'demandDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'location' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'projectionDuration' => 'SearchColumnLongField[]',
		'projectionInterval' => 'SearchColumnStringField[]',
		'projectionMethod' => 'SearchColumnStringField[]',
		'projectionStartDate' => 'SearchColumnDateField[]',
		'quantity' => 'SearchColumnDoubleField[]',
		'quantityUom' => 'SearchColumnDoubleField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'units' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
