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

class ItemRevision extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $effectiveDate;
	/**
	 * Var string
	 */
	public $obsoleteDate;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $inactive;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'item' => 'RecordRef',
		'name' => 'string',
		'effectiveDate' => 'dateTime',
		'obsoleteDate' => 'dateTime',
		'memo' => 'string',
		'inactive' => 'boolean',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
