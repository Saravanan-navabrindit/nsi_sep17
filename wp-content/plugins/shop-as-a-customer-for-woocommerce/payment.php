<?php
if (!is_admin()) {

	add_action( 'woocommerce_payment_gateways', 'myexclude');
}
function myexclude ( $methods ) {
	$methods[] = 'WC_Gateway_Custom'; 
	return $methods;
}


add_action('plugins_loaded', 'init_custom_gateway_class');



function init_custom_gateway_class() {

	class WC_Gateway_Custom extends WC_Payment_Gateway {

		public $domain;

		public function __construct() {

			$this->domain = 'custom_payment';
			$this->id                 = 'Offline Method';
			$this->icon               = apply_filters('woocommerce_custom_gateway_icon', 'sssssss');
			$this->has_fields         = false;
			$this->method_title       = __( 'Offline Payment Method', 'custom_payment' );
			$this->method_description = __( 'Allows you offline payments.', 'custom_payment' );
			$this->init_form_fields();
			$this->init_settings();
			$this->title        = $this->get_option( 'title' );
			$this->description  = $this->get_option( 'description' );
			$this->instructions = $this->get_option( 'instructions', $this->description );
			$this->order_status = $this->get_option( 'order_status', get_option('fme_defselectedp') );

			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			// add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );

			add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );

			
		}


		public function init_form_fields() {

			$this->form_fields = array(
				'enabled' => array(
					'title'   => __( 'Enable/Disable', 'custom_payment' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable Custom Payment', 'custom_payment' ),
					'default' => 'yes'
				),
				'title' => array(
					'title'       => __( 'Title', 'custom_payment' ),
					'type'        => 'text',
					'description' => __( 'This controls the title which the user sees during checkout.', 'custom_payment' ),
					'default'     => __( 'Offline Payment', 'custom_payment' ),
					'desc_tip'    => true,
				),

				'description' => array(
					'title'       => __( 'Description', 'custom_payment' ),
					'type'        => 'textarea',
					'description' => __( 'Payment method description that the customer will see on your checkout.', 'custom_payment' ),
					'default'     => __('Payment Information', 'custom_payment'),
					'desc_tip'    => true,
				),

			);
		}



		public function thankyou_page() {
			if ( $this->instructions ) {
				echo esc_attr(wpautop( wptexturize( $this->instructions ) ));
			}

		}



		public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
			if ( $this->instructions && ! $sent_to_admin && 'custom' === $order->payment_method && $order->has_status( 'on-hold' ) ) {
				echo esc_attr(wpautop( wptexturize( $this->instructions ) ) . PHP_EOL);
			}

		}

		

		public function process_payment( $order_id ) {

			$order = wc_get_order($order_id);

			global $woocommerce;

			$order->update_status('wc-processing', __('Order is received using Offline Payment Method', 'woo-credits'));

			if (WC()->version < '2.7.0') {
				$order->reduce_order_stock();
			} else {
				wc_reduce_stock_levels($order->get_id());
			}


			$order = wc_get_order( $order_id );
			$status = 'wc-' === substr( $this->order_status, 0, 3 ) ? substr( $this->order_status, 3 ) : $this->order_status;


			$order->update_status( $status, __( 'Checkout with Offline payment method . ', 'custom_payment' ) );


			$order->reduce_order_stock();


			WC()->cart->empty_cart();


			return array(
				'result'    => 'success',
				'redirect'  => $this->get_return_url( $order )
			);


		}
		public function get_icon() {
			$link = null;
			global $woocommerce;
			return apply_filters('woocommerce_gateway_icon', '', $this->id);
		}
	}
}
