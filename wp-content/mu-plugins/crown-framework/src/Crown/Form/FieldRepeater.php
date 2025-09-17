<?php
/**
 * Contains definition for \Crown\Form\FieldRepeater class.
 */

namespace Crown\Form;


/**
 * Form field group repeater class.
 *
 * Serves as a handler for form field repeater groups in the WordPress admin. A field repeater object may
 * contain multiple fields that can be duplicated to create multiple entries of data on various admin pages.
 *
 * @since 2.0.0
 */
class FieldRepeater extends FieldGroup {

	/**
	 * Repeater input basename.
	 *
	 * The repeater name is used to group all entries of a repeater field so they may be processed
	 * correctly when updating metadata.
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Label for add new entry button.
	 *
	 * @var string
	 */
	protected $addNewLabel;

	/**
	 * Title for single entry.
	 *
	 * @since 2.13.0
	 *
	 * @var string
	 */
	protected $entryTitle;

	/**
	 * Default field repeater configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultFieldRepeaterArgs = array(
		'name' => '',
		'addNewLabel' => 'Add New Entry',
		'entryTitle' => ''
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
	 *    * __name__ - (string) Repeater input basename.
	 *    * __addNewLabel__ - (string) Label for add new entry button.
	 *    * __entryTitle__ - (string) Title for single entry.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$fieldRepeaterArgs = array_merge($this::$defaultFieldRepeaterArgs, array_intersect_key($args, $this::$defaultFieldRepeaterArgs));

		// parse args into object variables
		$this->setName($fieldRepeaterArgs['name']);
		$this->setAddNewLabel($fieldRepeaterArgs['addNewLabel']);
		$this->setEntryTitle($fieldRepeaterArgs['entryTitle']);

	}


	/**
	 * Get repeater input basename.
	 *
	 * @since 2.0.0
	 *
	 * @return string Repeater input basename
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * Get label for add new entry button.
	 *
	 * @since 2.0.0
	 *
	 * @return string Add new entry button label.
	 */
	public function getAddNewLabel() {
		return $this->addNewLabel;
	}


	/**
	 * Get title for single entry.
	 *
	 * @since 2.13.0
	 *
	 * @return string Title for single entry.
	 */
	public function getEntryTitle() {
		return $this->entryTitle;
	}


	/**
	 * Set repeater input basename.
	 *
	 * @since 2.0.0
	 *
	 * @param string $name Repeater input basename.
	 */
	public function setName($name) {
		$this->name = $name;
	}


	/**
	 * Set label for add new entry button.
	 *
	 * @since 2.0.0
	 *
	 * @param string $addNewLabel Add new entry button label.
	 */
	public function setAddNewLabel($addNewLabel) {
		$this->addNewLabel = $addNewLabel;
	}


	/**
	 * Set title for single entry.
	 *
	 * @since 2.13.0
	 *
	 * @param string $entryTitle Title for single entry.
	 */
	public function setEntryTitle($entryTitle) {
		$this->entryTitle = $entryTitle;
	}


	/**
	 * Get the field repeater's input basename.
	 *
	 * @since 2.0.0
	 *
	 * @return string Input object's name.
	 */
	public function getInputName() {
		return !empty($this->name) ? $this->name : null;
	}


	/**
	 * Get field output HTML.
	 *
	 * @since 2.0.0
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

		// make sure name and fields are set
		if(empty($this->name)) return '';
		if(empty($this->fields)) return '';

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

					<div class="field-repeater-entries">

						<?php echo $this->getEntryOutput(array_merge($args, array('isTpl' => true, 'format' => 'div'))); ?>

						<?php foreach($args['value'] as $i => $entry) { ?>
							<?php echo $this->getEntryOutput(array_merge($args, array('entryIndex' => $i, 'value' => $entry, 'format' => 'div'))); ?>
						<?php } ?>

					</div>

					<button type="button" class="button add-field-repeater-entry"><?php echo $this->addNewLabel; ?></button>
					
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
	 * @used-by \Crown\Form\FieldRepeater::getOutput() during field element HTML generation.
	 *
	 * @param int $objectId Optional. Relative object ID.
	 *
	 * @return array Associative array of field element attribute key-value pairs.
	 */
	protected function getOutputAttributes($objectId = null) {

		$class = array_merge(array('crown-field', 'repeater'), $this->class);

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
	 * Generate HTML output for field repeater entry.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\FieldRepeater::getOutput() during field element HTML generation.
	 *
	 * @param array $args Optional. Field output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __objectId__ - (int) Relative object ID.
	 *    * __isTpl__ - (boolean) Whether field should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *    * __entryIndex__ - (int) Index of repeater entry.
	 *    * __format__ - (string) Field format type. Possible values: div|tr.
	 *
	 * @return string Entry output HTML.
	 */
	protected function getEntryOutput($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, array(
			'entryIndex' => 0,
			'entryId' => 0
		), $args);
		$args['entryId'] = array_key_exists('id', $args['value']) ? $args['value']['id'] : $args['entryId'];
		$output = '';

		$basename = !empty($args['basename']) ? $args['basename'].'['.$this->name.']' : $this->name;

		$output .= '<div class="entry field-count-'.count($this->fields).' '.($args['isTpl'] ? 'tpl' : '').'">';
		$output .= '<div class="add-field-repeater-entry-container before"><button type="button" class="button add-field-repeater-entry mid-list before">'.$this->addNewLabel.'</button></div>';
		$output .= '<div class="sort-handle"></div>';

		if(!empty($this->entryTitle)) {
			$output .= '<div class="entry-header"><button type="button" class="button-link collapse-toggle"></button> <h3>'.$this->entryTitle.'</h3></div>';
		}

		$output .= '<div class="entry-fields">';

		if($args['isTpl']) {
			$output .= '<input type="hidden" data-tpl-name="'.$basename.'[{{index}}][crown_repeater_entry_id]" value="'.$args['entryId'].'">';
		} else {
			$output .= '<input type="hidden" name="'.$basename.'[entry_'.$args['entryIndex'].'][crown_repeater_entry_id]" value="'.$args['entryId'].'">';
		}

		foreach($this->fields as $field) {
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
		$output .= '<div class="add-field-repeater-entry-container after"><button type="button" class="button add-field-repeater-entry mid-list after">'.$this->addNewLabel.'</button></div>';
		$output .= '</div>';

		return $output;
	}


	/**
	 * Retrieve fields' metadata values.
	 *
	 * Repeater entries are retrieved from the database and metadata for each field in repeater group
	 * is fetched. All metadata is returned in a single array of associative input name-value pair arrays.
	 *
	 * @since 2.0.0
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
			$entryValue = array('id' => $entryPost->ID);
			foreach($this->fields as $field) {
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
	 * @since 2.0.0
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

			// fetch all existing entry IDs
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
				foreach($this->fields as $field) {
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


	/**
	 * Restore the input's metadata value for a post from a revision.
	 *
	 * All existing entries are first deleted from the post and are replaced by copies of the repeater
	 * entries from the revision.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID to restore metadata to.
	 * @param int $revisionId Revision ID to restore metadata from.
	 *
	 * @return boolean True.
	 */
	public function restoreValue($postId, $revisionId) {
		if(empty($this->name)) return false;
		global $wpdb;

		// retrieve post revision's entries
		$revisionEntries = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'post_parent' => $revisionId,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => 'post'
				),
				array(
					'key' => 'crown_repeater_entry_name',
					'value' => $this->name
				)
			)
		));

		// fetch all existing entry IDs
		$postEntryIds = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'post_parent' => $postId,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_status' => array('any', 'trash'),
			'fields' => 'ids',
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => 'post'
				),
				array(
					'key' => 'crown_repeater_entry_name',
					'value' => $this->name
				)
			)
		));

		// transfer revision's entry data to post
		$entryIds = array();
		foreach($revisionEntries as $entry) {
			$entryArgs = array(
				'post_status' => 'publish',
				'post_type' => 'crown_repeater_entry',
				'menu_order' => $entry->menu_order,
				'post_parent' => $postId
			);
			$entryMeta = get_post_meta($entry->ID);
			$entryId = 0;
			// print_r($entryMeta); die;
			$storedEntryId = isset($entryMeta['crown_repeater_entry_id']) && isset($entryMeta['crown_repeater_entry_id'][0]) ? $entryMeta['crown_repeater_entry_id'][0] : 0;
			if(!empty($storedEntryId) && in_array($storedEntryId, $postEntryIds)) {
				$entryArgs['ID'] = $storedEntryId;
				$entryId = wp_update_post($entryArgs);
				$postMetaIds = $wpdb->get_col($wpdb->prepare("SELECT meta_id FROM $wpdb->postmeta WHERE post_id = %d", $entryId));
				foreach($postMetaIds as $mid) delete_metadata_by_mid('post', $mid);
			} else {
				$entryId = wp_insert_post($entryArgs);
			}
			$entryMeta['crown_repeater_entry_id'] = array($entryId);
			foreach($entryMeta as $key => $values) {
				foreach($values as $value) {
					add_post_meta($entryId, $key, $value);
				}
			}
			$entryIds[] = $entryId;
		}

		// delete leftover entries
		$leftoverEntryIds = array_diff($postEntryIds, $entryIds);
		foreach($leftoverEntryIds as $leftoverEntryId) {
			wp_trash_post($leftoverEntryId);
		}

		return true;

	}

}