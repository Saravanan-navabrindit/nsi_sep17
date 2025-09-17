<?php
/**
 * Contains definition for \Crown\Api\Zoho class
 */

namespace Crown\Api;

use Christiaan\ZohoCRMClient\ZohoCRMClient as ZohoCRMClient;


/**
 * Zoho API class.
 *
 * Serves as an interface to Christiaan's PHP wrapper for Zoho CRM API calls.
 *
 * @since 2.2.0
 */
class Zoho {

	/**
	 * Your auth token.
	 *
	 * @since 2.2.0
	 *
	 * @var string
	 */
	protected static $authToken = '';

	/**
	 * Default Zoho API configuration options.
	 *
	 * @since 2.2.0
	 *
	 * @var array
	 */
	protected static $defaultZohoArgs = array(
		'authToken' => ''
	);


	/**
	 * Initialize the Zoho API.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.2.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __authToken__ - (string) Your Oauth access token.
	 */
	public static function init($args = array()) {

		$zohoArgs = array_merge(self::$defaultZohoArgs, array_intersect_key($args, self::$defaultZohoArgs));

		// parse args into object variables
		self::setAuthToken($zohoArgs['authToken']);

	}


	/**
	 * Get auth token.
	 *
	 * @since 2.2.0
	 *
	 * @return string Auth token.
	 */
	public static function getAuthToken() {
		return self::$authToken;
	}


	/**
	 * Set auth token.
	 *
	 * @since 2.2.0
	 *
	 * @param string $authToken Auth token.
	 */
	public static function setAuthToken($authToken) {
		self::$authToken = $authToken;
	}


	/**
	 * Check if the Aoho API connection settings have been initialized.
	 *
	 * @since 2.2.0
	 *
	 * @return boolean Whether API connection settings has been initialized.
	 */
	public static function isInitialized() {

		if(empty(self::$authToken)) return false;

		return true;

	}


	/**
	 * Retrieve cached response for an API request.
	 *
	 * @since 2.2.0
	 *
	 * @param string $module CRM system module.
	 * @param string $method Request method.
	 * @param integer $rateLimit Requests per rate limit window (out of 15 minutes).
	 *
	 * @return mixed API cached response, null if API connection settings have not been initialized or cached data not found.
	 */
	protected static function getCachedData($module, $method, $rateLimit = -1) {
		$cacheKey = 'zoho_api_cache_'.md5($module.':'.$method);
		$response = null;
		if($rateLimit > 0) {

			// determine minimum age of fresh cache
			$limitMinTimeframe = (15 * 60) / $rateLimit;

			// retrieve cached data
			$cachedResult = get_option($cacheKey);

			// if cache for request exists and is still fresh, return response
			if($cachedResult !== false && $cachedResult['timestamp'] >= time() - $limitMinTimeframe) {
				return $cachedResult['response'];
			}

		}
		return $response;
	}


	/**
	 * Update cached response data for an API request.
	 *
	 * @since 2.2.0
	 *
	 * @param string $module CRM system module.
	 * @param string $method Request method.
	 * @param mixed $data Data to cache.
	 */
	protected static function updateCachedData($module, $method, $data) {
		$cacheKey = 'zoho_api_cache_'.md5($module.':'.$method);
		update_option($cacheKey, array(
			'timestamp' => time(),
			'response' => $data
		));
	}


	/**
	 * Retrieve fields associated with leads.
	 *
	 * @return \Christiaan\ZohoCRMClient\Response[] Set of field data.
	 */
	public static function getLeadFields() {
		if(!self::isInitialized()) return false;

		$fields = self::getCachedData('Leads', 'getFields', 15);
		if($fields === null) {
			$client = new ZohoCRMClient('Leads', self::$authToken);
			$fields = $client->getFields()->request();
		}
		self::updateCachedData('Leads', 'getFields', $fields);

		return $fields;
	}


	/**
	 * Insert/update records in CRM.
	 *
	 * @param array $records Collection of records to add.
	 *
	 * @return Christiaan\ZohoCRMClient\Response\MutationResult API response.
	 */
	public static function addRecords($records = array()) {
		if(!self::isInitialized()) return false;
		if(empty($records)) return false;

		$client = new ZohoCRMClient('Leads', self::$authToken);
		$response = $client->insertRecords()->onDuplicateUpdate()->setRecords($records)->request();

		return $response;
	}


}