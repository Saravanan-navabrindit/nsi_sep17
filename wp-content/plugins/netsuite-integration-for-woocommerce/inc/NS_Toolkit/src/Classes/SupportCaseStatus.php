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

class SupportCaseStatus extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $insertBefore;
	/**
	 * Var \NetSuite\Classes\SupportCaseStatusStage
	 */
	public $stage;
	/**
	 * Var boolean
	 */
	public $caseOnHold;
	/**
	 * Var boolean
	 */
	public $autoCloseCase;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'name' => 'string',
		'insertBefore' => 'RecordRef',
		'stage' => 'SupportCaseStatusStage',
		'caseOnHold' => 'boolean',
		'autoCloseCase' => 'boolean',
		'description' => 'string',
		'isInactive' => 'boolean',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
