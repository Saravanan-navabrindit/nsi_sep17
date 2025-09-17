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

class PricingSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $maximumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $minimumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $quantityRange;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $saleUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitPrice;
	public static $paramtypesmap = array(
		'currency' => 'SearchColumnSelectField[]',
		'customer' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'maximumQuantity' => 'SearchColumnDoubleField[]',
		'minimumQuantity' => 'SearchColumnDoubleField[]',
		'priceLevel' => 'SearchColumnSelectField[]',
		'quantityRange' => 'SearchColumnStringField[]',
		'saleUnit' => 'SearchColumnSelectField[]',
		'unitPrice' => 'SearchColumnDoubleField[]',
	);
}
