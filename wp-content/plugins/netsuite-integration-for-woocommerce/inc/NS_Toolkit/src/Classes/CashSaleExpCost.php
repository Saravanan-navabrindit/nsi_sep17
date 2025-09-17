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

class CashSaleExpCost {
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
	public $taxDetailsReference;
	/**
	 * Var string
	 */
	public $billedDate;
	/**
	 * Var string
	 */
	public $jobDisp;
	/**
	 * Var string
	 */
	public $employeeDisp;
	/**
	 * Var string
	 */
	public $categoryDisp;
	/**
	 * Var string
	 */
	public $memo;
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
	 * Var float
	 */
	public $originalAmount;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var float
	 */
	public $taxAmount;
	/**
	 * Var string
	 */
	public $taxableDisp;
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
		'taxDetailsReference' => 'string',
		'billedDate' => 'dateTime',
		'jobDisp' => 'string',
		'employeeDisp' => 'string',
		'categoryDisp' => 'string',
		'memo' => 'string',
		'department' => 'string',
		'class' => 'string',
		'location' => 'string',
		'originalAmount' => 'float',
		'amount' => 'float',
		'taxAmount' => 'float',
		'taxableDisp' => 'string',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'grossAmt' => 'float',
		'tax1Amt' => 'float',
		'taxCode' => 'RecordRef',
		'taxRate1' => 'float',
		'taxRate2' => 'float',
	);
}
