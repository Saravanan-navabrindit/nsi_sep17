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

class Contact extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $entityId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $contactSource;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $company;
	/**
	 * Var string
	 */
	public $salutation;
	/**
	 * Var string
	 */
	public $firstName;
	/**
	 * Var string
	 */
	public $middleName;
	/**
	 * Var string
	 */
	public $lastName;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var string
	 */
	public $phone;
	/**
	 * Var string
	 */
	public $fax;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var string
	 */
	public $defaultAddress;
	/**
	 * Var boolean
	 */
	public $isPrivate;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var string
	 */
	public $phoneticName;
	/**
	 * Var \NetSuite\Classes\CategoryList
	 */
	public $categoryList;
	/**
	 * Var string
	 */
	public $altEmail;
	/**
	 * Var string
	 */
	public $officePhone;
	/**
	 * Var string
	 */
	public $homePhone;
	/**
	 * Var string
	 */
	public $mobilePhone;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supervisor;
	/**
	 * Var string
	 */
	public $supervisorPhone;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assistant;
	/**
	 * Var string
	 */
	public $assistantPhone;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\GlobalSubscriptionStatus
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $image;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var string
	 */
	public $dateCreated;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\ContactAddressbookList
	 */
	public $addressbookList;
	/**
	 * Var \NetSuite\Classes\SubscriptionsList
	 */
	public $subscriptionsList;
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
		'customForm' => 'RecordRef',
		'entityId' => 'string',
		'contactSource' => 'RecordRef',
		'company' => 'RecordRef',
		'salutation' => 'string',
		'firstName' => 'string',
		'middleName' => 'string',
		'lastName' => 'string',
		'title' => 'string',
		'phone' => 'string',
		'fax' => 'string',
		'email' => 'string',
		'defaultAddress' => 'string',
		'isPrivate' => 'boolean',
		'isInactive' => 'boolean',
		'subsidiary' => 'RecordRef',
		'phoneticName' => 'string',
		'categoryList' => 'CategoryList',
		'altEmail' => 'string',
		'officePhone' => 'string',
		'homePhone' => 'string',
		'mobilePhone' => 'string',
		'supervisor' => 'RecordRef',
		'supervisorPhone' => 'string',
		'assistant' => 'RecordRef',
		'assistantPhone' => 'string',
		'comments' => 'string',
		'globalSubscriptionStatus' => 'GlobalSubscriptionStatus',
		'image' => 'RecordRef',
		'billPay' => 'boolean',
		'dateCreated' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'addressbookList' => 'ContactAddressbookList',
		'subscriptionsList' => 'SubscriptionsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
