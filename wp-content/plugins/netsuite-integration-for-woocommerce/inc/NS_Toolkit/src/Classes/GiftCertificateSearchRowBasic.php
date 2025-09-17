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

class GiftCertificateSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amtAvailBilled;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expirationDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $gcActive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $incomeAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $liabilityAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $originalAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $purchaseDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $sender;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amountRemaining' => 'SearchColumnDoubleField[]',
		'amtAvailBilled' => 'SearchColumnDoubleField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'email' => 'SearchColumnStringField[]',
		'expirationDate' => 'SearchColumnDateField[]',
		'gcActive' => 'SearchColumnBooleanField[]',
		'giftCertCode' => 'SearchColumnStringField[]',
		'incomeAcct' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'liabilityAcct' => 'SearchColumnStringField[]',
		'message' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'originalAmount' => 'SearchColumnDoubleField[]',
		'purchaseDate' => 'SearchColumnDateField[]',
		'sender' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
