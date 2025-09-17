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

class TimeSheetTimeGrid {
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $sunday;
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $monday;
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $tuesday;
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $wednesday;
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $thursday;
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $friday;
	/**
	 * Var \NetSuite\Classes\TimeEntry
	 */
	public $saturday;
	public static $paramtypesmap = array(
		'sunday' => 'TimeEntry',
		'monday' => 'TimeEntry',
		'tuesday' => 'TimeEntry',
		'wednesday' => 'TimeEntry',
		'thursday' => 'TimeEntry',
		'friday' => 'TimeEntry',
		'saturday' => 'TimeEntry',
	);
}
