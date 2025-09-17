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

class PaycheckPayTax {
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var boolean
	 */
	public $apply;
	/**
	 * Var string
	 */
	public $payTax;
	/**
	 * Var integer
	 */
	public $payItem;
	/**
	 * Var float
	 */
	public $taxableWageBase;
	/**
	 * Var float
	 */
	public $taxedWageBase;
	/**
	 * Var float
	 */
	public $reportableWageBase;
	/**
	 * Var boolean
	 */
	public $isExempt;
	/**
	 * Var boolean
	 */
	public $isResidentTax;
	/**
	 * Var float
	 */
	public $amount;
	public static $paramtypesmap = array(
		'line' => 'integer',
		'apply' => 'boolean',
		'payTax' => 'string',
		'payItem' => 'integer',
		'taxableWageBase' => 'float',
		'taxedWageBase' => 'float',
		'reportableWageBase' => 'float',
		'isExempt' => 'boolean',
		'isResidentTax' => 'boolean',
		'amount' => 'float',
	);
}
