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

class SearchTextNumberFieldOperator {
	public static $paramtypesmap = array(
	);
	const BETWEEN = 'between';
	const NSEMPTY = 'empty';
	const EQUALTO = 'equalTo';
	const GREATERTHAN = 'greaterThan';
	const GREATERTHANOREQUALTO = 'greaterThanOrEqualTo';
	const LESSTHAN = 'lessThan';
	const LESSTHANOREQUALTO = 'lessThanOrEqualTo';
	const NOTBETWEEN = 'notBetween';
	const NOTEMPTY = 'notEmpty';
	const NOTEQUALTO = 'notEqualTo';
	const NOTGREATERTHAN = 'notGreaterThan';
	const NOTGREATERTHANOREQUALTO = 'notGreaterThanOrEqualTo';
	const NOTLESSTHAN = 'notLessThan';
	const NOTLESSTHANOREQUALTO = 'notLessThanOrEqualTo';
}
