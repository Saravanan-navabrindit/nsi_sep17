<?php
/**
 * Contains definition for \Crown\Form\Input\Hidden class.
 */

namespace Crown\Form\Input;


/**
 * Form hidden input element class.
 *
 * @since 2.0.0
 */
class Hidden extends Input {


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'hidden'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'hidden';
	}

}