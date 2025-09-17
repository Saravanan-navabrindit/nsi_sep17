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

class ManufacturingOperationTaskSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $actualRunTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $actualSetupTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $completedQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $inputQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $laborResources;
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
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $machineResources;
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
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $order;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $predecessor;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $predecessorType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $remainingQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $runRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $runTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $sequence;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $setupTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $workOrder;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualRunTime' => 'SearchColumnDoubleField[]',
		'actualSetupTime' => 'SearchColumnDoubleField[]',
		'completedQuantity' => 'SearchColumnDoubleField[]',
		'endDate' => 'SearchColumnDateField[]',
		'estimatedWork' => 'SearchColumnDoubleField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'id' => 'SearchColumnLongField[]',
		'inputQuantity' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'laborResources' => 'SearchColumnDoubleField[]',
		'lagAmount' => 'SearchColumnDoubleField[]',
		'lagType' => 'SearchColumnEnumSelectField[]',
		'lagUnits' => 'SearchColumnStringField[]',
		'machineResources' => 'SearchColumnDoubleField[]',
		'manufacturingCostTemplate' => 'SearchColumnSelectField[]',
		'manufacturingWorkCenter' => 'SearchColumnSelectField[]',
		'message' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'order' => 'SearchColumnDoubleField[]',
		'predecessor' => 'SearchColumnSelectField[]',
		'predecessorType' => 'SearchColumnStringField[]',
		'remainingQuantity' => 'SearchColumnDoubleField[]',
		'runRate' => 'SearchColumnDoubleField[]',
		'runTime' => 'SearchColumnDoubleField[]',
		'sequence' => 'SearchColumnLongField[]',
		'setupTime' => 'SearchColumnDoubleField[]',
		'startDate' => 'SearchColumnDateField[]',
		'status' => 'SearchColumnSelectField[]',
		'workOrder' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
