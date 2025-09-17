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

class RecordType {
	public static $paramtypesmap = array(
	);
	const ACCOUNT = 'account';
	const ACCOUNTINGPERIOD = 'accountingPeriod';
	const ADVINTERCOMPANYJOURNALENTRY = 'advInterCompanyJournalEntry';
	const ASSEMBLYBUILD = 'assemblyBuild';
	const ASSEMBLYUNBUILD = 'assemblyUnbuild';
	const ASSEMBLYITEM = 'assemblyItem';
	const BILLINGACCOUNT = 'billingAccount';
	const BILLINGSCHEDULE = 'billingSchedule';
	const BIN = 'bin';
	const BINTRANSFER = 'binTransfer';
	const BINWORKSHEET = 'binWorksheet';
	const BOM = 'bom';
	const BOMREVISION = 'bomRevision';
	const BUDGET = 'budget';
	const BUDGETCATEGORY = 'budgetCategory';
	const CALENDAREVENT = 'calendarEvent';
	const CAMPAIGN = 'campaign';
	const CAMPAIGNAUDIENCE = 'campaignAudience';
	const CAMPAIGNCATEGORY = 'campaignCategory';
	const CAMPAIGNCHANNEL = 'campaignChannel';
	const CAMPAIGNFAMILY = 'campaignFamily';
	const CAMPAIGNOFFER = 'campaignOffer';
	const CAMPAIGNRESPONSE = 'campaignResponse';
	const CAMPAIGNSEARCHENGINE = 'campaignSearchEngine';
	const CAMPAIGNSUBSCRIPTION = 'campaignSubscription';
	const CAMPAIGNVERTICAL = 'campaignVertical';
	const CASHREFUND = 'cashRefund';
	const CASHSALE = 'cashSale';
	const CHECK = 'check';
	const CHARGE = 'charge';
	const CLASSIFICATION = 'classification';
	const CONSOLIDATEDEXCHANGERATE = 'consolidatedExchangeRate';
	const CONTACT = 'contact';
	const CONTACTCATEGORY = 'contactCategory';
	const CONTACTROLE = 'contactRole';
	const COSTCATEGORY = 'costCategory';
	const COUPONCODE = 'couponCode';
	const CREDITMEMO = 'creditMemo';
	const CRMCUSTOMFIELD = 'crmCustomField';
	const CURRENCY = 'currency';
	const CURRENCYRATE = 'currencyRate';
	const CUSTOMLIST = 'customList';
	const CUSTOMPURCHASE = 'customPurchase';
	const CUSTOMRECORD = 'customRecord';
	const CUSTOMRECORDCUSTOMFIELD = 'customRecordCustomField';
	const CUSTOMRECORDTYPE = 'customRecordType';
	const CUSTOMSALE = 'customSale';
	const CUSTOMSEGMENT = 'customSegment';
	const CUSTOMTRANSACTION = 'customTransaction';
	const CUSTOMTRANSACTIONTYPE = 'customTransactionType';
	const CUSTOMER = 'customer';
	const CUSTOMERCATEGORY = 'customerCategory';
	const CUSTOMERDEPOSIT = 'customerDeposit';
	const CUSTOMERMESSAGE = 'customerMessage';
	const CUSTOMERPAYMENT = 'customerPayment';
	const CUSTOMERREFUND = 'customerRefund';
	const CUSTOMERSTATUS = 'customerStatus';
	const CUSTOMERSUBSIDIARYRELATIONSHIP = 'customerSubsidiaryRelationship';
	const DEPOSIT = 'deposit';
	const DEPOSITAPPLICATION = 'depositApplication';
	const DEPARTMENT = 'department';
	const DESCRIPTIONITEM = 'descriptionItem';
	const DISCOUNTITEM = 'discountItem';
	const DOWNLOADITEM = 'downloadItem';
	const EMPLOYEE = 'employee';
	const ENTITYCUSTOMFIELD = 'entityCustomField';
	const ENTITYGROUP = 'entityGroup';
	const ESTIMATE = 'estimate';
	const EXPENSECATEGORY = 'expenseCategory';
	const EXPENSEREPORT = 'expenseReport';
	const FAIRVALUEPRICE = 'fairValuePrice';
	const FILE = 'file';
	const FOLDER = 'folder';
	const GENERALTOKEN = 'generalToken';
	const GIFTCERTIFICATE = 'giftCertificate';
	const GIFTCERTIFICATEITEM = 'giftCertificateItem';
	const GLOBALACCOUNTMAPPING = 'globalAccountMapping';
	const HCMJOB = 'hcmJob';
	const INBOUNDSHIPMENT = 'inboundShipment';
	const INTERCOMPANYJOURNALENTRY = 'interCompanyJournalEntry';
	const INTERCOMPANYTRANSFERORDER = 'interCompanyTransferOrder';
	const INVENTORYADJUSTMENT = 'inventoryAdjustment';
	const INVENTORYCOSTREVALUATION = 'inventoryCostRevaluation';
	const INVENTORYITEM = 'inventoryItem';
	const INVENTORYNUMBER = 'inventoryNumber';
	const INVENTORYTRANSFER = 'inventoryTransfer';
	const INVOICE = 'invoice';
	const ITEMACCOUNTMAPPING = 'itemAccountMapping';
	const ITEMCUSTOMFIELD = 'itemCustomField';
	const ITEMDEMANDPLAN = 'itemDemandPlan';
	const ITEMFULFILLMENT = 'itemFulfillment';
	const ITEMGROUP = 'itemGroup';
	const ITEMNUMBERCUSTOMFIELD = 'itemNumberCustomField';
	const ITEMOPTIONCUSTOMFIELD = 'itemOptionCustomField';
	const ITEMSUPPLYPLAN = 'itemSupplyPlan';
	const ITEMREVISION = 'itemRevision';
	const ISSUE = 'issue';
	const JOB = 'job';
	const JOBSTATUS = 'jobStatus';
	const JOBTYPE = 'jobType';
	const ITEMRECEIPT = 'itemReceipt';
	const JOURNALENTRY = 'journalEntry';
	const KITITEM = 'kitItem';
	const LEADSOURCE = 'leadSource';
	const LOCATION = 'location';
	const LOTNUMBEREDINVENTORYITEM = 'lotNumberedInventoryItem';
	const LOTNUMBEREDASSEMBLYITEM = 'lotNumberedAssemblyItem';
	const MARKUPITEM = 'markupItem';
	const MERCHANDISEHIERARCHYNODE = 'merchandiseHierarchyNode';
	const MESSAGE = 'message';
	const MANUFACTURINGCOSTTEMPLATE = 'manufacturingCostTemplate';
	const MANUFACTURINGOPERATIONTASK = 'manufacturingOperationTask';
	const MANUFACTURINGROUTING = 'manufacturingRouting';
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
	const OTHERCUSTOMFIELD = 'otherCustomField';
	const OTHERNAMECATEGORY = 'otherNameCategory';
	const PARTNER = 'partner';
	const PARTNERCATEGORY = 'partnerCategory';
	const PAYCHECK = 'paycheck';
	const PAYCHECKJOURNAL = 'paycheckJournal';
	const PAYMENTCARD = 'paymentCard';
	const PAYMENTCARDTOKEN = 'paymentCardToken';
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
	const REVRECSCHEDULE = 'revRecSchedule';
	const REVRECTEMPLATE = 'revRecTemplate';
	const SALESORDER = 'salesOrder';
	const SALESROLE = 'salesRole';
	const SALESTAXITEM = 'salesTaxItem';
	const SERIALIZEDINVENTORYITEM = 'serializedInventoryItem';
	const SERIALIZEDASSEMBLYITEM = 'serializedAssemblyItem';
	const SERVICEPURCHASEITEM = 'servicePurchaseItem';
	const SERVICERESALEITEM = 'serviceResaleItem';
	const SERVICESALEITEM = 'serviceSaleItem';
	const SOLUTION = 'solution';
	const SITECATEGORY = 'siteCategory';
	const STATE = 'state';
	const STATISTICALJOURNALENTRY = 'statisticalJournalEntry';
	const SUBSIDIARY = 'subsidiary';
	const SUBTOTALITEM = 'subtotalItem';
	const SUPPORTCASE = 'supportCase';
	const SUPPORTCASEISSUE = 'supportCaseIssue';
	const SUPPORTCASEORIGIN = 'supportCaseOrigin';
	const SUPPORTCASEPRIORITY = 'supportCasePriority';
	const SUPPORTCASESTATUS = 'supportCaseStatus';
	const SUPPORTCASETYPE = 'supportCaseType';
	const TASK = 'task';
	const TAXACCT = 'taxAcct';
	const TAXGROUP = 'taxGroup';
	const TAXTYPE = 'taxType';
	const TERM = 'term';
	const TIMEBILL = 'timeBill';
	const TIMESHEET = 'timeSheet';
	const TOPIC = 'topic';
	const TRANSFERORDER = 'transferOrder';
	const TRANSACTIONBODYCUSTOMFIELD = 'transactionBodyCustomField';
	const TRANSACTIONCOLUMNCUSTOMFIELD = 'transactionColumnCustomField';
	const UNITSTYPE = 'unitsType';
	const USAGE = 'usage';
	const VENDOR = 'vendor';
	const VENDORCATEGORY = 'vendorCategory';
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
