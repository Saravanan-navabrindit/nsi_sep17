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

class CreditMemo extends Record {
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
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var string
	 */
	public $vatRegNum;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
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
	 * Var string
	 */
	public $otherRefNum;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var boolean
	 */
	public $excludeCommission;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $leadSource;
	/**
	 * Var float
	 */
	public $balance;
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
	public $onCreditHold;
	/**
	 * Var float
	 */
	public $amountPaid;
	/**
	 * Var string
	 */
	public $salesEffectiveDate;
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
	 * Var string
	 */
	public $currencyName;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $promoCode;
	/**
	 * Var float
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $discountItem;
	/**
	 * Var string
	 */
	public $source;
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
	 * Var float
	 */
	public $unapplied;
	/**
	 * Var boolean
	 */
	public $autoApply;
	/**
	 * Var float
	 */
	public $applied;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $handlingTaxCode;
	/**
	 * Var string
	 */
	public $shippingTax2Rate;
	/**
	 * Var float
	 */
	public $handlingTax1Rate;
	/**
	 * Var string
	 */
	public $handlingTax2Rate;
	/**
	 * Var float
	 */
	public $handlingCost;
	/**
	 * Var float
	 */
	public $subTotal;
	/**
	 * Var float
	 */
	public $discountTotal;
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
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var float
	 */
	public $altShippingCost;
	/**
	 * Var float
	 */
	public $altHandlingCost;
	/**
	 * Var boolean
	 */
	public $isMultiShipTo;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
	/**
	 * Var boolean
	 */
	public $syncSalesTeams;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $giftCert;
	/**
	 * Var float
	 */
	public $giftCertTotal;
	/**
	 * Var float
	 */
	public $giftCertApplied;
	/**
	 * Var float
	 */
	public $giftCertAvailable;
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
	 * Var \NetSuite\Classes\CreditMemoSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\CreditMemoItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CreditMemoPartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\CreditMemoApplyList
	 */
	public $applyList;
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
		'currency' => 'RecordRef',
		'entity' => 'RecordRef',
		'vatRegNum' => 'string',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'createdFrom' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'job' => 'RecordRef',
		'salesRep' => 'RecordRef',
		'partner' => 'RecordRef',
		'contribPct' => 'string',
		'otherRefNum' => 'string',
		'memo' => 'string',
		'excludeCommission' => 'boolean',
		'leadSource' => 'RecordRef',
		'balance' => 'float',
		'account' => 'RecordRef',
		'exchangeRate' => 'float',
		'onCreditHold' => 'string',
		'amountPaid' => 'float',
		'salesEffectiveDate' => 'dateTime',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
		'currencyName' => 'string',
		'promoCode' => 'RecordRef',
		'amountRemaining' => 'float',
		'discountItem' => 'RecordRef',
		'source' => 'string',
		'discountRate' => 'string',
		'isTaxable' => 'boolean',
		'taxItem' => 'RecordRef',
		'taxRate' => 'float',
		'unapplied' => 'float',
		'autoApply' => 'boolean',
		'applied' => 'float',
		'toBePrinted' => 'boolean',
		'toBeEmailed' => 'boolean',
		'email' => 'string',
		'toBeFaxed' => 'boolean',
		'fax' => 'string',
		'messageSel' => 'RecordRef',
		'message' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'shipMethod' => 'RecordRef',
		'shippingCost' => 'float',
		'shippingTax1Rate' => 'float',
		'shippingTaxCode' => 'RecordRef',
		'handlingTaxCode' => 'RecordRef',
		'shippingTax2Rate' => 'string',
		'handlingTax1Rate' => 'float',
		'handlingTax2Rate' => 'string',
		'handlingCost' => 'float',
		'subTotal' => 'float',
		'discountTotal' => 'float',
		'revenueStatus' => 'RevenueStatus',
		'recognizedRevenue' => 'float',
		'deferredRevenue' => 'float',
		'revRecOnRevCommitment' => 'boolean',
		'taxTotal' => 'float',
		'tax2Total' => 'float',
		'altShippingCost' => 'float',
		'altHandlingCost' => 'float',
		'isMultiShipTo' => 'boolean',
		'total' => 'float',
		'salesGroup' => 'RecordRef',
		'syncSalesTeams' => 'boolean',
		'status' => 'string',
		'giftCert' => 'RecordRef',
		'giftCertTotal' => 'float',
		'giftCertApplied' => 'float',
		'giftCertAvailable' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'salesTeamList' => 'CreditMemoSalesTeamList',
		'itemList' => 'CreditMemoItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'partnersList' => 'CreditMemoPartnersList',
		'applyList' => 'CreditMemoApplyList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
