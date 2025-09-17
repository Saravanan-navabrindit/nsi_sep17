<?php
/**
 * Contains definition for \Crown\Form\Input\CheckboxSet class.
 */

namespace Crown\Form\Input;


/**
 * Form checkbox input set element class.
 *
 * @since 2.5.0
 */
class CheckboxSet extends RadioSet {

	/**
	 * Default input value.
	 *
	 * The default value must be stored as an array with all set values.
	 *
	 * @since 2.5.0
	 *
	 * @var array
	 */
	protected $defaultValue;

	/**
	 * Input set sortable flag.
	 *
	 * @since 2.5.0
	 *
	 * @var boolean
	 */
	protected $sortable;

	/**
	 * Default checkbox set configuration options.
	 *
	 * @since 2.5.0
	 *
	 * @var array
	 */
	protected static $defaultCheckboxSetArgs = array(
		'defaultValue' => array(),
		'sortable' => false
	);


	/**
	 * Checkbox set object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.5.0
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
	 *    * __options__ - (array) Select element options.
	 *    * __sortable__ - (boolean) Input set sortable flag.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$checkboxSetArgs = array_merge($this::$defaultCheckboxSetArgs, array_intersect_key($args, $this::$defaultCheckboxSetArgs));

		// parse args into object variables
		$this->setDefaultValue($checkboxSetArgs['defaultValue']);
		$this->setSortable($checkboxSetArgs['sortable']);

	}


	/**
	 * Get set element sortable flag.
	 *
	 * @since 2.5.0
	 *
	 * @return boolean Set element sortable flag.
	 */
	public function getSortable() {
		return $this->sortable;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'checkboxSet'.
	 *
	 * @since 2.5.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'checkboxSet';
	}


	/**
	 * Set default input value.
	 *
	 * @since 2.5.0
	 *
	 * @param string $defaultValue Default input value.
	 */
	public function setDefaultValue($defaultValue) {
		if(is_array($defaultValue)) $this->defaultValue = $defaultValue;
	}


	/**
	 * Set set element sortable flag.
	 *
	 * @since 2.5.0
	 *
	 * @param boolean $sortable Set element sortable flag.
	 */
	public function setSortable($sortable) {
		$this->sortable = (bool)$sortable;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.5.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\CheckboxSet::getOutputAttributes() to build input element's attribute array.
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
		if(!is_array($args['value'])) $args['value'] = $this->defaultValue;

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
	 * Generate checkbox set element options output HTML.
	 *
	 * @since 2.5.0
	 *
	 * @param array $options Options to convert to HTML.
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return string Checkbox set input element options output HTML.
	 */
	protected function getOutputOptions($options = array(), $args = array()) {
		$output = array();

		$inputs = array();
		foreach($options as $option) {
			$value = !is_array($option) ? $option : (array_key_exists('value', $option) ? $option['value'] : '');
			$inputs[$value] = $this->getOptionOutput($option, $args);
		}

		if($this->sortable) {
			foreach($args['value'] as $v) {
				if(array_key_exists($v, $inputs)) {
					$output[] = $inputs[$v];
					unset($inputs[$v]);
				}
			}
		}

		$output = array_merge($output, array_values($inputs));

		return implode('', $output);
	}


	/**
	 * Generate checkbox option output HTML.
	 *
	 * @since 2.5.0
	 *
	 * @param array $option Option to convert to HTML.
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return string Checkbox input element option output HTML.
	 */
	protected function getOptionOutput($option = '', $args = array()) {
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
			'name' => $this->name.'[]',
			'value' => $value,
			'label' => '<span class="overflow">'.$label.'</span>',
			'atts' => array(
				'checked' => in_array($value, $args['value'])
			)
		);
		$input = new Checkbox($inputArgs);

		// setup option indentation
		// $indentation = str_repeat('&nbsp;', $depth * 3);
		
		return '<div class="input-wrap depth-'.$depth.'">'.$input->getOutput($args).'</div>';
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

		$defaultClasses = array(
			'crown-checkbox-set-input'
		);
		if($this->sortable) $defaultClasses[] = 'sortable';
		$class = array_merge($defaultClasses, $this->class);

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
	 * The metadata key corresponds to input object's name.
	 *
	 * @since 2.5.0
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param string $previousValue Optional. Previous value to replace. By default, replaces all entries for meta key.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function updateMetaValue($value = array(), $type = 'site', $objectId = null, $previousValue = '') {

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