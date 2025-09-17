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

class ManufacturingRouting extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billOfMaterials;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $locationList;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $isDefault;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $autoCalculateLag;
	/**
	 * Var \NetSuite\Classes\ManufacturingRoutingRoutingStepList
	 */
	public $routingStepList;
	/**
	 * Var \NetSuite\Classes\ManufacturingRoutingRoutingComponentList
	 */
	public $routingComponentList;
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
		'billOfMaterials' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'item' => 'RecordRef',
		'locationList' => 'RecordRefList',
		'name' => 'string',
		'memo' => 'string',
		'isDefault' => 'boolean',
		'isInactive' => 'boolean',
		'autoCalculateLag' => 'boolean',
		'routingStepList' => 'ManufacturingRoutingRoutingStepList',
		'routingComponentList' => 'ManufacturingRoutingRoutingComponentList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
