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

class CustomerCurrency {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var float
	 */
	public $consolBalance;
	/**
	 * Var float
	 */
	public $depositBalance;
	/**
	 * Var float
	 */
	public $consolDepositBalance;
	/**
	 * Var float
	 */
	public $overdueBalance;
	/**
	 * Var float
	 */
	public $consolOverdueBalance;
	/**
	 * Var float
	 */
	public $unbilledOrders;
	/**
	 * Var float
	 */
	public $consolUnbilledOrders;
	/**
	 * Var boolean
	 */
	public $overrideCurrencyFormat;
	/**
	 * Var string
	 */
	public $displaySymbol;
	/**
	 * Var \NetSuite\Classes\CurrencySymbolPlacement
	 */
	public $symbolPlacement;
	public static $paramtypesmap = array(
		'currency' => 'RecordRef',
		'balance' => 'float',
		'consolBalance' => 'float',
		'depositBalance' => 'float',
		'consolDepositBalance' => 'float',
		'overdueBalance' => 'float',
		'consolOverdueBalance' => 'float',
		'unbilledOrders' => 'float',
		'consolUnbilledOrders' => 'float',
		'overrideCurrencyFormat' => 'boolean',
		'displaySymbol' => 'string',
		'symbolPlacement' => 'CurrencySymbolPlacement',
	);
}
