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

class TimeBillSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $break;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $date;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $durationDecimal;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $hours;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isBillable;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isExempt;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isProductive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isUtilized;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModified;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $paidExternally;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $payItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $payrollDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $rejectionNote;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $supervisorApproval;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $temporaryLocalJurisdiction;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $temporaryStateJurisdiction;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $timeModified;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $timeSheet;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'approvalStatus' => 'SearchColumnSelectField[]',
		'break' => 'SearchColumnStringField[]',
		'class' => 'SearchColumnSelectField[]',
		'customer' => 'SearchColumnSelectField[]',
		'date' => 'SearchColumnDateField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'department' => 'SearchColumnSelectField[]',
		'durationDecimal' => 'SearchColumnDoubleField[]',
		'employee' => 'SearchColumnSelectField[]',
		'endTime' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'hours' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isBillable' => 'SearchColumnBooleanField[]',
		'isExempt' => 'SearchColumnBooleanField[]',
		'isProductive' => 'SearchColumnBooleanField[]',
		'isUtilized' => 'SearchColumnBooleanField[]',
		'item' => 'SearchColumnStringField[]',
		'lastModified' => 'SearchColumnDateField[]',
		'location' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'paidExternally' => 'SearchColumnBooleanField[]',
		'payItem' => 'SearchColumnSelectField[]',
		'payrollDate' => 'SearchColumnDateField[]',
		'rate' => 'SearchColumnDoubleField[]',
		'rejectionNote' => 'SearchColumnStringField[]',
		'startTime' => 'SearchColumnDateField[]',
		'status' => 'SearchColumnStringField[]',
		'subsidiary' => 'SearchColumnStringField[]',
		'supervisorApproval' => 'SearchColumnBooleanField[]',
		'temporaryLocalJurisdiction' => 'SearchColumnStringField[]',
		'temporaryStateJurisdiction' => 'SearchColumnStringField[]',
		'timeModified' => 'SearchColumnBooleanField[]',
		'timeSheet' => 'SearchColumnSelectField[]',
		'type' => 'SearchColumnEnumSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
