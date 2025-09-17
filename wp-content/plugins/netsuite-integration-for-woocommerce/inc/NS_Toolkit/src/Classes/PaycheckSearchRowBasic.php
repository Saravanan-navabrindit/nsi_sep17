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

class PaycheckSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $amendedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $batchNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $checkDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $hasGLImpact;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $hours;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $payrollItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $payrollItemType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $subjectWages;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $taxableWages;
	public static $paramtypesmap = array(
		'account' => 'SearchColumnSelectField[]',
		'amendedDate' => 'SearchColumnDateField[]',
		'amount' => 'SearchColumnDoubleField[]',
		'batchNumber' => 'SearchColumnLongField[]',
		'checkDate' => 'SearchColumnDateField[]',
		'employee' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'hasGLImpact' => 'SearchColumnBooleanField[]',
		'hours' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'payrollItem' => 'SearchColumnSelectField[]',
		'payrollItemType' => 'SearchColumnSelectField[]',
		'subjectWages' => 'SearchColumnDoubleField[]',
		'taxableWages' => 'SearchColumnDoubleField[]',
	);
}
