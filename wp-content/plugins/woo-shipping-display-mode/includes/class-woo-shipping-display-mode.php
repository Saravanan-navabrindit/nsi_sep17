<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Shipping_Display_Mode {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Shipping_Display_Mode_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'woo-shipping-display-mode';
		$this->version     = '1.0.0';

		$this->load_dependencies();
        $this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->initialize_blocks_integration();

        add_filter( 'plugin_action_links_' . WSDM_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Shipping_Display_Mode_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Shipping_Display_Mode_i18n. Defines internationalization functionality.
	 * - Woo_Shipping_Display_Mode_Admin. Defines all hooks for the admin area.
	 * - Woo_Shipping_Display_Mode_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-shipping-display-mode-i18n.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-shipping-display-mode-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-shipping-display-mode-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-shipping-display-mode-public.php';

		/**
		 * WooCommerce Blocks integration
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-shipping-display-mode-blocks.php';

		$this->loader = new Woo_Shipping_Display_Mode_Loader();

	}

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Advanced_Flat_Rate_Shipping_For_WooCommerce_Pro_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new Woo_Shipping_Display_Mode_i18n();
        $plugin_i18n->set_domain( $this->get_plugin_name() );
        $this->loader->add_action( 'init', $plugin_i18n, 'load_plugin_textdomain' );
    }
    
	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_Shipping_Display_Mode_Admin( $this->get_plugin_name(), $this->get_version() );

        // Enqueue styles and scripts
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles', 10 );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts', 10 );
        
        // Initialize admin settings page
		$this->loader->add_action( 'admin_init', $plugin_admin, 'wsdm_woo_shipping_admin_init_own' );
        
        // Add plugin row meta
		$this->loader->add_action( 'plugin_row_meta', $plugin_admin, 'wsdm_plugin_row_meta',10,2 );
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Woo_Shipping_Display_Mode_Public( $this->get_plugin_name(), $this->get_version() );

        // Enqueue styles and scripts
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		// Modify shipping methods display
		$this->loader->add_action( 'init', $plugin_public, 'wsdm_modify_shipping_methods_display' );
		$this->loader->add_filter( 'body_class', $plugin_public, 'wsdm_add_body_class_for_shipping_mode' );
		$this->loader->add_filter( 'woocommerce_package_rates', $plugin_public, 'wsdm_filter_store_api_shipping_rates', 10, 2 );
	}

	/**
	 * Initialize WooCommerce Blocks integration.
	 *
	 * @since    3.8.1
	 * @access   private
	 */
	private function initialize_blocks_integration() {
		if ( class_exists( 'Woo_Shipping_Display_Mode_Blocks' ) ) {
			new Woo_Shipping_Display_Mode_Blocks();
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Shipping_Display_Mode_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

    /**
	 * Show action links on the plugin screen.
	 *
	 * @param mixed $links Plugin Action links.
	 *
	 * @return array
	 */
	public static function plugin_action_links( $links ) {
		$action_links = array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=shipping_mode' ) . '" aria-label="' . esc_attr__( 'View WooCommerce settings', 'woo-shipping-display-mode' ) . '">' . esc_html__( 'Settings Main', 'woo-shipping-display-mode' ) . '</a>',
		);

		return array_merge( $action_links, $links );
	}
}