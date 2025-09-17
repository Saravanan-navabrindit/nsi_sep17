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

class TimeSheetSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $id;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $totalHours;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'approvalStatus' => 'SearchColumnSelectField[]',
		'employee' => 'SearchColumnSelectField[]',
		'endDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'id' => 'SearchColumnLongField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'startDate' => 'SearchColumnDateField[]',
		'totalHours' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
