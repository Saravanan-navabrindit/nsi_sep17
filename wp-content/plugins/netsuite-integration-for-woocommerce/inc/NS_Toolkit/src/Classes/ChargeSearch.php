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

class ChargeSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\ChargeSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchBasic
	 */
	public $billingAccountJoin;
	/**
	 * Var \NetSuite\Classes\BillingScheduleSearchBasic
	 */
	public $billingScheduleJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $chargeEmployeeJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $invoiceJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $salesOrderJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\UsageSearchBasic
	 */
	public $usageJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ChargeSearchBasic',
		'billingAccountJoin' => 'BillingAccountSearchBasic',
		'billingScheduleJoin' => 'BillingScheduleSearchBasic',
		'chargeEmployeeJoin' => 'EmployeeSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'invoiceJoin' => 'TransactionSearchBasic',
		'itemJoin' => 'ItemSearchBasic',
		'jobJoin' => 'JobSearchBasic',
		'salesOrderJoin' => 'TransactionSearchBasic',
		'timeJoin' => 'TimeBillSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'usageJoin' => 'UsageSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
