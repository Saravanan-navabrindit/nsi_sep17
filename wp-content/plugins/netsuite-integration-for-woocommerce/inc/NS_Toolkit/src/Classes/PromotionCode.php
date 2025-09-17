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

class PromotionCode extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $implementation;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\PromotionCodeUseType
	 */
	public $useType;
	/**
	 * Var boolean
	 */
	public $displayLineDiscounts;
	/**
	 * Var string
	 */
	public $code;
	/**
	 * Var string
	 */
	public $codePattern;
	/**
	 * Var integer
	 */
	public $numberToGenerate;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $locationList;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $discount;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var boolean
	 */
	public $discountType;
	/**
	 * Var \NetSuite\Classes\PromotionCodeApplyDiscountTo
	 */
	public $applyDiscountTo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $freeShipMethod;
	/**
	 * Var float
	 */
	public $minimumOrderAmount;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var boolean
	 */
	public $isPublic;
	/**
	 * Var \NetSuite\Classes\PromotionCodeCurrencyList
	 */
	public $currencyList;
	/**
	 * Var boolean
	 */
	public $excludeItems;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\PromotionCodeItemsList
	 */
	public $itemsList;
	/**
	 * Var \NetSuite\Classes\PromotionCodePartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'implementation' => 'RecordRef',
		'customForm' => 'RecordRef',
		'useType' => 'PromotionCodeUseType',
		'displayLineDiscounts' => 'boolean',
		'code' => 'string',
		'codePattern' => 'string',
		'numberToGenerate' => 'integer',
		'description' => 'string',
		'locationList' => 'RecordRefList',
		'isInactive' => 'boolean',
		'discount' => 'RecordRef',
		'rate' => 'string',
		'discountType' => 'boolean',
		'applyDiscountTo' => 'PromotionCodeApplyDiscountTo',
		'freeShipMethod' => 'RecordRef',
		'minimumOrderAmount' => 'float',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'isPublic' => 'boolean',
		'currencyList' => 'PromotionCodeCurrencyList',
		'excludeItems' => 'boolean',
		'name' => 'string',
		'itemsList' => 'PromotionCodeItemsList',
		'partnersList' => 'PromotionCodePartnersList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
