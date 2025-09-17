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

class Partner extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $entityId;
	/**
	 * Var string
	 */
	public $altName;
	/**
	 * Var string
	 */
	public $partnerCode;
	/**
	 * Var boolean
	 */
	public $isPerson;
	/**
	 * Var string
	 */
	public $phoneticName;
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
	public $companyName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
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
	public $url;
	/**
	 * Var string
	 */
	public $defaultAddress;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\PartnerTaxRegistrationList
	 */
	public $taxRegistrationList;
	/**
	 * Var \NetSuite\Classes\GlobalSubscriptionStatus
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var string
	 */
	public $referringUrl;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $roleList;
	/**
	 * Var \NetSuite\Classes\CategoryList
	 */
	public $categoryList;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var string
	 */
	public $printOnCheckAs;
	/**
	 * Var string
	 */
	public $taxIdNum;
	/**
	 * Var string
	 */
	public $vatRegNumber;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var string
	 */
	public $bcn;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $image;
	/**
	 * Var \NetSuite\Classes\TaxFractionUnit
	 */
	public $taxFractionUnit;
	/**
	 * Var \NetSuite\Classes\EmailPreference
	 */
	public $emailPreference;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\TaxRounding
	 */
	public $taxRounding;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var string
	 */
	public $homePhone;
	/**
	 * Var string
	 */
	public $mobilePhone;
	/**
	 * Var string
	 */
	public $altEmail;
	/**
	 * Var boolean
	 */
	public $giveAccess;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $accessRole;
	/**
	 * Var boolean
	 */
	public $sendEmail;
	/**
	 * Var string
	 */
	public $password;
	/**
	 * Var string
	 */
	public $password2;
	/**
	 * Var boolean
	 */
	public $requirePwdChange;
	/**
	 * Var boolean
	 */
	public $subPartnerLogin;
	/**
	 * Var string
	 */
	public $loginAs;
	/**
	 * Var boolean
	 */
	public $eligibleForCommission;
	/**
	 * Var \NetSuite\Classes\ContactAccessRolesList
	 */
	public $contactRolesList;
	/**
	 * Var \NetSuite\Classes\PartnerPromoCodeList
	 */
	public $promoCodeList;
	/**
	 * Var \NetSuite\Classes\PartnerAddressbookList
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
		'altName' => 'string',
		'partnerCode' => 'string',
		'isPerson' => 'boolean',
		'phoneticName' => 'string',
		'salutation' => 'string',
		'firstName' => 'string',
		'middleName' => 'string',
		'lastName' => 'string',
		'companyName' => 'string',
		'parent' => 'RecordRef',
		'phone' => 'string',
		'fax' => 'string',
		'email' => 'string',
		'url' => 'string',
		'defaultAddress' => 'string',
		'isInactive' => 'boolean',
		'lastModifiedDate' => 'dateTime',
		'dateCreated' => 'dateTime',
		'taxRegistrationList' => 'PartnerTaxRegistrationList',
		'globalSubscriptionStatus' => 'GlobalSubscriptionStatus',
		'referringUrl' => 'string',
		'roleList' => 'RecordRefList',
		'categoryList' => 'CategoryList',
		'title' => 'string',
		'printOnCheckAs' => 'string',
		'taxIdNum' => 'string',
		'vatRegNumber' => 'string',
		'comments' => 'string',
		'bcn' => 'string',
		'image' => 'RecordRef',
		'taxFractionUnit' => 'TaxFractionUnit',
		'emailPreference' => 'EmailPreference',
		'defaultTaxReg' => 'RecordRef',
		'taxRounding' => 'TaxRounding',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'class' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'homePhone' => 'string',
		'mobilePhone' => 'string',
		'altEmail' => 'string',
		'giveAccess' => 'boolean',
		'accessRole' => 'RecordRef',
		'sendEmail' => 'boolean',
		'password' => 'string',
		'password2' => 'string',
		'requirePwdChange' => 'boolean',
		'subPartnerLogin' => 'boolean',
		'loginAs' => 'string',
		'eligibleForCommission' => 'boolean',
		'contactRolesList' => 'ContactAccessRolesList',
		'promoCodeList' => 'PartnerPromoCodeList',
		'addressbookList' => 'PartnerAddressbookList',
		'subscriptionsList' => 'SubscriptionsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
