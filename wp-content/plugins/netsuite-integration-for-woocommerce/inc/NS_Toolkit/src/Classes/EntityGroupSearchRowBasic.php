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

class EntityGroupSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $groupName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $groupType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isDynamic;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isManufacturingWorkCenter;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isPrivate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $laborResources;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $machineResources;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $savedSearch;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $size;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $workCalendar;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'email' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'groupName' => 'SearchColumnStringField[]',
		'groupType' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isDynamic' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isManufacturingWorkCenter' => 'SearchColumnBooleanField[]',
		'isPrivate' => 'SearchColumnBooleanField[]',
		'laborResources' => 'SearchColumnDoubleField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'machineResources' => 'SearchColumnDoubleField[]',
		'owner' => 'SearchColumnSelectField[]',
		'savedSearch' => 'SearchColumnStringField[]',
		'size' => 'SearchColumnLongField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'workCalendar' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
