<?php
/**
 * Contains definition for \Crown\Post\MetaBox class.
 */

namespace Crown\Post;


/**
 * Post meta box configuration class.
 *
 * Serves as a handler for post meta box registration.
 *
 * ```
 * $caseStudyDetailsMetaBox = new MetaBox(array(
 *     'id' => 'case-study-details',
 *     'title' => 'Details',
 *     'context' => 'side',
 *     'priority' => 'core',
 *     'fields' => array(
 *         new Field(array(
 *             'label' => 'Client Name',
 *             'input' => new TextInput(array('name' => 'case_study_client_name'))
 *         )),
 *         new Field(array(
 *             'label' => 'Case Study Type',
 *             'input' => new TextInput(array('name' => 'case_study_type'))
 *         ))
 *     )
 * ));
 * ```
 *
 * Meta box objects are generally added to `/Crown/Post/Type` objects where the
 * necessary action and filter hooks are registered for handling the meta box'
 * functionality.
 *
 * @since 2.0.0
 */
class MetaBox {

	/**
	 * Meta box element ID.
	 *
	 * The unique ID for the particular meta box. This ID is used in the HTML
	 * generated for the meta box in the admin interface for editing a post.
	 *
	 * @see \Crown\Post\MetaBox::getId()
	 * @see \Crown\Post\MetaBox::setId()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Meta box element class.
	 *
	 * The classes to add to the meta box HTML element in the post editor.
	 *
	 * @see \Crown\Post\MetaBox::getClass()
	 * @see \Crown\Post\MetaBox::setClass()
	 *
	 * @since 2.1.0
	 *
	 * @var string[]
	 */
	protected $class;

	/**
	 * Meta box title.
	 *
	 * The title for the meta box displays in the header of the meta box
	 * element in the post editor.
	 *
	 * @see \Crown\Post\MetaBox::getTitle()
	 * @see \Crown\Post\MetaBox::setTitle()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * Section of the page to display meta box.
	 *
	 * The area of the post editor page where the meta box should be shown.
	 *
	 * Possible values: `'normal'`, `'advanced'`, or `'side'`. By default,
	 * meta box shown in the normal section.
	 *
	 * @see \Crown\Post\MetaBox::getContext()
	 * @see \Crown\Post\MetaBox::setContext()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $context;

	/**
	 * The priority within the context where the meta box should display.
	 *
	 * Priority is relative to other meta boxes within the same context of the
	 * post editor page.
	 *
	 * Possible values: `'high'`, `'core'`, `'default'`, or `'low'`. By default,
	 * meta box shown with a default priority.
	 *
	 * @see \Crown\Post\MetaBox::getPriority()
	 * @see \Crown\Post\MetaBox::setPriority()
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $priority;

	/**
	 * Meta box content output callback pointer.
	 *
	 * If a callback function is defined for the meta box' output,
	 * that function will be called instead of outputting any fields
	 * assigned to the meta box.
	 *
	 * ```
	 * function myMetaBoxOutputCb($post, $args, $fields) {
	 *     // custom output script goes here...
	 * }
	 * ```
	 *
	 * The callback function should accept three parameters:
	 *    * __`$post`__ - (`WP_Post`) Post object for which to display meta box.
	 *    * __`$args`__ - (`array`) Additional arguments defined in the meta box' `$outputCbArgs` property.
	 *    * __`$fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that have been registered for the meta box.
	 *
	 * @see \Crown\Post\MetaBox::getOutputCb()
	 * @see \Crown\Post\MetaBox::setOutputCb()
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $outputCb;

	/**
	 * Additional arguments to pass to meta box content output callback.
	 *
	 * If a callback function is defined for the meta box' output,
	 * this property will be passed in as one of the parameters to that function.
	 *
	 * @see \Crown\Post\MetaBox::getOutputCbArgs()
	 * @see \Crown\Post\MetaBox::setOutputCbArgs()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $outputCbArgs;

	/**
	 * Meta box settings save callback pointer.
	 *
	 * The save meta callback function, if set, will be called after any fields
	 * associated with the meta box have already been saved.
	 *
	 * ```
	 * function myMetaBoxSaveMetaCb($post, $input, $args, $fields) {
	 *     // custom meta data save script goes here...
	 * }
	 * ```
	 *
	 * The callback function should accept three parameters:
	 *    * __`$post`__ - (`WP_Post`) Post object for which to display meta box.
	 *    * __`$input`__ - (`array`) Set of input data submitted by form.
	 *    * __`$args`__ - (`array`) Additional arguments defined in the meta box' `$saveMetaCbArgs` property.
	 *    * __`$fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that have been registered for the meta box.
	 *
	 * @see \Crown\Post\MetaBox::getSaveMetaCb()
	 * @see \Crown\Post\MetaBox::setSaveMetaCb()
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $saveMetaCb;

	/**
	 * Additional arguments to pass to meta box settings save callback.
	 *
	 * If a callback function is defined for when saving the meta box' meta
	 * data, this property will be passed in as one of the parameters to that
	 * function.
	 *
	 * @see \Crown\Post\MetaBox::getSaveMetaCbArgs()
	 * @see \Crown\Post\MetaBox::setSaveMetaCbArgs()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $saveMetaCbArgs;

	/**
	 * Fields that appear in the meta box.
	 *
	 * @see \Crown\Post\MetaBox::getFields()
	 * @see \Crown\Post\MetaBox::setFields()
	 * @see \Crown\Post\MetaBox::addField()
	 *
	 * @since 2.0.0
	 *
	 * @var \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[]
	 */
	protected $fields;

	/**
	 * UI visibility rules.
	 *
	 * The rules defined for the meta box control the conditions in which the
	 * box should be visible on the post editor page.
	 *
	 * @see \Crown\Post\MetaBox::getUIRules()
	 * @see \Crown\Post\MetaBox::setUIRules()
	 *
	 * @since 2.1.0
	 *
	 * @var \Crown\UIRule[]
	 */
	protected $uIRules;

	/**
	 * Default meta box configuration options.
	 *
	 * These options can be overridden by passing in an array of arguments when
	 * constructing a `MetaBox` object.
	 *
	 * ```
	 * $defaultPostMetaBoxArgs = array(
	 *     'id' => '',
	 *     'class' => '',
	 *     'title' => '',
	 *     'context' => 'normal',
	 *     'priority' => 'default',
	 *     'outputCb' => null,
	 *     'outputCbArgs' => array(),
	 *     'saveMetaCb' => null,
	 *     'saveMetaCbArgs' => array(),
	 *     'fields' => array(),
	 *     'uIRules' => array()
	 * );
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::__construct()
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultPostMetaBoxArgs = array(
		'id' => '',
		'class' => '',
		'title' => '',
		'context' => 'normal',
		'priority' => 'default',
		'outputCb' => null,
		'outputCbArgs' => array(),
		'saveMetaCb' => null,
		'saveMetaCbArgs' => array(),
		'fields' => array(),
		'uIRules' => array()
	);


	/**
	 * Meta box object constructor.
	 *
	 * Parses configuration options into object properties. Passed in options
	 * array overrides those found in `$defaultPostMetaBoxArgs` property.
	 *
	 * ```
	 * $caseStudyDetailsMetaBox = new MetaBox(array(
	 *     'id' => 'case-study-details',
	 *     'title' => 'Details',
	 *     'context' => 'side',
	 *     'priority' => 'core',
	 *     'fields' => array(
	 *         new Field(array(
	 *             'label' => 'Client Name',
	 *             'input' => new TextInput(array('name' => 'case_study_client_name'))
	 *         )),
	 *         new Field(array(
	 *             'label' => 'Case Study Type',
	 *             'input' => new TextInput(array('name' => 'case_study_type'))
	 *         ))
	 *     )
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$defaultPostMetaBoxArgs
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __`id`__ - (`string`) Meta box element ID.
	 *    * __`class`__ - (`string`|`string[]`) Meta box element class.
	 *    * __`title`__ - (`string`) Meta box title.
	 *    * __`context`__ - (`string`) Section of the page to display meta box. Possible values: `'normal'`, `'advanced'`, or `'side'`.
	 *    * __`priority`__ - (`string`) The priority within the context where the meta box should display. Possible values: `'high'`, `'core'`, `'default'`, or `'low'`.
	 *    * __`outputCb`__ - (`callback`) Meta box content output callback pointer.
	 *    * __`outputCbArgs`__ - (`array`) Additional arguments to pass to meta box content output callback.
	 *    * __`saveMetaCb`__ - (`callback`) Meta box settings save callback pointer.
	 *    * __`saveMetaCbArgs`__ - (`array`) Additional arguments to pass to meta box settings save callback.
	 *    * __`fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that appear in meta box.
	 *    * __`uIRules`__ - (`UIRule[]`) UI visibility rules.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$postMetaBoxArgs = array_merge($this::$defaultPostMetaBoxArgs, array_intersect_key($args, $this::$defaultPostMetaBoxArgs));

		// parse args into object variables
		$this->setId($postMetaBoxArgs['id']);
		$this->setClass($postMetaBoxArgs['class']);
		$this->setTitle($postMetaBoxArgs['title']);
		$this->setContext($postMetaBoxArgs['context']);
		$this->setPriority($postMetaBoxArgs['priority']);
		$this->setOutputCb($postMetaBoxArgs['outputCb']);
		$this->setOutputCbArgs($postMetaBoxArgs['outputCbArgs']);
		$this->setSaveMetaCb($postMetaBoxArgs['saveMetaCb']);
		$this->setSaveMetaCbArgs($postMetaBoxArgs['saveMetaCbArgs']);
		$this->setFields($postMetaBoxArgs['fields']);
		$this->setUIRules($postMetaBoxArgs['uIRules']);

	}


	/**
	 * Get meta box element ID.
	 *
	 * ```
	 * $id = $myMetaBox->getId();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$id
	 *
	 * @since 2.0.0
	 *
	 * @return string Meta box element ID.
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * Get meta box element class.
	 *
	 * ```
	 * $class = $myMetaBox->getClass();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$class
	 *
	 * @since 2.1.0
	 *
	 * @return string[] Meta box element class.
	 */
	public function getClass() {
		return $this->class;
	}


	/**
	 * Get meta box title.
	 *
	 * ```
	 * $title = $myMetaBox->getTitle();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$title
	 *
	 * @since 2.0.0
	 *
	 * @return string Meta box title.
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * Get section of the page to display meta box.
	 *
	 * ```
	 * $context = $myMetaBox->getContext();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$context
	 *
	 * @since 2.0.0
	 *
	 * @return string Meta box context.
	 */
	public function getContext() {
		return $this->context;
	}


	/**
	 * Get the priority within the context where the meta box should display.
	 *
	 * ```
	 * $priority = $myMetaBox->getPriority();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$priority
	 *
	 * @since 2.0.0
	 *
	 * @return string Meta box priority.
	 */
	public function getPriority() {
		return $this->priority;
	}


	/**
	 * Get meta box content output callback pointer.
	 *
	 * ```
	 * $outputCb = $myMetaBox->getOutputCb();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$outputCb
	 *
	 * @since 2.0.0
	 *
	 * @return callback Content output callback.
	 */
	public function getOutputCb() {
		return $this->outputCb;
	}


	/**
	 * Get additional arguments to pass to meta box content output callback.
	 *
	 * ```
	 * $outputCbArgs = $myMetaBox->getOutputCbArgs();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$outputCbArgs
	 *
	 * @since 2.0.0
	 *
	 * @return array Output arguments.
	 */
	public function getOutputCbArgs() {
		return $this->outputCbArgs;
	}


	/**
	 * Get meta box settings save callback pointer.
	 *
	 * ```
	 * $saveMetaCb = $myMetaBox->getSaveMetaCb();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$saveMetaCb
	 *
	 * @since 2.0.0
	 *
	 * @return callback Settings save callback.
	 */
	public function getSaveMetaCb() {
		return $this->saveMetaCb;
	}


	/**
	 * Get additional arguments to pass to meta box settings save callback.
	 *
	 * ```
	 * $saveMetaCbArgs = $myMetaBox->getSaveMetaCbArgs();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$saveMetaCbArgs
	 *
	 * @since 2.0.0
	 *
	 * @return array Save callback arguments.
	 */
	public function getSaveMetaCbArgs() {
		return $this->saveMetaCbArgs;
	}


	/**
	 * Get fields that appear in meta box.
	 *
	 * ```
	 * $fields = $myMetaBox->getFields();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$fields
	 *
	 * @since 2.0.0
	 *
	 * @return \Crown\Form\Field Meta box fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Get UI visibility rules.
	 *
	 * ```
	 * $uIRules = $myMetaBox->getUIRules();
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$uIRules
	 *
	 * @since 2.1.0
	 *
	 * @return array UI visibility rules.
	 */
	public function getUIRules() {
		return $this->uIRules;
	}


	/**
	 * Set meta box element ID.
	 *
	 * ```
	 * $myMetaBox->setId('my-meta-box');
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$id
	 *
	 * @since 2.0.0
	 *
	 * @param string $id Meta box element ID.
	 */
	public function setId($id) {
		$this->id = $id;
	}


	/**
	 * Set meta box element class.
	 *
	 * ```
	 * $myMetaBox->setClass('class-one class-two');
	 * ```
	 *
	 * ```
	 * $myMetaBox->setClass(array('class-one', 'class-two'));
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$class
	 *
	 * @since 2.1.0
	 *
	 * @uses \Crown\Post\MetaBox::parseClasses() to parse meta box class into array.
	 *
	 * @param string|string[] $class List of meta box element classes.
	 */
	public function setClass($class) {
		$this->class = $this->parseClasses($class);
	}


	/**
	 * Set meta box title.
	 *
	 * ```
	 * $myMetaBox->setTitle('My Meta Box');
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$title
	 *
	 * @since 2.0.0
	 *
	 * @param string $title Meta box title.
	 */
	public function setTitle($title) {
		$this->title = $title;
	}


	/**
	 * Set section of the page to display meta box.
	 *
	 * ```
	 * $myMetaBox->setContext('normal');
	 * ```
	 *
	 * Possible values: `'normal'`, `'advanced'`, or `'side'`.
	 *
	 * @see \Crown\Post\MetaBox::$context
	 *
	 * @since 2.0.0
	 *
	 * @param string $context Meta box context.
	 */
	public function setContext($context) {
		$this->context = $context;
	}


	/**
	 * Set the priority within the context where the meta box should display.
	 *
	 * ```
	 * $myMetaBox->setPriority('default');
	 * ```
	 *
	 * Possible values: `'high'`, `'core'`, `'default'`, or `'low'`.
	 *
	 * @see \Crown\Post\MetaBox::$priority
	 *
	 * @since 2.0.0
	 *
	 * @param string $priority Meta box priority.
	 */
	public function setPriority($priority) {
		$this->priority = $priority;
	}


	/**
	 * Set meta box content output callback pointer.
	 *
	 * ```
	 * function myMetaBoxOutputCb($post, $args, $fields) {
	 *     // custom output script goes here...
	 * }
	 * $myMetaBox->setOutputCb('myMetaBoxOutputCb');
	 * ```
	 *
	 * The callback function should accept three parameters:
	 *    * __`$post`__ - (`WP_Post`) Post object for which to display meta box.
	 *    * __`$args`__ - (`array`) Additional arguments defined in the meta box' `$outputCbArgs` property.
	 *    * __`$fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that have been registered for the meta box.
	 *
	 * @see \Crown\Post\MetaBox::$outputCb
	 *
	 * @since 2.0.0
	 *
	 * @param callback $outputCb Content output callback.
	 */
	public function setOutputCb($outputCb) {
		$this->outputCb = $outputCb;
	}


	/**
	 * Set additional arguments to pass to meta box content output callback.
	 *
	 * ```
	 * $myMetaBox->setOutputCbArgs($args);
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$outputCbArgs
	 *
	 * @since 2.0.0
	 *
	 * @param array $outputCbArgs Output arguments.
	 */
	public function setOutputCbArgs($outputCbArgs) {
		if(is_array($outputCbArgs)) $this->outputCbArgs = $outputCbArgs;
	}


	/**
	 * Set meta box settings save callback pointer.
	 *
	 * ```
	 * function myMetaBoxSaveMetaCb($post, $input, $args, $fields) {
	 *     // custom meta data save script goes here...
	 * }
	 * $myMetaBox->setSaveMetaCb('myMetaBoxSaveMetaCb');
	 * ```
	 *
	 * The callback function should accept three parameters:
	 *    * __`$post`__ - (`WP_Post`) Post object for which to display meta box.
	 *    * __`$input`__ - (`array`) Set of input data submitted by form.
	 *    * __`$args`__ - (`array`) Additional arguments defined in the meta box' `$saveMetaCbArgs` property.
	 *    * __`$fields`__ - (`Field[]`|`FieldGroup[]`|`FieldRepeater[]`) Fields that have been registered for the meta box.
	 *
	 * @see \Crown\Post\MetaBox::$saveMetaCb
	 *
	 * @since 2.0.0
	 *
	 * @param callback $saveMetaCb Settings save callback.
	 */
	public function setSaveMetaCb($saveMetaCb) {
		$this->saveMetaCb = $saveMetaCb;
	}


	/**
	 * Set additional arguments to pass to meta box settings save callback.
	 *
	 * ```
	 * $myMetaBox->setSaveMetaCbArgs($args);
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$saveMetaCbArgs
	 *
	 * @since 2.0.0
	 *
	 * @param array $saveMetaCbArgs Save callback arguments.
	 */
	public function setSaveMetaCbArgs($saveMetaCbArgs) {
		if(is_array($saveMetaCbArgs)) $this->saveMetaCbArgs = $saveMetaCbArgs;
	}


	/**
	 * Set fields that appear in meta box.
	 *
	 * ```
	 * $myMetaBox->setFields(array(
	 *     new Field(array(
	 *         'label' => 'Custom Field 1',
	 *         'input' => new Text(array('name' => 'my_meta_box_custom_field_1'))
	 *     )),
	 *     new Field(array(
	 *         'label' => 'Custom Field 2',
	 *         'input' => new Text(array('name' => 'my_meta_box_custom_field_2'))
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$fields
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field[]|\Crown\Form\FieldGroup[]|\Crown\Form\FieldRepeater[] $fields Meta box fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Set UI visibility rules.
	 *
	 * ```
	 * $myMetaBox->setUIRules(array(
	 *     new UIRule(array(
	 *         'property' => 'pageTemplate',
	 *         'compare' => 'in',
	 *         'value' => array('page-tpl-contact.php', 'page-tpl-feedback.php')
	 *     ))
	 * ));
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$uIRules
	 *
	 * @since 2.1.0
	 *
	 * @param array $uIRules UI visibility rules.
	 */
	public function setUIRules($uIRules) {
		if(is_array($uIRules)) $this->uIRules = $uIRules;
	}


	/**
	 * Add field to meta box.
	 *
	 * ```
	 * $myMetaBox->addField(new Field(array(
	 *     'label' => 'Custom Field',
	 *     'input' => new Text(array('name' => 'my_meta_box_custom_field'))
	 * )));
	 * ```
	 *
	 * @see \Crown\Post\MetaBox::$fields
	 *
	 * @since 2.0.0
	 *
	 * @param \Crown\Form\Field|\Crown\Form\FieldGroup|\Crown\Form\FieldRepeater $field New field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Register the post meta box with WordPress.
	 *
	 * **Note:** If the meta box is configured to be a part of a
	 * `/Crown/Post/Type` object, the `register()` method will be invoked
	 * automatically by the post type object.
	 *
	 * ```
	 * $myMetaBox->register('post');
	 * ```
	 *
	 * ```
	 * $myMetaBox->register(array('post', 'page'));
	 * ```
	 *
	 * This method uses the [`add_meta_box()`](https://codex.wordpress.org/Function_Reference/add_meta_box)
	 * core WordPress function for registering the meta box for the post type.
	 *
	 * @since 2.0.0
	 *
	 * @param string|string[] $postType Post type or collection of post types to add meta box to.
	 */
	public function register($postType) {
		if(empty($this->id)) return;
		if(empty($this->title)) return;
		if(empty($postType)) return;

		// build post type array
		$postTypes = array($postType);
		if(is_array($postType)) {
			$postTypes = $postType;
		}

		// add meta box for each post type
		foreach($postTypes as $pt) {
			add_meta_box($this->id, $this->title, array(&$this, 'output'), $pt, $this->context, $this->priority, $this->outputCbArgs);
			add_filter('postbox_classes_'.$pt.'_'.$this->id, array(&$this, 'filterClasses'));
		}

	}


	/**
	 * Output the meta box content.
	 *
	 * **Automatically set as a callback in the `register` method.**
	 *
	 * If the meta box' output callback property is defined, that
	 * function will be called. Otherwise, all the fields registered
	 * for the meta box will be output. A nonce field is output at this time as
	 * well, for security purposes. Additionally, if any UI rules have been
	 * configured for the meta box, some javascript is output to initialize
	 * the conditional handling.
	 *
	 * @see \Crown\Post\MetaBox::$outputCb
	 *
	 * @since 2.0.0
	 *
	 * @param \WP_Post $post Post object for which to display meta box.
	 * @param array $args Meta box output arguments.
	 */
	public function output($post, $args) {

		// output meta box fields
		if(is_callable($this->outputCb)) {
			// custom meta box field output
			call_user_func($this->outputCb, $post, $args, $this->fields);
		} else {
			// default field output
			foreach($this->fields as $field) {
				$fieldValue = $field->getValue('post', $post->ID);
				$field->output(array('value' => $fieldValue, 'objectId' => $post->ID));
			}
		}

		// add nonce field
		wp_nonce_field('save_meta_box_'.$this->id, 'nonce_meta_box_'.$this->id);

		// build rule attributes
		if(!empty($this->uIRules)) {
			$rulesAtts = array();
			foreach($this->uIRules as $uIRule) {
				$property = $uIRule->getProperty();
				if(!empty($property)) {
					$rulesAtts[] = array(
						'property' => $property,
						'compare' => $uIRule->getCompare(),
						'value' => $uIRule->getValue(),
						'options' => $uIRule->getOptions(),
						'passed' => $uIRule->evaluate($post->ID)
					);
				}
			}
			?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery.crownUIRule.initMetaBox('<?php echo $this->id; ?>', <?php echo json_encode($rulesAtts); ?>);
					});
				</script>
			<?php
		}

	}


	/**
	 * Save meta box's metadata for a post.
	 *
	 * **Note:** If the meta box is configured to be a part of a
	 * `/Crown/Post/Type` object, the `saveMeta()` method will be invoked
	 * automatically by the post type object.
	 *
	 * Meta data to be saved is collected from `$input` parameter array. A
	 * nonce field is verified before saving to the database.
	 *
	 * ```
	 * $myMetaBox->saveMeta($post, $_POST);
	 * ```
	 *
	 * @since 2.0.0
	 *
	 * @param \WP_Post $post Post object for which to save metadata.
	 * @param array $input Submitted form data.
	 */
	public function saveMeta($post, $input) {

		// verify nonce field
		if(!isset($_POST['nonce_meta_box_'.$this->id]) || !wp_verify_nonce($_POST['nonce_meta_box_'.$this->id], 'save_meta_box_'.$this->id)) return $post->ID;

		// save meta box fields
		foreach($this->fields as $field) {
			$field->saveValue($input, 'post', $post->ID);
		}

		// additional custom meta box data saving
		if(is_callable($this->saveMetaCb)) call_user_func($this->saveMetaCb, $post, $input, $this->saveMetaCbArgs, $this->fields);

	}


	/**
	 * Restore meta box's metadata for a post from a revision.
	 *
	 * **Note:** If the meta box is configured to be a part of a
	 * `/Crown/Post/Type` object, the `restoreMeta()` method will be invoked
	 * automatically by the post type object.
	 *
	 * Only data associated with the fields registered to the `MetaBox` object
	 * will be affected.
	 *
	 * ```
	 * $myMetaBox->restoreMeta($postId, $revisionId);
	 * ```
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

	}


	/**
	 * Parse class argument into array.
	 *
	 * If passed in `$class` parameter is a string, it's split up into an
	 * array. Each class in the array is trimmed of extra whitespace and then
	 * verified to not be an empty string before being returned.
	 *
	 * @since 2.1.0
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
	 * Filter default meta box classes.
	 *
	 * **Automatically registered on the `postbox_classes_${post_type}_${meta_box_id}` filter hook.**
	 *
	 * Filtered class list is merged with those set in meta box' `$class`
	 * property. Special conditional classes based on any defined UI rules
	 * are also added to the class list.
	 *
	 * @see \Crown\Post\MetaBox::$class
	 *
	 * @since 2.1.0
	 *
	 * @param string[] $classes Class names to filter.
	 *
	 * @return string[] Filtered meta box classes.
	 */
	public function filterClasses($classes = array()) {
		global $post;

		$classes = array_merge($classes, $this->class);

		$classes[] =  'field-count-'.count($this->fields);

		// add UI rules classes
		if(!empty($this->uIRules)) {
			$classes[] = 'conditional-ui';
			$active = true;
			foreach($this->uIRules as $uIRule) {
				$property = $uIRule->getProperty();
				if(!empty($property)) {
					$classes[] = 'conditional-ui-property-'.$property;
				}
				if(!$uIRule->evaluate($post->ID)) $active = false;
			}
			if($active) {
				$classes[] = 'conditional-ui-active';
			}
		}

		return $classes;

	}

}