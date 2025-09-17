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

class CampaignResponseCategory {
	public static $paramtypesmap = array(
	);
	const _BOUNCED = '_bounced';
	const _CLICKEDTHROUGH = '_clickedThrough';
	const _FAILED = '_failed';
	const _PURCHASED = '_purchased';
	const _QUEUED = '_queued';
	const _RECEIVED = '_received';
	const _RESPONDED = '_responded';
	const _SENT = '_sent';
	const _SUBSCRIBED = '_subscribed';
	const _UNSUBSCRIBED = '_unsubscribed';
}
