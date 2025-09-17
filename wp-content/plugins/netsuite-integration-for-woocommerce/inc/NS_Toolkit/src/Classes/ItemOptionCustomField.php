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

class ItemOptionCustomField extends CustomFieldType {
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $insertBefore;
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
	 * Var string
	 */
	public $linkText;
	/**
	 * Var boolean
	 */
	public $isMandatory;
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
	 * Var boolean
	 */
	public $colPurchase;
	/**
	 * Var boolean
	 */
	public $colSale;
	/**
	 * Var boolean
	 */
	public $colOpportunity;
	/**
	 * Var boolean
	 */
	public $colStore;
	/**
	 * Var boolean
	 */
	public $colStoreHidden;
	/**
	 * Var boolean
	 */
	public $colTransferOrder;
	/**
	 * Var boolean
	 */
	public $colAllItems;
	/**
	 * Var \NetSuite\Classes\ItemsList
	 */
	public $itemsList;
	/**
	 * Var boolean
	 */
	public $colKitItem;
	/**
	 * Var \NetSuite\Classes\ItemOptionCustomFieldFilterList
	 */
	public $filterList;
	/**
	 * Var string
	 */
	public $colOptionLabel;
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
		'insertBefore' => 'RecordRef',
		'displayType' => 'CustomizationDisplayType',
		'displayWidth' => 'integer',
		'displayHeight' => 'integer',
		'help' => 'string',
		'linkText' => 'string',
		'isMandatory' => 'boolean',
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
		'colPurchase' => 'boolean',
		'colSale' => 'boolean',
		'colOpportunity' => 'boolean',
		'colStore' => 'boolean',
		'colStoreHidden' => 'boolean',
		'colTransferOrder' => 'boolean',
		'colAllItems' => 'boolean',
		'itemsList' => 'ItemsList',
		'colKitItem' => 'boolean',
		'filterList' => 'ItemOptionCustomFieldFilterList',
		'colOptionLabel' => 'string',
		'accessLevel' => 'CustomizationAccessLevel',
		'searchLevel' => 'CustomizationSearchLevel',
		'roleAccessList' => 'CustomFieldRoleAccessList',
		'deptAccessList' => 'CustomFieldDepartmentAccessList',
		'subAccessList' => 'CustomFieldSubAccessList',
		'translationsList' => 'CustomFieldTranslationsList',
		'internalId' => 'string',
	);
}
