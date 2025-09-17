<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class SalesTaxItem extends Record {
	/**
	 * Var string
	 */
	public $itemId;
	/**
	 * Var string
	 */
	public $displayName;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxAgency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $saleAccount;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $effectiveFrom;
	/**
	 * Var string
	 */
	public $validUntil;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var boolean
	 */
	public $includeChildren;
	/**
	 * Var boolean
	 */
	public $eccode;
	/**
	 * Var boolean
	 */
	public $reverseCharge;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var boolean
	 */
	public $service;
	/**
	 * Var boolean
	 */
	public $exempt;
	/**
	 * Var boolean
	 */
	public $isDefault;
	/**
	 * Var boolean
	 */
	public $excludeFromTaxReports;
	/**
	 * Var \NetSuite\Classes\SalesTaxItemAvailable
	 */
	public $available;
	/**
	 * Var boolean
	 */
	public $export;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxAccount;
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
	public $state;
	/**
	 * Var string
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nexusCountry;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
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
		'displayName' => 'string',
		'description' => 'string',
		'rate' => 'string',
		'taxType' => 'RecordRef',
		'taxAgency' => 'RecordRef',
		'purchaseAccount' => 'RecordRef',
		'saleAccount' => 'RecordRef',
		'isInactive' => 'boolean',
		'effectiveFrom' => 'dateTime',
		'validUntil' => 'dateTime',
		'subsidiaryList' => 'RecordRefList',
		'includeChildren' => 'boolean',
		'eccode' => 'boolean',
		'reverseCharge' => 'boolean',
		'parent' => 'RecordRef',
		'service' => 'boolean',
		'exempt' => 'boolean',
		'isDefault' => 'boolean',
		'excludeFromTaxReports' => 'boolean',
		'available' => 'SalesTaxItemAvailable',
		'export' => 'boolean',
		'taxAccount' => 'RecordRef',
		'county' => 'string',
		'city' => 'string',
		'state' => 'string',
		'zip' => 'string',
		'nexusCountry' => 'RecordRef',
		'name' => 'string',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
