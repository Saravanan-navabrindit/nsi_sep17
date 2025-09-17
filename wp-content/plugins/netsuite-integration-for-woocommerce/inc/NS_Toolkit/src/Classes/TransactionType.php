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

class TransactionType {
	public static $paramtypesmap = array(
	);
	const _ASSEMBLYBUILD = '_assemblyBuild';
	const _ASSEMBLYUNBUILD = '_assemblyUnbuild';
	const _BINTRANSFER = '_binTransfer';
	const _BINWORKSHEET = '_binWorksheet';
	const _CASHREFUND = '_cashRefund';
	const _CASHSALE = '_cashSale';
	const _CHECK = '_check';
	const _CREDITMEMO = '_creditMemo';
	const _CUSTOM = '_custom';
	const _CUSTOMPURCHASE = '_customPurchase';
	const _CUSTOMSALE = '_customSale';
	const _CUSTOMERDEPOSIT = '_customerDeposit';
	const _CUSTOMERPAYMENT = '_customerPayment';
	const _CUSTOMERREFUND = '_customerRefund';
	const _DEPOSIT = '_deposit';
	const _DEPOSITAPPLICATION = '_depositApplication';
	const _ESTIMATE = '_estimate';
	const _EXPENSEREPORT = '_expenseReport';
	const _INBOUNDSHIPMENT = '_inboundShipment';
	const _INVENTORYADJUSTMENT = '_inventoryAdjustment';
	const _INVENTORYCOSTREVALUATION = '_inventoryCostRevaluation';
	const _INVENTORYTRANSFER = '_inventoryTransfer';
	const _INVOICE = '_invoice';
	const _ITEMFULFILLMENT = '_itemFulfillment';
	const _ITEMRECEIPT = '_itemReceipt';
	const _JOURNAL = '_journal';
	const _OPPORTUNITY = '_opportunity';
	const _PAYCHECK = '_paycheck';
	const _PAYCHECKJOURNAL = '_paycheckJournal';
	const _PERIODENDJOURNAL = '_periodEndJournal';
	const _PURCHASEORDER = '_purchaseOrder';
	const _REQUISITION = '_requisition';
	const _RETURNAUTHORIZATION = '_returnAuthorization';
	const _SALESORDER = '_salesOrder';
	const _TRANSFERORDER = '_transferOrder';
	const _VENDORBILL = '_vendorBill';
	const _VENDORCREDIT = '_vendorCredit';
	const _VENDORPAYMENT = '_vendorPayment';
	const _VENDORRETURNAUTHORIZATION = '_vendorReturnAuthorization';
	const _WORKORDER = '_workOrder';
	const _WORKORDERCLOSE = '_workOrderClose';
	const _WORKORDERCOMPLETION = '_workOrderCompletion';
	const _WORKORDERISSUE = '_workOrderIssue';
}
