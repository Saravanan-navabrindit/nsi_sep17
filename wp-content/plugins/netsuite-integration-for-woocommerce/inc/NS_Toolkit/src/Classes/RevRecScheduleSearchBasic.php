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

class RevRecScheduleSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $amorStatus;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amortizedAmount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $amorType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $deferredAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $destAcct;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $initialAmt;
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
	public $isRecognized;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $jeDoc;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $pctComplete;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $pctRecognition;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $periodOffset;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $postPeriod;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $schedDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $scheduleNumber;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $scheduleNumberText;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $sourceAcct;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $srcTranPostPeriod;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $srcTranType;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $startOffset;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $templateName;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useForeignAmounts;
	public static $paramtypesmap = array(
		'accountingBook' => 'SearchMultiSelectField',
		'amorStatus' => 'SearchEnumMultiSelectField',
		'amortizedAmount' => 'SearchDoubleField',
		'amorType' => 'SearchEnumMultiSelectField',
		'amount' => 'SearchDoubleField',
		'currency' => 'SearchMultiSelectField',
		'deferredAmount' => 'SearchDoubleField',
		'destAcct' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'initialAmt' => 'SearchDoubleField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isRecognized' => 'SearchBooleanField',
		'jeDoc' => 'SearchMultiSelectField',
		'name' => 'SearchStringField',
		'pctComplete' => 'SearchDoubleField',
		'pctRecognition' => 'SearchDoubleField',
		'periodOffset' => 'SearchLongField',
		'postPeriod' => 'SearchMultiSelectField',
		'schedDate' => 'SearchDateField',
		'scheduleNumber' => 'SearchLongField',
		'scheduleNumberText' => 'SearchStringField',
		'sourceAcct' => 'SearchMultiSelectField',
		'srcTranPostPeriod' => 'SearchMultiSelectField',
		'srcTranType' => 'SearchMultiSelectField',
		'startOffset' => 'SearchLongField',
		'templateName' => 'SearchStringField',
		'useForeignAmounts' => 'SearchBooleanField',
	);
}
