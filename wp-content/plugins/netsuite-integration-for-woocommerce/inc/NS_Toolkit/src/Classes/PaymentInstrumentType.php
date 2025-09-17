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

class PaymentInstrumentType {
	public static $paramtypesmap = array(
	);
	const _PAYMENTCARD = '_paymentCard';
	const _GENERALTOKEN = '_generalToken';
	const _PAYMENTCARDTOKEN = '_paymentCardToken';
	const _PAYMENTCARDSWIPE = '_paymentCardSwipe';
	const _EMV = '_emv';
	const _EXTERNALCHECKOUT = '_externalCheckout';
	const _CASH = '_cash';
	const _CHECK = '_check';
	const _OFFLINE = '_offline';
	const _PAYBYREFERENCE = '_payByReference';
	const _ACH = '_ach';
	const _PAYPAL = '_payPal';
}
