<?php
/**
 * Contains definition for \Crown\UserSettings class.
 */

namespace Crown;


/**
 * User settings section configuration class.
 *
 * Serves as a handler for user settings sections in WordPress. Sections are
 * appended after 'About the User' section.
 *
 * @since 2.10.0
 */
class UserSettings {

	/**
	 * Section title.
	 *
	 * @since 2.10.0
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * User capability restriction.
	 *
	 * @since 2.10.0
	 *
	 * @var string
	 */
	protected $capability;
	
	/**
	 * Section position.
	 *
	 * @since 2.10.0
	 *
	 * @var int
	 */
	protected $position;

	/**
	 * Section fields.
	 *
	 * @since 2.10.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $fields;

	/**
	 * Columns that appear in the admin's user list table.
	 *
	 * @since 2.10.0
	 *
	 * @var \Crown\ListTableColumn[]
	 */
	protected $listTableColumns;

	/**
	 * Default user settings configuration options.
	 *
	 * @since 2.10.0
	 *
	 * @var array
	 */
	protected static $defaultUserSettingsArgs = array(
		'title' => '',
		'capability' => 'read',
		'position' => 10,
		'fields' => array(),
		'listTableColumns' => array()
	);


	/**
	 * User settings object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.10.0
	 *
	 * @param array $args Optional. Page configuration options. Possible arguments:
	 *    * __title__ - (string) Section title.
	 *    * __capability__ - (string) User capability restriction.
	 *    * __position__ - (int) Section position.
	 *    * __fields__ - (\Crown\Form\Field[]) Section fields.
	 *    * __listTableColumns__ - (\Crown\ListTableColumn[]) Columns that appear in the admin's user list table.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$userSettingsArgs = array_merge($this::$defaultUserSettingsArgs, array_intersect_key($args, $this::$defaultUserSettingsArgs));

		// parse args into object variables
		$this->setTitle($userSettingsArgs['title']);
		$this->setCapability($userSettingsArgs['capability']);
		$this->setPosition($userSettingsArgs['position']);
		$this->setFields($userSettingsArgs['fields']);
		$this->setListTableColumns($userSettingsArgs['listTableColumns']);

		// user meta hooks
		add_action('show_user_profile', array(&$this, 'outputFields'));
		add_action('edit_user_profile', array(&$this, 'outputFields'));
		add_action('personal_options_update', array(&$this, 'saveMeta'));
		add_action('edit_user_profile_update', array(&$this, 'saveMeta'));

		// user list table column hooks
		add_filter('manage_users_columns', array(&$this, 'registerListTableColumns'));
		add_filter('manage_users_custom_column', array(&$this, 'outputListTableColumn'), 10, 3);

	}


	/**
	 * Get section title.
	 *
	 * @since 2.10.0
	 *
	 * @return string Page title.
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * Get user capability restriction.
	 *
	 * @since 2.10.0
	 *
	 * @return string User capability restriction.
	 */
	public function getCapability() {
		return $this->capability;
	}


	/**
	 * Get section position.
	 *
	 * @since 2.10.0
	 *
	 * @return int Section position.
	 */
	public function getPosition() {
		return $this->position;
	}


	/**
	 * Get section fields.
	 *
	 * @since 2.10.0
	 *
	 * @return \Crown\Form\Field[] Section fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Get columns that appear in the admin's user list table.
	 *
	 * @since 2.10.0
	 *
	 * @return \Crown\ListTableColumn[] User columns.
	 */
	public function getListTableColumns() {
		return $this->listTableColumns;
	}


	/**
	 * Set section title.
	 *
	 * @since 2.10.0
	 *
	 * @param string $title Section title.
	 */
	public function setTitle($title) {
		$this->title = $title;
	}


	/**
	 * Set user capability restriction.
	 *
	 * @since 2.10.0
	 *
	 * @param string $capability User capability restriction.
	 */
	public function setCapability($capability) {
		$this->capability = $capability;
	}


	/**
	 * Set section position.
	 *
	 * @since 2.10.0
	 *
	 * @param int $position Section position.
	 */
	public function setPosition($position) {
		$this->position = intval($position);
	}


	/**
	 * Set section fields.
	 *
	 * @since 2.10.0
	 *
	 * @param \Crown\Form\Field[] $fields Section fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Set columns that appear in the admin's user list table.
	 *
	 * @since 2.10.0
	 *
	 * @param \Crown\ListTableColumn[] $listTableColumns User columns.
	 */
	public function setListTableColumns($listTableColumns) {
		if(is_array($listTableColumns)) $this->listTableColumns = $listTableColumns;
	}


	/**
	 * Add section field.
	 *
	 * @since 2.10.0
	 *
	 * @param \Crown\Form\Field $field Section field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Add list table column to users.
	 *
	 * @since 2.10.0
	 *
	 * @param \Crown\ListTableColumn $listTableColumn New list table column.
	 */
	public function addListTableColumn($listTableColumn) {
		$this->listTableColumns[] = $listTableColumns;
	}


	/**
	 * Output the section's fields.
	 *
	 * **Automatically registered on the `show_user_profile` and
	 * `edit_user_profile` action hooks.**
	 *
	 * The fields added to the `$field` property are output, along with a nonce
	 * field to be verified upon submission.
	 *
	 * @since 2.10.0
	 *
	 * @param \WP_User $profileUser The WP_User object of the current profile.
	 */
	public function outputFields($profileUser) {

		// make sure current user has capability
		if(!current_user_can($this->capability)) return;

		// output section title
		if(!empty($this->title)) {
			echo '<h3>'.$this->title.'</h3>';
		}

		// add nonce field
		wp_nonce_field('crown_save_user_settings_'.sanitize_title($this->title), 'nonce_user_settings_'.sanitize_title($this->title));

		echo '<table class="form-table">';
		echo '<tbody>';

		// output section fields
		foreach($this->fields as $field) {
			$fieldValue = $field->getValue('user', $profileUser->ID);
			$field->output(array('value' => $fieldValue, 'objectId' => $profileUser->ID, 'format' => 'tr'));
		}

		echo '</tbody>';
		echo '</table>';

	}


	/**
	 * Save a user's metadata associated with the section fields.
	 *
	 * **Automatically registered on the `personal_options_update` and
	 * `edit_user_profile_update` action hooks.**
	 *
	 * Meta data to be saved is collected from `$_POST` array. A nonce field is
	 * verified before saving to the database.
	 *
	 * Only data associated with the fields registered to the `UserSettings`
	 * object will be affected.
	 *
	 * @since 2.10.0
	 *
	 * @param int $userId User ID.
	 */
	public function saveMeta($userId) {

		if(isset($GLOBALS['crown_save_lock']) && $GLOBALS['crown_save_lock']) return $termId;

		// make sure current user has capability
		if(!current_user_can($this->capability)) return;

		// verify nonce field
		if(!isset($_POST['nonce_user_settings_'.sanitize_title($this->title)]) || !wp_verify_nonce($_POST['nonce_user_settings_'.sanitize_title($this->title)], 'crown_save_user_settings_'.sanitize_title($this->title))) return $termId;

		$input = $_POST;

		// enable save lock to prevent endless loops
		$GLOBALS['crown_save_lock'] = true;

		// save section's fields' meta data
		foreach($this->fields as $field) {
			$field->saveValue($input, 'user', $userId);
		}

		// disable save lock
		$GLOBALS['crown_save_lock'] = false;

	}


	/**
	 * Register the user list table columns with WordPress.
	 *
	 * **Automatically registered on the `manage_users_columns` filter hook.**
	 *
	 * The columns defined in the `$listTableColumns` property are added to the
	 * list of default user data table columns.
	 *
	 * @since 2.10.0
	 *
	 * @param array $defaults Default columns.
	 *
	 * @return array List table columns with custom columns added.
	 */
	public function registerListTableColumns($defaults) {
		foreach($this->listTableColumns as $listTableColumn) {
			$defaults = $listTableColumn->addColumn($defaults);
		}
		return $defaults;
	}


	/**
	 * Output the user's column data.
	 *
	 * **Automatically registered on the `manage_users_custom_column` filter hook.**
	 *
	 * Outputs the appropriate column data if defined in the
	 * `$listTableColumns` property.
	 *
	 * @since 2.10.0
	 *
	 * @param string $value Column value to filter.
	 * @param string $key Column key.
	 * @param int $userId User ID.
	 */
	public function outputListTableColumn($value, $key, $userId) {
		foreach($this->listTableColumns as $listTableColumn) {
			if($listTableColumn->getKey() == $key) {
				$value = $listTableColumn->getOutput($userId);
			}
		}
		return $value;
	}


}