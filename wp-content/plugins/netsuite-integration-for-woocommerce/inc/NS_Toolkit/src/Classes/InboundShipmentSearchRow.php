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

class InboundShipmentSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\InboundShipmentSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\InventoryDetailSearchRowBasic
	 */
	public $inventoryDetailJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $itemReceiptJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $purchaseOrderJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'InboundShipmentSearchRowBasic',
		'inventoryDetailJoin' => 'InventoryDetailSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'itemReceiptJoin' => 'TransactionSearchRowBasic',
		'purchaseOrderJoin' => 'TransactionSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
