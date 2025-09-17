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

class ResourceAllocationSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $allocationType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $allocationUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $nextApprover;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $notes;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $numberHours;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $percentOfTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $project;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $requestedBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $resource;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'allocationType' => 'SearchColumnSelectField[]',
		'allocationUnit' => 'SearchColumnEnumSelectField[]',
		'approvalStatus' => 'SearchColumnEnumSelectField[]',
		'customer' => 'SearchColumnSelectField[]',
		'endDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'nextApprover' => 'SearchColumnSelectField[]',
		'notes' => 'SearchColumnStringField[]',
		'numberHours' => 'SearchColumnDoubleField[]',
		'percentOfTime' => 'SearchColumnDoubleField[]',
		'project' => 'SearchColumnSelectField[]',
		'requestedBy' => 'SearchColumnSelectField[]',
		'resource' => 'SearchColumnSelectField[]',
		'startDate' => 'SearchColumnDateField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
