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

class ItemFulfillmentItem {
	/**
	 * Var string
	 */
	public $jobName;
	/**
	 * Var boolean
	 */
	public $itemReceive;
	/**
	 * Var string
	 */
	public $itemName;
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
	 * Var float
	 */
	public $onHand;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var string
	 */
	public $unitsDisplay;
	/**
	 * Var string
	 */
	public $createPo;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $binNumbers;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var string
	 */
	public $poNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $orderLine;
	/**
	 * Var float
	 */
	public $quantityRemaining;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var integer
	 */
	public $shipGroup;
	/**
	 * Var boolean
	 */
	public $itemIsFulfilled;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'jobName' => 'string',
		'itemReceive' => 'boolean',
		'itemName' => 'string',
		'description' => 'string',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'onHand' => 'float',
		'quantity' => 'float',
		'unitsDisplay' => 'string',
		'createPo' => 'string',
		'inventoryDetail' => 'InventoryDetail',
		'binNumbers' => 'string',
		'serialNumbers' => 'string',
		'poNum' => 'string',
		'item' => 'RecordRef',
		'orderLine' => 'integer',
		'quantityRemaining' => 'float',
		'options' => 'CustomFieldList',
		'shipGroup' => 'integer',
		'itemIsFulfilled' => 'boolean',
		'shipAddress' => 'RecordRef',
		'shipMethod' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
