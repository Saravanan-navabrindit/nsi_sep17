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

class FileSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableWithoutLogin;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $created;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateViewed;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $documentSize;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $fileType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $folder;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $hits;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $hostedPath;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isAvailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $modified;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $url;
	public static $paramtypesmap = array(
		'availableWithoutLogin' => 'SearchColumnBooleanField[]',
		'created' => 'SearchColumnDateField[]',
		'dateViewed' => 'SearchColumnDateField[]',
		'description' => 'SearchColumnStringField[]',
		'documentSize' => 'SearchColumnLongField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fileType' => 'SearchColumnEnumSelectField[]',
		'folder' => 'SearchColumnSelectField[]',
		'hits' => 'SearchColumnLongField[]',
		'hostedPath' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isAvailable' => 'SearchColumnBooleanField[]',
		'modified' => 'SearchColumnDateField[]',
		'name' => 'SearchColumnStringField[]',
		'owner' => 'SearchColumnSelectField[]',
		'url' => 'SearchColumnStringField[]',
	);
}
