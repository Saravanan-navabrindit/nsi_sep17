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

class CustomSale extends Record {
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
	public $tranType;
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
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingAccount;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $tranStatus;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
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
	public $isMultiShipTo;
	/**
	 * Var boolean
	 */
	public $isTaxable;
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
	public $handlingCost;
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
	 * Var string
	 */
	public $email;
	/**
	 * Var float
	 */
	public $giftCertApplied;
	/**
	 * Var boolean
	 */
	public $tranIsVsoeBundle;
	/**
	 * Var boolean
	 */
	public $vsoeAutoCalc;
	/**
	 * Var boolean
	 */
	public $syncPartnerTeams;
	/**
	 * Var \NetSuite\Classes\CustomSaleShipGroupList
	 */
	public $shipGroupList;
	/**
	 * Var boolean
	 */
	public $overrideInstallments;
	/**
	 * Var \NetSuite\Classes\InstallmentList
	 */
	public $installmentList;
	/**
	 * Var \NetSuite\Classes\CustomSalePartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\PromotionsList
	 */
	public $promotionsList;
	/**
	 * Var \NetSuite\Classes\CustomSaleItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\GiftCertRedemptionList
	 */
	public $giftCertRedemptionList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CustomSaleSalesTeamList
	 */
	public $salesTeamList;
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
		'tranType' => 'RecordRef',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxDetailsOverride' => 'boolean',
		'customForm' => 'RecordRef',
		'entity' => 'RecordRef',
		'billingAccount' => 'RecordRef',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
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
		'partner' => 'RecordRef',
		'leadSource' => 'RecordRef',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'otherRefNum' => 'string',
		'memo' => 'string',
		'tranStatus' => 'RecordRef',
		'salesEffectiveDate' => 'dateTime',
		'excludeCommission' => 'boolean',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'account' => 'RecordRef',
		'exchangeRate' => 'float',
		'currencyName' => 'string',
		'promoCode' => 'RecordRef',
		'discountItem' => 'RecordRef',
		'discountRate' => 'string',
		'isMultiShipTo' => 'boolean',
		'isTaxable' => 'boolean',
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
		'handlingCost' => 'float',
		'trackingNumbers' => 'string',
		'linkedTrackingNumbers' => 'string',
		'salesGroup' => 'RecordRef',
		'subTotal' => 'float',
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
		'email' => 'string',
		'giftCertApplied' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'shipGroupList' => 'CustomSaleShipGroupList',
		'overrideInstallments' => 'boolean',
		'installmentList' => 'InstallmentList',
		'partnersList' => 'CustomSalePartnersList',
		'promotionsList' => 'PromotionsList',
		'itemList' => 'CustomSaleItemList',
		'giftCertRedemptionList' => 'GiftCertRedemptionList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'salesTeamList' => 'CustomSaleSalesTeamList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
