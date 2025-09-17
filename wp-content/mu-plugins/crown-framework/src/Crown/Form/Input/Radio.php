<?php
/**
 * Contains definition for \Crown\Form\Input\Radio class.
 */

namespace Crown\Form\Input;


/**
 * Form radio input element class.
 *
 * @since 2.0.0
 */
class Radio extends Checkbox {


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'radio'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'radio';
	}

}