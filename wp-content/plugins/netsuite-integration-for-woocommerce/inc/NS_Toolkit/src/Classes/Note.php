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

class Note extends Record {
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $noteType;
	/**
	 * Var \NetSuite\Classes\NoteDirection
	 */
	public $direction;
	/**
	 * Var string
	 */
	public $noteDate;
	/**
	 * Var string
	 */
	public $note;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $activity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $author;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $folder;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $media;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $record;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $recordType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $topic;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transaction;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'title' => 'string',
		'noteType' => 'RecordRef',
		'direction' => 'NoteDirection',
		'noteDate' => 'dateTime',
		'note' => 'string',
		'lastModifiedDate' => 'dateTime',
		'activity' => 'RecordRef',
		'author' => 'RecordRef',
		'entity' => 'RecordRef',
		'folder' => 'RecordRef',
		'item' => 'RecordRef',
		'media' => 'RecordRef',
		'record' => 'RecordRef',
		'recordType' => 'RecordRef',
		'topic' => 'RecordRef',
		'transaction' => 'RecordRef',
		'customForm' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
