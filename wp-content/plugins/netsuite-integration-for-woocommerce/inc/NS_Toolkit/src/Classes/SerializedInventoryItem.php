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

class SerializedInventoryItem extends Record {
	/**
	 * Var string
	 */
	public $createdDate;
	/**
	 * Var string
	 */
	public $lastModifiedDate;
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
	 * Var \NetSuite\Classes\ItemMatrixType
	 */
	public $matrixType;
	/**
	 * Var boolean
	 */
	public $includeChildren;
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
	public $isHazmatItem;
	/**
	 * Var string
	 */
	public $hazmatId;
	/**
	 * Var string
	 */
	public $hazmatShippingName;
	/**
	 * Var string
	 */
	public $hazmatHazardClass;
	/**
	 * Var \NetSuite\Classes\HazmatPackingGroup
	 */
	public $hazmatPackingGroup;
	/**
	 * Var string
	 */
	public $hazmatItemUnits;
	/**
	 * Var float
	 */
	public $hazmatItemUnitsQty;
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
	 * Var \NetSuite\Classes\ItemCostingMethod
	 */
	public $costingMethod;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var string
	 */
	public $purchaseDescription;
	/**
	 * Var boolean
	 */
	public $copyDescription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueProduct;
	/**
	 * Var string
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $cogsAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoCogsAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $vendor;
	/**
	 * Var string
	 */
	public $salesDescription;
	/**
	 * Var string
	 */
	public $lastInvtCountDate;
	/**
	 * Var string
	 */
	public $nextInvtCountDate;
	/**
	 * Var integer
	 */
	public $invtCountInterval;
	/**
	 * Var \NetSuite\Classes\ItemInvtClassification
	 */
	public $invtClassification;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxSchedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $dropshipExpenseAccount;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $assetAccount;
	/**
	 * Var boolean
	 */
	public $matchBillToReceipt;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billQtyVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billPriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billExchRateVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $gainLossAccount;
	/**
	 * Var float
	 */
	public $shippingCost;
	/**
	 * Var float
	 */
	public $handlingCost;
	/**
	 * Var float
	 */
	public $weight;
	/**
	 * Var string
	 */
	public $costingMethodDisplay;
	/**
	 * Var string
	 */
	public $shippingCostUnits;
	/**
	 * Var string
	 */
	public $handlingCostUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $stockUnit;
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
	public $minimumQuantityUnits;
	/**
	 * Var string
	 */
	public $safetyStockLevelUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var boolean
	 */
	public $trackLandedCost;
	/**
	 * Var string
	 */
	public $matrixItemNameTemplate;
	/**
	 * Var boolean
	 */
	public $isDropShipItem;
	/**
	 * Var boolean
	 */
	public $isSpecialOrderItem;
	/**
	 * Var string
	 */
	public $stockDescription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $deferredRevenueAccount;
	/**
	 * Var boolean
	 */
	public $producer;
	/**
	 * Var string
	 */
	public $manufacturer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var string
	 */
	public $mpn;
	/**
	 * Var boolean
	 */
	public $multManufactureAddr;
	/**
	 * Var string
	 */
	public $manufacturerAddr1;
	/**
	 * Var string
	 */
	public $manufacturerCity;
	/**
	 * Var string
	 */
	public $manufacturerState;
	/**
	 * Var string
	 */
	public $manufacturerZip;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $countryOfManufacture;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultItemShipMethod;
	/**
	 * Var \NetSuite\Classes\ShippingCarrier
	 */
	public $itemCarrier;
	/**
	 * Var boolean
	 */
	public $roundUpAsComponent;
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
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $itemShipMethodList;
	/**
	 * Var string
	 */
	public $manufacturerTaxId;
	/**
	 * Var string
	 */
	public $scheduleBNumber;
	/**
	 * Var integer
	 */
	public $scheduleBQuantity;
	/**
	 * Var \NetSuite\Classes\ScheduleBCode
	 */
	public $scheduleBCode;
	/**
	 * Var string
	 */
	public $manufacturerTariff;
	/**
	 * Var \NetSuite\Classes\ItemPreferenceCriterion
	 */
	public $preferenceCriterion;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipPackage;
	/**
	 * Var boolean
	 */
	public $shipIndividually;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $softDescriptor;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $costCategory;
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
	 * Var \NetSuite\Classes\ItemCostEstimateType
	 */
	public $costEstimateType;
	/**
	 * Var float
	 */
	public $costEstimate;
	/**
	 * Var float
	 */
	public $transferPrice;
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
	public $preferredLocation;
	/**
	 * Var boolean
	 */
	public $isStorePickupAllowed;
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
	 * Var float
	 */
	public $cost;
	/**
	 * Var string
	 */
	public $costUnits;
	/**
	 * Var string
	 */
	public $quantityReorderUnits;
	/**
	 * Var integer
	 */
	public $reorderMultiple;
	/**
	 * Var float
	 */
	public $totalValue;
	/**
	 * Var boolean
	 */
	public $useBins;
	/**
	 * Var integer
	 */
	public $leadTime;
	/**
	 * Var boolean
	 */
	public $autoLeadTime;
	/**
	 * Var boolean
	 */
	public $autoReorderPoint;
	/**
	 * Var boolean
	 */
	public $autoPreferredStockLevel;
	/**
	 * Var float
	 */
	public $preferredStockLevelDays;
	/**
	 * Var float
	 */
	public $averageCost;
	/**
	 * Var float
	 */
	public $safetyStockLevel;
	/**
	 * Var float
	 */
	public $lastPurchasePrice;
	/**
	 * Var integer
	 */
	public $safetyStockLevelDays;
	/**
	 * Var integer
	 */
	public $backwardConsumptionDays;
	/**
	 * Var boolean
	 */
	public $seasonalDemand;
	/**
	 * Var float
	 */
	public $demandModifier;
	/**
	 * Var string
	 */
	public $storeDisplayName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $storeDisplayThumbnail;
	/**
	 * Var \NetSuite\Classes\ItemWeightUnit
	 */
	public $weightUnit;
	/**
	 * Var string
	 */
	public $weightUnits;
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
	 * Var string
	 */
	public $shoppingDotComCategory;
	/**
	 * Var integer
	 */
	public $shopzillaCategoryId;
	/**
	 * Var string
	 */
	public $nexTagCategory;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var string
	 */
	public $quantityOnHandUnits;
	/**
	 * Var float
	 */
	public $onHandValueMli;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var float
	 */
	public $reorderPoint;
	/**
	 * Var float
	 */
	public $preferredStockLevel;
	/**
	 * Var string
	 */
	public $reorderPointUnits;
	/**
	 * Var float
	 */
	public $defaultReturnCost;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supplyReplenishmentMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $alternateDemandSourceItem;
	/**
	 * Var float
	 */
	public $fixedLotSize;
	/**
	 * Var \NetSuite\Classes\PeriodicLotSizeType
	 */
	public $periodicLotSizeType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supplyType;
	/**
	 * Var integer
	 */
	public $demandTimeFence;
	/**
	 * Var integer
	 */
	public $supplyTimeFence;
	/**
	 * Var integer
	 */
	public $rescheduleInDays;
	/**
	 * Var integer
	 */
	public $rescheduleOutDays;
	/**
	 * Var integer
	 */
	public $periodicLotSizeDays;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supplyLotSizingMethod;
	/**
	 * Var integer
	 */
	public $forwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $demandSource;
	/**
	 * Var float
	 */
	public $quantityOnOrder;
	/**
	 * Var string
	 */
	public $preferredStockLevelUnits;
	/**
	 * Var float
	 */
	public $quantityCommitted;
	/**
	 * Var float
	 */
	public $quantityAvailable;
	/**
	 * Var float
	 */
	public $quantityBackOrdered;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseTaxCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchasePriceVarianceAcct;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesTaxCode;
	/**
	 * Var boolean
	 */
	public $onSpecial;
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
	 * Var string
	 */
	public $specialsDescription;
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
	public $featuredDescription;
	/**
	 * Var \NetSuite\Classes\ProductFeedList
	 */
	public $productFeedList;
	/**
	 * Var string
	 */
	public $urlComponent;
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
	 * Var \NetSuite\Classes\SerializedInventoryItemHierarchyVersionsList
	 */
	public $hierarchyVersionsList;
	/**
	 * Var \NetSuite\Classes\ItemAccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $itemNumberOptionsList;
	/**
	 * Var \NetSuite\Classes\SerializedInventoryItemNumbersList
	 */
	public $numbersList;
	/**
	 * Var \NetSuite\Classes\InventoryItemBinNumberList
	 */
	public $binNumberList;
	/**
	 * Var \NetSuite\Classes\SiteCategoryList
	 */
	public $siteCategoryList;
	/**
	 * Var \NetSuite\Classes\SerializedInventoryItemLocationsList
	 */
	public $locationsList;
	/**
	 * Var \NetSuite\Classes\TranslationList
	 */
	public $translationsList;
	/**
	 * Var \NetSuite\Classes\PresentationItemList
	 */
	public $presentationItemList;
	/**
	 * Var integer
	 */
	public $futureHorizon;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $consumptionUnit;
	/**
	 * Var boolean
	 */
	public $enableCatchWeight;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $secondaryUnitsType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $secondaryBaseUnit;
	/**
	 * Var float
	 */
	public $conversionRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $secondaryStockUnit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $secondarySaleUnit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $secondaryPurchaseUnit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $secondaryConsumptionUnit;
	/**
	 * Var float
	 */
	public $lowerWarningLimit;
	/**
	 * Var float
	 */
	public $upperWarningLimit;
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
		'customForm' => 'RecordRef',
		'itemId' => 'string',
		'upcCode' => 'string',
		'displayName' => 'string',
		'matrixType' => 'ItemMatrixType',
		'includeChildren' => 'boolean',
		'vendorName' => 'string',
		'parent' => 'RecordRef',
		'isOnline' => 'boolean',
		'isHazmatItem' => 'boolean',
		'hazmatId' => 'string',
		'hazmatShippingName' => 'string',
		'hazmatHazardClass' => 'string',
		'hazmatPackingGroup' => 'HazmatPackingGroup',
		'hazmatItemUnits' => 'string',
		'hazmatItemUnitsQty' => 'float',
		'isGcoCompliant' => 'boolean',
		'offerSupport' => 'boolean',
		'isInactive' => 'boolean',
		'availableToPartners' => 'boolean',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'costingMethod' => 'ItemCostingMethod',
		'subsidiaryList' => 'RecordRefList',
		'purchaseDescription' => 'string',
		'copyDescription' => 'boolean',
		'issueProduct' => 'RecordRef',
		'currency' => 'string',
		'cogsAccount' => 'RecordRef',
		'intercoCogsAccount' => 'RecordRef',
		'vendor' => 'RecordRef',
		'salesDescription' => 'string',
		'lastInvtCountDate' => 'dateTime',
		'nextInvtCountDate' => 'dateTime',
		'invtCountInterval' => 'integer',
		'invtClassification' => 'ItemInvtClassification',
		'incomeAccount' => 'RecordRef',
		'intercoIncomeAccount' => 'RecordRef',
		'isTaxable' => 'boolean',
		'taxSchedule' => 'RecordRef',
		'dropshipExpenseAccount' => 'RecordRef',
		'revenueRecognitionRule' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'revenueAllocationGroup' => 'RecordRef',
		'createRevenuePlansOn' => 'RecordRef',
		'directRevenuePosting' => 'boolean',
		'assetAccount' => 'RecordRef',
		'matchBillToReceipt' => 'boolean',
		'billQtyVarianceAcct' => 'RecordRef',
		'billPriceVarianceAcct' => 'RecordRef',
		'billExchRateVarianceAcct' => 'RecordRef',
		'gainLossAccount' => 'RecordRef',
		'shippingCost' => 'float',
		'handlingCost' => 'float',
		'weight' => 'float',
		'costingMethodDisplay' => 'string',
		'shippingCostUnits' => 'string',
		'handlingCostUnits' => 'string',
		'unitsType' => 'RecordRef',
		'stockUnit' => 'RecordRef',
		'purchaseUnit' => 'RecordRef',
		'saleUnit' => 'RecordRef',
		'minimumQuantityUnits' => 'string',
		'safetyStockLevelUnits' => 'string',
		'billingSchedule' => 'RecordRef',
		'trackLandedCost' => 'boolean',
		'matrixItemNameTemplate' => 'string',
		'isDropShipItem' => 'boolean',
		'isSpecialOrderItem' => 'boolean',
		'stockDescription' => 'string',
		'deferredRevenueAccount' => 'RecordRef',
		'producer' => 'boolean',
		'manufacturer' => 'string',
		'revRecSchedule' => 'RecordRef',
		'mpn' => 'string',
		'multManufactureAddr' => 'boolean',
		'manufacturerAddr1' => 'string',
		'manufacturerCity' => 'string',
		'manufacturerState' => 'string',
		'manufacturerZip' => 'string',
		'countryOfManufacture' => 'Country',
		'defaultItemShipMethod' => 'RecordRef',
		'itemCarrier' => 'ShippingCarrier',
		'roundUpAsComponent' => 'boolean',
		'purchaseOrderQuantity' => 'float',
		'purchaseOrderAmount' => 'float',
		'purchaseOrderQuantityDiff' => 'float',
		'receiptQuantity' => 'float',
		'receiptAmount' => 'float',
		'receiptQuantityDiff' => 'float',
		'itemShipMethodList' => 'RecordRefList',
		'manufacturerTaxId' => 'string',
		'scheduleBNumber' => 'string',
		'scheduleBQuantity' => 'integer',
		'scheduleBCode' => 'ScheduleBCode',
		'manufacturerTariff' => 'string',
		'preferenceCriterion' => 'ItemPreferenceCriterion',
		'minimumQuantity' => 'integer',
		'enforceMinQtyInternally' => 'boolean',
		'maximumQuantity' => 'integer',
		'shipPackage' => 'RecordRef',
		'shipIndividually' => 'boolean',
		'softDescriptor' => 'RecordRef',
		'costCategory' => 'RecordRef',
		'pricesIncludeTax' => 'boolean',
		'quantityPricingSchedule' => 'RecordRef',
		'useMarginalRates' => 'boolean',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'transferPrice' => 'float',
		'overallQuantityPricingType' => 'ItemOverallQuantityPricingType',
		'pricingGroup' => 'RecordRef',
		'preferredLocation' => 'RecordRef',
		'isStorePickupAllowed' => 'boolean',
		'vsoePrice' => 'float',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'itemRevenueCategory' => 'RecordRef',
		'cost' => 'float',
		'costUnits' => 'string',
		'quantityReorderUnits' => 'string',
		'reorderMultiple' => 'integer',
		'totalValue' => 'float',
		'useBins' => 'boolean',
		'leadTime' => 'integer',
		'autoLeadTime' => 'boolean',
		'autoReorderPoint' => 'boolean',
		'autoPreferredStockLevel' => 'boolean',
		'preferredStockLevelDays' => 'float',
		'averageCost' => 'float',
		'safetyStockLevel' => 'float',
		'lastPurchasePrice' => 'float',
		'safetyStockLevelDays' => 'integer',
		'backwardConsumptionDays' => 'integer',
		'seasonalDemand' => 'boolean',
		'demandModifier' => 'float',
		'storeDisplayName' => 'string',
		'storeDisplayThumbnail' => 'RecordRef',
		'weightUnit' => 'ItemWeightUnit',
		'weightUnits' => 'string',
		'storeDisplayImage' => 'RecordRef',
		'storeDescription' => 'string',
		'storeDetailedDescription' => 'string',
		'storeItemTemplate' => 'RecordRef',
		'pageTitle' => 'string',
		'metaTagHtml' => 'string',
		'excludeFromSitemap' => 'boolean',
		'sitemapPriority' => 'SitemapPriority',
		'searchKeywords' => 'string',
		'isDonationItem' => 'boolean',
		'showDefaultDonationAmount' => 'boolean',
		'maxDonationAmount' => 'float',
		'shoppingDotComCategory' => 'string',
		'shopzillaCategoryId' => 'integer',
		'nexTagCategory' => 'string',
		'quantityOnHand' => 'float',
		'quantityOnHandUnits' => 'string',
		'onHandValueMli' => 'float',
		'serialNumbers' => 'string',
		'reorderPoint' => 'float',
		'preferredStockLevel' => 'float',
		'reorderPointUnits' => 'string',
		'defaultReturnCost' => 'float',
		'supplyReplenishmentMethod' => 'RecordRef',
		'alternateDemandSourceItem' => 'RecordRef',
		'fixedLotSize' => 'float',
		'periodicLotSizeType' => 'PeriodicLotSizeType',
		'supplyType' => 'RecordRef',
		'demandTimeFence' => 'integer',
		'supplyTimeFence' => 'integer',
		'rescheduleInDays' => 'integer',
		'rescheduleOutDays' => 'integer',
		'periodicLotSizeDays' => 'integer',
		'supplyLotSizingMethod' => 'RecordRef',
		'forwardConsumptionDays' => 'integer',
		'demandSource' => 'RecordRef',
		'quantityOnOrder' => 'float',
		'preferredStockLevelUnits' => 'string',
		'quantityCommitted' => 'float',
		'quantityAvailable' => 'float',
		'quantityBackOrdered' => 'float',
		'purchaseTaxCode' => 'RecordRef',
		'purchasePriceVarianceAcct' => 'RecordRef',
		'rate' => 'float',
		'salesTaxCode' => 'RecordRef',
		'onSpecial' => 'boolean',
		'dontShowPrice' => 'boolean',
		'noPriceMessage' => 'string',
		'outOfStockMessage' => 'string',
		'specialsDescription' => 'string',
		'outOfStockBehavior' => 'ItemOutOfStockBehavior',
		'relatedItemsDescription' => 'string',
		'featuredDescription' => 'string',
		'productFeedList' => 'ProductFeedList',
		'urlComponent' => 'string',
		'itemOptionsList' => 'ItemOptionsList',
		'matrixOptionList' => 'MatrixOptionList',
		'itemVendorList' => 'ItemVendorList',
		'pricingMatrix' => 'PricingMatrix',
		'hierarchyVersionsList' => 'SerializedInventoryItemHierarchyVersionsList',
		'accountingBookDetailList' => 'ItemAccountingBookDetailList',
		'itemNumberOptionsList' => 'RecordRefList',
		'numbersList' => 'SerializedInventoryItemNumbersList',
		'binNumberList' => 'InventoryItemBinNumberList',
		'siteCategoryList' => 'SiteCategoryList',
		'locationsList' => 'SerializedInventoryItemLocationsList',
		'translationsList' => 'TranslationList',
		'presentationItemList' => 'PresentationItemList',
		'futureHorizon' => 'integer',
		'consumptionUnit' => 'RecordRef',
		'enableCatchWeight' => 'boolean',
		'secondaryUnitsType' => 'RecordRef',
		'secondaryBaseUnit' => 'RecordRef',
		'conversionRate' => 'float',
		'secondaryStockUnit' => 'RecordRef',
		'secondarySaleUnit' => 'RecordRef',
		'secondaryPurchaseUnit' => 'RecordRef',
		'secondaryConsumptionUnit' => 'RecordRef',
		'lowerWarningLimit' => 'float',
		'upperWarningLimit' => 'float',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
