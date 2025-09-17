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

class TaxDetails {
	/**
	 * Var string
	 */
	public $taxDetailsReference;
	/**
	 * Var string
	 */
	public $lineType;
	/**
	 * Var string
	 */
	public $lineName;
	/**
	 * Var float
	 */
	public $netAmount;
	/**
	 * Var float
	 */
	public $grossAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxCode;
	/**
	 * Var float
	 */
	public $taxBasis;
	/**
	 * Var float
	 */
	public $taxRate;
	/**
	 * Var float
	 */
	public $taxAmount;
	/**
	 * Var string
	 */
	public $calcDetail;
	public static $paramtypesmap = array(
		'taxDetailsReference' => 'string',
		'lineType' => 'string',
		'lineName' => 'string',
		'netAmount' => 'float',
		'grossAmount' => 'float',
		'taxType' => 'RecordRef',
		'taxCode' => 'RecordRef',
		'taxBasis' => 'float',
		'taxRate' => 'float',
		'taxAmount' => 'float',
		'calcDetail' => 'string',
	);
}
