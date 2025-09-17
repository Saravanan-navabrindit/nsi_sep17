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

class CustomerSalesTeam {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesRole;
	/**
	 * Var boolean
	 */
	public $isPrimary;
	/**
	 * Var float
	 */
	public $contribution;
	public static $paramtypesmap = array(
		'employee' => 'RecordRef',
		'salesRole' => 'RecordRef',
		'isPrimary' => 'boolean',
		'contribution' => 'float',
	);
}
