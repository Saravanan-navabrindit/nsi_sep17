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

class PurchaseRequisitionItem {
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
	public $vendorName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $poVendor;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var \NetSuite\Classes\InventoryDetail
	 */
	public $inventoryDetail;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var float
	 */
	public $estimatedRate;
	/**
	 * Var float
	 */
	public $estimatedAmount;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var float
	 */
	public $taxRate1;
	/**
	 * Var float
	 */
	public $taxRate2;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
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
	public $customer;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $linkedOrderList;
	/**
	 * Var string
	 */
	public $linkedOrderStatus;
	/**
	 * Var string
	 */
	public $expectedReceiptDate;
	/**
	 * Var boolean
	 */
	public $isClosed;
	/**
	 * Var boolean
	 */
	public $expandItemGroup;
	public static $paramtypesmap = array(
		'line' => 'integer',
		'item' => 'RecordRef',
		'vendorName' => 'string',
		'poVendor' => 'RecordRef',
		'quantity' => 'float',
		'units' => 'RecordRef',
		'serialNumbers' => 'string',
		'inventoryDetail' => 'InventoryDetail',
		'description' => 'string',
		'estimatedRate' => 'float',
		'estimatedAmount' => 'float',
		'rate' => 'string',
		'amount' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'grossAmt' => 'float',
		'options' => 'CustomFieldList',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'customer' => 'RecordRef',
		'isBillable' => 'boolean',
		'linkedOrderList' => 'RecordRefList',
		'linkedOrderStatus' => 'string',
		'expectedReceiptDate' => 'dateTime',
		'isClosed' => 'boolean',
		'expandItemGroup' => 'boolean',
	);
}
