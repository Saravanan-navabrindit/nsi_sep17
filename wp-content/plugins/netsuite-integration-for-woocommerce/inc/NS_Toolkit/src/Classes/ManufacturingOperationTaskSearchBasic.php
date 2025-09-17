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

class ManufacturingOperationTaskSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $actualRunTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $actualSetupTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $completedQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWork;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $inputQuantity;
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
	public $laborResources;
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
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $machineResources;
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
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $order;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $predecessor;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $remainingQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $runRate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $runTime;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $sequence;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $setupTime;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $workOrder;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualRunTime' => 'SearchDoubleField',
		'actualSetupTime' => 'SearchDoubleField',
		'completedQuantity' => 'SearchDoubleField',
		'endDate' => 'SearchDateField',
		'estimatedWork' => 'SearchDoubleField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'id' => 'SearchLongField',
		'inputQuantity' => 'SearchDoubleField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'laborResources' => 'SearchDoubleField',
		'lagAmount' => 'SearchDoubleField',
		'lagType' => 'SearchEnumMultiSelectField',
		'lagUnits' => 'SearchStringField',
		'machineResources' => 'SearchDoubleField',
		'manufacturingCostTemplate' => 'SearchMultiSelectField',
		'manufacturingWorkCenter' => 'SearchMultiSelectField',
		'name' => 'SearchStringField',
		'order' => 'SearchDoubleField',
		'predecessor' => 'SearchMultiSelectField',
		'remainingQuantity' => 'SearchDoubleField',
		'runRate' => 'SearchDoubleField',
		'runTime' => 'SearchDoubleField',
		'sequence' => 'SearchLongField',
		'setupTime' => 'SearchDoubleField',
		'startDate' => 'SearchDateField',
		'status' => 'SearchMultiSelectField',
		'workOrder' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
