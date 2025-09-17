<?php
/**
 * Contains definition for \Crown\Form\Input\Gallery class.
 */

namespace Crown\Form\Input;


/**
 * Form gallery input element class.
 *
 * @since 2.0.3
 */
class Gallery extends Input {

	/**
	 * Default input value.
	 *
	 * The default value must be stored as a numeric array of media attachment IDs.
	 *
	 * @since 2.0.3
	 *
	 * @var array
	 */
	protected $defaultValue;

	/**
	 * Add images button label.
	 *
	 * @var string
	 */
	protected $buttonLabel;

	/**
	 * Edit gallery button label.
	 *
	 * @var string
	 */
	protected $buttonEditLabel;

	/**
	 * Default gallery input configuration options.
	 *
	 * @since 2.0.3
	 *
	 * @var array
	 */
	protected static $defaultGalleryInputArgs = array(
		'defaultValue' => array(),
		'buttonLabel' => 'Add Images',
		'buttonEditLabel' => 'Edit Gallery'
	);


	/**
	 * Input object constructor.
	 *
	 * Parses configuration options into object properties.
	 *
	 * @since 2.0.3
	 *
	 * @param array $args Optional. Input configuration options. Possible arguments:
	 *    * __type__ - (string) Input element type.
	 *    * __name__ - (string) Input element name.
	 *    * __label__ - (string) Input label.
	 *    * __defaultValue__ - (array) Default input value.
	 *    * __id__ - (string) Input element ID.
	 *    * __class__ - (string|string[]) Input element class.
	 *    * __required__ - (boolean) Input element required flag.
	 *    * __atts__ - (array) Additional input element attributes.
	 *    * __buttonLabel__ - (string) Add images button label.
	 *    * __buttonEditLabel__ - (string) Edit gallery button label.
	 */
	public function __construct($args = array()) {

		// set inherited class options
		parent::__construct($args);

		// parse args into object variables
		$galleryInputArgs = array_merge($this::$defaultGalleryInputArgs, array_intersect_key($args, $this::$defaultGalleryInputArgs));

		// parse args into object variables
		$this->setDefaultValue($galleryInputArgs['defaultValue']);
		$this->setButtonLabel($galleryInputArgs['buttonLabel']);
		$this->setButtonEditLabel($galleryInputArgs['buttonEditLabel']);

	}


	/**
	 * Get add images button label.
	 *
	 * @since 2.0.3
	 *
	 * @return string Add images button label.
	 */
	public function getButtonLabel() {
		return $this->buttonLabel;
	}


	/**
	 * Get edit gallery button label.
	 *
	 * @since 2.0.3
	 *
	 * @return string Edit gallery button label.
	 */
	public function getButtonEditLabel() {
		return $this->buttonEditLabel;
	}


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'gallery'.
	 *
	 * @since 2.0.3
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'gallery';
	}


	/**
	 * Set add images button label.
	 *
	 * @since 2.0.3
	 *
	 * @param string $buttonLabel Add images button label.
	 */
	public function setButtonLabel($buttonLabel) {
		$this->buttonLabel = $buttonLabel;
	}


	/**
	 * Set edit gallery button label.
	 *
	 * @since 2.0.3
	 *
	 * @param string $buttonEditLabel Edit gallery button label.
	 */
	public function setButtonEditLabel($buttonEditLabel) {
		$this->buttonEditLabel = $buttonEditLabel;
	}


	/**
	 * Get input output HTML.
	 *
	 * @since 2.0.3
	 *
	 * @used-by \Crown\Form\Input\Input::output() during input output.
	 *
	 * @uses \Crown\Form\Input\Gallery::getOutputAttributes() to build input element's attribute array.
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
		if(!is_array($args['value'])) $args['value'] = $this->defaultValue;
		$output = '';

		// enqueue scripts
		wp_enqueue_media();
		wp_enqueue_script('crown-form-input-gallery');

		// get attribute array
		$atts = $this->convertHtmlAttributes($this->getOutputAttributes($args));

		// build label attributes array
		$labelAtts = $this->convertHtmlAttributes(array(
			'class' => 'input-label'
		));

		$output .= '<div '.implode(' ', $atts).'>';

		$output .= '<a href="#" class="button gallery-input-add-images-button">'.$this->buttonLabel.'</a>';
		$output .= '<a href="#" class="button gallery-input-edit-button">'.$this->buttonEditLabel.'</a>';

		$output .= '<ul class="gallery-images">';
		foreach($args['value'] as $attachmentId) {

			// append name to basename, if applicable
			$inputName = $this->name;
			if(!empty($args['basename'])) {
				$inputName = $args['basename'].'['.$inputName.']';
			}

			$output .= '<li>';
			$output .= '<input type="hidden" name="'.$inputName.'[]" value="'.$attachmentId.'">';
			$output .= wp_get_attachment_image($attachmentId, 'thumbnail', false, array('class' => 'thumbnail'));
			$output .= '<a class="gallery-image-remove" href="#" title="Remove Image">&times;</a>';
			$output .= '</li>';
		}
		$output .= '</ul>';

		if(!empty($this->label)) $output .= '<div class="input-description"><label '.implode(' ', $labelAtts).'>'.$this->label.'</label></div>';

		$output .= '</div>';

		return $output;

	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.0.3
	 *
	 * @used-by \Crown\Form\Input\Gallery::getOutput() during input element HTML generation.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *
	 * @return array Associative array of input element attribute key-value pairs.
	 */
	protected function getOutputAttributes($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, $args);

		$class = array_merge(array(
			'crown-gallery-input'
		), $this->class);

		if(!empty($args['value'])) $class[] = 'has-media';
		
		$atts = array(
			'id' => $this->id,
			'class' => implode(' ', $class),
			'data-basename' => $this->name
		);

		// append name to basename, if applicable
		if(!empty($args['basename'])) {
			$atts['data-basename'] = $args['basename'].'['.$atts['data-basename'].']';
		}

		// merge other attributes
		return array_merge($atts, $this->atts);

	}

}