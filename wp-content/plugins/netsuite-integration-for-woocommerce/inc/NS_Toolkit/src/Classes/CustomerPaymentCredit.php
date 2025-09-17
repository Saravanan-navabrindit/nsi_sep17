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

class CustomerPaymentCredit {
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
	public $creditDate;
	/**
	 * Var string
	 */
	public $type;
	/**
	 * Var string
	 */
	public $refNum;
	/**
	 * Var string
	 */
	public $appliedTo;
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
	 * Var float
	 */
	public $amount;
	public static $paramtypesmap = array(
		'apply' => 'boolean',
		'doc' => 'integer',
		'line' => 'integer',
		'creditDate' => 'dateTime',
		'type' => 'string',
		'refNum' => 'string',
		'appliedTo' => 'string',
		'total' => 'float',
		'due' => 'float',
		'currency' => 'string',
		'amount' => 'float',
	);
}
