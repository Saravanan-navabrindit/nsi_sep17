<?php
/**
 * Contains definition for \Crown\Form\Input\RichTextarea class.
 */

namespace Crown\Form\Input;


/**
 * Form rich textarea input element class.
 *
 * @since 2.0.0
 */
class RichTextarea extends Textarea {

	/**
	 * Enabled media buttons flag.
	 *
	 * @since 2.0.0
	 *
	 * @var boolean
	 */
	protected $mediaButtons;

	/**
	 * Enabled drag & drop upload flag.
	 *
	 * @since 2.0.0
	 *
	 * @var boolean
	 */
	protected $dragDropUpload;

	/**
	 * WP editor initialized flag.
	 *
	 * @since 2.0.0
	 *
	 * @var boolean
	 */
	protected static $isInitialized = false;

	/**
	 * Tiny MCE settings.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $mceSettings = null;

	/**
	 * Quick tags settings.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $qtSettings = null;

	/**
	 * Default rich textarea input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultRichTextareaArgs = array(
		'mediaButtons' => true,
		'dragDropUpload' => false
	);


	/**
	 * Rich textarea input object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __type__ - (string) Input element type.
	 *    * __name__ - (string) Input element name.
	 *    * __label__ - (string) Input label.
	 *    * __defaultValue__ - (string) Default input value.
	 *    * __id__ - (string) Input element ID.
	 *    * __class__ - (string|string[]) Input element class.
	 *    * __required__ - (boolean) Input element required flag.
	 *    * __atts__ - (array) Additional input element attributes.
	 *    * __placeholder__ - (string) Input element placeholder value.
	 *    * __rows__ - (int) Textarea element rows attribute value.
	 *    * __cols__ - (int) Textarea element cols attribute value.
	 *    * __mediaButtons__ - (string) Enabled media buttons flag.
	 *    * __dragDropUpload__ - (string) Enabled drag & drop upload flag.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// parse args into object variables
		$richTextareaArgs = array_merge($this::$defaultRichTextareaArgs, array_intersect_key($args, $this::$defaultRichTextareaArgs));

		// parse args into object variables
		$this->setMediaButtons($richTextareaArgs['mediaButtons']);
		$this->setDragDropUpload($richTextareaArgs['dragDropUpload']);

		// register hooks if class hasn't ever been instantiated
		if(!self::isInitialized()) {
			
			add_action('wp_ajax_get_rich_textarea', array(&$this, 'getAjaxRichTextarea'));

			add_filter('tiny_mce_before_init', get_class($this).'::initMceSettings', 10, 2);
			add_filter('quicktags_settings', get_class($this).'::initQtSettings', 10, 2);

			self::$isInitialized = true;

		}

	}


	/**
	 * Get WP editor initialized flag.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean WP editor initialized flag.
	 */
	public static function isInitialized() {
		return self::$isInitialized;
	}


	/**
	 * Get enabled media buttons flag.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Enabled media buttons flag.
	 */
	public function getMediaButtons() {
		return $this->mediaButtons;
	}


	/**
	 * Get enabled drag & drop upload flag.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Enabled drag & drop upload flag.
	 */
	public function getDragDropUpload() {
		return $this->dragDropUpload;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'richTextarea'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'richTextarea';
	}


	/**
	 * Set enabled media buttons flag.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $mediaButtons Enabled media buttons flag.
	 */
	public function setMediaButtons($mediaButtons) {
		$this->mediaButtons = (bool)$mediaButtons;
	}


	/**
	 * Set enabled drag & drop upload flag.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $dragDropUpload Enabled drag & drop upload flag.
	 */
	public function setDragDropUpload($dragDropUpload) {
		$this->dragDropUpload = (bool)$dragDropUpload;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Input::getOutputAttributes() to build input element's attribute array.
	 * @uses \Crown\Form\Input\Input::convertHtmlAttributes() to convert an associative array into HTML element attributes.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return string Output HTML.
	 */
	public function getOutput($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, array('value' => $this->defaultValue), $args);

		wp_enqueue_script('crown-form-input-rich-textarea');

		$id = !empty($this->id) ? $this->id : sanitize_title($this->name).'-'.rand();
		$settings = array(
			'media_buttons' => $this->mediaButtons,
			'textarea_name' => $this->name,
			'textarea_rows' => $this->rows,
			'editor_class' => implode(' ', $this->class),
			'drag_drop_upload' => $this->dragDropUpload
		);

		if(!empty($args['basename'])) {
			$settings['textarea_name'] = $args['basename'].'['.$settings['textarea_name'].']';
		}

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label'
		));

		ob_start();
		if($args['isTpl']) {
			$hiddenInput = new Hidden(array('class' => 'rich-textarea-settings'));
			$hiddenInputValue = json_encode(array(
				'content' => $args['value'],
				'id' => sanitize_title($this->name).'-',
				'settings' => $settings
			));
			$hiddenInput->output(array('value' => $hiddenInputValue, 'isTpl' => true));
		} else {
			wp_editor($args['value'], $id, $settings);
		}
		if(!empty($this->label)) echo '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';
		return ob_get_clean();

	}


	/**
	 * Output rich textarea to be consumed via AJAX.
	 *
	 * This method is added to the 'wp_ajax_get_rich_textarea' action hook.
	 *
	 * @api
	 * 
	 * @since 2.0.0
	 */
	public function getAjaxRichTextarea() {

		$content = $_GET['content'];
		$id = $_GET['id'];
		$settings = $_GET['settings'];
		$settings = array(
			'media_buttons' => $settings['media_buttons'] == 'true',
			'textarea_name' => $settings['textarea_name'],
			'textarea_rows' => !empty($settings['textarea_rows']) ? intval($settings['textarea_rows']) : get_option('default_post_edit_rows', 10),
			'editor_class' => $settings['editor_class'],
			'drag_drop_upload' => $settings['drag_drop_upload'] == 'true'
		);
		wp_editor($content, $id, $settings);

		$mceInit = $this->getMceInit($id);
		$qtInit = $this->getQtInit($id);
		?>
			<script type="text/javascript">
				tinyMCEPreInit.mceInit = jQuery.extend(tinyMCEPreInit.mceInit, <?php echo $mceInit; ?>);
				tinyMCEPreInit.qtInit = jQuery.extend(tinyMCEPreInit.qtInit, <?php echo $qtInit; ?>);
			</script>
		<?php

		die();
	}


	/**
	 * Save Tiny MCE settings.
	 *
	 * This method is added to the 'tiny_mce_before_init' filter hook.
	 *
	 * @since 2.0.0
	 *
	 * @param array $mceInit Tiny MCE settings.
	 * @param string $editorId WP editor ID.
	 *
	 * @return string Tiny MCE settings.
	 */
	public static function initMceSettings($mceInit, $editorId) {
		self::$mceSettings = $mceInit;
		return $mceInit;
	}


	/**
	 * Save quick tags settings.
	 *
	 * This method is added to the 'quicktags_settings' filter hook.
	 *
	 * @since 2.0.0
	 *
	 * @param array $qtInit Quick tags settings.
	 * @param string $editorId WP editor ID.
	 *
	 * @return string Quick tags settings.
	 */
	public static function initQtSettings($qtInit, $editorId) {
		self::$qtSettings = $qtInit;
		return $qtInit;
	}


	/**
	 * Get Tiny MCE settings.
	 *
	 * @since 2.0.0
	 *
	 * @param string $editorId WP editor ID.
	 *
	 * @return string JSON-formatted Tiny MCE settings.
	 */
	protected function getMceInit($editorId) {
		if(!empty(self::$mceSettings)) {
			$options = $this->parseInit(self::$mceSettings);
			$mceInit = '{'.trim("'$editorId':{$options},", ',').'}';
		} else {
			$mceInit = '{}';
		}
		return $mceInit;
	}


	/**
	 * Get quick tags settings.
	 *
	 * @since 2.0.0
	 *
	 * @param string $editorId WP editor ID.
	 *
	 * @return string JSON-formatted quick tags settings.
	 */
	protected function getQtInit($editorId) {
		if(!empty(self::$qtSettings)) {
			$options = $this->parseInit(self::$qtSettings);
			$qtInit = '{'.trim("'$editorId':{$options},", ',').'}';
		} else {
			$qtInit = '{}';
		}
		return $qtInit;
	}


	/**
	 * Parse plugin settings into JSON-formatted string.
	 *
	 * @since 2.0.0
	 *
	 * @param array $init Plugin settings.
	 *
	 * @return string JSON-formatted settings string.
	 */
	protected function parseInit($init) {
		$options = '';
		foreach($init as $k => $v) {
			if(is_bool($v)) {
				$options .= $k.':'.($v ? 'true' : 'false').',';
				continue;
			} else if(!empty($v) && is_string($v) && (('{' == $v[0] && '}' == $v[strlen($v) - 1]) || ('[' == $v[0] && ']' == $v[strlen($v) - 1]) || preg_match('/^\(?function ?\(/', $v))) {
				$options .= $k.':'.$v.',';
				continue;
			}
			$options .= $k.':"'.$v.'",';
		}
		return '{'.trim($options, ' ,').'}';
	}

}