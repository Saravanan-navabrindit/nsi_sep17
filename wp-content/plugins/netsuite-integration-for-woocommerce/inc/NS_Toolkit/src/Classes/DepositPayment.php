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

class DepositPayment {
	/**
	 * Var boolean
	 */
	public $deposit;
	/**
	 * Var integer
	 */
	public $id;
	/**
	 * Var string
	 */
	public $docDate;
	/**
	 * Var string
	 */
	public $type;
	/**
	 * Var string
	 */
	public $docNumber;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var string
	 */
	public $refNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $transactionAmount;
	/**
	 * Var float
	 */
	public $paymentAmount;
	/**
	 * Var integer
	 */
	public $lineId;
	public static $paramtypesmap = array(
		'deposit' => 'boolean',
		'id' => 'integer',
		'docDate' => 'dateTime',
		'type' => 'string',
		'docNumber' => 'string',
		'memo' => 'string',
		'paymentMethod' => 'RecordRef',
		'refNum' => 'string',
		'entity' => 'RecordRef',
		'currency' => 'RecordRef',
		'transactionAmount' => 'float',
		'paymentAmount' => 'float',
		'lineId' => 'integer',
	);
}
