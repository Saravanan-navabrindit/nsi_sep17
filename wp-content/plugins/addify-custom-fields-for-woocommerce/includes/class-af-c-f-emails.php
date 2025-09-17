<?php

defined( 'ABSPATH' ) || exit;

class AF_C_F_Emails {

	public function __construct() {

		add_filter('woocommerce_email_classes', array( $this, 'add_email_classes' ), 100, 1 );

		add_action('woocommerce_email_additional_content_customer_new_account', array( $this, 'add_extra_fields_data' ), 10, 2 );
	}//end __construct()


	public function add_email_classes( $classes ) {

		include_once AF_CF_PLUGIN_DIR . 'includes/emails/class-af-email-admin-register-new-user.php';
		include_once AF_CF_PLUGIN_DIR . 'includes/emails/class-af-email-register-new-account.php';
		include_once AF_CF_PLUGIN_DIR . 'includes/emails/class-af-email-approve-user-account.php';
		include_once AF_CF_PLUGIN_DIR . 'includes/emails/class-af-email-declined-user-account.php';

		$classes['af_email_admin_register_new_user'] = new AF_Email_Admin_Register_New_User();
		$classes['af_email_register_new_account']    = new AF_Email_Register_New_Account();
		$classes['af_email_approve_user_account']    = new AF_Email_Approve_User_Account();
		$classes['af_email_declined_user_account']   = new AF_Email_Declined_User_Account();

		return $classes;
	}//end add_email_classes()


	public function add_extra_fields_data( $additional_content, $user ) {

		$args = array(
			'user_id' => $user->ID,
		);

		if ( !$this->user_have_extra_fields_data( $user->ID ) ) {
			return $additional_content;
		}

		if ( ! apply_filters( 'addify_auto_add_custom_fields_data_in_email', true ) ) {

			return $additional_content;
		}

		ob_start();

		wc_get_template('emails/customer-details.php', $args, '', AF_CF_PLUGIN_DIR . 'templates/' );

		$details_html = ob_get_clean();

		$details_html = apply_filters( 'addify_c_f_email_customer_details', $details_html, $user->ID );

		return $details_html . $additional_content;
	}//end add_extra_fields_data()


	public function user_have_extra_fields_data( $user_id ) {

		$af_c_f_args = array( 
			'posts_per_page' => -1,
			'post_type'      => 'af_c_fields',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'fields'         => 'ids',
		);

		$af_c_f_extra_fields = get_posts($af_c_f_args);

		if ( !empty($af_c_f_extra_fields) ) {

			foreach ( $af_c_f_extra_fields as $field_id ) {

				$value = get_user_meta( $user_id, 'af_c_f_additional_' . $field_id, true );

				if ( !empty( $value ) ) {
					return true;
				}
			}
		}

		return false;
	}//end user_have_extra_fields_data()


	public static function get_customer_details( $user_id, $page = 'registration' ) {

		$args = array(
			'user_id' => $user_id,
			'page'    => $page,
		);

		ob_start();

		wc_get_template('emails/customer-details.php', $args, '', AF_CF_PLUGIN_DIR . 'templates/' );

		$details_html = ob_get_clean();

		return apply_filters( 'addify_c_f_email_customer_details', $details_html, $user_id );
	}//end get_customer_details()


	public static function get_approve_link( $user_id ) {

		$url         = admin_url( 'users.php?afreg-status-query-submit=addify-afreg-fields&action_email=approved&paged=1&user=' . $user_id );
		$approve_url = wp_nonce_url($url );

		return apply_filters( 'addify_c_f_admin_email_approve_url', $approve_url, $user_id );
	}//end get_approve_link()


	public static function get_disapprove_link( $user_id ) {
		
		$url            = admin_url( 'users.php?afreg-status-query-submit=addify-afreg-fields&action_email=disapproved&paged=1&user=' . $user_id );
		$disapprove_url = wp_nonce_url($url );

		return apply_filters( 'addify_c_f_admin_email_disapprove_url', $disapprove_url, $user_id );
	}//end get_disapprove_link()
}//end class


new AF_C_F_Emails();
