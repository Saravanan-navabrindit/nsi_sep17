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

class ProjectTaskSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $actualWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $constraintType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costBase;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costBaseBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costBaseVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costVariancePercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $endDateVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWorkVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedWorkVariancePercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $finishByDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isMilestone;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSummaryTask;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $nonBillableTask;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $percentWorkComplete;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $predecessor;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $predecessorLagDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $predecessors;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $predecessorType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $remainingWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $startDateVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $successor;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $successorType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualWork' => 'SearchColumnDoubleField[]',
		'company' => 'SearchColumnSelectField[]',
		'constraintType' => 'SearchColumnEnumSelectField[]',
		'contact' => 'SearchColumnSelectField[]',
		'cost' => 'SearchColumnDoubleField[]',
		'costBase' => 'SearchColumnDoubleField[]',
		'costBaseBaseline' => 'SearchColumnDoubleField[]',
		'costBaseline' => 'SearchColumnDoubleField[]',
		'costBaseVariance' => 'SearchColumnDoubleField[]',
		'costVariance' => 'SearchColumnDoubleField[]',
		'costVariancePercent' => 'SearchColumnDoubleField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'endDate' => 'SearchColumnDateField[]',
		'endDateBaseline' => 'SearchColumnDateField[]',
		'endDateVariance' => 'SearchColumnDoubleField[]',
		'estimatedWork' => 'SearchColumnDoubleField[]',
		'estimatedWorkBaseline' => 'SearchColumnDoubleField[]',
		'estimatedWorkVariance' => 'SearchColumnDoubleField[]',
		'estimatedWorkVariancePercent' => 'SearchColumnDoubleField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'finishByDate' => 'SearchColumnDateField[]',
		'id' => 'SearchColumnLongField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isMilestone' => 'SearchColumnBooleanField[]',
		'isSummaryTask' => 'SearchColumnBooleanField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'message' => 'SearchColumnStringField[]',
		'nonBillableTask' => 'SearchColumnBooleanField[]',
		'owner' => 'SearchColumnSelectField[]',
		'parent' => 'SearchColumnSelectField[]',
		'percentWorkComplete' => 'SearchColumnDoubleField[]',
		'plannedWork' => 'SearchColumnDoubleField[]',
		'plannedWorkBaseline' => 'SearchColumnDoubleField[]',
		'predecessor' => 'SearchColumnSelectField[]',
		'predecessorLagDays' => 'SearchColumnDoubleField[]',
		'predecessors' => 'SearchColumnStringField[]',
		'predecessorType' => 'SearchColumnStringField[]',
		'priority' => 'SearchColumnEnumSelectField[]',
		'remainingWork' => 'SearchColumnDoubleField[]',
		'startDate' => 'SearchColumnDateField[]',
		'startDateBaseline' => 'SearchColumnDateField[]',
		'startDateVariance' => 'SearchColumnDoubleField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'successor' => 'SearchColumnSelectField[]',
		'successorType' => 'SearchColumnStringField[]',
		'title' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
