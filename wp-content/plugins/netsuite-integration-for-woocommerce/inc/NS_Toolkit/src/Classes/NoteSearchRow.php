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

class NoteSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $authorJoin;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchRowBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $campaignJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchRowBasic
	 */
	public $caseJoin;
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
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $entityJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchRowBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\IssueSearchRowBasic
	 */
	public $issueJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchRowBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchRowBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\SolutionSearchRowBasic
	 */
	public $solutionJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $transactionJoin;
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
		'basic' => 'NoteSearchRowBasic',
		'authorJoin' => 'EmployeeSearchRowBasic',
		'callJoin' => 'PhoneCallSearchRowBasic',
		'campaignJoin' => 'CampaignSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'contactJoin' => 'ContactSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'entityJoin' => 'EntitySearchRowBasic',
		'eventJoin' => 'CalendarEventSearchRowBasic',
		'issueJoin' => 'IssueSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'opportunityJoin' => 'OpportunitySearchRowBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchRowBasic',
		'partnerJoin' => 'PartnerSearchRowBasic',
		'solutionJoin' => 'SolutionSearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
