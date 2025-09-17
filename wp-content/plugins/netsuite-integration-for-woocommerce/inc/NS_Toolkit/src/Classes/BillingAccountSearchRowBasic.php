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

class BillingAccountSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $cashSaleForm;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $customerDefault;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $frequency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $idNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $inactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $invoiceForm;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastBillCycleDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastBillDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $nextBillCycleDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'billingSchedule' => 'SearchColumnSelectField[]',
		'cashSaleForm' => 'SearchColumnSelectField[]',
		'class' => 'SearchColumnSelectField[]',
		'currency' => 'SearchColumnSelectField[]',
		'customer' => 'SearchColumnSelectField[]',
		'customerDefault' => 'SearchColumnBooleanField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'department' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'frequency' => 'SearchColumnEnumSelectField[]',
		'idNumber' => 'SearchColumnStringField[]',
		'inactive' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'invoiceForm' => 'SearchColumnSelectField[]',
		'lastBillCycleDate' => 'SearchColumnDateField[]',
		'lastBillDate' => 'SearchColumnDateField[]',
		'location' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'nextBillCycleDate' => 'SearchColumnDateField[]',
		'startDate' => 'SearchColumnDateField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
