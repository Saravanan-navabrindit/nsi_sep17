<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class CustomerSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchRowBasic
	 */
	public $billingAccountJoin;
	/**
	 * Var \NetSuite\Classes\BillingScheduleSearchRowBasic
	 */
	public $billingScheduleJoin;
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
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchRowBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $hostedPageJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $leadSourceJoin;
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
	 * Var \NetSuite\Classes\MseSubsidiarySearchRowBasic
	 */
	public $mseSubsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchRowBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchRowBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $parentCustomerJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\PaymentInstrumentSearchRowBasic
	 */
	public $paymentInstrumentJoin;
	/**
	 * Var \NetSuite\Classes\PricingSearchRowBasic
	 */
	public $pricingJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $purchasedItemJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchRowBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $salesRepJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $subCustomerJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\EntityTaxRegistrationSearchRowBasic
	 */
	public $taxRegistrationJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $topLevelParentJoin;
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
	 * Var \NetSuite\Classes\SiteCategorySearchRowBasic
	 */
	public $webSiteCategoryJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $webSiteItemJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'CustomerSearchRowBasic',
		'billingAccountJoin' => 'BillingAccountSearchRowBasic',
		'billingScheduleJoin' => 'BillingScheduleSearchRowBasic',
		'callJoin' => 'PhoneCallSearchRowBasic',
		'campaignResponseJoin' => 'CampaignSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'contactJoin' => 'ContactSearchRowBasic',
		'contactPrimaryJoin' => 'ContactSearchRowBasic',
		'eventJoin' => 'CalendarEventSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'hostedPageJoin' => 'FileSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'leadSourceJoin' => 'CampaignSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'messagesFromJoin' => 'MessageSearchRowBasic',
		'messagesToJoin' => 'MessageSearchRowBasic',
		'mseSubsidiaryJoin' => 'MseSubsidiarySearchRowBasic',
		'opportunityJoin' => 'OpportunitySearchRowBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchRowBasic',
		'parentCustomerJoin' => 'CustomerSearchRowBasic',
		'partnerJoin' => 'PartnerSearchRowBasic',
		'paymentInstrumentJoin' => 'PaymentInstrumentSearchRowBasic',
		'pricingJoin' => 'PricingSearchRowBasic',
		'purchasedItemJoin' => 'ItemSearchRowBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchRowBasic',
		'salesRepJoin' => 'EmployeeSearchRowBasic',
		'subCustomerJoin' => 'CustomerSearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'taxRegistrationJoin' => 'EntityTaxRegistrationSearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'topLevelParentJoin' => 'CustomerSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'upsellItemJoin' => 'ItemSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'webSiteCategoryJoin' => 'SiteCategorySearchRowBasic',
		'webSiteItemJoin' => 'ItemSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
