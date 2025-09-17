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

class ItemFulfillmentPackageFedEx {
	/**
	 * Var float
	 */
	public $packageWeightFedEx;
	/**
	 * Var float
	 */
	public $dryIceWeightFedEx;
	/**
	 * Var string
	 */
	public $packageTrackingNumberFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExPackagingFedEx
	 */
	public $packagingFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExAdmPackageTypeFedEx
	 */
	public $admPackageTypeFedEx;
	/**
	 * Var boolean
	 */
	public $isNonStandardContainerFedEx;
	/**
	 * Var boolean
	 */
	public $isAlcoholFedEx;
	/**
	 * Var \NetSuite\Classes\AlcoholRecipientType
	 */
	public $alcoholRecipientTypeFedEx;
	/**
	 * Var boolean
	 */
	public $isNonHazLithiumFedEx;
	/**
	 * Var float
	 */
	public $insuredValueFedEx;
	/**
	 * Var boolean
	 */
	public $useInsuredValueFedEx;
	/**
	 * Var string
	 */
	public $reference1FedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExPriorityAlertTypeFedEx
	 */
	public $priorityAlertTypeFedEx;
	/**
	 * Var string
	 */
	public $priorityAlertContentFedEx;
	/**
	 * Var integer
	 */
	public $packageLengthFedEx;
	/**
	 * Var integer
	 */
	public $packageWidthFedEx;
	/**
	 * Var integer
	 */
	public $packageHeightFedEx;
	/**
	 * Var boolean
	 */
	public $useCodFedEx;
	/**
	 * Var float
	 */
	public $codAmountFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExCodMethodFedEx
	 */
	public $codMethodFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExCodFreightTypeFedEx
	 */
	public $codFreightTypeFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExDeliveryConfFedEx
	 */
	public $deliveryConfFedEx;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageFedExSignatureOptionsFedEx
	 */
	public $signatureOptionsFedEx;
	/**
	 * Var string
	 */
	public $signatureReleaseFedEx;
	/**
	 * Var string
	 */
	public $authorizationNumberFedEx;
	public static $paramtypesmap = array(
		'packageWeightFedEx' => 'float',
		'dryIceWeightFedEx' => 'float',
		'packageTrackingNumberFedEx' => 'string',
		'packagingFedEx' => 'ItemFulfillmentPackageFedExPackagingFedEx',
		'admPackageTypeFedEx' => 'ItemFulfillmentPackageFedExAdmPackageTypeFedEx',
		'isNonStandardContainerFedEx' => 'boolean',
		'isAlcoholFedEx' => 'boolean',
		'alcoholRecipientTypeFedEx' => 'AlcoholRecipientType',
		'isNonHazLithiumFedEx' => 'boolean',
		'insuredValueFedEx' => 'float',
		'useInsuredValueFedEx' => 'boolean',
		'reference1FedEx' => 'string',
		'priorityAlertTypeFedEx' => 'ItemFulfillmentPackageFedExPriorityAlertTypeFedEx',
		'priorityAlertContentFedEx' => 'string',
		'packageLengthFedEx' => 'integer',
		'packageWidthFedEx' => 'integer',
		'packageHeightFedEx' => 'integer',
		'useCodFedEx' => 'boolean',
		'codAmountFedEx' => 'float',
		'codMethodFedEx' => 'ItemFulfillmentPackageFedExCodMethodFedEx',
		'codFreightTypeFedEx' => 'ItemFulfillmentPackageFedExCodFreightTypeFedEx',
		'deliveryConfFedEx' => 'ItemFulfillmentPackageFedExDeliveryConfFedEx',
		'signatureOptionsFedEx' => 'ItemFulfillmentPackageFedExSignatureOptionsFedEx',
		'signatureReleaseFedEx' => 'string',
		'authorizationNumberFedEx' => 'string',
	);
}
