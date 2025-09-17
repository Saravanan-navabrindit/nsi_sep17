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

class PhoneCallSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $company;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $completedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $contact;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $createdBy;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPrivate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $priority;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'assigned' => 'SearchMultiSelectField',
		'company' => 'SearchMultiSelectField',
		'completedDate' => 'SearchDateField',
		'contact' => 'SearchMultiSelectField',
		'createdBy' => 'SearchMultiSelectField',
		'createdDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isPrivate' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'owner' => 'SearchBooleanField',
		'phone' => 'SearchStringField',
		'priority' => 'SearchEnumMultiSelectField',
		'startDate' => 'SearchDateField',
		'status' => 'SearchEnumMultiSelectField',
		'title' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
