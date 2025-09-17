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

class ItemMember {
	/**
	 * Var string
	 */
	public $memberDescr;
	/**
	 * Var float
	 */
	public $componentYield;
	/**
	 * Var float
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\ItemSource
	 */
	public $itemSource;
	/**
	 * Var float
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $memberUnit;
	/**
	 * Var \NetSuite\Classes\VsoeDeferral
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\VsoePermitDiscount
	 */
	public $vsoePermitDiscount;
	/**
	 * Var boolean
	 */
	public $vsoeDelivered;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxSchedule;
	/**
	 * Var string
	 */
	public $taxcode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var float
	 */
	public $taxrate;
	/**
	 * Var string
	 */
	public $effectiveDate;
	/**
	 * Var string
	 */
	public $obsoleteDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $effectiveRevision;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $obsoleteRevision;
	/**
	 * Var integer
	 */
	public $lineNumber;
	/**
	 * Var string
	 */
	public $memberKey;
	public static $paramtypesmap = array(
		'memberDescr' => 'string',
		'componentYield' => 'float',
		'bomQuantity' => 'float',
		'itemSource' => 'ItemSource',
		'quantity' => 'float',
		'memberUnit' => 'RecordRef',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'taxSchedule' => 'RecordRef',
		'taxcode' => 'string',
		'item' => 'RecordRef',
		'taxrate' => 'float',
		'effectiveDate' => 'dateTime',
		'obsoleteDate' => 'dateTime',
		'effectiveRevision' => 'RecordRef',
		'obsoleteRevision' => 'RecordRef',
		'lineNumber' => 'integer',
		'memberKey' => 'string',
	);
}
