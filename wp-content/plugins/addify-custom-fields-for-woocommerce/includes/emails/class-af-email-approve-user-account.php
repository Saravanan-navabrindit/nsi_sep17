<?php
/**
 * Class AF_Email_Approve_User_Account file.
 *
 * @package WooCommerce\Emails
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'AF_Email_Approve_User_Account', false ) ) :

	/**
	 * Customer New Account.
	 *
	 * An email sent to the customer when they create an account.
	 *
	 * @class       AF_Email_Approve_User_Account
	 * @version     3.5.0
	 * @package     WooCommerce\Classes\Emails
	 * @extends     WC_Email
	 */
	class AF_Email_Approve_User_Account extends WC_Email {

		/**
		 * User login name.
		 *
		 * @var string
		 */
		public $user_login;

		/**
		 * User email.
		 *
		 * @var string
		 */
		public $user_email;

		/**
		 * User password.
		 *
		 * @var string
		 */
		public $user_pass;

		/**
		 * Is the password generated?
		 *
		 * @var boolean
		 */
		public $password_generated;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id             = 'af_email_approve_user_account';
			$this->customer_email = true;
			$this->title          = __( 'Addify Approve New User', 'af_custom_fields' );
			$this->description    = __( 'Customer " Approve new account" emails are sent to the customer when admin approve the customer account.', 'af_custom_fields' );
			$this->template_base  = AF_CF_PLUGIN_DIR . 'templates/';
			$this->template_html  = 'emails/approve-user-account.php';
			$this->template_plain = 'emails/plain/approve-user-account.php';

			$this->placeholders = array(
				'{customer-id}'      => '', 
				'{customer-details}' => '', 
				'{user-name}'        => '', 
				'{first-name}'       => '', 
				'{last-name}'        => '', 
				'{full-name}'        => '', 
				'{user-status}'      => '', 
				'{approval-link}'    => '', 
				'{disapprove-link}'  => '',
			);
			// Call parent constructor.
			parent::__construct();
		}//end __construct()


		/**
		 * Get email subject.
		 *
		 * @since  3.1.0
		 * @return string
		 */
		public function get_default_subject() {
			return __( 'Your {site_title} account has been created!', 'af_custom_fields' );
		}//end get_default_subject()


		/**
		 * Get email heading.
		 *
		 * @since  3.1.0
		 * @return string
		 */
		public function get_default_heading() {
			return __( 'Welcome to {site_title}', 'af_custom_fields' );
		}//end get_default_heading()


		/**
		 * Trigger.
		 *
		 * @param integer $user_id            User ID.
		 * @param string  $user_pass          User password.
		 * @param boolean $password_generated Whether the password was generated automatically or not.
		 */
		public function trigger( $user_id, $user_pass = '', $password_generated = false ) {
			$this->setup_locale();

			if ( $user_id ) {

				$user         = new WP_User( $user_id );
				$this->object = $user;

				$this->user_pass          = $user_pass;
				$this->user_login         = stripslashes( $this->object->user_login );
				$this->user_email         = stripslashes( $this->object->user_email );
				$this->recipient          = $this->user_email;
				$this->password_generated = $password_generated;

				$this->placeholders = array(
					'{customer-id}'      => $user->ID,
					'{customer-email}'   => $user->user_email, 
					'{customer-details}' => AF_C_F_Emails::get_customer_details( $user_id ), 
					'{user-name}'        => $user->user_login,
					'{first-name}'       => $user->user_firstname, 
					'{last-name}'        => $user->user_lastname, 
					'{full-name}'        => $user->display_name,
					'{user-status}'      => get_user_meta( $user->ID, 'af_c_f_new_user_status', true ), 
					'{approval-link}'    => '', 
					'{disapprove-link}'  => '',
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


		public function get_email_content() {

			return apply_filters( 'addify_email_content_' . $this->id, $this->format_string( get_option('af_c_f_approved_email_text') ), $this->object, $this );
		}//end get_email_content()


		/**
		 * Get content html.
		 *
		 * @return string
		 */
		public function get_content_html() {
			return wc_get_template_html(
				$this->template_html,
				array(
					'email_heading'      => $this->get_heading(),
					'additional_content' => $this->get_additional_content(),
					'content'            => $this->get_email_content(),
					'user_login'         => $this->user_login,
					'user_pass'          => $this->user_pass,
					'user_status'        => get_post_meta( $this->object->ID, '', true ),
					'blogname'           => $this->get_blogname(),
					'password_generated' => $this->password_generated,
					'sent_to_admin'      => false,
					'plain_text'         => false,
					'email'              => $this,
				),
				'',
				$this->template_base
			);
		}//end get_content_html()


		/**
		 * Get content plain.
		 *
		 * @return string
		 */
		public function get_content_plain() {
			return wc_get_template_html(
				$this->template_plain,
				array(
					'email_heading'      => $this->get_heading(),
					'additional_content' => $this->get_additional_content(),
					'content'            => $this->get_email_content(),
					'user_login'         => $this->user_login,
					'user_pass'          => $this->user_pass,
					'blogname'           => $this->get_blogname(),
					'password_generated' => $this->password_generated,
					'sent_to_admin'      => false,
					'plain_text'         => true,
					'email'              => $this,
				),
				'',
				$this->template_base
			);
		}//end get_content_plain()


		/**
		 * Default content to show below main email content.
		 *
		 * @since 3.7.0
		 * @return string
		 */
		public function get_default_additional_content() {
			return __( 'We look forward to seeing you soon.', 'af_custom_fields' );
		}//end get_default_additional_content()
	}//end class


endif;
