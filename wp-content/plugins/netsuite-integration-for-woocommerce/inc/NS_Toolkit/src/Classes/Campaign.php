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

class Campaign extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $customForm;
	/**
	 * Var string
	 */
	public $campaignId;
	/**
	 * Var string
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $owner;
	/**
	 * Var string
	 */
	public $startDate;
	/**
	 * Var string
	 */
	public $endDate;
	/**
	 * Var string
	 */
	public $url;
	/**
	 * Var float
	 */
	public $baseCost;
	/**
	 * Var float
	 */
	public $cost;
	/**
	 * Var float
	 */
	public $expectedRevenue;
	/**
	 * Var string
	 */
	public $message;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var boolean
	 */
	public $local;
	/**
	 * Var float
	 */
	public $totalRevenue;
	/**
	 * Var float
	 */
	public $roi;
	/**
	 * Var float
	 */
	public $profit;
	/**
	 * Var float
	 */
	public $costPerCustomer;
	/**
	 * Var float
	 */
	public $convCostPerCustomer;
	/**
	 * Var integer
	 */
	public $conversions;
	/**
	 * Var integer
	 */
	public $leadsGenerated;
	/**
	 * Var integer
	 */
	public $uniqueVisitors;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $vertical;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $audience;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $offer;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $promotionCode;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $itemList;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $family;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $searchEngine;
	/**
	 * Var string
	 */
	public $keyword;
	/**
	 * Var \NetSuite\Classes\CampaignEmailList
	 */
	public $campaignEmailList;
	/**
	 * Var \NetSuite\Classes\CampaignDirectMailList
	 */
	public $campaignDirectMailList;
	/**
	 * Var \NetSuite\Classes\CampaignEventList
	 */
	public $campaignEventList;
	/**
	 * Var \NetSuite\Classes\CampaignEventResponseList
	 */
	public $eventResponseList;
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
		'campaignId' => 'string',
		'title' => 'string',
		'category' => 'RecordRef',
		'owner' => 'RecordRef',
		'startDate' => 'dateTime',
		'endDate' => 'dateTime',
		'url' => 'string',
		'baseCost' => 'float',
		'cost' => 'float',
		'expectedRevenue' => 'float',
		'message' => 'string',
		'isInactive' => 'boolean',
		'local' => 'boolean',
		'totalRevenue' => 'float',
		'roi' => 'float',
		'profit' => 'float',
		'costPerCustomer' => 'float',
		'convCostPerCustomer' => 'float',
		'conversions' => 'integer',
		'leadsGenerated' => 'integer',
		'uniqueVisitors' => 'integer',
		'vertical' => 'RecordRef',
		'audience' => 'RecordRef',
		'offer' => 'RecordRef',
		'promotionCode' => 'RecordRef',
		'itemList' => 'RecordRefList',
		'family' => 'RecordRef',
		'searchEngine' => 'RecordRef',
		'keyword' => 'string',
		'campaignEmailList' => 'CampaignEmailList',
		'campaignDirectMailList' => 'CampaignDirectMailList',
		'campaignEventList' => 'CampaignEventList',
		'eventResponseList' => 'CampaignEventResponseList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
