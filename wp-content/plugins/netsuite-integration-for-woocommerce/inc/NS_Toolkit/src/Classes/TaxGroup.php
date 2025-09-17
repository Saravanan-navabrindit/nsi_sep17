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

class TaxGroup extends Record {
	/**
	 * Var string
	 */
	public $itemId;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxitem1;
	/**
	 * Var string
	 */
	public $unitprice1;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxitem2;
	/**
	 * Var string
	 */
	public $unitprice2;
	/**
	 * Var boolean
	 */
	public $piggyback;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxType;
	/**
	 * Var boolean
	 */
	public $includeChildren;
	/**
	 * Var string
	 */
	public $county;
	/**
	 * Var string
	 */
	public $city;
	/**
	 * Var string
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nexusCountry;
	/**
	 * Var boolean
	 */
	public $isDefault;
	/**
	 * Var \NetSuite\Classes\TaxGroupTaxItemList
	 */
	public $taxItemList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'itemId' => 'string',
		'description' => 'string',
		'state' => 'string',
		'subsidiaryList' => 'RecordRefList',
		'taxitem1' => 'RecordRef',
		'unitprice1' => 'string',
		'taxitem2' => 'RecordRef',
		'unitprice2' => 'string',
		'piggyback' => 'boolean',
		'isInactive' => 'boolean',
		'rate' => 'float',
		'taxType' => 'RecordRef',
		'includeChildren' => 'boolean',
		'county' => 'string',
		'city' => 'string',
		'zip' => 'string',
		'nexusCountry' => 'RecordRef',
		'isDefault' => 'boolean',
		'taxItemList' => 'TaxGroupTaxItemList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
