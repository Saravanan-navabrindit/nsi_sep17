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

class VendorSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $accountJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $campaignResponseJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $expAccountJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $manufacturingLocationsJoin;
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
	 * Var \NetSuite\Classes\MseSubsidiarySearchBasic
	 */
	public $mseSubsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\EntityTaxRegistrationSearchBasic
	 */
	public $taxRegistrationJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $timeApproverJoin;
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
		'basic' => 'VendorSearchBasic',
		'accountJoin' => 'AccountSearchBasic',
		'campaignResponseJoin' => 'CampaignSearchBasic',
		'contactJoin' => 'ContactSearchBasic',
		'contactPrimaryJoin' => 'ContactSearchBasic',
		'expAccountJoin' => 'AccountSearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'manufacturingLocationsJoin' => 'LocationSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'messagesFromJoin' => 'MessageSearchBasic',
		'messagesToJoin' => 'MessageSearchBasic',
		'mseSubsidiaryJoin' => 'MseSubsidiarySearchBasic',
		'taxRegistrationJoin' => 'EntityTaxRegistrationSearchBasic',
		'timeApproverJoin' => 'EmployeeSearchBasic',
		'transactionJoin' => 'TransactionSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
