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

class RevRecSchedule extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\RevRecScheduleAmortizationType
	 */
	public $amortizationType;
	/**
	 * Var \NetSuite\Classes\RevRecScheduleRecurrenceType
	 */
	public $recurrenceType;
	/**
	 * Var \NetSuite\Classes\RevRecScheduleRecogIntervalSrc
	 */
	public $recogIntervalSrc;
	/**
	 * Var integer
	 */
	public $amortizationPeriod;
	/**
	 * Var integer
	 */
	public $periodOffset;
	/**
	 * Var integer
	 */
	public $revRecOffset;
	/**
	 * Var float
	 */
	public $initialAmount;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\RevRecScheduleRecurrenceList
	 */
	public $recurrenceList;
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
		'amortizationType' => 'RevRecScheduleAmortizationType',
		'recurrenceType' => 'RevRecScheduleRecurrenceType',
		'recogIntervalSrc' => 'RevRecScheduleRecogIntervalSrc',
		'amortizationPeriod' => 'integer',
		'periodOffset' => 'integer',
		'revRecOffset' => 'integer',
		'initialAmount' => 'float',
		'isInactive' => 'boolean',
		'recurrenceList' => 'RevRecScheduleRecurrenceList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
