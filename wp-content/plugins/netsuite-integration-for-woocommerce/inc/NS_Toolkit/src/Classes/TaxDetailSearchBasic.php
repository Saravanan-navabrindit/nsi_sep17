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

class TaxDetailSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $lineNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $taxAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $taxBasis;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxCode;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $taxRate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $tranId;
	public static $paramtypesmap = array(
		'account' => 'SearchMultiSelectField',
		'lineNumber' => 'SearchLongField',
		'taxAmount' => 'SearchDoubleField',
		'taxBasis' => 'SearchDoubleField',
		'taxCode' => 'SearchMultiSelectField',
		'taxRate' => 'SearchDoubleField',
		'taxType' => 'SearchMultiSelectField',
		'tranId' => 'SearchMultiSelectField',
	);
}
