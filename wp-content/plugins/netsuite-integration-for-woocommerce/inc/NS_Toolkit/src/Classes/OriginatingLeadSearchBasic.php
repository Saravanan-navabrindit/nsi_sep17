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

class OriginatingLeadSearchBasic extends SearchRecordBasic {
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assignedSite;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assignedSiteId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $availableOffline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billAddress;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $boughtAmount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $boughtDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buyingReason;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buyingTimeFrame;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $ccCustomerCode;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $ccDefault;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $ccExpDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $ccHolderName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $ccNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $ccState;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $ccStateFrom;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $ccType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $classBought;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $companyName;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $consolBalance;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $consolDaysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $consolDepositBalance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $consolOverdueBalance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $consolUnbilledOrders;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $contribution;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $conversionDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $county;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $creditHold;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $creditHoldOverride;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $creditLimit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $custStage;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $custStatus;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateClosed;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $daysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $defaultOrderPriority;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $defaultTaxRegText;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $depositBalance;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $deptBought;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $drAccount;
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
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $entityId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $entityStatus;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedBudget;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $explicitConversion;
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
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $firstOrderDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $firstSaleDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $fxAccount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxBalance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxConsolBalance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxConsolUnbilledOrders;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $groupPricingLevel;
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
	public $isBudgetApproved;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isReportedLead;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isShipAddress;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemPricingLevel;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $itemPricingUnitPrice;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemsBought;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemsOrdered;
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
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastOrderDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastSaleDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $leadDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $locationBought;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $manualCreditHold;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $merchantAccount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $middleName;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $monthlyClosing;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $onCreditHold;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $orderedAmount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $orderedDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $otherRelationships;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $overdueBalance;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parentItemsBought;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parentItemsOrdered;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $partnerContribution;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partnerRole;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partnerTeamMember;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $pricingGroup;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $pricingItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $printTransactions;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $prospectDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $pstExempt;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $receivablesAccount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $reminderDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $resaleNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $role;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesReadiness;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesTeamMember;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesTeamRole;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $salutation;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shipComplete;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shippingItem;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $sourceSite;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $sourceSiteId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $stage;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidBought;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $taxable;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $terms;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $territory;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $webLead;
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
		'assignedSite' => 'SearchMultiSelectField',
		'assignedSiteId' => 'SearchMultiSelectField',
		'attention' => 'SearchStringField',
		'availableOffline' => 'SearchBooleanField',
		'balance' => 'SearchDoubleField',
		'billAddress' => 'SearchStringField',
		'boughtAmount' => 'SearchDoubleField',
		'boughtDate' => 'SearchDateField',
		'buyingReason' => 'SearchMultiSelectField',
		'buyingTimeFrame' => 'SearchMultiSelectField',
		'category' => 'SearchMultiSelectField',
		'ccCustomerCode' => 'SearchStringField',
		'ccDefault' => 'SearchBooleanField',
		'ccExpDate' => 'SearchDateField',
		'ccHolderName' => 'SearchStringField',
		'ccNumber' => 'SearchStringField',
		'ccState' => 'SearchMultiSelectField',
		'ccStateFrom' => 'SearchDateField',
		'ccType' => 'SearchMultiSelectField',
		'city' => 'SearchStringField',
		'classBought' => 'SearchMultiSelectField',
		'comments' => 'SearchStringField',
		'companyName' => 'SearchStringField',
		'consolBalance' => 'SearchDoubleField',
		'consolDaysOverdue' => 'SearchLongField',
		'consolDepositBalance' => 'SearchDoubleField',
		'consolOverdueBalance' => 'SearchDoubleField',
		'consolUnbilledOrders' => 'SearchDoubleField',
		'contact' => 'SearchStringField',
		'contribution' => 'SearchLongField',
		'conversionDate' => 'SearchDateField',
		'country' => 'SearchEnumMultiSelectField',
		'county' => 'SearchStringField',
		'creditHold' => 'SearchEnumMultiSelectField',
		'creditHoldOverride' => 'SearchBooleanField',
		'creditLimit' => 'SearchDoubleField',
		'currency' => 'SearchMultiSelectField',
		'custStage' => 'SearchMultiSelectField',
		'custStatus' => 'SearchMultiSelectField',
		'dateClosed' => 'SearchDateField',
		'dateCreated' => 'SearchDateField',
		'daysOverdue' => 'SearchLongField',
		'defaultOrderPriority' => 'SearchDoubleField',
		'defaultTaxReg' => 'SearchMultiSelectField',
		'defaultTaxRegText' => 'SearchStringField',
		'depositBalance' => 'SearchDoubleField',
		'deptBought' => 'SearchMultiSelectField',
		'drAccount' => 'SearchMultiSelectField',
		'email' => 'SearchStringField',
		'emailPreference' => 'SearchEnumMultiSelectField',
		'emailTransactions' => 'SearchBooleanField',
		'endDate' => 'SearchDateField',
		'entityId' => 'SearchStringField',
		'entityStatus' => 'SearchMultiSelectField',
		'estimatedBudget' => 'SearchDoubleField',
		'explicitConversion' => 'SearchBooleanField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fax' => 'SearchStringField',
		'faxTransactions' => 'SearchBooleanField',
		'firstName' => 'SearchStringField',
		'firstOrderDate' => 'SearchDateField',
		'firstSaleDate' => 'SearchDateField',
		'fxAccount' => 'SearchMultiSelectField',
		'fxBalance' => 'SearchDoubleField',
		'fxConsolBalance' => 'SearchDoubleField',
		'fxConsolUnbilledOrders' => 'SearchDoubleField',
		'fxUnbilledOrders' => 'SearchDoubleField',
		'giveAccess' => 'SearchBooleanField',
		'globalSubscriptionStatus' => 'SearchEnumMultiSelectField',
		'group' => 'SearchMultiSelectField',
		'groupPricingLevel' => 'SearchMultiSelectField',
		'hasDuplicates' => 'SearchBooleanField',
		'image' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isBudgetApproved' => 'SearchBooleanField',
		'isDefaultBilling' => 'SearchBooleanField',
		'isDefaultShipping' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isPerson' => 'SearchBooleanField',
		'isReportedLead' => 'SearchBooleanField',
		'isShipAddress' => 'SearchBooleanField',
		'itemPricingLevel' => 'SearchMultiSelectField',
		'itemPricingUnitPrice' => 'SearchDoubleField',
		'itemsBought' => 'SearchMultiSelectField',
		'itemsOrdered' => 'SearchMultiSelectField',
		'language' => 'SearchEnumMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'lastName' => 'SearchStringField',
		'lastOrderDate' => 'SearchDateField',
		'lastSaleDate' => 'SearchDateField',
		'leadDate' => 'SearchDateField',
		'leadSource' => 'SearchMultiSelectField',
		'level' => 'SearchEnumMultiSelectField',
		'locationBought' => 'SearchMultiSelectField',
		'manualCreditHold' => 'SearchBooleanField',
		'merchantAccount' => 'SearchMultiSelectField',
		'middleName' => 'SearchStringField',
		'monthlyClosing' => 'SearchEnumMultiSelectField',
		'onCreditHold' => 'SearchBooleanField',
		'orderedAmount' => 'SearchDoubleField',
		'orderedDate' => 'SearchDateField',
		'otherRelationships' => 'SearchEnumMultiSelectField',
		'overdueBalance' => 'SearchDoubleField',
		'parent' => 'SearchMultiSelectField',
		'parentItemsBought' => 'SearchMultiSelectField',
		'parentItemsOrdered' => 'SearchMultiSelectField',
		'partner' => 'SearchMultiSelectField',
		'partnerContribution' => 'SearchLongField',
		'partnerRole' => 'SearchMultiSelectField',
		'partnerTeamMember' => 'SearchMultiSelectField',
		'pec' => 'SearchStringField',
		'permission' => 'SearchEnumMultiSelectField',
		'phone' => 'SearchStringField',
		'phoneticName' => 'SearchStringField',
		'priceLevel' => 'SearchMultiSelectField',
		'pricingGroup' => 'SearchMultiSelectField',
		'pricingItem' => 'SearchMultiSelectField',
		'printTransactions' => 'SearchBooleanField',
		'prospectDate' => 'SearchDateField',
		'pstExempt' => 'SearchBooleanField',
		'receivablesAccount' => 'SearchMultiSelectField',
		'reminderDate' => 'SearchDateField',
		'resaleNumber' => 'SearchStringField',
		'role' => 'SearchMultiSelectField',
		'salesReadiness' => 'SearchMultiSelectField',
		'salesRep' => 'SearchMultiSelectField',
		'salesTeamMember' => 'SearchMultiSelectField',
		'salesTeamRole' => 'SearchMultiSelectField',
		'salutation' => 'SearchStringField',
		'shipAddress' => 'SearchStringField',
		'shipComplete' => 'SearchBooleanField',
		'shippingItem' => 'SearchMultiSelectField',
		'sourceSite' => 'SearchMultiSelectField',
		'sourceSiteId' => 'SearchMultiSelectField',
		'stage' => 'SearchMultiSelectField',
		'startDate' => 'SearchDateField',
		'state' => 'SearchStringField',
		'subsidBought' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'taxable' => 'SearchBooleanField',
		'terms' => 'SearchMultiSelectField',
		'territory' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'unbilledOrders' => 'SearchDoubleField',
		'url' => 'SearchStringField',
		'vatRegNumber' => 'SearchStringField',
		'webLead' => 'SearchBooleanField',
		'zipCode' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
