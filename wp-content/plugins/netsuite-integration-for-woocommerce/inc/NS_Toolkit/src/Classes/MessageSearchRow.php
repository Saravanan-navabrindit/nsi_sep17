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

class MessageSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $attachmentsJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $authorJoin;
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
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $recipientJoin;
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
	public static $paramtypesmap = array(
		'basic' => 'MessageSearchRowBasic',
		'attachmentsJoin' => 'FileSearchRowBasic',
		'authorJoin' => 'EntitySearchRowBasic',
		'campaignJoin' => 'CampaignSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'contactJoin' => 'ContactSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'entityJoin' => 'EntitySearchRowBasic',
		'opportunityJoin' => 'OpportunitySearchRowBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchRowBasic',
		'partnerJoin' => 'PartnerSearchRowBasic',
		'recipientJoin' => 'EntitySearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
	);
}
