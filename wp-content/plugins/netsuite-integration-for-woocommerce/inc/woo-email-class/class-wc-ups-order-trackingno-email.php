<?php

if ( ! defined( 'ABSPATH' ) ) {
exit; // Exit if accessed directly
}

if ( ! class_exists( 'WC_UPS_Order_TrackingNo_Email', false ) ) :

/**
 * A custom UPS Order Status WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */
	class WC_UPS_Order_TrackingNo_Email extends WC_Email {

		 /**
		 * Set email defaults
		 *
		 * @since 0.1
		 */
		public function __construct() {

			// set ID, this simply needs to be a unique name
			$this->id = 'wc_ups_order_trackingno_recieved';

			$this->customer_email = true;

			// this is the title in WooCommerce Email settings
			$this->title = __( 'UPS Order Tracking No.', 'woocommerce' );

			// this is the description in WooCommerce email settings
			$this->description = __( 'order status notification emails will be sent to customer ', 'woocommerce' );

			// these are the default heading and subject lines that can be overridden using the settings
			$this->heading = 'Order Tracking No.';
			$this->subject = 'Order Tracking No.';

			$this->template_base  = TMWNI_DIR . 'woocommerce/' ;	// Fix the template base lookup for use on admin screen template path display

			$this->template_html  = 'emails/email-ups-trackingno-recieved.php';
			$this->template_plain = 'emails/plain/email-ups-trackingno-recieved.php';

			parent::__construct();

			$this->manual = true;
		}

		/**
		 * Determine if the email should actually be sent and setup email merge variables
		 *
		 * @since 0.1
		 * @param int $order_id
		 */
		public function trigger( $order_id, $order = false ) {

			$this->setup_locale();

			if ( $order_id && ! is_a( $order, 'WC_Order' ) ) {
				$order = wc_get_order( $order_id );
			}

			if ( is_a( $order, 'WC_Order' ) ) {
				$this->object                         = $order;
				$this->recipient                      = $this->object->get_billing_email();
				$this->placeholders['{order_date}']   = wc_format_datetime( $this->object->get_date_created() );
				$this->placeholders['{order_number}'] = $this->object->get_order_number();
			}
		

			if ( $this->get_recipient() ) {
				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}

			$this->restore_locale();

		}

		/**
		 * Get_content_html function.
		 *
		 * @since 0.1
		 * @return string
		 */
		public function get_content_html() {
			return wc_get_template_html(
				$this->template_html, array(
					'order'         => $this->object,
					'email_heading' => $this->get_heading(),
					'sent_to_admin' => false,
					'plain_text'    => false,
					'email'         => $this,
				), '', $this->template_base
			);
		}


		/**
		 * Get_content_plain function.
		 *
		 * @since 0.1
		 * @return string
		 */
		public function get_content_plain() {
			return wc_get_template_html(
				$this->template_plain, array(
					'order'         => $this->object,
					'email_heading' => $this->get_heading(),
					'sent_to_admin' => false,
					'plain_text'    => false,
					'email'         => $this,
				), '', $this->template_base
			);
		}

		  /**
		 * Initialize Settings Form Fields
		 *
		 * @since 0.1
		 */
		public function init_form_fields() {

			$this->form_fields = array(
			'subject'    => array(
				'title'       => 'Subject',
				'type'        => 'text',
				'description' => sprintf( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', $this->subject ),
				'placeholder' => '',
				'default'     => ''
			),
			'heading'    => array(
				'title'       => 'Email Heading',
				'type'        => 'text',
				'description' => 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', $this->heading,
				'placeholder' => '',
				'default'     => ''
			),
			'email_type' => array(
				'title'       => 'Email type',
				'type'        => 'select',
				'description' => 'Choose which format of email to send.',
				'default'     => 'html',
				'class'       => 'email_type',
				'options'     => array(
					'plain'     => 'Plain text',
					'html'      => 'HTML', 'woocommerce',
					'multipart' => 'Multipart', 'woocommerce',
				)
			)
			);
		}

	}

endif;

return new WC_UPS_Order_TrackingNo_Email();
