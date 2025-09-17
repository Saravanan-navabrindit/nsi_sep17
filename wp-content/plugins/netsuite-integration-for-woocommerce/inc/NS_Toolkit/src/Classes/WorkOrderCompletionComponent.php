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

class WorkOrderCompletionComponent {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $operationSequenceNumber;
	/**
	 * Var float
	 */
	public $quantityPer;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $componentInventoryDetail;
	/**
	 * Var integer
	 */
	public $lineNumber;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'operationSequenceNumber' => 'integer',
		'quantityPer' => 'float',
		'quantity' => 'float',
		'componentInventoryDetail' => 'InventoryDetail',
		'lineNumber' => 'integer',
	);
}
