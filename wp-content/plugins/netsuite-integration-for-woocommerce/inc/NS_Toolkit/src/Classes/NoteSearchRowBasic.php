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

class NoteSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $author;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $direction;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $note;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $noteDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $noteType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'author' => 'SearchColumnSelectField[]',
		'direction' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'note' => 'SearchColumnStringField[]',
		'noteDate' => 'SearchColumnDateField[]',
		'noteType' => 'SearchColumnStringField[]',
		'title' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
