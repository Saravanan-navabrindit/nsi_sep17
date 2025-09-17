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

class InventoryAssignment {
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueInventoryNumber;
	/**
	 * Var string
	 */
	public $receiptInventoryNumber;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $binNumber;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $toBinNumber;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var string
	 */
	public $expirationDate;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $inventoryStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $toInventoryStatus;
	public static $paramtypesmap = array(
		'internalId' => 'string',
		'issueInventoryNumber' => 'RecordRef',
		'receiptInventoryNumber' => 'string',
		'binNumber' => 'RecordRef',
		'toBinNumber' => 'RecordRef',
		'quantity' => 'float',
		'expirationDate' => 'dateTime',
		'quantityAvailable' => 'float',
		'inventoryStatus' => 'RecordRef',
		'toInventoryStatus' => 'RecordRef',
	);
}
