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

class ResourceAllocationSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $allocationType;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $allocationUnit;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $nextApprover;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $notes;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $numberHours;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $percentOfTime;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $project;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $requestedBy;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $resource;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'allocationType' => 'SearchMultiSelectField',
		'allocationUnit' => 'SearchEnumMultiSelectField',
		'approvalStatus' => 'SearchEnumMultiSelectField',
		'customer' => 'SearchMultiSelectField',
		'endDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'nextApprover' => 'SearchMultiSelectField',
		'notes' => 'SearchStringField',
		'numberHours' => 'SearchDoubleField',
		'percentOfTime' => 'SearchDoubleField',
		'project' => 'SearchMultiSelectField',
		'requestedBy' => 'SearchMultiSelectField',
		'resource' => 'SearchMultiSelectField',
		'startDate' => 'SearchDateField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
