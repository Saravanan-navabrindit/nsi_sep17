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

class JobSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accountNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $actualTime;
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
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allocatePayrollExpenses;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allowAllResourcesForTasks;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allowExpenses;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allowTime;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingRateCard;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingSchedule;
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
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $calculatedEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $calculatedEndDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $calculatedStartDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $category;
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
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $countryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customer;
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
	public $estimatedCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedGrossProfitPercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedLaborCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedLaborCostBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedLaborRevenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedTimeOverride;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedTimeOverrideBaseline;
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
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $includeCrmTasksInTotals;
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
	public $isExemptTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isProductiveTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isUtilizedTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $jobBillingType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $jobItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $jobPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $jobResource;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $jobResourceRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $language;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastBaselineDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $limitTimeToAssignees;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $materializeTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $percentComplete;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $percentTimeComplete;
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
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $projectedEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $projectedEndDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $projectExpenseType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $projectManager;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revRecForecastRule;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $scheduledEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $schedulingMethod;
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
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $sourceServiceItemFromRateCard;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDateBaseline;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $timeApproval;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $timeRemaining;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $usePercentCompleteOverride;
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
		'actualTime' => 'SearchColumnDoubleField[]',
		'address' => 'SearchColumnStringField[]',
		'address1' => 'SearchColumnStringField[]',
		'address2' => 'SearchColumnStringField[]',
		'address3' => 'SearchColumnStringField[]',
		'addressee' => 'SearchColumnStringField[]',
		'addressInternalId' => 'SearchColumnStringField[]',
		'addressLabel' => 'SearchColumnStringField[]',
		'addressPhone' => 'SearchColumnStringField[]',
		'allocatePayrollExpenses' => 'SearchColumnBooleanField[]',
		'allowAllResourcesForTasks' => 'SearchColumnBooleanField[]',
		'allowExpenses' => 'SearchColumnBooleanField[]',
		'allowTime' => 'SearchColumnBooleanField[]',
		'altContact' => 'SearchColumnStringField[]',
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
		'billingRateCard' => 'SearchColumnSelectField[]',
		'billingSchedule' => 'SearchColumnSelectField[]',
		'billPhone' => 'SearchColumnStringField[]',
		'billState' => 'SearchColumnStringField[]',
		'billZipCode' => 'SearchColumnStringField[]',
		'calculatedEndDate' => 'SearchColumnDateField[]',
		'calculatedEndDateBaseline' => 'SearchColumnDateField[]',
		'calculatedStartDate' => 'SearchColumnDateField[]',
		'category' => 'SearchColumnSelectField[]',
		'city' => 'SearchColumnStringField[]',
		'comments' => 'SearchColumnStringField[]',
		'companyName' => 'SearchColumnStringField[]',
		'contact' => 'SearchColumnStringField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'countryCode' => 'SearchColumnStringField[]',
		'customer' => 'SearchColumnSelectField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'defaultTaxReg' => 'SearchColumnStringField[]',
		'email' => 'SearchColumnStringField[]',
		'endDate' => 'SearchColumnDateField[]',
		'entityId' => 'SearchColumnStringField[]',
		'entityNumber' => 'SearchColumnLongField[]',
		'entityStatus' => 'SearchColumnSelectField[]',
		'estimatedCost' => 'SearchColumnDoubleField[]',
		'estimatedGrossProfit' => 'SearchColumnDoubleField[]',
		'estimatedGrossProfitPercent' => 'SearchColumnDoubleField[]',
		'estimatedLaborCost' => 'SearchColumnDoubleField[]',
		'estimatedLaborCostBaseline' => 'SearchColumnDoubleField[]',
		'estimatedLaborRevenue' => 'SearchColumnDoubleField[]',
		'estimatedRevenue' => 'SearchColumnDoubleField[]',
		'estimatedTime' => 'SearchColumnDoubleField[]',
		'estimatedTimeOverride' => 'SearchColumnDoubleField[]',
		'estimatedTimeOverrideBaseline' => 'SearchColumnDoubleField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fax' => 'SearchColumnStringField[]',
		'globalSubscriptionStatus' => 'SearchColumnEnumSelectField[]',
		'image' => 'SearchColumnSelectField[]',
		'includeCrmTasksInTotals' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isDefaultBilling' => 'SearchColumnBooleanField[]',
		'isDefaultShipping' => 'SearchColumnBooleanField[]',
		'isExemptTime' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isProductiveTime' => 'SearchColumnBooleanField[]',
		'isUtilizedTime' => 'SearchColumnBooleanField[]',
		'jobBillingType' => 'SearchColumnEnumSelectField[]',
		'jobItem' => 'SearchColumnSelectField[]',
		'jobPrice' => 'SearchColumnDoubleField[]',
		'jobResource' => 'SearchColumnSelectField[]',
		'jobResourceRole' => 'SearchColumnSelectField[]',
		'language' => 'SearchColumnEnumSelectField[]',
		'lastBaselineDate' => 'SearchColumnDateField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'level' => 'SearchColumnEnumSelectField[]',
		'limitTimeToAssignees' => 'SearchColumnBooleanField[]',
		'materializeTime' => 'SearchColumnBooleanField[]',
		'percentComplete' => 'SearchColumnDoubleField[]',
		'percentTimeComplete' => 'SearchColumnDoubleField[]',
		'permission' => 'SearchColumnEnumSelectField[]',
		'phone' => 'SearchColumnStringField[]',
		'phoneticName' => 'SearchColumnStringField[]',
		'plannedWork' => 'SearchColumnDoubleField[]',
		'plannedWorkBaseline' => 'SearchColumnDoubleField[]',
		'projectedEndDate' => 'SearchColumnDateField[]',
		'projectedEndDateBaseline' => 'SearchColumnDateField[]',
		'projectExpenseType' => 'SearchColumnSelectField[]',
		'projectManager' => 'SearchColumnSelectField[]',
		'revRecForecastRule' => 'SearchColumnSelectField[]',
		'scheduledEndDate' => 'SearchColumnDateField[]',
		'schedulingMethod' => 'SearchColumnEnumSelectField[]',
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
		'sourceServiceItemFromRateCard' => 'SearchColumnBooleanField[]',
		'startDate' => 'SearchColumnDateField[]',
		'startDateBaseline' => 'SearchColumnDateField[]',
		'state' => 'SearchColumnStringField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'subscriptionDate' => 'SearchColumnDateField[]',
		'subscriptionStatus' => 'SearchColumnBooleanField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'timeApproval' => 'SearchColumnSelectField[]',
		'timeRemaining' => 'SearchColumnDoubleField[]',
		'usePercentCompleteOverride' => 'SearchColumnBooleanField[]',
		'zipCode' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
