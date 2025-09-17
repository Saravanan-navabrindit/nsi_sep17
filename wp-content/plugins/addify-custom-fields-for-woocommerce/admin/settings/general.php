<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_settings_section(
	'afreg_checkout_general_sec',         
	esc_html__( 'General settings', 'af_custom_fields' ),   
	'', 
	'afreg_checkout_general_section'
);

add_settings_field(
	'af_cf_display_location',                   
	esc_html__( 'Display Location', 'af_custom_fields' ), 
	'af_cf_display_location_callback',
	'afreg_checkout_general_section',                       
	'afreg_checkout_general_sec',      
	array( esc_html__( 'Option to display custom fields on checkout page.', 'af_custom_fields' ) )
);

register_setting(
	'afreg_checkout_general_fields',
	'af_cf_display_location'
);

if ( !function_exists('af_cf_display_location_callback') ) {

	function af_cf_display_location_callback( $args ) {

		$selected_location = get_option('af_cf_display_location');

		$all_location = array(
			'woocommerce_checkout_before_customer_details' => __( 'Before Customer Details', 'af_custom_fields'),
			'woocommerce_before_checkout_billing_form'     => __( 'Before Billing Form', 'af_custom_fields'),
			'woocommerce_after_checkout_billing_form'      => __( 'After Billing Form', 'af_custom_fields'),
			'woocommerce_before_checkout_shipping_form'    => __( 'Before Shipping Form', 'af_custom_fields'),
			'woocommerce_after_checkout_shipping_form'     => __( 'After Shipping Form', 'af_custom_fields'),
			'woocommerce_checkout_after_customer_details'  => __( 'After Customer Details', 'af_custom_fields'),
			'woocommerce_checkout_before_order_review_heading' => __( 'Before Order Review Heading', 'af_custom_fields'),
			'woocommerce_checkout_before_order_review'     => __( 'Before Order Review', 'af_custom_fields'),
			'woocommerce_checkout_after_order_review'      => __( 'After Order Review', 'af_custom_fields'),
			'woocommerce_before_order_notes'               => __( 'Before Order Notes', 'af_custom_fields'),
			'woocommerce_after_order_notes'                => __( 'After Order Notes', 'af_custom_fields'),
			'woocommerce_checkout_before_terms_and_conditions' => __( 'After Order Notes', 'af_custom_fields'),
			'woocommerce_checkout_after_terms_and_conditions' => __( 'After Order Notes', 'af_custom_fields'),
			'woocommerce_review_order_before_submit'       => __( 'Before Order Submit', 'af_custom_fields'),
			'woocommerce_review_order_after_submit'        => __( 'After Order Submit', 'af_custom_fields'),
		);

		?>
		<select name="af_cf_display_location">
			<?php foreach ( $all_location as $key => $label ) : ?>
				<option value="<?php echo esc_html($key); ?>"><?php echo esc_html($label); ?></option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php echo esc_html( current( $args ) ); ?></p>
		<?php
	}//end af_cf_display_location_callback()

}
