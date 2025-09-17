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

class Term extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var boolean
	 */
	public $dateDriven;
	/**
	 * Var integer
	 */
	public $daysUntilNetDue;
	/**
	 * Var float
	 */
	public $discountPercent;
	/**
	 * Var integer
	 */
	public $daysUntilExpiry;
	/**
	 * Var integer
	 */
	public $dayOfMonthNetDue;
	/**
	 * Var integer
	 */
	public $dueNextMonthIfWithinDays;
	/**
	 * Var float
	 */
	public $discountPercentDateDriven;
	/**
	 * Var integer
	 */
	public $dayDiscountExpires;
	/**
	 * Var boolean
	 */
	public $preferred;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $installment;
	/**
	 * Var \NetSuite\Classes\TermRecurrenceFrequency
	 */
	public $recurrenceFrequency;
	/**
	 * Var integer
	 */
	public $recurrenceCount;
	/**
	 * Var integer
	 */
	public $repeatEvery;
	/**
	 * Var boolean
	 */
	public $splitEvenly;
	/**
	 * Var \NetSuite\Classes\TermPercentagesList
	 */
	public $percentagesList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'name' => 'string',
		'dateDriven' => 'boolean',
		'daysUntilNetDue' => 'integer',
		'discountPercent' => 'float',
		'daysUntilExpiry' => 'integer',
		'dayOfMonthNetDue' => 'integer',
		'dueNextMonthIfWithinDays' => 'integer',
		'discountPercentDateDriven' => 'float',
		'dayDiscountExpires' => 'integer',
		'preferred' => 'boolean',
		'isInactive' => 'boolean',
		'installment' => 'boolean',
		'recurrenceFrequency' => 'TermRecurrenceFrequency',
		'recurrenceCount' => 'integer',
		'repeatEvery' => 'integer',
		'splitEvenly' => 'boolean',
		'percentagesList' => 'TermPercentagesList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
