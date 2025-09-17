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

class PostingTransactionSummaryField {
	/**
	 * Var boolean
	 */
	public $period;
	/**
	 * Var boolean
	 */
	public $account;
	/**
	 * Var boolean
	 */
	public $parentItem;
	/**
	 * Var boolean
	 */
	public $item;
	/**
	 * Var boolean
	 */
	public $entity;
	/**
	 * Var boolean
	 */
	public $department;
	/**
	 * Var boolean
	 */
	public $class;
	/**
	 * Var boolean
	 */
	public $location;
	/**
	 * Var boolean
	 */
	public $subsidiary;
	/**
	 * Var boolean
	 */
	public $book;
	public static $paramtypesmap = array(
		'period' => 'boolean',
		'account' => 'boolean',
		'parentItem' => 'boolean',
		'item' => 'boolean',
		'entity' => 'boolean',
		'department' => 'boolean',
		'class' => 'boolean',
		'location' => 'boolean',
		'subsidiary' => 'boolean',
		'book' => 'boolean',
	);
}
