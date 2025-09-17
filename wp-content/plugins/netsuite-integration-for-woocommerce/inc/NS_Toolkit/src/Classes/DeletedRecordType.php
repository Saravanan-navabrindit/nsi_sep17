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

class DeletedRecordType {
	public static $paramtypesmap = array(
	);
	const ADVINTERCOMPANYJOURNALENTRY = 'advInterCompanyJournalEntry';
	const ASSEMBLYBUILD = 'assemblyBuild';
	const ASSEMBLYITEM = 'assemblyItem';
	const ASSEMBLYUNBUILD = 'assemblyUnbuild';
	const BILLINGSCHEDULE = 'billingSchedule';
	const BIN = 'bin';
	const BINTRANSFER = 'binTransfer';
	const BINWORKSHEET = 'binWorksheet';
	const BOM = 'bom';
	const BOMREVISION = 'bomRevision';
	const CALENDAREVENT = 'calendarEvent';
	const CAMPAIGN = 'campaign';
	const CASHREFUND = 'cashRefund';
	const CASHSALE = 'cashSale';
	const CHARGE = 'charge';
	const CHECK = 'check';
	const CONTACT = 'contact';
	const CONTACTCATEGORY = 'contactCategory';
	const COSTCATEGORY = 'costCategory';
	const COUPONCODE = 'couponCode';
	const CREDITMEMO = 'creditMemo';
	const CURRENCYRATE = 'currencyRate';
	const CUSTOMPURCHASE = 'customPurchase';
	const CUSTOMRECORD = 'customRecord';
	const CUSTOMSALE = 'customSale';
	const CUSTOMTRANSACTION = 'customTransaction';
	const CUSTOMER = 'customer';
	const CUSTOMERCATEGORY = 'customerCategory';
	const CUSTOMERMESSAGE = 'customerMessage';
	const CUSTOMERDEPOSIT = 'customerDeposit';
	const CUSTOMERPAYMENT = 'customerPayment';
	const CUSTOMERREFUND = 'customerRefund';
	const CUSTOMERSTATUS = 'customerStatus';
	const CUSTOMERSUBSIDIARYRELATIONSHIP = 'customerSubsidiaryRelationship';
	const DEPOSIT = 'deposit';
	const DEPOSITAPPLICATION = 'depositApplication';
	const DESCRIPTIONITEM = 'descriptionItem';
	const DISCOUNTITEM = 'discountItem';
	const DOWNLOADITEM = 'downloadItem';
	const EMPLOYEE = 'employee';
	const ESTIMATE = 'estimate';
	const EXPENSEREPORT = 'expenseReport';
	const FILE = 'file';
	const FOLDER = 'folder';
	const GIFTCERTIFICATEITEM = 'giftCertificateItem';
	const GLOBALACCOUNTMAPPING = 'globalAccountMapping';
	const INTERCOMPANYJOURNALENTRY = 'interCompanyJournalEntry';
	const INTERCOMPANYTRANSFERORDER = 'interCompanyTransferOrder';
	const INVENTORYADJUSTMENT = 'inventoryAdjustment';
	const INVENTORYCOSTREVALUATION = 'inventoryCostRevaluation';
	const INVENTORYITEM = 'inventoryItem';
	const INVENTORYNUMBER = 'inventoryNumber';
	const INVENTORYTRANSFER = 'inventoryTransfer';
	const INVOICE = 'invoice';
	const ISSUE = 'issue';
	const ITEMACCOUNTMAPPING = 'itemAccountMapping';
	const ITEMDEMANDPLAN = 'itemDemandPlan';
	const ITEMFULFILLMENT = 'itemFulfillment';
	const ITEMSUPPLYPLAN = 'itemSupplyPlan';
	const ITEMGROUP = 'itemGroup';
	const ITEMRECEIPT = 'itemReceipt';
	const ITEMREVISION = 'itemRevision';
	const JOB = 'job';
	const JOBSTATUS = 'jobStatus';
	const JOURNALENTRY = 'journalEntry';
	const KITITEM = 'kitItem';
	const LOTNUMBEREDASSEMBLYITEM = 'lotNumberedAssemblyItem';
	const LOTNUMBEREDINVENTORYITEM = 'lotNumberedInventoryItem';
	const MARKUPITEM = 'markupItem';
	const MESSAGE = 'message';
	const MANUFACTURINGCOSTTEMPLATE = 'manufacturingCostTemplate';
	const MANUFACTURINGOPERATIONTASK = 'manufacturingOperationTask';
	const MANUFACTURINGROUTING = 'manufacturingRouting';
	const MERCHANDISEHIERARCHYNODE = 'merchandiseHierarchyNode';
	const NEXUS = 'nexus';
	const NONINVENTORYPURCHASEITEM = 'nonInventoryPurchaseItem';
	const NONINVENTORYRESALEITEM = 'nonInventoryResaleItem';
	const NONINVENTORYSALEITEM = 'nonInventorySaleItem';
	const NOTE = 'note';
	const NOTETYPE = 'noteType';
	const OPPORTUNITY = 'opportunity';
	const OTHERCHARGEPURCHASEITEM = 'otherChargePurchaseItem';
	const OTHERCHARGERESALEITEM = 'otherChargeResaleItem';
	const OTHERCHARGESALEITEM = 'otherChargeSaleItem';
	const OTHERNAMECATEGORY = 'otherNameCategory';
	const PARTNER = 'partner';
	const PAYCHECK = 'paycheck';
	const PAYMENTITEM = 'paymentItem';
	const PAYMENTMETHOD = 'paymentMethod';
	const PAYROLLITEM = 'payrollItem';
	const PERIODENDJOURNAL = 'periodEndJournal';
	const PHONECALL = 'phoneCall';
	const PRICELEVEL = 'priceLevel';
	const PRICINGGROUP = 'pricingGroup';
	const PROJECTTASK = 'projectTask';
	const PROMOTIONCODE = 'promotionCode';
	const PURCHASEORDER = 'purchaseOrder';
	const PURCHASEREQUISITION = 'purchaseRequisition';
	const RESOURCEALLOCATION = 'resourceAllocation';
	const RETURNAUTHORIZATION = 'returnAuthorization';
	const SALESORDER = 'salesOrder';
	const SALESTAXITEM = 'salesTaxItem';
	const SERIALIZEDASSEMBLYITEM = 'serializedAssemblyItem';
	const SERIALIZEDINVENTORYITEM = 'serializedInventoryItem';
	const SERVICEPURCHASEITEM = 'servicePurchaseItem';
	const SERVICERESALEITEM = 'serviceResaleItem';
	const SERVICESALEITEM = 'serviceSaleItem';
	const STATISTICALJOURNALENTRY = 'statisticalJournalEntry';
	const SUBTOTALITEM = 'subtotalItem';
	const SUPPORTCASE = 'supportCase';
	const SUPPORTCASEISSUE = 'supportCaseIssue';
	const SUPPORTCASEORIGIN = 'supportCaseOrigin';
	const SUPPORTCASEPRIORITY = 'supportCasePriority';
	const SUPPORTCASESTATUS = 'supportCaseStatus';
	const SUPPORTCASETYPE = 'supportCaseType';
	const TASK = 'task';
	const TERM = 'term';
	const TIMESHEET = 'timeSheet';
	const TRANSFERORDER = 'transferOrder';
	const USAGE = 'usage';
	const VENDOR = 'vendor';
	const VENDORBILL = 'vendorBill';
	const VENDORCREDIT = 'vendorCredit';
	const VENDORPAYMENT = 'vendorPayment';
	const VENDORRETURNAUTHORIZATION = 'vendorReturnAuthorization';
	const VENDORSUBSIDIARYRELATIONSHIP = 'vendorSubsidiaryRelationship';
	const WINLOSSREASON = 'winLossReason';
	const WORKORDER = 'workOrder';
	const WORKORDERISSUE = 'workOrderIssue';
	const WORKORDERCOMPLETION = 'workOrderCompletion';
	const WORKORDERCLOSE = 'workOrderClose';
}
