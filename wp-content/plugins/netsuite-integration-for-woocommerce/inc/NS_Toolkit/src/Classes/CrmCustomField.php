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

require_once 'CustomFieldType.php';


class CrmCustomField extends CustomFieldType {
	/**
	 * Var string
	 */
	public $label;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $selectRecordType;
	/**
	 * Var boolean
	 */
	public $storeValue;
	/**
	 * Var boolean
	 */
	public $showInList;
	/**
	 * Var boolean
	 */
	public $globalSearch;
	/**
	 * Var boolean
	 */
	public $isParent;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $insertBefore;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subtab;
	/**
	 * Var \NetSuite\Classes\CustomizationDisplayType
	 */
	public $displayType;
	/**
	 * Var integer
	 */
	public $displayWidth;
	/**
	 * Var integer
	 */
	public $displayHeight;
	/**
	 * Var string
	 */
	public $help;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parentSubtab;
	/**
	 * Var string
	 */
	public $linkText;
	/**
	 * Var boolean
	 */
	public $isMandatory;
	/**
	 * Var boolean
	 */
	public $checkSpelling;
	/**
	 * Var integer
	 */
	public $maxLength;
	/**
	 * Var float
	 */
	public $minValue;
	/**
	 * Var float
	 */
	public $maxValue;
	/**
	 * Var boolean
	 */
	public $defaultChecked;
	/**
	 * Var string
	 */
	public $defaultValue;
	/**
	 * Var boolean
	 */
	public $isFormula;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultSelection;
	/**
	 * Var \NetSuite\Classes\CustomizationDynamicDefault
	 */
	public $dynamicDefault;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $searchDefault;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $searchCompareField;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $sourceList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $sourceFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $sourceFilterBy;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customSegment;
	/**
	 * Var boolean
	 */
	public $appliesToTask;
	/**
	 * Var boolean
	 */
	public $appliesToMfgProjectTask;
	/**
	 * Var boolean
	 */
	public $appliesToProjectTask;
	/**
	 * Var boolean
	 */
	public $appliesToPhoneCall;
	/**
	 * Var boolean
	 */
	public $appliesToEvent;
	/**
	 * Var boolean
	 */
	public $appliesToCase;
	/**
	 * Var boolean
	 */
	public $appliesToCampaign;
	/**
	 * Var boolean
	 */
	public $appliesPerKeyword;
	/**
	 * Var boolean
	 */
	public $appliesToSolution;
	/**
	 * Var boolean
	 */
	public $appliesToIssue;
	/**
	 * Var boolean
	 */
	public $availableExternally;
	/**
	 * Var boolean
	 */
	public $availableToSso;
	/**
	 * Var boolean
	 */
	public $showIssueChanges;
	/**
	 * Var \NetSuite\Classes\CrmCustomFieldFilterList
	 */
	public $filterList;
	/**
	 * Var \NetSuite\Classes\CustomizationAccessLevel
	 */
	public $accessLevel;
	/**
	 * Var \NetSuite\Classes\CustomizationSearchLevel
	 */
	public $searchLevel;
	/**
	 * Var \NetSuite\Classes\CustomFieldRoleAccessList
	 */
	public $roleAccessList;
	/**
	 * Var \NetSuite\Classes\CustomFieldDepartmentAccessList
	 */
	public $deptAccessList;
	/**
	 * Var \NetSuite\Classes\CustomFieldSubAccessList
	 */
	public $subAccessList;
	/**
	 * Var \NetSuite\Classes\CustomFieldTranslationsList
	 */
	public $translationsList;
	/**
	 * Var string
	 */
	public $internalId;
	public static $paramtypesmap = array(
		'label' => 'string',
		'owner' => 'RecordRef',
		'description' => 'string',
		'selectRecordType' => 'RecordRef',
		'storeValue' => 'boolean',
		'showInList' => 'boolean',
		'globalSearch' => 'boolean',
		'isParent' => 'boolean',
		'insertBefore' => 'RecordRef',
		'subtab' => 'RecordRef',
		'displayType' => 'CustomizationDisplayType',
		'displayWidth' => 'integer',
		'displayHeight' => 'integer',
		'help' => 'string',
		'parentSubtab' => 'RecordRef',
		'linkText' => 'string',
		'isMandatory' => 'boolean',
		'checkSpelling' => 'boolean',
		'maxLength' => 'integer',
		'minValue' => 'float',
		'maxValue' => 'float',
		'defaultChecked' => 'boolean',
		'defaultValue' => 'string',
		'isFormula' => 'boolean',
		'defaultSelection' => 'RecordRef',
		'dynamicDefault' => 'CustomizationDynamicDefault',
		'searchDefault' => 'RecordRef',
		'searchCompareField' => 'RecordRef',
		'sourceList' => 'RecordRef',
		'sourceFrom' => 'RecordRef',
		'sourceFilterBy' => 'RecordRef',
		'customSegment' => 'RecordRef',
		'appliesToTask' => 'boolean',
		'appliesToMfgProjectTask' => 'boolean',
		'appliesToProjectTask' => 'boolean',
		'appliesToPhoneCall' => 'boolean',
		'appliesToEvent' => 'boolean',
		'appliesToCase' => 'boolean',
		'appliesToCampaign' => 'boolean',
		'appliesPerKeyword' => 'boolean',
		'appliesToSolution' => 'boolean',
		'appliesToIssue' => 'boolean',
		'availableExternally' => 'boolean',
		'availableToSso' => 'boolean',
		'showIssueChanges' => 'boolean',
		'filterList' => 'CrmCustomFieldFilterList',
		'accessLevel' => 'CustomizationAccessLevel',
		'searchLevel' => 'CustomizationSearchLevel',
		'roleAccessList' => 'CustomFieldRoleAccessList',
		'deptAccessList' => 'CustomFieldDepartmentAccessList',
		'subAccessList' => 'CustomFieldSubAccessList',
		'translationsList' => 'CustomFieldTranslationsList',
		'internalId' => 'string',
	);
}
