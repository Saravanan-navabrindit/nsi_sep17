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

class FairValuePriceSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
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
	public $fairValue;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $fairValueFormula;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $fairValueRangePolicy;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $highValue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $highValuePercent;
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
	public $isVsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemRevenueCategory;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $lowValue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $lowValuePercent;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $unitsType;
	public static $paramtypesmap = array(
		'currency' => 'SearchMultiSelectField',
		'endDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fairValue' => 'SearchDoubleField',
		'fairValueFormula' => 'SearchMultiSelectField',
		'fairValueRangePolicy' => 'SearchEnumMultiSelectField',
		'highValue' => 'SearchDoubleField',
		'highValuePercent' => 'SearchDoubleField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isVsoePrice' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'itemRevenueCategory' => 'SearchMultiSelectField',
		'lowValue' => 'SearchDoubleField',
		'lowValuePercent' => 'SearchDoubleField',
		'startDate' => 'SearchDateField',
		'unitsType' => 'SearchMultiSelectField',
	);
}
