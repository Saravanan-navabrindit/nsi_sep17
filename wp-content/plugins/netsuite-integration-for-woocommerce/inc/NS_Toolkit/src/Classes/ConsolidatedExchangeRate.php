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

class ConsolidatedExchangeRate extends Record {
	/**
	 * Var string
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $fromSubsidiary;
	/**
	 * Var string
	 */
	public $fromCurrency;
	/**
	 * Var string
	 */
	public $toSubsidiary;
	/**
	 * Var string
	 */
	public $toCurrency;
	/**
	 * Var float
	 */
	public $averageRate;
	/**
	 * Var float
	 */
	public $currentRate;
	/**
	 * Var float
	 */
	public $historicalRate;
	/**
	 * Var string
	 */
	public $accountingBook;
	/**
	 * Var boolean
	 */
	public $isPeriodClosed;
	/**
	 * Var boolean
	 */
	public $isDerived;
	/**
	 * Var boolean
	 */
	public $isEliminationSubsidiary;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'postingPeriod' => 'string',
		'fromSubsidiary' => 'string',
		'fromCurrency' => 'string',
		'toSubsidiary' => 'string',
		'toCurrency' => 'string',
		'averageRate' => 'float',
		'currentRate' => 'float',
		'historicalRate' => 'float',
		'accountingBook' => 'string',
		'isPeriodClosed' => 'boolean',
		'isDerived' => 'boolean',
		'isEliminationSubsidiary' => 'boolean',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
