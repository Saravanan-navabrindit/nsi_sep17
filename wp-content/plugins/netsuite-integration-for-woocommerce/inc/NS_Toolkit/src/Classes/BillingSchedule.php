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

class BillingSchedule extends Record {
	/**
	 * Var \NetSuite\Classes\BillingScheduleType
	 */
	public $scheduleType;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\BillingScheduleRecurrencePattern
	 */
	public $recurrencePattern;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $project;
	/**
	 * Var string
	 */
	public $initialAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $initialTerms;
	/**
	 * Var \NetSuite\Classes\BillingScheduleFrequency
	 */
	public $frequency;
	/**
	 * Var \NetSuite\Classes\RecurrenceDowMaskList
	 */
	public $recurrenceDowMaskList;
	/**
	 * Var \NetSuite\Classes\BillingScheduleRecurrenceMode
	 */
	public $yearMode;
	/**
	 * Var \NetSuite\Classes\BillingScheduleYearDowim
	 */
	public $yearDowim;
	/**
	 * Var \NetSuite\Classes\BillingScheduleYearDow
	 */
	public $yearDow;
	/**
	 * Var \NetSuite\Classes\BillingScheduleYearDowimMonth
	 */
	public $yearDowimMonth;
	/**
	 * Var \NetSuite\Classes\BillingScheduleYearMonth
	 */
	public $yearMonth;
	/**
	 * Var integer
	 */
	public $yearDom;
	/**
	 * Var \NetSuite\Classes\BillingScheduleRecurrenceMode
	 */
	public $monthMode;
	/**
	 * Var \NetSuite\Classes\BillingScheduleMonthDowim
	 */
	public $monthDowim;
	/**
	 * Var \NetSuite\Classes\BillingScheduleMonthDow
	 */
	public $monthDow;
	/**
	 * Var integer
	 */
	public $monthDom;
	/**
	 * Var integer
	 */
	public $dayPeriod;
	/**
	 * Var \NetSuite\Classes\BillingScheduleRepeatEvery
	 */
	public $repeatEvery;
	/**
	 * Var boolean
	 */
	public $billForActuals;
	/**
	 * Var integer
	 */
	public $numberRemaining;
	/**
	 * Var boolean
	 */
	public $inArrears;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $recurrenceTerms;
	/**
	 * Var boolean
	 */
	public $isPublic;
	/**
	 * Var boolean
	 */
	public $applyToSubtotal;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transaction;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $seriesStartDate;
	/**
	 * Var \NetSuite\Classes\BillingScheduleRecurrenceList
	 */
	public $recurrenceList;
	/**
	 * Var \NetSuite\Classes\BillingScheduleMilestoneList
	 */
	public $milestoneList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'scheduleType' => 'BillingScheduleType',
		'name' => 'string',
		'recurrencePattern' => 'BillingScheduleRecurrencePattern',
		'project' => 'RecordRef',
		'initialAmount' => 'string',
		'initialTerms' => 'RecordRef',
		'frequency' => 'BillingScheduleFrequency',
		'recurrenceDowMaskList' => 'RecurrenceDowMaskList',
		'yearMode' => 'BillingScheduleRecurrenceMode',
		'yearDowim' => 'BillingScheduleYearDowim',
		'yearDow' => 'BillingScheduleYearDow',
		'yearDowimMonth' => 'BillingScheduleYearDowimMonth',
		'yearMonth' => 'BillingScheduleYearMonth',
		'yearDom' => 'integer',
		'monthMode' => 'BillingScheduleRecurrenceMode',
		'monthDowim' => 'BillingScheduleMonthDowim',
		'monthDow' => 'BillingScheduleMonthDow',
		'monthDom' => 'integer',
		'dayPeriod' => 'integer',
		'repeatEvery' => 'BillingScheduleRepeatEvery',
		'billForActuals' => 'boolean',
		'numberRemaining' => 'integer',
		'inArrears' => 'boolean',
		'recurrenceTerms' => 'RecordRef',
		'isPublic' => 'boolean',
		'applyToSubtotal' => 'boolean',
		'transaction' => 'RecordRef',
		'isInactive' => 'boolean',
		'seriesStartDate' => 'dateTime',
		'recurrenceList' => 'BillingScheduleRecurrenceList',
		'milestoneList' => 'BillingScheduleMilestoneList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
