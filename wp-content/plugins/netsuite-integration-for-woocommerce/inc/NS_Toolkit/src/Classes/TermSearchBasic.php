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

class TermSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $dateDriven;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $dayDiscountExpires;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $dayOfMonthNetDue;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $daysUntilExpiry;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $daysUntilNetDue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $discountPercent;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $discountPercentDateDriven;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $dueNextMonthIfWithinDays;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $installment;
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
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $preferred;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $recurrenceCount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $recurrenceFrequency;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $repeatEvery;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $splitEvenly;
	public static $paramtypesmap = array(
		'dateDriven' => 'SearchBooleanField',
		'dayDiscountExpires' => 'SearchLongField',
		'dayOfMonthNetDue' => 'SearchLongField',
		'daysUntilExpiry' => 'SearchLongField',
		'daysUntilNetDue' => 'SearchLongField',
		'discountPercent' => 'SearchDoubleField',
		'discountPercentDateDriven' => 'SearchDoubleField',
		'dueNextMonthIfWithinDays' => 'SearchLongField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'installment' => 'SearchBooleanField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'name' => 'SearchStringField',
		'preferred' => 'SearchBooleanField',
		'recurrenceCount' => 'SearchLongField',
		'recurrenceFrequency' => 'SearchEnumMultiSelectField',
		'repeatEvery' => 'SearchLongField',
		'splitEvenly' => 'SearchBooleanField',
	);
}
