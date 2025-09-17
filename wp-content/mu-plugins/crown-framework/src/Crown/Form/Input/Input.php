<?php
/**
 * Contains definition for \Crown\Form\Input\Input class.
 */

namespace Crown\Form\Input;


/**
 * Form input element class.
 *
 * Serves as a handler for field inputs in the WordPress admin. Input objects are used to generate
 * form input HTML and save relevant data to specific database tables, based on their context.
 *
 * @since 2.0.0
 */
class Input {

	/**
	 * Input element type.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Input element name.
	 *
	 * The input's name is also used to specify which submitted form data to interact with and save
	 * as metadata in the database.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Input label.
	 *
	 * In contrast to field labels, input labels should be reserved to indicate a closer relationship
	 * between label and input, such as within a field group.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * Default input value.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $defaultValue;

	/**
	 * Input element ID.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Input element class.
	 *
	 * @since 2.0.0
	 *
	 * @var string[]
	 */
	protected $class;

	/**
	 * Input element required flag.
	 *
	 * @since 2.0.0
	 *
	 * @var boolean
	 */
	protected $required;

	/**
	 * Additional input element attributes.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $atts;

	/**
	 * Default input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultInputArgs = array(
		'type' => '',
		'name' => '',
		'label' => '',
		'defaultValue' => '',
		'id' => '',
		'class' => array(),
		'required' => false,
		'atts' => array(),
	);

	/**
	 * Default input element output options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultOutputArgs = array(
		'value' => '',
		'isTpl' => false,
		'basename' => ''
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
	 *    * __defaultValue__ - (string) Default input value.
	 *    * __id__ - (string) Input element ID.
	 *    * __class__ - (string|string[]) Input element class.
	 *    * __required__ - (boolean) Input element required flag.
	 *    * __atts__ - (array) Additional input element attributes.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$inputArgs = array_merge($this::$defaultInputArgs, array_intersect_key($args, $this::$defaultInputArgs));

		// parse args into object variables
		$this->setType($inputArgs['type']);
		$this->setName($inputArgs['name']);
		$this->setLabel($inputArgs['label']);
		$this->setDefaultValue($inputArgs['defaultValue']);
		$this->setId($inputArgs['id']);
		$this->setClass($inputArgs['class']);
		$this->setRequired($inputArgs['required']);
		$this->setAtts($inputArgs['atts']);

	}


	/**
	 * Get input element type.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input element type.
	 */
	public function getType() {
		return $this->type;
	}


	/**
	 * Get input element name.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input element name.
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * Get input label.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input label.
	 */
	public function getLabel() {
		return $this->label;
	}


	/**
	 * Get default input value.
	 *
	 * @since 2.0.0
	 *
	 * @return string Default input value.
	 */
	public function getDefaultValue() {
		return $this->defaultValue;
	}


	/**
	 * Get input element ID.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input element ID.
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * Get input element class.
	 *
	 * @since 2.0.0
	 *
	 * @return string[] List of input element classes.
	 */
	public function getClass() {
		return $this->class;
	}


	/**
	 * Get input element required flag.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Input element required flag.
	 */
	public function getRequired() {
		return $this->required;
	}


	/**
	 * Get additional input element attributes.
	 *
	 * @since 2.0.0
	 *
	 * @return array Additional input element attributes.
	 */
	public function getAtts() {
		return $this->atts;
	}


	/**
	 * Set input element type.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = $type;
	}


	/**
	 * Set input element name.
	 *
	 * @since 2.0.0
	 *
	 * @param string $name Input element name.
	 */
	public function setName($name) {
		$this->name = $name;
	}


	/**
	 * Set input label.
	 *
	 * @since 2.0.0
	 *
	 * @param string $label Input label.
	 */
	public function setLabel($label) {
		$this->label = $label;
	}


	/**
	 * Set default input value.
	 *
	 * @since 2.0.0
	 *
	 * @param string $defaultValue Default input value.
	 */
	public function setDefaultValue($defaultValue) {
		$this->defaultValue = $defaultValue;
	}


	/**
	 * Set input element ID.
	 *
	 * @since 2.0.0
	 *
	 * @param string $id Input element ID.
	 */
	public function setId($id) {
		$this->id = $id;
	}


	/**
	 * Set input element class.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Form\Input\Input::parseClasses() to parse input class into array.
	 *
	 * @param string|string[] $class List of input element classes.
	 */
	public function setClass($class) {
		$this->class = $this->parseClasses($class);
	}


	/**
	 * Set input element required flag.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $required Input element required flag.
	 */
	public function setRequired($required) {
		$this->required = (bool)$required;
	}


	/**
	 * Set additional input element attributes.
	 *
	 * @since 2.0.0
	 *
	 * @param array $atts Additional input element attributes.
	 */
	public function setAtts($atts) {
		if(is_array($atts)) $this->atts = $atts;
	}


	/**
	 * Asserts if input is required
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Whether input is required.
	 */
	public function isRequired() {
		return $this->required;
	}


	/**
	 * Output input HTML.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Form\Input\Input::getOutput() to generate input HTML.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 */
	public function output($args = array()) {
		echo $this->getOutput($args);
	}



	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Input::getOutputAttributes() to build input element's attribute array.
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

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label',
			'for' => $this->id
		));

		// output input element
		$output .= '<input '.implode(' ', $atts).'>';

		// output input-level label, if applicable
		if(!empty($this->label)) $output .= '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';

		return $output;

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

		// merge options with defaults
		$args = array_merge($this::$defaultOutputArgs, $args);
		
		$atts = array(
			'type' => $this->type,
			'name' => $this->name,
			'value' => $args['value'],
			'id' => $this->id,
			'class' => implode(' ', $this->class),
			'required' => $this->required
		);

		// append name to basename, if applicable
		if(!empty($args['basename'])) {
			if(preg_match('/(\[[^\]]*\])$/', $atts['name'], $matches)) {
				$atts['name'] = $args['basename'].'['.preg_replace('/(\[[^\]]*\])$/', '', $atts['name']).']'.$matches[1];
			} else {
				$atts['name'] = $args['basename'].'['.$atts['name'].']';
			}
		}

		// if input is part of a template, mask name and required attribute so data isn't submitted
		if($args['isTpl']) {
			$atts['data-tpl-name'] = $atts['name'];
			unset($atts['name']);
			$atts['data-tpl-required'] = (string)$atts['required'];
			unset($atts['required']);
		}

		// merge other attributes
		return array_merge($atts, $this->atts);

	}


	/**
	 * Parse class argument into array.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::setClass() during input element class configuration.
	 *
	 * @param string|string[] $class Element class.
	 *
	 * @return string[] List of element classes.
	 */
	protected function parseClasses($class) {

		// check if already an array
		if(is_array($class)) return $class;

		// split string into array
		$classArray = array();
		foreach(explode(' ', $class) as $className) {
			$className = trim($className);
			if(!empty($className)) $classArray[] = $className;
		}

		return $classArray;

	}


	/**
	 * Convert an associative array into HTML element attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::getOutput() during input element HTML generation.
	 *
	 * @param array $atts Associative array of element attribute key-value pairs.
	 *
	 * @return string HTML element attributes.
	 */
	protected function convertHtmlAttributes($atts) {
		$elementAtts = array();
		foreach($atts as $attr => $val) {
			if(is_bool($val) && !$val) continue;
			if(!is_bool($val) && (string)$val === '' && $attr != 'value') continue;
			$elementAttr = $attr;
			if((string)$val !== '' && !is_bool($val)) $elementAttr .= '="'.esc_attr($val).'"';
			$elementAtts[] = $elementAttr;
		}
		return $elementAtts;
	}


	/**
	 * Check if input's value has been set for the given context.
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean True if value is defined, false if otherwise.
	 */
	public function isMetaValueDefined($type = 'site', $objectId = null) {

		// make sure name is set
		if(empty($this->name)) return false;

		// check against allowed meta types
		if(!in_array($type, array('site', 'blog', 'post', 'user', 'term'))) return false;

		// if site meta, update site option value
		if($type == 'site') {
			return get_site_option($this->name, null) !== null;
		}

		// if site meta, update site option value
		if($type == 'blog') {
			return get_option($this->name, null) !== null;
		}

		// retrieve object meta value
		$value = get_metadata($type, $objectId, $this->name);
		return !empty($value);

	}


	/**
	 * Retrieve metadata value.
	 *
	 * The metadata key corresponds to input object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param boolean $single Optional. Whether to return a single value. By default, returns all values for key.
	 *
	 * @return mixed Will be an array if $single is false. Will be value of metadata field if $single is true.
	 */
	public function getMetaValue($type = 'site', $objectId = null, $single = true) {

		// make sure name is set
		if(empty($this->name)) return false;

		// check against allowed meta types
		if(!in_array($type, array('site', 'blog', 'post', 'user', 'term'))) return false;

		// if site meta, update site option value
		if($type == 'site') {
			return get_site_option($this->name, $this->defaultValue);
		}

		// if site meta, update site option value
		if($type == 'blog') {
			return get_option($this->name, $this->defaultValue);
		}

		// retrieve object meta value
		$value = get_metadata($type, $objectId, $this->name, $single);

		// merge with default value if necessary
		if($single) {
			if(is_a($this, '\Crown\Form\Input\Select') && !$this->multiple && is_array($value)) {
				$value = !empty($value) ? $value[0] : $this->defaultValue;
			}
			if(is_a($this, '\Crown\Form\Input\Checkbox') || is_a($this, '\Crown\Form\Input\CheckboxSet') || (is_a($this, '\Crown\Form\Input\Select') && $this->multiple)) {
				$values = get_metadata($type, $objectId, $this->name, false);
				if(empty($values)) {
					$value = $this->defaultValue;
				}
			} else if(is_array($value)) {
				$value = array_merge($this->defaultValue, $value);
			} else if($value === '') {
				$valueEntries = get_metadata($type, $objectId, $this->name);
				if(empty($valueEntries)) $value = $this->defaultValue;
			}
		} else if(empty($value)) {
			if(is_array($this->defaultValue) && !empty($this->defaultValue)) {
				$value = $this->defaultValue;
			}
		}

		return $value;

	}


	/**
	 * Add metadata value.
	 *
	 * The metadata key corresponds to input object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, adds site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param boolean $unique Optional. Whether the same key should not be added. By default, adds for existing key.
	 *
	 * @return int|bool Metadata ID on success, false on failure.
	 */
	public function addMetaValue($value = '', $type = 'site', $objectId = null, $unique = false) {

		// make sure name is set
		if(empty($this->name)) return false;

		// check against allowed meta types
		if(!in_array($type, array('site', 'blog', 'post', 'user', 'term'))) return false;

		// if site meta, add site option value
		if($type == 'site') {
			return add_site_option($this->name, wp_unslash($value));
		}

		// if blog meta, add blog option value
		if($type == 'blog') {
			return add_option($this->name, wp_unslash($value));
		}

		// add object meta value
		return add_metadata($type, $objectId, $this->name, $value, $unique);

	}


	/**
	 * Update metadata value.
	 *
	 * The metadata key corresponds to input object's name.
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

		// make sure name is set
		if(empty($this->name)) return false;

		// check against allowed meta types
		if(!in_array($type, array('site', 'blog', 'post', 'user', 'term'))) return false;

		// if site meta, update site option value
		if($type == 'site') {
			return update_site_option($this->name, wp_unslash($value));
		}

		// if blog meta, update blog option value
		if($type == 'blog') {
			return update_option($this->name, wp_unslash($value));
		}

		// update object meta value
		return update_metadata($type, $objectId, $this->name, $value, $previousValue);

	}


	/**
	 * Remove metadata value.
	 *
	 * The metadata key corresponds to input object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, removes site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 * @param string $previousValue Optional. Metadata value. Must be serializable if non-scalar. By default, removes all entries for meta key.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function deleteMetaValue($type = 'site', $objectId = null, $previousValue = '') {

		// make sure name is set
		if(empty($this->name)) return false;

		// check against allowed meta types
		if(!in_array($type, array('site', 'blog', 'post', 'user', 'term'))) return false;

		// if site meta, delete site option value
		if($type == 'site') {
			return delete_site_option($this->name);
		}

		// if blog meta, delete blog option value
		if($type == 'blog') {
			return delete_option($this->name);
		}

		// delete object meta value
		return delete_metadata($type, $objectId, $this->name, $previousValue);

	}


	/**
	 * Restore metadata value for a post from a revision.
	 *
	 * The metadata key corresponds to input object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID to restore metadata to.
	 * @param int $revisionId Revision ID to restore metadata from.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function restoreMetaValue($postId, $revisionId) {

		// make sure name is set
		if(empty($this->name)) return false;

		// retrieve post revision's meta values
		$revisionValues = $this->getMetaValue('post', $revisionId, false);

		// remove existing meta values
		$this->deleteMetaValue('post', $postId);

		// add metadata to post
		foreach($revisionValues as $value) {
			$this->addMetaValue($value, 'post', $postId);
		}

		return true;

	}

}