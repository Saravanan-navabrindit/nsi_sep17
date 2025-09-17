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

class AccountingPeriodSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $allLocked;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $allowNonGlChanges;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $apLocked;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $arLocked;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $closed;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $closedOnDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isAdjust;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isQuarter;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isYear;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $payrollLocked;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $periodName;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	public static $paramtypesmap = array(
		'allLocked' => 'SearchBooleanField',
		'allowNonGlChanges' => 'SearchBooleanField',
		'apLocked' => 'SearchBooleanField',
		'arLocked' => 'SearchBooleanField',
		'closed' => 'SearchBooleanField',
		'closedOnDate' => 'SearchDateField',
		'endDate' => 'SearchDateField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isAdjust' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isQuarter' => 'SearchBooleanField',
		'isYear' => 'SearchBooleanField',
		'parent' => 'SearchMultiSelectField',
		'payrollLocked' => 'SearchBooleanField',
		'periodName' => 'SearchStringField',
		'startDate' => 'SearchDateField',
	);
}
