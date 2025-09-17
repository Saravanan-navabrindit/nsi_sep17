<?php
/**
 * Contains definition for \Crown\Post\Type class.
 */

namespace Crown\Post;


/**
 * Post type configuration class.
 *
 * Serves as a handler for post type registration.
 * 
 * ```
 * $caseStudyPostType = new Type(array(
 *     'name' => 'case_study',
 *     'singularLabel' => 'Case Study',
 *     'pluralLabel' => 'Case Studies',
 *     'settings' => array(
 *         'supports' => array('title', 'editor'),
 *         'rewrite' => array('slug' => 'case-studies', 'with_front' => false),
 *         'has_archive' => true,
 *         'menu_icon' => 'dashicons-analytics'
 *     )
 * ));
 * ```
 * 
 * The `Type` object can also serve as a wrapper for post types that have already
 * been registered by core or other plugins in order to easily add Crown
 * Framework components.
 *
 * ```
 * $pagePostType = new Type(array(
 *     'name' => 'page'
 * ));
 * ```
 *
 * Whenever a new `Type` object is instantiated, all necessary action/filter
 * hooks are automatically registered within WordPress to manage the post
 * type's admin user interface.
 *
 * @since 2.0.0
 */
class Type {

	/**
	 * Post type slug.
	 *
	 * This is the unique name of the post type used to distinguish itself from
	 * other post types in the WordPress system. For consistency, the post type
	 * slug should always be in singular form.
	 *
	 * @see \Crown\Post\Type::getName()
	 * @see \Crown\Post\Type::setName()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Singular label for post type.
	 *
	 * The name to be shown in the WordPress admin when referencing a single
	 * instance of the post type.
	 *
	 * @see \Crown\Post\Type::getSingularLabel()
	 * @see \Crown\Post\Type::setSingularLabel()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $singularLabel;

	/**
	 * Plural label for post type.
	 *
	 * The name to be shown in the WordPress admin when referencing multiple
	 * instances of the post type.
	 *
	 * @see \Crown\Post\Type::getPluralLabel()
	 * @see \Crown\Post\Type::setPluralLabel()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $pluralLabel;

	/**
	 * Post type settings to be used during registration.
	 *
	 * Available setting options are the same as what can be passed into the
	 * `$args` parameter for WordPress' [`register_post_type()`](https://codex.wordpress.org/Function_Reference/register_post_type)
	 * function.
	 * 
	 * By default, the `labels` setting will be pre-populated with
	 * the relevant strings set in the `Type` class' `$singularLabel` and
	 * `$pluralLabel` properties. Note that all labels do not need to be
	 * redefined if just some must be tweaked.
	 * 
	 * Also by default, the `public` setting will be set to `true`. This
	 * setting must be overridden if you want to disable this post type
	 * completely from the WordPress admin or query functions.
	 *
	 * @see \Crown\Post\Type::getSettings()
	 * @see \Crown\Post\Type::setSettings()
	 * @see \Crown\Post\Type::setSetting()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Fields that appear on the post's editor page.
	 *
	 * These fields will appear directly below the post's main content editor
	 * (or in its place, if disabled). They can not be hidden or reorganized
	 * like meta boxes.
	 *
	 * @see \Crown\Post\Type::getFields()
	 * @see \Crown\Post\Type::setFields()
	 * @see \Crown\Post\Type::addField()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[]
	 */
	protected $fields;

	/**
	 * Meta boxes that appear on the post's editor page.
	 *
	 * Meta boxes should be used for grouping sets of post meta fields to
	 * organize different properties of a post's components.
	 *
	 * @see \Crown\Post\Type::getMetaBoxes()
	 * @see \Crown\Post\Type::setMetaBoxes()
	 * @see \Crown\Post\Type::addMetaBox()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Post\MetaBox[]
	 */
	protected $metaBoxes;

	/**
	 * Columns that appear in the admin's post list table.
	 *
	 * Data columns may be added to the table shown when listing all of a post
	 * type in the WordPress admin.
	 *
	 * @see \Crown\Post\Type::getListTableColumns()
	 * @see \Crown\Post\Type::setListTableColumns()
	 * @see \Crown\Post\Type::addListTableColumn()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\ListTableColumn[]
	 */
	protected $listTableColumns;

	/**
	 * Default post type configuration options.
	 *
	 * These options can be overridden by passing in an array of arguments when
	 * constructing a `Type` object.
	 *
	 * ```
	 * $defaultPostTypeArgs = array(
	 *     'name' => '',
	 *     'singularLabel' => '',
	 *     'pluralLabel' => '',
	 *     'settings' => array(
	 *         'public' => true
	 *     ),
	 *     'fields' => array(),
	 *     'metaBoxes' => array(),
	 *     'listTableColumns' => array()
	 * );
	 * ```
	 *
	 * @see \Crown\Post\Type::__construct()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultPostTypeArgs = array(
		'name' => '',
		'singularLabel' => '',
		'pluralLabel' => '',
		'settings' => array(
			'public' => true
		),
		'fields' => array(),
		'metaBoxes' => array(),
		'listTableColumns' => array()
	);


	/**
	 * Post type object constructor.
	 *
	 * Parses configuration options into object properties and registers
	 * relevant action/filter hooks. Passed in options array overrides those
	 * found in `$defaultPostTypeArgs` property.
	 *
	 * ```
	 * $caseStudyPostType = new Type(array(
	 *     'name' => 'case_study',
	 *     'singularLabel' => 'Case Study',
	 *     'pluralLabel' => 'Case Studies',
	 *     'settings' => array(
	 *         'supports' => array('title', 'editor'),
	 *         'rewrite' => array('slug' => 'case-studies', 'with_front' => false),
	 *         'has_archive' => true,
	 *         'menu_icon' => 'dashicons-analytics'
	 *     )
	 * ));
	 * ```
	 *
	 * The `register()` method is registered on the `init` WordPress action
	 * hook.
	 *
	 * @see \Crown\Post\Type::$defaultPostTypeArgs
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __`name`__ - (`string`) Post type slug.
	 *    * __`singularLabel`__ - (`string`) Singular label for post type.
	 *    * __`pluralLabel`__ - (`string`) Plural label for post type.
	 *    * __`settings`__ - (`array`) Post type settings to be used during registration.
	 *    * __`fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that appear on the post's editor page.
	 *    * __`metaBoxes`__ - (`MetaBox[]`) Metaboxes that appear on the post's editor page.
	 *    * __`listTableColumns`__ - (`ListTableColumn[]`) Columns that appear in the admin's post list table.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$postTypeArgs = array_merge($this::$defaultPostTypeArgs, array_intersect_key($args, $this::$defaultPostTypeArgs));

		// parse args into object variables
		$this->setName($postTypeArgs['name']);
		$this->setSingularLabel($postTypeArgs['singularLabel']);
		$this->setPluralLabel($postTypeArgs['pluralLabel']);
		$this->setSettings($postTypeArgs['settings']);
		$this->setFields($postTypeArgs['fields']);
		$this->setMetaBoxes($postTypeArgs['metaBoxes']);
		$this->setListTableColumns($postTypeArgs['listTableColumns']);

		// register hooks
		add_action('init', array(&$this, 'register'));

	}


	/**
	 * Get post type slug.
	 *
	 * ```
	 * $name = $myPostType->getName();
	 * ```
	 *
	 * @see \Crown\Post\Type::$name
	 *
	 * @since 2.0.0
	 *
	 * @return string Post type slug.
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * Get singular label for post type.
	 *
	 * ```
	 * $singularLabel = $myPostType->getSingularLabel();
	 * ```
	 *
	 * @see \Crown\Post\Type::$singularLabel
	 *
	 * @since 2.0.0
	 *
	 * @return string Post type singular label.
	 */
	public function getSingularLabel() {
		return $this->singularLabel;
	}


	/**
	 * Get plural label for post type.
	 *
	 * ```
	 * $pluralLabel = $myPostType->getPluralLabel();
	 * ```
	 *
	 * @see \Crown\Post\Type::$pluralLabel
	 *
	 * @since 2.0.0
	 *
	 * @return string Post type plural label.
	 */
	public function getPluralLabel() {
		return $this->pluralLabel;
	}


	/**
	 * Get post type settings to be used during registration.
	 *
	 * ```
	 * $settings = $myPostType->getSettings();
	 * ```
	 *
	 * @see \Crown\Post\Type::$settings
	 *
	 * @since 2.0.0
	 *
	 * @return array Post type settings.
	 */
	public function getSettings() {
		return $this->settings;
	}


	/**
	 * Get fields that appear on the post's editor page.
	 *
	 * ```
	 * $fields = $myPostType->getFields();
	 * ```
	 *
	 * @see \Crown\Post\Type::$fields
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Form\Field[] Post type fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Get metaboxes that appear on the post's editor page.
	 *
	 * ```
	 * $metaBoxes = $myPostType->getMetaBoxes();
	 * ```
	 *
	 * @see \Crown\Post\Type::$metaBoxes
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Post\MetaBox[] Post type meta boxes.
	 */
	public function getMetaBoxes() {
		return $this->metaBoxes;
	}


	/**
	 * Get columns that appear in the admin's post list table.
	 *
	 * ```
	 * $listTableColumns = $myPostType->getListTableColumns();
	 * ```
	 *
	 * @see \Crown\Post\Type::$listTableColumns
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\ListTableColumn[] Post type columns.
	 */
	public function getListTableColumns() {
		return $this->listTableColumns;
	}


	/**
	 * Set post type slug.
	 *
	 * ```
	 * $myPostType->setName('my_post_type');
	 * ```
	 *
	 * @see \Crown\Post\Type::$name
	 *
	 * @since 2.0.0
	 *
	 * @param string $name Post type slug.
	 */
	public function setName($name) {
		$this->name = $name;
	}


	/**
	 * Set singular label for post type.
	 *
	 * ```
	 * $myPostType->setSingularLabel('My Post Type');
	 * ```
	 *
	 * @see \Crown\Post\Type::$singularLabel
	 *
	 * @since 2.0.0
	 *
	 * @param string $singularLabel Post type singular label.
	 */
	public function setSingularLabel($singularLabel) {
		$this->singularLabel = $singularLabel;
	}


	/**
	 * Set plural label for post type.
	 *
	 * ```
	 * $myPostType->setPluralLabel('My Post Types');
	 * ```
	 *
	 * @see \Crown\Post\Type::$pluralLabel
	 *
	 * @since 2.0.0
	 *
	 * @param string $pluralLabel Post type plural label.
	 */
	public function setPluralLabel($pluralLabel) {
		$this->pluralLabel = $pluralLabel;
	}


	/**
	 * Set post type settings to be used during registration.
	 *
	 * ```
	 * $myPostType->setSettings(array(
	 *     'supports' => array('title', 'editor'),
	 *     'rewrite' => array('slug' => 'my-post-type', 'with_front' => false),
	 *     'has_archive' => true,
	 *     'menu_icon' => 'dashicons-admin-post'
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Type::$settings
	 *
	 * @since 2.0.0
	 *
	 * @param array $settings Post type settings.
	 */
	public function setSettings($settings) {
		if(is_array($settings)) $this->settings = array_merge($this::$defaultPostTypeArgs['settings'], $settings);
	}


	/**
	 * Set fields that appear on the post's editor page.
	 *
	 * ```
	 * $myPostType->setFields(array(
	 *     new Field(array(
	 *         'label' => 'Custom Field 1',
	 *         'input' => new Text(array('name' => 'my_post_type_custom_field_1'))
	 *     )),
	 *     new Field(array(
	 *         'label' => 'Custom Field 2',
	 *         'input' => new Text(array('name' => 'my_post_type_custom_field_2'))
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Type::$fields
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[] $fields Post type fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Set metaboxes that appear on the post's editor page.
	 *
	 * ```
	 * $myPostType->setMetaBoxes(array(
	 *     new MetaBox(array(
	 *         'id' => 'my-meta-box-1',
	 *         'title' => 'My Meta Box 1',
	 *         'fields' => array()
	 *     )),
	 *     new MetaBox(array(
	 *         'id' => 'my-meta-box-2',
	 *         'title' => 'My Meta Box 2',
	 *         'fields' => array()
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Type::$metaBoxes
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Post\MetaBox[] $metaBoxes Post type meta boxes.
	 */
	public function setMetaBoxes($metaBoxes) {
		if(is_array($metaBoxes)) $this->metaBoxes = $metaBoxes;
	}


	/**
	 * Set columns that appear in the admin's post list table.
	 *
	 * ```
	 * $myPostType->setListTableColumns(array(
	 *     new ListTableColumn(array(
	 *         'key' => 'my-custom-column-1',
	 *         'title' => 'Custom Column 1',
	 *         'position' => 2,
	 *         'outputCb' => 'outputMyPostTypeCustomColumn1Column'
	 *     )),
	 *     new ListTableColumn(array(
	 *         'key' => 'my-custom-column-2',
	 *         'title' => 'Custom Column 2',
	 *         'position' => 3,
	 *         'outputCb' => 'outputMyPostTypeCustomColumn2Column'
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Type::$listTableColumns
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\ListTableColumn[] $listTableColumns Post type columns.
	 */
	public function setListTableColumns($listTableColumns) {
		if(is_array($listTableColumns)) $this->listTableColumns = $listTableColumns;
	}


	/**
	 * Set a single post type setting to be used during registration.
	 *
	 * ```
	 * $myPostType->setSetting('has_archive', true);
	 * ```
	 *
	 * @see \Crown\Post\Type::$settings
	 *
	 * @since 2.0.0
	 *
	 * @param string $setting Setting key.
	 * @param mixed $value Setting value.
	 */
	public function setSetting($setting, $value) {
		$this->settings[$setting] = $value;
	}


	/**
	 * Add field to post type.
	 *
	 * ```
	 * $myPostType->addField(new Field(array(
	 *     'label' => 'Custom Field',
	 *     'input' => new Text(array('name' => 'my_post_type_custom_field'))
	 * )));
	 * ```
	 *
	 * @see \Crown\Post\Type::$fields
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field|\Crown\Form\FieldGroup|\Crown\Form\FieldRepeater $field New field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Add meta box to post type.
	 *
	 * ```
	 * $myPostType->addMetaBox(new MetaBox(array(
	 *     'id' => 'my-meta-box',
	 *     'title' => 'My Meta Box',
	 *     'fields' => array()
	 * )));
	 * ```
	 *
	 * @see \Crown\Post\Type::$metaBoxes
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Post\MetaBox $metaBox New meta box.
	 */
	public function addMetaBox($metaBox) {
		$this->metaBoxes[] = $metaBox;
	}


	/**
	 * Add list table column to post type.
	 *
	 * ```
	 * $myPostType->addListTableColumn(new ListTableColumn(array(
	 *     'key' => 'my-custom-column',
	 *     'title' => 'Custom Column',
	 *     'position' => 2,
	 *     'outputCb' => array(&$this, 'outputMyCustomColumn')
	 * )));
	 * ```
	 *
	 * @see \Crown\Post\Type::$listTableColumns
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\ListTableColumn $listTableColumn New list table column.
	 */
	public function addListTableColumn($listTableColumn) {
		$this->listTableColumns[] = $listTableColumn;
	}


	/**
	 * Register the post type with WordPress.
	 *
	 * **Automatically registered on the `init` action hook.**
	 *
	 * If the post type slug is not already registered with WordPress, the post
	 * type is registered. Hooks for initializing post meta data fields, saving
	 * post data, and registering list table columns are also added during this
	 * process.
	 *
	 * The following WordPress action/filter hooks are registered:
	 * 
	 * * The `saveMeta()` method is registered on the `save_post` action hook.
	 * * The `restoreMeta()` method is registered on the `wp_restore_post_revision` action hook.
	 * * The `registerMetaBoxes()` method is registered on the `add_meta_boxes` action hook.
	 * * The `outputFields()` method is registered on the `edit_form_after_editor` action hook.
	 * * The `deleteRepeaterFieldEntries()` method is registered on the `after_delete_post` action hook.
	 * * The `registerListTableColumns()` method is registered on the `manage_${post_type}_posts_columns` filter hook.
	 * * The `registerSortableListTableColumns()` method is registered on the `manage_edit-${post_type}_sortable_columns` filter hook.
	 * * The `outputListTableColumn()` method is registered on the `manage_${post_type}_posts_custom_column` action hook.
	 * * The `addSortQueryVars()` method is registered on the `request` filter hook when loading the `load-edit.php` admin page.
	 *
	 * This method uses the [`register_post_type()`](https://codex.wordpress.org/Function_Reference/register_post_type)
	 * core WordPress function for registering the post type.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Post\Type::getPostTypeArgs() to build post type settings array.
	 */
	public function register() {
		if(empty($this->name)) return false;
		$self = &$this;

		// register post type
		if(!post_type_exists($this->name)) {
			register_post_type($this->name, $this->getPostTypeArgs());
		}

		// post meta hooks
		add_action('save_post', array(&$this, 'saveMeta'));
		add_action('wp_restore_post_revision', array(&$this, 'restoreMeta'), 10, 2);
		add_action('add_meta_boxes', array(&$this, 'registerMetaBoxes'));
		add_action('edit_form_after_editor', array(&$this, 'outputFields'));
		add_action('after_delete_post', array(&$this, 'deleteRepeaterFieldEntries'));

		// post list table column hooks
		add_filter('manage_'.$this->name.'_posts_columns', array(&$this, 'registerListTableColumns'));
		add_filter('manage_edit-'.$this->name.'_sortable_columns', array(&$this, 'registerSortableListTableColumns'));
		add_action('manage_'.$this->name.'_posts_custom_column', array(&$this, 'outputListTableColumn'));
		add_action('load-edit.php', function() use (&$self) {
			add_filter('request', array(&$self, 'addSortQueryVars'));
		});

	}


	/**
	 * Builds post type settings array.
	 *
	 * Returned array can be used in WordPress' [`register_post_type()`](https://codex.wordpress.org/Function_Reference/register_post_type)
	 * function.
	 *
	 * @since 2.0.0
	 *
	 * @return array Post type settings.
	 */
	protected function getPostTypeArgs() {

		$args = array();

		// setup default labels
		if(!empty($this->singularLabel) && !empty($this->pluralLabel)) {
			$args['labels'] = array(
				'name' => $this->pluralLabel,
				'singular_name' => $this->singularLabel,
				'menu_name' => $this->pluralLabel,
				'name_admin_bar' => $this->singularLabel,
				'all_items' => 'All '.$this->pluralLabel,
				'add_new' => 'Add New',
				'add_new_item' => 'Add New '.$this->singularLabel,
				'edit_item' => 'Edit '.$this->singularLabel,
				'new_item' => 'New '.$this->singularLabel,
				'view_item' => 'View '.$this->singularLabel,
				'search_items' => 'Search '.$this->pluralLabel,
				'not_found' =>  'No '.$this->pluralLabel.' found',
				'not_found_in_trash' => 'No '.$this->pluralLabel.' found in Trash', 
				'parent_item_colon' => 'Parent '.$this->singularLabel
			);
		}

		// merge with label settings
		if(array_key_exists('labels', $this->settings)) {
			$args['labels'] = array_merge($args['labels'], $this->settings['labels']);
		}

		// return combined settings
		return apply_filters('crown_post_type_args', array_merge($this->settings, $args), $this->name);

	}


	/**
	 * Save a post's meta data associated with the post's type.
	 *
	 * **Automatically registered on the `save_post` action hook.**
	 *
	 * Meta data to be saved is collected from `$_POST` array. A nonce field is
	 * verified and the user's permission is checked before saving to the
	 * database. A 'saving lock' is enabled so the method may not be called
	 * recursively.
	 *
	 * Only data associated with the fields and meta boxes registered to the
	 * `Type` object will be affected.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID.
	 */
	public function saveMeta($postId) {

		// if(wp_is_post_revision($postId)) return $postId;
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $postId;
		if(defined('DOING_AJAX') && DOING_AJAX) return $postId;
		if(defined('DOING_CRON') && DOING_CRON) return $postId;
		if(isset($GLOBALS['crown_save_lock']) && $GLOBALS['crown_save_lock']) return $postId;

		// verify nonce field
		// if(!isset($_POST['nonce_post_type_'.$this->name]) || !wp_verify_nonce($_POST['nonce_post_type_'.$this->name], 'crown_save_post_type_'.$this->name)) return $postId;

		$post = get_post($postId);
		if(!$post) return $postId;

		// check if revision
		$revisionParent = get_post(wp_is_post_revision($postId));
		if(wp_is_post_revision($postId) && $revisionParent) {

			// check if revision parent is of the correct type
			if($this->name != $revisionParent->post_type) return $postId;

			// check if current user has capability to save parent post type
			$postTypeObject = get_post_type_object($revisionParent->post_type);
			if(!current_user_can($postTypeObject->cap->edit_post, $revisionParent->ID)) return $postId;

		} else {

			// check if post is of the corrent type
			if($this->name != $post->post_type) return $postId;

			// check if current user has capability to save post type
			$postTypeObject = get_post_type_object($post->post_type);
			if(!current_user_can($postTypeObject->cap->edit_post, $postId)) return $postId;

		}

		$input = $_POST;

		// enable save lock to prevent endless loops
		$GLOBALS['crown_save_lock'] = true;

		// save post's fields' meta data
		foreach($this->fields as $field) {
			$field->saveValue($input, 'post', $post->ID);
		}

		// save post's meta boxes' meta data
		foreach($this->metaBoxes as $metaBox) {
			$metaBox->saveMeta($post, $input);
		}

		// disable save lock
		$GLOBALS['crown_save_lock'] = false;

	}


	/**
	 * Restore meta data for a post from a revision.
	 *
	 * **Automatically registered on the `wp_restore_post_revision` action hook.**
	 *
	 * Only data associated with the fields and meta boxes registered to the
	 * `Type` object will be affected.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID.
	 * @param int $revisionId Revision ID.
	 */
	public function restoreMeta($postId, $revisionId) {

		foreach($this->fields as $field) {
			$field->restoreValue($postId, $revisionId);
		}

		foreach($this->metaBoxes as $metaBox) {
			$metaBox->restoreMeta($postId, $revisionId);
		}

	}


	/**
	 * Output the post type's fields.
	 *
	 * **Automatically registered on the `edit_form_after_editor` action hook.**
	 *
	 * The fields added to the `$field` property are output, along with a nonce
	 * field to be verified upon submission.
	 *
	 * @since 2.0.0
	 */
	public function outputFields() {
		global $post;

		// check if post is of the corrent type
		if($this->name != $post->post_type) return $post->ID;

		foreach($this->fields as $field) {
			$fieldValue = $field->getValue('post', $post->ID);
			$field->output(array('value' => $fieldValue, 'objectId' => $post->ID));
		}

		// add nonce field
		wp_nonce_field('crown_save_post_type_'.$this->name, 'nonce_post_type_'.$this->name);

	}


	/**
	 * Delete a post's repeater field entries.
	 *
	 * **Automatically registered on the `after_delete_post` action hook.**
	 *
	 * All repeater entry posts, as well as any of their associated data, will
	 * be removed for the specified post.
	 *
	 * @since 2.0.0
	 *
	 * @param int $postId Post ID.
	 */
	public function deleteRepeaterFieldEntries($postId) {
		$entries = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'post_parent' => $postId,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => 'post'
				)
			)
		));
		foreach($entries as $entry) {
			wp_delete_post($entry->ID, true);
		}
	}


	/**
	 * Register the post type's meta boxes with WordPress.
	 *
	 * **Automatically registered on the `add_meta_boxes` action hook.**
	 *
	 * The meta boxes defined in the `$metaBoxes` property are registered.
	 *
	 * @since 2.0.0
	 */
	public function registerMetaBoxes() {

		foreach($this->metaBoxes as $metaBox) {
			$metaBox->register($this->name);
		}

	}


	/**
	 * Register the post type's list table columns with WordPress.
	 *
	 * **Automatically registered on the `manage_${post_type}_posts_columns` filter hook.**
	 *
	 * The columns defined in the `$listTableColumns` property are added to the
	 * list of default post data table columns.
	 *
	 * @since 2.0.0
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
	 * Register the post type's sortable list table columns with WordPress.
	 *
	 * **Automatically registered on the `manage_edit-${post_type}_sortable_columns` filter hook.**
	 *
	 * The columns defined in the `$listTableColumns` property that have been
	 * specified as sortable are added to the list of default sortable post
	 * data table columns.
	 *
	 * @since 2.0.0
	 *
	 * @param array $defaults Default sortable column keys.
	 *
	 * @return array Sortable list table column keys with custom columns added.
	 */
	public function registerSortableListTableColumns($defaults) {
		foreach($this->listTableColumns as $listTableColumn) {
			if($listTableColumn->isSortable()) {
				$defaults[$listTableColumn->getKey()] = $listTableColumn->getKey();
			}
		}
		return $defaults;
	}


	/**
	 * Output the post type's column data.
	 *
	 * **Automatically registered on the `manage_${post_type}_posts_custom_column` action hook.**
	 *
	 * Outputs the appropriate column data if defined in the
	 * `$listTableColumns` property.
	 *
	 * @since 2.0.0
	 *
	 * @param string $key Column key.
	 */
	public function outputListTableColumn($key) {
		foreach($this->listTableColumns as $listTableColumn) {
			if($listTableColumn->getKey() == $key) {
				$listTableColumn->output(get_the_ID());
			}
		}
	}


	/**
	 * Add post query variables to sort posts in admin list table.
	 *
	 * **Automatically registered on the `request` action hook when loading the `load-edit.php` admin page.**
	 *
	 * Appropriate variables are added to request query if one of columns in
	 * the `$listTableColumns` property is indicated in `orderby` query
	 * parameter.
	 *
	 * @since 2.0.0
	 *
	 * @param array $queryVars Default post query variables.
	 *
	 * @return array Updated post query variables.
	 */
	public function addSortQueryVars($queryVars) {
		if(!isset($queryVars['post_type']) || $queryVars['post_type'] != $this->name) return $queryVars;

		if(isset($queryVars['orderby'])) {
			foreach($this->listTableColumns as $listTableColumn) {
				if($listTableColumn->isSortable() && $queryVars['orderby'] == $listTableColumn->getKey()) {
					$queryVars = $listTableColumn->addSortQueryVars($queryVars);
				}
			}
		}

		return $queryVars;
	}


}