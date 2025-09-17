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

class PartnerSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $address;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $addressee;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $addressLabel;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $addressPhone;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $assignTasks;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billAddress;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $commissionPlan;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $county;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $defaultTaxRegText;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $eligibleForCommission;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $emailPreference;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $entityId;
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
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $firstName;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $giveAccess;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $group;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $hasDuplicates;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $image;
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
	public $isDefaultBilling;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isDefaultShipping;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPerson;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $language;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $lastName;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $middleName;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $otherRelationships;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $partnerCode;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $permission;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $phoneticName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $salutation;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $URL;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $zipCode;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'address' => 'SearchStringField',
		'addressee' => 'SearchStringField',
		'addressLabel' => 'SearchStringField',
		'addressPhone' => 'SearchStringField',
		'assignTasks' => 'SearchBooleanField',
		'attention' => 'SearchStringField',
		'billAddress' => 'SearchStringField',
		'category' => 'SearchMultiSelectField',
		'city' => 'SearchStringField',
		'class' => 'SearchMultiSelectField',
		'comments' => 'SearchStringField',
		'commissionPlan' => 'SearchMultiSelectField',
		'country' => 'SearchEnumMultiSelectField',
		'county' => 'SearchStringField',
		'dateCreated' => 'SearchDateField',
		'defaultTaxReg' => 'SearchMultiSelectField',
		'defaultTaxRegText' => 'SearchStringField',
		'department' => 'SearchMultiSelectField',
		'eligibleForCommission' => 'SearchBooleanField',
		'email' => 'SearchStringField',
		'emailPreference' => 'SearchEnumMultiSelectField',
		'entityId' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fax' => 'SearchStringField',
		'firstName' => 'SearchStringField',
		'giveAccess' => 'SearchBooleanField',
		'globalSubscriptionStatus' => 'SearchEnumMultiSelectField',
		'group' => 'SearchMultiSelectField',
		'hasDuplicates' => 'SearchBooleanField',
		'image' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isDefaultBilling' => 'SearchBooleanField',
		'isDefaultShipping' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isPerson' => 'SearchBooleanField',
		'language' => 'SearchEnumMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'lastName' => 'SearchStringField',
		'level' => 'SearchEnumMultiSelectField',
		'location' => 'SearchMultiSelectField',
		'middleName' => 'SearchStringField',
		'otherRelationships' => 'SearchEnumMultiSelectField',
		'parent' => 'SearchMultiSelectField',
		'partnerCode' => 'SearchStringField',
		'permission' => 'SearchEnumMultiSelectField',
		'phone' => 'SearchStringField',
		'phoneticName' => 'SearchStringField',
		'promoCode' => 'SearchMultiSelectField',
		'salutation' => 'SearchStringField',
		'shipAddress' => 'SearchStringField',
		'state' => 'SearchStringField',
		'subsidiary' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'URL' => 'SearchStringField',
		'zipCode' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
