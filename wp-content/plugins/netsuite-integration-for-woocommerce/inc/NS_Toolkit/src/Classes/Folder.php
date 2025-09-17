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

class Folder extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $isPrivate;
	/**
	 * Var boolean
	 */
	public $bundleable;
	/**
	 * Var boolean
	 */
	public $hideInBundle;
	/**
	 * Var boolean
	 */
	public $isOnline;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $group;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\FolderFolderType
	 */
	public $folderType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'name' => 'string',
		'department' => 'RecordRef',
		'description' => 'string',
		'isInactive' => 'boolean',
		'isPrivate' => 'boolean',
		'bundleable' => 'boolean',
		'hideInBundle' => 'boolean',
		'isOnline' => 'boolean',
		'group' => 'RecordRef',
		'parent' => 'RecordRef',
		'folderType' => 'FolderFolderType',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
