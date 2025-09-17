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

class CashSale extends Record {
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
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
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
	public $location;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
	/**
	 * Var boolean
	 */
	public $undepFunds;
	/**
	 * Var boolean
	 */
	public $canHaveStackable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $account;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentOption;
	/**
	 * Var string
	 */
	public $inputAuthCode;
	/**
	 * Var string
	 */
	public $inputReferenceCode;
	/**
	 * Var string
	 */
	public $checkNumber;
	/**
	 * Var string
	 */
	public $paymentCardCsc;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentProcessingProfile;
	/**
	 * Var \NetSuite\Classes\CashSaleHandlingMode
	 */
	public $handlingMode;
	/**
	 * Var string
	 */
	public $outputAuthCode;
	/**
	 * Var string
	 */
	public $outputReferenceCode;
	/**
	 * Var \NetSuite\Classes\CashSalePaymentOperation
	 */
	public $paymentOperation;
	/**
	 * Var string
	 */
	public $dynamicDescriptor;
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
	public $linkedTrackingNumbers;
	/**
	 * Var string
	 */
	public $trackingNumbers;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var string
	 */
	public $payPalStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
	/**
	 * Var string
	 */
	public $ccNumber;
	/**
	 * Var string
	 */
	public $ccExpireDate;
	/**
	 * Var string
	 */
	public $ccName;
	/**
	 * Var string
	 */
	public $ccStreet;
	/**
	 * Var string
	 */
	public $ccZipCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var boolean
	 */
	public $ccApproved;
	/**
	 * Var string
	 */
	public $authCode;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccAvsStreetMatch;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccAvsZipMatch;
	/**
	 * Var boolean
	 */
	public $isRecurringPayment;
	/**
	 * Var string
	 */
	public $payPalTranId;
	/**
	 * Var float
	 */
	public $subTotal;
	/**
	 * Var boolean
	 */
	public $ccIsPurchaseCardBin;
	/**
	 * Var boolean
	 */
	public $ignoreAvs;
	/**
	 * Var boolean
	 */
	public $ccProcessAsPurchaseCard;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemCostDiscount;
	/**
	 * Var string
	 */
	public $itemCostDiscRate;
	/**
	 * Var float
	 */
	public $itemCostDiscAmount;
	/**
	 * Var float
	 */
	public $itemCostTaxRate1;
	/**
	 * Var float
	 */
	public $itemCostTaxRate2;
	/**
	 * Var boolean
	 */
	public $itemCostDiscTaxable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $itemCostTaxCode;
	/**
	 * Var float
	 */
	public $itemCostDiscTax1Amt;
	/**
	 * Var boolean
	 */
	public $itemCostDiscPrint;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expCostDiscount;
	/**
	 * Var string
	 */
	public $expCostDiscRate;
	/**
	 * Var float
	 */
	public $expCostDiscAmount;
	/**
	 * Var boolean
	 */
	public $expCostDiscTaxable;
	/**
	 * Var boolean
	 */
	public $expCostDiscprint;
	/**
	 * Var float
	 */
	public $expCostTaxRate1;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeDiscount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $expCostTaxCode;
	/**
	 * Var string
	 */
	public $timeDiscRate;
	/**
	 * Var float
	 */
	public $expCostTaxRate2;
	/**
	 * Var float
	 */
	public $expCostDiscTax1Amt;
	/**
	 * Var float
	 */
	public $timeDiscAmount;
	/**
	 * Var boolean
	 */
	public $timeDiscTaxable;
	/**
	 * Var boolean
	 */
	public $timeDiscPrint;
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
	public $timeTaxRate1;
	/**
	 * Var float
	 */
	public $altShippingCost;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $timeTaxCode;
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
	public $timeDiscTax1Amt;
	/**
	 * Var string
	 */
	public $ccSecurityCode;
	/**
	 * Var float
	 */
	public $timeTaxRate2;
	/**
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccSecurityCodeMatch;
	/**
	 * Var boolean
	 */
	public $chargeIt;
	/**
	 * Var string
	 */
	public $debitCardIssueNo;
	/**
	 * Var string
	 */
	public $threeDStatusCode;
	/**
	 * Var string
	 */
	public $pnRefNum;
	/**
	 * Var string
	 */
	public $paypalAuthId;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var boolean
	 */
	public $paypalProcess;
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
	public $validFrom;
	/**
	 * Var string
	 */
	public $vatRegNum;
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
	 * Var \NetSuite\Classes\CashSaleSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\CashSalePartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\CashSaleItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CashSaleItemCostList
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
	 * Var \NetSuite\Classes\CashSaleExpCostList
	 */
	public $expCostList;
	/**
	 * Var \NetSuite\Classes\CashSaleTimeList
	 */
	public $timeList;
	/**
	 * Var \NetSuite\Classes\CashSaleShipGroupList
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
		'customForm' => 'RecordRef',
		'entity' => 'RecordRef',
		'billingAccount' => 'RecordRef',
		'recurringBill' => 'boolean',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'source' => 'string',
		'postingPeriod' => 'RecordRef',
		'createdFrom' => 'RecordRef',
		'opportunity' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
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
		'revRecSchedule' => 'RecordRef',
		'undepFunds' => 'boolean',
		'canHaveStackable' => 'boolean',
		'currency' => 'RecordRef',
		'account' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
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
		'paymentOption' => 'RecordRef',
		'inputAuthCode' => 'string',
		'inputReferenceCode' => 'string',
		'checkNumber' => 'string',
		'paymentCardCsc' => 'string',
		'paymentProcessingProfile' => 'RecordRef',
		'handlingMode' => 'CashSaleHandlingMode',
		'outputAuthCode' => 'string',
		'outputReferenceCode' => 'string',
		'paymentOperation' => 'CashSalePaymentOperation',
		'dynamicDescriptor' => 'string',
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
		'linkedTrackingNumbers' => 'string',
		'trackingNumbers' => 'string',
		'salesGroup' => 'RecordRef',
		'revenueStatus' => 'RevenueStatus',
		'recognizedRevenue' => 'float',
		'deferredRevenue' => 'float',
		'revRecOnRevCommitment' => 'boolean',
		'syncSalesTeams' => 'boolean',
		'paymentMethod' => 'RecordRef',
		'payPalStatus' => 'string',
		'creditCard' => 'RecordRef',
		'ccNumber' => 'string',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'creditCardProcessor' => 'RecordRef',
		'ccApproved' => 'boolean',
		'authCode' => 'string',
		'ccAvsStreetMatch' => 'AvsMatchCode',
		'ccAvsZipMatch' => 'AvsMatchCode',
		'isRecurringPayment' => 'boolean',
		'payPalTranId' => 'string',
		'subTotal' => 'float',
		'ccIsPurchaseCardBin' => 'boolean',
		'ignoreAvs' => 'boolean',
		'ccProcessAsPurchaseCard' => 'boolean',
		'itemCostDiscount' => 'RecordRef',
		'itemCostDiscRate' => 'string',
		'itemCostDiscAmount' => 'float',
		'itemCostTaxRate1' => 'float',
		'itemCostTaxRate2' => 'float',
		'itemCostDiscTaxable' => 'boolean',
		'itemCostTaxCode' => 'RecordRef',
		'itemCostDiscTax1Amt' => 'float',
		'itemCostDiscPrint' => 'boolean',
		'expCostDiscount' => 'RecordRef',
		'expCostDiscRate' => 'string',
		'expCostDiscAmount' => 'float',
		'expCostDiscTaxable' => 'boolean',
		'expCostDiscprint' => 'boolean',
		'expCostTaxRate1' => 'float',
		'timeDiscount' => 'RecordRef',
		'expCostTaxCode' => 'RecordRef',
		'timeDiscRate' => 'string',
		'expCostTaxRate2' => 'float',
		'expCostDiscTax1Amt' => 'float',
		'timeDiscAmount' => 'float',
		'timeDiscTaxable' => 'boolean',
		'timeDiscPrint' => 'boolean',
		'discountTotal' => 'float',
		'taxTotal' => 'float',
		'timeTaxRate1' => 'float',
		'altShippingCost' => 'float',
		'timeTaxCode' => 'RecordRef',
		'altHandlingCost' => 'float',
		'total' => 'float',
		'timeDiscTax1Amt' => 'float',
		'ccSecurityCode' => 'string',
		'timeTaxRate2' => 'float',
		'ccSecurityCodeMatch' => 'AvsMatchCode',
		'chargeIt' => 'boolean',
		'debitCardIssueNo' => 'string',
		'threeDStatusCode' => 'string',
		'pnRefNum' => 'string',
		'paypalAuthId' => 'string',
		'status' => 'string',
		'paypalProcess' => 'boolean',
		'job' => 'RecordRef',
		'billingSchedule' => 'RecordRef',
		'email' => 'string',
		'tax2Total' => 'float',
		'validFrom' => 'dateTime',
		'vatRegNum' => 'string',
		'giftCertApplied' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'salesTeamList' => 'CashSaleSalesTeamList',
		'partnersList' => 'CashSalePartnersList',
		'itemList' => 'CashSaleItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'itemCostList' => 'CashSaleItemCostList',
		'giftCertRedemptionList' => 'GiftCertRedemptionList',
		'promotionsList' => 'PromotionsList',
		'expCostList' => 'CashSaleExpCostList',
		'timeList' => 'CashSaleTimeList',
		'shipGroupList' => 'CashSaleShipGroupList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
