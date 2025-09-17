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

class Currency extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $symbol;
	/**
	 * Var boolean
	 */
	public $isBaseCurrency;
	/**
	 * Var boolean
	 */
	public $isInactive;
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
	/**
	 * Var \NetSuite\Classes\CurrencyLocale
	 */
	public $locale;
	/**
	 * Var string
	 */
	public $formatSample;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\CurrencyFxRateUpdateTimezone
	 */
	public $fxRateUpdateTimezone;
	/**
	 * Var boolean
	 */
	public $inclInFxRateUpdates;
	/**
	 * Var \NetSuite\Classes\CurrencyCurrencyPrecision
	 */
	public $currencyPrecision;
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
		'symbol' => 'string',
		'isBaseCurrency' => 'boolean',
		'isInactive' => 'boolean',
		'overrideCurrencyFormat' => 'boolean',
		'displaySymbol' => 'string',
		'symbolPlacement' => 'CurrencySymbolPlacement',
		'locale' => 'CurrencyLocale',
		'formatSample' => 'string',
		'exchangeRate' => 'float',
		'fxRateUpdateTimezone' => 'CurrencyFxRateUpdateTimezone',
		'inclInFxRateUpdates' => 'boolean',
		'currencyPrecision' => 'CurrencyCurrencyPrecision',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
