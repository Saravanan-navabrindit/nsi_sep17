<?php
/**
 * Contains definition for \Crown\Form\Input\Color class.
 */

namespace Crown\Form\Input;


/**
 * Form color input element class.
 *
 * @since 2.3.0
 */
class Color extends Text {

	/**
	 * Input element colorpicker options.
	 *
	 * @since 2.3.0
	 *
	 * @var array
	 */
	protected $colorpickerOptions;


	/**
	 * Default color input configuration options.
	 *
	 * @since 2.3.0
	 *
	 * @var array
	 */
	protected static $defaultColorInputArgs = array(
		'colorpickerOptions' => array()
	);


	/**
	 * Color input object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.3.0
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
	 *    * __colorpickerOptions__ - (array) Input element colorpicker options.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$colorInputArgs = array_merge($this::$defaultColorInputArgs, array_intersect_key($args, $this::$defaultColorInputArgs));

		// parse args into object variables
		$this->setColorpickerOptions($colorInputArgs['colorpickerOptions']);

	}


	/**
	 * Get input element colorpicker options.
	 *
	 * @since 2.3.0
	 *
	 * @return array Input element colorpicker options.
	 */
	public function getColorpickerOptions() {
		return $this->colorpickerOptions;
	}


	/**
	 * Set input element colorpicker options.
	 *
	 * @since 2.3.0
	 *
	 * @param array $colorpickerOptions Input element colorpicker options.
	 */
	public function setColorpickerOptions($colorpickerOptions) {
		if(is_array($colorpickerOptions)) $this->colorpickerOptions = $colorpickerOptions;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'color'.
	 *
	 * @since 2.3.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'color';
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.3.0
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

		// enqueue styles and scripts
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_script('crown-form-input-color');

		return parent::getOutput($args);

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.3.0
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

		// add color input variables
		$atts = array_merge($atts, array(
			'type' => 'text',
			'data-colorpicker-options' => json_encode($this->colorpickerOptions, JSON_FORCE_OBJECT)
		));

		return $atts;

	}


	/**
	 * Parse class argument into array.
	 *
	 * @since 2.3.0
	 *
	 * @used-by \Crown\Form\Input\Input::setClass() during input element class configuration.
	 *
	 * @param string|string[] $class Element class.
	 *
	 * @return string[] List of element classes.
	 */
	protected function parseClasses($class) {
		$classArray = parent::parseClasses($class);

		if(!in_array('crown-colorpicker-input', $classArray)) {
			$classArray = array_merge(array(
				'crown-colorpicker-input',
			), $classArray);
		}

		return $classArray;

	}

}