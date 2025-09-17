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

class ResourceAllocationSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchBasic
	 */
	public $requestedByJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchBasic
	 */
	public $resourceJoin;
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
		'basic' => 'ResourceAllocationSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'employeeJoin' => 'EmployeeSearchBasic',
		'jobJoin' => 'JobSearchBasic',
		'projectTaskJoin' => 'ProjectTaskSearchBasic',
		'requestedByJoin' => 'EntitySearchBasic',
		'resourceJoin' => 'EntitySearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'vendorJoin' => 'VendorSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
