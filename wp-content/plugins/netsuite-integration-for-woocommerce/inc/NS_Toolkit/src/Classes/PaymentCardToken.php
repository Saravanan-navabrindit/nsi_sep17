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

class PaymentCardToken extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var string
	 */
	public $mask;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\PaymentInstrumentState
	 */
	public $state;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $preserveOnFile;
	/**
	 * Var boolean
	 */
	public $isDefault;
	/**
	 * Var string
	 */
	public $token;
	/**
	 * Var string
	 */
	public $tokenExpirationDate;
	/**
	 * Var \NetSuite\Classes\TokenFamily
	 */
	public $tokenFamily;
	/**
	 * Var string
	 */
	public $tokenNamespace;
	/**
	 * Var string
	 */
	public $cardIssuerIdNumber;
	/**
	 * Var \NetSuite\Classes\PaymentCardBrand
	 */
	public $cardBrand;
	/**
	 * Var \NetSuite\Classes\PaymentCardType
	 */
	public $cardType;
	/**
	 * Var string
	 */
	public $cardNameOnCard;
	/**
	 * Var string
	 */
	public $cardLastFourDigits;
	/**
	 * Var string
	 */
	public $cardExpirationDate;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'entity' => 'RecordRef',
		'mask' => 'string',
		'paymentMethod' => 'RecordRef',
		'memo' => 'string',
		'state' => 'PaymentInstrumentState',
		'isInactive' => 'boolean',
		'preserveOnFile' => 'boolean',
		'isDefault' => 'boolean',
		'token' => 'string',
		'tokenExpirationDate' => 'dateTime',
		'tokenFamily' => 'TokenFamily',
		'tokenNamespace' => 'string',
		'cardIssuerIdNumber' => 'string',
		'cardBrand' => 'PaymentCardBrand',
		'cardType' => 'PaymentCardType',
		'cardNameOnCard' => 'string',
		'cardLastFourDigits' => 'string',
		'cardExpirationDate' => 'dateTime',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
