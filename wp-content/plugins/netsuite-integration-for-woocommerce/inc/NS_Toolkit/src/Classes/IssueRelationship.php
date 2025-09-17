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

class IssueRelationship {
	public static $paramtypesmap = array(
	);
	const _BLOCKS = '_blocks';
	const _DEPENDSON = '_dependsOn';
	const _DUPLICATEDBY = '_duplicatedBy';
	const _DUPLICATES = '_duplicates';
	const _FOLLOWEDUPBY = '_followedUpBy';
	const _FOLLOWUPFOR = '_followUpFor';
	const _INJECTEDBY = '_injectedBy';
	const _INJECTS = '_injects';
	const _ISBLOCKEDBY = '_isBlockedBy';
	const _ISREQUIREDFOR = '_isRequiredFor';
	const _RELATEDTO = '_relatedTo';
}
