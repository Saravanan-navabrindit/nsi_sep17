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

class EmployeeSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $campaignResponseJoin;
	/**
	 * Var \NetSuite\Classes\ChargeSearchBasic
	 */
	public $chargeJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\HcmJobSearchBasic
	 */
	public $hcmJobJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $managedJobJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesFromJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesToJoin;
	/**
	 * Var \NetSuite\Classes\ResourceAllocationSearchBasic
	 */
	public $resourceAllocationJoin;
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchBasic
	 */
	public $subsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $transactionJoin;
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
		'basic' => 'EmployeeSearchBasic',
		'campaignResponseJoin' => 'CampaignSearchBasic',
		'chargeJoin' => 'ChargeSearchBasic',
		'departmentJoin' => 'DepartmentSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'hcmJobJoin' => 'HcmJobSearchBasic',
		'locationJoin' => 'LocationSearchBasic',
		'managedJobJoin' => 'JobSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'messagesFromJoin' => 'MessageSearchBasic',
		'messagesToJoin' => 'MessageSearchBasic',
		'resourceAllocationJoin' => 'ResourceAllocationSearchBasic',
		'subsidiaryJoin' => 'SubsidiarySearchBasic',
		'timeJoin' => 'TimeBillSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
