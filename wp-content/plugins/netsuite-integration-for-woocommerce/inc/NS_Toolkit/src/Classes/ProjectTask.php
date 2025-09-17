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

class ProjectTask extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $eventId;
	/**
	 * Var float
	 */
	public $percentTimeComplete;
	/**
	 * Var string
	 */
	public $title;
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
	public $order;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $priority;
	/**
	 * Var float
	 */
	public $estimatedWork;
	/**
	 * Var float
	 */
	public $estimatedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\ProjectTaskConstraintType
	 */
	public $constraintType;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $startDateBaseline;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $finishByDate;
	/**
	 * Var string
	 */
	public $endDateBaseline;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $actualWork;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $remainingWork;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var boolean
	 */
	public $isMilestone;
	/**
	 * Var string
	 */
	public $isOnCriticalPath;
	/**
	 * Var float
	 */
	public $slackMinutes;
	/**
	 * Var string
	 */
	public $lateEnd;
	/**
	 * Var string
	 */
	public $lateStart;
	/**
	 * Var \NetSuite\Classes\ProjectTaskStatus
	 */
	public $status;
	/**
	 * Var boolean
	 */
	public $nonBillableTask;
	/**
	 * Var \NetSuite\Classes\ProjectTaskAssigneeList
	 */
	public $assigneeList;
	/**
	 * Var \NetSuite\Classes\ProjectTaskPredecessorList
	 */
	public $predecessorList;
	/**
	 * Var \NetSuite\Classes\ProjectTaskTimeItemList
	 */
	public $timeItemList;
	/**
	 * Var float
	 */
	public $plannedWork;
	/**
	 * Var float
	 */
	public $plannedWorkBaseline;
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
		'customForm' => 'RecordRef',
		'eventId' => 'RecordRef',
		'percentTimeComplete' => 'float',
		'title' => 'string',
		'company' => 'RecordRef',
		'contact' => 'RecordRef',
		'order' => 'RecordRef',
		'owner' => 'RecordRef',
		'parent' => 'RecordRef',
		'priority' => 'RecordRef',
		'estimatedWork' => 'float',
		'estimatedWorkBaseline' => 'float',
		'constraintType' => 'ProjectTaskConstraintType',
		'startDate' => 'dateTime',
		'startDateBaseline' => 'dateTime',
		'endDate' => 'dateTime',
		'finishByDate' => 'dateTime',
		'endDateBaseline' => 'dateTime',
		'actualWork' => 'Duration',
		'remainingWork' => 'Duration',
		'message' => 'string',
		'isMilestone' => 'boolean',
		'isOnCriticalPath' => 'string',
		'slackMinutes' => 'float',
		'lateEnd' => 'dateTime',
		'lateStart' => 'dateTime',
		'status' => 'ProjectTaskStatus',
		'nonBillableTask' => 'boolean',
		'assigneeList' => 'ProjectTaskAssigneeList',
		'predecessorList' => 'ProjectTaskPredecessorList',
		'timeItemList' => 'ProjectTaskTimeItemList',
		'plannedWork' => 'float',
		'plannedWorkBaseline' => 'float',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
