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

class AssemblyBuild extends Record {
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $expirationDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var float
	 */
	public $buildable;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billOfMaterials;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revision;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billOfMaterialsRevision;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\AssemblyComponentList
	 */
	public $componentList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'createdDate' => 'dateTime',
		'expirationDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'customForm' => 'RecordRef',
		'createdFrom' => 'RecordRef',
		'tranDate' => 'dateTime',
		'postingPeriod' => 'RecordRef',
		'tranId' => 'string',
		'item' => 'RecordRef',
		'buildable' => 'float',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'total' => 'float',
		'billOfMaterials' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbers' => 'string',
		'binNumbers' => 'string',
		'subsidiary' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'revision' => 'RecordRef',
		'billOfMaterialsRevision' => 'RecordRef',
		'memo' => 'string',
		'componentList' => 'AssemblyComponentList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
