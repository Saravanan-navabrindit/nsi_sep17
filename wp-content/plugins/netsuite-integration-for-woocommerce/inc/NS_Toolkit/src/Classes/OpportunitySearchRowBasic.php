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

class OpportunitySearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $actionItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $availableOffline;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $buyingReason;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $buyingTimeFrame;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $closeDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $competitor;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $contribution;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $contributionPrimary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $custType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $daysOpen;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $daysToClose;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $decisionMaker;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $entityStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estimatedBudget;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expectedCloseDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $forecastType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $foreignProjectedAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $foreignRangeHigh;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $foreignRangeLow;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxTranCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isBudgetApproved;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $partnerContribution;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $partnerRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $partnerTeamMember;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $period;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $probability;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $projAltSalesAmt;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $projectedTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rangeHigh;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rangeHighAlt;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rangeLow;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rangeLowAlt;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $salesReadiness;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesTeamMember;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesTeamRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $tranCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $tranEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $tranEstGrossProfitPct;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $tranFxEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $weightedTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $winLossReason;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $wonBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'actionItem' => 'SearchColumnStringField[]',
		'availableOffline' => 'SearchColumnBooleanField[]',
		'buyingReason' => 'SearchColumnStringField[]',
		'buyingTimeFrame' => 'SearchColumnStringField[]',
		'class' => 'SearchColumnSelectField[]',
		'closeDate' => 'SearchColumnDateField[]',
		'competitor' => 'SearchColumnSelectField[]',
		'contribution' => 'SearchColumnDoubleField[]',
		'contributionPrimary' => 'SearchColumnDoubleField[]',
		'currency' => 'SearchColumnSelectField[]',
		'custType' => 'SearchColumnStringField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'daysOpen' => 'SearchColumnLongField[]',
		'daysToClose' => 'SearchColumnLongField[]',
		'decisionMaker' => 'SearchColumnSelectField[]',
		'department' => 'SearchColumnSelectField[]',
		'entity' => 'SearchColumnSelectField[]',
		'entityStatus' => 'SearchColumnSelectField[]',
		'estimatedBudget' => 'SearchColumnDoubleField[]',
		'expectedCloseDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'forecastType' => 'SearchColumnEnumSelectField[]',
		'foreignProjectedAmount' => 'SearchColumnDoubleField[]',
		'foreignRangeHigh' => 'SearchColumnDoubleField[]',
		'foreignRangeLow' => 'SearchColumnDoubleField[]',
		'fxTranCostEstimate' => 'SearchColumnDoubleField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isBudgetApproved' => 'SearchColumnBooleanField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'leadSource' => 'SearchColumnSelectField[]',
		'location' => 'SearchColumnSelectField[]',
		'memo' => 'SearchColumnStringField[]',
		'partner' => 'SearchColumnSelectField[]',
		'partnerContribution' => 'SearchColumnDoubleField[]',
		'partnerRole' => 'SearchColumnSelectField[]',
		'partnerTeamMember' => 'SearchColumnSelectField[]',
		'period' => 'SearchColumnStringField[]',
		'probability' => 'SearchColumnDoubleField[]',
		'projAltSalesAmt' => 'SearchColumnDoubleField[]',
		'projectedTotal' => 'SearchColumnDoubleField[]',
		'rangeHigh' => 'SearchColumnDoubleField[]',
		'rangeHighAlt' => 'SearchColumnDoubleField[]',
		'rangeLow' => 'SearchColumnDoubleField[]',
		'rangeLowAlt' => 'SearchColumnDoubleField[]',
		'salesReadiness' => 'SearchColumnStringField[]',
		'salesRep' => 'SearchColumnSelectField[]',
		'salesTeamMember' => 'SearchColumnSelectField[]',
		'salesTeamRole' => 'SearchColumnSelectField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'taxPeriod' => 'SearchColumnSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'total' => 'SearchColumnDoubleField[]',
		'tranCostEstimate' => 'SearchColumnDoubleField[]',
		'tranDate' => 'SearchColumnDateField[]',
		'tranEstGrossProfit' => 'SearchColumnDoubleField[]',
		'tranEstGrossProfitPct' => 'SearchColumnDoubleField[]',
		'tranFxEstGrossProfit' => 'SearchColumnDoubleField[]',
		'tranId' => 'SearchColumnStringField[]',
		'weightedTotal' => 'SearchColumnDoubleField[]',
		'winLossReason' => 'SearchColumnSelectField[]',
		'wonBy' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
