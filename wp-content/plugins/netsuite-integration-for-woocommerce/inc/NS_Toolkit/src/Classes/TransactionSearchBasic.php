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

class TransactionSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $account;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $accountType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $acctCorpCardExp;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $actualProductionEndDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $actualProductionStartDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $actualShipDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $altSalesAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $altSalesNetAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountPaid;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountRemaining;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $amountUnbilled;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $anyLineItem;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $appliedToForeignAmount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $appliedToIsFxVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $appliedToLinkAmount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $appliedToLinkType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $appliedToTransaction;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $applyingForeignAmount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $applyingIsFxVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $applyingLinkAmount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $applyingLinkType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $applyingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $approvalStatus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $authCode;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $autoCalculateLag;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $avsStreetMatch;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $avsZipMatch;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $billable;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billAddress;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billAddressee;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billAttention;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billCity;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $billCountry;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billCounty;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $billedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingAccount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingSchedule;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $billingStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $billingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billPhone;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billState;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $billVarianceStatus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $billZip;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $binNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $binNumberQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $bomQuantity;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $bookSpecificTransaction;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $buildEntireAssembly;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $buildVariance;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $built;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $canHaveStackablePromotions;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $catchUpPeriod;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $ccCustomerCode;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $ccExpireDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $ccName;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $ccNumber;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $chargeType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $class;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $cleared;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $closed;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $closeDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $cogs;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $commissionEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $commit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $componentYield;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $confirmationNumber;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $contribution;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costComponentAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $costComponentCategory;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $costComponentItem;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costComponentQuantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costComponentStandardCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costEstimate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $costEstimateRate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $costEstimateType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $createdBy;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $creditAmount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $cscMatch;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $currency;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $customerSubOf;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $customForm;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $customGL;
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
	public $daysOverdue;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $debitAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $deferredRevenue;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $deferRevRec;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $department;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $depositDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $depositTransaction;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $drAccount;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $dueDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $email;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $employee;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
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
	public $estGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $estGrossProfitPct;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $excludeCommission;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $excludeFromRateRequest;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expectedCloseDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expectedReceiptDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $expenseCategory;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $expenseDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $finChrg;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $firmed;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $forecastType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $fulfillingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $fxAccount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxCostEstimateRate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxEstGrossProfit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxTranCostEstimate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxVsoeAllocation;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxVsoeAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $fxVsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $gcoAvailabelToCharge;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $gcoAvailableToRefund;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $gcoAvsStreetMatch;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $gcoAvsZipMatch;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $gcoBuyerAccountAge;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoBuyerIp;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoChargeAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoChargebackAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoConfirmedChargedTotal;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoConfirmedRefundedTotal;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoCreditcardNumber;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $gcoCscMatch;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoFinancialState;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoFulfillmentState;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoOrderId;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoOrderTotal;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoPromotionAmount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoPromotionName;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoRefundAmount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $gcoShippingTotal;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $gcoStateChangedDetail;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $giftCertificate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $grossAmount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $includeInForecast;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $incoterm;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $intercoStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $intercoTransaction;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $inventoryLocation;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $inventorySubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $inVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isAllocation;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isBackflush;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isGcoChargeback;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isGcoChargeConfirmed;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isGcoPaymentGuaranteed;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isGcoRefundConfirmed;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInsideDelivery;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInsidePickup;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isIntercompanyAdjustment;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInTransitPayment;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isMultiShipTo;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isPayPalMeth;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isReversal;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isRevRecTransaction;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isScrap;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isShipAddress;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isTransferPriceCosting;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isVsoeAlloc;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isWip;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $itemFulfillmentChoice;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemRevision;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $itemSubOf;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $landedCostPerLine;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $lineUniqueKey;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $location;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $locationAutoAssigned;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $mainLine;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $mainName;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $manufacturingRouting;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $matchBillToReceipt;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $memoMain;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $memorized;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $merchantAccount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $multiSubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $nameText;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $netAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $nextApprover;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $nextBillDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $nexus;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $noAutoAssignLocation;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $nonReimbursable;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $oneTimeTotal;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $opportunity;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $orderAllocationStrategy;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $orderPriority;
	/**
	 * Var \NetSuite\Classes\SearchTextNumberField
	 */
	public $otherRefNum;
	/**
	 * Var \NetSuite\Classes\SearchTextNumberField
	 */
	public $otherRefNumNonDeposit;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $overheadParentItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $overrideInstallments;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $packageCount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $paidTransaction;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $parent;
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
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $payingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $paymentApproved;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $paymentEventDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $paymentEventHoldReason;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $paymentEventPurchaseCardUsed;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $paymentEventPurchaseDataSent;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $paymentEventResult;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $paymentEventType;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $paymentHold;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $paymentMethod;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $paymentOption;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $payPalPending;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $payPalStatus;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $payPalTranId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $pnRefNum;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $poAsText;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $posting;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\PostingPeriodDate
	 */
	public $postingPeriodRelative;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $priceLevel;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $printedPickingTicket;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $probability;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $projectedAmount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $projectTask;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $purchaseOrder;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantity;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityBilled;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityPacked;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityPicked;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityRevCommitted;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $quantityShipRecv;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $recognizedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $recordType;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $recurAnnuallyTotal;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $recurMonthlyTotal;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $recurQuarterlyTotal;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $recurringBill;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $recurWeeklyTotal;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $refNumber;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $requestedDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $revCommitStatus;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $revCommittingStatus;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $revCommittingTransaction;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $revenueStatus;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $reversalDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $reversalNumber;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $revRecEndDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $revRecOnRevCommitment;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $revRecStartDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $revRecTermInMonths;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $salesEffectiveDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $salesOrder;
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
	public $schedulingMethod;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $serialNumber;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $serialNumberCost;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $serialNumberCostAdjustment;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $serialNumberQuantity;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $serialNumbers;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipAddress;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipAddressee;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipAttention;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $shipCarrier;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipCity;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shipComplete;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $shipCountry;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipCounty;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $shipDate;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $shipGroup;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shipMethod;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipPhone;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shipping;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shipRecvStatus;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $shipRecvStatusLine;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shipState;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $shipTo;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $shipZip;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $statistical;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscriptionLine;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subsidiaryTaxRegNum;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $taxItem;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $taxLine;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $taxPeriod;
	/**
	 * Var \NetSuite\Classes\PostingPeriodDate
	 */
	public $taxPeriodRelative;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $taxPointDate;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $taxRate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $terms;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $termsOfSale;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $toBeEmailed;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $toBePrinted;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $toSubsidiary;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $totalAmount;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $trackingNumbers;
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
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $tranIsVsoeBundle;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $transactionDiscount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $transactionLineType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $transactionNumber;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $transferLocation;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $transferOrderQuantityCommitted;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $transferOrderQuantityPacked;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $transferOrderQuantityPicked;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $transferOrderQuantityReceived;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $transferOrderQuantityShipped;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $type;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $unit;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $unitCostOverride;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $unitsType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $vendType;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $visibleToCustomer;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $voided;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vsoeAllocation;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vsoeAmount;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $vsoeDeferral;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $vsoeDelivered;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $vsoePermitDiscount;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $vsoePrice;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $webSite;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'account' => 'SearchMultiSelectField',
		'accountType' => 'SearchEnumMultiSelectField',
		'acctCorpCardExp' => 'SearchMultiSelectField',
		'actualProductionEndDate' => 'SearchDateField',
		'actualProductionStartDate' => 'SearchDateField',
		'actualShipDate' => 'SearchDateField',
		'altSalesAmount' => 'SearchDoubleField',
		'altSalesNetAmount' => 'SearchDoubleField',
		'amount' => 'SearchDoubleField',
		'amountPaid' => 'SearchDoubleField',
		'amountRemaining' => 'SearchDoubleField',
		'amountUnbilled' => 'SearchDoubleField',
		'anyLineItem' => 'SearchMultiSelectField',
		'appliedToForeignAmount' => 'SearchDoubleField',
		'appliedToIsFxVariance' => 'SearchBooleanField',
		'appliedToLinkAmount' => 'SearchDoubleField',
		'appliedToLinkType' => 'SearchEnumMultiSelectField',
		'appliedToTransaction' => 'SearchMultiSelectField',
		'applyingForeignAmount' => 'SearchDoubleField',
		'applyingIsFxVariance' => 'SearchBooleanField',
		'applyingLinkAmount' => 'SearchDoubleField',
		'applyingLinkType' => 'SearchEnumMultiSelectField',
		'applyingTransaction' => 'SearchMultiSelectField',
		'approvalStatus' => 'SearchEnumMultiSelectField',
		'authCode' => 'SearchStringField',
		'autoCalculateLag' => 'SearchBooleanField',
		'avsStreetMatch' => 'SearchEnumMultiSelectField',
		'avsZipMatch' => 'SearchEnumMultiSelectField',
		'billable' => 'SearchBooleanField',
		'billAddress' => 'SearchStringField',
		'billAddressee' => 'SearchStringField',
		'billAttention' => 'SearchStringField',
		'billCity' => 'SearchStringField',
		'billCountry' => 'SearchEnumMultiSelectField',
		'billCounty' => 'SearchStringField',
		'billedDate' => 'SearchDateField',
		'billingAccount' => 'SearchMultiSelectField',
		'billingSchedule' => 'SearchMultiSelectField',
		'billingStatus' => 'SearchBooleanField',
		'billingTransaction' => 'SearchMultiSelectField',
		'billPhone' => 'SearchStringField',
		'billState' => 'SearchStringField',
		'billVarianceStatus' => 'SearchEnumMultiSelectField',
		'billZip' => 'SearchStringField',
		'binNumber' => 'SearchStringField',
		'binNumberQuantity' => 'SearchDoubleField',
		'bomQuantity' => 'SearchDoubleField',
		'bookSpecificTransaction' => 'SearchBooleanField',
		'buildEntireAssembly' => 'SearchBooleanField',
		'buildVariance' => 'SearchDoubleField',
		'built' => 'SearchDoubleField',
		'canHaveStackablePromotions' => 'SearchBooleanField',
		'catchUpPeriod' => 'SearchMultiSelectField',
		'ccCustomerCode' => 'SearchStringField',
		'ccExpireDate' => 'SearchDateField',
		'ccName' => 'SearchStringField',
		'ccNumber' => 'SearchStringField',
		'chargeType' => 'SearchEnumMultiSelectField',
		'class' => 'SearchMultiSelectField',
		'cleared' => 'SearchBooleanField',
		'closed' => 'SearchBooleanField',
		'closeDate' => 'SearchDateField',
		'cogs' => 'SearchBooleanField',
		'commissionEffectiveDate' => 'SearchDateField',
		'commit' => 'SearchEnumMultiSelectField',
		'componentYield' => 'SearchDoubleField',
		'confirmationNumber' => 'SearchStringField',
		'contribution' => 'SearchLongField',
		'costComponentAmount' => 'SearchDoubleField',
		'costComponentCategory' => 'SearchMultiSelectField',
		'costComponentItem' => 'SearchMultiSelectField',
		'costComponentQuantity' => 'SearchDoubleField',
		'costComponentStandardCost' => 'SearchDoubleField',
		'costEstimate' => 'SearchDoubleField',
		'costEstimateRate' => 'SearchDoubleField',
		'costEstimateType' => 'SearchEnumMultiSelectField',
		'createdBy' => 'SearchMultiSelectField',
		'createdFrom' => 'SearchMultiSelectField',
		'creditAmount' => 'SearchDoubleField',
		'cscMatch' => 'SearchEnumMultiSelectField',
		'currency' => 'SearchMultiSelectField',
		'customerSubOf' => 'SearchMultiSelectField',
		'customForm' => 'SearchMultiSelectField',
		'customGL' => 'SearchBooleanField',
		'custType' => 'SearchMultiSelectField',
		'dateCreated' => 'SearchDateField',
		'daysOpen' => 'SearchLongField',
		'daysOverdue' => 'SearchLongField',
		'debitAmount' => 'SearchDoubleField',
		'deferredRevenue' => 'SearchDoubleField',
		'deferRevRec' => 'SearchBooleanField',
		'department' => 'SearchMultiSelectField',
		'depositDate' => 'SearchDateField',
		'depositTransaction' => 'SearchMultiSelectField',
		'drAccount' => 'SearchMultiSelectField',
		'dueDate' => 'SearchDateField',
		'email' => 'SearchStringField',
		'employee' => 'SearchMultiSelectField',
		'endDate' => 'SearchDateField',
		'entity' => 'SearchMultiSelectField',
		'entityStatus' => 'SearchMultiSelectField',
		'estGrossProfit' => 'SearchDoubleField',
		'estGrossProfitPct' => 'SearchDoubleField',
		'exchangeRate' => 'SearchDoubleField',
		'excludeCommission' => 'SearchBooleanField',
		'excludeFromRateRequest' => 'SearchBooleanField',
		'expectedCloseDate' => 'SearchDateField',
		'expectedReceiptDate' => 'SearchDateField',
		'expenseCategory' => 'SearchMultiSelectField',
		'expenseDate' => 'SearchDateField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'finChrg' => 'SearchBooleanField',
		'firmed' => 'SearchBooleanField',
		'forecastType' => 'SearchEnumMultiSelectField',
		'fulfillingTransaction' => 'SearchMultiSelectField',
		'fxAccount' => 'SearchMultiSelectField',
		'fxAmount' => 'SearchDoubleField',
		'fxCostEstimate' => 'SearchDoubleField',
		'fxCostEstimateRate' => 'SearchDoubleField',
		'fxEstGrossProfit' => 'SearchDoubleField',
		'fxTranCostEstimate' => 'SearchDoubleField',
		'fxVsoeAllocation' => 'SearchDoubleField',
		'fxVsoeAmount' => 'SearchDoubleField',
		'fxVsoePrice' => 'SearchDoubleField',
		'gcoAvailabelToCharge' => 'SearchBooleanField',
		'gcoAvailableToRefund' => 'SearchBooleanField',
		'gcoAvsStreetMatch' => 'SearchEnumMultiSelectField',
		'gcoAvsZipMatch' => 'SearchEnumMultiSelectField',
		'gcoBuyerAccountAge' => 'SearchLongField',
		'gcoBuyerIp' => 'SearchStringField',
		'gcoChargeAmount' => 'SearchDoubleField',
		'gcoChargebackAmount' => 'SearchDoubleField',
		'gcoConfirmedChargedTotal' => 'SearchDoubleField',
		'gcoConfirmedRefundedTotal' => 'SearchDoubleField',
		'gcoCreditcardNumber' => 'SearchStringField',
		'gcoCscMatch' => 'SearchEnumMultiSelectField',
		'gcoFinancialState' => 'SearchStringField',
		'gcoFulfillmentState' => 'SearchStringField',
		'gcoOrderId' => 'SearchStringField',
		'gcoOrderTotal' => 'SearchDoubleField',
		'gcoPromotionAmount' => 'SearchDoubleField',
		'gcoPromotionName' => 'SearchStringField',
		'gcoRefundAmount' => 'SearchDoubleField',
		'gcoShippingTotal' => 'SearchDoubleField',
		'gcoStateChangedDetail' => 'SearchStringField',
		'giftCertificate' => 'SearchStringField',
		'grossAmount' => 'SearchDoubleField',
		'includeInForecast' => 'SearchBooleanField',
		'incoterm' => 'SearchMultiSelectField',
		'intercoStatus' => 'SearchEnumMultiSelectField',
		'intercoTransaction' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'inventoryLocation' => 'SearchMultiSelectField',
		'inventorySubsidiary' => 'SearchMultiSelectField',
		'inVsoeBundle' => 'SearchBooleanField',
		'isAllocation' => 'SearchBooleanField',
		'isBackflush' => 'SearchBooleanField',
		'isGcoChargeback' => 'SearchBooleanField',
		'isGcoChargeConfirmed' => 'SearchBooleanField',
		'isGcoPaymentGuaranteed' => 'SearchBooleanField',
		'isGcoRefundConfirmed' => 'SearchBooleanField',
		'isInsideDelivery' => 'SearchBooleanField',
		'isInsidePickup' => 'SearchBooleanField',
		'isIntercompanyAdjustment' => 'SearchBooleanField',
		'isInTransitPayment' => 'SearchBooleanField',
		'isMultiShipTo' => 'SearchBooleanField',
		'isPayPalMeth' => 'SearchBooleanField',
		'isReversal' => 'SearchBooleanField',
		'isRevRecTransaction' => 'SearchBooleanField',
		'isScrap' => 'SearchBooleanField',
		'isShipAddress' => 'SearchBooleanField',
		'isTransferPriceCosting' => 'SearchBooleanField',
		'isVsoeAlloc' => 'SearchBooleanField',
		'isWip' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'itemFulfillmentChoice' => 'SearchEnumMultiSelectField',
		'itemRevision' => 'SearchMultiSelectField',
		'itemSubOf' => 'SearchMultiSelectField',
		'landedCostPerLine' => 'SearchBooleanField',
		'lastModifiedDate' => 'SearchDateField',
		'leadSource' => 'SearchMultiSelectField',
		'lineUniqueKey' => 'SearchLongField',
		'location' => 'SearchMultiSelectField',
		'locationAutoAssigned' => 'SearchBooleanField',
		'mainLine' => 'SearchBooleanField',
		'mainName' => 'SearchMultiSelectField',
		'manufacturingRouting' => 'SearchMultiSelectField',
		'matchBillToReceipt' => 'SearchBooleanField',
		'memo' => 'SearchStringField',
		'memoMain' => 'SearchStringField',
		'memorized' => 'SearchBooleanField',
		'merchantAccount' => 'SearchStringField',
		'message' => 'SearchStringField',
		'multiSubsidiary' => 'SearchBooleanField',
		'nameText' => 'SearchStringField',
		'netAmount' => 'SearchDoubleField',
		'nextApprover' => 'SearchMultiSelectField',
		'nextBillDate' => 'SearchDateField',
		'nexus' => 'SearchMultiSelectField',
		'noAutoAssignLocation' => 'SearchBooleanField',
		'nonReimbursable' => 'SearchBooleanField',
		'number' => 'SearchLongField',
		'oneTimeTotal' => 'SearchDoubleField',
		'opportunity' => 'SearchMultiSelectField',
		'orderAllocationStrategy' => 'SearchMultiSelectField',
		'orderPriority' => 'SearchDoubleField',
		'otherRefNum' => 'SearchTextNumberField',
		'otherRefNumNonDeposit' => 'SearchTextNumberField',
		'overheadParentItem' => 'SearchMultiSelectField',
		'overrideInstallments' => 'SearchBooleanField',
		'packageCount' => 'SearchLongField',
		'paidTransaction' => 'SearchMultiSelectField',
		'parent' => 'SearchLongField',
		'partner' => 'SearchMultiSelectField',
		'partnerContribution' => 'SearchLongField',
		'partnerRole' => 'SearchMultiSelectField',
		'partnerTeamMember' => 'SearchMultiSelectField',
		'payingTransaction' => 'SearchMultiSelectField',
		'paymentApproved' => 'SearchBooleanField',
		'paymentEventDate' => 'SearchDateField',
		'paymentEventHoldReason' => 'SearchEnumMultiSelectField',
		'paymentEventPurchaseCardUsed' => 'SearchBooleanField',
		'paymentEventPurchaseDataSent' => 'SearchBooleanField',
		'paymentEventResult' => 'SearchEnumMultiSelectField',
		'paymentEventType' => 'SearchEnumMultiSelectField',
		'paymentHold' => 'SearchBooleanField',
		'paymentMethod' => 'SearchMultiSelectField',
		'paymentOption' => 'SearchStringField',
		'payPalPending' => 'SearchBooleanField',
		'payPalStatus' => 'SearchStringField',
		'payPalTranId' => 'SearchStringField',
		'pnRefNum' => 'SearchStringField',
		'poAsText' => 'SearchStringField',
		'posting' => 'SearchBooleanField',
		'postingPeriod' => 'RecordRef',
		'postingPeriodRelative' => 'PostingPeriodDate',
		'priceLevel' => 'SearchMultiSelectField',
		'printedPickingTicket' => 'SearchBooleanField',
		'probability' => 'SearchLongField',
		'projectedAmount' => 'SearchDoubleField',
		'projectTask' => 'SearchMultiSelectField',
		'promoCode' => 'SearchMultiSelectField',
		'purchaseOrder' => 'SearchMultiSelectField',
		'quantity' => 'SearchDoubleField',
		'quantityBilled' => 'SearchDoubleField',
		'quantityCommitted' => 'SearchDoubleField',
		'quantityPacked' => 'SearchDoubleField',
		'quantityPicked' => 'SearchDoubleField',
		'quantityRevCommitted' => 'SearchDoubleField',
		'quantityShipRecv' => 'SearchDoubleField',
		'recognizedRevenue' => 'SearchDoubleField',
		'recordType' => 'SearchStringField',
		'recurAnnuallyTotal' => 'SearchDoubleField',
		'recurMonthlyTotal' => 'SearchDoubleField',
		'recurQuarterlyTotal' => 'SearchDoubleField',
		'recurringBill' => 'SearchBooleanField',
		'recurWeeklyTotal' => 'SearchDoubleField',
		'refNumber' => 'SearchLongField',
		'requestedDate' => 'SearchDateField',
		'revCommitStatus' => 'SearchEnumMultiSelectField',
		'revCommittingStatus' => 'SearchBooleanField',
		'revCommittingTransaction' => 'SearchMultiSelectField',
		'revenueStatus' => 'SearchEnumMultiSelectField',
		'reversalDate' => 'SearchDateField',
		'reversalNumber' => 'SearchStringField',
		'revRecEndDate' => 'SearchDateField',
		'revRecOnRevCommitment' => 'SearchBooleanField',
		'revRecStartDate' => 'SearchDateField',
		'revRecTermInMonths' => 'SearchLongField',
		'salesEffectiveDate' => 'SearchDateField',
		'salesOrder' => 'SearchMultiSelectField',
		'salesRep' => 'SearchMultiSelectField',
		'salesTeamMember' => 'SearchMultiSelectField',
		'salesTeamRole' => 'SearchMultiSelectField',
		'schedulingMethod' => 'SearchEnumMultiSelectField',
		'serialNumber' => 'SearchStringField',
		'serialNumberCost' => 'SearchDoubleField',
		'serialNumberCostAdjustment' => 'SearchDoubleField',
		'serialNumberQuantity' => 'SearchDoubleField',
		'serialNumbers' => 'SearchStringField',
		'shipAddress' => 'SearchStringField',
		'shipAddressee' => 'SearchStringField',
		'shipAttention' => 'SearchStringField',
		'shipCarrier' => 'SearchEnumMultiSelectField',
		'shipCity' => 'SearchStringField',
		'shipComplete' => 'SearchBooleanField',
		'shipCountry' => 'SearchEnumMultiSelectField',
		'shipCounty' => 'SearchStringField',
		'shipDate' => 'SearchDateField',
		'shipGroup' => 'SearchLongField',
		'shipMethod' => 'SearchMultiSelectField',
		'shipPhone' => 'SearchStringField',
		'shipping' => 'SearchBooleanField',
		'shipRecvStatus' => 'SearchBooleanField',
		'shipRecvStatusLine' => 'SearchBooleanField',
		'shipState' => 'SearchMultiSelectField',
		'shipTo' => 'SearchMultiSelectField',
		'shipZip' => 'SearchStringField',
		'source' => 'SearchEnumMultiSelectField',
		'startDate' => 'SearchDateField',
		'statistical' => 'SearchBooleanField',
		'status' => 'SearchEnumMultiSelectField',
		'subscription' => 'SearchMultiSelectField',
		'subscriptionLine' => 'SearchMultiSelectField',
		'subsidiary' => 'SearchMultiSelectField',
		'subsidiaryTaxRegNum' => 'SearchMultiSelectField',
		'taxItem' => 'SearchMultiSelectField',
		'taxLine' => 'SearchBooleanField',
		'taxPeriod' => 'RecordRef',
		'taxPeriodRelative' => 'PostingPeriodDate',
		'taxPointDate' => 'SearchDateField',
		'taxRate' => 'SearchDoubleField',
		'terms' => 'SearchMultiSelectField',
		'termsOfSale' => 'SearchEnumMultiSelectField',
		'title' => 'SearchStringField',
		'toBeEmailed' => 'SearchBooleanField',
		'toBePrinted' => 'SearchBooleanField',
		'toSubsidiary' => 'SearchMultiSelectField',
		'totalAmount' => 'SearchDoubleField',
		'trackingNumbers' => 'SearchStringField',
		'tranCostEstimate' => 'SearchDoubleField',
		'tranDate' => 'SearchDateField',
		'tranEstGrossProfit' => 'SearchDoubleField',
		'tranEstGrossProfitPct' => 'SearchDoubleField',
		'tranFxEstGrossProfit' => 'SearchDoubleField',
		'tranId' => 'SearchStringField',
		'tranIsVsoeBundle' => 'SearchBooleanField',
		'transactionDiscount' => 'SearchBooleanField',
		'transactionLineType' => 'SearchEnumMultiSelectField',
		'transactionNumber' => 'SearchStringField',
		'transferLocation' => 'SearchMultiSelectField',
		'transferOrderQuantityCommitted' => 'SearchDoubleField',
		'transferOrderQuantityPacked' => 'SearchDoubleField',
		'transferOrderQuantityPicked' => 'SearchDoubleField',
		'transferOrderQuantityReceived' => 'SearchDoubleField',
		'transferOrderQuantityShipped' => 'SearchDoubleField',
		'type' => 'SearchEnumMultiSelectField',
		'unit' => 'SearchMultiSelectField',
		'unitCostOverride' => 'SearchDoubleField',
		'unitsType' => 'SearchMultiSelectField',
		'vendType' => 'SearchMultiSelectField',
		'visibleToCustomer' => 'SearchBooleanField',
		'voided' => 'SearchBooleanField',
		'vsoeAllocation' => 'SearchDoubleField',
		'vsoeAmount' => 'SearchDoubleField',
		'vsoeDeferral' => 'SearchEnumMultiSelectField',
		'vsoeDelivered' => 'SearchBooleanField',
		'vsoePermitDiscount' => 'SearchEnumMultiSelectField',
		'vsoePrice' => 'SearchDoubleField',
		'webSite' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
