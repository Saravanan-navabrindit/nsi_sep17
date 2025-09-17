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

class RevRecTemplateSearchBasic extends SearchRecordBasic {
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $amorMethod;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $amorPeriod;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $amorStartOffset;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $amorTermSrc;
	/**
	 * Var \NetSuite\Classes\SearchEnumMultiSelectField
	 */
	public $amorType;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $contraAccount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $deferralAccount;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $externalId;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $externalIdString;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $internalId;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $internalIdNumber;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $isInactive;
	/**
	 * Var \NetSuite\Classes\SearchStringField
	 */
	public $name;
	/**
	 * Var \NetSuite\Classes\SearchLongField
	 */
	public $periodOffset;
	/**
	 * Var \NetSuite\Classes\SearchMultiSelectField
	 */
	public $targetAccount;
	/**
	 * Var \NetSuite\Classes\SearchBooleanField
	 */
	public $useForeignAmounts;
	public static $paramtypesmap = array(
		'amorMethod' => 'SearchEnumMultiSelectField',
		'amorPeriod' => 'SearchLongField',
		'amorStartOffset' => 'SearchLongField',
		'amorTermSrc' => 'SearchEnumMultiSelectField',
		'amorType' => 'SearchEnumMultiSelectField',
		'contraAccount' => 'SearchMultiSelectField',
		'deferralAccount' => 'SearchMultiSelectField',
		'externalId' => 'SearchMultiSelectField',
		'externalIdString' => 'SearchStringField',
		'internalId' => 'SearchMultiSelectField',
		'internalIdNumber' => 'SearchLongField',
		'isInactive' => 'SearchBooleanField',
		'name' => 'SearchStringField',
		'periodOffset' => 'SearchLongField',
		'targetAccount' => 'SearchMultiSelectField',
		'useForeignAmounts' => 'SearchBooleanField',
	);
}
