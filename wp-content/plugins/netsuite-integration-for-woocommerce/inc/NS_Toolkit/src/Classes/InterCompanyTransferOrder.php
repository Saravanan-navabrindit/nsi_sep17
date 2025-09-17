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

class InterCompanyTransferOrder extends Record {
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
	public $customForm;
	/**
	 * Var float
	 */
	public $shippingCost;
	/**
	 * Var float
	 */
	public $subTotal;
	/**
	 * Var string
	 */
	public $status;
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
	public $tranDate;
	/**
	 * Var string
	 */
	public $tranId;
	/**
	 * Var string
	 */
	public $source;
	/**
	 * Var \NetSuite\Classes\TransferOrderOrderStatus
	 */
	public $orderStatus;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $toSubsidiary;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $employee;
	/**
	 * Var boolean
	 */
	public $useItemCostAsTransferCost;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $incoterm;
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
	public $transferLocation;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var string
	 */
	public $shipDate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipMethod;
	/**
	 * Var string
	 */
	public $trackingNumbers;
	/**
	 * Var string
	 */
	public $linkedTrackingNumbers;
	/**
	 * Var boolean
	 */
	public $shipComplete;
	/**
	 * Var float
	 */
	public $altShippingCost;
	/**
	 * Var float
	 */
	public $shippingTax1Rate;
	/**
	 * Var float
	 */
	public $handlingTax1Rate;
	/**
	 * Var float
	 */
	public $shippingTax2Rate;
	/**
	 * Var float
	 */
	public $handlingTax2Rate;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shippingTaxCode;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $handlingTaxCode;
	/**
	 * Var float
	 */
	public $total;
	/**
	 * Var \NetSuite\Classes\InterCompanyTransferOrderItemList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\AccountingBookDetailList
	 */
	public $accountingBookDetailList;
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
		'customForm' => 'RecordRef',
		'shippingCost' => 'float',
		'subTotal' => 'float',
		'status' => 'string',
		'shippingAddress' => 'Address',
		'shipIsResidential' => 'boolean',
		'shipAddressList' => 'RecordRef',
		'fob' => 'string',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'source' => 'string',
		'orderStatus' => 'TransferOrderOrderStatus',
		'subsidiary' => 'RecordRef',
		'toSubsidiary' => 'RecordRef',
		'employee' => 'RecordRef',
		'useItemCostAsTransferCost' => 'boolean',
		'incoterm' => 'RecordRef',
		'department' => 'RecordRef',
		'class' => 'RecordRef',
		'location' => 'RecordRef',
		'transferLocation' => 'RecordRef',
		'memo' => 'string',
		'shipDate' => 'dateTime',
		'shipMethod' => 'RecordRef',
		'trackingNumbers' => 'string',
		'linkedTrackingNumbers' => 'string',
		'shipComplete' => 'boolean',
		'altShippingCost' => 'float',
		'shippingTax1Rate' => 'float',
		'handlingTax1Rate' => 'float',
		'shippingTax2Rate' => 'float',
		'handlingTax2Rate' => 'float',
		'shippingTaxCode' => 'RecordRef',
		'handlingTaxCode' => 'RecordRef',
		'total' => 'float',
		'itemList' => 'InterCompanyTransferOrderItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
