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

class MseSubsidiarySearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBookCurrency;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $address;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $effectiveFrom;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $fax;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isElimination;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $legalName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $nameNoHierarchy;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $primary;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $receiptAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $receiptQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $receiptQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxEngine;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $taxIdNum;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $taxRegistrationNumber;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $tranPrefix;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $url;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $validUntil;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountingBook' => 'SearchMultiSelectField',
		'accountingBookCurrency' => 'SearchMultiSelectField',
		'address' => 'SearchStringField',
		'city' => 'SearchStringField',
		'country' => 'SearchEnumMultiSelectField',
		'currency' => 'SearchMultiSelectField',
		'effectiveFrom' => 'SearchDateField',
		'email' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fax' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isElimination' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'legalName' => 'SearchStringField',
		'name' => 'SearchStringField',
		'nameNoHierarchy' => 'SearchStringField',
		'nexus' => 'SearchMultiSelectField',
		'phone' => 'SearchStringField',
		'primary' => 'SearchBooleanField',
		'purchaseOrderAmount' => 'SearchDoubleField',
		'purchaseOrderQuantity' => 'SearchDoubleField',
		'purchaseOrderQuantityDiff' => 'SearchDoubleField',
		'receiptAmount' => 'SearchDoubleField',
		'receiptQuantity' => 'SearchDoubleField',
		'receiptQuantityDiff' => 'SearchDoubleField',
		'state' => 'SearchStringField',
		'subsidiary' => 'SearchMultiSelectField',
		'taxEngine' => 'SearchMultiSelectField',
		'taxIdNum' => 'SearchStringField',
		'taxRegistrationNumber' => 'SearchStringField',
		'tranPrefix' => 'SearchStringField',
		'url' => 'SearchStringField',
		'validUntil' => 'SearchDateField',
		'zip' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
