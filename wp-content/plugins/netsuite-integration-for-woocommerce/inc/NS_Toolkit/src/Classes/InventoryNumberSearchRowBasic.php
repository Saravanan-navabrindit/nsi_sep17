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

class InventoryNumberSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expirationDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $inventoryNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isonhand;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityavailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityintransit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityonhand;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityonorder;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'expirationDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'inventoryNumber' => 'SearchColumnStringField[]',
		'isonhand' => 'SearchColumnBooleanField[]',
		'item' => 'SearchColumnSelectField[]',
		'location' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'quantityavailable' => 'SearchColumnDoubleField[]',
		'quantityintransit' => 'SearchColumnDoubleField[]',
		'quantityonhand' => 'SearchColumnDoubleField[]',
		'quantityonorder' => 'SearchColumnDoubleField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
