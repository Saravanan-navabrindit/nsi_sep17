<?php
/**
 * Contains definition for \Crown\Form\FieldGroupSet class.
 */

namespace Crown\Form;


/**
 * Form field group set container class.
 *
 * Serves as a handler for form field group sets in the WordPress admin. A field group set object may contain
 * multiple field group objects to group them, visually, on various admin pages.
 *
 * @since 2.6.0
 */
class FieldGroupSet extends FieldGroup {

	/**
	 * Set Groups.
	 *
	 * @since 2.6.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $fieldGroups;

	/**
	 * Default field group set configuration options.
	 *
	 * @since 2.6.0
	 *
	 * @var array
	 */
	protected static $defaultFieldGroupSetArgs = array(
		'fieldGroups' => array()
	);


	/**
	 * Field object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.6.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __label__ - (string) Field label.
	 *    * __input__ - (\Crown\Form\Input\Input) Input object.
	 *    * __description__ - (string) Field description.
	 *    * __id__ - (string) Field element ID.
	 *    * __class__ - (string|string[]) Field element class.
	 *    * __atts__ - (array) Additional field element attributes.
	 *    * __fieldGroups__ - (\Crown\Form\FieldGroup[]) Set groups.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$fieldGroupSetArgs = array_merge($this::$defaultFieldGroupSetArgs, array_intersect_key($args, $this::$defaultFieldGroupSetArgs));

		// parse args into object variables
		$this->setFieldGroups($fieldGroupSetArgs['fieldGroups']);

	}


	/**
	 * Get field groups.
	 *
	 * @since 2.6.0
	 *
	 * @return \Crown\Form\FieldGroup[] Field Groups.
	 */
	public function getFieldGroups() {
		return $this->fieldGroups;
	}


	/**
	 * Set group fields.
	 *
	 * Overridden to disable fields getting assigned to field group directly.
	 *
	 * @since 2.6.0
	 *
	 * @param \Crown\Form\Field[] $fields Group fields.
	 */
	public function setFields($fields) {}


	/**
	 * Set field groups.
	 *
	 * @since 2.6.0
	 *
	 * @param \Crown\Form\FieldGroup[] $fieldGroups Field Groups.
	 */
	public function setFieldGroups($fieldGroups) {
		if(is_array($fieldGroups)) $this->fieldGroups = $fieldGroups;
	}


	/**
	 * Add field to group.
	 *
	 * Overridden to disable fields getting assigned to field group directly.
	 *
	 * @since 2.6.0
	 *
	 * @param \Crown\Form\Field $field New field.
	 */
	public function addField($field) {}


	/**
	 * Add group to set.
	 *
	 * @since 2.6.0
	 *
	 * @param \Crown\Form\FieldGroup $fieldGroup New field.
	 */
	public function addFieldGroup($fieldGroup) {
		$this->fieldGroups[] = $fieldGroup;
	}


	/**
	 * Get field output HTML.
	 *
	 * @since 2.6.0
	 *
	 * @used-by \Crown\Form\Field::output() during field output.
	 *
	 * @uses \Crown\Form\FieldGroupSet::getOutputAttributes() to build field element's attribute array.
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

		// make sure field groups are set
		if(empty($this->fieldGroups)) return '';

		// enqueue scripts
		wp_enqueue_script('crown-form-field-group-set');

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

		$activeGroup = 0;
		foreach($this->fieldGroups as $i => $fieldGroup) {
			$uIActive = $this->checkFieldGroupUIState($fieldGroup, $args['objectId']);
			if($i == $activeGroup && $uIActive) {
				break;
			}
			$activeGroup++;
		}

		ob_start();
		?>

			<<?php echo $fieldWrapTag; ?> <?php echo implode(' ', $fieldAtts); ?>>

				<?php echo $args['format'] == 'tr' ? '<'.$labelWrapTag.' class="label-wrap">' : ''; ?>

				<?php if(!empty($this->label)) { ?>
					<?php if($args['format'] == 'tr') { ?>
						<label <?php echo implode(' ', $labelAtts); ?>><?php echo $this->label; ?></label>
					<?php } else { ?>
						<?php /*<legend <?php echo implode(' ', $labelAtts); ?>><?php echo $this->label; ?></legend>*/ ?>
					<?php } ?>
				<?php } ?>

				<?php if(!empty($this->description)) { ?>
					<?php if($args['format'] == 'tr') { ?>
						<span <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></span>
					<?php } else { ?>
						<?php /*<p <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></p>*/ ?>
					<?php } ?>
				<?php } ?>

				<?php echo $args['format'] == 'tr' ? '</'.$labelWrapTag.'>' : ''; ?>

				<<?php echo $inputWrapTag; ?> class="input-wrap">
					<div class="group-set-wrap">

						<ul class="group-set-nav">
							<?php
								foreach($this->fieldGroups as $i => $fieldGroup) {
									$label = $fieldGroup->getLabel();
									if(empty($label)) $label = 'Option Set '.($i + 1);
									$uIActive = $this->checkFieldGroupUIState($fieldGroup, $args['objectId']);
									echo '<li class="'.($activeGroup == $i ? 'active' : '').' '.(!$uIActive ? 'disabled' : '').'"><a href="#">'.$label.'</a></li>';
								}
							?>
						</ul>
						
						<div class="group-set-field-groups">
							<?php
								foreach($this->fieldGroups as $i => $fieldGroup) {
									$uIActive = $this->checkFieldGroupUIState($fieldGroup, $args['objectId']);
									echo '<div class="group-set-field-group '.($activeGroup == $i ? 'active' : '').' '.(!$uIActive ? 'disabled' : '').'">';
									$fieldGroupArgs = array_merge($args, array('objectId' => $args['objectId'], 'format' => 'div'));
									$fieldGroup->output($fieldGroupArgs);
									echo '</div>';
								}
							?>
						</div>

					</div>
				</<?php echo $inputWrapTag; ?>>
				
			</<?php echo $fieldWrapTag; ?>>

		<?php
		$output = ob_get_clean();

		return $output;
	}


	/**
	 * Build list of field element's attributes.
	 *
	 * @since 2.6.0
	 *
	 * @used-by \Crown\Form\FieldGroupSet::getOutput() during field element HTML generation.
	 *
	 * @param int $objectId Optional. Relative object ID.
	 *
	 * @return array Associative array of field element attribute key-value pairs.
	 */
	protected function getOutputAttributes($objectId = null) {

		$class = array_merge(array('crown-field', 'group', 'group-set'), $this->class);

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
	 * Check if field group passes conditional UI rules.
	 *
	 * @since 2.6.0
	 *
	 * @param \Crown\Form\FieldGroup $fieldGroup Field group to assess.
	 * @param int $objectId Object ID to evaluate against
	 *
	 * @return boolean True on success, false on failure.
	 */
	protected function checkFieldGroupUIState($fieldGroup, $objectId = null) {
		$uIRules = $fieldGroup->getUIRules();
		if(empty($uIRules)) return true;
		foreach($uIRules as $uIRule) {
			$passed = $uIRule->evaluate($objectId);
			if(!$passed) return false;
		}
		return true;
	}


	/**
	 * Retrieve field groups' metadata values.
	 *
	 * Field groups in set are looped through to retrieve metadata values individually and returned
	 * as a single associative array with input name-value pairs.
	 *
	 * @since 2.6.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return array Input name-value pairs.
	 */
	public function getValue($type = 'site', $objectId = null) {

		$value = array();

		foreach($this->fieldGroups as $fieldGroup) {
			$fieldGroupValue = $fieldGroup->getValue($type, $objectId);
			if(!empty($fieldGroupValue)) $value = array_merge($value, $fieldGroupValue);
		}

		return $value;

	}


	/**
	 * Save input's metadata value from input source.
	 *
	 * Field groups in set are looped through to save each input's metadata value.
	 *
	 * @since 2.6.0
	 *
	 * @param array $input Submitted data to search for relevant metadata value.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean True.
	 */
	public function saveValue($input = array(), $type = 'site', $objectId = null) {

		foreach($this->fieldGroups as $fieldGroup) {
			$fieldGroup->saveValue($input, $type, $objectId);
		}

		// additional custom field data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $this, $input, $type, $objectId, null);

		return true;

	}


	/**
	 * Restore the input's metadata value for a post from a revision.
	 *
	 * Field groups in set are looped through to restore each input's metadata value.
	 *
	 * @since 2.6.0
	 *
	 * @param int $postId Post ID to restore metadata to.
	 * @param int $revisionId Revision ID to restore metadata from.
	 *
	 * @return boolean True.
	 */
	public function restoreValue($postId, $revisionId) {

		foreach($this->fieldGroups as $fieldGroup) {
			$fieldGroup->restoreValue($postId, $revisionId);
		}

		return true;

	}

}