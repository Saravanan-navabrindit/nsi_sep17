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

class JobSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
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
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $projectManagerJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchRowBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchRowBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'JobSearchRowBasic',
		'billingAccountJoin' => 'BillingAccountSearchRowBasic',
		'billingScheduleJoin' => 'BillingScheduleSearchRowBasic',
		'contactPrimaryJoin' => 'ContactSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'projectManagerJoin' => 'EmployeeSearchRowBasic',
		'projectTaskJoin' => 'ProjectTaskSearchRowBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
