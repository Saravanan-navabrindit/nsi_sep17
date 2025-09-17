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

class Nexus extends Record {
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxAgency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxAgencyPst;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parentNexus;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $taxDateFromFulfillment;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'country' => 'Country',
		'state' => 'RecordRef',
		'taxAgency' => 'RecordRef',
		'taxAgencyPst' => 'RecordRef',
		'taxCode' => 'RecordRef',
		'description' => 'string',
		'parentNexus' => 'RecordRef',
		'isInactive' => 'boolean',
		'taxDateFromFulfillment' => 'boolean',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
