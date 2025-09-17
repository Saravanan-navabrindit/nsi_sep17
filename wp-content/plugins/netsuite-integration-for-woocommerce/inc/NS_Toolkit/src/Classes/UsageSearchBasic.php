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

class UsageSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $customer;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $date;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscriptionPlan;
	public static $paramtypesmap = array(
		'customer' => 'SearchMultiSelectField',
		'date' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'item' => 'SearchMultiSelectField',
		'memo' => 'SearchStringField',
		'quantity' => 'SearchDoubleField',
		'subscription' => 'SearchMultiSelectField',
		'subscriptionLine' => 'SearchMultiSelectField',
		'subscriptionPlan' => 'SearchMultiSelectField',
	);
}
