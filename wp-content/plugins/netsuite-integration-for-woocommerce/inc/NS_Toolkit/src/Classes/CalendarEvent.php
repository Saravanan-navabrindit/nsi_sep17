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

class CalendarEvent extends Record {
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
	 * Var integer
	 */
	public $period;
	/**
	 * Var \NetSuite\Classes\RecurrenceFrequency
	 */
	public $frequency;
	/**
	 * Var \NetSuite\Classes\RecurrenceDowMaskList
	 */
	public $recurrenceDowMaskList;
	/**
	 * Var \NetSuite\Classes\RecurrenceDow
	 */
	public $recurrenceDow;
	/**
	 * Var \NetSuite\Classes\RecurrenceDowim
	 */
	public $recurrenceDowim;
	/**
	 * Var string
	 */
	public $seriesStartDate;
	/**
	 * Var string
	 */
	public $endByDate;
	/**
	 * Var boolean
	 */
	public $noEndDate;
	/**
	 * Var boolean
	 */
	public $sendEmail;
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
	public $recurrence;
	/**
	 * Var string
	 */
	public $location;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var boolean
	 */
	public $allDayEvent;
	/**
	 * Var boolean
	 */
	public $timedEvent;
	/**
	 * Var \NetSuite\Classes\CalendarEventReminderType
	 */
	public $reminderType;
	/**
	 * Var \NetSuite\Classes\CalendarEventReminderMinutes
	 */
	public $reminderMinutes;
	/**
	 * Var \NetSuite\Classes\CalendarEventStatus
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\CalendarEventAccessLevel
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $organizer;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\ExclusionDateList
	 */
	public $exclusionDateList;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\CalendarEventAttendeeList
	 */
	public $attendeeList;
	/**
	 * Var \NetSuite\Classes\CalendarEventResourceList
	 */
	public $resourceList;
	/**
	 * Var \NetSuite\Classes\CalendarEventTimeItemList
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
		'period' => 'integer',
		'frequency' => 'RecurrenceFrequency',
		'recurrenceDowMaskList' => 'RecurrenceDowMaskList',
		'recurrenceDow' => 'RecurrenceDow',
		'recurrenceDowim' => 'RecurrenceDowim',
		'seriesStartDate' => 'dateTime',
		'endByDate' => 'dateTime',
		'noEndDate' => 'boolean',
		'sendEmail' => 'boolean',
		'customForm' => 'RecordRef',
		'title' => 'string',
		'recurrence' => 'string',
		'location' => 'string',
		'startDate' => 'dateTime',
		'allDayEvent' => 'boolean',
		'timedEvent' => 'boolean',
		'reminderType' => 'CalendarEventReminderType',
		'reminderMinutes' => 'CalendarEventReminderMinutes',
		'status' => 'CalendarEventStatus',
		'accessLevel' => 'CalendarEventAccessLevel',
		'organizer' => 'RecordRef',
		'message' => 'string',
		'createdDate' => 'dateTime',
		'endDate' => 'dateTime',
		'exclusionDateList' => 'ExclusionDateList',
		'lastModifiedDate' => 'dateTime',
		'owner' => 'RecordRef',
		'attendeeList' => 'CalendarEventAttendeeList',
		'resourceList' => 'CalendarEventResourceList',
		'timeItemList' => 'CalendarEventTimeItemList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
