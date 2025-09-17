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

class ItemSupplyPlan extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $units;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\ItemSupplyPlanOrderList
	 */
	public $orderList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'customForm' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'location' => 'RecordRef',
		'item' => 'RecordRef',
		'units' => 'RecordRef',
		'memo' => 'string',
		'orderList' => 'ItemSupplyPlanOrderList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
