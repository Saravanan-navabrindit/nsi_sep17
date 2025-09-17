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

class LotNumberedInventoryItemLocations {
	/**
	 * Var string
	 */
	public $location;
	/**
	 * Var float
	 */
	public $quantityOnHand;
	/**
	 * Var float
	 */
	public $onHandValueMli;
	/**
	 * Var string
	 */
	public $serialNumbers;
	/**
	 * Var string
	 */
	public $expirationDate;
	/**
	 * Var float
	 */
	public $averageCostMli;
	/**
	 * Var float
	 */
	public $lastPurchasePriceMli;
	/**
	 * Var float
	 */
	public $reorderPoint;
	/**
	 * Var boolean
	 */
	public $locationAllowStorePickup;
	/**
	 * Var float
	 */
	public $locationStorePickupBufferStock;
	/**
	 * Var float
	 */
	public $locationQtyAvailForStorePickup;
	/**
	 * Var float
	 */
	public $preferredStockLevel;
	/**
	 * Var integer
	 */
	public $leadTime;
	/**
	 * Var float
	 */
	public $defaultReturnCost;
	/**
	 * Var float
	 */
	public $safetyStockLevel;
	/**
	 * Var float
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $inventoryCostTemplate;
	/**
	 * Var float
	 */
	public $buildTime;
	/**
	 * Var string
	 */
	public $lastInvtCountDate;
	/**
	 * Var string
	 */
	public $nextInvtCountDate;
	/**
	 * Var boolean
	 */
	public $isWip;
	/**
	 * Var integer
	 */
	public $invtCountInterval;
	/**
	 * Var \NetSuite\Classes\ItemInvtClassification
	 */
	public $invtClassification;
	/**
	 * Var float
	 */
	public $costingLotSize;
	/**
	 * Var float
	 */
	public $quantityOnOrder;
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
	public $locationId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $locationlookup;
	/**
	 * Var string
	 */
	public $location_display;
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
	 * Var integer
	 */
	public $periodicLotSizeDays;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supplyType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $supplyLotSizingMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $demandSource;
	/**
	 * Var integer
	 */
	public $backwardConsumptionDays;
	/**
	 * Var integer
	 */
	public $forwardConsumptionDays;
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
	public static $paramtypesmap = array(
		'location' => 'string',
		'quantityOnHand' => 'float',
		'onHandValueMli' => 'float',
		'serialNumbers' => 'string',
		'expirationDate' => 'dateTime',
		'averageCostMli' => 'float',
		'lastPurchasePriceMli' => 'float',
		'reorderPoint' => 'float',
		'locationAllowStorePickup' => 'boolean',
		'locationStorePickupBufferStock' => 'float',
		'locationQtyAvailForStorePickup' => 'float',
		'preferredStockLevel' => 'float',
		'leadTime' => 'integer',
		'defaultReturnCost' => 'float',
		'safetyStockLevel' => 'float',
		'cost' => 'float',
		'inventoryCostTemplate' => 'RecordRef',
		'buildTime' => 'float',
		'lastInvtCountDate' => 'dateTime',
		'nextInvtCountDate' => 'dateTime',
		'isWip' => 'boolean',
		'invtCountInterval' => 'integer',
		'invtClassification' => 'ItemInvtClassification',
		'costingLotSize' => 'float',
		'quantityOnOrder' => 'float',
		'quantityCommitted' => 'float',
		'quantityAvailable' => 'float',
		'quantityBackOrdered' => 'float',
		'locationId' => 'RecordRef',
		'locationlookup' => 'RecordRef',
		'location_display' => 'string',
		'supplyReplenishmentMethod' => 'RecordRef',
		'alternateDemandSourceItem' => 'RecordRef',
		'fixedLotSize' => 'float',
		'periodicLotSizeType' => 'PeriodicLotSizeType',
		'periodicLotSizeDays' => 'integer',
		'supplyType' => 'RecordRef',
		'supplyLotSizingMethod' => 'RecordRef',
		'demandSource' => 'RecordRef',
		'backwardConsumptionDays' => 'integer',
		'forwardConsumptionDays' => 'integer',
		'demandTimeFence' => 'integer',
		'supplyTimeFence' => 'integer',
		'rescheduleInDays' => 'integer',
		'rescheduleOutDays' => 'integer',
	);
}
