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

class CustomRecordSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\CustomRecordSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $ownerJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'CustomRecordSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'ownerJoin' => 'EmployeeSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
