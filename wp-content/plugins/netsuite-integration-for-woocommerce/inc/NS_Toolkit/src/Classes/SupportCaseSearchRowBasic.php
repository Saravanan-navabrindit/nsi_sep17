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

class SupportCaseSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $awaitingReply;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $customerStage;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $escalatee;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $helpDesk;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $inboundEmail;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $issue;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $issueNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastMessageDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastReopenedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $locked;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $module;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $origin;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $product;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $profile;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serialNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $stage;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'assigned' => 'SearchColumnSelectField[]',
		'awaitingReply' => 'SearchColumnBooleanField[]',
		'caseNumber' => 'SearchColumnStringField[]',
		'category' => 'SearchColumnSelectField[]',
		'company' => 'SearchColumnSelectField[]',
		'contact' => 'SearchColumnSelectField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'customerStage' => 'SearchColumnEnumSelectField[]',
		'email' => 'SearchColumnStringField[]',
		'endDate' => 'SearchColumnDateField[]',
		'escalatee' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'helpDesk' => 'SearchColumnBooleanField[]',
		'inboundEmail' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'issue' => 'SearchColumnSelectField[]',
		'issueNumber' => 'SearchColumnStringField[]',
		'item' => 'SearchColumnSelectField[]',
		'lastMessageDate' => 'SearchColumnDateField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'lastReopenedDate' => 'SearchColumnDateField[]',
		'locked' => 'SearchColumnBooleanField[]',
		'module' => 'SearchColumnSelectField[]',
		'origin' => 'SearchColumnSelectField[]',
		'priority' => 'SearchColumnSelectField[]',
		'product' => 'SearchColumnSelectField[]',
		'profile' => 'SearchColumnSelectField[]',
		'serialNumber' => 'SearchColumnStringField[]',
		'stage' => 'SearchColumnEnumSelectField[]',
		'startDate' => 'SearchColumnDateField[]',
		'status' => 'SearchColumnSelectField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
