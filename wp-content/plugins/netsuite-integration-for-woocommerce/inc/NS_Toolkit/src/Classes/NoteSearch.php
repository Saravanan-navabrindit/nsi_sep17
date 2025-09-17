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

class NoteSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $authorJoin;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $campaignJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchBasic
	 */
	public $entityJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\IssueSearchBasic
	 */
	public $issueJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\SolutionSearchBasic
	 */
	public $solutionJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $transactionJoin;
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
		'basic' => 'NoteSearchBasic',
		'authorJoin' => 'EmployeeSearchBasic',
		'callJoin' => 'PhoneCallSearchBasic',
		'campaignJoin' => 'CampaignSearchBasic',
		'caseJoin' => 'SupportCaseSearchBasic',
		'contactJoin' => 'ContactSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'employeeJoin' => 'EmployeeSearchBasic',
		'entityJoin' => 'EntitySearchBasic',
		'eventJoin' => 'CalendarEventSearchBasic',
		'issueJoin' => 'IssueSearchBasic',
		'itemJoin' => 'ItemSearchBasic',
		'opportunityJoin' => 'OpportunitySearchBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchBasic',
		'partnerJoin' => 'PartnerSearchBasic',
		'solutionJoin' => 'SolutionSearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'vendorJoin' => 'VendorSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
