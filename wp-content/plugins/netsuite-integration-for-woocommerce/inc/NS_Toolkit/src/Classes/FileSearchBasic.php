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

class FileSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $availableWithoutLogin;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $created;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateViewed;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $documentSize;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $fileType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $folder;
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
	public $isAvailable;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isLink;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $modified;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $url;
	public static $paramtypesmap = array(
		'availableWithoutLogin' => 'SearchBooleanField',
		'created' => 'SearchDateField',
		'dateViewed' => 'SearchDateField',
		'description' => 'SearchStringField',
		'documentSize' => 'SearchLongField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'fileType' => 'SearchEnumMultiSelectField',
		'folder' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isAvailable' => 'SearchBooleanField',
		'isLink' => 'SearchBooleanField',
		'modified' => 'SearchDateField',
		'name' => 'SearchStringField',
		'owner' => 'SearchMultiSelectField',
		'url' => 'SearchStringField',
	);
}
