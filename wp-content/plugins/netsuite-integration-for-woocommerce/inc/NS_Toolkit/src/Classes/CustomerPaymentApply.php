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

class CustomerPaymentApply {
	/**
	 * Var boolean
	 */
	public $apply;
	/**
	 * Var integer
	 */
	public $doc;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var string
	 */
	public $applyDate;
	/**
	 * Var string
	 */
	public $job;
	/**
	 * Var string
	 */
	public $type;
	/**
	 * Var string
	 */
	public $refNum;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var float
	 */
	public $due;
	/**
	 * Var string
	 */
	public $currency;
	/**
	 * Var string
	 */
	public $discDate;
	/**
	 * Var float
	 */
	public $discAmt;
	/**
	 * Var float
	 */
	public $disc;
	/**
	 * Var float
	 */
	public $amount;
	public static $paramtypesmap = array(
		'apply' => 'boolean',
		'doc' => 'integer',
		'line' => 'integer',
		'applyDate' => 'dateTime',
		'job' => 'string',
		'type' => 'string',
		'refNum' => 'string',
		'total' => 'float',
		'due' => 'float',
		'currency' => 'string',
		'discDate' => 'dateTime',
		'discAmt' => 'float',
		'disc' => 'float',
		'amount' => 'float',
	);
}
