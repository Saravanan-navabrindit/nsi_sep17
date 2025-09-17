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

class Employee extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $template;
	/**
	 * Var string
	 */
	public $entityId;
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
	public $altName;
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
	public $defaultAddress;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $phoneticName;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $dateCreated;
	/**
	 * Var string
	 */
	public $initials;
	/**
	 * Var string
	 */
	public $officePhone;
	/**
	 * Var string
	 */
	public $homePhone;
	/**
	 * Var string
	 */
	public $mobilePhone;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingClass;
	/**
	 * Var string
	 */
	public $accountNumber;
	/**
	 * Var \NetSuite\Classes\EmployeeCompensationCurrency
	 */
	public $compensationCurrency;
	/**
	 * Var \NetSuite\Classes\EmployeeBaseWageType
	 */
	public $baseWageType;
	/**
	 * Var float
	 */
	public $baseWage;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\GlobalSubscriptionStatus
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $image;
	/**
	 * Var \NetSuite\Classes\EmployeePayFrequency
	 */
	public $payFrequency;
	/**
	 * Var string
	 */
	public $lastPaidDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\EmployeeUseTimeData
	 */
	public $useTimeData;
	/**
	 * Var boolean
	 */
	public $usePerquest;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workplace;
	/**
	 * Var string
	 */
	public $adpId;
	/**
	 * Var boolean
	 */
	public $directDeposit;
	/**
	 * Var float
	 */
	public $expenseLimit;
	/**
	 * Var float
	 */
	public $purchaseOrderLimit;
	/**
	 * Var float
	 */
	public $purchaseOrderApprovalLimit;
	/**
	 * Var string
	 */
	public $socialSecurityNumber;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supervisor;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approver;
	/**
	 * Var float
	 */
	public $approvalLimit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeApprover;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employeeType;
	/**
	 * Var boolean
	 */
	public $isSalesRep;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesRole;
	/**
	 * Var boolean
	 */
	public $isSupportRep;
	/**
	 * Var boolean
	 */
	public $isJobResource;
	/**
	 * Var float
	 */
	public $laborCost;
	/**
	 * Var string
	 */
	public $birthDate;
	/**
	 * Var string
	 */
	public $hireDate;
	/**
	 * Var string
	 */
	public $releaseDate;
	/**
	 * Var string
	 */
	public $terminationDetails;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $terminationReason;
	/**
	 * Var \NetSuite\Classes\EmployeeTerminationRegretted
	 */
	public $terminationRegretted;
	/**
	 * Var \NetSuite\Classes\EmployeeTerminationCategory
	 */
	public $terminationCategory;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeOffPlan;
	/**
	 * Var string
	 */
	public $lastReviewDate;
	/**
	 * Var string
	 */
	public $nextReviewDate;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employeeStatus;
	/**
	 * Var string
	 */
	public $jobDescription;
	/**
	 * Var \NetSuite\Classes\EmployeeWorkAssignment
	 */
	public $workAssignment;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $maritalStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $ethnicity;
	/**
	 * Var \NetSuite\Classes\Gender
	 */
	public $gender;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseOrderApprover;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workCalendar;
	/**
	 * Var boolean
	 */
	public $giveAccess;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultExpenseReportCurrency;
	/**
	 * Var boolean
	 */
	public $concurrentWebServicesUser;
	/**
	 * Var boolean
	 */
	public $sendEmail;
	/**
	 * Var boolean
	 */
	public $hasOfflineAccess;
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
	public $inheritIPRules;
	/**
	 * Var string
	 */
	public $IPAddressRule;
	/**
	 * Var string
	 */
	public $startDateTimeOffCalc;
	/**
	 * Var \NetSuite\Classes\EmployeeCommissionPaymentPreference
	 */
	public $commissionPaymentPreference;
	/**
	 * Var boolean
	 */
	public $billPay;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultAcctCorpCardExp;
	/**
	 * Var boolean
	 */
	public $eligibleForCommission;
	/**
	 * Var \NetSuite\Classes\EmployeeSubscriptionsList
	 */
	public $subscriptionsList;
	/**
	 * Var \NetSuite\Classes\EmployeeRatesList
	 */
	public $ratesList;
	/**
	 * Var \NetSuite\Classes\EmployeeAddressbookList
	 */
	public $addressbookList;
	/**
	 * Var \NetSuite\Classes\EmployeeRolesList
	 */
	public $rolesList;
	/**
	 * Var \NetSuite\Classes\EmployeeHrEducationList
	 */
	public $hrEducationList;
	/**
	 * Var \NetSuite\Classes\EmployeeAccruedTimeList
	 */
	public $accruedTimeList;
	/**
	 * Var \NetSuite\Classes\EmployeeDirectDepositList
	 */
	public $directDepositList;
	/**
	 * Var \NetSuite\Classes\EmployeeCurrencyList
	 */
	public $currencyList;
	/**
	 * Var \NetSuite\Classes\EmployeeCompanyContributionList
	 */
	public $companyContributionList;
	/**
	 * Var \NetSuite\Classes\EmployeeEarningList
	 */
	public $earningList;
	/**
	 * Var \NetSuite\Classes\EmployeeEmergencyContactList
	 */
	public $emergencyContactList;
	/**
	 * Var \NetSuite\Classes\EmployeeHcmPositionList
	 */
	public $hcmPositionList;
	/**
	 * Var \NetSuite\Classes\EmployeeDeductionList
	 */
	public $deductionList;
	/**
	 * Var boolean
	 */
	public $isJobManager;
	/**
	 * Var float
	 */
	public $targetUtilization;
	/**
	 * Var float
	 */
	public $bonusTarget;
	/**
	 * Var string
	 */
	public $bonusTargetComment;
	/**
	 * Var \NetSuite\Classes\EmployeeBonusTargetType
	 */
	public $bonusTargetType;
	/**
	 * Var \NetSuite\Classes\EmployeeBonusTargetPayFrequency
	 */
	public $bonusTargetPayFrequency;
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
		'template' => 'RecordRef',
		'entityId' => 'string',
		'salutation' => 'string',
		'firstName' => 'string',
		'middleName' => 'string',
		'lastName' => 'string',
		'altName' => 'string',
		'phone' => 'string',
		'fax' => 'string',
		'email' => 'string',
		'defaultAddress' => 'string',
		'isInactive' => 'boolean',
		'phoneticName' => 'string',
		'lastModifiedDate' => 'dateTime',
		'dateCreated' => 'dateTime',
		'initials' => 'string',
		'officePhone' => 'string',
		'homePhone' => 'string',
		'mobilePhone' => 'string',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'billingClass' => 'RecordRef',
		'accountNumber' => 'string',
		'compensationCurrency' => 'EmployeeCompensationCurrency',
		'baseWageType' => 'EmployeeBaseWageType',
		'baseWage' => 'float',
		'comments' => 'string',
		'globalSubscriptionStatus' => 'GlobalSubscriptionStatus',
		'image' => 'RecordRef',
		'payFrequency' => 'EmployeePayFrequency',
		'lastPaidDate' => 'dateTime',
		'currency' => 'RecordRef',
		'useTimeData' => 'EmployeeUseTimeData',
		'usePerquest' => 'boolean',
		'workplace' => 'RecordRef',
		'adpId' => 'string',
		'directDeposit' => 'boolean',
		'expenseLimit' => 'float',
		'purchaseOrderLimit' => 'float',
		'purchaseOrderApprovalLimit' => 'float',
		'socialSecurityNumber' => 'string',
		'supervisor' => 'RecordRef',
		'approver' => 'RecordRef',
		'approvalLimit' => 'float',
		'timeApprover' => 'RecordRef',
		'employeeType' => 'RecordRef',
		'isSalesRep' => 'boolean',
		'salesRole' => 'RecordRef',
		'isSupportRep' => 'boolean',
		'isJobResource' => 'boolean',
		'laborCost' => 'float',
		'birthDate' => 'dateTime',
		'hireDate' => 'dateTime',
		'releaseDate' => 'dateTime',
		'terminationDetails' => 'string',
		'terminationReason' => 'RecordRef',
		'terminationRegretted' => 'EmployeeTerminationRegretted',
		'terminationCategory' => 'EmployeeTerminationCategory',
		'timeOffPlan' => 'RecordRef',
		'lastReviewDate' => 'dateTime',
		'nextReviewDate' => 'dateTime',
		'title' => 'string',
		'employeeStatus' => 'RecordRef',
		'jobDescription' => 'string',
		'workAssignment' => 'EmployeeWorkAssignment',
		'job' => 'RecordRef',
		'maritalStatus' => 'RecordRef',
		'ethnicity' => 'RecordRef',
		'gender' => 'Gender',
		'purchaseOrderApprover' => 'RecordRef',
		'workCalendar' => 'RecordRef',
		'giveAccess' => 'boolean',
		'defaultExpenseReportCurrency' => 'RecordRef',
		'concurrentWebServicesUser' => 'boolean',
		'sendEmail' => 'boolean',
		'hasOfflineAccess' => 'boolean',
		'password' => 'string',
		'password2' => 'string',
		'requirePwdChange' => 'boolean',
		'inheritIPRules' => 'boolean',
		'IPAddressRule' => 'string',
		'startDateTimeOffCalc' => 'dateTime',
		'commissionPaymentPreference' => 'EmployeeCommissionPaymentPreference',
		'billPay' => 'boolean',
		'defaultAcctCorpCardExp' => 'RecordRef',
		'eligibleForCommission' => 'boolean',
		'subscriptionsList' => 'EmployeeSubscriptionsList',
		'ratesList' => 'EmployeeRatesList',
		'addressbookList' => 'EmployeeAddressbookList',
		'rolesList' => 'EmployeeRolesList',
		'hrEducationList' => 'EmployeeHrEducationList',
		'accruedTimeList' => 'EmployeeAccruedTimeList',
		'directDepositList' => 'EmployeeDirectDepositList',
		'currencyList' => 'EmployeeCurrencyList',
		'companyContributionList' => 'EmployeeCompanyContributionList',
		'earningList' => 'EmployeeEarningList',
		'emergencyContactList' => 'EmployeeEmergencyContactList',
		'hcmPositionList' => 'EmployeeHcmPositionList',
		'deductionList' => 'EmployeeDeductionList',
		'isJobManager' => 'boolean',
		'targetUtilization' => 'float',
		'bonusTarget' => 'float',
		'bonusTargetComment' => 'string',
		'bonusTargetType' => 'EmployeeBonusTargetType',
		'bonusTargetPayFrequency' => 'EmployeeBonusTargetPayFrequency',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
