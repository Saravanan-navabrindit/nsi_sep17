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

class EmployeeSearchBasic extends SearchRecordBasic {
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
	public $alienNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $allocation;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $anniversary;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $approvalLimit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $approver;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $authWorkDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $baseWage;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $baseWageType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billAddress;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingClass;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $birthDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $birthDay;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $bonusTarget;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $bonusTargetComment;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $bonusTargetPayFrequency;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $bonusTargetType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $cContribution;
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
	public $compensationCurrency;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $concurrentWebServicesUser;
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
	public $deduction;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $defaultAcctCorpCardExp;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $defaultExpenseReportCurrency;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $earning;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $education;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $eligibleForCommission;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $employeeStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $employeeType;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $employeeTypeKpi;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $entityId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $ethnicity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $expenseLimit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $expenseReportCurrency;
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
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $gender;
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
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $hireDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $I9Verified;
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
	public $isJobManager;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isJobResource;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isTemplate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $jobDescription;
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
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastPaidDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastReviewDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $maritalStatus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $middleName;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $nextReviewDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $offlineAccess;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $payFrequency;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $permChangeDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $permission;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $permissionChange;
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
	public $positionTitle;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $primaryEarningAmount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $primaryEarningItem;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $primaryEarningType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderApprovalLimit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $purchaseOrderApprover;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderLimit;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $releaseDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $residentStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $role;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $roleChange;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $roleChangeDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesRole;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $salutation;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $socialSecurityNumber;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDateTimeOffCalc;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $supervisor;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $supportRep;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $targetUtilization;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $terminationCategory;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $terminationDetails;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $terminationReason;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $terminationRegretted;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $timeApprover;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $timeOffPlan;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $usePerquest;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useTimeData;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $visaExpDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $visaType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $withholding;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $workCalendar;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $workplace;
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
		'alienNumber' => 'SearchStringField',
		'allocation' => 'SearchDoubleField',
		'anniversary' => 'SearchDateField',
		'approvalLimit' => 'SearchDoubleField',
		'approver' => 'SearchMultiSelectField',
		'attention' => 'SearchStringField',
		'authWorkDate' => 'SearchDateField',
		'baseWage' => 'SearchDoubleField',
		'baseWageType' => 'SearchEnumMultiSelectField',
		'billAddress' => 'SearchStringField',
		'billingClass' => 'SearchMultiSelectField',
		'birthDate' => 'SearchDateField',
		'birthDay' => 'SearchDateField',
		'bonusTarget' => 'SearchDoubleField',
		'bonusTargetComment' => 'SearchStringField',
		'bonusTargetPayFrequency' => 'SearchEnumMultiSelectField',
		'bonusTargetType' => 'SearchEnumMultiSelectField',
		'cContribution' => 'SearchMultiSelectField',
		'city' => 'SearchStringField',
		'class' => 'SearchMultiSelectField',
		'comments' => 'SearchStringField',
		'commissionPlan' => 'SearchMultiSelectField',
		'compensationCurrency' => 'SearchEnumMultiSelectField',
		'concurrentWebServicesUser' => 'SearchBooleanField',
		'country' => 'SearchEnumMultiSelectField',
		'county' => 'SearchStringField',
		'dateCreated' => 'SearchDateField',
		'deduction' => 'SearchMultiSelectField',
		'defaultAcctCorpCardExp' => 'SearchMultiSelectField',
		'defaultExpenseReportCurrency' => 'SearchMultiSelectField',
		'defaultTaxReg' => 'SearchMultiSelectField',
		'defaultTaxRegText' => 'SearchStringField',
		'department' => 'SearchMultiSelectField',
		'earning' => 'SearchMultiSelectField',
		'education' => 'SearchMultiSelectField',
		'eligibleForCommission' => 'SearchBooleanField',
		'email' => 'SearchStringField',
		'employeeStatus' => 'SearchMultiSelectField',
		'employeeType' => 'SearchMultiSelectField',
		'employeeTypeKpi' => 'SearchBooleanField',
		'entityId' => 'SearchStringField',
		'ethnicity' => 'SearchMultiSelectField',
		'expenseLimit' => 'SearchDoubleField',
		'expenseReportCurrency' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fax' => 'SearchStringField',
		'firstName' => 'SearchStringField',
		'gender' => 'SearchEnumMultiSelectField',
		'giveAccess' => 'SearchBooleanField',
		'globalSubscriptionStatus' => 'SearchEnumMultiSelectField',
		'group' => 'SearchMultiSelectField',
		'hireDate' => 'SearchDateField',
		'I9Verified' => 'SearchBooleanField',
		'image' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isDefaultBilling' => 'SearchBooleanField',
		'isDefaultShipping' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isJobManager' => 'SearchBooleanField',
		'isJobResource' => 'SearchBooleanField',
		'isTemplate' => 'SearchBooleanField',
		'job' => 'SearchMultiSelectField',
		'jobDescription' => 'SearchStringField',
		'laborCost' => 'SearchDoubleField',
		'language' => 'SearchEnumMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'lastName' => 'SearchStringField',
		'lastPaidDate' => 'SearchDateField',
		'lastReviewDate' => 'SearchDateField',
		'level' => 'SearchEnumMultiSelectField',
		'location' => 'SearchMultiSelectField',
		'maritalStatus' => 'SearchMultiSelectField',
		'middleName' => 'SearchStringField',
		'nextReviewDate' => 'SearchDateField',
		'offlineAccess' => 'SearchBooleanField',
		'payFrequency' => 'SearchEnumMultiSelectField',
		'permChangeDate' => 'SearchDateField',
		'permission' => 'SearchEnumMultiSelectField',
		'permissionChange' => 'SearchEnumMultiSelectField',
		'phone' => 'SearchStringField',
		'phoneticName' => 'SearchStringField',
		'positionTitle' => 'SearchMultiSelectField',
		'primaryEarningAmount' => 'SearchDoubleField',
		'primaryEarningItem' => 'SearchStringField',
		'primaryEarningType' => 'SearchStringField',
		'purchaseOrderApprovalLimit' => 'SearchDoubleField',
		'purchaseOrderApprover' => 'SearchMultiSelectField',
		'purchaseOrderLimit' => 'SearchDoubleField',
		'releaseDate' => 'SearchDateField',
		'residentStatus' => 'SearchMultiSelectField',
		'role' => 'SearchMultiSelectField',
		'roleChange' => 'SearchMultiSelectField',
		'roleChangeDate' => 'SearchDateField',
		'salesRep' => 'SearchBooleanField',
		'salesRole' => 'SearchMultiSelectField',
		'salutation' => 'SearchStringField',
		'socialSecurityNumber' => 'SearchStringField',
		'startDateTimeOffCalc' => 'SearchDateField',
		'state' => 'SearchStringField',
		'subsidiary' => 'SearchMultiSelectField',
		'supervisor' => 'SearchMultiSelectField',
		'supportRep' => 'SearchBooleanField',
		'targetUtilization' => 'SearchDoubleField',
		'terminationCategory' => 'SearchEnumMultiSelectField',
		'terminationDetails' => 'SearchStringField',
		'terminationReason' => 'SearchMultiSelectField',
		'terminationRegretted' => 'SearchEnumMultiSelectField',
		'timeApprover' => 'SearchMultiSelectField',
		'timeOffPlan' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'usePerquest' => 'SearchBooleanField',
		'useTimeData' => 'SearchBooleanField',
		'visaExpDate' => 'SearchDateField',
		'visaType' => 'SearchMultiSelectField',
		'withholding' => 'SearchMultiSelectField',
		'workCalendar' => 'SearchMultiSelectField',
		'workplace' => 'SearchMultiSelectField',
		'zipCode' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
