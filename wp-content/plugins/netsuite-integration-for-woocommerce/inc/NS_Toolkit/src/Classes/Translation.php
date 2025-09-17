<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class Translation {
	/**
	 * Var \NetSuite\Classes\Language
	 */
	public $locale;
	/**
	 * Var string
	 */
	public $language;
	/**
	 * Var string
	 */
	public $displayName;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var string
	 */
	public $salesDescription;
	/**
	 * Var string
	 */
	public $storeDisplayName;
	/**
	 * Var string
	 */
	public $storeDescription;
	/**
	 * Var string
	 */
	public $storeDetailedDescription;
	/**
	 * Var string
	 */
	public $featuredDescription;
	/**
	 * Var string
	 */
	public $specialsDescription;
	/**
	 * Var string
	 */
	public $pageTitle;
	/**
	 * Var string
	 */
	public $noPriceMessage;
	/**
	 * Var string
	 */
	public $outOfStockMessage;
	public static $paramtypesmap = array(
		'locale' => 'Language',
		'language' => 'string',
		'displayName' => 'string',
		'description' => 'string',
		'salesDescription' => 'string',
		'storeDisplayName' => 'string',
		'storeDescription' => 'string',
		'storeDetailedDescription' => 'string',
		'featuredDescription' => 'string',
		'specialsDescription' => 'string',
		'pageTitle' => 'string',
		'noPriceMessage' => 'string',
		'outOfStockMessage' => 'string',
	);
}
