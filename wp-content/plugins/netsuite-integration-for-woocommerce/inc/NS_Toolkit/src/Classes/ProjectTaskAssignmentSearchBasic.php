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

class ProjectTaskAssignmentSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $actualWork;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costBase;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWork;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $grossProfit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $grossProfitBase;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $price;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $priceBase;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $resource;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $resourceName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $serviceItem;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $serviceItemDesc;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unitCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unitCostBase;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unitPrice;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unitPriceBase;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $workCalendar;
	public static $paramtypesmap = array(
		'actualWork' => 'SearchDoubleField',
		'cost' => 'SearchDoubleField',
		'costBase' => 'SearchDoubleField',
		'endDate' => 'SearchDateField',
		'estimatedWork' => 'SearchDoubleField',
		'estimatedWorkBaseline' => 'SearchDoubleField',
		'grossProfit' => 'SearchDoubleField',
		'grossProfitBase' => 'SearchDoubleField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'plannedWork' => 'SearchDoubleField',
		'plannedWorkBaseline' => 'SearchDoubleField',
		'price' => 'SearchDoubleField',
		'priceBase' => 'SearchDoubleField',
		'resource' => 'SearchMultiSelectField',
		'resourceName' => 'SearchStringField',
		'serviceItem' => 'SearchStringField',
		'serviceItemDesc' => 'SearchStringField',
		'startDate' => 'SearchDateField',
		'unitCost' => 'SearchDoubleField',
		'unitCostBase' => 'SearchDoubleField',
		'unitPrice' => 'SearchDoubleField',
		'unitPriceBase' => 'SearchDoubleField',
		'units' => 'SearchDoubleField',
		'workCalendar' => 'SearchMultiSelectField',
	);
}
