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

class ChargeSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billTo;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $chargeDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $modifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $rule;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $runId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $salesOrder;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $stage;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $use;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amount' => 'SearchColumnDoubleField[]',
		'billingAccount' => 'SearchColumnSelectField[]',
		'billingItem' => 'SearchColumnSelectField[]',
		'billTo' => 'SearchColumnSelectField[]',
		'chargeDate' => 'SearchColumnDateField[]',
		'chargeType' => 'SearchColumnSelectField[]',
		'class' => 'SearchColumnSelectField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'currency' => 'SearchColumnSelectField[]',
		'department' => 'SearchColumnSelectField[]',
		'description' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'location' => 'SearchColumnSelectField[]',
		'modifiedDate' => 'SearchColumnDateField[]',
		'postingPeriod' => 'SearchColumnStringField[]',
		'quantity' => 'SearchColumnStringField[]',
		'rate' => 'SearchColumnStringField[]',
		'rule' => 'SearchColumnSelectField[]',
		'runId' => 'SearchColumnStringField[]',
		'salesOrder' => 'SearchColumnStringField[]',
		'stage' => 'SearchColumnEnumSelectField[]',
		'subscriptionLine' => 'SearchColumnSelectField[]',
		'use' => 'SearchColumnEnumSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
