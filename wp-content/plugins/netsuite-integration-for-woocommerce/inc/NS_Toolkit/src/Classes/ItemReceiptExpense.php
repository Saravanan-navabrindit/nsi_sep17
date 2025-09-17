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

class ItemReceiptExpense {
	/**
	 * Var boolean
	 */
	public $markReceived;
	/**
	 * Var integer
	 */
	public $orderLine;
	/**
	 * Var integer
	 */
	public $line;
	/**
	 * Var string
	 */
	public $account;
	/**
	 * Var string
	 */
	public $memo;
	/**
	 * Var float
	 */
	public $amount;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	public static $paramtypesmap = array(
		'markReceived' => 'boolean',
		'orderLine' => 'integer',
		'line' => 'integer',
		'account' => 'string',
		'memo' => 'string',
		'amount' => 'float',
		'customFieldList' => 'CustomFieldList',
	);
}
