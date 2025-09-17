<?php
/**
 * Contains definition for \Crown\Api\Facebook class
 */

namespace Crown\Api;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;


/**
 * Facebook API class.
 *
 * Serves as an interface to Facebook's social graph API calls.
 *
 * @since 2.1.0
 */
class Facebook {

	/**
	 * Your app ID.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $appId = '';

	/**
	 * Your app secret.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $appSecret = '';

	/**
	 * Your access token.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $accessToken = '';

	/**
	 * Facebook API session.
	 *
	 * @since 2.1.0
	 *
	 * @var \Facebook\FacebookSession
	 */
	protected static $session = null;

	/**
	 * Default Twitter API configuration options.
	 *
	 * @since 2.1.0
	 *
	 * @var array
	 */
	protected static $defaultFacebookArgs = array(
		'appId' => '',
		'appSecret' => '',
		'accessToken' => ''
	);


	/**
	 * Initialize the Facebook API.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.1.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __appId__ - (string) Your app ID.
	 *    * __appSecret__ - (string) Your app secret.
	 *    * __accessToken__ - (string) Your access token.
	 */
	public static function init($args = array()) {

		$facebookArgs = array_merge(self::$defaultFacebookArgs, array_intersect_key($args, self::$defaultFacebookArgs));

		// parse args into object variables
		self::setAppId($facebookArgs['appId']);
		self::setAppSecret($facebookArgs['appSecret']);
		self::setAccessToken($facebookArgs['accessToken']);

	}


	/**
	 * Get app ID.
	 *
	 * @since 2.1.0
	 *
	 * @return string App ID.
	 */
	public static function getAppId() {
		return self::$appId;
	}


	/**
	 * Get app secret.
	 *
	 * @since 2.1.0
	 *
	 * @return string App secret.
	 */
	public static function getAppSecret() {
		return self::$appSecret;
	}


	/**
	 * Get access token.
	 *
	 * @since 2.1.0
	 *
	 * @return string Access token.
	 */
	public static function getAccessToken() {
		return self::$accessToken;
	}


	/**
	 * Set app ID.
	 *
	 * @since 2.1.0
	 *
	 * @param string $appId App ID.
	 */
	public static function setAppId($appId) {
		self::$appId = $appId;
	}


	/**
	 * Set app secret.
	 *
	 * @since 2.1.0
	 *
	 * @param string $appSecret App secret.
	 */
	public static function setAppSecret($appSecret) {
		self::$appSecret = $appSecret;
	}


	/**
	 * Set access token.
	 *
	 * @since 2.1.0
	 *
	 * @param string $accessToken Access token.
	 */
	public static function setAccessToken($accessToken) {
		self::$accessToken = $accessToken;
	}


	/**
	 * Check if the Facebook API connection settings have been initialized.
	 *
	 * If all settings have been configured, the app session is instantiated.
	 *
	 * @since 2.1.0
	 *
	 * @return boolean Whether API connection settings has been initialized.
	 */
	public static function isInitialized() {

		if(!empty(self::$session)) return true;

		if(empty(self::$appId)) return false;
		if(empty(self::$appSecret)) return false;
		// if(empty(self::$accessToken)) return false;

		FacebookSession::setDefaultApplication(self::$appId, self::$appSecret);
		self::$session = FacebookSession::newAppSession();

		return true;

	}


	/**
	 * Make a request to the Facebook API.
	 *
	 * @since 2.1.0
	 *
	 * @param string $endpoint The API endpoint resource. For example: `'/{page-id}/feed'`.
	 * @param string $requestMethod Request method. Defualt value is `GET`.
	 * @param array $args Associative array of request parameters.
	 * @param integer $rateLimit Requests per rate limit window (out of 15 minutes).
	 *
	 * @return mixed API response, null if API connection settings have not been initialized.
	 */
	protected static function request($endpoint, $requestMethod = 'GET', $args = array(), $rateLimit = -1) {

		$cacheKey = 'facebook_api_cache_'.md5($endpoint.'?'.http_build_query($args));
		$response = null;

		// attempt to retrieve from cache if still fresh
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

		// check if initialized first
		if(!self::isInitialized()) return $response;

		// make API request
		$request = new FacebookRequest(self::$session, $requestMethod, $endpoint, $args);
		$response = $request->execute()->getGraphObject()->asArray();

		// update cache
		update_option($cacheKey, array(
			'timestamp' => time(),
			'response' => $response
		));

		return $response;

	}


	/**
	 * Parse a post returned by the API.
	 *
	 * Concatenates the message/story with link, if applicable.
	 *
	 * @since 2.1.0
	 *
	 * @param object $post Post object returned by API.
	 * @param array $templates Templates used by parser.
	 *
	 * @return string Concatenated post content.
	 */
	public static function parsePost($post, $templates = array()) {

		$templates = array_merge(array(
			'urlLink' => '<a href="%s" rel="nofollow" target="_blank" title="%s">%s</a>'
		), $templates);

		$text = $post->message;
		if(empty($text)) $text = $post->story;

		if($post->type == 'link') {
			$text .= ' '.sprintf($templates['urlLink'], $post->link, $post->name, self::truncateUrl($post->link));
		} else if($post->type == 'photo') {
			$text .= ' '.sprintf($templates['urlLink'], $post->link, '', self::truncateUrl($post->link));
		}

		return $text;

	}


	/**
	 * Truncate a long URL to a given length, if necessary.
	 *
	 * @since 2.1.0
	 *
	 * @param string $url URL to truncate.
	 * @param int $length Desired length.
	 *
	 * @return string Truncated URL.
	 */
	protected static function truncateUrl($url, $length = 40) {
		$truncatedUrl = substr($url, 0, $length);
		if(strlen($truncatedUrl < $url)) {
			$truncatedUrl .= '...';
		}
		return $truncatedUrl;
	}


	/**
	 * Retrieve a page's posts.
	 *
	 * @since 2.1.0
	 *
	 * @param int $pageId The page's ID.
	 * @param array $args Associative array of request parameters.
	 * @param integer $rateLimit Requests per rate limit window (out of 15 minutes).
	 *
	 * @return array The queried posts.
	 */
	public static function getPagePosts($pageId, $args = array(), $rateLimit = 180) {
		return self::request('/'.$pageId.'/posts', 'GET', $args, $rateLimit);
	}


}