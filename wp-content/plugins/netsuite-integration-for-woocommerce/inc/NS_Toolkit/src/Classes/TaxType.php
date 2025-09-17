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

class TaxType extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var boolean
	 */
	public $doesNotAddToTotal;
	/**
	 * Var boolean
	 */
	public $postToItemCost;
	/**
	 * Var boolean
	 */
	public $taxInNetAmount;
	/**
	 * Var boolean
	 */
	public $reverseCharge;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\TaxTypeNexusAccountsList
	 */
	public $nexusAccountsList;
	/**
	 * Var \NetSuite\Classes\TaxTypeNexusesTaxList
	 */
	public $nexusesTaxList;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $country;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'name' => 'string',
		'description' => 'string',
		'doesNotAddToTotal' => 'boolean',
		'postToItemCost' => 'boolean',
		'taxInNetAmount' => 'boolean',
		'reverseCharge' => 'boolean',
		'isInactive' => 'boolean',
		'nexusAccountsList' => 'TaxTypeNexusAccountsList',
		'nexusesTaxList' => 'TaxTypeNexusesTaxList',
		'country' => 'Country',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
