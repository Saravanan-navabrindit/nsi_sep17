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

class PurchaseRequisitionExpense {
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var boolean
	 */
	public $isClosed;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $poVendor;
	/**
	 * Var float
	 */
	public $estimatedAmount;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var string
	 */
	public $memo;
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
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $linkedOrderList;
	/**
	 * Var string
	 */
	public $linkedOrderStatus;
	/**
	 * Var boolean
	 */
	public $isBillable;
	public static $paramtypesmap = array(
		'line' => 'integer',
		'category' => 'RecordRef',
		'location' => 'RecordRef',
		'isClosed' => 'boolean',
		'account' => 'RecordRef',
		'poVendor' => 'RecordRef',
		'estimatedAmount' => 'float',
		'amount' => 'float',
		'memo' => 'string',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'customer' => 'RecordRef',
		'linkedOrderList' => 'RecordRefList',
		'linkedOrderStatus' => 'string',
		'isBillable' => 'boolean',
	);
}
