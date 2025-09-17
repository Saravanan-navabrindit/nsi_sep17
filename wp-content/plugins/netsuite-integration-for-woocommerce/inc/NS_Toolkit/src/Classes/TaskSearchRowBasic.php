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

class TaskSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $actualTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assigned;
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
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedTimeOverride;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isJobSummaryTask;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isJobTask;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
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
	public $milestone;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $order;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $percentComplete;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $percentTimeComplete;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
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
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $timeRemaining;
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
		'accessLevel' => 'SearchColumnStringField[]',
		'actualTime' => 'SearchColumnDoubleField[]',
		'assigned' => 'SearchColumnSelectField[]',
		'company' => 'SearchColumnSelectField[]',
		'completedDate' => 'SearchColumnDateField[]',
		'contact' => 'SearchColumnSelectField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'dueDate' => 'SearchColumnDateField[]',
		'estimatedTime' => 'SearchColumnDoubleField[]',
		'estimatedTimeOverride' => 'SearchColumnDoubleField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isJobSummaryTask' => 'SearchColumnBooleanField[]',
		'isJobTask' => 'SearchColumnBooleanField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'markdone' => 'SearchColumnStringField[]',
		'message' => 'SearchColumnStringField[]',
		'milestone' => 'SearchColumnSelectField[]',
		'order' => 'SearchColumnLongField[]',
		'owner' => 'SearchColumnSelectField[]',
		'percentComplete' => 'SearchColumnDoubleField[]',
		'percentTimeComplete' => 'SearchColumnDoubleField[]',
		'priority' => 'SearchColumnEnumSelectField[]',
		'startDate' => 'SearchColumnDateField[]',
		'startTime' => 'SearchColumnStringField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'timeRemaining' => 'SearchColumnDoubleField[]',
		'title' => 'SearchColumnStringField[]',
		'transaction' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
