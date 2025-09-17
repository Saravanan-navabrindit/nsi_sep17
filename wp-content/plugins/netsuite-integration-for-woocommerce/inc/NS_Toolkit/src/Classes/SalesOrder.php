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

class SalesOrder extends Record {
	/**
	 * Var string
	 */
	public $createdDate;
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
	public $job;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $drAccount;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $fxAccount;
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
	 * Var \NetSuite\Classes\SalesOrderOrderStatus
	 */
	public $orderStatus;
	/**
	 * Var string
	 */
	public $nextBill;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $opportunity;
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
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $promoCode;
	/**
	 * Var string
	 */
	public $currencyName;
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
	 * Var \NetSuite\Classes\SalesOrderHandlingMode
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
	 * Var \NetSuite\Classes\SalesOrderPaymentOperation
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
	 * Var string
	 */
	public $actualShipDate;
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
	 * Var boolean
	 */
	public $isMultiShipTo;
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
	 * Var string
	 */
	public $handlingTax2Rate;
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
	 * Var boolean
	 */
	public $shipComplete;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var string
	 */
	public $shopperIpAddress;
	/**
	 * Var boolean
	 */
	public $saveOnAuthDecline;
	/**
	 * Var boolean
	 */
	public $canHaveStackable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
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
	 * Var \NetSuite\Classes\RevenueCommitStatus
	 */
	public $revCommitStatus;
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
	 * Var string
	 */
	public $payPalStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var string
	 */
	public $payPalTranId;
	/**
	 * Var boolean
	 */
	public $ccApproved;
	/**
	 * Var boolean
	 */
	public $getAuth;
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
	 * Var \NetSuite\Classes\AvsMatchCode
	 */
	public $ccSecurityCodeMatch;
	/**
	 * Var float
	 */
	public $altSalesTotal;
	/**
	 * Var boolean
	 */
	public $ignoreAvs;
	/**
	 * Var \NetSuite\Classes\TransactionPaymentEventResult
	 */
	public $paymentEventResult;
	/**
	 * Var \NetSuite\Classes\TransactionPaymentEventHoldReason
	 */
	public $paymentEventHoldReason;
	/**
	 * Var \NetSuite\Classes\TransactionPaymentEventType
	 */
	public $paymentEventType;
	/**
	 * Var string
	 */
	public $paymentEventDate;
	/**
	 * Var string
	 */
	public $paymentEventUpdatedBy;
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
	 * Var string
	 */
	public $paypalAuthId;
	/**
	 * Var float
	 */
	public $balance;
	/**
	 * Var boolean
	 */
	public $paypalProcess;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $billingSchedule;
	/**
	 * Var string
	 */
	public $ccSecurityCode;
	/**
	 * Var string
	 */
	public $threeDStatusCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $intercoTransaction;
	/**
	 * Var \NetSuite\Classes\IntercoStatus
	 */
	public $intercoStatus;
	/**
	 * Var string
	 */
	public $debitCardIssueNo;
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
	 * Var string
	 */
	public $taxPointDate;
	/**
	 * Var boolean
	 */
	public $taxDetailsOverride;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $location;
	/**
	 * Var string
	 */
	public $pnRefNum;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $terms;
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
	 * Var \NetSuite\Classes\SalesOrderSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\SalesOrderPartnersList
	 */
	public $partnersList;
	/**
	 * Var \NetSuite\Classes\GiftCertRedemptionList
	 */
	public $giftCertRedemptionList;
	/**
	 * Var \NetSuite\Classes\PromotionsList
	 */
	public $promotionsList;
	/**
	 * Var \NetSuite\Classes\SalesOrderItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\SalesOrderShipGroupList
	 */
	public $shipGroupList;
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
		'customForm' => 'RecordRef',
		'entity' => 'RecordRef',
		'job' => 'RecordRef',
		'currency' => 'RecordRef',
		'drAccount' => 'RecordRef',
		'fxAccount' => 'RecordRef',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'source' => 'string',
		'createdFrom' => 'RecordRef',
		'orderStatus' => 'SalesOrderOrderStatus',
		'nextBill' => 'dateTime',
		'opportunity' => 'RecordRef',
		'salesRep' => 'RecordRef',
		'contribPct' => 'string',
		'partner' => 'RecordRef',
		'salesGroup' => 'RecordRef',
		'syncSalesTeams' => 'boolean',
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
		'exchangeRate' => 'float',
		'promoCode' => 'RecordRef',
		'currencyName' => 'string',
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
		'handlingMode' => 'SalesOrderHandlingMode',
		'outputAuthCode' => 'string',
		'outputReferenceCode' => 'string',
		'paymentOperation' => 'SalesOrderPaymentOperation',
		'dynamicDescriptor' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'shippingAddress' => 'Address',
		'shipIsResidential' => 'boolean',
		'shipAddressList' => 'RecordRef',
		'fob' => 'string',
		'shipDate' => 'dateTime',
		'actualShipDate' => 'dateTime',
		'shipMethod' => 'RecordRef',
		'shippingCost' => 'float',
		'shippingTax1Rate' => 'float',
		'isMultiShipTo' => 'boolean',
		'shippingTax2Rate' => 'string',
		'shippingTaxCode' => 'RecordRef',
		'handlingTaxCode' => 'RecordRef',
		'handlingTax1Rate' => 'float',
		'handlingTax2Rate' => 'string',
		'handlingCost' => 'float',
		'trackingNumbers' => 'string',
		'linkedTrackingNumbers' => 'string',
		'shipComplete' => 'boolean',
		'paymentMethod' => 'RecordRef',
		'shopperIpAddress' => 'string',
		'saveOnAuthDecline' => 'boolean',
		'canHaveStackable' => 'boolean',
		'creditCard' => 'RecordRef',
		'revenueStatus' => 'RevenueStatus',
		'recognizedRevenue' => 'float',
		'deferredRevenue' => 'float',
		'revRecOnRevCommitment' => 'boolean',
		'revCommitStatus' => 'RevenueCommitStatus',
		'ccNumber' => 'string',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'payPalStatus' => 'string',
		'creditCardProcessor' => 'RecordRef',
		'payPalTranId' => 'string',
		'ccApproved' => 'boolean',
		'getAuth' => 'boolean',
		'authCode' => 'string',
		'ccAvsStreetMatch' => 'AvsMatchCode',
		'ccAvsZipMatch' => 'AvsMatchCode',
		'isRecurringPayment' => 'boolean',
		'ccSecurityCodeMatch' => 'AvsMatchCode',
		'altSalesTotal' => 'float',
		'ignoreAvs' => 'boolean',
		'paymentEventResult' => 'TransactionPaymentEventResult',
		'paymentEventHoldReason' => 'TransactionPaymentEventHoldReason',
		'paymentEventType' => 'TransactionPaymentEventType',
		'paymentEventDate' => 'dateTime',
		'paymentEventUpdatedBy' => 'string',
		'subTotal' => 'float',
		'discountTotal' => 'float',
		'taxTotal' => 'float',
		'altShippingCost' => 'float',
		'altHandlingCost' => 'float',
		'total' => 'float',
		'revRecSchedule' => 'RecordRef',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'paypalAuthId' => 'string',
		'balance' => 'float',
		'paypalProcess' => 'boolean',
		'billingSchedule' => 'RecordRef',
		'ccSecurityCode' => 'string',
		'threeDStatusCode' => 'string',
		'class' => 'RecordRef',
        'custbody_ns_division' => 'RecordRef',
        'custcol_ns_division' => 'RecordRef',
        'department' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'intercoTransaction' => 'RecordRef',
		'intercoStatus' => 'IntercoStatus',
		'debitCardIssueNo' => 'string',
		'lastModifiedDate' => 'dateTime',
		'nexus' => 'RecordRef',
		'subsidiaryTaxRegNum' => 'RecordRef',
		'taxRegOverride' => 'boolean',
		'taxPointDate' => 'dateTime',
		'taxDetailsOverride' => 'boolean',
		'location' => 'RecordRef',
		'pnRefNum' => 'string',
		'status' => 'string',
		'tax2Total' => 'float',
		'terms' => 'RecordRef',
		'validFrom' => 'dateTime',
		'vatRegNum' => 'string',
		'giftCertApplied' => 'float',
		'oneTime' => 'float',
		'recurWeekly' => 'float',
		'recurMonthly' => 'float',
		'recurQuarterly' => 'float',
		'recurAnnually' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'salesTeamList' => 'SalesOrderSalesTeamList',
		'partnersList' => 'SalesOrderPartnersList',
		'giftCertRedemptionList' => 'GiftCertRedemptionList',
		'promotionsList' => 'PromotionsList',
		'itemList' => 'SalesOrderItemList',
		'shipGroupList' => 'SalesOrderShipGroupList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
