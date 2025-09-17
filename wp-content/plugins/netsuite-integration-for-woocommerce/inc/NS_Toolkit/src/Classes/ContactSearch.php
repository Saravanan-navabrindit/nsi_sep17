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

class ContactSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $campaignResponseJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesFromJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesToJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $parentCustomerJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $parentJobJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $parentPartnerJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $parentVendorJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $partnerPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $purchasedItemJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $upsellItemJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $vendorPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ContactSearchBasic',
		'callJoin' => 'PhoneCallSearchBasic',
		'campaignResponseJoin' => 'CampaignSearchBasic',
		'caseJoin' => 'SupportCaseSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'customerPrimaryJoin' => 'CustomerSearchBasic',
		'eventJoin' => 'CalendarEventSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'jobJoin' => 'JobSearchBasic',
		'jobPrimaryJoin' => 'JobSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'messagesFromJoin' => 'MessageSearchBasic',
		'messagesToJoin' => 'MessageSearchBasic',
		'opportunityJoin' => 'OpportunitySearchBasic',
		'parentCustomerJoin' => 'CustomerSearchBasic',
		'parentJobJoin' => 'JobSearchBasic',
		'parentPartnerJoin' => 'PartnerSearchBasic',
		'parentVendorJoin' => 'VendorSearchBasic',
		'partnerJoin' => 'PartnerSearchBasic',
		'partnerPrimaryJoin' => 'PartnerSearchBasic',
		'purchasedItemJoin' => 'ItemSearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'upsellItemJoin' => 'ItemSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'vendorJoin' => 'VendorSearchBasic',
		'vendorPrimaryJoin' => 'VendorSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
