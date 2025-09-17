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

class FolderSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $folderSize;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $group;
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
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $numFiles;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	public static $paramtypesmap = array(
		'class' => 'SearchColumnSelectField[]',
		'department' => 'SearchColumnSelectField[]',
		'description' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'folderSize' => 'SearchColumnLongField[]',
		'group' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'location' => 'SearchColumnSelectField[]',
		'name' => 'SearchColumnStringField[]',
		'numFiles' => 'SearchColumnLongField[]',
		'owner' => 'SearchColumnSelectField[]',
		'parent' => 'SearchColumnSelectField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
	);
}
