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

class CampaignDirectMail {
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $campaignGroup;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $template;
	/**
	 * Var string
	 */
	public $description;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $channel;
	/**
	 * Var float
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\CampaignCampaignDirectMailStatus
	 */
	public $status;
	/**
	 * Var string
	 */
	public $dateScheduled;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'internalId' => 'string',
		'campaignGroup' => 'RecordRef',
		'template' => 'RecordRef',
		'description' => 'string',
		'subscription' => 'RecordRef',
		'channel' => 'RecordRef',
		'cost' => 'float',
		'status' => 'CampaignCampaignDirectMailStatus',
		'dateScheduled' => 'dateTime',
		'promoCode' => 'RecordRef',
		'customFieldList' => 'CustomFieldList',
	);
}
