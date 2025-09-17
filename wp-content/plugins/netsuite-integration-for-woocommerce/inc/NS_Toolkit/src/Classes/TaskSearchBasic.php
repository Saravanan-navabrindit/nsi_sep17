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

class TaskSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $actualTime;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $completedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedTimeOverride;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
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
	public $isJobSummaryTask;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isJobTask;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPrivate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $milestone;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $percentComplete;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $percentTimeComplete;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $timeRemaining;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualTime' => 'SearchDoubleField',
		'assigned' => 'SearchMultiSelectField',
		'company' => 'SearchMultiSelectField',
		'completedDate' => 'SearchDateField',
		'contact' => 'SearchMultiSelectField',
		'createdDate' => 'SearchDateField',
		'endDate' => 'SearchDateField',
		'estimatedTime' => 'SearchDoubleField',
		'estimatedTimeOverride' => 'SearchDoubleField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isJobSummaryTask' => 'SearchBooleanField',
		'isJobTask' => 'SearchBooleanField',
		'isPrivate' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'milestone' => 'SearchLongField',
		'owner' => 'SearchMultiSelectField',
		'percentComplete' => 'SearchLongField',
		'percentTimeComplete' => 'SearchLongField',
		'priority' => 'SearchEnumMultiSelectField',
		'startDate' => 'SearchDateField',
		'status' => 'SearchEnumMultiSelectField',
		'timeRemaining' => 'SearchDoubleField',
		'title' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
