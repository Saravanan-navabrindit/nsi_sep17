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

class ResourceAllocationSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchRowBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $requestedByJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $resourceJoin;
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
		'basic' => 'ResourceAllocationSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'projectTaskJoin' => 'ProjectTaskSearchRowBasic',
		'requestedByJoin' => 'EntitySearchRowBasic',
		'resourceJoin' => 'EntitySearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
