<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

register_setting(
	'af_checkout_billing_fields',
	'af_checkout_billing_fields'
);

register_setting(
	'af_checkout_shipping_fields',
	'af_checkout_shipping_fields'
);

add_settings_section(
	'afreg_checkout_billing_title_sec',  
	esc_html__( 'Checkout billing fields labels', 'af_custom_fields' ),   
	'', 
	'afreg_checkout_title_section'
);
if ( ! wc() ) {
	return;
}
$fields = wc()->checkout()->get_checkout_fields( 'billing' );

foreach ( $fields as $key => $value ) {

	$field_label = empty( get_option('afreg_' . $key ) ) ?  $value['label'] : get_option('afreg_' . $key );
	$field_name  = 'afreg_' . $key;

	add_settings_field(
		$field_name,
		esc_html( $value['label'] ),
		function ( $args ) {

			$restricted_keys = array( 'billing_state', 'billing_address_1', 'billing_postcode', 'billing_city' );
			$readonly        = '';

			if ( in_array( $args[3], $restricted_keys ) ) {
				$readonly = 'readonly';
			}
			?>
				<input type="text" <?php echo esc_attr( $readonly ); ?> name="<?php echo esc_html( $args[2] ); ?>" id="" value="<?php echo esc_attr( $args[1] ); ?>" />
				<?php if ( empty( $readonly ) ) : ?>
					<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post( $args[0] ); ?> </p>
				<?php endif; ?>
			<?php
		},
		'afreg_checkout_title_section',
		'afreg_checkout_billing_title_sec',
		array(
			// translators: %s: Billing Field Label
			sprintf( __( 'Change label of %s', 'af_custom_fields' ), esc_html( $value['label'] ) ),
			$field_label,
			$field_name,
			$key,
		)
	);

	register_setting(
		'afreg_checkout_title_fields',
		$field_name
	);
}

add_settings_section(
	'afreg_checkout_shipping_title_sec',         
	esc_html__( 'Checkout Shipping Fields Labels', 'af_custom_fields' ),   
	'', 
	'afreg_checkout_title_section'
);

$fields = wc()->checkout()->get_checkout_fields( 'shipping' );

foreach ( $fields as $key => $value ) {

	$field_label = empty( get_option('afreg_' . $key ) ) ?  $value['label'] : get_option( 'afreg_' . $key );
	$field_name  = 'afreg_' . $key;

	add_settings_field(
		$field_name,
		esc_html( $value['label'] ),
		function ( $args ) {

			$restricted_keys = array( 'shipping_state', 'shipping_address_1', 'shipping_postcode', 'shipping_city' );
			$readonly        = '';

			if ( in_array( $args[3], $restricted_keys ) ) {
				$readonly = 'readonly';
			}
			?>
				<input type="text" <?php echo esc_attr( $readonly ); ?> name="<?php echo esc_html( $args[2] ); ?>" id="" value="<?php echo esc_attr( $args[1] ); ?>" />
				<?php if ( empty( $readonly ) ) : ?>
					<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post( $args[0] ); ?> </p>
				<?php endif; ?>
			<?php
		},
		'afreg_checkout_title_section',
		'afreg_checkout_shipping_title_sec',
		array( 
			// translators: %s: Shipping Field Label
			sprintf( __( 'Change label of %s', 'af_custom_fields' ), esc_html( $value['label'] ) ),
			$field_label,
			$field_name,
			$key,
		)
	);

	register_setting(
		'afreg_checkout_title_fields',
		$field_name
	);
}
