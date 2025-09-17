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

class WorkOrderCompletionOperation {
	/**
	 * Var integer
	 */
	public $operationSequence;
	/**
	 * Var string
	 */
	public $operationName;
	/**
	 * Var string
	 */
	public $workCenter;
	/**
	 * Var float
	 */
	public $machineResources;
	/**
	 * Var float
	 */
	public $laborResources;
	/**
	 * Var float
	 */
	public $inputQuantity;
	/**
	 * Var float
	 */
	public $quantityRemaining;
	/**
	 * Var float
	 */
	public $predecessorCompletedQuantity;
	/**
	 * Var float
	 */
	public $completedQuantity;
	/**
	 * Var boolean
	 */
	public $recordSetup;
	/**
	 * Var float
	 */
	public $machineSetupTime;
	/**
	 * Var float
	 */
	public $laborSetupTime;
	/**
	 * Var float
	 */
	public $machineRunTime;
	/**
	 * Var float
	 */
	public $laborRunTime;
	public static $paramtypesmap = array(
		'operationSequence' => 'integer',
		'operationName' => 'string',
		'workCenter' => 'string',
		'machineResources' => 'float',
		'laborResources' => 'float',
		'inputQuantity' => 'float',
		'quantityRemaining' => 'float',
		'predecessorCompletedQuantity' => 'float',
		'completedQuantity' => 'float',
		'recordSetup' => 'boolean',
		'machineSetupTime' => 'float',
		'laborSetupTime' => 'float',
		'machineRunTime' => 'float',
		'laborRunTime' => 'float',
	);
}
