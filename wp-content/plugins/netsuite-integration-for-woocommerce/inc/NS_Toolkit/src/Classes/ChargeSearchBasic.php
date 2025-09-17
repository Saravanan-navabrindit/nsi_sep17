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

class ChargeSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingAccount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingItem;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billTo;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $chargeDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $modifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\PostingPeriodDate
	 */
	public $postingPeriodRelative;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $rule;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $runId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $salesOrder;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $stage;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $use;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amount' => 'SearchDoubleField',
		'billingAccount' => 'SearchMultiSelectField',
		'billingItem' => 'SearchMultiSelectField',
		'billTo' => 'SearchMultiSelectField',
		'chargeDate' => 'SearchDateField',
		'chargeType' => 'SearchMultiSelectField',
		'class' => 'SearchMultiSelectField',
		'createdDate' => 'SearchDateField',
		'currency' => 'SearchMultiSelectField',
		'department' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'location' => 'SearchMultiSelectField',
		'modifiedDate' => 'SearchDateField',
		'postingPeriod' => 'RecordRef',
		'postingPeriodRelative' => 'PostingPeriodDate',
		'quantity' => 'SearchDoubleField',
		'rate' => 'SearchDoubleField',
		'rule' => 'SearchMultiSelectField',
		'runId' => 'SearchStringField',
		'salesOrder' => 'SearchLongField',
		'stage' => 'SearchEnumMultiSelectField',
		'subscriptionLine' => 'SearchMultiSelectField',
		'use' => 'SearchEnumMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
