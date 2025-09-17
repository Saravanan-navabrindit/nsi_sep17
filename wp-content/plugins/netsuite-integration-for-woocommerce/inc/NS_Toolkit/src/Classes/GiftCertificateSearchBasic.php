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

class GiftCertificateSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountAvailableBilled;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expirationDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertCode;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $incomeAccount;
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
	public $isActive;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $liabilityAccount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $originalAmount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $purchaseDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $sender;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amountAvailableBilled' => 'SearchDoubleField',
		'amountRemaining' => 'SearchDoubleField',
		'createdDate' => 'SearchDateField',
		'email' => 'SearchStringField',
		'expirationDate' => 'SearchDateField',
		'giftCertCode' => 'SearchStringField',
		'incomeAccount' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isActive' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'liabilityAccount' => 'SearchMultiSelectField',
		'message' => 'SearchStringField',
		'name' => 'SearchStringField',
		'originalAmount' => 'SearchDoubleField',
		'purchaseDate' => 'SearchDateField',
		'sender' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
