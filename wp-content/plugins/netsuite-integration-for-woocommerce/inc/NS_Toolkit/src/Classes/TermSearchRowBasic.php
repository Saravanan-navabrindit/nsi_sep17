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

class TermSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $dateDriven;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $dayDiscountExpires;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $dayOfMonthNetDue;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $daysUntilExpiry;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $daysUntilNetDue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $discountPercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $discountPercentDateDriven;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $dueNextMonthIfWithinDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $installment;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $preferred;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $recurrenceCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $recurrenceFrequency;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $repeatEvery;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $splitEvenly;
	public static $paramtypesmap = array(
		'dateDriven' => 'SearchColumnBooleanField[]',
		'dayDiscountExpires' => 'SearchColumnLongField[]',
		'dayOfMonthNetDue' => 'SearchColumnLongField[]',
		'daysUntilExpiry' => 'SearchColumnLongField[]',
		'daysUntilNetDue' => 'SearchColumnLongField[]',
		'discountPercent' => 'SearchColumnDoubleField[]',
		'discountPercentDateDriven' => 'SearchColumnDoubleField[]',
		'dueNextMonthIfWithinDays' => 'SearchColumnLongField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'installment' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'name' => 'SearchColumnStringField[]',
		'preferred' => 'SearchColumnBooleanField[]',
		'recurrenceCount' => 'SearchColumnLongField[]',
		'recurrenceFrequency' => 'SearchColumnStringField[]',
		'repeatEvery' => 'SearchColumnLongField[]',
		'splitEvenly' => 'SearchColumnBooleanField[]',
	);
}
