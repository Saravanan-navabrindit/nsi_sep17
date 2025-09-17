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

class JobSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
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
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $projectManagerJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'JobSearchBasic',
		'billingAccountJoin' => 'BillingAccountSearchBasic',
		'billingScheduleJoin' => 'BillingScheduleSearchBasic',
		'contactPrimaryJoin' => 'ContactSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'projectManagerJoin' => 'EmployeeSearchBasic',
		'projectTaskJoin' => 'ProjectTaskSearchBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'timeJoin' => 'TimeBillSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
