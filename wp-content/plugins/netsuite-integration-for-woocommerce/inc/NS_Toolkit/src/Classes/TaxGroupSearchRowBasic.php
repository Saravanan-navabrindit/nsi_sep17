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

class TaxGroupSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $county;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isDefault;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $itemId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $piggyBack;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $stateDisplayName;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiaryNoHierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxItem1;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxItem2;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitPrice1;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitPrice2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $zip;
	public static $paramtypesmap = array(
		'city' => 'SearchColumnStringField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'county' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'includeChildren' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isDefault' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'itemId' => 'SearchColumnStringField[]',
		'piggyBack' => 'SearchColumnBooleanField[]',
		'rate' => 'SearchColumnDoubleField[]',
		'state' => 'SearchColumnSelectField[]',
		'stateDisplayName' => 'SearchColumnStringField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'subsidiaryNoHierarchy' => 'SearchColumnSelectField[]',
		'taxItem1' => 'SearchColumnSelectField[]',
		'taxItem2' => 'SearchColumnSelectField[]',
		'taxType' => 'SearchColumnSelectField[]',
		'unitPrice1' => 'SearchColumnDoubleField[]',
		'unitPrice2' => 'SearchColumnDoubleField[]',
		'zip' => 'SearchColumnStringField[]',
	);
}
