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

class IssueSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $ageInMonths;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $buildBroken;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $buildFixed;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $buildTarget;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $caseCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $closedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateReleased;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $duplicateOf;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $employeeOrTeam;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $eventStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $externalAbstract;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $externalDetails;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $externalFixedIn;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $fixed;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $fixedBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isOwner;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isReviewed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isShowStopper;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $issueAbstract;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $issueStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $module;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $originalFixedIn;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $product;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $productTeam;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $relatedIssue;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $relationship;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $relationshipComment;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $reportedBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $reproduce;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $resolved;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $resolvedBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $reviewer;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $severity;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $tags;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $userType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $versionBroken;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $versionFixed;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $versionTarget;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'ageInMonths' => 'SearchColumnLongField[]',
		'assigned' => 'SearchColumnSelectField[]',
		'buildBroken' => 'SearchColumnSelectField[]',
		'buildFixed' => 'SearchColumnSelectField[]',
		'buildTarget' => 'SearchColumnSelectField[]',
		'caseCount' => 'SearchColumnLongField[]',
		'caseNumber' => 'SearchColumnStringField[]',
		'closedDate' => 'SearchColumnDateField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'dateReleased' => 'SearchColumnDateField[]',
		'duplicateOf' => 'SearchColumnSelectField[]',
		'employeeOrTeam' => 'SearchColumnSelectField[]',
		'eventStatus' => 'SearchColumnEnumSelectField[]',
		'externalAbstract' => 'SearchColumnStringField[]',
		'externalDetails' => 'SearchColumnStringField[]',
		'externalFixedIn' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'externalStatus' => 'SearchColumnSelectField[]',
		'fixed' => 'SearchColumnDateField[]',
		'fixedBy' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isOwner' => 'SearchColumnBooleanField[]',
		'isReviewed' => 'SearchColumnBooleanField[]',
		'isShowStopper' => 'SearchColumnBooleanField[]',
		'issueAbstract' => 'SearchColumnStringField[]',
		'issueStatus' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'module' => 'SearchColumnStringField[]',
		'number' => 'SearchColumnStringField[]',
		'originalFixedIn' => 'SearchColumnStringField[]',
		'priority' => 'SearchColumnSelectField[]',
		'product' => 'SearchColumnSelectField[]',
		'productTeam' => 'SearchColumnSelectField[]',
		'relatedIssue' => 'SearchColumnSelectField[]',
		'relationship' => 'SearchColumnEnumSelectField[]',
		'relationshipComment' => 'SearchColumnStringField[]',
		'reportedBy' => 'SearchColumnSelectField[]',
		'reproduce' => 'SearchColumnSelectField[]',
		'resolved' => 'SearchColumnDateField[]',
		'resolvedBy' => 'SearchColumnSelectField[]',
		'reviewer' => 'SearchColumnSelectField[]',
		'severity' => 'SearchColumnSelectField[]',
		'source' => 'SearchColumnEnumSelectField[]',
		'tags' => 'SearchColumnSelectField[]',
		'type' => 'SearchColumnStringField[]',
		'userType' => 'SearchColumnSelectField[]',
		'versionBroken' => 'SearchColumnSelectField[]',
		'versionFixed' => 'SearchColumnSelectField[]',
		'versionTarget' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
