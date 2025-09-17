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

class EntityGroup extends Record {
	/**
	 * Var string
	 */
	public $groupName;
	/**
	 * Var \NetSuite\Classes\EntityGroupType
	 */
	public $groupType;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $groupOwner;
	/**
	 * Var boolean
	 */
	public $isSavedSearch;
	/**
	 * Var \NetSuite\Classes\EntityGroupType
	 */
	public $parentGroupType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $savedSearch;
	/**
	 * Var boolean
	 */
	public $isSalesTeam;
	/**
	 * Var string
	 */
	public $comments;
	/**
	 * Var boolean
	 */
	public $isPrivate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $restrictionGroup;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $isSalesRep;
	/**
	 * Var boolean
	 */
	public $isSupportRep;
	/**
	 * Var boolean
	 */
	public $isProductTeam;
	/**
	 * Var boolean
	 */
	public $isFunctionalTeam;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueRole;
	/**
	 * Var boolean
	 */
	public $isManufacturingWorkCenter;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var float
	 */
	public $machineResources;
	/**
	 * Var float
	 */
	public $laborResources;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $workCalendar;
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
		'groupName' => 'string',
		'groupType' => 'EntityGroupType',
		'email' => 'string',
		'groupOwner' => 'RecordRef',
		'isSavedSearch' => 'boolean',
		'parentGroupType' => 'EntityGroupType',
		'savedSearch' => 'RecordRef',
		'isSalesTeam' => 'boolean',
		'comments' => 'string',
		'isPrivate' => 'boolean',
		'restrictionGroup' => 'RecordRef',
		'isInactive' => 'boolean',
		'isSalesRep' => 'boolean',
		'isSupportRep' => 'boolean',
		'isProductTeam' => 'boolean',
		'isFunctionalTeam' => 'boolean',
		'issueRole' => 'RecordRef',
		'isManufacturingWorkCenter' => 'boolean',
		'subsidiary' => 'RecordRef',
		'machineResources' => 'float',
		'laborResources' => 'float',
		'workCalendar' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
