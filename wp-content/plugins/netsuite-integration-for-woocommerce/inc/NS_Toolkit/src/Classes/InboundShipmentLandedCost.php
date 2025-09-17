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

class InboundShipmentLandedCost {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $landedCostCostCategory;
	/**
	 * Var float
	 */
	public $landedCostAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $landedCostCurrency;
	/**
	 * Var float
	 */
	public $landedCostExchangeRate;
	/**
	 * Var string
	 */
	public $landedCostEffectiveDate;
	/**
	 * Var \NetSuite\Classes\InboundShipmentLandedCostAllocationMethod
	 */
	public $landedCostAllocationMethod;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $landedCostShipmentItemsList;
	public static $paramtypesmap = array(
		'landedCostCostCategory' => 'RecordRef',
		'landedCostAmount' => 'float',
		'landedCostCurrency' => 'RecordRef',
		'landedCostExchangeRate' => 'float',
		'landedCostEffectiveDate' => 'dateTime',
		'landedCostAllocationMethod' => 'InboundShipmentLandedCostAllocationMethod',
		'landedCostShipmentItemsList' => 'RecordRefList',
	);
}
