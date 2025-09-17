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

class BomRevision extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billOfMaterials;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $effectiveStartDate;
	/**
	 * Var string
	 */
	public $effectiveEndDate;
	/**
	 * Var \NetSuite\Classes\BomRevisionComponentList
	 */
	public $componentList;
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
		'name' => 'string',
		'createdDate' => 'dateTime',
		'billOfMaterials' => 'RecordRef',
		'memo' => 'string',
		'isInactive' => 'boolean',
		'effectiveStartDate' => 'dateTime',
		'effectiveEndDate' => 'dateTime',
		'componentList' => 'BomRevisionComponentList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
