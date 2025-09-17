<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class SearchResult {
	/**
	 * Var \NetSuite\Classes\Status
	 */
	public $status;
	/**
	 * Var integer
	 */
	public $totalRecords;
	/**
	 * Var integer
	 */
	public $pageSize;
	/**
	 * Var integer
	 */
	public $totalPages;
	/**
	 * Var integer
	 */
	public $pageIndex;
	/**
	 * Var string
	 */
	public $searchId;
	/**
	 * Var \NetSuite\Classes\RecordList
	 */
	public $recordList;
	/**
	 * Var \NetSuite\Classes\SearchRowList
	 */
	public $searchRowList;
	public static $paramtypesmap = array(
		'status' => 'Status',
		'totalRecords' => 'integer',
		'pageSize' => 'integer',
		'totalPages' => 'integer',
		'pageIndex' => 'integer',
		'searchId' => 'string',
		'recordList' => 'RecordList',
		'searchRowList' => 'SearchRowList',
	);
}
