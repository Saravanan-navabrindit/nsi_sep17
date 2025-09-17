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

class ItemSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accBookRevRecForecastRule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBookAmortization;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBookCreatePlansOn;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBookRevRecRule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $accountingBookRevRecSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $allowedShippingMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $alternateDemandSourceItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $assetAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $atpLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $atpMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $autoLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $autoPreferredStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $autoReorderPoint;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableToPartners;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $averageCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $backwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $basePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billExchRateVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billPriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billQtyVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $binNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $binOnHandAvail;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $binOnHandCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $buildEntireAssembly;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $buildTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $buyItNowPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $categoryPreferred;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $componentYield;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $consumptionUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $contingentRevenueHandling;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $conversionRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $copyDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $correlatedItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $correlatedItemCorrelation;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $correlatedItemCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $correlatedItemLift;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $correlatedItemPurchaseRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $costAccountingStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $costCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $costEstimateType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $costingMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $countryOfManufacture;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $created;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $createJob;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $createRevenuePlansOn;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $custReturnVarianceAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateViewed;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $daysBeforeExpiration;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $defaultReturnCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $defaultShippingMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $deferredExpenseAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $deferredRevenueAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $demandModifier;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $demandSource;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $demandTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $departmentnohierarchy;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $directRevenuePosting;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $displayIneBayStore;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $displayName;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $distributionCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $distributionNetwork;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $dontShowPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $eBayItemDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $eBayItemSubtitle;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $eBayItemTitle;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $ebayRelistingOption;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $effectiveBomControl;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $effectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $effectiveRevision;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $enableCatchWeight;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $endAuctionsWhenOutOfStock;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $excludeFromSitemap;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $expenseAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $featuredDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $feedDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $feedName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fixedLotSize;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $forwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $fraudRisk;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $froogleProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $futureHorizon;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $gainLossAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $generateAccruals;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertAuthCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertEmail;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertExpirationDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertFrom;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertMessage;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertOriginalAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCertRecipient;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $hierarchyNode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $hierarchyVersion;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $hits;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $imageUrl;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $incomeAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $intercoDefRevAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $intercoExpenseAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $intercoIncomeAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $inventoryLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $invtClassification;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $invtCountInterval;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isAvailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isDropShipItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isFulfillable;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isGcoCompliant;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isLotItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isOnline;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSerialItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSpecialOrderItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSpecialWorkOrderItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isStorePickupAllowed;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $issueProduct;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isWip;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $itemId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $itemRevenueCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $itemUrl;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $lastPurchasePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastQuantityAvailableChange;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $leadTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $liabilityAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $listingDuration;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $locationAllowStorePickup;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationAtpLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationAverageCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $locationBinQuantityAvailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationBuildTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationCostAccountingStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationDefaultReturnCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationDemandSource;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationDemandTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationFixedLotSize;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $locationInventoryCostTemplate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationInvtClassification;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationInvtCountInterval;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $locationLastInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $locationNextInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationPeriodicLotSizeDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationPeriodicLotSizeType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationPreferredStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQtyAvailForStorePickup;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQuantityAvailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQuantityBackOrdered;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQuantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQuantityInTransit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQuantityOnHand;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationQuantityOnOrder;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationReOrderPoint;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationRescheduleInDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationRescheduleOutDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationSafetyStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationStorePickupBufferStock;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationSupplyLotSizingMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locationSupplyTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $locationSupplyType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $locationTotalValue;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locBackwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $locForwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $lowerWarningLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturer;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturerAddr1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturerCity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturerState;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturerTariff;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturerTaxId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $manufacturerZip;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $manufacturingChargeItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $matchBillToReceipt;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $maximumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $memberItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $memberQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $metaTagHtml;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $minimumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $modified;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $mossApplies;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $mpn;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $multManufactureAddr;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $nextagCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $nextagProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $nextInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $noPriceMessage;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $numActiveListings;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $numberAllowedDownloads;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $numCurrentlyListed;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $obsoleteDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $obsoleteRevision;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $offerSupport;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $onlineCustomerPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $onlinePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $onSpecial;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $otherPrices;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $otherVendor;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $outOfStockBehavior;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $outOfStockMessage;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $overallQuantityPricingType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $overheadType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pageTitle;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $periodicLotSizeDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $periodicLotSizeType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $preferenceCriterion;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $preferredBin;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $preferredLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $preferredStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $preferredStockLevelDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $pricesIncludeTax;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $pricingGroup;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $primaryCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $prodPriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $prodQtyVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $purchaseDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $purchasePriceVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $purchaseUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityAvailable;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityBackOrdered;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityOnHand;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityOnOrder;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $quantityPricingSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $receiptAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $receiptQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $receiptQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $reorderMultiple;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $reOrderPoint;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $rescheduleInDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $rescheduleOutDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $reservePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revenueAllocationGroup;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revenueRecognitionRule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revRecForecastRule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revReclassFXAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revRecSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $roundUpAsComponent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $safetyStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $safetyStockLevelDays;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $salesDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesTaxCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $saleUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $sameAsPrimaryBookAmortization;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $sameAsPrimaryBookRevRec;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $scheduleBCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $scheduleBNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $scheduleBQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $scrapAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $searchKeywords;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $seasonalDemand;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $secondaryConsumptionUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $secondaryPurchaseUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $secondarySaleUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $secondaryStockUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $secondaryUnitsType;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $sellOnEBay;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serialNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serialNumberLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $shipIndividually;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $shipPackage;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $shippingCarrier;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $shippingRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shoppingDotComCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $shoppingProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $shopzillaCategoryId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $shopzillaProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $sitemapPriority;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $softDescriptor;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $startingPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $stockDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $stockUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $storeDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $storeDetailedDescription;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $storeDisplayImage;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $storeDisplayName;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $storeDisplayThumbnail;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $subType;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $supplyLotSizingMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $supplyReplenishmentMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $supplyTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $supplyType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $thumbNailUrl;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $totalValue;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $trackLandedCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $transferPrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $unbuildVarianceAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $upcCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $upperWarningLimit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $urlComponent;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useBins;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useComponentYield;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useMarginalRates;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $vendor;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $vendorCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vendorCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vendorCostEntered;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $vendorName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $vendorPriceCurrency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $vendorSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $vendReturnVarianceAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $vsoeDelivered;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $vsoePermitDiscount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $vsoeSopGroup;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $webSite;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $weight;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $weightUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $wipAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $wipVarianceAcct;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $yahooProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accBookRevRecForecastRule' => 'SearchColumnSelectField[]',
		'accountingBook' => 'SearchColumnSelectField[]',
		'accountingBookAmortization' => 'SearchColumnSelectField[]',
		'accountingBookCreatePlansOn' => 'SearchColumnSelectField[]',
		'accountingBookRevRecRule' => 'SearchColumnSelectField[]',
		'accountingBookRevRecSchedule' => 'SearchColumnSelectField[]',
		'allowedShippingMethod' => 'SearchColumnSelectField[]',
		'alternateDemandSourceItem' => 'SearchColumnStringField[]',
		'assetAccount' => 'SearchColumnSelectField[]',
		'atpLeadTime' => 'SearchColumnDoubleField[]',
		'atpMethod' => 'SearchColumnEnumSelectField[]',
		'autoLeadTime' => 'SearchColumnBooleanField[]',
		'autoPreferredStockLevel' => 'SearchColumnBooleanField[]',
		'autoReorderPoint' => 'SearchColumnBooleanField[]',
		'availableToPartners' => 'SearchColumnBooleanField[]',
		'averageCost' => 'SearchColumnDoubleField[]',
		'backwardConsumptionDays' => 'SearchColumnLongField[]',
		'basePrice' => 'SearchColumnDoubleField[]',
		'billExchRateVarianceAcct' => 'SearchColumnSelectField[]',
		'billPriceVarianceAcct' => 'SearchColumnSelectField[]',
		'billQtyVarianceAcct' => 'SearchColumnSelectField[]',
		'binNumber' => 'SearchColumnStringField[]',
		'binOnHandAvail' => 'SearchColumnDoubleField[]',
		'binOnHandCount' => 'SearchColumnDoubleField[]',
		'bomQuantity' => 'SearchColumnDoubleField[]',
		'buildEntireAssembly' => 'SearchColumnBooleanField[]',
		'buildTime' => 'SearchColumnDoubleField[]',
		'buyItNowPrice' => 'SearchColumnDoubleField[]',
		'category' => 'SearchColumnStringField[]',
		'categoryPreferred' => 'SearchColumnStringField[]',
		'class' => 'SearchColumnSelectField[]',
		'componentYield' => 'SearchColumnDoubleField[]',
		'consumptionUnit' => 'SearchColumnSelectField[]',
		'contingentRevenueHandling' => 'SearchColumnBooleanField[]',
		'conversionRate' => 'SearchColumnDoubleField[]',
		'copyDescription' => 'SearchColumnBooleanField[]',
		'correlatedItem' => 'SearchColumnSelectField[]',
		'correlatedItemCorrelation' => 'SearchColumnDoubleField[]',
		'correlatedItemCount' => 'SearchColumnLongField[]',
		'correlatedItemLift' => 'SearchColumnDoubleField[]',
		'correlatedItemPurchaseRate' => 'SearchColumnDoubleField[]',
		'cost' => 'SearchColumnDoubleField[]',
		'costAccountingStatus' => 'SearchColumnEnumSelectField[]',
		'costCategory' => 'SearchColumnStringField[]',
		'costEstimate' => 'SearchColumnDoubleField[]',
		'costEstimateType' => 'SearchColumnEnumSelectField[]',
		'costingMethod' => 'SearchColumnEnumSelectField[]',
		'countryOfManufacture' => 'SearchColumnEnumSelectField[]',
		'created' => 'SearchColumnDateField[]',
		'createJob' => 'SearchColumnBooleanField[]',
		'createRevenuePlansOn' => 'SearchColumnSelectField[]',
		'custReturnVarianceAccount' => 'SearchColumnSelectField[]',
		'dateViewed' => 'SearchColumnDateField[]',
		'daysBeforeExpiration' => 'SearchColumnStringField[]',
		'defaultReturnCost' => 'SearchColumnDoubleField[]',
		'defaultShippingMethod' => 'SearchColumnStringField[]',
		'deferredExpenseAccount' => 'SearchColumnSelectField[]',
		'deferredRevenueAccount' => 'SearchColumnSelectField[]',
		'deferRevRec' => 'SearchColumnBooleanField[]',
		'demandModifier' => 'SearchColumnDoubleField[]',
		'demandSource' => 'SearchColumnEnumSelectField[]',
		'demandTimeFence' => 'SearchColumnLongField[]',
		'department' => 'SearchColumnSelectField[]',
		'departmentnohierarchy' => 'SearchColumnSelectField[]',
		'directRevenuePosting' => 'SearchColumnBooleanField[]',
		'displayIneBayStore' => 'SearchColumnBooleanField[]',
		'displayName' => 'SearchColumnStringField[]',
		'distributionCategory' => 'SearchColumnSelectField[]',
		'distributionNetwork' => 'SearchColumnSelectField[]',
		'dontShowPrice' => 'SearchColumnBooleanField[]',
		'eBayItemDescription' => 'SearchColumnStringField[]',
		'eBayItemSubtitle' => 'SearchColumnStringField[]',
		'eBayItemTitle' => 'SearchColumnStringField[]',
		'ebayRelistingOption' => 'SearchColumnEnumSelectField[]',
		'effectiveBomControl' => 'SearchColumnEnumSelectField[]',
		'effectiveDate' => 'SearchColumnDateField[]',
		'effectiveRevision' => 'SearchColumnSelectField[]',
		'enableCatchWeight' => 'SearchColumnBooleanField[]',
		'endAuctionsWhenOutOfStock' => 'SearchColumnBooleanField[]',
		'excludeFromSitemap' => 'SearchColumnBooleanField[]',
		'expenseAccount' => 'SearchColumnSelectField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'featuredDescription' => 'SearchColumnStringField[]',
		'feedDescription' => 'SearchColumnStringField[]',
		'feedName' => 'SearchColumnStringField[]',
		'fixedLotSize' => 'SearchColumnDoubleField[]',
		'forwardConsumptionDays' => 'SearchColumnLongField[]',
		'fraudRisk' => 'SearchColumnEnumSelectField[]',
		'froogleProductFeed' => 'SearchColumnBooleanField[]',
		'futureHorizon' => 'SearchColumnLongField[]',
		'fxCost' => 'SearchColumnDoubleField[]',
		'gainLossAccount' => 'SearchColumnSelectField[]',
		'generateAccruals' => 'SearchColumnBooleanField[]',
		'giftCertAuthCode' => 'SearchColumnStringField[]',
		'giftCertEmail' => 'SearchColumnStringField[]',
		'giftCertExpirationDate' => 'SearchColumnStringField[]',
		'giftCertFrom' => 'SearchColumnStringField[]',
		'giftCertMessage' => 'SearchColumnStringField[]',
		'giftCertOriginalAmount' => 'SearchColumnStringField[]',
		'giftCertRecipient' => 'SearchColumnStringField[]',
		'hierarchyNode' => 'SearchColumnStringField[]',
		'hierarchyVersion' => 'SearchColumnStringField[]',
		'hits' => 'SearchColumnLongField[]',
		'imageUrl' => 'SearchColumnStringField[]',
		'includeChildren' => 'SearchColumnBooleanField[]',
		'incomeAccount' => 'SearchColumnSelectField[]',
		'intercoDefRevAccount' => 'SearchColumnSelectField[]',
		'intercoExpenseAccount' => 'SearchColumnSelectField[]',
		'intercoIncomeAccount' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'inventoryLocation' => 'SearchColumnSelectField[]',
		'invtClassification' => 'SearchColumnEnumSelectField[]',
		'invtCountInterval' => 'SearchColumnLongField[]',
		'isAvailable' => 'SearchColumnBooleanField[]',
		'isDropShipItem' => 'SearchColumnBooleanField[]',
		'isFulfillable' => 'SearchColumnBooleanField[]',
		'isGcoCompliant' => 'SearchColumnBooleanField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isLotItem' => 'SearchColumnBooleanField[]',
		'isOnline' => 'SearchColumnBooleanField[]',
		'isSerialItem' => 'SearchColumnBooleanField[]',
		'isSpecialOrderItem' => 'SearchColumnBooleanField[]',
		'isSpecialWorkOrderItem' => 'SearchColumnBooleanField[]',
		'isStorePickupAllowed' => 'SearchColumnBooleanField[]',
		'issueProduct' => 'SearchColumnSelectField[]',
		'isTaxable' => 'SearchColumnBooleanField[]',
		'isVsoeBundle' => 'SearchColumnBooleanField[]',
		'isWip' => 'SearchColumnBooleanField[]',
		'itemId' => 'SearchColumnStringField[]',
		'itemRevenueCategory' => 'SearchColumnSelectField[]',
		'itemUrl' => 'SearchColumnStringField[]',
		'lastInvtCountDate' => 'SearchColumnDateField[]',
		'lastPurchasePrice' => 'SearchColumnDoubleField[]',
		'lastQuantityAvailableChange' => 'SearchColumnDateField[]',
		'leadTime' => 'SearchColumnLongField[]',
		'liabilityAccount' => 'SearchColumnSelectField[]',
		'listingDuration' => 'SearchColumnEnumSelectField[]',
		'location' => 'SearchColumnSelectField[]',
		'locationAllowStorePickup' => 'SearchColumnBooleanField[]',
		'locationAtpLeadTime' => 'SearchColumnDoubleField[]',
		'locationAverageCost' => 'SearchColumnDoubleField[]',
		'locationBinQuantityAvailable' => 'SearchColumnStringField[]',
		'locationBuildTime' => 'SearchColumnDoubleField[]',
		'locationCost' => 'SearchColumnDoubleField[]',
		'locationCostAccountingStatus' => 'SearchColumnEnumSelectField[]',
		'locationDefaultReturnCost' => 'SearchColumnDoubleField[]',
		'locationDemandSource' => 'SearchColumnEnumSelectField[]',
		'locationDemandTimeFence' => 'SearchColumnLongField[]',
		'locationFixedLotSize' => 'SearchColumnDoubleField[]',
		'locationInventoryCostTemplate' => 'SearchColumnStringField[]',
		'locationInvtClassification' => 'SearchColumnEnumSelectField[]',
		'locationInvtCountInterval' => 'SearchColumnLongField[]',
		'locationLastInvtCountDate' => 'SearchColumnDateField[]',
		'locationLeadTime' => 'SearchColumnLongField[]',
		'locationNextInvtCountDate' => 'SearchColumnDateField[]',
		'locationPeriodicLotSizeDays' => 'SearchColumnLongField[]',
		'locationPeriodicLotSizeType' => 'SearchColumnEnumSelectField[]',
		'locationPreferredStockLevel' => 'SearchColumnDoubleField[]',
		'locationQtyAvailForStorePickup' => 'SearchColumnDoubleField[]',
		'locationQuantityAvailable' => 'SearchColumnDoubleField[]',
		'locationQuantityBackOrdered' => 'SearchColumnDoubleField[]',
		'locationQuantityCommitted' => 'SearchColumnDoubleField[]',
		'locationQuantityInTransit' => 'SearchColumnDoubleField[]',
		'locationQuantityOnHand' => 'SearchColumnDoubleField[]',
		'locationQuantityOnOrder' => 'SearchColumnDoubleField[]',
		'locationReOrderPoint' => 'SearchColumnDoubleField[]',
		'locationRescheduleInDays' => 'SearchColumnLongField[]',
		'locationRescheduleOutDays' => 'SearchColumnLongField[]',
		'locationSafetyStockLevel' => 'SearchColumnDoubleField[]',
		'locationStorePickupBufferStock' => 'SearchColumnDoubleField[]',
		'locationSupplyLotSizingMethod' => 'SearchColumnEnumSelectField[]',
		'locationSupplyTimeFence' => 'SearchColumnLongField[]',
		'locationSupplyType' => 'SearchColumnEnumSelectField[]',
		'locationTotalValue' => 'SearchColumnDoubleField[]',
		'locBackwardConsumptionDays' => 'SearchColumnLongField[]',
		'locForwardConsumptionDays' => 'SearchColumnLongField[]',
		'lowerWarningLimit' => 'SearchColumnDoubleField[]',
		'manufacturer' => 'SearchColumnStringField[]',
		'manufacturerAddr1' => 'SearchColumnStringField[]',
		'manufacturerCity' => 'SearchColumnStringField[]',
		'manufacturerState' => 'SearchColumnStringField[]',
		'manufacturerTariff' => 'SearchColumnStringField[]',
		'manufacturerTaxId' => 'SearchColumnStringField[]',
		'manufacturerZip' => 'SearchColumnStringField[]',
		'manufacturingChargeItem' => 'SearchColumnBooleanField[]',
		'matchBillToReceipt' => 'SearchColumnBooleanField[]',
		'maximumQuantity' => 'SearchColumnStringField[]',
		'memberItem' => 'SearchColumnSelectField[]',
		'memberQuantity' => 'SearchColumnDoubleField[]',
		'metaTagHtml' => 'SearchColumnStringField[]',
		'minimumQuantity' => 'SearchColumnStringField[]',
		'modified' => 'SearchColumnDateField[]',
		'mossApplies' => 'SearchColumnBooleanField[]',
		'mpn' => 'SearchColumnStringField[]',
		'multManufactureAddr' => 'SearchColumnBooleanField[]',
		'nextagCategory' => 'SearchColumnStringField[]',
		'nextagProductFeed' => 'SearchColumnBooleanField[]',
		'nextInvtCountDate' => 'SearchColumnDateField[]',
		'noPriceMessage' => 'SearchColumnStringField[]',
		'numActiveListings' => 'SearchColumnLongField[]',
		'numberAllowedDownloads' => 'SearchColumnStringField[]',
		'numCurrentlyListed' => 'SearchColumnLongField[]',
		'obsoleteDate' => 'SearchColumnDateField[]',
		'obsoleteRevision' => 'SearchColumnSelectField[]',
		'offerSupport' => 'SearchColumnBooleanField[]',
		'onlineCustomerPrice' => 'SearchColumnDoubleField[]',
		'onlinePrice' => 'SearchColumnDoubleField[]',
		'onSpecial' => 'SearchColumnBooleanField[]',
		'otherPrices' => 'SearchColumnDoubleField[]',
		'otherVendor' => 'SearchColumnSelectField[]',
		'outOfStockBehavior' => 'SearchColumnStringField[]',
		'outOfStockMessage' => 'SearchColumnStringField[]',
		'overallQuantityPricingType' => 'SearchColumnEnumSelectField[]',
		'overheadType' => 'SearchColumnEnumSelectField[]',
		'pageTitle' => 'SearchColumnStringField[]',
		'parent' => 'SearchColumnSelectField[]',
		'periodicLotSizeDays' => 'SearchColumnLongField[]',
		'periodicLotSizeType' => 'SearchColumnEnumSelectField[]',
		'preferenceCriterion' => 'SearchColumnStringField[]',
		'preferredBin' => 'SearchColumnBooleanField[]',
		'preferredLocation' => 'SearchColumnSelectField[]',
		'preferredStockLevel' => 'SearchColumnDoubleField[]',
		'preferredStockLevelDays' => 'SearchColumnLongField[]',
		'pricesIncludeTax' => 'SearchColumnBooleanField[]',
		'pricingGroup' => 'SearchColumnSelectField[]',
		'primaryCategory' => 'SearchColumnStringField[]',
		'prodPriceVarianceAcct' => 'SearchColumnSelectField[]',
		'prodQtyVarianceAcct' => 'SearchColumnSelectField[]',
		'purchaseDescription' => 'SearchColumnStringField[]',
		'purchaseOrderAmount' => 'SearchColumnDoubleField[]',
		'purchaseOrderQuantity' => 'SearchColumnDoubleField[]',
		'purchaseOrderQuantityDiff' => 'SearchColumnDoubleField[]',
		'purchasePriceVarianceAcct' => 'SearchColumnSelectField[]',
		'purchaseUnit' => 'SearchColumnSelectField[]',
		'quantityAvailable' => 'SearchColumnDoubleField[]',
		'quantityBackOrdered' => 'SearchColumnDoubleField[]',
		'quantityCommitted' => 'SearchColumnDoubleField[]',
		'quantityOnHand' => 'SearchColumnDoubleField[]',
		'quantityOnOrder' => 'SearchColumnDoubleField[]',
		'quantityPricingSchedule' => 'SearchColumnSelectField[]',
		'receiptAmount' => 'SearchColumnDoubleField[]',
		'receiptQuantity' => 'SearchColumnDoubleField[]',
		'receiptQuantityDiff' => 'SearchColumnDoubleField[]',
		'reorderMultiple' => 'SearchColumnLongField[]',
		'reOrderPoint' => 'SearchColumnDoubleField[]',
		'rescheduleInDays' => 'SearchColumnLongField[]',
		'rescheduleOutDays' => 'SearchColumnLongField[]',
		'reservePrice' => 'SearchColumnDoubleField[]',
		'revenueAllocationGroup' => 'SearchColumnSelectField[]',
		'revenueRecognitionRule' => 'SearchColumnSelectField[]',
		'revRecForecastRule' => 'SearchColumnSelectField[]',
		'revReclassFXAccount' => 'SearchColumnSelectField[]',
		'revRecSchedule' => 'SearchColumnSelectField[]',
		'roundUpAsComponent' => 'SearchColumnBooleanField[]',
		'safetyStockLevel' => 'SearchColumnDoubleField[]',
		'safetyStockLevelDays' => 'SearchColumnLongField[]',
		'salesDescription' => 'SearchColumnStringField[]',
		'salesTaxCode' => 'SearchColumnSelectField[]',
		'saleUnit' => 'SearchColumnSelectField[]',
		'sameAsPrimaryBookAmortization' => 'SearchColumnBooleanField[]',
		'sameAsPrimaryBookRevRec' => 'SearchColumnBooleanField[]',
		'scheduleBCode' => 'SearchColumnEnumSelectField[]',
		'scheduleBNumber' => 'SearchColumnStringField[]',
		'scheduleBQuantity' => 'SearchColumnStringField[]',
		'scrapAcct' => 'SearchColumnSelectField[]',
		'searchKeywords' => 'SearchColumnStringField[]',
		'seasonalDemand' => 'SearchColumnBooleanField[]',
		'secondaryConsumptionUnit' => 'SearchColumnSelectField[]',
		'secondaryPurchaseUnit' => 'SearchColumnSelectField[]',
		'secondarySaleUnit' => 'SearchColumnSelectField[]',
		'secondaryStockUnit' => 'SearchColumnSelectField[]',
		'secondaryUnitsType' => 'SearchColumnSelectField[]',
		'sellOnEBay' => 'SearchColumnBooleanField[]',
		'serialNumber' => 'SearchColumnStringField[]',
		'serialNumberLocation' => 'SearchColumnStringField[]',
		'shipIndividually' => 'SearchColumnBooleanField[]',
		'shipPackage' => 'SearchColumnSelectField[]',
		'shippingCarrier' => 'SearchColumnEnumSelectField[]',
		'shippingRate' => 'SearchColumnDoubleField[]',
		'shoppingDotComCategory' => 'SearchColumnStringField[]',
		'shoppingProductFeed' => 'SearchColumnBooleanField[]',
		'shopzillaCategoryId' => 'SearchColumnLongField[]',
		'shopzillaProductFeed' => 'SearchColumnBooleanField[]',
		'sitemapPriority' => 'SearchColumnEnumSelectField[]',
		'softDescriptor' => 'SearchColumnSelectField[]',
		'startingPrice' => 'SearchColumnDoubleField[]',
		'stockDescription' => 'SearchColumnStringField[]',
		'stockUnit' => 'SearchColumnSelectField[]',
		'storeDescription' => 'SearchColumnStringField[]',
		'storeDetailedDescription' => 'SearchColumnStringField[]',
		'storeDisplayImage' => 'SearchColumnSelectField[]',
		'storeDisplayName' => 'SearchColumnStringField[]',
		'storeDisplayThumbnail' => 'SearchColumnSelectField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'subType' => 'SearchColumnEnumSelectField[]',
		'supplyLotSizingMethod' => 'SearchColumnEnumSelectField[]',
		'supplyReplenishmentMethod' => 'SearchColumnEnumSelectField[]',
		'supplyTimeFence' => 'SearchColumnLongField[]',
		'supplyType' => 'SearchColumnEnumSelectField[]',
		'taxSchedule' => 'SearchColumnSelectField[]',
		'thumbNailUrl' => 'SearchColumnStringField[]',
		'totalValue' => 'SearchColumnDoubleField[]',
		'trackLandedCost' => 'SearchColumnBooleanField[]',
		'transferPrice' => 'SearchColumnDoubleField[]',
		'type' => 'SearchColumnEnumSelectField[]',
		'unbuildVarianceAccount' => 'SearchColumnSelectField[]',
		'unitsType' => 'SearchColumnSelectField[]',
		'upcCode' => 'SearchColumnStringField[]',
		'upperWarningLimit' => 'SearchColumnDoubleField[]',
		'urlComponent' => 'SearchColumnStringField[]',
		'useBins' => 'SearchColumnBooleanField[]',
		'useComponentYield' => 'SearchColumnBooleanField[]',
		'useMarginalRates' => 'SearchColumnBooleanField[]',
		'vendor' => 'SearchColumnSelectField[]',
		'vendorCode' => 'SearchColumnStringField[]',
		'vendorCost' => 'SearchColumnDoubleField[]',
		'vendorCostEntered' => 'SearchColumnDoubleField[]',
		'vendorName' => 'SearchColumnStringField[]',
		'vendorPriceCurrency' => 'SearchColumnStringField[]',
		'vendorSchedule' => 'SearchColumnSelectField[]',
		'vendReturnVarianceAccount' => 'SearchColumnSelectField[]',
		'vsoeDeferral' => 'SearchColumnEnumSelectField[]',
		'vsoeDelivered' => 'SearchColumnBooleanField[]',
		'vsoePermitDiscount' => 'SearchColumnEnumSelectField[]',
		'vsoePrice' => 'SearchColumnDoubleField[]',
		'vsoeSopGroup' => 'SearchColumnEnumSelectField[]',
		'webSite' => 'SearchColumnSelectField[]',
		'weight' => 'SearchColumnDoubleField[]',
		'weightUnit' => 'SearchColumnEnumSelectField[]',
		'wipAcct' => 'SearchColumnSelectField[]',
		'wipVarianceAcct' => 'SearchColumnSelectField[]',
		'yahooProductFeed' => 'SearchColumnBooleanField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
