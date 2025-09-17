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

class OpportunitySearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\OpportunitySearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $actualJoin;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $decisionMakerJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $estimateJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $leadSourceJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $orderJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $salesRepJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'OpportunitySearchBasic',
		'actualJoin' => 'TransactionSearchBasic',
		'callJoin' => 'PhoneCallSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'decisionMakerJoin' => 'ContactSearchBasic',
		'estimateJoin' => 'TransactionSearchBasic',
		'eventJoin' => 'CalendarEventSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'itemJoin' => 'ItemSearchBasic',
		'leadSourceJoin' => 'CampaignSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'orderJoin' => 'TransactionSearchBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchBasic',
		'partnerJoin' => 'PartnerSearchBasic',
		'salesRepJoin' => 'EmployeeSearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
