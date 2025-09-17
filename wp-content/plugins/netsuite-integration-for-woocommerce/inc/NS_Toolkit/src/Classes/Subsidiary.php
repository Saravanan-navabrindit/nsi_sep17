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

class Subsidiary extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 Var	public $parent;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $showSubsidiaryName;
	/**
	 * Var string
	 */
	public $url;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $logo;
	/**
	 * Var string
	 */
	public $tranPrefix;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $pageLogo;
	/**
	 * Var string
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $mainAddress;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $shippingAddress;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $returnAddress;
	/**
	 * Var string
	 */
	public $legalName;
	/**
	 * Var boolean
	 */
	public $isElimination;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $fiscalCalendar;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxFiscalCalendar;
	/**
	 * Var boolean
	 */
	public $allowPayroll;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var float
	 */
	public $purchaseOrderAmount;
	/**
	 * Var float
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var float
	 */
	public $receiptQuantity;
	/**
	 * Var float
	 */
	public $receiptAmount;
	/**
	 * Var float
	 */
	public $receiptQuantityDiff;
	/**
	 * Var string
	 */
	public $fax;
	/**
	 * Var string
	 */
	public $edition;
	/**
	 * Var string
	 */
	public $federalIdNumber;
	/**
	 * Var string
	 */
	public $addrLanguage;
	/**
	 * Var string
	 */
	public $state1TaxNumber;
	/**
	 * Var \NetSuite\Classes\SubsidiaryTaxRegistrationList
	 */
	public $taxRegistrationList;
	/**
	 * Var string
	 */
	public $ssnOrTin;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $interCoAccount;
	/**
	 * Var \NetSuite\Classes\SubsidiaryNexusList
	 */
	public $nexusList;
	/**
	 * Var \NetSuite\Classes\SubsidiaryAccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $checkLayout;
	/**
	 * Var \NetSuite\Classes\ClassTranslationList
	 */
	public $classTranslationList;
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
		'name' => 'string',
		'parent' => 'RecordRef',
		'isInactive' => 'boolean',
		'showSubsidiaryName' => 'boolean',
		'url' => 'string',
		'logo' => 'RecordRef',
		'tranPrefix' => 'string',
		'pageLogo' => 'RecordRef',
		'state' => 'string',
		'country' => 'Country',
		'mainAddress' => 'Address',
		'shippingAddress' => 'Address',
		'returnAddress' => 'Address',
		'legalName' => 'string',
		'isElimination' => 'boolean',
		'fiscalCalendar' => 'RecordRef',
		'taxFiscalCalendar' => 'RecordRef',
		'allowPayroll' => 'boolean',
		'email' => 'string',
		'currency' => 'RecordRef',
		'purchaseOrderQuantity' => 'float',
		'purchaseOrderAmount' => 'float',
		'purchaseOrderQuantityDiff' => 'float',
		'receiptQuantity' => 'float',
		'receiptAmount' => 'float',
		'receiptQuantityDiff' => 'float',
		'fax' => 'string',
		'edition' => 'string',
		'federalIdNumber' => 'string',
		'addrLanguage' => 'string',
		'state1TaxNumber' => 'string',
		'taxRegistrationList' => 'SubsidiaryTaxRegistrationList',
		'ssnOrTin' => 'string',
		'interCoAccount' => 'RecordRef',
		'nexusList' => 'SubsidiaryNexusList',
		'accountingBookDetailList' => 'SubsidiaryAccountingBookDetailList',
		'checkLayout' => 'RecordRef',
		'classTranslationList' => 'ClassTranslationList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
