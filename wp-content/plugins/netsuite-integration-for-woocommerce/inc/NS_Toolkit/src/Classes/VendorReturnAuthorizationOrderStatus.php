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

class VendorReturnAuthorizationOrderStatus {
	public static $paramtypesmap = array(
	);
	const _CANCELLED = '_cancelled';
	const _CLOSED = '_closed';
	const _CREDITED = '_credited';
	const _PARTIALLYRETURNED = '_partiallyReturned';
	const _PENDINGAPPROVAL = '_pendingApproval';
	const _PENDINGCREDIT = '_pendingCredit';
	const _PENDINGCREDITPARTIALLYRETURNED = '_pendingCreditPartiallyReturned';
	const _PENDINGRETURN = '_pendingReturn';
	const _UNDEFINED = '_undefined';
}
