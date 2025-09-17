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

class ResourceAllocation extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $requestedby;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationApprovalStatus
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nextApprover;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $allocationResource;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $project;
	/**
	 * Var string
	 */
	public $notes;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var float
	 */
	public $allocationAmount;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationAllocationUnit
	 */
	public $allocationUnit;
	/**
	 * Var float
	 */
	public $numberHours;
	/**
	 * Var float
	 */
	public $percentOfTime;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $allocationType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
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
		'requestedby' => 'RecordRef',
		'approvalStatus' => 'ResourceAllocationApprovalStatus',
		'nextApprover' => 'RecordRef',
		'allocationResource' => 'RecordRef',
		'project' => 'RecordRef',
		'notes' => 'string',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'allocationAmount' => 'float',
		'allocationUnit' => 'ResourceAllocationAllocationUnit',
		'numberHours' => 'float',
		'percentOfTime' => 'float',
		'allocationType' => 'RecordRef',
		'customForm' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
