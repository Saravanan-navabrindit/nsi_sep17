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

class BinTransferInventory {
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $preferredBin;
	/**
	 * Var float
	 */
	public $quantity;
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
	public $fromBins;
	/**
	 * Var string
	 */
	public $toBins;
	public static $paramtypesmap = array(
		'line' => 'integer',
		'item' => 'RecordRef',
		'description' => 'string',
		'preferredBin' => 'string',
		'quantity' => 'float',
		'itemUnitsLabel' => 'string',
		'inventoryDetail' => 'InventoryDetail',
		'fromBins' => 'string',
		'toBins' => 'string',
	);
}
