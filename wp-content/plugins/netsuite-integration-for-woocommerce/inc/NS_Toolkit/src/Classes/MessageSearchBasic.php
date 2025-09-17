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

class MessageSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $author;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $authorEmail;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $bcc;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $cc;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $hasAttachment;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $internalOnly;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $messageDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $messageType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $recipient;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $recipientEmail;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $subject;
	public static $paramtypesmap = array(
		'author' => 'SearchMultiSelectField',
		'authorEmail' => 'SearchStringField',
		'bcc' => 'SearchStringField',
		'cc' => 'SearchStringField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'hasAttachment' => 'SearchBooleanField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'internalOnly' => 'SearchBooleanField',
		'message' => 'SearchStringField',
		'messageDate' => 'SearchDateField',
		'messageType' => 'SearchEnumMultiSelectField',
		'recipient' => 'SearchMultiSelectField',
		'recipientEmail' => 'SearchStringField',
		'subject' => 'SearchStringField',
	);
}
