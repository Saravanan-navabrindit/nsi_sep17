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

class CashRefund extends Record {
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
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
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
	 * Var string
	 */
	public $salesEffectiveDate;
	/**
	 * Var boolean
	 */
	public $refundCheck;
	/**
	 * Var boolean
	 */
	public $toPrint2;
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
	public $account;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
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
	 * Var \NetSuite\Classes\CashRefundHandlingMode
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
	 * Var \NetSuite\Classes\CashRefundPaymentOperation
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingTaxCode;
	/**
	 * Var float
	 */
	public $shippingTax1Rate;
	/**
	 * Var string
	 */
	public $shippingTax2Rate;
	/**
	 * Var float
	 */
	public $shippingCost;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $handlingTaxCode;
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
	public $paymentMethod;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
	/**
	 * Var boolean
	 */
	public $chargeIt;
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
	 * Var boolean
	 */
	public $ccApproved;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var string
	 */
	public $debitCardIssueNo;
	/**
	 * Var string
	 */
	public $pnRefNum;
	/**
	 * Var string
	 */
	public $validFrom;
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
	 * Var float
	 */
	public $discountTotal;
	/**
	 * Var boolean
	 */
	public $ccProcessAsPurchaseCard;
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
	 * Var string
	 */
	public $payPalStatus;
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
	public $payPalAuthId;
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
	public $payPalProcess;
	/**
	 * Var boolean
	 */
	public $vsoeAutoCalc;
	/**
	 * Var boolean
	 */
	public $syncPartnerTeams;
	/**
	 * Var \NetSuite\Classes\CashRefundItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\CashRefundSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\CashRefundPartnersList
	 */
	public $partnersList;
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
		'vatRegNum' => 'string',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'source' => 'string',
		'createdFrom' => 'RecordRef',
		'postingPeriod' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'leadSource' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'salesRep' => 'RecordRef',
		'partner' => 'RecordRef',
		'contribPct' => 'string',
		'otherRefNum' => 'string',
		'memo' => 'string',
		'salesEffectiveDate' => 'dateTime',
		'refundCheck' => 'boolean',
		'toPrint2' => 'boolean',
		'excludeCommission' => 'boolean',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
		'account' => 'RecordRef',
		'currency' => 'RecordRef',
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
		'email' => 'string',
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
		'handlingMode' => 'CashRefundHandlingMode',
		'outputAuthCode' => 'string',
		'outputReferenceCode' => 'string',
		'paymentOperation' => 'CashRefundPaymentOperation',
		'dynamicDescriptor' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'shipMethod' => 'RecordRef',
		'shippingTaxCode' => 'RecordRef',
		'shippingTax1Rate' => 'float',
		'shippingTax2Rate' => 'string',
		'shippingCost' => 'float',
		'handlingTaxCode' => 'RecordRef',
		'handlingTax1Rate' => 'float',
		'handlingTax2Rate' => 'string',
		'handlingCost' => 'float',
		'salesGroup' => 'RecordRef',
		'syncSalesTeams' => 'boolean',
		'paymentMethod' => 'RecordRef',
		'revenueStatus' => 'RevenueStatus',
		'recognizedRevenue' => 'float',
		'deferredRevenue' => 'float',
		'revRecOnRevCommitment' => 'boolean',
		'creditCard' => 'RecordRef',
		'chargeIt' => 'boolean',
		'ccNumber' => 'string',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'ccApproved' => 'boolean',
		'creditCardProcessor' => 'RecordRef',
		'debitCardIssueNo' => 'string',
		'pnRefNum' => 'string',
		'validFrom' => 'dateTime',
		'payPalTranId' => 'string',
		'subTotal' => 'float',
		'ccIsPurchaseCardBin' => 'boolean',
		'discountTotal' => 'float',
		'ccProcessAsPurchaseCard' => 'boolean',
		'taxTotal' => 'float',
		'tax2Total' => 'float',
		'altShippingCost' => 'float',
		'payPalStatus' => 'string',
		'altHandlingCost' => 'float',
		'total' => 'float',
		'payPalAuthId' => 'string',
		'status' => 'string',
		'job' => 'RecordRef',
		'giftCert' => 'RecordRef',
		'giftCertTotal' => 'float',
		'giftCertApplied' => 'float',
		'giftCertAvailable' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'payPalProcess' => 'boolean',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'itemList' => 'CashRefundItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'salesTeamList' => 'CashRefundSalesTeamList',
		'partnersList' => 'CashRefundPartnersList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
