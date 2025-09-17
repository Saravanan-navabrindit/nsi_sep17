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

class ProjectTaskAssignee {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $resource;
	/**
	 * Var float
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $serviceItem;
	/**
	 * Var float
	 */
	public $estimatedWork;
	/**
	 * Var float
	 */
	public $unitCost;
	/**
	 * Var float
	 */
	public $unitPrice;
	/**
	 * Var float
	 */
	public $cost;
	/**
	 * Var float
	 */
	public $price;
	/**
	 * Var float
	 */
	public $plannedWork;
	public static $paramtypesmap = array(
		'resource' => 'RecordRef',
		'units' => 'float',
		'serviceItem' => 'RecordRef',
		'estimatedWork' => 'float',
		'unitCost' => 'float',
		'unitPrice' => 'float',
		'cost' => 'float',
		'price' => 'float',
		'plannedWork' => 'float',
	);
}
