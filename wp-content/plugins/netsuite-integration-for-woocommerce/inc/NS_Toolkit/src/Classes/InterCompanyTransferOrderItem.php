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

class InterCompanyTransferOrderItem {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $quantityBackOrdered;
	/**
	 * Var float
	 */
	public $quantityCommitted;
	/**
	 * Var float
	 */
	public $quantityFulfilled;
	/**
	 * Var float
	 */
	public $quantityReceived;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var \NetSuite\Classes\TransferOrderItemCommitInventory
	 */
	public $commitInventory;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var float
	 */
	public $lastPurchasePrice;
	/**
	 * Var float
	 */
	public $averageCost;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'line' => 'integer',
		'quantityAvailable' => 'float',
		'quantityOnHand' => 'float',
		'quantityBackOrdered' => 'float',
		'quantityCommitted' => 'float',
		'quantityFulfilled' => 'float',
		'quantityReceived' => 'float',
		'quantity' => 'float',
		'rate' => 'float',
		'units' => 'RecordRef',
		'amount' => 'float',
		'description' => 'string',
		'inventoryDetail' => 'InventoryDetail',
		'commitInventory' => 'TransferOrderItemCommitInventory',
		'options' => 'CustomFieldList',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'lastPurchasePrice' => 'float',
		'averageCost' => 'float',
		'customFieldList' => 'CustomFieldList',
	);
}
