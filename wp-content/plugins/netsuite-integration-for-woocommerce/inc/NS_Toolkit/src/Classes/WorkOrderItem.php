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

class WorkOrderItem {
	/**
	 * Var integer
	 */
	public $line;
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
	public $componentYield;
	/**
	 * Var float
	 */
	public $bomQuantity;
	/**
	 * Var float
	 */
	public $quantityCommitted;
	/**
	 * Var float
	 */
	public $quantityBackOrdered;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var float
	 */
	public $averageCost;
	/**
	 * Var float
	 */
	public $lastPurchasePrice;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var float
	 */
	public $orderPriority;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var \NetSuite\Classes\ItemSource
	 */
	public $itemSource;
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
	public $poVendor;
	/**
	 * Var float
	 */
	public $poRate;
	/**
	 * Var float
	 */
	public $percentComplete;
	/**
	 * Var float
	 */
	public $contribution;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\WorkOrderItemItemCommitInventory
	 */
	public $commitInventory;
	/**
	 * Var string
	 */
	public $plannedIssueDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $orderAllocationStrategy;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'line' => 'integer',
		'item' => 'RecordRef',
		'operationSequenceNumber' => 'integer',
		'componentYield' => 'float',
		'bomQuantity' => 'float',
		'quantityCommitted' => 'float',
		'quantityBackOrdered' => 'float',
		'quantityAvailable' => 'float',
		'averageCost' => 'float',
		'lastPurchasePrice' => 'float',
		'quantityOnHand' => 'float',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbers' => 'string',
		'orderPriority' => 'float',
		'options' => 'CustomFieldList',
		'itemSource' => 'ItemSource',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'poVendor' => 'RecordRef',
		'poRate' => 'float',
		'percentComplete' => 'float',
		'contribution' => 'float',
		'description' => 'string',
		'commitInventory' => 'WorkOrderItemItemCommitInventory',
		'plannedIssueDate' => 'dateTime',
		'orderAllocationStrategy' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
