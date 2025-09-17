<?php
/**
 * Contains definition for \Crown\Form\Input\Time class.
 */

namespace Crown\Form\Input;


/**
 * Form time input element class.
 *
 * @since 2.0.0
 */
class Time extends Select {

	/**
	 * Time input minimum time.
	 *
	 * @since 2.2.1
	 *
	 * @var string
	 */
	protected $min;

	/**
	 * Time input maximum time.
	 *
	 * @since 2.2.1
	 *
	 * @var string
	 */
	protected $max;

	/**
	 * Time input option interval (in minutes).
	 *
	 * @since 2.2.1
	 *
	 * @var int
	 */
	protected $interval;

	/**
	 * Default time input configuration options.
	 *
	 * @since 2.2.1
	 *
	 * @var array
	 */
	protected static $defaultTimeArgs = array(
		'min' => '12am',
		'max' => '11:59pm',
		'interval' => 30
	);


	/**
	 * Time input object constructor.
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
	 *    * __options__ - (array) Select element options.
	 *    * __min__ - (string) Time input minimum time.
	 *    * __max__ - (string) Time input maximum time.
	 *    * __interval__ - (int) Time input option interval (in minutes).
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$timeArgs = array_merge($this::$defaultTimeArgs, array_intersect_key($args, $this::$defaultTimeArgs));

		// parse args into object variables
		$this->setMin($timeArgs['min']);
		$this->setMax($timeArgs['max']);
		$this->setInterval($timeArgs['interval']);

	}


	/**
	 * Get time input minimum time.
	 *
	 * @since 2.2.1
	 *
	 * @return string Time input minimum time.
	 */
	public function getMin() {
		return $this->min;
	}


	/**
	 * Get time input maximum time.
	 *
	 * @since 2.2.1
	 *
	 * @return string Time input maximum time.
	 */
	public function getMax() {
		return $this->min;
	}


	/**
	 * Get time input option interval.
	 *
	 * @since 2.2.1
	 *
	 * @return string Time option interval (in minutes).
	 */
	public function getInterval() {
		return $this->interval;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'time'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'time';
	}


	/**
	 * Set time input minimum time.
	 *
	 * @since 2.2.1
	 *
	 * @param string $min Time input minimum time.
	 */
	public function setMin($min) {
		$this->min = $min;
	}


	/**
	 * Set time input maximum time.
	 *
	 * @since 2.2.1
	 *
	 * @param string $max Time input maximum time.
	 */
	public function setMax($max) {
		$this->max = $max;
	}


	/**
	 * Set time input option interval.
	 *
	 * @since 2.2.1
	 *
	 * @param string $interval Time input option interval (in minutes).
	 */
	public function setInterval($interval) {
		$this->interval = intval($interval);
	}


	/**
	 * Generate time input element options output HTML.
	 *
	 * @since 2.2.1
	 *
	 * @param array $options Options to convert to HTML (ignored).
	 * @param string $selectedValue Optional. Value to match to options to determine if selected.
	 *
	 * @return string Select element options output HTML.
	 */
	protected function getOutputOptions($options = array(), $selectedValue = null) {
		$options = array();

		if($this->interval == 0) return '';

		$minTime = strtotime($this->min);
		$maxTime = strtotime($this->max);
		if(!$minTime || !$maxTime) return '';

		for($i = $minTime; $i <= $maxTime; $i += ($this->interval * 60)) {
			$options[] = array('value' => date('H:i:s', $i), 'label' => date('g:ia', $i));
		}

		return parent::getOutputOptions($options, $selectedValue);
	}

}