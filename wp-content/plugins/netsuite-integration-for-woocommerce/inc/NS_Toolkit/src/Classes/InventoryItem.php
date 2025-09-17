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

class InventoryItem extends Record {
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
	public $copyDescription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expenseAccount;
	/**
	 * Var string
	 */
	public $dateConvertedToInv;
	/**
	 * Var \NetSuite\Classes\ItemType
	 */
	public $originalItemType;
	/**
	 * Var \NetSuite\Classes\ItemSubType
	 */
	public $originalItemSubtype;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $cogsAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoCogsAccount;
	/**
	 * Var string
	 */
	public $salesDescription;
	/**
	 * Var \NetSuite\Classes\InventoryItemFraudRisk
	 */
	public $fraudRisk;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxSchedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $dropshipExpenseAccount;
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
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\ItemMatrixType
	 */
	public $matrixType;
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
	 * Var string
	 */
	public $shippingCostUnits;
	/**
	 * Var float
	 */
	public $handlingCost;
	/**
	 * Var string
	 */
	public $handlingCostUnits;
	/**
	 * Var float
	 */
	public $weight;
	/**
	 * Var \NetSuite\Classes\ItemWeightUnit
	 */
	public $weightUnit;
	/**
	 * Var string
	 */
	public $weightUnits;
	/**
	 * Var string
	 */
	public $costingMethodDisplay;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueProduct;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoDefRevAccount;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $defaultItemShipMethod;
	/**
	 * Var \NetSuite\Classes\ShippingCarrier
	 */
	public $itemCarrier;
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
	 * Var string
	 */
	public $minimumQuantityUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $softDescriptor;
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
	public $costCategory;
	/**
	 * Var boolean
	 */
	public $pricesIncludeTax;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchasePriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $quantityPricingSchedule;
	/**
	 * Var string
	 */
	public $reorderPointUnits;
	/**
	 * Var boolean
	 */
	public $useMarginalRates;
	/**
	 * Var string
	 */
	public $preferredStockLevelUnits;
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
	 * Var float
	 */
	public $vsoePrice;
	/**
	 * Var \NetSuite\Classes\VsoeSopGroup
	 */
	public $vsoeSopGroup;
	/**
	 * Var string
	 */
	public $costEstimateUnits;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $preferredLocation;
	/**
	 * Var boolean
	 */
	public $isStorePickupAllowed;
	/**
	 * Var integer
	 */
	public $reorderMultiple;
	/**
	 * Var float
	 */
	public $cost;
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
	 * Var string
	 */
	public $costUnits;
	/**
	 * Var float
	 */
	public $totalValue;
	/**
	 * Var float
	 */
	public $averageCost;
	/**
	 * Var boolean
	 */
	public $useBins;
	/**
	 * Var string
	 */
	public $quantityReorderUnits;
	/**
	 * Var integer
	 */
	public $leadTime;
	/**
	 * Var boolean
	 */
	public $autoLeadTime;
	/**
	 * Var float
	 */
	public $lastPurchasePrice;
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
	public $safetyStockLevel;
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
	 * Var string
	 */
	public $safetyStockLevelUnits;
	/**
	 * Var float
	 */
	public $demandModifier;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $distributionNetwork;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $distributionCategory;
	/**
	 * Var boolean
	 */
	public $autoReorderPoint;
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
	 * Var string
	 */
	public $featuredDescription;
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
	 * Var string
	 */
	public $urlComponent;
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
	 * Var string
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $preferredStockLevel;
	/**
	 * Var \NetSuite\Classes\PricingMatrix
	 */
	public $pricingMatrix;
	/**
	 * Var \NetSuite\Classes\InventoryItemHierarchyVersionsList
	 */
	public $hierarchyVersionsList;
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
	public $quantityBackOrdered;
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
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $onHandValueMli;
	/**
	 * Var float
	 */
	public $quantityOnOrder;
	/**
	 * Var float
	 */
	public $rate;
	/**
	 * Var float
	 */
	public $reorderPoint;
	/**
	 * Var string
	 */
	public $quantityCommittedUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesTaxCode;
	/**
	 * Var string
	 */
	public $quantityAvailableUnits;
	/**
	 * Var string
	 */
	public $quantityOnHandUnits;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $vendor;
	/**
	 * Var string
	 */
	public $quantityOnOrderUnits;
	/**
	 * Var \NetSuite\Classes\ProductFeedList
	 */
	public $productFeedList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var \NetSuite\Classes\ItemOptionsList
	 */
	public $itemOptionsList;
	/**
	 * Var \NetSuite\Classes\ItemVendorList
	 */
	public $itemVendorList;
	/**
	 * Var \NetSuite\Classes\SiteCategoryList
	 */
	public $siteCategoryList;
	/**
	 * Var \NetSuite\Classes\TranslationList
	 */
	public $translationsList;
	/**
	 * Var \NetSuite\Classes\InventoryItemBinNumberList
	 */
	public $binNumberList;
	/**
	 * Var \NetSuite\Classes\InventoryItemLocationsList
	 */
	public $locationsList;
	/**
	 * Var \NetSuite\Classes\MatrixOptionList
	 */
	public $matrixOptionList;
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
		'purchaseDescription' => 'string',
		'copyDescription' => 'boolean',
		'expenseAccount' => 'RecordRef',
		'dateConvertedToInv' => 'dateTime',
		'originalItemType' => 'ItemType',
		'originalItemSubtype' => 'ItemSubType',
		'cogsAccount' => 'RecordRef',
		'intercoCogsAccount' => 'RecordRef',
		'salesDescription' => 'string',
		'fraudRisk' => 'InventoryItemFraudRisk',
		'includeChildren' => 'boolean',
		'incomeAccount' => 'RecordRef',
		'intercoIncomeAccount' => 'RecordRef',
		'taxSchedule' => 'RecordRef',
		'dropshipExpenseAccount' => 'RecordRef',
		'deferRevRec' => 'boolean',
		'revenueRecognitionRule' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'revenueAllocationGroup' => 'RecordRef',
		'createRevenuePlansOn' => 'RecordRef',
		'directRevenuePosting' => 'boolean',
		'contingentRevenueHandling' => 'boolean',
		'revReclassFXAccount' => 'RecordRef',
		'isTaxable' => 'boolean',
		'matrixType' => 'ItemMatrixType',
		'assetAccount' => 'RecordRef',
		'matchBillToReceipt' => 'boolean',
		'billQtyVarianceAcct' => 'RecordRef',
		'billPriceVarianceAcct' => 'RecordRef',
		'billExchRateVarianceAcct' => 'RecordRef',
		'gainLossAccount' => 'RecordRef',
		'shippingCost' => 'float',
		'shippingCostUnits' => 'string',
		'handlingCost' => 'float',
		'handlingCostUnits' => 'string',
		'weight' => 'float',
		'weightUnit' => 'ItemWeightUnit',
		'weightUnits' => 'string',
		'costingMethodDisplay' => 'string',
		'unitsType' => 'RecordRef',
		'stockUnit' => 'RecordRef',
		'purchaseUnit' => 'RecordRef',
		'saleUnit' => 'RecordRef',
		'issueProduct' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'trackLandedCost' => 'boolean',
		'matrixItemNameTemplate' => 'string',
		'isDropShipItem' => 'boolean',
		'isSpecialOrderItem' => 'boolean',
		'stockDescription' => 'string',
		'deferredRevenueAccount' => 'RecordRef',
		'intercoDefRevAccount' => 'RecordRef',
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
		'roundUpAsComponent' => 'boolean',
		'purchaseOrderQuantity' => 'float',
		'purchaseOrderAmount' => 'float',
		'purchaseOrderQuantityDiff' => 'float',
		'receiptQuantity' => 'float',
		'receiptAmount' => 'float',
		'receiptQuantityDiff' => 'float',
		'defaultItemShipMethod' => 'RecordRef',
		'itemCarrier' => 'ShippingCarrier',
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
		'minimumQuantityUnits' => 'string',
		'softDescriptor' => 'RecordRef',
		'shipPackage' => 'RecordRef',
		'shipIndividually' => 'boolean',
		'costCategory' => 'RecordRef',
		'pricesIncludeTax' => 'boolean',
		'purchasePriceVarianceAcct' => 'RecordRef',
		'quantityPricingSchedule' => 'RecordRef',
		'reorderPointUnits' => 'string',
		'useMarginalRates' => 'boolean',
		'preferredStockLevelUnits' => 'string',
		'costEstimateType' => 'ItemCostEstimateType',
		'costEstimate' => 'float',
		'transferPrice' => 'float',
		'overallQuantityPricingType' => 'ItemOverallQuantityPricingType',
		'pricingGroup' => 'RecordRef',
		'vsoePrice' => 'float',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'costEstimateUnits' => 'string',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'itemRevenueCategory' => 'RecordRef',
		'preferredLocation' => 'RecordRef',
		'isStorePickupAllowed' => 'boolean',
		'reorderMultiple' => 'integer',
		'cost' => 'float',
		'lastInvtCountDate' => 'dateTime',
		'nextInvtCountDate' => 'dateTime',
		'invtCountInterval' => 'integer',
		'invtClassification' => 'ItemInvtClassification',
		'costUnits' => 'string',
		'totalValue' => 'float',
		'averageCost' => 'float',
		'useBins' => 'boolean',
		'quantityReorderUnits' => 'string',
		'leadTime' => 'integer',
		'autoLeadTime' => 'boolean',
		'lastPurchasePrice' => 'float',
		'autoPreferredStockLevel' => 'boolean',
		'preferredStockLevelDays' => 'float',
		'safetyStockLevel' => 'float',
		'safetyStockLevelDays' => 'integer',
		'backwardConsumptionDays' => 'integer',
		'seasonalDemand' => 'boolean',
		'safetyStockLevelUnits' => 'string',
		'demandModifier' => 'float',
		'distributionNetwork' => 'RecordRef',
		'distributionCategory' => 'RecordRef',
		'autoReorderPoint' => 'boolean',
		'storeDisplayName' => 'string',
		'storeDisplayThumbnail' => 'RecordRef',
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
		'dontShowPrice' => 'boolean',
		'noPriceMessage' => 'string',
		'outOfStockMessage' => 'string',
		'onSpecial' => 'boolean',
		'outOfStockBehavior' => 'ItemOutOfStockBehavior',
		'relatedItemsDescription' => 'string',
		'specialsDescription' => 'string',
		'featuredDescription' => 'string',
		'shoppingDotComCategory' => 'string',
		'shopzillaCategoryId' => 'integer',
		'nexTagCategory' => 'string',
		'urlComponent' => 'string',
		'customForm' => 'RecordRef',
		'itemId' => 'string',
		'upcCode' => 'string',
		'displayName' => 'string',
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
		'currency' => 'string',
		'preferredStockLevel' => 'float',
		'pricingMatrix' => 'PricingMatrix',
		'hierarchyVersionsList' => 'InventoryItemHierarchyVersionsList',
		'accountingBookDetailList' => 'ItemAccountingBookDetailList',
		'purchaseTaxCode' => 'RecordRef',
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
		'quantityBackOrdered' => 'float',
		'quantityCommitted' => 'float',
		'quantityAvailable' => 'float',
		'quantityOnHand' => 'float',
		'onHandValueMli' => 'float',
		'quantityOnOrder' => 'float',
		'rate' => 'float',
		'reorderPoint' => 'float',
		'quantityCommittedUnits' => 'string',
		'salesTaxCode' => 'RecordRef',
		'quantityAvailableUnits' => 'string',
		'quantityOnHandUnits' => 'string',
		'vendor' => 'RecordRef',
		'quantityOnOrderUnits' => 'string',
		'productFeedList' => 'ProductFeedList',
		'subsidiaryList' => 'RecordRefList',
		'itemOptionsList' => 'ItemOptionsList',
		'itemVendorList' => 'ItemVendorList',
		'siteCategoryList' => 'SiteCategoryList',
		'translationsList' => 'TranslationList',
		'binNumberList' => 'InventoryItemBinNumberList',
		'locationsList' => 'InventoryItemLocationsList',
		'matrixOptionList' => 'MatrixOptionList',
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
