<?php
/**
 * Contains definition for \Crown\Form\FieldTable class.
 */

namespace Crown\Form;


/**
 * Form field table class.
 *
 * Serves as a handler for form field tables in the WordPress admin. A field table object may contain
 * multiple fields for columns, rows, and cells that can be use to create multiple entries of data within
 * the table on various admin pages.
 *
 * @since 2.13.0
 */
class FieldTable extends FieldRepeater {

	/**
	 * Table column fields.
	 *
	 * @since 2.13.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $columnFields;

	/**
	 * Table row fields.
	 *
	 * @since 2.13.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $rowFields;

	/**
	 * Table cell fields.
	 *
	 * @since 2.13.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $cellFields;

	/**
	 * Cell fields UI rules.
	 * 
	 * @since 2.13.7
	 *
	 * @var \Crown\UIRule[]
	 */
	protected $cellFieldsUIRules;

	/**
	 * Default field table configuration options.
	 *
	 * @since 2.13.0
	 *
	 * @var array
	 */
	protected static $defaultFieldTableArgs = array(
		'columnFields' => array(),
		'rowFields' => array(),
		'cellFields' => array(),
		'cellFieldsUIRules' => array()
	);


	/**
	 * Field object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.13.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __id__ - (string) Field element ID.
	 *    * __class__ - (string|string[]) Field element class.
	 *    * __atts__ - (array) Additional field element attributes.
	 *    * __name__ - (string) Table input basename.
	 *    * __columnFields__ - (\Crown\Form\Field[]) Column fields.
	 *    * __rowFields__ - (\Crown\Form\Field[]) Row fields.
	 *    * __cellFields__ - (\Crown\Form\Field[]) Cell fields.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// merge options with defaults
		$fieldTableArgs = array_merge($this::$defaultFieldTableArgs, array_intersect_key($args, $this::$defaultFieldTableArgs));

		// parse args into object variables
		$this->setColumnFields($fieldTableArgs['columnFields']);
		$this->setRowFields($fieldTableArgs['rowFields']);
		$this->setCellFields($fieldTableArgs['cellFields']);
		$this->setCellFieldsUIRules($fieldTableArgs['cellFieldsUIRules']);

	}


	/**
	 * Get column fields.
	 *
	 * @since 2.13.0
	 *
	 * @return \Crown\Form\Field[] Column fields.
	 */
	public function getColumnFields() {
		return $this->columnFields;
	}


	/**
	 * Get row fields.
	 *
	 * @since 2.13.0
	 *
	 * @return \Crown\Form\Field[] Row fields.
	 */
	public function getRowFields() {
		return $this->rowFields;
	}


	/**
	 * Get cell fields.
	 *
	 * @since 2.13.0
	 *
	 * @return \Crown\Form\Field[] Cell fields.
	 */
	public function getCellFields() {
		return $this->cellFields;
	}


	/**
	 * Get cell fields UI rules.
	 * 
	 * @since 2.13.7
	 *
	 * @return \Crown\UIRule[] Cell fields UI rules.
	 */
	public function getCellFieldsUIRules() {
		return $this->cellFieldsUIRules;
	}


	/**
	 * Set column fields.
	 *
	 * @since 2.13.0
	 *
	 * @param \Crown\Form\Field[] $fields Column fields.
	 */
	public function setColumnFields($columnFields) {
		if(is_array($columnFields)) $this->columnFields = $columnFields;
	}


	/**
	 * Set row fields.
	 *
	 * @since 2.13.0
	 *
	 * @param \Crown\Form\Field[] $fields Row fields.
	 */
	public function setRowFields($rowFields) {
		if(is_array($rowFields)) $this->rowFields = $rowFields;
	}


	/**
	 * Set cell fields.
	 *
	 * @since 2.13.0
	 *
	 * @param \Crown\Form\Field[] $fields Cell fields.
	 */
	public function setCellFields($cellFields) {
		if(is_array($cellFields)) $this->cellFields = $cellFields;
	}


	/**
	 * Set cell fields UI rules.
	 *
	 * @since 2.13.7
	 * 
	 * @param \Crown\UIRule[] $cellFieldsUIRules Cell fields UI rules
	 */
	public function setCellFieldsUIRules($cellFieldsUIRules) {
		if(is_array($cellFieldsUIRules)) $this->cellFieldsUIRules = $cellFieldsUIRules;
	}


	/**
	 * Get field output HTML.
	 *
	 * @since 2.13.0
	 *
	 * @used-by \Crown\Form\Field::output() during field output.
	 *
	 * @param array $args Optional. Field output options. Possible arguments:
	 *    * __value__ - (array) Input element value.
	 *    * __objectId__ - (int) Relative object ID.
	 *    * __isTpl__ - (boolean) Whether field should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *    * __format__ - (string) Field format type. Possible values: div|tr. By default, outputs as div element.
	 *
	 * @return string Output HTML.
	 */
	public function getOutput($args = array()) {

		// merge options with defaults
		$args = array_merge($this::$defaultOutputArgs, array('value' => (object)array('rows' => array(), 'columns' => array())), $args);

		// use custom field output, if applicable
		if(is_callable($this->getOutputCb) && ($output = call_user_func_array($this->getOutputCb, array($this, &$args)))) {
			return $output;	
		}

		// make sure cell fields are set
		if(empty($this->name)) return '';
		if(empty($this->cellFields)) return '';

		// enqueue scripts
		wp_enqueue_script('crown-form-field-table');

		$args['value'] = array(
			$this->name.'_rows' => $args['value']->rows,
			$this->name.'_columns' => $args['value']->columns
		);

		$fieldGroupSet = new FieldGroupSet(array(
			'id' => $this->id,
			'class' => array_merge($this->class, array('field-table')),
			'atts' => array_merge($this->atts, array('data-initial-value' => json_encode($args['value']))),
			'fieldGroups' => array(
				new FieldGroup(array(
					'label' => 'Rows',
					'fields' => array(
						new FieldRepeater(array(
							'name' => $this->name.'_rows',
							'addNewLabel' => 'Add New Row',
							'class' => 'field-table-rows',
							'fields' => array_merge(array(
								new Field(array(
									'input' => new Input\Text(array('name' => 'title', 'placeholder' => 'Row Title', 'class' => 'input-large'))
								))
							), $this->rowFields, array(
								new FieldRepeater(array(
									'name' => 'cells',
									'class' => 'field-table-cells',
									'uIRules' => $this->cellFieldsUIRules,
									'fields' => array(
										new FieldGroup(array(
											'label' => 'Column Title',
											'fields' => $this->cellFields
										))
									)
								))
							))
						))
					)
				)),
				new FieldGroup(array(
					'label' => 'Columns',
					'fields' => array(
						new FieldRepeater(array(
							'name' => $this->name.'_columns',
							'addNewLabel' => 'Define New Column',
							'class' => 'field-table-columns',
							'fields' => array_merge(array(
								new Field(array(
									'input' => new Input\Text(array('name' => 'title', 'placeholder' => 'Column Title', 'class' => 'input-large field-table-column-title-input'))
								))
							), $this->columnFields)
						))
					)
				))
			)
		));

		$output = $fieldGroupSet->getOutput($args);

		return $output;
	}


	/**
	 * Retrieve fields' metadata values.
	 *
	 * @since 2.13.0
	 *
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, retrieves site metadata.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return object Input value.
	 */
	public function getValue($type = 'site', $objectId = null) {

		$defaultValue = (object)array(
			'columns' => array(),
			'rows' => array()
		);
		
		// make sure name is set
		if(empty($this->name)) return false;

		// check against allowed meta types
		if(!in_array($type, array('site', 'blog', 'post', 'user', 'term'))) return false;

		// if site meta, update site option value
		if($type == 'site') {
			return $this->sanitizeValue(get_site_option($this->name, $defaultValue));
		}

		// if site meta, update site option value
		if($type == 'blog') {
			return $this->sanitizeValue(get_option($this->name, $defaultValue));
		}

		// retrieve object meta value
		$value = get_metadata($type, $objectId, $this->name, true);

		return $this->sanitizeValue($value);

	}


	/**
	 * Sanitizes the field value.
	 *
	 * This function ensures that the value for the field is an array that contains metadata for its
	 * rows, columns, and cells.
	 *
	 * @since 2.13.0
	 *
	 * @param mixed $value The value to be sanitized.
	 *
	 * @return object Sanitized field value.
	 */
	protected function sanitizeValue($value) {
		$value = (object)$value;

		$saniValue = (object)array(
			'columns' => array(),
			'rows' => array()
		);

		if(property_exists($value, 'columns') && is_array($value->columns)) {
			$saniValue->columns = array_map(function($column) {
				$defaultValues = array('title' => '');
				foreach($this->columnFields as $field) {
					$fieldInputName = $field->getInputName();
					if(!empty($fieldInputName)) {
						$defaultValues[$fieldInputName] = $field->getValue(null);
					} else {
						$fieldValue = $field->getValue(null);
						if(!empty($fieldValue)) $defaultValues = array_merge($defaultValues, $fieldValue);
					}
				}
				$column = array_merge($defaultValues, $column);
				return $column;
			}, $value->columns);
		}

		if(property_exists($value, 'rows') && is_array($value->rows)) {
			$saniValue->rows = array_map(function($row) {
				$defaultValues = array('title' => '', 'cells' => array());
				foreach($this->rowFields as $field) {
					$fieldInputName = $field->getInputName();
					if(!empty($fieldInputName)) {
						$defaultValues[$fieldInputName] = $field->getValue(null);
					} else {
						$fieldValue = $field->getValue(null);
						if(!empty($fieldValue)) $defaultValues = array_merge($defaultValues, $fieldValue);
					}
				}
				$row = array_merge($defaultValues, $row);
				return $row;
			}, $value->rows);
		}

		return $saniValue;
	}


	/**
	 * Update field's metadata value.
	 *
	 * The value for the field for the current context is updated according to the passed in value.
	 * The metadata key corresponds to field object's name.
	 *
	 * @since 2.13.0
	 *
	 * @param mixed $value Metadata value. Must be serializable if non-scalar.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return int|bool Metadata ID if the key didn't exist, true on successful update, false on failure.
	 */
	public function setValue($value = '', $type = 'site', $objectId = null) {

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
		return update_metadata($type, $objectId, $this->name, $value);

	}


	/**
	 * Save field's metadata value from input source.
	 *
	 * The relevant data from the input array is extracted and used to update
	 * the field's input's metadata value.
	 *
	 * @since 2.13.0
	 *
	 * @param array $input Submitted data to search for relevant metadata value.
	 * @param string $type Optional. Metadata's object type. Available options: site|blog|post|user|term. By default, updates site metadata value.
	 * @param int $objectId Optional. Object ID, if applicable.
	 *
	 * @return boolean True.
	 */
	public function saveValue($input = array(), $type = 'site', $objectId = null) {
		
		$value = (object)array(
			'columns' => array(),
			'rows' => array()
		);

		if(!empty($this->name)) {

			$columnsInput = isset($input[$this->name.'_columns']) ? $input[$this->name.'_columns'] : array();
			$value->columns = array_values(array_map(function($column) {
				unset($column['crown_repeater_entry_id']);
				return $column;
			}, $columnsInput));

			$rowsInput = isset($input[$this->name.'_rows']) ? $input[$this->name.'_rows'] : array();
			$value->rows = array_values(array_map(function($row) {
				unset($row['crown_repeater_entry_id']);
				$row['cells'] = array_values(array_map(function($cell) {
					unset($cell['crown_repeater_entry_id']);
					return $cell;
				}, $row['cells']));
				return $row;
			}, $rowsInput));

		}

		$result = $this->setValue($value, $type, $objectId);

		// additional custom field data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $this, $input, $type, $objectId, $value);

		return $result;

	}


	/**
	 * Restore the field's metadata value for a post from a revision.
	 *
	 * The value for the field object for the current context is transferred
	 * from the revision. The metadata key corresponds to field object's name.
	 *
	 * @since 2.13.0
	 *
	 * @param int $postId Post ID to restore metadata to.
	 * @param int $revisionId Revision ID to restore metadata from.
	 *
	 * @return boolean True on success, false on failure.
	 */
	public function restoreValue($postId, $revisionId) {

		// make sure name is set
		if(empty($this->name)) return false;

		// retrieve post revision's meta value
		$revisionValue = $this->getValue('post', $revisionId);

		// update meta values
		$this->setValue($revisionValue, 'post', $postId);

		return true;

	}


}