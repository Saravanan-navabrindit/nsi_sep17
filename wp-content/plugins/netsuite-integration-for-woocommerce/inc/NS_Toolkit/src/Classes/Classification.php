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

class Classification extends Record {
	/**
	 * Var string
	 */
	public $name;
	/**
	 * Var boolean
	 */
	public $includeChildren;
	/**
	 * Var \NetSuite\Classes\RecordRef
	 */
	public $parent;
	/**
	 * Var boolean
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\ClassTranslationList
	 */
	public $classTranslationList;
	/**
	 * Var \NetSuite\Classes\RecordRefList
	 */
	public $subsidiaryList;
	/**
	 * Var \NetSuite\Classes\CustomFieldList
	 */
	public $customFieldList;
	/**
	 * Var string
	 */
	public $internalId;
	/**
	 * Var string
	 */
	public $externalId;
	public static $paramtypesmap = array(
		'name' => 'string',
		'includeChildren' => 'boolean',
		'parent' => 'RecordRef',
		'isInactive' => 'boolean',
		'classTranslationList' => 'ClassTranslationList',
		'subsidiaryList' => 'RecordRefList',
		'customFieldList' => 'CustomFieldList',
		'internalId' => 'string',
		'externalId' => 'string',
	);
}
