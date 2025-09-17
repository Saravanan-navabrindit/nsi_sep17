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

class CashSaleTime {
	/**
	 * Var boolean
	 */
	public $apply;
	/**
	 * Var integer
	 */
	public $doc;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var string
	 */
	public $billedDate;
	/**
	 * Var string
	 */
	public $employeeDisp;
	/**
	 * Var string
	 */
	public $itemDisp;
	/**
	 * Var string
	 */
	public $jobDisp;
	/**
	 * Var string
	 */
	public $department;
	/**
	 * Var string
	 */
	public $class;
	/**
	 * Var string
	 */
	public $location;
	/**
	 * Var string
	 */
	public $quantity;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var string
	 */
	public $unitDisp;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var float
	 */
	public $taxAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var string
	 */
	public $revRecStartDate;
	/**
	 * Var string
	 */
	public $revRecEndDate;
	/**
	 * Var float
	 */
	public $grossAmt;
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var float
	 */
	public $tax1Amt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var float
	 */
	public $taxRate1;
	/**
	 * Var float
	 */
	public $taxRate2;
	public static $paramtypesmap = array(
		'apply' => 'boolean',
		'doc' => 'integer',
		'line' => 'integer',
		'billedDate' => 'dateTime',
		'employeeDisp' => 'string',
		'itemDisp' => 'string',
		'jobDisp' => 'string',
		'department' => 'string',
		'class' => 'string',
		'location' => 'string',
		'quantity' => 'string',
		'rate' => 'float',
		'unitDisp' => 'string',
		'amount' => 'float',
		'memo' => 'string',
		'taxAmount' => 'float',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'grossAmt' => 'float',
		'taxDetailsReference' => 'string',
		'tax1Amt' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
	);
}
