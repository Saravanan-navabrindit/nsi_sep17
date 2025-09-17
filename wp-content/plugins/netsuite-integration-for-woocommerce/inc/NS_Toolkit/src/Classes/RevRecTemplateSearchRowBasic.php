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

class RevRecTemplateSearchRowBasic extends SearchRowBasic {
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $amorMethod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $amorPeriod;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $amorStartOffset;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $amorTermSrc;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $amorType;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $contraAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $deferralAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnSelectField[]
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $periodOffset;
	/**
	 * Var \NetSuite\Classes\SearchColumnStringField[]
	 */
	public $targetAccount;
	/**
	 * Var \NetSuite\Classes\SearchColumnBooleanField[]
	 */
	public $useForeignAmounts;
	public static $paramtypesmap = array(
		'amorMethod' => 'SearchColumnStringField[]',
		'amorPeriod' => 'SearchColumnStringField[]',
		'amorStartOffset' => 'SearchColumnStringField[]',
		'amorTermSrc' => 'SearchColumnStringField[]',
		'amorType' => 'SearchColumnStringField[]',
		'contraAccount' => 'SearchColumnStringField[]',
		'deferralAccount' => 'SearchColumnStringField[]',
		'externalId' => 'SearchColumnSelectField[]',
		'internalId' => 'SearchColumnSelectField[]',
		'isInactive' => 'SearchColumnStringField[]',
		'name' => 'SearchColumnStringField[]',
		'periodOffset' => 'SearchColumnStringField[]',
		'targetAccount' => 'SearchColumnStringField[]',
		'useForeignAmounts' => 'SearchColumnBooleanField[]',
	);
}
