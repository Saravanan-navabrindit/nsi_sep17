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

class ItemSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\RevRecTemplateSearchBasic
	 */
	public $accountingBookRevRecScheduleJoin;
	/**
	 * Var \NetSuite\Classes\AssemblyItemBomSearchBasic
	 */
	public $assemblyItemBillOfMaterialsJoin;
	/**
	 * Var \NetSuite\Classes\BinSearchBasic
	 */
	public $binNumberJoin;
	/**
	 * Var \NetSuite\Classes\ItemBinNumberSearchBasic
	 */
	public $binOnHandJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $correlatedItemJoin;
	/**
	 * Var \NetSuite\Classes\ItemRevisionSearchBasic
	 */
	public $effectiveRevisionJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\MerchandiseHierarchyNodeSearchBasic
	 */
	public $hierarchyNodeJoin;
	/**
	 * Var \NetSuite\Classes\InventoryDetailSearchBasic
	 */
	public $inventoryDetailJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $inventoryLocationJoin;
	/**
	 * Var \NetSuite\Classes\InventoryNumberSearchBasic
	 */
	public $inventoryNumberJoin;
	/**
	 * Var \NetSuite\Classes\InventoryNumberBinSearchBasic
	 */
	public $inventoryNumberBinOnHandJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $memberItemJoin;
	/**
	 * Var \NetSuite\Classes\ItemRevisionSearchBasic
	 */
	public $obsoleteRevisionJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $parentJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $preferredLocationJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $preferredVendorJoin;
	/**
	 * Var \NetSuite\Classes\PricingSearchBasic
	 */
	public $pricingJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $shopperJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ItemSearchBasic',
		'accountingBookRevRecScheduleJoin' => 'RevRecTemplateSearchBasic',
		'assemblyItemBillOfMaterialsJoin' => 'AssemblyItemBomSearchBasic',
		'binNumberJoin' => 'BinSearchBasic',
		'binOnHandJoin' => 'ItemBinNumberSearchBasic',
		'correlatedItemJoin' => 'ItemSearchBasic',
		'effectiveRevisionJoin' => 'ItemRevisionSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'hierarchyNodeJoin' => 'MerchandiseHierarchyNodeSearchBasic',
		'inventoryDetailJoin' => 'InventoryDetailSearchBasic',
		'inventoryLocationJoin' => 'LocationSearchBasic',
		'inventoryNumberJoin' => 'InventoryNumberSearchBasic',
		'inventoryNumberBinOnHandJoin' => 'InventoryNumberBinSearchBasic',
		'memberItemJoin' => 'ItemSearchBasic',
		'obsoleteRevisionJoin' => 'ItemRevisionSearchBasic',
		'parentJoin' => 'ItemSearchBasic',
		'preferredLocationJoin' => 'LocationSearchBasic',
		'preferredVendorJoin' => 'VendorSearchBasic',
		'pricingJoin' => 'PricingSearchBasic',
		'shopperJoin' => 'CustomerSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'vendorJoin' => 'VendorSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
