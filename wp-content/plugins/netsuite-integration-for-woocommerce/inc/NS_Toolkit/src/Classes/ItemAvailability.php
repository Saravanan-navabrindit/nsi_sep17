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

class ItemAvailability {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var string
	 */
	public $lastQtyAvailableChange;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $locationId;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $onHandValueMli;
	/**
	 * Var float
	 */
	public $reorderPoint;
	/**
	 * Var float
	 */
	public $preferredStockLevel;
	/**
	 * Var float
	 */
	public $quantityOnOrder;
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
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'lastQtyAvailableChange' => 'dateTime',
		'locationId' => 'RecordRef',
		'quantityOnHand' => 'float',
		'onHandValueMli' => 'float',
		'reorderPoint' => 'float',
		'preferredStockLevel' => 'float',
		'quantityOnOrder' => 'float',
		'quantityCommitted' => 'float',
		'quantityBackOrdered' => 'float',
		'quantityAvailable' => 'float',
	);
}
