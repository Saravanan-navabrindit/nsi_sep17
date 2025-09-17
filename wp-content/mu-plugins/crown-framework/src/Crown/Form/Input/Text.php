<?php
/**
 * Contains definition for \Crown\Form\Input\Text class.
 */

namespace Crown\Form\Input;


/**
 * Form text input element class.
 *
 * @since 2.0.0
 */
class Text extends Input {

	/**
	 * Input element placeholder value.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $placeholder;

	/**
	 * Default text input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultTextInputArgs = array(
		'placeholder' => ''
	);


	/**
	 * Text input object constructor.
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
	 *    * __placeholder__ - (string) Input element placeholder value.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$textInputArgs = array_merge($this::$defaultTextInputArgs, array_intersect_key($args, $this::$defaultTextInputArgs));

		// parse args into object variables
		$this->setPlaceholder($textInputArgs['placeholder']);

	}


	/**
	 * Get input element placeholder value.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input element placeholder value.
	 */
	public function getPlaceholder() {
		return $this->placeholder;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'text'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'text';
	}


	/**
	 * Set input element placeholder value.
	 *
	 * @since 2.0.0
	 *
	 * @param string $placeholder Input element placeholder value.
	 */
	public function setPlaceholder($placeholder) {
		$this->placeholder = $placeholder;
	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.0
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

		// add text input variables
		$atts = array_merge($atts, array(
			'placeholder' => $this->placeholder
		));

		return $atts;

	}

}