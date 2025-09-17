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

class CustomRecord extends Record {
	/**
	 * Var string
	 */
	public $customRecordId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var string
	 */
	public $disclaimer;
	/**
	 * Var string
	 */
	public $created;
	/**
	 * Var string
	 */
	public $lastModified;
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var boolean
	 */
	public $autoName;
	/**
	 * Var string
	 */
	public $altName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $recType;
	/**
	 * Var boolean
	 */
	public $enableNumbering;
	/**
	 * Var string
	 */
	public $numberingPrefix;
	/**
	 * Var string
	 */
	public $numberingSuffix;
	/**
	 * Var integer
	 */
	public $numberingMinDigits;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var integer
	 */
	public $numberingInit;
	/**
	 * Var integer
	 */
	public $numberingCurrentNumber;
	/**
	 * Var boolean
	 */
	public $allowNumberingOverride;
	/**
	 * Var boolean
	 */
	public $isNumberingUpdateable;
	/**
	 * Var \NetSuite\Classes\CustomRecordTranslationsList
	 */
	public $translationsList;
	/**
	 * Var boolean
	 */
	public $includeName;
	/**
	 * Var boolean
	 */
	public $showId;
	/**
	 * Var boolean
	 */
	public $showCreationDate;
	/**
	 * Var boolean
	 */
	public $showCreationDateOnList;
	/**
	 * Var boolean
	 */
	public $showLastModified;
	/**
	 * Var boolean
	 */
	public $showLastModifiedOnList;
	/**
	 * Var boolean
	 */
	public $showOwner;
	/**
	 * Var boolean
	 */
	public $showOwnerOnList;
	/**
	 * Var boolean
	 */
	public $showOwnerAllowChange;
	/**
	 * Var boolean
	 */
	public $usePermissions;
	/**
	 * Var boolean
	 */
	public $allowAttachments;
	/**
	 * Var boolean
	 */
	public $showNotes;
	/**
	 * Var boolean
	 */
	public $enablEmailMerge;
	/**
	 * Var boolean
	 */
	public $isOrdered;
	/**
	 * Var boolean
	 */
	public $allowInlineEditing;
	/**
	 * Var boolean
	 */
	public $isAvailableOffline;
	/**
	 * Var boolean
	 */
	public $allowQuickSearch;
	/**
	 * Var string
	 */
	public $recordName;
	/**
	 * Var string
	 */
	public $scriptId;
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
		'customRecordId' => 'string',
		'customForm' => 'RecordRef',
		'isInactive' => 'boolean',
		'parent' => 'RecordRef',
		'disclaimer' => 'string',
		'created' => 'dateTime',
		'lastModified' => 'dateTime',
		'name' => 'string',
		'autoName' => 'boolean',
		'altName' => 'string',
		'owner' => 'RecordRef',
		'recType' => 'RecordRef',
		'enableNumbering' => 'boolean',
		'numberingPrefix' => 'string',
		'numberingSuffix' => 'string',
		'numberingMinDigits' => 'integer',
		'description' => 'string',
		'numberingInit' => 'integer',
		'numberingCurrentNumber' => 'integer',
		'allowNumberingOverride' => 'boolean',
		'isNumberingUpdateable' => 'boolean',
		'translationsList' => 'CustomRecordTranslationsList',
		'includeName' => 'boolean',
		'showId' => 'boolean',
		'showCreationDate' => 'boolean',
		'showCreationDateOnList' => 'boolean',
		'showLastModified' => 'boolean',
		'showLastModifiedOnList' => 'boolean',
		'showOwner' => 'boolean',
		'showOwnerOnList' => 'boolean',
		'showOwnerAllowChange' => 'boolean',
		'usePermissions' => 'boolean',
		'allowAttachments' => 'boolean',
		'showNotes' => 'boolean',
		'enablEmailMerge' => 'boolean',
		'isOrdered' => 'boolean',
		'allowInlineEditing' => 'boolean',
		'isAvailableOffline' => 'boolean',
		'allowQuickSearch' => 'boolean',
		'recordName' => 'string',
		'scriptId' => 'string',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
