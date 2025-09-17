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

class AccountingPeriodSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allLocked;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allowNonGLChanges;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $apLocked;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $arLocked;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $closed;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $closedOnDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isAdjust;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isQuarter;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isYear;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $payrollLocked;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $periodName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	public static $paramtypesmap = array(
		'allLocked' => 'SearchColumnBooleanField[]',
		'allowNonGLChanges' => 'SearchColumnBooleanField[]',
		'apLocked' => 'SearchColumnBooleanField[]',
		'arLocked' => 'SearchColumnBooleanField[]',
		'closed' => 'SearchColumnBooleanField[]',
		'closedOnDate' => 'SearchColumnDateField[]',
		'endDate' => 'SearchColumnDateField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isAdjust' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isQuarter' => 'SearchColumnBooleanField[]',
		'isYear' => 'SearchColumnBooleanField[]',
		'parent' => 'SearchColumnSelectField[]',
		'payrollLocked' => 'SearchColumnBooleanField[]',
		'periodName' => 'SearchColumnStringField[]',
		'startDate' => 'SearchColumnDateField[]',
	);
}
