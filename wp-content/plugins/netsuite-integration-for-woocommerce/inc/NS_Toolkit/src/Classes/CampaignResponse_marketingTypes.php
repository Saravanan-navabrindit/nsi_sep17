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

class CampaignResponse_MarketingTypes {
	public static $paramtypesmap = array(
	);
	const _CLICKEDTHROUGH = '_clickedThrough';
	const _FAILEDDELIVERYFAILURE = '_failedDeliveryFailure';
	const _FAILEDINVALIDADDRESS = '_failedInvalidAddress';
	const _FAILEDOTHER = '_failedOther';
	const _FAILEDSPAM = '_failedSpam';
	const _FAILEDTEMPLATEERROR = '_failedTemplateError';
	const _FAILEDUNEXPECTEDERROR = '_failedUnexpectedError';
	const _INVALIDSENDERADDRESS = '_invalidSenderAddress';
	const _MAILBOXDISABLED = '_mailboxDisabled';
	const _MAILBOXISFULL = '_mailboxIsFull';
	const _MAILBOXNOTACCEPTINGMESSAGES = '_mailboxNotAcceptingMessages';
	const _MAILPROTOCOLISSUES = '_mailProtocolIssues';
	const _MEDIAERROR = '_mediaError';
	const _MESSAGEEXCEEDSSIZELENGTHLIMITS = '_messageExceedsSizeLengthLimits';
	const _NETWORKSERVERISSUES = '_networkServerIssues';
	const _OPENED = '_opened';
	const _PURCHASED = '_purchased';
	const _QUEUED = '_queued';
	const _RECEIVED = '_received';
	const _RESPONDED = '_responded';
	const _SECURITYISSUES = '_securityIssues';
	const _SENT = '_sent';
	const _SKIPPEDDUETOPREVIOUSHARDBOUNCE = '_skippedDueToPreviousHardBounce';
	const _SUBSCRIBED = '_subscribed';
	const _TOOMANYRECIPIENTS = '_tooManyRecipients';
	const _UNSUBSCRIBED = '_unsubscribed';
	const _UNSUBSCRIBEDBYFEEDBACKLOOP = '_unsubscribedByFeedbackLoop';
}
