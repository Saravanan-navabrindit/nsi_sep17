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

class MessageSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $author;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $authorEmail;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $bcc;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $cc;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $hasAttachment;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $internalOnly;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isEmailed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isIncoming;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $messageDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $messageType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $recipient;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $recipientEmail;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $subject;
	public static $paramtypesmap = array(
		'author' => 'SearchColumnSelectField[]',
		'authorEmail' => 'SearchColumnStringField[]',
		'bcc' => 'SearchColumnStringField[]',
		'cc' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'hasAttachment' => 'SearchColumnBooleanField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'internalOnly' => 'SearchColumnBooleanField[]',
		'isEmailed' => 'SearchColumnBooleanField[]',
		'isIncoming' => 'SearchColumnBooleanField[]',
		'message' => 'SearchColumnStringField[]',
		'messageDate' => 'SearchColumnDateField[]',
		'messageType' => 'SearchColumnEnumSelectField[]',
		'recipient' => 'SearchColumnSelectField[]',
		'recipientEmail' => 'SearchColumnStringField[]',
		'subject' => 'SearchColumnStringField[]',
	);
}
