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

class InventoryAdjustmentInventory {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $currentValue;
	/**
	 * Var float
	 */
	public $adjustQtyBy;
	/**
	 * Var string
	 */
	public $binNumbers;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var float
	 */
	public $newQuantity;
	/**
	 * Var float
	 */
	public $unitCost;
	/**
	 * Var float
	 */
	public $foreignCurrencyUnitCost;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var string
	 */
	public $currency;
	/**
	 * Var string
	 */
	public $expirationDate;
	/**
	 * Var float
	 */
	public $exchangeRate;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'line' => 'integer',
		'inventoryDetail' => 'InventoryDetail',
		'description' => 'string',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'units' => 'RecordRef',
		'quantityOnHand' => 'float',
		'currentValue' => 'float',
		'adjustQtyBy' => 'float',
		'binNumbers' => 'string',
		'serialNumbers' => 'string',
		'newQuantity' => 'float',
		'unitCost' => 'float',
		'foreignCurrencyUnitCost' => 'float',
		'memo' => 'string',
		'currency' => 'string',
		'expirationDate' => 'dateTime',
		'exchangeRate' => 'float',
	);
}
