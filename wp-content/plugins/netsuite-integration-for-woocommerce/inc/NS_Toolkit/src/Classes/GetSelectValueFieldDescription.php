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

class GetSelectValueFieldDescription {
	/**
	 * Var \NetSuite\Classes\RecordType::*
	 */
	public $recordType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customRecordType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customTransactionType;
	/**
	 * Var string
	 */
	public $sublist;
	/**
	 * Var string
	 */
	public $field;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\GetSelectValueFilter
	 */
	public $filter;
	/**
	 * Var \NetSuite\Classes\GetSelectFilterByFieldValueList
	 */
	public $filterByValueList;
	public static $paramtypesmap = array(
		'recordType' => 'RecordType',
		'customRecordType' => 'RecordRef',
		'customTransactionType' => 'RecordRef',
		'sublist' => 'string',
		'field' => 'string',
		'customForm' => 'RecordRef',
		'filter' => 'GetSelectValueFilter',
		'filterByValueList' => 'GetSelectFilterByFieldValueList',
	);
}
