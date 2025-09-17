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

class ManufacturingRoutingSearchRow extends SearchRow {
	/**
	 * Var \NetSuite\Classes\ManufacturingRoutingSearchRowBasic
	 */
	public $basic;
	/**
	 * Var \NetSuite\Classes\ItemSearchRowBasic
	 */
	public $itemJoin;
	/**
	 * Var \NetSuite\Classes\LocationSearchRowBasic
	 */
	public $locationJoin;
	/**
	 * Var \NetSuite\Classes\ManufacturingCostTemplateSearchRowBasic
	 */
	public $manufacturingCostTemplateJoin;
	/**
	 * Var \NetSuite\Classes\EntityGroupSearchRowBasic
	 */
	public $manufacturingWorkCenterJoin;
	/**
	 * Var \NetSuite\Classes\EmployeeSearchRowBasic
	 */
	public $userJoin;
	/**
	 * Var \NetSuite\Classes\CustomSearchRowBasic[]
	 */
	public $customSearchJoin;
	public static $paramtypesmap = array(
		'basic' => 'ManufacturingRoutingSearchRowBasic',
		'itemJoin' => 'ItemSearchRowBasic',
		'locationJoin' => 'LocationSearchRowBasic',
		'manufacturingCostTemplateJoin' => 'ManufacturingCostTemplateSearchRowBasic',
		'manufacturingWorkCenterJoin' => 'EntityGroupSearchRowBasic',
		'userJoin' => 'EmployeeSearchRowBasic',
		'customSearchJoin' => 'CustomSearchRowBasic[]',
	);
}
