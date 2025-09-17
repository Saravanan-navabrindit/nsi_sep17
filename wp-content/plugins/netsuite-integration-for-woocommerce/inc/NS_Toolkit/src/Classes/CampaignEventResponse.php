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

class CampaignEventResponse {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var string
	 */
	public $type;
	/**
	 * Var string
	 */
	public $dateSent;
	/**
	 * Var float
	 */
	public $sent;
	/**
	 * Var float
	 */
	public $opened;
	/**
	 * Var float
	 */
	public $openedRatio;
	/**
	 * Var float
	 */
	public $clickedThru;
	/**
	 * Var float
	 */
	public $clickedThruRatio;
	/**
	 * Var integer
	 */
	public $responded;
	/**
	 * Var float
	 */
	public $respondedRatio;
	/**
	 * Var integer
	 */
	public $unsubscribed;
	/**
	 * Var float
	 */
	public $unsubscribedRatio;
	/**
	 * Var integer
	 */
	public $bounced;
	/**
	 * Var float
	 */
	public $bouncedRatio;
	public static $paramtypesmap = array(
		'name' => 'string',
		'type' => 'string',
		'dateSent' => 'dateTime',
		'sent' => 'float',
		'opened' => 'float',
		'openedRatio' => 'float',
		'clickedThru' => 'float',
		'clickedThruRatio' => 'float',
		'responded' => 'integer',
		'respondedRatio' => 'float',
		'unsubscribed' => 'integer',
		'unsubscribedRatio' => 'float',
		'bounced' => 'integer',
		'bouncedRatio' => 'float',
	);
}
