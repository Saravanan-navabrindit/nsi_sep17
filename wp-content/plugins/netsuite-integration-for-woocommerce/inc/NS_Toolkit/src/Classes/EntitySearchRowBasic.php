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

class EntitySearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address3;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $addressee;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $addressInternalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $addressLabel;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $addressPhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $altEmail;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $altName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $altPhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress3;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddressee;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAttention;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billCity;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $billCountry;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billCountryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billPhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billState;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billZipCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $countryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $entityId;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $entityNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fax;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $image;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isDefaultBilling;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isDefaultShipping;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $language;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $permission;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phoneticName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress3;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddressee;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAttention;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipCity;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $shipCountry;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipCountryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipPhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipState;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipZip;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $subscriptionDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $subscriptionStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $zipCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'address' => 'SearchColumnStringField[]',
		'address1' => 'SearchColumnStringField[]',
		'address2' => 'SearchColumnStringField[]',
		'address3' => 'SearchColumnStringField[]',
		'addressee' => 'SearchColumnStringField[]',
		'addressInternalId' => 'SearchColumnStringField[]',
		'addressLabel' => 'SearchColumnStringField[]',
		'addressPhone' => 'SearchColumnStringField[]',
		'altEmail' => 'SearchColumnStringField[]',
		'altName' => 'SearchColumnStringField[]',
		'altPhone' => 'SearchColumnStringField[]',
		'attention' => 'SearchColumnStringField[]',
		'billAddress1' => 'SearchColumnStringField[]',
		'billAddress2' => 'SearchColumnStringField[]',
		'billAddress3' => 'SearchColumnStringField[]',
		'billAddressee' => 'SearchColumnStringField[]',
		'billAttention' => 'SearchColumnStringField[]',
		'billCity' => 'SearchColumnStringField[]',
		'billCountry' => 'SearchColumnEnumSelectField[]',
		'billCountryCode' => 'SearchColumnStringField[]',
		'billPhone' => 'SearchColumnStringField[]',
		'billState' => 'SearchColumnStringField[]',
		'billZipCode' => 'SearchColumnStringField[]',
		'city' => 'SearchColumnStringField[]',
		'comments' => 'SearchColumnStringField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'countryCode' => 'SearchColumnStringField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'defaultTaxReg' => 'SearchColumnStringField[]',
		'email' => 'SearchColumnStringField[]',
		'entityId' => 'SearchColumnStringField[]',
		'entityNumber' => 'SearchColumnLongField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fax' => 'SearchColumnStringField[]',
		'globalSubscriptionStatus' => 'SearchColumnEnumSelectField[]',
		'image' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isDefaultBilling' => 'SearchColumnBooleanField[]',
		'isDefaultShipping' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'language' => 'SearchColumnEnumSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'level' => 'SearchColumnEnumSelectField[]',
		'permission' => 'SearchColumnEnumSelectField[]',
		'phone' => 'SearchColumnStringField[]',
		'phoneticName' => 'SearchColumnStringField[]',
		'shipAddress1' => 'SearchColumnStringField[]',
		'shipAddress2' => 'SearchColumnStringField[]',
		'shipAddress3' => 'SearchColumnStringField[]',
		'shipAddressee' => 'SearchColumnStringField[]',
		'shipAttention' => 'SearchColumnStringField[]',
		'shipCity' => 'SearchColumnStringField[]',
		'shipCountry' => 'SearchColumnEnumSelectField[]',
		'shipCountryCode' => 'SearchColumnStringField[]',
		'shipPhone' => 'SearchColumnStringField[]',
		'shipState' => 'SearchColumnStringField[]',
		'shipZip' => 'SearchColumnStringField[]',
		'state' => 'SearchColumnStringField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'subscriptionDate' => 'SearchColumnDateField[]',
		'subscriptionStatus' => 'SearchColumnBooleanField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'type' => 'SearchColumnEnumSelectField[]',
		'zipCode' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
