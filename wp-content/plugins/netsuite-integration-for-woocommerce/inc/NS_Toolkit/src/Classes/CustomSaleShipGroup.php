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

class CustomSaleShipGroup {
	/**
	 * Var string
	 */
	public $sourceAddress;
	/**
	 * Var string
	 */
	public $destinationAddress;
	/**
	 * Var string
	 */
	public $shippingMethod;
	/**
	 * Var float
	 */
	public $shippingRate;
	/**
	 * Var float
	 */
	public $handlingRate;
	/**
	 * Var integer
	 */
	public $id;
	/**
	 * Var string
	 */
	public $isFulfilled;
	/**
	 * Var float
	 */
	public $weight;
	/**
	 * Var string
	 */
	public $sourceAddressRef;
	/**
	 * Var string
	 */
	public $destinationAddressRef;
	/**
	 * Var string
	 */
	public $shippingMethodRef;
	public static $paramtypesmap = array(
		'sourceAddress' => 'string',
		'destinationAddress' => 'string',
		'shippingMethod' => 'string',
		'shippingRate' => 'float',
		'handlingRate' => 'float',
		'id' => 'integer',
		'isFulfilled' => 'string',
		'weight' => 'float',
		'sourceAddressRef' => 'string',
		'destinationAddressRef' => 'string',
		'shippingMethodRef' => 'string',
	);
}
