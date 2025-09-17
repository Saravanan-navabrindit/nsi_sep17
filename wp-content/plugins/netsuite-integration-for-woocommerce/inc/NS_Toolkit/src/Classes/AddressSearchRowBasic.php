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

class AddressSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address3;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $addressee;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $attention;
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
	public $countryCode;
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
	public $override;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'address' => 'SearchColumnStringField[]',
		'address1' => 'SearchColumnStringField[]',
		'address2' => 'SearchColumnStringField[]',
		'address3' => 'SearchColumnStringField[]',
		'addressee' => 'SearchColumnStringField[]',
		'attention' => 'SearchColumnStringField[]',
		'city' => 'SearchColumnStringField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'countryCode' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'override' => 'SearchColumnBooleanField[]',
		'phone' => 'SearchColumnStringField[]',
		'state' => 'SearchColumnStringField[]',
		'zip' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
