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

class ManufacturingOperationTaskSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\ManufacturingOperationTaskSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\ManufacturingOperationTaskSearchBasic
	 */
	public $predecessorJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $workOrderJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ManufacturingOperationTaskSearchBasic',
		'predecessorJoin' => 'ManufacturingOperationTaskSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'workOrderJoin' => 'TransactionSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
