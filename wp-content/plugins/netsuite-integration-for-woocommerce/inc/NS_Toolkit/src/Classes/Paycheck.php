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

class Paycheck extends Record {
	/**
	 * Var string
	 */
	public $batchNumber;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var string
	 */
	public $address;
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
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workplace;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var float
	 */
	public $userAmount;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var string
	 */
	public $payFrequency;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var string
	 */
	public $periodEnding;
	/**
	 * Var \NetSuite\Classes\PaycheckPayEarnList
	 */
	public $payEarnList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayTimeList
	 */
	public $payTimeList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayExpList
	 */
	public $payExpList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayPtoList
	 */
	public $payPtoList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayDeductList
	 */
	public $payDeductList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayContribList
	 */
	public $payContribList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayTaxList
	 */
	public $payTaxList;
	/**
	 * Var \NetSuite\Classes\PaycheckPaySummaryList
	 */
	public $paySummaryList;
	/**
	 * Var \NetSuite\Classes\PaycheckPayDisburseList
	 */
	public $payDisburseList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'batchNumber' => 'string',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'status' => 'string',
		'entity' => 'RecordRef',
		'address' => 'string',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'class' => 'RecordRef',
		'workplace' => 'RecordRef',
		'tranId' => 'string',
		'userAmount' => 'float',
		'memo' => 'string',
		'account' => 'RecordRef',
		'payFrequency' => 'string',
		'balance' => 'float',
		'tranDate' => 'dateTime',
		'postingPeriod' => 'RecordRef',
		'periodEnding' => 'dateTime',
		'payEarnList' => 'PaycheckPayEarnList',
		'payTimeList' => 'PaycheckPayTimeList',
		'payExpList' => 'PaycheckPayExpList',
		'payPtoList' => 'PaycheckPayPtoList',
		'payDeductList' => 'PaycheckPayDeductList',
		'payContribList' => 'PaycheckPayContribList',
		'payTaxList' => 'PaycheckPayTaxList',
		'paySummaryList' => 'PaycheckPaySummaryList',
		'payDisburseList' => 'PaycheckPayDisburseList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
