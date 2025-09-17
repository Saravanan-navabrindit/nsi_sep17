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

class JobSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $accountNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $actualTime;
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
	public $allocatePayrollExpenses;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $allowAllResourcesForTasks;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $allowExpenses;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $allowTime;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $applyProjectExpenseTypeToAll;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingRateCard;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $calculatedEndDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $calculatedEndDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $calculatedStartDate;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $customer;
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
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $entityId;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estCost;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $estEndDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedGrossProfitPercent;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedLaborCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedLaborCostBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedLaborRevenue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedTimeOverride;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedTimeOverrideBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estRevenue;
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
	public $giveAccess;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $image;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $includeCrmTasksInTotals;
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
	public $isExemptTime;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isProductiveTime;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isUtilizedTime;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $jobBillingType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $jobItem;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $jobPrice;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $jobResource;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $jobResourceRole;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $language;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastBaselineDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $limitTimeToAssignees;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $materializeTime;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $pctComplete;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $percentTimeComplete;
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
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $projectedEndDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $projectExpenseType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $projectManager;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $revRecForecastRule;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $scheduledEndDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $schedulingMethod;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $sourceServiceItemFromRateCard;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDateBaseline;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $timeApproval;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $timeRemaining;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $usePercentCompleteOverride;
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
		'actualTime' => 'SearchDoubleField',
		'address' => 'SearchStringField',
		'addressee' => 'SearchStringField',
		'addressLabel' => 'SearchStringField',
		'addressPhone' => 'SearchStringField',
		'allocatePayrollExpenses' => 'SearchBooleanField',
		'allowAllResourcesForTasks' => 'SearchBooleanField',
		'allowExpenses' => 'SearchBooleanField',
		'allowTime' => 'SearchBooleanField',
		'applyProjectExpenseTypeToAll' => 'SearchBooleanField',
		'attention' => 'SearchStringField',
		'billingRateCard' => 'SearchMultiSelectField',
		'billingSchedule' => 'SearchMultiSelectField',
		'calculatedEndDate' => 'SearchDateField',
		'calculatedEndDateBaseline' => 'SearchDateField',
		'calculatedStartDate' => 'SearchDateField',
		'category' => 'SearchMultiSelectField',
		'city' => 'SearchStringField',
		'comments' => 'SearchStringField',
		'contact' => 'SearchStringField',
		'country' => 'SearchEnumMultiSelectField',
		'county' => 'SearchStringField',
		'customer' => 'SearchMultiSelectField',
		'dateCreated' => 'SearchDateField',
		'defaultTaxReg' => 'SearchMultiSelectField',
		'defaultTaxRegText' => 'SearchStringField',
		'email' => 'SearchStringField',
		'endDate' => 'SearchDateField',
		'entityId' => 'SearchStringField',
		'estCost' => 'SearchDoubleField',
		'estEndDate' => 'SearchDateField',
		'estimatedGrossProfit' => 'SearchDoubleField',
		'estimatedGrossProfitPercent' => 'SearchDoubleField',
		'estimatedLaborCost' => 'SearchDoubleField',
		'estimatedLaborCostBaseline' => 'SearchDoubleField',
		'estimatedLaborRevenue' => 'SearchDoubleField',
		'estimatedTime' => 'SearchDoubleField',
		'estimatedTimeOverride' => 'SearchDoubleField',
		'estimatedTimeOverrideBaseline' => 'SearchDoubleField',
		'estRevenue' => 'SearchDoubleField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fax' => 'SearchStringField',
		'giveAccess' => 'SearchBooleanField',
		'globalSubscriptionStatus' => 'SearchEnumMultiSelectField',
		'image' => 'SearchStringField',
		'includeCrmTasksInTotals' => 'SearchBooleanField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isDefaultBilling' => 'SearchBooleanField',
		'isDefaultShipping' => 'SearchBooleanField',
		'isExemptTime' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isProductiveTime' => 'SearchBooleanField',
		'isUtilizedTime' => 'SearchBooleanField',
		'jobBillingType' => 'SearchEnumMultiSelectField',
		'jobItem' => 'SearchMultiSelectField',
		'jobPrice' => 'SearchDoubleField',
		'jobResource' => 'SearchMultiSelectField',
		'jobResourceRole' => 'SearchMultiSelectField',
		'language' => 'SearchEnumMultiSelectField',
		'lastBaselineDate' => 'SearchDateField',
		'lastModifiedDate' => 'SearchDateField',
		'level' => 'SearchEnumMultiSelectField',
		'limitTimeToAssignees' => 'SearchBooleanField',
		'materializeTime' => 'SearchBooleanField',
		'parent' => 'SearchMultiSelectField',
		'pctComplete' => 'SearchLongField',
		'percentTimeComplete' => 'SearchLongField',
		'permission' => 'SearchEnumMultiSelectField',
		'phone' => 'SearchStringField',
		'phoneticName' => 'SearchStringField',
		'plannedWork' => 'SearchDoubleField',
		'plannedWorkBaseline' => 'SearchDoubleField',
		'projectedEndDateBaseline' => 'SearchDateField',
		'projectExpenseType' => 'SearchMultiSelectField',
		'projectManager' => 'SearchMultiSelectField',
		'revRecForecastRule' => 'SearchMultiSelectField',
		'scheduledEndDate' => 'SearchDateField',
		'schedulingMethod' => 'SearchEnumMultiSelectField',
		'sourceServiceItemFromRateCard' => 'SearchBooleanField',
		'startDate' => 'SearchDateField',
		'startDateBaseline' => 'SearchDateField',
		'state' => 'SearchStringField',
		'status' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'timeApproval' => 'SearchMultiSelectField',
		'timeRemaining' => 'SearchDoubleField',
		'type' => 'SearchMultiSelectField',
		'usePercentCompleteOverride' => 'SearchBooleanField',
		'zipCode' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
