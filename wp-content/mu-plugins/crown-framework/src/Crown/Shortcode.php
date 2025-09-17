<?php
/**
 * Contains definition for \Crown\Shortcode class.
 */

namespace Crown;


/**
 * Shortcode configuration class.
 *
 * Serves as a handler for shortcode registration.
 *
 * @since 2.0.0
 */
class Shortcode {

	/**
	 * Shortcode tag name.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $tag;

	/**
	 * Pointer to callback function that generates shortcode's HTML.
	 *
	 * @since 2.0.0
	 *
	 * @var callback
	 */
	protected $getOutputCb;

	/**
	 * Default shortcode attributes.
	 *
	 * Runtime shortcode attributes will be merged with this array and passed to output callback.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected $defaultAtts;

	/**
	 * Default shortcode input content.
	 *
	 * Runtime shortcode content, if provided, will override this value when passed to output callback.
	 *
	 * @since 2.0.0
	 *
	 * @var string
	 */
	protected $defaultContent;

	/**
	 * Whether the shortcode should be processed before the 'the_content' filter's auto p script.
	 *
	 * @since 2.0.0
	 *
	 * @var boolean
	 */
	protected $preprocess;

	/**
	 * Default shortcode configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultShortcodeArgs = array(
		'tag' => '',
		'getOutputCb' => null,
		'defaultAtts' => array(),
		'defaultContent' => '',
		'preprocess' => false
	);


	/**
	 * Shortcode object constructor.
	 *
	 * Parses configuration options into object properties and registers relevant action/filter hooks.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args Optional. Shortcode configuration options. Possible arguments:
	 *    * __tag__ - (string) Shortcode tag name.
	 *    * __outputCb__ - (callback) Pointer to callback function that generates shortcode's HTML.
	 *    * __defaultAtts__ - (array) Default shortcode attributes.
	 *    * __defaultContent__ - (string) Default shortcode input content.
	 *    * __preprocess__ - (boolean) Whether the shortcode should be processed before the 'the_content' filter's auto p script.
	 */
	public function __construct($args = array()) {

		// merge options with defaults
		$shortcodeArgs = array_merge($this::$defaultShortcodeArgs, array_intersect_key($args, $this::$defaultShortcodeArgs));

		// parse options into object properties
		$this->setTag($shortcodeArgs['tag']);
		$this->setGetOutputCb($shortcodeArgs['getOutputCb']);
		$this->setDefaultAtts($shortcodeArgs['defaultAtts']);
		$this->setDefaultContent($shortcodeArgs['defaultContent']);
		$this->setPreprocess($shortcodeArgs['preprocess']);

		// register hooks
		add_action('init', array(&$this, 'register'));

	}


	/**
	 * Get tag name.
	 *
	 * @since 2.0.0
	 *
	 * @return string Tag name.
	 */
	public function getTag() {
		return $this->tag;
	}


	/**
	 * Get output callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @return callback Output callback pointer.
	 */
	public function getGetOutputCb() {
		return $this->getOutputCb;
	}


	/**
	 * Get default shortcode attributes.
	 *
	 * @since 2.0.0
	 *
	 * @return array Default shortcode attributes.
	 */
	public function getDefaultAtts() {
		return $this->defaultAtts;
	}


	/**
	 * Get default shortcode input content.
	 *
	 * @since 2.0.0
	 *
	 * @return string Default shortcode input content.
	 */
	public function getDefaultContent() {
		return $this->defaultContent;
	}


	/**
	 * Get preprocess flag.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Preprocess flag.
	 */
	public function getPreprocess() {
		return $this->preprocess;
	}


	/**
	 * Set tag name.
	 *
	 * @since 2.0.0
	 *
	 * @param string $tag Tag name.
	 */
	public function setTag($tag) {
		$this->tag = $tag;
	}


	/**
	 * Set output callback pointer.
	 *
	 * @since 2.0.0
	 *
	 * @param callback $getOutputCb Output callback pointer.
	 */
	public function setGetOutputCb($getOutputCb) {
		$this->getOutputCb = $getOutputCb;
	}


	/**
	 * Set default shortcode attributes.
	 *
	 * @since 2.0.0
	 *
	 * @param array $defaultAtts Default shortcode attributes.
	 */
	public function setDefaultAtts($defaultAtts) {
		if(is_array($defaultAtts)) $this->defaultAtts = $defaultAtts;
	}


	/**
	 * Set default shortcode input content.
	 *
	 * @since 2.0.0
	 *
	 * @param string $defaultContent Default shortcode input content.
	 */
	public function setDefaultContent($defaultContent) {
		$this->defaultContent = $defaultContent;
	}


	/**
	 * Set preprocess flag.
	 *
	 * @since 2.0.0
	 *
	 * @param boolean $preprocess Preprocess flag.
	 */
	public function setPreprocess($preprocess) {
		$this->preprocess = (bool)$preprocess;
	}


	/**
	 * Asserts if shortcode should be processed before auto p function.
	 *
	 * @since 2.0.0
	 *
	 * @return boolean Whether shortcode should be preprocessed.
	 */
	public function isPreprocess() {
		return $this->preprocess;
	}


	/**
	 * Register the shortcode with WordPress.
	 *
	 * This method is added to the 'init' action hook.
	 *
	 * @since 2.0.0
	 */
	public function register() {
		if(empty($this->tag)) return false;
		if(empty($this->getOutputCb)) return false;

		// add shortcode
		if($this->preprocess) {
			add_preprocess_shortcode($this->tag, array(&$this, 'getOutput'));
		} else {
			add_shortcode($this->tag, array(&$this, 'getOutput'));
		}

	}


	/**
	 * Get the shortcode's output HTML.
	 *
	 * Merges shortcode attributes and content with defaults and passes to output callback.
	 *
	 * @since 2.0.0
	 *
	 * @param array $atts Optional. Shortcode attributes. By default, will be merged with default shortcode attributes.
	 * @param string $content Optional. Shortcode input content. By default, will use default shortcode input content.
	 *
	 * @return string Shortcode output HTML.
	 */
	public function getOutput($atts = array(), $content = '') {
		if(!is_callable($this->getOutputCb)) return '';

		// parse with defaults
		$atts = shortcode_atts($this->defaultAtts, $atts);
		$content = empty($content) ? $this->defaultContent : $content;

		// get shortcode's output
		return call_user_func($this->getOutputCb, $atts, $content);

	}


}