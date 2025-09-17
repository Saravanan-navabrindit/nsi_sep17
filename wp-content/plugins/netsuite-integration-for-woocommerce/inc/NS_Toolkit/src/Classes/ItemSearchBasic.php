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

require_once 'SearchRecordBasic.php';

class ItemSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accBookRevRecForecastRule;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBook;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBookAmortization;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBookCreatePlansOn;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBookRevRecRule;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $accountingBookRevRecSchedule;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $allowedShippingMethod;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $alternateDemandSourceItem;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $atpLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $atpMethod;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $autoLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $autoPreferredStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $autoReorderPoint;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $availableToPartners;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $averageCost;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $backwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $binNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $binOnHandAvail;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $binOnHandCount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $buildEntireAssembly;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $buildTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $buyItNowPrice;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $caption;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $component;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $componentOf;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $componentYield;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $consumptionUnit;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $contingentRevenueHandling;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $conversionRate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $copyDescription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $correlatedItem;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $correlatedItemCorrelation;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $correlatedItemCount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $correlatedItemLift;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $correlatedItemPurchaseRate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $costAccountingStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $costCategory;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costEstimate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $costEstimateType;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $costingMethod;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $countryOfManufacture;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $created;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $createJob;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $createRevenuePlansOn;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateViewed;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $daysBeforeExpiration;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $defaultReturnCost;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $defaultShippingMethod;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $demandModifier;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $demandSource;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $demandTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $directRevenuePosting;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $displayIneBayStore;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $displayName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $distributionCategory;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $distributionNetwork;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $dontShowPrice;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $eBayItemDescription;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $eBayItemSubtitle;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $eBayItemTitle;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $ebayRelistingOption;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $effectiveBomControl;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $effectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $effectiveRevision;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $enableCatchWeight;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $endAuctionsWhenOutOfStock;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $excludeFromSitemap;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $featuredDescription;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $feedDescription;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $feedName;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fixedLotSize;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $forwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $fraudRisk;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $froogleProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $futureHorizon;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxCost;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $generateAccruals;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertAuthCode;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertEmail;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $giftCertExpDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertFrom;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertMsg;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertOrigAmt;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertRecipient;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $hierarchyNode;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $hierarchyVersion;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $imageUrl;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $inventoryLocation;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $invtClassification;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $invtCountInterval;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isAvailable;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isDropShipItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isFulfillable;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isGcoCompliant;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isLotItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isOnline;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPreferredVendor;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSerialItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSpecialOrderItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSpecialWorkOrderItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isStorePickupAllowed;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $issueProduct;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isWip;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $itemId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemRevenueCategory;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $itemUrl;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $lastPurchasePrice;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastQuantityAvailableChange;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $leadTime;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $listingDuration;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $locationAllowStorePickup;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationAtpLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationAverageCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationBuildTime;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationCost;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationCostAccountingStatus;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationDefaultReturnCost;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationDemandSource;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationDemandTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationFixedLotSize;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $locationInventoryCostTemplate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationInvtClassification;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationInvtCountInterval;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $locationLastInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationLeadTime;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $locationNextInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationPeriodicLotSizeDays;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationPeriodicLotSizeType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationPreferredStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQtyAvailForStorePickup;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQuantityAvailable;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQuantityBackOrdered;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQuantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQuantityInTransit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQuantityOnHand;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationQuantityOnOrder;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationReorderPoint;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationRescheduleInDays;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationRescheduleOutDays;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationSafetyStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationStorePickupBufferStock;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationSupplyLotSizingMethod;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locationSupplyTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $locationSupplyType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $locationTotalValue;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locBackwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $locForwardConsumptionDays;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $lowerWarningLimit;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufacturer;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufactureraddr1;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufacturerCity;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufacturerState;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufacturerTariff;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufacturerTaxId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $manufacturerZip;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $manufacturingChargeItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $matchBillToReceipt;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $matrix;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $matrixChild;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $maximumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $metaTagHtml;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $minimumQuantity;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $mossApplies;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $mpn;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $multManufactureAddr;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $nexTagCategory;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $nexTagProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $nextInvtCountDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $numActiveListings;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $numberAllowedDownloads;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $numCurrentlyListed;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $obsoleteDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $obsoleteRevision;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $offerSupport;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $onlineCustomerPrice;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $onSpecial;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $otherVendor;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $outOfStockBehavior;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $overallQuantityPricingType;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $overheadType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $pageTitle;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $parent;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $periodicLotSizeDays;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $periodicLotSizeType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $preferenceCriterion;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $preferredBin;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $preferredLocation;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $preferredStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $preferredStockLevelDays;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $price;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $pricesIncludeTax;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $pricingGroup;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $primaryCategory;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $purchaseOrderQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $purchaseUnit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityAvailable;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityBackOrdered;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityOnHand;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityOnOrder;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $quantityPricingSchedule;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $receiptAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $receiptQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $receiptQuantityDiff;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $reorderMultiple;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $reorderPoint;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $rescheduleInDays;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $rescheduleOutDays;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $reservePrice;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $revenueAllocationGroup;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $revenueRecognitionRule;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $revRecForecastRule;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $revRecSchedule;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $roundUpAsComponent;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $safetyStockLevel;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $safetyStockLevelDays;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $salesDescription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $saleUnit;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $sameAsPrimaryBookAmortization;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $sameAsPrimaryBookRevRec;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $scheduleBCode;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $scheduleBNumber;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $scheduleBQuantity;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $searchKeywords;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $seasonalDemand;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $secondaryConsumptionUnit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $secondaryPurchaseUnit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $secondarySaleUnit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $secondaryStockUnit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $secondaryUnitsType;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $sellOnEBay;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $serialNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $serialNumberLocation;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shipIndividually;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shipPackage;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $shippingCarrier;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $shippingRate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shoppingDotComCategory;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shoppingProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $shopzillaCategoryId;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shopzillaProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $sitemapPriority;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $softDescriptor;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $startingPrice;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $stockDescription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $stockUnit;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $storeDescription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $subType;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $supplyLotSizingMethod;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $supplyReplenishmentMethod;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $supplyTimeFence;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $supplyType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxCode;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxSchedule;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $thumbnailUrl;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $totalValue;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $trackLandedCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $transferPrice;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $upcCode;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $upperWarningLimit;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $urlComponent;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useBins;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useComponentYield;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useMarginalRates;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $vendor;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $vendorCode;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vendorCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vendorCostEntered;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $vendorName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $vendorPriceCurrency;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $vsoeDelivered;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $vsoePermitDiscount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $vsoeSopGroup;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $webSite;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $weight;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $yahooProductFeed;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'accBookRevRecForecastRule' => 'SearchMultiSelectField',
		'account' => 'SearchMultiSelectField',
		'accountingBook' => 'SearchMultiSelectField',
		'accountingBookAmortization' => 'SearchMultiSelectField',
		'accountingBookCreatePlansOn' => 'SearchMultiSelectField',
		'accountingBookRevRecRule' => 'SearchMultiSelectField',
		'accountingBookRevRecSchedule' => 'SearchMultiSelectField',
		'allowedShippingMethod' => 'SearchMultiSelectField',
		'alternateDemandSourceItem' => 'SearchMultiSelectField',
		'atpLeadTime' => 'SearchDoubleField',
		'atpMethod' => 'SearchEnumMultiSelectField',
		'autoLeadTime' => 'SearchBooleanField',
		'autoPreferredStockLevel' => 'SearchBooleanField',
		'autoReorderPoint' => 'SearchBooleanField',
		'availableToPartners' => 'SearchBooleanField',
		'averageCost' => 'SearchDoubleField',
		'backwardConsumptionDays' => 'SearchLongField',
		'binNumber' => 'SearchStringField',
		'binOnHandAvail' => 'SearchDoubleField',
		'binOnHandCount' => 'SearchDoubleField',
		'bomQuantity' => 'SearchDoubleField',
		'buildEntireAssembly' => 'SearchBooleanField',
		'buildTime' => 'SearchDoubleField',
		'buyItNowPrice' => 'SearchDoubleField',
		'caption' => 'SearchStringField',
		'category' => 'SearchMultiSelectField',
		'class' => 'SearchMultiSelectField',
		'component' => 'SearchMultiSelectField',
		'componentOf' => 'SearchMultiSelectField',
		'componentYield' => 'SearchDoubleField',
		'consumptionUnit' => 'SearchMultiSelectField',
		'contingentRevenueHandling' => 'SearchBooleanField',
		'conversionRate' => 'SearchDoubleField',
		'copyDescription' => 'SearchBooleanField',
		'correlatedItem' => 'SearchMultiSelectField',
		'correlatedItemCorrelation' => 'SearchDoubleField',
		'correlatedItemCount' => 'SearchLongField',
		'correlatedItemLift' => 'SearchDoubleField',
		'correlatedItemPurchaseRate' => 'SearchDoubleField',
		'cost' => 'SearchDoubleField',
		'costAccountingStatus' => 'SearchEnumMultiSelectField',
		'costCategory' => 'SearchMultiSelectField',
		'costEstimate' => 'SearchDoubleField',
		'costEstimateType' => 'SearchEnumMultiSelectField',
		'costingMethod' => 'SearchEnumMultiSelectField',
		'countryOfManufacture' => 'SearchEnumMultiSelectField',
		'created' => 'SearchDateField',
		'createJob' => 'SearchBooleanField',
		'createRevenuePlansOn' => 'SearchMultiSelectField',
		'dateViewed' => 'SearchDateField',
		'daysBeforeExpiration' => 'SearchDoubleField',
		'defaultReturnCost' => 'SearchDoubleField',
		'defaultShippingMethod' => 'SearchMultiSelectField',
		'deferRevRec' => 'SearchBooleanField',
		'demandModifier' => 'SearchDoubleField',
		'demandSource' => 'SearchEnumMultiSelectField',
		'demandTimeFence' => 'SearchLongField',
		'department' => 'SearchMultiSelectField',
		'directRevenuePosting' => 'SearchBooleanField',
		'displayIneBayStore' => 'SearchBooleanField',
		'displayName' => 'SearchStringField',
		'distributionCategory' => 'SearchMultiSelectField',
		'distributionNetwork' => 'SearchMultiSelectField',
		'dontShowPrice' => 'SearchBooleanField',
		'eBayItemDescription' => 'SearchStringField',
		'eBayItemSubtitle' => 'SearchStringField',
		'eBayItemTitle' => 'SearchStringField',
		'ebayRelistingOption' => 'SearchEnumMultiSelectField',
		'effectiveBomControl' => 'SearchEnumMultiSelectField',
		'effectiveDate' => 'SearchDateField',
		'effectiveRevision' => 'SearchMultiSelectField',
		'enableCatchWeight' => 'SearchBooleanField',
		'endAuctionsWhenOutOfStock' => 'SearchBooleanField',
		'excludeFromSitemap' => 'SearchBooleanField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'featuredDescription' => 'SearchStringField',
		'feedDescription' => 'SearchStringField',
		'feedName' => 'SearchStringField',
		'fixedLotSize' => 'SearchDoubleField',
		'forwardConsumptionDays' => 'SearchLongField',
		'fraudRisk' => 'SearchEnumMultiSelectField',
		'froogleProductFeed' => 'SearchBooleanField',
		'futureHorizon' => 'SearchLongField',
		'fxCost' => 'SearchDoubleField',
		'generateAccruals' => 'SearchBooleanField',
		'giftCertAuthCode' => 'SearchStringField',
		'giftCertEmail' => 'SearchStringField',
		'giftCertExpDate' => 'SearchDateField',
		'giftCertFrom' => 'SearchStringField',
		'giftCertMsg' => 'SearchStringField',
		'giftCertOrigAmt' => 'SearchStringField',
		'giftCertRecipient' => 'SearchStringField',
		'hierarchyNode' => 'SearchMultiSelectField',
		'hierarchyVersion' => 'SearchMultiSelectField',
		'imageUrl' => 'SearchStringField',
		'includeChildren' => 'SearchBooleanField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'inventoryLocation' => 'SearchMultiSelectField',
		'invtClassification' => 'SearchEnumMultiSelectField',
		'invtCountInterval' => 'SearchLongField',
		'isAvailable' => 'SearchBooleanField',
		'isDropShipItem' => 'SearchBooleanField',
		'isFulfillable' => 'SearchBooleanField',
		'isGcoCompliant' => 'SearchBooleanField',
		'isInactive' => 'SearchBooleanField',
		'isLotItem' => 'SearchBooleanField',
		'isOnline' => 'SearchBooleanField',
		'isPreferredVendor' => 'SearchBooleanField',
		'isSerialItem' => 'SearchBooleanField',
		'isSpecialOrderItem' => 'SearchBooleanField',
		'isSpecialWorkOrderItem' => 'SearchBooleanField',
		'isStorePickupAllowed' => 'SearchBooleanField',
		'issueProduct' => 'SearchMultiSelectField',
		'isTaxable' => 'SearchBooleanField',
		'isVsoeBundle' => 'SearchBooleanField',
		'isWip' => 'SearchBooleanField',
		'itemId' => 'SearchStringField',
		'itemRevenueCategory' => 'SearchMultiSelectField',
		'itemUrl' => 'SearchStringField',
		'lastInvtCountDate' => 'SearchDateField',
		'lastModifiedDate' => 'SearchDateField',
		'lastPurchasePrice' => 'SearchDoubleField',
		'lastQuantityAvailableChange' => 'SearchDateField',
		'leadTime' => 'SearchLongField',
		'listingDuration' => 'SearchEnumMultiSelectField',
		'location' => 'SearchMultiSelectField',
		'locationAllowStorePickup' => 'SearchBooleanField',
		'locationAtpLeadTime' => 'SearchDoubleField',
		'locationAverageCost' => 'SearchDoubleField',
		'locationBuildTime' => 'SearchDoubleField',
		'locationCost' => 'SearchDoubleField',
		'locationCostAccountingStatus' => 'SearchEnumMultiSelectField',
		'locationDefaultReturnCost' => 'SearchDoubleField',
		'locationDemandSource' => 'SearchEnumMultiSelectField',
		'locationDemandTimeFence' => 'SearchLongField',
		'locationFixedLotSize' => 'SearchDoubleField',
		'locationInventoryCostTemplate' => 'SearchMultiSelectField',
		'locationInvtClassification' => 'SearchEnumMultiSelectField',
		'locationInvtCountInterval' => 'SearchLongField',
		'locationLastInvtCountDate' => 'SearchDateField',
		'locationLeadTime' => 'SearchLongField',
		'locationNextInvtCountDate' => 'SearchDateField',
		'locationPeriodicLotSizeDays' => 'SearchLongField',
		'locationPeriodicLotSizeType' => 'SearchEnumMultiSelectField',
		'locationPreferredStockLevel' => 'SearchDoubleField',
		'locationQtyAvailForStorePickup' => 'SearchDoubleField',
		'locationQuantityAvailable' => 'SearchDoubleField',
		'locationQuantityBackOrdered' => 'SearchDoubleField',
		'locationQuantityCommitted' => 'SearchDoubleField',
		'locationQuantityInTransit' => 'SearchDoubleField',
		'locationQuantityOnHand' => 'SearchDoubleField',
		'locationQuantityOnOrder' => 'SearchDoubleField',
		'locationReorderPoint' => 'SearchDoubleField',
		'locationRescheduleInDays' => 'SearchLongField',
		'locationRescheduleOutDays' => 'SearchLongField',
		'locationSafetyStockLevel' => 'SearchDoubleField',
		'locationStorePickupBufferStock' => 'SearchDoubleField',
		'locationSupplyLotSizingMethod' => 'SearchEnumMultiSelectField',
		'locationSupplyTimeFence' => 'SearchLongField',
		'locationSupplyType' => 'SearchEnumMultiSelectField',
		'locationTotalValue' => 'SearchDoubleField',
		'locBackwardConsumptionDays' => 'SearchLongField',
		'locForwardConsumptionDays' => 'SearchLongField',
		'lowerWarningLimit' => 'SearchDoubleField',
		'manufacturer' => 'SearchStringField',
		'manufactureraddr1' => 'SearchStringField',
		'manufacturerCity' => 'SearchStringField',
		'manufacturerState' => 'SearchStringField',
		'manufacturerTariff' => 'SearchStringField',
		'manufacturerTaxId' => 'SearchStringField',
		'manufacturerZip' => 'SearchStringField',
		'manufacturingChargeItem' => 'SearchBooleanField',
		'matchBillToReceipt' => 'SearchBooleanField',
		'matrix' => 'SearchBooleanField',
		'matrixChild' => 'SearchBooleanField',
		'maximumQuantity' => 'SearchLongField',
		'metaTagHtml' => 'SearchStringField',
		'minimumQuantity' => 'SearchLongField',
		'mossApplies' => 'SearchBooleanField',
		'mpn' => 'SearchStringField',
		'multManufactureAddr' => 'SearchBooleanField',
		'nexTagCategory' => 'SearchStringField',
		'nexTagProductFeed' => 'SearchBooleanField',
		'nextInvtCountDate' => 'SearchDateField',
		'numActiveListings' => 'SearchLongField',
		'numberAllowedDownloads' => 'SearchDoubleField',
		'numCurrentlyListed' => 'SearchLongField',
		'obsoleteDate' => 'SearchDateField',
		'obsoleteRevision' => 'SearchMultiSelectField',
		'offerSupport' => 'SearchBooleanField',
		'onlineCustomerPrice' => 'SearchDoubleField',
		'onSpecial' => 'SearchBooleanField',
		'otherVendor' => 'SearchMultiSelectField',
		'outOfStockBehavior' => 'SearchMultiSelectField',
		'overallQuantityPricingType' => 'SearchEnumMultiSelectField',
		'overheadType' => 'SearchEnumMultiSelectField',
		'pageTitle' => 'SearchStringField',
		'parent' => 'SearchMultiSelectField',
		'periodicLotSizeDays' => 'SearchLongField',
		'periodicLotSizeType' => 'SearchEnumMultiSelectField',
		'preferenceCriterion' => 'SearchStringField',
		'preferredBin' => 'SearchBooleanField',
		'preferredLocation' => 'SearchMultiSelectField',
		'preferredStockLevel' => 'SearchDoubleField',
		'preferredStockLevelDays' => 'SearchLongField',
		'price' => 'SearchDoubleField',
		'pricesIncludeTax' => 'SearchBooleanField',
		'pricingGroup' => 'SearchMultiSelectField',
		'primaryCategory' => 'SearchLongField',
		'purchaseOrderAmount' => 'SearchDoubleField',
		'purchaseOrderQuantity' => 'SearchDoubleField',
		'purchaseOrderQuantityDiff' => 'SearchDoubleField',
		'purchaseUnit' => 'SearchMultiSelectField',
		'quantityAvailable' => 'SearchDoubleField',
		'quantityBackOrdered' => 'SearchDoubleField',
		'quantityCommitted' => 'SearchDoubleField',
		'quantityOnHand' => 'SearchDoubleField',
		'quantityOnOrder' => 'SearchDoubleField',
		'quantityPricingSchedule' => 'SearchMultiSelectField',
		'receiptAmount' => 'SearchDoubleField',
		'receiptQuantity' => 'SearchDoubleField',
		'receiptQuantityDiff' => 'SearchDoubleField',
		'reorderMultiple' => 'SearchLongField',
		'reorderPoint' => 'SearchDoubleField',
		'rescheduleInDays' => 'SearchLongField',
		'rescheduleOutDays' => 'SearchLongField',
		'reservePrice' => 'SearchDoubleField',
		'revenueAllocationGroup' => 'SearchMultiSelectField',
		'revenueRecognitionRule' => 'SearchMultiSelectField',
		'revRecForecastRule' => 'SearchMultiSelectField',
		'revRecSchedule' => 'SearchMultiSelectField',
		'roundUpAsComponent' => 'SearchBooleanField',
		'safetyStockLevel' => 'SearchDoubleField',
		'safetyStockLevelDays' => 'SearchLongField',
		'salesDescription' => 'SearchStringField',
		'saleUnit' => 'SearchMultiSelectField',
		'sameAsPrimaryBookAmortization' => 'SearchBooleanField',
		'sameAsPrimaryBookRevRec' => 'SearchBooleanField',
		'scheduleBCode' => 'SearchEnumMultiSelectField',
		'scheduleBNumber' => 'SearchStringField',
		'scheduleBQuantity' => 'SearchStringField',
		'searchKeywords' => 'SearchStringField',
		'seasonalDemand' => 'SearchBooleanField',
		'secondaryConsumptionUnit' => 'SearchMultiSelectField',
		'secondaryPurchaseUnit' => 'SearchMultiSelectField',
		'secondarySaleUnit' => 'SearchMultiSelectField',
		'secondaryStockUnit' => 'SearchMultiSelectField',
		'secondaryUnitsType' => 'SearchMultiSelectField',
		'sellOnEBay' => 'SearchBooleanField',
		'serialNumber' => 'SearchStringField',
		'serialNumberLocation' => 'SearchMultiSelectField',
		'shipIndividually' => 'SearchBooleanField',
		'shipPackage' => 'SearchMultiSelectField',
		'shippingCarrier' => 'SearchEnumMultiSelectField',
		'shippingRate' => 'SearchDoubleField',
		'shoppingDotComCategory' => 'SearchStringField',
		'shoppingProductFeed' => 'SearchBooleanField',
		'shopzillaCategoryId' => 'SearchLongField',
		'shopzillaProductFeed' => 'SearchBooleanField',
		'sitemapPriority' => 'SearchEnumMultiSelectField',
		'softDescriptor' => 'SearchMultiSelectField',
		'startingPrice' => 'SearchDoubleField',
		'stockDescription' => 'SearchStringField',
		'stockUnit' => 'SearchMultiSelectField',
		'storeDescription' => 'SearchStringField',
		'subsidiary' => 'SearchMultiSelectField',
		'subType' => 'SearchEnumMultiSelectField',
		'supplyLotSizingMethod' => 'SearchEnumMultiSelectField',
		'supplyReplenishmentMethod' => 'SearchEnumMultiSelectField',
		'supplyTimeFence' => 'SearchLongField',
		'supplyType' => 'SearchEnumMultiSelectField',
		'taxCode' => 'SearchMultiSelectField',
		'taxSchedule' => 'SearchMultiSelectField',
		'thumbnailUrl' => 'SearchStringField',
		'totalValue' => 'SearchDoubleField',
		'trackLandedCost' => 'SearchBooleanField',
		'transferPrice' => 'SearchDoubleField',
		'type' => 'SearchEnumMultiSelectField',
		'unitsType' => 'SearchMultiSelectField',
		'upcCode' => 'SearchStringField',
		'upperWarningLimit' => 'SearchDoubleField',
		'urlComponent' => 'SearchStringField',
		'useBins' => 'SearchBooleanField',
		'useComponentYield' => 'SearchBooleanField',
		'useMarginalRates' => 'SearchBooleanField',
		'vendor' => 'SearchMultiSelectField',
		'vendorCode' => 'SearchStringField',
		'vendorCost' => 'SearchDoubleField',
		'vendorCostEntered' => 'SearchDoubleField',
		'vendorName' => 'SearchStringField',
		'vendorPriceCurrency' => 'SearchMultiSelectField',
		'vsoeDeferral' => 'SearchEnumMultiSelectField',
		'vsoeDelivered' => 'SearchBooleanField',
		'vsoePermitDiscount' => 'SearchEnumMultiSelectField',
		'vsoePrice' => 'SearchDoubleField',
		'vsoeSopGroup' => 'SearchEnumMultiSelectField',
		'webSite' => 'SearchMultiSelectField',
		'weight' => 'SearchDoubleField',
		'yahooProductFeed' => 'SearchBooleanField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
