<?php
/**
 * UPS Shipped email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-ups-shipped.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Executes the e-mail header.
 *
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>

<?php 
global $TMWNI_OPTIONS;

//$orderId = trim(str_replace('#', '', $order->get_order_number())); 

$orderId = $order->get_id();

$ups_trackingno = get_post_meta($orderId, 'ywot_tracking_code', true);
if (isset($TMWNI_OPTIONS['ns_order_shipping_courier']) && !empty($TMWNI_OPTIONS['ns_order_shipping_courier'])) {

	$shipping_carrier =	get_post_meta($order_id, $TMWNI_OPTIONS['ns_order_shipping_courier'], true);
} else {
	$shipping_carrier = 	get_post_meta($order_id, 'ywot_carrier_name', true);
}

?>
<p>
	<?php 
	/* translators: %s Order date */
	printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); 

	?>
</p>
<p>
	<?php
	/* translators: %s Order date */
		// printf( esc_html__( 'Your order has been picked up by UPS on %s:', 'woocommerce' ), esc_html( wc_format_datetime( $order->get_date_created() ) ) );
	printf( esc_html__( 'Your order has been picked up', 'woocommerce' ));
	?>
</p>
<p>
	<?php
	/* translators: %s Order date */
	printf( esc_html__( 'This is the %1$s tracking number for your order : %2$s', 'woocommerce' ), esc_html($shipping_carrier), esc_html( $ups_trackingno ) );
	?>
</p>
<?php

/**
 * Hook for the woocommerce_email_order_details.
 *
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for the woocommerce_email_order_meta.
 *
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for woocommerce_email_customer_details.
 *
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

?>
<p>
	<?php esc_html_e( 'Thanks for reading.', 'woocommerce' ); ?>
</p>
<?php

/**
 * Executes the email footer.
 *
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
