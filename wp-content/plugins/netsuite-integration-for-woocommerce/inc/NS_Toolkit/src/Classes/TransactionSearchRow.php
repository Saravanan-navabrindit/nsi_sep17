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

class TransactionSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\AccountSearchRowBasic
	 */
	public $accountJoin;
	/**
	 * Var \NetSuite\Classes\AccountingPeriodSearchRowBasic
	 */
	public $accountingPeriodJoin;
	/**
	 * Var \NetSuite\Classes\AccountingTransactionSearchRowBasic
	 */
	public $accountingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchRowBasic
	 */
	public $advanceToApplyAccountJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $appliedToTransactionJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $applyingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $assemblyJoin;
	/**
	 * Var \NetSuite\Classes\AddressSearchRowBasic
	 */
	public $billingAddressJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $billingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\BinSearchRowBasic
	 */
	public $binNumberJoin;
	/**
	 * Var \NetSuite\Classes\BomSearchRowBasic
	 */
	public $bomJoin;
	/**
	 * Var \NetSuite\Classes\BomRevisionSearchRowBasic
	 */
	public $bomRevisionJoin;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchRowBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchRowBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\ClassificationSearchRowBasic
	 */
	public $classJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $cogsPurchaseJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $cogsSaleJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchRowBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $createdFromJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchRowBasic
	 */
	public $customerMainJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchRowBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $depositTransactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchRowBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\ExpenseCategorySearchRowBasic
	 */
	public $expenseCategoryJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $fromLocationJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $fulfillingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchRowBasic
	 */
	public $headerBillingAccountJoin;
	/**
	 * Var \NetSuite\Classes\InstallmentSearchRowBasic
	 */
	public $installmentJoin;
	/**
	 * Var \NetSuite\Classes\InventoryDetailSearchRowBasic
	 */
	public $inventoryDetailJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\InventoryNumberSearchRowBasic
	 */
	public $itemNumberJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchRowBasic
	 */
	public $jobMainJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchRowBasic
	 */
	public $leadSourceJoin;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchRowBasic
	 */
	public $lineBillingAccountJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchRowBasic
	 */
	public $lineFileJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\ManufacturingOperationTaskSearchRowBasic
	 */
	public $manufacturingOperationTaskJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchRowBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchRowBasic
	 */
	public $nextApproverJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchRowBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $outsourcingVendorJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $paidTransactionJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchRowBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $payingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\PaymentInstrumentSearchRowBasic
	 */
	public $paymentInstrumentJoin;
	/**
	 * Var \NetSuite\Classes\PaymentOptionSearchRowBasic
	 */
	public $paymentOptionJoin;
	/**
	 * Var \NetSuite\Classes\PayrollItemSearchRowBasic
	 */
	public $payrollItemJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchRowBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $purchaseOrderJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $requestorJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $revCommittingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\ItemRevisionSearchRowBasic
	 */
	public $revisionJoin;
	/**
	 * Var \NetSuite\Classes\RevRecScheduleSearchRowBasic
	 */
	public $revRecScheduleJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $rgPostingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchRowBasic
	 */
	public $salesOrderJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $salesRepJoin;
	/**
	 * Var \NetSuite\Classes\AddressSearchRowBasic
	 */
	public $shippingAddressJoin;
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchRowBasic
	 */
	public $subsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchRowBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\SalesTaxItemSearchRowBasic
	 */
	public $taxCodeJoin;
	/**
	 * Var \NetSuite\Classes\TaxDetailSearchRowBasic
	 */
	public $taxDetailJoin;
	/**
	 * Var \NetSuite\Classes\SalesTaxItemSearchRowBasic
	 */
	public $taxItemJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchRowBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $toLocationJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchRowBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchRowBasic
	 */
	public $vendorLineJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'TransactionSearchRowBasic',
		'accountJoin' => 'AccountSearchRowBasic',
		'accountingPeriodJoin' => 'AccountingPeriodSearchRowBasic',
		'accountingTransactionJoin' => 'AccountingTransactionSearchRowBasic',
		'advanceToApplyAccountJoin' => 'AccountSearchRowBasic',
		'appliedToTransactionJoin' => 'TransactionSearchRowBasic',
		'applyingTransactionJoin' => 'TransactionSearchRowBasic',
		'assemblyJoin' => 'ItemSearchRowBasic',
		'billingAddressJoin' => 'AddressSearchRowBasic',
		'billingTransactionJoin' => 'TransactionSearchRowBasic',
		'binNumberJoin' => 'BinSearchRowBasic',
		'bomJoin' => 'BomSearchRowBasic',
		'bomRevisionJoin' => 'BomRevisionSearchRowBasic',
		'callJoin' => 'PhoneCallSearchRowBasic',
		'caseJoin' => 'SupportCaseSearchRowBasic',
		'classJoin' => 'ClassificationSearchRowBasic',
		'cogsPurchaseJoin' => 'TransactionSearchRowBasic',
		'cogsSaleJoin' => 'TransactionSearchRowBasic',
		'contactPrimaryJoin' => 'ContactSearchRowBasic',
		'createdFromJoin' => 'TransactionSearchRowBasic',
		'customerJoin' => 'CustomerSearchRowBasic',
		'customerMainJoin' => 'CustomerSearchRowBasic',
		'departmentJoin' => 'DepartmentSearchRowBasic',
		'depositTransactionJoin' => 'TransactionSearchRowBasic',
		'employeeJoin' => 'EmployeeSearchRowBasic',
		'eventJoin' => 'CalendarEventSearchRowBasic',
		'expenseCategoryJoin' => 'ExpenseCategorySearchRowBasic',
		'fileJoin' => 'FileSearchRowBasic',
		'fromLocationJoin' => 'LocationSearchRowBasic',
		'fulfillingTransactionJoin' => 'TransactionSearchRowBasic',
		'headerBillingAccountJoin' => 'BillingAccountSearchRowBasic',
		'installmentJoin' => 'InstallmentSearchRowBasic',
		'inventoryDetailJoin' => 'InventoryDetailSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'itemNumberJoin' => 'InventoryNumberSearchRowBasic',
		'jobJoin' => 'JobSearchRowBasic',
		'jobMainJoin' => 'JobSearchRowBasic',
		'leadSourceJoin' => 'CampaignSearchRowBasic',
		'lineBillingAccountJoin' => 'BillingAccountSearchRowBasic',
		'lineFileJoin' => 'FileSearchRowBasic',
		'locationJoin' => 'LocationSearchRowBasic',
		'manufacturingOperationTaskJoin' => 'ManufacturingOperationTaskSearchRowBasic',
		'messagesJoin' => 'MessageSearchRowBasic',
		'nextApproverJoin' => 'EntitySearchRowBasic',
		'opportunityJoin' => 'OpportunitySearchRowBasic',
		'outsourcingVendorJoin' => 'VendorSearchRowBasic',
		'paidTransactionJoin' => 'TransactionSearchRowBasic',
		'partnerJoin' => 'PartnerSearchRowBasic',
		'payingTransactionJoin' => 'TransactionSearchRowBasic',
		'paymentInstrumentJoin' => 'PaymentInstrumentSearchRowBasic',
		'paymentOptionJoin' => 'PaymentOptionSearchRowBasic',
		'payrollItemJoin' => 'PayrollItemSearchRowBasic',
		'projectTaskJoin' => 'ProjectTaskSearchRowBasic',
		'purchaseOrderJoin' => 'TransactionSearchRowBasic',
		'requestorJoin' => 'EmployeeSearchRowBasic',
		'revCommittingTransactionJoin' => 'TransactionSearchRowBasic',
		'revisionJoin' => 'ItemRevisionSearchRowBasic',
		'revRecScheduleJoin' => 'RevRecScheduleSearchRowBasic',
		'rgPostingTransactionJoin' => 'TransactionSearchRowBasic',
		'salesOrderJoin' => 'TransactionSearchRowBasic',
		'salesRepJoin' => 'EmployeeSearchRowBasic',
		'shippingAddressJoin' => 'AddressSearchRowBasic',
		'subsidiaryJoin' => 'SubsidiarySearchRowBasic',
		'taskJoin' => 'TaskSearchRowBasic',
		'taxCodeJoin' => 'SalesTaxItemSearchRowBasic',
		'taxDetailJoin' => 'TaxDetailSearchRowBasic',
		'taxItemJoin' => 'SalesTaxItemSearchRowBasic',
		'timeJoin' => 'TimeBillSearchRowBasic',
		'toLocationJoin' => 'LocationSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'userNotesJoin' => 'NoteSearchRowBasic',
		'vendorJoin' => 'VendorSearchRowBasic',
		'vendorLineJoin' => 'VendorSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
