<?php
/**
 * Contains definition for \Crown\Form\Input\RadioSet class.
 */

namespace Crown\Form\Input;


/**
 * Form radio input set element class.
 *
 * @since 2.5.0
 */
class RadioSet extends Input {

	/**
	 * Radio set element options.
	 *
	 * Options should be stored as either an array of strings or an array of associative arrays
	 * with the following possible values:
	 * * __value__ - (string) Option value.
	 * * __label__ - (string) Option/optgroup label.
	 * * __depth__ - (int) Visual label indentation.
	 * * __options__ - (array) Collection of options belonging to an optgroup.
	 *
	 * @since 2.5.0
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Default radio set configuration options.
	 *
	 * @since 2.5.0
	 *
	 * @var array
	 */
	protected static $defaultRadioSetArgs = array(
		'options' => array()
	);


	/**
	 * Radio set object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.5.0
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
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$radioSetArgs = array_merge($this::$defaultRadioSetArgs, array_intersect_key($args, $this::$defaultRadioSetArgs));

		// parse args into object variables
		$this->setOptions($radioSetArgs['options']);

	}


	/**
	 * Get radio set element options.
	 *
	 * @since 2.5.0
	 *
	 * @return array Radio set element options.
	 */
	public function getOptions() {
		return $this->options;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'radioSet'.
	 *
	 * @since 2.5.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'radioSet';
	}


	/**
	 * Set radio set element options.
	 *
	 * @since 2.5.0
	 *
	 * @param array $options Radio set element options.
	 */
	public function setOptions($options) {
		if(is_array($options)) $this->options = $options;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.5.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\RadioSet::getOutputAttributes() to build input element's attribute array.
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

		// merge options with defaults
		$args = array_merge($this::$defaultOutputArgs, array('value' => $this->defaultValue), $args);

		$output = '';

		// enqueue scripts
		wp_enqueue_script('crown-form-input-checkbox-set');

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label',
			'for' => $this->id
		));

		if(!empty($this->label)) $output .= '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';
		$output .= '<div '.implode(' ', $atts).'><div class="inner">'.$this->getOutputOptions($this->options, $args).'</div></div>';

		return $output;

	}


	/**
	 * Generate radio set element options output HTML.
	 *
	 * @since 2.5.0
	 *
	 * @param array $options Options to convert to HTML.
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return string Radio set input element options output HTML.
	 */
	protected function getOutputOptions($options = array(), $args = array()) {

		$output = array();
		foreach($options as $option) {
			$value = $option;
			$label = $option;
			$depth = 0;

			// check if option in array format
			if(is_array($option)) {
				$value = array_key_exists('value', $option) ? $option['value'] : '';
				$label = array_key_exists('label', $option) ? $option['label'] : $value;
				$depth = array_key_exists('depth', $option) ? intval($option['depth']) : $depth;
			}

			$inputArgs = array(
				'name' => $this->name,
				'value' => $value,
				'label' => '<span class="overflow">'.$label.'</span>'
			);
			$input = new Radio($inputArgs);

			// setup option indentation
			// $indentation = str_repeat('&nbsp;', $depth * 3);

			$output[] = '<div class="input-wrap depth-'.$depth.'">'.$input->getOutput($args).'</div>';

		}

		return implode('', $output);
	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.5.0
	 *
	 * @used-by \Crown\Form\Input\RadioSet::getOutput() during input element HTML generation.
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
			'crown-radio-set-input'
		), $this->class);

		$atts = array(
			'id' => $this->id,
			'class' => implode(' ', $class)
		);

		// merge other attributes
		return array_merge($atts, $this->atts);

	}


}