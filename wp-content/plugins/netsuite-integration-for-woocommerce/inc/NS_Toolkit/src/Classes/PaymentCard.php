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

class PaymentCard extends Record {
	/**
	 * Var string
	 */
	public $lastFourDigits;
	/**
	 * Var string
	 */
	public $issuerIdNumber;
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
	public $cardNumber;
	/**
	 * Var string
	 */
	public $expirationDate;
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
	public $nameOnCard;
	/**
	 * Var string
	 */
	public $street;
	/**
	 * Var string
	 */
	public $zipCode;
	/**
	 * Var string
	 */
	public $validFromDate;
	/**
	 * Var string
	 */
	public $issueNumber;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'lastFourDigits' => 'string',
		'issuerIdNumber' => 'string',
		'entity' => 'RecordRef',
		'mask' => 'string',
		'paymentMethod' => 'RecordRef',
		'memo' => 'string',
		'state' => 'PaymentInstrumentState',
		'isInactive' => 'boolean',
		'preserveOnFile' => 'boolean',
		'isDefault' => 'boolean',
		'cardNumber' => 'string',
		'expirationDate' => 'dateTime',
		'cardBrand' => 'PaymentCardBrand',
		'cardType' => 'PaymentCardType',
		'nameOnCard' => 'string',
		'street' => 'string',
		'zipCode' => 'string',
		'validFromDate' => 'dateTime',
		'issueNumber' => 'string',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
