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

class FairValuePriceSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fairValue;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $fairValueFormula;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $fairValueRangePolicy;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $highValue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $highValuePercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isVsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $itemRevenueCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $lowValue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $lowValuePercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $unitsType;
	public static $paramtypesmap = array(
		'currency' => 'SearchColumnSelectField[]',
		'endDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fairValue' => 'SearchColumnDoubleField[]',
		'fairValueFormula' => 'SearchColumnSelectField[]',
		'fairValueRangePolicy' => 'SearchColumnEnumSelectField[]',
		'highValue' => 'SearchColumnDoubleField[]',
		'highValuePercent' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isVsoePrice' => 'SearchColumnBooleanField[]',
		'item' => 'SearchColumnSelectField[]',
		'itemRevenueCategory' => 'SearchColumnSelectField[]',
		'lowValue' => 'SearchColumnDoubleField[]',
		'lowValuePercent' => 'SearchColumnDoubleField[]',
		'startDate' => 'SearchColumnDateField[]',
		'units' => 'SearchColumnSelectField[]',
		'unitsType' => 'SearchColumnSelectField[]',
	);
}
