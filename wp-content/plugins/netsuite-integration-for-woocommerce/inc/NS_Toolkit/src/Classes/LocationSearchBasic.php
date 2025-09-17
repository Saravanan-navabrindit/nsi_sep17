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

class LocationSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $address;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $allowStorePickup;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $autoAssignmentRegionSetting;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $bufferStock;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $city;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $country;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $county;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $dailyShippingCapacity;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endTime;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $geolocationMethod;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isFriday;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isIncludeInCt;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isMonday;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isOffice;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSaturday;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSunday;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isThursday;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isTuesday;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isWednesday;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $latitude;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $longitude;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $makeInventoryAvailable;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $makeInventoryAvailableStore;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $nameNoHierarchy;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $nextPickupCutOffTime;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $phone;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $sameDayPickupCutOffTime;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startTime;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $state;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $storePickupBufferStock;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $timeZone;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $totalShippingCapacity;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $tranprefix;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $usesBins;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $zip;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'address' => 'SearchStringField',
		'allowStorePickup' => 'SearchBooleanField',
		'autoAssignmentRegionSetting' => 'SearchEnumMultiSelectField',
		'bufferStock' => 'SearchLongField',
		'city' => 'SearchStringField',
		'country' => 'SearchEnumMultiSelectField',
		'county' => 'SearchStringField',
		'dailyShippingCapacity' => 'SearchLongField',
		'endTime' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'geolocationMethod' => 'SearchEnumMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isFriday' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isIncludeInCt' => 'SearchBooleanField',
		'isMonday' => 'SearchBooleanField',
		'isOffice' => 'SearchBooleanField',
		'isSaturday' => 'SearchBooleanField',
		'isSunday' => 'SearchBooleanField',
		'isThursday' => 'SearchBooleanField',
		'isTuesday' => 'SearchBooleanField',
		'isWednesday' => 'SearchBooleanField',
		'latitude' => 'SearchDoubleField',
		'locationType' => 'SearchEnumMultiSelectField',
		'longitude' => 'SearchDoubleField',
		'makeInventoryAvailable' => 'SearchBooleanField',
		'makeInventoryAvailableStore' => 'SearchBooleanField',
		'name' => 'SearchStringField',
		'nameNoHierarchy' => 'SearchStringField',
		'nextPickupCutOffTime' => 'SearchDateField',
		'phone' => 'SearchStringField',
		'sameDayPickupCutOffTime' => 'SearchDateField',
		'startTime' => 'SearchDateField',
		'state' => 'SearchStringField',
		'storePickupBufferStock' => 'SearchDoubleField',
		'subsidiary' => 'SearchMultiSelectField',
		'timeZone' => 'SearchEnumMultiSelectField',
		'totalShippingCapacity' => 'SearchLongField',
		'tranprefix' => 'SearchStringField',
		'usesBins' => 'SearchBooleanField',
		'zip' => 'SearchStringField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
