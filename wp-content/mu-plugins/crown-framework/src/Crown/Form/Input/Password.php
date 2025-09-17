<?php
/**
 * Contains definition for \Crown\Form\Input\Password class.
 */

namespace Crown\Form\Input;


/**
 * Form password input element class.
 *
 * @since 2.0.0
 */
class Password extends Text {


	/**
	 * Set input element type.
	 *
	 * Input type is overridden to always be set to 'password'.
	 *
	 * @since 2.0.0
	 *
	 * @param string $type Input element type.
	 */
	public function setType($type) {
		$this->type = 'password';
	}

}