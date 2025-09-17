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

class PromotionCodeSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $applyDiscountTo;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $code;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $discount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $freeShipItem;
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
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPublic;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'applyDiscountTo' => 'SearchEnumMultiSelectField',
		'code' => 'SearchStringField',
		'description' => 'SearchStringField',
		'discount' => 'SearchMultiSelectField',
		'endDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'freeShipItem' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'isPublic' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'location' => 'SearchMultiSelectField',
		'name' => 'SearchStringField',
		'partner' => 'SearchMultiSelectField',
		'startDate' => 'SearchDateField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
