<?php
/**
 * Contains definition for \Crown\Form\Input\Media class.
 */

namespace Crown\Form\Input;


/**
 * Form media input element class.
 *
 * @since 2.0.0
 */
class Media extends Input {

	/**
	 * Select media button label.
	 *
	 * @var string
	 */
	protected $buttonLabel;

	/**
	 * Media mime type restriction.
	 *
	 * @var string
	 */
	protected $mimeType;

	/**
	 * Default media input configuration options.
	 *
	 * @since 2.0.0
	 *
	 * @var array
	 */
	protected static $defaultMediaInputArgs = array(
		'buttonLabel' => 'Select File',
		'mimeType' => ''
	);


	/**
	 * Input object constructor.
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
	 *    * __buttonLabel__ - (string) Select media button label.
	 *    * __mimeType__ - (string) Media mime type restriction.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// parse args into object variables
		$mediaInputArgs = array_merge($this::$defaultMediaInputArgs, array_intersect_key($args, $this::$defaultMediaInputArgs));

		// parse args into object variables
		$this->setButtonLabel($mediaInputArgs['buttonLabel']);
		$this->setMimeType($mediaInputArgs['mimeType']);

	}


	/**
	 * Get select media button label.
	 *
	 * @since 2.0.0
	 *
	 * @return string Select media button label.
	 */
	public function getButtonLabel() {
		return $this->buttonLabel;
	}


	/**
	 * Get media mime type restriction.
	 *
	 * @since 2.0.0
	 *
	 * @return string Media mime type restriction.
	 */
	public function getMimeType() {
		return $this->mimeType;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'media'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'media';
	}


	/**
	 * Set select media button label.
	 *
	 * @since 2.0.0
	 *
	 * @param string $buttonLabel Select media button label.
	 */
	public function setButtonLabel($buttonLabel) {
		$this->buttonLabel = $buttonLabel;
	}


	/**
	 * Set media mime type restriction.
	 *
	 * @since 2.0.0
	 *
	 * @param string $mimeType Media mime type restriction.
	 */
	public function setMimeType($mimeType) {
		$this->mimeType = $mimeType;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Media::getOutputAttributes() to build input element's attribute array.
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
		$output = '';

		// enqueue scripts
		wp_enqueue_media();
		wp_enqueue_script('crown-form-input-media');

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label'
		));

		$output .= '<span '.implode(' ', $atts).'>';

		// hidden input field to hold media id
		$hiddenInput = new Hidden(array('name' => $this->name));
		$output .= $hiddenInput->getOutput($args);

		// media preview
		$preview = intval($args['value']) ? wp_get_attachment_image(intval($args['value']), 'medium', true) : '';
		$output .= '<span class="media-input-preview">'.$preview.'</span> ';

		// media file name
		$filename = '';
		if(intval($args['value'])) {
			preg_match('/\/[^\/]+$/', wp_get_attachment_url(intval($args['value'])), $matches);
			$filename = substr($matches[0], 1);
		}
		$output .= '<span class="media-input-name">'.$filename.'</span>';

		// select/remove media buttons
		$output .= '<a href="#" class="button media-input-button">'.$this->buttonLabel.'</a> ';
		$output .= '<a href="#" class="media-input-remove">Remove</a> ';
		if(!empty($this->label)) $output .= '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';

		$output .= '</span>';

		return $output;

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.0
	 *
	 * @used-by \Crown\Form\Input\Media::getOutput() during input element HTML generation.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *
	 * @return array Associative array of input element attribute key-value pairs.
	 */
	protected function getOutputAttributes($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, $args);

		$class = array_merge(array(
			'crown-media-input',
			'mime-type-'.$this->mimeType
		), $this->class);

		if(!empty($args['value'])) $class[] = 'has-media';
		
		$atts = array(
			'id' => $this->id,
			'class' => implode(' ', $class),
			'data-media-mime-type' => $this->mimeType
		);

		// merge other attributes
		return array_merge($atts, $this->atts);

	}

}