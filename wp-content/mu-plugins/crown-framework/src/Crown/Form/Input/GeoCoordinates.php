<?php
/**
 * Contains definition for \Crown\Form\Input\GeoCoordinates class.
 */

namespace Crown\Form\Input;

use Crown\Api\GoogleMaps;


/**
 * Form geographical coordinates input element class.
 *
 * @since 2.0.0
 */
class GeoCoordinates extends Input {

	/**
	 * Default input value.
	 *
	 * The default value must be stored as an associative array with keys for lat and lng coordinate values.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $defaultValue;

	/**
	 * Input element readonly flag.
	 *
	 * @since 2.0.0
	 *
	 * @var boolean
	 */
	protected $readonly;

	/**
	 * Show Google map flag.
	 *
	 * @since 2.0.2
	 *
	 * @var boolean
	 */
	protected $showGoogleMap;

	/**
	 * Allow draggable Google map marker flag.
	 *
	 * @since 2.11.2
	 *
	 * @var boolean
	 */
	protected $draggableMapMarker;

	/**
	 * Default geographical coordinates input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultGeoCoordinatesArgs = array(
		'defaultValue' => array('lat' => '', 'lng' => ''),
		'readonly' => false,
		'showGoogleMap' => false,
		'draggableMapMarker' => false
	);


	/**
	 * Input object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __type__ - (string) Input element type.
	 *    * __name__ - (string) Input element name.
	 *    * __label__ - (string) Input label.
	 *    * __defaultValue__ - (array) Default input value.
	 *    * __id__ - (string) Input element ID.
	 *    * __class__ - (string|string[]) Input element class.
	 *    * __required__ - (boolean) Input element required flag.
	 *    * __atts__ - (array) Additional input element attributes.
	 *    * __readonly__ - (boolean) Input element readonly flag.
	 *    * __showGoogleMap__ - (boolean) Show Google map flag.
	 *    * __draggableMapMarker__ - (boolean) Allow draggable Google map marker flag.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// parse args into object variables
		$geoCoordinatesArgs = array_merge($this::$defaultGeoCoordinatesArgs, array_intersect_key($args, $this::$defaultGeoCoordinatesArgs));

		// parse args into object variables
		$this->setDefaultValue($geoCoordinatesArgs['defaultValue']);
		$this->setReadonly($geoCoordinatesArgs['readonly']);
		$this->setShowGoogleMap($geoCoordinatesArgs['showGoogleMap']);
		$this->setDraggableMapMarker($geoCoordinatesArgs['draggableMapMarker']);

	}


	/**
	 * Get input element readonly flag.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Input element readonly flag.
	 */
	public function getReadonly() {
		return $this->readonly;
	}


	/**
	 * Get Google map flag.
	 *
	 * @since 2.0.2
	 *
	 * @return boolean Whether Google map should be displayed.
	 */
	public function getShowGoogleMap() {
		return $this->showGoogleMap;
	}


	/**
	 * Get draggable Google map marker flag.
	 *
	 * @since 2.11.2
	 *
	 * @return boolean Whether Google map marker should be draggable.
	 */
	public function getDraggableMapMarker() {
		return $this->draggableMapMarker;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'geoCoordinates'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'geoCoordinates';
	}


	/**
	 * Set input element readonly flag.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $readonly Input element readonly flag.
	 */
	public function setReadonly($readonly) {
		$this->readonly = (bool)$readonly;
	}


	/**
	 * Set Google map flag.
	 *
	 * @since 2.0.2
	 *
	 * @param boolean $showGoogleMap Whether Google map should be displayed.
	 */
	public function setShowGoogleMap($showGoogleMap) {
		$this->showGoogleMap = (bool)$showGoogleMap;
	}


	/**
	 * Set draggable Google map marker flag.
	 *
	 * @since 2.11.2
	 *
	 * @param boolean $draggableMapMarker Google map marker should be draggable.
	 */
	public function setDraggableMapMarker($draggableMapMarker) {
		$this->draggableMapMarker = (bool)$draggableMapMarker;
	}


	/**
	 * Asserts if input is read only.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Whether input is read only.
	 */
	public function isReadonly() {
		return $this->readonly;
	}


	/**
	 * Asserts if Google map should be displayed.
	 *
	 * @since 2.0.2
	 *
	 * @return boolean Whether Google map should be displayed.
	 */
	public function showGoogleMap() {
		return $this->showGoogleMap;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\GeoCoordinates::getOutputAttributes() to build input element's attribute array.
	 * @uses \Crown\Form\Input\Input::convertHtmlAttributes() to convert an associative array into HTML element attributes.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return string Output HTML.
	 */
	public function getOutput($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, array('value' => $this->defaultValue), $args);
		if(!is_array($args['value']) || count(array_intersect(array_keys($args['value']), array('lat', 'lng'))) != 2 || empty($args['value']['lat']) || empty($args['value']['lng'])) {
			$args['value'] = $this->defaultValue;
		}
		$output = '';

		// enqueue scripts
		wp_enqueue_script('crown-form-input-geo-coordinates');

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		$inputLat = new Text(array('name' => $this->name.'[lat]', 'label' => 'Latitude', 'class' => 'coordinate-lat', 'atts' => array('readonly' => $this->readonly)));
		$inputLng = new Text(array('name' => $this->name.'[lng]', 'label' => 'Longitude', 'class' => 'coordinate-lng', 'atts' => array('readonly' => $this->readonly)));

		$output .= '<span '.implode(' ', $atts).'>';

		if($this->showGoogleMap && GoogleMaps::isInitialized()) {
			$mapSettings = array(
				'points' => array(),
				'options' => array(
					'center' => array('lat' => 25, 'lng' => 0),
					'zoom' => 1,
					'scrollwheel' => false,
					'streetViewControl' => false
				)
			);
			if(!empty($args['value']['lat']) && !empty($args['value']['lng'])) {
				$mapSettings['points'] = array($args['value']);
				$mapSettings['options']['zoom'] = 10;
			}
			if($this->draggableMapMarker) {
				$mapSettings['allowDraggableMarkers'] = true;
			}
			if($args['isTpl']) $mapSettings['autoInit'] = false;
			$googleMap = GoogleMaps::getMap($mapSettings);
			$output .= '<span class="google-map-wrap"><span class="inner">'.$googleMap.'</span></span>';
		}

		$output .= '<span class="input-wrap">'.$inputLat->getOutput(array_merge($args, array('value' => $args['value']['lat']))).'</span> ';
		$output .= '<span class="input-wrap">'.$inputLng->getOutput(array_merge($args, array('value' => $args['value']['lng']))).'</span>';

		$output .= '</span>';

		return $output;

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\GeoCoordinates::getOutput() during input element HTML generation.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return array Associative array of input element attribute key-value pairs.
	 */
	protected function getOutputAttributes($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, $args);

		$class = array_merge(array(
			'crown-geo-coordinates-input'
		), $this->class);

		$atts = array(
			'id' => $this->id,
			'class' => implode(' ', $class)
		);

		// merge other attributes
		return array_merge($atts, $this->atts);

	}


	/**
	 * Update metadata value.
	 *
	 * The metadata key corresponds to input object's name. Coordinates metadata is stored as an assocative array
	 * with keys for lat and lng coordinate values. Additional metadata is stored for each coordinate with the meta
	 * keys of {$key}_lat and {$key}_lng.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param string $previousValue Optional. Previous value to replace. By default, replaces all entries for meta key.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function updateMetaValue($value = '', $type = 'site', $objectId = null, $previousValue = '') {

		// peform default function
		$result = parent::updateMetaValue($value, $type, $objectId, $previousValue);

		// save additional meta
		if(is_array($value) && count(array_intersect(array_keys($value), array('lat', 'lng'))) == 2) {
			if($type == 'site') {
				update_site_option($this->name.'_lat', $value['lat']);
				update_site_option($this->name.'_lng', $value['lng']);
			} else if($type == 'blog') {
				update_option($this->name.'_lat', $value['lat']);
				update_option($this->name.'_lng', $value['lng']);
			} else {
				update_metadata($type, $objectId, $this->name.'_lat', $value['lat']);
				update_metadata($type, $objectId, $this->name.'_lng', $value['lng']);
			}
		}
		
		return $result;

	}


}