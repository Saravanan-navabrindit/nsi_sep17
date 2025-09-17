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

class SolutionSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assigned;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $caseCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $displayOnline;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $previewref;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $solutionCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'assigned' => 'SearchColumnSelectField[]',
		'caseCount' => 'SearchColumnLongField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'description' => 'SearchColumnStringField[]',
		'displayOnline' => 'SearchColumnBooleanField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'message' => 'SearchColumnStringField[]',
		'previewref' => 'SearchColumnStringField[]',
		'solutionCode' => 'SearchColumnStringField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
