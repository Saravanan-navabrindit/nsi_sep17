<?php

if ( ! class_exists( 'Crown_Theme_Scripts' ) ) {
	class Crown_Theme_Scripts {


		public static function init() {

			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'localize_script_data' ), 11 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ), 12 );
			add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_scripts' ), 20, 1 );
			
			add_action( 'wp_head', array( __CLASS__, 'output_head_scripts' ) );
			add_action( 'wp_body_open', array( __CLASS__, 'output_body_open_scripts' ) );
			add_action( 'wp_footer', array( __CLASS__, 'output_footer_scripts' ) );

			add_action( 'wp_ajax_get_site_by_domain', array( __CLASS__, 'get_ajax_site_by_domain' ) );
			add_action( 'wp_ajax_nopriv_get_site_by_domain', array( __CLASS__, 'get_ajax_site_by_domain' ) );

			add_filter( 'script_loader_tag', array( __CLASS__, 'add_type_module') , 10, 3 );

            add_action( 'wp_ajax_calculate_cart_items_amount', array( __CLASS__, 'calculate_cart_items_amount' ) );
            add_action( 'wp_ajax_nopriv_calculate_cart_items_amount', array( __CLASS__, 'calculate_cart_items_amount' ) );
            add_filter( 'script_loader_tag', array( __CLASS__, 'add_type_module_to_script'), 10, 3 ) ;
		}


		public static function register_scripts() {

			$scripts = array(
				array(
					'handle' => 'popperjs',
					'local_path' => '/lib/popperjs/dist/umd/popper.min.js'
				),
				array(
					'handle' => 'bootstrap',
					'local_path' => '/lib/bootstrap/dist/js/bootstrap.min.js',
					'deps' => array( 'jquery', 'popperjs' )
				),
				array(
					'handle' => 'slick',
					'local_path' => '/lib/slick/slick.min.js',
					'deps' => array( 'jquery' )
				),
				array(
					'handle' => 'blueimp-gallery',
					'local_path' => '/lib/blueimp-gallery/js/blueimp-gallery.min.js'
				),
				array(
					'handle' => 'odometer',
					'local_path' => '/lib/odometer/odometer.min.js'
				),
				array(
					'handle' => 'google-maps-infobox',
					'local_path' => '/lib/infobox/infobox_packed.js',
					'deps' => array( 'google-maps-api' )
				),
				array(
					'handle' => 'jquery-oembed',
					'local_path' => '/lib/jquery-oembed/jquery.oembed.js',
					'deps' => array( 'jquery' )
				),
				array(
					'handle' => 'rellax',
					'local_path' => '/lib/rellax/rellax.min.js'
				),
				array(
					'handle' => 'crown-theme-scripts',
					'local_path' => '/assets/dist/js/public.min.js',
					'deps' => array( 'jquery-effects-core' )
				),
				array(
					'handle' => 'crown-theme-main',
                        'local_path' => '/assets/js/main' . ( ( defined('JS_CSS_MODE_MIN') && JS_CSS_MODE_MIN ) ? '.min' : '' ) . '.js',
                        'deps' => array( 'jquery-effects-core', 'bootstrap', 'slick', 'blueimp-gallery', 'odometer', 'jquery-oembed', 'rellax', 'select2' )
				)
			);
			
			$scripts = apply_filters( 'crown_theme_scripts', $scripts );

			foreach ( $scripts as $script ) {
				self::register_script( $script );
			}

		}


		protected static function register_script( $args ) {

			$args = array_merge( array(
				'handle' => '',
				'local_path' => '',
				'src' => '',
				'ver' => '',
				'deps' => array(),
				'in_footer' => true
			), $args);

			if ( ! empty( $args['local_path'] ) ) {
				if ( ! file_exists( Crown_Theme::get_dir() . $args['local_path'] ) ) return false;
				$args['src'] = empty( $args['src'] ) ? Crown_Theme::get_uri() . $args['local_path'] : $args['src'];
				$args['ver'] = empty( $args['ver'] ) ? filemtime( Crown_Theme::get_dir() . $args['local_path'] ) : $args['ver'];
			}

			wp_register_script( $args['handle'], $args['src'], $args['deps'], $args['ver'], $args['in_footer'] );

		}


		public static function localize_script_data() {
            $nonce_profile_quote = wp_create_nonce('afrfq-profile-quote');
			$data = array(
				'baseUrl' => get_home_url(),
				'themeUrl' => Crown_Theme::get_uri(),
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'siteName' => get_bloginfo( 'name' ),
				'calendlyUrlOverride' => false,
                'nonce_profile_quote' => $nonce_profile_quote,
                'quote_lines_limit' => defined('AFRFQ_MAX_ROWS_ALLOWED') ? AFRFQ_MAX_ROWS_ALLOWED : 200,
			);

			wp_localize_script( 'crown-theme-main', 'crownThemeData', $data );

		}

		public static function enqueue_scripts() {

			wp_enqueue_script( 'crown-theme-main' );
            $afrfq_id = get_query_var( 'request-quote' );
            $quote = get_post( $afrfq_id );

            if ( is_page('request-a-quote') || (! empty( $afrfq_id ) && is_a( $quote, 'WP_Post' )) ) {
                $import_script_path = '/assets/js/afrfq-import-script.js';
				$import_pricing_script_path = '/assets/js/afrfq-pricing-import-script.js';
				$import_detail_pricing_script_path = '/assets/js/afrfq-detail-pricing-import-script.js';
                $clear_cart_script_path = '/assets/js/clear-carts.js';
                wp_register_script('afrfq-import-script', Crown_Theme::get_uri() . $import_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_script_path), true);
                wp_register_script('afrfq-pricing-import-script', Crown_Theme::get_uri() . $import_pricing_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_pricing_script_path), true);
                wp_register_script('afrfq-detail-pricing-import-script', Crown_Theme::get_uri() . $import_detail_pricing_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_detail_pricing_script_path), true);
                wp_register_script('clear-carts', Crown_Theme::get_uri() . $clear_cart_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $clear_cart_script_path), true);
                wp_enqueue_script('afrfq-import-script');
				wp_enqueue_script('afrfq-pricing-import-script');
				wp_enqueue_script('afrfq-detail-pricing-import-script');
                wp_enqueue_script('clear-carts');
                $import_nonce = wp_create_nonce('afrfq_import_nonce');
                $clear_cart_nonce = wp_create_nonce('clear_quotes_cart');
                wp_localize_script('afrfq-import-script', 'afrfq_ajax_obj', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'afrfq_import_nonce' => $import_nonce,
                    'afrfq_clear_cart_nonce' => $clear_cart_nonce,
                    'afrfq_pricing_import_nonce' => wp_create_nonce('afrfq_pricing_import_nonce'),
                    'afrfq_detail_pricing_import_nonce' => wp_create_nonce('afrfq_detail_pricing_import_nonce')
                ));
                wp_localize_script('afrfq-pricing-import-script', 'afrfq_ajax_obj', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'afrfq_import_nonce' => $import_nonce,
                    'afrfq_clear_cart_nonce' => $clear_cart_nonce
                ));
                wp_localize_script('afrfq-detail-pricing-import-script', 'afrfq_ajax_obj', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'afrfq_import_nonce' => $import_nonce,
                    'afrfq_clear_cart_nonce' => $clear_cart_nonce
                ));
            }

            if ( is_page('cart') ) {
                $import_script_path = '/assets/js/cart-data-import-script.js';
                $clear_cart_script_path = '/assets/js/clear-carts.js';
                wp_register_script('cart-data-import-script', Crown_Theme::get_uri() . $import_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_script_path), true);
                wp_register_script('clear-carts', Crown_Theme::get_uri() . $clear_cart_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $clear_cart_script_path), true);
                wp_enqueue_script('cart-data-import-script');
                wp_enqueue_script('clear-carts');
                $nonce = wp_create_nonce('cart_data_import_nonce');
                $clear_shopping_cart_nonce = wp_create_nonce('clear_shopping_cart');
                wp_localize_script('cart-data-import-script', 'afrfq_ajax_obj', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => $nonce,
                    'clear_shopping_cart_nonce' => $clear_shopping_cart_nonce
                ));
            }

            if (is_wc_endpoint_url('view-order')) {
                $order_id = get_query_var( 'view-order' );
                $order_documents_script_path = '/assets/js/order-documents.js';
                wp_register_script('order-documents-script', Crown_Theme::get_uri() . $order_documents_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $order_documents_script_path), true);
                wp_enqueue_script('order-documents-script');
                $order_documents_nonce = wp_create_nonce('order_documents_nonce_' . $order_id);
                wp_localize_script('order-documents-script', 'order_document', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => $order_documents_nonce,
                ));
            }
		}

        public static function add_type_module_to_script( $tag, $handle, $src ) {
    if (
        $handle === 'cart-data-import-script' ||
        $handle === 'afrfq-import-script' ||
        $handle === 'afrfq-pricing-import-script' ||
        $handle === 'afrfq-detail-pricing-import-script'
    ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '" id="'.$handle.'"></script>';
    }
    return $tag;
}


		public static function enqueue_admin_scripts($hook) {
            global $post;
            $local_path = '/assets/js/admin-panel.js';
            $script_path = Crown_Theme::get_dir() . $local_path;
            wp_register_script('admin-panel', Crown_Theme::get_uri() . $local_path, array(), filemtime($script_path), true);
            wp_enqueue_script('admin-panel');

            if ( ( $hook === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'addify_quote')
            || ( $hook === 'post.php' && isset($_GET['post']) && get_post_type($_GET['post']) === 'addify_quote') ) {
                $import_script_path = '/assets/js/afrfq-import-script.js';
				$import_pricing_script_path = '/assets/js/afrfq-pricing-import-script.js';
				$import_detail_pricing_script_path = '/assets/js/afrfq-detail-pricing-import-script.js';
                wp_register_script('afrfq-import-script', Crown_Theme::get_uri() . $import_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_script_path), true);
                wp_register_script('afrfq-pricing-import-script', Crown_Theme::get_uri() . $import_pricing_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_pricing_script_path), true);
				wp_register_script('afrfq-detail-pricing-import-script', Crown_Theme::get_uri() . $import_detail_pricing_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $import_detail_pricing_script_path), true);
                wp_enqueue_script('afrfq-import-script');
				wp_enqueue_script('afrfq-pricing-import-script');
				wp_enqueue_script('afrfq-detail-pricing-import-script');
                $nonce = wp_create_nonce('afrfq_import_nonce');
                wp_localize_script('afrfq-import-script', 'afrfq_ajax_obj', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => $nonce,
                    'afrfq_import_nonce' => $nonce,
                    'afrfq_pricing_import_nonce' => wp_create_nonce('afrfq_pricing_import_nonce'),
                    'afrfq_detail_pricing_import_nonce' => wp_create_nonce('afrfq_detail_pricing_import_nonce')
                ));
                wp_localize_script('afrfq-pricing-import-script', 'afrfq_ajax_obj', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => $nonce,
                    'afrfq_import_nonce' => $nonce,
                ));
				wp_localize_script('afrfq-detail-pricing-import-script', 'afrfq_ajax_obj', array(
					'ajaxurl' => admin_url('admin-ajax.php'),
					'nonce' => $nonce,
					'afrfq_import_nonce' => $nonce,
				));
            }

            if ( isset($post) && 'shop_order' === get_post_type($post) ) {
                $order_documents_script_path = '/assets/js/order-documents.js';
                wp_register_script('order-documents-script', Crown_Theme::get_uri() . $order_documents_script_path, array('jquery'), filemtime(Crown_Theme::get_dir() . $order_documents_script_path), true);
                wp_enqueue_script('order-documents-script');
                $order_documents_nonce = wp_create_nonce('order_documents_nonce_' . $post->ID);
                wp_localize_script('order-documents-script', 'order_document', array(
                    'ajaxurl' => admin_url('admin-ajax.php'),
                    'nonce' => $order_documents_nonce,
                ));
            }
        }

		public static function output_head_scripts() {
			?>

				<script type="text/javascript">
					document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
				</script>

			<?php
		}


		public static function output_body_open_scripts() {
			if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) {
				gtm4wp_the_gtm_tag();
			}
		}


		public static function output_footer_scripts() {}


		public static function get_ajax_site_by_domain() {

			$domain = isset( $_GET['domain'] ) ? $_GET['domain'] : '';
			if ( empty( $domain ) ) wp_send_json( null );

			$sites = get_sites( array( 'domain' => $domain, 'number' => 1 ) );
			if ( empty( $sites ) && ! preg_match( '/^www\./', $domain ) ) {
				$sites = get_sites( array( 'domain' => 'www.' . $domain, 'number' => 1 ) );
			}

			if ( ! empty( $sites ) ) {
				wp_send_json( get_blog_details( $sites[0]->blog_id ) );
			} else {
				wp_send_json( null );
			}

		}

		public static function add_type_module($tag, $handle, $src) {
			if ( !in_array($handle, array('crown-theme-main', 'admin-panel')) ) {
				return $tag;
			}
			$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
			return $tag;
		}

        /**
         * AJAX callback - returns amount of items in cart
         */
        public static function calculate_cart_items_amount(): void
        {
            $cart_count = WC()->cart instanceof \WC_Cart ? WC()->cart->get_cart_contents_count() : '0';

            echo json_encode([
                'cart_count' => $cart_count,
            ]);
            die();
        }

	}
}
