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

class TimeEntry extends Record {
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $hours;
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
	public $customer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $caseTaskEvent;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
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
	public $price;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var boolean
	 */
	public $overrideRate;
	/**
	 * Var string
	 */
	public $memo;
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
	 * Var string
	 */
	public $billingClass;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\TimeBillTimeType
	 */
	public $timeType;
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
		'hours' => 'Duration',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'customer' => 'RecordRef',
		'caseTaskEvent' => 'RecordRef',
		'item' => 'RecordRef',
		'isBillable' => 'boolean',
		'payrollItem' => 'RecordRef',
		'paidExternally' => 'boolean',
		'price' => 'RecordRef',
		'rate' => 'float',
		'overrideRate' => 'boolean',
		'memo' => 'string',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'billingClass' => 'string',
		'subsidiary' => 'RecordRef',
		'approvalStatus' => 'RecordRef',
		'timeType' => 'TimeBillTimeType',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
