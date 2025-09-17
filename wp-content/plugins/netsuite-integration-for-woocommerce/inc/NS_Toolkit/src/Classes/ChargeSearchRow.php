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

class ChargeSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\ChargeSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchRowBasic
	 */
	public $billingAccountJoin;
	/**
	 * Var \NetSuite\Classes\BillingScheduleSearchRowBasic
	 */
	public $billingScheduleJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $chargeEmployeeJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $invoiceJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $salesOrderJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\UsageSearchRowBasic
	 */
	public $usageJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ChargeSearchRowBasic',
		'billingAccountJoin' => 'BillingAccountSearchRowBasic',
		'billingScheduleJoin' => 'BillingScheduleSearchRowBasic',
		'chargeEmployeeJoin' => 'EmployeeSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'invoiceJoin' => 'TransactionSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'salesOrderJoin' => 'TransactionSearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'usageJoin' => 'UsageSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
