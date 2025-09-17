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

class BillingScheduleMilestone {
	/**
	 * Var integer
	 */
	public $milestoneId;
	/**
	 * Var float
	 */
	public $milestoneAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $milestoneTerms;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $projectTask;
	/**
	 * Var string
	 */
	public $milestoneDate;
	/**
	 * Var boolean
	 */
	public $milestoneCompleted;
	/**
	 * Var string
	 */
	public $milestoneActualCompletionDate;
	/**
	 * Var string
	 */
	public $comments;
	public static $paramtypesmap = array(
		'milestoneId' => 'integer',
		'milestoneAmount' => 'float',
		'milestoneTerms' => 'RecordRef',
		'projectTask' => 'RecordRef',
		'milestoneDate' => 'dateTime',
		'milestoneCompleted' => 'boolean',
		'milestoneActualCompletionDate' => 'dateTime',
		'comments' => 'string',
	);
}
