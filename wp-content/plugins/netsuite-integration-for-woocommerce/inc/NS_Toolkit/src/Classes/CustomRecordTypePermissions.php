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

class CustomRecordTypePermissions {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $permittedRole;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypePermissionsPermittedLevel
	 */
	public $permittedLevel;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypePermissionsRestriction
	 */
	public $restriction;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultForm;
	/**
	 * Var boolean
	 */
	public $restrictForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $searchForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $searchResults;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $listView;
	/**
	 * Var boolean
	 */
	public $listViewRestricted;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $dashboardView;
	/**
	 * Var boolean
	 */
	public $restrictDashboardView;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $sublistView;
	/**
	 * Var boolean
	 */
	public $restrictSublistView;
	public static $paramtypesmap = array(
		'permittedRole' => 'RecordRef',
		'permittedLevel' => 'CustomRecordTypePermissionsPermittedLevel',
		'restriction' => 'CustomRecordTypePermissionsRestriction',
		'defaultForm' => 'RecordRef',
		'restrictForm' => 'boolean',
		'searchForm' => 'RecordRef',
		'searchResults' => 'RecordRef',
		'listView' => 'RecordRef',
		'listViewRestricted' => 'boolean',
		'dashboardView' => 'RecordRef',
		'restrictDashboardView' => 'boolean',
		'sublistView' => 'RecordRef',
		'restrictSublistView' => 'boolean',
	);
}
