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

class PurchaseOrder extends Record {
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
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $purchaseContract;
	/**
	 * Var string
	 */
	public $vatRegNum;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employee;
	/**
	 * Var boolean
	 */
	public $supervisorApproval;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $terms;
	/**
	 * Var string
	 */
	public $dueDate;
	/**
	 * Var string
	 */
	public $otherRefNum;
	/**
	 * Var float
	 */
	public $availableVendorCredit;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $approvalStatus;
	/**
	 * Var float
	 */
	public $exchangeRate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $nextApprover;
	/**
	 * Var string
	 */
	public $source;
	/**
	 * Var string
	 */
	public $currencyName;
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
	public $currency;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipTo;
	/**
	 * Var float
	 */
	public $subTotal;
	/**
	 * Var float
	 */
	public $taxTotal;
	/**
	 * Var float
	 */
	public $tax2Total;
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $incoterm;
	/**
	 * Var string
	 */
	public $trackingNumbers;
	/**
	 * Var string
	 */
	public $linkedTrackingNumbers;
	/**
	 * Var float
	 */
	public $total;
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
	 * Var string
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\PurchaseOrderOrderStatus
	 */
	public $orderStatus;
	/**
	 * Var \NetSuite\Classes\PurchaseOrderItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
	/**
	 * Var \NetSuite\Classes\PurchaseOrderExpenseList
	 */
	public $expenseList;
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
		'entity' => 'RecordRef',
		'purchaseContract' => 'RecordRef',
		'vatRegNum' => 'string',
		'employee' => 'RecordRef',
		'supervisorApproval' => 'boolean',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'entityTaxRegNum' => 'RecordRef',
		'taxPointDate' => 'dateTime',
		'createdFrom' => 'RecordRef',
		'terms' => 'RecordRef',
		'dueDate' => 'dateTime',
		'otherRefNum' => 'string',
		'availableVendorCredit' => 'float',
		'memo' => 'string',
		'approvalStatus' => 'RecordRef',
		'exchangeRate' => 'float',
		'nextApprover' => 'RecordRef',
		'source' => 'string',
		'currencyName' => 'string',
		'toBePrinted' => 'boolean',
		'toBeEmailed' => 'boolean',
		'email' => 'string',
		'toBeFaxed' => 'boolean',
		'fax' => 'string',
		'message' => 'string',
		'billingAddress' => 'Address',
		'billAddressList' => 'RecordRef',
		'currency' => 'RecordRef',
		'shipTo' => 'RecordRef',
		'subTotal' => 'float',
		'taxTotal' => 'float',
		'tax2Total' => 'float',
		'shippingAddress' => 'Address',
		'shipIsResidential' => 'boolean',
		'shipAddressList' => 'RecordRef',
		'fob' => 'string',
		'shipDate' => 'dateTime',
		'shipMethod' => 'RecordRef',
		'incoterm' => 'RecordRef',
		'trackingNumbers' => 'string',
		'linkedTrackingNumbers' => 'string',
		'total' => 'float',
		'class' => 'RecordRef',
		'department' => 'RecordRef',
		'location' => 'RecordRef',
		'subsidiary' => 'RecordRef',
		'intercoTransaction' => 'RecordRef',
		'intercoStatus' => 'IntercoStatus',
		'status' => 'string',
		'orderStatus' => 'PurchaseOrderOrderStatus',
		'itemList' => 'PurchaseOrderItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'expenseList' => 'PurchaseOrderExpenseList',
		'taxDetailsList' => 'TaxDetailsList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
