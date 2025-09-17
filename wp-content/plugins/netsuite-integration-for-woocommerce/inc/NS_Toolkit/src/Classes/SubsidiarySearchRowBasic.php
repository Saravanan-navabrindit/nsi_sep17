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

class SubsidiarySearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBookCurrency;
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
	public $anonymousCustomerInboundEmail;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $anonymousCustomerOnlineForms;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseAssignmentTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseAutomaticClosureTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseCopyEmployeeTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseCreationTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseEscalationTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $caseUpdateTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $companyNameForSupportMessages;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $effectiveFrom;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $employeeCaseUpdateTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fax;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isElimination;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $legalName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $mainSupportEmailAddress;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $nameNoHierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $receiptAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $receiptQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $receiptQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxEngine;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $taxIdNum;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $taxRegistrationNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $tranPrefix;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $url;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $validUntil;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountingBook' => 'SearchColumnSelectField[]',
		'accountingBookCurrency' => 'SearchColumnSelectField[]',
		'address1' => 'SearchColumnStringField[]',
		'address2' => 'SearchColumnStringField[]',
		'address3' => 'SearchColumnStringField[]',
		'anonymousCustomerInboundEmail' => 'SearchColumnStringField[]',
		'anonymousCustomerOnlineForms' => 'SearchColumnStringField[]',
		'caseAssignmentTemplate' => 'SearchColumnStringField[]',
		'caseAutomaticClosureTemplate' => 'SearchColumnStringField[]',
		'caseCopyEmployeeTemplate' => 'SearchColumnStringField[]',
		'caseCreationTemplate' => 'SearchColumnStringField[]',
		'caseEscalationTemplate' => 'SearchColumnStringField[]',
		'caseUpdateTemplate' => 'SearchColumnStringField[]',
		'city' => 'SearchColumnStringField[]',
		'companyNameForSupportMessages' => 'SearchColumnStringField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'currency' => 'SearchColumnSelectField[]',
		'effectiveFrom' => 'SearchColumnDateField[]',
		'email' => 'SearchColumnStringField[]',
		'employeeCaseUpdateTemplate' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fax' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isElimination' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'legalName' => 'SearchColumnStringField[]',
		'mainSupportEmailAddress' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'nameNoHierarchy' => 'SearchColumnStringField[]',
		'nexus' => 'SearchColumnSelectField[]',
		'phone' => 'SearchColumnStringField[]',
		'purchaseOrderAmount' => 'SearchColumnDoubleField[]',
		'purchaseOrderQuantity' => 'SearchColumnDoubleField[]',
		'purchaseOrderQuantityDiff' => 'SearchColumnDoubleField[]',
		'receiptAmount' => 'SearchColumnDoubleField[]',
		'receiptQuantity' => 'SearchColumnDoubleField[]',
		'receiptQuantityDiff' => 'SearchColumnDoubleField[]',
		'state' => 'SearchColumnStringField[]',
		'taxEngine' => 'SearchColumnSelectField[]',
		'taxIdNum' => 'SearchColumnStringField[]',
		'taxRegistrationNumber' => 'SearchColumnStringField[]',
		'tranPrefix' => 'SearchColumnStringField[]',
		'url' => 'SearchColumnStringField[]',
		'validUntil' => 'SearchColumnDateField[]',
		'zip' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
