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

class CampaignSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $audience;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $baseCost;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $campaignId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $channel;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $event;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $executedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $expectedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $family;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $isSalesCampaign;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $keyword;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $managerRole;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $message;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $offer;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $owner;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $recipient;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $response;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $responseCategory;
	/**
	 * Var \NetSuite\Classes\SearchColumnLongField[]
	 */
	public $responseCode;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $responseDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $responseNotes;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $revenue;
	/**
	 * Var \NetSuite\Classes\SearchColumnDoubleField[]
	 */
	public $roi;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $scheduledDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $searchEngine;
	/**
	 * Var \NetSuite\Classes\SearchColumnDateField[]
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchColumnEnumSelectField[]
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $url;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $vertical;
	/**
	 * Var \NetSuite\Classes\SearchColumnCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'audience' => 'SearchColumnSelectField[]',
		'baseCost' => 'SearchColumnDoubleField[]',
		'campaignId' => 'SearchColumnStringField[]',
		'category' => 'SearchColumnSelectField[]',
		'channel' => 'SearchColumnSelectField[]',
		'cost' => 'SearchColumnDoubleField[]',
		'createdDate' => 'SearchColumnDateField[]',
		'endDate' => 'SearchColumnDateField[]',
		'event' => 'SearchColumnStringField[]',
		'executedDate' => 'SearchColumnDateField[]',
		'expectedRevenue' => 'SearchColumnDoubleField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'family' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnBooleanField[]',
		'isSalesCampaign' => 'SearchColumnBooleanField[]',
		'item' => 'SearchColumnSelectField[]',
		'keyword' => 'SearchColumnStringField[]',
		'lastModifiedDate' => 'SearchColumnDateField[]',
		'managerRole' => 'SearchColumnSelectField[]',
		'message' => 'SearchColumnStringField[]',
		'offer' => 'SearchColumnSelectField[]',
		'owner' => 'SearchColumnSelectField[]',
		'promoCode' => 'SearchColumnStringField[]',
		'recipient' => 'SearchColumnSelectField[]',
		'response' => 'SearchColumnEnumSelectField[]',
		'responseCategory' => 'SearchColumnEnumSelectField[]',
		'responseCode' => 'SearchColumnLongField[]',
		'responseDate' => 'SearchColumnDateField[]',
		'responseNotes' => 'SearchColumnStringField[]',
		'revenue' => 'SearchColumnDoubleField[]',
		'roi' => 'SearchColumnDoubleField[]',
		'scheduledDate' => 'SearchColumnDateField[]',
		'searchEngine' => 'SearchColumnSelectField[]',
		'startDate' => 'SearchColumnDateField[]',
		'status' => 'SearchColumnEnumSelectField[]',
		'subscription' => 'SearchColumnSelectField[]',
		'title' => 'SearchColumnStringField[]',
		'url' => 'SearchColumnStringField[]',
		'vertical' => 'SearchColumnSelectField[]',
		'customFieldList' => 'SearchColumnCustomFieldList',
	);
}
