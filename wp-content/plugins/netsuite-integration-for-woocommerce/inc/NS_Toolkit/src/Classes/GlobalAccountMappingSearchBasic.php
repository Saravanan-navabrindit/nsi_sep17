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

class GlobalAccountMappingSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectCustomField
	 */
	public $customDimension;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $destinationAccount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $effectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
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
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $sourceAccount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accountingBook' => 'SearchMultiSelectField',
		'class' => 'SearchMultiSelectField',
		'customDimension' => 'SearchMultiSelectCustomField',
		'department' => 'SearchMultiSelectField',
		'destinationAccount' => 'SearchMultiSelectField',
		'effectiveDate' => 'SearchDateField',
		'endDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'location' => 'SearchMultiSelectField',
		'sourceAccount' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
