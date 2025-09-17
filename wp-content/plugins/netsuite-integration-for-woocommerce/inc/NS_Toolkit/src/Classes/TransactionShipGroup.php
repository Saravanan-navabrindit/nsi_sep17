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

class TransactionShipGroup {
	/**
	 * Var integer
	 */
	public $id;
	/**
	 * Var boolean
	 */
	public $isFulfilled;
	/**
	 * Var float
	 */
	public $weight;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $sourceAddressRef;
	/**
	 * Var string
	 */
	public $sourceAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $destinationAddressRef;
	/**
	 * Var string
	 */
	public $destinationAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingMethodRef;
	/**
	 * Var string
	 */
	public $shippingMethod;
	/**
	 * Var boolean
	 */
	public $isHandlingTaxable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $handlingTaxCode;
	/**
	 * Var string
	 */
	public $handlingTaxRate;
	/**
	 * Var string
	 */
	public $handlingTax2Rate;
	/**
	 * Var float
	 */
	public $handlingRate;
	/**
	 * Var float
	 */
	public $handlingTaxAmt;
	/**
	 * Var float
	 */
	public $handlingTax2Amt;
	/**
	 * Var boolean
	 */
	public $isShippingTaxable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingTaxCode;
	/**
	 * Var string
	 */
	public $shippingTaxRate;
	/**
	 * Var string
	 */
	public $shippingTax2Rate;
	/**
	 * Var float
	 */
	public $shippingRate;
	/**
	 * Var float
	 */
	public $shippingTaxAmt;
	/**
	 * Var float
	 */
	public $shippingTax2Amt;
	public static $paramtypesmap = array(
		'id' => 'integer',
		'isFulfilled' => 'boolean',
		'weight' => 'float',
		'sourceAddressRef' => 'RecordRef',
		'sourceAddress' => 'string',
		'destinationAddressRef' => 'RecordRef',
		'destinationAddress' => 'string',
		'shippingMethodRef' => 'RecordRef',
		'shippingMethod' => 'string',
		'isHandlingTaxable' => 'boolean',
		'handlingTaxCode' => 'RecordRef',
		'handlingTaxRate' => 'string',
		'handlingTax2Rate' => 'string',
		'handlingRate' => 'float',
		'handlingTaxAmt' => 'float',
		'handlingTax2Amt' => 'float',
		'isShippingTaxable' => 'boolean',
		'shippingTaxCode' => 'RecordRef',
		'shippingTaxRate' => 'string',
		'shippingTax2Rate' => 'string',
		'shippingRate' => 'float',
		'shippingTaxAmt' => 'float',
		'shippingTax2Amt' => 'float',
	);
}
