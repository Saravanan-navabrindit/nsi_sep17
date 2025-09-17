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

class TimeBillSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchRowBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchRowBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\ChargeSearchRowBasic
	 */
	public $chargeJoin;
	/**
	 * Var \NetSuite\Classes\ClassificationSearchRowBasic
	 */
	public $classJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchRowBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchRowBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchRowBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskAssignmentSearchRowBasic
	 */
	public $projectTaskAssignmentJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchRowBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TimeSheetSearchRowBasic
	 */
	public $timeSheetJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'TimeBillSearchRowBasic',
		'callJoin' => 'PhoneCallSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'chargeJoin' => 'ChargeSearchRowBasic',
		'classJoin' => 'ClassificationSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'departmentJoin' => 'DepartmentSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'eventJoin' => 'CalendarEventSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'locationJoin' => 'LocationSearchRowBasic',
		'projectTaskJoin' => 'ProjectTaskSearchRowBasic',
		'projectTaskAssignmentJoin' => 'ProjectTaskAssignmentSearchRowBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'timeSheetJoin' => 'TimeSheetSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
