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

class File extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\FileAttachFrom
	 */
	public $attachFrom;
	/**
	 * Var string
	 */
	public $mediaTypeName;
	/**
	 * Var \NetSuite\Classes\MediaType
	 */
	public $fileType;
	/**
	 * Var \NetSuite\Classes\base64Binary
	 */
	public $content;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $folder;
	/**
	 * Var float
	 */
	public $fileSize;
	/**
	 * Var string
	 */
	public $url;
	/**
	 * Var string
	 */
	public $urlComponent;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $mediaFile;
	/**
	 * Var \NetSuite\Classes\TextFileEncoding
	 */
	public $textFileEncoding;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\FileEncoding
	 */
	public $encoding;
	/**
	 * Var string
	 */
	public $altTagCaption;
	/**
	 * Var boolean
	 */
	public $isOnline;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $class;
	/**
	 * Var boolean
	 */
	public $bundleable;
	/**
	 * Var string
	 */
	public $department;
	/**
	 * Var boolean
	 */
	public $hideInBundle;
	/**
	 * Var boolean
	 */
	public $isPrivate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var string
	 */
	public $caption;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeDisplayThumbnail;
	/**
	 * Var string
	 */
	public $siteDescription;
	/**
	 * Var string
	 */
	public $featuredDescription;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\FileSiteCategoryList
	 */
	public $siteCategoryList;
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
		'attachFrom' => 'FileAttachFrom',
		'mediaTypeName' => 'string',
		'fileType' => 'MediaType',
		'content' => 'base64Binary',
		'folder' => 'RecordRef',
		'fileSize' => 'float',
		'url' => 'string',
		'urlComponent' => 'string',
		'mediaFile' => 'RecordRef',
		'textFileEncoding' => 'TextFileEncoding',
		'description' => 'string',
		'encoding' => 'FileEncoding',
		'altTagCaption' => 'string',
		'isOnline' => 'boolean',
		'isInactive' => 'boolean',
		'class' => 'string',
		'bundleable' => 'boolean',
		'department' => 'string',
		'hideInBundle' => 'boolean',
		'isPrivate' => 'boolean',
		'owner' => 'RecordRef',
		'caption' => 'string',
		'storeDisplayThumbnail' => 'RecordRef',
		'siteDescription' => 'string',
		'featuredDescription' => 'string',
		'lastModifiedDate' => 'dateTime',
		'createdDate' => 'dateTime',
		'siteCategoryList' => 'FileSiteCategoryList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
