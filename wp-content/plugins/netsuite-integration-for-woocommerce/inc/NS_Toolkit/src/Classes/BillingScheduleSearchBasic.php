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

class BillingScheduleSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $applyToSubtotal;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $frequency;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $inArrears;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $initialAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $initialTerms;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPublic;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $recurrenceCount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $recurrencePattern;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $recurrenceTerms;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $repeatEvery;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $type;
	public static $paramtypesmap = array(
		'applyToSubtotal' => 'SearchBooleanField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'frequency' => 'SearchEnumMultiSelectField',
		'inArrears' => 'SearchBooleanField',
		'initialAmount' => 'SearchDoubleField',
		'initialTerms' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'isPublic' => 'SearchBooleanField',
		'name' => 'SearchStringField',
		'recurrenceCount' => 'SearchLongField',
		'recurrencePattern' => 'SearchEnumMultiSelectField',
		'recurrenceTerms' => 'SearchMultiSelectField',
		'repeatEvery' => 'SearchLongField',
		'type' => 'SearchEnumMultiSelectField',
	);
}
