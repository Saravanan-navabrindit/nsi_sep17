<?php
/**
 * Plugin Name: Eleks Hawksearch Integration
 * Description: Integrates Hawksearch with WooCommerce for enhanced search functionality.
 * Version: 1.0
 * Author: Eleks
 */

if (!defined('ABSPATH')) exit;

define('HAWKSEARCH_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HAWKSEARCH_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once HAWKSEARCH_PLUGIN_DIR . 'inc/class-hawksearch-base-api.php';
require_once HAWKSEARCH_PLUGIN_DIR . 'inc/class-hawksearch-indexing-api.php';
require_once HAWKSEARCH_PLUGIN_DIR . 'inc/class-hawksearch-hierarchy-api.php';

class HawkSearch {

	public static $init = false;

	/**
	 * Hawksearch base API class.
	 *
	 * @var ?Hawksearch_base_API
	 */
	public static ?Hawksearch_base_API $base_api = null;

	/**
	 * Hawksearch indexing API class.
	 *
	 * @var ?Hawksearch_indexing_API
	 */
	public static ?Hawksearch_indexing_API $indexing_api = null;

	/**
	 * Hawksearch background index products class.
	 *
	 * @var Hawksearch_Products_Background_Indexing
	 */
	protected static $hawksearch_products_background_indexing = null;
    protected static ?Hawksearch_hierarchy_API $hierarchy_api = null;

	public static function init() {
		if( self::$init ) return;
		self::$init = true;

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_scripts' ), 10 );
		add_action( 'woocommerce_loaded', array( __CLASS__, 'init_hawksearch_batch_index_products' ), 1000 );
		add_action('save_post', array( __CLASS__, 'hawksearch_index_single_product'), 10, 3);
		add_action('before_delete_post', array( __CLASS__, 'hawksearch_remove_product_from_index'), 10, 2);
		add_action('plugins_loaded', array( __CLASS__, 'hawksearch_init'));

		if ( class_exists( 'WP_CLI' ) ) {
			/**
			 * WP_CLI hawksearch index products allows to index all available products in batches.
			 *
			 * Usage:
			 * wp hawksearch index products --new_index=true
			 * wp hawksearch index products --limit=250 --offset=250
			 */
			WP_CLI::add_command( 'hawksearch index products', function( $args, $assoc_args ) {
				if ( isset( $assoc_args['limit'] ) && isset( $assoc_args['offset'] ) ) {
					$limit = $assoc_args['limit'];
					$offset = $assoc_args['offset'];
					$new_index = FALSE;
				} elseif ( isset( $assoc_args['new_index'] ) ) {
					$limit = -1;
					$offset = 0;
					$new_index = TRUE;
				} else {
					WP_CLI::log( 'Please specify the limit and offset or set flag --new_index=true.' );
					return;
				}
				WP_CLI::log( 'Started products push to indexing batch.' );
				self::hawksearch_batch_index_products($limit, $offset, $new_index);
				if ( $new_index ) {
					WP_CLI::log( 'Pushed all products to indexing batch. It will take some time to reindex. Please wait until it is done.' );
				} else {
					WP_CLI::log( 'Products pushed to indexing limited to ' . $limit );
				}
			} );

            /**
             * WP_CLI hawksearch create new index allows to create new empty index.
             *
             * Usage:
             * wp hawksearch create new index
             * wp hawksearch create new index --current=true
             */
            WP_CLI::add_command( 'hawksearch create new index', function( $args, $assoc_args ) {
                $current = $assoc_args['current'] ?? FALSE;
                WP_CLI::log('Started creating new index.');
                if ($current) {
                    $current_index = self::$indexing_api->get_current_index();


                    if ($current_index && !strpos('Unable to retrieve the current index name.', $current_index)) {
                        WP_CLI::log('Current index: ' . $current_index);
                        $all_indexes = self::$indexing_api->get_all_indexes();
                        $indexes = array_diff($all_indexes, array($current_index)) ?? array();
                        $indexed_values = array_values($indexes);
                        foreach ($indexed_values as $index) {
                            self::$indexing_api->delete_index($index);
                            WP_CLI::log('Index deleted: ' . $index);
                        }
                    } else {
                        WP_CLI::log('Unable to retrieve the current index name.');
                    }
                }

                $index_name = self::$indexing_api->create_index();
                if ($index_name) {
                    self::$indexing_api->set_current_index($index_name);
                    WP_CLI::log('New index created and set up as current.');
                } else {
                    WP_CLI::log('Something went wrong, new index wasn\'t created.');
                }
            } );

			/**
             * WP_CLI hawksearch cancel indexing allows to cancel reindex process.
             *
             * Usage:
             * wp hawksearch cancel indexing
             */
            WP_CLI::add_command( 'hawksearch cancel indexing', function( $args, $assoc_args ) {
				self::$hawksearch_products_background_indexing->cancel_process();
				WP_CLI::log( 'Successfully removed hawksearch indexing batches.' );
            } );

            /**
             * WP_CLI hawksearch refresh hierarchy - rebuilds hierarchy data on current index
             *
             * Usage:
             * wp hawksearch refresh hierarchy
             */
            WP_CLI::add_command( 'hawksearch refresh hierarchy', function( $args, $assoc_args ) {
                $current_index = self::$indexing_api->get_current_index();
                self::$hierarchy_api->delete_hierarchy( $current_index );
                self::$hierarchy_api->upsert_hierarchy_data( $current_index );
                self::$hierarchy_api->rebuild_hierarchy( $current_index );
                self::$indexing_api->rebuild_all( $current_index );
                WP_CLI::log( 'Successfully refreshed hierarchy data.' );
            } );

            /**
             * WP_CLI hawksearch add hierarchy - populates hierarchy data on current index
             *
             * Usage:
             * wp hawksearch add hierarchy
             */
            WP_CLI::add_command( 'hawksearch add hierarchy', function( $args, $assoc_args ) {
                $current_index = self::$indexing_api->get_current_index();
                self::$hierarchy_api->upsert_hierarchy_data( $current_index );
                self::$hierarchy_api->rebuild_hierarchy( $current_index );
                self::$indexing_api->rebuild_all( $current_index );
                WP_CLI::log( 'Successfully populated hierarchy data.' );
            } );

            /**
             * WP_CLI hawksearch delete indexes - removes all existing indexes on HawkSearch
             *
             * Usage:
             * wp hawksearch delete indexes
             */
            WP_CLI::add_command( 'hawksearch delete indexes', function( $args, $assoc_args ) {
                $indexes = self::$indexing_api->get_all_indexes();
                if ( $indexes ) {
                    foreach ( $indexes as $index ) {
                        self::$indexing_api->delete_index( $index );
                    }

                    WP_CLI::log( 'Indexes removed' );
                } else {
                    WP_CLI::log( 'Indexes not found' );
                }
            } );
		}
	}

	public static function register_scripts() {
		wp_register_script( 'hawksearch-main', plugins_url('assets/js/hawksearch-main.js', __FILE__), array('jquery'));

		wp_enqueue_script('hawksearch-main');
	}

	public static function hawksearch_batch_index_products($limit, $offset, $new_index = FALSE) {
		$product_ids = get_posts( array(
			'post_type' => 'product',
            'post_status' => 'publish',
			'posts_per_page' => $limit,
			'fields' => 'ids',
			'offset' => $offset,
			) );
		$batch_size = 125;
		$product_batches = array();
		WP_CLI::log( 'Products count: ' . count($product_ids) );
		for ($i = 0; $i < count($product_ids); $i += $batch_size) {
			$product_batches[] = array_slice($product_ids, $i, $batch_size);
		}

		$current_index = self::$indexing_api->get_current_index();
		if ($new_index) {
			$all_indexes = self::$indexing_api->get_all_indexes();
			$indexes = array_diff( $all_indexes, array( $current_index ) ) ?? array();
			$indexed_values = array_values( $indexes );
			foreach ($indexed_values as $index) {
				self::$indexing_api->delete_index($index);
			}

			$index_name = self::$indexing_api->create_index();
            self::$hierarchy_api->upsert_hierarchy_data( $index_name );
            self::$hierarchy_api->rebuild_hierarchy( $index_name );
			WP_CLI::log( 'New index created: ' . $index_name );
		} else {
			$index_name = $current_index;
		}

		if ($index_name) {
			foreach ($product_batches as $batch) {
				self::$hawksearch_products_background_indexing->push_to_queue( array( 'products' => $batch, 'index_name' => $index_name, 'new_index' => $new_index ) );
			}
			self::$hawksearch_products_background_indexing->save()->dispatch();
		}
	}

	public static function init_hawksearch_batch_index_products() {
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins ) ) {
			include( dirname( __FILE__ ) . '/inc/class-hawksearch-products-background-indexing.php' );
			self::$hawksearch_products_background_indexing = new Hawksearch_Products_Background_Indexing();
		}
	}

	public static function hawksearch_index_single_product($post_id, $product, $update) {
		if ($product->post_type != 'product') {
			return;
		}

        if (get_post_status($post_id) === 'publish') {
            self::$indexing_api->sync_single_product_to_hawksearch($post_id);
        } else {
            self::$indexing_api->delete_single_product_from_index($post_id);
        }
	}

    public static function hawksearch_remove_product_from_index($post_id, $product) {
		if ($product->post_type != 'product') {
			return;
		}
        self::$indexing_api->delete_single_product_from_index($post_id);
	}

	public static function hawksearch_init() {
		self::$base_api = new Hawksearch_base_API();
		self::$indexing_api = new Hawksearch_indexing_API();
        self::$hierarchy_api = new Hawksearch_hierarchy_API( self::$indexing_api );
	}
}

HawkSearch::init();