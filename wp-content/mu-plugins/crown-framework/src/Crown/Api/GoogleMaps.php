<?php
/**
 * Contains definition for \Crown\Api\GoogleMaps class
 */

namespace Crown\Api;


/**
 * Google Maps API
 * 
 * Google maps geocoding class
 * 
 * @since  2.0.0
 */

class GoogleMaps {


	/**
	 * Google Maps 3.0 API key.
	 * @var string
	 */
	protected static $apiKey = '';


	/**
	 * URL to google maps api
	 * @var string
	 */
	protected static $apiEndpointBase = 'https://maps.googleapis.com/maps/api';


	/**
	 * Array of default google map arguments
	 * @var array
	 */
	protected static $defaultGoogleMapsArgs = array(
		'apiKey' => ''
	);


	/**
	 * Initialize the Google Maps API
	 * @param  array  $args
	 * @return null
	 */
	public static function init($args = array()) {

		$googleMapsArgs = array_merge(self::$defaultGoogleMapsArgs, array_intersect_key($args, self::$defaultGoogleMapsArgs));

		// parse args into object variables
		self::setApiKey($googleMapsArgs['apiKey']);

		add_action('init', array('Crown\Api\GoogleMaps', 'registerScripts'));

	}


	/**
	 * Get API Key
	 * @return string
	 */
	public static function getApiKey() { return self::$apiKey; }


	/**
	 * Set API Key
	 * @param string $apiKey
	 */
	public static function setApiKey($apiKey) { self::$apiKey = $apiKey; }


	/**
	 * Check if the Google Maps API is initalize.
	 * @return boolean
	 */
	public static function isInitialized() { return !empty(self::$apiKey); }


	/**
	 * Register scripts necessary for maps integration.
	 */
	public static function registerScripts() {
		if(!self::isInitialized()) return;

		wp_register_script('google-maps-api', self::$apiEndpointBase.'/js?key='.self::$apiKey);
		wp_register_script('crown-api-google-maps', CROWN_URL.'/src/Resources/Public/js/ApiGoogleMaps.min.js', array('jquery', 'json2', 'google-maps-api'));
	}


	/**
	 * Retrieve the location data for the provided address.
	 * @param  string $address Address to locate
	 * @return object Object containing geocode data.
	 */
	public static function getGeocodeData($address) {
		if(empty($address)) return null;

		// remove line breaks and html tags
		$address = preg_replace('/\r\n/', ', ', strip_tags($address));
		
		// get geocode data
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, self::$apiEndpointBase.'/geocode/json?address='.urlencode($address).'&sensor=false&key='.self::$apiKey); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$geocodeData = json_decode(curl_exec($ch)); 
		curl_close($ch); 

		// if result found, return data
		if($geocodeData->status == 'OK' && count($geocodeData->results) > 0) {
			return $geocodeData->results[0];
		}

		return null;

	}


	/**
	 * Retrieve the coordinates for the provided address.
	 * @param  string $address Address to locate
	 * @return object Object containing lat and lng coordinates.
	 */
	public static function geocode($address) {
		$coordinates = self::getGeocodeData($address);
		if($coordinates && $coordinates->geometry->location) {
			return $coordinates->geometry->location;
		}
		return null;
	}


	/**
	 * Caluclate the distance between two coordinate points.
	 * Distance is returned in miles.
	 * 
	 * @param  array $coords1 Cooridnate point containing values for the keys lat and lng.
	 * @param  array $coords2 Cooridnate point containing values for the keys lat and lng.
	 * @return float Distance between point in miles.
	 */
	public static function calcDistance($coords1, $coords2) {
		$lat1 = $coords1['lat'];
		$lng1 = $coords1['lng'];
		$lat2 = $coords2['lat'];
		$lng2 = $coords2['lng'];
		return atan2(
			sqrt(
				pow(cos(deg2rad($lat2)) *
					sin(deg2rad($lng1 - $lng2)), 2) + 
				pow(cos(deg2rad($lat1)) * sin(deg2rad($lat2)) - 
					sin(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
					cos(deg2rad($lng1 - $lng2)), 2)), 
			(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + 
				cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
				cos(deg2rad($lng1 - $lng2)))
		) * 3959;
	}


	/**
	 * Get Google map output.
	 *
	 * Example usage:
	 *
	 * ```
	 * echo GoogleMaps::getMap(array(
	 * 	'points' => array(
	 * 		array('lat' => 47.8885479, -122.2062842),
	 * 		array('lat' => 37.422, -122.084058)
	 * 	),
	 * 	'options' => array(
	 * 		'zoom' => 10
	 * 	)
	 * ));
	 *
	 * ```
	 *
	 * @since 2.0.2
	 *
	 * @param array $args Map configuration settings. Possible arguments:
	 *    * __id__ - (string) Map element ID.
	 *    * __class__ - (string) Map element class.
	 *    * __points__ - (array) Set of points, lat/lng key value sets, to add to the map.
	 *    * __options__ - (array) Google map initialization options.
	 *
	 * @return string Google map output HTML.
	 */
	public static function getMap($args) {

		// make sure API key has been set
		if(!self::isInitialized()) return '';

		// merge arguments with defaults
		$args = array_merge(array(
			'id' => 'google-map-'.rand(),
			'class' => '',
			'points' => array(),
			'allowDraggableMarkers' => false,
			'options' => array(),
			'autoInit' => true,
			'autoAddMarkers' => true
		), $args);

		// merge map options with defaults
		$args['options'] = array_merge(array(
			'zoom' => 13,
			'mapTypeId' => 'roadmap'
		), $args['options']);

		// enqueue scripts
		wp_enqueue_script('crown-api-google-maps');

		// configure map settings
		$mapSettings = array(
			'points' => $args['points'],
			'allowDraggableMarkers' => $args['allowDraggableMarkers'],
			'options' => $args['options'],
			'autoInit' => $args['autoInit'],
			'autoAddMarkers' => $args['autoAddMarkers']
		);
		
		$atts = array(
			'id="'.$args['id'].'"',
			'class="google-map '.$args['class'].'"'
		);

		ob_start();
		?>

			<div <?php echo implode(' ', $atts); ?>></div>
			<script type="text/javascript">
				if(typeof window.googleMapSettings === 'undefined') window.googleMapSettings = {};
				window.googleMapSettings['<?php echo $args['id']; ?>'] = <?php echo json_encode($mapSettings); ?>;
			</script>

		<?php
		return ob_get_clean();

	}


}