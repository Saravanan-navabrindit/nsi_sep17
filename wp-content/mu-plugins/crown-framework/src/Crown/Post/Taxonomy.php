<?php
/**
 * Contains definition for \Crown\Post\Taxonomy class.
 */

namespace Crown\Post;


/**
 * Post taxonomy configuration class.
 *
 * Serves as a handler for post taxonomy registration.
 *
 * ```
 * $caseStudyCategoryTaxonomy = new Taxonomy(array(
 *     'name' => 'case_study_category',
 *     'singularLabel' => 'Case Study Category',
 *     'pluralLabel' => 'Case Study Categories',
 *     'postTypes' => array('case_study'),
 *     'settings' => array(
 *         'hierarchical' => true,
 *         'show_in_nav_menus' => false,
 *         'labels' => array(
 *             'menu_name' => 'Categories',
 *             'all_items' => 'All Categories'
 *         )
 *     )
 * ));
 * ```
 * 
 * The `Taxonomy` object can also serve as a wrapper for taxonomies that have
 * already been registered by core or other plugins in order to easily add
 * Crown Framework components.
 *
 * ```
 * $postCategoryTaxonomy = new Taxonomy(array(
 *     'name' => 'category'
 * ));
 * ```
 *
 * Whenever a new `Taxonomy` object is instantiated, all necessary
 * action/filter hooks are automatically registered within WordPress to manage
 * the taxonomy's admin user interface.
 *
 * @since 2.0.0
 */
class Taxonomy {

	/**
	 * Taxonomy slug.
	 *
	 * This is the unique name of the taxonomy used to distinguish itself from
	 * other taxonomies in the WordPress system. For consistency, the taxonomy
	 * slug should always be in singular form.
	 *
	 * @see \Crown\Post\Taxonomy::getName()
	 * @see \Crown\Post\Taxonomy::setName()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Singular label for taxonomy term.
	 *
	 * The name to be shown in the WordPress admin when referencing a single
	 * term of the taxonomy.
	 *
	 * @see \Crown\Post\Taxonomy::getSingularLabel()
	 * @see \Crown\Post\Taxonomy::setSingularLabel()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $singularLabel;

	/**
	 * Plural label for taxonomy terms.
	 *
	 * The name to be shown in the WordPress admin when referencing multiple
	 * terms of the taxonomy.
	 *
	 * @see \Crown\Post\Taxonomy::getPluralLabel()
	 * @see \Crown\Post\Taxonomy::setPluralLabel()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $pluralLabel;

	/**
	 * Post types associated with taxonomy.
	 *
	 * This is the post type, or types, that will be able to be classified with
	 * the terms of the taxonomy.
	 *
	 * @see \Crown\Post\Taxonomy::getPostTypes()
	 * @see \Crown\Post\Taxonomy::setPostTypes()
	 * @see \Crown\Post\Taxonomy::addPostType()
	 *
	 * @since 2.0.0
	 *
	 * @var string|string[]|\Crown\Post\Type|\Crown\Post\Type[]
	 */
	protected $postTypes;

	/**
	 * Taxonomy settings to be used during registration.
	 *
	 * Available setting options are the same as what can be passed into the
	 * `$args` parameter for WordPress' [`register_taxonomy()`](https://codex.wordpress.org/Function_Reference/register_taxonomy)
	 * function.
	 * 
	 * By default, the `labels` setting will be pre-populated with
	 * the relevant strings set in the `Taxonomy` class' `$singularLabel` and
	 * `$pluralLabel` properties. Note that all labels do not need to be
	 * redefined if just some must be tweaked.
	 * 
	 * Also by default, the `show_admin_column` setting will be set to `true`.
	 * This setting must be overridden if you want to disable the post table
	 * column that lists out all the terms of this taxonomy associated with
	 * each post.
	 *
	 * @see \Crown\Post\Taxonomy::getSettings()
	 * @see \Crown\Post\Taxonomy::setSettings()
	 * @see \Crown\Post\Taxonomy::setSetting()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Fields that appear on the taxonomy term's create & edit pages.
	 *
	 * These fields will appear in the new term form for the taxonomy as well
	 * as the taxonomy's term editor pages.
	 *
	 * @see \Crown\Post\Taxonomy::getFields()
	 * @see \Crown\Post\Taxonomy::setFields()
	 * @see \Crown\Post\Taxonomy::addField()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[]
	 */
	protected $fields;

	/**
	 * Columns that appear in the admin's taxonomy term list table.
	 *
	 * Data columns may be added to the table shown when listing all terms of a
	 * taxonomy in the WordPress admin.
	 *
	 * @see \Crown\Post\Taxonomy::getListTableColumns()
	 * @see \Crown\Post\Taxonomy::setListTableColumns()
	 * @see \Crown\Post\Taxonomy::addListTableColumn()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\ListTableColumn[]
	 */
	protected $listTableColumns;

	/**
	 * Default taxonomy configuration options.
	 *
	 * These options can be overridden by passing in an array of arguments when
	 * constructing a `Taxonomy` object.
	 *
	 * ```
	 * $defaultTaxonomyArgs = array(
	 *     'name' => '',
	 *     'singularLabel' => '',
	 *     'pluralLabel' => '',
	 *     'postTypes' => array(),
	 *     'settings' => array(
	 *         'show_admin_column' => true
	 *     ),
	 *     'fields' => array(),
	 *     'listTableColumns' => array()
	 * );
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::__construct()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultTaxonomyArgs = array(
		'name' => '',
		'singularLabel' => '',
		'pluralLabel' => '',
		'postTypes' => array(),
		'settings' => array(
			'show_admin_column' => true
		),
		'fields' => array(),
		'listTableColumns' => array()
	);


	/**
	 * Post type object constructor.
	 *
	 * Parses configuration options into object properties and registers
	 * relevant action/filter hooks. Passed in options array overrides those
	 * found in `$defaultTaxonomyArgs` property.
	 * 
	 * ```
	 * $caseStudyCategoryTaxonomy = new Taxonomy(array(
	 *     'name' => 'case_study_category',
	 *     'singularLabel' => 'Case Study Category',
	 *     'pluralLabel' => 'Case Study Categories',
	 *     'postTypes' => array('case_study'),
	 *     'settings' => array(
	 *         'hierarchical' => true,
	 *         'show_in_nav_menus' => false,
	 *         'labels' => array(
	 *             'menu_name' => 'Categories',
	 *             'all_items' => 'All Categories'
	 *         )
	 *     )
	 * ));
	 * ```
	 *
	 * The `register()` method is registered on the `init` WordPress action
	 * hook. The `enqueueAdminScripts()` method is registered on the
	 * `admin_enqueue_scripts` WordPress action hook.
	 *
	 * @see \Crown\Post\Taxonomy::$defaultTaxonomyArgs
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __`name`__ - (`string`) Taxonomy slug.
	 *    * __`singularLabel`__ - (`string`) Singular label for taxonomy term.
	 *    * __`pluralLabel`__ - (`string`) Plural label for taxonomy terms.
	 *    * __`postTypes`__ - (`string`|`string[]`|`\Crown\Post\Type`|`\Crown\Post\Type[]`) Post types associated with taxonomy.
	 *    * __`settings`__ - (`array`) Taxonomy settings to be used during registration.
	 *    * __`fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that appear on the taxonomy term's create & edit pages.
	 *    * __`listTableColumns`__ - (`\Crown\ListTableColumn[]`) Columns that appear in the admin's taxonomy term list table.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$taxonomyArgs = array_merge($this::$defaultTaxonomyArgs, array_intersect_key($args, $this::$defaultTaxonomyArgs));

		// parse args into object variables
		$this->setName($taxonomyArgs['name']);
		$this->setSingularLabel($taxonomyArgs['singularLabel']);
		$this->setPluralLabel($taxonomyArgs['pluralLabel']);
		$this->setPostTypes($taxonomyArgs['postTypes']);
		$this->setSettings($taxonomyArgs['settings']);
		$this->setFields($taxonomyArgs['fields']);
		$this->setListTableColumns($taxonomyArgs['listTableColumns']);

		// register hooks
		add_action('init', array(&$this, 'register'));
		add_action('admin_enqueue_scripts', array(&$this, 'enqueueAdminScripts'));

	}


	/**
	 * Get taxonomy slug.
	 *
	 * ```
	 * $name = $myTaxonomy->getName();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$name
	 *
	 * @since 2.0.0
	 *
	 * @return string Taxonomy slug.
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * Get singular label for taxonomy term.
	 *
	 * ```
	 * $singularLabel = $myTaxonomy->getSingularLabel();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$singularLabel
	 *
	 * @since 2.0.0
	 *
	 * @return string Taxonomy singular label.
	 */
	public function getSingularLabel() {
		return $this->singularLabel;
	}


	/**
	 * Get plural label for taxonomy terms.
	 *
	 * ```
	 * $pluralLabel = $myTaxonomy->getPluralLabel();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$pluralLabel
	 *
	 * @since 2.0.0
	 *
	 * @return string Taxonomy plural label.
	 */
	public function getPluralLabel() {
		return $this->pluralLabel;
	}


	/**
	 * Get post types associated with taxonomy.
	 *
	 * ```
	 * $postTypes = $myTaxonomy->getPostTypes();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$postTypes
	 *
	 * @since 2.0.0
	 *
	 * @return string|string[]|\Crown\Post\Type|\Crown\Post\Type[] Post types.
	 */
	public function getPostTypes() {
		return $this->postTypes;
	}


	/**
	 * Get taxonomy settings to be used during registration.
	 *
	 * ```
	 * $settings = $myTaxonomy->getSettings();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$settings
	 *
	 * @since 2.0.0
	 *
	 * @return array Taxonomy settings.
	 */
	public function getSettings() {
		return $this->settings;
	}


	/**
	 * Get fields that appear on the taxonomy term's create & edit pages.
	 *
	 * ```
	 * $fields = $myTaxonomy->getFields();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$fields
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[] Taxonomy fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Get columns that appear in the admin's taxonomy term list table.
	 *
	 * ```
	 * $listTableColumns = $myTaxonomy->getListTableColumns();
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$listTableColumns
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\ListTableColumn[] Taxonomy columns.
	 */
	public function getListTableColumns() {
		return $this->listTableColumns;
	}


	/**
	 * Set taxonomy slug.
	 *
	 * ```
	 * $myTaxonomy->setName('my_taxonomy');
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$name
	 *
	 * @since 2.0.0
	 *
	 * @param string $name Taxonomy slug.
	 */
	public function setName($name) {
		$this->name = $name;
	}


	/**
	 * Set singular label for taxonomy term.
	 *
	 * ```
	 * $myTaxonomy->setSingularLabel('My Taxonomy Term');
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$singularLabel
	 *
	 * @since 2.0.0
	 *
	 * @param string $singularLabel Taxonomy singular label.
	 */
	public function setSingularLabel($singularLabel) {
		$this->singularLabel = $singularLabel;
	}


	/**
	 * Set plural label for taxonomy terms.
	 *
	 * ```
	 * $myTaxonomy->setPluralLabel('My Taxonomy Terms');
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$pluralLabel
	 *
	 * @since 2.0.0
	 *
	 * @param string $pluralLabel Taxonomy plural label.
	 */
	public function setPluralLabel($pluralLabel) {
		$this->pluralLabel = $pluralLabel;
	}


	/**
	 * Set post types associated with taxonomy.
	 *
	 * ```
	 * $myTaxonomy->setPostTypes('post');
	 * ```
	 *
	 * ```
	 * $myTaxonomy->setPostTypes(array('post', 'page'));
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$postTypes
	 *
	 * @since 2.0.0
	 *
	 * @param string|string[]|\Crown\Post\Type|\Crown\Post\Type[] $postTypes Taxonomy post types.
	 */
	public function setPostTypes($postTypes) {
		$this->postTypes = is_array($postTypes) ? $postTypes : array($postTypes);
	}


	/**
	 * Set taxonomy settings to be used during registration.
	 *
	 * ```
	 * $myTaxonomy->setSettings(array(
	 *     'hierarchical' => false,
	 *     'show_admin_column' => false,
	 *     'rewrite' => array('slug' => 'my-taxonomy', 'with_front' => false)
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$settings
	 *
	 * @since 2.0.0
	 *
	 * @param array $settings Taxonomy settings.
	 */
	public function setSettings($settings) {
		if(is_array($settings)) $this->settings = array_merge($this::$defaultTaxonomyArgs['settings'], $settings);
	}


	/**
	 * Set fields that appear on the taxonomy term's create & edit pages.
	 *
	 * ```
	 * $myTaxonomy->setFields(array(
	 *     new Field(array(
	 *         'label' => 'Custom Field 1',
	 *         'input' => new Text(array('name' => 'my_taxonomy_custom_field_1'))
	 *     )),
	 *     new Field(array(
	 *         'label' => 'Custom Field 2',
	 *         'input' => new Text(array('name' => 'my_taxonomy_custom_field_2'))
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$fields
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[] $fields Taxonomy fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Set columns that appear in the admin's taxonomy term list table.
	 *
	 * ```
	 * $myTaxonomy->setListTableColumns(array(
	 *     new ListTableColumn(array(
	 *         'key' => 'my-custom-column-1',
	 *         'title' => 'Custom Column 1',
	 *         'position' => 2,
	 *         'outputCb' => 'outputMyTaxonomyCustomColumn1Column'
	 *     )),
	 *     new ListTableColumn(array(
	 *         'key' => 'my-custom-column-2',
	 *         'title' => 'Custom Column 2',
	 *         'position' => 3,
	 *         'outputCb' => 'outputMyTaxonomyCustomColumn2Column'
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$listTableColumns
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\ListTableColumn[] $listTableColumns Taxonomy columns.
	 */
	public function setListTableColumns($listTableColumns) {
		if(is_array($listTableColumns)) $this->listTableColumns = $listTableColumns;
	}


	/**
	 * Add a post type to associate with taxonomy.
	 *
	 * ```
	 * $myTaxonomy->addPostType('post');
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$postTypes
	 *
	 * @since 2.0.0
	 *
	 * @param string|\Crown\Post\Type $postType New post type.
	 */
	public function addPostType($postType) {
		$this->postTypes[] = $postType;
	}


	/**
	 * Set a single taxonomy setting to be used during registration.
	 * 
	 * ```
	 * $myTaxonomy->setSetting('hierarchical', false);
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$settings
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
	 * Add field to taxonomy.
	 *
	 * ```
	 * $myTaxonomy->addField(new Field(array(
	 *     'label' => 'Custom Field',
	 *     'input' => new Text(array('name' => 'my_taxonomy_custom_field'))
	 * )));
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$fields
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field|\Crown\Form\FieldGroup|\Crown\Form\FieldRepeater $field New field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Add list table column to taxonomy.
	 *
	 * ```
	 * $myTaxonomy->addListTableColumn(new ListTableColumn(array(
	 *     'key' => 'my-custom-column',
	 *     'title' => 'Custom Column',
	 *     'position' => 2,
	 *     'outputCb' => array(&$this, 'outputMyCustomColumn')
	 * )));
	 * ```
	 *
	 * @see \Crown\Post\Taxonomy::$listTableColumns
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\ListTableColumn $listTableColumn New list table column.
	 */
	public function addListTableColumn($listTableColumn) {
		$this->listTableColumns[] = $listTableColumn;
	}


	/**
	 * Register the taxonomy with WordPress.
	 *
	 * **Automatically registered on the `init` action hook.**
	 *
	 * If the taxonomy slug is not already registered with WordPress, the
	 * taxonomy is registered. Hooks for initializing term meta data fields,
	 * saving term data, and registering list table columns are also added
	 * during this process.
	 *
	 * The following WordPress action/filter hooks are registered:
	 * 
	 * * The `saveMeta()` method is registered on the `create_${taxonomy}` action hook.
	 * * The `saveMeta()` method is registered on the `edited_${taxonomy}` action hook.
	 * * The `outputFields()` method is registered on the `${taxonomy}_edit_form_fields` action hook.
	 * * The `outputCreateFields()` method is registered on the `${taxonomy}_add_form_fields` action hook.
	 * * The `deleteRepeaterFieldEntries()` method is registered on the `delete_term` action hook.
	 * * The `registerListTableColumns()` method is registered on the `manage_edit-${taxonomy}_columns` filter hook.
	 * * The `outputListTableColumn()` method is registered on the `manage_${taxonomy}_custom_column` filter hook.
	 *
	 * This method uses the [`register_taxonomy()`](https://codex.wordpress.org/Function_Reference/register_taxonomy)
	 * core WordPress function for registering the taxonomy.
	 *
	 * @since 2.0.0
	 *
	 * @uses \Crown\Post\Taxonomy::getTaxonomyArgs() to build taxonomy settings array.
	 */
	public function register() {
		if(empty($this->name)) return;
		if(empty($this->postTypes)) return;

		// build array of post type names
		$postTypeNames = array();
		foreach($this->postTypes as $postType) {
			if(is_a($postType, 'Crown\Post\Type')) {
				$postTypeNames[] = $postType->getName();
			} else {
				$postTypeNames[] = $postType;
			}
		}
		$postTypeNames = array_unique($postTypeNames);

		// register taxonomy
		if(!taxonomy_exists($this->name)) {
			register_taxonomy($this->name, $postTypeNames, $this->getTaxonomyArgs());
		}

		// term meta hooks
		add_action('create_'.$this->name, array(&$this, 'saveMeta'), 10, 2);
		add_action('edited_'.$this->name, array(&$this, 'saveMeta'), 10, 2);
		add_action($this->name.'_edit_form_fields', array(&$this, 'outputFields'), 10, 2);
		add_action($this->name.'_add_form_fields', array(&$this, 'outputCreateFields'), 10, 1);
		add_action('delete_term', array(&$this, 'deleteRepeaterFieldEntries'), 10, 4);

		// term list table column hooks
		add_filter('manage_edit-'.$this->name.'_columns', array(&$this, 'registerListTableColumns'));
		add_filter('manage_'.$this->name.'_custom_column', array(&$this, 'outputListTableColumn'), 10, 3);

	}


	/**
	 * Builds taxonomy settings array.
	 *
	 * Returned array can be used in WordPress' [`register_taxonomy()`](https://codex.wordpress.org/Function_Reference/register_taxonomy)
	 * function.
	 *
	 * @since 2.0.0
	 *
	 * @return array Taxonomy settings.
	 */
	protected function getTaxonomyArgs() {

		$args = array();

		// setup default labels
		if(!empty($this->singularLabel) && !empty($this->pluralLabel)) {
			$args['labels'] = array(
				'name' => $this->pluralLabel,
				'singular_name' => $this->singularLabel,
				'menu_name' => $this->pluralLabel,
				'all_items' => 'All '.$this->pluralLabel,
				'edit_item' => 'Edit '.$this->singularLabel,
				'view_item' => 'View '.$this->singularLabel,
				'update_item' => 'Update '.$this->singularLabel,
				'add_new_item' => 'Add New '.$this->singularLabel,
				'new_item_name' => 'New '.$this->singularLabel.' Name',
				'parent_item' => 'Parent '.$this->singularLabel,
				'parent_item_colon' => 'Parent '.$this->singularLabel.':',
				'search_items' => 'Search '.$this->pluralLabel,
				'popular_items' => 'Popular '.$this->pluralLabel,
				'separate_items_with_commas' => 'Separate '.$this->pluralLabel.' with commas',
				'add_or_remove_items' => 'Add or remove '.$this->pluralLabel,
				'choose_from_most_used' => 'Choose from the most used '.$this->pluralLabel,
				'not_found' =>  'No '.$this->pluralLabel.' found'
			);
		}

		// merge with label settings
		if(array_key_exists('labels', $this->settings)) {
			$args['labels'] = array_merge($args['labels'], $this->settings['labels']);
		}

		// return combined settings
		return apply_filters('crown_taxonomy_args', array_merge($this->settings, $args), $this->name);

	}


	/**
	 * Save a term's metadata associated with the term's taxonomy.
	 *
	 * **Automatically registered on the `create_${taxonomy}` and `edited_${taxonomy}` action hook.**
	 *
	 * Meta data to be saved is collected from `$_POST` array. A nonce field is
	 * verified before saving to the database.
	 *
	 * Only data associated with the fields registered to the `Taxonomy` object
	 * will be affected.
	 *
	 * @since 2.0.0
	 *
	 * @param int $termId Term ID.
	 * @param int $ttId Term taxonomy ID.
	 */
	public function saveMeta($termId, $ttId) {

		if(isset($GLOBALS['crown_save_lock']) && $GLOBALS['crown_save_lock']) return $termId;

		// verify nonce field
		if(!isset($_POST['nonce_taxonony_'.$this->name]) || !wp_verify_nonce($_POST['nonce_taxonony_'.$this->name], 'crown_save_taxonomy_'.$this->name)) return $termId;

		$term = get_term($termId, $this->name);
		if(!$term) return $termId;

		$input = $_POST;

		// enable save lock to prevent endless loops
		$GLOBALS['crown_save_lock'] = true;

		// save taxonomy term's fields' meta data
		foreach($this->fields as $field) {
			$field->saveValue($input, 'term', $term->term_id);
		}

		// disable save lock
		$GLOBALS['crown_save_lock'] = false;

	}


	/**
	 * Output the taxonomy's edit term fields.
	 *
	 * **Automatically registered on the `${taxonomy}_edit_form_fields` action hook.**
	 *
	 * The fields added to the `$field` property are output, along with a nonce
	 * field to be verified upon submission.
	 *
	 * @since 2.0.0
	 *
	 * @param \WP_Term $term Term for which to output fields.
	 * @param string $taxonomyName Taxonomy name.
	 */
	public function outputFields($term, $taxonomyName) {

		foreach($this->fields as $field) {
			$fieldValue = $field->getValue('term', $term->term_id);
			$field->output(array('value' => $fieldValue, 'objectId' => $term->term_id, 'format' => 'tr'));
		}

		// add nonce field
		wp_nonce_field('crown_save_taxonomy_'.$this->name, 'nonce_taxonony_'.$this->name);

	}


	/**
	 * Output the taxonomy's create term fields.
	 *
	 * **Automatically registered on the `${taxonomy}_add_form_fields` action hook.**
	 *
	 * The fields added to the `$field` property are output, along with a nonce
	 * field to be verified upon submission.
	 *
	 * @since 2.0.0
	 *
	 * @param string $taxonomyName Taxonomy name.
	 */
	public function outputCreateFields($taxonomyName) {

		foreach($this->fields as $field) {
			$field->output(array());
		}

		// add nonce field
		wp_nonce_field('crown_save_taxonomy_'.$this->name, 'nonce_taxonony_'.$this->name);

	}


	/**
	 * Delete a term's repeater field entries.
	 *
	 * **Automatically registered on the `delete_term` action hook.**
	 *
	 * All repeater entry posts, as well as any of their associated data, will
	 * be removed for the specified term.
	 *
	 * @since 2.0.0
	 *
	 * @param int $termId Term ID.
	 * @param int $termTaxId Term taxonomy ID.
	 * @param string $taxonomySlug Taxonomy name.
	 * @param \WP_Term $deletedTerm Term that is being deleted.
	 */
	public function deleteRepeaterFieldEntries($termId, $termTaxId, $taxonomySlug, $deletedTerm) {
		$entries = get_posts(array(
			'posts_per_page' => -1,
			'post_type' => 'crown_repeater_entry',
			'post_parent' => $termId,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => 'crown_repeater_entry_object_type',
					'value' => 'term'
				)
			)
		));
		foreach($entries as $entry) {
			wp_delete_post($entry->ID, true);
		}
	}


	/**
	 * Register the taxonomy's list table columns with WordPress.
	 *
	 * **Automatically registered on the `manage_edit-${taxonomy}_columns` filter hook.**
	 *
	 * The columns defined in the `$listTableColumns` property are added to the
	 * list of default term data table columns.
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
	 * Output the taxonomy's column data.
	 *
	 * **Automatically registered on the `manage_{$taxonomy}_custom_column` filter hook.**
	 *
	 * Outputs the appropriate column data if defined in the
	 * `$listTableColumns` property.
	 *
	 * @since 2.0.0
	 *
	 * @param string $output Default column content.
	 * @param string $key Column key.
	 * @param int $termId Term ID for which to display column data.
	 *
	 * @return string Column data content.
	 */
	public function outputListTableColumn($output, $key, $termId) {
		foreach($this->listTableColumns as $listTableColumn) {
			if($listTableColumn->getKey() == $key) {
				$output .= $listTableColumn->getOutput($termId);
			}
		}
		return $output;
	}


	/**
	 * Enqueue scripts to be used in the WP admin.
	 *
	 * **Automatically registered on the `admin_enqueue_scripts` action hook.**
	 *
	 * @since 2.3.1
	 *
	 * @param string $hook The current admin page's hook.
	 */
	public function enqueueAdminScripts($hook) {

		if($hook == 'edit-tags.php') {
			wp_enqueue_script('crown-post-taxonomy');
		}

	}


}