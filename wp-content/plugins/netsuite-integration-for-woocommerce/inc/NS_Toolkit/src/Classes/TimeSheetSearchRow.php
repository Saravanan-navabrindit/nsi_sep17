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

class TimeSheetSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\TimeSheetSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeBillJoin;
	/**
	 * Var \NetSuite\Classes\TimeEntrySearchRowBasic
	 */
	public $timeEntryJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'TimeSheetSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'timeBillJoin' => 'TimeBillSearchRowBasic',
		'timeEntryJoin' => 'TimeEntrySearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
