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

class TransactionSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $abbrev;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $accountType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $acctCorpCardExp;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $actualProductionEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $actualProductionStartDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $actualShipDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $altSalesAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $altSalesNetAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amountPaid;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $amountUnbilled;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $appliedToForeignAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $appliedToIsFxVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $appliedToLinkAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $appliedToLinkType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $appliedToTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $applyingForeignAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $applyingIsFxVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $applyingLinkAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $applyingLinkType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $applyingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $authCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $autoCalculateLag;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $avsStreetMatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $avsZipMatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $billable;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddress3;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAddressee;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billAttention;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billCity;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $billCountry;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billCountryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $billedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $billingAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $billingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billPhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billState;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $billVarianceStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $billZip;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $binNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $binNumberQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $buildEntireAssembly;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $buildVariance;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $built;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $canHaveStackablePromotions;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $catchUpPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccCustomerCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $ccExpDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccHolderName;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccStreet;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $ccZipCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $cleared;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $closed;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $closeDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $cogsAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $commissionEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $commit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $componentYield;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $confirmationNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $contribution;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $contributionPrimary;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costComponentAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $costComponentCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $costComponentItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costComponentQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costComponentStandardCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $costEstimateRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $costEstimateType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $createdBy;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $creditAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $cscMatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $customGL;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
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
	public $daysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $debitAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $deferredRevenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $depositDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $depositTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $discountAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $docUnit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $drAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $effectiveRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
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
	public $estGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estGrossProfitPct;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $estGrossProfitPercent;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $excludeCommission;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $excludeFromRateRequest;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expectedCloseDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expectedReceiptDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $expenseCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $expenseDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $firmed;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $forecastType;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $fulfillingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $fxAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxCostEstimateRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxTranCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxVsoeAllocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxVsoeAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $fxVsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $gcoAvailabelToCharge;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $gcoAvailableToRefund;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $gcoAvsStreetMatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $gcoAvsZipMatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $gcoBuyerAccountAge;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoBuyerIp;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoChargeAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoChargebackAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoConfirmedChargedTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoConfirmedRefundedTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoCreditcardNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $gcoCscMatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoFinancialState;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoFulfillmentState;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoOrderId;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoOrderTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoPromotionAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoPromotionName;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoRefundAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $gcoShippingTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $gcoStateChangedDetail;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $giftCert;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $grossAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $includeInForecast;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $incoterm;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $intercoStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $intercoTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $inventoryLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $inventorySubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $inVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isAllocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isBackflush;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isGcoChargeback;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isGcoChargeConfirmed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isGcoPaymentGuaranteed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isGcoRefundConfirmed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInsideDelivery;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInsidePickup;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isIntercompanyAdjustment;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInTransitPayment;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isMultiShipTo;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isReversal;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isRevRecTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isScrap;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isShipAddress;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isTransferPriceCosting;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isWip;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $itemFulfillmentChoice;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $itemRevision;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $landedCostPerLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $line;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $lineSequenceNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $lineUniqueKey;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $locationAutoAssigned;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $mainLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $mainName;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $manufacturingRouting;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $matchBillToReceipt;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $memoMain;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $memorized;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $merchantAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $multiSubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $netAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $netAmountNoTax;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $nextApprover;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $nextBillDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $noAutoAssignLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $nonReimbursable;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $oneTimeTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $opportunity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $options;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $orderAllocationStrategy;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $orderPriority;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $originator;
	/**
	 * Var \NetSuite\Classes\SearchColumnTextNumberField[]
	 */
	public $otherRefNum;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $overheadParentItem;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $overrideInstallments;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $packageCount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $paidAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $paidTransaction;
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
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $payingAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $payingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $paymentApproved;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $paymentEventDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $paymentEventHoldReason;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $paymentEventPurchaseCardUsed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $paymentEventPurchaseDataSent;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $paymentEventResult;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $paymentEventType;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $paymentHold;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $paymentMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $paymentOption;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $payPalPending;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $payPalStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $payPalTranId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $payrollBatch;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $pnRefNum;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $poRate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $posting;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $print;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $probability;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $projectedAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $projectTask;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $purchaseOrder;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityBilled;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityPacked;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityPicked;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityRevCommitted;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityShipRecv;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $quantityUom;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $realizedGainPostingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recognizedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $recordType;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recurAnnuallyTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recurMonthlyTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recurQuarterlyTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $recurringBill;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $recurWeeklyTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $refNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $requestedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $revCommitStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $revCommittingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $revenueStatus;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $reversalDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $reversalNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $revRecEndDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $revRecOnRevCommitment;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $revRecStartDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $rgAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $rgAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $salesEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $salesOrder;
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
	public $schedulingMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serialNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $serialNumberCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $serialNumberCostAdjustment;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $serialNumberQuantity;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $serialNumbers;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress1;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress2;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddress3;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAddressee;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipAttention;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $shipCarrier;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipCity;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $shipComplete;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $shipCountry;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipCountryCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $shipDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $shipGroup;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $shipMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipPhone;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $shippingAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $shipRecvStatusLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipState;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $shipTo;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $shipZip;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $signedAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $subsidiaryTaxRegNum;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $taxAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $taxLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $taxPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $taxPointDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $taxTotal;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $termInMonths;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $terms;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $termsOfSale;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $toBeEmailed;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $toBePrinted;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $toSubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $totalCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $trackingNumbers;
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
	public $tranFxEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $tranId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $tranIsVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $transactionDiscount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $transactionLineType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $transactionNumber;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $transferLocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $transferOrderItemLine;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $transferOrderQuantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $transferOrderQuantityPacked;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $transferOrderQuantityPicked;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $transferOrderQuantityReceived;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $transferOrderQuantityShipped;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $unit;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $unitCostOverride;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $vendType;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $visibleToCustomer;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vsoeAllocation;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vsoeAmount;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $vsoeDelivered;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $vsoePermitDiscount;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $vsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $webSite;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'abbrev' => 'SearchColumnStringField[]',
		'account' => 'SearchColumnSelectField[]',
		'accountType' => 'SearchColumnEnumSelectField[]',
		'acctCorpCardExp' => 'SearchColumnSelectField[]',
		'actualProductionEndDate' => 'SearchColumnDateField[]',
		'actualProductionStartDate' => 'SearchColumnDateField[]',
		'actualShipDate' => 'SearchColumnDateField[]',
		'altSalesAmount' => 'SearchColumnDoubleField[]',
		'altSalesNetAmount' => 'SearchColumnDoubleField[]',
		'amount' => 'SearchColumnDoubleField[]',
		'amountPaid' => 'SearchColumnDoubleField[]',
		'amountRemaining' => 'SearchColumnDoubleField[]',
		'amountUnbilled' => 'SearchColumnDoubleField[]',
		'appliedToForeignAmount' => 'SearchColumnDoubleField[]',
		'appliedToIsFxVariance' => 'SearchColumnBooleanField[]',
		'appliedToLinkAmount' => 'SearchColumnDoubleField[]',
		'appliedToLinkType' => 'SearchColumnStringField[]',
		'appliedToTransaction' => 'SearchColumnSelectField[]',
		'applyingForeignAmount' => 'SearchColumnDoubleField[]',
		'applyingIsFxVariance' => 'SearchColumnBooleanField[]',
		'applyingLinkAmount' => 'SearchColumnDoubleField[]',
		'applyingLinkType' => 'SearchColumnStringField[]',
		'applyingTransaction' => 'SearchColumnSelectField[]',
		'approvalStatus' => 'SearchColumnEnumSelectField[]',
		'authCode' => 'SearchColumnStringField[]',
		'autoCalculateLag' => 'SearchColumnBooleanField[]',
		'avsStreetMatch' => 'SearchColumnEnumSelectField[]',
		'avsZipMatch' => 'SearchColumnEnumSelectField[]',
		'billable' => 'SearchColumnBooleanField[]',
		'billAddress' => 'SearchColumnStringField[]',
		'billAddress1' => 'SearchColumnStringField[]',
		'billAddress2' => 'SearchColumnStringField[]',
		'billAddress3' => 'SearchColumnStringField[]',
		'billAddressee' => 'SearchColumnStringField[]',
		'billAttention' => 'SearchColumnStringField[]',
		'billCity' => 'SearchColumnStringField[]',
		'billCountry' => 'SearchColumnEnumSelectField[]',
		'billCountryCode' => 'SearchColumnStringField[]',
		'billedDate' => 'SearchColumnDateField[]',
		'billingAccount' => 'SearchColumnSelectField[]',
		'billingAmount' => 'SearchColumnDoubleField[]',
		'billingSchedule' => 'SearchColumnSelectField[]',
		'billingTransaction' => 'SearchColumnSelectField[]',
		'billPhone' => 'SearchColumnStringField[]',
		'billState' => 'SearchColumnStringField[]',
		'billVarianceStatus' => 'SearchColumnEnumSelectField[]',
		'billZip' => 'SearchColumnStringField[]',
		'binNumber' => 'SearchColumnStringField[]',
		'binNumberQuantity' => 'SearchColumnDoubleField[]',
		'bomQuantity' => 'SearchColumnDoubleField[]',
		'buildEntireAssembly' => 'SearchColumnBooleanField[]',
		'buildVariance' => 'SearchColumnDoubleField[]',
		'built' => 'SearchColumnDoubleField[]',
		'canHaveStackablePromotions' => 'SearchColumnBooleanField[]',
		'catchUpPeriod' => 'SearchColumnStringField[]',
		'ccCustomerCode' => 'SearchColumnStringField[]',
		'ccExpDate' => 'SearchColumnDateField[]',
		'ccHolderName' => 'SearchColumnStringField[]',
		'ccNumber' => 'SearchColumnStringField[]',
		'ccStreet' => 'SearchColumnStringField[]',
		'ccZipCode' => 'SearchColumnStringField[]',
		'class' => 'SearchColumnSelectField[]',
		'cleared' => 'SearchColumnBooleanField[]',
		'closed' => 'SearchColumnBooleanField[]',
		'closeDate' => 'SearchColumnDateField[]',
		'cogsAmount' => 'SearchColumnDoubleField[]',
		'commissionEffectiveDate' => 'SearchColumnDateField[]',
		'commit' => 'SearchColumnEnumSelectField[]',
		'componentYield' => 'SearchColumnDoubleField[]',
		'confirmationNumber' => 'SearchColumnStringField[]',
		'contribution' => 'SearchColumnDoubleField[]',
		'contributionPrimary' => 'SearchColumnDoubleField[]',
		'costComponentAmount' => 'SearchColumnDoubleField[]',
		'costComponentCategory' => 'SearchColumnStringField[]',
		'costComponentItem' => 'SearchColumnStringField[]',
		'costComponentQuantity' => 'SearchColumnDoubleField[]',
		'costComponentStandardCost' => 'SearchColumnDoubleField[]',
		'costEstimate' => 'SearchColumnDoubleField[]',
		'costEstimateRate' => 'SearchColumnDoubleField[]',
		'costEstimateType' => 'SearchColumnEnumSelectField[]',
		'createdBy' => 'SearchColumnSelectField[]',
		'createdFrom' => 'SearchColumnSelectField[]',
		'creditAmount' => 'SearchColumnDoubleField[]',
		'cscMatch' => 'SearchColumnEnumSelectField[]',
		'currency' => 'SearchColumnSelectField[]',
		'customForm' => 'SearchColumnSelectField[]',
		'customGL' => 'SearchColumnBooleanField[]',
		'custType' => 'SearchColumnSelectField[]',
		'dateCreated' => 'SearchColumnDateField[]',
		'daysOpen' => 'SearchColumnLongField[]',
		'daysOverdue' => 'SearchColumnLongField[]',
		'debitAmount' => 'SearchColumnDoubleField[]',
		'deferredRevenue' => 'SearchColumnDoubleField[]',
		'deferRevRec' => 'SearchColumnBooleanField[]',
		'department' => 'SearchColumnSelectField[]',
		'depositDate' => 'SearchColumnDateField[]',
		'depositTransaction' => 'SearchColumnSelectField[]',
		'discountAmount' => 'SearchColumnDoubleField[]',
		'docUnit' => 'SearchColumnStringField[]',
		'drAccount' => 'SearchColumnStringField[]',
		'dueDate' => 'SearchColumnDateField[]',
		'effectiveRate' => 'SearchColumnDoubleField[]',
		'email' => 'SearchColumnStringField[]',
		'endDate' => 'SearchColumnDateField[]',
		'entity' => 'SearchColumnSelectField[]',
		'entityStatus' => 'SearchColumnSelectField[]',
		'estGrossProfit' => 'SearchColumnDoubleField[]',
		'estGrossProfitPct' => 'SearchColumnDoubleField[]',
		'estGrossProfitPercent' => 'SearchColumnDoubleField[]',
		'exchangeRate' => 'SearchColumnDoubleField[]',
		'excludeCommission' => 'SearchColumnBooleanField[]',
		'excludeFromRateRequest' => 'SearchColumnBooleanField[]',
		'expectedCloseDate' => 'SearchColumnDateField[]',
		'expectedReceiptDate' => 'SearchColumnDateField[]',
		'expenseCategory' => 'SearchColumnSelectField[]',
		'expenseDate' => 'SearchColumnDateField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'firmed' => 'SearchColumnBooleanField[]',
		'forecastType' => 'SearchColumnEnumSelectField[]',
		'fulfillingTransaction' => 'SearchColumnSelectField[]',
		'fxAccount' => 'SearchColumnStringField[]',
		'fxAmount' => 'SearchColumnDoubleField[]',
		'fxCostEstimate' => 'SearchColumnDoubleField[]',
		'fxCostEstimateRate' => 'SearchColumnDoubleField[]',
		'fxEstGrossProfit' => 'SearchColumnDoubleField[]',
		'fxTranCostEstimate' => 'SearchColumnDoubleField[]',
		'fxVsoeAllocation' => 'SearchColumnDoubleField[]',
		'fxVsoeAmount' => 'SearchColumnDoubleField[]',
		'fxVsoePrice' => 'SearchColumnDoubleField[]',
		'gcoAvailabelToCharge' => 'SearchColumnBooleanField[]',
		'gcoAvailableToRefund' => 'SearchColumnBooleanField[]',
		'gcoAvsStreetMatch' => 'SearchColumnEnumSelectField[]',
		'gcoAvsZipMatch' => 'SearchColumnEnumSelectField[]',
		'gcoBuyerAccountAge' => 'SearchColumnLongField[]',
		'gcoBuyerIp' => 'SearchColumnStringField[]',
		'gcoChargeAmount' => 'SearchColumnDoubleField[]',
		'gcoChargebackAmount' => 'SearchColumnDoubleField[]',
		'gcoConfirmedChargedTotal' => 'SearchColumnDoubleField[]',
		'gcoConfirmedRefundedTotal' => 'SearchColumnDoubleField[]',
		'gcoCreditcardNumber' => 'SearchColumnStringField[]',
		'gcoCscMatch' => 'SearchColumnEnumSelectField[]',
		'gcoFinancialState' => 'SearchColumnStringField[]',
		'gcoFulfillmentState' => 'SearchColumnStringField[]',
		'gcoOrderId' => 'SearchColumnStringField[]',
		'gcoOrderTotal' => 'SearchColumnDoubleField[]',
		'gcoPromotionAmount' => 'SearchColumnDoubleField[]',
		'gcoPromotionName' => 'SearchColumnStringField[]',
		'gcoRefundAmount' => 'SearchColumnDoubleField[]',
		'gcoShippingTotal' => 'SearchColumnDoubleField[]',
		'gcoStateChangedDetail' => 'SearchColumnStringField[]',
		'giftCert' => 'SearchColumnStringField[]',
		'grossAmount' => 'SearchColumnDoubleField[]',
		'includeInForecast' => 'SearchColumnBooleanField[]',
		'incoterm' => 'SearchColumnSelectField[]',
		'intercoStatus' => 'SearchColumnEnumSelectField[]',
		'intercoTransaction' => 'SearchColumnStringField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'inventoryLocation' => 'SearchColumnSelectField[]',
		'inventorySubsidiary' => 'SearchColumnSelectField[]',
		'inVsoeBundle' => 'SearchColumnBooleanField[]',
		'isAllocation' => 'SearchColumnBooleanField[]',
		'isBackflush' => 'SearchColumnBooleanField[]',
		'isGcoChargeback' => 'SearchColumnBooleanField[]',
		'isGcoChargeConfirmed' => 'SearchColumnBooleanField[]',
		'isGcoPaymentGuaranteed' => 'SearchColumnBooleanField[]',
		'isGcoRefundConfirmed' => 'SearchColumnBooleanField[]',
		'isInsideDelivery' => 'SearchColumnBooleanField[]',
		'isInsidePickup' => 'SearchColumnBooleanField[]',
		'isIntercompanyAdjustment' => 'SearchColumnBooleanField[]',
		'isInTransitPayment' => 'SearchColumnBooleanField[]',
		'isMultiShipTo' => 'SearchColumnBooleanField[]',
		'isReversal' => 'SearchColumnBooleanField[]',
		'isRevRecTransaction' => 'SearchColumnBooleanField[]',
		'isScrap' => 'SearchColumnBooleanField[]',
		'isShipAddress' => 'SearchColumnBooleanField[]',
		'isTransferPriceCosting' => 'SearchColumnBooleanField[]',
		'isWip' => 'SearchColumnBooleanField[]',
		'item' => 'SearchColumnSelectField[]',
		'itemFulfillmentChoice' => 'SearchColumnEnumSelectField[]',
		'itemRevision' => 'SearchColumnSelectField[]',
		'landedCostPerLine' => 'SearchColumnBooleanField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'leadSource' => 'SearchColumnSelectField[]',
		'line' => 'SearchColumnLongField[]',
		'lineSequenceNumber' => 'SearchColumnLongField[]',
		'lineUniqueKey' => 'SearchColumnLongField[]',
		'location' => 'SearchColumnSelectField[]',
		'locationAutoAssigned' => 'SearchColumnBooleanField[]',
		'mainLine' => 'SearchColumnBooleanField[]',
		'mainName' => 'SearchColumnStringField[]',
		'manufacturingRouting' => 'SearchColumnSelectField[]',
		'matchBillToReceipt' => 'SearchColumnBooleanField[]',
		'memo' => 'SearchColumnStringField[]',
		'memoMain' => 'SearchColumnStringField[]',
		'memorized' => 'SearchColumnBooleanField[]',
		'merchantAccount' => 'SearchColumnSelectField[]',
		'message' => 'SearchColumnStringField[]',
		'multiSubsidiary' => 'SearchColumnBooleanField[]',
		'netAmount' => 'SearchColumnDoubleField[]',
		'netAmountNoTax' => 'SearchColumnDoubleField[]',
		'nextApprover' => 'SearchColumnSelectField[]',
		'nextBillDate' => 'SearchColumnDateField[]',
		'nexus' => 'SearchColumnSelectField[]',
		'noAutoAssignLocation' => 'SearchColumnBooleanField[]',
		'nonReimbursable' => 'SearchColumnBooleanField[]',
		'oneTimeTotal' => 'SearchColumnDoubleField[]',
		'opportunity' => 'SearchColumnSelectField[]',
		'options' => 'SearchColumnStringField[]',
		'orderAllocationStrategy' => 'SearchColumnSelectField[]',
		'orderPriority' => 'SearchColumnDoubleField[]',
		'originator' => 'SearchColumnEnumSelectField[]',
		'otherRefNum' => 'SearchColumnTextNumberField[]',
		'overheadParentItem' => 'SearchColumnSelectField[]',
		'overrideInstallments' => 'SearchColumnBooleanField[]',
		'packageCount' => 'SearchColumnLongField[]',
		'paidAmount' => 'SearchColumnDoubleField[]',
		'paidTransaction' => 'SearchColumnSelectField[]',
		'partner' => 'SearchColumnSelectField[]',
		'partnerContribution' => 'SearchColumnDoubleField[]',
		'partnerRole' => 'SearchColumnSelectField[]',
		'partnerTeamMember' => 'SearchColumnSelectField[]',
		'payingAmount' => 'SearchColumnDoubleField[]',
		'payingTransaction' => 'SearchColumnSelectField[]',
		'paymentApproved' => 'SearchColumnBooleanField[]',
		'paymentEventDate' => 'SearchColumnDateField[]',
		'paymentEventHoldReason' => 'SearchColumnEnumSelectField[]',
		'paymentEventPurchaseCardUsed' => 'SearchColumnBooleanField[]',
		'paymentEventPurchaseDataSent' => 'SearchColumnBooleanField[]',
		'paymentEventResult' => 'SearchColumnEnumSelectField[]',
		'paymentEventType' => 'SearchColumnEnumSelectField[]',
		'paymentHold' => 'SearchColumnBooleanField[]',
		'paymentMethod' => 'SearchColumnSelectField[]',
		'paymentOption' => 'SearchColumnSelectField[]',
		'payPalPending' => 'SearchColumnBooleanField[]',
		'payPalStatus' => 'SearchColumnStringField[]',
		'payPalTranId' => 'SearchColumnStringField[]',
		'payrollBatch' => 'SearchColumnStringField[]',
		'pnRefNum' => 'SearchColumnStringField[]',
		'poRate' => 'SearchColumnDoubleField[]',
		'posting' => 'SearchColumnBooleanField[]',
		'postingPeriod' => 'SearchColumnSelectField[]',
		'priceLevel' => 'SearchColumnSelectField[]',
		'print' => 'SearchColumnStringField[]',
		'probability' => 'SearchColumnDoubleField[]',
		'projectedAmount' => 'SearchColumnDoubleField[]',
		'projectTask' => 'SearchColumnSelectField[]',
		'promoCode' => 'SearchColumnSelectField[]',
		'purchaseOrder' => 'SearchColumnSelectField[]',
		'quantity' => 'SearchColumnDoubleField[]',
		'quantityBilled' => 'SearchColumnDoubleField[]',
		'quantityCommitted' => 'SearchColumnDoubleField[]',
		'quantityPacked' => 'SearchColumnDoubleField[]',
		'quantityPicked' => 'SearchColumnDoubleField[]',
		'quantityRevCommitted' => 'SearchColumnDoubleField[]',
		'quantityShipRecv' => 'SearchColumnDoubleField[]',
		'quantityUom' => 'SearchColumnDoubleField[]',
		'rate' => 'SearchColumnDoubleField[]',
		'realizedGainPostingTransaction' => 'SearchColumnStringField[]',
		'recognizedRevenue' => 'SearchColumnDoubleField[]',
		'recordType' => 'SearchColumnStringField[]',
		'recurAnnuallyTotal' => 'SearchColumnDoubleField[]',
		'recurMonthlyTotal' => 'SearchColumnDoubleField[]',
		'recurQuarterlyTotal' => 'SearchColumnDoubleField[]',
		'recurringBill' => 'SearchColumnBooleanField[]',
		'recurWeeklyTotal' => 'SearchColumnDoubleField[]',
		'refNumber' => 'SearchColumnLongField[]',
		'requestedDate' => 'SearchColumnDateField[]',
		'revCommitStatus' => 'SearchColumnEnumSelectField[]',
		'revCommittingTransaction' => 'SearchColumnSelectField[]',
		'revenueStatus' => 'SearchColumnEnumSelectField[]',
		'reversalDate' => 'SearchColumnDateField[]',
		'reversalNumber' => 'SearchColumnStringField[]',
		'revRecEndDate' => 'SearchColumnDateField[]',
		'revRecOnRevCommitment' => 'SearchColumnBooleanField[]',
		'revRecStartDate' => 'SearchColumnDateField[]',
		'rgAccount' => 'SearchColumnSelectField[]',
		'rgAmount' => 'SearchColumnDoubleField[]',
		'salesEffectiveDate' => 'SearchColumnDateField[]',
		'salesOrder' => 'SearchColumnSelectField[]',
		'salesRep' => 'SearchColumnSelectField[]',
		'salesTeamMember' => 'SearchColumnSelectField[]',
		'salesTeamRole' => 'SearchColumnSelectField[]',
		'schedulingMethod' => 'SearchColumnEnumSelectField[]',
		'serialNumber' => 'SearchColumnStringField[]',
		'serialNumberCost' => 'SearchColumnDoubleField[]',
		'serialNumberCostAdjustment' => 'SearchColumnDoubleField[]',
		'serialNumberQuantity' => 'SearchColumnDoubleField[]',
		'serialNumbers' => 'SearchColumnStringField[]',
		'shipAddress' => 'SearchColumnStringField[]',
		'shipAddress1' => 'SearchColumnStringField[]',
		'shipAddress2' => 'SearchColumnStringField[]',
		'shipAddress3' => 'SearchColumnStringField[]',
		'shipAddressee' => 'SearchColumnStringField[]',
		'shipAttention' => 'SearchColumnStringField[]',
		'shipCarrier' => 'SearchColumnEnumSelectField[]',
		'shipCity' => 'SearchColumnStringField[]',
		'shipComplete' => 'SearchColumnBooleanField[]',
		'shipCountry' => 'SearchColumnEnumSelectField[]',
		'shipCountryCode' => 'SearchColumnStringField[]',
		'shipDate' => 'SearchColumnDateField[]',
		'shipGroup' => 'SearchColumnLongField[]',
		'shipMethod' => 'SearchColumnSelectField[]',
		'shipPhone' => 'SearchColumnStringField[]',
		'shippingAmount' => 'SearchColumnDoubleField[]',
		'shipRecvStatusLine' => 'SearchColumnBooleanField[]',
		'shipState' => 'SearchColumnStringField[]',
		'shipTo' => 'SearchColumnSelectField[]',
		'shipZip' => 'SearchColumnStringField[]',
		'signedAmount' => 'SearchColumnDoubleField[]',
		'source' => 'SearchColumnStringField[]',
		'startDate' => 'SearchColumnDateField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'subscriptionLine' => 'SearchColumnSelectField[]',
		'subsidiary' => 'SearchColumnSelectField[]',
		'subsidiaryTaxRegNum' => 'SearchColumnStringField[]',
		'taxAmount' => 'SearchColumnDoubleField[]',
		'taxCode' => 'SearchColumnSelectField[]',
		'taxLine' => 'SearchColumnBooleanField[]',
		'taxPeriod' => 'SearchColumnSelectField[]',
		'taxPointDate' => 'SearchColumnDateField[]',
		'taxTotal' => 'SearchColumnDoubleField[]',
		'termInMonths' => 'SearchColumnLongField[]',
		'terms' => 'SearchColumnSelectField[]',
		'termsOfSale' => 'SearchColumnStringField[]',
		'title' => 'SearchColumnStringField[]',
		'toBeEmailed' => 'SearchColumnBooleanField[]',
		'toBePrinted' => 'SearchColumnBooleanField[]',
		'toSubsidiary' => 'SearchColumnSelectField[]',
		'total' => 'SearchColumnDoubleField[]',
		'totalCostEstimate' => 'SearchColumnDoubleField[]',
		'trackingNumbers' => 'SearchColumnStringField[]',
		'tranDate' => 'SearchColumnDateField[]',
		'tranEstGrossProfit' => 'SearchColumnDoubleField[]',
		'tranFxEstGrossProfit' => 'SearchColumnDoubleField[]',
		'tranId' => 'SearchColumnStringField[]',
		'tranIsVsoeBundle' => 'SearchColumnBooleanField[]',
		'transactionDiscount' => 'SearchColumnBooleanField[]',
		'transactionLineType' => 'SearchColumnEnumSelectField[]',
		'transactionNumber' => 'SearchColumnStringField[]',
		'transferLocation' => 'SearchColumnSelectField[]',
		'transferOrderItemLine' => 'SearchColumnStringField[]',
		'transferOrderQuantityCommitted' => 'SearchColumnDoubleField[]',
		'transferOrderQuantityPacked' => 'SearchColumnDoubleField[]',
		'transferOrderQuantityPicked' => 'SearchColumnDoubleField[]',
		'transferOrderQuantityReceived' => 'SearchColumnDoubleField[]',
		'transferOrderQuantityShipped' => 'SearchColumnDoubleField[]',
		'type' => 'SearchColumnEnumSelectField[]',
		'unit' => 'SearchColumnStringField[]',
		'unitCostOverride' => 'SearchColumnDoubleField[]',
		'vendType' => 'SearchColumnSelectField[]',
		'visibleToCustomer' => 'SearchColumnBooleanField[]',
		'vsoeAllocation' => 'SearchColumnDoubleField[]',
		'vsoeAmount' => 'SearchColumnDoubleField[]',
		'vsoeDeferral' => 'SearchColumnEnumSelectField[]',
		'vsoeDelivered' => 'SearchColumnBooleanField[]',
		'vsoePermitDiscount' => 'SearchColumnEnumSelectField[]',
		'vsoePrice' => 'SearchColumnDoubleField[]',
		'webSite' => 'SearchColumnStringField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
