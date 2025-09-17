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

class ItemFulfillment extends Record {
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
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $postingPeriod;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $createdFrom;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $requestedBy;
	/**
	 * Var integer
	 */
	public $createdFromShipGroup;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $partner;
	/**
	 * Var \NetSuite\Classes\Address
	 */
	public $shippingAddress;
	/**
	 * Var string
	 */
	public $pickedDate;
	/**
	 * Var string
	 */
	public $packedDate;
	/**
	 * Var string
	 */
	public $shippedDate;
	/**
	 * Var boolean
	 */
	public $shipIsResidential;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $shipAddressList;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentShipStatus
	 */
	public $shipStatus;
	/**
	 * Var boolean
	 */
	public $saturdayDeliveryUps;
	/**
	 * Var boolean
	 */
	public $sendShipNotifyEmailUps;
	/**
	 * Var boolean
	 */
	public $sendBackupEmailUps;
	/**
	 * Var string
	 */
	public $shipNotifyEmailAddressUps;
	/**
	 * Var string
	 */
	public $shipNotifyEmailAddress2Ups;
	/**
	 * Var string
	 */
	public $backupEmailAddressUps;
	/**
	 * Var string
	 */
	public $shipNotifyEmailMessageUps;
	/**
	 * Var string
	 */
	public $thirdPartyAcctUps;
	/**
	 * Var string
	 */
	public $thirdPartyZipcodeUps;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $thirdPartyCountryUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentThirdPartyTypeUps
	 */
	public $thirdPartyTypeUps;
	/**
	 * Var boolean
	 */
	public $partiesToTransactionUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentExportTypeUps
	 */
	public $exportTypeUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentMethodOfTransportUps
	 */
	public $methodOfTransportUps;
	/**
	 * Var string
	 */
	public $carrierIdUps;
	/**
	 * Var string
	 */
	public $entryNumberUps;
	/**
	 * Var string
	 */
	public $inbondCodeUps;
	/**
	 * Var boolean
	 */
	public $isRoutedExportTransactionUps;
	/**
	 * Var string
	 */
	public $licenseNumberUps;
	/**
	 * Var string
	 */
	public $licenseDateUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentLicenseExceptionUps
	 */
	public $licenseExceptionUps;
	/**
	 * Var string
	 */
	public $eccNumberUps;
	/**
	 * Var string
	 */
	public $recipientTaxIdUps;
	/**
	 * Var string
	 */
	public $blanketStartDateUps;
	/**
	 * Var string
	 */
	public $blanketEndDateUps;
	/**
	 * Var float
	 */
	public $shipmentWeightUps;
	/**
	 * Var boolean
	 */
	public $saturdayDeliveryFedEx;
	/**
	 * Var boolean
	 */
	public $saturdayPickupFedex;
	/**
	 * Var boolean
	 */
	public $sendShipNotifyEmailFedEx;
	/**
	 * Var boolean
	 */
	public $sendBackupEmailFedEx;
	/**
	 * Var boolean
	 */
	public $signatureHomeDeliveryFedEx;
	/**
	 * Var string
	 */
	public $shipNotifyEmailAddressFedEx;
	/**
	 * Var string
	 */
	public $backupEmailAddressFedEx;
	/**
	 * Var string
	 */
	public $shipDateFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentHomeDeliveryTypeFedEx
	 */
	public $homeDeliveryTypeFedEx;
	/**
	 * Var string
	 */
	public $homeDeliveryDateFedEx;
	/**
	 * Var string
	 */
	public $bookingConfirmationNumFedEx;
	/**
	 * Var string
	 */
	public $intlExemptionNumFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentB13AFilingOptionFedEx
	 */
	public $b13aFilingOptionFedEx;
	/**
	 * Var string
	 */
	public $b13aStatementDataFedEx;
	/**
	 * Var string
	 */
	public $thirdPartyAcctFedEx;
	/**
	 * Var \NetSuite\Classes\Country::*
	 */
	public $thirdPartyCountryFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentThirdPartyTypeFedEx
	 */
	public $thirdPartyTypeFedEx;
	/**
	 * Var float
	 */
	public $shipmentWeightFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentTermsOfSaleFedEx
	 */
	public $termsOfSaleFedEx;
	/**
	 * Var float
	 */
	public $termsFreightChargeFedEx;
	/**
	 * Var float
	 */
	public $termsInsuranceChargeFedEx;
	/**
	 * Var boolean
	 */
	public $insideDeliveryFedEx;
	/**
	 * Var boolean
	 */
	public $insidePickupFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentAncillaryEndorsementFedEx
	 */
	public $ancillaryEndorsementFedEx;
	/**
	 * Var boolean
	 */
	public $holdAtLocationFedEx;
	/**
	 * Var string
	 */
	public $halPhoneFedEx;
	/**
	 * Var string
	 */
	public $halAddr1FedEx;
	/**
	 * Var string
	 */
	public $halAddr2FedEx;
	/**
	 * Var string
	 */
	public $halAddr3FedEx;
	/**
	 * Var string
	 */
	public $halCityFedEx;
	/**
	 * Var string
	 */
	public $halZipFedEx;
	/**
	 * Var string
	 */
	public $halStateFedEx;
	/**
	 * Var string
	 */
	public $halCountryFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentHazmatTypeFedEx
	 */
	public $hazmatTypeFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentAccessibilityTypeFedEx
	 */
	public $accessibilityTypeFedEx;
	/**
	 * Var boolean
	 */
	public $isCargoAircraftOnlyFedEx;
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
	public $shipMethod;
	/**
	 * Var boolean
	 */
	public $generateIntegratedShipperLabel;
	/**
	 * Var float
	 */
	public $shippingCost;
	/**
	 * Var float
	 */
	public $handlingCost;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $transferLocation;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageList
	 */
	public $packageList;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUpsList
	 */
	public $packageUpsList;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUspsList
	 */
	public $packageUspsList;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExList
	 */
	public $packageFedExList;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentItemList
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
		'postingPeriod' => 'RecordRef',
		'entity' => 'RecordRef',
		'createdFrom' => 'RecordRef',
		'requestedBy' => 'RecordRef',
		'createdFromShipGroup' => 'integer',
		'partner' => 'RecordRef',
		'shippingAddress' => 'Address',
		'pickedDate' => 'dateTime',
		'packedDate' => 'dateTime',
		'shippedDate' => 'dateTime',
		'shipIsResidential' => 'boolean',
		'shipAddressList' => 'RecordRef',
		'shipStatus' => 'ItemFulfillmentShipStatus',
		'saturdayDeliveryUps' => 'boolean',
		'sendShipNotifyEmailUps' => 'boolean',
		'sendBackupEmailUps' => 'boolean',
		'shipNotifyEmailAddressUps' => 'string',
		'shipNotifyEmailAddress2Ups' => 'string',
		'backupEmailAddressUps' => 'string',
		'shipNotifyEmailMessageUps' => 'string',
		'thirdPartyAcctUps' => 'string',
		'thirdPartyZipcodeUps' => 'string',
		'thirdPartyCountryUps' => 'Country',
		'thirdPartyTypeUps' => 'ItemFulfillmentThirdPartyTypeUps',
		'partiesToTransactionUps' => 'boolean',
		'exportTypeUps' => 'ItemFulfillmentExportTypeUps',
		'methodOfTransportUps' => 'ItemFulfillmentMethodOfTransportUps',
		'carrierIdUps' => 'string',
		'entryNumberUps' => 'string',
		'inbondCodeUps' => 'string',
		'isRoutedExportTransactionUps' => 'boolean',
		'licenseNumberUps' => 'string',
		'licenseDateUps' => 'dateTime',
		'licenseExceptionUps' => 'ItemFulfillmentLicenseExceptionUps',
		'eccNumberUps' => 'string',
		'recipientTaxIdUps' => 'string',
		'blanketStartDateUps' => 'dateTime',
		'blanketEndDateUps' => 'dateTime',
		'shipmentWeightUps' => 'float',
		'saturdayDeliveryFedEx' => 'boolean',
		'saturdayPickupFedex' => 'boolean',
		'sendShipNotifyEmailFedEx' => 'boolean',
		'sendBackupEmailFedEx' => 'boolean',
		'signatureHomeDeliveryFedEx' => 'boolean',
		'shipNotifyEmailAddressFedEx' => 'string',
		'backupEmailAddressFedEx' => 'string',
		'shipDateFedEx' => 'dateTime',
		'homeDeliveryTypeFedEx' => 'ItemFulfillmentHomeDeliveryTypeFedEx',
		'homeDeliveryDateFedEx' => 'dateTime',
		'bookingConfirmationNumFedEx' => 'string',
		'intlExemptionNumFedEx' => 'string',
		'b13aFilingOptionFedEx' => 'ItemFulfillmentB13AFilingOptionFedEx',
		'b13aStatementDataFedEx' => 'string',
		'thirdPartyAcctFedEx' => 'string',
		'thirdPartyCountryFedEx' => 'Country',
		'thirdPartyTypeFedEx' => 'ItemFulfillmentThirdPartyTypeFedEx',
		'shipmentWeightFedEx' => 'float',
		'termsOfSaleFedEx' => 'ItemFulfillmentTermsOfSaleFedEx',
		'termsFreightChargeFedEx' => 'float',
		'termsInsuranceChargeFedEx' => 'float',
		'insideDeliveryFedEx' => 'boolean',
		'insidePickupFedEx' => 'boolean',
		'ancillaryEndorsementFedEx' => 'ItemFulfillmentAncillaryEndorsementFedEx',
		'holdAtLocationFedEx' => 'boolean',
		'halPhoneFedEx' => 'string',
		'halAddr1FedEx' => 'string',
		'halAddr2FedEx' => 'string',
		'halAddr3FedEx' => 'string',
		'halCityFedEx' => 'string',
		'halZipFedEx' => 'string',
		'halStateFedEx' => 'string',
		'halCountryFedEx' => 'string',
		'hazmatTypeFedEx' => 'ItemFulfillmentHazmatTypeFedEx',
		'accessibilityTypeFedEx' => 'ItemFulfillmentAccessibilityTypeFedEx',
		'isCargoAircraftOnlyFedEx' => 'boolean',
		'tranDate' => 'dateTime',
		'tranId' => 'string',
		'shipMethod' => 'RecordRef',
		'generateIntegratedShipperLabel' => 'boolean',
		'shippingCost' => 'float',
		'handlingCost' => 'float',
		'memo' => 'string',
		'transferLocation' => 'RecordRef',
		'packageList' => 'ItemFulfillmentPackageList',
		'packageUpsList' => 'ItemFulfillmentPackageUpsList',
		'packageUspsList' => 'ItemFulfillmentPackageUspsList',
		'packageFedExList' => 'ItemFulfillmentPackageFedExList',
		'itemList' => 'ItemFulfillmentItemList',
		'accountingBookDetailList' => 'AccountingBookDetailList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
