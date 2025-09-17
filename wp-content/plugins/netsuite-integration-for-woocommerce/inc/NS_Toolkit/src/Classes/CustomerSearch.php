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

class CustomerSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchBasic
	 */
	public $billingAccountJoin;
	/**
	 * Var \NetSuite\Classes\BillingScheduleSearchBasic
	 */
	public $billingScheduleJoin;
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
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $hostedPageJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $leadSourceJoin;
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
	 * Var \NetSuite\Classes\MseSubsidiarySearchBasic
	 */
	public $mseSubsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $parentCustomerJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\PaymentInstrumentSearchBasic
	 */
	public $paymentInstrumentJoin;
	/**
	 * Var \NetSuite\Classes\PricingSearchBasic
	 */
	public $pricingJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $purchasedItemJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $salesRepJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $subCustomerJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\EntityTaxRegistrationSearchBasic
	 */
	public $taxRegistrationJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $topLevelParentJoin;
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
	 * Var \NetSuite\Classes\SiteCategorySearchBasic
	 */
	public $webSiteCategoryJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $webSiteItemJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'CustomerSearchBasic',
		'billingAccountJoin' => 'BillingAccountSearchBasic',
		'billingScheduleJoin' => 'BillingScheduleSearchBasic',
		'callJoin' => 'PhoneCallSearchBasic',
		'campaignResponseJoin' => 'CampaignSearchBasic',
		'caseJoin' => 'SupportCaseSearchBasic',
		'contactJoin' => 'ContactSearchBasic',
		'contactPrimaryJoin' => 'ContactSearchBasic',
		'eventJoin' => 'CalendarEventSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'hostedPageJoin' => 'FileSearchBasic',
		'jobJoin' => 'JobSearchBasic',
		'leadSourceJoin' => 'CampaignSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'messagesFromJoin' => 'MessageSearchBasic',
		'messagesToJoin' => 'MessageSearchBasic',
		'mseSubsidiaryJoin' => 'MseSubsidiarySearchBasic',
		'opportunityJoin' => 'OpportunitySearchBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchBasic',
		'parentCustomerJoin' => 'CustomerSearchBasic',
		'partnerJoin' => 'PartnerSearchBasic',
		'paymentInstrumentJoin' => 'PaymentInstrumentSearchBasic',
		'pricingJoin' => 'PricingSearchBasic',
		'purchasedItemJoin' => 'ItemSearchBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchBasic',
		'salesRepJoin' => 'EmployeeSearchBasic',
		'subCustomerJoin' => 'CustomerSearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'taxRegistrationJoin' => 'EntityTaxRegistrationSearchBasic',
		'timeJoin' => 'TimeBillSearchBasic',
		'topLevelParentJoin' => 'CustomerSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'upsellItemJoin' => 'ItemSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'webSiteCategoryJoin' => 'SiteCategorySearchBasic',
		'webSiteItemJoin' => 'ItemSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
