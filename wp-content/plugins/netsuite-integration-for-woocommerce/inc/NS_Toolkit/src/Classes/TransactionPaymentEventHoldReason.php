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

class TransactionPaymentEventHoldReason {
	public static $paramtypesmap = array(
	);
	const _AMOUNTEXCEEDSMAXIMUMALLOWEDAMOUNT = '_amountExceedsMaximumAllowedAmount';
	const _AUTHORIZATIONDECLINE = '_authorizationDecline';
	const _CARDEXPIRED = '_cardExpired';
	const _CARDINVALID = '_cardInvalid';
	const _CONFIRMATIONOFTHEOPERATIONISPENDING = '_confirmationOfTheOperationIsPending';
	const _EXTERNALFRAUDREJECTION = '_externalFraudRejection';
	const _EXTERNALFRAUDREVIEW = '_externalFraudReview';
	const _FAILEDTOPRIMEDEVICE = '_failedToPrimeDevice';
	const _FATALERROR = '_fatalError';
	const _FORWARDEDTOPAYERAUTHENTICATION = '_forwardedToPayerAuthentication';
	const _FORWARDREQUESTED = '_forwardRequested';
	const _FORWARDTOAUTHENTICATEDEVICE = '_forwardToAuthenticateDevice';
	const _FORWARDTOCHALLENGESHOPPER = '_forwardToChallengeShopper';
	const _GATEWAYASYNCHRONOUSNOTIFICATION = '_gatewayAsynchronousNotification';
	const _GATEWAYERROR = '_gatewayError';
	const _GENERALHOLD = '_generalHold';
	const _GENERALREJECT = '_generalReject';
	const _NOTREQUIRED = '_notRequired';
	const _OPERATIONWASSUCCESSFUL = '_operationWasSuccessful';
	const _OPERATIONWASTERMINATED = '_operationWasTerminated';
	const _OVERRIDENBY = '_overridenBy';
	const _PARTNERDECLINE = '_partnerDecline';
	const _PAYMENTDEVICEWASPRIMED = '_paymentDeviceWasPrimed';
	const _PAYMENTOPERATIONWASCANCELED = '_paymentOperationWasCanceled';
	const _SYSTEMERROR = '_systemError';
	const _VERBALAUTHORIZATIONREQUESTED = '_verbalAuthorizationRequested';
	const _VERIFICATIONREJECTION = '_verificationRejection';
	const _VERIFICATIONREQUIRED = '_verificationRequired';
}
