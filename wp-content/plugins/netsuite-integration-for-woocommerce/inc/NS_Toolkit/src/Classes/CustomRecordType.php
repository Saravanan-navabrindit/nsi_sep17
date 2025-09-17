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

class CustomRecordType extends Record {
	/**
	 * Var string
	 */
	public $recordName;
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
	 * Var \NetSuite\Classes\CustomRecordTypeAccessType
	 */
	public $accessType;
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
	public $enableMailMerge;
	/**
	 * Var boolean
	 */
	public $isOrdered;
	/**
	 * Var boolean
	 */
	public $isAvailableOffline;
	/**
	 * Var boolean
	 */
	public $allowQuickSearch;
	/**
	 * Var boolean
	 */
	public $hierarchical;
	/**
	 * Var boolean
	 */
	public $enableDle;
	/**
	 * Var boolean
	 */
	public $enableNameTranslation;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $disclaimer;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeTabsList
	 */
	public $tabsList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeSublistsList
	 */
	public $sublistsList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeFormsList
	 */
	public $formsList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeOnlineFormsList
	 */
	public $onlineFormsList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypePermissionsList
	 */
	public $permissionsList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeLinksList
	 */
	public $linksList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeManagersList
	 */
	public $managersList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeChildrenList
	 */
	public $childrenList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeParentsList
	 */
	public $parentsList;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeTranslationsList
	 */
	public $translationsList;
	/**
	 * Var string
	 */
	public $scriptId;
	/**
	 * Var \NetSuite\Classes\CustomRecordTypeFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	public static $paramtypesmap = array(
		'recordName' => 'string',
		'includeName' => 'boolean',
		'showId' => 'boolean',
		'showCreationDate' => 'boolean',
		'showCreationDateOnList' => 'boolean',
		'showLastModified' => 'boolean',
		'showLastModifiedOnList' => 'boolean',
		'showOwner' => 'boolean',
		'showOwnerOnList' => 'boolean',
		'showOwnerAllowChange' => 'boolean',
		'accessType' => 'CustomRecordTypeAccessType',
		'allowAttachments' => 'boolean',
		'showNotes' => 'boolean',
		'enableMailMerge' => 'boolean',
		'isOrdered' => 'boolean',
		'isAvailableOffline' => 'boolean',
		'allowQuickSearch' => 'boolean',
		'hierarchical' => 'boolean',
		'enableDle' => 'boolean',
		'enableNameTranslation' => 'boolean',
		'isInactive' => 'boolean',
		'disclaimer' => 'string',
		'enableNumbering' => 'boolean',
		'numberingPrefix' => 'string',
		'numberingSuffix' => 'string',
		'numberingMinDigits' => 'integer',
		'numberingInit' => 'integer',
		'numberingCurrentNumber' => 'integer',
		'allowNumberingOverride' => 'boolean',
		'isNumberingUpdateable' => 'boolean',
		'owner' => 'RecordRef',
		'description' => 'string',
		'tabsList' => 'CustomRecordTypeTabsList',
		'sublistsList' => 'CustomRecordTypeSublistsList',
		'formsList' => 'CustomRecordTypeFormsList',
		'onlineFormsList' => 'CustomRecordTypeOnlineFormsList',
		'permissionsList' => 'CustomRecordTypePermissionsList',
		'linksList' => 'CustomRecordTypeLinksList',
		'managersList' => 'CustomRecordTypeManagersList',
		'childrenList' => 'CustomRecordTypeChildrenList',
		'parentsList' => 'CustomRecordTypeParentsList',
		'translationsList' => 'CustomRecordTypeTranslationsList',
		'scriptId' => 'string',
		'customFieldList' => 'CustomRecordTypeFieldList',
		'internalId' => 'string',
	);
}
