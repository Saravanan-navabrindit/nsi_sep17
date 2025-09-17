<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce Blocks integration for shipping display mode.
 *
 * @link       https://www.thedotstore.com/
 * @since      3.8.1
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/includes
 */

/**
 * The blocks integration class.
 *
 * This class handles integration with WooCommerce blocks, particularly
 * the Cart and Checkout blocks, to support shipping method display mode.
 *
 * @since      3.8.1
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/includes
 * @author     theDotstore <support@thedotstore.com>
 */
class Woo_Shipping_Display_Mode_Blocks {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    3.8.1
	 */
	public function __construct() {
		add_action( 'woocommerce_blocks_loaded', array( $this, 'register_blocks_integration' ) );
	}

	/**
	 * Register blocks integration when WooCommerce Blocks is loaded.
	 *
	 * @since 3.8.1
	 */
	public function register_blocks_integration() {
		
		if ( ! class_exists( 'Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface' ) ) {
			return;
		}

		add_action( 'woocommerce_blocks_cart_block_registration', array( $this, 'register_cart_block_integration' ) );
		add_action( 'woocommerce_blocks_checkout_block_registration', array( $this, 'register_checkout_block_integration' ) );

		// Store API hooks for shipping method data
		add_filter( 'woocommerce_store_api_cart_select_shipping_rate', array( $this, 'handle_store_api_shipping_selection' ), 10, 3 );

		// Add shipping display mode data to Store API
		add_filter( 'woocommerce_store_api_cart_extensions', array( $this, 'extend_cart_store_api_data' ) );
		add_filter( 'woocommerce_store_api_checkout_extensions', array( $this, 'extend_checkout_store_api_data' ) );
	}

	/**
	 * Register cart block integration.
	 *
	 * @since 3.8.1
	 */
	public function register_cart_block_integration() {
		woocommerce_store_api_register_endpoint_data(
			array(
				'endpoint'        => \Automattic\WooCommerce\StoreApi\Schemas\V1\CartSchema::IDENTIFIER,
				'namespace'       => 'woo-shipping-display-mode',
				'data_callback'   => array( $this, 'get_cart_block_data' ),
				'schema_callback' => array( $this, 'get_cart_block_schema' ),
				'schema_type'     => ARRAY_A,
			)
		);
	}

	/**
	 * Register checkout block integration.
	 *
	 * @since 3.8.1
	 */
	public function register_checkout_block_integration() {
		woocommerce_store_api_register_endpoint_data(
			array(
				'endpoint'        => \Automattic\WooCommerce\StoreApi\Schemas\V1\CheckoutSchema::IDENTIFIER,
				'namespace'       => 'woo-shipping-display-mode',
				'data_callback'   => array( $this, 'get_checkout_block_data' ),
				'schema_callback' => array( $this, 'get_checkout_block_schema' ),
				'schema_type'     => ARRAY_A,
			)
		);
	}

	/**
	 * Get cart block data for Store API.
	 *
	 * @since 3.8.1
	 * @return array
	 */
	public function get_cart_block_data() {
		return array(
			'shipping_display_mode' => get_option( 'woocommerce_shipping_method_format', 'radio' ),
			'available_packages'    => $this->get_formatted_shipping_packages(),
		);
	}

	/**
	 * Get checkout block data for Store API.
	 *
	 * @since 3.8.1
	 * @return array
	 */
	public function get_checkout_block_data() {
		return array(
			'shipping_display_mode' => get_option( 'woocommerce_shipping_method_format', 'radio' ),
			'available_packages'    => $this->get_formatted_shipping_packages(),
		);
	}

	/**
	 * Get cart block schema for Store API.
	 *
	 * @since 3.8.1
	 * @return array
	 */
	public function get_cart_block_schema() {
		return array(
			'shipping_display_mode' => array(
				'description' => __( 'Shipping method display mode', 'woo-shipping-display-mode' ),
				'type'        => 'string',
				'enum'        => array( 'radio', 'select' ),
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
			'available_packages' => array(
				'description' => __( 'Available shipping packages with display mode formatting', 'woo-shipping-display-mode' ),
				'type'        => 'array',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
			),
		);
	}

	/**
	 * Get checkout block schema for Store API.
	 *
	 * @since 3.8.1
	 * @return array
	 */
	public function get_checkout_block_schema() {
		return $this->get_cart_block_schema();
	}

	/**
	 * Get formatted shipping packages for the current cart.
	 *
	 * @since 3.8.1
	 * @return array
	 */
	private function get_formatted_shipping_packages() {
		if ( ! WC()->cart || WC()->cart->is_empty() ) {
			return array();
		}

		$packages = WC()->shipping()->get_packages();
		$shipping_format = get_option( 'woocommerce_shipping_method_format', 'radio' );
		$formatted_packages = array();

		foreach ( $packages as $i => $package ) {
			$available_methods = $package['rates'] ?? array();
			
			if ( empty( $available_methods ) ) {
				continue;
			}

			$formatted_packages[ $i ] = array(
				'package_id'        => $i,
				'display_mode'      => count( $available_methods ) > 1 ? $shipping_format : 'single',
				'available_methods' => $this->format_shipping_methods( $available_methods, $i ),
				'chosen_method'     => WC()->session->get( 'chosen_shipping_methods' )[ $i ] ?? '',
			);
		}

		return $formatted_packages;
	}

	/**
	 * Format shipping methods for API response.
	 *
	 * @since 3.8.1
	 * @param array $methods Available shipping methods.
	 * @param int $package_id Package ID.
	 * @return array
	 */
	private function format_shipping_methods( $methods, $package_id ) {
		$formatted_methods = array();

		foreach ( $methods as $method ) {
			$formatted_methods[] = array(
				'id'          => $method->id,
				'label'       => $method->get_label(),
				'cost'        => $method->cost,
				'description' => $method->get_method_description(),
				'meta_data'   => $method->get_meta_data(),
			);
		}

		return $formatted_methods;
	}

	/**
	 * Handle shipping rate selection via Store API.
	 *
	 * @since 3.8.1
	 * @param bool $result Result of the selection.
	 * @param string $rate_id Selected rate ID.
	 * @param int $package_id Package ID.
	 * @return bool
	 */
	public function handle_store_api_shipping_selection( $result, $rate_id, $package_id ) {
		// Let WooCommerce handle the actual selection
		// We just need to ensure our display mode is respected
		return $result;
	}

	/**
	 * Extend cart Store API data.
	 *
	 * @since 3.8.1
	 * @param array $extensions Current extensions.
	 * @return array
	 */
	public function extend_cart_store_api_data( $extensions ) {
		$extensions['woo-shipping-display-mode'] = $this->get_cart_block_data();
		return $extensions;
	}

	/**
	 * Extend checkout Store API data.
	 *
	 * @since 3.8.1
	 * @param array $extensions Current extensions.
	 * @return array
	 */
	public function extend_checkout_store_api_data( $extensions ) {
		$extensions['woo-shipping-display-mode'] = $this->get_checkout_block_data();
		return $extensions;
	}
}
