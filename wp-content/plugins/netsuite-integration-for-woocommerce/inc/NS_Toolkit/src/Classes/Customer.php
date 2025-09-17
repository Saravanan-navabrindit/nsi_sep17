<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class Customer extends Record {
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
	public $entityStatus;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
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
	public $altPhone;
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
	 * Var \NetSuite\Classes\Language
	 */
	public $language;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\CustomerNumberFormat
	 */
	public $numberFormat;
	/**
	 * Var \NetSuite\Classes\CustomerNegativeNumberFormat
	 */
	public $negativeNumberFormat;
	/**
	 * Var string
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $image;
	/**
	 * Var \NetSuite\Classes\EmailPreference
	 */
	public $emailPreference;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $representingSubsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $territory;
	/**
	 * Var string
	 */
	public $contribPct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
	/**
	 * Var string
	 */
	public $vatRegNumber;
	/**
	 * Var string
	 */
	public $accountNumber;
	/**
	 * Var boolean
	 */
	public $taxExempt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $terms;
	/**
	 * Var float
	 */
	public $creditLimit;
	/**
	 * Var \NetSuite\Classes\CustomerCreditHoldOverride
	 */
	public $creditHoldOverride;
	/**
	 * Var \NetSuite\Classes\CustomerMonthlyClosing
	 */
	public $monthlyClosing;
	/**
	 * Var boolean
	 */
	public $overrideCurrencyFormat;
	/**
	 * Var string
	 */
	public $displaySymbol;
	/**
	 * Var \NetSuite\Classes\CurrencySymbolPlacement
	 */
	public $symbolPlacement;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var float
	 */
	public $overdueBalance;
	/**
	 * Var integer
	 */
	public $daysOverdue;
	/**
	 * Var float
	 */
	public $unbilledOrders;
	/**
	 * Var float
	 */
	public $consolUnbilledOrders;
	/**
	 * Var float
	 */
	public $consolOverdueBalance;
	/**
	 * Var float
	 */
	public $consolDepositBalance;
	/**
	 * Var float
	 */
	public $consolBalance;
	/**
	 * Var float
	 */
	public $consolAging;
	/**
	 * Var float
	 */
	public $consolAging1;
	/**
	 * Var float
	 */
	public $consolAging2;
	/**
	 * Var float
	 */
	public $consolAging3;
	/**
	 * Var float
	 */
	public $consolAging4;
	/**
	 * Var integer
	 */
	public $consolDaysOverdue;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $prefCCProcessor;
	/**
	 * Var float
	 */
	public $depositBalance;
	/**
	 * Var boolean
	 */
	public $shipComplete;
	/**
	 * Var boolean
	 */
	public $taxable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxItem;
	/**
	 * Var string
	 */
	public $resaleNumber;
	/**
	 * Var float
	 */
	public $aging;
	/**
	 * Var float
	 */
	public $aging1;
	/**
	 * Var float
	 */
	public $aging2;
	/**
	 * Var float
	 */
	public $aging3;
	/**
	 * Var float
	 */
	public $aging4;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\AlcoholRecipientType
	 */
	public $alcoholRecipientType;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var integer
	 */
	public $reminderDays;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingItem;
	/**
	 * Var string
	 */
	public $thirdPartyAcct;
	/**
	 * Var string
	 */
	public $thirdPartyZipcode;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $thirdPartyCountry;
	/**
	 * Var boolean
	 */
	public $giveAccess;
	/**
	 * Var float
	 */
	public $estimatedBudget;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $accessRole;
	/**
	 * Var boolean
	 */
	public $sendEmail;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assignedWebSite;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $campaignCategory;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $sourceWebSite;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $receivablesAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $drAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $fxAccount;
	/**
	 * Var float
	 */
	public $defaultOrderPriority;
	/**
	 * Var string
	 */
	public $webLead;
	/**
	 * Var string
	 */
	public $referrer;
	/**
	 * Var string
	 */
	public $keywords;
	/**
	 * Var string
	 */
	public $clickStream;
	/**
	 * Var string
	 */
	public $lastPageVisited;
	/**
	 * Var integer
	 */
	public $visits;
	/**
	 * Var string
	 */
	public $firstVisit;
	/**
	 * Var string
	 */
	public $lastVisit;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var float
	 */
	public $openingBalance;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $openingBalanceDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $openingBalanceAccount;
	/**
	 * Var \NetSuite\Classes\CustomerStage
	 */
	public $stage;
	/**
	 * Var boolean
	 */
	public $emailTransactions;
	/**
	 * Var boolean
	 */
	public $printTransactions;
	/**
	 * Var boolean
	 */
	public $faxTransactions;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultTaxReg;
	/**
	 * Var boolean
	 */
	public $syncPartnerTeams;
	/**
	 * Var boolean
	 */
	public $isBudgetApproved;
	/**
	 * Var \NetSuite\Classes\GlobalSubscriptionStatus
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesReadiness;
	/**
	 * Var \NetSuite\Classes\CustomerSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buyingReason;
	/**
	 * Var \NetSuite\Classes\CustomerDownloadList
	 */
	public $downloadList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buyingTimeFrame;
	/**
	 * Var \NetSuite\Classes\CustomerAddressbookList
	 */
	public $addressbookList;
	/**
	 * Var \NetSuite\Classes\SubscriptionsList
	 */
	public $subscriptionsList;
	/**
	 * Var \NetSuite\Classes\ContactAccessRolesList
	 */
	public $contactRolesList;
	/**
	 * Var \NetSuite\Classes\CustomerCurrencyList
	 */
	public $currencyList;
	/**
	 * Var \NetSuite\Classes\CustomerCreditCardsList
	 */
	public $creditCardsList;
	/**
	 * Var \NetSuite\Classes\CustomerPartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\CustomerGroupPricingList
	 */
	public $groupPricingList;
	/**
	 * Var \NetSuite\Classes\CustomerItemPricingList
	 */
	public $itemPricingList;
	/**
	 * Var \NetSuite\Classes\CustomerTaxRegistrationList
	 */
	public $taxRegistrationList;
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
		'isPerson' => 'boolean',
		'phoneticName' => 'string',
		'salutation' => 'string',
		'firstName' => 'string',
		'middleName' => 'string',
		'lastName' => 'string',
		'companyName' => 'string',
		'entityStatus' => 'RecordRef',
		'parent' => 'RecordRef',
		'phone' => 'string',
		'fax' => 'string',
		'email' => 'string',
		'url' => 'string',
		'defaultAddress' => 'string',
		'isInactive' => 'boolean',
		'category' => 'RecordRef',
		'title' => 'string',
		'printOnCheckAs' => 'string',
		'altPhone' => 'string',
		'homePhone' => 'string',
		'mobilePhone' => 'string',
		'altEmail' => 'string',
		'language' => 'Language',
		'comments' => 'string',
		'numberFormat' => 'CustomerNumberFormat',
		'negativeNumberFormat' => 'CustomerNegativeNumberFormat',
		'dateCreated' => 'dateTime',
		'image' => 'RecordRef',
		'emailPreference' => 'EmailPreference',
		'subsidiary' => 'RecordRef',
		'representingSubsidiary' => 'RecordRef',
		'salesRep' => 'RecordRef',
		'territory' => 'RecordRef',
		'contribPct' => 'string',
		'partner' => 'RecordRef',
		'salesGroup' => 'RecordRef',
		'vatRegNumber' => 'string',
		'accountNumber' => 'string',
		'taxExempt' => 'boolean',
		'terms' => 'RecordRef',
		'creditLimit' => 'float',
		'creditHoldOverride' => 'CustomerCreditHoldOverride',
		'monthlyClosing' => 'CustomerMonthlyClosing',
		'overrideCurrencyFormat' => 'boolean',
		'displaySymbol' => 'string',
		'symbolPlacement' => 'CurrencySymbolPlacement',
		'balance' => 'float',
		'overdueBalance' => 'float',
		'daysOverdue' => 'integer',
		'unbilledOrders' => 'float',
		'consolUnbilledOrders' => 'float',
		'consolOverdueBalance' => 'float',
		'consolDepositBalance' => 'float',
		'consolBalance' => 'float',
		'consolAging' => 'float',
		'consolAging1' => 'float',
		'consolAging2' => 'float',
		'consolAging3' => 'float',
		'consolAging4' => 'float',
		'consolDaysOverdue' => 'integer',
		'priceLevel' => 'RecordRef',
		'currency' => 'RecordRef',
		'prefCCProcessor' => 'RecordRef',
		'depositBalance' => 'float',
		'shipComplete' => 'boolean',
		'taxable' => 'boolean',
		'taxItem' => 'RecordRef',
		'resaleNumber' => 'string',
		'aging' => 'float',
		'aging1' => 'float',
		'aging2' => 'float',
		'aging3' => 'float',
		'aging4' => 'float',
		'startDate' => 'dateTime',
		'alcoholRecipientType' => 'AlcoholRecipientType',
		'endDate' => 'dateTime',
		'reminderDays' => 'integer',
		'shippingItem' => 'RecordRef',
		'thirdPartyAcct' => 'string',
		'thirdPartyZipcode' => 'string',
		'thirdPartyCountry' => 'Country',
		'giveAccess' => 'boolean',
		'estimatedBudget' => 'float',
		'accessRole' => 'RecordRef',
		'sendEmail' => 'boolean',
		'assignedWebSite' => 'RecordRef',
		'password' => 'string',
		'password2' => 'string',
		'requirePwdChange' => 'boolean',
		'campaignCategory' => 'RecordRef',
		'sourceWebSite' => 'RecordRef',
		'leadSource' => 'RecordRef',
		'receivablesAccount' => 'RecordRef',
		'drAccount' => 'RecordRef',
		'fxAccount' => 'RecordRef',
		'defaultOrderPriority' => 'float',
		'webLead' => 'string',
		'referrer' => 'string',
		'keywords' => 'string',
		'clickStream' => 'string',
		'lastPageVisited' => 'string',
		'visits' => 'integer',
		'firstVisit' => 'dateTime',
		'lastVisit' => 'dateTime',
		'billPay' => 'boolean',
		'openingBalance' => 'float',
		'lastModifiedDate' => 'dateTime',
		'openingBalanceDate' => 'dateTime',
		'openingBalanceAccount' => 'RecordRef',
		'stage' => 'CustomerStage',
		'emailTransactions' => 'boolean',
		'printTransactions' => 'boolean',
		'faxTransactions' => 'boolean',
		'defaultTaxReg' => 'RecordRef',
		'syncPartnerTeams' => 'boolean',
		'isBudgetApproved' => 'boolean',
		'globalSubscriptionStatus' => 'GlobalSubscriptionStatus',
		'salesReadiness' => 'RecordRef',
		'salesTeamList' => 'CustomerSalesTeamList',
		'buyingReason' => 'RecordRef',
		'downloadList' => 'CustomerDownloadList',
		'buyingTimeFrame' => 'RecordRef',
		'addressbookList' => 'CustomerAddressbookList',
		'subscriptionsList' => 'SubscriptionsList',
		'contactRolesList' => 'ContactAccessRolesList',
		'currencyList' => 'CustomerCurrencyList',
		'creditCardsList' => 'CustomerCreditCardsList',
		'partnersList' => 'CustomerPartnersList',
		'groupPricingList' => 'CustomerGroupPricingList',
		'itemPricingList' => 'CustomerItemPricingList',
		'taxRegistrationList' => 'CustomerTaxRegistrationList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
