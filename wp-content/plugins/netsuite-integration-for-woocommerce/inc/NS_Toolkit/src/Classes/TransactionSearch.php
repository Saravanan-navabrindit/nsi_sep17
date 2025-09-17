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

class TransactionSearch extends SearchRecord {
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $accountJoin;
	/**
	 * Var \NetSuite\Classes\AccountingPeriodSearchBasic
	 */
	public $accountingPeriodJoin;
	/**
	 * Var \NetSuite\Classes\AccountingTransactionSearchBasic
	 */
	public $accountingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\AccountSearchBasic
	 */
	public $advanceToApplyAccountJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $appliedToTransactionJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $applyingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $assemblyJoin;
	/**
	 * Var \NetSuite\Classes\AddressSearchBasic
	 */
	public $billingAddressJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $billingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\BinSearchBasic
	 */
	public $binNumberJoin;
	/**
	 * Var \NetSuite\Classes\BomSearchBasic
	 */
	public $bomJoin;
	/**
	 * Var \NetSuite\Classes\BomRevisionSearchBasic
	 */
	public $bomRevisionJoin;
	/**
	 * Var \NetSuite\Classes\PhoneCallSearchBasic
	 */
	public $callJoin;
	/**
	 * Var \NetSuite\Classes\SupportCaseSearchBasic
	 */
	public $caseJoin;
	/**
	 * Var \NetSuite\Classes\ClassificationSearchBasic
	 */
	public $classJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $cogsPurchaseJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $cogsSaleJoin;
	/**
	 * Var \NetSuite\Classes\ContactSearchBasic
	 */
	public $contactPrimaryJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $createdFromJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerJoin;
	/**
	 * Var \NetSuite\Classes\CustomerSearchBasic
	 */
	public $customerMainJoin;
	/**
	 * Var \NetSuite\Classes\DepartmentSearchBasic
	 */
	public $departmentJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $depositTransactionJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $employeeJoin;
	/**
	 * Var \NetSuite\Classes\CalendarEventSearchBasic
	 */
	public $eventJoin;
	/**
	 * Var \NetSuite\Classes\ExpenseCategorySearchBasic
	 */
	public $expenseCategoryJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $fileJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $fromLocationJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $fulfillingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchBasic
	 */
	public $headerBillingAccountJoin;
	/**
	 * Var \NetSuite\Classes\InstallmentSearchBasic
	 */
	public $installmentJoin;
	/**
	 * Var \NetSuite\Classes\InventoryDetailSearchBasic
	 */
	public $inventoryDetailJoin;
	/**
	 * Var \NetSuite\Classes\ItemSearchBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\InventoryNumberSearchBasic
	 */
	public $itemNumberJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobJoin;
	/**
	 * Var \NetSuite\Classes\JobSearchBasic
	 */
	public $jobMainJoin;
	/**
	 * Var \NetSuite\Classes\CampaignSearchBasic
	 */
	public $leadSourceJoin;
	/**
	 * Var \NetSuite\Classes\BillingAccountSearchBasic
	 */
	public $lineBillingAccountJoin;
	/**
	 * Var \NetSuite\Classes\FileSearchBasic
	 */
	public $lineFileJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\ManufacturingOperationTaskSearchBasic
	 */
	public $manufacturingOperationTaskJoin;
	/**
	 * Var \NetSuite\Classes\MessageSearchBasic
	 */
	public $messagesJoin;
	/**
	 * Var \NetSuite\Classes\EntitySearchBasic
	 */
	public $nextApproverJoin;
	/**
	 * Var \NetSuite\Classes\OpportunitySearchBasic
	 */
	public $opportunityJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $outsourcingVendorJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $paidTransactionJoin;
	/**
	 * Var \NetSuite\Classes\PartnerSearchBasic
	 */
	public $partnerJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $payingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\PaymentInstrumentSearchBasic
	 */
	public $paymentInstrumentJoin;
	/**
	 * Var \NetSuite\Classes\PaymentOptionSearchBasic
	 */
	public $paymentOptionJoin;
	/**
	 * Var \NetSuite\Classes\PayrollItemSearchBasic
	 */
	public $payrollItemJoin;
	/**
	 * Var \NetSuite\Classes\ProjectTaskSearchBasic
	 */
	public $projectTaskJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $purchaseOrderJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $requestorJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $revCommittingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\ItemRevisionSearchBasic
	 */
	public $revisionJoin;
	/**
	 * Var \NetSuite\Classes\RevRecScheduleSearchBasic
	 */
	public $revRecScheduleJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $rgPostingTransactionJoin;
	/**
	 * Var \NetSuite\Classes\TransactionSearchBasic
	 */
	public $salesOrderJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $salesRepJoin;
	/**
	 * Var \NetSuite\Classes\AddressSearchBasic
	 */
	public $shippingAddressJoin;
	/**
	 * Var \NetSuite\Classes\SubsidiarySearchBasic
	 */
	public $subsidiaryJoin;
	/**
	 * Var \NetSuite\Classes\TaskSearchBasic
	 */
	public $taskJoin;
	/**
	 * Var \NetSuite\Classes\SalesTaxItemSearchBasic
	 */
	public $taxCodeJoin;
	/**
	 * Var \NetSuite\Classes\TaxDetailSearchBasic
	 */
	public $taxDetailJoin;
	/**
	 * Var \NetSuite\Classes\SalesTaxItemSearchBasic
	 */
	public $taxItemJoin;
	/**
	 * Var \NetSuite\Classes\TimeBillSearchBasic
	 */
	public $timeJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchBasic
	 */
	public $toLocationJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\NoteSearchBasic
	 */
	public $userNotesJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $vendorJoin;
	/**
	 * Var \NetSuite\Classes\VendorSearchBasic
	 */
	public $vendorLineJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchJoin[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'TransactionSearchBasic',
		'accountJoin' => 'AccountSearchBasic',
		'accountingPeriodJoin' => 'AccountingPeriodSearchBasic',
		'accountingTransactionJoin' => 'AccountingTransactionSearchBasic',
		'advanceToApplyAccountJoin' => 'AccountSearchBasic',
		'appliedToTransactionJoin' => 'TransactionSearchBasic',
		'applyingTransactionJoin' => 'TransactionSearchBasic',
		'assemblyJoin' => 'ItemSearchBasic',
		'billingAddressJoin' => 'AddressSearchBasic',
		'billingTransactionJoin' => 'TransactionSearchBasic',
		'binNumberJoin' => 'BinSearchBasic',
		'bomJoin' => 'BomSearchBasic',
		'bomRevisionJoin' => 'BomRevisionSearchBasic',
		'callJoin' => 'PhoneCallSearchBasic',
		'caseJoin' => 'SupportCaseSearchBasic',
		'classJoin' => 'ClassificationSearchBasic',
		'cogsPurchaseJoin' => 'TransactionSearchBasic',
		'cogsSaleJoin' => 'TransactionSearchBasic',
		'contactPrimaryJoin' => 'ContactSearchBasic',
		'createdFromJoin' => 'TransactionSearchBasic',
		'customerJoin' => 'CustomerSearchBasic',
		'customerMainJoin' => 'CustomerSearchBasic',
		'departmentJoin' => 'DepartmentSearchBasic',
		'depositTransactionJoin' => 'TransactionSearchBasic',
		'employeeJoin' => 'EmployeeSearchBasic',
		'eventJoin' => 'CalendarEventSearchBasic',
		'expenseCategoryJoin' => 'ExpenseCategorySearchBasic',
		'fileJoin' => 'FileSearchBasic',
		'fromLocationJoin' => 'LocationSearchBasic',
		'fulfillingTransactionJoin' => 'TransactionSearchBasic',
		'headerBillingAccountJoin' => 'BillingAccountSearchBasic',
		'installmentJoin' => 'InstallmentSearchBasic',
		'inventoryDetailJoin' => 'InventoryDetailSearchBasic',
		'itemJoin' => 'ItemSearchBasic',
		'itemNumberJoin' => 'InventoryNumberSearchBasic',
		'jobJoin' => 'JobSearchBasic',
		'jobMainJoin' => 'JobSearchBasic',
		'leadSourceJoin' => 'CampaignSearchBasic',
		'lineBillingAccountJoin' => 'BillingAccountSearchBasic',
		'lineFileJoin' => 'FileSearchBasic',
		'locationJoin' => 'LocationSearchBasic',
		'manufacturingOperationTaskJoin' => 'ManufacturingOperationTaskSearchBasic',
		'messagesJoin' => 'MessageSearchBasic',
		'nextApproverJoin' => 'EntitySearchBasic',
		'opportunityJoin' => 'OpportunitySearchBasic',
		'outsourcingVendorJoin' => 'VendorSearchBasic',
		'paidTransactionJoin' => 'TransactionSearchBasic',
		'partnerJoin' => 'PartnerSearchBasic',
		'payingTransactionJoin' => 'TransactionSearchBasic',
		'paymentInstrumentJoin' => 'PaymentInstrumentSearchBasic',
		'paymentOptionJoin' => 'PaymentOptionSearchBasic',
		'payrollItemJoin' => 'PayrollItemSearchBasic',
		'projectTaskJoin' => 'ProjectTaskSearchBasic',
		'purchaseOrderJoin' => 'TransactionSearchBasic',
		'requestorJoin' => 'EmployeeSearchBasic',
		'revCommittingTransactionJoin' => 'TransactionSearchBasic',
		'revisionJoin' => 'ItemRevisionSearchBasic',
		'revRecScheduleJoin' => 'RevRecScheduleSearchBasic',
		'rgPostingTransactionJoin' => 'TransactionSearchBasic',
		'salesOrderJoin' => 'TransactionSearchBasic',
		'salesRepJoin' => 'EmployeeSearchBasic',
		'shippingAddressJoin' => 'AddressSearchBasic',
		'subsidiaryJoin' => 'SubsidiarySearchBasic',
		'taskJoin' => 'TaskSearchBasic',
		'taxCodeJoin' => 'SalesTaxItemSearchBasic',
		'taxDetailJoin' => 'TaxDetailSearchBasic',
		'taxItemJoin' => 'SalesTaxItemSearchBasic',
		'timeJoin' => 'TimeBillSearchBasic',
		'toLocationJoin' => 'LocationSearchBasic',
		'userJoin' => 'EmployeeSearchBasic',
		'userNotesJoin' => 'NoteSearchBasic',
		'vendorJoin' => 'VendorSearchBasic',
		'vendorLineJoin' => 'VendorSearchBasic',
		'customSearchJoin' => 'CustomSearchJoin[]',
	);
}
