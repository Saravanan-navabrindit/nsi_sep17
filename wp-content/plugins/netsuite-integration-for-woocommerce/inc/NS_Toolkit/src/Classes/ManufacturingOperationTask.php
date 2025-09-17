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

class ManufacturingOperationTask extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $manufacturingWorkCenter;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $manufacturingCostTemplate;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var integer
	 */
	public $operationSequence;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workOrder;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $order;
	/**
	 * Var \NetSuite\Classes\ManufacturingOperationTaskStatus
	 */
	public $status;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var float
	 */
	public $estimatedWork;
	/**
	 * Var float
	 */
	public $actualWork;
	/**
	 * Var float
	 */
	public $remainingWork;
	/**
	 * Var float
	 */
	public $inputQuantity;
	/**
	 * Var float
	 */
	public $completedQuantity;
	/**
	 * Var float
	 */
	public $setupTime;
	/**
	 * Var float
	 */
	public $runRate;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var boolean
	 */
	public $autoCalculateLag;
	/**
	 * Var float
	 */
	public $machineResources;
	/**
	 * Var float
	 */
	public $laborResources;
	/**
	 * Var \NetSuite\Classes\ManufacturingCostDetailList
	 */
	public $costDetailList;
	/**
	 * Var \NetSuite\Classes\ManufacturingOperationTaskPredecessorList
	 */
	public $predecessorList;
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
		'manufacturingWorkCenter' => 'RecordRef',
		'manufacturingCostTemplate' => 'RecordRef',
		'title' => 'string',
		'operationSequence' => 'integer',
		'workOrder' => 'RecordRef',
		'order' => 'RecordRef',
		'status' => 'ManufacturingOperationTaskStatus',
		'message' => 'string',
		'estimatedWork' => 'float',
		'actualWork' => 'float',
		'remainingWork' => 'float',
		'inputQuantity' => 'float',
		'completedQuantity' => 'float',
		'setupTime' => 'float',
		'runRate' => 'float',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'autoCalculateLag' => 'boolean',
		'machineResources' => 'float',
		'laborResources' => 'float',
		'costDetailList' => 'ManufacturingCostDetailList',
		'predecessorList' => 'ManufacturingOperationTaskPredecessorList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
