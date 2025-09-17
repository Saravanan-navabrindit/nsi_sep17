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

class SupportCase extends Record {
	/**
	 * Var string
	 */
	public $escalationMessage;
	/**
	 * Var string
	 */
	public $lastReopenedDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $incomingMessage;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $insertSolution;
	/**
	 * Var string
	 */
	public $outgoingMessage;
	/**
	 * Var string
	 */
	public $searchSolution;
	/**
	 * Var boolean
	 */
	public $emailForm;
	/**
	 * Var string
	 */
	public $newSolutionFromMsg;
	/**
	 * Var boolean
	 */
	public $internalOnly;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var string
	 */
	public $caseNumber;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $lastMessageDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $profile;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $contact;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var string
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $product;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $module;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $serialNumber;
	/**
	 * Var string
	 */
	public $inboundEmail;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issue;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $status;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $origin;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assigned;
	/**
	 * Var boolean
	 */
	public $helpDesk;
	/**
	 * Var \NetSuite\Classes\EmailEmployeesList
	 */
	public $emailEmployeesList;
	/**
	 * Var \NetSuite\Classes\SupportCaseEscalateToList
	 */
	public $escalateToList;
	/**
	 * Var \NetSuite\Classes\SupportCaseTimeItemList
	 */
	public $timeItemList;
	/**
	 * Var \NetSuite\Classes\SupportCaseSolutionsList
	 */
	public $solutionsList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'escalationMessage' => 'string',
		'lastReopenedDate' => 'dateTime',
		'endDate' => 'dateTime',
		'incomingMessage' => 'string',
		'insertSolution' => 'RecordRef',
		'outgoingMessage' => 'string',
		'searchSolution' => 'string',
		'emailForm' => 'boolean',
		'newSolutionFromMsg' => 'string',
		'internalOnly' => 'boolean',
		'customForm' => 'RecordRef',
		'title' => 'string',
		'caseNumber' => 'string',
		'startDate' => 'dateTime',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'lastMessageDate' => 'dateTime',
		'company' => 'RecordRef',
		'profile' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'contact' => 'RecordRef',
		'email' => 'string',
		'phone' => 'string',
		'product' => 'RecordRef',
		'module' => 'RecordRef',
		'item' => 'RecordRef',
		'serialNumber' => 'RecordRef',
		'inboundEmail' => 'string',
		'issue' => 'RecordRef',
		'status' => 'RecordRef',
		'isInactive' => 'boolean',
		'priority' => 'RecordRef',
		'origin' => 'RecordRef',
		'category' => 'RecordRef',
		'assigned' => 'RecordRef',
		'helpDesk' => 'boolean',
		'emailEmployeesList' => 'EmailEmployeesList',
		'escalateToList' => 'SupportCaseEscalateToList',
		'timeItemList' => 'SupportCaseTimeItemList',
		'solutionsList' => 'SupportCaseSolutionsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
