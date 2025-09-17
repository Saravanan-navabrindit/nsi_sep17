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

class OpportunitySearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $availableOffline;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buyingReason;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $buyingTimeFrame;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $closeDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $competitor;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $contribution;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $custType;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dateCreated;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $daysOpen;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $daysToClose;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $entityStatus;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estimatedBudget;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expectedCloseDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $forecastType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $foreignProjectedAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $foreignRangeHigh;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $foreignRangeLow;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxTranCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isBudgetApproved;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $partnerContribution;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partnerRole;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $partnerTeamMember;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\PostingPeriodDate
	 */
	public $postingPeriodRelative;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $probability;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $projAltSalesAmt;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $projectedTotal;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $rangeHigh;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $rangeHighAlt;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $rangeLow;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $rangeLowAlt;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesReadiness;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesTeamMember;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesTeamRole;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxPeriod;
	/**
	 * Var \NetSuite\Classes\PostingPeriodDate
	 */
	public $taxPeriodRelative;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $tranCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $tranDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $tranEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $tranEstGrossProfitPct;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $tranFxEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $winLossReason;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $wonBy;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'amount' => 'SearchDoubleField',
		'availableOffline' => 'SearchBooleanField',
		'buyingReason' => 'SearchMultiSelectField',
		'buyingTimeFrame' => 'SearchMultiSelectField',
		'class' => 'SearchMultiSelectField',
		'closeDate' => 'SearchDateField',
		'competitor' => 'SearchMultiSelectField',
		'contribution' => 'SearchLongField',
		'currency' => 'SearchMultiSelectField',
		'custType' => 'SearchMultiSelectField',
		'dateCreated' => 'SearchDateField',
		'daysOpen' => 'SearchLongField',
		'daysToClose' => 'SearchLongField',
		'department' => 'SearchMultiSelectField',
		'entity' => 'SearchMultiSelectField',
		'entityStatus' => 'SearchMultiSelectField',
		'estimatedBudget' => 'SearchDoubleField',
		'expectedCloseDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'forecastType' => 'SearchEnumMultiSelectField',
		'foreignProjectedAmount' => 'SearchDoubleField',
		'foreignRangeHigh' => 'SearchDoubleField',
		'foreignRangeLow' => 'SearchDoubleField',
		'fxTranCostEstimate' => 'SearchDoubleField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isBudgetApproved' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'lastModifiedDate' => 'SearchDateField',
		'leadSource' => 'SearchMultiSelectField',
		'location' => 'SearchMultiSelectField',
		'memo' => 'SearchStringField',
		'number' => 'SearchLongField',
		'partner' => 'SearchMultiSelectField',
		'partnerContribution' => 'SearchLongField',
		'partnerRole' => 'SearchMultiSelectField',
		'partnerTeamMember' => 'SearchMultiSelectField',
		'postingPeriod' => 'RecordRef',
		'postingPeriodRelative' => 'PostingPeriodDate',
		'probability' => 'SearchLongField',
		'projAltSalesAmt' => 'SearchDoubleField',
		'projectedTotal' => 'SearchDoubleField',
		'rangeHigh' => 'SearchDoubleField',
		'rangeHighAlt' => 'SearchDoubleField',
		'rangeLow' => 'SearchDoubleField',
		'rangeLowAlt' => 'SearchDoubleField',
		'salesReadiness' => 'SearchMultiSelectField',
		'salesRep' => 'SearchMultiSelectField',
		'salesTeamMember' => 'SearchMultiSelectField',
		'salesTeamRole' => 'SearchMultiSelectField',
		'status' => 'SearchEnumMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'taxPeriod' => 'RecordRef',
		'taxPeriodRelative' => 'PostingPeriodDate',
		'title' => 'SearchStringField',
		'tranCostEstimate' => 'SearchDoubleField',
		'tranDate' => 'SearchDateField',
		'tranEstGrossProfit' => 'SearchDoubleField',
		'tranEstGrossProfitPct' => 'SearchDoubleField',
		'tranFxEstGrossProfit' => 'SearchDoubleField',
		'tranId' => 'SearchStringField',
		'winLossReason' => 'SearchMultiSelectField',
		'wonBy' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
