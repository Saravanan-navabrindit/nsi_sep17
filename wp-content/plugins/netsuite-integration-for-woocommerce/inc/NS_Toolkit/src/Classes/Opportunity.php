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

class Opportunity extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var float
	 */
	public $estimatedBudget;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entityTaxRegNum;
	/**
	 * Var string
	 */
	public $taxPointDate;
	/**
	 * Var float
	 */
	public $oneTime;
	/**
	 * Var float
	 */
	public $recurWeekly;
	/**
	 * Var float
	 */
	public $recurMonthly;
	/**
	 * Var float
	 */
	public $recurQuarterly;
	/**
	 * Var float
	 */
	public $recurAnnually;
	/**
	 * Var string
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesRep;
	/**
	 * Var string
	 */
	public $contribPct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
	/**
	 * Var boolean
	 */
	public $syncSalesTeams;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entityStatus;
	/**
	 * Var float
	 */
	public $probability;
	/**
	 * Var string
	 */
	public $tranDate;
	/**
	 * Var string
	 */
	public $expectedCloseDate;
	/**
	 * Var integer
	 */
	public $daysOpen;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $forecastType;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var float
	 */
	public $projectedTotal;
	/**
	 * Var float
	 */
	public $rangeLow;
	/**
	 * Var float
	 */
	public $rangeHigh;
	/**
	 * Var float
	 */
	public $projAltSalesAmt;
	/**
	 * Var float
	 */
	public $altSalesRangeLow;
	/**
	 * Var float
	 */
	public $altSalesRangeHigh;
	/**
	 * Var float
	 */
	public $weightedTotal;
	/**
	 * Var string
	 */
	public $actionItem;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $winLossReason;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var boolean
	 */
	public $isBudgetApproved;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesReadiness;
	/**
	 * Var float
	 */
	public $totalCostEstimate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buyingTimeFrame;
	/**
	 * Var float
	 */
	public $estGrossProfit;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $buyingReason;
	/**
	 * Var float
	 */
	public $estGrossProfitPercent;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $billingAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billAddressList;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $shippingAddress;
	/**
	 * Var boolean
	 */
	public $shipIsResidential;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipAddressList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var string
	 */
	public $closeDate;
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
	public $nexus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiaryTaxRegNum;
	/**
	 * Var boolean
	 */
	public $taxRegOverride;
	/**
	 * Var boolean
	 */
	public $taxDetailsOverride;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var string
	 */
	public $vatRegNum;
	/**
	 * Var boolean
	 */
	public $syncPartnerTeams;
	/**
	 * Var \NetSuite\Classes\OpportunitySalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\OpportunityPartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\OpportunityItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\OpportunityCompetitorsList
	 */
	public $competitorsList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\TaxDetailsList
	 */
	public $taxDetailsList;
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
		'customForm' => 'RecordRef',
		'currency' => 'RecordRef',
		'estimatedBudget' => 'float',
		'entity' => 'RecordRef',
		'job' => 'RecordRef',
		'title' => 'string',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'oneTime' => 'float',
		'recurWeekly' => 'float',
		'recurMonthly' => 'float',
		'recurQuarterly' => 'float',
		'recurAnnually' => 'float',
		'source' => 'string',
		'salesRep' => 'RecordRef',
		'contribPct' => 'string',
		'partner' => 'RecordRef',
		'salesGroup' => 'RecordRef',
		'syncSalesTeams' => 'boolean',
		'leadSource' => 'RecordRef',
		'entityStatus' => 'RecordRef',
		'probability' => 'float',
		'tranDate' => 'dateTime',
		'expectedCloseDate' => 'dateTime',
		'daysOpen' => 'integer',
		'forecastType' => 'RecordRef',
		'currencyName' => 'string',
		'exchangeRate' => 'float',
		'projectedTotal' => 'float',
		'rangeLow' => 'float',
		'rangeHigh' => 'float',
		'projAltSalesAmt' => 'float',
		'altSalesRangeLow' => 'float',
		'altSalesRangeHigh' => 'float',
		'weightedTotal' => 'float',
		'actionItem' => 'string',
		'winLossReason' => 'RecordRef',
		'memo' => 'string',
		'taxTotal' => 'float',
		'isBudgetApproved' => 'boolean',
		'tax2Total' => 'float',
		'salesReadiness' => 'RecordRef',
		'totalCostEstimate' => 'float',
		'buyingTimeFrame' => 'RecordRef',
		'estGrossProfit' => 'float',
		'buyingReason' => 'RecordRef',
		'estGrossProfitPercent' => 'float',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'shippingAddress' => 'Address',
		'shipIsResidential' => 'boolean',
		'shipAddressList' => 'RecordRef',
		'class' => 'RecordRef',
		'closeDate' => 'dateTime',
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxDetailsOverride' => 'boolean',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'status' => 'string',
		'vatRegNum' => 'string',
		'syncPartnerTeams' => 'boolean',
		'salesTeamList' => 'OpportunitySalesTeamList',
		'partnersList' => 'OpportunityPartnersList',
		'itemList' => 'OpportunityItemList',
		'competitorsList' => 'OpportunityCompetitorsList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
