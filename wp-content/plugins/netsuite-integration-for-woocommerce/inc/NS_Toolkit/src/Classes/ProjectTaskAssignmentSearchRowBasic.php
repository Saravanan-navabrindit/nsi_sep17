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

class ProjectTaskAssignmentSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $actualWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $grossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $grossProfitBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $price;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $priceBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $resource;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $resourceName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serviceItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serviceItemDesc;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitCostBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitPriceBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $workCalendar;
	public static $paramtypesmap = array(
		'actualWork' => 'SearchColumnDoubleField[]',
		'cost' => 'SearchColumnDoubleField[]',
		'costBase' => 'SearchColumnDoubleField[]',
		'endDate' => 'SearchColumnDateField[]',
		'estimatedWork' => 'SearchColumnDoubleField[]',
		'estimatedWorkBaseline' => 'SearchColumnDoubleField[]',
		'grossProfit' => 'SearchColumnDoubleField[]',
		'grossProfitBase' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'plannedWork' => 'SearchColumnDoubleField[]',
		'plannedWorkBaseline' => 'SearchColumnDoubleField[]',
		'price' => 'SearchColumnDoubleField[]',
		'priceBase' => 'SearchColumnDoubleField[]',
		'resource' => 'SearchColumnSelectField[]',
		'resourceName' => 'SearchColumnStringField[]',
		'serviceItem' => 'SearchColumnStringField[]',
		'serviceItemDesc' => 'SearchColumnStringField[]',
		'startDate' => 'SearchColumnDateField[]',
		'unitCost' => 'SearchColumnDoubleField[]',
		'unitCostBase' => 'SearchColumnDoubleField[]',
		'unitPrice' => 'SearchColumnDoubleField[]',
		'unitPriceBase' => 'SearchColumnDoubleField[]',
		'units' => 'SearchColumnDoubleField[]',
		'workCalendar' => 'SearchColumnSelectField[]',
	);
}
