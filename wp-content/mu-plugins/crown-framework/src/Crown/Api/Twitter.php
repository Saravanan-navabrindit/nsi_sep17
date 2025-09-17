<?php
/**
 * Contains definition for \Crown\Api\Twitter class
 */

namespace Crown\Api;


/**
 * Twitter API class.
 *
 * Serves as an interface to J7mbo's PHP wrapper for Twitter API v1.1 calls.
 *
 * @since 2.1.0
 */
class Twitter {

	/**
	 * Your Oauth access token.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $oauthAccessToken = '';

	/**
	 * Your Oauth access token screen.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $oauthAccessTokenSecret = '';

	/**
	 * Your consumer key.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $consumerKey = '';

	/**
	 * Your consumer secret.
	 *
	 * @since 2.1.0
	 *
	 * @var string
	 */
	protected static $consumerSecret = '';

	/**
	 * Twitter API exchange service.
	 *
	 * @since 2.1.0
	 *
	 * @var \TwitterAPIExchange
	 */
	protected static $api = null;

	/**
	 * Default Twitter API configuration options.
	 *
	 * @since 2.1.0
	 *
	 * @var array
	 */
	protected static $defaultTwitterArgs = array(
		'oauthAccessToken' => '',
		'oauthAccessTokenSecret' => '',
		'consumerKey' => '',
		'consumerSecret' => ''
	);


	/**
	 * Initialize the Twitter API.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.1.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __oauthAccessToken__ - (string) Your Oauth access token.
	 *    * __oauthAccessTokenSecret__ - (string) Your Oauth access token screen.
	 *    * __consumerKey__ - (string) Your consumer key.
	 *    * __consumerSecret__ - (string) Your consumer secret.
	 */
	public static function init($args = array()) {

		$twitterArgs = array_merge(self::$defaultTwitterArgs, array_intersect_key($args, self::$defaultTwitterArgs));

		// parse args into object variables
		self::setOauthAccessToken($twitterArgs['oauthAccessToken']);
		self::setOauthAccessTokenSecret($twitterArgs['oauthAccessTokenSecret']);
		self::setConsumerKey($twitterArgs['consumerKey']);
		self::setConsumerSecret($twitterArgs['consumerSecret']);

	}


	/**
	 * Get Oauth access token.
	 *
	 * @since 2.1.0
	 *
	 * @return string Oauth access token.
	 */
	public static function getOauthAccessToken() {
		return self::$oauthAccessToken;
	}


	/**
	 * Get Oauth access token secret.
	 *
	 * @since 2.1.0
	 *
	 * @return string Oauth access token secret.
	 */
	public static function getOauthAccessTokenSecret() {
		return self::$oauthAccessTokenSecret;
	}


	/**
	 * Get consumer key.
	 *
	 * @since 2.1.0
	 *
	 * @return string Consumer key.
	 */
	public static function getConsumerKey() {
		return self::$consumerKey;
	}


	/**
	 * Get consumer secret.
	 *
	 * @since 2.1.0
	 *
	 * @return string Consumer secret.
	 */
	public static function getConsumerSecret() {
		return self::$consumerSecret;
	}


	/**
	 * Set Oauth access token.
	 *
	 * @since 2.1.0
	 *
	 * @param string $oauthAccessToken Oauth access token.
	 */
	public static function setOauthAccessToken($oauthAccessToken) {
		self::$oauthAccessToken = $oauthAccessToken;
	}


	/**
	 * Set Oauth access token secret.
	 *
	 * @since 2.1.0
	 *
	 * @param string $oauthAccessTokenSecret Oauth access token secret.
	 */
	public static function setOauthAccessTokenSecret($oauthAccessTokenSecret) {
		self::$oauthAccessTokenSecret = $oauthAccessTokenSecret;
	}


	/**
	 * Set consumer key.
	 *
	 * @since 2.1.0
	 *
	 * @param string $consumerKey Consumer key.
	 */
	public static function setConsumerKey($consumerKey) {
		self::$consumerKey = $consumerKey;
	}


	/**
	 * Set consumer secret.
	 *
	 * @since 2.1.0
	 *
	 * @param string $consumerSecret Consumer secret.
	 */
	public static function setConsumerSecret($consumerSecret) {
		self::$consumerSecret = $consumerSecret;
	}


	/**
	 * Check if the Twitter API connection settings have been initialized.
	 *
	 * If all settings have been configured, the exchange services is instantiated.
	 *
	 * @since 2.1.0
	 *
	 * @return boolean Whether API connection settings has been initialized.
	 */
	public static function isInitialized() {

		if(!empty(self::$api)) return true;

		// if(empty(self::$oauthAccessToken)) return false;
		// if(empty(self::$oauthAccessTokenSecret)) return false;
		if(empty(self::$consumerKey)) return false;
		if(empty(self::$consumerSecret)) return false;

		self::$api = new \TwitterAPIExchange(array(
			'oauth_access_token' => self::$oauthAccessToken,
			'oauth_access_token_secret' => self::$oauthAccessTokenSecret,
			'consumer_key' => self::$consumerKey,
			'consumer_secret' => self::$consumerSecret
		));

		return true;

	}


	/**
	 * Make a request to the Twitter API.
	 *
	 * @since 2.1.0
	 *
	 * @param string $endpoint The API endpoint resource. For example: `'statuses/user_timeline'`.
	 * @param string $requestMethod Request method. Defualt value is `GET`.
	 * @param array $args Associative array of request parameters.
	 * @param integer $rateLimit Requests per rate limit window (out of 15 minutes).
	 *
	 * @return mixed API response, null if API connection settings have not been initialized.
	 */
	protected static function request($endpoint, $requestMethod = 'GET', $args = array(), $rateLimit = -1) {

		$url = 'https://api.twitter.com/1.1/'.$endpoint.'.json';
		$cacheKey = 'twitter_api_cache_'.md5($url.'?'.http_build_query($args));
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
		if($requestMethod == 'POST') {
			$response = self::$api->buildOauth($url, $requestMethod)->setPostfields($args)->performRequest();
		} else {
			$response = self::$api->setGetfield('?'.http_build_query($args))->buildOauth($url, $requestMethod)->performRequest();
		}
		$response = json_decode($response);

		// update cache
		update_option($cacheKey, array(
			'timestamp' => time(),
			'response' => $response
		));

		return $response;

	}


	/**
	 * Parse a tweet returned by the API.
	 *
	 * Replaces tweet entities with relevant links.
	 *
	 * @since 2.1.0
	 *
	 * @param object $tweet Tweet object returned by API.
	 * @param array $templates Templates used by parser.
	 *
	 * @return string Concatenated tweet content.
	 */
	public static function parseTweet($tweet, $templates = array()) {

		$templates = array_merge(array(
			'hashtagLink' => '<a href="http://twitter.com/search?q=%%23%s&src=hash" rel="nofollow" target="_blank">#%s</a>',
			'urlLink' => '<a href="%s" rel="nofollow" target="_blank" title="%s">%s</a>',
			'userMentionLink' => '<a href="http://twitter.com/%s" rel="nofollow" target="_blank" title="%s">@%s</a>',
			'mediaLink' => '<a href="%s" rel="nofollow" target="_blank" title="%s">%s</a>'
		), $templates);

		if(property_exists($tweet, 'retweeted_status')) {
			$text = self::parseTweet($tweet->retweeted_status);
			$text = 'RT '.sprintf($templates['userMentionLink'], strtolower($tweet->retweeted_status->user->screen_name), $tweet->retweeted_status->user->name, $tweet->retweeted_status->user->screen_name).': '.$text;
			return $text;
		}

		$text = property_exists($tweet, 'full_text') ? $tweet->full_text : $tweet->text;
		$text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
		
		$entityHolder = array();

		foreach($tweet->entities->hashtags as $hashtag) {
			$entity = new \stdclass();
			$entity->start = $hashtag->indices[0];
			$entity->end = $hashtag->indices[1];
			$entity->length = $hashtag->indices[1] - $hashtag->indices[0];
			$entity->replace = sprintf($templates['hashtagLink'], strtolower($hashtag->text), $hashtag->text);
			$entityHolder[$entity->start] = $entity;
		}

		foreach($tweet->entities->urls as $url) {
			$entity = new \stdclass();
			$entity->start = $url->indices[0];
			$entity->end = $url->indices[1];
			$entity->length = $url->indices[1] - $url->indices[0];
			$entity->replace = sprintf($templates['urlLink'], $url->url, $url->expanded_url, $url->display_url);
			$entityHolder[$entity->start] = $entity;
		}

		foreach($tweet->entities->user_mentions as $user_mention) {
			$entity = new \stdclass();
			$entity->start = $user_mention->indices[0];
			$entity->end = $user_mention->indices[1];
			$entity->length = $user_mention->indices[1] - $user_mention->indices[0];
			$entity->replace = sprintf($templates['userMentionLink'], strtolower($user_mention->screen_name), $user_mention->name, $user_mention->screen_name);
			$entityHolder[$entity->start] = $entity;
		}

		if(property_exists($tweet->entities, 'media')) {
			foreach($tweet->entities->media as $media) {
				$entity = new \stdclass();
				$entity->start = $media->indices[0];
				$entity->end = $media->indices[1];
				$entity->length = $media->indices[1] - $media->indices[0];
				$entity->replace = sprintf($templates['mediaLink'], $media->url, $media->expanded_url, $media->display_url);
				$entityHolder[$entity->start] = $entity;
			}
		}

		krsort($entityHolder);
		foreach($entityHolder as $entity) {
			$text = substr_replace($text, $entity->replace, $entity->start, $entity->length);
		}

		return $text;

	}


	/**
	 * Retrieve a user's timeline of tweets.
	 *
	 * @since 2.1.0
	 *
	 * @param array $args Associative array of request parameters.
	 * @param integer $rateLimit Requests per rate limit window (out of 15 minutes).
	 *
	 * @return array The queried tweets.
	 */
	public static function getUserTimeline($args = array(), $rateLimit = 180) {
		return self::request('statuses/user_timeline', 'GET', $args, $rateLimit);
	}


}