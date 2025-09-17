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

class PurchaseOrderItem {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var float
	 */
	public $quantityOnShipments;
	/**
	 * Var string
	 */
	public $vendorName;
	/**
	 * Var float
	 */
	public $quantityReceived;
	/**
	 * Var float
	 */
	public $quantityBilled;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var float
	 */
	public $quantityOnHand;
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
	public $quantity;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
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
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseContract;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $options;
	/**
	 * Var float
	 */
	public $taxAmount;
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
	public $landedCostCategory;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\TransactionBillVarianceStatus
	 */
	public $billVarianceStatus;
	/**
	 * Var boolean
	 */
	public $matchBillToReceipt;
	/**
	 * Var string
	 */
	public $expectedReceiptDate;
	/**
	 * Var boolean
	 */
	public $isClosed;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $linkedOrderList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'line' => 'integer',
		'quantityOnShipments' => 'float',
		'vendorName' => 'string',
		'quantityReceived' => 'float',
		'quantityBilled' => 'float',
		'quantityAvailable' => 'float',
		'quantityOnHand' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
		'quantity' => 'float',
		'tax1Amt' => 'float',
		'grossAmt' => 'float',
		'units' => 'RecordRef',
		'inventoryDetail' => 'InventoryDetail',
		'serialNumbers' => 'string',
		'description' => 'string',
		'purchaseContract' => 'RecordRef',
		'rate' => 'string',
		'amount' => 'float',
		'options' => 'CustomFieldList',
		'taxAmount' => 'float',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'landedCostCategory' => 'RecordRef',
		'customer' => 'RecordRef',
		'isBillable' => 'boolean',
		'billVarianceStatus' => 'TransactionBillVarianceStatus',
		'matchBillToReceipt' => 'boolean',
		'expectedReceiptDate' => 'dateTime',
		'isClosed' => 'boolean',
		'taxDetailsReference' => 'string',
		'createdFrom' => 'RecordRef',
		'linkedOrderList' => 'RecordRefList',
		'customFieldList' => 'CustomFieldList',
	);
}
