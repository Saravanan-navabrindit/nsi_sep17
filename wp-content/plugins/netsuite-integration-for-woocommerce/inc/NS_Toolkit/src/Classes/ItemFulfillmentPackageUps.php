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

class ItemFulfillmentPackageUps {
	/**
	 * Var float
	 */
	public $packageWeightUps;
	/**
	 * Var string
	 */
	public $packageDescrUps;
	/**
	 * Var string
	 */
	public $packageTrackingNumberUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUpsPackagingUps
	 */
	public $packagingUps;
	/**
	 * Var boolean
	 */
	public $useInsuredValueUps;
	/**
	 * Var float
	 */
	public $insuredValueUps;
	/**
	 * Var string
	 */
	public $reference1Ups;
	/**
	 * Var string
	 */
	public $reference2Ups;
	/**
	 * Var integer
	 */
	public $packageLengthUps;
	/**
	 * Var integer
	 */
	public $packageWidthUps;
	/**
	 * Var integer
	 */
	public $packageHeightUps;
	/**
	 * Var boolean
	 */
	public $additionalHandlingUps;
	/**
	 * Var boolean
	 */
	public $useCodUps;
	/**
	 * Var float
	 */
	public $codAmountUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUpsCodMethodUps
	 */
	public $codMethodUps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUpsDeliveryConfUps
	 */
	public $deliveryConfUps;
	public static $paramtypesmap = array(
		'packageWeightUps' => 'float',
		'packageDescrUps' => 'string',
		'packageTrackingNumberUps' => 'string',
		'packagingUps' => 'ItemFulfillmentPackageUpsPackagingUps',
		'useInsuredValueUps' => 'boolean',
		'insuredValueUps' => 'float',
		'reference1Ups' => 'string',
		'reference2Ups' => 'string',
		'packageLengthUps' => 'integer',
		'packageWidthUps' => 'integer',
		'packageHeightUps' => 'integer',
		'additionalHandlingUps' => 'boolean',
		'useCodUps' => 'boolean',
		'codAmountUps' => 'float',
		'codMethodUps' => 'ItemFulfillmentPackageUpsCodMethodUps',
		'deliveryConfUps' => 'ItemFulfillmentPackageUpsDeliveryConfUps',
	);
}
