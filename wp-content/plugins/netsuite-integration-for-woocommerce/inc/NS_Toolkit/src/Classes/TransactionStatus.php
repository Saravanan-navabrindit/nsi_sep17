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

class TransactionStatus {
	public static $paramtypesmap = array(
	);
	const _BILLCANCELLED = '_billCancelled';
	const _BILLOPEN = '_billOpen';
	const _BILLPAIDINFULL = '_billPaidInFull';
	const _BILLPAYMENTAPPROVED = '_billPaymentApproved';
	const _BILLPAYMENTCONFIRMED = '_billPaymentConfirmed';
	const _BILLPAYMENTDECLINED = '_billPaymentDeclined';
	const _BILLPAYMENTINTRANSIT = '_billPaymentInTransit';
	const _BILLPAYMENTONLINEBILLPAYPENDINGACCOUNTINGAPPROVAL = '_billPaymentOnlineBillPayPendingAccountingApproval';
	const _BILLPAYMENTPENDINGAPPROVAL = '_billPaymentPendingApproval';
	const _BILLPAYMENTREJECTED = '_billPaymentRejected';
	const _BILLPAYMENTVOIDED = '_billPaymentVoided';
	const _BILLPENDINGAPPROVAL = '_billPendingApproval';
	const _BILLREJECTED = '_billRejected';
	const _CASHSALEDEPOSITED = '_cashSaleDeposited';
	const _CASHSALENOTDEPOSITED = '_cashSaleNotDeposited';
	const _CASHSALEUNAPPROVEDPAYMENT = '_cashSaleUnapprovedPayment';
	const _CHECKONLINEBILLPAYPENDINGACCOUNTINGAPPROVAL = '_checkOnlineBillPayPendingAccountingApproval';
	const _CHECKVOIDED = '_checkVoided';
	const _COMMISSIONOVERPAID = '_commissionOverpaid';
	const _COMMISSIONPAIDINFULL = '_commissionPaidInFull';
	const _COMMISSIONPENDINGACCOUNTINGAPPROVAL = '_commissionPendingAccountingApproval';
	const _COMMISSIONPENDINGPAYMENT = '_commissionPendingPayment';
	const _COMMISSIONREJECTEDBYACCOUNTING = '_commissionRejectedByAccounting';
	const _CREDITMEMOFULLYAPPLIED = '_creditMemoFullyApplied';
	const _CREDITMEMOOPEN = '_creditMemoOpen';
	const _CREDITMEMOVOIDED = '_creditMemoVoided';
	const _CUSTOMERDEPOSITCANCELLED = '_customerDepositCancelled';
	const _CUSTOMERDEPOSITDEPOSITED = '_customerDepositDeposited';
	const _CUSTOMERDEPOSITFULLYAPPLIED = '_customerDepositFullyApplied';
	const _CUSTOMERDEPOSITNOTDEPOSITED = '_customerDepositNotDeposited';
	const _CUSTOMERDEPOSITUNAPPROVEDPAYMENT = '_customerDepositUnapprovedPayment';
	const _CUSTOMERREFUNDCANCELLED = '_customerRefundCancelled';
	const _CUSTOMERREFUNDVOIDED = '_customerRefundVoided';
	const _ESTIMATECLOSED = '_estimateClosed';
	const _ESTIMATEEXPIRED = '_estimateExpired';
	const _ESTIMATEOPEN = '_estimateOpen';
	const _ESTIMATEPROCESSED = '_estimateProcessed';
	const _ESTIMATEVOIDED = '_estimateVoided';
	const _EXPENSEREPORTAPPROVEDBYACCOUNTING = '_expenseReportApprovedByAccounting';
	const _EXPENSEREPORTAPPROVEDOVERRIDDENBYACCOUNTING = '_expenseReportApprovedOverriddenByAccounting';
	const _EXPENSEREPORTINPROGRESS = '_expenseReportInProgress';
	const _EXPENSEREPORTPAIDINFULL = '_expenseReportPaidInFull';
	const _EXPENSEREPORTPAYMENTINTRANSIT = '_expenseReportPaymentInTransit';
	const _EXPENSEREPORTPENDINGACCOUNTINGAPPROVAL = '_expenseReportPendingAccountingApproval';
	const _EXPENSEREPORTPENDINGSUPERVISORAPPROVAL = '_expenseReportPendingSupervisorApproval';
	const _EXPENSEREPORTREJECTEDBYACCOUNTING = '_expenseReportRejectedByAccounting';
	const _EXPENSEREPORTREJECTEDBYSUPERVISOR = '_expenseReportRejectedBySupervisor';
	const _EXPENSEREPORTREJECTEDOVERRIDDENBYACCOUNTING = '_expenseReportRejectedOverriddenByAccounting';
	const _EXPENSEREPORTVOIDED = '_expenseReportVoided';
	const _INVOICEOPEN = '_invoiceOpen';
	const _INVOICEPAIDINFULL = '_invoicePaidInFull';
	const _INVOICEPENDINGAPPROVAL = '_invoicePendingApproval';
	const _INVOICEREJECTED = '_invoiceRejected';
	const _INVOICEVOIDED = '_invoiceVoided';
	const _ITEMFULFILLMENTPACKED = '_itemFulfillmentPacked';
	const _ITEMFULFILLMENTPICKED = '_itemFulfillmentPicked';
	const _ITEMFULFILLMENTSHIPPED = '_itemFulfillmentShipped';
	const _JOURNALAPPROVEDFORPOSTING = '_journalApprovedForPosting';
	const _JOURNALPENDINGAPPROVAL = '_journalPendingApproval';
	const _JOURNALREJECTED = '_journalRejected';
	const _OPPORTUNITYCLOSEDLOST = '_opportunityClosedLost';
	const _OPPORTUNITYCLOSEDWON = '_opportunityClosedWon';
	const _OPPORTUNITYINPROGRESS = '_opportunityInProgress';
	const _OPPORTUNITYISSUEDESTIMATE = '_opportunityIssuedEstimate';
	const _PAYCHECKCOMMITTED = '_paycheckCommitted';
	const _PAYCHECKCREATED = '_paycheckCreated';
	const _PAYCHECKERROR = '_paycheckError';
	const _PAYCHECKPENDINGCOMMITMENT = '_paycheckPendingCommitment';
	const _PAYCHECKPENDINGTAXCALCULATION = '_paycheckPendingTaxCalculation';
	const _PAYCHECKPREVIEW = '_paycheckPreview';
	const _PAYCHECKREVERSED = '_paycheckReversed';
	const _PAYMENTCANCELLED = '_paymentCancelled';
	const _PAYMENTDEPOSITED = '_paymentDeposited';
	const _PAYMENTNOTDEPOSITED = '_paymentNotDeposited';
	const _PAYMENTUNAPPROVEDPAYMENT = '_paymentUnapprovedPayment';
	const _PAYROLLLIABILITYCHECKVOIDED = '_payrollLiabilityCheckVoided';
	const _PERIODENDJOURNALAPPROVEDFORPOSTING = '_periodEndJournalApprovedForPosting';
	const _PERIODENDJOURNALPENDINGAPPROVAL = '_periodEndJournalPendingApproval';
	const _PERIODENDJOURNALREJECTED = '_periodEndJournalRejected';
	const _PURCHASEORDERCLOSED = '_purchaseOrderClosed';
	const _PURCHASEORDERFULLYBILLED = '_purchaseOrderFullyBilled';
	const _PURCHASEORDERPARTIALLYRECEIVED = '_purchaseOrderPartiallyReceived';
	const _PURCHASEORDERPENDINGBILL = '_purchaseOrderPendingBill';
	const _PURCHASEORDERPENDINGBILLINGPARTIALLYRECEIVED = '_purchaseOrderPendingBillingPartiallyReceived';
	const _PURCHASEORDERPENDINGRECEIPT = '_purchaseOrderPendingReceipt';
	const _PURCHASEORDERPENDINGSUPERVISORAPPROVAL = '_purchaseOrderPendingSupervisorApproval';
	const _PURCHASEORDERPLANNED = '_purchaseOrderPlanned';
	const _PURCHASEORDERREJECTEDBYSUPERVISOR = '_purchaseOrderRejectedBySupervisor';
	const _REQUISITIONCANCELLED = '_requisitionCancelled';
	const _REQUISITIONCLOSED = '_requisitionClosed';
	const _REQUISITIONFULLYORDERED = '_requisitionFullyOrdered';
	const _REQUISITIONFULLYRECEIVED = '_requisitionFullyReceived';
	const _REQUISITIONPARTIALLYORDERED = '_requisitionPartiallyOrdered';
	const _REQUISITIONPARTIALLYRECEIVED = '_requisitionPartiallyReceived';
	const _REQUISITIONPENDINGAPPROVAL = '_requisitionPendingApproval';
	const _REQUISITIONPENDINGORDER = '_requisitionPendingOrder';
	const _REQUISITIONREJECTED = '_requisitionRejected';
	const _RETURNAUTHORIZATIONCANCELLED = '_returnAuthorizationCancelled';
	const _RETURNAUTHORIZATIONCLOSED = '_returnAuthorizationClosed';
	const _RETURNAUTHORIZATIONPARTIALLYRECEIVED = '_returnAuthorizationPartiallyReceived';
	const _RETURNAUTHORIZATIONPENDINGAPPROVAL = '_returnAuthorizationPendingApproval';
	const _RETURNAUTHORIZATIONPENDINGRECEIPT = '_returnAuthorizationPendingReceipt';
	const _RETURNAUTHORIZATIONPENDINGREFUND = '_returnAuthorizationPendingRefund';
	const _RETURNAUTHORIZATIONPENDINGREFUNDPARTIALLYRECEIVED = '_returnAuthorizationPendingRefundPartiallyReceived';
	const _RETURNAUTHORIZATIONREFUNDED = '_returnAuthorizationRefunded';
	const _SALESORDERBILLED = '_salesOrderBilled';
	const _SALESORDERCANCELLED = '_salesOrderCancelled';
	const _SALESORDERCLOSED = '_salesOrderClosed';
	const _SALESORDERPARTIALLYFULFILLED = '_salesOrderPartiallyFulfilled';
	const _SALESORDERPENDINGAPPROVAL = '_salesOrderPendingApproval';
	const _SALESORDERPENDINGBILLING = '_salesOrderPendingBilling';
	const _SALESORDERPENDINGBILLINGPARTIALLYFULFILLED = '_salesOrderPendingBillingPartiallyFulfilled';
	const _SALESORDERPENDINGFULFILLMENT = '_salesOrderPendingFulfillment';
	const _SALESTAXPAYMENTONLINEBILLPAYPENDINGACCOUNTINGAPPROVAL = '_salesTaxPaymentOnlineBillPayPendingAccountingApproval';
	const _SALESTAXPAYMENTVOIDED = '_salesTaxPaymentVoided';
	const _STATEMENTCHARGEOPEN = '_statementChargeOpen';
	const _STATEMENTCHARGEPAIDINFULL = '_statementChargePaidInFull';
	const _TAXLIABILITYCHEQUEVOIDED = '_taxLiabilityChequeVoided';
	const _TEGATAPAYABLEENDORSED = '_tegataPayableEndorsed';
	const _TEGATAPAYABLEISSUED = '_tegataPayableIssued';
	const _TEGATAPAYABLEPAID = '_tegataPayablePaid';
	const _TEGATARECEIVABLESCOLLECTED = '_tegataReceivablesCollected';
	const _TEGATARECEIVABLESDISCOUNTED = '_tegataReceivablesDiscounted';
	const _TEGATARECEIVABLESENDORSED = '_tegataReceivablesEndorsed';
	const _TEGATARECEIVABLESHOLDING = '_tegataReceivablesHolding';
	const _TEGATARECEIVABLESVOIDED = '_tegataReceivablesVoided';
	const _TRANSFERORDERCLOSED = '_transferOrderClosed';
	const _TRANSFERORDERPARTIALLYFULFILLED = '_transferOrderPartiallyFulfilled';
	const _TRANSFERORDERPENDINGAPPROVAL = '_transferOrderPendingApproval';
	const _TRANSFERORDERPENDINGFULFILLMENT = '_transferOrderPendingFulfillment';
	const _TRANSFERORDERPENDINGRECEIPT = '_transferOrderPendingReceipt';
	const _TRANSFERORDERPENDINGRECEIPTPARTIALLYFULFILLED = '_transferOrderPendingReceiptPartiallyFulfilled';
	const _TRANSFERORDERRECEIVED = '_transferOrderReceived';
	const _TRANSFERORDERREJECTED = '_transferOrderRejected';
	const _VENDORRETURNAUTHORIZATIONCANCELLED = '_vendorReturnAuthorizationCancelled';
	const _VENDORRETURNAUTHORIZATIONCLOSED = '_vendorReturnAuthorizationClosed';
	const _VENDORRETURNAUTHORIZATIONCREDITED = '_vendorReturnAuthorizationCredited';
	const _VENDORRETURNAUTHORIZATIONPARTIALLYRETURNED = '_vendorReturnAuthorizationPartiallyReturned';
	const _VENDORRETURNAUTHORIZATIONPENDINGAPPROVAL = '_vendorReturnAuthorizationPendingApproval';
	const _VENDORRETURNAUTHORIZATIONPENDINGCREDIT = '_vendorReturnAuthorizationPendingCredit';
	const _VENDORRETURNAUTHORIZATIONPENDINGCREDITPARTIALLYRETURNED = '_vendorReturnAuthorizationPendingCreditPartiallyReturned';
	const _VENDORRETURNAUTHORIZATIONPENDINGRETURN = '_vendorReturnAuthorizationPendingReturn';
	const _WORKORDERBUILT = '_workOrderBuilt';
	const _WORKORDERCANCELLED = '_workOrderCancelled';
	const _WORKORDERCLOSED = '_workOrderClosed';
	const _WORKORDERPARTIALLYBUILT = '_workOrderPartiallyBuilt';
	const _WORKORDERPENDINGBUILD = '_workOrderPendingBuild';
	const _WORKORDERPLANNED = '_workOrderPlanned';
}
