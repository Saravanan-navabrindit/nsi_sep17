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

class TaxTypeSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $doesNotAddToTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $payablesAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $postToItemCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $receivablesAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $reverseCharge;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $taxInNetAmount;
	public static $paramtypesmap = array(
		'country' => 'SearchColumnEnumSelectField[]',
		'description' => 'SearchColumnStringField[]',
		'doesNotAddToTotal' => 'SearchColumnBooleanField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'name' => 'SearchColumnStringField[]',
		'nexus' => 'SearchColumnSelectField[]',
		'payablesAccount' => 'SearchColumnSelectField[]',
		'postToItemCost' => 'SearchColumnBooleanField[]',
		'receivablesAccount' => 'SearchColumnSelectField[]',
		'reverseCharge' => 'SearchColumnBooleanField[]',
		'taxInNetAmount' => 'SearchColumnBooleanField[]',
	);
}
