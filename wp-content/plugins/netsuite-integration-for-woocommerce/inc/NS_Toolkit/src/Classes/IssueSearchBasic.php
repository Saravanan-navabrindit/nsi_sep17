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

class IssueSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $ageInMonths;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buildBroken;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $buildBrokenName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buildFixed;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $buildFixedName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buildTarget;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $buildTargetName;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $caseCount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $caseNumber;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $closedDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateReleased;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $details;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $duplicateOf;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $eFix;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $employeeOrTeam;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $eventStatus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalAbstract;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalDetails;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalFixedIn;
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
	public $externalStatus;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $fixed;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $fixedBy;
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
	public $isOwner;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isReviewed;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isShowStopper;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $issueAbstract;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $issueNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $module;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $originalFixedIn;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $product;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $productTeam;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $relatedIssue;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $relationship;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $relationshipComment;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $reportedBy;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $reproduce;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $resolved;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $resolvedBy;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $reviewer;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $severity;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $tags;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $tracking;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $userType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $versionBroken;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $versionFixed;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $versionTarget;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'ageInMonths' => 'SearchLongField',
		'assigned' => 'SearchMultiSelectField',
		'buildBroken' => 'SearchMultiSelectField',
		'buildBrokenName' => 'SearchStringField',
		'buildFixed' => 'SearchMultiSelectField',
		'buildFixedName' => 'SearchStringField',
		'buildTarget' => 'SearchMultiSelectField',
		'buildTargetName' => 'SearchStringField',
		'caseCount' => 'SearchLongField',
		'caseNumber' => 'SearchStringField',
		'closedDate' => 'SearchDateField',
		'createdDate' => 'SearchDateField',
		'dateReleased' => 'SearchDateField',
		'details' => 'SearchStringField',
		'duplicateOf' => 'SearchMultiSelectField',
		'eFix' => 'SearchBooleanField',
		'employeeOrTeam' => 'SearchMultiSelectField',
		'eventStatus' => 'SearchEnumMultiSelectField',
		'externalAbstract' => 'SearchStringField',
		'externalDetails' => 'SearchStringField',
		'externalFixedIn' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'externalStatus' => 'SearchMultiSelectField',
		'fixed' => 'SearchDateField',
		'fixedBy' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isOwner' => 'SearchBooleanField',
		'isReviewed' => 'SearchBooleanField',
		'isShowStopper' => 'SearchBooleanField',
		'issueAbstract' => 'SearchStringField',
		'issueNumber' => 'SearchStringField',
		'item' => 'SearchMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'module' => 'SearchMultiSelectField',
		'number' => 'SearchLongField',
		'originalFixedIn' => 'SearchStringField',
		'priority' => 'SearchMultiSelectField',
		'product' => 'SearchMultiSelectField',
		'productTeam' => 'SearchMultiSelectField',
		'relatedIssue' => 'SearchMultiSelectField',
		'relationship' => 'SearchEnumMultiSelectField',
		'relationshipComment' => 'SearchStringField',
		'reportedBy' => 'SearchMultiSelectField',
		'reproduce' => 'SearchMultiSelectField',
		'resolved' => 'SearchDateField',
		'resolvedBy' => 'SearchMultiSelectField',
		'reviewer' => 'SearchMultiSelectField',
		'severity' => 'SearchMultiSelectField',
		'source' => 'SearchEnumMultiSelectField',
		'status' => 'SearchMultiSelectField',
		'tags' => 'SearchMultiSelectField',
		'tracking' => 'SearchBooleanField',
		'type' => 'SearchMultiSelectField',
		'userType' => 'SearchMultiSelectField',
		'versionBroken' => 'SearchMultiSelectField',
		'versionFixed' => 'SearchMultiSelectField',
		'versionTarget' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
