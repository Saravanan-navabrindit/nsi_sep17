<?php
/**
 * Contains definition for \Crown\Form\Input\Checkbox class.
 */

namespace Crown\Form\Input;


/**
 * Form checkbox input element class.
 *
 * @since 2.0.0
 */
class Checkbox extends Input {

	/**
	 * Input element value.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $value;

	/**
	 * Default checkbox input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultCheckboxInputArgs = array(
		'defaultValue' => 0,
		'value' => 1
	);


	/**
	 * Select input object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.0.0
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
	 *    * __value__ - (string) Input element value.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// parse args into object variables
		$checkboxInputArgs = array_merge($this::$defaultCheckboxInputArgs, array_intersect_key($args, $this::$defaultCheckboxInputArgs));

		// parse args into object variables
		$this->setDefaultValue($checkboxInputArgs['defaultValue']);
		$this->setValue($checkboxInputArgs['value']);

	}


	/**
	 * Get input element value.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input element value.
	 */
	public function getValue() {
		return $this->value;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'checkbox'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'checkbox';
	}


	/**
	 * Set input element value.
	 *
	 * @since 2.0.0
	 *
	 * @param string $value Input element value.
	 */
	public function setValue($value) {
		$this->value = $value;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Checkbox::getOutputAttributes() to build input element's attribute array.
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
		$output = '';

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		$output .= '<div class="checkbox-wrap">';
		$output .= '<label>';
		$output .= '<input '.implode(' ', $atts).'>';
		if(!empty($this->label)) $output .= ' '.$this->label;
		$output .= '</label>';
		$output .= '</div>';

		return $output;

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Checkbox::getOutput() during input element HTML generation.
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

		// set checkbox value
		$atts['value'] = $this->value;

		// if value matches, mark as checked
		if($args['value'] == $this->value) {
			$atts['checked'] = true;
		}

		return $atts;

	}

}