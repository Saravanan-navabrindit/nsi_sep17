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

class EmployeeDirectDeposit {
	/**
	 * Var integer
	 */
	public $id;
	/**
	 * Var boolean
	 */
	public $netAccount;
	/**
	 * Var boolean
	 */
	public $savingsAccount;
	/**
	 * Var boolean
	 */
	public $accountPrenoted;
	/**
	 * Var \NetSuite\Classes\EmployeeDirectDepositAccountStatus
	 */
	public $accountStatus;
	/**
	 * Var string
	 */
	public $bankName;
	/**
	 * Var string
	 */
	public $bankId;
	/**
	 * Var string
	 */
	public $bankNumber;
	/**
	 * Var string
	 */
	public $bankRoutingNumber;
	/**
	 * Var string
	 */
	public $bankAccountNumber;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var boolean
	 */
	public $inactive;
	public static $paramtypesmap = array(
		'id' => 'integer',
		'netAccount' => 'boolean',
		'savingsAccount' => 'boolean',
		'accountPrenoted' => 'boolean',
		'accountStatus' => 'EmployeeDirectDepositAccountStatus',
		'bankName' => 'string',
		'bankId' => 'string',
		'bankNumber' => 'string',
		'bankRoutingNumber' => 'string',
		'bankAccountNumber' => 'string',
		'amount' => 'float',
		'inactive' => 'boolean',
	);
}
