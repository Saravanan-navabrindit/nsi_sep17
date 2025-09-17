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

class SupportCaseSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $awaitingReply;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $caseNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $closedDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $escalateTo;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $helpDesk;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $inboundEmail;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $issue;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $lastMessage;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastReopenedDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $locked;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $messageAuthor;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $messageDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $messageType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $module;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $origin;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $product;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $profile;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $serialNumber;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $stage;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'assigned' => 'SearchMultiSelectField',
		'awaitingReply' => 'SearchBooleanField',
		'caseNumber' => 'SearchStringField',
		'category' => 'SearchMultiSelectField',
		'closedDate' => 'SearchDateField',
		'company' => 'SearchStringField',
		'contact' => 'SearchStringField',
		'createdDate' => 'SearchDateField',
		'email' => 'SearchStringField',
		'escalateTo' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'helpDesk' => 'SearchBooleanField',
		'inboundEmail' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'issue' => 'SearchMultiSelectField',
		'item' => 'SearchMultiSelectField',
		'lastMessage' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'lastReopenedDate' => 'SearchDateField',
		'locked' => 'SearchBooleanField',
		'message' => 'SearchStringField',
		'messageAuthor' => 'SearchMultiSelectField',
		'messageDate' => 'SearchDateField',
		'messageType' => 'SearchBooleanField',
		'module' => 'SearchMultiSelectField',
		'number' => 'SearchLongField',
		'origin' => 'SearchMultiSelectField',
		'priority' => 'SearchMultiSelectField',
		'product' => 'SearchMultiSelectField',
		'profile' => 'SearchMultiSelectField',
		'serialNumber' => 'SearchStringField',
		'stage' => 'SearchEnumMultiSelectField',
		'startDate' => 'SearchDateField',
		'status' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
