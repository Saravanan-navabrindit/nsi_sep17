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

class ManufacturingRoutingRoutingStep {
	/**
	 * Var integer
	 */
	public $operationSequence;
	/**
	 * Var string
	 */
	public $operationName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $manufacturingWorkCenter;
	/**
	 * Var float
	 */
	public $machineResources;
	/**
	 * Var float
	 */
	public $laborResources;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $manufacturingCostTemplate;
	/**
	 * Var float
	 */
	public $setupTime;
	/**
	 * Var float
	 */
	public $runRate;
	/**
	 * Var \NetSuite\Classes\ManufacturingLagType
	 */
	public $lagType;
	/**
	 * Var integer
	 */
	public $lagAmount;
	/**
	 * Var string
	 */
	public $lagUnits;
	public static $paramtypesmap = array(
		'operationSequence' => 'integer',
		'operationName' => 'string',
		'manufacturingWorkCenter' => 'RecordRef',
		'machineResources' => 'float',
		'laborResources' => 'float',
		'manufacturingCostTemplate' => 'RecordRef',
		'setupTime' => 'float',
		'runRate' => 'float',
		'lagType' => 'ManufacturingLagType',
		'lagAmount' => 'integer',
		'lagUnits' => 'string',
	);
}
