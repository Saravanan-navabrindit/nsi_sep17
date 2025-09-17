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

class NexusSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parentNexus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxAgency;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $taxDateFromFulfillment;
	public static $paramtypesmap = array(
		'country' => 'SearchColumnEnumSelectField[]',
		'description' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'parentNexus' => 'SearchColumnSelectField[]',
		'state' => 'SearchColumnSelectField[]',
		'taxAgency' => 'SearchColumnSelectField[]',
		'taxDateFromFulfillment' => 'SearchColumnBooleanField[]',
	);
}
