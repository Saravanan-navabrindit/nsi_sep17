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

class PaycheckSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $batchNumber;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $checkDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $hasGLImpact;
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
	public $payrollItem;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $payrollItemType;
	public static $paramtypesmap = array(
		'account' => 'SearchMultiSelectField',
		'batchNumber' => 'SearchLongField',
		'checkDate' => 'SearchDateField',
		'employee' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'hasGLImpact' => 'SearchBooleanField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'payrollItem' => 'SearchMultiSelectField',
		'payrollItemType' => 'SearchMultiSelectField',
	);
}
