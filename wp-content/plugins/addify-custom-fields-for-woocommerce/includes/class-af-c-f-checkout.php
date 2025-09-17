<?php

defined('ABSPATH') || exit;

use PH7\Eu\Vat\Validator;
use PH7\Eu\Vat\Provider\Europa;

class AF_C_F_Checkout {

	public $dependent_fields;

	public function __construct() {

		add_action('wp_loaded', function () {
			$this->dependent_fields = $this->get_all_dependent_fields();
		}, 10, 1);
	}//end __construct()



	public function save_checkout_user_fields( $customer_id ) {

		$checkout_fields = $this->get_checkout_fields();

		if (empty($checkout_fields)) {
			return;
		}


		foreach ($checkout_fields as $field_id) {

			$field_name  = 'af_c_f_' . $field_id;
			$meta_key    = 'af_c_f_additional_' . $field_id;
			$field_pages = (array) get_post_meta($field_id, 'af_c_f_field_pages', true);
			$value       = empty($_POST[ $field_name ]) ? '' : sanitize_meta('', wp_unslash($_POST[ $field_name ]), '');

			$nonce = isset( $_POST['af_cf_nonce'] ) ? sanitize_text_field( $_POST['af_cf_nonce'] ) : 0;

			if (!empty($_POST[ $field_name ]) && !wp_verify_nonce( $nonce, 'af-c-f-ajax-nonce') && 'no' ==  get_option('woocommerce_enable_signup_and_login_from_checkout') ) {
				wp_die(esc_html__('Failed Ajax security check!', 'af_custom_fields'));
			}
			if (in_array('registration', $field_pages)) {

				if (is_array($value)) {

					update_user_meta($customer_id, $meta_key, implode(',', $value));
				} else {

					update_user_meta($customer_id, $meta_key, $value);
				}
			}
		}
	}//end save_checkout_user_fields()


	public function add_hook_for_custom_fields() {

		$checkout_fields = $this->get_checkout_fields();

		if (empty($checkout_fields)) {
			return;
		}

		$all_location = array(
			'woocommerce_checkout_before_customer_details' => __('Before Customer Details', 'af_custom_fields'),
			'woocommerce_before_checkout_billing_form'     => __('Before Billing Form', 'af_custom_fields'),
			'woocommerce_after_checkout_billing_form'      => __('After Billing Form', 'af_custom_fields'),
			'woocommerce_before_checkout_shipping_form'    => __('Before Shipping Form', 'af_custom_fields'),
			'woocommerce_after_checkout_shipping_form'     => __('After Shipping Form', 'af_custom_fields'),
			'woocommerce_checkout_after_customer_details'  => __('After Customer Details', 'af_custom_fields'),
			'woocommerce_checkout_before_order_review_heading' => __('Before Order Review Heading', 'af_custom_fields'),
			'woocommerce_checkout_before_order_review'     => __('Before Order Review', 'af_custom_fields'),
			'woocommerce_checkout_after_order_review'      => __('After Order Review', 'af_custom_fields'),
			'woocommerce_before_order_notes'               => __('Before Order Notes', 'af_custom_fields'),
			'woocommerce_after_order_notes'                => __('After Order Notes', 'af_custom_fields'),
			'woocommerce_checkout_before_terms_and_conditions' => __('Before Terms and Conditions', 'af_custom_fields'),
			'woocommerce_checkout_after_terms_and_conditions' => __('After Terms and Conditions', 'af_custom_fields'),
			'woocommerce_review_order_before_submit'       => __('Before Order Submit', 'af_custom_fields'),
			'woocommerce_review_order_after_submit'        => __('After Order Submit', 'af_custom_fields'),
		);

		foreach ($all_location as $key => $location) {
			add_action($key, function () use ( $key ) {
				$this->show_custom_fields($key);
			}, 100);
		}

		add_action('woocommerce_checkout_process', array( $this, 'validate_checkout_fields_data' ));
		add_action('woocommerce_checkout_update_order_meta', array( $this, 'save_checkout_fields_data' ), 10, 1);

		add_filter('woocommerce_email_order_meta_fields', array( $this, 'email_order_meta_fields' ), 10, 3);
		add_filter('woocommerce_form_field_args', array( $this, 'change_label_of_fields' ), 100, 3);

		add_action('woocommerce_cart_calculate_fees', array( $this, 'add_checkout_fields_fee' ), 10 );
	}//end add_hook_for_custom_fields()


	public function add_checkout_fields_fee( $cart ) {

		// Return if not checkout page.
		if ( ! is_checkout() ) {
			return;
		}

		if ( empty( $_POST ) || empty( $this->get_checkout_fields() ) ) {
			return;
		}

		if ( isset( $_POST['woocommerce-process-checkout-nonce'] ) ) {

			$nonce_value = sanitize_text_field( wp_unslash( $_POST['woocommerce-process-checkout-nonce'] ) );

			if ( ! wp_verify_nonce( $nonce_value, 'woocommerce-process_checkout' ) && 'no' ==  get_option('woocommerce_enable_signup_and_login_from_checkout') ) {
				wp_die('Security violated ');
			}
		}

		$post_data = $_POST;
		// Ajax Security check.
		if ( isset( $_POST['security'] ) ) {
			check_ajax_referer( 'update-order-review', 'security' );
			if ( isset(  $_POST['post_data'] ) ) {
				parse_str( sanitize_meta('', $_POST['post_data'], ''), $post_data );
			}
		}

		$excluded_fields = $this->get_excluded_dependent_fields();

		$excluded_fields_for_cart = $this->get_excluded_field_cart();

		$checkout_fields = array_merge( $this->get_checkout_fields(), $this->get_all_dependent_fields() );

		foreach ( $checkout_fields as $field_id ) {

			if ( in_array( $field_id, $excluded_fields ) ) {
				continue;
			}

			if ( in_array( $field_id, $excluded_fields_for_cart ) ) {
				continue;
			}

			if ( empty( $post_data[ 'af_c_f_' . $field_id ] ) ) {
				continue;
			}

			$price_type = get_post_meta( $field_id, 'af_c_f_field_price_type', true );

			if ( $this->is_field_has_options($field_id) ) {


				$field_value = $post_data[ 'af_c_f_' . $field_id ];

				$_type   = get_post_meta( $field_id, 'af_c_f_field_type', true );
				$options = get_post_meta( $field_id , 'af_c_f_field_option', true );

				if ( is_array( $field_value ) ) {

					$options = (array) get_post_meta( $field_id , 'af_c_f_field_option', true );


					foreach ( $field_value as $value ) {

						$option = $this->find_option_of_value( $value, $options );

						$option_price         = isset( $option['option_price'] ) ? floatval( $option['option_price'] ) : 0;
						$option_price_taxable = isset( $option['option_price_taxable'] ) && !empty( $option['option_price_taxable'] ) ? (string) $option['option_price_taxable']  : '';

						$price_taxable = 'yes' === (string) $option_price_taxable ? true : false;
						
						if ( empty( $option_price ) ) {
							continue;
						}

						if ( 'percentage' === $price_type ) {

							$price = ( wc()->cart->get_subtotal() * $price ) / 100;
							wc()->cart->add_fee( get_the_title( $field_id ) . '(' . $option['field_text'] . ') Fee', $price, $price_taxable );

						} else {

							wc()->cart->add_fee( get_the_title( $field_id ) . '(' . $option['field_text'] . ') Fee', $option_price, $price_taxable );
						}
					}

				} else {

					$option        = $this->find_option_of_value( $field_value, $options );
					$option_price  = isset( $option['option_price'] ) ? floatval( $option['option_price'] ) : 0;
					$price_taxable = isset( $option['option_price_taxable'] ) && !empty( $option['option_price_taxable'] ) ? (string) $option['option_price_taxable']  : '';
					$price_taxable = 'yes' === (string) $price_taxable ? true : false;

					if ( empty( $option_price ) ) {
						continue;
					}

					if ( 'percentage' === $price_type ) {

						$price = ( wc()->cart->get_subtotal() * $option_price ) / 100;
						wc()->cart->add_fee( get_the_title( $field_id ) . '(' . $option['field_text'] . ') Fee', $price, $price_taxable );

					} else {

						wc()->cart->add_fee( get_the_title( $field_id ) . '(' . $option['field_text'] . ') Fee', $option_price, $price_taxable );
					}
				}

			} else {


				$price = get_post_meta( $field_id, 'af_c_f_field_price', true );

				if ( empty( $price ) ) {
					continue;
				}

				$price_type    = get_post_meta( $field_id, 'af_c_f_field_price_type', true );
				$price_taxable = get_post_meta( $field_id, 'af_c_f_field_price_taxable', true );
				$price_taxable = 'yes' === (string) $price_taxable ? true : false;
				
				if ( 'percentage' === $price_type ) {

					$price = ( wc()->cart->get_subtotal() * $price ) / 100;
					wc()->cart->add_fee( get_the_title( $field_id   ) . ' Fee', $price, $price_taxable );

				} else {

					wc()->cart->add_fee( get_the_title( $field_id   ) . ' Fee', $price, $price_taxable );
				}
			}
		}
	}//end add_checkout_fields_fee()


	public function change_label_of_fields( $args, $key, $value ) {

		if (get_option('afreg_' . $key)) {

			$args['label'] = get_option('afreg_' . $key);
		}

		return $args;
	}//end change_label_of_fields()


	public function email_order_meta_fields( $fields, $sent_to_admin, $order ) {

		$checkout_fields = $this->get_checkout_fields();

		$order_id = $order->get_id();

		if (empty($checkout_fields)) {
			return $fields;
		}

		foreach ($checkout_fields as $field_id) {

			$field_name = 'af_c_f_' . $field_id;

			$_type = get_post_meta($field_id, 'af_c_f_field_type', true);

			$value = '';

			if (in_array($_type, array( 'heading', 'message', 'googlecaptcha' ))) {
				continue;
			}

			if (in_array($_type, array( 'multiselect', 'multi_checkbox', 'radio', 'select' ))) {

				$val_array            = (array) get_post_meta($order_id, $field_name, true);
				$af_c_f_field_options = (array) get_post_meta($field_id, 'af_c_f_field_option', true);
				$af_c_f_field_options = empty($af_c_f_field_options) ? array() : ( $af_c_f_field_options );
				$value                = array();

				foreach ($val_array as $option_val) {

					foreach ($af_c_f_field_options as $af_c_f_field_option) {

						if ($af_c_f_field_option['field_value'] == $option_val) {

							$value[] =  $af_c_f_field_option['field_text'];
						}
					}
				}

				$value = implode(', ', $value);
			} elseif ('checkbox' == $_type) {

				$value = get_post_meta($order_id, $field_name, true);
				$value = empty($value) ? __('No', 'af_custom_fields') :  __('Yes', 'af_custom_fields');
			} elseif ('password' == $_type) {

				$value = get_post_meta($order_id, $field_name, true);

				$value = empty($value) ? '' : '*********';
			} elseif ('privacy' == $_type) {

				$value = __('Agree', 'af_custom_fields');
			} elseif ('fileupload' == $_type) {

				$value = get_post_meta($order_id, $field_name, true);
				$value = sprintf('<a href="%s">%s</a>', esc_url(AF_CF_UPLOAD_DIR . $value), __('View File', 'af-checkout-fields'));
			} elseif (!empty(get_post_meta($order_id, $field_name, true))) {

				$value = get_post_meta($order_id, $field_name, true);
			}

			if (!empty($value)) {

				$fields[ $field_name ] = array(
					'label' => get_the_title($field_id),
					'value' => $value,
				);
			}
		}

		return $fields;
	}//end email_order_meta_fields()


	public function get_order_meta( $order_id ) {

		$af_cf_args = array(
			'numberposts'      => -1,
			'post_type'        => 'af_c_fields',
			'post_status'      => 'publish',
			'orderby'          => 'menu_order',
			'suppress_filters' => false,
			'order'            => 'ASC',
			'fields'           => 'ids',
		);

		$af_cf_extra_fields = get_posts($af_cf_args);

		$checkout_fields = array();

		foreach ($af_cf_extra_fields as $field_id) {

			$field_roles = (array) get_post_meta($field_id, 'af_c_f_field_user_roles', true);

			$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);


			if ( empty( get_post_meta($field_id, 'af_c_f_field_pages', true) ) || in_array('checkout', (array) get_post_meta($field_id, 'af_c_f_field_pages', true))) {

				$checkout_fields[] = $field_id;

				$dependent_fields = $this->get_dependent_field($field_id);

				if (!empty($dependent_fields)) {

					foreach ($dependent_fields as $dep_field) {
						$checkout_fields[] = $dep_field;
					}
				}
			}
		}


		if (empty($checkout_fields)) {
			return;
		}

		$checkout_data = array();

		foreach ($checkout_fields as $field_id) {


			$field_name = 'af_c_f_' . $field_id;
			
			$_type = get_post_meta($field_id, 'af_c_f_field_type', true);


			if (in_array($_type, array( 'heading', 'message', 'googlecaptcha' ))) {
				continue;
			}

			if (in_array($_type, array( 'multiselect', 'multi_checkbox', 'radio', 'select' ))) {

				$val_array = (array) get_post_meta($order_id, $field_name, true);
				
				$af_c_f_field_options = (array) get_post_meta($field_id, 'af_c_f_field_option', true);

				$value = array();


				foreach ($val_array as $option_val) {

					foreach ($af_c_f_field_options as $af_c_f_field_option) {

						if ($af_c_f_field_option['field_value'] == $option_val) {

							$value[] =  $af_c_f_field_option['field_text'];
						}
					}
				}

				$checkout_data[ get_the_title($field_id) ] = implode(', ', $value);
			} elseif ('checkbox' == $_type) {

				$value = get_post_meta($order_id, $field_name, true);
				$value = empty($value) ? __('No', 'af_checkout_fields') :  __('Yes', 'af_checkout_fields');

				$checkout_data[ get_the_title($field_id) ] = $value;
			} elseif ('password' == $_type) {

				$value = get_post_meta($order_id, $field_name, true);
				$value = empty($value) ? '' : '*********';

				$checkout_data[ get_the_title($field_id) ] = $value;
			} elseif ('privacy' == $_type) {

				$value = __('Agree', 'af_checkout_fields');

				$checkout_data[ get_the_title($field_id) ] = $value;
			} elseif ('fileupload' == $_type) {

				$field_name = 'af_c_f_' . $field_id;

				if ( empty( get_post_meta($order_id, $field_name, true) ) ) {
					continue;
				}

				$value = AF_CF_UPLOAD_DIR . get_post_meta($order_id, $field_name, true);
				$value = str_replace('D:\xammp\htdocs', 'http://localhost', $value);

				$value = sprintf('<a href="%s" target="_">%s</a>', ( $value ), __('View File', 'af-checkout-fields'));

				$checkout_data[ get_the_title($field_id) ] = $value;
			} else {

				$checkout_data[ get_the_title($field_id) ] = get_post_meta($order_id, $field_name, true);
			}

		}

		return $checkout_data;
	}//end get_order_meta()


	public function validate_checkout_fields_data() {

		$checkout_fields = $this->get_checkout_fields();


		if (empty($checkout_fields)) {
			return;
		}


		$excluded_dependent_fields = $this->get_excluded_dependent_fields();

		foreach ($checkout_fields as $field_id) {

			$_required  = get_post_meta($field_id, 'af_c_f_field_required', true);
			$field_name = 'af_c_f_' . $field_id;
			$_type      = get_post_meta($field_id, 'af_c_f_field_type', true);
			$value      = empty($_POST[ $field_name ]) ? '' : sanitize_text_field(wp_unslash($_POST[ $field_name ]));
			$nonce      = isset( $_POST['af_cf_nonce'] ) ? sanitize_text_field( $_POST['af_cf_nonce'] ) : 0;

			if (!empty($_POST[ $field_name ]) && !wp_verify_nonce( $nonce , 'af-c-f-ajax-nonce') && 'no' ==  get_option('woocommerce_enable_signup_and_login_from_checkout')) {
				wp_die(esc_html__('Failed Ajax security check!', 'af_custom_fields'));
			}

			if (in_array($field_id, $excluded_dependent_fields)) {
				continue;
			}

			if ('on' != $_required && 'googlecaptcha' != $_type && 'privacy' != $_type) {
				continue;
			}

			$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);

			if ('yes' == $is_dependent) {
				continue;
			}

			if ('fileupload' == $_type) {

				if (empty($_POST[ 'af_c_file_uploaded_' . $field_id ]) && ( 'on' == $_required )) {
					// translators: %s: field label
					wc_add_notice(sprintf(__('%s is a required field', 'af_custom_fields'), get_the_title($field_id)), 'error');
				}
				continue;
			}

			if (in_array($_type, array( 'message', 'heading' ))) {
				continue;
			}

			if ('googlecaptcha' == $_type) {

				$response = isset($_POST['g-recaptcha-response']) ? sanitize_text_field($_POST['g-recaptcha-response']) : '';

				if (!empty($response)) {

					$ccheck = $this->captcha_check($response);

					if ('error' == $ccheck) {
						// translators: %s: field label
						wc_add_notice(sprintf(__('%s is not a valid', 'af_custom_fields'), get_the_title($field_id)), 'error');
						continue;
					}
				} else {
					// translators: %s: field label
					wc_add_notice(sprintf(__('%s is required', 'af_custom_fields'), get_the_title($field_id)), 'error');
					continue;
				}

				continue;
			}

			if (empty($_POST[ $field_name ]) && ( 'on' == $_required || 'privacy' == $_type )) {
				// translators: %s: field label
				wc_add_notice(sprintf(__('%s is a required field', 'af_custom_fields'), get_the_title($field_id)), 'error');
				continue;
			} elseif (empty($_POST[ $field_name ])) {
				continue;
			}

			if ('email' == $_type && !is_email($value)) {
				// translators: %s: field label
				wc_add_notice(sprintf(__('%s is a not a valid email address', 'af_custom_fields'), get_the_title($field_id)), 'error');
				continue;
			}

			if ('number' == $_type && !is_numeric($value)) {
				// translators: %s: field label
				wc_add_notice(sprintf(__('%s is a not a valid number', 'af_custom_fields'), get_the_title($field_id)), 'error');
				continue;
			}

			if ('vat' == $_type) {

				$af_c_f_vat_type   = get_post_meta($field_id, 'af_c_f_vat_type', true);
				$af_c_f_vat_length = get_post_meta($field_id, 'af_c_f_vat_length', true);

				if ('vies' == $af_c_f_vat_type && !$this->validate_vat($value)) {

					// translators: %s: field label
					wc_add_notice(sprintf(__('%s is a not a valid VAT number', 'af_custom_fields'), get_the_title($field_id)), 'error');
					continue;
				} elseif ('length' == $af_c_f_vat_type && !empty($af_c_f_vat_length)) {

					if (strlen($value) != $af_c_f_vat_length) {

						// translators: %s: field label
						wc_add_notice(sprintf(__('%s is a not a valid VAT number', 'af_custom_fields'), get_the_title($field_id)), 'error');
						continue;
					}
				}
			}
		}
	}//end validate_checkout_fields_data()


	public function captcha_check( $res ) {

		$secret = get_option('af_c_f_secret_key');

		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $res);

		$responseData = json_decode($verifyResponse);

		if ($responseData->success) {
			return 'success';
		} else {
			return 'error';
		}
	}//end captcha_check()


	public function validate_vat( $value ) {

		$country = trim(substr($value, 0, 2));
		$vatnum  = trim(str_replace($country, '', $value));

		if (extension_loaded('soap')) {

			$oVatValidator = new Validator(new Europa(), $vatnum, $country);

			if ($oVatValidator->check()) {
				return true;
			}

			return false;
		}

		return true;
	}//end validate_vat()


	public function get_independent_fields() {

		$checkout_fields  = $this->get_checkout_fields();
		$dependent_fields = $this->dependent_fields;

		$independent_fields = array_diff($checkout_fields, $dependent_fields);

		return $independent_fields;
	}//end get_independent_fields()


	public function get_excluded_dependent_fields() {

		if (isset($_POST['woocommerce-process-checkout-nonce'])) {

			$nonce_value = sanitize_text_field(wp_unslash($_POST['woocommerce-process-checkout-nonce']));

			if ( !wp_verify_nonce($nonce_value, 'woocommerce-process_checkout') && 'no' ==  get_option('woocommerce_enable_signup_and_login_from_checkout') ) {
				wp_die('Security violated');
			}
		}

		$post_data = $_POST;
		// Ajax Security check.
		if (isset($_POST['security'])) {
			check_ajax_referer('update-order-review', 'security');
			if (isset($_POST['post_data'])) {
				parse_str(sanitize_meta('', $_POST['post_data'], ''), $post_data);
			}
		}

		$excluded_dependent_fields = array();
		$visible_fields            = array();

		$independent_fields = $this->get_independent_fields();
		$visible_fields     = $visible_fields;
		$tree               = $this->get_tree_of_fields($independent_fields);
		$bf_tree_traversal  = $this->breath_first_tree_traversal($tree);

		foreach ($bf_tree_traversal as $parent_field_id) {

			if (in_array($parent_field_id, $excluded_dependent_fields)) {
				continue;
			}

			$dependent_fields = $this->get_multiple_dependent_field($parent_field_id);

			if (empty($dependent_fields)) {
				continue;
			}

			$post_value = '';

			if (isset($post_data[ 'af_c_f_' . $parent_field_id ])) {
				$post_value = sanitize_meta('', wp_unslash($post_data[ 'af_c_f_' . $parent_field_id ]), '');
			}

			$parent_type    = get_post_meta($parent_field_id, 'af_c_f_field_type', true);
			$parent_options = get_post_meta($parent_field_id, 'af_c_f_field_option', true);

			foreach ($dependent_fields as $child_field_id) {

				$field_roles       = get_post_meta($child_field_id, 'af_c_f_field_user_roles', true);
				$dependable_values = get_post_meta($child_field_id, 'af_c_f_dependable_values', true);

				$user_role = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';

				if (!empty($field_roles) && !in_array($user_role, $field_roles)) {
					$excluded_dependent_fields[] = $child_field_id;
				}

				if ($this->is_child_field_visible($parent_type, $dependable_values, $post_value)) {
					continue;
				}

				$tree_node = $this->find_tree_node_of_field_id($tree, $child_field_id);

				if (is_array($tree_node) && isset($tree_node['children'])) {

					$tree_traversal = $this->breath_first_tree_traversal(array( $tree_node ));

					$excluded_dependent_fields = array_merge($excluded_dependent_fields, $tree_traversal);
				} else {

					$excluded_dependent_fields[] = $child_field_id;
				}
			}
		}

		return $excluded_dependent_fields;
	}//end get_excluded_dependent_fields()


	public function get_multiple_dependent_field( $field_id, $dependent_fields = array() ) {

		if ( empty( $this->dependent_fields ) ) {
			$this->dependent_fields = $this->get_all_dependent_fields();
		}
		
		if ( empty( $this->dependent_fields ) ) {
			return;
		}

		foreach ( $this->dependent_fields as $field ) {

			if ( get_post_meta( $field, 'af_c_f_dep_fields', true ) == $field_id ) {

				$dependent_fields[] = $field;
			}
		}

		return array_filter( $dependent_fields );
	}//end get_multiple_dependent_field()


	public function get_tree_of_fields( $independent_fields = array() ) {

		if ( empty( $independent_fields ) ) {
			$independent_fields = $this->get_independent_fields();
		}

		$recursion = true;

		$tree = array();

		foreach ( $independent_fields as $parent_field_id ) {

			$dependent_fields = $this->get_multiple_dependent_field( $parent_field_id );
			$dependent_fields = is_array( $dependent_fields ) ? array_filter( $dependent_fields ) : '';
			$post_value       = '';

			if ( !empty( $dependent_fields ) ) {

				$tree[] = array( 
					'value'    => $parent_field_id,
					'children' => $this->get_tree_of_fields($dependent_fields),
				);

			} else {

				$tree[] = array( 
					'value' => $parent_field_id,
				);
			}
		}

		return $tree;
	}//end get_tree_of_fields()


	public function find_tree_node_of_field_id( $tree, $field_id ) {

		$independent_fields = $this->get_independent_fields();

		foreach ($independent_fields as $field_key => $parent_field_id) {

			$all_trees_traversal = array();

			foreach ($tree as $index => $tree_data) {

				if ($parent_field_id == $this->visit_node($tree_data)) {

					$tree_elements = $this->preorder_tree_traversal($tree_data);

					if (in_array($field_id, $tree_elements)) {

						if ($field_id == $parent_field_id) {
							return $tree_data;
						} else {
							$tree_node = $this->find_node_in_tree(array( $tree_data ), array(), $field_id);
							return $tree_node;
						}
					}
				}
			}
		}
	}//end find_tree_node_of_field_id()


	public function visit_node( array $node ) {
		return isset( $node['value'] ) ? $node['value'] : '';
	}//end visit_node()


	public function preorder_tree_traversal( array $node, $find_id = 0 ) {

		if ( empty( $traversed_nodes ) ) {
			$traversed_nodes = array();
		}

		array_push( $traversed_nodes, $this->visit_node($node) );

		if ( !empty( $find_id ) && $find_id == $this->visit_node( $node ) ) {
			return $node;
		}

		if ( !empty( $node['children'] ) ) {

			foreach ($node['children'] as $child) {
				
				$traversed_nodes =  array_merge( $traversed_nodes, $this->preorder_tree_traversal($child) );
			}
		}

		return $traversed_nodes;
	}//end preorder_tree_traversal()


	public function find_node_in_tree( array $queue, array $output = array(), $find_id = 0 ) {

		if (count($queue) === 0) {
			return $output;
		}

		// Take the first item from the queue and visit it.
		$node = array_shift($queue);

		if ( !empty( $find_id ) && $find_id == $this->visit_node( $node ) ) {
			return $node;
		}

		$output[] = $this->visit_node($node);

		// Add any children to the queue.
		if ( !empty( $node['children'] ) ) {
			foreach ($node['children'] as $child) {
				$queue[] = $child;
			}
		}   

		// Repeat the algorithm with the rest of the queue.
		return $this->find_node_in_tree($queue, $output, $find_id);
	}//end find_node_in_tree()


	public function find_option_of_value( $value, $options ) {

		foreach ( $options as $option ) {

			if ( is_array($option) && isset($option['field_value']) && $value == $option['field_value'] ) {
				return $option;
			}
		}
	}//end find_option_of_value()


	public function get_excluded_field_cart() {
		if ( wc()->cart->is_empty() ) {
			return array();
		}

		$excluded_fields = array();

		foreach ( $this->get_checkout_fields() as $field_id ) {

			

			if ( ! $this->rule_is_aplicable_for_checkout_page( $field_id ) ) {

				$excluded_fields[] = $field_id; 
			}
		}

		return $excluded_fields;
	}//end get_excluded_field_cart()


	public function breath_first_tree_traversal( array $queue, array $output = array() ) {

		if (count($queue) === 0) {
			return $output;
		}

		// Take the first item from the queue and visit it.
		$node     = array_shift($queue);
		$output[] = $this->visit_node($node);

		// Add any children to the queue.
		if ( !empty( $node['children'] ) ) {
			foreach ($node['children'] as $child) {
				$queue[] = $child;
			}
		}

		// Repeat the algorithm with the rest of the queue.
		return $this->breath_first_tree_traversal($queue, $output);
	}//end breath_first_tree_traversal()


	public function is_child_field_visible( $parent_type, $dependable_values, $post_value ) {

		if (in_array($parent_type, array( 'select', 'multiselect', 'checkbox', 'multi_checkbox', 'radio' ))) {

			if (!empty($dependable_values)) {

				if (is_array($post_value)) {

					if (count((array) array_intersect($post_value, explode(',', $dependable_values))) > 0) {
						return true;
					}
				} elseif (in_array($post_value, explode(',', $dependable_values))) {

						return true;
				}
			} elseif ('checkbox' == $parent_type) {

				if (!empty($post_value)) {
					return true;
				}
			}

			return false;
		}

		return true;
	}//end is_child_field_visible()


	public function save_checkout_fields_data( $order_id, $data = '' ) {

		$checkout_fields = $this->get_checkout_fields();


		if (empty($checkout_fields)) {
			return;
		}


		foreach ($checkout_fields as $field_id) {

			$field_name = 'af_c_f_' . $field_id;
			$_type      = get_post_meta($field_id, 'af_c_f_field_type', true);
			$nonce      = isset( $_POST['af_cf_nonce'] ) ? sanitize_text_field( $_POST['af_cf_nonce'] ) : 0;

			if (isset($_POST[ $field_name ])) {
				
				if (!empty($_POST[ $field_name ]) && !wp_verify_nonce($nonce , 'af-c-f-ajax-nonce') && 'no' ==  get_option('woocommerce_enable_signup_and_login_from_checkout') ) {
					wp_die(esc_html__('Failed Ajax security check!', 'af_custom_fields'));
				}

				update_post_meta($order_id, $field_name, sanitize_meta('', wp_unslash($_POST[ $field_name ]), ''));

				if ( is_user_logged_in() ) {

					update_user_meta( get_current_user_id(), $field_name, sanitize_meta( '', wp_unslash( $_POST[ $field_name ] ), '' ) );
				}
			}

			if ( 'fileupload' == $_type ) {


				if ( isset(  $_POST[ 'af_c_file_uploaded_' . $field_id ] ) ) {

					update_post_meta( $order_id, $field_name, sanitize_text_field( $_POST[ 'af_c_file_uploaded_' . $field_id ] ) );

					if ( is_user_logged_in() ) {

						update_user_meta( get_current_user_id(), $field_name, sanitize_text_field( $_POST[ 'af_c_file_uploaded_' . $field_id ] ) );
					}
				}
			}
		}
	}//end save_checkout_fields_data()


	public function show_custom_fields( $location_key ) {

		$checkout_fields = $this->get_checkout_fields();

		if (empty($checkout_fields)) {
			return;
		}

		foreach ($checkout_fields as $field_id) {

			$_location = get_post_meta($field_id, 'af_c_f_checkout_position', true);

			if ('yes' == get_post_meta($field_id, 'af_c_f_dependable', true)) {
				continue;
			}

			if ($location_key != $_location) {
				continue;
			}

			$key = 'af_c_f_' . $field_id;

			$field_pages = (array) get_post_meta($field_id, 'af_c_f_field_pages', true);
			$dep_fields  = (array) get_post_meta($field_id, 'af_c_f_dep_fields', true);

			$_type    = get_post_meta($field_id, 'af_c_f_field_type', true);
			$_options = (array) get_post_meta($field_id, 'af_c_f_field_option', true);

			$_file_size = get_post_meta($field_id, 'af_c_f_field_file_size', true);
			$_file_type = get_post_meta($field_id, 'af_c_f_field_file_type', true);

			$_required      = get_post_meta($field_id, 'af_c_f_field_required', true);
			$_read_only     = get_post_meta($field_id, 'af_c_f_field_read_only', true);
			$_order_details = get_post_meta($field_id, 'af_c_f_field_order_details', true);
			$_width         = get_post_meta($field_id, 'af_c_f_field_width', true);
			$_placeholder   = get_post_meta($field_id, 'af_c_f_field_placeholder', true);
			$_description   = get_post_meta($field_id, 'af_c_f_field_description', true);
			$_css           = get_post_meta($field_id, 'af_c_f_field_css', true);
			$_heading_tag   = get_post_meta($field_id, 'af_c_f_heading_tag', true);
			$_text          = get_post_meta($field_id, 'af_c_f_field_text', true);
			$value          = get_user_meta(get_current_user_id(), 'af_c_f_additional_' . $field_id, true);

			$field_price         = get_post_meta( $field_id, 'af_c_f_field_price', true );
			$field_price_type    = get_post_meta( $field_id, 'af_c_f_field_price_type', true );
			$field_price_taxable = get_post_meta( $field_id, 'af_c_f_field_price_taxable', true );

			$price = 0;

			if ( !$this->is_field_has_options( $field_id ) ) {

				switch ( $field_price_type ) {
					case 'fixed':
						$price = floatval( $field_price );
						break;
					case 'percentage':
						$price = wc()->cart->get_subtotal() * ( floatval( $field_price ) / 100 );
						break;
				}
			}

			$field_price = $this->is_field_has_price( $field_id );
			$input_class = !empty( $field_price ) && false !== $field_price ? array( 'af_c_f_field_price' ) : array();

			$label  = get_the_title( $field_id );
			$label .= !empty( $price ) ? '(' . wc_price( $price ) . ')' : '';

			$custom_attributes = '';

			$woocommerce_types = array( 'country', 'state', 'textarea', 'checkbox', 'text', 'password', 'datetime', 'datetime-local', 'date', 'month', 'time', 'week', 'number', 'email', 'url', 'tel', 'hidden' );

			if (in_array($_type, $woocommerce_types)) {

				$args = array(
					'type'              => $_type,
					'label'             => $label,
					'description'       => $_description,
					'placeholder'       => $_placeholder,
					'maxlength'         => false,
					'required'          => 'on' == $_required ? true : false,
					'id'                => $key,
					'class'             => 'half' == $_width ? array( 'half_width' ) : array( 'form-row-wide' ),
					'label_class'       => array(),
					'input_class'       => $input_class,
					'return'            => false,
					'options'           => empty($_options) ? array() : $this->get_options_of_field($_options),
					'custom_attributes' => array(),
					'validate'          => array(),
					'autofocus'         => '',
					'priority'          => '',
				);

				$default_value = $value;

				if ('checkbox' == $_type) {
					$default_value = 'yes' == $value ? 1 : 0;
				}

				woocommerce_form_field($key, $args, $default_value);
			} else {

				$_options         = $this->get_options_of_field( $_options );
				$field_price      = $this->is_field_has_price( $field_id );
				$input_class      = !empty( $field_price ) && false !== $field_price ? 'af_c_f_field_price' : '';
				$af_cf_main_class = 'half' == $_width ? 'half_width' : 'form-row-wide';

				include AF_CF_PLUGIN_DIR . 'templates/checkout/checkout_fields.php';
			}

			$this->show_dependent_field($field_id);
			wp_nonce_field('af-c-f-ajax-nonce', 'af_cf_nonce');
		}
	}//end show_custom_fields()


	public function is_field_has_options( $field_id ) {

		$_type = get_post_meta( $field_id, 'af_c_f_field_type', true );

		if ( in_array( $_type, array( 'multiselect', 'multi_checkbox', 'radio', 'select' ) ) ) {
			return true;
		}

		return false;
	}//end is_field_has_options()


	public function is_field_has_price( $field_id ) {

		if ( $this->is_field_has_options( $field_id ) ) {

			$_options = get_post_meta( $field_id, 'af_c_f_field_option', true );
			$_options = is_serialized( $_options ) ? ( $_options ) : '';

			if ( empty( $_options ) ) {
				return false;
			}

			foreach ( $_options as $option ) {

				if ( !empty( $option['option_price'] ) ) {
					return true;
				}
			}

		} else {

			return get_post_meta( $field_id, 'af_c_f_field_price', true );
		}
	}//end is_field_has_price()


	public function get_multilevel_dependent_fields( $dependent_fields ) {

		$iterated_dependent_fields = array();

		foreach ( $dependent_fields as $key => $field_id ) {

			$tree_node = $this->find_tree_node_of_field_id( $this->get_tree_of_fields(), $field_id );

			if ( is_array( $tree_node ) ) {

				$tree_traversal            = $this->preorder_tree_traversal( $tree_node );
				$iterated_dependent_fields =  array_merge( $iterated_dependent_fields, $tree_traversal );

			} else {

				array_push( $iterated_dependent_fields, $field_id );
			}
		}

		return array_filter( array_unique( $iterated_dependent_fields ) );
	}//end get_multilevel_dependent_fields()


	public function show_dependent_field( $par_field_id ) {

		$dependent_fields = $this->get_dependent_field($par_field_id);

		if (empty($dependent_fields)) {
			return;
		}

		$dependent_fields = $this->get_multilevel_dependent_fields( $dependent_fields );

		$excluded_fields_for_cart = $this->get_excluded_field_cart();

		foreach ($dependent_fields as $field_id) {

			if ( in_array( $field_id, $excluded_fields_for_cart ) ) {
				continue;
			}

			$key = 'af_c_f_' . $field_id;

			$_type          = get_post_meta($field_id, 'af_c_f_field_type', true);
			$_options       = (array) ( get_post_meta($field_id, 'af_c_f_field_option', true) );
			$_required      = get_post_meta($field_id, 'af_c_f_field_required', true);
			$_read_only     = get_post_meta($field_id, 'af_c_f_field_read_only', true);
			$_order_details = get_post_meta($field_id, 'af_c_f_field_order_details', true);
			$_width         = get_post_meta($field_id, 'af_c_f_field_width', true);
			$_placeholder   = get_post_meta($field_id, 'af_c_f_field_placeholder', true);
			$_description   = get_post_meta($field_id, 'af_c_f_field_description', true);
			$_css           = get_post_meta($field_id, 'af_c_f_field_css', true);
			$_heading_tag   = get_post_meta($field_id, 'af_c_f_heading_tag', true);
			$_text          = get_post_meta($field_id, 'af_c_f_field_text', true);
			$value          = get_user_meta(get_current_user_id(), 'af_c_f_additional_' . $field_id, true);

			$dependable_values = get_post_meta($field_id, 'af_c_f_dependable_values', true);
			$dep_fields        = get_post_meta($field_id, 'af_c_f_dep_fields', true);

			$field_price         = get_post_meta( $field_id, 'af_c_f_field_price', true );
			$field_price_type    = get_post_meta( $field_id, 'af_c_f_field_price_type', true );
			$field_price_taxable = get_post_meta( $field_id, 'af_c_f_field_price_taxable', true );
			
			$price = 0;

			if ( !$this->is_field_has_options( $field_id ) ) {

				switch ( $field_price_type ) {
					case 'fixed':
						$price = floatval( $field_price );
						break;
					case 'percentage':
						$price = wc()->cart->get_subtotal() * ( floatval( $field_price ) / 100 );
						break;
				}
			}

			$label  = get_the_title( $field_id );
			$label .= !empty( $price ) ? '(' . wc_price( $price ) . ')' : '';

			if ('checkbox' == get_post_meta($dep_fields, 'af_c_f_field_type', true)) {
				$dependable_values = '1';
			}

			$class = array( 'af_c_f_is_dependable' );

			$class[] = 'half' == $_width ? 'half_width' : 'form-row-wide';

			$custom_attributes = '';

			$dep_field_id =  'af_c_f_' . $field_id;

			$woocommerce_types = array( 'country', 'state', 'textarea', 'checkbox', 'text', 'password', 'datetime', 'datetime-local', 'date', 'month', 'time', 'week', 'number', 'email', 'url', 'tel', 'hidden' );

			if (in_array($_type, $woocommerce_types)) {

				$custom_attributes = array();

				$custom_attributes['data-dependent_on'] = 'af_c_f_' . $dep_fields;

				if (!empty($dependable_values)) {

					$custom_attributes['data-dependent_val'] = trim($dependable_values);
				}

				$args = array(
					'type'              => $_type,
					'label'             => get_the_title($field_id),
					'description'       => $_description,
					'placeholder'       => $_placeholder,
					'maxlength'         => false,
					'required'          => 'on' == $_required ? true : false,
					'id'                => $key,
					'class'             => $class,
					'label_class'       => array(),
					'input_class'       => array(),
					'return'            => false,
					'options'           => empty($_options) ? array() : $this->get_options_of_field($_options),
					'custom_attributes' => $custom_attributes,
					'validate'          => array(),
					'autofocus'         => '',
					'priority'          => '',
				);

				$default_value = $value;

				if ('checkbox' == $_type) {
					$default_value = 'yes' == $value ? 1 : 0;
				}

				woocommerce_form_field($key, $args, $default_value);

			} else {

				if ( empty( $dependable_values ) ) {

					$custom_attributes = 'data-dependent_on=af_c_f_' . $dep_fields ;

				} else {

					$custom_attributes = 'data-dependent_val=' . $dependable_values . ' data-dependent_on=af_c_f_' . $dep_fields ;
				}

				$_options = $this->get_options_of_field( $_options );

				$af_cf_main_class  = 'af_c_f_is_dependable ';
				$af_cf_main_class .= 'half' == $_width ? 'half_width' : 'form-row-wide';
				$field_price       = $this->is_field_has_price( $field_id );
				$input_class       = !empty( $field_price ) && false !== $field_price ? 'af_c_f_field_price' : '';

				include AF_CF_PLUGIN_DIR . 'templates/checkout/checkout_fields.php';
			}
		}
	}//end show_dependent_field()


	public function get_options_of_field( $options ) {

		if ( empty( $options ) ) {
			return $options;
		}

		$field_options = array();

		foreach ( $options as $option ) {

			if ( isset( $option['field_value'] ) ) {

				$field_options[ $option['field_value'] ] = isset( $option['field_text'] ) ? $option['field_text'] : '';

				if ( !empty( $option['option_price'] ) ) {
					$field_options[ $option['field_value'] ] .= '(' . wc_price( $option['option_price'] ) . ')';
				}
			}
		}

		return $field_options;
	}//end get_options_of_field()


	public function get_checkout_fields() {

		$af_cf_args = array(
			'numberposts'      => -1,
			'post_type'        => 'af_c_fields',
			'post_status'      => 'publish',
			'orderby'          => 'menu_order',
			'suppress_filters' => false,
			'order'            => 'ASC',
			'fields'           => 'ids',
		);


		$af_cf_extra_fields = get_posts($af_cf_args);
		$checkout_fields    = array();
		$user_role          = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';

		foreach ( $af_cf_extra_fields as $field_id ) {


			

			$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true) ? (array) get_post_meta($field_id, 'af_c_f_field_user_roles', true) : array( $user_role );

			$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);

			if ('yes' == $is_dependent) {
				continue;
			}


			if ( ! in_array( $user_role, $field_roles ) ) {
				continue;
			}


			if ( in_array('checkout', (array) get_post_meta($field_id, 'af_c_f_field_pages', true)) ) {
				
				if ( ! is_admin() && ! $this->rule_is_aplicable_for_checkout_page( $field_id ) ) {
					continue;
				}

				$checkout_fields[] = $field_id;

				$dependent_fields = (array) $this->get_dependent_field($field_id);

				$checkout_fields = array_merge($dependent_fields, $checkout_fields);

			}
		}

		$checkout_fields = array_filter($checkout_fields);
		$checkout_fields = array_unique($checkout_fields);

		return $checkout_fields;
	}//end get_checkout_fields()


	public function get_dependent_field( $field_id ) {

		if (empty($this->get_all_dependent_fields())) {
			return;
		}

		$dependent_fields = array();

		foreach ($this->get_all_dependent_fields() as $field) {

			if (get_post_meta($field, 'af_c_f_dep_fields', true) == $field_id) {
				$dependent_fields[] = $field;
			}
		}

		return $dependent_fields;
	}//end get_dependent_field()


	public function get_all_dependent_fields() {

		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'af_c_fields',
			'post_status'      => 'publish',
			'orderby'          => 'menu_order',
			'suppress_filters' => false,
			'order'            => 'ASC',
			'fields'           => 'ids',
			'meta_key'         => 'af_c_f_dependable',
			'meta_value'       => 'yes',
		);

		$fields = get_posts($args);

		$user_role = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';

		if (!empty($fields)) {

			foreach ($fields as $key => $field_id) {

				$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

				if (!empty($field_roles)) {
					if (!in_array($user_role, $field_roles)) {
						unset($fields[ $key ]);
					}
				}
			}
		}

		return $fields;
	}//end get_all_dependent_fields()


	public function organize_checkout_fields( $fields ) {

		$user_role = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';

		// Set Billing fields.
		$billing_fields = isset($fields['billing']) ? $fields['billing'] : array();

		if (!empty($billing_fields)) {

			$billing_fields = $this->organize_billing_fields($billing_fields, $user_role);
		}

		// Set Shipping fields.
		$shipping_fields = isset($fields['shipping']) ? $fields['shipping'] : array();

		if (!empty($shipping_fields)) {
			$shipping_fields = $this->organize_shipping_fields($shipping_fields, $user_role);
		}

		$fields['billing']  = $billing_fields;
		$fields['shipping'] = $shipping_fields;

		return $fields;
	}//end organize_checkout_fields()


	public function organize_billing_fields( $fields, $user_role ) {

		$final_fields = $fields;

		$final_fields = $this->remove_disabled_billing_fields($fields, $user_role);

		$final_fields = $this->sort_billing_fields($final_fields, $user_role);

		return $this->set_custom_labels_of_fields($final_fields);
	}//end organize_billing_fields()


	public function organize_shipping_fields( $fields, $user_role ) {

		$final_fields = $fields;

		$final_fields = $this->remove_disabled_shipping_fields($fields, $user_role);

		$final_fields = $this->sort_shipping_fields($final_fields, $user_role);

		return $this->set_custom_labels_of_fields($final_fields);
	}//end organize_shipping_fields()


	public function set_custom_labels_of_fields( $fields ) {

		$final_fields = $fields;

		foreach ($fields as $key => $field) {

			if (get_option('afreg_' . $key)) {
				$final_fields[ $key ]['label'] = get_option('afreg_' . $key);
			}
		}

		return $final_fields;
	}//end set_custom_labels_of_fields()


	public function sort_billing_fields( $fields, $user_role ) {

		$settings = get_option('af_checkout_billing_fields');

		if (empty($settings) || !isset($settings[ $user_role ])) {
			return $fields;
		}

		$priority = 10;

		$final_fields = $fields;

		foreach ((array) $settings[ $user_role ] as $field_key) {

			if (isset($fields[ $field_key ])) {

				$final_fields[ $field_key ]['priority'] = $priority;

				$priority += 10;
			}
		}

		return $final_fields;
	}//end sort_billing_fields()


	public function sort_shipping_fields( $fields, $user_role ) {

		$settings = get_option('af_checkout_shipping_fields');

		if (empty($settings) || !isset($settings[ $user_role ])) {
			return $fields;
		}

		$final_fields = $fields;

		$priority = 10;

		foreach ((array) $settings[ $user_role ] as $field_key) {

			if (isset($fields[ $field_key ])) {

				$final_fields[ $field_key ]['priority'] = $priority;

				$priority += 10;
			}
		}

		return $final_fields;
	}//end sort_shipping_fields()


	public function remove_disabled_billing_fields( $fields, $user_role ) {

		$final_fields = $fields;

		$settings = get_option('af_checkout_billing_fields');

		if (empty($settings) || !isset($settings[ $user_role ])) {
			return $final_fields;
		}

		foreach ($fields as $key => $field) {

			if (!in_array($key, (array) $settings[ $user_role ])) {

				unset($final_fields[ $key ]);
			}
		}

		return $final_fields;
	}//end remove_disabled_billing_fields()


	public function remove_disabled_shipping_fields( $fields, $user_role ) {

		$final_fields = $fields;

		$settings = get_option('af_checkout_shipping_fields');

		if (empty($settings) || !isset($settings[ $user_role ])) {
			return $final_fields;
		}

		foreach ($fields as $key => $field) {

			if (!in_array($key, (array) $settings[ $user_role ])) {

				unset($final_fields[ $key ]);
			}
		}

		return $final_fields;
	}//end remove_disabled_shipping_fields()



	public function rule_is_aplicable_for_checkout_page( $field_id ) {

		$match_product = false;
		
		$field_products = (array) get_post_meta( $field_id, 'af_c_f_field_products', true );
		$field_products = array_filter( $field_products );
		
		$field_categories = (array) get_post_meta( $field_id, 'af_c_f_field_categories', true );
		$field_categories = array_filter( $field_categories );
		
		$field_tags = (array) get_post_meta( $field_id, 'af_c_f_field_tags', true );
		$field_tags = array_filter( $field_tags );

		if ( count( $field_products ) < 1 && count( $field_categories ) < 1 && count( $field_tags ) < 1 ) {

			$match_product = true;

		}

		if ( isset(WC()->session) && isset( wc()->cart ) &&  wc()->cart->get_cart_contents() ) {
			
			foreach ( wc()->cart->get_cart_contents() as $cart_item_key => $cart_item ) {

				$product_id = $cart_item['product_id'];

				if ( in_array($product_id, $field_products ) ) {
					$match_product = true;

				}


				if ( count($field_categories) >= 1 && has_term($field_categories, 'product_cat', $product_id ) ) {
					$match_product = true;
				}


				if ( count($field_tags) >= 1 && has_term($field_tags, 'product_tag', $product_id ) ) {
					$match_product = true;
				}


			}

		}
		

		return $match_product;
	}//end rule_is_aplicable_for_checkout_page()
}//end class
