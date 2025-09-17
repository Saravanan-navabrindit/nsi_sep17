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

class InventoryNumberSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expirationDate;
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
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $inventoryNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isOnHand;
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
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityAvailable;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityInTransit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityOnHand;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityOnOrder;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'expirationDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'inventoryNumber' => 'SearchStringField',
		'isOnHand' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'location' => 'SearchMultiSelectField',
		'memo' => 'SearchStringField',
		'quantityAvailable' => 'SearchDoubleField',
		'quantityInTransit' => 'SearchDoubleField',
		'quantityOnHand' => 'SearchDoubleField',
		'quantityOnOrder' => 'SearchDoubleField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
