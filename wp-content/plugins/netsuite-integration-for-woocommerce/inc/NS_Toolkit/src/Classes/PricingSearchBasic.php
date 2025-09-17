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

class PricingSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $assignedPriceLevel;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $maximumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $minimumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $rate;
	public static $paramtypesmap = array(
		'assignedPriceLevel' => 'SearchBooleanField',
		'currency' => 'SearchMultiSelectField',
		'customer' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'item' => 'SearchMultiSelectField',
		'maximumQuantity' => 'SearchDoubleField',
		'minimumQuantity' => 'SearchDoubleField',
		'priceLevel' => 'SearchMultiSelectField',
		'rate' => 'SearchDoubleField',
	);
}
