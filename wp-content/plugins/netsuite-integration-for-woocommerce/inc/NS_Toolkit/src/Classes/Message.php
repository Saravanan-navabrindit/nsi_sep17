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

class Message extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $author;
	/**
	 * Var string
	 */
	public $authorEmail;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $recipient;
	/**
	 * Var string
	 */
	public $recipientEmail;
	/**
	 * Var string
	 */
	public $cc;
	/**
	 * Var string
	 */
	public $bcc;
	/**
	 * Var string
	 */
	public $messageDate;
	/**
	 * Var string
	 */
	public $recordName;
	/**
	 * Var string
	 */
	public $recordTypeName;
	/**
	 * Var string
	 */
	public $subject;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var boolean
	 */
	public $emailed;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $activity;
	/**
	 * Var boolean
	 */
	public $compressAttachments;
	/**
	 * Var boolean
	 */
	public $incoming;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transaction;
	/**
	 * Var \NetSuite\Classes\MessageMediaItemList
	 */
	public $mediaItemList;
	/**
	 * Var string
	 */
	public $dateTime;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'author' => 'RecordRef',
		'authorEmail' => 'string',
		'recipient' => 'RecordRef',
		'recipientEmail' => 'string',
		'cc' => 'string',
		'bcc' => 'string',
		'messageDate' => 'dateTime',
		'recordName' => 'string',
		'recordTypeName' => 'string',
		'subject' => 'string',
		'message' => 'string',
		'emailed' => 'boolean',
		'activity' => 'RecordRef',
		'compressAttachments' => 'boolean',
		'incoming' => 'boolean',
		'lastModifiedDate' => 'dateTime',
		'transaction' => 'RecordRef',
		'mediaItemList' => 'MessageMediaItemList',
		'dateTime' => 'string',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
