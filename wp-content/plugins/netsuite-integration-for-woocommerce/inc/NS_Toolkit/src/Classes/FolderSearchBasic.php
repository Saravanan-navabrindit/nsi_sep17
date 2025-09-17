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

class FolderSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $group;
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
	public $isTopLevel;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $numFiles;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $predecessor;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $private;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $size;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	public static $paramtypesmap = array(
		'class' => 'SearchMultiSelectField',
		'department' => 'SearchMultiSelectField',
		'description' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'group' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'isTopLevel' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'location' => 'SearchMultiSelectField',
		'name' => 'SearchStringField',
		'numFiles' => 'SearchLongField',
		'owner' => 'SearchMultiSelectField',
		'parent' => 'SearchMultiSelectField',
		'predecessor' => 'SearchMultiSelectField',
		'private' => 'SearchBooleanField',
		'size' => 'SearchLongField',
		'subsidiary' => 'SearchMultiSelectField',
	);
}
