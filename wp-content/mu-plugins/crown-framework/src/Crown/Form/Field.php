<?php
/**
 * Contains definition for \Crown\Form\Field class.
 */

namespace Crown\Form;


/**
 * Form field container class.
 *
 * Serves as a handler for form fields in the WordPress admin. A field object
 * contains a single input object, which is used to save relevant data to
 * specific database tables, based on the field's context.
 * 
 * ```
 * $myCustomField = new Field(array(
 *     'label' => 'Custom Field',
 *     'input' => new Text(array('name' => 'my_custom_field')),
 *     'description' => 'Custom field description goes here...',
 *     'id' => 'my-custom-field',
 *     'class' => 'custom-field custom-class',
 *     'atts' => array('data-field-data' => '0'),
 *     'uIRules' => array(
 *         new UIRule(array('property' => 'userPermission', 'value' => 'edit_users'))
 *     ),
 *     'getOutputCb' => 'getMyCustomFieldOutput',
 *     'saveMetaCb' => 'saveMyCustomFieldMeta'
 * ));
 * ```
 *
 * Field objects are generally added WordPress data type objects, such as posts,
 * meta boxes, or taxonomies where the necessary action and filter hooks are
 * registered for handling the field's functionality.
 *
 * @since 2.0.0
 */
class Field {

	/**
	 * Field label.
	 *
	 * In most cases, the field's label will be output above the field's input
	 * in bold text.
	 *
	 * @see \Crown\Form\Field::getLabel()
	 * @see \Crown\Form\Field::setLabel()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $label;

	/**
	 * Input object.
	 *
	 * Any of the `\Crown\Form\Field\Input` classes can be set to the field's `input`
	 * property. This defines what kind of input to use for the field.
	 *
	 * @see \Crown\Form\Field::getInput()
	 * @see \Crown\Form\Field::setInput()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Form\Input\Input
	 */
	protected $input;

	/**
	 * Field description.
	 *
	 * Any additional direction that may be needed for the field. This text is
	 * typically output between the field's label and input.
	 *
	 * @see \Crown\Form\Field::getInput()
	 * @see \Crown\Form\Field::setInput()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Field element ID.
	 *
	 * Optional ID for the field's HTML element to allow for CSS/JS targeting.
	 *
	 * @see \Crown\Form\Field::getId()
	 * @see \Crown\Form\Field::setId()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Field element class.
	 *
	 * Optional class for the field's HTML element to allow for CSS/JS targeting.
	 *
	 * @see \Crown\Form\Field::getClass()
	 * @see \Crown\Form\Field::setClass()
	 *
	 * @since 2.0.0
	 *
	 * @var string[]
	 */
	protected $class;

	/**
	 * Additional field element attributes.
	 *
	 * Optional set of attributes to include in the HTML element output of the
	 * field. Attributes are stored as an associative array with the keys
	 * corresponding to the desired attribute names.
	 *
	 * ```
	 * $fieldAtts = array(
	 *     'id' => 'my-custom-field',
	 *     'disabled' => true
	 * );
	 * ```
	 *
	 * The attributes defined in this property will override any of the field's
	 * default attributes set by the `\Crown\Form\Field` class.
	 *
	 * @see \Crown\Form\Field::getAtts()
	 * @see \Crown\Form\Field::setAtts()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $atts;

	/**
	 * UI visibility rules.
	 *
	 * A set of rules to evaluate when determining the field's visibility for
	 * the specific context. The visibility is decided by the intersection of
	 * the rules defined, meaning all rules must be satisfied to show the field.
	 *
	 * @see \Crown\Form\Field::getUIRules()
	 * @see \Crown\Form\Field::setUIRules()
	 *
	 * @since 2.1.0
	 *
	 * @var \Crown\UIRule[]
	 */
	protected $uIRules;

	/**
	 * Field get output callback pointer.
	 *
	 * If a callback function is defined for the field's get output method,
	 * that function will be called before generating any of field's default
	 * output. If something is returned by the callback, that result will be
	 * displayed instead of the default output.
	 *
	 * ```
	 * function getMyCustomFieldOutput($field, $args) {
	 *     // custom output script goes here...
	 * }
	 * ```
	 *
	 * The callback function should accept two parameters:
	 *    * __`$field`__ - (`Field`) Field object for which to output.
	 *    * __`$args`__ - (`array`) Field output options passed into the `\Crown\Form\Field::getOutput()` method.
	 *
	 * If the default field output is to be overridden, be sure to return the
	 * desired HTML output for the field.
	 *
	 * @see \Crown\Form\Field::getGetOutputCb()
	 * @see \Crown\Form\Field::setGetOutputCb()
	 *
	 * @since 2.3.0
	 *
	 * @var callback
	 */
	protected $getOutputCb;

	/**
	 * Field settings save callback pointer.
	 *
	 * The save meta callback function, if set, will be called after any input
	 * associated with the field have already been saved.
	 *
	 * ```
	 * function saveMyCustomFieldMeta($field, $input, $type, $objectId, $value) {
	 *     // custom meta data save script goes here...
	 * }
	 * ```
	 *
	 * The callback function should accept five parameters:
	 *    * __`$field`__ - (`Field`) Field object for which to save meta data.
	 *    * __`$input`__ - (`array`) Set of input data submitted by form.
	 *    * __`$type`__ - (`string`) Type of object meta data is being saved to.
	 *    * __`$objectId`__ - (`int`) ID of object to save meta data to, if applicable.
	 *    * __`$value`__ - (`mixed`) Value of field saved by default save meta method.
	 *
	 * @see \Crown\Form\Field::getSaveMetaCb()
	 * @see \Crown\Form\Field::setSaveMetaCb()
	 *
	 * @since 2.3.0
	 *
	 * @var callback
	 */
	protected $saveMetaCb;

	/**
	 * Default field configuration options.
	 *
	 * These options can be overridden by passing in an array of arguments when
	 * constructing a `Field` object.
	 *
	 * ```
	 * $defaultFieldArgs = array(
	 *     'label' => '',
	 *     'input' => null,
	 *     'description' => '',
	 *     'id' => '',
	 *     'class' => array(),
	 *     'atts' => array(),
	 *     'uIRules' => array(),
	 *     'getOutputCb' => null,
	 *     'saveMetaCb' => null
	 * );
	 * ```
	 *
	 * @see \Crown\Form\Field::__construct()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultFieldArgs = array(
		'label' => '',
		'input' => null,
		'description' => '',
		'id' => '',
		'class' => array(),
		'atts' => array(),
		'uIRules' => array(),
		'getOutputCb' => null,
		'saveMetaCb' => null
	);

	/**
	 * Default field element output options.
	 *
	 * These are all the possible arguments that can be passed into the
	 * `\Crown\Form\Field::getOutput()` method. If a get output callback is
	 * defined, these same arguments will be passed through to it.
	 *
	 * ```
	 * $defaultOutputArgs = array(
	 *     'value' => '',
	 *     'objectId' => null,
	 *     'isTpl' => false,
	 *     'basename' => '',
	 *     'format' => 'div'
	 * );
	 * ```
	 *
	 * @see \Crown\Form\Field::getOutput()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultOutputArgs = array(
		'value' => '',
		'objectId' => null,
		'isTpl' => false,
		'basename' => '',
		'format' => 'div'
	);


	/**
	 * Field object constructor.
	 *
	 * Parses configuration options into object properties. Passed in options
	 * array overrides those found in `$defaultFieldArgs` property.
	 *
	 * ```
	 * $myCustomField = new Field(array(
	 *     'label' => 'Custom Field',
	 *     'input' => new Text(array('name' => 'my_custom_field')),
	 *     'description' => 'Custom field description goes here...',
	 *     'id' => 'my-custom-field',
	 *     'class' => 'custom-field custom-class',
	 *     'atts' => array('data-field-data' => '0'),
	 *     'uIRules' => array(
	 *         new UIRule(array('property' => 'userPermission', 'value' => 'edit_users'))
	 *     ),
	 *     'getOutputCb' => 'getMyCustomFieldOutput',
	 *     'saveMetaCb' => 'saveMyCustomFieldMeta'
	 * ));
	 * ```
	 *
	 * @see \Crown\Form\Field::$defaultFieldArgs
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __label__ - (string) Field label.
	 *    * __input__ - (\Crown\Form\Input\Input) Input object.
	 *    * __description__ - (string) Field description.
	 *    * __id__ - (string) Field element ID.
	 *    * __class__ - (string|string[]) Field element class.
	 *    * __atts__ - (array) Additional field element attributes.
	 *    * __uIRules__ - (array) UI visibility rules.
	 *    * __getOutputCb__ - (callback) Field content output callback pointer.
	 *    * __saveMetaCb__ - (callback) Field settings save callback pointer.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$fieldArgs = array_merge($this::$defaultFieldArgs, array_intersect_key($args, $this::$defaultFieldArgs));

		// parse args into object variables
		$this->setLabel($fieldArgs['label']);
		$this->setInput($fieldArgs['input']);
		$this->setDescription($fieldArgs['description']);
		$this->setId($fieldArgs['id']);
		$this->setClass($fieldArgs['class']);
		$this->setAtts($fieldArgs['atts']);
		$this->setUIRules($fieldArgs['uIRules']);
		$this->setGetOutputCb($fieldArgs['getOutputCb']);
		$this->setSaveMetaCb($fieldArgs['saveMetaCb']);

	}


	/**
	 * Get field label.
	 *
	 * ```
	 * $label = $myField->getLabel();
	 * ```
	 *
	 * @see \Crown\Form\Field::$label
	 *
	 * @since 2.0.0
	 *
	 * @return string Field label.
	 */
	public function getLabel() {
		return $this->label;
	}


	/**
	 * Get input object.
	 *
	 * ```
	 * $input = $myField->getInput();
	 * ```
	 *
	 * @see \Crown\Form\Field::$input
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Form\Input\Input Input object
	 */
	public function getInput() {
		return $this->input;
	}


	/**
	 * Get field description.
	 *
	 * ```
	 * $description = $myField->getDescription();
	 * ```
	 *
	 * @see \Crown\Form\Field::$description
	 *
	 * @since 2.0.0
	 *
	 * @return string Field description.
	 */
	public function getDescription() {
		return $this->description;
	}


	/**
	 * Get field element ID.
	 *
	 * ```
	 * $Id = $myField->getId();
	 * ```
	 *
	 * @see \Crown\Form\Field::$id
	 *
	 * @since 2.0.0
	 *
	 * @return string Field element ID.
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * Get field element class.
	 *
	 * ```
	 * $class = $myField->getClass();
	 * ```
	 *
	 * @see \Crown\Form\Field::$class
	 *
	 * @since 2.0.0
	 *
	 * @return string[] Field element class.
	 */
	public function getClass() {
		return $this->class;
	}


	/**
	 * Get additional field element attributes.
	 *
	 * ```
	 * $atts = $myField->getAtts();
	 * ```
	 *
	 * @see \Crown\Form\Field::$atts
	 *
	 * @since 2.0.0
	 *
	 * @return array Additional field element attributes.
	 */
	public function getAtts() {
		return $this->atts;
	}


	/**
	 * Get UI visibility rules.
	 *
	 * ```
	 * $uIRules = $myField->getUIRules();
	 * ```
	 *
	 * @see \Crown\Form\Field::$uIRules
	 *
	 * @since 2.1.0
	 *
	 * @return array UI visibility rules.
	 */
	public function getUIRules() {
		return $this->uIRules;
	}


	/**
	 * Get field content output callback pointer.
	 *
	 * ```
	 * $getOutputCb = $myField->getGetOutputCb();
	 * ```
	 *
	 * @see \Crown\Form\Field::$getOutputCb
	 *
	 * @since 2.3.0
	 *
	 * @return callback Content get output callback.
	 */
	public function getGetOutputCb() {
		return $this->getOutputCb;
	}


	/**
	 * Get field settings save callback pointer.
	 *
	 * ```
	 * $saveMetaCb = $myField->getSaveMetaCb();
	 * ```
	 *
	 * @see \Crown\Form\Field::$saveMetaCb
	 *
	 * @since 2.3.0
	 *
	 * @return callback Settings save callback.
	 */
	public function getSaveMetaCb() {
		return $this->saveMetaCb;
	}


	/**
	 * Set field label.
	 *
	 * ```
	 * $myField->setLabel('Custom Field');
	 * ```
	 *
	 * @see \Crown\Form\Field::$label
	 *
	 * @since 2.0.0
	 *
	 * @param string $label Field label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}


	/**
	 * Set input object.
	 *
	 * ```
	 * $myField->setInput(new Text(array('name' => 'my_custom_field')));
	 * ```
	 *
	 * @see \Crown\Form\Field::$input
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Input\Input $input Input object.
	 */
	public function setInput($input) {
		$this->input = $input;
	}


	/**
	 * Set field description.
	 *
	 * ```
	 * $myField->setLabel('Custom Field');
	 * ```
	 *
	 * @see \Crown\Form\Field::$label
	 *
	 * @since 2.0.0
	 *
	 * @param string $description Field description.
	 */
	public function setDescription($description) {
		$this->description = $description;
	}


	/**
	 * Set field element ID.
	 *
	 * ```
	 * $myField->setId('my-custom-field');
	 * ```
	 *
	 * @see \Crown\Form\Field::$id
	 *
	 * @since 2.0.0
	 *
	 * @param string $id Field element ID.
	 */
	public function setId($id) {
		$this->id = $id;
	}


	/**
	 * Set field element class.
	 *
	 * ```
	 * $myField->setClass('custom-field custom-class');
	 * ```
	 *
	 * Optionally, classes can be passed in as an array:
	 *
	 * ```
	 * $myField->setClass(array('custom-field', 'custom-class'));
	 * ```
	 *
	 * @see \Crown\Form\Field::$class
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Form\Field::parseClasses() to parse field class into array.
	 *
	 * @param string|string[] $class List of field element classes.
	 */
	public function setClass($class) {
		$this->class = $this->parseClasses($class);
	}


	/**
	 * Set additional field element attributes.
	 *
	 * ```
	 * $myField->setAtts(array('data-field-data' => '0'));
	 * ```
	 *
	 * @see \Crown\Form\Field::$atts
	 *
	 * @since 2.0.0
	 *
	 * @param array $atts Additional field element attributes.
	 */
	public function setAtts($atts) {
		if(is_array($atts)) $this->atts = $atts;
	}


	/**
	 * Set UI visibility rules.
	 *
	 * ```
	 * $myField->setUIRules(array(
	 *     new UIRule(array('property' => 'userPermission', 'value' => 'edit_users'))
	 * ));
	 * ```
	 *
	 * @see \Crown\Form\Field::$uIRules
	 *
	 * @since 2.1.0
	 *
	 * @param array $uIRules UI visibility rules.
	 */
	public function setUIRules($uIRules) {
		if(is_array($uIRules)) $this->uIRules = $uIRules;
	}


	/**
	 * Set field content output callback pointer.
	 *
	 * ```
	 * function getMyCustomFieldOutput($field, $args) {
	 *     // custom output script goes here...
	 * }
	 * $myField->setGetOutputCb('getMyCustomFieldOutput');
	 * ```
	 *
	 * The callback function should accept two parameters:
	 *    * __`$field`__ - (`Field`) Field object for which to output.
	 *    * __`$args`__ - (`array`) Field output options passed into the `\Crown\Form\Field::getOutput()` method.
	 *
	 * If the default field output is to be overridden, be sure to return the
	 * desired HTML output for the field.
	 *
	 * @see \Crown\Form\Field::$getOutputCb
	 *
	 * @since 2.3.0
	 *
	 * @param callback $getOutputCb Content get output callback.
	 */
	public function setGetOutputCb($getOutputCb) {
		$this->getOutputCb = $getOutputCb;
	}


	/**
	 * Set field settings save callback pointer.
	 *
	 * ```
	 * function saveMyCustomFieldMeta($field, $input, $type, $objectId, $value) {
	 *     // custom meta data save script goes here...
	 * }
	 * $myField->setSaveMetaCb('saveMyCustomFieldMeta');
	 * ```
	 *
	 * The callback function should accept five parameters:
	 *    * __`$field`__ - (`Field`) Field object for which to save meta data.
	 *    * __`$input`__ - (`array`) Set of input data submitted by form.
	 *    * __`$type`__ - (`string`) Type of object meta data is being saved to.
	 *    * __`$objectId`__ - (`int`) ID of object to save meta data to, if applicable.
	 *    * __`$value`__ - (`mixed`) Value of field saved by default save meta method.
	 *
	 * @see \Crown\Form\Field::$saveMetaCb
	 *
	 * @since 2.3.0
	 *
	 * @param callback $saveMetaCb Settings save callback.
	 */
	public function setSaveMetaCb($saveMetaCb) {
		$this->saveMetaCb = $saveMetaCb;
	}


	/**
	 * Get the field's input object's name.
	 *
	 * If an input is defined for the field, it's name is retrieved, otherwise,
	 * `null` is returned.
	 *
	 * ```
	 * $inputName = $myField->getInputName();
	 * ```
	 *
	 * @see \Crown\Form\Input\Input::getName()
	 *
	 * @since 2.0.0
	 *
	 * @return string Input object's name.
	 */
	public function getInputName() {
		return !empty($this->input) ? $this->input->getName() : null;
	}


	/**
	 * Output field HTML.
	 *
	 * The HTML generated by `\Crown\Form\Field::getOutput()` is echoed out.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Form\Field::getOutput() to generate field HTML.
	 *
	 * @param array $args Optional. Field output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether field should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *    * __format__ - (string) Field format type. Possible values: div|tr. By default, outputs as div element.
	 */
	public function output($args = array()) {
		echo $this->getOutput($args);
	}


	/**
	 * Get field output HTML.
	 *
	 * If the field's get output callback property is defined, that function
	 * will be called. Otherwise, the default field HTML will be generated for
	 * output.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Form\Field::getOutputAttributes() to build field element's attribute array.
	 * @uses \Crown\Form\Field::convertHtmlAttributes() to convert an associative arrays into HTML element attributes.
	 *
	 * @param array $args Optional. Field output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __objectId__ - (int) Relative object ID.
	 *    * __isTpl__ - (boolean) Whether field should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *    * __format__ - (string) Field format type. Possible values: div|tr. By default, outputs as div element.
	 *
	 * @return string Output HTML.
	 */
	public function getOutput($args = array()) {

		// merge options with defaults
		$args = array_merge($this::$defaultOutputArgs, array('value' => isset($args['isTpl']) && $args['isTpl'] && $this->input ? $this->input->getDefaultValue() : ''), $args);

		// use custom field output, if applicable
		if(is_callable($this->getOutputCb) && ($output = call_user_func_array($this->getOutputCb, array($this, &$args)))) {
			return $output;	
		}

		// make sure input is set
		if(empty($this->input)) return '';

		// if input is hidden, just output the input object alone
		if($this->input->getType() == 'hidden') {
			return $this->input->getOutput($args);
		}

		// get attribute array
		$fieldAtts = $this->convertHtmlAttributes($this->getOutputAttributes($args['objectId']));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'for' => $this->input->getId()
		));

		// build description attributes array
		$descriptionAtts = $this->convertHtmlAttributes(array(
			'class' => 'description'
		));

		// configure output HTML tags
		$fieldWrapTag = $args['format'] == 'tr' ? 'tr' : 'div';
		$labelWrapTag = $args['format'] == 'tr' ? 'th' : 'div';
		$inputWrapTag = $args['format'] == 'tr' ? 'td' : 'div';

		ob_start();
		?>

			<<?php echo $fieldWrapTag; ?> <?php echo implode(' ', $fieldAtts); ?>>

				<?php if($args['format'] == 'tr' || !empty($this->label) || !empty($this->description)) { ?>
					<<?php echo $labelWrapTag; ?> class="label-wrap">

						<?php if(!empty($this->label)) { ?>
							<label <?php echo implode(' ', $labelAtts); ?>><?php echo $this->label; ?></label>
						<?php } ?>

						<?php if(!empty($this->description)) { ?>
							<?php if($args['format'] != 'tr') { ?>
								<p <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></p>
							<?php } ?>
						<?php } ?>

					</<?php echo $labelWrapTag; ?>>
				<?php } ?>

				<<?php echo $inputWrapTag; ?> class="input-wrap">

					<?php $this->input->output($args); ?>

					<?php if($args['format'] == 'tr') { ?>
						<p <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></p>
					<?php } ?>

				</<?php echo $inputWrapTag; ?>>

			</<?php echo $fieldWrapTag; ?>>

		<?php
		$output = ob_get_clean();

		return $output;

	}


	/**
	 * Build list of field element's attributes.
	 *
	 * Attributes for the field's HTML elemented are generated based on the
	 * various field properties. These attributes are then merged with the
	 * field's `$atts` property before being returned.
	 *
	 * @since 2.0.0
	 *
	 * @param int $objectId Optional. Relative object ID.
	 *
	 * @return array Associative array of field element attribute key-value pairs.
	 */
	protected function getOutputAttributes($objectId = null) {

		$class = array_merge(array('crown-field'), $this->class);

		// build rule attributes
		$rulesAtts = array();
		if(!empty($this->uIRules)) {
			$class[] = 'conditional-ui';
			$active = true;
			foreach($this->uIRules as $uIRule) {
				$passed = $uIRule->evaluate($objectId);
				$property = $uIRule->getProperty();
				if(!empty($property)) {
					$class[] = 'conditional-ui-property-'.$property;
					$rulesAtts[] = array(
						'property' => $property,
						'compare' => $uIRule->getCompare(),
						'value' => $uIRule->getValue(),
						'options' => $uIRule->getOptions(),
						'passed' => $passed
					);
				}
				if(!$passed) $active = false;
			}
			if($active) {
				$class[] = 'conditional-ui-active';
			}
		}
		
		$atts = array(
			'id' => $this->id,
			'class' => implode(' ', $class)
		);

		if(!empty($this->uIRules)) {
			$atts['data-conditional-ui-rules'] = json_encode($rulesAtts);
		}

		// merge other attributes
		return array_merge($atts, $this->atts);

	}


	/**
	 * Parse class argument into array.
	 *
	 * If passed in `$class` parameter is a string, it's split up into an
	 * array. Each class in the array is trimmed of extra whitespace and then
	 * verified to not be an empty string before being returned.
	 *
	 * @since 2.0.0
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
	 * @param array $atts Associative array of element attribute key-value pairs.
	 *
	 * @return string HTML element attributes.
	 */
	protected function convertHtmlAttributes($atts) {
		$elementAtts = array();
		foreach($atts as $attr => $val) {
			if(is_bool($val) && !$val) continue;
			if(!is_bool($val) && (string)$val === '') continue;
			$elementAttr = $attr;
			if((string)$val !== '' && !is_bool($val)) $elementAttr .= '="'.esc_attr($val).'"';
			$elementAtts[] = $elementAttr;
		}
		return $elementAtts;
	}


	/**
	 * Retrieve input's metadata value.
	 *
	 * The stored value for the input object, if set, for the current context
	 * is retrieved. The metadata key corresponds to input object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return mixed Will be an array if $single is false. Will be value of metadata field if $single is true.
	 */
	public function getValue($type = 'site', $objectId = null) {

		// make sure input is set
		if(empty($this->input)) return '';

		$value = $this->input->getMetaValue($type, $objectId);

		if(empty($value) && !$this->input->isMetaValueDefined($type, $objectId)) {
			$value = $this->input->getDefaultValue();
		}

		return $value;

	}


	/**
	 * Update input's metadata value.
	 *
	 * The value for the input object, if set, for the current context is
	 * updated according to the passed in value. The metadata key corresponds
	 * to input object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function setValue($value = '', $type = 'site', $objectId = null) {

		// make sure input is set
		if(empty($this->input)) return false;

		return $this->input->updateMetaValue($value, $type, $objectId);

	}


	/**
	 * Save input's metadata value from input source.
	 *
	 * The relevant data from the input array is extracted and used to update
	 * the field's input's metadata value.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Form\Field::setValue() to update the input's metadata value.
	 *
	 * @param array $input Submitted data to search for relevant metadata value.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function saveValue($input = array(), $type = 'site', $objectId = null) {

		$result = false;
		$value = null;

		// make sure input is set
		if(!empty($this->input)) {

			$value = $this->input->getDefaultValue();

			// default value override for special input cases
			if(is_a($this->input, '\Crown\Form\Input\Checkbox')) {
				$value = '';
			} else if(is_a($this->input, '\Crown\Form\Input\CheckboxSet')) {
				$value = array();
			} else if(is_a($this->input, '\Crown\Form\Input\Select') && $this->input->getMultiple()) {
				$value = array();
			}

			// retrieve value from input data if set
			if(isset($input[$this->input->getName()])) {
				$value = $input[$this->input->getName()];
			}

			$result = $this->setValue($value, $type, $objectId);

		}

		// additional custom field data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $this, $input, $type, $objectId, $value);

		return $result;

	}


	/**
	 * Restore the input's metadata value for a post from a revision.
	 *
	 * The value for the input object, if set, for the current context is
	 * transferred from the revision. The metadata key corresponds to input
	 * object's name.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID to restore metadata to.
	 * @param int $revisionId Revision ID to restore metadata from.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function restoreValue($postId, $revisionId) {

		// make sure input is set
		if(empty($this->input)) return false;

		return $this->input->restoreMetaValue($postId, $revisionId);

	}

}