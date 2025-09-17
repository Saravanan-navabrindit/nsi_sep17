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

class LocationSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $address3;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $allowStorePickup;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $autoAssignmentRegionSetting;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $bufferStock;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $dailyShippingCapacity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $geolocationMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isFriday;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isIncludeInCt;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isMonday;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isOffice;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSaturday;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSunday;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isThursday;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isTuesday;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isWednesday;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $latitude;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $longitude;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $makeInventoryAvailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $makeInventoryAvailableStore;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $nameNoHierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $nextPickupCutOffTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $sameDayPickupCutOffTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $storePickupBufferStock;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $timeZone;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $totalShippingCapacity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $tranPrefix;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $usesBins;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'address1' => 'SearchColumnStringField[]',
		'address2' => 'SearchColumnStringField[]',
		'address3' => 'SearchColumnStringField[]',
		'allowStorePickup' => 'SearchColumnBooleanField[]',
		'autoAssignmentRegionSetting' => 'SearchColumnEnumSelectField[]',
		'bufferStock' => 'SearchColumnLongField[]',
		'city' => 'SearchColumnStringField[]',
		'country' => 'SearchColumnEnumSelectField[]',
		'dailyShippingCapacity' => 'SearchColumnLongField[]',
		'endTime' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'geolocationMethod' => 'SearchColumnEnumSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isFriday' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isIncludeInCt' => 'SearchColumnBooleanField[]',
		'isMonday' => 'SearchColumnBooleanField[]',
		'isOffice' => 'SearchColumnBooleanField[]',
		'isSaturday' => 'SearchColumnBooleanField[]',
		'isSunday' => 'SearchColumnBooleanField[]',
		'isThursday' => 'SearchColumnBooleanField[]',
		'isTuesday' => 'SearchColumnBooleanField[]',
		'isWednesday' => 'SearchColumnBooleanField[]',
		'latitude' => 'SearchColumnDoubleField[]',
		'locationType' => 'SearchColumnEnumSelectField[]',
		'longitude' => 'SearchColumnDoubleField[]',
		'makeInventoryAvailable' => 'SearchColumnBooleanField[]',
		'makeInventoryAvailableStore' => 'SearchColumnBooleanField[]',
		'name' => 'SearchColumnStringField[]',
		'nameNoHierarchy' => 'SearchColumnStringField[]',
		'nextPickupCutOffTime' => 'SearchColumnDateField[]',
		'phone' => 'SearchColumnStringField[]',
		'sameDayPickupCutOffTime' => 'SearchColumnDateField[]',
		'startTime' => 'SearchColumnDateField[]',
		'state' => 'SearchColumnStringField[]',
		'storePickupBufferStock' => 'SearchColumnDoubleField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'timeZone' => 'SearchColumnEnumSelectField[]',
		'totalShippingCapacity' => 'SearchColumnLongField[]',
		'tranPrefix' => 'SearchColumnStringField[]',
		'usesBins' => 'SearchColumnBooleanField[]',
		'zip' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
