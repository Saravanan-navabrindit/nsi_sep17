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

class SerializedAssemblyItem extends Record {
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
	public $printItems;
	/**
	 * Var boolean
	 */
	public $isOnline;
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
	public $useComponentYield;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var boolean
	 */
	public $availableToPartners;
	/**
	 * Var boolean
	 */
	public $includeChildren;
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
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $cogsAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $vendor;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesTaxCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $costCategory;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseTaxCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $prodQtyVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $prodPriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchasePriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $wipVarianceAcct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxSchedule;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $scrapAcct;
	/**
	 * Var float
	 */
	public $shippingCost;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $wipAcct;
	/**
	 * Var string
	 */
	public $shippingCostUnits;
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
	public $handlingCostUnits;
	/**
	 * Var \NetSuite\Classes\ItemWeightUnit
	 */
	public $weightUnit;
	/**
	 * Var string
	 */
	public $weightUnits;
	/**
	 * Var \NetSuite\Classes\ItemCostingMethod
	 */
	public $costingMethod;
	/**
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var string
	 */
	public $costingMethodDisplay;
	/**
	 * Var float
	 */
	public $rate;
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
	 * Var boolean
	 */
	public $trackLandedCost;
	/**
	 * Var string
	 */
	public $matrixItemNameTemplate;
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
	 * Var string
	 */
	public $stockDescription;
	/**
	 * Var boolean
	 */
	public $producer;
	/**
	 * Var string
	 */
	public $manufacturer;
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
	public $manufactureraddr1;
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
	 * Var \NetSuite\Classes\AssemblyItemEffectiveBomControl
	 */
	public $effectiveBomControl;
	/**
	 * Var string
	 */
	public $minimumQuantityUnits;
	/**
	 * Var string
	 */
	public $defaultRevision;
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
	 * Var boolean
	 */
	public $isDropShipItem;
	/**
	 * Var boolean
	 */
	public $isPhantom;
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
	 * Var \NetSuite\Classes\RecordRef
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $issueProduct;
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
	public $softDescriptor;
	/**
	 * Var boolean
	 */
	public $isSpecialWorkOrderItem;
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
	public $buildEntireAssembly;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var string
	 */
	public $quantityOnHandUnits;
	/**
	 * Var boolean
	 */
	public $useMarginalRates;
	/**
	 * Var integer
	 */
	public $reorderMultiple;
	/**
	 * Var float
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\ItemCostEstimateType
	 */
	public $costEstimateType;
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
	public $intercoCogsAccount;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $unbuildVarianceAccount;
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
	public $dropshipExpenseAccount;
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
	public $totalValue;
	/**
	 * Var boolean
	 */
	public $useBins;
	/**
	 * Var float
	 */
	public $averageCost;
	/**
	 * Var float
	 */
	public $lastPurchasePrice;
	/**
	 * Var string
	 */
	public $purchaseDescription;
	/**
	 * Var integer
	 */
	public $leadTime;
	/**
	 * Var boolean
	 */
	public $autoLeadTime;
	/**
	 * Var integer
	 */
	public $buildTime;
	/**
	 * Var float
	 */
	public $safetyStockLevel;
	/**
	 * Var string
	 */
	public $safetyStockLevelUnits;
	/**
	 * Var integer
	 */
	public $safetyStockLevelDays;
	/**
	 * Var boolean
	 */
	public $seasonalDemand;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var float
	 */
	public $reorderPoint;
	/**
	 * Var string
	 */
	public $reorderPointUnits;
	/**
	 * Var float
	 */
	public $preferredStockLevel;
	/**
	 * Var string
	 */
	public $preferredStockLevelUnits;
	/**
	 * Var float
	 */
	public $demandModifier;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supplyLotSizingMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $demandSource;
	/**
	 * Var boolean
	 */
	public $shipIndividually;
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
	 * Var float
	 */
	public $quantityOnOrder;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipPackage;
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
	public $urlComponent;
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
	public $shoppingDotComCategory;
	/**
	 * Var integer
	 */
	public $shopzillaCategoryId;
	/**
	 * Var string
	 */
	public $outOfStockMessage;
	/**
	 * Var string
	 */
	public $nexTagCategory;
	/**
	 * Var \NetSuite\Classes\ItemOutOfStockBehavior
	 */
	public $outOfStockBehavior;
	/**
	 * Var \NetSuite\Classes\ProductFeedList
	 */
	public $productFeedList;
	/**
	 * Var string
	 */
	public $relatedItemsDescription;
	/**
	 * Var boolean
	 */
	public $onSpecial;
	/**
	 * Var string
	 */
	public $specialsDescription;
	/**
	 * Var string
	 */
	public $featuredDescription;
	/**
	 * Var \NetSuite\Classes\ItemOptionsList
	 */
	public $itemOptionsList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $itemNumberOptionsList;
	/**
	 * Var \NetSuite\Classes\ItemVendorList
	 */
	public $itemVendorList;
	/**
	 * Var \NetSuite\Classes\PricingMatrix
	 */
	public $pricingMatrix;
	/**
	 * Var \NetSuite\Classes\SerializedAssemblyItemBillOfMaterialsList
	 */
	public $billOfMaterialsList;
	/**
	 * Var \NetSuite\Classes\ItemMemberList
	 */
	public $memberList;
	/**
	 * Var \NetSuite\Classes\ItemAccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\SerializedInventoryItemLocationsList
	 */
	public $locationsList;
	/**
	 * Var \NetSuite\Classes\SiteCategoryList
	 */
	public $siteCategoryList;
	/**
	 * Var \NetSuite\Classes\InventoryItemBinNumberList
	 */
	public $binNumberList;
	/**
	 * Var \NetSuite\Classes\SerializedInventoryItemNumbersList
	 */
	public $numbersList;
	/**
	 * Var \NetSuite\Classes\TranslationList
	 */
	public $translationsList;
	/**
	 * Var \NetSuite\Classes\PresentationItemList
	 */
	public $presentationItemList;
	/**
	 * Var \NetSuite\Classes\SerializedAssemblyItemHierarchyVersionsList
	 */
	public $hierarchyVersionsList;
	/**
	 * Var integer
	 */
	public $futureHorizon;
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
		'customForm' => 'RecordRef',
		'itemId' => 'string',
		'upcCode' => 'string',
		'displayName' => 'string',
		'vendorName' => 'string',
		'parent' => 'RecordRef',
		'printItems' => 'boolean',
		'isOnline' => 'boolean',
		'lastInvtCountDate' => 'dateTime',
		'nextInvtCountDate' => 'dateTime',
		'invtCountInterval' => 'integer',
		'invtClassification' => 'ItemInvtClassification',
		'isGcoCompliant' => 'boolean',
		'offerSupport' => 'boolean',
		'useComponentYield' => 'boolean',
		'isInactive' => 'boolean',
		'subsidiaryList' => 'RecordRefList',
		'availableToPartners' => 'boolean',
		'includeChildren' => 'boolean',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'description' => 'string',
		'cogsAccount' => 'RecordRef',
		'vendor' => 'RecordRef',
		'incomeAccount' => 'RecordRef',
		'intercoIncomeAccount' => 'RecordRef',
		'assetAccount' => 'RecordRef',
		'matchBillToReceipt' => 'boolean',
		'billQtyVarianceAcct' => 'RecordRef',
		'billPriceVarianceAcct' => 'RecordRef',
		'billExchRateVarianceAcct' => 'RecordRef',
		'gainLossAccount' => 'RecordRef',
		'salesTaxCode' => 'RecordRef',
		'costCategory' => 'RecordRef',
		'purchaseTaxCode' => 'RecordRef',
		'prodQtyVarianceAcct' => 'RecordRef',
		'prodPriceVarianceAcct' => 'RecordRef',
		'purchasePriceVarianceAcct' => 'RecordRef',
		'wipVarianceAcct' => 'RecordRef',
		'taxSchedule' => 'RecordRef',
		'scrapAcct' => 'RecordRef',
		'shippingCost' => 'float',
		'wipAcct' => 'RecordRef',
		'shippingCostUnits' => 'string',
		'handlingCost' => 'float',
		'weight' => 'float',
		'handlingCostUnits' => 'string',
		'weightUnit' => 'ItemWeightUnit',
		'weightUnits' => 'string',
		'costingMethod' => 'ItemCostingMethod',
		'isTaxable' => 'boolean',
		'costingMethodDisplay' => 'string',
		'rate' => 'float',
		'unitsType' => 'RecordRef',
		'stockUnit' => 'RecordRef',
		'purchaseUnit' => 'RecordRef',
		'saleUnit' => 'RecordRef',
		'trackLandedCost' => 'boolean',
		'matrixItemNameTemplate' => 'string',
		'billingSchedule' => 'RecordRef',
		'deferredRevenueAccount' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'stockDescription' => 'string',
		'producer' => 'boolean',
		'manufacturer' => 'string',
		'mpn' => 'string',
		'multManufactureAddr' => 'boolean',
		'manufactureraddr1' => 'string',
		'manufacturerCity' => 'string',
		'manufacturerState' => 'string',
		'manufacturerZip' => 'string',
		'countryOfManufacture' => 'Country',
		'effectiveBomControl' => 'AssemblyItemEffectiveBomControl',
		'minimumQuantityUnits' => 'string',
		'defaultRevision' => 'string',
		'defaultItemShipMethod' => 'RecordRef',
		'itemCarrier' => 'ShippingCarrier',
		'roundUpAsComponent' => 'boolean',
		'purchaseOrderQuantity' => 'float',
		'purchaseOrderAmount' => 'float',
		'purchaseOrderQuantityDiff' => 'float',
		'receiptQuantity' => 'float',
		'receiptAmount' => 'float',
		'receiptQuantityDiff' => 'float',
		'isDropShipItem' => 'boolean',
		'isPhantom' => 'boolean',
		'itemShipMethodList' => 'RecordRefList',
		'manufacturerTaxId' => 'string',
		'scheduleBNumber' => 'string',
		'scheduleBQuantity' => 'integer',
		'scheduleBCode' => 'RecordRef',
		'manufacturerTariff' => 'string',
		'preferenceCriterion' => 'ItemPreferenceCriterion',
		'issueProduct' => 'RecordRef',
		'minimumQuantity' => 'integer',
		'enforceMinQtyInternally' => 'boolean',
		'maximumQuantity' => 'integer',
		'softDescriptor' => 'RecordRef',
		'isSpecialWorkOrderItem' => 'boolean',
		'pricesIncludeTax' => 'boolean',
		'quantityPricingSchedule' => 'RecordRef',
		'buildEntireAssembly' => 'boolean',
		'quantityOnHand' => 'float',
		'quantityOnHandUnits' => 'string',
		'useMarginalRates' => 'boolean',
		'reorderMultiple' => 'integer',
		'cost' => 'float',
		'costEstimateType' => 'ItemCostEstimateType',
		'isHazmatItem' => 'boolean',
		'hazmatId' => 'string',
		'hazmatShippingName' => 'string',
		'hazmatHazardClass' => 'string',
		'hazmatPackingGroup' => 'HazmatPackingGroup',
		'hazmatItemUnits' => 'string',
		'hazmatItemUnitsQty' => 'float',
		'costEstimate' => 'float',
		'transferPrice' => 'float',
		'overallQuantityPricingType' => 'ItemOverallQuantityPricingType',
		'pricingGroup' => 'RecordRef',
		'intercoCogsAccount' => 'RecordRef',
		'vsoePrice' => 'float',
		'vsoeSopGroup' => 'VsoeSopGroup',
		'vsoeDeferral' => 'VsoeDeferral',
		'vsoePermitDiscount' => 'VsoePermitDiscount',
		'vsoeDelivered' => 'boolean',
		'itemRevenueCategory' => 'RecordRef',
		'unbuildVarianceAccount' => 'RecordRef',
		'revenueRecognitionRule' => 'RecordRef',
		'revRecForecastRule' => 'RecordRef',
		'revenueAllocationGroup' => 'RecordRef',
		'createRevenuePlansOn' => 'RecordRef',
		'directRevenuePosting' => 'boolean',
		'dropshipExpenseAccount' => 'RecordRef',
		'preferredLocation' => 'RecordRef',
		'isStorePickupAllowed' => 'boolean',
		'totalValue' => 'float',
		'useBins' => 'boolean',
		'averageCost' => 'float',
		'lastPurchasePrice' => 'float',
		'purchaseDescription' => 'string',
		'leadTime' => 'integer',
		'autoLeadTime' => 'boolean',
		'buildTime' => 'integer',
		'safetyStockLevel' => 'float',
		'safetyStockLevelUnits' => 'string',
		'safetyStockLevelDays' => 'integer',
		'seasonalDemand' => 'boolean',
		'serialNumbers' => 'string',
		'reorderPoint' => 'float',
		'reorderPointUnits' => 'string',
		'preferredStockLevel' => 'float',
		'preferredStockLevelUnits' => 'string',
		'demandModifier' => 'float',
		'autoReorderPoint' => 'boolean',
		'autoPreferredStockLevel' => 'boolean',
		'preferredStockLevelDays' => 'float',
		'defaultReturnCost' => 'float',
		'supplyReplenishmentMethod' => 'RecordRef',
		'alternateDemandSourceItem' => 'RecordRef',
		'fixedLotSize' => 'float',
		'supplyType' => 'RecordRef',
		'demandTimeFence' => 'integer',
		'supplyTimeFence' => 'integer',
		'rescheduleInDays' => 'integer',
		'rescheduleOutDays' => 'integer',
		'supplyLotSizingMethod' => 'RecordRef',
		'demandSource' => 'RecordRef',
		'shipIndividually' => 'boolean',
		'quantityCommitted' => 'float',
		'quantityAvailable' => 'float',
		'quantityBackOrdered' => 'float',
		'quantityOnOrder' => 'float',
		'shipPackage' => 'RecordRef',
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
		'urlComponent' => 'string',
		'searchKeywords' => 'string',
		'isDonationItem' => 'boolean',
		'showDefaultDonationAmount' => 'boolean',
		'maxDonationAmount' => 'float',
		'dontShowPrice' => 'boolean',
		'noPriceMessage' => 'string',
		'shoppingDotComCategory' => 'string',
		'shopzillaCategoryId' => 'integer',
		'outOfStockMessage' => 'string',
		'nexTagCategory' => 'string',
		'outOfStockBehavior' => 'ItemOutOfStockBehavior',
		'productFeedList' => 'ProductFeedList',
		'relatedItemsDescription' => 'string',
		'onSpecial' => 'boolean',
		'specialsDescription' => 'string',
		'featuredDescription' => 'string',
		'itemOptionsList' => 'ItemOptionsList',
		'itemNumberOptionsList' => 'RecordRefList',
		'itemVendorList' => 'ItemVendorList',
		'pricingMatrix' => 'PricingMatrix',
		'billOfMaterialsList' => 'SerializedAssemblyItemBillOfMaterialsList',
		'memberList' => 'ItemMemberList',
		'accountingBookDetailList' => 'ItemAccountingBookDetailList',
		'locationsList' => 'SerializedInventoryItemLocationsList',
		'siteCategoryList' => 'SiteCategoryList',
		'binNumberList' => 'InventoryItemBinNumberList',
		'numbersList' => 'SerializedInventoryItemNumbersList',
		'translationsList' => 'TranslationList',
		'presentationItemList' => 'PresentationItemList',
		'hierarchyVersionsList' => 'SerializedAssemblyItemHierarchyVersionsList',
		'futureHorizon' => 'integer',
		'consumptionUnit' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
