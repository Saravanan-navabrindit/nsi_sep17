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

class VendorSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $accountNumber;
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
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $balance;
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
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $county;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $creditLimit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $currentExchangeRate;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $emailTransactions;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $entityId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $expenseAccount;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $faxTransactions;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $firstName;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxBalance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxUnbilledOrders;
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
	public $incoterm;
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
	public $is1099Eligible;
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
	public $isJobResourceVend;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPerson;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $laborCost;
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
	public $payablesAccount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $pec;
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
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $predConfidence;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $predictedDays;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $printTransactions;
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
	public $taxIdNum;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $timeApprover;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $url;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $vatRegNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $workCalendar;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $zipCode;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountNumber' => 'SearchStringField',
		'address' => 'SearchStringField',
		'addressee' => 'SearchStringField',
		'addressLabel' => 'SearchStringField',
		'addressPhone' => 'SearchStringField',
		'attention' => 'SearchStringField',
		'balance' => 'SearchDoubleField',
		'billAddress' => 'SearchStringField',
		'category' => 'SearchMultiSelectField',
		'city' => 'SearchStringField',
		'comments' => 'SearchStringField',
		'contact' => 'SearchStringField',
		'country' => 'SearchEnumMultiSelectField',
		'county' => 'SearchStringField',
		'creditLimit' => 'SearchDoubleField',
		'currency' => 'SearchMultiSelectField',
		'currentExchangeRate' => 'SearchDoubleField',
		'dateCreated' => 'SearchDateField',
		'defaultTaxReg' => 'SearchMultiSelectField',
		'defaultTaxRegText' => 'SearchStringField',
		'eligibleForCommission' => 'SearchBooleanField',
		'email' => 'SearchStringField',
		'emailPreference' => 'SearchEnumMultiSelectField',
		'emailTransactions' => 'SearchBooleanField',
		'entityId' => 'SearchStringField',
		'expenseAccount' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fax' => 'SearchStringField',
		'faxTransactions' => 'SearchBooleanField',
		'firstName' => 'SearchStringField',
		'fxBalance' => 'SearchDoubleField',
		'fxUnbilledOrders' => 'SearchDoubleField',
		'giveAccess' => 'SearchBooleanField',
		'globalSubscriptionStatus' => 'SearchEnumMultiSelectField',
		'group' => 'SearchMultiSelectField',
		'hasDuplicates' => 'SearchBooleanField',
		'image' => 'SearchStringField',
		'incoterm' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'is1099Eligible' => 'SearchBooleanField',
		'isDefaultBilling' => 'SearchBooleanField',
		'isDefaultShipping' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isJobResourceVend' => 'SearchBooleanField',
		'isPerson' => 'SearchBooleanField',
		'laborCost' => 'SearchDoubleField',
		'language' => 'SearchEnumMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'lastName' => 'SearchStringField',
		'level' => 'SearchEnumMultiSelectField',
		'middleName' => 'SearchStringField',
		'otherRelationships' => 'SearchEnumMultiSelectField',
		'payablesAccount' => 'SearchMultiSelectField',
		'pec' => 'SearchStringField',
		'permission' => 'SearchEnumMultiSelectField',
		'phone' => 'SearchStringField',
		'phoneticName' => 'SearchStringField',
		'predConfidence' => 'SearchDoubleField',
		'predictedDays' => 'SearchDoubleField',
		'printTransactions' => 'SearchBooleanField',
		'purchaseOrderAmount' => 'SearchDoubleField',
		'purchaseOrderQuantity' => 'SearchDoubleField',
		'purchaseOrderQuantityDiff' => 'SearchDoubleField',
		'receiptAmount' => 'SearchDoubleField',
		'receiptQuantity' => 'SearchDoubleField',
		'receiptQuantityDiff' => 'SearchDoubleField',
		'salutation' => 'SearchStringField',
		'shipAddress' => 'SearchStringField',
		'state' => 'SearchStringField',
		'subsidiary' => 'SearchMultiSelectField',
		'taxIdNum' => 'SearchStringField',
		'timeApprover' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'unbilledOrders' => 'SearchDoubleField',
		'url' => 'SearchStringField',
		'vatRegNumber' => 'SearchStringField',
		'workCalendar' => 'SearchMultiSelectField',
		'zipCode' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
