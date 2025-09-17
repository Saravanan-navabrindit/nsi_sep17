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

class EmployeeSearchRowBasic extends SearchRowBasic {
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
	public $alienNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $allocation;
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
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $approvalLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $approver;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $attention;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $authWorkDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $baseWage;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField[]
	 */
	public $baseWageType;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingClass;
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
	public $birthDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $birthDay;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $bonusTarget;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $bonusTargetComment;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $bonusTargetPayFrequency;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $bonusTargetType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $comments;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $compensationCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $concurrentWebServicesUser;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $countryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $defaultAcctCorpCardExp;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $defaultExpenseReportCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $defaultTaxReg;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $eligibleForCommission;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $employeeStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $employeeType;
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
	public $ethnicity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $expenseLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $expenseReportCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fax;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $firstName;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $gender;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $giveAccess;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $globalSubscriptionStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $hireDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $homePhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $i9Verified;
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
	public $isJobManager;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isJobResource;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSalesRep;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSupportRep;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $laborCost;
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
	public $lastPaidDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastReviewDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $level;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $maritalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $middleName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $mobilePhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $nextReviewDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $offlineAccess;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $payFrequency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $permChangeDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $permChangeLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $permission;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $permissionChange;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phoneticName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $positionTitle;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $primaryEarningAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $primaryEarningItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $primaryEarningType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderApprovalLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $purchaseOrderApprover;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $releaseDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $residentStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $role;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $roleChange;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $roleChangeAction;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $roleChangeDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $salutation;
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
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $socialSecurityNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDateTimeOffCalc;
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
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $supervisor;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $targetUtilization;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $terminationCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $terminationDetails;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $terminationReason;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $terminationRegretted;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $timeApprover;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $timeOffPlan;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $usePerquest;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useTimeData;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $visaExpDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $visaType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $workCalendar;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $workplace;
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
		'alienNumber' => 'SearchColumnStringField[]',
		'allocation' => 'SearchColumnDoubleField[]',
		'altEmail' => 'SearchColumnStringField[]',
		'altName' => 'SearchColumnStringField[]',
		'altPhone' => 'SearchColumnStringField[]',
		'approvalLimit' => 'SearchColumnDoubleField[]',
		'approver' => 'SearchColumnSelectField[]',
		'attention' => 'SearchColumnStringField[]',
		'authWorkDate' => 'SearchColumnDateField[]',
		'baseWage' => 'SearchColumnDoubleField[]',
		'baseWageType' => 'SearchEnumMultiSelectField[]',
		'billAddress' => 'SearchColumnStringField[]',
		'billAddress1' => 'SearchColumnStringField[]',
		'billAddress2' => 'SearchColumnStringField[]',
		'billAddress3' => 'SearchColumnStringField[]',
		'billAddressee' => 'SearchColumnStringField[]',
		'billAttention' => 'SearchColumnStringField[]',
		'billCity' => 'SearchColumnStringField[]',
		'billCountry' => 'SearchColumnEnumSelectField[]',
		'billCountryCode' => 'SearchColumnStringField[]',
		'billingClass' => 'SearchColumnSelectField[]',
		'billPhone' => 'SearchColumnStringField[]',
		'billState' => 'SearchColumnStringField[]',
		'billZipCode' => 'SearchColumnStringField[]',
		'birthDate' => 'SearchColumnDateField[]',
		'birthDay' => 'SearchColumnDateField[]',
		'bonusTarget' => 'SearchColumnDoubleField[]',
		'bonusTargetComment' => 'SearchColumnStringField[]',
		'bonusTargetPayFrequency' => 'SearchColumnEnumSelectField[]',
		'bonusTargetType' => 'SearchColumnEnumSelectField[]',
		'city' => 'SearchColumnStringField[]',
		'class' => 'SearchColumnSelectField[]',
		'comments' => 'SearchColumnStringField[]',
		'compensationCurrency' => 'SearchColumnEnumSelectField[]',
		'concurrentWebServicesUser' => 'SearchColumnBooleanField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'countryCode' => 'SearchColumnStringField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'defaultAcctCorpCardExp' => 'SearchColumnSelectField[]',
		'defaultExpenseReportCurrency' => 'SearchColumnSelectField[]',
		'defaultTaxReg' => 'SearchColumnStringField[]',
		'department' => 'SearchColumnSelectField[]',
		'eligibleForCommission' => 'SearchColumnBooleanField[]',
		'email' => 'SearchColumnStringField[]',
		'employeeStatus' => 'SearchColumnSelectField[]',
		'employeeType' => 'SearchColumnSelectField[]',
		'entityId' => 'SearchColumnStringField[]',
		'entityNumber' => 'SearchColumnLongField[]',
		'ethnicity' => 'SearchColumnSelectField[]',
		'expenseLimit' => 'SearchColumnDoubleField[]',
		'expenseReportCurrency' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fax' => 'SearchColumnStringField[]',
		'firstName' => 'SearchColumnStringField[]',
		'gender' => 'SearchColumnEnumSelectField[]',
		'giveAccess' => 'SearchColumnBooleanField[]',
		'globalSubscriptionStatus' => 'SearchColumnEnumSelectField[]',
		'hireDate' => 'SearchColumnDateField[]',
		'homePhone' => 'SearchColumnStringField[]',
		'i9Verified' => 'SearchColumnBooleanField[]',
		'image' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isDefaultBilling' => 'SearchColumnBooleanField[]',
		'isDefaultShipping' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isJobManager' => 'SearchColumnBooleanField[]',
		'isJobResource' => 'SearchColumnBooleanField[]',
		'isSalesRep' => 'SearchColumnBooleanField[]',
		'isSupportRep' => 'SearchColumnBooleanField[]',
		'isTemplate' => 'SearchColumnBooleanField[]',
		'job' => 'SearchColumnSelectField[]',
		'laborCost' => 'SearchColumnDoubleField[]',
		'language' => 'SearchColumnEnumSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'lastName' => 'SearchColumnStringField[]',
		'lastPaidDate' => 'SearchColumnDateField[]',
		'lastReviewDate' => 'SearchColumnDateField[]',
		'level' => 'SearchColumnEnumSelectField[]',
		'location' => 'SearchColumnSelectField[]',
		'maritalStatus' => 'SearchColumnSelectField[]',
		'middleName' => 'SearchColumnStringField[]',
		'mobilePhone' => 'SearchColumnStringField[]',
		'nextReviewDate' => 'SearchColumnDateField[]',
		'offlineAccess' => 'SearchColumnBooleanField[]',
		'payFrequency' => 'SearchColumnEnumSelectField[]',
		'permChangeDate' => 'SearchColumnDateField[]',
		'permChangeLevel' => 'SearchColumnStringField[]',
		'permission' => 'SearchColumnEnumSelectField[]',
		'permissionChange' => 'SearchColumnEnumSelectField[]',
		'phone' => 'SearchColumnStringField[]',
		'phoneticName' => 'SearchColumnStringField[]',
		'positionTitle' => 'SearchColumnStringField[]',
		'primaryEarningAmount' => 'SearchColumnDoubleField[]',
		'primaryEarningItem' => 'SearchColumnStringField[]',
		'primaryEarningType' => 'SearchColumnStringField[]',
		'purchaseOrderApprovalLimit' => 'SearchColumnDoubleField[]',
		'purchaseOrderApprover' => 'SearchColumnSelectField[]',
		'purchaseOrderLimit' => 'SearchColumnDoubleField[]',
		'releaseDate' => 'SearchColumnDateField[]',
		'residentStatus' => 'SearchColumnSelectField[]',
		'role' => 'SearchColumnSelectField[]',
		'roleChange' => 'SearchColumnStringField[]',
		'roleChangeAction' => 'SearchColumnStringField[]',
		'roleChangeDate' => 'SearchColumnDateField[]',
		'salesRole' => 'SearchColumnSelectField[]',
		'salutation' => 'SearchColumnStringField[]',
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
		'socialSecurityNumber' => 'SearchColumnStringField[]',
		'startDateTimeOffCalc' => 'SearchColumnDateField[]',
		'state' => 'SearchColumnEnumSelectField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'subscriptionDate' => 'SearchColumnDateField[]',
		'subscriptionStatus' => 'SearchColumnBooleanField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'supervisor' => 'SearchColumnSelectField[]',
		'targetUtilization' => 'SearchColumnDoubleField[]',
		'terminationCategory' => 'SearchColumnEnumSelectField[]',
		'terminationDetails' => 'SearchColumnStringField[]',
		'terminationReason' => 'SearchColumnSelectField[]',
		'terminationRegretted' => 'SearchColumnEnumSelectField[]',
		'timeApprover' => 'SearchColumnSelectField[]',
		'timeOffPlan' => 'SearchColumnStringField[]',
		'title' => 'SearchColumnStringField[]',
		'usePerquest' => 'SearchColumnBooleanField[]',
		'useTimeData' => 'SearchColumnBooleanField[]',
		'visaExpDate' => 'SearchColumnDateField[]',
		'visaType' => 'SearchColumnSelectField[]',
		'workCalendar' => 'SearchColumnStringField[]',
		'workplace' => 'SearchColumnSelectField[]',
		'zipCode' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
