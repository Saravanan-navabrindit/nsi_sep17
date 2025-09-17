<?php
/**
 * This file is part of the netsuitephp/netsuite-php library
 * AND originally from the NetSuite PHP Toolkit.
 *
 * New content:
 *
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

class SearchDate {
	public static $paramtypesmap = array(
	);
	const FISCALHALFBEFORELAST = 'fiscalHalfBeforeLast';
	const FISCALHALFBEFORELASTTODATE = 'fiscalHalfBeforeLastToDate';
	const FISCALQUARTERBEFORELAST = 'fiscalQuarterBeforeLast';
	const FISCALQUARTERBEFORELASTTODATE = 'fiscalQuarterBeforeLastToDate';
	const FISCALYEARBEFORELAST = 'fiscalYearBeforeLast';
	const FISCALYEARBEFORELASTTODATE = 'fiscalYearBeforeLastToDate';
	const FIVEDAYSAGO = 'fiveDaysAgo';
	const FIVEDAYSFROMNOW = 'fiveDaysFromNow';
	const FOURDAYSAGO = 'fourDaysAgo';
	const FOURDAYSFROMNOW = 'fourDaysFromNow';
	const FOURWEEKSSTARTINGTHISWEEK = 'fourWeeksStartingThisWeek';
	const LASTBUSINESSWEEK = 'lastBusinessWeek';
	const LASTFISCALHALF = 'lastFiscalHalf';
	const LASTFISCALHALFONEFISCALYEARAGO = 'lastFiscalHalfOneFiscalYearAgo';
	const LASTFISCALHALFTODATE = 'lastFiscalHalfToDate';
	const LASTFISCALQUARTER = 'lastFiscalQuarter';
	const LASTFISCALQUARTERONEFISCALYEARAGO = 'lastFiscalQuarterOneFiscalYearAgo';
	const LASTFISCALQUARTERTODATE = 'lastFiscalQuarterToDate';
	const LASTFISCALQUARTERTWOFISCALYEARSAGO = 'lastFiscalQuarterTwoFiscalYearsAgo';
	const LASTFISCALYEAR = 'lastFiscalYear';
	const LASTFISCALYEARTODATE = 'lastFiscalYearToDate';
	const LASTMONTH = 'lastMonth';
	const LASTMONTHONEFISCALQUARTERAGO = 'lastMonthOneFiscalQuarterAgo';
	const LASTMONTHONEFISCALYEARAGO = 'lastMonthOneFiscalYearAgo';
	const LASTMONTHTODATE = 'lastMonthToDate';
	const LASTMONTHTWOFISCALQUARTERSAGO = 'lastMonthTwoFiscalQuartersAgo';
	const LASTMONTHTWOFISCALYEARSAGO = 'lastMonthTwoFiscalYearsAgo';
	const LASTROLLINGHALF = 'lastRollingHalf';
	const LASTROLLINGQUARTER = 'lastRollingQuarter';
	const LASTROLLINGYEAR = 'lastRollingYear';
	const LASTWEEK = 'lastWeek';
	const LASTWEEKTODATE = 'lastWeekToDate';
	const MONTHAFTERNEXT = 'monthAfterNext';
	const MONTHAFTERNEXTTODATE = 'monthAfterNextToDate';
	const MONTHBEFORELAST = 'monthBeforeLast';
	const MONTHBEFORELASTTODATE = 'monthBeforeLastToDate';
	const NEXTBUSINESSWEEK = 'nextBusinessWeek';
	const NEXTFISCALHALF = 'nextFiscalHalf';
	const NEXTFISCALQUARTER = 'nextFiscalQuarter';
	const NEXTFISCALYEAR = 'nextFiscalYear';
	const NEXTFOURWEEKS = 'nextFourWeeks';
	const NEXTMONTH = 'nextMonth';
	const NEXTONEHALF = 'nextOneHalf';
	const NEXTONEMONTH = 'nextOneMonth';
	const NEXTONEQUARTER = 'nextOneQuarter';
	const NEXTONEWEEK = 'nextOneWeek';
	const NEXTONEYEAR = 'nextOneYear';
	const NEXTWEEK = 'nextWeek';
	const NINETYDAYSAGO = 'ninetyDaysAgo';
	const NINETYDAYSFROMNOW = 'ninetyDaysFromNow';
	const ONEYEARBEFORELAST = 'oneYearBeforeLast';
	const PREVIOUSFISCALQUARTERSLASTFISCALYEAR = 'previousFiscalQuartersLastFiscalYear';
	const PREVIOUSFISCALQUARTERSTHISFISCALYEAR = 'previousFiscalQuartersThisFiscalYear';
	const PREVIOUSMONTHSLASTFISCALHALF = 'previousMonthsLastFiscalHalf';
	const PREVIOUSMONTHSLASTFISCALQUARTER = 'previousMonthsLastFiscalQuarter';
	const PREVIOUSMONTHSLASTFISCALYEAR = 'previousMonthsLastFiscalYear';
	const PREVIOUSMONTHSSAMEFISCALHALFLASTFISCALYEAR = 'previousMonthsSameFiscalHalfLastFiscalYear';
	const PREVIOUSMONTHSSAMEFISCALQUARTERLASTFISCALYEAR = 'previousMonthsSameFiscalQuarterLastFiscalYear';
	const PREVIOUSMONTHSTHISFISCALHALF = 'previousMonthsThisFiscalHalf';
	const PREVIOUSMONTHSTHISFISCALQUARTER = 'previousMonthsThisFiscalQuarter';
	const PREVIOUSMONTHSTHISFISCALYEAR = 'previousMonthsThisFiscalYear';
	const PREVIOUSONEDAY = 'previousOneDay';
	const PREVIOUSONEHALF = 'previousOneHalf';
	const PREVIOUSONEMONTH = 'previousOneMonth';
	const PREVIOUSONEQUARTER = 'previousOneQuarter';
	const PREVIOUSONEWEEK = 'previousOneWeek';
	const PREVIOUSONEYEAR = 'previousOneYear';
	const PREVIOUSROLLINGHALF = 'previousRollingHalf';
	const PREVIOUSROLLINGQUARTER = 'previousRollingQuarter';
	const PREVIOUSROLLINGYEAR = 'previousRollingYear';
	const SAMEDAYFISCALQUARTERBEFORELAST = 'sameDayFiscalQuarterBeforeLast';
	const SAMEDAYFISCALYEARBEFORELAST = 'sameDayFiscalYearBeforeLast';
	const SAMEDAYLASTFISCALQUARTER = 'sameDayLastFiscalQuarter';
	const SAMEDAYLASTFISCALYEAR = 'sameDayLastFiscalYear';
	const SAMEDAYLASTMONTH = 'sameDayLastMonth';
	const SAMEDAYLASTWEEK = 'sameDayLastWeek';
	const SAMEDAYMONTHBEFORELAST = 'sameDayMonthBeforeLast';
	const SAMEDAYWEEKBEFORELAST = 'sameDayWeekBeforeLast';
	const SAMEFISCALHALFLASTFISCALYEAR = 'sameFiscalHalfLastFiscalYear';
	const SAMEFISCALHALFLASTFISCALYEARTODATE = 'sameFiscalHalfLastFiscalYearToDate';
	const SAMEFISCALQUARTERFISCALYEARBEFORELAST = 'sameFiscalQuarterFiscalYearBeforeLast';
	const SAMEFISCALQUARTERLASTFISCALYEAR = 'sameFiscalQuarterLastFiscalYear';
	const SAMEFISCALQUARTERLASTFISCALYEARTODATE = 'sameFiscalQuarterLastFiscalYearToDate';
	const SAMEMONTHFISCALQUARTERBEFORELAST = 'sameMonthFiscalQuarterBeforeLast';
	const SAMEMONTHFISCALYEARBEFORELAST = 'sameMonthFiscalYearBeforeLast';
	const SAMEMONTHLASTFISCALQUARTER = 'sameMonthLastFiscalQuarter';
	const TODAY = 'today';
	const TOMORROW = 'tomorrow';
	const TWODAYSAGO = 'twoDaysAgo';
	const TWODAYSFROMNOW = 'twoDaysFromNow';
	const WEEKAFTERNEXT = 'weekAfterNext';
	const WEEKAFTERNEXTTODATE = 'weekAfterNextToDate';
	const WEEKBEFORELAST = 'weekBeforeLast';
	const WEEKBEFORELASTTODATE = 'weekBeforeLastToDate';
	const YESTERDAY = 'yesterday';
}
