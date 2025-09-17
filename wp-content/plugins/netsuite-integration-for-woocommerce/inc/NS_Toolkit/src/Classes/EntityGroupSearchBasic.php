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

class EntityGroupSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
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
	public $groupName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $groupOwner;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $groupType;
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
	public $isDynamic;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isManufacturingWorkCenter;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPrivate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $laborResources;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $machineResources;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $workCalendar;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'email' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'groupName' => 'SearchStringField',
		'groupOwner' => 'SearchMultiSelectField',
		'groupType' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isDynamic' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isManufacturingWorkCenter' => 'SearchBooleanField',
		'isPrivate' => 'SearchBooleanField',
		'laborResources' => 'SearchDoubleField',
		'lastModifiedDate' => 'SearchDateField',
		'machineResources' => 'SearchDoubleField',
		'subsidiary' => 'SearchMultiSelectField',
		'workCalendar' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
