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

class PaymentMethod extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var boolean
	 */
	public $creditCard;
	/**
	 * Var boolean
	 */
	public $undepFunds;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $isOnline;
	/**
	 * Var \NetSuite\Classes\PaymentMethodVisualsList
	 */
	public $visualsList;
	/**
	 * Var boolean
	 */
	public $isDebitCard;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $merchantAccountsList;
	/**
	 * Var string
	 */
	public $payPalEmailAddress;
	/**
	 * Var string
	 */
	public $expressCheckoutArrangement;
	/**
	 * Var boolean
	 */
	public $useExpressCheckout;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'name' => 'string',
		'creditCard' => 'boolean',
		'undepFunds' => 'boolean',
		'account' => 'RecordRef',
		'isInactive' => 'boolean',
		'isOnline' => 'boolean',
		'visualsList' => 'PaymentMethodVisualsList',
		'isDebitCard' => 'boolean',
		'merchantAccountsList' => 'RecordRefList',
		'payPalEmailAddress' => 'string',
		'expressCheckoutArrangement' => 'string',
		'useExpressCheckout' => 'boolean',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
