<?php
/**
 * Contains definition for \Crown\Form\Input\RadioImageSet class.
 */

namespace Crown\Form\Input;


/**
 * Form radio input set element class.
 *
 * @since 2.11.0
 */
class RadioImageSet extends RadioSet {


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'radioImageSet'.
	 *
	 * @since 2.11.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'radioImageSet';
	}


	/**
	 * Generate radio image set element options output HTML.
	 *
	 * @since 2.11.0
	 *
	 * @param array $options Options to convert to HTML.
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return string Radio image set input element options output HTML.
	 */
	protected function getOutputOptions($options = array(), $args = array()) {

		$output = array();
		foreach($options as $option) {
			$value = $option;
			$label = $option;
			$image = '';
			$depth = 0;

			// check if option in array format
			if(is_array($option)) {
				$value = array_key_exists('value', $option) ? $option['value'] : '';
				$label = array_key_exists('label', $option) ? $option['label'] : $value;
				$image = array_key_exists('image', $option) ? $option['image'] : $image;
				$depth = array_key_exists('depth', $option) ? intval($option['depth']) : $depth;
			}

			$inputArgs = array(
				'name' => $this->name,
				'value' => $value,
				'label' => '<span class="image-container"><span class="image" '.(!empty($image) ? 'style="background-image: url('.$image.')"' : '').'></span></span><span class="label"><span class="inner">'.$label.'</span></span>'
			);
			$input = new Radio($inputArgs);

			// setup option indentation
			// $indentation = str_repeat('&nbsp;', $depth * 3);

			$output[] = '<div class="input-wrap depth-'.$depth.'">'.$input->getOutput($args).'</div>';

		}

		return implode('', $output);
	}


	/**
	 * Build list of input element's attributes.
	 *
	 * @since 2.11.0
	 *
	 * @used-by \Crown\Form\Input\RadioSet::getOutput() during input element HTML generation.
	 *
	 * @param array $args Optional. Input output options. Possible arguments:
	 *    * __value__ - (string) Input element value.
	 *    * __isTpl__ - (boolean) Whether input should be output as part of a template.
	 *    * __basename__ - (string) Input element name basename.
	 *
	 * @return array Associative array of input element attribute key-value pairs.
	 */
	protected function getOutputAttributes($args = array()) {
		$args = array_merge($this::$defaultOutputArgs, $args);

		$class = array_merge(array(
			'crown-radio-image-set-input'
		), $this->class);

		$atts = array(
			'id' => $this->id,
			'class' => implode(' ', $class)
		);

		// merge other attributes
		return array_merge($atts, $this->atts);

	}


}