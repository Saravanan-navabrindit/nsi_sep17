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

class PhoneCallSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $companyCustomerJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchBasic
	 */
	public $participantJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'PhoneCallSearchBasic',
		'caseJoin' => 'SupportCaseSearchBasic',
		'companyCustomerJoin' => 'CustomerSearchBasic',
		'contactJoin' => 'ContactSearchBasic',
		'employeeJoin' => 'EmployeeSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'opportunityJoin' => 'OpportunitySearchBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchBasic',
		'participantJoin' => 'EntitySearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
