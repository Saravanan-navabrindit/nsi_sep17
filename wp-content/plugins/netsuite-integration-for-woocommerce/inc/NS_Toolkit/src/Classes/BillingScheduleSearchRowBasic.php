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

class BillingScheduleSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $applyToSubtotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $frequency;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $inArrears;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $initialAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $initialTerms;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isPublic;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $recurrenceCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $recurrencePattern;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $recurrenceTerms;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $repeatEvery;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $type;
	public static $paramtypesmap = array(
		'applyToSubtotal' => 'SearchColumnBooleanField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'frequency' => 'SearchColumnEnumSelectField[]',
		'inArrears' => 'SearchColumnBooleanField[]',
		'initialAmount' => 'SearchColumnStringField[]',
		'initialTerms' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isPublic' => 'SearchColumnBooleanField[]',
		'name' => 'SearchColumnStringField[]',
		'recurrenceCount' => 'SearchColumnLongField[]',
		'recurrencePattern' => 'SearchColumnEnumSelectField[]',
		'recurrenceTerms' => 'SearchColumnStringField[]',
		'repeatEvery' => 'SearchColumnLongField[]',
		'type' => 'SearchColumnEnumSelectField[]',
	);
}
