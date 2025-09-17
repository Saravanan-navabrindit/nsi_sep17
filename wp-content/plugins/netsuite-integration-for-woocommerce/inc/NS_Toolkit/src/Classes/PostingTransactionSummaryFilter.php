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

class PostingTransactionSummaryFilter {
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $period;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $parentItem;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $book;
	public static $paramtypesmap = array(
		'period' => 'RecordRefList',
		'account' => 'RecordRefList',
		'parentItem' => 'RecordRefList',
		'item' => 'RecordRefList',
		'entity' => 'RecordRefList',
		'department' => 'RecordRefList',
		'class' => 'RecordRefList',
		'location' => 'RecordRefList',
		'subsidiary' => 'RecordRefList',
		'book' => 'RecordRefList',
	);
}
