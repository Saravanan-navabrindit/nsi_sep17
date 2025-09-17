<?php
/**
 * Plugin Name: NSI Industries - Return Merchandise Authorization
 * Description: Integrates Netsuite Return Merchandise Authorization with WooCommerce.
 * Version: 1.0
 * Author: Eleks
 * Text Domain: nsi-rma
 */

if ( !defined('ABSPATH') ) exit;

define( 'NSI_RMA_DIR_PATH', plugin_dir_path( __FILE__ ) );

require_once NSI_RMA_DIR_PATH . 'classes/nsi-rma-post-type.php';
require_once NSI_RMA_DIR_PATH . 'classes/nsi-rma-multistep-form.php';
require_once NSI_RMA_DIR_PATH . 'classes/nsi-rma-listings.php';
require_once NSI_RMA_DIR_PATH . 'classes/nsi-rma-settings.php';
require_once NSI_RMA_DIR_PATH . 'classes/nsi-ns-api.php';

class NSI_RMA_Integration {

    public static $init = false;
    public static $ver = 1.0;

    public static function init() {
        if( self::$init ) {
            return;
        }
        self::$init = true;

        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_rma_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_rma_admin_scripts' ) );
        add_filter( 'woocommerce_account_menu_items', array( __CLASS__, 'add_returns_menu_item' ), 20, 2 );
        add_action( 'template_redirect', array( __CLASS__, 'restrict_rma_pages' ) );
    }

    public static function enqueue_rma_scripts() {
        wp_enqueue_style( 'rma-style', plugin_dir_url( __FILE__ ) . '/assets/style.css', array(), self::$ver );
        if ( is_account_page() && (NSI_RMA_Multistep_Form::is_rma_form() || NSI_RMA_Listings::is_single_rma_page()) ) {
            wp_register_script( 'rma-integration-main', plugins_url('assets/js/rma-integration-main.js', __FILE__), array('jquery'));
            wp_enqueue_script('rma-integration-main');

            $localize_arr = array();
            if ( NSI_RMA_Listings::is_single_rma_page() ) {
                $rma_pdf_nonce = wp_create_nonce('rma_pdf_nonce_' . get_query_var('returns') );
                $localize_arr['rma_pdf_nonce'] = $rma_pdf_nonce;
                $localize_arr['ajaxurl'] = admin_url('admin-ajax.php');
            }
            wp_localize_script( 'rma-integration-main', 'NSI_RMA_Settings', $localize_arr );
        }
    }

    public static function enqueue_rma_admin_scripts() {
        wp_enqueue_style( 'rma-admin-style', plugin_dir_url( __FILE__ ) . '/assets/style-admin.css', array(), self::$ver );
        wp_enqueue_script( 'rma-admin-scripts', plugin_dir_url( __FILE__ ) . '/assets/js/scripts-admin.js', array( 'jquery', 'jquery-ui-core' ), self::$ver );
        wp_enqueue_style( 'woocommerce_admin_styles' );

        global $post;
        if ( isset($post) && get_post_type($post) == 'rma' ) {
            wp_register_script( 'rma-integration-main', plugins_url('assets/js/rma-integration-main.js', __FILE__), array('jquery'));
            wp_enqueue_script('rma-integration-main');

            $rma_pdf_nonce = wp_create_nonce('rma_pdf_nonce_' . $post->ID );
            $localize_arr = array(
                'rma_pdf_nonce' => $rma_pdf_nonce,
                'ajaxurl' => admin_url('admin-ajax.php'),
            );
            wp_localize_script( 'rma-integration-main', 'NSI_RMA_Settings', $localize_arr );
        }

        wp_localize_script( 'rma-admin-scripts', 'NSI_RMA_Admin_Settings', array( 'nonce' => wp_create_nonce('nsi_rma_integration_nonce') ) );
    }

    public static function add_returns_menu_item( $items ) {
        $current_user = wp_get_current_user();
        if ( $current_user->roles[0] === 'customer' ) {
            $logout = $items['customer-logout'];
            unset( $items['customer-logout'] );
            $items['returns'] = esc_html__( 'Returns', 'nsi-rma-integration' );
            $items['customer-logout'] = $logout;
        }
        return $items;
    }

    public static function restrict_rma_pages() {
        if ( is_account_page() && ( NSI_RMA_Multistep_Form::is_rma_form() || NSI_RMA_Listings::is_rma_dashboard() ) ) {
            $current_user = wp_get_current_user();
            if ( $current_user->roles[0] === 'customer' ) {
                return;
            }
            wp_redirect( home_url( '/access-denied' ) );
            exit;
        }
    }

}

NSI_RMA_Integration::init();