<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/public
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Shipping_Display_Mode_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-shipping-display-mode-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-shipping-display-mode-public.js', array( 'jquery' ), $this->version, false );
		
		// Localize script for block compatibility
		wp_localize_script( $this->plugin_name, 'wsdm_params', array(
			'shipping_format' => get_option( 'woocommerce_shipping_method_format', 'radio' ),
			'is_blocks_enabled' => $this->wsdm_is_woocommerce_blocks_enabled(),
            'shipping_options_label' => esc_html__( 'Shipping options', 'woo-shipping-display-mode' ),
		) );
	}

	/**
	 * Check if WooCommerce blocks are enabled for cart and checkout.
	 *
	 * @return bool
	 */
	public function wsdm_is_woocommerce_blocks_enabled() {
		if ( ! function_exists( 'wc_get_page_id' ) ) {
			return false;
		}

		$cart_page_id = wc_get_page_id( 'cart' );
		$checkout_page_id = wc_get_page_id( 'checkout' );

		// Check if cart page uses blocks
		$cart_has_blocks = false;
		if ( $cart_page_id && $cart_page_id > 0 ) {
			$cart_content = get_post_field( 'post_content', $cart_page_id );
			$cart_has_blocks = has_block( 'woocommerce/cart', $cart_content );
		}

		// Check if checkout page uses blocks
		$checkout_has_blocks = false;
		if ( $checkout_page_id && $checkout_page_id > 0 ) {
			$checkout_content = get_post_field( 'post_content', $checkout_page_id );
			$checkout_has_blocks = has_block( 'woocommerce/checkout', $checkout_content );
		}

		return $cart_has_blocks || $checkout_has_blocks;
	}

	/**
	 * Modify shipping methods display via hooks for classic cart/checkout.
	 * 
	 * @param array $packages Available packages.
	 * @return void
	 */
	public function wsdm_modify_shipping_methods_display( $packages ) {
		$shipping_format = get_option( 'woocommerce_shipping_method_format', 'radio' );
		
		if ( 'select' !== $shipping_format ) {
			return;
		}

		// Add custom CSS class to body for easier targeting
		add_filter( 'body_class', array( $this, 'wsdm_add_body_class_for_shipping_mode' ) );
	}

	/**
	 * Add body class for shipping display mode.
	 *
	 * @param array $classes Body classes.
	 * @return array Modified body classes.
	 */
	public function wsdm_add_body_class_for_shipping_mode( $classes ) {
		$shipping_format = get_option( 'woocommerce_shipping_method_format', 'radio' );
		
		if ( 'select' === $shipping_format ) {
			$classes[] = 'wsdm-shipping-select-mode';
		}

		if ( $this->wsdm_is_woocommerce_blocks_enabled() ) {
			$classes[] = 'wsdm-blocks-enabled';
		}

		return $classes;
	}

	/**
	 * Filter shipping methods for Store API (Block checkout compatibility).
	 *
	 * @param array $rates Shipping rates.
	 * @param array $package Package data.
	 * @return array Modified rates.
	 */
	public function wsdm_filter_store_api_shipping_rates( $rates, $package ) {
		$shipping_format = get_option( 'woocommerce_shipping_method_format', 'radio' );
		
		if ( 'select' === $shipping_format && count( $rates ) > 1 ) {
			// Add metadata to indicate dropdown format for Store API
			foreach ( $rates as $rate_id => $rate ) {
				$rates[ $rate_id ]->meta_data['wsdm_display_mode'] = 'select';
			}
		}
		
		return $rates;
	}
}