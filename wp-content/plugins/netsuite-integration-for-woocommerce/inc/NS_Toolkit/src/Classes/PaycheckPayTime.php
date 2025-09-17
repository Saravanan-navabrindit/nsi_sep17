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

class PaycheckPayTime {
	/**
	 * Var boolean
	 */
	public $apply;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var integer
	 */
	public $payItem;
	/**
	 * Var string
	 */
	public $payItemName;
	/**
	 * Var string
	 */
	public $ddate;
	/**
	 * Var string
	 */
	public $custJob;
	/**
	 * Var string
	 */
	public $serviceItem;
	/**
	 * Var float
	 */
	public $count;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $amount;
	public static $paramtypesmap = array(
		'apply' => 'boolean',
		'line' => 'integer',
		'payItem' => 'integer',
		'payItemName' => 'string',
		'ddate' => 'dateTime',
		'custJob' => 'string',
		'serviceItem' => 'string',
		'count' => 'float',
		'rate' => 'float',
		'amount' => 'float',
	);
}
