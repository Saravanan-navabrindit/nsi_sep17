<?php

if( ! class_exists( 'Crown_Theme' ) ) {
	class Crown_Theme {


		protected static $config;


		public static function init() {

			add_action( 'after_setup_theme', array( __CLASS__, 'setup_theme_textdomain' ), 1);
			add_action( 'after_setup_theme', array( __CLASS__, 'setup_theme_support' ), 1);
			add_action( 'after_setup_theme', array( __CLASS__, 'setup_image_sizes' ), 1);
			add_action( 'after_setup_theme', array( __CLASS__, 'setup_nav_menus' ), 1);
			add_action( 'after_setup_theme', array( __CLASS__, 'setup_editor_stylesheet' ), 1);

			add_action( 'init', array( __CLASS__, 'disable_emojis' ) );
			add_filter( 'image_size_names_choose', array( __CLASS__, 'filter_image_size_select_option_names' ) );
			add_action( 'widgets_init', array( __CLASS__, 'register_widget_locations' ) );
			add_action( 'update_option_page_for_posts', array( __CLASS__, 'setup_page_for_posts' ), 10, 2 );
            add_action( 'wp_enqueue_scripts', array( __CLASS__, 'disable_woocommerce_photoswipe'), 20);

			add_filter( 'upload_mimes', array( __CLASS__, 'filter_allowed_upload_mimes' ) );
			add_filter( 'wp_check_filetype_and_ext', array( __CLASS__, 'validate_file_ext_and_type' ), 10, 4 );

			add_filter( 'crown_theme_colors', array( __CLASS__, 'filter_crown_theme_colors' ), 10, 2 );
			add_filter( 'crown_google_map_styles', array( __CLASS__, 'filter_crown_google_map_styles' ) );

			add_action( 'template_redirect', array( __CLASS__, 'redirect_request' ) );
			add_filter( 'crown_breadcrumb_items', array( __CLASS__, 'filter_crown_breadcrumb_items' ), 10 );

			add_action( 'wp_ajax_nopriv_search_products_by_sku', array( __CLASS__, 'ajax_search_products_by_sku' ), 10 );
			add_action( 'wp_ajax_search_products_by_sku', array( __CLASS__, 'ajax_search_products_by_sku' ), 10 );

            add_action( 'after_setup_theme', array( __CLASS__, 'get_min_order_amount') );

        }


		public static function get_dir() {
			return get_template_directory();
		}


		public static function get_uri() {
			return get_template_directory_uri();
		}


		public static function get_child_dir() {
			return get_stylesheet_directory();
		}


		public static function get_child_uri() {
			return get_stylesheet_directory_uri();
		}


		public static function is_child() {
			return self::get_dir() != self::get_child_dir();
		}


		public static function setup_theme_textdomain() {
			load_theme_textdomain( 'crown_theme' );
		}


		public static function setup_theme_support() {

			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
			// add_theme_support( 'post-formats', array() );
			add_theme_support( 'align-wide' );
			add_theme_support( 'responsive-embeds' );
			add_theme_support( 'editor-styles' );

			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-slider' );
			add_theme_support( 'wc-product-gallery-lightbox' );

			if ( ( $site_logo_size = self::get_site_logo_size() ) && ! empty( $site_logo_size ) ) {
				add_theme_support( 'custom-logo', $site_logo_size );
			}

		}


		public static function setup_image_sizes() {

			// configure post thumbnail size
			if ( ( $post_thumbnail_size = self::get_post_thumbnail_size() ) && ! empty( $post_thumbnail_size ) ) {
				set_post_thumbnail_size( $post_thumbnail_size['width'], $post_thumbnail_size['height'], $post_thumbnail_size['crop'] );
			}

			// configure additional image sizes
			if ( ( $image_sizes = self::get_image_sizes() ) && ! empty( $image_sizes ) ) {
				foreach ( $image_sizes as $size ) {
					add_image_size( $size['slug'], $size['width'], $size['height'], $size['crop'] );
				}
			}

		}


		public static function setup_nav_menus() {
			// print_r(self::get_nav_menu_locations()); die;

			if ( ( $nav_menu_locations = self::get_nav_menu_locations() ) && ! empty( $nav_menu_locations ) ) {
				foreach ( $nav_menu_locations as $location ) {
					register_nav_menu( $location['slug'], $location['name'] );
				}
			}

		}


		public static function setup_editor_stylesheet() {
			add_editor_style( 'assets/css/editor-style.min.css' );
			add_editor_style( self::get_uri() . '/assets/css/editor-style.min.css?ver=' . filemtime( self::get_dir() . '/assets/css/editor-style.min.css' ) );
		}


		public static function disable_emojis() {
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		}


		public static function filter_image_size_select_option_names( $sizes ) {
			global $_wp_additional_image_sizes;
			
			$sizes_config = array();
			foreach ( get_intermediate_image_sizes() as $size_name ) {
				if ( $size_name == 'post-thumbnail' ) continue;
				if ( in_array( $size_name, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$sizes_config[ $size_name ]['width'] = get_option( $size_name . '_size_w' );
					$sizes_config[ $size_name ]['height'] = get_option( $size_name . '_size_h' );
					$sizes_config[ $size_name ]['crop'] = (bool) get_option( $size_name . '_crop' );
				} else if ( isset( $_wp_additional_image_sizes[ $size_name ] ) ) {
					$sizes_config[ $size_name ] = array(
						'width' => $_wp_additional_image_sizes[ $size_name ]['width'],
						'height' => $_wp_additional_image_sizes[ $size_name ]['height'],
						'crop' => $_wp_additional_image_sizes[ $size_name ]['crop']
					);
				}
			}
			uasort( $sizes_config, function( $a, $b ) {
				return $a['width'] - $b['width'];
			} );

			$sizes = array();
			foreach ( $sizes_config as $size_name => $config ) {
				$label = ucwords( str_replace( '_', ' ', $size_name ) );
				$dimensions = $config['width'] . '×' . $config['height'];
				if ( ! $config['crop'] ) {
					if ( $config['height'] >= 9999 || $config['height'] == 0 ) {
						$dimensions = $config['width'] . 'px max width';
					} else {
						$dimensions .= ' max';
					}
				}
				$label .= ' (' . $dimensions . ')';
				$sizes[ $size_name ] = $label;
			}
			$sizes['full'] = 'Full Size';

			return $sizes;
		}

        public static function disable_woocommerce_photoswipe() {
            wp_dequeue_script('photoswipe');
            wp_dequeue_script('photoswipe-ui-default');

            wp_dequeue_style('photoswipe');
            wp_dequeue_style('wc-product-gallery');
        }

        public static function register_widget_locations() {

			$defaults = array(
				'id' => '',
				'name' => '',
				'description' => '',
				'class' => '',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget' => '</section>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			);

			$widget_locations = self::get( 'widgetLocations' );
			if ( ! empty( $widget_locations ) ) {
				foreach ( $widget_locations as $location ) {
					$location = array_merge( $defaults, (array) $location );
					if ( empty( $location['slug'] ) ) continue;
					$location['id'] = $location['slug'];
					unset( $location['slug'] );
					register_sidebar( $location );
				}
			}

		}


		public static function setup_page_for_posts( $old_value, $new_value ) {
			$post = $new_value ? get_post( $new_value ) : null;
			if ( $post && empty( $post->post_content ) ) {
				wp_update_post( array( 'ID' => $post->ID, 'post_content' => ' ' ) );
			}
		}


		public static function filter_allowed_upload_mimes($mimes) {
			$mimes = array_merge( $mimes, (array) self::get( 'uploadMimes' ) );
			return $mimes;
		}
	
	
		public static function validate_file_ext_and_type($check, $file, $filename, $mimes) {
			if ( $check['ext'] && $check['type'] ) {
				return $check;
			}
			return array_merge( $check, wp_check_filetype( $filename, apply_filters( 'upload_mimes', array() ) ) );
		}


		public static function filter_crown_theme_colors( $colors, $context = '' ) {
			$color_palette = self::get( 'color', 'palette' );
			if ( empty( $color_palette ) ) return $colors;
			$colors = array_map( function( $n ) { return $n->color; }, $color_palette );
			return $colors;
		}


		public static function filter_crown_google_map_styles( $styles = null ) {
			$path = self::get_dir() . '/assets/data/google-map-styles.json';
			if ( ! file_exists( $path ) ) return $styles;
			return json_decode( file_get_contents( $path ) );
		}






		public static function get( $key = null, $child_key = null ) {
			if ( self::$config === null ) {
				$path = self::get_dir() . '/theme.json';
				self::$config = file_exists( $path ) ? json_decode( file_get_contents( $path ) ) : new stdClass();
				if ( property_exists( self::$config, 'settings' ) ) self::$config = self::$config->settings;
				if ( self::is_child() ) {
					$path = self::get_child_dir() . '/theme.json';
					$child_config = file_exists( $path ) ? json_decode( file_get_contents( $path ) ) : new stdClass();
					if ( property_exists( $child_config, 'settings' ) ) $child_config = $child_config->settings;
					self::$config = (object) array_merge( (array) self::$config, (array) $child_config );
				}
			}
			if ( ! empty( $key ) ) {
				if ( property_exists( self::$config, $key ) ) {
					if ( ! empty( $child_key ) ) {
						if ( property_exists( self::$config->$key, $child_key ) ) {
							return self::$config->$key->$child_key;
						}
						return null;
					}
					return self::$config->$key;
				}
				return null;
			}
			return self::$config;
		}


		public static function get_site_logo_size() {
			$site_logo_size = self::get( 'siteLogoSize' );
			if ( empty( $site_logo_size ) ) return null;
			$site_logo_size = array_merge( array(
				'width' => 300,
				'height' => 200,
				'flexWidth' => true,
				'flexHeight' => true
			), (array) $site_logo_size );
			$site_logo_size = array_merge( $site_logo_size, array(
				'flex-width' => $site_logo_size['flexWidth'],
				'flex-height' => $site_logo_size['flexHeight']
			) );
			unset( $site_logo_size['flexWidth'] );
			unset( $site_logo_size['flexHeight'] );
			return $site_logo_size;
		}


		public static function get_post_thumbnail_size() {
			$post_thumbnail_size = self::get( 'postThumbnailSize' );
			if ( empty( $post_thumbnail_size ) ) return null;
			$post_thumbnail_size = array_merge( array(
				'width' => 150,
				'height' => 150,
				'crop' => false
			), (array) $post_thumbnail_size );
			return $post_thumbnail_size;
		}


		public static function get_image_sizes() {
			$image_sizes = self::get( 'imageSizes' );
			if ( empty( $image_sizes ) ) return array();
			$image_sizes = array_map( function( $n ) {
				$n = array_merge( array(
					'slug' => '',
					'width' => 0,
					'height' => 0,
					'crop' => false
				), (array) $n );
				return $n;
			}, $image_sizes );
			return $image_sizes;
		}


		public static function get_nav_menu_locations() {
			$nav_menu_locations = self::get( 'navMenuLocations' );
			if ( empty( $nav_menu_locations ) ) return array();
			$nav_menu_locations = array_map( function( $n ) {
				$n = array_merge( array(
					'name' => '',
					'slug' => ''
				), (array) $n );
				return $n;
			}, $nav_menu_locations );
			return $nav_menu_locations;
		}


		public static function get_grid_breakpoints() {
			$grid_breakpoints_config = self::get( 'gridBreakpoints' );
			$grid_breakpoints = array();
			if ( empty( $grid_breakpoints_config ) || ! is_array( $grid_breakpoints_config ) ) return $grid_breakpoints;
			foreach ( $grid_breakpoints_config as $grid_breakpoint_config ) {
				$grid_breakpoint = (object) array_merge( array(
					'name' => '',
					'width' => 0
				), (array) $grid_breakpoint_config );
				if ( empty( $grid_breakpoint->name ) ) continue;
				$grid_breakpoints[] = $grid_breakpoint;
			}
			usort( $grid_breakpoints, function( $a, $b ) { return $a->width - $b->width; } );
			return $grid_breakpoints;
		}



		public static function redirect_request() {
			$redirect_url = null;
			
			if ( is_category() ) {
				$posts_page_id = get_option('theme_config_index_page_post');
				if ( ! empty( $posts_page_id ) ) {
					$term = get_queried_object();
					$redirect_url = add_query_arg( array( 'p_category' => $term->term_id ), get_permalink( $posts_page_id ) );
				}
			}

			if ( ! empty( $redirect_url ) ) {
				wp_redirect( $redirect_url );
				die;
			}
		}

		public static function filter_crown_breadcrumb_items( $items ) {

			if ( is_singular( 'post' ) ) {
				$new_items = array();
				$posts_page_id = get_option('theme_config_index_page_post');
				if ( ! empty( $posts_page_id ) ) {
					$new_items = CrownBreadcrumbs::getPostAncestorBreadcrumbItems( $posts_page_id );
					$new_items[] = array( 'p' => $posts_page_id );
				}
				if ( ! empty( $new_items ) ) {
					array_splice( $items, 1, 0, $new_items );
				}
			}

			return $items;
		}




		public static function ajax_search_products_by_sku() {
			global $wpdb;

			$response = array(
				'query' => '',
				'results' => array()
			);

			$s = isset( $_GET['s'] ) ? trim( $_GET['s'] ) : '';
			if ( empty( $s ) || strlen( $s ) < 2 ) wp_send_json( $response );

			$response['query'] = $s;

			$product_ids = $wpdb->get_col( $wpdb->prepare(
				"SELECT
						p.ID
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->wc_product_meta_lookup pm1 ON (pm1.product_id = p.ID)
					WHERE p.post_type = 'product'
					AND p.post_status = 'publish'
					AND pm1.sku LIKE %s
					ORDER BY pm1.sku ASC
					LIMIT 20
				", '%' . $s . '%' ) );

			$response['results'] = array_map( function( $n ) {
				return array(
					'url' => get_permalink( $n ),
					'title' => get_the_title( $n ),
					'sku' => get_post_meta( $n, '_sku', true )
				);
			}, $product_ids );

			wp_send_json( $response );
		}

        public static function get_min_order_amount() {
            global $minimum_order_amount_allowed;

            if ( !isset( $minimum_order_amount_allowed ) ) {
                $min_order_amount_allowed_from_fb = get_option('custom_settings_default_minimum_order_amount');
                $minimum_order_amount_allowed = $min_order_amount_allowed_from_fb == false ? 100 : $min_order_amount_allowed_from_fb;
            }
            return $minimum_order_amount_allowed;
        }
	}

}


Crown_Theme::init();