<?php
/**
 * Checkout functionality - overrides the default WooCommerce checkout class get_value (WooCommerce\Classes).
 *
 * The WooCommerce checkout class handles the checkout process, collecting user data and processing the payment.
 *
 */

if ( ! class_exists( 'Custom_WC_Checkout' ) ) {
    class Custom_WC_Checkout {

        public function __construct() {
            add_filter( 'woocommerce_checkout_get_value', array( $this, 'get_value' ), 10, 2 );
        }

        /**
         * Gets the value either from POST, or from the customer object. Sets the default values in checkout fields.
         *
         * @param mixed  $value
         * @param string $input
         * @return string The default value.
         * @throws Exception
         */
        public function get_value(mixed $value, string $input ): string
        {
            if ( ! empty( $_POST[ $input ] ) ) {
                return wc_clean( wp_unslash( $_POST[ $input ] ) );
            }

            if ( ! is_null( $value ) ) {
                return $value;
            }

            $customer_object = WC()->customer;

            if ( ! $customer_object ) {
                $logger = wc_get_logger();
                $logger->error( 'Customer object is null for user ID: ' . get_current_user_id(), array( 'source' => 'handled_errors' ) );
            }

            if ( $customer_object && is_callable( array( $customer_object, "get_$input" ) ) ) {
                $value = $customer_object->{"get_$input"}();
            } elseif ( $customer_object && $customer_object->meta_exists( $input ) ) {
                $value = $customer_object->get_meta( $input, true );
            }

            if ( '' === $value ) {
                $value = null;
            }

            return apply_filters( 'default_checkout_' . $input, $value, $input );
        }
    }

    new Custom_WC_Checkout();
}