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

class TimeEntrySearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\TimeEntrySearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\ClassificationSearchBasic
	 */
	public $classJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskAssignmentSearchBasic
	 */
	public $projectTaskAssignmentJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TimeSheetSearchBasic
	 */
	public $timeSheetJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'TimeEntrySearchBasic',
		'callJoin' => 'PhoneCallSearchBasic',
		'caseJoin' => 'SupportCaseSearchBasic',
		'classJoin' => 'ClassificationSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'departmentJoin' => 'DepartmentSearchBasic',
		'employeeJoin' => 'EmployeeSearchBasic',
		'eventJoin' => 'CalendarEventSearchBasic',
		'itemJoin' => 'ItemSearchBasic',
		'jobJoin' => 'JobSearchBasic',
		'locationJoin' => 'LocationSearchBasic',
		'projectTaskJoin' => 'ProjectTaskSearchBasic',
		'projectTaskAssignmentJoin' => 'ProjectTaskAssignmentSearchBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'timeSheetJoin' => 'TimeSheetSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'vendorJoin' => 'VendorSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
