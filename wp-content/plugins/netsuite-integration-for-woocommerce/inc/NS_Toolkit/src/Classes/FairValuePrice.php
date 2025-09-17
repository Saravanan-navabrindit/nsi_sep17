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

class FairValuePrice extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemRevenueCategory;
	/**
	 * Var float
	 */
	public $fairValue;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $fairValueFormula;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\FairValuePriceFairValueRangePolicy
	 */
	public $fairValueRangePolicy;
	/**
	 * Var float
	 */
	public $lowValue;
	/**
	 * Var float
	 */
	public $lowValuePercent;
	/**
	 * Var float
	 */
	public $highValue;
	/**
	 * Var float
	 */
	public $highValuePercent;
	/**
	 * Var boolean
	 */
	public $isVsoePrice;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var \NetSuite\Classes\DimensionList
	 */
	public $dimensionList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'customForm' => 'RecordRef',
		'item' => 'RecordRef',
		'itemRevenueCategory' => 'RecordRef',
		'fairValue' => 'float',
		'fairValueFormula' => 'RecordRef',
		'currency' => 'RecordRef',
		'unitsType' => 'RecordRef',
		'units' => 'RecordRef',
		'fairValueRangePolicy' => 'FairValuePriceFairValueRangePolicy',
		'lowValue' => 'float',
		'lowValuePercent' => 'float',
		'highValue' => 'float',
		'highValuePercent' => 'float',
		'isVsoePrice' => 'boolean',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'customFieldList' => 'CustomFieldList',
		'dimensionList' => 'DimensionList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
