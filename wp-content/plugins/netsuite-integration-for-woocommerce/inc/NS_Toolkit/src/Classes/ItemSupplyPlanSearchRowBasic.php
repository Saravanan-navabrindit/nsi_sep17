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

class ItemSupplyPlanSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $orderCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $orderDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $orderType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityUom;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $receiptDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'location' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'orderCreated' => 'SearchColumnBooleanField[]',
		'orderDate' => 'SearchColumnDateField[]',
		'orderType' => 'SearchColumnSelectField[]',
		'quantity' => 'SearchColumnDoubleField[]',
		'quantityUom' => 'SearchColumnDoubleField[]',
		'receiptDate' => 'SearchColumnDateField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'units' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
