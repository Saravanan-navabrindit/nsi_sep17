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

class CalendarEventSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $attendee;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $completedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $endTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $instanceEnd;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $instanceStart;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $markdone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $organizer;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $recurrence;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $resource;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $response;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $startTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $transaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accessLevel' => 'SearchColumnEnumSelectField[]',
		'attendee' => 'SearchColumnSelectField[]',
		'company' => 'SearchColumnSelectField[]',
		'completedDate' => 'SearchColumnDateField[]',
		'contact' => 'SearchColumnSelectField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'endTime' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'instanceEnd' => 'SearchColumnDateField[]',
		'instanceStart' => 'SearchColumnDateField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'location' => 'SearchColumnStringField[]',
		'markdone' => 'SearchColumnStringField[]',
		'message' => 'SearchColumnStringField[]',
		'organizer' => 'SearchColumnSelectField[]',
		'owner' => 'SearchColumnSelectField[]',
		'recurrence' => 'SearchColumnStringField[]',
		'resource' => 'SearchColumnSelectField[]',
		'response' => 'SearchColumnEnumSelectField[]',
		'startDate' => 'SearchColumnStringField[]',
		'startTime' => 'SearchColumnStringField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'transaction' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
