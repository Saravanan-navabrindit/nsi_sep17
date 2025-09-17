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

class SiteCategorySearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateViewed;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $excludeFromSitemap;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fullName;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $hidden;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $hits;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $longDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pageTitle;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $sitemapPriority;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $urlComponent;
	public static $paramtypesmap = array(
		'dateViewed' => 'SearchColumnDateField[]',
		'description' => 'SearchColumnStringField[]',
		'excludeFromSitemap' => 'SearchColumnBooleanField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'fullName' => 'SearchColumnStringField[]',
		'hidden' => 'SearchColumnBooleanField[]',
		'hits' => 'SearchColumnLongField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'longDescription' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'pageTitle' => 'SearchColumnStringField[]',
		'sitemapPriority' => 'SearchColumnEnumSelectField[]',
		'urlComponent' => 'SearchColumnStringField[]',
	);
}
