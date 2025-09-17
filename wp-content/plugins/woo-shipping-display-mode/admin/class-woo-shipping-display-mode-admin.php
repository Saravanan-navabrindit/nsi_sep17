<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://multidots.com/
 * @since      1.0.0
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Shipping_Display_Mode
 * @subpackage Woo_Shipping_Display_Mode/admin
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Shipping_Display_Mode_Admin
{

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
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     *
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Shipping_Display_Mode_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Shipping_Display_Mode_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $page_no = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ('wc-settings' === $page_no && 'shipping_mode' === $tab) {
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_style('wp-pointer');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-shipping-display-mode-admin.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Shipping_Display_Mode_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Shipping_Display_Mode_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $page_no = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ('wc-settings' === $page_no && 'shipping_mode' === $tab) {
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-shipping-display-mode-admin.js', array(
                'jquery',
                'jquery-ui-dialog'
            ), $this->version, false);
            wp_enqueue_script('wp-pointer');
        }
    }

    /** 
     * Initialize the admin display.
     *
     * @since 1.0.0
     */
    public function wsdm_woo_shipping_admin_init_own() {
        require_once plugin_dir_path(__FILE__) . 'partials/woo-shipping-display-mode-admin-display.php';
        new WC_Settings_Shipping_Display_Mode_Methods();
    }

    /**
     * Add plugin row meta.
     *
     * @since 3.8.0
     */
    function wsdm_plugin_row_meta( $links, $file ) {

        if (strpos($file, 'woo-shipping-display-mode.php') !== false) {
            $new_links = array(
                'support' => '<a href="' . esc_url('https://www.thedotstore.com/support/') . '" target="_blank">' . esc_html__('Support', 'woo-shipping-display-mode') . '</a>',
            );

            $links = array_merge($links, $new_links);
        }

        return $links;
    }
}