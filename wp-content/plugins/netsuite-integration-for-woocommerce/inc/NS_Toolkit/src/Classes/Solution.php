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

class Solution extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $solutionCode;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SolutionStatus
	 */
	public $status;
	/**
	 * Var boolean
	 */
	public $displayOnline;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assigned;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $longDescription;
	/**
	 * Var \NetSuite\Classes\SolutionTopicsList
	 */
	public $topicsList;
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SolutionsList
	 */
	public $solutionsList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'customForm' => 'RecordRef',
		'solutionCode' => 'string',
		'title' => 'string',
		'message' => 'string',
		'status' => 'SolutionStatus',
		'displayOnline' => 'boolean',
		'assigned' => 'RecordRef',
		'isInactive' => 'boolean',
		'longDescription' => 'string',
		'topicsList' => 'SolutionTopicsList',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'solutionsList' => 'SolutionsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
