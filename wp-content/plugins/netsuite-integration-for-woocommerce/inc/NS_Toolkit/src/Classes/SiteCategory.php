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

class SiteCategory extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $website;
	/**
	 * Var string
	 */
	public $itemId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parentCategory;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $categoryListLayout;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemListLayout;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $relatedItemsListLayout;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $correlatedItemsListLayout;
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
	public $description;
	/**
	 * Var string
	 */
	public $storeDetailedDescription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeDisplayThumbnail;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeDisplayImage;
	/**
	 * Var string
	 */
	public $pageTitle;
	/**
	 * Var string
	 */
	public $metaTagHtml;
	/**
	 * Var boolean
	 */
	public $excludeFromSitemap;
	/**
	 * Var string
	 */
	public $urlComponent;
	/**
	 * Var \NetSuite\Classes\SitemapPriority
	 */
	public $sitemapPriority;
	/**
	 * Var string
	 */
	public $searchKeywords;
	/**
	 * Var \NetSuite\Classes\SiteCategoryPresentationItemList
	 */
	public $presentationItemList;
	/**
	 * Var \NetSuite\Classes\SiteCategoryTranslationList
	 */
	public $translationsList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'website' => 'RecordRef',
		'itemId' => 'string',
		'parentCategory' => 'RecordRef',
		'categoryListLayout' => 'RecordRef',
		'itemListLayout' => 'RecordRef',
		'relatedItemsListLayout' => 'RecordRef',
		'correlatedItemsListLayout' => 'RecordRef',
		'isOnline' => 'boolean',
		'isInactive' => 'boolean',
		'description' => 'string',
		'storeDetailedDescription' => 'string',
		'storeDisplayThumbnail' => 'RecordRef',
		'storeDisplayImage' => 'RecordRef',
		'pageTitle' => 'string',
		'metaTagHtml' => 'string',
		'excludeFromSitemap' => 'boolean',
		'urlComponent' => 'string',
		'sitemapPriority' => 'SitemapPriority',
		'searchKeywords' => 'string',
		'presentationItemList' => 'SiteCategoryPresentationItemList',
		'translationsList' => 'SiteCategoryTranslationList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
