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

class InboundShipment extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $shipmentNumber;
	/**
	 * Var string
	 */
	public $externalDocumentNumber;
	/**
	 * Var \NetSuite\Classes\InboundShipmentShipmentStatus
	 */
	public $shipmentStatus;
	/**
	 * Var string
	 */
	public $expectedShippingDate;
	/**
	 * Var string
	 */
	public $actualShippingDate;
	/**
	 * Var string
	 */
	public $expectedDeliveryDate;
	/**
	 * Var string
	 */
	public $actualDeliveryDate;
	/**
	 * Var string
	 */
	public $shipmentMemo;
	/**
	 * Var string
	 */
	public $vesselNumber;
	/**
	 * Var string
	 */
	public $billOfLading;
	/**
	 * Var \NetSuite\Classes\InboundShipmentLandedCostList
	 */
	public $landedCostList;
	/**
	 * Var \NetSuite\Classes\InboundShipmentItemsList
	 */
	public $itemsList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipmentBaseCurrency;
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
		'customForm' => 'RecordRef',
		'shipmentNumber' => 'string',
		'externalDocumentNumber' => 'string',
		'shipmentStatus' => 'InboundShipmentShipmentStatus',
		'expectedShippingDate' => 'dateTime',
		'actualShippingDate' => 'dateTime',
		'expectedDeliveryDate' => 'dateTime',
		'actualDeliveryDate' => 'dateTime',
		'shipmentMemo' => 'string',
		'vesselNumber' => 'string',
		'billOfLading' => 'string',
		'landedCostList' => 'InboundShipmentLandedCostList',
		'itemsList' => 'InboundShipmentItemsList',
		'shipmentBaseCurrency' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
