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

class OtherChargeResaleItem extends Record {
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
	/**
	 * Var string
	 */
	public $purchaseDescription;
	/**
	 * Var boolean
	 */
	public $manufacturingChargeItem;
	/**
	 * Var float
	 */
	public $cost;
	/**
	 * Var string
	 */
	public $costUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expenseAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoExpenseAccount;
	/**
	 * Var string
	 */
	public $salesDescription;
	/**
	 * Var boolean
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $incomeAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoIncomeAccount;
	/**
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\ItemMatrixType
	 */
	public $matrixType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxSchedule;
	/**
	 * Var \NetSuite\Classes\ItemCostEstimateType
	 */
	public $costEstimateType;
	/**
	 * Var float
	 */
	public $costEstimate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseUnit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $saleUnit;
	/**
	 * Var string
	 */
	public $costEstimateUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueProduct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $deferredRevenueAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoDefRevAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $deferralAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $amortizationTemplate;
	/**
	 * Var string
	 */
	public $residual;
	/**
	 * Var boolean
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revenueRecognitionRule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecForecastRule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revenueAllocationGroup;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createRevenuePlansOn;
	/**
	 * Var boolean
	 */
	public $directRevenuePosting;
	/**
	 * Var boolean
	 */
	public $contingentRevenueHandling;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revReclassFXAccount;
	/**
	 * Var integer
	 */
	public $amortizationPeriod;
	/**
	 * Var integer
	 */
	public $minimumQuantity;
	/**
	 * Var string
	 */
	public $minimumQuantityUnits;
	/**
	 * Var boolean
	 */
	public $enforceMinQtyInternally;
	/**
	 * Var integer
	 */
	public $maximumQuantity;
	/**
	 * Var string
	 */
	public $softDescriptor;
	/**
	 * Var boolean
	 */
	public $isFulfillable;
	/**
	 * Var boolean
	 */
	public $generateAccruals;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $costCategory;
	/**
	 * Var float
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var float
	 */
	public $purchaseOrderAmount;
	/**
	 * Var float
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var float
	 */
	public $receiptQuantity;
	/**
	 * Var float
	 */
	public $receiptAmount;
	/**
	 * Var float
	 */
	public $receiptQuantityDiff;
	/**
	 * Var boolean
	 */
	public $pricesIncludeTax;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $quantityPricingSchedule;
	/**
	 * Var boolean
	 */
	public $useMarginalRates;
	/**
	 * Var \NetSuite\Classes\ItemOverallQuantityPricingType
	 */
	public $overallQuantityPricingType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $pricingGroup;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $itemId;
	/**
	 * Var string
	 */
	public $upcCode;
	/**
	 * Var string
	 */
	public $displayName;
	/**
	 * Var string
	 */
	public $vendorName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var boolean
	 */
	public $isOnline;
	/**
	 * Var boolean
	 */
	public $isGcoCompliant;
	/**
	 * Var boolean
	 */
	public $offerSupport;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var string
	 */
	public $matrixItemNameTemplate;
	/**
	 * Var boolean
	 */
	public $availableToPartners;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var float
	 */
	public $vsoePrice;
	/**
	 * Var \NetSuite\Classes\VsoeSopGroup
	 */
	public $vsoeSopGroup;
	/**
	 * Var \NetSuite\Classes\VsoeDeferral
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\VsoePermitDiscount
	 */
	public $vsoePermitDiscount;
	/**
	 * Var boolean
	 */
	public $vsoeDelivered;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemRevenueCategory;
	/**
	 * Var string
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\ItemOptionsList
	 */
	public $itemOptionsList;
	/**
	 * Var \NetSuite\Classes\MatrixOptionList
	 */
	public $matrixOptionList;
	/**
	 * Var \NetSuite\Classes\ItemVendorList
	 */
	public $itemVendorList;
	/**
	 * Var \NetSuite\Classes\PricingMatrix
	 */
	public $pricingMatrix;
	/**
	 * Var \NetSuite\Classes\ItemAccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseTaxCode;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesTaxCode;
	/**
	 * Var \NetSuite\Classes\TranslationList
	 */
	public $translationsList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $vendor;
	/**
	 * Var \NetSuite\Classes\OtherChargeResaleItemHierarchyVersionsList
	 */
	public $hierarchyVersionsList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $consumptionUnit;
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
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'purchaseDescription' => 'string',
		'manufacturingChargeItem' => 'boolean',
		'cost' => 'float',
		'costUnits' => 'string',
		'expenseAccount' => 'RecordRef',
		'intercoExpenseAccount' => 'RecordRef',
		'salesDescription' => 'string',
		'includeChildren' => 'boolean',
		'incomeAccount' => 'RecordRef',
		'intercoIncomeAccount' => 'RecordRef',
		'isTaxable' => 'boolean',
		'matrixType' => 'ItemMatrixType',
		'taxSchedule' => 'RecordRef',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'unitsType' => 'RecordRef',
		'purchaseUnit' => 'RecordRef',
		'saleUnit' => 'RecordRef',
		'costEstimateUnits' => 'string',
		'issueProduct' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'deferredRevenueAccount' => 'RecordRef',
		'intercoDefRevAccount' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'deferralAccount' => 'RecordRef',
		'amortizationTemplate' => 'RecordRef',
		'residual' => 'string',
		'deferRevRec' => 'boolean',
		'revenueRecognitionRule' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'revenueAllocationGroup' => 'RecordRef',
		'createRevenuePlansOn' => 'RecordRef',
		'directRevenuePosting' => 'boolean',
		'contingentRevenueHandling' => 'boolean',
		'revReclassFXAccount' => 'RecordRef',
		'amortizationPeriod' => 'integer',
		'minimumQuantity' => 'integer',
		'minimumQuantityUnits' => 'string',
		'enforceMinQtyInternally' => 'boolean',
		'maximumQuantity' => 'integer',
		'softDescriptor' => 'string',
		'isFulfillable' => 'boolean',
		'generateAccruals' => 'boolean',
		'costCategory' => 'RecordRef',
		'purchaseOrderQuantity' => 'float',
		'purchaseOrderAmount' => 'float',
		'purchaseOrderQuantityDiff' => 'float',
		'receiptQuantity' => 'float',
		'receiptAmount' => 'float',
		'receiptQuantityDiff' => 'float',
		'pricesIncludeTax' => 'boolean',
		'quantityPricingSchedule' => 'RecordRef',
		'useMarginalRates' => 'boolean',
		'overallQuantityPricingType' => 'ItemOverallQuantityPricingType',
		'pricingGroup' => 'RecordRef',
		'customForm' => 'RecordRef',
		'itemId' => 'string',
		'upcCode' => 'string',
		'displayName' => 'string',
		'vendorName' => 'string',
		'parent' => 'RecordRef',
		'isOnline' => 'boolean',
		'isGcoCompliant' => 'boolean',
		'offerSupport' => 'boolean',
		'isInactive' => 'boolean',
		'matrixItemNameTemplate' => 'string',
		'availableToPartners' => 'boolean',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiaryList' => 'RecordRefList',
		'vsoePrice' => 'float',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'itemRevenueCategory' => 'RecordRef',
		'currency' => 'string',
		'itemOptionsList' => 'ItemOptionsList',
		'matrixOptionList' => 'MatrixOptionList',
		'itemVendorList' => 'ItemVendorList',
		'pricingMatrix' => 'PricingMatrix',
		'accountingBookDetailList' => 'ItemAccountingBookDetailList',
		'purchaseTaxCode' => 'RecordRef',
		'rate' => 'float',
		'salesTaxCode' => 'RecordRef',
		'translationsList' => 'TranslationList',
		'vendor' => 'RecordRef',
		'hierarchyVersionsList' => 'OtherChargeResaleItemHierarchyVersionsList',
		'consumptionUnit' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
