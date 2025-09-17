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

class OpportunitySearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\OpportunitySearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $actualJoin;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchRowBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $decisionMakerJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $estimateJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchRowBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $leadSourceJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $orderJoin;
	/**
	 * Var \NetSuite\Classes\OriginatingLeadSearchRowBasic
	 */
	public $originatingLeadJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $salesRepJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'OpportunitySearchRowBasic',
		'actualJoin' => 'TransactionSearchRowBasic',
		'callJoin' => 'PhoneCallSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'decisionMakerJoin' => 'ContactSearchRowBasic',
		'estimateJoin' => 'TransactionSearchRowBasic',
		'eventJoin' => 'CalendarEventSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'leadSourceJoin' => 'CampaignSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'orderJoin' => 'TransactionSearchRowBasic',
		'originatingLeadJoin' => 'OriginatingLeadSearchRowBasic',
		'partnerJoin' => 'PartnerSearchRowBasic',
		'salesRepJoin' => 'EmployeeSearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
