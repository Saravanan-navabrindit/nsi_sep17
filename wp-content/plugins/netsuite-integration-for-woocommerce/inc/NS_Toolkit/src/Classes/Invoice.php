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

class Invoice extends Record {
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
	public $customForm;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nextApprover;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingAccount;
	/**
	 * Var boolean
	 */
	public $recurringBill;
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
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
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
	public $currency;
	/**
	 * Var string
	 */
	public $dueDate;
	/**
	 * Var string
	 */
	public $discountDate;
	/**
	 * Var float
	 */
	public $discountAmount;
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
	public $leadSource;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
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
	public $salesEffectiveDate;
	/**
	 * Var boolean
	 */
	public $excludeCommission;
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
	public $revRecSchedule;
	/**
	 * Var string
	 */
	public $revRecStartDate;
	/**
	 * Var string
	 */
	public $revRecEndDate;
	/**
	 * Var float
	 */
	public $amountPaid;
	/**
	 * Var float
	 */
	public $amountRemaining;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
	/**
	 * Var string
	 */
	public $onCreditHold;
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
	 * Var boolean
	 */
	public $toBePrinted;
	/**
	 * Var boolean
	 */
	public $toBeEmailed;
	/**
	 * Var boolean
	 */
	public $toBeFaxed;
	/**
	 * Var string
	 */
	public $fax;
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
	 * Var string
	 */
	public $shippingTax2Rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingTaxCode;
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
	public $handlingTax2Rate;
	/**
	 * Var string
	 */
	public $trackingNumbers;
	/**
	 * Var string
	 */
	public $linkedTrackingNumbers;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
	/**
	 * Var float
	 */
	public $subTotal;
	/**
	 * Var boolean
	 */
	public $canHaveStackable;
	/**
	 * Var \NetSuite\Classes\RevenueStatus
	 */
	public $revenueStatus;
	/**
	 * Var float
	 */
	public $recognizedRevenue;
	/**
	 * Var float
	 */
	public $deferredRevenue;
	/**
	 * Var boolean
	 */
	public $revRecOnRevCommitment;
	/**
	 * Var boolean
	 */
	public $syncSalesTeams;
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
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var string
	 */
	public $vatRegNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expCostDiscount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemCostDiscount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeDiscount;
	/**
	 * Var string
	 */
	public $expCostDiscRate;
	/**
	 * Var string
	 */
	public $itemCostDiscRate;
	/**
	 * Var string
	 */
	public $timeDiscRate;
	/**
	 * Var float
	 */
	public $expCostDiscAmount;
	/**
	 * Var float
	 */
	public $expCostTaxRate1;
	/**
	 * Var float
	 */
	public $expCostTaxRate2;
	/**
	 * Var float
	 */
	public $itemCostDiscAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expCostTaxCode;
	/**
	 * Var float
	 */
	public $expCostDiscTax1Amt;
	/**
	 * Var float
	 */
	public $itemCostTaxRate1;
	/**
	 * Var float
	 */
	public $timeDiscAmount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemCostTaxCode;
	/**
	 * Var boolean
	 */
	public $expCostDiscTaxable;
	/**
	 * Var boolean
	 */
	public $itemCostDiscTaxable;
	/**
	 * Var float
	 */
	public $itemCostTaxRate2;
	/**
	 * Var float
	 */
	public $itemCostDiscTax1Amt;
	/**
	 * Var boolean
	 */
	public $itemCostDiscPrint;
	/**
	 * Var boolean
	 */
	public $timeDiscTaxable;
	/**
	 * Var float
	 */
	public $timeTaxRate1;
	/**
	 * Var boolean
	 */
	public $expCostDiscPrint;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeTaxCode;
	/**
	 * Var boolean
	 */
	public $timeDiscPrint;
	/**
	 * Var float
	 */
	public $giftCertApplied;
	/**
	 * Var float
	 */
	public $timeDiscTax1Amt;
	/**
	 * Var boolean
	 */
	public $tranIsVsoeBundle;
	/**
	 * Var float
	 */
	public $timeTaxRate2;
	/**
	 * Var boolean
	 */
	public $vsoeAutoCalc;
	/**
	 * Var boolean
	 */
	public $syncPartnerTeams;
	/**
	 * Var \NetSuite\Classes\InvoiceSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\InvoicePartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\InvoiceItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\InvoiceItemCostList
	 */
	public $itemCostList;
	/**
	 * Var \NetSuite\Classes\GiftCertRedemptionList
	 */
	public $giftCertRedemptionList;
	/**
	 * Var \NetSuite\Classes\PromotionsList
	 */
	public $promotionsList;
	/**
	 * Var \NetSuite\Classes\InvoiceExpCostList
	 */
	public $expCostList;
	/**
	 * Var \NetSuite\Classes\InvoiceTimeList
	 */
	public $timeList;
	/**
	 * Var \NetSuite\Classes\InvoiceShipGroupList
	 */
	public $shipGroupList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approvalStatus;
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
		'createdDate' => 'dateTime',
		'lastModifiedDate' => 'dateTime',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxDetailsOverride' => 'boolean',
		'customForm' => 'RecordRef',
		'nextApprover' => 'RecordRef',
		'entity' => 'RecordRef',
		'billingAccount' => 'RecordRef',
		'recurringBill' => 'boolean',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'source' => 'string',
		'createdFrom' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'opportunity' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'terms' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'currency' => 'RecordRef',
		'dueDate' => 'dateTime',
		'discountDate' => 'dateTime',
		'discountAmount' => 'float',
		'salesRep' => 'RecordRef',
		'contribPct' => 'string',
		'partner' => 'RecordRef',
		'leadSource' => 'RecordRef',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'otherRefNum' => 'string',
		'memo' => 'string',
		'salesEffectiveDate' => 'dateTime',
		'excludeCommission' => 'boolean',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'amountPaid' => 'float',
		'amountRemaining' => 'float',
		'balance' => 'float',
		'account' => 'RecordRef',
		'onCreditHold' => 'string',
		'exchangeRate' => 'float',
		'currencyName' => 'string',
		'promoCode' => 'RecordRef',
		'discountItem' => 'RecordRef',
		'discountRate' => 'string',
		'isTaxable' => 'boolean',
		'taxItem' => 'RecordRef',
		'taxRate' => 'float',
		'toBePrinted' => 'boolean',
		'toBeEmailed' => 'boolean',
		'toBeFaxed' => 'boolean',
		'fax' => 'string',
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
		'shippingTax2Rate' => 'string',
		'shippingTaxCode' => 'RecordRef',
		'handlingTaxCode' => 'RecordRef',
		'handlingTax1Rate' => 'float',
		'handlingCost' => 'float',
		'handlingTax2Rate' => 'string',
		'trackingNumbers' => 'string',
		'linkedTrackingNumbers' => 'string',
		'salesGroup' => 'RecordRef',
		'subTotal' => 'float',
		'canHaveStackable' => 'boolean',
		'revenueStatus' => 'RevenueStatus',
		'recognizedRevenue' => 'float',
		'deferredRevenue' => 'float',
		'revRecOnRevCommitment' => 'boolean',
		'syncSalesTeams' => 'boolean',
		'discountTotal' => 'float',
		'taxTotal' => 'float',
		'altShippingCost' => 'float',
		'altHandlingCost' => 'float',
		'total' => 'float',
		'status' => 'string',
		'job' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'email' => 'string',
		'tax2Total' => 'float',
		'vatRegNum' => 'string',
		'expCostDiscount' => 'RecordRef',
		'itemCostDiscount' => 'RecordRef',
		'timeDiscount' => 'RecordRef',
		'expCostDiscRate' => 'string',
		'itemCostDiscRate' => 'string',
		'timeDiscRate' => 'string',
		'expCostDiscAmount' => 'float',
		'expCostTaxRate1' => 'float',
		'expCostTaxRate2' => 'float',
		'itemCostDiscAmount' => 'float',
		'expCostTaxCode' => 'RecordRef',
		'expCostDiscTax1Amt' => 'float',
		'itemCostTaxRate1' => 'float',
		'timeDiscAmount' => 'float',
		'itemCostTaxCode' => 'RecordRef',
		'expCostDiscTaxable' => 'boolean',
		'itemCostDiscTaxable' => 'boolean',
		'itemCostTaxRate2' => 'float',
		'itemCostDiscTax1Amt' => 'float',
		'itemCostDiscPrint' => 'boolean',
		'timeDiscTaxable' => 'boolean',
		'timeTaxRate1' => 'float',
		'expCostDiscPrint' => 'boolean',
		'timeTaxCode' => 'RecordRef',
		'timeDiscPrint' => 'boolean',
		'giftCertApplied' => 'float',
		'timeDiscTax1Amt' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'timeTaxRate2' => 'float',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'salesTeamList' => 'InvoiceSalesTeamList',
		'partnersList' => 'InvoicePartnersList',
		'itemList' => 'InvoiceItemList',
		'itemCostList' => 'InvoiceItemCostList',
		'giftCertRedemptionList' => 'GiftCertRedemptionList',
		'promotionsList' => 'PromotionsList',
		'expCostList' => 'InvoiceExpCostList',
		'timeList' => 'InvoiceTimeList',
		'shipGroupList' => 'InvoiceShipGroupList',
		'approvalStatus' => 'RecordRef',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
