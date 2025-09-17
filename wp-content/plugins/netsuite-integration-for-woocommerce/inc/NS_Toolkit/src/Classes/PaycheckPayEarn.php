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

class PaycheckPayEarn {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $payItem;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var float
	 */
	public $count;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $serviceItem;
	/**
	 * Var float
	 */
	public $grossAmount;
	/**
	 * Var boolean
	 */
	public $manualEntry;
	public static $paramtypesmap = array(
		'payItem' => 'RecordRef',
		'line' => 'integer',
		'count' => 'float',
		'rate' => 'string',
		'serviceItem' => 'RecordRef',
		'grossAmount' => 'float',
		'manualEntry' => 'boolean',
	);
}
