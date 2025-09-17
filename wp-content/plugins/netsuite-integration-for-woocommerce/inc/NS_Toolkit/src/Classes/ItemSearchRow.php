<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class ItemSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\RevRecTemplateSearchRowBasic
	 */
	public $accountingBookRevRecScheduleJoin;
	/**
	 * Var \NetSuite\Classes\AssemblyItemBomSearchRowBasic
	 */
	public $assemblyItemBillOfMaterialsJoin;
	/**
	 * Var \NetSuite\Classes\BinSearchRowBasic
	 */
	public $binNumberJoin;
	/**
	 * Var \NetSuite\Classes\ItemBinNumberSearchRowBasic
	 */
	public $binOnHandJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $correlatedItemJoin;
	/**
	 * Var \NetSuite\Classes\ItemRevisionSearchRowBasic
	 */
	public $effectiveRevisionJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\MerchandiseHierarchyNodeSearchRowBasic
	 */
	public $hierarchyNodeJoin;
	/**
	 * Var \NetSuite\Classes\InventoryDetailSearchRowBasic
	 */
	public $inventoryDetailJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $inventoryLocationJoin;
	/**
	 * Var \NetSuite\Classes\InventoryNumberSearchRowBasic
	 */
	public $inventoryNumberJoin;
	/**
	 * Var \NetSuite\Classes\InventoryNumberBinSearchRowBasic
	 */
	public $inventoryNumberBinOnHandJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $memberItemJoin;
	/**
	 * Var \NetSuite\Classes\ItemRevisionSearchRowBasic
	 */
	public $obsoleteRevisionJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $parentJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $preferredLocationJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $preferredVendorJoin;
	/**
	 * Var \NetSuite\Classes\PricingSearchRowBasic
	 */
	public $pricingJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $shopperJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ItemSearchRowBasic',
		'accountingBookRevRecScheduleJoin' => 'RevRecTemplateSearchRowBasic',
		'assemblyItemBillOfMaterialsJoin' => 'AssemblyItemBomSearchRowBasic',
		'binNumberJoin' => 'BinSearchRowBasic',
		'binOnHandJoin' => 'ItemBinNumberSearchRowBasic',
		'correlatedItemJoin' => 'ItemSearchRowBasic',
		'effectiveRevisionJoin' => 'ItemRevisionSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'hierarchyNodeJoin' => 'MerchandiseHierarchyNodeSearchRowBasic',
		'inventoryDetailJoin' => 'InventoryDetailSearchRowBasic',
		'inventoryLocationJoin' => 'LocationSearchRowBasic',
		'inventoryNumberJoin' => 'InventoryNumberSearchRowBasic',
		'inventoryNumberBinOnHandJoin' => 'InventoryNumberBinSearchRowBasic',
		'memberItemJoin' => 'ItemSearchRowBasic',
		'obsoleteRevisionJoin' => 'ItemRevisionSearchRowBasic',
		'parentJoin' => 'ItemSearchRowBasic',
		'preferredLocationJoin' => 'LocationSearchRowBasic',
		'preferredVendorJoin' => 'VendorSearchRowBasic',
		'pricingJoin' => 'PricingSearchRowBasic',
		'shopperJoin' => 'CustomerSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
