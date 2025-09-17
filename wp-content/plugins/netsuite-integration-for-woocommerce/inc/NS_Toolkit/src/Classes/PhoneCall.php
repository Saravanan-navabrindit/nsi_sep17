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

class PhoneCall extends Record {
	/**
	 * Var string
	 */
	public $message;
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
	public $owner;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assigned;
	/**
	 * Var boolean
	 */
	public $sendEmail;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var boolean
	 */
	public $timedEvent;
	/**
	 * Var string
	 */
	public $completedDate;
	/**
	 * Var string
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\PhoneCallStatus
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\PhoneCallPriority
	 */
	public $priority;
	/**
	 * Var boolean
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\PhoneCallReminderType
	 */
	public $reminderType;
	/**
	 * Var \NetSuite\Classes\PhoneCallReminderMinutes
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
	 * Var \NetSuite\Classes\PhoneCallContactList
	 */
	public $contactList;
	/**
	 * Var \NetSuite\Classes\PhoneCallTimeItemList
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
		'message' => 'string',
		'company' => 'RecordRef',
		'contact' => 'RecordRef',
		'supportCase' => 'RecordRef',
		'transaction' => 'RecordRef',
		'milestone' => 'RecordRef',
		'customForm' => 'RecordRef',
		'title' => 'string',
		'owner' => 'RecordRef',
		'assigned' => 'RecordRef',
		'sendEmail' => 'boolean',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'timedEvent' => 'boolean',
		'completedDate' => 'dateTime',
		'phone' => 'string',
		'status' => 'PhoneCallStatus',
		'priority' => 'PhoneCallPriority',
		'accessLevel' => 'boolean',
		'reminderType' => 'PhoneCallReminderType',
		'reminderMinutes' => 'PhoneCallReminderMinutes',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'contactList' => 'PhoneCallContactList',
		'timeItemList' => 'PhoneCallTimeItemList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
