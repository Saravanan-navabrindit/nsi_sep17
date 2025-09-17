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

class ManufacturingRoutingRoutingComponent {
	/**
	 * Var string
	 */
	public $itemName;
	/**
	 * Var string
	 */
	public $revision;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var float
	 */
	public $yield;
	/**
	 * Var float
	 */
	public $bomQuantity;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var string
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $operationDisplayText;
	/**
	 * Var integer
	 */
	public $operationSequenceNumber;
	/**
	 * Var string
	 */
	public $component;
	/**
	 * Var string
	 */
	public $item;
	public static $paramtypesmap = array(
		'itemName' => 'string',
		'revision' => 'string',
		'description' => 'string',
		'yield' => 'float',
		'bomQuantity' => 'float',
		'quantity' => 'float',
		'units' => 'string',
		'operationDisplayText' => 'RecordRef',
		'operationSequenceNumber' => 'integer',
		'component' => 'string',
		'item' => 'string',
	);
}
