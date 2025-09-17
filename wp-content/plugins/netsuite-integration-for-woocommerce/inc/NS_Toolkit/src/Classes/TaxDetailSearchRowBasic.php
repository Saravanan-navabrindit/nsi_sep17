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

class TaxDetailSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $details;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $lineNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $taxAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $taxBasis;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $taxRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxType;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $tranId;
	public static $paramtypesmap = array(
		'account' => 'SearchColumnStringField[]',
		'details' => 'SearchColumnStringField[]',
		'lineNumber' => 'SearchColumnLongField[]',
		'taxAmount' => 'SearchColumnDoubleField[]',
		'taxBasis' => 'SearchColumnDoubleField[]',
		'taxCode' => 'SearchColumnSelectField[]',
		'taxRate' => 'SearchColumnDoubleField[]',
		'taxType' => 'SearchColumnSelectField[]',
		'tranId' => 'SearchColumnLongField[]',
	);
}
