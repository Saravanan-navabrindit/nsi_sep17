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

class CustomRecordSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $recType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $altName;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableOffline;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $created;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModified;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $lastModifiedBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'recType' => 'RecordRef',
		'altName' => 'SearchColumnStringField[]',
		'availableOffline' => 'SearchColumnBooleanField[]',
		'created' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'id' => 'SearchColumnLongField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'lastModified' => 'SearchColumnDateField[]',
		'lastModifiedBy' => 'SearchColumnSelectField[]',
		'name' => 'SearchColumnStringField[]',
		'owner' => 'SearchColumnSelectField[]',
		'parent' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
