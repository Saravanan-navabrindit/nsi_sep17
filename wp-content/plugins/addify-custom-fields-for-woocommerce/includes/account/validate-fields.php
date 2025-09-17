<?php

defined( 'ABSPATH' ) || exit;

if (!empty($_REQUEST['af_c_f_nonce_field'])) {

	$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
} else {
	$retrieved_nonce = 0;
}

if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

	wp_die( esc_html__('Security Violated 1', 'af_custom_fields') );
}


if ( 'googlecaptcha' == $af_c_f_field_type) {
		
	if ( ! empty( $_POST['g-recaptcha-response'] ) ) {

		$ccheck = $this->captcha_check(sanitize_text_field($_POST['g-recaptcha-response']));

		if ('error' == $ccheck) {
			// translators: %s: field label
			$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', esc_html__( 'Invalid reCaptcha!', 'af_custom_fields' ) );
		}
		
	} else {
		// translators: %s: field label
		$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', sprintf( esc_html__('%s is required!', 'af_custom_fields' ) , get_the_title( $field_id ) ) );
	}
}

if ( 'fileupload' != $af_c_f_field_type && empty( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) && ( 'on' == $af_c_f_field_required ) ) {
	// translators: %s: field label
	$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', sprintf( esc_html__('%s is required!', 'af_custom_fields' ) , get_the_title( $field_id ) ) );
}

if ( 'privacy' == $af_c_f_field_type && empty( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) ) {

	// translators: %s: field label
	$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', sprintf( esc_html__('%s is required!', 'af_custom_fields' ) , get_the_title( $field_id ) ) );
}

if ('email' == $af_c_f_field_type) {

	if ( !empty( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) && !is_email( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) ) {

		// translators: %s: field label
		$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', esc_html( get_the_title( $field_id ) ) . esc_html__( ' is not a valid email address!', 'af_custom_fields' ) );
	}
}

if ( 'vat' == $af_c_f_field_type) {

	if ( !empty( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) ) {

		$af_c_f_vat_type   = get_post_meta( $field_id, 'af_c_f_vat_type', true );
		$af_c_f_vat_length = get_post_meta( $field_id, 'af_c_f_vat_length', true );

		$value = sanitize_text_field( wp_unslash( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) );
		if ( 'vies' == $af_c_f_vat_type && isset( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) && ! $this->validate_vat( $value ) ) {

			// translators: %s: field label
			$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', sprintf( esc_html__('%s is not a valid Vat Number.', 'af_custom_fields' ) , get_the_title( $field_id ) ) );
		
		} elseif ( 'length' == $af_c_f_vat_type && !empty( $af_c_f_vat_length ) ) {

			if ( strlen( $value ) != $af_c_f_vat_length ) {

				// translators: %s: field label
				$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', sprintf( esc_html__('%s is not a valid Vat Number.', 'af_custom_fields' ) , get_the_title( $field_id ) ) );
			}
		}
	}   
}

if ('number' == $af_c_f_field_type) {

	if ( !empty( $_POST[ 'af_c_f_additional_' . intval($field_id) ] ) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_INT) ) {

		// translators: %s: field label
		$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', esc_html( get_the_title( $field_id ) ) . esc_html__( ' is not a valid number!', 'af_custom_fields' ) );
	}
}

if ( 'fileupload' == $af_c_f_field_type) {

	if ( empty( $previous_value ) && empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

		// translators: %s: field label
		$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', esc_html( get_the_title( $field_id ) ) . esc_html__( ' is required.', 'af_custom_fields' ) );
	}

	if ( !empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

		$af_c_f_allowed_types =  explode(',', $af_c_f_field_file_type);
		$af_c_f_filename      = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);
		$af_c_f_ext           = pathinfo($af_c_f_filename, PATHINFO_EXTENSION);

		if ( !in_array($af_c_f_ext, array_map( 'trim', $af_c_f_allowed_types ) ) ) {

			// translators: %s: field label
			$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', esc_html( get_the_title( $field_id ) ) . esc_html__( ': File type is not allowed!', 'af_custom_fields' ) );
		}

		if ( isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size'])) {

			$af_c_f_filesize = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size']);
		} else {
			$af_c_f_filesize = 0;
		}
	
		$af_c_f_allowed_size = $af_c_f_field_file_size * 1000000; // convert from MB to Bytes

		if ($af_c_f_filesize > $af_c_f_allowed_size) {

			// translators: %s: field label
			$validation_errors->add( 'af_c_f_additional_' . intval($field_id) . '_error', esc_html( get_the_title( $field_id ) ) . esc_html__( ': File size is too big!', 'af_custom_fields' ) );

		}
	}
}
