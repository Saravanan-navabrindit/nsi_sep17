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

class CalendarEventSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $attendee;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $calendar;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $completedDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $instanceStart;
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
	public $isUpcomingEvent;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $organizer;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $resource;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $response;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accessLevel' => 'SearchEnumMultiSelectField',
		'attendee' => 'SearchMultiSelectField',
		'calendar' => 'SearchMultiSelectField',
		'completedDate' => 'SearchDateField',
		'createdDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'instanceStart' => 'SearchDateField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isUpcomingEvent' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'location' => 'SearchStringField',
		'message' => 'SearchStringField',
		'organizer' => 'SearchMultiSelectField',
		'owner' => 'SearchMultiSelectField',
		'resource' => 'SearchMultiSelectField',
		'response' => 'SearchEnumMultiSelectField',
		'startDate' => 'SearchDateField',
		'status' => 'SearchEnumMultiSelectField',
		'title' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
