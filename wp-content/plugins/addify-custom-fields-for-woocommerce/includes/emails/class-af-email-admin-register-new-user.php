<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AF_Email_Admin_Register_New_User', false ) ) :

	class AF_Email_Admin_Register_New_User extends WC_Email {

		public function __construct() {

			$this->id             = 'af_email_admin_register_new_user';
			$this->title          = __( 'Addify New User Registered', 'af_custom_fields' );
			$this->customer_email = false;
			$this->description    = __( 'Email notification to admin when user create an account.', 'af_custom_fields' );
			$this->template_base  = AF_CF_PLUGIN_DIR . 'templates/';
			$this->template_html  = 'emails/admin-new-user-register.php';
			$this->template_plain = 'emails/plain/admin-new-user-register.php';

			$this->placeholders = array(
				'{customer-id}'      => '', 
				'{customer-email}'   => '',
				'{customer-details}' => '', 
				'{user-name}'        => '', 
				'{first-name}'       => '', 
				'{last-name}'        => '', 
				'{full-name}'        => '', 
				'{user-status}'      => '', 
				'{approval-link}'    => '', 
				'{disapprove-link}'  => '',
			);

			// Call to the  parent constructor.
			parent::__construct();

			// Other settings.
			$this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );

			add_action( 'addify_new_user_registered_email_notification', array( $this, 'trigger' ), 10, 2 );
		}//end __construct()


		// Default subject
		public function get_default_subject() {
			return __( '[{site_title}]: New user has been registered..', 'af_custom_fields' );
		}//end get_default_subject()


		public function get_default_heading() {
			return __( 'Account Created : {username}', 'af_custom_fields' );
		}//end get_default_heading()


		public function trigger( $user_id, $user = false ) {

			$this->setup_locale();

			if ( ! is_a( $user, 'WP_User' ) ) {
				$user = get_user_by( 'id', $user_id );
			}

			if ( is_a( $user, 'WP_User') ) {

				$this->object       = $user;
				$this->placeholders = array(
					'{customer-id}'      => $user->ID,
					'{customer-email}'   => $user->user_email, 
					'{customer-details}' => AF_C_F_Emails::get_customer_details( $user_id ), 
					'{user-name}'        => $user->user_login, 
					'{first-name}'       => $user->user_firstname, 
					'{last-name}'        => $user->user_lastname, 
					'{full-name}'        => $user->display_name, 
					'{user-status}'      => get_user_meta( $user->ID, 'af_c_f_new_user_status', true ), 
					'{approval-link}'    => AF_C_F_Emails::get_approve_link( $user_id ), 
					'{disapprove-link}'  => AF_C_F_Emails::get_disapprove_link( $user_id ),
				);

				// Find/replace.
				$this->placeholders = array_merge(
					array(
						'{site_title}'   => $this->get_blogname(),
						'{site_address}' => wp_parse_url( home_url(), PHP_URL_HOST ),
						'{site_url}'     => wp_parse_url( home_url(), PHP_URL_HOST ),
					),
					$this->placeholders
				);
			}
			

			if ( $this->is_enabled() && $this->get_recipient() ) {
				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}

			$this->restore_locale();
		}//end trigger()


		/**
		 * Initialise settings form fields.
		 */
		public function init_form_fields() {
			// translators: %s: list of placeholders
			$placeholder_text  = sprintf( __( 'Available placeholders: %s', 'af_custom_fields' ), '<code>' . implode( '</code>, <code>', array_keys( $this->placeholders ) ) . '</code>' );
			$this->form_fields = array(
				'enabled'            => array(
					'title'   => __( 'Enable/Disable', 'af_custom_fields' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable this email notification', 'af_custom_fields' ),
					'default' => 'yes',
				),
				'recipient'          => array(
					'title'       => __( 'Recipient(s)', 'af_custom_fields' ),
					'type'        => 'text',
					// translators: %s: WP admin email
					'description' => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to %s.', 'af_custom_fields' ), '<code>' . esc_attr( get_option( 'admin_email' ) ) . '</code>' ),
					'placeholder' => '',
					'default'     => esc_attr( get_option( 'admin_email' ) ),
					'desc_tip'    => true,
				),
				'subject'            => array(
					'title'       => __( 'Subject', 'af_custom_fields' ),
					'type'        => 'text',
					'desc_tip'    => true,
					'description' => $placeholder_text,
					'placeholder' => $this->get_default_subject(),
					'default'     => '',
				),
				'heading'            => array(
					'title'       => __( 'Email heading', 'af_custom_fields' ),
					'type'        => 'text',
					'desc_tip'    => true,
					'description' => $placeholder_text,
					'placeholder' => $this->get_default_heading(),
					'default'     => '',
				),
				'additional_content' => array(
					'title'       => __( 'Additional content', 'af_custom_fields' ),
					'description' => __( 'Text to appear below the main email content.', 'af_custom_fields' ) . ' ' . $placeholder_text,
					'css'         => 'width:400px; height: 75px;',
					'placeholder' => __( 'N/A', 'af_custom_fields' ),
					'type'        => 'textarea',
					'default'     => $this->get_default_additional_content(),
					'desc_tip'    => true,
				),
				'email_type'         => array(
					'title'       => __( 'Email type', 'af_custom_fields' ),
					'type'        => 'select',
					'description' => __( 'Choose which format of email to send.', 'af_custom_fields' ),
					'default'     => 'html',
					'class'       => 'email_type wc-enhanced-select',
					'options'     => $this->get_email_type_options(),
					'desc_tip'    => true,
				),
			);
		}//end init_form_fields()


		public function get_email_content() {

			return apply_filters( 'addify_email_content_' . $this->id, $this->format_string( get_option('af_c_f_admin_email_text') ), $this->object, $this );
		}//end get_email_content()

		
		public function get_content_html() {
			return wc_get_template_html(
				$this->template_html,
				array(
					'member'             => $this->object,
					'email_heading'      => $this->get_heading(),
					'content'            => $this->get_email_content(),
					'additional_content' => $this->get_additional_content(),
					'sent_to_admin'      => true,
					'plain_text'         => false,
					'email'              => $this,
				),
				'',
				$this->template_base
			);
		}//end get_content_html()


	
		public function get_content_plain() {
			return wc_get_template_html(
				$this->template_html,
				array(
					'member'             => $this->object,
					'email_heading'      => $this->get_heading(),
					'content'            => $this->get_email_content(),
					'additional_content' => $this->get_additional_content(),
					'sent_to_admin'      => true,
					'plain_text'         => false,
					'email'              => $this,
				),
				'',
				$this->template_base
			);
		}//end get_content_plain()
	}//end class


endif;
