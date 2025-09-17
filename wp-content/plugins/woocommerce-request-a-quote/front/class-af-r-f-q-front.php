<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'AF_R_F_Q_Front' ) ) {

	class AF_R_F_Q_Front extends Addify_Request_For_Quote {

		public function __construct() {
			
			// Enqueue scripts.
			add_action( 'wp_enqueue_scripts', array( $this, 'afrfq_front_script' ) );

			// Process form submit actions.
			add_action( 'wp_loaded', array( $this, 'addify_convert_to_order_customer' ) );
			add_action( 'wp_loaded', array( $this, 'addify_insert_customer_quote' ) );

			// Display Quote basket in menus.
			add_action( 'wp_nav_menu_items', array( $this, 'afrfq_quote_basket' ), 10, 2 );

			// Request a Quote page short code. 
			add_shortcode( 'addify-quote-request-page', array( $this, 'addify_quote_request_page_shortcode_function' ) );
			add_shortcode( 'addify-mini-quote', array( $this, 'addify_mini_quote_shortcode_function' ) );

			// Add endpoint of quote and process its content.
			add_action( 'init', array( $this, 'addify_add_endpoints' ) );
			add_filter( 'woocommerce_account_menu_items', array( $this, 'addify_new_menu_items' ) );
			add_action( 'woocommerce_account_request-quote_endpoint', array( $this, 'addify_endpoint_content' ) );
			add_action( 'woocommerce_get_endpoint_url', array( $this, 'addify_endpoint_url' ), 10, 4 );
			add_filter( 'query_vars', array( $this, 'addify_add_query_vars' ), 0 );
			add_filter( 'the_title', array( $this, 'addify_endpoint_title' ) );
			
			// Start customer session for guest users.
			add_action( 'woocommerce_init', array( $this, 'afrfq_start_customer_session' ) );
		}

		public function afrfq_load_quote_from_session() {

			if ( isset( wc()->session ) && empty( wc()->session->get( 'quotes' ) ) ) {

				if ( is_user_logged_in() ) {

					$quotes = get_user_meta( get_current_user_id(), 'addify_quote', true );

					if ( ! empty( $quotes ) ) {
						wc()->session->set( 'quotes', $quotes );
					}
				}
			}
		}

		public function addify_insert_customer_quote() {

			if ( isset( $_REQUEST['_afrfq__wpnonce'] ) && ! wp_verify_nonce( esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['_afrfq__wpnonce'] ) ) ), '_afrfq__wpnonce' ) ) {
				die( esc_html__( 'Site security violated.', 'addify_rfq' ) );
			}

			if ( isset( $_POST['afrfq_action'] ) ) {

				$af_quote = new AF_R_F_Q_Quote();

				 if ( 'save_afrfq_discount' === $_POST['afrfq_action'] ) {
					if ( ! isset( $_POST['afrfq_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['afrfq_nonce'] ) ), 'save_afrfq_discount' ) ) {
						wp_die( 'Security check failed for discount quote submission where.' );
					}
					$af_quote->insert_new_discount_quote( $_POST );

				} else { 
					if ( ! isset( $_POST['afrfq_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['afrfq_nonce'] ) ), 'save_afrfq' ) ) {
						wp_die( 'Security check failed for standard quote submission.' );
					}

					unset( $_POST['afrfq_action'] );
					$data = (array) sanitize_meta( '', wp_unslash( $_POST ), '' );
					$af_quote->insert_new_quote( array_merge( $data, (array) $_FILES ) );
				}
			}

		}

		public function addify_convert_to_order_customer() {

			if ( isset( $_REQUEST['_afrfq__wpnonce'] ) && ! wp_verify_nonce( esc_attr( sanitize_text_field( wp_unslash( $_REQUEST['_afrfq__wpnonce'] ) ) ), '_afrfq__wpnonce' ) ) {
				wp_die( esc_html__( 'Site security violated.', 'addify_rfq' ) );
			}

			if ( isset( $_POST['addify_convert_to_order_customer'] ) ) {

				$quote_id = sanitize_text_field( wp_unslash( $_POST['addify_convert_to_order_customer'] ) );

				if ( empty( intval( $quote_id ) ) ) {
					return;
				}

				$af_quote = new AF_R_F_Q_Quote();

				$af_quote->convert_quote_to_order( $quote_id );
				

			} else {
				return;
			}
		}

		public function afrfq_start_customer_session() {

			if ( is_user_logged_in() || is_admin() ) {
				return;
			}

			if ( isset( WC()->session ) ) {
				if ( ! WC()->session->has_session() ) {
					WC()->session->set_customer_session_cookie( true );
				}
			}
		}

		public function afrfq_front_script() {

			wp_enqueue_style( 'afrfq-front', AFRFQ_URL . 'assets/css/afrfq_front.css', false, '1.1' );
			wp_enqueue_style( 'jquery-model', AFRFQ_URL . 'assets/css/jquery.modal.min.css', false, '1.0' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-model', AFRFQ_URL . 'assets/js/jquery.modal.min.js', array( 'jquery' ), '1.0', true );
			wp_enqueue_script( 'afrfq-frontj', AFRFQ_URL . 'assets/js/afrfq_front.js', array( 'jquery' ), '1.3.1', true );

			$afrfq_data = array(
				'admin_url' => admin_url( 'admin-ajax.php' ),
				'nonce'     => wp_create_nonce( 'afquote-ajax-nonce' ),
				'redirect'  => get_option( 'afrfq_redirect_to_quote' ),
				'pageurl'   => get_page_link( get_option( 'addify_atq_page_id', true ) ),
			);
			wp_localize_script( 'afrfq-frontj', 'afrfq_phpvars', $afrfq_data );
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_script( 'Google reCaptcha JS', '//www.google.com/recaptcha/api.js', array( 'jquery' ), '1.0', true );
            wp_enqueue_style('select2', AFRFQ_URL . '/assets/css/select2.css', false, '1.0');
            wp_enqueue_script('select2', AFRFQ_URL . '/assets/js/select2.js', array('jquery'), '1.0', true);
		}

		public function addify_mini_quote_shortcode_function() {

			ob_start();

			wc_get_template( 
				'quote/mini-quote.php',
				array(),
				'/woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);

			return ob_get_clean();
		}

		public function afrfq_quote_basket( $items, $args ) {

			if ( is_user_logged_in() ) {
				$user_role = current( wp_get_current_user()->roles );
			} else {
				$user_role = 'guest';
			}

			if ( !empty( get_option('afrfq_customer_roles') ) && in_array( $user_role , (array) get_option('afrfq_customer_roles') ) ) {
				return $items;
			}
			
			$menu_ids = is_serialized( get_option( 'quote_menu' ) ) ? unserialize( get_option( 'quote_menu' ) ) : get_option( 'quote_menu' );
			
			if ( empty( $menu_ids ) ) {
				return $items;
			}

			if ( isset( $args->menu->term_id ) ) {

				$menu_id = $args->menu->term_id;

			} elseif ( isset( $args->term_id ) ) {

				$menu_id = $args->term_id;

			} elseif ( isset( $args->menu ) ) {

				$menu_id = $args->menu;

			} else {

				$menu_id = 0;
			}
			
			$menu_match = in_array( (string) $menu_id, (array) $menu_ids, true ) ? true : false;

			if ( ! $menu_match ) {
				return $items;
			}

			ob_start();

			wc_get_template( 
				'quote/mini-quote.php',
				array(),
				'/woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);

			return $items . ob_get_clean();
		}

		public function addify_quote_request_page_shortcode_function() {

			ob_start();

			if ( file_exists( get_stylesheet_directory() . '/woocommerce/addify/rfq/front/addify-quote-request-page.php' ) ) {

				require_once get_stylesheet_directory() . '/woocommerce/addify/rfq/front/addify-quote-request-page.php';

			} else {

				wc_get_template(
					'quote/addify-quote-request-page.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);
			}

			return ob_get_clean();
		}

		public function addify_add_endpoints() {

			add_rewrite_endpoint( 'request-quote', EP_ROOT | EP_PAGES );
			flush_rewrite_rules();
		}

		public function addify_add_query_vars( $vars ) {
			$vars[] = 'request-quote';
			return $vars;
		}

		public function addify_endpoint_title( $title ) {
			global $wp_query;
			$is_endpoint = isset( $wp_query->query_vars['request-quote'] );
			if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
				// New page title.
				$title = esc_html__( 'Quotes', 'addify_rfq' );
				remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
			}
			return $title;
		}

		public function addify_new_menu_items( $items ) {
            $current_user = wp_get_current_user();
			// Remove the logout menu item.
			$logout = $items['customer-logout'];
			unset( $items['customer-logout'] );
			// Insert your custom endpoint.
            if ( !in_array($current_user->roles[0], array('order_viewer', 'branch_employee_viewer')) ) {
                $items['request-a-quote'] = esc_html__( 'New Quote', 'addify_rfq' );
            }
            $items = $this->add_spa_pricing_and_template( $current_user, $items );
			$items['request-quote'] = esc_html__( 'Quotes', 'addify_rfq' );
			// Insert back the logout item.
			$items['customer-logout'] = $logout;
			return $items;
		}

        public function addify_endpoint_url( $url, $endpoint, $value, $permalink ) {
            if ( $endpoint === 'request-a-quote' ) {
                return home_url( '/request-a-quote' );
            }

            if ( $endpoint === 'stock-price-spa-request' ) {
                $request_url = get_field( 'stock_price_spa_request_url', 'options' );
                return $request_url ?: '#';
            }

            if ( $endpoint === 'pricing-template' ) {
                $pricing_xls = get_field( 'pricing_template_file', 'options' );
                return $pricing_xls['url'] ?? '#';
            }

            return $url;
        }

		public function addify_endpoint_content() {

			//Single Quote

			$statuses = array(
				'af_pending'    => __( 'Pending', 'addify_rfq' ),
				'af_in_process' => __( 'In Process', 'addify_rfq' ),
				'af_accepted'   => __( 'Accepted', 'addify_rfq' ),
				'af_converted'  => __( 'Converted to Order', 'addify_rfq' ),
				'af_declined'   => __( 'Declined', 'addify_rfq' ),
				'af_cancelled'  => __( 'Cancelled', 'addify_rfq' ),
			);

			$afrfq_id = get_query_var( 'request-quote' );

			$quote = get_post( $afrfq_id );

			if ( ! empty( $afrfq_id ) && is_a( $quote, 'WP_Post' ) ) {
				$quotedataid = get_post_meta( $afrfq_id, 'quote_proid', true );

				if ( ! empty( $quotedataid ) ) {

					wc_get_template( 
						'my-account/quote-details-my-account-old-quotes.php',
						array(
							'afrfq_id' => $afrfq_id,
							'quote'    => $quote
						),
						'/woocommerce/addify/rfq/',
						AFRFQ_PLUGIN_DIR . 'templates/'
					);

				} else {

					wc_get_template( 
						'my-account/quote-details-my-account.php',
						array(
							'afrfq_id' => $afrfq_id,
							'quote'    => $quote
						),
						'/woocommerce/addify/rfq/',
						AFRFQ_PLUGIN_DIR . 'templates/'
					);
					echo Crown_Shop_Rfq::afrfq_admin_add_import_modal_render($afrfq_id);
				}
			} else {

				$customer_quotes = get_posts(
					array(
						'numberposts' => -1,
						'meta_key'    => '_customer_user',
						'meta_value'  => get_current_user_id(),
						'post_type'   => 'addify_quote',
						'post_status' => 'publish',
					)
				);

				wc_get_template( 
					'my-account/quote-list-table.php',
					array(
						'customer_quotes' => $customer_quotes,
						'statuses' => $statuses
					),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);
			}
		}

        public function add_spa_pricing_and_template( $current_user, $items ) {
            if ( $current_user->roles[0] === 'shop_manager' || $current_user->roles[0] === 'dual_shop_manager') {
                $current_user_email = $current_user->user_email;
                $domains = get_field( 'user_profile_domains_for_tpl_spa', 'options' );
                if ( !empty($domains) ) {
                    foreach ( $domains as $domain ) {
                        $lowercase_email = strtolower($current_user_email);
                        $lowercase_domain = strtolower($domain['tpl_spa_domain']);
                        if ( str_contains($lowercase_email, $lowercase_domain) ) {
                            $items['stock-price-spa-request'] = esc_html__( 'Stock Price & Spa Request', 'addify_rfq' );
                            $items['pricing-template'] = esc_html__( 'Download Pricing Template', 'addify_rfq' );
                            break;
                        }
                    }
                }
            } else if( in_array($current_user->roles[0], array('pricing', 'administrator')) ) {
                $items['stock-price-spa-request'] = esc_html__( 'Stock Price & Spa Request', 'addify_rfq' );
                $items['pricing-template'] = esc_html__( 'Download Pricing Template', 'addify_rfq' );
            }

            return $items;
        }
	}
	new AF_R_F_Q_Front();
}
