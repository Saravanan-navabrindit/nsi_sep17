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

class BomRevisionComponentSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $bomRevision;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $componentYield;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $itemSource;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $itemSubtype;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $itemType;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $lineId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $units;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $weight;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'bomQuantity' => 'SearchColumnDoubleField[]',
		'bomRevision' => 'SearchColumnSelectField[]',
		'componentYield' => 'SearchColumnDoubleField[]',
		'description' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'itemSource' => 'SearchColumnEnumSelectField[]',
		'itemSubtype' => 'SearchColumnStringField[]',
		'itemType' => 'SearchColumnSelectField[]',
		'lineId' => 'SearchColumnLongField[]',
		'quantity' => 'SearchColumnDoubleField[]',
		'units' => 'SearchColumnStringField[]',
		'weight' => 'SearchColumnDoubleField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
