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

class UsageSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\UsageSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\ChargeSearchBasic
	 */
	public $chargeJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $subscriptionPlanJoin;
	public static $paramtypesmap = array(
		'basic' => 'UsageSearchBasic',
		'chargeJoin' => 'ChargeSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'itemJoin' => 'ItemSearchBasic',
		'subscriptionPlanJoin' => 'ItemSearchBasic',
	);
}
