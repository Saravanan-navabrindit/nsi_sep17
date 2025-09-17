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

class CampaignSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $audience;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $baseCost;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $campaignEventType;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $campaignId;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $category;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $channel;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $cost;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $createdDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $endDate;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $event;
	/**
	 * Var \NetSuite\Classes\SearchDoubleField
	 */
	public $expectedRevenue;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $family;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $group;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isSalesCampaign;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $item;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $keyword;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $lastModifiedDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $manager;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $managerRole;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $number;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $offer;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $promoCode;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $recipient;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $response;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $responseCategory;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $responseCode;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $responseComments;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $responseDate;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $scheduleDate;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $searchEngine;
	/**
	 * Var \NetSuite\Classes\SearchDateField
	 */
	public $startDate;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $status;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $subscription;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $template;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $title;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $vertical;
	/**
	 * Var \NetSuite\Classes\SearchCustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'audience' => 'SearchMultiSelectField',
		'baseCost' => 'SearchDoubleField',
		'campaignEventType' => 'SearchEnumMultiSelectField',
		'campaignId' => 'SearchStringField',
		'category' => 'SearchMultiSelectField',
		'channel' => 'SearchMultiSelectField',
		'cost' => 'SearchDoubleField',
		'createdDate' => 'SearchDateField',
		'endDate' => 'SearchDateField',
		'event' => 'SearchStringField',
		'expectedRevenue' => 'SearchDoubleField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'family' => 'SearchMultiSelectField',
		'group' => 'SearchMultiSelectField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'isSalesCampaign' => 'SearchBooleanField',
		'item' => 'SearchMultiSelectField',
		'keyword' => 'SearchStringField',
		'lastModifiedDate' => 'SearchDateField',
		'manager' => 'SearchMultiSelectField',
		'managerRole' => 'SearchMultiSelectField',
		'number' => 'SearchLongField',
		'offer' => 'SearchMultiSelectField',
		'promoCode' => 'SearchMultiSelectField',
		'recipient' => 'SearchMultiSelectField',
		'response' => 'SearchEnumMultiSelectField',
		'responseCategory' => 'SearchEnumMultiSelectField',
		'responseCode' => 'SearchLongField',
		'responseComments' => 'SearchStringField',
		'responseDate' => 'SearchDateField',
		'scheduleDate' => 'SearchDateField',
		'searchEngine' => 'SearchMultiSelectField',
		'startDate' => 'SearchDateField',
		'status' => 'SearchEnumMultiSelectField',
		'subscription' => 'SearchMultiSelectField',
		'template' => 'SearchMultiSelectField',
		'title' => 'SearchStringField',
		'vertical' => 'SearchMultiSelectField',
		'customFieldList' => 'SearchCustomFieldList',
	);
}
