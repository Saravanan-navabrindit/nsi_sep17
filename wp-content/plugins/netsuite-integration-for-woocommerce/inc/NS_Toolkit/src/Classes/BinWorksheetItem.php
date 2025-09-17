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

class BinWorksheetItem {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var string
	 */
	public $itemName;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var string
	 */
	public $itemOnHand;
	/**
	 * Var string
	 */
	public $itemUnitsLabel;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $itemBins;
	/**
	 * Var string
	 */
	public $itemBinNumbers;
	/**
	 * Var string
	 */
	public $itemBinList;
	/**
	 * Var string
	 */
	public $itemPreferBin;
	/**
	 * Var string
	 */
	public $itemBlank;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'itemName' => 'string',
		'description' => 'string',
		'quantity' => 'float',
		'itemOnHand' => 'string',
		'itemUnitsLabel' => 'string',
		'inventoryDetail' => 'InventoryDetail',
		'itemBins' => 'string',
		'itemBinNumbers' => 'string',
		'itemBinList' => 'string',
		'itemPreferBin' => 'string',
		'itemBlank' => 'string',
	);
}
