<?php 
/**
 * Plugin Name:       Custom Fields for WooCommerce
 * Plugin URI:        https://addify.store/product/custom-fields-for-woocommerce/
 * Description:       Add extra fields to registration and checkout page. Supports 19 fields types and ability to add fields dependable fields.
 * Version:           1.3.0
 * Author:            Addify
 * Developed By:      Addify
 * Author URI:        https://addify.store/
 * Support:           https://addify.store/
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       af_custom_fields
 * WC requires at least: 3.0.9
 * WC tested up to: 8.*.*
 */

if (! defined('WPINC') ) {
	die;
}




if (!class_exists('AF_Custom_Fields') ) {

	class AF_Custom_Fields {

		public function __construct() {

			$this->afreg_global_constents_vars();

			add_action('after_setup_theme', array( $this, 'afreg_init' ));
			add_action( 'init', array( $this, 'afreg_custom_post_type' ));
			add_action( 'init', array( $this, 'afdef_custom_post_type' ));
			register_activation_hook( __FILE__, array( $this, 'afreg_installation' ) );

			//HOPS compatibility
			add_action('before_woocommerce_init', array( $this, 'afcf__HOPS_Compatibility' ));

			add_action( 'plugins_loaded', array( $this, 'afcf_checks' ) );

			add_action('woocommerce_init', array( $this, 'afcf_session_check' ) );

			if ( extension_loaded('soap') ) {
				require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';
			} else {
				add_action('admin_notices', array( $this, 'add_admin_notice_for_soap' ) );
			}

			include_once AF_CF_PLUGIN_DIR . 'includes/class-af-c-f-general-functions.php';
			include_once AF_CF_PLUGIN_DIR . 'includes/class-af-c-f-ajax.php';
			include_once AF_CF_PLUGIN_DIR . 'includes/class-af-c-f-checkout.php';
			include_once AF_CF_PLUGIN_DIR . 'includes/class-af-c-f-emails.php';

			if (is_admin() ) {
				include_once AF_CF_PLUGIN_DIR . 'admin/class-af-c-f-admin.php';
			} else {
				include_once AF_CF_PLUGIN_DIR . 'front/class-af-c-f-front.php';
			}
		}//end __construct()

			

		public function afcf__HOPS_Compatibility() {

			if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
				\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
			}
		}

		public function afcf_checks() {

			// Check for multisite.
			if ( ! is_multisite() && ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

				add_action( 'admin_notices', array( $this, 'afcf_admin_notice' ));
			} 
		}

		public function afcf_admin_notice() {

			// Deactivate the plugin.
				deactivate_plugins(__FILE__);

				$cstmonum_woo_check = '<div id="message" class="error">
	                <p><strong>' . __( 'Custom Fields for WooCommerce plugin is inactive.', 'af_custom_fields' ) . '</strong> The <a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce plugin</a> ' . __( 'must be active for this plugin to work. Please install &amp; activate WooCommerce.', 'af_custom_fields' ) . ' »</p></div>';
			echo wp_kses_post( $cstmonum_woo_check );
		}

		public function afcf_session_check() {

			if (is_user_logged_in() || is_admin()) {
				return;
			}

			if (isset(WC()->session)) {
				if (!WC()->session->has_session()) {
					WC()->session->set_customer_session_cookie(true);
				}
			}
		}

			
		public function add_admin_notice_for_soap() {
			?>
				<div id="message" class="error">
					<p>
						<a href="https://woocommerce.com/products/custom-fields-for-woocommerce/">
						<?php esc_html_e('Custom Fields for WooCommerce:', 'af_custom_fields'); ?>
						</a>
					<?php esc_html_e(' Kindly activate soap application from your server to validate VIES VAT number validation.', 'af_custom_fields'); ?>
					</p>
				</div>
				<?php
		}//end add_admin_notice_for_soap()

		// end add_admin_notice_for_soap()
		public function afreg_global_constents_vars() {

			if (!defined('AF_CF_URL') ) {
				define('AF_CF_URL', plugin_dir_url(__FILE__) );
			}

			if (!defined('AF_CF_BASENAME') ) {
				define('AF_CF_BASENAME', plugin_basename(__FILE__ ));
			}

			if (! defined('AF_CF_PLUGIN_DIR') ) {
				define('AF_CF_PLUGIN_DIR', plugin_dir_path(__FILE__) );
			}

			if ( !defined( 'AF_CF_UPLOAD_DIR' )) {

				$upload_dir = wp_upload_dir();

				define( 'AF_CF_UPLOAD_DIR', $upload_dir['basedir'] . '/addify-custom-fields/' );

				if ( !is_dir( AF_CF_UPLOAD_DIR ) ) {
					mkdir( AF_CF_UPLOAD_DIR );
				}
			}

			if ( !defined( 'AF_CF_UPLOAD_URL' ) ) {

				$upload_dir = wp_upload_dir();

				define( 'AF_CF_UPLOAD_URL', $upload_dir['baseurl'] . '/addify-custom-fields/' );
			}
		}//end afreg_global_constents_vars()

		// end afreg_global_constents_vars()
		public function afreg_init() {

			if (function_exists('load_plugin_textdomain') ) {

				load_plugin_textdomain('af_custom_fields', false, dirname(plugin_basename(__FILE__)) . '/languages/');
			}
		}//end afreg_init()

		// end afreg_init()
		public function afreg_custom_post_type() {

			$labels = array(
				'name'                => esc_html__('Custom Fields', 'af_custom_fields'),
				'singular_name'       => esc_html__('Custom Field', 'af_custom_fields'),
				'add_new'             => esc_html__('Add New Field', 'af_custom_fields'),
				'add_new_item'        => esc_html__('Add New Field', 'af_custom_fields'),
				'edit_item'           => esc_html__('Edit Custom Field', 'af_custom_fields'),
				'new_item'            => esc_html__('New Custom Field', 'af_custom_fields'),
				'view_item'           => esc_html__('View Custom Field', 'af_custom_fields'),
				'search_items'        => esc_html__('Search Custom Field', 'af_custom_fields'),
				'exclude_from_search' => true,
				'not_found'           => esc_html__('No Custom field found', 'af_custom_fields'),
				'not_found_in_trash'  => esc_html__('No Custom field found in trash', 'af_custom_fields'),
				'parent_item_colon'   => '',
				'all_items'           => esc_html__('Custom Fields', 'af_custom_fields'),
				'menu_name'           => esc_html__('Custom Fields', 'af_custom_fields'),
			);

			$args = array(
				'labels'             => $labels,
				'menu_icon'          => plugin_dir_url( __FILE__ ) . 'images/small_logo_grey.png',
				'public'             => false,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => 'woocommerce',
				'query_var'          => true,
				
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 30,
				'rewrite'            => array(
					'slug'       => 'af_c_fields',
					'with_front' =>false,
				),
				'supports'           => array( 'title' ),
			);

			register_post_type( 'af_c_fields', $args );
		}//end afreg_custom_post_type()

		// end afreg_custom_post_type()
		public function afdef_custom_post_type() {

			$def_labels = array(
				'name'                => esc_html__('Default Registration Fields', 'af_custom_fields'),
				'singular_name'       => esc_html__('Default Registration Fields', 'af_custom_fields'),
				'edit_item'           => esc_html__('Edit Registration Field', 'af_custom_fields'),
				'new_item'            => esc_html__('New Registration Field', 'af_custom_fields'),
				'view_item'           => esc_html__('View Registration Field', 'af_custom_fields'),
				'search_items'        => esc_html__('Search Registration Field', 'af_custom_fields'),
				'exclude_from_search' => true,
				'not_found'           => esc_html__('No Custom field found', 'af_custom_fields'),
				'not_found_in_trash'  => esc_html__('No Custom field found in trash', 'af_custom_fields'),
				'parent_item_colon'   => '',
				'all_items'           => esc_html__('All Default Fields', 'af_custom_fields'),
				'menu_name'           => esc_html__('Default Registration Fields', 'af_custom_fields'),
			);

			$args = array(
				'labels'             => $def_labels,
				'public'             => false,
				'publicly_queryable' => true,
				'show_ui'            => false,
				'show_in_menu'       => false,
				'query_var'          => true,
				
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'rewrite'            => array(
					'slug'       => 'def_reg_fields',
					'with_front' =>false,
				),
				'supports'           => array( 'title' ),
			);

			register_post_type( 'def_reg_fields', $args );
		}//end afdef_custom_post_type()

		// end afdef_custom_post_type()
		public function afreg_installation() {

			$this->afreg_insert_default_fields();
		}//end afreg_installation()

		// end afreg_installation()
		public function afreg_insert_default_fields() {

			// New code
			$first_name_posts = get_page_by_path( 'first_name', OBJECT, 'def_reg_fields' );
			if ('' == $first_name_posts) {
				$first_name_post = array(
					'post_title'  => __('First Name', 'af_custom_fields'),
					'post_name'   => 'first_name',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 1,        
				);
				$first_name_id   = wp_insert_post($first_name_post);
				update_post_meta($first_name_id, 'placeholder', 'Enter your first name');
				update_post_meta($first_name_id, 'is_required', 1);
				update_post_meta($first_name_id, 'width', 'half');
				update_post_meta($first_name_id, 'type', 'text');
				update_post_meta($first_name_id, 'message', '');
			}
			// Last Name
			$last_name_posts = get_page_by_path( 'last_name', OBJECT, 'def_reg_fields' );
			if ('' == $last_name_posts) {
				$last_name_post = array(
					'post_title'  => __('Last Name', 'af_custom_fields'),
					'post_name'   => 'last_name',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 2,        
				);
				$last_name_id   = wp_insert_post($last_name_post);
				update_post_meta($last_name_id, 'placeholder', 'Enter your last name');
				update_post_meta($last_name_id, 'is_required', 1);
				update_post_meta($last_name_id, 'width', 'half');
				update_post_meta($last_name_id, 'type', 'text');
				update_post_meta($last_name_id, 'message', '');
			}
			// Company
			$company_posts = get_page_by_path( 'billing_company', OBJECT, 'def_reg_fields' );
			if ('' == $company_posts) {
				$company_post = array(
					'post_title'  => __('Company', 'af_custom_fields'),
					'post_name'   => 'billing_company',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 3,       
				);
				$company_id   = wp_insert_post($company_post);
				update_post_meta($company_id, 'placeholder', 'Enter your company');
				update_post_meta($company_id, 'is_required', 0);
				update_post_meta($company_id, 'width', 'full');
				update_post_meta($company_id, 'type', 'text');
				update_post_meta($company_id, 'message', '');
			}
			// Country
			$country_posts = get_page_by_path( 'billing_country', OBJECT, 'def_reg_fields' );
			if ('' == $country_posts) {
				$country_post = array(
					'post_title'  => __('Country', 'af_custom_fields'),
					'post_name'   => 'billing_country',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 4,       
				);
				$country_id   = wp_insert_post($country_post);
				update_post_meta($country_id, 'placeholder', 'Select your country');
				update_post_meta($country_id, 'is_required', 1);
				update_post_meta($country_id, 'width', 'full');
				update_post_meta($country_id, 'type', 'select');
				update_post_meta($country_id, 'message', '');
			}
			// Address Line 1
			$address_1_posts = get_page_by_path( 'billing_address_1', OBJECT, 'def_reg_fields' );
			if ('' == $address_1_posts) {
				$address_1_post = array(
					'post_title'  => __('Street Address', 'af_custom_fields'),
					'post_name'   => 'billing_address_1',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 5,       
				);
				$address_1_id   = wp_insert_post($address_1_post);
				update_post_meta($address_1_id, 'placeholder', 'House number and street name');
				update_post_meta($address_1_id, 'is_required', 1);
				update_post_meta($address_1_id, 'width', 'full');
				update_post_meta($address_1_id, 'type', 'text');
				update_post_meta($address_1_id, 'message', '');
			}
			// Address Line 2
			$address_2_posts = get_page_by_path( 'billing_address_2', OBJECT, 'def_reg_fields' );
			if ('' == $address_2_posts) {
				$address_2_post = array(
					'post_title'  => __('Address 2', 'af_custom_fields'),
					'post_name'   => 'billing_address_2',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 6,       
				);
				$address_2_id   = wp_insert_post($address_2_post);
				update_post_meta($address_2_id, 'placeholder', 'Apartment, suite, unit etc. (optional)');
				update_post_meta($address_2_id, 'is_required', 0);
				update_post_meta($address_2_id, 'width', 'full');
				update_post_meta($address_2_id, 'type', 'text');
				update_post_meta($address_2_id, 'message', '');
			}
			// State
			$state_posts = get_page_by_path( 'billing_state', OBJECT, 'def_reg_fields' );
			if ('' == $state_posts) {
				$state_post = array(
					'post_title'  => __('State / County', 'af_custom_fields'),
					'post_name'   => 'billing_state',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 7,       
				);
				$state_id   = wp_insert_post($state_post);
				update_post_meta($state_id, 'placeholder', 'Select your state / county');
				update_post_meta($state_id, 'is_required', 1);
				update_post_meta($state_id, 'width', 'full');
				update_post_meta($state_id, 'type', 'select');
				update_post_meta($state_id, 'message', '');
			}
			// City
			$city_posts = get_page_by_path( 'billing_city', OBJECT, 'def_reg_fields' );
			if ('' == $city_posts) {
				$city_post = array(
					'post_title'  => __('Town / City', 'af_custom_fields'),
					'post_name'   => 'billing_city',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 8,       
				);
				$city_id   = wp_insert_post($city_post);
				update_post_meta($city_id, 'placeholder', 'Enter your city');
				update_post_meta($city_id, 'is_required', 1);
				update_post_meta($city_id, 'width', 'half');
				update_post_meta($city_id, 'type', 'text');
				update_post_meta($city_id, 'message', '');
			}
			// Post Code
			$postcode_posts = get_page_by_path( 'billing_postcode', OBJECT, 'def_reg_fields' );
			if ('' == $postcode_posts) {
				$postcode_post = array(
					'post_title'  => __('Postcode / Zip', 'af_custom_fields'),
					'post_name'   => 'billing_postcode',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 9,      
				);
				$postcode_id   = wp_insert_post($postcode_post);
				update_post_meta($postcode_id, 'placeholder', 'Enter your postcode / zip');
				update_post_meta($postcode_id, 'is_required', 1);
				update_post_meta($postcode_id, 'width', 'half');
				update_post_meta($postcode_id, 'type', 'text');
				update_post_meta($postcode_id, 'message', '');
			}
			// Phone
			$phone_posts = get_page_by_path( 'billing_phone', OBJECT, 'def_reg_fields' );
			if ('' == $phone_posts) {
				$phone_post = array(
					'post_title'  => __('Phone', 'af_custom_fields'),
					'post_name'   => 'billing_phone',
					'post_type'   => 'def_reg_fields',
					'post_status' => 'unpublish',
					'menu_order'  => 10,      
				);
				$phone_id   = wp_insert_post($phone_post);
				update_post_meta($phone_id, 'placeholder', 'Enter your phone');
				update_post_meta($phone_id, 'is_required', 1);
				update_post_meta($phone_id, 'width', 'full');
				update_post_meta($phone_id, 'type', 'tel');
				update_post_meta($phone_id, 'message', '');
			}
		}//end afreg_insert_default_fields()

		// end afreg_insert_default_fields()


		

		public function add_dot_before_extension( $value ) {

			if ( strpos('.', $value ) ) {
				$value = str_replace( '.', '', $value );
			}

			return '.' . $value;
		}//end add_dot_before_extension()

			// end add_dot_before_extension()
	}//end class

	// end class
	new AF_Custom_Fields();
}


