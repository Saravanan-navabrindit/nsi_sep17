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

class Job extends Record {
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
	public $companyName;
	/**
	 * Var string
	 */
	public $phoneticName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entityStatus;
	/**
	 * Var string
	 */
	public $defaultAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\JobPercentCompleteOverrideList
	 */
	public $percentCompleteOverrideList;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var string
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workplace;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $language;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var string
	 */
	public $accountNumber;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $fxRate;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $phone;
	/**
	 * Var string
	 */
	public $altPhone;
	/**
	 * Var string
	 */
	public $calculatedEndDate;
	/**
	 * Var string
	 */
	public $calculatedEndDateBaseline;
	/**
	 * Var string
	 */
	public $startDateBaseline;
	/**
	 * Var string
	 */
	public $projectedEndDate;
	/**
	 * Var string
	 */
	public $projectedEndDateBaseline;
	/**
	 * Var string
	 */
	public $lastBaselineDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $jobType;
	/**
	 * Var float
	 */
	public $percentComplete;
	/**
	 * Var float
	 */
	public $estimatedCost;
	/**
	 * Var float
	 */
	public $estimatedRevenue;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $estimatedTime;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $estimatedTimeOverride;
	/**
	 * Var string
	 */
	public $fax;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\EmailPreference
	 */
	public $emailPreference;
	/**
	 * Var float
	 */
	public $openingBalance;
	/**
	 * Var string
	 */
	public $openingBalanceDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $openingBalanceAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\JobBillingType
	 */
	public $jobBillingType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $jobItem;
	/**
	 * Var float
	 */
	public $percentTimeComplete;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $actualTime;
	/**
	 * Var boolean
	 */
	public $allowTime;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $timeRemaining;
	/**
	 * Var boolean
	 */
	public $limitTimeToAssignees;
	/**
	 * Var float
	 */
	public $estimatedLaborCost;
	/**
	 * Var float
	 */
	public $estimatedLaborCostBaseline;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $estimateRevRecTemplate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecForecastRule;
	/**
	 * Var boolean
	 */
	public $usePercentCompleteOverride;
	/**
	 * Var float
	 */
	public $estimatedLaborRevenue;
	/**
	 * Var float
	 */
	public $estimatedGrossProfit;
	/**
	 * Var float
	 */
	public $estimatedGrossProfitPercent;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $projectExpenseType;
	/**
	 * Var boolean
	 */
	public $applyProjectExpenseTypeToAll;
	/**
	 * Var boolean
	 */
	public $allowAllResourcesForTasks;
	/**
	 * Var float
	 */
	public $jobPrice;
	/**
	 * Var boolean
	 */
	public $isUtilizedTime;
	/**
	 * Var boolean
	 */
	public $isProductiveTime;
	/**
	 * Var boolean
	 */
	public $isExemptTime;
	/**
	 * Var boolean
	 */
	public $materializeTime;
	/**
	 * Var boolean
	 */
	public $allowExpenses;
	/**
	 * Var boolean
	 */
	public $allocatePayrollExpenses;
	/**
	 * Var boolean
	 */
	public $includeCrmTasksInTotals;
	/**
	 * Var \NetSuite\Classes\GlobalSubscriptionStatus
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\JobResourcesList
	 */
	public $jobResourcesList;
	/**
	 * Var \NetSuite\Classes\JobPlStatementList
	 */
	public $plStatementList;
	/**
	 * Var \NetSuite\Classes\JobAddressbookList
	 */
	public $addressbookList;
	/**
	 * Var \NetSuite\Classes\JobMilestonesList
	 */
	public $milestonesList;
	/**
	 * Var \NetSuite\Classes\JobCreditCardsList
	 */
	public $creditCardsList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeApproval;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $plannedWork;
	/**
	 * Var \NetSuite\Classes\Duration
	 */
	public $plannedWorkBaseline;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingRateCard;
	/**
	 * Var boolean
	 */
	public $createChargeRule;
	/**
	 * Var boolean
	 */
	public $sourceServiceItemFromRateCard;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $projectManager;
	/**
	 * Var \NetSuite\Classes\JobSchedulingMethod
	 */
	public $schedulingMethod;
	/**
	 * Var string
	 */
	public $scheduledEndDate;
	/**
	 * Var string
	 */
	public $calculatedStartDate;
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
		'companyName' => 'string',
		'phoneticName' => 'string',
		'entityStatus' => 'RecordRef',
		'defaultAddress' => 'string',
		'parent' => 'RecordRef',
		'isInactive' => 'boolean',
		'percentCompleteOverrideList' => 'JobPercentCompleteOverrideList',
		'lastModifiedDate' => 'dateTime',
		'billPay' => 'boolean',
		'dateCreated' => 'dateTime',
		'category' => 'RecordRef',
		'workplace' => 'RecordRef',
		'language' => 'RecordRef',
		'comments' => 'string',
		'accountNumber' => 'string',
		'currency' => 'RecordRef',
		'fxRate' => 'float',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'phone' => 'string',
		'altPhone' => 'string',
		'calculatedEndDate' => 'dateTime',
		'calculatedEndDateBaseline' => 'dateTime',
		'startDateBaseline' => 'dateTime',
		'projectedEndDate' => 'dateTime',
		'projectedEndDateBaseline' => 'dateTime',
		'lastBaselineDate' => 'dateTime',
		'jobType' => 'RecordRef',
		'percentComplete' => 'float',
		'estimatedCost' => 'float',
		'estimatedRevenue' => 'float',
		'estimatedTime' => 'Duration',
		'estimatedTimeOverride' => 'Duration',
		'fax' => 'string',
		'email' => 'string',
		'emailPreference' => 'EmailPreference',
		'openingBalance' => 'float',
		'openingBalanceDate' => 'dateTime',
		'openingBalanceAccount' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'jobBillingType' => 'JobBillingType',
		'billingSchedule' => 'RecordRef',
		'jobItem' => 'RecordRef',
		'percentTimeComplete' => 'float',
		'actualTime' => 'Duration',
		'allowTime' => 'boolean',
		'timeRemaining' => 'Duration',
		'limitTimeToAssignees' => 'boolean',
		'estimatedLaborCost' => 'float',
		'estimatedLaborCostBaseline' => 'float',
		'estimateRevRecTemplate' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'usePercentCompleteOverride' => 'boolean',
		'estimatedLaborRevenue' => 'float',
		'estimatedGrossProfit' => 'float',
		'estimatedGrossProfitPercent' => 'float',
		'projectExpenseType' => 'RecordRef',
		'applyProjectExpenseTypeToAll' => 'boolean',
		'allowAllResourcesForTasks' => 'boolean',
		'jobPrice' => 'float',
		'isUtilizedTime' => 'boolean',
		'isProductiveTime' => 'boolean',
		'isExemptTime' => 'boolean',
		'materializeTime' => 'boolean',
		'allowExpenses' => 'boolean',
		'allocatePayrollExpenses' => 'boolean',
		'includeCrmTasksInTotals' => 'boolean',
		'globalSubscriptionStatus' => 'GlobalSubscriptionStatus',
		'jobResourcesList' => 'JobResourcesList',
		'plStatementList' => 'JobPlStatementList',
		'addressbookList' => 'JobAddressbookList',
		'milestonesList' => 'JobMilestonesList',
		'creditCardsList' => 'JobCreditCardsList',
		'timeApproval' => 'RecordRef',
		'plannedWork' => 'Duration',
		'plannedWorkBaseline' => 'Duration',
		'billingRateCard' => 'RecordRef',
		'createChargeRule' => 'boolean',
		'sourceServiceItemFromRateCard' => 'boolean',
		'projectManager' => 'RecordRef',
		'schedulingMethod' => 'JobSchedulingMethod',
		'scheduledEndDate' => 'dateTime',
		'calculatedStartDate' => 'dateTime',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
