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

class TransactionColumnCustomField extends CustomFieldType {
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
	 * Var boolean
	 */
	public $availableToSso;
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
	public $colExpense;
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
	public $colJournal;
	/**
	 * Var boolean
	 */
	public $colBuild;
	/**
	 * Var boolean
	 */
	public $colExpenseReport;
	/**
	 * Var boolean
	 */
	public $colTime;
	/**
	 * Var boolean
	 */
	public $colTransferOrder;
	/**
	 * Var boolean
	 */
	public $colTimeGroup;
	/**
	 * Var boolean
	 */
	public $colItemReceipt;
	/**
	 * Var boolean
	 */
	public $colItemReceiptOrder;
	/**
	 * Var boolean
	 */
	public $colItemFulfillment;
	/**
	 * Var boolean
	 */
	public $colItemFulfillmentOrder;
	/**
	 * Var boolean
	 */
	public $colPrintFlag;
	/**
	 * Var boolean
	 */
	public $colPickingTicket;
	/**
	 * Var boolean
	 */
	public $colPackingSlip;
	/**
	 * Var boolean
	 */
	public $colReturnForm;
	/**
	 * Var boolean
	 */
	public $colStoreWithGroups;
	/**
	 * Var boolean
	 */
	public $colGroupOnInvoices;
	/**
	 * Var boolean
	 */
	public $colKitItem;
	/**
	 * Var \NetSuite\Classes\TransactionColumnCustomFieldFilterList
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
		'insertBefore' => 'RecordRef',
		'availableToSso' => 'boolean',
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
		'sourceList' => 'RecordRef',
		'sourceFrom' => 'RecordRef',
		'sourceFilterBy' => 'RecordRef',
		'customSegment' => 'RecordRef',
		'colExpense' => 'boolean',
		'colPurchase' => 'boolean',
		'colSale' => 'boolean',
		'colOpportunity' => 'boolean',
		'colStore' => 'boolean',
		'colStoreHidden' => 'boolean',
		'colJournal' => 'boolean',
		'colBuild' => 'boolean',
		'colExpenseReport' => 'boolean',
		'colTime' => 'boolean',
		'colTransferOrder' => 'boolean',
		'colTimeGroup' => 'boolean',
		'colItemReceipt' => 'boolean',
		'colItemReceiptOrder' => 'boolean',
		'colItemFulfillment' => 'boolean',
		'colItemFulfillmentOrder' => 'boolean',
		'colPrintFlag' => 'boolean',
		'colPickingTicket' => 'boolean',
		'colPackingSlip' => 'boolean',
		'colReturnForm' => 'boolean',
		'colStoreWithGroups' => 'boolean',
		'colGroupOnInvoices' => 'boolean',
		'colKitItem' => 'boolean',
		'filterList' => 'TransactionColumnCustomFieldFilterList',
		'accessLevel' => 'CustomizationAccessLevel',
		'searchLevel' => 'CustomizationSearchLevel',
		'roleAccessList' => 'CustomFieldRoleAccessList',
		'deptAccessList' => 'CustomFieldDepartmentAccessList',
		'subAccessList' => 'CustomFieldSubAccessList',
		'translationsList' => 'CustomFieldTranslationsList',
		'internalId' => 'string',
	);
}
