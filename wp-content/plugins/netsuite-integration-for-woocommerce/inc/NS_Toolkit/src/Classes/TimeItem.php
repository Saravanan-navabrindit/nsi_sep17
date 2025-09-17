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

class TimeItem {
	/**
	 * Var integer
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\TimeItemTimeType
	 */
	public $timeType;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customer;
	/**
	 * Var boolean
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $payrollItem;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $temporaryLocalJurisdiction;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $temporaryStateJurisdiction;
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
	 * Var float
	 */
	public $rate;
	/**
	 * Var boolean
	 */
	public $overrideRate;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $hoursTotal;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $caseTaskEvent;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $isUtilized;
	/**
	 * Var boolean
	 */
	public $isProductive;
	/**
	 * Var boolean
	 */
	public $isExempt;
	public static $paramtypesmap = array(
		'id' => 'integer',
		'employee' => 'RecordRef',
		'timeType' => 'TimeItemTimeType',
		'tranDate' => 'dateTime',
		'customer' => 'RecordRef',
		'isBillable' => 'boolean',
		'payrollItem' => 'RecordRef',
		'item' => 'RecordRef',
		'temporaryLocalJurisdiction' => 'RecordRef',
		'temporaryStateJurisdiction' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'hours' => 'Duration',
		'price' => 'RecordRef',
		'rate' => 'float',
		'overrideRate' => 'boolean',
		'hoursTotal' => 'Duration',
		'caseTaskEvent' => 'RecordRef',
		'memo' => 'string',
		'isUtilized' => 'boolean',
		'isProductive' => 'boolean',
		'isExempt' => 'boolean',
	);
}
