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

class ItemAccountingBookDetail {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createRevenuePlansOn;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revenueRecognitionRule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecForecastRule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var boolean
	 */
	public $sameAsPrimaryRevRec;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $amortizationTemplate;
	/**
	 * Var boolean
	 */
	public $sameAsPrimaryAmortization;
	public static $paramtypesmap = array(
		'accountingBook' => 'RecordRef',
		'createRevenuePlansOn' => 'RecordRef',
		'revenueRecognitionRule' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'sameAsPrimaryRevRec' => 'boolean',
		'amortizationTemplate' => 'RecordRef',
		'sameAsPrimaryAmortization' => 'boolean',
	);
}
