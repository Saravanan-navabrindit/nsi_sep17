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

class ProjectTaskSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $actualWork;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assignee;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $constraintType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costBase;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costBaseBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costBaseVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costVariancePercent;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $endDateVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWork;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWorkVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedWorkVariancePercent;
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
	public $finishByDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $id;
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
	public $isMilestone;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSummaryTask;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $nonBillableTask;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $percentWorkComplete;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $predecessor;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $predecessors;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $remainingWork;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $startDateVariance;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $successor;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actualWork' => 'SearchDoubleField',
		'assignee' => 'SearchMultiSelectField',
		'company' => 'SearchMultiSelectField',
		'constraintType' => 'SearchEnumMultiSelectField',
		'contact' => 'SearchMultiSelectField',
		'cost' => 'SearchDoubleField',
		'costBase' => 'SearchDoubleField',
		'costBaseBaseline' => 'SearchDoubleField',
		'costBaseline' => 'SearchDoubleField',
		'costBaseVariance' => 'SearchDoubleField',
		'costVariance' => 'SearchDoubleField',
		'costVariancePercent' => 'SearchDoubleField',
		'createdDate' => 'SearchDateField',
		'endDate' => 'SearchDateField',
		'endDateBaseline' => 'SearchDateField',
		'endDateVariance' => 'SearchDoubleField',
		'estimatedWork' => 'SearchDoubleField',
		'estimatedWorkBaseline' => 'SearchDoubleField',
		'estimatedWorkVariance' => 'SearchDoubleField',
		'estimatedWorkVariancePercent' => 'SearchDoubleField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'finishByDate' => 'SearchDateField',
		'id' => 'SearchLongField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isMilestone' => 'SearchBooleanField',
		'isSummaryTask' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'nonBillableTask' => 'SearchBooleanField',
		'owner' => 'SearchMultiSelectField',
		'parent' => 'SearchMultiSelectField',
		'percentWorkComplete' => 'SearchDoubleField',
		'plannedWork' => 'SearchDoubleField',
		'plannedWorkBaseline' => 'SearchDoubleField',
		'predecessor' => 'SearchMultiSelectField',
		'predecessors' => 'SearchStringField',
		'priority' => 'SearchEnumMultiSelectField',
		'remainingWork' => 'SearchDoubleField',
		'startDate' => 'SearchDateField',
		'startDateBaseline' => 'SearchDateField',
		'startDateVariance' => 'SearchDoubleField',
		'status' => 'SearchEnumMultiSelectField',
		'successor' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
