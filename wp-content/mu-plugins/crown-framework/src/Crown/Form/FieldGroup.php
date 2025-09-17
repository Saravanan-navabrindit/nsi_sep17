<?php
/**
 * Contains definition for \Crown\Form\FieldGroup class.
 */

namespace Crown\Form;


/**
 * Form field group container class.
 *
 * Serves as a handler for form field groups in the WordPress admin. A field group object may contain
 * multiple field objects to group them, visually, on various admin pages.
 *
 * @since 2.0.0
 */
class FieldGroup extends Field {

	/**
	 * Group fields.
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $fields;

	/**
	 * Default field group configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultFieldGroupArgs = array(
		'fields' => array()
	);


	/**
	 * Field object constructor.
	 *
	 * Parses configuration options into object properties.
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
	 *    * __fields__ - (\Crown\Form\Field[]) Group fields.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$fieldGroupArgs = array_merge($this::$defaultFieldGroupArgs, array_intersect_key($args, $this::$defaultFieldGroupArgs));

		// parse args into object variables
		$this->setFields($fieldGroupArgs['fields']);

	}


	/**
	 * Get group fields.
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Form\Field[] Group fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Set input object.
	 *
	 * Input object is overridden to always be set to null.
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Input\Input $input Input object.
	 */
	public function setInput($input) {
		$this->input = null;
	}


	/**
	 * Set group fields.
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field[] $fields Group fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Add field to group.
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field $field New field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Get field output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Field::output() during field output.
	 *
	 * @uses \Crown\Form\FieldGroup::getOutputAttributes() to build field element's attribute array.
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
		$args = array_merge($this::$defaultOutputArgs, array('value' => array()), $args);

		// use custom field output, if applicable
		if(is_callable($this->getOutputCb) && ($output = call_user_func_array($this->getOutputCb, array($this, &$args)))) {
			return $output;	
		}

		// make sure fields are set
		if(empty($this->fields)) return '';

		// get attribute array
		$fieldAtts = $this->convertHtmlAttributes($this->getOutputAttributes($args['objectId']));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array());

		// build description attributes array
		$descriptionAtts = $this->convertHtmlAttributes(array(
			'class' => 'description'
		));

		// configure output HTML tags
		$fieldWrapTag = $args['format'] == 'tr' ? 'tr' : 'fieldset';
		$labelWrapTag = $args['format'] == 'tr' ? 'th' : 'div';
		$inputWrapTag = $args['format'] == 'tr' ? 'td' : 'div';

		ob_start();
		?>

			<<?php echo $fieldWrapTag; ?> <?php echo implode(' ', $fieldAtts); ?>>

				<?php echo $args['format'] == 'tr' ? '<'.$labelWrapTag.' class="label-wrap">' : ''; ?>

				<?php if(!empty($this->label)) { ?>
					<?php if($args['format'] == 'tr') { ?>
						<label <?php echo implode(' ', $labelAtts); ?>><?php echo $this->label; ?></label>
					<?php } else { ?>
						<legend <?php echo implode(' ', $labelAtts); ?>><?php echo $this->label; ?></legend>
					<?php } ?>
				<?php } ?>

				<?php if(!empty($this->description)) { ?>
					<?php if($args['format'] == 'tr') { ?>
						<span <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></span>
					<?php } else { ?>
						<p <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></p>
					<?php } ?>
				<?php } ?>

				<?php echo $args['format'] == 'tr' ? '</'.$labelWrapTag.'>' : ''; ?>

				<<?php echo $inputWrapTag; ?> class="input-wrap">

					<?php
						foreach($this->fields as $field) {
							$fieldInputName = $field->getInputName();
							$fieldValue = empty($fieldInputName) ? $args['value'] : '';
							if(!empty($fieldInputName) && array_key_exists($fieldInputName, $args['value'])) {
								$fieldValue = $args['value'][$fieldInputName];
							}
							$fieldArgs = array_merge($args, array('value' => $fieldValue, 'objectId' => $args['objectId'], 'format' => 'div'));
							if($fieldArgs['value'] == '') {
								if($args['isTpl'] || !$field->getInput() || $field->getInput()->getType() != 'checkbox') {
									unset($fieldArgs['value']);
								}
							}
							$field->output($fieldArgs);
						}
					?>

				</<?php echo $inputWrapTag; ?>>
				
			</<?php echo $fieldWrapTag; ?>>

		<?php
		$output = ob_get_clean();

		return $output;
	}


	/**
	 * Build list of field element's attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\FieldGroup::getOutput() during field element HTML generation.
	 *
	 * @param int $objectId Optional. Relative object ID.
	 *
	 * @return array Associative array of field element attribute key-value pairs.
	 */
	protected function getOutputAttributes($objectId = null) {

		$class = array_merge(array('crown-field', 'group'), $this->class);

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
	 * Retrieve fields' metadata values.
	 *
	 * Fields in group are looped through to retrieve metadata values individually and returned
	 * as a single associative array with input name-value pairs.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return array Input name-value pairs.
	 */
	public function getValue($type = 'site', $objectId = null) {

		$value = array();

		foreach($this->fields as $field) {
			$fieldInputName = $field->getInputName();
			if(!empty($fieldInputName)) { // single
				$value[$fieldInputName] = $field->getValue($type, $objectId);
			} else { // multiple fields
				$fieldValue = $field->getValue($type, $objectId);
				if(!empty($fieldValue)) $value = array_merge($value, $fieldValue);
			}
		}

		return $value;

	}


	/**
	 * Update input's metadata value.
	 *
	 * This method doesn't do anything and is only meant to override the inherited field class'
	 * behavior of updating the input's metadata value. Since field groups don't contain any input
	 * objects, there is nothing to be updated at this level.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Field::saveValue() during submission data saving.
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean False.
	 */
	public function setValue($value = '', $type = 'site', $objectId = null) {

		// don't want to set single value for all fields in group
		return false;

	}


	/**
	 * Save input's metadata value from input source.
	 *
	 * Fields in group are looped through to save each input's metadata value.
	 *
	 * @since 2.0.0
	 *
	 * @param array $input Submitted data to search for relevant metadata value.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean True.
	 */
	public function saveValue($input = array(), $type = 'site', $objectId = null) {

		foreach($this->fields as $field) {
			$field->saveValue($input, $type, $objectId);
		}

		// additional custom field data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $this, $input, $type, $objectId, null);

		return true;

	}


	/**
	 * Restore the input's metadata value for a post from a revision.
	 *
	 * Fields in group are looped through to restore each input's metadata value.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID to restore metadata to.
	 * @param int $revisionId Revision ID to restore metadata from.
	 *
	 * @return boolean True.
	 */
	public function restoreValue($postId, $revisionId) {

		foreach($this->fields as $field) {
			$field->restoreValue($postId, $revisionId);
		}

		return true;

	}

}