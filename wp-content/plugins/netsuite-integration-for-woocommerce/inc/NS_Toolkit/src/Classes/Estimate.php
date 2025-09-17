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

class Estimate extends Record {
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
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var string
	 */
	public $tranDate;
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
	 * Var string
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entityStatus;
	/**
	 * Var float
	 */
	public $probability;
	/**
	 * Var boolean
	 */
	public $includeInForecast;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $forecastType;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $opportunity;
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
	public $terms;
	/**
	 * Var string
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $partner;
	/**
	 * Var string
	 */
	public $contribPct;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $leadSource;
	/**
	 * Var string
	 */
	public $expectedCloseDate;
	/**
	 * Var string
	 */
	public $otherRefNum;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var float
	 */
	public $totalCostEstimate;
	/**
	 * Var float
	 */
	public $estGrossProfit;
	/**
	 * Var float
	 */
	public $estGrossProfitPercent;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $discountItem;
	/**
	 * Var string
	 */
	public $discountRate;
	/**
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxItem;
	/**
	 * Var float
	 */
	public $taxRate;
	/**
	 * Var string
	 */
	public $vatRegNum;
	/**
	 * Var boolean
	 */
	public $toBePrinted;
	/**
	 * Var boolean
	 */
	public $toBeEmailed;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var boolean
	 */
	public $toBeFaxed;
	/**
	 * Var string
	 */
	public $fax;
	/**
	 * Var boolean
	 */
	public $visibleToCustomer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $messageSel;
	/**
	 * Var string
	 */
	public $message;
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
	 * Var string
	 */
	public $fob;
	/**
	 * Var string
	 */
	public $shipDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
	/**
	 * Var float
	 */
	public $shippingCost;
	/**
	 * Var float
	 */
	public $shippingTax1Rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingTaxCode;
	/**
	 * Var string
	 */
	public $shippingTax2Rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $handlingTaxCode;
	/**
	 * Var float
	 */
	public $handlingTax1Rate;
	/**
	 * Var float
	 */
	public $handlingCost;
	/**
	 * Var string
	 */
	public $trackingNumbers;
	/**
	 * Var string
	 */
	public $handlingTax2Rate;
	/**
	 * Var string
	 */
	public $linkedTrackingNumbers;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
	/**
	 * Var boolean
	 */
	public $syncSalesTeams;
	/**
	 * Var float
	 */
	public $altSalesTotal;
	/**
	 * Var boolean
	 */
	public $canHaveStackable;
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
	 * Var float
	 */
	public $subTotal;
	/**
	 * Var float
	 */
	public $discountTotal;
	/**
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var float
	 */
	public $altShippingCost;
	/**
	 * Var float
	 */
	public $altHandlingCost;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var \NetSuite\Classes\EstimateItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\EstimateSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var boolean
	 */
	public $syncPartnerTeams;
	/**
	 * Var \NetSuite\Classes\EstimatePartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\PromotionsList
	 */
	public $promotionsList;
	/**
	 * Var \NetSuite\Classes\EstimateShipGroupList
	 */
	public $shipGroupList;
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
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxDetailsOverride' => 'boolean',
		'entity' => 'RecordRef',
		'job' => 'RecordRef',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'source' => 'string',
		'customForm' => 'RecordRef',
		'currency' => 'RecordRef',
		'title' => 'string',
		'entityStatus' => 'RecordRef',
		'probability' => 'float',
		'includeInForecast' => 'boolean',
		'forecastType' => 'RecordRef',
		'opportunity' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'terms' => 'RecordRef',
		'dueDate' => 'dateTime',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'status' => 'string',
		'salesRep' => 'RecordRef',
		'partner' => 'RecordRef',
		'contribPct' => 'string',
		'leadSource' => 'RecordRef',
		'expectedCloseDate' => 'dateTime',
		'otherRefNum' => 'string',
		'memo' => 'string',
		'endDate' => 'dateTime',
		'startDate' => 'dateTime',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
		'createdFrom' => 'RecordRef',
		'exchangeRate' => 'float',
		'currencyName' => 'string',
		'promoCode' => 'RecordRef',
		'discountItem' => 'RecordRef',
		'discountRate' => 'string',
		'isTaxable' => 'boolean',
		'taxItem' => 'RecordRef',
		'taxRate' => 'float',
		'vatRegNum' => 'string',
		'toBePrinted' => 'boolean',
		'toBeEmailed' => 'boolean',
		'email' => 'string',
		'toBeFaxed' => 'boolean',
		'fax' => 'string',
		'visibleToCustomer' => 'boolean',
		'messageSel' => 'RecordRef',
		'message' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'shippingAddress' => 'Address',
		'shipIsResidential' => 'boolean',
		'shipAddressList' => 'RecordRef',
		'fob' => 'string',
		'shipDate' => 'dateTime',
		'shipMethod' => 'RecordRef',
		'shippingCost' => 'float',
		'shippingTax1Rate' => 'float',
		'shippingTaxCode' => 'RecordRef',
		'shippingTax2Rate' => 'string',
		'handlingTaxCode' => 'RecordRef',
		'handlingTax1Rate' => 'float',
		'handlingCost' => 'float',
		'trackingNumbers' => 'string',
		'handlingTax2Rate' => 'string',
		'linkedTrackingNumbers' => 'string',
		'salesGroup' => 'RecordRef',
		'syncSalesTeams' => 'boolean',
		'altSalesTotal' => 'float',
		'canHaveStackable' => 'boolean',
		'oneTime' => 'float',
		'recurWeekly' => 'float',
		'recurMonthly' => 'float',
		'recurQuarterly' => 'float',
		'recurAnnually' => 'float',
		'subTotal' => 'float',
		'discountTotal' => 'float',
		'taxTotal' => 'float',
		'altShippingCost' => 'float',
		'altHandlingCost' => 'float',
		'total' => 'float',
		'tax2Total' => 'float',
		'itemList' => 'EstimateItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'salesTeamList' => 'EstimateSalesTeamList',
		'syncPartnerTeams' => 'boolean',
		'partnersList' => 'EstimatePartnersList',
		'promotionsList' => 'PromotionsList',
		'shipGroupList' => 'EstimateShipGroupList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
