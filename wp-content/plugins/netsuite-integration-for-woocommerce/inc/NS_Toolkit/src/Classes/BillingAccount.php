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

class BillingAccount extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $idNumber;
	/**
	 * Var boolean
	 */
	public $customerDefault;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var boolean
	 */
	public $inactive;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $createdBy;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\BillingAccountFrequency
	 */
	public $frequency;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $lastBillDate;
	/**
	 * Var string
	 */
	public $lastBillCycleDate;
	/**
	 * Var string
	 */
	public $nextBillCycleDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $invoiceForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $cashSaleForm;
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
		'customForm' => 'RecordRef',
		'idNumber' => 'string',
		'customerDefault' => 'boolean',
		'customer' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'name' => 'string',
		'inactive' => 'boolean',
		'memo' => 'string',
		'createdDate' => 'dateTime',
		'createdBy' => 'string',
		'currency' => 'RecordRef',
		'class' => 'RecordRef',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'frequency' => 'BillingAccountFrequency',
		'startDate' => 'dateTime',
		'lastBillDate' => 'dateTime',
		'lastBillCycleDate' => 'dateTime',
		'nextBillCycleDate' => 'dateTime',
		'invoiceForm' => 'RecordRef',
		'cashSaleForm' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
