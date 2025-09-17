<?php
/**
 * Contains definition for \Crown\Form\FieldRepeaterFlex class.
 */

namespace Crown\Form;


/**
 * Form flexible field group repeater class.
 *
 * Serves as a handler for form field repeater groups that allow for varying
 * types in the WordPress admin. A field repeater object may contain multiple
 * fields that can be duplicated to create multiple entries of data on various
 * admin pages.
 *
 * @since 2.4.0
 */
class FieldRepeaterFlex extends FieldRepeater {

	/**
	 * Flex repeater types.
	 *
	 * @since 2.4.0
	 *
	 * @var array
	 */
	protected $types;

	/**
	 * Default field repeater configuration options.
	 *
	 * @since 2.4.0
	 *
	 * @var array
	 */
	protected static $defaultFieldRepeaterFlexArgs = array(
		'types' => array()
	);


	/**
	 * Field object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.4.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __label__ - (string) Field label.
	 *    * __input__ - (\Crown\Form\Input\Input) Input object.
	 *    * __description__ - (string) Field description.
	 *    * __id__ - (string) Field element ID.
	 *    * __class__ - (string|string[]) Field element class.
	 *    * __atts__ - (array) Additional field element attributes.
	 *    * __fields__ - (\Crown\Form\Field[]) Group fields.
	 *    * __name__ - (string) Repeater input basename.
	 *    * __addNewLabel__ - (string) Label for add new entry button.
	 *    * __types__ - (array) Repeater types.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$fieldRepeaterFlexArgs = array_merge($this::$defaultFieldRepeaterFlexArgs, array_intersect_key($args, $this::$defaultFieldRepeaterFlexArgs));

		// parse args into object variables
		$this->setTypes($fieldRepeaterFlexArgs['types']);

	}


	/**
	 * Get flex repeater types.
	 *
	 * @since 2.4.0
	 *
	 * @return array Repeater types.
	 */
	public function getTypes() {
		return $this->types;
	}


	/**
	 * Set flex repeater types.
	 *
	 * @since 2.4.0
	 *
	 * @param array $types Repeater types.
	 */
	public function setTypes($types) {
		if(is_array($types)) {
			$this->types = array();
			foreach($types as $typeConfig) {
				$this->addType($typeConfig);
			}
		}
	}


	/**
	 * Add flex repeater type.
	 *
	 * @since 2.4.0
	 *
	 * @param array $typeConfig Repeater type configuration.
	 */
	public function addType($typeConfig) {
		if(!is_array($typeConfig)) return;

		$type = (object)array_merge(array(
			'name' => '',
			'slug' => '',
			'fields' => array()
		), $typeConfig);

		if(empty($type->name)) {
			$type->name = 'Entry';
		}

		if(empty($type->slug)) {
			$type->slug = sanitize_title($type->name);
		}

		// make sure there aren't already any types with the same slug
		$existingTypes = $this->getTypes();
		if(array_key_exists($type->slug, $existingTypes)) return;

		$this->types[$type->slug] = $type;
	}


	/**
	 * Get field output HTML.
	 *
	 * @since 2.4.0
	 *
	 * @used-by \Crown\Form\Field::output() during field output.
	 *
	 * @uses \Crown\Form\FieldRepeater::getOutputAttributes() to build field element's attribute array.
	 * @uses \Crown\Form\Field::convertHtmlAttributes() to convert an associative arrays into HTML element attributes.
	 * @uses \Crown\Form\FieldRepeater::getEntryOutput() to generate HTML for repeater entries.
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

		// make sure name and types are set
		if(empty($this->name)) return '';
		if(empty($this->types)) return '';

		// enqueue scripts
		wp_enqueue_script('crown-form-field-repeater');

		// get attribute array
		$fieldAtts = $this->convertHtmlAttributes($this->getOutputAttributes($args['objectId']));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array());

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
							<?php if($args['format'] == 'tr') { ?>
								<span <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></span>
							<?php } else { ?>
								<p <?php echo implode(' ', $descriptionAtts); ?>><?php echo $this->description; ?></p>
							<?php } ?>
						<?php } ?>

					</<?php echo $labelWrapTag; ?>>
				<?php } ?>

				<<?php echo $inputWrapTag; ?> class="input-wrap">

					<div class="field-repeater-entry-controls">
						<ul class="actions">
							<li><a href="#" class="collapse-expand">Collapse/Expand All</a></li>
						</ul>
					</div>

					<div class="field-repeater-entries">
						
						<?php foreach($this->types as $type) { ?>
							<?php echo $this->getEntryOutput(array_merge($args, array('isTpl' => true, 'format' => 'div', 'type' => $type->slug))); ?>
						<?php } ?>

						<?php foreach($args['value'] as $i => $entry) { ?>
							<?php $entryType = isset($entry['crown_repeater_entry_type']) ? $entry['crown_repeater_entry_type'] : ''; ?>
							<?php if(array_key_exists($entryType, $this->types)) { ?>
								<?php echo $this->getEntryOutput(array_merge($args, array('entryIndex' => $i, 'value' => $entry, 'format' => 'div', 'type' => $entryType))); ?>
							<?php } ?>
						<?php } ?>

					</div>
					
					<div class="add-flex-field-repeater-entry-options">
						<button type="button" class="button dropdown-toggle">Add new...</button>
						<div class="dropdown-wrap">
							<div class="dropdown">
								<ul class="options">
									<?php foreach($this->types as $type) { ?>
										<li><a href="#" data-entry-type="<?php echo $type->slug; ?>"><?php echo $type->name; ?></a></li>
									<?php } ?>
								</ul>
							</div>
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
	 * @since 2.4.0
	 *
	 * @used-by \Crown\Form\FieldRepeaterFlex::getOutput() during field element HTML generation.
	 *
	 * @param int $objectId Optional. Relative object ID.
	 *
	 * @return array Associative array of field element attribute key-value pairs.
	 */
	protected function getOutputAttributes($objectId = null) {

		$class = array_merge(array('crown-field', 'repeater', 'flex-repeater'), $this->class);

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
	 * Generate HTML output for flex field repeater entry.
	 *
	 * @since 2.4.0
	 *
	 * @used-by \Crown\Form\FieldRepeaterFlex::getOutput() during field element HTML generation.
	 *
	 * @param array $args Optional. Field output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __objectId__ - (int) Relative object ID.
	 *    * __isTpl__ - (boolean) Whether field should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *    * __entryIndex__ - (int) Index of repeater entry.
	 *    * __format__ - (string) Field format type. Possible values: div|tr.
	 *    * __type__ - (string) Slug of type to generate output for.
	 *
	 * @return string Entry output HTML.
	 */
	protected function getEntryOutput($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, array(
			'entryIndex' => 0,
			'entryId' => 0,
			'type' => ''
		), $args);
		$args['entryId'] = array_key_exists('id', $args['value']) ? $args['value']['id'] : $args['entryId'];
		$output = '';

		$type = array_key_exists($args['type'], $this->types) ? $this->types[$args['type']] : null;
		if(!$type) return $output;
		if(empty($type->fields)) return $output;

		$basename = !empty($args['basename']) ? $args['basename'].'['.$this->name.']' : $this->name;
		
		$output .= '<div class="entry field-count-'.count($type->fields).' '.($args['isTpl'] ? 'tpl' : '').' type-'.$type->slug.'">';
		$output .= '<div class="add-field-repeater-entry-container before"></div>';
		$output .= '<div class="sort-handle"></div>';

		$output .= '<div class="entry-header"><button type="button" class="button-link collapse-toggle"></button> <h3>'.$type->name.'</h3></div>';

		$output .= '<div class="entry-fields">';

		if($args['isTpl']) {
			$output .= '<input type="hidden" data-tpl-name="'.$basename.'[{{index}}][crown_repeater_entry_id]" value="'.$args['entryId'].'">';
			$output .= '<input type="hidden" data-tpl-name="'.$basename.'[{{index}}][crown_repeater_entry_type]" value="'.$type->slug.'">';
		} else {
			$output .= '<input type="hidden" name="'.$basename.'[entry_'.$args['entryIndex'].'][crown_repeater_entry_id]" value="'.$args['entryId'].'">';
			$output .= '<input type="hidden" name="'.$basename.'[entry_'.$args['entryIndex'].'][crown_repeater_entry_type]" value="'.$type->slug.'">';
		}

		foreach($type->fields as $field) {
			if($args['isTpl']) {

				// output template field
				$output .= $field->getOutput(array('objectId' => $args['objectId'], 'basename' => $basename.'[{{index}}]', 'isTpl' => true));

			} else {

				// output entry field
				$fieldInputName = $field->getInputName();
				$fieldValue = !empty($fieldInputName) && array_key_exists($fieldInputName, $args['value']) ? $args['value'][$fieldInputName] : $args['value'];
				$output .= $field->getOutput(array_merge($args, array(
					'basename' => $basename.'[entry_'.$args['entryIndex'].']',
					'value' => $fieldValue
				)));
				
			}
		}

		$output .= '</div>';

		$output .= '<button type="button" class="button remove-field-repeater-entry" title="Remove">&times;</button>';
		$output .= '<div class="add-field-repeater-entry-container after"></div>';
		$output .= '</div>';

		return $output;
	}


	/**
	 * Retrieve fields' metadata values.
	 *
	 * Repeater entries are retrieved from the database and metadata for each field in repeater group
	 * is fetched. All metadata is returned in a single array of associative input name-value pair arrays.
	 *
	 * @since 2.4.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return array Input name-value pairs.
	 */
	public function getValue($type = 'site', $objectId = null) {
		if(empty($this->name)) return array();

		// fetch all entries
		$entryQueryArgs = array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => $type
				),
				array(
					'key' => 'crown_repeater_entry_name',
					'value' => $this->name
				)
			)
		);
		if(!in_array($type, array('site, blog'))) {
			$entryQueryArgs['post_parent'] = $objectId;
		}
		$entries = get_posts($entryQueryArgs);

		$value = array();

		// fetch metadata for each entry
		foreach($entries as $entryPost) {
			$entryType = get_post_meta($entryPost->ID, 'crown_repeater_entry_type', true);
			if(!array_key_exists($entryType, $this->types)) continue;
			$entryValue = array(
				'id' => $entryPost->ID,
				'crown_repeater_entry_type' => $entryType
			);
			foreach($this->types[$entryType]->fields as $field) {
				$fieldInputName = $field->getInputName();
				if(!empty($fieldInputName)) {
					// single field
					$entryValue[$fieldInputName] = $field->getValue('post', $entryPost->ID);
				} else {
					// multiple fields
					$fieldValue = $field->getValue('post', $entryPost->ID);
					if(!empty($fieldValue)) $entryValue = array_merge($entryValue, $fieldValue);
				}
			}
			$value[] = $entryValue;
		}

		return $value;

	}


	/**
	 * Save input's metadata value from input source.
	 *
	 * All existing entries are first deleted and the new ones are saved for the object. Repeater
	 * entries are stored as posts, with the type of 'crown_repeater_entry', along with the metadata
	 * for each entry.
	 *
	 * @since 2.4.0
	 *
	 * @param array $input Submitted data to search for relevant metadata value.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean True.
	 */
	public function saveValue($input = array(), $type = 'site', $objectId = null) {

		$entryIds = array();
		
		if(!empty($this->name)) {

			// remove all existing entries
			$entryQueryArgs = array(
				'posts_per_page' => -1,
				'post_type' => 'crown_repeater_entry',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'fields' => 'ids',
				'meta_query' => array(
					array(
						'key' => 'crown_repeater_entry_object_type',
						'value' => $type
					),
					array(
						'key' => 'crown_repeater_entry_name',
						'value' => $this->name
					)
				)
			);
			if(!in_array($type, array('site, blog'))) {
				$entryQueryArgs['post_parent'] = $objectId;
			}
			$existingEntryIds = get_posts($entryQueryArgs);

			// retrieve entries from input data if set
			$entries = isset($input[$this->name]) ? $input[$this->name] : array();

			// add each entry to database
			$entryIndex = 0;
			foreach($entries as $entryValue) {
				$entryType = isset($entryValue['crown_repeater_entry_type']) ? $entryValue['crown_repeater_entry_type'] : '';
				if(!array_key_exists($entryType, $this->types)) continue;
				$entryArgs = array(
					'post_status' => 'publish',
					'post_type' => 'crown_repeater_entry',
					'menu_order' => $entryIndex
				);
				if(!in_array($type, array('site, blog'))) {
					$entryArgs['post_parent'] = $objectId;
				}
				$entryId = 0;
				$passedEntryId = isset($entryValue['crown_repeater_entry_id']) ? $entryValue['crown_repeater_entry_id'] : 0;
				if(!wp_is_post_revision($objectId) && !empty($passedEntryId) && in_array($passedEntryId, $existingEntryIds)) {
					$entryArgs['ID'] = $passedEntryId;
					$entryId = wp_update_post($entryArgs);
				} else {
					$entryId = wp_insert_post($entryArgs);
				}
				$storedEntryId = !empty($passedEntryId) && (in_array($passedEntryId, $existingEntryIds) || wp_is_post_revision($objectId)) ? $passedEntryId : $entryId;
				update_post_meta($entryId, 'crown_repeater_entry_id', $storedEntryId);
				update_post_meta($entryId, 'crown_repeater_entry_object_type', $type);
				update_post_meta($entryId, 'crown_repeater_entry_name', $this->name);
				update_post_meta($entryId, 'crown_repeater_entry_type', $entryValue['crown_repeater_entry_type']);
				foreach($this->types[$entryType]->fields as $field) {
					$field->saveValue($entryValue, 'post', $entryId);
				}
				$entryIds[] = $entryId;
				$entryIndex++;
			}

			// delete leftover entries
			$leftoverEntryIds = array_diff($existingEntryIds, $entryIds);
			foreach($leftoverEntryIds as $leftoverEntryId) {
				wp_trash_post($leftoverEntryId);
			}

		}

		// additional custom field data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $this, $input, $type, $objectId, $entryIds);

		return true;

	}


}