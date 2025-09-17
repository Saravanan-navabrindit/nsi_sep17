<?php

if (!defined('WPINC')) {
	die;
}

use PH7\Eu\Vat\Validator;
use PH7\Eu\Vat\Provider\Europa;

if (!class_exists('Af_C_F_Front')) {

	class Af_C_F_Front {

		protected $af_checkout;

		public $dependent_fields;

		public function __construct() {

			add_action('wp_loaded', function () {
				$this->dependent_fields = $this->get_all_dependent_fields();
			}, 5, 1);

			$this->af_checkout = new AF_C_F_Checkout();

			add_action('wp_enqueue_scripts', array( $this, 'af_c_f_front_scripts' ));
			add_action('woocommerce_register_form', array( $this, 'af_c_f_extra_fields_show' ));
			add_action('woocommerce_after_checkout_registration_form', array( $this, 'af_c_f_extra_fields_show' ));
			add_action('woocommerce_register_post', array( $this, 'af_c_f_default_fields_validate' ), 10, 3);
			add_action('woocommerce_register_post', array( $this, 'af_c_f_validate_extra_register_fields' ), 10, 3);

			add_action('user_register', array( $this, 'af_c_f_save_extra_fields' ));
			add_action('woocommerce_edit_account_form', array( $this, 'af_c_f_update_extra_fields_my_account' ));
			add_action('woocommerce_save_account_details_errors', array( $this, 'af_c_f_validate_update_role_my_account' ), 10, 1);
			add_action('woocommerce_save_account_details', array( $this, 'af_c_f_save_update_role_my_account' ), 12, 1);

			// // For WordPress
			add_filter('register_form', array( $this, 'af_c_f_extra_fields_show_wordpress' ));
			add_filter('registration_errors', array( $this, 'af_c_f_validate_extra_register_fields_wordpress' ), 10, 3);

			// Manual Approve Users
			add_action('woocommerce_registration_redirect', array( $this, 'af_c_f_user_autologout' ), 2);
			add_action('wp_loaded', array( $this, 'af_c_f_registration_message' ), 2);
			add_filter('wp_authenticate_user', array( $this, 'af_c_f_auth_login' ));

			add_filter('woocommerce_form_field_multiselect', array( $this, 'af_c_f_custom_multiselect_handler' ), 10, 4);

			// Default Fields
			add_action('woocommerce_register_form_start', array( $this, 'af_c_f_default_fields' ));

			// Display registration fields meta in order emails.
			add_filter('woocommerce_email_order_meta_fields', array( $this, 'af_c_f_email_order_meta_fields' ), 10, 3);

			// Organize checkout fields i.e edit, delete, sort.
			add_filter('woocommerce_checkout_fields', array( $this->af_checkout, 'organize_checkout_fields' ), 100, 1);

			// Add custom fields, store data in order meta and order emails.
			add_action('init', array( $this->af_checkout, 'add_hook_for_custom_fields' ));
		}//end __construct()


		public function replace_place_holders( $message, $user_id ) {

			$customer = get_user_by('id', $user_id);

			$placeholders = array(

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

			if (is_a($customer, 'WP_User')) {

				$placeholders = array(

					'{customer-id}'      => $customer->ID,
					'{customer-email}'   => $customer->user_email,
					'{customer-details}' => '',
					'{user-name}'        => $customer->user_login,
					'{first-name}'       => $customer->first_name,
					'{last-name}'        => $customer->last_name,
					'{full-name}'        => $customer->user_fullname,
					'{user-status}'      => get_user_meta($customer->ID, 'af_c_f_new_user_status', true),
					'{approval-link}'    => '',
					'{disapprove-link}'  => '',
				);
			}

			return str_replace(array_keys($placeholders), array_values($placeholders), $message);
		}//end replace_place_holders()


		public function validate_vat( $value ) {

			$country = trim(substr($value, 0, 2));
			$vatnum  = trim(str_replace($country, '', $value));

			if (extension_loaded('soap')) {

				try {

					$oVatValidator = new Validator(new Europa(), $vatnum, $country);

					if ($oVatValidator->check()) {
						return true;
					}
				} catch (Exception $ex) {

					wc_add_notice($ex->getMessage(), 'error');
					return false;
				}

				return false;
			}

			return true;
		}//end validate_vat()

		public function af_c_f_email_order_meta_fields( $fields, $sent_to_admin, $order ) {

			$user = wp_get_current_user();

			$af_c_f_args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);


			$af_c_f_extra_fields = get_posts($af_c_f_args);

			foreach ($af_c_f_extra_fields as $field_id ) {

				$af_c_f_field_type          = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
				$af_c_f_field_order_details = get_post_meta(intval($field_id), 'af_c_f_field_order_details', true);
				$afregcheck                 = get_user_meta($user->ID, 'af_c_f_additional_' . intval($field_id), true);

				if (!empty($afregcheck) && 'on' == $af_c_f_field_order_details) {

					$value = get_user_meta($user->ID, 'af_c_f_additional_' . intval($field_id), true);

					if ('fileupload' == $af_c_f_field_type) {

						$value = '<a class="af-front-fields" href="' . esc_url(AF_CF_URL . 'uploaded_files/' . $value) . '">' . esc_html__('Click here to view', 'af_custom_fields') . '</a>';


						$fields[ get_the_title($field_id) ] = array(
							'label' => esc_html__(get_the_title($field_id) . ': ', 'af_custom_fields'),
							'value' => $value,
						);
					} else {

						$fields[ get_the_title($field_id) ] = array(
							'label' => esc_html__(get_the_title($field_id) . ': ', 'af_custom_fields'),
							'value' => $value,
						);
					}
				}
			}

			return $fields;
		}//end af_c_f_email_order_meta_fields()


		public function af_c_f_before_checkout_create_order( $order, $data ) {

			$user = wp_get_current_user();

			$af_c_f_args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);

			$af_c_f_extra_fields = get_posts($af_c_f_args);

			foreach ($af_c_f_extra_fields as $field_id ) {

				$af_c_f_field_type = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
				$afregcheck        = get_user_meta($user->ID, 'af_c_f_additional_' . intval($field_id), true);

				if (!empty($afregcheck)) {

					$value = get_user_meta($user->ID, 'af_c_f_additional_' . intval($field_id), true);
					$order->update_meta_data('af_c_f_additional_' . intval($field_id), $value);
				}
			}
		}//end af_c_f_before_checkout_create_order()


		public function af_c_f_front_scripts() {

			wp_enqueue_style('afreg-front-css', AF_CF_URL . 'front/css/af-cf-front.css', array(), '1.0');
			wp_enqueue_script('jquery');
			wp_enqueue_script('afreg-front-js', AF_CF_URL . 'front/js/af-cf-front.js', array( 'jquery' ), '1.0.0', false);
			wp_enqueue_script('Google-reCaptcha-JS', '//www.google.com/recaptcha/api.js', array( 'jquery' ), '1.0.0', false);


			$af_c_f_data = array(
				'admin_url' => admin_url('admin-ajax.php'),
				'nonce'     => wp_create_nonce('afcf_nonce'),

			);
			wp_localize_script('afreg-front-js', 'php_info', $af_c_f_data);
		}//end af_c_f_front_scripts()


		public function get_account_page_fields() {

			$af_cf_args         = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);
			$af_cf_extra_fields = get_posts($af_cf_args);

			$account_fields = array();

			foreach ($af_cf_extra_fields as $field_id ) {

				$is_dependent = (array) get_post_meta($field_id, 'af_c_f_dependable', true);

				if ('yes' == $is_dependent) {
					continue;
				}

				if (in_array('my-account', (array) get_post_meta($field_id, 'af_c_f_field_pages', true))) {

					$account_fields[] = $field_id;

					$dependent_fields = $this->get_dependent_field($field_id);

					if (!empty($dependent_fields)) {

						foreach ($dependent_fields as $dep_field) {
							$account_fields[] = $dep_field;
						}
					}
				}
			}

			return array_filter( array_unique($account_fields ) );
		}//end get_account_page_fields()


		public function get_registration_fields() {

			$af_cf_args         = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);
			$af_cf_extra_fields = get_posts($af_cf_args);

			$registration_fields = array();

			foreach ($af_cf_extra_fields as $field_id ) {

				$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);

				if ('yes' == $is_dependent) {
					continue;
				}

				if (is_checkout() && in_array('checkout', (array) get_post_meta($field_id, 'af_c_f_field_pages', true))) {
					continue;
				}

				if (in_array('registration', (array) get_post_meta($field_id, 'af_c_f_field_pages', true))) {

					$registration_fields[] = $field_id;

					$dependent_fields = $this->get_dependent_field($field_id);

					if (!empty($dependent_fields)) {
						$dependent_fields = $this->get_multilevel_dependent_fields($dependent_fields);
					}

					if (!empty($dependent_fields)) {

						foreach ($dependent_fields as $dep_field) {
							$registration_fields[] = $dep_field;
						}
					}
				}
			}

			return $registration_fields;
		}//end get_registration_fields()


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


		public function get_dependent_field( $par_field_id, $filter_by_role = false ) {

			if (empty($this->dependent_fields)) {
				return;
			}

			$dependent_fields = array();

			foreach ($this->dependent_fields as $field_id ) {

				if (get_post_meta($field_id, 'af_c_f_dep_fields', true) == $par_field_id ) {
					$dependent_fields[] = $field_id;
				}
			}

			if (!empty($dependent_fields)) {
				$dependent_fields = $this->get_multilevel_dependent_fields($dependent_fields);
			}

			if ($filter_by_role) {

				$user_role = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';

				if (!empty($dependent_fields)) {

					foreach ($dependent_fields as $key => $field_id ) {

						$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

						if (!empty($field_roles)) {

							if (!in_array($user_role, $field_roles)) {
								unset($dependent_fields[ $key ]);
							}
						}
					}
				}
			}


			return $dependent_fields;
		}//end get_dependent_field()


		public function get_multiple_dependent_field( $par_field_id, $dependent_fields = array() ) {

			if (empty($this->dependent_fields)) {
				$this->dependent_fields = $this->get_all_dependent_fields();
			}

			if (empty($this->dependent_fields)) {
				return;
			}

			foreach ($this->dependent_fields as $field_id ) {

				if (get_post_meta($field_id, 'af_c_f_dep_fields', true) == $par_field_id) {

					$dependent_fields[] = $field_id;
				}
			}

			return array_filter($dependent_fields);
		}//end get_multiple_dependent_field()


		public function get_all_dependent_fields() {

			$args = array(
				'numberposts'      => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'meta_key'         => 'af_c_f_dependable',
				'meta_value'       => 'yes',
				'fields'           => 'ids',
			);

			$fields = get_posts($args);

			return $fields;
		}//end get_all_dependent_fields()


		public function af_c_f_extra_fields_show() {
			?>

			<div class="af_c_f_extra_fields">
				<h3><?php echo esc_html__(get_option('af_c_f_additional_fields_section_title'), 'af_custom_fields'); ?></h3>

				<?php

				$user = wp_get_current_user();

				wp_nonce_field('af_c_f_nonce_action', 'af_c_f_nonce_field');

				if (isset($_POST['register']) && '' != $_POST['register']) {

					if (!empty($_REQUEST['af_c_f_nonce_field'])) {

						$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
					} else {
						$retrieved_nonce = 0;
					}

					if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

						wp_die(esc_html__('Security Violated', 'af_custom_fields'));
					}
				}


				if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {

					if (!empty(get_option('af_c_f_user_role_field_text'))) {

						$role_field_label = get_option('af_c_f_user_role_field_text');
					} else {

						$role_field_label = 'Select User Role';
					}

					// When error values should stay
					if (!empty($_POST['af_c_f_user_roles'])) {
						$vall =  sanitize_text_field($_POST['af_c_f_user_roles']);
					} else {
						$vall = '';
					}

					include AF_CF_PLUGIN_DIR . 'templates/registration/user-roles-dropdown.php';
				}

				$af_c_f_extra_fields = $this->get_registration_fields();

				if (!empty($af_c_f_extra_fields)) {

					foreach ($af_c_f_extra_fields as $field_id ) {

						$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);

						if ('yes' == $is_dependent) {
							continue;
						}

						// When error values should stay
						if (!empty($_POST[ 'af_c_f_additional_' . intval($field_id) ])) {
							$vall =  sanitize_text_field($_POST[ 'af_c_f_additional_' . intval($field_id) ]);
						} else {
							$vall = '';
						}

						if (!empty($_POST[ 'af_c_f_additional_' . intval($field_id) ])) {
							$vall_checkbox =  sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '');
						} else {
							$vall_checkbox = array();
						}


						$af_c_f_field_type     = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
						$af_c_f_field_options  = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
						$af_c_f_field_required = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
						$af_c_f_field_width    = get_post_meta(intval($field_id), 'af_c_f_field_width', true);

						if (!empty(get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true))) {
							$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
						} else {
							$af_c_f_field_placeholder = '';
						}

						if (is_checkout() && 'fileupload' == $af_c_f_field_type) {
							continue;
						}

						$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);
						$af_c_f_field_css         = get_post_meta(intval($field_id), 'af_c_f_field_css', true);

						if (!empty($af_c_f_field_width) && 'full' == $af_c_f_field_width) {

							$af_c_f_main_class = 'form-row-wide newr';
						} elseif (!empty($af_c_f_field_width) && 'half' == $af_c_f_field_width) {

							$af_c_f_main_class = 'half_width newr';
						}

						if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

							$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
						} else {
							$af_c_f_is_dependable = 'off';
						}

						$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

						$custom_attributes = '';

						include AF_CF_PLUGIN_DIR . 'templates/registration/registration-fields.php';

						$this->show_dependent_field($field_id);
					}
				}
				?>
			</div>
			<?php
		}//end af_c_f_extra_fields_show()


		public function show_dependent_field( $par_field_id, $page = 'registration' ) {

			if ('account' == $page) {
				$dependent_fields = $this->get_dependent_field($par_field_id, true);
			} else {
				$dependent_fields = $this->get_dependent_field($par_field_id);
			}

			if (empty($dependent_fields)) {
				return;
			}

			foreach ($dependent_fields as $field_id ) {

				$key = 'af_c_f_additional_' . $field_id;

				$af_c_f_field_type      = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
				$af_c_f_field_options   = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
				$af_c_f_field_required  = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
				$af_c_f_field_width     = get_post_meta(intval($field_id), 'af_c_f_field_width', true);
				$af_c_f_field_read_only = get_post_meta(intval($field_id), 'af_c_f_field_read_only', true);

				if (is_checkout() && 'fileupload' == $af_c_f_field_type) {
					continue;
				}

				if (!empty(get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true))) {
					$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
				} else {
					$af_c_f_field_placeholder = '';
				}

				$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);
				$af_c_f_field_css         = get_post_meta(intval($field_id), 'af_c_f_field_css', true);

				if (!empty($af_c_f_field_width) && 'full' == $af_c_f_field_width) {

					$af_c_f_main_class = 'form-row-wide newr af_c_f_is_dependable';
				} elseif (!empty($af_c_f_field_width) && 'half' == $af_c_f_field_width) {

					$af_c_f_main_class = 'half_width newr af_c_f_is_dependable';
				}

				if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

					$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
				} else {
					$af_c_f_is_dependable = 'off';
				}

				$parent_field_type = get_post_meta($par_field_id, 'af_c_f_field_type', true);

				$value = get_user_meta(get_current_user_id(), 'af_c_f_additional_' . intval($field_id), true);

				$dependable_values = get_post_meta($field_id, 'af_c_f_dependable_values', true);
				$dep_fields        = get_post_meta($field_id, 'af_c_f_dep_fields', true);

				$class = 'af_c_f_is_dependable ';

				$class .= 'half' == $af_c_f_field_width ? 'half_width' : 'form-row-wide';

				if (in_array($parent_field_type, array( 'radio', 'multi_checkbox' ))) {

					$class .= ' multiple_dependable';
				}

				if (empty($dependable_values)) {

					$custom_attributes = 'data-dependent_on=af_c_f_additional_' . $dep_fields;
				} else {

					if ('checkbox' == get_post_meta($dep_fields, 'af_c_f_field_type', true)) {
						$dependable_values = '1';
					}

					$custom_attributes = 'data-dependent_val=' . $dependable_values . ' data-dependent_on=af_c_f_additional_' . $dep_fields;
				}

				$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

				if ('account' == $page) {

					include AF_CF_PLUGIN_DIR . 'templates/my-account/account-fields.php';
				} else {

					include AF_CF_PLUGIN_DIR . 'templates/registration/registration-fields.php';
				}
			}
		}//end show_dependent_field()


		public function af_c_f_validate_extra_register_fields( $username, $email, $validation_errors ) {

			if (isset($_POST['register']) || is_checkout()) {

				if (isset($_POST['af_c_f_user_roles']) && empty($_POST['af_c_f_user_roles'])) {

					if (!empty(get_option('af_c_f_user_role_field_text'))) {

						$role_field_label = get_option('af_c_f_user_role_field_text');
					} else {

						$role_field_label = __('Select User Role', 'af_custom_fields');
					}

					$validation_errors->add('af_c_f_user_roles_error', esc_html__($role_field_label . ' is required!', 'af_custom_fields'));
				}

				$af_c_f_extra_fields = $this->get_registration_fields();

				if (!empty($af_c_f_extra_fields)) {

					if (!empty($_REQUEST['af_c_f_nonce_field'])) {

						$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
					} else {
						$retrieved_nonce = 0;
					}

					if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

						wp_die(esc_html__('Security Violated', 'af_custom_fields'));
					}

					if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {

						if (isset($_POST['af_c_f_user_roles']) && empty($_POST['af_c_f_user_roles'])) {

							if (!empty(get_option('af_c_f_user_role_field_text'))) {

								$role_field_label = get_option('af_c_f_user_role_field_text');
							} else {

								$role_field_label = 'Select User Role';
							}

							// translators: %s: field label
							$validation_errors->add('af_c_f_user_roles_error', esc_html($role_field_label) . esc_html__(' is required!', 'af_custom_fields'));
							return;
						}
					}

					$excluded_fields = $this->get_excluded_dependent_fields();

					foreach ($af_c_f_extra_fields as $field_id ) {

						if (in_array($field_id, $excluded_fields)) {
							continue;
						}

						$field_pages = (array) get_post_meta($field_id, 'af_c_f_field_pages', true);

						if (is_checkout() && in_array('checkout', $field_pages)) {
							continue;
						}

						$dependent_fields = $this->get_dependent_field($field_id);

						$af_c_f_field_required  = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
						$af_c_f_field_type      = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
						$af_c_f_field_file_type = get_post_meta(intval($field_id), 'af_c_f_field_file_type', true);
						$af_c_f_field_file_size = get_post_meta(intval($field_id), 'af_c_f_field_file_size', true);
						$af_c_f_field_options   = get_post_meta(intval($field_id), 'af_c_f_field_option', true);

						if (is_checkout() && 'fileupload' == $af_c_f_field_type) {
							continue;
						}

						if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

							$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
						} else {
							$af_c_f_is_dependable = 'off';
						}

						if (in_array($af_c_f_field_type, array( 'heading', 'message' ))) {
							continue;
						}

						$previous_value = get_user_meta(get_current_user_id(), 'af_c_f_additional_' . $field_id, true);
						$field_roles    = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

						include AF_CF_PLUGIN_DIR . 'includes/registration/validate-fields.php';
					}
				}
			}

			return $validation_errors;
		}//end af_c_f_validate_extra_register_fields()


		public function af_c_f_validate_extra_register_fields_wordpress( $validation_errors, $username, $email ) {

			$af_c_f_args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);

			if (isset($_POST['af_c_f_user_roles']) && empty($_POST['af_c_f_user_roles'])) {

				if (!empty(get_option('af_c_f_user_role_field_text'))) {

					$role_field_label = get_option('af_c_f_user_role_field_text');
				} else {

					$role_field_label = 'Select User Role';
				}

				$validation_errors->add('af_c_f_user_roles_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__($role_field_label, 'af_custom_fields')) . esc_html__(' is required.', 'af_custom_fields'));
			}

			$af_c_f_extra_fields = get_posts($af_c_f_args);

			if (!empty($af_c_f_extra_fields)) {

				if (!empty($_REQUEST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated', 'af_custom_fields'));
				}

				foreach ($af_c_f_extra_fields as $field_id ) {

					$af_c_f_field_required  = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
					$af_c_f_field_type      = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
					$af_c_f_field_file_type = get_post_meta(intval($field_id), 'af_c_f_field_file_type', true);
					$af_c_f_field_file_size = get_post_meta(intval($field_id), 'af_c_f_field_file_size', true);

					if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

						$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
					} else {
						$af_c_f_is_dependable = 'off';
					}

					$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);


					if (!empty($field_roles)) {

						if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {

							if (isset($_POST['af_c_f_user_roles']) && !empty($_POST['af_c_f_user_roles'])) {

								if (in_array($_POST['af_c_f_user_roles'], $field_roles)) {

									if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required )) {

										// translators: %s: field label
										$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
									}

									if ('email' == $af_c_f_field_type) {

										if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && !empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_EMAIL)) {

											// translators: %s: field label
											$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is not a valid email address!', 'af_custom_fields'), get_the_title($field_id)));
										}
									}

									if ('multiselect' == $af_c_f_field_type) {

										if (empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && 'on' == $af_c_f_field_required) {

											// translators: %s: field label
											$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
										}
									}

									if ('number' == $af_c_f_field_type) {

										if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && !empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_INT)) {

											// translators: %s: field label
											$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' .
												esc_html(get_the_title($field_id)) . esc_html__(' is not a valid number!', 'af_custom_fields'));
										}
									}

									if ('multi_checkbox' == $af_c_f_field_type || 'checkbox' == $af_c_f_field_type || 'radio' == $af_c_f_field_type) {

										if (!isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required )) {

											// translators: %s: field label
											$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
										}
									}


									if ('googlecaptcha' == $af_c_f_field_type) {

										if (isset($_POST['g-recaptcha-response']) && '' != $_POST['g-recaptcha-response']) {
											$ccheck = $this->captcha_check(sanitize_text_field($_POST['g-recaptcha-response']));
											if ('' == $ccheck) {
												// translators: %s: field label
												$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html__('Invalid reCaptcha!', 'af_custom_fields'));
											}
										} else {
											// translators: %s: field label
											$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
										}
									}

									if ('fileupload' == $af_c_f_field_type) {

										if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

											// translators: %s: field label
											$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
										}

										if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && !empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

											$af_c_f_allowed_types =  explode(',', $af_c_f_field_file_type);
											$af_c_f_filename      = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);
											$af_c_f_ext           = pathinfo($af_c_f_filename, PATHINFO_EXTENSION);

											if (!in_array($af_c_f_ext, $af_c_f_allowed_types)) {

												// translators: %s: field label
												$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(get_the_title($field_id)) . esc_html__(': File type is not allowed!', 'af_custom_fields'));
											}

											if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size'])) {

												$af_c_f_filesize = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size']);
											} else {
												$af_c_f_filesize = 0;
											}

											// translators: %s: field label
											$af_c_f_allowed_size = $af_c_f_field_file_size * 1000000; // convert from MB to Bytes

											if ($af_c_f_filesize > $af_c_f_allowed_size) {

												$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(get_the_title($field_id)) . esc_html__(': File size is too big!', 'af_custom_fields'));
											}
										}
									}
								}
							}
						}
					} else {

						if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required )) {

							// translators: %s: field label
							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
						}

						if ('email' == $af_c_f_field_type) {

							if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && !empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_EMAIL)) {

								// translators: %s: field label
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(get_the_title($field_id)) . esc_html__(' is not a valid email address!', 'af_custom_fields'));
							}
						}

						if ('multiselect' == $af_c_f_field_type) {

							if (empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && 'on' == $af_c_f_field_required) {

								// translators: %s: field label
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
							}
						}

						if ('number' == $af_c_f_field_type) {

							if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && !empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_INT)) {

								// translators: %s: field label
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(get_the_title($field_id)) . esc_html__(' is not a valid number!', 'af_custom_fields'));
							}
						}

						if ('multi_checkbox' == $af_c_f_field_type || 'checkbox' == $af_c_f_field_type || 'radio' == $af_c_f_field_type) {

							if (!isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required )) {

								// translators: %s: field label
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
							}
						}


						if ('googlecaptcha' == $af_c_f_field_type) {

							if (isset($_POST['g-recaptcha-response']) && '' != $_POST['g-recaptcha-response']) {
								$ccheck = $this->captcha_check(sanitize_text_field($_POST['g-recaptcha-response']));
								if ('error' == $ccheck) {
									// translators: %s: field label
									$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html__('Invalid reCaptcha!', 'af_custom_fields'));
								}
							} else {
								// translators: %s: field label
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
							}
						}

						if ('fileupload' == $af_c_f_field_type) {

							if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

								// translators: %s: field label
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . sprintf(esc_html__('%s is required.', 'af_custom_fields'), get_the_title($field_id)));
							}

							if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && !empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

								$af_c_f_allowed_types =  explode(',', $af_c_f_field_file_type);
								$af_c_f_filename      = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);
								$af_c_f_ext           = pathinfo($af_c_f_filename, PATHINFO_EXTENSION);

								if (!in_array($af_c_f_ext, $af_c_f_allowed_types)) {

									// translators: %s: field label
									$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(get_the_title($field_id)) . esc_html__(': File type is not allowed!', 'af_custom_fields'));
								}

								if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size'])) {

									$af_c_f_filesize = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size']);
								} else {
									$af_c_f_filesize = 0;
								}

								$af_c_f_allowed_size = $af_c_f_field_file_size * 1000000; // convert from MB to Bytes

								if ($af_c_f_filesize > $af_c_f_allowed_size) {

									// translators: %s: field label
									$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(get_the_title($field_id)) . esc_html__(': File size is too big!', 'af_custom_fields'));
								}
							}
						}
					}
				}
			}

			return $validation_errors;
		}//end af_c_f_validate_extra_register_fields_wordpress()



		public function af_c_f_save_extra_fields( $customer_id ) {

			$user = new WP_User($customer_id);

			if (!isset($_POST['af_c_f_user_roles']) || empty($_POST['af_c_f_user_roles'])) {
				$user->set_role(get_option('default_role'));
			}


			if (isset($_POST['first_name'])) {

				if (!empty($_REQUEST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated', 'af_custom_fields'));
				}
			}

			// Manual Approve User
			if (!empty(get_option('af_c_f_enable_approve_user')) && 'yes' == get_option('af_c_f_enable_approve_user')) {
				if (isset($_POST['af_c_f_user_roles']) && '' != $_POST['af_c_f_user_roles']) {
					$default_role = sanitize_text_field($_POST['af_c_f_user_roles']);
				} else {

					$default_role = get_option('default_role');
				}

				if (!empty(get_option('af_c_f_exclude_user_roles_approve_new_user'))) {
					$manual_user_roles = get_option('af_c_f_exclude_user_roles_approve_new_user');
				} else {
					$manual_user_roles = array();
				}


				if (!in_array($default_role, $manual_user_roles)) {

					if (is_checkout() && 'yes' == get_option('af_c_f_enable_approve_user_checkout')) {
						update_user_meta($customer_id, 'af_c_f_new_user_status', 'pending');
					} elseif (!is_checkout()) {
						update_user_meta($customer_id, 'af_c_f_new_user_status', 'pending');
					} elseif (is_account_page() && is_wc_endpoint_url('edit-account')) {

						update_user_meta($customer_id, 'af_c_f_new_user_status', 'approved');
					} else {
						update_user_meta($customer_id, 'af_c_f_new_user_status', 'approved');
					}
				}
			}

			// Default Fields
			$def_fiels_email_fields = '';
			// First Name
			if (isset($_POST['first_name']) && '' != $_POST['first_name']) {
				update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['first_name']));
				update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['first_name']));

				$checkfield = $this->getFieldBySlug('first_name');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'First Name';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['first_name']) . '</p>';
			}

			// Last Name
			if (isset($_POST['last_name']) && '' != $_POST['last_name']) {
				update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['last_name']));
				update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['last_name']));

				$checkfield = $this->getFieldBySlug('last_name');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Last Name';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['last_name']) . '</p>';
			}

			// Company
			if (isset($_POST['billing_company'])) {
				update_user_meta($customer_id, 'billing_company', sanitize_text_field($_POST['billing_company']));

				$checkfield = $this->getFieldBySlug('billing_company');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Company';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_company']) . '</p>';
			}

			// country
			if (isset($_POST['billing_country'])) {
				update_user_meta($customer_id, 'billing_country', sanitize_text_field($_POST['billing_country']));


				$checkfield = $this->getFieldBySlug('billing_country');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Country';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_country']) . '</p>';
			}


			// address 1
			if (isset($_POST['billing_address_1'])) {
				update_user_meta($customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));

				$checkfield = $this->getFieldBySlug('billing_address_1');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Address 1';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_address_1']) . '</p>';
			}

			// address 2
			if (isset($_POST['billing_address_2'])) {
				update_user_meta($customer_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));

				$checkfield = $this->getFieldBySlug('billing_address_2');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Address 2';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_address_2']) . '</p>';
			}

			// city
			if (isset($_POST['billing_city'])) {
				update_user_meta($customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']));

				$checkfield = $this->getFieldBySlug('billing_city');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'City';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_city']) . '</p>';
			}

			// state
			if (isset($_POST['billing_state'])) {
				update_user_meta($customer_id, 'billing_state', sanitize_text_field($_POST['billing_state']));

				$checkfield = $this->getFieldBySlug('billing_state');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'State';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_state']) . '</p>';
			}

			// postcode
			if (isset($_POST['billing_postcode'])) {
				update_user_meta($customer_id, 'billing_postcode', sanitize_text_field($_POST['billing_postcode']));

				$checkfield = $this->getFieldBySlug('billing_postcode');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Post Code';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_postcode']) . '</p>';
			}

			// phone
			if (isset($_POST['billing_phone'])) {
				update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));

				$checkfield = $this->getFieldBySlug('billing_phone');

				if (!empty($checkfield)) {

					$title = get_post(current($checkfield))->post_title;
				} else {
					$title = 'Phone';
				}

				$def_fiels_email_fields .= '<p><b>' . esc_html__($title . ': ', 'af_custom_fields') . '</b>' . sanitize_text_field($_POST['billing_phone']) . '</p>';
			}

			if (!empty($_POST['af_c_f_user_roles'])) {


				// User Role
				if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {
					$user_roles = get_option('af_c_f_user_roles');
					$user       = new WP_User($customer_id);

					if (!empty($user_roles)) {

						if (!empty($_POST['af_c_f_user_roles']) && in_array($_POST['af_c_f_user_roles'], $user_roles)) {

							$user->set_role(sanitize_text_field($_POST['af_c_f_user_roles']));
						} else {
							$user->set_role(get_option('default_role'));
						}
					}
				}
			}

			$af_c_f_extra_fields = $this->get_registration_fields();

			if (is_checkout()) {

				$this->af_checkout->save_checkout_user_fields($customer_id);
			}

			if (!empty($af_c_f_extra_fields)) {

				foreach ($af_c_f_extra_fields as $field_id ) {

					if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

						$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
					} else {
						$af_c_f_is_dependable = 'off';
					}

					$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

					$af_c_f_field_type = get_post_meta(intval($field_id), 'af_c_f_field_type', true);

					if (!empty($field_roles)) {

						if (isset($_POST['af_c_f_user_roles']) && in_array($_POST['af_c_f_user_roles'], $field_roles)) {

							if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) || isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ])) {

								if ('fileupload' == $af_c_f_field_type) {

									if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && '' != $_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) {

										$file = time() . sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);


										if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name'])) {

											$temp = move_uploaded_file(sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name']), AF_CF_UPLOAD_DIR . $file);
										} else {

											$temp = '';
										}

										update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), $file);
									}
								} elseif ('multiselect' == $af_c_f_field_type) {
									$prefix   = '';
									$multival = sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '');

									$multival = implode(',', $multival);

									update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
								} elseif ('multi_checkbox' == $af_c_f_field_type) {
									$prefix   = '';
									$multival = '';
									$multival = sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '');

									$multival = implode(',', $multival);

									update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
								} else {

									update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($_POST[ 'af_c_f_additional_' . intval($field_id) ]));
								}
							}
						}
					} elseif (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) || isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ])) {


						if ('fileupload' == $af_c_f_field_type) {

							if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && '' != $_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) {

								$file = time() . sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);


								if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name'])) {

									$temp = move_uploaded_file(sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name']), AF_CF_UPLOAD_DIR . $file);
								} else {

									$temp = '';
								}

								update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), $file);
							}
						} elseif ('multiselect' == $af_c_f_field_type) {

							$multival = sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '');
							$multival = implode(',', $multival);

							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
						} elseif ('multi_checkbox' == $af_c_f_field_type) {

							$multival = sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '');
							$multival = implode(',', $multival);

							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
						} else {

							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($_POST[ 'af_c_f_additional_' . intval($field_id) ]));
						}
					}
				}
			}

			if ('pending' == get_user_meta($customer_id, 'af_c_f_new_user_status', true)) {
				wc()->mailer()->emails['af_email_register_new_account']->trigger($customer_id);
			}

			wc()->mailer()->emails['af_email_admin_register_new_user']->trigger($customer_id);
		}//end af_c_f_save_extra_fields()


		public function af_c_f_update_extra_fields_my_account() {

			global $wp_roles;

			$all_roles = $wp_roles->get_names();

			$user  = wp_get_current_user();
			$roles = (array) $user->roles;
			wp_nonce_field('af_c_f_nonce_action', 'af_c_f_nonce_field');
			?>
			<div class="af_c_f_extra_fields">
				<h3><?php echo esc_html__(get_option('af_c_f_additional_fields_section_title'), 'af_custom_fields'); ?></h3>
				<fieldset>

					<!-- User Role -->

					<?php

					if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {

						if (!empty(get_option('af_c_f_user_role_field_text'))) {

							$role_field_label = get_option('af_c_f_user_role_field_text');
						} else {

							$role_field_label = 'Select User Role';
						}


						?>

						<p class="form-row form-row-wide">
							<label for="af_c_f_user_role"><?php echo esc_html__($role_field_label, 'af_custom_fields'); ?></label>
							<b>
								<?php
								if (isset($all_roles[ current($roles) ])) {
									echo esc_attr($all_roles[ current($roles) ]);
								}
								?>
							</b>
						</p>

						<?php
					}

					$af_c_f_extra_fields = $this->get_account_page_fields();

					if (!empty($af_c_f_extra_fields)) {

						foreach ($af_c_f_extra_fields as $field_id ) {

							$is_dependent = get_post_meta($field_id, 'af_c_f_dependable', true);

							if ('yes' == $is_dependent) {
								continue;
							}

							if (!in_array('my-account', (array) get_post_meta($field_id, 'af_c_f_field_pages', true))) {
								continue;
							}

							$af_c_f_field_type     = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
							$af_c_f_field_options  = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
							$af_c_f_field_required = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
							$af_c_f_field_width    = get_post_meta(intval($field_id), 'af_c_f_field_width', true);
							if (!empty(get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true))) {
								$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
							} else {
								$af_c_f_field_placeholder = '';
							}
							$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);
							$af_c_f_field_css         = get_post_meta(intval($field_id), 'af_c_f_field_css', true);
							$af_c_f_field_read_only   = get_post_meta($field_id, 'af_c_f_field_read_only', true);

							if (!empty($af_c_f_field_width) && 'full' == $af_c_f_field_width) {

								$af_c_f_main_class = 'form-row-wide';
							} elseif (!empty($af_c_f_field_width) && 'half' == $af_c_f_field_width) {

								$af_c_f_main_class = 'half_width';
							}

							$value = get_user_meta(intval($user->ID), 'af_c_f_additional_' . intval($field_id), true);


							if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

								$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
							} else {
								$af_c_f_is_dependable = 'off';
							}

							$custom_attributes = '';

							$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

							if (in_array(current($roles), (array) $field_roles) || empty($field_roles)) {

								include AF_CF_PLUGIN_DIR . 'templates/my-account/account-fields.php';

								$this->show_dependent_field($field_id, 'account');
							}
						}
					}
					?>
				</fieldset>
			</div>

			<?php
		}//end af_c_f_update_extra_fields_my_account()


		public function af_c_f_validate_update_role_my_account( $validation_errors ) {

			$af_c_f_allowed_tags = array(
				'strong' => array(),
			);

			$af_c_f_extra_fields = $this->get_account_page_fields();

			if (!empty($af_c_f_extra_fields)) {

				if (!empty($_REQUEST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated 1', 'af_custom_fields'));
				}

				$user  = wp_get_current_user();
				$roles = (array) $user->roles;

				$excluded_fields = $this->get_excluded_dependent_fields();

				foreach ($af_c_f_extra_fields as $field_id ) {

					if (in_array($field_id, $excluded_fields)) {
						continue;
					}

					$af_c_f_field_required  = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
					$af_c_f_field_type      = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
					$af_c_f_field_file_type = get_post_meta(intval($field_id), 'af_c_f_field_file_type', true);
					$af_c_f_field_file_size = get_post_meta(intval($field_id), 'af_c_f_field_file_size', true);
					$af_c_f_field_read_only = get_post_meta(intval($field_id), 'af_c_f_field_read_only', true);

					$dependent_fields = $this->get_dependent_field($field_id);

					if ('on' == $af_c_f_field_read_only) {
						continue;
					}

					if (in_array($af_c_f_field_type, array( 'heading', 'message' ))) {
						continue;
					}

					$previous_value = get_user_meta(get_current_user_id(), 'af_c_f_additional_' . $field_id, true);

					if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

						$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
					} else {
						$af_c_f_is_dependable = 'off';
					}

					$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

					if (isset($_POST['af_c_f_user_roles'])) {

						$user_role = !empty($_POST['af_c_f_user_roles']) ? sanitize_text_field($_POST['af_c_f_user_roles']) : 'guest';

						if (!empty($field_roles) && !in_array($user_role, $field_roles)) {
							continue;
						}
					}

					if (!isset($_POST['af_c_f_user_roles'])) {

						$user_role = is_user_logged_in() ? current(wp_get_current_user()->roles) : 'guest';

						if (!empty($field_roles) && !in_array($user_role, $field_roles)) {
							continue;
						}
					}

					include AF_CF_PLUGIN_DIR . 'includes/account/validate-fields.php';
				}
			}

			return $validation_errors;
		}//end af_c_f_validate_update_role_my_account()


		public function get_excluded_dependent_fields() {

			$excluded_dependent_fields = array();
			$visible_fields            = array();

			$independent_fields = $this->get_independent_fields();
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

				if (isset($_POST[ 'af_c_f_additional_' . $parent_field_id ])) {
					if (!empty($_REQUEST['af_c_f_nonce_field'])) {

						$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
					} else {
						$retrieved_nonce = 0;
					}

					if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

						wp_die(esc_html__('Security Violated 2', 'af_custom_fields'));
					}
					$post_value = sanitize_meta('', wp_unslash($_POST[ 'af_c_f_additional_' . $parent_field_id ]), '');
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


		public function get_independent_fields() {

			$checkout_fields  = $this->get_fields();
			$dependent_fields = $this->dependent_fields;

			$independent_fields = array_diff($checkout_fields, $dependent_fields);

			return $independent_fields;
		}//end get_independent_fields()


		public function get_fields() {
			$args = array(
				'numberposts'      => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);

			$fields = get_posts($args);

			return $fields;
		}//end get_fields()


		public function get_tree_of_fields( $independent_fields = array() ) {

			if (empty($independent_fields)) {
				$independent_fields = $this->get_independent_fields();
			}

			$recursion = true;

			$tree = array();

			foreach ($independent_fields as $parent_field_id) {

				$dependent_fields = $this->get_multiple_dependent_field($parent_field_id);
				$dependent_fields = is_array($dependent_fields) ? array_filter($dependent_fields) : '';
				$post_value       = '';

				if (!empty($dependent_fields)) {

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
			return isset($node['value']) ? $node['value'] : '';
		}//end visit_node()


		public function preorder_tree_traversal( array $node, $find_id = 0 ) {

			if (empty($traversed_nodes)) {
				$traversed_nodes = array();
			}

			array_push($traversed_nodes, $this->visit_node($node));

			if (!empty($find_id) && $find_id == $this->visit_node($node)) {
				return $node;
			}

			if (!empty($node['children'])) {

				foreach ($node['children'] as $child) {

					$traversed_nodes =  array_merge($traversed_nodes, $this->preorder_tree_traversal($child));
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

			if (!empty($find_id) && $find_id == $this->visit_node($node)) {
				return $node;
			}

			$output[] = $this->visit_node($node);

			// Add any children to the queue.
			if (!empty($node['children'])) {
				foreach ($node['children'] as $child) {
					$queue[] = $child;
				}
			}

			// Repeat the algorithm with the rest of the queue.
			return $this->find_node_in_tree($queue, $output, $find_id);
		}//end find_node_in_tree()


		public function find_option_of_value( $value, $options ) {

			$options = is_serialized($options) ? ( $options ) : array();

			foreach ($options as $option) {

				if ($value == $option['field_value']) {
					return $option;
				}
			}
		}//end find_option_of_value()


		public function get_excluded_field_cart() {
			if (wc()->cart->is_empty()) {
				return array();
			}

			$excluded_fields = array();

			foreach ($this->get_checkout_fields() as $field_id) {

				$field_products   = get_post_meta($field_id, 'af_c_f_field_products', true);
				$field_categories = get_post_meta($field_id, 'af_c_f_field_categories', true);
				$field_tags       = get_post_meta($field_id, 'af_c_f_field_tags', true);

				if (empty($field_products) && empty($field_categories) && empty($field_tags)) {
					continue;
				}

				$match_product = false;

				foreach (wc()->cart->get_cart_contents() as $cart_item_key  => $cart_item) {

					$product_id = $cart_item['product_id'];

					if (!empty($field_products)) {
						if (in_array($product_id, $field_products)) {
							$match_product = true;
							break;
						}
					}

					if (!empty($field_categories)) {
						if (has_term($field_categories, 'product_cat', $product_id)) {
							$match_product = true;
							break;
						}
					}

					if (!empty($field_tags)) {
						if (has_term($field_tags, 'product_tag', $product_id)) {
							$match_product = true;
							break;
						}
					}
				}

				if (!$match_product) {
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
			if (!empty($node['children'])) {
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


		public function af_c_f_save_update_role_my_account( $customer_id ) {

			$af_c_f_extra_fields = $this->get_account_page_fields();

			if (!empty($af_c_f_extra_fields)) {

				if (!empty($_REQUEST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated 2', 'af_custom_fields'));
				}

				Af_C_F_General_Functions::empty_all_data_before_updation( $customer_id );

				foreach ($af_c_f_extra_fields as $field_id ) {


					$af_c_f_field_type        = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
					$af_c_f_field_read_only   = get_post_meta($field_id, 'af_c_f_field_read_only', true);
					$af_c_f_dependable        = get_post_meta($field_id, 'af_c_f_dependable', true);
					$af_c_f_dep_fields        = get_post_meta($field_id, 'af_c_f_dep_fields', true);
					$af_c_f_dependable_values = explode(',', get_post_meta($field_id, 'af_c_f_dependable_values', true) );
					
					
					if ('on' != $af_c_f_field_read_only) {


						if ( 'yes' == $af_c_f_dependable && isset( $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ] )  ) {
						
							$filed_value = array( '' );

							if ( isset( $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ]) && is_array( $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ] ) && count( $af_c_f_dependable_values ) >= 1 ) {

								$filed_value =  sanitize_meta( '', $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ] , '' );

							} elseif ( isset( $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ]) && ! is_array( $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ] ) ) {

								$filed_value =  array( sanitize_text_field( $_POST[ 'af_c_f_additional_' . $af_c_f_dep_fields ] ) );
							}


							if ( ! array_intersect($af_c_f_dependable_values , $filed_value ) ) {
								continue;

							}

						}

						if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) || isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ])) {

							if ('fileupload' == $af_c_f_field_type) {

								if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && '' != $_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) {

									if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name'])) {
										$file = time() . sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);
									} else {
										$file = '';
									}


									if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name'])) {
										$temp = move_uploaded_file(sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['tmp_name']), AF_CF_UPLOAD_DIR . $file);
									} else {
										$temp = '';
									}

									update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), $file);
								}
							} elseif ('multiselect' == $af_c_f_field_type) {
								$prefix   = '';
								$multival = '';
								foreach (sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '') as $value) {
									$multival .= $prefix . $value;
									$prefix    = ', ';
								}
								update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
							} elseif ('multi_checkbox' == $af_c_f_field_type) {
								$prefix   = '';
								$multival = '';
								foreach (sanitize_meta('', $_POST[ 'af_c_f_additional_' . intval($field_id) ], '') as $value) {
									$multival .= $prefix . $value;
									$prefix    = ', ';
								}
								update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($multival));
							} else {

								update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), sanitize_text_field($_POST[ 'af_c_f_additional_' . intval($field_id) ]));
							}
						} else {

							update_user_meta($customer_id, 'af_c_f_additional_' . intval($field_id), '');
						}
					}
				}
			}
		}//end af_c_f_save_update_role_my_account()


		public function af_c_f_extra_fields_show_wordpress() {
			wp_nonce_field('af_c_f_nonce_action', 'af_c_f_nonce_field');
			?>
			<div class="wordpress_additional">
				<h3><?php echo esc_html__(get_option('af_c_f_additional_fields_section_title'), 'af_custom_fields'); ?></h3>
				<?php

				if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {

					if (!empty(get_option('af_c_f_user_role_field_text'))) {

						$role_field_label = get_option('af_c_f_user_role_field_text');
					} else {

						$role_field_label = 'Select User Role';
					}

					// When error values should stay
					if (!empty($_POST['af_c_f_user_roles'])) {

						if (!empty($_REQUEST['af_c_f_nonce_field'])) {

							$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
						} else {
							$retrieved_nonce = 0;
						}

						if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

							wp_die(esc_html__('Security Violated', 'af_custom_fields'));
						}

						$vall =  sanitize_text_field($_POST['af_c_f_user_roles']);
					} else {
						$vall = '';
					}

					?>
					<p class="form-row-wordpress">
						<label for="af_c_f_user_role"><?php echo esc_html__($role_field_label, 'af_custom_fields'); ?><span
							class="required">*</span></label>
							<select class="input input-select af-front-fields" name="af_c_f_user_roles" id="af_c_f_user_roles">
								<option value=""><?php echo esc_html__('---Select---', 'af_custom_fields'); ?></option>
								<?php
								$user_roles = get_option('af_c_f_user_roles');
								global $wp_rolesss;
								if (!isset($wp_rolesss)) {
									$wp_rolesss = new WP_Roles();
								}

								if (!empty($user_roles)) {
									foreach ($user_roles as $key => $value) {
										?>
										<option value="<?php echo esc_attr($value); ?>" <?php echo selected($value, $vall); ?>>
											<?php echo esc_attr($wp_rolesss->roles[ $value ]['name']); ?>
										</option>
										<?php 
									}
								} 
								?>
							</select>
						</p>
						<?php
				}

					$af_c_f_args         = array(
						'posts_per_page'   => -1,
						'post_type'        => 'af_c_fields',
						'post_status'      => 'publish',
						'orderby'          => 'menu_order',
						'suppress_filters' => false,
						'order'            => 'ASC',
						'fields'           => 'ids',
					);
					$af_c_f_extra_fields = get_posts($af_c_f_args);
					if (!empty($af_c_f_extra_fields)) {

						foreach ($af_c_f_extra_fields as $field_id ) {

							$af_c_f_field_type        = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
							$af_c_f_field_options     = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
							$af_c_f_field_required    = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
							$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);
							$af_c_f_field_width       = get_post_meta(intval($field_id), 'af_c_f_field_width', true);

							if (!empty($af_c_f_field_width) && 'full' == $af_c_f_field_width) {

								$af_c_f_main_class = 'form-row-wide';
							} elseif (!empty($af_c_f_field_width) && 'half' == $af_c_f_field_width) {

								$af_c_f_main_class = 'form-row-wide';
							}

							if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

								$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
							} else {
								$af_c_f_is_dependable = 'off';
							}

							$field_roles = get_post_meta($field_id, 'af_c_f_field_user_roles', true);

							if ('text' == $af_c_f_field_type) {
								?>

								<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
									id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
									<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
										<?php
										if (!empty(get_the_title($field_id))) {
											echo esc_html__(get_the_title($field_id), 'af_custom_fields');
										}
										?>
										<span class="required">
											<?php
											if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
												?>
												*
												<?php
											}
											?>

										</span></label>
										<input type="text" class="input af-front-fields" name="af_c_f_additional_<?php echo intval($field_id); ?>"
										id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
										<?php if (!empty($af_c_f_field_description)) { ?>
											<br>
											<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
										<?php } ?>
									</p>

								<?php } elseif ('textarea' == $af_c_f_field_type) { ?>

									<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
										id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
										<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
											<?php
											if (!empty(get_the_title($field_id))) {
												echo esc_html__(get_the_title($field_id), 'af_custom_fields');
											}
											?>
											<span class="required">
												<?php
												if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
													?>
													*
													<?php
												}
												?>
											</span></label>
											<textarea rows="7" cols="31" class="input af-front-fields" name="af_c_f_additional_<?php echo intval($field_id); ?>"
												id="af_c_f_additional_<?php echo intval($field_id); ?>"></textarea>
												<?php if (!empty($af_c_f_field_description)) { ?>
													<br>
													<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
												<?php } ?>
											</p>

										<?php } elseif ('email' == $af_c_f_field_type) { ?>

											<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
												id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
												<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
													<?php
													if (!empty(get_the_title($field_id))) {
														echo esc_html__(get_the_title($field_id), 'af_custom_fields');
													}
													?>
													<span class="required">
														<?php
														if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
															?>
															*
															<?php
														}
														?>

													</span></label>
													<input type="text" class="input af-front-fields" name="af_c_f_additional_<?php echo intval($field_id); ?>"
													id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
													<?php if (!empty($af_c_f_field_description)) { ?>
														<br>
														<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
													<?php } ?>
												</p>

											<?php } elseif ('select' == $af_c_f_field_type) { ?>

												<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
													id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
													<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
														<?php
														if (!empty(get_the_title($field_id))) {
															echo esc_html__(get_the_title($field_id), 'af_custom_fields');
														}
														?>
														<span class="required">
															<?php
															if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																?>
																*
																<?php
															}
															?>

														</span></label>
														<select class="inputselect af-front-fields" name="af_c_f_additional_<?php echo intval($field_id); ?>"
															id="af_c_f_additional_<?php echo intval($field_id); ?>">
															<?php foreach ($af_c_f_field_options as $af_c_f_field_option) { ?>
																<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>">
																	<?php
																	if (!empty($af_c_f_field_option['field_text'])) {
																		echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');
																	}
																	?>
																</option>
															<?php } ?>
														</select>
														<?php if (!empty($af_c_f_field_description)) { ?>
															<br>
															<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
														<?php } ?>
													</p>

												<?php } elseif ('multiselect' == $af_c_f_field_type) { ?>

													<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
														id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
														<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
															<?php
															if (!empty(get_the_title($field_id))) {
																echo esc_html__(get_the_title($field_id), 'af_custom_fields');
															}
															?>
															<span class="required">
																<?php
																if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																	?>
																	*
																	<?php
																}
																?>

															</span></label>
															<select class="inputmselect af-front-fields" name="af_c_f_additional_<?php echo intval($field_id); ?>[]"
																id="af_c_f_additional_<?php echo intval($field_id); ?>" multiple>
																<?php
																foreach ($af_c_f_field_options as $af_c_f_field_option) {
																	?>
																	<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>">
																		<?php echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields'); ?>
																	</option>
																<?php } ?>
															</select>
															<?php if (!empty($af_c_f_field_description)) { ?>
																<br>
																<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
															<?php } ?>
														</p>

													<?php } elseif ('multi_checkbox' == $af_c_f_field_type) { ?>

														<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
															id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
															<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																<?php
																if (!empty(get_the_title($field_id))) {
																	echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																}
																?>
																<span class="required">
																	<?php
																	if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																		?>
																		*
																		<?php
																	}
																	?>

																</span></label>
																<?php foreach ($af_c_f_field_options as $af_c_f_field_option) { ?>
																	<input type="checkbox" class="af-front-fields inputradio" name="af_c_f_additional_<?php echo intval($field_id); ?>[]"
																	id="af_c_f_additional_<?php echo intval($field_id); ?>"
																	value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" />
																	<span class="af_c_f_radio">
																		<?php
																		if (!empty($af_c_f_field_option['field_text'])) {
																			echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');
																		}
																		?>
																	</span>
																<?php } ?>

																<?php if (!empty($af_c_f_field_description)) { ?>
																	<br>
																	<span
																	class="af_c_f_field_message_wordpress_checkbox"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																<?php } ?>
															</p>

														<?php } elseif ('checkbox' == $af_c_f_field_type) { ?>

															<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																	<?php
																	if (!empty(get_the_title($field_id))) {
																		echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																	}
																	?>
																	<span class="required">
																		<?php
																		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																			?>
																			*
																			<?php
																		}
																		?>

																	</span></label>

																	<input type="checkbox" class="af-front-fields inputcheckbox" name="af_c_f_additional_<?php echo intval($field_id); ?>"
																	id="af_c_f_additional_<?php echo intval($field_id); ?>" value="yes" />

																	<?php if (!empty($af_c_f_field_description)) { ?>
																		<br>
																		<span
																		class="af_c_f_field_message_wordpress_checkbox"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																	<?php } ?>
																</p>

															<?php } elseif ('radio' == $af_c_f_field_type) { ?>

																<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																	id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																	<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																		<?php
																		if (!empty(get_the_title($field_id))) {
																			echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																		}
																		?>
																		<span class="required">
																			<?php
																			if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																				?>
																				*
																				<?php
																			}
																			?>

																		</span></label>

																		<?php foreach ($af_c_f_field_options as $af_c_f_field_option) { ?>
																			<input type="radio" class="af-front-fields inputradio" name="af_c_f_additional_<?php echo intval($field_id); ?>"
																			id="af_c_f_additional_<?php echo intval($field_id); ?>"
																			value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" />
																			<span class="af_c_f_radio">
																				<?php
																				if (!empty($af_c_f_field_option['field_text'])) {
																					echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');
																				}
																				?>
																			</span>
																		<?php } ?>

																		<?php if (!empty($af_c_f_field_description)) { ?>
																			<br>
																			<span class="af_c_f_field_message_radio_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																		<?php } ?>
																	</p>

																<?php } elseif ('number' == $af_c_f_field_type) { ?>

																	<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																		id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																			<?php
																			if (!empty(get_the_title($field_id))) {
																				echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																			}
																			?>
																			<span class="required">
																				<?php
																				if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																					?>
																					*
																					<?php
																				}
																				?>

																			</span></label>
																			<input type="number" class="af-front-fields input inputnumb" name="af_c_f_additional_<?php echo intval($field_id); ?>"
																			id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
																			<?php if (!empty($af_c_f_field_description)) { ?>
																				<br>
																				<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																			<?php } ?>
																		</p>

																	<?php } elseif ('password' == $af_c_f_field_type) { ?>

																		<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																			id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																				<?php
																				if (!empty(get_the_title($field_id))) {
																					echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																				}
																				?>
																				<span class="required">
																					<?php
																					if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																						?>
																						*
																						<?php
																					}
																					?>

																				</span></label>
																				<input type="password" class="af-front-fields input" name="af_c_f_additional_<?php echo intval($field_id); ?>"
																				id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
																				<?php if (!empty($af_c_f_field_description)) { ?>
																					<br>
																					<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																				<?php } ?>
																			</p>

																		<?php } elseif ('fileupload' == $af_c_f_field_type) { ?>

																			<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																				id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																				<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																					<?php
																					if (!empty(get_the_title($field_id))) {
																						echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																					}
																					?>
																					<span class="required">
																						<?php
																						if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																							?>
																							*
																							<?php
																						}
																						?>

																					</span></label>
																					<input type="file" class="af-front-fields input 
																					<?php
																					if (!empty($af_c_f_field_css)) {
																						echo esc_attr($af_c_f_field_css);
																					}
																					?>
																					" name="af_c_f_additional_<?php echo intval($field_id); ?>"
																					id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" placeholder="
																					<?php
																					if (!empty($af_c_f_field_placeholder)) {
																						echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields');
																					}
																					?>
																					" />
																					<?php if (!empty($af_c_f_field_description)) { ?>
																						<br>
																						<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																					<?php } ?>
																				</p>

																			<?php } elseif ('color' == $af_c_f_field_type) { ?>

																				<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																					id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																					<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																						<?php
																						if (!empty(get_the_title($field_id))) {
																							echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																						}
																						?>
																						<span class="required">
																							<?php
																							if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																								?>
																								*
																								<?php
																							}
																							?>

																						</span></label>
																						<input type="color" class="af-front-fields input color_sepctrum"
																						name="af_c_f_additional_<?php echo intval($field_id); ?>"
																						id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
																						<?php if (!empty($af_c_f_field_description)) { ?>
																							<br>
																							<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																						<?php } ?>
																					</p>

																				<?php } elseif ('datepicker' == $af_c_f_field_type) { ?>

																					<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																						id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																						<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																							<?php
																							if (!empty(get_the_title($field_id))) {
																								echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																							}
																							?>
																							<span class="required">
																								<?php
																								if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																									?>
																									*
																									<?php
																								}
																								?>

																							</span></label>
																							<input type="date" class="af-front-fields input" name="af_c_f_additional_<?php echo intval($field_id); ?>"
																							id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
																							<?php if (!empty($af_c_f_field_description)) { ?>
																								<br>
																								<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																							<?php } ?>
																						</p>

																					<?php } elseif ('timepicker' == $af_c_f_field_type) { ?>

																						<p class="form-row-wordpress <?php echo esc_attr($af_c_f_main_class); ?>"
																							id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																							<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																								<?php
																								if (!empty(get_the_title($field_id))) {
																									echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																								}
																								?>
																								<span class="required">
																									<?php
																									if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
																										?>
																										*
																										<?php
																									}
																									?>

																								</span></label>
																								<input type="time" class="af-front-fields input " name="af_c_f_additional_<?php echo intval($field_id); ?>"
																								id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" />
																								<?php if (!empty($af_c_f_field_description)) { ?>
																									<br>
																									<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																								<?php } ?>
																							</p>

																						<?php } elseif ('googlecaptcha' == $af_c_f_field_type) { ?>

																							<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>"
																								id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
																								<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
																									<?php
																									if (!empty(get_the_title($field_id))) {
																										echo esc_html__(get_the_title($field_id), 'af_custom_fields');
																									}
																									?>
																									<span class="required">*</span></label>

																									<div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('af_c_f_site_key')); ?>"></div>

																									<?php if (!empty($af_c_f_field_description)) { ?>
																										<br>
																										<span class="af_c_f_field_message_wordpress"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
																									<?php } ?>
																								</p>

																								<?php
																						}

																						?>

																							<!-- Dependable -->
																							<?php if (!empty($field_roles)) { ?>

																								<style>
																									#af_c_f_additionalshowhide_
																									<?php 
																									echo intval($field_id);

																									?>
																									{
																										display: none;
																									}
																								</style>

																							<?php } ?>

																							<script>
																								jQuery(document).on('change', '#af_c_f_user_roles', function() {

																									var val = this.value;
																									var field_roles = new Array();
																									var is_dependable = '<?php echo esc_attr($af_c_f_is_dependable); ?>';

																									<?php if (!empty($field_roles)) { ?>
																										<?php foreach ($field_roles as $key => $value) { ?>

																											field_roles.push('<?php echo esc_attr($value); ?>');

																										<?php } ?>

																										var match_val = field_roles.includes(val);

																										if (match_val == true && is_dependable == 'on') {


																											jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

																										} else if (match_val == false && is_dependable == 'on') {

																											jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
																										} else {

																											jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

																										}

																									<?php } ?>


																								});
																								jQuery(document).on('ready', function() {

																									var val = jQuery('#af_c_f_user_roles').val();
																									var field_roles = new Array();
																									var is_dependable = '<?php echo esc_attr($af_c_f_is_dependable); ?>';

																									<?php if (!empty($field_roles)) { ?>
																										<?php foreach ($field_roles as $key => $value) { ?>

																											field_roles.push('<?php echo esc_attr($value); ?>');

																										<?php } ?>

																										var match_val = field_roles.includes(val);

																										if (match_val == true && is_dependable == 'on') {


																											jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

																										} else if (match_val == false && is_dependable == 'on') {

																											jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
																										} else {

																											jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

																										}

																									<?php } ?>


																								});
																							</script>

																							<?php

						}
					}
					?>
																				</div>
																				<?php
		}//end af_c_f_extra_fields_show_wordpress()


		public function aferg_wordpress_registration_errors( $validation_errors, $sanitized_user_login, $user_email ) {

			$af_c_f_args = array(
				'posts_per_page'   => -1,
				'post_type'        => 'af_c_fields',
				'post_status'      => 'publish',
				'orderby'          => 'menu_order',
				'suppress_filters' => false,
				'order'            => 'ASC',
				'fields'           => 'ids',
			);

			$af_c_f_extra_fields = get_posts($af_c_f_args);
			if (!empty($af_c_f_extra_fields)) {

				if (!empty($_REQUEST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated', 'af_custom_fields'));
				}

				if (!empty(get_option('af_c_f_enable_user_role')) && 'yes' == get_option('af_c_f_enable_user_role')) {
					if (isset($_POST['af_c_f_user_roles']) && empty($_POST['af_c_f_user_roles'])) {

						if (!empty(get_option('af_c_f_user_role_field_text'))) {

							$role_field_label = get_option('af_c_f_user_role_field_text');
						} else {

							$role_field_label = 'Select User Role';
						}

						$validation_errors->add('af_c_f_user_roles_error', esc_html__($role_field_label . ' is required!', 'af_custom_fields'));
					}
				}

				foreach ($af_c_f_extra_fields as $field_id ) {

					$af_c_f_field_required  = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
					$af_c_f_field_type      = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
					$af_c_f_field_file_type = get_post_meta(intval($field_id), 'af_c_f_field_file_type', true);
					$af_c_f_field_file_size = get_post_meta(intval($field_id), 'af_c_f_field_file_size', true);

					if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required )) {

						$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is required!', 'af_custom_fields'));
					}

					if ('email' == $af_c_f_field_type) {

						if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && !empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_EMAIL)) {

							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is not a valid email address!', 'af_custom_fields'));
						}
					}

					if ('multiselect' == $af_c_f_field_type) {

						if (empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && 'on' == $af_c_f_field_required) {

							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is required!', 'af_custom_fields'));
						}
					}

					if ('number' == $af_c_f_field_type) {

						if (isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && !empty($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required ) && !filter_var($_POST[ 'af_c_f_additional_' . intval($field_id) ], FILTER_VALIDATE_INT)) {

							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is not a valid number!', 'af_custom_fields'));
						}
					}

					if ('checkbox' == $af_c_f_field_type || 'radio' == $af_c_f_field_type) {

						if (!isset($_POST[ 'af_c_f_additional_' . intval($field_id) ]) && ( 'on' == $af_c_f_field_required )) {

							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is required!', 'af_custom_fields'));
						}
					}

					if ('googlecaptcha' == $af_c_f_field_type) {

						if (isset($_POST['g-recaptcha-response']) && '' != $_POST['g-recaptcha-response']) {
							$ccheck = $this->captcha_check(sanitize_text_field($_POST['g-recaptcha-response']));
							if ('error' == $ccheck) {
								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__('Invalid reCaptcha!', 'af_custom_fields'));
							}
						} else {
							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is required!', 'af_custom_fields'));
						}
					}

					if ('fileupload' == $af_c_f_field_type) {

						if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on' == $af_c_f_field_required) {

							$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ' is required!', 'af_custom_fields'));
						}

						if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && !empty($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']) && 'on ' == $af_c_f_field_required) {

							$af_c_f_allowed_types =  explode(',', $af_c_f_field_file_type);
							$af_c_f_filename      = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['name']);
							$af_c_f_ext           = pathinfo($af_c_f_filename, PATHINFO_EXTENSION);

							if (!in_array($af_c_f_ext, $af_c_f_allowed_types)) {

								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ': File type is not allowed!', 'af_custom_fields'));
							}

							if (isset($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size'])) {
								$af_c_f_filesize = sanitize_text_field($_FILES[ 'af_c_f_additional_' . intval($field_id) ]['size']);
							} else {
								$af_c_f_filesize = '';
							}

							$af_c_f_allowed_size = $af_c_f_field_file_size * 1000000; // convert from MB to Bytes

							if ($af_c_f_filesize > $af_c_f_allowed_size) {

								$validation_errors->add('af_c_f_additional_' . intval($field_id) . '_error', esc_html__(get_the_title($field_id) . ': File size is too big!', 'af_custom_fields'));
							}
						}
					}
				}
			}

			return $validation_errors;
		}//end aferg_wordpress_registration_errors()



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


		// Manual Approve Users
		public function af_c_f_user_autologout() {

			if (is_user_logged_in()) {

				if (!empty(get_option('af_c_f_enable_approve_user')) && 'yes' == get_option('af_c_f_enable_approve_user')) {

					$current_user = wp_get_current_user();
					$user_id      = $current_user->ID;

					$roles = (array) $current_user->roles;

					$default_role = $roles[0];

					if (!empty(get_option('af_c_f_exclude_user_roles_approve_new_user'))) {
						$manual_user_roles = get_option('af_c_f_exclude_user_roles_approve_new_user');
					} else {
						$manual_user_roles = array();
					}


					if (!in_array($default_role, $manual_user_roles)) {
						$approved_status = get_user_meta($user_id, 'af_c_f_new_user_status', true);
						// if the user hasn't been approved yet by WP Approve User plugin, destroy the cookie to kill the session and log them out
						if ('approved' == $approved_status) {

							return get_permalink(wc_get_page_id('myaccount'));
						} elseif ('pending' == $approved_status) {

							wp_logout();

							WC()->session->set('af_c_f_user_id', $user_id);

							return get_permalink(wc_get_page_id('myaccount')) . '?approved=pending&customerid=' . $user_id;
						} elseif ('disapproved' == $approved_status) {

							wp_logout();

							WC()->session->set('af_c_f_user_id', $user_id);

							return get_permalink(wc_get_page_id('myaccount')) . '?approved=disapproved&customerid=' . $user_id;
						} else {

							return get_permalink(wc_get_page_id('myaccount'));
						}
					} else {
						return get_permalink(wc_get_page_id('myaccount'));
					}
				} else {

					return get_permalink(wc_get_page_id('myaccount'));
				}
			}
		}//end af_c_f_user_autologout()


		public function af_c_f_user_checkout_autologout() {

			if (is_user_logged_in()) {

				if (!empty(get_option('af_c_f_enable_approve_user')) && 'yes' == get_option('af_c_f_enable_approve_user')) {

					$current_user = wp_get_current_user();
					$user_id      = $current_user->ID;

					$roles = (array) $current_user->roles;

					$default_role = $roles[0];

					if (!empty(get_option('af_c_f_exclude_user_roles_approve_new_user'))) {
						$manual_user_roles = get_option('af_c_f_exclude_user_roles_approve_new_user');
					} else {
						$manual_user_roles = array();
					}


					if (!in_array($default_role, $manual_user_roles)) {

						$approved_status = get_user_meta($user_id, 'af_c_f_new_user_status', true);
						// if the user hasn't been approved yet by WP Approve User plugin, destroy the cookie to kill the session and log them out
						if ('approved' == $approved_status) {
							return;
						} elseif ('pending' == $approved_status) {
							wp_logout();

							WC()->session->set('refresh_totals', true);

							$message = get_option('af_c_f_user_pending_approval_message');
							$message = $this->replace_place_holders($message, $user_id);

							wc_add_notice($message, 'notice');
						} elseif ('disapproved' == $approved_status) {

							wp_logout();
							WC()->session->set('refresh_totals', true);
							$message = get_option('af_c_f_user_disapproved_message');
							$message = $this->replace_place_holders($message, $user_id);

							wc_add_notice($message, 'error');
						} else {
							return;
						}
					} else {
						return;
					}
				} else {

					return;
				}
			}
		}//end af_c_f_user_checkout_autologout()



		public function af_c_f_registration_message() {

			if (!empty($_POST['af_c_f_nonce_action']) && !wp_verify_nonce('af_c_f_nonce_action', 'af_c_f_nonce_action')) {
				die('Admin Security Failed');
			}

			if (isset($_REQUEST['approved']) && isset($_GET['customerid'])) {

				$approved = sanitize_text_field($_REQUEST['approved']);
				$user_id  = sanitize_text_field(wp_unslash($_GET['customerid']));

				if ('pending' == $approved) {

					$message = get_option('af_c_f_user_pending_approval_message');
					$message = $this->replace_place_holders($message, $user_id);

					wc_add_notice($message, 'notice');
				} elseif ('disapproved' == $approved) {

					$message = get_option('af_c_f_user_disapproved_message');
					$message = $this->replace_place_holders($message, $user_id);

					wc_add_notice($message, 'error');
				}
			}
		}//end af_c_f_registration_message()


		public function af_c_f_auth_login( $user ) {

			$status = get_user_meta($user->ID, 'af_c_f_new_user_status', true);


			if (empty($status) || is_wp_error($user)) {
				// the user does not have a status so let's assume the user is good to go
				return $user;
			}

			$message = false;
			switch ($status) {
				case 'pending':
					$pending_message = get_option('af_c_f_user_approval_message');
					$pending_message = $this->replace_place_holders($pending_message, $user->ID);
					$message         = new WP_Error('pending_approval', $pending_message);
					break;
				case 'disapproved':
					$disapproved_message = get_option('af_c_f_user_disapproved_message');
					$disapproved_message = $this->replace_place_holders($disapproved_message, $user->ID);
					$message             = new WP_Error('disapproved_access', $disapproved_message);
					break;
				case 'approved':
					$message = $user;
					break;
			}

			return $message;
		}//end af_c_f_auth_login()



		public function af_c_f_checkout_account_extra_fields( $fields ) {

			if (!is_user_logged_in()) {

				$af_c_f_args = array(
					'posts_per_page'   => -1,
					'post_type'        => 'af_c_fields',
					'post_status'      => 'publish',
					'orderby'          => 'menu_order',
					'suppress_filters' => false,
					'order'            => 'ASC',
					'fields'           => 'ids',
				);

				$af_c_f_extra_fields = get_posts($af_c_f_args);

				if (!empty($af_c_f_extra_fields)) {

					foreach ($af_c_f_extra_fields as $field_id ) {

						$af_c_f_field_type        = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
						$af_c_f_field_options     = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
						$af_c_f_field_required    = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
						$af_c_f_field_width       = get_post_meta(intval($field_id), 'af_c_f_field_width', true);
						$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
						$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);
						$af_c_f_field_css         = get_post_meta(intval($field_id), 'af_c_f_field_css', true);
						$af_c_f_field_read_only   = get_post_meta($field_id, 'af_c_f_field_read_only', true);

						if (!empty($af_c_f_field_width) && 'full' == $af_c_f_field_width) {

							$af_c_f_main_class = 'form-row-wide';
						} elseif (!empty($af_c_f_field_width) && 'half' == $af_c_f_field_width) {

							$af_c_f_main_class = 'half_width';
						}

						if ('select' == $af_c_f_field_type) {

							$select_options = array();

							foreach ($af_c_f_field_options as $opt) {

								$select_options[ $opt['field_value'] ] = $opt['field_text'];
							}
						}

						if ('multiselect' == $af_c_f_field_type) {
							$multiselect_options = array();
							foreach ($af_c_f_field_options as $opt) {

								$multiselect_options[ $opt['field_value'] ] = $opt['field_text'];
							}
						}

						if ('radio' == $af_c_f_field_type) {
							$radio_options = array();
							foreach ($af_c_f_field_options as $opt) {

								$radio_options[ $opt['field_value'] ] = $opt['field_text'];
							}
						}

						if (!empty(get_post_meta(intval($field_id), 'af_c_f_is_dependable', true))) {

							$af_c_f_is_dependable = get_post_meta(intval($field_id), 'af_c_f_is_dependable', true);
						} else {
							$af_c_f_is_dependable = 'off';
						}



						if ('text' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'text',
								'description' => $af_c_f_field_description,
							);
						} elseif ('textarea' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'textarea',
								'description' => $af_c_f_field_description,
							);
						} elseif ('select' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'select',
								'description' => $af_c_f_field_description,
								'options'     => $select_options,
							);
						} elseif ('multiselect' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) . '[]' ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => '',
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'multiselect',
								'description' => $af_c_f_field_description,
								'options'     => $multiselect_options,
							);
						} elseif ('radio' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css, 'af_c_f_radio' ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'radio',
								'description' => $af_c_f_field_description,
								'options'     => $radio_options,
							);
						} elseif ('checkbox' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {



							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css, 'af_c_f_radio' ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'checkbox',
								'description' => $af_c_f_field_description,

							);
						} elseif ('email' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'email',
								'description' => $af_c_f_field_description,
							);
						} elseif ('number' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'number',
								'description' => $af_c_f_field_description,
							);
						} elseif ('password' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'password',
								'description' => $af_c_f_field_description,
							);
						} elseif ('datepicker' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'date',
								'description' => $af_c_f_field_description,
							);
						} elseif ('timepicker' == $af_c_f_field_type && 'off' == $af_c_f_is_dependable) {

							$fields['account'][ 'af_c_f_additional_' . intval($field_id) ] = array(
								'label'       => esc_html__(get_the_title($field_id), 'af_custom_fields'),
								'placeholder' => esc_html__($af_c_f_field_placeholder, 'af_custom_fields'),
								'required'    => ( 'on' == $af_c_f_field_required ? true : false ),
								'class'       => array( $af_c_f_main_class, $af_c_f_field_css ),
								'clear'       => false,
								'id'          => 'af_c_f_additional_' . intval($field_id),
								'type'        => 'time',
								'description' => $af_c_f_field_description,
							);
						}
					}
				}
			}

			return $fields;
		}//end af_c_f_checkout_account_extra_fields()



		public function af_c_f_custom_multiselect_handler( $field, $key, $args, $value ) {

			$options     = '';
			$ekey        = explode('[', $key);
			$field_id    = explode('af_c_f_additional_', $ekey[0]);
			$is_required = get_post_meta(intval($field_id[1]), 'af_c_f_field_required', true);

			if ('' != $is_required) {
				if ('on' == $is_required) {
					$required = '<abbr class="required" title="required">*</abbr>';
				} else {
					$required = '';
				}
			}
			if (!empty($args['options'])) {
				foreach ($args['options'] as $option_key => $option_text) {
					$options .= '<option value="' . esc_attr($option_key) . '" ' . selected($value, $option_key, false) . '>' . esc_attr($option_text) . '</option>';
				}

				$field = '<p class="form-row ' . implode(' ', $args['class']) . '" id="' . $key . '_field">
				<label for="' . $key . '" class="' . implode(' ', $args['label_class']) . '">' . $args['label'] . $required . '</label>
				<select name="' . $key . '" id="' . $key . '" class="select" multiple="multiple">
				' . $options . '
				</select>
				</p>';
			}

			return $field_id;
		}//end af_c_f_custom_multiselect_handler()


		public function af_c_f_get_allowed_countries( $countries ) {

			// Only on frontend
			if (is_admin()) {
				return $countries;
			}

			if (class_exists('WC_Geolocation')) {
				$location = WC_Geolocation::geolocate_ip();

				if (isset($location['country'])) {
					$countryCode = $location['country'];
				} else {
					// If there is no country, then return allowed countries
					return $countries;
				}
			} else {
				// If you can't geolocate user country by IP, then return allowed countries
				return $countries;
			}

			// If everything went ok then I filter user country in the allowed countries array
			$user_country_code_array = array( $countryCode );

			$intersect_countries = array_intersect_key($countries, array_flip($user_country_code_array));

			return $intersect_countries;
		}//end af_c_f_get_allowed_countries()



		public function af_c_f_default_fields() {
			$posts = get_posts(
				array(
					'post_type'        => 'def_reg_fields',
					'numberposts'      => -1,
					'order'            => 'ASC',
					'post_status'      => 'publish',
					'suppress_filters' => true,
					'orderby'          => 'menu_order',
				)
			);
			wp_nonce_field('af_c_f_nonce_action', 'af_c_f_nonce_field');
			if (0 < count($posts)) {
				?>
				<div class="af_c_f_extra_fields">
					<?php
			} else {
				return;
			}

				global $woocommerce;

				$location = WC_Geolocation::geolocate_ip();

				$countries_obj = new WC_Countries();

				$countries = $countries_obj->get_allowed_countries();

			foreach ($posts as $post) :
				$required    = get_post_meta($post->ID, 'is_required', true);
				$width       = get_post_meta($post->ID, 'width', true);
				$message     = get_post_meta($post->ID, 'message', true);
				$placeholder = get_post_meta($post->ID, 'placeholder', true);
				$type        = get_post_meta($post->ID, 'type', true);
				if (!empty($_POST[ $post->post_name ])) {
					if (!empty($_POST['af_c_f_nonce_field'])) {
						$retrieved_nonce = sanitize_text_field($_POST['af_c_f_nonce_field']);
					} else {
						$retrieved_nonce = 0;
					}
					if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {
						wp_die(esc_html__('Security Violated', 'af_custom_fields'));
					}
					$def_value = sanitize_text_field($_POST[ $post->post_name ]);
				} else {
					$def_value = '';
				}
				// Text Field
				if ('text' == $type || 'tel' == $type) {
					$name = __($post->post_title, 'woocommerce');

					?>
						<p id="<?php echo esc_attr($post->post_name); ?>" class="form-row <?php echo esc_attr($width); ?>_field">
							<label
							for="<?php echo esc_attr__($post->post_name, 'af_custom_fields'); ?>"><?php echo esc_html__($name, 'af_custom_fields'); ?>
							<?php
							if (1 == $required) {
								?>
								<span class="required">*</span>
							<?php } ?>
						</label>
						<input type="<?php echo esc_attr($type); ?>" class="af-front-fields input-text" name="<?php echo esc_attr($post->post_name); ?>"
						id="<?php echo esc_attr($post->post_name); ?>" value="<?php echo esc_attr($def_value); ?>"
						placeholder="<?php echo esc_html__($placeholder, 'af_custom_fields'); ?>" />
						<?php if (isset($message) && '' != $message) { ?>
							<span class="fmessage"><?php echo esc_html__($message, 'af_custom_fields'); ?></span>
						<?php } ?>
					</p>
					<?php
				} elseif ('select' == $type) {
					if ('billing_country' == $post->post_name) {



						if (!empty($_POST[ $post->post_name ])) {
							$billing_country = sanitize_text_field($_POST[ $post->post_name ]);
						} elseif (!empty($location['country'])) {
							$billing_country = $location['country'];
						} else {
							$billing_country = '';
						}
						$billing_country_title = __($post->post_title, 'woocommerce');



						?>
						<p id="<?php echo esc_attr($post->post_name); ?>" class="form-row <?php echo esc_attr($width); ?>_field">
							<label
							for="<?php echo esc_attr__($post->post_name, 'af_custom_fields'); ?>"><?php echo esc_html__($billing_country_title, 'af_custom_fields'); ?>
								<?php
								if (1 == $required) {
									?>
								<span class="required">*</span> <?php } ?>
							</label>

							<select class="js-example-basic-single input-select af-front-fields" name="<?php echo esc_attr($post->post_name); ?>"
								onchange="selectState(this.value);">
								<option value=""><?php echo esc_html__('Select a country...', 'af_custom_fields'); ?></option>
								<?php foreach ($countries as $key => $value) { ?>
									<option value="<?php echo esc_attr($key); ?>" <?php echo selected($billing_country, $key); ?>>
										<?php echo esc_attr($value); ?></option>
									<?php } ?>
								</select>
								<?php if (isset($message) && '' != $message) { ?>
									<span class="fmessage"><?php echo esc_html__($message, 'af_custom_fields'); ?></span>
								<?php } ?>
							</p>
						<?php } elseif ('billing_state' == $post->post_name) { ?>
							<p id="dropdown_state" class="form-row <?php echo esc_attr($width); ?>_field">
								<label
								for="<?php echo esc_attr__($post->post_name, 'af_custom_fields'); ?>"><?php echo esc_html__($post->post_title, 'af_custom_fields'); ?>
									<?php
									if (1 == $required) {
										?>
									<span class="required">*</span> <?php } ?>
								</label>
								<input type="text" class="af-front-fields input-text" name="<?php echo esc_attr($post->post_name); ?>" id="drop_down_state"
								value="" placeholder="<?php echo esc_html__($placeholder, 'af_custom_fields'); ?>" />

								<?php if (isset($message) && '' != $message) { ?>
									<span class="fmessage"><?php echo esc_html__($message, 'af_custom_fields'); ?></span>
								<?php } ?>
							</p>
						<?php } ?>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery('.js-example-basic-single').select2();

								<?php if ('billing_country' == $post->post_name) { ?>
									<?php if (isset($_POST['billing_country']) && '' != $_POST['billing_country']) { ?>
										var country = "<?php echo esc_attr(sanitize_text_field($_POST['billing_country'])); ?>";
									<?php } elseif (!empty($location['country'])) { ?>
										var country = "<?php echo esc_attr($location['country']); ?>";
									<?php } else { ?>
										var country = '';
									<?php } ?>
									<?php if (isset($_POST['billing_state']) && '' != $_POST['billing_state']) { ?>
										var af_state = "<?php echo esc_attr(sanitize_text_field($_POST['billing_state'])); ?>";
									<?php } else { ?>
										var af_state = "";
									<?php } ?>
									var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
									var name = "<?php echo esc_attr($post->post_name); ?>";
									var label = "<?php echo esc_attr($post->post_title); ?>";
									var message = "<?php echo esc_attr($message); ?>";
									var required = "<?php echo esc_attr($required); ?>";
									var width = "<?php echo esc_attr($width); ?>";
									var nonce = "<?php echo esc_attr(wp_create_nonce('afreg-ajax-nonce')); ?>";

									jQuery.ajax({
			type: 'POST', // Adding Post method
			url: ajaxurl, // Including ajax file
			data: {
				"action": "get_states",
				"country": country,
				"name": name,
				"label": label,
				"message": message,
				"required": required,
				"width": width,
				"af_state": af_state,
				"nonce": nonce
			},
			success: function(data) {

				jQuery('#dropdown_state').html(data);
			}
		});
								<?php } ?>
							});

							function selectState(country) {
								var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
								var name = "<?php echo esc_attr($post->post_name); ?>";
								var label = "<?php echo esc_attr($post->post_title); ?>";
								var message = "<?php echo esc_attr($message); ?>";
								var required = "<?php echo esc_attr($required); ?>";
								var width = "<?php echo esc_attr($width); ?>";
								var nonce = "<?php echo esc_attr(wp_create_nonce('afreg-ajax-nonce')); ?>";
								jQuery.ajax({
			type: 'POST', // Adding Post method
			url: ajaxurl, // Including ajax file
			data: {
				"action": "get_states",
				"country": country,
				"name": name,
				"label": label,
				"message": message,
				"required": required,
				"width": width,
				"nonce": nonce
			},
			success: function(data) {
				jQuery('#dropdown_state').html(data);
			}
		});
							}
						</script>
					<?php } ?>

					<?php
				endforeach;
			?>
			</div>
			<?php
		}//end af_c_f_default_fields()


		public function af_c_f_default_fields_validate( $username, $email, $validation_errors ) {

			if (is_checkout()) {
				return $validation_errors;
			}
			if (isset($_POST['first_name'])) {

				if (!empty($_POST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_POST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated', 'af_custom_fields'));
				}
			}

			// First Name
			$checkfield = $this->getFieldBySlug('first_name');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['first_name']) && empty($_POST['first_name']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}


			// Last Name
			$checkfield = $this->getFieldBySlug('last_name');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['last_name']) && empty($_POST['last_name']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Company
			$checkfield = $this->getFieldBySlug('billing_company');

			if (!empty($checkfield)) {
				$required = get_post_meta( current($checkfield) , 'is_required', true);

				if (isset($_POST['billing_company']) && empty($_POST['billing_company']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Country
			$checkfield = $this->getFieldBySlug('billing_country');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_country']) && empty($_POST['billing_country']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Address Line 1
			$checkfield = $this->getFieldBySlug('billing_address_1');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_address_1']) && empty($_POST['billing_address_1']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Address Line 2
			$checkfield = $this->getFieldBySlug('billing_address_2');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_address_2']) && empty($_POST['billing_address_2']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// State
			$checkfield = $this->getFieldBySlug('billing_state');

			if (!empty($checkfield) && !is_checkout()) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_state']) && empty($_POST['billing_state']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// City
			$checkfield = $this->getFieldBySlug('billing_city');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_city']) && empty($_POST['billing_city']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Post Code
			$checkfield = $this->getFieldBySlug('billing_postcode');

			if (!empty($checkfield) && !is_checkout()) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_postcode']) && empty($_POST['billing_postcode']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Phone
			$checkfield = $this->getFieldBySlug('billing_phone');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_phone']) && empty($_POST['billing_phone']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}

				if (isset($_POST['billing_phone']) && !empty($_POST['billing_phone']) && 1 == $required && !preg_match('/^[0-9-+\s()]*$/', sanitize_text_field($_POST['billing_phone']))) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', esc_html__(get_post(current($checkfield))->post_title . ' is not valid!', 'af_custom_fields'));
				}
			}


			return $validation_errors;
		}//end af_c_f_default_fields_validate()


		public function af_c_f_default_fields_validate_wordpress( $validation_errors, $username, $email ) {
			if (is_checkout()) {
				return $validation_errors;
			}
			if (isset($_POST['first_name'])) {

				if (!empty($_POST['af_c_f_nonce_field'])) {

					$retrieved_nonce = sanitize_text_field($_POST['af_c_f_nonce_field']);
				} else {
					$retrieved_nonce = 0;
				}

				if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

					wp_die(esc_html__('Security Violated', 'af_custom_fields'));
				}
			}

			// First Name
			$checkfield = $this->getFieldBySlug('first_name');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['first_name']) && empty($_POST['first_name']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}


			// Last Name
			$checkfield = $this->getFieldBySlug('last_name');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['last_name']) && empty($_POST['last_name']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Company
			$checkfield = $this->getFieldBySlug('billing_company');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_company']) && empty($_POST['billing_company']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Country
			$checkfield = $this->getFieldBySlug('billing_country');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_country']) && empty($_POST['billing_country']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Address Line 1
			$checkfield = $this->getFieldBySlug('billing_address_1');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_address_1']) && empty($_POST['billing_address_1']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}


			// Address Line 2
			$checkfield = $this->getFieldBySlug('billing_address_2');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_address_2']) && empty($_POST['billing_address_2']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// State
			$checkfield = $this->getFieldBySlug('billing_state');

			if (!empty($checkfield) && !is_checkout()) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_state']) && empty($_POST['billing_state']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// City
			$checkfield = $this->getFieldBySlug('billing_city');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_city']) && empty($_POST['billing_city']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Post Code
			$checkfield = $this->getFieldBySlug('billing_postcode');

			if (!empty($checkfield) && !is_checkout()) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_postcode']) && empty($_POST['billing_postcode']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}
			}

			// Phone
			$checkfield = $this->getFieldBySlug('billing_phone');

			if (!empty($checkfield)) {
				$required = get_post_meta(get_post(current($checkfield))->ID, 'is_required', true);

				if (isset($_POST['billing_phone']) && empty($_POST['billing_phone']) && 1 == $required) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html(__(get_post(current($checkfield))->post_title, 'af_custom_fields')) . esc_html__(' is required!', 'af_custom_fields'));
				}

				if (isset($_POST['billing_phone']) && !empty($_POST['billing_phone']) && 1 == $required && !preg_match('/^[0-9-+\s()]*$/', sanitize_text_field($_POST['billing_phone']))) {
					$validation_errors->add(get_post(current($checkfield))->post_name . '_error', '<strong>' . __('Error', 'af_custom_fields') . '</strong>: ' . esc_html__(get_post(current($checkfield))->post_title . ' is not valid!', 'af_custom_fields'));
				}
			}


			return $validation_errors;
		}//end af_c_f_default_fields_validate_wordpress()


		public function getFieldBySlug( $slug ) {

			$args     = array(
				'name'             => $slug,
				'post_type'        => 'def_reg_fields',
				'post_status'      => 'publish',
				'suppress_filters' => false,
				'numberposts'      => 1,
				'fields'           => 'ids',
			);
			$my_posts = get_posts($args);
			if ($my_posts) :
				return $my_posts;
			endif;
		}//end getFieldBySlug()


		public function af_c_f_validate_fields_checkout() {


			global $woocommerce;

			$af_c_f_args = array(
				'posts_per_page' => -1,
				'post_type'      => 'af_c_fields',
				'post_status'    => 'publish',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'fields'         => 'ids',
			);

			$af_c_f_extra_fields = get_posts($af_c_f_args);

			if (!empty($af_c_f_extra_fields)) {

				if (isset($_POST['createaccount']) && 1 == $_POST['createaccount']) {


					if (!empty($_POST['af_c_f_nonce_field'])) {

						$retrieved_nonce = sanitize_text_field($_POST['af_c_f_nonce_field']);
					} else {
						$retrieved_nonce = 0;
					}

					if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

						wp_die(esc_html__('Security Violated', 'af_custom_fields'));
					}


					foreach ($af_c_f_extra_fields as $field_id ) {

						$af_c_f_field_type        = get_post_meta(intval($field_id), 'af_c_f_field_type', true);
						$af_c_f_field_options     = ( get_post_meta(intval($field_id), 'af_c_f_field_option', true) );
						$af_c_f_field_required    = get_post_meta(intval($field_id), 'af_c_f_field_required', true);
						$af_c_f_field_width       = get_post_meta(intval($field_id), 'af_c_f_field_width', true);
						$af_c_f_field_placeholder = get_post_meta(intval($field_id), 'af_c_f_field_placeholder', true);
						$af_c_f_field_description = get_post_meta(intval($field_id), 'af_c_f_field_description', true);
						$af_c_f_field_css         = get_post_meta(intval($field_id), 'af_c_f_field_css', true);
						$af_c_f_field_read_only   = get_post_meta($field_id, 'af_c_f_field_read_only', true);

						if ('on' == $af_c_f_field_required && 'multiselect' == $af_c_f_field_type) {

							if (empty($_POST[ 'af_c_f_additional_' . intval($field_id) ])) {

								wc_add_notice(__('<b>' . get_the_title($field_id) . '</b> is required!', 'af_custom_fields'), 'error');
							}
						}
					}
				}
			}
			
			$ids_with_price = array();
		}//end af_c_f_validate_fields_checkout()
	}//end class


	new Af_C_F_Front();
}
