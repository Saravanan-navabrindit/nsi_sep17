<?php
/**
 * Contains definition for \Crown\Form\Input\Select class.
 */

namespace Crown\Form\Input;


/**
 * Form select input element class.
 *
 * @since 2.0.0
 */
class Select extends Input {

	/**
	 * Select element options.
	 *
	 * Options should be stored as either an array of strings or an array of associative arrays
	 * with the following possible values:
	 * * __value__ - (string) Option value.
	 * * __label__ - (string) Option/optgroup label.
	 * * __depth__ - (int) Visual label indentation.
	 * * __options__ - (array) Collection of options belonging to an optgroup.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Select element multiple flag.
	 *
	 * @since 2.13.2
	 *
	 * @var boolean
	 */
	protected $multiple;

	/**
	 * Select2 config options.
	 *
	 * @since 2.13.0
	 *
	 * @var array|boolean
	 */
	protected $select2;

	/**
	 * Default select input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultSelectArgs = array(
		'options' => array(),
		'multiple' => false,
		'select2' => false
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
	 *    * __options__ - (array) Select element options.
	 *    * __multiple__ - (boolean) Select element multiple flag.
	 *    * __select2__ - (array|boolean) Select2 config options.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$selectArgs = array_merge($this::$defaultSelectArgs, array_intersect_key($args, $this::$defaultSelectArgs));

		// parse args into object variables
		$this->setOptions($selectArgs['options']);
		$this->setMultiple($selectArgs['multiple']);
		$this->setSelect2($selectArgs['select2']);

	}


	/**
	 * Get select element options.
	 *
	 * @since 2.0.0
	 *
	 * @return array Select element options.
	 */
	public function getOptions() {
		return $this->options;
	}


	/**
	 * Get select element multiple flag.
	 *
	 * @since 2.13.2
	 *
	 * @return boolean Select element multiple flag.
	 */
	public function getMultiple() {
		return $this->multiple;
	}


	/**
	 * Get select2 config options.
	 *
	 * @since 2.13.0
	 *
	 * @return array|boolean Configuration options for select2 element.
	 */
	public function getSelect2() {
		return $this->select2;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'select'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'select';
	}


	/**
	 * Set select element options.
	 *
	 * @since 2.0.0
	 *
	 * @param array $options Select element options.
	 */
	public function setOptions($options) {
		if(is_array($options)) $this->options = $options;
	}


	/**
	 * Set select element multiple flag.
	 *
	 * @since 2.13.2
	 *
	 * @param boolean $multiple Select element multiple flag.
	 */
	public function setMultiple($multiple) {
		$this->multiple = (bool)$multiple;
	}


	/**
	 * Set select2 config options.
	 *
	 * @since 2.13.0
	 *
	 * @param array|boolean $select2 Configuration options for select2 element.
	 */
	public function setSelect2($select2) {
		$this->select2 = $select2;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Select::getOutputAttributes() to build input element's attribute array.
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
		if($this->select2) {
			wp_enqueue_script('crown-form-input-select');
			wp_enqueue_style('select2');
		}

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label',
			'for' => $this->id
		));

		$output .= '<select '.implode(' ', $atts).'>'.$this->getOutputOptions($this->options, $args['value']).'</select>';
		if(!empty($this->label)) $output .= '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';

		return $output;

	}


	/**
	 * Generate select element options output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @param array $options Options to convert to HTML.
	 * @param string $selectedValue Optional. Value to match to options to determine if selected.
	 *
	 * @return string Select element options output HTML.
	 */
	protected function getOutputOptions($options = array(), $selectedValue = null) {

		if($this->multiple && !is_array($selectedValue)) {
			$selectedValue = array($selectedValue);
		} else if(!$this->multiple && is_array($selectedValue)) {
			$selectedValue = !empty($selectedValue) ? $selectedValue[0] : $this->defaultValue;
		}

		if($this->multiple && is_array($this->select2) && array_key_exists('sortable', $this->select2) && $this->select2['sortable']) {
			$valueIndeces = array();
			foreach($options as $i => $option) {
				$value = is_array($option) ? (array_key_exists('value', $option) ? $option['value'] : '') : $option;
				if(!array_key_exists($value, $valueIndeces)) $valueIndeces[$value] = $i;
			}
			$selectedOptions = array();
			$optionIndecesToRemove = array();
			foreach($selectedValue as $v) {
				if(array_key_exists($v, $valueIndeces) && !in_array($valueIndeces[$v], $optionIndecesToRemove)) {
					$selectedOptions[] = $options[$valueIndeces[$v]];
					$optionIndecesToRemove[] = $valueIndeces[$v];
				}
			}
			rsort($optionIndecesToRemove);
			foreach($optionIndecesToRemove as $i) {
				unset($options[$i]);
			}
			$options = array_merge($selectedOptions, $options);
		}

		$output = array();
		foreach($options as $option) {
			$value = $option;
			$label = $option;
			$depth = 0;
			$groupOptions = array();

			// check if option in array format
			if(is_array($option)) {
				$value = array_key_exists('value', $option) ? $option['value'] : '';
				$label = array_key_exists('label', $option) ? $option['label'] : $value;
				$depth = array_key_exists('depth', $option) ? intval($option['depth']) : $depth;
				$groupOptions = array_key_exists('options', $option) ? $option['options'] : $groupOptions;
			}

			// check if should be output as optgroup or option
			if(!empty($groupOptions)) {

				$optgroupAtts = array(
					'label' => $label
				);

				$output[] = '<optgroup '.implode(' ', $this->convertHtmlAttributes($optgroupAtts)).'>'.$this->getOutputOptions($groupOptions, $selectedValue).'</optgroup>';

			} else {

				$optionAtts = array(
					'selected' => $this->multiple ? in_array($value, $selectedValue) : $selectedValue == $value
				);

				// setup option indentation
				$indentation = str_repeat('&nbsp;', $depth * 3);

				$output[] = '<option value="'.esc_attr($value).'" '.implode(' ', $this->convertHtmlAttributes($optionAtts)).'>'.$indentation.esc_html($label).'</option>';

			}
			
		}

		return implode('', $output);
	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Select::getOutput() during input element HTML generation.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return array Associative array of input element attribute key-value pairs.
	 */
	protected function getOutputAttributes($args = array()) {
		
		$atts = array_merge(array(
			'multiple' => $this->multiple
		), parent::getOutputAttributes($args));

		// remove uneeded attributes
		unset($atts['type']);
		unset($atts['value']);

		if($this->multiple) {
			if(array_key_exists('name', $atts)) $atts['name'] .= '[]';
			if(array_key_exists('data-tpl-name', $atts)) $atts['data-tpl-name'] .= '[]';
		}

		if($this->select2) {
			$atts = array_merge($atts, array(
				'data-select2-options' => json_encode(is_array($this->select2) ? $this->select2 : array(), JSON_FORCE_OBJECT)
			));
		}

		return $atts;

	}


	/**
	 * Update metadata value.
	 *
	 * The metadata key corresponds to input object's name.
	 *
	 * @since 2.13.2
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param string $previousValue Optional. Previous value to replace. By default, replaces all entries for meta key.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function updateMetaValue($value = array(), $type = 'site', $objectId = null, $previousValue = '') {

		if(!$this->multiple) {
			return parent::updateMetaValue($value, $type, $objectId, $previousValue);
		}

		if(!is_array($value)) $value = array();

		// peform default function
		$result = parent::updateMetaValue($value, $type, $objectId, $previousValue);

		// save individual items for certain object types
		if(!empty($this->name) && in_array($type, array('post', 'user', 'term'))) {
			delete_metadata($type, $objectId, '__'.$this->name);
			foreach($value as $v) {
				add_metadata($type, $objectId, '__'.$this->name, $v);
			}
		}

		return $result;

	}

}