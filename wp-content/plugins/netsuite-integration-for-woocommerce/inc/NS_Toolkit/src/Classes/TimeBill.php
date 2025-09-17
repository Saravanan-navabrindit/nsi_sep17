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

class TimeBill extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employee;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $caseTaskEvent;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $payrollItem;
	/**
	 * Var boolean
	 */
	public $paidExternally;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workplace;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $hours;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $price;
	/**
	 * Var \NetSuite\Classes\TimeBillTimeType
	 */
	public $timeType;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var boolean
	 */
	public $overrideRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $temporaryLocalJurisdiction;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $temporaryStateJurisdiction;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var string
	 */
	public $rejectionNote;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var boolean
	 */
	public $supervisorApproval;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeSheet;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var boolean
	 */
	public $timeModified;
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
		'employee' => 'RecordRef',
		'tranDate' => 'dateTime',
		'approvalStatus' => 'RecordRef',
		'customer' => 'RecordRef',
		'caseTaskEvent' => 'RecordRef',
		'isBillable' => 'boolean',
		'payrollItem' => 'RecordRef',
		'paidExternally' => 'boolean',
		'workplace' => 'RecordRef',
		'item' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'hours' => 'Duration',
		'price' => 'RecordRef',
		'timeType' => 'TimeBillTimeType',
		'rate' => 'float',
		'overrideRate' => 'boolean',
		'temporaryLocalJurisdiction' => 'RecordRef',
		'temporaryStateJurisdiction' => 'RecordRef',
		'memo' => 'string',
		'rejectionNote' => 'string',
		'subsidiary' => 'RecordRef',
		'supervisorApproval' => 'boolean',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'timeSheet' => 'RecordRef',
		'status' => 'string',
		'timeModified' => 'boolean',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
