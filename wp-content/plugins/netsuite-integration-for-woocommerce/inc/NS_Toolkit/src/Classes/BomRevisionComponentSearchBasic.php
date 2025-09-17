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

class BomRevisionComponentSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $bomRevision;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $componentYield;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $itemSource;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $itemSubtype;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemType;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $lineId;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $weight;
	public static $paramtypesmap = array(
		'bomQuantity' => 'SearchDoubleField',
		'bomRevision' => 'SearchMultiSelectField',
		'componentYield' => 'SearchDoubleField',
		'description' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'item' => 'SearchMultiSelectField',
		'itemSource' => 'SearchEnumMultiSelectField',
		'itemSubtype' => 'SearchStringField',
		'itemType' => 'SearchMultiSelectField',
		'lineId' => 'SearchLongField',
		'quantity' => 'SearchDoubleField',
		'units' => 'SearchStringField',
		'weight' => 'SearchDoubleField',
	);
}
