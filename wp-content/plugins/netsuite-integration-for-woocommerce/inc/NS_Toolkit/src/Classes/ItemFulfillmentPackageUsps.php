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

class ItemFulfillmentPackageUsps {
	/**
	 * Var float
	 */
	public $packageWeightUsps;
	/**
	 * Var string
	 */
	public $packageDescrUsps;
	/**
	 * Var string
	 */
	public $packageTrackingNumberUsps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUspsPackagingUsps
	 */
	public $packagingUsps;
	/**
	 * Var boolean
	 */
	public $useInsuredValueUsps;
	/**
	 * Var float
	 */
	public $insuredValueUsps;
	/**
	 * Var string
	 */
	public $reference1Usps;
	/**
	 * Var string
	 */
	public $reference2Usps;
	/**
	 * Var integer
	 */
	public $packageLengthUsps;
	/**
	 * Var integer
	 */
	public $packageWidthUsps;
	/**
	 * Var integer
	 */
	public $packageHeightUsps;
	/**
	 * Var \NetSuite\Classes\ItemFulfillmentPackageUspsDeliveryConfUsps
	 */
	public $deliveryConfUsps;
	public static $paramtypesmap = array(
		'packageWeightUsps' => 'float',
		'packageDescrUsps' => 'string',
		'packageTrackingNumberUsps' => 'string',
		'packagingUsps' => 'ItemFulfillmentPackageUspsPackagingUsps',
		'useInsuredValueUsps' => 'boolean',
		'insuredValueUsps' => 'float',
		'reference1Usps' => 'string',
		'reference2Usps' => 'string',
		'packageLengthUsps' => 'integer',
		'packageWidthUsps' => 'integer',
		'packageHeightUsps' => 'integer',
		'deliveryConfUsps' => 'ItemFulfillmentPackageUspsDeliveryConfUsps',
	);
}
