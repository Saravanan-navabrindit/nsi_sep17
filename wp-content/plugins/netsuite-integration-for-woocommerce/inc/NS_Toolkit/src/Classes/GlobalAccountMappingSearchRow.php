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

class GlobalAccountMappingSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\GlobalAccountMappingSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\ClassificationSearchRowBasic
	 */
	public $classJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchRowBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchRowBasic
	 */
	public $destinationAccountJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchRowBasic
	 */
	public $sourceAccountJoin;
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchRowBasic
	 */
	public $subsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'GlobalAccountMappingSearchRowBasic',
		'classJoin' => 'ClassificationSearchRowBasic',
		'departmentJoin' => 'DepartmentSearchRowBasic',
		'destinationAccountJoin' => 'AccountSearchRowBasic',
		'locationJoin' => 'LocationSearchRowBasic',
		'sourceAccountJoin' => 'AccountSearchRowBasic',
		'subsidiaryJoin' => 'SubsidiarySearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
