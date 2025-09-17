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

class Location extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var boolean
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $tranPrefix;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $mainAddress;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $returnAddress;
	/**
	 * Var \NetSuite\Classes\LocationType
	 */
	public $locationType;
	/**
	 * Var \NetSuite\Classes\LocationTimeZone
	 */
	public $timeZone;
	/**
	 * Var float
	 */
	public $latitude;
	/**
	 * Var float
	 */
	public $longitude;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $logo;
	/**
	 * Var boolean
	 */
	public $useBins;
	/**
	 * Var boolean
	 */
	public $makeInventoryAvailable;
	/**
	 * Var boolean
	 */
	public $makeInventoryAvailableStore;
	/**
	 * Var \NetSuite\Classes\LocationGeolocationMethod
	 */
	public $geolocationMethod;
	/**
	 * Var \NetSuite\Classes\LocationAutoAssignmentRegionSetting
	 */
	public $autoAssignmentRegionSetting;
	/**
	 * Var string
	 */
	public $nextPickupCutOffTime;
	/**
	 * Var integer
	 */
	public $bufferStock;
	/**
	 * Var boolean
	 */
	public $allowStorePickup;
	/**
	 * Var float
	 */
	public $storePickupBufferStock;
	/**
	 * Var integer
	 */
	public $dailyShippingCapacity;
	/**
	 * Var integer
	 */
	public $totalShippingCapacity;
	/**
	 * Var \NetSuite\Classes\LocationRegionsList
	 */
	public $includeLocationRegionsList;
	/**
	 * Var \NetSuite\Classes\LocationRegionsList
	 */
	public $excludeLocationRegionsList;
	/**
	 * Var \NetSuite\Classes\LocationBusinessHoursList
	 */
	public $businessHoursList;
	/**
	 * Var \NetSuite\Classes\ClassTranslationList
	 */
	public $classTranslationList;
	/**
	 * Var boolean
	 */
	public $includeInControlTower;
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
		'name' => 'string',
		'parent' => 'RecordRef',
		'includeChildren' => 'boolean',
		'subsidiaryList' => 'RecordRefList',
		'isInactive' => 'boolean',
		'tranPrefix' => 'string',
		'mainAddress' => 'Address',
		'returnAddress' => 'Address',
		'locationType' => 'LocationType',
		'timeZone' => 'LocationTimeZone',
		'latitude' => 'float',
		'longitude' => 'float',
		'logo' => 'RecordRef',
		'useBins' => 'boolean',
		'makeInventoryAvailable' => 'boolean',
		'makeInventoryAvailableStore' => 'boolean',
		'geolocationMethod' => 'LocationGeolocationMethod',
		'autoAssignmentRegionSetting' => 'LocationAutoAssignmentRegionSetting',
		'nextPickupCutOffTime' => 'dateTime',
		'bufferStock' => 'integer',
		'allowStorePickup' => 'boolean',
		'storePickupBufferStock' => 'float',
		'dailyShippingCapacity' => 'integer',
		'totalShippingCapacity' => 'integer',
		'includeLocationRegionsList' => 'LocationRegionsList',
		'excludeLocationRegionsList' => 'LocationRegionsList',
		'businessHoursList' => 'LocationBusinessHoursList',
		'classTranslationList' => 'ClassTranslationList',
		'includeInControlTower' => 'boolean',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
