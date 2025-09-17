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

class TaskSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $assignedJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchRowBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $companyCustomerJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchRowBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchRowBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'TaskSearchRowBasic',
		'assignedJoin' => 'EmployeeSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'companyCustomerJoin' => 'CustomerSearchRowBasic',
		'contactJoin' => 'ContactSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'opportunityJoin' => 'OpportunitySearchRowBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
