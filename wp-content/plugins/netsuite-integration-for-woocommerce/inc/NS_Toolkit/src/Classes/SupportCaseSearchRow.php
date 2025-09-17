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

class SupportCaseSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $companyJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\IssueSearchRowBasic
	 */
	public $issueJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesJoin;
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
		'basic' => 'SupportCaseSearchRowBasic',
		'companyJoin' => 'EntitySearchRowBasic',
		'contactJoin' => 'ContactSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'issueJoin' => 'IssueSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
