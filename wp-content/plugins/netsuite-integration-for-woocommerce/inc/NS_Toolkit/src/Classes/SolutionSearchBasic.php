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

class SolutionSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $abstract;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $caseCount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $code;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $description;
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
	public $find;
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
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isOnline;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $topic;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'abstract' => 'SearchStringField',
		'assigned' => 'SearchMultiSelectField',
		'caseCount' => 'SearchLongField',
		'code' => 'SearchStringField',
		'createdDate' => 'SearchDateField',
		'description' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'find' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'isOnline' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'number' => 'SearchLongField',
		'status' => 'SearchEnumMultiSelectField',
		'title' => 'SearchStringField',
		'topic' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
