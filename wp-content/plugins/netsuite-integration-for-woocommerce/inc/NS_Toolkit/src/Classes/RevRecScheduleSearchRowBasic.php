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

class RevRecScheduleSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $amorStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $amorTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amortizedAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $amorType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $deferredAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $destAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $initialAmt;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isRecognized;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $jeDoc;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $lineSequenceNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $nameUrl;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $pctComplete;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $pctRecognition;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $periodOffset;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recurAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recurFxAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $schedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $scheduleNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $sourceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $srcDocLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $srcTran;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $srcTranPostPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $startOffset;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useForeignAmounts;
	public static $paramtypesmap = array(
		'accountingBook' => 'SearchColumnSelectField[]',
		'amorStatus' => 'SearchColumnEnumSelectField[]',
		'amorTemplate' => 'SearchColumnStringField[]',
		'amortizedAmount' => 'SearchColumnDoubleField[]',
		'amorType' => 'SearchColumnEnumSelectField[]',
		'amount' => 'SearchColumnDoubleField[]',
		'currency' => 'SearchColumnStringField[]',
		'deferredAmount' => 'SearchColumnDoubleField[]',
		'destAcct' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'initialAmt' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isRecognized' => 'SearchColumnBooleanField[]',
		'jeDoc' => 'SearchColumnStringField[]',
		'lineSequenceNumber' => 'SearchColumnLongField[]',
		'name' => 'SearchColumnStringField[]',
		'nameUrl' => 'SearchColumnStringField[]',
		'pctComplete' => 'SearchColumnDoubleField[]',
		'pctRecognition' => 'SearchColumnDoubleField[]',
		'periodOffset' => 'SearchColumnLongField[]',
		'recurAmount' => 'SearchColumnDoubleField[]',
		'recurFxAmount' => 'SearchColumnDoubleField[]',
		'schedDate' => 'SearchColumnDateField[]',
		'scheduleNumber' => 'SearchColumnStringField[]',
		'sourceAcct' => 'SearchColumnStringField[]',
		'srcDocLine' => 'SearchColumnStringField[]',
		'srcTran' => 'SearchColumnStringField[]',
		'srcTranPostPeriod' => 'SearchColumnStringField[]',
		'startOffset' => 'SearchColumnLongField[]',
		'useForeignAmounts' => 'SearchColumnBooleanField[]',
	);
}
