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

class Charge extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesOrder;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billTo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingAccount;
	/**
	 * Var \NetSuite\Classes\ChargeStage
	 */
	public $stage;
	/**
	 * Var string
	 */
	public $chargeDate;
	/**
	 * Var \NetSuite\Classes\ChargeUse
	 */
	public $use;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $projectTask;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeRecord;
	/**
	 * Var string
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingItem;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transaction;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transactionLine;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesOrderLine;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $invoice;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $invoiceLine;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $rule;
	/**
	 * Var string
	 */
	public $runId;
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
		'salesOrder' => 'RecordRef',
		'billTo' => 'RecordRef',
		'billingAccount' => 'RecordRef',
		'stage' => 'ChargeStage',
		'chargeDate' => 'dateTime',
		'use' => 'ChargeUse',
		'chargeType' => 'RecordRef',
		'projectTask' => 'RecordRef',
		'description' => 'string',
		'createdDate' => 'dateTime',
		'timeRecord' => 'RecordRef',
		'rate' => 'string',
		'quantity' => 'float',
		'amount' => 'float',
		'billingItem' => 'RecordRef',
		'currency' => 'RecordRef',
		'transaction' => 'RecordRef',
		'transactionLine' => 'RecordRef',
		'class' => 'RecordRef',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'salesOrderLine' => 'RecordRef',
		'subscriptionLine' => 'RecordRef',
		'invoice' => 'RecordRef',
		'invoiceLine' => 'RecordRef',
		'rule' => 'RecordRef',
		'runId' => 'string',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
