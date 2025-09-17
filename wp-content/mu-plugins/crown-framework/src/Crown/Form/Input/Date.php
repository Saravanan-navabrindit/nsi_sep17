<?php
/**
 * Contains definition for \Crown\Form\Input\Date class.
 */

namespace Crown\Form\Input;


/**
 * Form date input element class.
 *
 * @since 2.0.0
 */
class Date extends Text {

	/**
	 * Input element datepicker options.
	 *
	 * @since 2.2.1
	 *
	 * @var array
	 */
	protected $datepickerOptions;


	/**
	 * Default date input configuration options.
	 *
	 * @since 2.2.1
	 *
	 * @var array
	 */
	protected static $defaultDateInputArgs = array(
		'datepickerOptions' => array()
	);


	/**
	 * Date input object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.2.1
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __type__ - (string) Input element type.
	 *    * __name__ - (string) Input element name.
	 *    * __label__ - (string) Input label.
	 *    * __defaultValue__ - (string) Default input value.
	 *    * __id__ - (string) Input element ID.
	 *    * __class__ - (string|string[]) Input element class.
	 *    * __required__ - (boolean) Input element required flag.
	 *    * __atts__ - (array) Additional input element attributes.
	 *    * __placeholder__ - (string) Input element placeholder value.
	 *    * __datepickerOptions__ - (array) Input element datepicker options.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$dateInputArgs = array_merge($this::$defaultDateInputArgs, array_intersect_key($args, $this::$defaultDateInputArgs));

		// parse args into object variables
		$this->setDatepickerOptions($dateInputArgs['datepickerOptions']);

	}


	/**
	 * Get input element datepicker options.
	 *
	 * @since 2.2.1
	 *
	 * @return array Input element datepicker options.
	 */
	public function getDatepickerOptions() {
		return $this->datepickerOptions;
	}


	/**
	 * Set input element datepicker options.
	 *
	 * @since 2.2.1
	 *
	 * @param array $datepickerOptions Input element datepicker options.
	 */
	public function setDatepickerOptions($datepickerOptions) {
		if(is_array($datepickerOptions)) $this->datepickerOptions = $datepickerOptions;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'date'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'date';
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.2.1
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Media::getOutputAttributes() to build input element's attribute array.
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

		// enqueue scripts
		wp_enqueue_script('crown-form-input-date');

		return parent::getOutput($args);

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.2.1
	 *
	 * @used-by \Crown\Form\Input\Input::getOutput() during input element HTML generation.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return array Associative array of input element attribute key-value pairs.
	 */
	protected function getOutputAttributes($args = array()) {
		$atts = parent::getOutputAttributes($args);

		/*// prepare datepicker options
		$datepickerOptions = $this->datepickerOptions;

		// extract callback functions
		$valueArr = array();
		$replaceKeys = array();
		foreach($datepickerOptions as $key => &$value){
			if(strpos($value, 'function(') === 0) {
				$valueArr[] = $value;    
				$value = '%'.$key.'%';    
				$replaceKeys[] = '"'.$value.'"';
			}
		}

		// encode options
		$datepickerOptions = json_encode($datepickerOptions, JSON_FORCE_OBJECT);
		$datepickerOptions = str_replace($replaceKeys, $valueArr, $datepickerOptions);*/

		// add date input variables
		$atts = array_merge($atts, array(
			'type' => 'text',
			'data-datepicker-options' => json_encode($this->datepickerOptions, JSON_FORCE_OBJECT)
		));

		return $atts;

	}


	/**
	 * Parse class argument into array.
	 *
	 * @since 2.2.1
	 *
	 * @used-by \Crown\Form\Input\Input::setClass() during input element class configuration.
	 *
	 * @param string|string[] $class Element class.
	 *
	 * @return string[] List of element classes.
	 */
	protected function parseClasses($class) {
		$classArray = parent::parseClasses($class);

		if(!in_array('crown-datepicker-input', $classArray)) {
			$classArray = array_merge(array(
				'crown-datepicker-input',
			), $classArray);
		}

		return $classArray;

	}


	/**
	 * Retrieve metadata value.
	 *
	 * Date is formatted to `'n/j/Y'` before being returned.
	 *
	 * @since 2.3.1
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param boolean $single Optional. Whether to return a single value. By default, returns all values for key.
	 *
	 * @return mixed Will be an array if $single is false. Will be value of metadata field if $single is true.
	 */
	public function getMetaValue($type = 'site', $objectId = null, $single = true) {

		// retrieve value from database
		$value = parent::getMetaValue($type, $objectId, $single);

		// format date value
		if(!empty($value)) {
			$timestamp = strtotime($value);
			$value = date('n/j/Y', $timestamp);
		}

		return $value;

	}


	/**
	 * Add metadata value.
	 *
	 * Date is formatted to `'Y-m-d'` before being stored.
	 *
	 * @since 2.3.1
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, adds site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param boolean $unique Optional. Whether the same key should not be added. By default, adds for existing key.
	 *
	 * @return int|bool Metadata ID on success, false on failure.
	 */
	public function addMetaValue($value = '', $type = 'site', $objectId = null, $unique = false) {

		// format date value
		$timestamp = strtotime($value);
		$value = date('Y-m-d', $timestamp);

		// add object meta value
		return parent::getMetaValue($value, $type, $objectId, $unique);

	}


	/**
	 * Update metadata value.
	 *
	 * Date is formatted to `'Y-m-d'` before being stored.
	 *
	 * @since 2.3.1
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param string $previousValue Optional. Previous value to replace. By default, replaces all entries for meta key.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function updateMetaValue($value = '', $type = 'site', $objectId = null, $previousValue = '') {

		// format date value
		if(!empty($value)) {
			$timestamp = strtotime($value);
			$value = date('Y-m-d', $timestamp);
		}

		// update object meta value
		return parent::updateMetaValue($value, $type, $objectId, $previousValue);

	}

}