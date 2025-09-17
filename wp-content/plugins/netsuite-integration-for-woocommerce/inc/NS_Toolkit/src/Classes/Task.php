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

class Task extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supportCase;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transaction;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $milestone;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assigned;
	/**
	 * Var boolean
	 */
	public $sendEmail;
	/**
	 * Var boolean
	 */
	public $timedEvent;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $estimatedTime;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $estimatedTimeOverride;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $actualTime;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $timeRemaining;
	/**
	 * Var float
	 */
	public $percentTimeComplete;
	/**
	 * Var float
	 */
	public $percentComplete;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $dueDate;
	/**
	 * Var string
	 */
	public $completedDate;
	/**
	 * Var \NetSuite\Classes\TaskPriority
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\TaskStatus
	 */
	public $status;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var boolean
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\TaskReminderType
	 */
	public $reminderType;
	/**
	 * Var \NetSuite\Classes\TaskReminderMinutes
	 */
	public $reminderMinutes;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\TaskContactList
	 */
	public $contactList;
	/**
	 * Var \NetSuite\Classes\TaskTimeItemList
	 */
	public $timeItemList;
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
		'company' => 'RecordRef',
		'contact' => 'RecordRef',
		'supportCase' => 'RecordRef',
		'transaction' => 'RecordRef',
		'milestone' => 'RecordRef',
		'customForm' => 'RecordRef',
		'title' => 'string',
		'assigned' => 'RecordRef',
		'sendEmail' => 'boolean',
		'timedEvent' => 'boolean',
		'estimatedTime' => 'Duration',
		'estimatedTimeOverride' => 'Duration',
		'actualTime' => 'Duration',
		'timeRemaining' => 'Duration',
		'percentTimeComplete' => 'float',
		'percentComplete' => 'float',
		'parent' => 'RecordRef',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'dueDate' => 'dateTime',
		'completedDate' => 'dateTime',
		'priority' => 'TaskPriority',
		'status' => 'TaskStatus',
		'message' => 'string',
		'accessLevel' => 'boolean',
		'reminderType' => 'TaskReminderType',
		'reminderMinutes' => 'TaskReminderMinutes',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'owner' => 'RecordRef',
		'contactList' => 'TaskContactList',
		'timeItemList' => 'TaskTimeItemList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
