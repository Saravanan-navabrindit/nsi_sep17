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

class PaymentInstrumentSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $cardBrand;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $cardExpDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $cardLastFourDigits;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $cardTokenCardBrand;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $cardTokenCardExpDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $cardTokenExpDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $cardTokenNameOnCard;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $default;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $generalTokenExpirationDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $lastFourDigits;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $mask;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $nameOnCard;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $paymentInstrumentStateType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $paymentInstrumentType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $paymentMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $preserveOnFile;
	public static $paramtypesmap = array(
		'cardBrand' => 'SearchColumnStringField[]',
		'cardExpDate' => 'SearchColumnDateField[]',
		'cardLastFourDigits' => 'SearchColumnStringField[]',
		'cardTokenCardBrand' => 'SearchColumnStringField[]',
		'cardTokenCardExpDate' => 'SearchColumnDateField[]',
		'cardTokenExpDate' => 'SearchColumnDateField[]',
		'cardTokenNameOnCard' => 'SearchColumnStringField[]',
		'default' => 'SearchColumnStringField[]',
		'entity' => 'SearchColumnSelectField[]',
		'generalTokenExpirationDate' => 'SearchColumnDateField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnStringField[]',
		'lastFourDigits' => 'SearchColumnStringField[]',
		'mask' => 'SearchColumnStringField[]',
		'nameOnCard' => 'SearchColumnStringField[]',
		'paymentInstrumentStateType' => 'SearchColumnSelectField[]',
		'paymentInstrumentType' => 'SearchColumnEnumSelectField[]',
		'paymentMethod' => 'SearchColumnSelectField[]',
		'preserveOnFile' => 'SearchColumnStringField[]',
	);
}
