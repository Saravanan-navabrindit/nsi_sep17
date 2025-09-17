<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class CustomerCreditCards {
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $ccNumber;
	/**
	 * Var string
	 */
	public $ccExpireDate;
	/**
	 * Var string
	 */
	public $ccName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $cardState;
	/**
	 * Var string
	 */
	public $stateFrom;
	/**
	 * Var string
	 */
	public $debitcardIssueNo;
	/**
	 * Var string
	 */
	public $ccMemo;
	/**
	 * Var string
	 */
	public $validfrom;
	/**
	 * Var boolean
	 */
	public $ccDefault;
	public static $paramtypesmap = array(
		'internalId' => 'string',
		'ccNumber' => 'string',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'paymentMethod' => 'RecordRef',
		'cardState' => 'RecordRef',
		'stateFrom' => 'dateTime',
		'debitcardIssueNo' => 'string',
		'ccMemo' => 'string',
		'validfrom' => 'dateTime',
		'ccDefault' => 'boolean',
	);
}
