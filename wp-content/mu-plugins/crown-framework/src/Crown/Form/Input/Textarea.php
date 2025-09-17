<?php
/**
 * Contains definition for \Crown\Form\Input\Textarea class.
 */

namespace Crown\Form\Input;


/**
 * Form textarea input element class.
 *
 * @since 2.0.0
 */
class Textarea extends Input {

	/**
	 * Input element placeholder value.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $placeholder;

	/**
	 * Textarea element rows attribute value.
	 *
	 * @since 2.0.0
	 *
	 * @var int
	 */
	protected $rows;

	/**
	 * Textarea element cols attribute value.
	 *
	 * @since 2.0.0
	 *
	 * @var int
	 */
	protected $cols;

	/**
	 * Textarea mode.
	 *
	 * @since 2.13.2
	 *
	 * @var string
	 */
	protected $mode;

	/**
	 * Default textarea input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultTextareaArgs = array(
		'placeholder' => '',
		'rows' => 6,
		'cols' => '',
		'mode' => ''
	);


	/**
	 * Textarea input object constructor.
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
	 *    * __rows__ - (int) Textarea element rows attribute value.
	 *    * __cols__ - (int) Textarea element cols attribute value.
	 *    * __mode__ - (string) Textarea mode.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$textareaArgs = array_merge($this::$defaultTextareaArgs, array_intersect_key($args, $this::$defaultTextareaArgs));

		// parse args into object variables
		$this->setPlaceholder($textareaArgs['placeholder']);
		$this->setRows($textareaArgs['rows']);
		$this->setCols($textareaArgs['cols']);
		$this->setMode($textareaArgs['mode']);

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
	 * Get textarea element rows attribute value.
	 *
	 * @since 2.0.0
	 *
	 * @return int Textarea element rows attribute value.
	 */
	public function getRows() {
		return $this->rows;
	}


	/**
	 * Get textarea element cols attribute value.
	 *
	 * @since 2.0.0
	 *
	 * @return int Textarea element cols attribute value.
	 */
	public function getCols() {
		return $this->cols;
	}


	/**
	 * Get textarea mode.
	 *
	 * @since 2.13.2
	 *
	 * @return string Textarea mode.
	 */
	public function getMode() {
		return $this->mode;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'textarea'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type == 'textarea';
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
	 * Set textarea element rows attribute value.
	 *
	 * @since 2.0.0
	 *
	 * @param int $rows Textarea element rows attribute value.
	 */
	public function setRows($rows) {
		$this->rows = intval($rows);
	}


	/**
	 * Set textarea element cols attribute value.
	 *
	 * @since 2.0.0
	 *
	 * @param int $cols Textarea element cols attribute value.
	 */
	public function setCols($cols) {
		$this->cols = intval($cols);
	}


	/**
	 * Set textarea mode.
	 *
	 * @since 2.13.2
	 *
	 * @param string $mode Textarea mode.
	 */
	public function setMode($mode) {
		$this->mode = $mode;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Textarea::getOutputAttributes() to build input element's attribute array.
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

		// enqueue scripts
		if(!empty($this->mode)) {
			$availableModes = array('html', 'javascript', 'css');
			if(in_array($this->mode, $availableModes)) {
				wp_enqueue_script('codemirror-mode-'.$this->mode);
				wp_enqueue_script('crown-form-input-textarea');
				wp_enqueue_style('codemirror');
			}
		}

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label',
			'for' => $this->id
		));

		$output .= '<textarea '.implode(' ', $atts).'>'.$args['value'].'</textarea>';
		if(!empty($this->label)) $output .= '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';

		return $output;

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Textarea::getOutput() during input element HTML generation.
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

		// remove uneeded attributes
		unset($atts['type']);
		unset($atts['value']);

		// add textarea variables
		$atts = array_merge($atts, array(
			'placeholder' => $this->placeholder,
			'rows' => $this->rows,
			'cols' => $this->cols
		));

		if(!empty($this->mode)) {
			$atts = array_merge($atts, array(
				'data-textarea-mode' => $this->mode
			));
		}

		return $atts;

	}

}