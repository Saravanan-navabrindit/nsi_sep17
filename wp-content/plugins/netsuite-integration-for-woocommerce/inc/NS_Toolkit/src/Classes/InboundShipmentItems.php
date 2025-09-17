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

class InboundShipmentItems {
	/**
	 * Var integer
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseOrder;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipmentItem;
	/**
	 * Var string
	 */
	public $shipmentItemDescription;
	/**
	 * Var string
	 */
	public $poVendor;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $receivingLocation;
	/**
	 * Var float
	 */
	public $quantityReceived;
	/**
	 * Var float
	 */
	public $quantityExpected;
	/**
	 * Var float
	 */
	public $quantityRemaining;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unit;
	/**
	 * Var float
	 */
	public $poRate;
	/**
	 * Var float
	 */
	public $expectedRate;
	/**
	 * Var float
	 */
	public $shipmentItemExchangeRate;
	/**
	 * Var string
	 */
	public $shipmentItemEffectiveDate;
	/**
	 * Var float
	 */
	public $unitLandedCost;
	/**
	 * Var float
	 */
	public $totalUnitCost;
	/**
	 * Var float
	 */
	public $shipmentItemAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $poCurrency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $incoterm;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	public static $paramtypesmap = array(
		'id' => 'integer',
		'purchaseOrder' => 'RecordRef',
		'shipmentItem' => 'RecordRef',
		'shipmentItemDescription' => 'string',
		'poVendor' => 'string',
		'receivingLocation' => 'RecordRef',
		'quantityReceived' => 'float',
		'quantityExpected' => 'float',
		'quantityRemaining' => 'float',
		'unit' => 'RecordRef',
		'poRate' => 'float',
		'expectedRate' => 'float',
		'shipmentItemExchangeRate' => 'float',
		'shipmentItemEffectiveDate' => 'dateTime',
		'unitLandedCost' => 'float',
		'totalUnitCost' => 'float',
		'shipmentItemAmount' => 'float',
		'poCurrency' => 'RecordRef',
		'incoterm' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
	);
}
