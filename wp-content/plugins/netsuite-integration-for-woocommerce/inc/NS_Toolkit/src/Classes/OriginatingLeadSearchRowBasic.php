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

class OriginatingLeadSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accountNumber;
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
	public $altContact;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assignedSite;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $assignedSiteId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableOffline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress;
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
	public $buyingReason;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $buyingTimeFrame;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccCustomerCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $ccDefault;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $ccExpDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccHolderName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccInternalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $ccState;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $ccStateFrom;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $ccType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $companyName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $consolBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $consolDaysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $consolDepositBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $consolOverdueBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $consolUnbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $contribution;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $contributionPrimary;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $conversionDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $countryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $creditHold;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $creditHoldOverride;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $creditLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateClosed;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $daysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $defaultOrderPriority;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $depositBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $drAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $emailPreference;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $emailTransactions;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
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
	public $entityStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedBudget;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $explicitConversion;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fax;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $faxTransactions;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $firstName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $firstOrderDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $firstSaleDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fxAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxConsolBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxConsolUnbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxUnbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $giveAccess;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $groupPricingLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $hasDuplicates;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $homePhone;
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
	public $isBudgetApproved;
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
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isPerson;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isShipAddress;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $itemPricingLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $itemPricingUnitPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $jobEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $jobProjectedEnd;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $jobStartDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $jobType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $language;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $lastName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastOrderDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastSaleDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $leadDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $manualCreditHold;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $middleName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $mobilePhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $monthlyClosing;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $onCreditHold;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $overdueBalance;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $partnerContribution;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $partnerRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $partnerTeamMember;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pec;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $prefCCProcessor;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pricingGroup;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pricingItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $printTransactions;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $prospectDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $receivablesAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $reminderDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $resaleNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $role;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $salesReadiness;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesTeamMember;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesTeamRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $salutation;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress;
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
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $shipComplete;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $shippingItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipState;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipZip;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $sourceSite;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $sourceSiteId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $stage;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
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
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $taxable;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $terms;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $territory;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $url;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $vatRegNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $webLead;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $zipCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountNumber' => 'SearchColumnStringField[]',
		'address' => 'SearchColumnStringField[]',
		'address1' => 'SearchColumnStringField[]',
		'address2' => 'SearchColumnStringField[]',
		'address3' => 'SearchColumnStringField[]',
		'addressee' => 'SearchColumnStringField[]',
		'addressInternalId' => 'SearchColumnStringField[]',
		'addressLabel' => 'SearchColumnStringField[]',
		'addressPhone' => 'SearchColumnStringField[]',
		'altContact' => 'SearchColumnStringField[]',
		'altEmail' => 'SearchColumnStringField[]',
		'altName' => 'SearchColumnStringField[]',
		'altPhone' => 'SearchColumnStringField[]',
		'assignedSite' => 'SearchColumnSelectField[]',
		'assignedSiteId' => 'SearchColumnLongField[]',
		'attention' => 'SearchColumnStringField[]',
		'availableOffline' => 'SearchColumnBooleanField[]',
		'balance' => 'SearchColumnDoubleField[]',
		'billAddress' => 'SearchColumnStringField[]',
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
		'buyingReason' => 'SearchColumnStringField[]',
		'buyingTimeFrame' => 'SearchColumnStringField[]',
		'category' => 'SearchColumnSelectField[]',
		'ccCustomerCode' => 'SearchColumnStringField[]',
		'ccDefault' => 'SearchColumnBooleanField[]',
		'ccExpDate' => 'SearchColumnDateField[]',
		'ccHolderName' => 'SearchColumnStringField[]',
		'ccInternalId' => 'SearchColumnStringField[]',
		'ccNumber' => 'SearchColumnStringField[]',
		'ccState' => 'SearchColumnSelectField[]',
		'ccStateFrom' => 'SearchColumnDateField[]',
		'ccType' => 'SearchColumnSelectField[]',
		'city' => 'SearchColumnStringField[]',
		'comments' => 'SearchColumnStringField[]',
		'companyName' => 'SearchColumnStringField[]',
		'consolBalance' => 'SearchColumnDoubleField[]',
		'consolDaysOverdue' => 'SearchColumnLongField[]',
		'consolDepositBalance' => 'SearchColumnDoubleField[]',
		'consolOverdueBalance' => 'SearchColumnDoubleField[]',
		'consolUnbilledOrders' => 'SearchColumnDoubleField[]',
		'contact' => 'SearchColumnStringField[]',
		'contribution' => 'SearchColumnDoubleField[]',
		'contributionPrimary' => 'SearchColumnDoubleField[]',
		'conversionDate' => 'SearchColumnDateField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'countryCode' => 'SearchColumnStringField[]',
		'creditHold' => 'SearchColumnEnumSelectField[]',
		'creditHoldOverride' => 'SearchColumnBooleanField[]',
		'creditLimit' => 'SearchColumnDoubleField[]',
		'currency' => 'SearchColumnSelectField[]',
		'dateClosed' => 'SearchColumnDateField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'daysOverdue' => 'SearchColumnLongField[]',
		'defaultOrderPriority' => 'SearchColumnDoubleField[]',
		'defaultTaxReg' => 'SearchColumnStringField[]',
		'depositBalance' => 'SearchColumnDoubleField[]',
		'drAccount' => 'SearchColumnStringField[]',
		'email' => 'SearchColumnStringField[]',
		'emailPreference' => 'SearchColumnEnumSelectField[]',
		'emailTransactions' => 'SearchColumnBooleanField[]',
		'endDate' => 'SearchColumnDateField[]',
		'entityId' => 'SearchColumnStringField[]',
		'entityNumber' => 'SearchColumnLongField[]',
		'entityStatus' => 'SearchColumnSelectField[]',
		'estimatedBudget' => 'SearchColumnDoubleField[]',
		'explicitConversion' => 'SearchColumnBooleanField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fax' => 'SearchColumnStringField[]',
		'faxTransactions' => 'SearchColumnBooleanField[]',
		'firstName' => 'SearchColumnStringField[]',
		'firstOrderDate' => 'SearchColumnDateField[]',
		'firstSaleDate' => 'SearchColumnDateField[]',
		'fxAccount' => 'SearchColumnStringField[]',
		'fxBalance' => 'SearchColumnDoubleField[]',
		'fxConsolBalance' => 'SearchColumnDoubleField[]',
		'fxConsolUnbilledOrders' => 'SearchColumnDoubleField[]',
		'fxUnbilledOrders' => 'SearchColumnDoubleField[]',
		'giveAccess' => 'SearchColumnBooleanField[]',
		'globalSubscriptionStatus' => 'SearchColumnEnumSelectField[]',
		'groupPricingLevel' => 'SearchColumnStringField[]',
		'hasDuplicates' => 'SearchColumnBooleanField[]',
		'homePhone' => 'SearchColumnStringField[]',
		'image' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isBudgetApproved' => 'SearchColumnBooleanField[]',
		'isDefaultBilling' => 'SearchColumnBooleanField[]',
		'isDefaultShipping' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isPerson' => 'SearchColumnBooleanField[]',
		'isShipAddress' => 'SearchColumnBooleanField[]',
		'itemPricingLevel' => 'SearchColumnStringField[]',
		'itemPricingUnitPrice' => 'SearchColumnDoubleField[]',
		'jobEndDate' => 'SearchColumnDateField[]',
		'jobProjectedEnd' => 'SearchColumnDateField[]',
		'jobStartDate' => 'SearchColumnDateField[]',
		'jobType' => 'SearchColumnSelectField[]',
		'language' => 'SearchColumnEnumSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'lastName' => 'SearchColumnStringField[]',
		'lastOrderDate' => 'SearchColumnDateField[]',
		'lastSaleDate' => 'SearchColumnDateField[]',
		'leadDate' => 'SearchColumnDateField[]',
		'leadSource' => 'SearchColumnSelectField[]',
		'level' => 'SearchColumnEnumSelectField[]',
		'manualCreditHold' => 'SearchColumnBooleanField[]',
		'middleName' => 'SearchColumnStringField[]',
		'mobilePhone' => 'SearchColumnStringField[]',
		'monthlyClosing' => 'SearchColumnEnumSelectField[]',
		'onCreditHold' => 'SearchColumnBooleanField[]',
		'overdueBalance' => 'SearchColumnDoubleField[]',
		'parent' => 'SearchColumnSelectField[]',
		'partner' => 'SearchColumnSelectField[]',
		'partnerContribution' => 'SearchColumnDoubleField[]',
		'partnerRole' => 'SearchColumnStringField[]',
		'partnerTeamMember' => 'SearchColumnSelectField[]',
		'pec' => 'SearchColumnStringField[]',
		'permission' => 'SearchColumnEnumSelectField[]',
		'phone' => 'SearchColumnStringField[]',
		'phoneticName' => 'SearchColumnStringField[]',
		'prefCCProcessor' => 'SearchColumnSelectField[]',
		'priceLevel' => 'SearchColumnSelectField[]',
		'pricingGroup' => 'SearchColumnStringField[]',
		'pricingItem' => 'SearchColumnStringField[]',
		'printTransactions' => 'SearchColumnBooleanField[]',
		'prospectDate' => 'SearchColumnDateField[]',
		'receivablesAccount' => 'SearchColumnStringField[]',
		'reminderDays' => 'SearchColumnLongField[]',
		'resaleNumber' => 'SearchColumnStringField[]',
		'role' => 'SearchColumnStringField[]',
		'salesReadiness' => 'SearchColumnStringField[]',
		'salesRep' => 'SearchColumnSelectField[]',
		'salesTeamMember' => 'SearchColumnSelectField[]',
		'salesTeamRole' => 'SearchColumnSelectField[]',
		'salutation' => 'SearchColumnStringField[]',
		'shipAddress' => 'SearchColumnStringField[]',
		'shipAddress1' => 'SearchColumnStringField[]',
		'shipAddress2' => 'SearchColumnStringField[]',
		'shipAddress3' => 'SearchColumnStringField[]',
		'shipAddressee' => 'SearchColumnStringField[]',
		'shipAttention' => 'SearchColumnStringField[]',
		'shipCity' => 'SearchColumnStringField[]',
		'shipComplete' => 'SearchColumnBooleanField[]',
		'shipCountry' => 'SearchColumnEnumSelectField[]',
		'shipCountryCode' => 'SearchColumnStringField[]',
		'shipPhone' => 'SearchColumnStringField[]',
		'shippingItem' => 'SearchColumnSelectField[]',
		'shipState' => 'SearchColumnStringField[]',
		'shipZip' => 'SearchColumnStringField[]',
		'sourceSite' => 'SearchColumnSelectField[]',
		'sourceSiteId' => 'SearchColumnLongField[]',
		'stage' => 'SearchColumnStringField[]',
		'startDate' => 'SearchColumnDateField[]',
		'state' => 'SearchColumnEnumSelectField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'subscriptionDate' => 'SearchColumnDateField[]',
		'subscriptionStatus' => 'SearchColumnBooleanField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'taxable' => 'SearchColumnBooleanField[]',
		'taxItem' => 'SearchColumnSelectField[]',
		'terms' => 'SearchColumnSelectField[]',
		'territory' => 'SearchColumnSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'unbilledOrders' => 'SearchColumnDoubleField[]',
		'url' => 'SearchColumnStringField[]',
		'vatRegNumber' => 'SearchColumnStringField[]',
		'webLead' => 'SearchColumnBooleanField[]',
		'zipCode' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
