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

require_once 'Record.php';

class Address extends Record {
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $country;
	/**
	 * Var string
	 */
	public $attention;
	/**
	 * Var string
	 */
	public $addressee;
	/**
	 * Var string
	 */
	public $addrPhone;
	/**
	 * Var string
	 */
	public $addr1;
	/**
	 * Var string
	 */
	public $addr2;
	/**
	 * Var string
	 */
	public $addr3;
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
	 * Var string
	 */
	public $addrText;
	/**
	 * Var boolean
	 */
	public $override;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'internalId' => 'string',
		'country' => 'Country',
		'attention' => 'string',
		'addressee' => 'string',
		'addrPhone' => 'string',
		'addr1' => 'string',
		'addr2' => 'string',
		'addr3' => 'string',
		'city' => 'string',
		'state' => 'string',
		'zip' => 'string',
		'addrText' => 'string',
		'override' => 'boolean',
		'customFieldList' => 'CustomFieldList',
	);
}
