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

class AccountingPeriod extends Record {
	/**
	 * Var string
	 */
	public $periodName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $fiscalCalendar;
	/**
	 * Var string
	 */
	public $closedOnDate;
	/**
	 * Var boolean
	 */
	public $isAdjust;
	/**
	 * Var \NetSuite\Classes\AccountingPeriodFiscalCalendarsList
	 */
	public $fiscalCalendarsList;
	/**
	 * Var boolean
	 */
	public $isQuarter;
	/**
	 * Var boolean
	 */
	public $isYear;
	/**
	 * Var boolean
	 */
	public $closed;
	/**
	 * Var boolean
	 */
	public $apLocked;
	/**
	 * Var boolean
	 */
	public $arLocked;
	/**
	 * Var boolean
	 */
	public $payrollLocked;
	/**
	 * Var boolean
	 */
	public $allLocked;
	/**
	 * Var boolean
	 */
	public $allowNonGLChanges;
	/**
	 * Var string
	 */
	public $internalId;
	public static $paramtypesmap = array(
		'periodName' => 'string',
		'parent' => 'RecordRef',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'fiscalCalendar' => 'RecordRef',
		'closedOnDate' => 'dateTime',
		'isAdjust' => 'boolean',
		'fiscalCalendarsList' => 'AccountingPeriodFiscalCalendarsList',
		'isQuarter' => 'boolean',
		'isYear' => 'boolean',
		'closed' => 'boolean',
		'apLocked' => 'boolean',
		'arLocked' => 'boolean',
		'payrollLocked' => 'boolean',
		'allLocked' => 'boolean',
		'allowNonGLChanges' => 'boolean',
		'internalId' => 'string',
	);
}
