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

class EmployeeSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $campaignResponseJoin;
	/**
	 * Var \NetSuite\Classes\ChargeSearchRowBasic
	 */
	public $chargeJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchRowBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\HcmJobSearchRowBasic
	 */
	public $hcmJobJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $managedJobJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesFromJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesToJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchRowBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchRowBasic
	 */
	public $subsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $transactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'EmployeeSearchRowBasic',
		'campaignResponseJoin' => 'CampaignSearchRowBasic',
		'chargeJoin' => 'ChargeSearchRowBasic',
		'departmentJoin' => 'DepartmentSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'hcmJobJoin' => 'HcmJobSearchRowBasic',
		'locationJoin' => 'LocationSearchRowBasic',
		'managedJobJoin' => 'JobSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'messagesFromJoin' => 'MessageSearchRowBasic',
		'messagesToJoin' => 'MessageSearchRowBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchRowBasic',
		'subsidiaryJoin' => 'SubsidiarySearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
