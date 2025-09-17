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

class Issue extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $issueNumber;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $product;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $module;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $productTeam;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $reportedBy;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $reproduce;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $versionBroken;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buildBroken;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $versionTarget;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buildTarget;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $versionFixed;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buildFixed;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $severity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $priority;
	/**
	 * Var boolean
	 */
	public $isShowStopper;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $reviewer;
	/**
	 * Var boolean
	 */
	public $isReviewed;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueStatus;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $issueTagsList;
	/**
	 * Var string
	 */
	public $issueAbstract;
	/**
	 * Var string
	 */
	public $newDetails;
	/**
	 * Var boolean
	 */
	public $isOwner;
	/**
	 * Var \NetSuite\Classes\IssueTrackCode
	 */
	public $trackCode;
	/**
	 * Var boolean
	 */
	public $emailAssignee;
	/**
	 * Var \NetSuite\Classes\EmailEmployeesList
	 */
	public $emailEmployeesList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $emailCellsList;
	/**
	 * Var string
	 */
	public $externalAbstract;
	/**
	 * Var string
	 */
	public $externalDetails;
	/**
	 * Var \NetSuite\Classes\IssueVersionList
	 */
	public $brokenInVersionList;
	/**
	 * Var \NetSuite\Classes\IssueVersionList
	 */
	public $targetVersionList;
	/**
	 * Var \NetSuite\Classes\IssueVersionList
	 */
	public $fixedInVersionList;
	/**
	 * Var \NetSuite\Classes\IssueRelatedIssuesList
	 */
	public $relatedIssuesList;
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
		'issueNumber' => 'string',
		'createdDate' => 'dateTime',
		'issueType' => 'RecordRef',
		'product' => 'RecordRef',
		'module' => 'RecordRef',
		'item' => 'RecordRef',
		'productTeam' => 'RecordRef',
		'source' => 'RecordRef',
		'reportedBy' => 'RecordRef',
		'reproduce' => 'RecordRef',
		'versionBroken' => 'RecordRef',
		'buildBroken' => 'RecordRef',
		'versionTarget' => 'RecordRef',
		'buildTarget' => 'RecordRef',
		'versionFixed' => 'RecordRef',
		'buildFixed' => 'RecordRef',
		'severity' => 'RecordRef',
		'priority' => 'RecordRef',
		'isShowStopper' => 'boolean',
		'assigned' => 'RecordRef',
		'reviewer' => 'RecordRef',
		'isReviewed' => 'boolean',
		'issueStatus' => 'RecordRef',
		'lastModifiedDate' => 'dateTime',
		'issueTagsList' => 'RecordRefList',
		'issueAbstract' => 'string',
		'newDetails' => 'string',
		'isOwner' => 'boolean',
		'trackCode' => 'IssueTrackCode',
		'emailAssignee' => 'boolean',
		'emailEmployeesList' => 'EmailEmployeesList',
		'emailCellsList' => 'RecordRefList',
		'externalAbstract' => 'string',
		'externalDetails' => 'string',
		'brokenInVersionList' => 'IssueVersionList',
		'targetVersionList' => 'IssueVersionList',
		'fixedInVersionList' => 'IssueVersionList',
		'relatedIssuesList' => 'IssueRelatedIssuesList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
