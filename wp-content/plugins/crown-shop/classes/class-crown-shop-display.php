<?php

use Crown\Post\Taxonomy;
use CrownShop\Enums\LogWooErrorType;

if ( ! class_exists( 'Crown_Shop_Display' ) ) {
	class Crown_Shop_Display {

		public static $init = false;

		protected static $checkout_lock = false;

        public static $display_inventory_price_for_non_purchasable = FALSE;
        public static $product_in_manual_restricted_brands_for_sales_rep_domains_list = FALSE;
        public static $is_product_allowed_for_dual_shop_manager = true;
        public static array $manual_allow_restricted_customer_divisions = ['HVAC'];
        public static array $manual_restricted_brands = ['Supco'];
        public static array $manual_restricted_brands_for_sales_rep_domains = array( '@kunz-powell.com' => array('Metallics') );
        public static array $roles_restricted_for_sales_rep_domains_brands = array( 'shop_manager' );
        public static string $limited_rep_email_domain = '';
        private static Crown_Shop_Display $instance;

		public static function init() {
			if( self::$init ) return;
			self::$init = true;

            if ( defined( 'DISPLAY_INVENTORY_PRICE_FOR_NON_PURCHASABLE' ) ) {
                self::$display_inventory_price_for_non_purchasable = DISPLAY_INVENTORY_PRICE_FOR_NON_PURCHASABLE;
            }
            if ( defined( 'MANUAL_ALLOW_RESTRICTED_CUSTOMER_DIVISIONS' ) ) {
                self::$manual_allow_restricted_customer_divisions = MANUAL_ALLOW_RESTRICTED_CUSTOMER_DIVISIONS;
            }
            if ( defined( 'MANUAL_RESTRICTED_BRANDS' ) ) {
                self::$manual_restricted_brands = MANUAL_RESTRICTED_BRANDS;
            }
            if ( defined( 'MANUAL_RESTRICTED_BRANDS_FOR_SALES_REP_DOMAINS' ) ) {
                self::$manual_restricted_brands_for_sales_rep_domains = MANUAL_RESTRICTED_BRANDS_FOR_SALES_REP_DOMAINS;
            }
            if ( defined( 'ROLES_RESTRICTED_FOR_SALES_REP_DOMAINS_BRANDS' ) ) {
                self::$roles_restricted_for_sales_rep_domains_brands = ROLES_RESTRICTED_FOR_SALES_REP_DOMAINS_BRANDS;
            }

			add_action( 'woocommerce_loaded', array( __CLASS__, 'init_woocommerce_hooks' ) );
            add_action( 'woocommerce_get_endpoint_url', array(  __CLASS__, 'cart_endpoint_url' ), 10, 4 );
            add_filter( 'woocommerce_account_menu_items', array( __CLASS__, 'add_new_order_menu_item' ) );
            add_filter( 'woocommerce_is_purchasable', array( __CLASS__, 'is_product_allowed_for_purchase' ), 10, 2 );
            add_action('wp_footer', array(__CLASS__, 'cart_import_modal_render'));
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_scripts' ), 10 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'register_styles' ), 10 );
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_assets' ), 20 );

            add_action( 'in_admin_header',  array( __CLASS__, 'add_admin_panel_spinner') );
		}

		public static function init_woocommerce_hooks() {
			// global
			add_action( 'pre_get_posts', array( __CLASS__, 'pre_get_posts' ), 50 );
			add_action( 'woocommerce_before_main_content', function() { echo '<div id="main-content">'; }, 0 );
			add_action( 'woocommerce_before_main_content', array( __CLASS__, 'woocommerce_page_header' ), 5 );
			add_filter( 'crown_breadcrumb_items', array( __CLASS__, 'filter_crown_breadcrumb_items' ), 10 );
			add_action( 'woocommerce_before_main_content', function() { echo '<div class="wp-block-crown-blocks-page-section full-width woocommerce-wrap">'; }, 9 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			add_action( 'woocommerce_before_main_content', function() { echo '<div class="woocommerce-main"><div class="inner">'; }, 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			add_action( 'woocommerce_after_main_content', function() { echo '</div></div>'; }, 10 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
			remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
			add_action( 'woocommerce_sidebar',  array( __CLASS__, 'woocommerce_sidebar' ), 10 );
			add_action( 'woocommerce_sidebar', function() { echo '</div>'; }, 11 );
			add_action( 'woocommerce_sidebar', function() { echo '</div>'; }, 100 );

			// page headers
			// add_filter( 'woocommerce_show_page_title', '__return_false' );
			add_filter( 'woocommerce_page_title', array( __CLASS__, 'filter_woocommerce_page_title' ), 10 );
			remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );

			// product loop
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( __CLASS__, 'woocommerce_loop_product_thumbnail' ), 10 );
			add_filter( 'single_product_archive_thumbnail_size', function( $size ) { return 'medium'; }, 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( __CLASS__, 'woocommerce_after_shop_loop_item_title' ), 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			// single product
			add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'woocommerce_template_single_after_title' ), 6 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
            add_action( 'woocommerce_single_product_summary', array( __CLASS__ , 'woocommerce_template_single_price'), 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'woocommerce_template_single_excerpt' ), 20 );
			add_action( 'woocommerce_single_product_summary', array( __CLASS__, 'woocommerce_template_single_after_excerpt' ), 21 );
			if ( ! is_user_logged_in() ) remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			add_filter( 'woocommerce_get_stock_html', array( __CLASS__, 'filter_woocommerce_get_stock_html' ), 10, 2 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			add_action( 'woocommerce_after_single_product_summary', array( __CLASS__, 'woocommerce_output_product_data_tabs' ), 10 );
			add_filter( 'wc_product_enable_dimensions_display', '__return_false' );
			add_filter( 'woocommerce_display_product_attributes', array( __CLASS__, 'filter_woocommerce_display_product_attributes' ), 10, 2 );

			// product photos
			add_filter( 'woocommerce_product_get_image', array( __CLASS__, 'filter_woocommerce_product_get_image' ), 10, 6 );
            add_filter('woocommerce_product_get_gallery_image_ids', array( __CLASS__, 'custom_woocommerce_product_get_gallery_image_ids' ), 10, 2);
            add_filter( 'woocommerce_single_product_image_thumbnail_html', array( __CLASS__, 'filter_woocommerce_single_product_image_thumbnail_html' ), 10, 2 );
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			add_action( 'woocommerce_product_thumbnails', array( __CLASS__, 'woocommerce_show_product_thumbnails' ), 20 );

			// search results
			add_filter( 'relevanssi_match', array( __CLASS__, 'filter_relevanssi_match' ) );

			// cart
			add_action( 'woocommerce_before_cart', array( __CLASS__, 'woocommerce_before_cart' ) );
			add_action( 'woocommerce_cart_is_empty', array( __CLASS__, 'woocommerce_before_cart' ) );
			add_action( 'wp_loaded', array( __CLASS__, 'handle_add_sku_to_cart_submission' ), 15 );
			add_action( 'woocommerce_after_cart_item_name', array( __CLASS__, 'woocommerce_after_cart_item_name' ), 10, 2 );
			add_filter( 'woocommerce_cart_shipping_method_full_label', array( __CLASS__, 'filter_woocommerce_cart_shipping_method_full_label' ), 10, 2 );

			// checkout
			add_filter( 'woocommerce_checkout_fields', array( __CLASS__, 'filter_woocommerce_checkout_fields' ), 10, 1 );
			add_filter('woocommerce_form_field', array( __CLASS__, 'add_description_to_order_comments_field' ), 10, 4);
			add_filter( 'default_checkout_billing_email', array( __CLASS__, 'filter_default_checkout_billing_email' ), 10, 2 );
			add_filter( 'default_checkout_shipping_first_name', array( __CLASS__, 'filter_default_checkout_shipping_name' ), 10, 2 );
			add_filter( 'default_checkout_shipping_last_name', array( __CLASS__, 'filter_default_checkout_shipping_name' ), 10, 2 );

			// order summary
			add_action( 'woocommerce_order_item_meta_start', array( __CLASS__, 'woocommerce_order_item_meta_start' ), 10, 4 );

			// disable orders
			add_action( 'init', function() {
				if ( get_option( 'theme_config_shop_checkout_status' ) == 'disabled' ) {
					remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
					remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
					remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
					// add_action( 'woocommerce_before_main_content', array( __CLASS__, 'shop_disabled_notice' ), 5 );
					add_action( 'woocommerce_before_cart', array( __CLASS__, 'shop_disabled_notice' ), 5 );
					add_action( 'woocommerce_before_checkout_form', array( __CLASS__, 'shop_disabled_notice' ), 5 );
				}
			} );
			
            add_action( 'parse_tax_query', array(__CLASS__, 'change_product_brand_taxonomy_field'));
			add_action( 'wp_loaded', array( __CLASS__, 'remove_wp_ajax_order_logs_function' ), 900 );
            add_filter( 'woocommerce_product_tabs', array( __CLASS__, 'remove_reviews_tab' ), 98 );
            add_filter( 'woocommerce_get_availability_text', array( __CLASS__, 'dropship_items_availability_text'), 10, 2 );
		}

        public static function cart_endpoint_url( $url, $endpoint, $value, $permalink ) {
            if ( $endpoint === 'cart' ) {
                return wc_get_cart_url();
            }

            return $url;
        }

        public static function add_new_order_menu_item( $items ) {
            $current_user = wp_get_current_user();
            $allowed_roles = array(
                'customer',
            );
            if ( in_array( $current_user->roles[0], $allowed_roles ) ) {
                $new_order_item = array( 'cart' => esc_html__( 'New Order', 'woocommerce' ) );
                return array_slice($items, 0, 1, true) + $new_order_item + array_slice($items, 1, null, true);
            }
            return $items;
        }

		public static function remove_wp_ajax_order_logs_function() {
		    // Override the basic function that forms a list of orders in the TM Netsuite dashboard
            // so that to fix the search functionality (search by order number or any key word).
		    if ( class_exists('TMWNI_Admin_Loader') ) {
				remove_action('wp_ajax_order_logs', array( TMWNI_Admin_Loader::getInstance(),'getOrderLogs' ) );
				add_action('wp_ajax_order_logs', array(__CLASS__, 'getOrderLogsFiltered'), 40);
            }
		}

		public static function shop_disabled_notice() {
			wc_print_notice( 'Online orders are momentarily disabled. Please check back again later.', 'error');
		}


		public static function register_scripts() {
			wp_register_script( 'crown-shop-public', plugin_dir_url( __FILE__ ) . '/../../assets/dist/js/public.min.js', array( 'jquery' ), filemtime( dirname( __FILE__ ) . '/../assets/dist/js/public.min.js' ), true );
		}


		public static function register_styles() {
			wp_register_style( 'crown-shop-public', plugin_dir_url( __FILE__ ) . '/../../assets/dist/css/public.min.css', array(), filemtime( dirname( __FILE__ ) . '/../assets/dist/css/public.min.css' ) );
		}


		public static function load_assets() {
			wp_enqueue_script( 'crown-shop-public' );
			wp_enqueue_style( 'crown-shop-public' );
		}


		public static function pre_get_posts( $q ) {
			if ( ! $q->is_main_query() || is_admin() ) return;

			$product_taxonomies = get_object_taxonomies( 'product' );
			if ( $q->is_post_type_archive( 'product' ) || $q->is_tax( $product_taxonomies ) ) {
				$q->set( 'orderby', 'meta_value' );
				$q->set( 'meta_key', '_sku' );
				$q->set( 'order', 'ASC' );
				$tax_query = $q->get( 'tax_query' );
				if ( empty( $tax_query ) ) $tax_query = array();
				if ( is_tax('product_industry') ) {
					$term_ids = get_term_meta( $q->get_queried_object()->term_id, 'product_industry_product_categories', true );
					if ( ! empty( $term_ids ) ) {
						$q->set( 'product_industry', null );
						$tax_query[] = array( 'taxonomy' => 'product_cat', 'terms' => $term_ids );
					}
				}
				foreach ( $_GET as $k => $v ) {
					if ( in_array( $k, $product_taxonomies ) ) {
						$term_ids = array_filter( array_map( 'intval', explode( ',', $_GET[ $k ] ) ), function ( $n ) { return $n; } );
						if ( ! empty( $term_ids ) ) {
							$tax_query[] = array( 'taxonomy' => $k,  'terms' => $term_ids );
						}
					}
				}
				if ( isset( $_GET['product_category'] ) ) {
					$tax_query[] = array( 'taxonomy' => 'product_cat','terms' => intval( $_GET['product_category'] ) );
				}
				$q->set( 'tax_query', $tax_query );
			}
	

		}


		public static function woocommerce_page_header() {
			global $wp_query;

			$config = array(
				'title' => '',
				'content' => '',
				'image' => null,
				'cta_link' => array(
					'url' => '',
					'label' => 'Learn More'
				)
			);

			if ( is_product_category() ) {
				$term_id = $wp_query->get_queried_object()->term_id;
				$root_term = get_term( $term_id, 'product_cat' );
				while ( $root_term->parent != 0 ) {
					$root_term = get_term( $root_term->parent, 'product_cat' );
				}
				$config['title'] = $root_term->name;
				$config['content'] = $root_term->description;
				$config['image'] = get_term_meta( $root_term->term_id, 'product_cat_header_image', true );
				$config['cta_link']['url'] = get_term_meta( $root_term->term_id, 'product_cat_marketing_page_url', true );
			} else if ( is_tax('product_brand') ) {
				$term_id = $wp_query->get_queried_object()->term_id;
				$root_term = get_term( $term_id, 'product_brand' );
				$config['title'] = $root_term->name;
				$config['content'] = $root_term->description;
				$config['image'] = get_term_meta( $root_term->term_id, 'product_brand_header_image', true );
				$config['cta_link']['url'] = get_term_meta( $root_term->term_id, 'product_brand_marketing_page_url', true );
			} else if ( is_tax('product_industry') ) {
				$term_id = $wp_query->get_queried_object()->term_id;
				$root_term = get_term( $term_id, 'product_industry' );
				$config['title'] = $root_term->name;
				$config['content'] = $root_term->description;
				$config['image'] = get_term_meta( $root_term->term_id, 'product_industry_header_image', true );
				$config['cta_link']['url'] = get_term_meta( $root_term->term_id, 'product_industry_marketing_page_url', true );
			}

			?>
				<?php if ( ! empty( $config['title'] ) || ! empty( $config['content'] ) ) { ?>
					<div class="wp-block-crown-blocks-page-section-callout">
						<div class="inner">
							<?php if ( $config['image'] ) { ?>
								<div class="callout-image">
									<?php echo wp_get_attachment_image( $config['image'], 'large', false ); ?>
								</div>
							<?php } ?>
							<div class="callout-contents">
								<div class="inner">

									<?php if ( ! empty( $config['title'] ) ) { ?>
										<h1><?php echo $config['title']; ?></h1>
									<?php } ?>

									<?php if ( ! empty( $config['content'] ) ) { ?>
										<?php echo apply_filters( 'the_content', $config['content'] ); ?>
									<?php } ?>

									<?php if ( ! empty( $config['cta_link']['url'] ) ) { ?>
										<p><a href="<?php echo esc_attr( $config['cta_link']['url'] ); ?>" class="btn btn--white"><?php echo $config['cta_link']['label']; ?></a></p>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				
				<?php if ( class_exists( 'CrownBreadcrumbs' ) ) { ?>
					<div class="wp-block-crown-blocks-breadcrumbs">
						<?php echo CrownBreadcrumbs::getBreadcrumbs(); ?>
					</div>
				<?php } ?>
			<?php

		}


		public static function filter_crown_breadcrumb_items( $items ) {

			if ( is_singular( 'product' ) ) {
				$new_items = array();
				$primary_term_id = get_post_meta( get_the_ID(), '_primary_term_product_cat', true );
				$terms = wp_get_object_terms( get_the_ID(), 'product_cat', array( 'orderby' => 'term_order' ) );
				if ( ! empty( $terms ) ) {
					$primary_term = false;
					if ( ! empty( $primary_term_id ) ) {
						foreach ( $terms as $term ) {
							if ( $term->term_id == $primary_term_id ) {
								$primary_term = $term;
								break;
							}
						}
					}
					if ( ! $primary_term ) $primary_term = $terms[0];
					$new_items = CrownBreadcrumbs::getTermAncestorBreadcrumbItems( $primary_term->term_id, 'product_cat' );
					$new_items[] = array( 'tax' => 'product_cat', 'term' => $primary_term->term_id );
					array_splice( $items, -1, 0, $new_items );
				}
			}

			return $items;
		}


		public static function woocommerce_sidebar() {
			global $wp_query;

			if ( is_singular( 'product' ) ) return;

			echo '<div class="woocommerce-sidebar">';

			echo '<button class="sidebar-expander-toggle btn btn--black">Filter Options</button>';
			echo '<div class="sidebar-expander">';

			// category filters
			if ( is_shop() || is_product_category() || is_tax('product_brand') || is_tax('product_industry') ) {
				$parent = is_product_category() ? $wp_query->get_queried_object()->term_id : 0;
				if ( isset( $_GET['product_category'] ) ) $parent = intval( $_GET['product_category'] );
				if ( is_tax('product_industry') && empty( $parent ) ) {
					$term_ids = get_term_meta( $wp_query->get_queried_object()->term_id, 'product_industry_product_categories', true );
					if ( ! empty( $term_ids ) ) {
						echo '<div class="widget product-categories">';
						echo '<h3 class="widget-title">Category</h3>';
						echo '<ul>';
						foreach ( $term_ids as $term_id ) {
							$category = get_term( $term_id, 'product_cat' );
							if ( ! $category ) continue;
							$link = get_term_link( $category, 'product_cat' ) . ( ! empty( $_GET ) ? '?' . http_build_query( $_GET ) : '' );
							echo '<li>';
							echo '<a class="label" href="' . $link . '">' . $category->name . '</a>';
							self::output_product_categories_list( $category->term_id );
							echo '</li>';
						}
						echo '</ul>';
						echo '</div>';
					}
				} else if ( is_tax('product_brand') ) {
					$filtered_term_ids = self::get_posts_of_term_term_ids( $wp_query->get_queried_object()->term_id, 'product_brand', 'product_cat' );
					$root_term_ids = self::get_root_term_ids( $filtered_term_ids, 'product_cat', $parent );
					if ( ! empty( $root_term_ids ) ) {
						echo '<div class="widget product-categories">';
						echo '<h3 class="widget-title">Category</h3>';
						echo '<ul>';
						foreach ( $root_term_ids as $term_id ) {
							$category = get_term( $term_id, 'product_cat' );
							if ( ! $category ) continue;
							$link = add_query_arg( 'product_category', $term_id );
							echo '<li>';
							echo '<a class="label" href="' . $link . '">' . $category->name . '</a>';
							self::output_product_categories_list( $category->term_id, $filtered_term_ids );
							echo '</li>';
						}
						echo '</ul>';
						echo '</div>';
					}
				} else if ( ! empty( get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $parent, 'fields' => 'ids' ) ) ) ) {
					echo '<div class="widget product-categories">';
					echo '<h3 class="widget-title">Category</h3>';
					self::output_product_categories_list( $parent );
					echo '</div>';
				}
			}

			// attribute filters
			if ( is_shop() || is_product_category() || is_tax('product_brand') || is_tax('product_industry') ) {
				echo '<div class="widget product-filters">';
				echo '<h3 class="widget-title">Filters</h3>';
				self::output_product_attributes_list();
				echo '</div>';
			}

			echo '</div>';

			echo '</div>';

		}

		protected static function output_product_categories_list( $parent = 0, $filtered_term_ids = array() ) {
			$categories = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $parent ) );
			if ( ! empty( $filtered_term_ids ) ) {
				$category_ids = self::get_root_term_ids( $filtered_term_ids, 'product_cat', $parent );
				$categories = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $parent, 'include' => $category_ids ) );
			}
			if ( ! empty( $categories ) ) {
				echo '<ul>';
				foreach ( $categories as $category ) {
					$link = get_term_link( $category, 'product_cat' ) . ( ! empty( $_GET ) ? '?' . http_build_query( $_GET ) : '' );
					if ( is_tax('product_brand') ) {
						$link = add_query_arg( 'product_category', $category->term_id );
					}
					echo '<li>';
					echo '<a class="label" href="' . $link . '">' . $category->name . '</a>';
					self::output_product_categories_list( $category->term_id, $filtered_term_ids );
					echo '</li>';
				}
				echo '</ul>';
			}
		}

		public static function get_attribute_filter_taxonomies_to_display( $root_cat_term = null ) {
			$taxonomies_to_display = array();
			if ( $root_cat_term ) {
				if ( $root_cat_term->name == 'Power Connectors and Grounding' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_finish', 'pa_color', 'pa_conductor_type', 'pa_conductors_count', 'pa_wire_range', 'pa_assortment', 'pa_type', 'pa_application', 'pa_die_color_code' ) );
				} else if ( $root_cat_term->name == 'Cable and Conduit Fittings' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_assortment' ) );
				} else if ( $root_cat_term->name == 'Switches and Controls' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_color', 'pa_assortment', 'pa_style', 'pa_type' ) );
				} else if ( $root_cat_term->name == 'Wire and Cable Management' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_finish', 'pa_color', 'pa_assortment', 'pa_application' ) );
				} else if ( $root_cat_term->name == 'Tools, Testers and Specialty Products' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_assortment' ) );
				} else if ( $root_cat_term->name == 'Electrical Hardware and Supplies' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_finish', 'pa_color', 'pa_wire_type', 'pa_wire_range', 'pa_assortment', 'pa_application' ) );
				} else if ( $root_cat_term->name == 'Safety Protection' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_finish', 'pa_color', 'pa_cut_level', 'pa_assortment', 'pa_application' ) );
				}
			}
			return $taxonomies_to_display;
		}

		protected static function output_product_attributes_list() {
			global $wp_query;

			$taxonomies_to_display = array();

			if ( is_tax('product_brand') ) {
				$term = get_queried_object();
				if ( $term->name == 'Polaris' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_finish', 'pa_color', 'pa_conductor_type', 'pa_conductors_count', 'pa_wire_range', 'pa_assortment', 'pa_type', 'pa_application', 'pa_die_color_code' ) );
				} else if ( $term->name == 'TORK' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_color', 'pa_assortment', 'pa_style', 'pa_type' ) );
				} else if ( $term->name == 'RHINO Safety' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_finish', 'pa_color', 'pa_cut_level', 'pa_assortment', 'pa_application' ) );
				} else if ( $term->name == 'WarriorWrap' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_color', 'pa_assortment', 'pa_application' ) );
				} else if ( $term->name == 'TERMINATOR' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_color', 'pa_wire_type', 'pa_wire_range', 'pa_application' ) );
				} else if ( $term->name == 'Easy-Twist' ) {
					$taxonomies_to_display = array_merge( $taxonomies_to_display, array( 'pa_material', 'pa_color', 'pa_wire_type', 'pa_wire_range', 'pa_application' ) );
				}
			} else {
				$taxonomies_to_display[] = 'product_brand';
			}

			if ( is_tax( 'product_cat' ) ) {
				$root_term = get_queried_object();
				while ( $root_term->parent != 0 ) {
					$root_term = get_term( $root_term->parent, 'product_cat' );
				}
				$taxonomies_to_display = array_merge( $taxonomies_to_display, self::get_attribute_filter_taxonomies_to_display( $root_term ) );
			}
			

			$attribute_ids = wc_get_attribute_taxonomy_ids();
			echo '<ul>';
			foreach ( $taxonomies_to_display as $taxonomy_name ) {
				$config = array(
					'title' => '',
					'taxonomy' => $taxonomy_name,
					'terms' => array()
				);
				if ( preg_match( '/^pa_(.+)/', $taxonomy_name, $matches ) ) {
					$attribute_id = array_key_exists( $matches[1], $attribute_ids ) ? $attribute_ids[ $matches[1] ] : null;
					if ( $attribute_id ) {
						$attribute = wc_get_attribute( $attribute_id );
						$config['title'] = ucwords( preg_replace( '/\s*_\s*/', ' ', $attribute->name ) );
						if ( is_tax( 'product_cat' ) || is_tax( 'product_brand' ) ) {
							$term_ids = array();
							if ( is_tax( 'product_cat' ) ) {
								$cat_term = get_queried_object();
								$term_ids = self::get_posts_of_term_term_ids( $cat_term->term_id, 'product_cat', $taxonomy_name );
							} else if ( is_tax( 'product_brand' ) ) {
								$brand_term = get_queried_object();
								$term_ids = self::get_posts_of_term_term_ids( $brand_term->term_id, 'product_brand', $taxonomy_name );
								if ( isset( $_GET['product_category'] ) ) {
									$term_ids = array_intersect( $term_ids, self::get_posts_of_term_term_ids( intval( $_GET['product_category'] ), 'product_cat', $taxonomy_name ) );
								}
							}
							$config['terms'] = $term_ids ? get_terms( array( 'taxonomy' => $taxonomy_name, 'include' => $term_ids ) ) : array();
						} else {
							$config['terms'] = get_terms( array( 'taxonomy' => $taxonomy_name ) );
						}
					}
				} else {
					$taxonomy = get_taxonomy( $taxonomy_name );
					if ( $taxonomy ) {
						$config['title'] = $taxonomy->label;
						if ( is_tax( 'product_cat' ) ) {
							$cat_term = get_queried_object();
							$term_ids = self::get_posts_of_term_term_ids( $cat_term->term_id, 'product_cat', $taxonomy_name );
							$config['terms'] = $term_ids ? get_terms( array( 'taxonomy' => $taxonomy_name, 'include' => $term_ids ) ) : array();
						} else {
							$config['terms'] = get_terms( array( 'taxonomy' => $taxonomy_name ) );
						}
					}
				}
				if ( ! empty( $config['terms'] ) ) {
					$queried_options = array();
					if ( isset( $_GET[ $config['taxonomy'] ] ) && ! empty( $_GET[ $config['taxonomy'] ] ) ) {
						$queried_options = array_filter( array_map( 'intval', explode( ',', $_GET[ $config['taxonomy'] ] ) ), function ( $n ) { return $n; } );
					}
					echo '<li class="' . $config['taxonomy'] . '">';
					echo '<span class="label">' . $config['title'] . '</span>';
					echo '<ul>';
					foreach ( $config['terms'] as $term ) {
						$var_values = array_merge( $queried_options, array( $term->term_id ) );
						if ( in_array( $term->term_id, $queried_options ) ) {
							$var_values = $queried_options;
							unset( $var_values[ array_search( $term->term_id, $var_values ) ] );
						}
						echo '<li class="' . ( in_array( $term->term_id, $queried_options ) ? 'active' : '' ) . '">';
						echo '<a href="' . add_query_arg( $term->taxonomy, $var_values ? implode( ',', $var_values ) : false ) . '">' . $term->name . '</a>';
						echo '</li>';
					}
					echo '</ul>';
					echo '</li>';
				}
			}
			echo '</ul>';
		}


		public static function get_posts_of_term_term_ids( $search_term_ids, $search_taxonomy, $taxonomy, $include_children = true ) {
			global $wpdb;
			$search_term_ids = (array) $search_term_ids;
			if ( $include_children ) {
				$child_terms = array();
				foreach ( $search_term_ids as $search_term_id ) {
					$child_terms = array_merge( $child_terms, get_term_children( $search_term_id, $search_taxonomy ) );
				}
				$search_term_ids = array_unique( array_merge( $search_term_ids, $child_terms ) );
			}
			$search_term_ids_in = "'" . implode( "', '", array_map( 'esc_sql', $search_term_ids ) ) . "'";
			$term_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT terms2.term_id
				FROM
					$wpdb->posts as p1
					LEFT JOIN $wpdb->term_relationships as r1 ON p1.ID = r1.object_ID
					LEFT JOIN $wpdb->term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id
					LEFT JOIN $wpdb->terms as terms1 ON t1.term_id = terms1.term_id,
		
					$wpdb->posts as p2
					LEFT JOIN $wpdb->term_relationships as r2 ON p2.ID = r2.object_ID
					LEFT JOIN $wpdb->term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id
					LEFT JOIN $wpdb->terms as terms2 ON t2.term_id = terms2.term_id
				WHERE
					t1.taxonomy = '%s' AND p1.post_status = 'publish' AND terms1.term_id IN ( $search_term_ids_in ) AND
					t2.taxonomy = '%s' AND p2.post_status = 'publish'
					AND p1.ID = p2.ID
				ORDER by terms2.name", array( $search_taxonomy, $taxonomy ) ) );
			return $term_ids;
		}


		protected static function get_root_term_ids( $child_term_ids, $taxonomy, $root_parent_id = 0 ) {
			$root_terms = array();
			foreach ( $child_term_ids as $child_term_id ) {
				$root_term = get_term( $child_term_id, $taxonomy );
				while ( $root_term->parent != 0 && $root_term->parent != $root_parent_id ) {
					$root_term = get_term( $root_term->parent, $taxonomy );
				}
				if ( $root_term->parent == $root_parent_id ) $root_terms[] = $root_term;
			}
			usort( $root_terms, function( $a, $b ) { return strcmp( $a->name, $b->name ); } );
			return array_unique( array_map( function( $n ) { return $n->term_id; }, $root_terms ) );
		}


		public static function filter_woocommerce_page_title( $title ) {
			$new_title = $title;
			if ( is_tax() ) {
				$new_title = 'All ' . $title;
			}
			if ( isset( $_GET['product_category'] ) ) {
				$term = get_term( $_GET['product_category'], 'product_cat' );
				if ( $term ) {
					$new_title = $title . ': ' . $term->name;
				}
			}
			return $new_title;
		}


		public static function woocommerce_loop_product_thumbnail() {
			?>
				<div class="woocommerce-loop-product__thumbnail">
					<?php echo woocommerce_get_product_thumbnail(); ?>
				</div>
			<?php
		}


		public static function woocommerce_after_shop_loop_item_title() {
			global $product;

			$sku = $product->get_sku();
			if ( ! empty( $sku ) ) {
				echo '<span class="sku">#' . $sku . '</span>';
			}

			$atts = array();
			$attributes_to_display = array( 'voltage_rating', 'dimensions' );
			$attributes = $product->get_attributes();
			foreach ( $attributes_to_display as $slug ) {
				$sub_attributes_to_display = array();
				if ( $slug == 'dimensions' ) {
					$sub_attributes_to_display = array( 'width', 'length', 'height' );
				}
				if ( ! empty( $sub_attributes_to_display ) ) {
					$sub_atts = array();
					foreach ( $sub_attributes_to_display as $slug2 ) {
						if ( array_key_exists( 'pa_' . $slug2, $attributes ) ) {
							$attribute = $attributes[ 'pa_' . $slug2 ];
							$terms = $attribute->get_terms();
							if ( ! empty( $terms ) ) {
								$sub_atts[] = '<span class="attr-' . $slug . '">' . implode( ', ', wp_list_pluck( $terms, 'name' ) ) . '</span>';
							}
						}
					}
					if ( ! empty( $sub_atts ) ) {
						$sep = '';
						if ( $slug == 'dimensions' ) $sep = ' &times; ';
						$atts[] = '<span class="attr-' . $slug . '">' . implode( $sep, $sub_atts ) . '</span>';
					}
				} else if ( array_key_exists( 'pa_' . $slug, $attributes ) ) {
					$attribute = $attributes[ 'pa_' . $slug ];
					$terms = $attribute->get_terms();
					if ( ! empty( $terms ) ) {
						$atts[] = '<span class="attr-' . $slug . '">' . implode( ', ', wp_list_pluck( $terms, 'name' ) ) . '</span>';
					}
				}
			}
			if ( ! empty( $atts ) ) {
				echo '<div class="attributes">' . implode( ', ', $atts ) . '</div>';
			}
			// print_r($attributes);

		}


		public static function woocommerce_template_single_after_title() {
			global $product;

			// if ( defined( 'TMWNI_DIR' ) ) {
			// 	require_once(TMWNI_DIR . 'inc/item.php');
			// 	$netsuiteClient = new ItemClient();
			// 	$netsuiteClient->searchItemUpdateInventory( $product->get_sku(), $product->get_id() );
			// }

			echo get_the_term_list( get_the_ID(), 'product_cat', '<p class="entry-categories">', ', ', '</p>' );

			$sku = $product->get_sku();
			if ( ! empty( $sku ) ) {
				echo '<p class="entry-sku">#' . $sku . '</p>';
			}

		}
        public static function is_product_purchasable() {
            global $product;
            return ( !empty($product) && $product->is_purchasable() );
        }

        public static function is_zero_product_price() {
            global $product;
            return ( !empty($product) && $product->get_price() == 0 );
        }

        public static function is_product_restricted() {
            global $product;
            return !empty($product) && $product->get_meta('ns_restricted_item_flag') === 'yes';
        }

        public static function is_product_restricted_for_current_user() {
            global $product;
            return !empty($product) && $product->get_meta('ns_restricted_item_flag') === 'yes'
                    && !(get_user_meta( get_current_user_id(), 'ns_allow_restricted_items', true ) === '1');
        }

        public static function is_product_in_manual_restricted_list() {
            global $product;
            return !empty($product) && in_array( $product->get_meta('product_brand'), self::$manual_restricted_brands );
        }

        public static function is_product_allowed_for_purchase($is_purchasable, $product) {
            $user = wp_get_current_user();
            self::$product_in_manual_restricted_brands_for_sales_rep_domains_list = self::is_product_in_manual_restricted_brands_for_sales_rep_domains_list( $product, $user );
            self::$is_product_allowed_for_dual_shop_manager = self::is_product_allowed_for_dual_shop_manager( $product );
            return $is_purchasable && ! self::$product_in_manual_restricted_brands_for_sales_rep_domains_list && self::$is_product_allowed_for_dual_shop_manager;
        }

        public static function is_product_in_manual_restricted_brands_for_sales_rep_domains_list($product, $user) {
            if ( empty( $product ) ) {
                return false;
            }
            if ( ! isset( $user->roles[0] ) ) {
                return false;
            }
            if ( in_array( $user->roles[0], self::$roles_restricted_for_sales_rep_domains_brands ) ) {
                $rep_email_domain = self::get_user_mail_domain($user->user_email);
                if ( ! empty( $rep_email_domain ) && isset(self::$manual_restricted_brands_for_sales_rep_domains[ $rep_email_domain ] ) ) {
                    return in_array( $product->get_meta('product_brand'), self::$manual_restricted_brands_for_sales_rep_domains[ $rep_email_domain ] );
                }
            } elseif ( $user->roles[0] === 'customer' && self::is_customer_switched_from_limited_access_acount( $user->ID ) ) {
                return in_array( $product->get_meta('product_brand'), self::$manual_restricted_brands_for_sales_rep_domains[ self::$limited_rep_email_domain ] );
            }
            return false;
        }

        public static function is_customer_switched_from_limited_access_acount($current_user_id) {
            $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
            $admin_user = get_user_by( 'id', $admin_id );
            if (
                Nsi_Helper::is_admin_session_set()
                && $current_user_id != $admin_id && $admin_id != 0
                && isset( $admin_user->roles[0] ) && in_array( $admin_user->roles[0], self::$roles_restricted_for_sales_rep_domains_brands )
            ) {
                $rep_email_domain = self::get_user_mail_domain($admin_user->user_email);
                if ( ! empty( $rep_email_domain ) && isset(self::$manual_restricted_brands_for_sales_rep_domains[ $rep_email_domain ] ) ) {
                    self::$limited_rep_email_domain = $rep_email_domain;
                    return true;
                }
            }
            return false;
        }

        public static function get_original_switched_user( $current_user_id ) {
            $admin_id = isset( $_COOKIE['sac_admin_id'] ) ? $_COOKIE['sac_admin_id'] : 0;
            $admin_user = get_user_by( 'id', $admin_id );
            if (
                Nsi_Helper::is_admin_session_set()
                && $current_user_id != $admin_id && $admin_id != 0
            ) {
                return $admin_user;
            }
            return false;
        }

        public static function is_product_allowed_for_dual_shop_manager( $product ) {
            $current_user = wp_get_current_user();
            if ( $current_user == null ) {
                return true;
            }

            $switched_user = self::get_original_switched_user( $current_user->ID );
            if ( $switched_user && isset($switched_user->roles[0]) && $switched_user->roles[0] == 'dual_shop_manager' ) {
                $dsm_allowed_brands = get_dual_shop_manager_allowed_brands( $switched_user );
                $product_brand = $product->get_meta('product_brand');
                return in_array( $product_brand, $dsm_allowed_brands );
            }

            if ( isset($current_user->roles) && $current_user->roles[0] == 'dual_shop_manager' ) {
                $dsm_allowed_brands = get_dual_shop_manager_allowed_brands( $current_user );
                $product_brand = $product->get_meta('product_brand');
                return in_array( $product_brand, $dsm_allowed_brands );
            }

            return true;
        }

        public static function get_user_mail_domain($user_email) {
            $email_domain = '';
            if ( preg_match( '/(@[^,;\s]+)/', $user_email, $matches ) ) {
                $email_domain = $matches[1];
            }
            return $email_domain;
        }

        public static function is_customer_in_manual_allow_list() {
            return in_array( get_user_meta(get_current_user_id(), 'ns_division_name', true), self::$manual_allow_restricted_customer_divisions );
        }

        public static function is_product_manually_allowed() {
            return self::is_product_in_manual_restricted_list() && self::is_customer_in_manual_allow_list();
        }

        public static function woocommerce_template_single_price() {
            if (is_user_logged_in()
                && (self::is_product_purchasable()
                    || (!self::is_zero_product_price()
                        && ! self::$product_in_manual_restricted_brands_for_sales_rep_domains_list
                        && self::$is_product_allowed_for_dual_shop_manager
                        && ((self::is_product_restricted() && !self::is_product_restricted_for_current_user())
                            || (self::$display_inventory_price_for_non_purchasable && self::is_product_manually_allowed()))
                    )
                )
            ) {
                self::woocommerce_template_before_single_price();
                self::woocommerce_template_after_single_price();
            }
        }

		public static function woocommerce_template_before_single_price() {
			global $product;
			$price_html = $product->get_price_html();
			$price_qty_multiplier = get_post_meta( get_the_ID(), 'ns_price_qty_multiplier', true );
			$price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
			if ( $price_qty_multiplier != 1 && preg_match( '/>(\d+(?:\.\d+)?)/', $price_html, $matches ) ) {
				$product_price = wc_get_price_excluding_tax( $product );
				$price_html = preg_replace( '/>\d+(\.\d+)?/', '>' . number_format( $product_price * $price_qty_multiplier, 2 ), $price_html );
			}
			echo '<p class="' . esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ) . '">' . $price_html . '</p>';
		}


		public static function woocommerce_template_after_single_price() {
			$price_qty_multiplier = get_post_meta( get_the_ID(), 'ns_price_qty_multiplier', true );
			$price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
			if ( $price_qty_multiplier != 1 ) {
				echo '<p class="price-qty" style="margin-top: -1rem; color: #77a464;">Price per ' . $price_qty_multiplier . '</p>';
			}
		}


		public static function woocommerce_template_single_excerpt() {
			the_excerpt();
		}


		public static function woocommerce_template_single_after_excerpt() {

			$features = array();
			for ( $i = 1; $i <= 17; $i++ ) {
				$feature = get_post_meta( get_the_ID(), 'product_feature_' . $i, true );
				if ( ! empty( $feature ) ) $features[] = '<li>' . $feature . '</li>';
			}
			if ( ! empty( $features ) ) {
				echo '<ul class="entry-features">' . implode( '', $features ) . '</ul>';
			}

		}


		public static function filter_woocommerce_get_stock_html( $html, $product ) {
			$excluded_brands = get_option('ns_inventory_settings_excluded_brands', []);

			if ($excluded_brands) {
				$product_brands = wp_get_post_terms(
					$product->get_id(),
					'product_brand',
					['fields' => 'slugs']
				);
				
				if (array_intersect($excluded_brands, $product_brands)) {
					return '';
				}
			}

            if ( self::is_dropship_item_inventory( $product ) ) {
                return $html;
            }

			$availability = $product->get_availability();
			if ( empty( $availability['availability'] ) ) {
				$html = '<p class="stock ' . $availability['class'] . '">Please contact customer service for availability.</p>';
			}
			return $html;
		}

        public static function is_dropship_item_inventory($product) {
            $is_dropship_item = get_post_meta( $product->get_id(), 'ns_dropship_item_flag', true ) ?? 'no';
            $dropship_brands = defined('BRANDS_GET_DATA_FROM_DROPSHIP_INVENTORY_TABLE') ? BRANDS_GET_DATA_FROM_DROPSHIP_INVENTORY_TABLE : array('Remke', 'Metallics');
            if ( $is_dropship_item == 'yes' && in_array( $product->get_meta('product_brand'), $dropship_brands ) ) {
                return TRUE;
            }
            return FALSE;
        }

		public static function woocommerce_output_product_data_tabs() {
			global $product;
			$docs = get_post_meta( get_the_ID(), 'product_doc_data', true );
            $docs = is_array($docs) ? $docs : (is_string($docs) ? [$docs] : []);
			$videos = get_post_meta( get_the_ID(), 'product_video_data', true );
            $videos = is_array($videos) ? $videos : (is_string($videos) ? [$videos] : []);
            ?>
				<div class="wp-block-crown-blocks-tabbed-content is-style-boxed">
					<div class="inner">
						<div class="tabbed-content-tabs">
							<div class="inner">

								<div class="wp-block-crown-blocks-tabbed-content-tab attributes">
									<div class="inner">
										<header class="tab-header">
											<h3 class="tab-title">Product Information</h3>
										</header>
										<div class="tab-contents">
											<div class="inner">
												<?php wc_display_product_attributes( $product ); ?>
											</div>
										</div>
									</div>
								</div>

								<div class="wp-block-crown-blocks-tabbed-content-tab">
									<div class="inner">
										<header class="tab-header">
											<h3 class="tab-title">Resources</h3>
										</header>
										<div class="tab-contents">
											<div class="inner">
												
												<div class="entry-resources">

													<?php if ( ! empty( $docs ) ) { ?>
														<div class="entry-documents">
															<h4>Documents</h4>
															<ul>
																<?php foreach ( $docs as $i => $doc ) {
                                                                        $doc_name = isset($doc['filename']) ? $doc['filename'] : 'Document' . $i + 1;
                                                                        $doc_src = isset($doc['src']) ? $doc['src'] : $doc;
                                                                    ?>
																	<li>
																		<span class="name"><?php echo $doc_name; ?></span>
																		<span class="download"><a href="<?php echo self::convert_amplifi_cdn_src( $doc_src ); ?>" target="_blank" class="btn btn--outline btn--outline-black">Download</a></span>
																	</li>
																<?php } ?>
															</ul>
														</div>
													<?php } ?>
													
												</div>
                                                <div class="entry-resources">
													<?php if ( ! empty( $videos ) ) { ?>
                                                        <div class="entry-documents">
                                                            <h4>Video resources</h4>
                                                            <ul>
																<?php foreach ( $videos as $i => $video ) {
                                                                    $video_filename = isset($video['filename']) ? $video['filename'] : 'Video ' . $i + 1;
                                                                    $video_src = isset($video['src']) ? $video['src'] : $video;
                                                                    ?>
                                                                    <li>
                                                                        <span class="name"><?php echo $video_filename; ?></span>
                                                                        <span class="download"><a href="<?php echo self::convert_amplifi_cdn_src( $video_src ); ?>" target="_blank" class="btn btn--outline btn--outline-black">View video</a></span>
                                                                    </li>
																<?php } ?>
                                                            </ul>
                                                        </div>
													<?php } ?>
                                                </div>

											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			<?php
		}


		public static function filter_woocommerce_display_product_attributes( $product_attributes, $product ) {
            $not_processed_attributes = $product_attributes;

			$ordered_hidden_attributes = array(
				'pa_pack_weight' => true,
				'pa_pack_width' => true,
				'pa_pack_length' => true,
				'pa_pack_height' => true,
				'pa_weight' => true,
				'pa_width' => true,
				'pa_length' => true,
				'pa_height' => true,
				'pa_depth' => true,
				'pa_case_weight' => true,
				'pa_case_width' => true,
				'pa_case_length' => true,
				'pa_case_height' => true,
				'pa_inner_weight' => true,
				'pa_inner_width' => true,
				'pa_inner_length' => true,
				'pa_inner_height' => true,
				'pa_warranty' => true,
				'pa_is_custom' => true,
				'pa_unit_measure' => true,
				'pa_voltage_rating' => false,
				'pa_pack_type' => true,
				'pa_material' => false,
				'pa_finish' => false,
				'pa_color' => false,
				'pa_manufacturer' => true,
				'pa_pack_qty' => false,
				'pa_case_qty' => true,
				'pa_min_qty' => true,
				'product_gtin' => false,
				'product_upc' => false,
				'product_ean' => false,
				'pa_unspsc' => false,
				'pa_origin_country' => false,
				'pa_codes' => false,
				'pa_certifications' => false,
				'pa_ampacity' => false,
				'pa_ul_standard' => false,
				'pa_ce_cert' => false,
				'pa_iso_rating' => false,
				'pa_apparel_size' => false,
				'pa_cut_level' => false,
				'pa_csa_standard' => false,
				'pa_min_install_temp' => false,
				'pa_conductor_range' => false,
				'pa_cable_conduit_type' => false,
				'pa_trade_size' => false,
				'pa_huskie_die' => false,
				'pa_huskie_tools' => false,
				'pa_tb_die' => false,
				'pa_tb_tools' => false,
				'pa_burndy_die' => false,
				'pa_burndy_tools' => false,
				'pa_ilsco_die' => false,
				'pa_ilsco_tools' => false,
				'pa_greenlee_die' => false,
				'pa_greenlee_tools' => false,
				'pa_nsi_die' => false,
				'pa_nsi_tools' => false,
				'pa_barrel_inside_diameter' => false,
				'pa_barrel_outside_diameter' => false,
				'pa_ul_file_no' => false,
				'pa_actuator' => false,
				'pa_contact_rating' => false,
				'pa_contact_config' => false,
				'pa_water_absorbtion' => false,
				'pa_decibels' => false,
				'pa_input_current' => false,
				'pa_lamp_count' => false,
				'pa_wattage' => false,
				'pa_mounting' => false,
				'pa_wire_type' => false,
				'pa_body_length' => false,
				'pa_pin_length' => false,
				'pa_pin_size' => false,
				'pa_stud_terminal_size' => false,
				'pa_wire_cable_class' => false,
				'pa_ansi' => false,
				'pa_al_conductor_max_amp' => false,
				'pa_cu_conductor_max_amp' => false,
				'pa_conductor_cu_size_range' => false,
				'pa_conductor_al_size_range' => false,
				'pa_conductor_type' => false,
				'pa_tang_thickness' => false,
				'pa_tang_length' => false,
				'pa_temp_rating' => false,
				'pa_mounting_hole_pos' => false,
				'pa_hole_spacing' => false,
				'pa_hole_count' => false,
				'pa_conductors_count' => false,
				'pa_pipe_size' => false,
				'pa_dielectric' => false,
				'pa_tensile_strength' => false,
				'pa_max_bundle_diameter' => false,
				'pa_hex_wrengh_size' => false,
				'pa_die_size' => false,
				'pa_tap_color_code' => false,
				'pa_tap_wire_size' => false,
				'pa_tap_acsr' => false,
				'pa_main_color_code' => false,
				'pa_main_wire_size' => false,
				'pa_main_ascr' => false,
				'pa_product_series' => true,
				'pa_wire_range' => false,
				'pa_env_temp' => false,
				'pa_assortment' => false,
				'pa_style' => false,
				'pa_type' => false,
				'pa_trade_name' => false,
				'pa_spec' => false,
				'pa_overall_length' => false,
				'pa_jaw_thickness' => false,
				'pa_jaw_length' => false,
				'pa_jaw_width' => false,
				'pa_jaw_pos' => false,
				'pa_jaw_opening' => false,
				'pa_tip_size' => false,
				'pa_handle_type' => false,
				'pa_thread_size' => false,
				'pa_application' => false,
				'pa_diameter' => false,
				'pa_ring_diameter' => false,
				'pa_handle_color' => false,
				'pa_wire_diameter' => false,
				'pa_shearing_size' => false,
				'pa_blade_length' => false,
				'pa_model_compatibility' => false,
				'pa_connection_type' => false,
				'pa_handle_material' => false,
				'pa_capacity' => false,
				'pa_blade_type' => false,
				'pa_contents' => false,
				'pa_body_material' => false,
				'pa_power_supply' => false,
				'pa_display_type' => false,
				'pa_expanded_wire_range' => false,
				'pa_outside_diameter' => false,
				'pa_inside_diameter' => false,
				'pa_cable_diameter' => false,
				'pa_die_color_code' => false,
				'pa_mounting_bolt_size' => false,
				'pa_mounting_hole_diameter' => false,
				'pa_max_torque' => false,
				'pa_resistive_rating' => false,
				'pa_tungsten_rating' => false,
				'pa_led_ballast' => false,
				'pa_motor_rating' => false,
				'pa_power_consumption' => false,
				'pa_ballast_rating' => false,
				'pa_insulation_type' => false,
				'pa_pin_diameter' => false,
				'pa_elongation' => false,
				'pa_frequency_rating' => false,
				'pa_nominal_size' => false,
				'pa_care' => false,
				'pa_construction' => false,
				'pa_barrel_length' => false,
				'pa_max_insulated_wire_diameter' => false,
				'pa_max_cable_outer_diameter' => false,
				'pa_attenuation' => false,
				'pa_cable_connectors_side_a' => false,
				'pa_cable_connectors_side_b' => false,
				'pa_cable_jacket_construction' => false,
				'pa_cable_shielding' => false,
				'pa_cable_type' => false,
				'pa_chipset' => false,
				'pa_connector_style' => false,
				'pa_connector_termination' => false,
				'pa_connector_type' => false,
				'pa_data_interface' => false,
				'pa_data_rate' => false,
				'pa_digital_optical_monitoring' => false,
				'pa_fiber_optic_cable_type' => false,
				'pa_hook_size_in' => false,
				'pa_locking' => false,
				'pa_max_resolution' => false,
				'pa_memory_dimm_type' => false,
				'pa_memory_ranking' => false,
				'pa_memory_size' => false,
				'pa_memory_speed' => false,
				'pa_mperge' => false,
				'pa_number_of_ports' => false,
				'pa_panel_insert_slots' => false,
				'pa_panel_insert_type' => false,
				'pa_poe' => false,
				'pa_port_type' => false,
				'pa_rack_spaces' => false,
				'pa_rg_type' => false,
				'pa_split_ratio' => false,
				'pa_splitter_in_out' => false,
				'pa_strand_conductor_count' => false,
				'pa_usb_type' => false,
				'pa_voltage' => false,
				'pa_wavelength' => false,
				'pa_cable_length' => false,
				'pa_compatibility' => false,
			);

			$filtered_attributes = array();
			$replacements = array(
				'/^Gtin$/' => 'GTIN',
				'/^Upc$/' => 'UPC',
				'/^Ean$/' => 'EAN',
				'/^Unspsc$/' => 'UNSPSC',
				'/^Poe$/' => 'POE'
			);


			foreach ( array_keys( $ordered_hidden_attributes ) as $key ) {
				if ( $ordered_hidden_attributes[ $key ] ) {
                    continue;
                }
                if ( preg_match( '/^pa_/', $key ) ) {
					$tax = 'attribute_' . $key;
					if ( array_key_exists( $tax, $product_attributes ) ) {
						$attribute = $product_attributes[ $tax ];
                        unset( $not_processed_attributes[$tax] );
						if ( empty( trim( $attribute['value'] ) ) ) continue;
						$attribute['value'] = make_clickable( $attribute['value'] );
						$attribute['value'] = strip_tags( $attribute['value'], array( '<a>' ) );
						$attribute['label'] = ucwords( preg_replace( '/\s*_\s*/', ' ', $attribute['label'] ) );
						$attribute['label'] = preg_replace( array_keys( $replacements ), array_values( $replacements ), $attribute['label'] );
						$filtered_attributes[ $tax ] = $attribute;
					}
                } else {
					$value = get_post_meta( get_the_ID(), $key, true );
                    if ($value) {
						$attribute['value'] = $value;
						$label = preg_replace('/^product_/', '', $key);
						$attribute['label'] = ucwords( preg_replace( '/\s*_\s*/', ' ', $label ) );
						$attribute['label'] = preg_replace( array_keys( $replacements ), array_values( $replacements ), $attribute['label'] );
						$filtered_attributes[ $key ] = $attribute;
					}
				}

			}

            $attributes_to_display = crown_get_product_attributes_settings();
            foreach ( $filtered_attributes as $key => $value ) {
                $label = str_replace( 'attribute_pa_', '', $key );
                if ( isset($attributes_to_display[$label]) ) {
                    if ( $attributes_to_display[$label]->is_active == 0 ) {
                        unset( $filtered_attributes[$key] );
                        continue;
                    }

                    if ( !empty($attributes_to_display[$label]->display_name) ) {
                        $filtered_attributes[$key]['label'] = $attributes_to_display[$label]->display_name;
                    }
                }
            }

            foreach ( $not_processed_attributes ?? [] as $key => $not_processed_attribute ) {
                $label = str_replace( 'attribute_pa_', '', $key );
                if ( !isset($attributes_to_display[$label]) || $attributes_to_display[$label]->is_active == 0 ) {
                    continue;
                }

                $attribute = $not_processed_attribute;
                if ( empty(trim($attribute['value'])) ) {
                    continue;
                }

                if ( !empty($attributes_to_display[$label]->display_name) ) {
                    $attribute['label'] = $attributes_to_display[$label]->display_name;
                } else {
                    $attribute['label'] = ucwords( preg_replace( '/\s*_\s*/', ' ', $attribute['label'] ) );
                    $attribute['label'] = preg_replace( array_keys( $replacements ), array_values( $replacements ), $attribute['label'] );
                }

                $attribute['value'] = make_clickable( $attribute['value'] );
                $attribute['value'] = strip_tags( $attribute['value'], array( '<a>' ) );
                $filtered_attributes[ 'attribute_pa_' . $not_processed_attribute['label'] ] = $attribute;
            }

			return $filtered_attributes;
		}


		public static function product_teaser() {
			global $product;
			if ( empty( $product ) || ! $product->is_visible() ) {
				return;
			}
			?>
				<article <?php post_class(); ?> data-post-id="<?php the_ID(); ?>">
					<?php
						do_action( 'woocommerce_before_shop_loop_item' );
						do_action( 'woocommerce_before_shop_loop_item_title' );
						do_action( 'woocommerce_shop_loop_item_title' );
						do_action( 'woocommerce_after_shop_loop_item_title' );
						do_action( 'woocommerce_after_shop_loop_item' );
					?>
				</article>
			<?php
		}


		public static function filter_woocommerce_product_get_image( $image, $product, $size, $attr, $placeholder, $image_orig ) {
			$post_id = $product->get_id();
            try {
                $image_srcs = get_post_meta( $post_id, '__product_image_srcs', true );
                $image_srcs = is_array($image_srcs) ? $image_srcs : (is_string($image_srcs) && !empty($image_srcs) ? [$image_srcs] : []);
                if ( is_array( $image_srcs ) && ! empty( $image_srcs[0] ) ) {
                    $image_src = self::convert_amplifi_cdn_src( $image_srcs[0] );
                    if ( in_array( $size, array( 'thumbnail' ) ) ) {
                        $image_src .= '_small.jpg';
                    } else if ( in_array( $size, array( 'medium' ) ) ) {
                        $image_src .= '_small.jpg';
                    } else if ( in_array( $size, array( 'large' ) ) ) {
                        $image_src .= '_medium.jpg';
                    }
                    return sprintf('<img src="'. esc_attr( $image_src ) . '" alt="%s" class="%s" />', esc_attr__('Product Image', 'woocommerce'),
                            esc_attr('wooswipe-product-image single-product-main-image'));
                }
            }
            catch ( \Throwable $e ) {
                Nsi_Helper::log_wc_error($e, $post_id, LogWooErrorType::HANDLED_FATAL);
            }
			return $image;
		}

        public static function custom_woocommerce_product_get_gallery_image_ids($image_ids, $product) {
            try {
                $post_id = $product->get_id();
                $custom_image_srcs = get_post_meta($post_id, '__product_image_srcs', true);
                $custom_image_srcs = is_array($custom_image_srcs)
                        ? $custom_image_srcs
                        : (is_string($custom_image_srcs) && !empty($custom_image_srcs) ? [$custom_image_srcs] : []);
                if ( !empty($custom_image_srcs) && is_array($custom_image_srcs) ) {
                    $image_ids = array_map(function($src) {
                        return self::convert_amplifi_cdn_src($src);
                    }, $custom_image_srcs);
                }
            } catch ( \Throwable $e ) {
                Nsi_Helper::log_wc_error($e, $post_id, LogWooErrorType::HANDLED_FATAL);
            }
            return $image_ids;
        }

		public static function convert_amplifi_cdn_src( $src ): string {
            return is_string( $src )
                    ? preg_replace( '/^https:\/\/fs\.amplifi\.io\/file\?id=/', 'https://cdn.amplifi.pattern.com/', $src )
                    : '';
		}


		public static function filter_woocommerce_single_product_image_thumbnail_html( $html, $post_thumbnail_id ) {
			global $product;
			$post_id = $product->get_id();
            $image_srcs = get_post_meta( $post_id, '__product_image_srcs', true );
            $image_srcs = is_array($image_srcs) ? $image_srcs : (is_string($image_srcs) && !empty($image_srcs) ? [$image_srcs] : []);
			if ( is_array( $image_srcs ) && ! empty( $image_srcs ) ) {
				$image_src = self::convert_amplifi_cdn_src( $image_srcs[0] );
				$thumb_src = $image_src . '_small.jpg';
				$large_src = $image_src . '_medium.jpg';
				return '<div data-thumb="' . esc_url( $thumb_src ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $large_src ) . '"><img src="' . esc_attr( $large_src ) . '"></a></div>';
			}
			return $html;
		}


		public static function woocommerce_show_product_thumbnails() {
			global $product;
			$post_id = $product->get_id();
            $image_srcs = get_post_meta( $post_id, '__product_image_srcs', true );
            $image_srcs = is_array($image_srcs) ? $image_srcs : (is_string($image_srcs) && !empty($image_srcs) ? [$image_srcs] : []);
			if ( is_array( $image_srcs ) && ! empty( $image_srcs ) ) {
				$primary_image_src = array_shift( $image_srcs );
				foreach ( $image_srcs as $image_src ) {
					$image_src = self::convert_amplifi_cdn_src( $image_src );
					$thumb_src = $image_src . '_small.jpg';
					$large_src = $image_src . '_medium.jpg';
					echo '<div data-thumb="' . esc_url( $thumb_src ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $large_src ) . '"><img src="' . esc_attr( $large_src ) . '"></a></div>';
				}
			}
		}


		public static function filter_relevanssi_match( $match ) {
			$custom_field_detail = json_decode( $match->customfield_detail );
			if ( null !== $custom_field_detail && isset( $custom_field_detail->_sku ) ) {
				$match->weight *= 100;
			}
			return $match;
		}


		public static function woocommerce_before_cart() {
			if ( ! is_user_logged_in() ) return;
			$sku = isset( $_REQUEST['sku'] ) ? wp_unslash( $_REQUEST['sku'] ) : '';
			$qty = isset( $_REQUEST['quantity'] ) ? intval( $_REQUEST['quantity'] ) : 1;
			if ( empty( $qty ) ) $qty = 1;
			?>
                <div class="before-cart--holder">
                    <div class="cart--left">
                        <form id="add-sku-to-cart">
                            <div class="field sku">
                                <input type="text" name="sku" placeholder="Enter complete part number" value="<?php echo esc_attr( $sku ); ?>">
                            </div>
                            <div class="field quantity">
                                <input type="number" class="input-text qty text" step="1" min="1" max="" name="quantity" value="<?php echo esc_attr( $qty ); ?>" title="Qty" size="4" placeholder="" inputmode="numeric" autocomplete="off">
                            </div>
                            <footer class="form-footer">
                                <button type="submit" class="btn btn-primary">Add to Cart</button>
                                <?php wp_nonce_field( 'submit_crown_shop_add_sku_to_cart', '_wpnonce_crown_shop', true ); ?>
                            </footer>
                        </form>
                        <button type="button" type="submit" id="xls_to_cart_import_btn" class="button xls_to_cart_import_btn" name="xls_to_cart_import" value="Import Product List">
                            <?php echo 'Import Product List'; ?>
                        </button>
                    </div>
                    <div class="cart--right">
                        <h4>Paste SKUs & Quantities to Create an Order.</h4>
                        <label for="create-cart-from-copypaste">
                            <textarea class="create-cart--textarea"
                                  placeholder="SKU QUANTITY
SKU QUANTITY
SKU QUANTITY"
                                  id="create-cart-from-copypaste"></textarea>
                        </label>
                        <span style="font-size: 14px;">* Each SKU and Quantity pair must be in a new line.</span>
                        <div class="create-cart--actions">
                            <div class="create-cart--errors"></div>
                            <button class="btn btn-primary" id="create-new-cart">Add to cart</button>
                        </div>
                    </div>
                </div>
			<?php
		}


		public static function handle_add_sku_to_cart_submission( $url = false ) {
			if ( ! isset( $_REQUEST['_wpnonce_crown_shop'] ) ) return;
			if ( ! wp_verify_nonce( $_REQUEST['_wpnonce_crown_shop'], 'submit_crown_shop_add_sku_to_cart' ) ) return;

			// Make sure WC is installed and add-to-cart-sku query arg exists
			if ( ! class_exists( 'WC_Form_Handler' ) || empty( $_REQUEST['sku'] ) || ! is_string( $_REQUEST['sku'] ) ) {
                wc_add_notice( __( 'Sorry, this product cannot be purchased.', 'woocommerce' ), 'error' );
                return;
			}
			 
			// Remove WooCommerce's hook, as it's useless
			remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );
		
			wc_nocache_headers();
		
			$product_id        = self::get_product_id_by_sku( wp_unslash( $_REQUEST['sku'] ) );
			$was_added_to_cart = false;
			$adding_to_cart    = wc_get_product( $product_id );
		
			if ( ! $adding_to_cart ) {
				return;
			}
		
			$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );
		
			if ( 'variable' === $add_to_cart_handler || 'variation' === $add_to_cart_handler ) {
				$was_added_to_cart = self::woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_variable', $product_id );
			} elseif ( 'grouped' === $add_to_cart_handler ) {
				$was_added_to_cart = self::woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_grouped', $product_id );
			} elseif ( has_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler ) ) {
				do_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler, $url ); // Custom handler.
			} else {
                $product_id_in_cart = WC()->cart->generate_cart_id( $product_id );
                $is_in_cart = WC()->cart->find_product_in_cart( $product_id_in_cart );
                if ( !empty($is_in_cart) ) {
                    add_filter( 'woocommerce_add_to_cart_validation', array( __CLASS__, 'validate_product_quantity' ), 10, 3 );
                }

				$was_added_to_cart = self::woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_simple', $product_id );
			}
		
			// If we added the product to the cart we can now optionally do a redirect.
			if ( $was_added_to_cart && 0 === wc_notice_count( 'error' ) ) {
				$url = apply_filters( 'woocommerce_add_to_cart_redirect', $url, $adding_to_cart );
		
				if ( $url ) {
					wp_safe_redirect( $url );
					exit;
				} elseif ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
					wp_safe_redirect( wc_get_cart_url() );
					exit;
				} else {
					wp_safe_redirect( wc_get_cart_url() );
					exit;
				}
			}
		}

        public static function validate_product_quantity( $bool, $product_id, $quantity ) {
            $product_step = intval( get_post_meta($product_id, 'product_step', true) );
            if ( $product_step > 1 && $quantity % $product_step != 0 && $quantity < $product_step ) {
                wc_add_notice( '<p><b>Warning</b>: Minimum Quantity for SKU ' . wp_unslash( $_REQUEST['sku'] ) . ' is ' .  $product_step . '.</p>', 'error' );
                return false;
            }

            return $bool;
        }

		protected static function get_product_id_by_sku( $sku ) {
			global $wpdb;
			$result = $wpdb->get_var( $wpdb->prepare( "SELECT
						p.ID AS id
					FROM $wpdb->posts p
					LEFT JOIN $wpdb->wc_product_meta_lookup pm1 ON (pm1.product_id = p.ID)
					WHERE p.post_type = 'product'
					AND p.post_status = 'publish'
					AND pm1.sku = %s
				", $sku ) );
			return $result ? intval( $result ) : $result;
		}

		private static function woo_hack_invoke_private_method( $class_name, $methodName ) {
			if ( version_compare( phpversion(), '5.3', '<' ) ) {
				throw new Exception( 'PHP version does not support ReflectionClass::setAccessible()' );
			}
		
			$args = func_get_args();
			unset( $args[0], $args[1] );
			$reflection = new ReflectionClass( $class_name );
			$method = $reflection->getMethod( $methodName );
			$method->setAccessible( true );
			$args = array_merge( array( $reflection ), $args );
			return call_user_func_array( array( $method, 'invoke' ), $args );
		}


		public static function woocommerce_after_cart_item_name( $cart_item, $cart_item_key ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			echo '<p class="sku">' . $_product->get_sku() . '</p>';
		}


		public static function filter_woocommerce_cart_shipping_method_full_label( $label, $method ) {
			// print_r($method);

			$method_settings = get_option( 'woocommerce_' . $method->get_method_id() . '_' . $method->get_instance_id() . '_settings', array() );
			if ( array_key_exists( 'title_override', $method_settings ) && ! empty( $method_settings['title_override'] ) ) {
				return $method_settings['title_override'];
			}

			$label_overrides = array(
				'289' => '[SB] FedEx 2Day®',
				'12352' => 'Fed - Ex Freight',
				'12353' => 'Fed 3 Day',
				'12360' => 'Fed Ex Early AM',
				'12354' => 'Fed Ex Freight Economy',
				'12355' => 'Fed Ex Freight Priority',
				'12356' => 'Fed Ex International Ground',
				'12359' => 'Fed Ex Priority Sat Delivery',
				'12362' => 'FedEx 2Day',
				'12366' => 'FedEx First Overnight',
				'12367' => 'FedEx Ground',
				'12368' => 'FedEx International Economy',
				'12370' => 'FedEx Standard Overnight',
				'12361' => 'Federal Express Frieght',
				'12364' => 'Fedex 2nd Day AM',
				'12365' => 'Fedex 3rd Day',
				'12369' => 'Fedex Priority Overnight',
				'12390' => 'UPS Ground',
				'12401' => 'USPS',
				'12387' => 'Ups Blue - 2nd Day',
				'12388' => 'Ups Blue - 2nd Day Early AM',
				'12389' => 'Ups Freight',
				'12391' => 'Ups Orange - 3rd Day',
				'12392' => 'Ups Red - Next Day',
				'12393' => 'Ups Red - Next Day Early AM',
				'12394' => 'Ups Red - Saturday',
				'12395' => 'Ups Red - Saturday AM',
				'12396' => 'Ups Red Air Saver',
				'12397' => 'Ups WorldWideExpress'
			);

			if ( array_key_exists( $label, $label_overrides ) ) {
				$label = $label_overrides[ $label ];
			}

			return $label;
		}


		public static function filter_woocommerce_checkout_fields( $fields ) {
			$fields['shipping']['shipping_first_name']['required'] = 0;
			$fields['shipping']['shipping_last_name']['required'] = 0;
			$fields['shipping']['shipping_company']['required'] = 1;
			$fields['shipping']['shipping_company']['priority'] = 5;

			$fields['order']['order_comments']['label'] = __('Special LTL instructions', 'woocommerce');
			$fields['order']['order_comments']['placeholder'] = __('Receiving hours; Reference#', 'woocommerce');
			$fields['order']['order_comments']['maxlength'] = 150;

			return $fields;
		}

		public static function add_description_to_order_comments_field($field, $key, $args, $value) {
			if ($key == 'order_comments') {
				ob_start();
				?>
                <div class="order_comments_details">
                    <span class="order_comments_details_description">
                        <b><?php echo __('Note: ', 'woocommerce'); ?></b><?php echo __('Any other comments regarding the order will not be processed.', 'woocommerce'); ?>
                    </span>
                    <div class="order_comments_details_chars_left"></div>
                </div>
				<?php
				$description = ob_get_clean();
				$field .= $description;
			}

			return $field;
		}

		public static function filter_default_checkout_billing_email( $value, $input ) {
			if ( preg_match( '/^customer-\d+@nsiindustries\.com/', $value ) ) {
				$value = '';
			}
			return $value;
		}


		public static function filter_default_checkout_shipping_name( $value, $input ) {
			if ( self::$checkout_lock ) return $value;
			self::$checkout_lock = true;
			$checkout = WC()->checkout();
			if ( ! empty( $checkout->get_value( 'shipping_company' ) ) ) {
				if ( $checkout->get_value( 'shipping_company' ) == $checkout->get_value( 'shipping_first_name' ) && $checkout->get_value( 'shipping_last_name' ) == 'Company' ) {
					$value = '';
				}
			}
			self::$checkout_lock = false;
			return $value;
		}


		public static function woocommerce_order_item_meta_start( $item_id, $item, $order, $plain_text ) {
			$product = $item->get_product();
			if ( $product ) {
				$sku = $product->get_sku();
				if ( ! empty( $sku ) ) {
					echo '<div class="sku">' . $sku . '</div>';
				}
			}
		}

        public static function change_product_brand_taxonomy_field($query) {
            if (!$query->is_main_query() || is_admin() || is_single() || str_contains($_SERVER['REQUEST_URI'], 'product-brands')) {
                return;
            }

            if (isset($query->tax_query->queries) && is_array($query->tax_query->queries)) {
                for ($i = 0; $i < count($query->tax_query->queries); $i++) {
                    if (isset($query->tax_query->queries[$i]['taxonomy']) && $query->tax_query->queries[$i]['taxonomy'] == 'product_brand') {
                        $query->tax_query->queries[$i]['field'] = 'term_id';
                    }
                }
            }

            return;
        }

        public static function add_admin_panel_spinner( ) {
            echo '<div id="loader_fme-nsi">';
            echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/img/loader1.gif' ) . '" alt="spinner">';
            echo '</div>';
        }

		/**
		 * Overrides TMWNI_Admin_Loader method getOrderLogs()that forms a list of orders in the TM Netsuite dashboard.
		 */
		public static function getOrderLogsFiltered() {
			global $wpdb;
			global $TMWNI_OPTIONS;
			if (isset($_POST['nonce']) && !empty($_POST['nonce']) && !wp_verify_nonce(sanitize_text_field($_POST['nonce']), 'security_nonce') ) {
				echo json_encode(array(
					'draw' => 0,
					'recordsTotal' => 0,
					'recordsFiltered' => 0,
					'data'=>0,
				));
			}
			if (!empty($_POST)) {
				$request = $_POST;

				require_once TMWNI_DIR . '/inc/datatables.php';

				$datatables = new Datatables();

				$columns = array(
					array(
					    'db' => 'orderlog.id as id',
						'dt' => 0,
						'db_ref' => 'id'
					),
					array(
						'db' => 'log.woo_object_id as woo_object_id',
						'dt' => 1,
						'db_ref' => 'woo_object_id'
					),
					array('db' => 'orderlog.created_at as created_at',
						'dt' => 2,
						'db_ref' => 'created_at'
					),
					array(
						'db' => 'orderlog.status as status',
						'dt' => 3,
						'db_ref' => 'status'
					),
					array(
						'db' => 'orderlog.ns_order_status as ns_order_status',
						'dt' => 4,
						'db_ref' => 'ns_order_status'
					),
					array(
						'db' => 'orderlog.notes as notes',
						'dt' => 5,
						'db_ref' => 'notes'
					),
				);

				$limit = $datatables->limit($request);
				$order = $datatables->order($request, $columns);
				$where = $datatables->filter($request, $columns, $binding);
				$wpdb->netsuite_order_logs = $wpdb->prefix . 'tm_woo_netsuite_auto_sync_order_status';

				$limit_arr = explode(' ', $limit);
				$order_arr = explode(' ', $order);

				if ( !empty($where) ) {
					$where_arr = explode(' ', $where);
					$where = str_replace("'", '', $where_arr[4]);
				}
                //TODO: check possibility to rewrite SQL query so that to make it universal.
				//ID base datatable
				if ('id'==$order_arr[2] && 'ASC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY id ASC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY id ASC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}
				if ('id'==$order_arr[2] && 'DESC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY id DESC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY id DESC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}

				//By Order Id
				if ('woo_object_id'==$order_arr[2] && 'ASC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY woo_object_id ASC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY woo_object_id ASC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}
				if ('woo_object_id'==$order_arr[2] && 'DESC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY woo_object_id DESC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY woo_object_id DESC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}

				//By Created Date
				if ('created_at'==$order_arr[2] && 'ASC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY created_at ASC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY created_at ASC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}
				if ('created_at'== $order_arr[2] && 'DESC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY created_at DESC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY created_at DESC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}

				//By Order Status
				if ('ns_order_status'==$order_arr[2] && 'ASC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY ns_order_status ASC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY ns_order_status ASC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}
				if ('ns_order_status'==$order_arr[2] && 'DESC'==$order_arr[3]) {
					if (!empty($where)) {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog WHERE (orderlog.woo_object_id  LIKE %s OR orderlog.status  LIKE %s OR orderlog.notes  LIKE %s) ORDER BY ns_order_status DESC limit %d, %d", $where, $where, $where, $limit_arr[1], $limit_arr[2]), ARRAY_A);
					} else {
						$data = $wpdb->get_results($wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS orderlog.id as id,orderlog.created_at as created_at,orderlog.operation as operation,orderlog.ns_order_status as ns_order_status,orderlog.notes as notes,orderlog.woo_object_id as woo_object_id,orderlog.ns_order_internal_id as ns_order_internal_id FROM {$wpdb->netsuite_order_logs} as orderlog  ORDER BY ns_order_status DESC limit %d, %d", $limit_arr[1], $limit_arr[2]), ARRAY_A);
					}
				}

				$ns_account_id = $TMWNI_OPTIONS['ns_account'];

				$data_filter = $wpdb->get_results('SELECT FOUND_ROWS() as filtered_rows');
				//total filtered records
				$recordsFiltered = $data_filter[0]->filtered_rows;

				$recordsTotal = $recordsFiltered;

				$site_url = get_site_url();

				$records = array();
				foreach ($data as $key => $record) {

					$order_link =  $site_url . '/wp-admin/post.php?post=' . $record['woo_object_id'] . '&amp;action=edit';

					$rows = array();
					$rows[] = $record['id'];
					$rows[] = $record['woo_object_id'];
					$rows[] = $record['created_at'];
					$rows[] = ( !empty($record['ns_order_internal_id']) ) ? '<a target="_blank" href="https://' . str_replace('_', '-', $ns_account_id) . '.app.netsuite.com/app/accounting/transactions/salesord.nl?id=' . $record['ns_order_internal_id'] . '&amp;whence=" class="btn btn-success">View</a>' : '';
					if (!empty($record['ns_order_internal_id'])) {
						$rows[]= $record['ns_order_status'];
					} else {
						$rows[]= $record['ns_order_status'] . '&nbsp;&nbsp;
					<a style="color:#95bf47" data-toggle="collapse" href="#collapsable-msg-' . $key . '" role="button" aria-expanded="false" aria-controls="collapsable-msg-' . $key . '">Know More</a><div class="row">
					<div class="col">
					<div class="collapse multi-collapse" id="collapsable-msg-' . $key . '">
					<div class="card card-body">' . $record['notes'] . '</div>
					</div>
					</div>
					</div>';
					}

					if (isset($TMWNI_OPTIONS['enableOrderSync']) && 'on' == $TMWNI_OPTIONS['enableOrderSync']) {
						$rows[] = '<div class="manually_order_sync_btn">
					<a target="_blank" href="' . $order_link . '"  class="btn btn-success">View</a>&nbsp;
					<button type="button" class="btn btn-success manual_order_sync"  data-id="' . $record['woo_object_id'] . '">Re-Submit</button>
					<span class="loaderSpiner"></span>
					</div>';
					} else {
						$rows[] = '<div class="manually_order_sync_btn">
					<a target="_blank" href="' . $order_link . '"  class="btn btn-success">View</a>
					</div>';
					}

					$records[] = $rows;
					# code...
				}

				//json to be returned
				echo json_encode(array(
					'draw' => intval($request['draw']),
					'recordsTotal' => intval($recordsTotal),
					'recordsFiltered' => intval($recordsFiltered),
					'data' => $records
				));
				die;

			}die;
		}



        public function remove_reviews_tab( $tabs ) {
            unset( $tabs['reviews'] );
            return $tabs;
        }

        public static function cart_import_modal_render() {
            if ( is_page('cart') ) {
                ob_start();
                ?>
                <div id="xls_to_cart_import_modal" class="cart-modal" style="display: none;">
                    <div class="cart-modal-content">
                        <span class="xls-to-cart-close">&times;</span>
                        <h3><?php echo 'Import Product List from XLS'; ?></h3>

                        <form id="cart_import_form" enctype="multipart/form-data">
                            <label for="import_cart_xls_file"><?php echo 'Choose file'; ?></label>
                            <input type="file" id="import_cart_xls_file" name="import_cart_xls_file" accept=".xls,.xlsx">
                            <button type="button" id="cart_parse_btn" class="button"><?php echo 'Start Import'; ?></button>
                        </form>

                        <div id="cart_import_status" style="display: none;"></div>
                    </div>
                </div>
                <?php
                $cart_import_modal = ob_get_clean();
                echo $cart_import_modal;
            }
        }

        public static function render_field_as_readonly($label, $value) {
            $type = 'text';
            $value = $value == '==BLANK==' ? '' : $value;
            $name = preg_replace('/-+/', '_', sanitize_title($label));
            return '
                <tr>
                    <th class="quote-field">' . esc_html($label) . '</th>
                    <td class="quote-field">
                        <input type="' . esc_attr($type) . '" name="' . esc_attr($name) . '"
                               class="form-control form-control-sm mb-3"
                               value="' . esc_attr($value) . '"
                               readonly>
                    </td>
                </tr>';
        }

        public static function dropship_items_availability_text( $availability, $product ) {
            if ( self::is_dropship_item_inventory( $product ) ) {
                return 'Please contact customer service for availability';
            }
            return $availability;
        }

	}
}
