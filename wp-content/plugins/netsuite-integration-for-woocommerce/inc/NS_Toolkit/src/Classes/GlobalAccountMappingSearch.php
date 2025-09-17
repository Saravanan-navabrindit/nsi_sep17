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

class GlobalAccountMappingSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\GlobalAccountMappingSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\ClassificationSearchBasic
	 */
	public $classJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $destinationAccountJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $sourceAccountJoin;
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchBasic
	 */
	public $subsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'GlobalAccountMappingSearchBasic',
		'classJoin' => 'ClassificationSearchBasic',
		'departmentJoin' => 'DepartmentSearchBasic',
		'destinationAccountJoin' => 'AccountSearchBasic',
		'locationJoin' => 'LocationSearchBasic',
		'sourceAccountJoin' => 'AccountSearchBasic',
		'subsidiaryJoin' => 'SubsidiarySearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
