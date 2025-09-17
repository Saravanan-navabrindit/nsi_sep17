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

class ContactSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchRowBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $campaignResponseJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchRowBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchRowBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesFromJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesToJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchRowBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $parentCustomerJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $parentJobJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $parentPartnerJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $parentVendorJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $partnerPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $purchasedItemJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $upsellItemJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ContactSearchRowBasic',
		'callJoin' => 'PhoneCallSearchRowBasic',
		'campaignResponseJoin' => 'CampaignSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'customerPrimaryJoin' => 'CustomerSearchRowBasic',
		'eventJoin' => 'CalendarEventSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'jobPrimaryJoin' => 'JobSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'messagesFromJoin' => 'MessageSearchRowBasic',
		'messagesToJoin' => 'MessageSearchRowBasic',
		'opportunityJoin' => 'OpportunitySearchRowBasic',
		'parentCustomerJoin' => 'CustomerSearchRowBasic',
		'parentJobJoin' => 'JobSearchRowBasic',
		'parentPartnerJoin' => 'PartnerSearchRowBasic',
		'parentVendorJoin' => 'VendorSearchRowBasic',
		'partnerJoin' => 'PartnerSearchRowBasic',
		'partnerPrimaryJoin' => 'PartnerSearchRowBasic',
		'purchasedItemJoin' => 'ItemSearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'upsellItemJoin' => 'ItemSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'vendorPrimaryJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
