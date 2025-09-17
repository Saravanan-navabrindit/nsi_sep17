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

class ItemReceiptItem {
	/**
	 * Var boolean
	 */
	public $itemReceive;
	/**
	 * Var string
	 */
	public $jobName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $orderLine;
	/**
	 * Var integer
	 */
	public $line;
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
	public $location;
	/**
	 * Var float
	 */
	public $onHand;
	/**
	 * Var float
	 */
	public $quantityRemaining;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var string
	 */
	public $unitsDisplay;
	/**
	 * Var float
	 */
	public $unitCostOverride;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var string
	 */
	public $binNumbers;
	/**
	 * Var string
	 */
	public $expirationDate;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var string
	 */
	public $currency;
	/**
	 * Var boolean
	 */
	public $restock;
	/**
	 * Var \NetSuite\Classes\TransactionBillVarianceStatus
	 */
	public $billVarianceStatus;
	/**
	 * Var boolean
	 */
	public $isDropShipment;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var \NetSuite\Classes\LandedCost
	 */
	public $landedCost;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'itemReceive' => 'boolean',
		'jobName' => 'string',
		'item' => 'RecordRef',
		'orderLine' => 'integer',
		'line' => 'integer',
		'itemName' => 'string',
		'description' => 'string',
		'location' => 'RecordRef',
		'onHand' => 'float',
		'quantityRemaining' => 'float',
		'quantity' => 'float',
		'unitsDisplay' => 'string',
		'unitCostOverride' => 'float',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbers' => 'string',
		'binNumbers' => 'string',
		'expirationDate' => 'dateTime',
		'rate' => 'string',
		'currency' => 'string',
		'restock' => 'boolean',
		'billVarianceStatus' => 'TransactionBillVarianceStatus',
		'isDropShipment' => 'boolean',
		'options' => 'CustomFieldList',
		'landedCost' => 'LandedCost',
		'customFieldList' => 'CustomFieldList',
	);
}
