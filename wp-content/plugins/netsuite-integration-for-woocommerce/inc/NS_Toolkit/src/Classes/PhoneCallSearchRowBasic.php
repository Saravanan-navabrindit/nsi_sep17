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

class PhoneCallSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $completedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $markdone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $transaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accessLevel' => 'SearchColumnStringField[]',
		'assigned' => 'SearchColumnSelectField[]',
		'company' => 'SearchColumnSelectField[]',
		'completedDate' => 'SearchColumnDateField[]',
		'contact' => 'SearchColumnSelectField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'endDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'markdone' => 'SearchColumnStringField[]',
		'message' => 'SearchColumnStringField[]',
		'owner' => 'SearchColumnSelectField[]',
		'phone' => 'SearchColumnStringField[]',
		'priority' => 'SearchColumnEnumSelectField[]',
		'startDate' => 'SearchColumnDateField[]',
		'startTime' => 'SearchColumnDateField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'transaction' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
