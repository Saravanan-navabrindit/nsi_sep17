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

class VendorSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\AccountSearchRowBasic
	 */
	public $accountJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $campaignResponseJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchRowBasic
	 */
	public $expAccountJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $manufacturingLocationsJoin;
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
	 * Var \NetSuite\Classes\MseSubsidiarySearchRowBasic
	 */
	public $mseSubsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\EntityTaxRegistrationSearchRowBasic
	 */
	public $taxRegistrationJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $timeApproverJoin;
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
		'basic' => 'VendorSearchRowBasic',
		'accountJoin' => 'AccountSearchRowBasic',
		'campaignResponseJoin' => 'CampaignSearchRowBasic',
		'contactJoin' => 'ContactSearchRowBasic',
		'contactPrimaryJoin' => 'ContactSearchRowBasic',
		'expAccountJoin' => 'AccountSearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'manufacturingLocationsJoin' => 'LocationSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'messagesFromJoin' => 'MessageSearchRowBasic',
		'messagesToJoin' => 'MessageSearchRowBasic',
		'mseSubsidiaryJoin' => 'MseSubsidiarySearchRowBasic',
		'taxRegistrationJoin' => 'EntityTaxRegistrationSearchRowBasic',
		'timeApproverJoin' => 'EmployeeSearchRowBasic',
		'transactionJoin' => 'TransactionSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
