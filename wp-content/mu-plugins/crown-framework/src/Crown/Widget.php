<?php
/**
 * Contains definition for \Crown\Widget class.
 */

namespace Crown;


/**
 * Widget configuration class.
 *
 * Serves as a handler for configuring widgets in WordPress.
 *
 * @since 2.10.0
 */
class Widget {

	/**
	 * Widget ID.
	 *
	 * @since 2.10.0
	 *
	 * @var string
	 */
	protected $id;

	/**
	 * Widget name.
	 *
	 * @since 2.10.0
	 *
	 * @var string
	 */
	protected $name;
	
	/**
	 * Widget description.
	 *
	 * @since 2.10.0
	 *
	 * @var int
	 */
	protected $description;

	/**
	 * Widget fields.
	 *
	 * @since 2.10.0
	 *
	 * @var \Crown\Form\Field[]
	 */
	protected $fields;

	/**
	 * Pointer to callback function that outputs widget's HTML.
	 *
	 * @since 2.10.0
	 *
	 * @var callback
	 */
	protected $outputCb;

	/**
	 * Widget settings save callback pointer.
	 *
	 * @since 2.10.0
	 *
	 * @var callback
	 */
	protected $saveMetaCb;

	/**
	 * Default widget configuration options.
	 *
	 * @since 2.10.0
	 *
	 * @var array
	 */
	protected static $defaultWidgetArgs = array(
		'id' => '',
		'name' => '',
		'description' => '',
		'fields' => array(),
		'outputCb' => null
	);

	/**
	 * Custom widget class template.
	 *
	 * @since 2.10.0
	 *
	 * @var string
	 */
	protected static $widgetClassTpl = 'class {{widget_classname}} extends \WP_Widget {
		public function __construct() {
			parent::__construct(\'{{widget_id}}\', \'{{widget_name}}\', array(\'description\' => \'{{widget_description}}\'));
		}
		public function widget($args, $instance) {
			call_user_func(\'\Crown\Widget::output\', \'{{widget_id}}\', $args, $instance);
		}
		public function update($newInstance, $oldInstance) {
			return call_user_func(\'\Crown\Widget::updateMeta\', \'{{widget_id}}\', $newInstance, $oldInstance);
		}
		public function form($instance) {
			$inputBasename = substr($this->get_field_name(\'\'), 0, -2);
			call_user_func(\'\Crown\Widget::outputFields\', \'{{widget_id}}\', $inputBasename, $instance);
		}
	}';

	/**
	 * Collection of registered widgets.
	 *
	 * @since 2.10.0
	 *
	 * @var array
	 */
	protected static $registeredWidgets = array();


	/**
	 * Widget object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.10.0
	 *
	 * @param array $args Optional. Page configuration options. Possible arguments:
	 *    * __id__ - (string) Widget ID.
	 *    * __name__ - (string) Widget name.
	 *    * __description__ - (string) Widget description.
	 *    * __fields__ - (\Crown\Form\Field[]) Widget fields.
	 *    * __outputCb__ - (callback) Pointer to callback function that outputs widget's HTML.
	 *    * __saveMetaCb__ - (callback) idget settings save callback pointer.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$widgetArgs = array_merge($this::$defaultWidgetArgs, array_intersect_key($args, $this::$defaultWidgetArgs));

		// parse args into object variables
		$this->setId($widgetArgs['id']);
		$this->setName($widgetArgs['name']);
		$this->setDescription($widgetArgs['description']);
		$this->setFields($widgetArgs['fields']);
		$this->setOutputCb($widgetArgs['outputCb']);

		// register hooks
		add_action('widgets_init', array(&$this, 'register'));

	}


	/**
	 * Get widget ID.
	 *
	 * @since 2.10.0
	 *
	 * @return string Widget ID.
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * Get widget name.
	 *
	 * @since 2.10.0
	 *
	 * @return string Widget name.
	 */
	public function getName() {
		return $this->name;
	}


	/**
	 * Get widget description.
	 *
	 * @since 2.10.0
	 *
	 * @return string Widget description.
	 */
	public function getDescription() {
		return $this->description;
	}


	/**
	 * Get widget fields.
	 *
	 * @since 2.10.0
	 *
	 * @return \Crown\Form\Field[] Widget fields.
	 */
	public function getFields() {
		return $this->fields;
	}


	/**
	 * Get pointer to widget output callback.
	 *
	 * @since 2.10.0
	 *
	 * @return callback Widget output callback pointer.
	 */
	public function getOutputCb() {
		return $this->outputCb;
	}


	/**
	 * Get widget settings save callback pointer.
	 *
	 * @since 2.10.0
	 *
	 * @return callback Widget settings save callback pointer.
	 */
	public function getSaveMetaCb() {
		return $this->outputCb;
	}


	/**
	 * Set widget ID.
	 *
	 * @since 2.10.0
	 *
	 * @param string $id Widget ID.
	 */
	public function setId($id) {
		$this->id = sanitize_title($id);
	}


	/**
	 * Set widget name.
	 *
	 * @since 2.10.0
	 *
	 * @param string $name Widget name.
	 */
	public function setName($name) {
		$this->name = $name;
	}


	/**
	 * Set widget description.
	 *
	 * @since 2.10.0
	 *
	 * @param string $description Widget description.
	 */
	public function setDescription($description) {
		$this->description = $description;
	}


	/**
	 * Set widget fields.
	 *
	 * @since 2.10.0
	 *
	 * @param \Crown\Form\Field[] $fields Widget fields.
	 */
	public function setFields($fields) {
		if(is_array($fields)) $this->fields = $fields;
	}


	/**
	 * Set widget output callback function.
	 *
	 * @since 2.10.0
	 *
	 * @param callback $outputCb Output callback pointer.
	 */
	public function setOutputCb($outputCb) {
		$this->outputCb = $outputCb;
	}


	/**
	 * Set widget settings save callback pointer.
	 *
	 * @since 2.10.0
	 *
	 * @param callback $saveMetaCb Widget settings save callback pointer.
	 */
	public function setSaveMetaCb($saveMetaCb) {
		$this->saveMetaCb = $saveMetaCb;
	}


	/**
	 * Add widget field.
	 *
	 * @since 2.10.0
	 *
	 * @param \Crown\Form\Field $field Widget field.
	 */
	public function addField($field) {
		$this->fields[] = $field;
	}


	/**
	 * Register the widget with WordPress.
	 *
	 * **Automatically registered on the `widgets_init` action hook.**
	 *
	 * @since 2.10.0
	 */
	public function register() {
		global $wp_registered_widgets;

		if(empty($this->id)) return false;
		if(empty($this->name)) return false;
		if(isset($wp_registered_widgets[$this->id])) return false;

		$widgetClassname = 'CrownWidget_'.str_replace('-', '_', $this->id);

		$search = array('{{widget_classname}}', '{{widget_id}}', '{{widget_name}}', '{{widget_description}}');
		$replace = array($widgetClassname, $this->id, $this->name, $this->description);
		$widgetClass = str_replace($search, $replace, self::$widgetClassTpl);
		eval($widgetClass);

		register_widget($widgetClassname);
		self::$registeredWidgets[$this->id] = $this;

	}


	/**
	 * Output the widget HTML.
	 *
	 * @since 2.10.0
	 *
	 * @param array $args Display arguments.
	 * @param array $widgetIndex Optional, internal order number of the widget instance.
	 */
	public static function output($id, $args, $instance) {
		echo self::getOutput($id, $args, $instance);
	}


	/**
	 * Get the widget HTML output.
	 *
	 * @since 2.10.0
	 *
	 * @param array $args Display arguments.
	 * @param array $widgetIndex Optional, internal order number of the widget instance.
	 */
	public static function getOutput($id, $args, $instance) {
		$widget = array_key_exists($id, self::$registeredWidgets) ? self::$registeredWidgets[$id] : false;
		if(!$widget) return;

		// output widget
		if(is_callable($widget->outputCb)) {
			ob_start();
			call_user_func($widget->outputCb, $args, $instance);
			return ob_get_clean();
		}

		return '';
	}


	/**
	 * Output the widget's fields.
	 *
	 * The fields added to the `$field` property are output, along with a nonce
	 * field to be verified upon submission.
	 *
	 * @since 2.10.0
	 *
	 * @param array $widgetIndex Optional, internal order number of the widget instance.
	 */
	public static function outputFields($id, $inputBasename, $instance) {
		$widget = array_key_exists($id, self::$registeredWidgets) ? self::$registeredWidgets[$id] : false;
		if(!$widget) return;

		$fields = $widget->getFields();
		if(empty($fields)) echo '<p class="no-options-widget">There are no options for this widget.</p>';

		// add nonce field
		// wp_nonce_field('crown_save_widget_'.$widget->getId(), 'nonce_widget_'.$widget->getId());

		foreach($fields as $field) {
			// $fieldValue = $field->getValue('widget', $post->ID);
			$fieldValue = array_key_exists($field->getInputName(), $instance) ? $instance[$field->getInputName()] : $field->getValue();
			$field->output(array('value' => $fieldValue, 'objectId' => null, 'basename' => $inputBasename));
		}

	}


	/**
	 * Update widget instance's meta data.
	 *
	 * The fields added to the `$field` property are output, along with a nonce
	 * field to be verified upon submission.
	 *
	 * @since 2.10.0
	 *
	 * @param string $id Widget ID.
	 * @param array $newInstance Meta data for new widget instance.
	 * @param array $oldInstance Meta data for old widget instance.
	 */
	public static function updateMeta($id, $newInstance, $oldInstance) {
		$widget = array_key_exists($id, self::$registeredWidgets) ? self::$registeredWidgets[$id] : false;
		if(!$widget) return $newInstance;

		if(is_callable($widget->saveMetaCb)) {
			return call_user_func($widget->saveMetaCb, $newInstance, $oldInstance);
		}
		return $newInstance;
	}


}