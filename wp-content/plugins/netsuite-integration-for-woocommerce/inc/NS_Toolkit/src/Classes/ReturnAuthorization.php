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

class ReturnAuthorization extends Record {
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
	 * Var string
	 */
	public $source;
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
	public $intercoTransaction;
	/**
	 * Var \NetSuite\Classes\IntercoStatus
	 */
	public $intercoStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $job;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $partner;
	/**
	 * Var string
	 */
	public $otherRefNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $leadSource;
	/**
	 * Var string
	 */
	public $memo;
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
	public $salesEffectiveDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $revRecSchedule;
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
	public $revRecStartDate;
	/**
	 * Var string
	 */
	public $revRecEndDate;
	/**
	 * Var boolean
	 */
	public $excludeCommission;
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
	public $discountItem;
	/**
	 * Var string
	 */
	public $discountRate;
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
	public $shipAddressList;
	/**
	 * Var string
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesGroup;
	/**
	 * Var boolean
	 */
	public $syncSalesTeams;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $paymentMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCard;
	/**
	 * Var string
	 */
	public $ccNumber;
	/**
	 * Var float
	 */
	public $altSalesTotal;
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
	 * Var string
	 */
	public $pnRefNum;
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
	public $total;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $creditCardProcessor;
	/**
	 * Var string
	 */
	public $payPalAuthId;
	/**
	 * Var boolean
	 */
	public $payPalProcess;
	/**
	 * Var string
	 */
	public $email;
	/**
	 * Var string
	 */
	public $fax;
	/**
	 * Var string
	 */
	public $debitCardIssueNo;
	/**
	 * Var boolean
	 */
	public $isTaxable;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $promoCode;
	/**
	 * Var string
	 */
	public $status;
	/**
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var float
	 */
	public $tax2Total;
	/**
	 * Var string
	 */
	public $validFrom;
	/**
	 * Var \NetSuite\Classes\ReturnAuthorizationOrderStatus
	 */
	public $orderStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $salesRep;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $giftCert;
	/**
	 * Var string
	 */
	public $contribPct;
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
	 * Var \NetSuite\Classes\ReturnAuthorizationItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\ReturnAuthorizationSalesTeamList
	 */
	public $salesTeamList;
	/**
	 * Var \NetSuite\Classes\ReturnAuthorizationPartnersList
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
		'currency' => 'RecordRef',
		'entity' => 'RecordRef',
		'vatRegNum' => 'string',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'source' => 'string',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'intercoTransaction' => 'RecordRef',
		'intercoStatus' => 'IntercoStatus',
		'job' => 'RecordRef',
		'partner' => 'RecordRef',
		'otherRefNum' => 'string',
		'leadSource' => 'RecordRef',
		'memo' => 'string',
		'drAccount' => 'RecordRef',
		'fxAccount' => 'RecordRef',
		'salesEffectiveDate' => 'dateTime',
		'createdFrom' => 'RecordRef',
		'revRecSchedule' => 'RecordRef',
		'totalCostEstimate' => 'float',
		'estGrossProfit' => 'float',
		'estGrossProfitPercent' => 'float',
		'revRecStartDate' => 'dateTime',
		'revRecEndDate' => 'dateTime',
		'excludeCommission' => 'boolean',
		'exchangeRate' => 'float',
		'currencyName' => 'string',
		'discountItem' => 'RecordRef',
		'discountRate' => 'string',
		'taxItem' => 'RecordRef',
		'taxRate' => 'float',
		'toBePrinted' => 'boolean',
		'toBeEmailed' => 'boolean',
		'toBeFaxed' => 'boolean',
		'messageSel' => 'RecordRef',
		'message' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'shipAddressList' => 'RecordRef',
		'shipAddress' => 'string',
		'salesGroup' => 'RecordRef',
		'syncSalesTeams' => 'boolean',
		'revenueStatus' => 'RevenueStatus',
		'recognizedRevenue' => 'float',
		'deferredRevenue' => 'float',
		'revRecOnRevCommitment' => 'boolean',
		'revCommitStatus' => 'RevenueCommitStatus',
		'paymentMethod' => 'RecordRef',
		'creditCard' => 'RecordRef',
		'ccNumber' => 'string',
		'altSalesTotal' => 'float',
		'ccExpireDate' => 'dateTime',
		'ccName' => 'string',
		'ccStreet' => 'string',
		'ccZipCode' => 'string',
		'ccApproved' => 'boolean',
		'pnRefNum' => 'string',
		'subTotal' => 'float',
		'discountTotal' => 'float',
		'total' => 'float',
		'creditCardProcessor' => 'RecordRef',
		'payPalAuthId' => 'string',
		'payPalProcess' => 'boolean',
		'email' => 'string',
		'fax' => 'string',
		'debitCardIssueNo' => 'string',
		'isTaxable' => 'boolean',
		'promoCode' => 'RecordRef',
		'status' => 'string',
		'taxTotal' => 'float',
		'tax2Total' => 'float',
		'validFrom' => 'dateTime',
		'orderStatus' => 'ReturnAuthorizationOrderStatus',
		'salesRep' => 'RecordRef',
		'giftCert' => 'RecordRef',
		'contribPct' => 'string',
		'giftCertTotal' => 'float',
		'giftCertApplied' => 'float',
		'giftCertAvailable' => 'float',
		'tranIsVsoeBundle' => 'boolean',
		'vsoeAutoCalc' => 'boolean',
		'syncPartnerTeams' => 'boolean',
		'itemList' => 'ReturnAuthorizationItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'salesTeamList' => 'ReturnAuthorizationSalesTeamList',
		'partnersList' => 'ReturnAuthorizationPartnersList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
