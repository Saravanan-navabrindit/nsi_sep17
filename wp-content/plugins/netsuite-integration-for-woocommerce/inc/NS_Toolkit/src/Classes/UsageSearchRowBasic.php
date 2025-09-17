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

class UsageSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $date;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscriptionPlan;
	public static $paramtypesmap = array(
		'customer' => 'SearchColumnSelectField[]',
		'date' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'item' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'quantity' => 'SearchColumnDoubleField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'subscriptionLine' => 'SearchColumnSelectField[]',
		'subscriptionPlan' => 'SearchColumnSelectField[]',
	);
}
