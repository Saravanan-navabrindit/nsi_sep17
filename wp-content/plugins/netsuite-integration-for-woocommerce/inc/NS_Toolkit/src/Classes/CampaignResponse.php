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

class CampaignResponse extends Record {
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $entity;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $leadSource;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $campaignEvent;
	/**
	 * Var string
	 */
	public $campaignResponseDate;
	/**
	 * Var string
	 */
	public $channel;
	/**
	 * Var \NetSuite\Classes\CampaignResponseResponse
	 */
	public $response;
	/**
	 * Var string
	 */
	public $note;
	/**
	 * Var \NetSuite\Classes\CampaignResponseResponsesList
	 */
	public $responsesList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'entity' => 'RecordRef',
		'leadSource' => 'RecordRef',
		'campaignEvent' => 'RecordRef',
		'campaignResponseDate' => 'dateTime',
		'channel' => 'string',
		'response' => 'CampaignResponseResponse',
		'note' => 'string',
		'responsesList' => 'CampaignResponseResponsesList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
