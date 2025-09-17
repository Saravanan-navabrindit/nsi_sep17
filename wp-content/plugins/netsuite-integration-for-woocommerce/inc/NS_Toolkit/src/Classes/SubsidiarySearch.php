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

class SubsidiarySearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\AddressSearchBasic
	 */
	public $addressJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $defaultAdvanceToApplyAccountJoin;
	/**
	 * Var \NetSuite\Classes\AddressSearchBasic
	 */
	public $returnAddressJoin;
	/**
	 * Var \NetSuite\Classes\AddressSearchBasic
	 */
	public $shippingAddressJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'SubsidiarySearchBasic',
		'addressJoin' => 'AddressSearchBasic',
		'defaultAdvanceToApplyAccountJoin' => 'AccountSearchBasic',
		'returnAddressJoin' => 'AddressSearchBasic',
		'shippingAddressJoin' => 'AddressSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
