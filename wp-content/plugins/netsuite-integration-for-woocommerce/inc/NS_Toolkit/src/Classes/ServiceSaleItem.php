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

class ServiceSaleItem extends Record {
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
	public $saleUnit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueProduct;
	/**
	 * Var string
	 */
	public $costEstimateUnits;
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
	public $revRecSchedule;
	/**
	 * Var integer
	 */
	public $minimumQuantity;
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
	 * Var boolean
	 */
	public $isFulfillable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $costCategory;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $pricingGroup;
	/**
	 * Var string
	 */
	public $minimumQuantityUnits;
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
	 * Var boolean
	 */
	public $createJob;
	/**
	 * Var string
	 */
	public $matrixItemNameTemplate;
	/**
	 * Var string
	 */
	public $storeDisplayName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeDisplayThumbnail;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeDisplayImage;
	/**
	 * Var string
	 */
	public $storeDescription;
	/**
	 * Var string
	 */
	public $storeDetailedDescription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeItemTemplate;
	/**
	 * Var string
	 */
	public $pageTitle;
	/**
	 * Var string
	 */
	public $urlComponent;
	/**
	 * Var string
	 */
	public $metaTagHtml;
	/**
	 * Var boolean
	 */
	public $excludeFromSitemap;
	/**
	 * Var \NetSuite\Classes\SitemapPriority
	 */
	public $sitemapPriority;
	/**
	 * Var string
	 */
	public $searchKeywords;
	/**
	 * Var boolean
	 */
	public $isDonationItem;
	/**
	 * Var boolean
	 */
	public $showDefaultDonationAmount;
	/**
	 * Var float
	 */
	public $maxDonationAmount;
	/**
	 * Var boolean
	 */
	public $dontShowPrice;
	/**
	 * Var string
	 */
	public $noPriceMessage;
	/**
	 * Var string
	 */
	public $outOfStockMessage;
	/**
	 * Var boolean
	 */
	public $onSpecial;
	/**
	 * Var \NetSuite\Classes\ItemOutOfStockBehavior
	 */
	public $outOfStockBehavior;
	/**
	 * Var string
	 */
	public $relatedItemsDescription;
	/**
	 * Var string
	 */
	public $specialsDescription;
	/**
	 * Var \NetSuite\Classes\ServiceItemTaskTemplatesList
	 */
	public $itemTaskTemplatesList;
	/**
	 * Var string
	 */
	public $featuredDescription;
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
	 * Var \NetSuite\Classes\BillingRatesMatrix
	 */
	public $billingRatesMatrix;
	/**
	 * Var \NetSuite\Classes\ItemAccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\ItemOptionsList
	 */
	public $itemOptionsList;
	/**
	 * Var \NetSuite\Classes\MatrixOptionList
	 */
	public $matrixOptionList;
	/**
	 * Var \NetSuite\Classes\PricingMatrix
	 */
	public $pricingMatrix;
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
	 * Var \NetSuite\Classes\SiteCategoryList
	 */
	public $siteCategoryList;
	/**
	 * Var \NetSuite\Classes\TranslationList
	 */
	public $translationsList;
	/**
	 * Var \NetSuite\Classes\PresentationItemList
	 */
	public $presentationItemList;
	/**
	 * Var \NetSuite\Classes\ServiceSaleItemHierarchyVersionsList
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
		'salesDescription' => 'string',
		'includeChildren' => 'boolean',
		'incomeAccount' => 'RecordRef',
		'isTaxable' => 'boolean',
		'matrixType' => 'ItemMatrixType',
		'taxSchedule' => 'RecordRef',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'unitsType' => 'RecordRef',
		'saleUnit' => 'RecordRef',
		'issueProduct' => 'RecordRef',
		'costEstimateUnits' => 'string',
		'billingSchedule' => 'RecordRef',
		'deferredRevenueAccount' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'minimumQuantity' => 'integer',
		'enforceMinQtyInternally' => 'boolean',
		'maximumQuantity' => 'integer',
		'softDescriptor' => 'string',
		'pricesIncludeTax' => 'boolean',
		'quantityPricingSchedule' => 'RecordRef',
		'useMarginalRates' => 'boolean',
		'overallQuantityPricingType' => 'ItemOverallQuantityPricingType',
		'isFulfillable' => 'boolean',
		'costCategory' => 'RecordRef',
		'pricingGroup' => 'RecordRef',
		'minimumQuantityUnits' => 'string',
		'vsoePrice' => 'float',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'itemRevenueCategory' => 'RecordRef',
		'deferRevRec' => 'boolean',
		'revenueRecognitionRule' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'revenueAllocationGroup' => 'RecordRef',
		'createRevenuePlansOn' => 'RecordRef',
		'directRevenuePosting' => 'boolean',
		'contingentRevenueHandling' => 'boolean',
		'revReclassFXAccount' => 'RecordRef',
		'createJob' => 'boolean',
		'matrixItemNameTemplate' => 'string',
		'storeDisplayName' => 'string',
		'storeDisplayThumbnail' => 'RecordRef',
		'storeDisplayImage' => 'RecordRef',
		'storeDescription' => 'string',
		'storeDetailedDescription' => 'string',
		'storeItemTemplate' => 'RecordRef',
		'pageTitle' => 'string',
		'urlComponent' => 'string',
		'metaTagHtml' => 'string',
		'excludeFromSitemap' => 'boolean',
		'sitemapPriority' => 'SitemapPriority',
		'searchKeywords' => 'string',
		'isDonationItem' => 'boolean',
		'showDefaultDonationAmount' => 'boolean',
		'maxDonationAmount' => 'float',
		'dontShowPrice' => 'boolean',
		'noPriceMessage' => 'string',
		'outOfStockMessage' => 'string',
		'onSpecial' => 'boolean',
		'outOfStockBehavior' => 'ItemOutOfStockBehavior',
		'relatedItemsDescription' => 'string',
		'specialsDescription' => 'string',
		'itemTaskTemplatesList' => 'ServiceItemTaskTemplatesList',
		'featuredDescription' => 'string',
		'customForm' => 'RecordRef',
		'itemId' => 'string',
		'upcCode' => 'string',
		'displayName' => 'string',
		'parent' => 'RecordRef',
		'isOnline' => 'boolean',
		'isGcoCompliant' => 'boolean',
		'offerSupport' => 'boolean',
		'isInactive' => 'boolean',
		'availableToPartners' => 'boolean',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiaryList' => 'RecordRefList',
		'billingRatesMatrix' => 'BillingRatesMatrix',
		'accountingBookDetailList' => 'ItemAccountingBookDetailList',
		'itemOptionsList' => 'ItemOptionsList',
		'matrixOptionList' => 'MatrixOptionList',
		'pricingMatrix' => 'PricingMatrix',
		'purchaseTaxCode' => 'RecordRef',
		'rate' => 'float',
		'salesTaxCode' => 'RecordRef',
		'siteCategoryList' => 'SiteCategoryList',
		'translationsList' => 'TranslationList',
		'presentationItemList' => 'PresentationItemList',
		'hierarchyVersionsList' => 'ServiceSaleItemHierarchyVersionsList',
		'consumptionUnit' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
