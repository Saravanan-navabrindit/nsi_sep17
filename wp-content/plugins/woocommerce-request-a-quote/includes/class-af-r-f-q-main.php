<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'AF_R_F_Q_Main' ) ) {

	class AF_R_F_Q_Main {

		public $quote_rules;

		public static $rule_applied;

		public function __construct() {

			add_action('init', function() {
				$this->quote_rules = $this->afrfq_get_quote_rules();
			});
			
			self::$rule_applied = array();

			// Hide price for selected products.
			add_filter( 'woocommerce_get_price_html', array( $this, 'afrfq_remove_woocommerce_price_html' ), 100, 2 );

			// Process and initialize the hooks.
			add_action( 'init', array( $this, 'afrfq_add_archive_page_hooks' ) );
			add_action( 'init', array( $this, 'afrfq_add_product_page_hooks' ) );

			// Display add to quote after add to cart button.
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'afrfq_custom_button_add_replacement' ), 30 );

			// Load and update saved quotes of registered users.
			add_action( 'wp_login', array( $this, 'afrfq_update_quote_data_after_login' ), 100, 2 );

			// Add woocommerce product addon compatibility
			add_filter( 'woocommerce_product_addons_show_grand_total', array( $this, 'hide_price_product_addon' ), 100, 2 );
		}

		public function hide_price_product_addon( $visible, $product ) {

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_price      = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_price', true );
				$afrfq_hide_price_text    = get_post_meta( intval( $rule->ID ), 'afrfq_hide_price_text', true );
				$afrfq_is_hide_addtocart  = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );
				$afrfq_custom_button_link = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_link', true );

				$istrue = false;

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				if ( 'yes' === $afrfq_is_hide_price ) {
					return false;
				}
			}

			return $visible;
		}

		public function afrfq_get_quote_rules() {

			$args = array(
				'post_type'        => 'addify_rfq',
				'post_status'      => 'publish',
				'numberposts'      => -1,
				'orderby'          => 'menu_order',
				'order'            => 'ASC',
				'suppress_filters' => false,

			);
			return get_posts( $args );
		}

		public function afrfq_show_rfq_out_of_stock( $html, $product ) {

			if ( $product->is_in_stock() ) {
				return $html;
			}

			if ( 'yes' !== get_option( 'enable_o_o_s_products' ) ) {
				return $html;
			}

			if ( 'simple' !== $product->get_type() ) {
				return $html;
			}

			wc_get_template( 
				'product/simple-out-of-stock.php',
				array(),
				'/woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);
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

		public function afrfq_update_quote_data_after_login( $user_login, $user ) {

			$saved_quotes   = (array) get_user_meta( $user->ID, 'addify_quote', true );
			$session_quotes = (array) WC()->session->get( 'quotes' );
			$final_quotes   = $session_quotes;

			// Merge saved quotes and session quotes.
			foreach ( (array) $saved_quotes as $key => $value ) {

				if ( ! isset( $final_quotes[ $key ] ) && ! empty( $value ) ) {
					$final_quotes[ $key ] = $value;
				}
			}

			// Filter quotes.
			foreach ( $final_quotes as $key => $value ) {
				if ( empty( $value ) ) {
					unset( $final_quotes[ $key ] );
				}
			}
            if ( !Crown_Shop_Custom_Roles::is_switched_user() ) {
                update_user_meta( $user->ID, 'addify_quote', $final_quotes );
            }
			WC()->session->set( 'quotes', $final_quotes );
		}

		public function afrfq_add_product_page_hooks() {

			$sol2_array = array( get_option( 'afrfq_enable_elementor_compt' ), get_option( 'afrfq_enable_divi_compt' ), get_option( 'afrfq_enable_solution2' ) );

			if ( in_array( 'yes', $sol2_array, true ) ) {

				add_action( 'woocommerce_simple_add_to_cart', array( $this, 'afrfq_custom_product_button_elementor' ), 1, 0 );
				add_action( 'woocommerce_variable_add_to_cart', array( $this, 'afrfq_custom_product_button_elementor' ), 1, 0 );
			} else {

				add_action( 'woocommerce_single_product_summary', array( $this, 'afrfq_custom_product_button' ), 1, 0 );
			}
		}

		public function afrfq_custom_product_button_elementor() {

			global $user, $product;

			$quote_button = false;

			if ( ( ! $product->is_in_stock() ) && 'yes' !== get_option('enable_o_o_s_products') ) {

				return;
			}

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_price      = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_price', true );
				$afrfq_hide_price_text    = get_post_meta( intval( $rule->ID ), 'afrfq_hide_price_text', true );
				$afrfq_is_hide_addtocart  = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );

				$istrue = false;

				if ( $quote_button && in_array( $afrfq_is_hide_addtocart, array( 'replace', 'addnewbutton' ), true ) ) {
					continue;
				}

				$afrfq_apply_on_oos_products = get_post_meta( intval( $rule->ID ), 'afrfq_apply_on_oos_products', true );
				
				if ( $product->is_in_stock() ) {

					if ( 'yes' == $afrfq_apply_on_oos_products ) {
						continue;
					}
				}

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				if ( 'replace' === $afrfq_is_hide_addtocart || 'replace_custom' === $afrfq_is_hide_addtocart ) {

					$quote_button = true;

					if ( 'variable' === $product->get_type() ) {
						remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
						add_action( 'woocommerce_single_variation', array( $this, 'afrfq_custom_button_replacement' ), 20 );
					} else {
						remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
						add_action( 'woocommerce_simple_add_to_cart', array( $this, 'afrfq_custom_button_replacement' ), 30 );
					}
				}
				continue;
			}
		}

		public function afrfq_add_archive_page_hooks() {

			// Replace add to cart button with custom button on shop page.
			add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'afrfq_replace_loop_add_to_cart_link' ), 10, 2 );

			// Replace add to cart button with custom button on shop page.
			add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'afrfq_custom_add_to_quote_button' ), 20, 2 );
		}

		public function afrfq_remove_woocommerce_price_html( $price, $product ) {

			if ( 'variation' === $product->get_type() ) {
				$product_id = $product->get_parent_id();
				$product    = wc_get_product( $product_id );
			}
			
			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_price   = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_price', true );
				$afrfq_hide_price_text = get_post_meta( intval( $rule->ID ), 'afrfq_hide_price_text', true );

				if ( 'yes' !== $afrfq_is_hide_price  ) {
					continue;
				}

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}
				
				return $afrfq_hide_price_text;
			}

			return $price;
		}

		public function check_required_addons( $product_id ) {
			// No parent add-ons, but yes to global.
			if ( in_array( 'woocommerce-product-addons/woocommerce-product-addons.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				$addons = WC_Product_Addons_Helper::get_product_addons( $product_id );

				if ( ! empty( $addons ) ) {
					return true;
				}
			}

			return false;
		}

		public function afrfq_check_rule_for_product( $product_id, $rule_id ) {

			$afrfq_rule_type         = get_post_meta( intval( $rule_id ), 'afrfq_rule_type', true );
			$afrfq_hide_products     = (array) unserialize( get_post_meta( intval( $rule_id ), 'afrfq_hide_products', true ) );
			$afrfq_hide_categories   = (array) unserialize( get_post_meta( intval( $rule_id ), 'afrfq_hide_categories', true ) );
			$afrfq_hide_user_role    = (array) unserialize( get_post_meta( intval( $rule_id ), 'afrfq_hide_user_role', true ) );
			$applied_on_all_products = get_post_meta( $rule_id, 'afrfq_apply_on_all_products', true );

			if ( ! is_user_logged_in() ) {

				if ( !in_array( 'guest', (array) $afrfq_hide_user_role, true ) && 'afrfq_for_guest_users' !== $afrfq_rule_type ) {

					return false;
				}

			} else {

				$curr_user      = wp_get_current_user();
				$curr_user_role = current( $curr_user->roles );

				if ( !in_array( $curr_user_role, (array) $afrfq_hide_user_role, true ) ) {
					return false;
				}
			}
			

			if ( 'yes' === $applied_on_all_products ) {
				return true;
			}

			if ( in_array( $product_id, $afrfq_hide_products ) ) {
				return true;
			}

			foreach ( $afrfq_hide_categories as $cat ) {

				if ( !empty( $cat) && has_term( $cat, 'product_cat', $product_id ) ) {

					return true;
				}
			}

			return false;
		}

		public function afrfq_replace_loop_add_to_cart_link( $html, $product ) {

			$pageurl = get_page_link( get_option( 'addify_atq_page_id', true ) );
			
			$cart_txt = $html;

			if ( 'simple' !== $product->get_type() ) {
				return $html;
			}

			if ( ( ! $product->is_in_stock() ) && 'yes' !== get_option('enable_o_o_s_products') ) {

				return $html;
			}

			$quote_button = false;

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_price         = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_price', true );
				$afrfq_hide_price_text       = get_post_meta( intval( $rule->ID ), 'afrfq_hide_price_text', true );
				$afrfq_is_hide_addtocart     = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text    = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );
				$afrfq_custom_button_link    = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_link', true );
				$afrfq_apply_on_oos_products = get_post_meta( intval( $rule->ID ), 'afrfq_apply_on_oos_products', true );

				$istrue = false;

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				if ( $product->is_in_stock() ) {

					if ( 'yes' == $afrfq_apply_on_oos_products ) {
						continue;
					}
				}

				if ( $quote_button && in_array( $afrfq_is_hide_addtocart, array( 'replace', 'addnewbutton' ), true ) ) {
					continue;
				}

				if ( $this->check_required_addons( $product->get_id() ) ) {
					//WooCommerce Product Add-ons compatibility
					return $html;

				} else {

					if ( 'replace' === $afrfq_is_hide_addtocart || 'replace_custom' === $afrfq_is_hide_addtocart ) {
						
						return '';
					}
				}

			}

			return $cart_txt;
		}

		public function afrfq_custom_add_to_quote_button( $html, $product ) {

			global $user, $product;

			$pageurl = get_page_link( get_option( 'addify_atq_page_id', true ) );

			if ( ( ! $product->is_in_stock() ) && 'yes' !== get_option('enable_o_o_s_products') ) {

				return $html;
			}

			$quote_button = false;

			ob_start();

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_price         = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_price', true );
				$afrfq_hide_price_text       = get_post_meta( intval( $rule->ID ), 'afrfq_hide_price_text', true );
				$afrfq_is_hide_addtocart     = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text    = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );
				$afrfq_custom_button_link    = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_link', true );
				$afrfq_apply_on_oos_products = get_post_meta( intval( $rule->ID ), 'afrfq_apply_on_oos_products', true );

				$istrue = false;

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				if ( $product->is_in_stock() ) {

					if ( 'yes' == $afrfq_apply_on_oos_products ) {
						continue;
					}
				}

				if ( $quote_button && in_array( $afrfq_is_hide_addtocart, array( 'replace', 'addnewbutton' ), true ) ) {
					continue;
				}

				if ( $this->check_required_addons( $product->get_id() ) ) {

					return apply_filters( 'addons_add_to_cart_text', __( 'Select options', 'woocommerce-product-addons' ) );
				} else {

					if ( ( 'replace' == $afrfq_is_hide_addtocart ||  'addnewbutton' === $afrfq_is_hide_addtocart ) && 'simple' === $product->get_type() ) {
						$quote_button = true;
						echo '<a href="javascript:void(0)" rel="nofollow" data-product_id="' . intval( $product->get_ID() ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" class="afrfqbt button add_to_cart_button product_type_' . esc_attr( $product->get_type() ) . '">' . esc_attr( $afrfq_custom_button_text ) . '</a>';

					} elseif ( ( 'replace_custom' == $afrfq_is_hide_addtocart || 'addnewbutton_custom' === $afrfq_is_hide_addtocart ) && 'simple' === $product->get_type() ) {

						if ( ! empty( $afrfq_custom_button_text ) ) {
							echo '<a href="' . esc_url( $afrfq_custom_button_link ) . '" rel="nofollow"  class=" button add_to_cart_button product_type_' . esc_attr( $product->get_type() ) . '">' . esc_attr( $afrfq_custom_button_text ) . '</a>';
						}
					}
				}
			}

			return $html . ob_get_clean();
		}

		public function afrfq_custom_product_button() {

			global $user, $product;

			if ( ( ! $product->is_in_stock() ) && 'yes' !== get_option('enable_o_o_s_products') ) {
				return;
			}

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_addtocart  = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );

				$istrue = false;

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				$afrfq_apply_on_oos_products = get_post_meta( intval( $rule->ID ), 'afrfq_apply_on_oos_products', true );

				if ( $product->is_in_stock() ) {

					if ( 'yes' == $afrfq_apply_on_oos_products ) {
						continue;
					}
				}

				if ( 'replace' === $afrfq_is_hide_addtocart || 'replace_custom' === $afrfq_is_hide_addtocart ) {

					if ( 'variable' === $product->get_type() ) {

						remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
						add_action( 'woocommerce_single_variation', array( $this, 'afrfq_custom_button_replacement' ), 30 );
						return;
					} else {

						remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
						add_action( 'woocommerce_simple_add_to_cart', array( $this, 'afrfq_custom_button_replacement' ), 30 );
						return;
					}
				}
			}
		}

		public function afrfq_custom_button_replacement() {

			$pageurl = get_page_link( get_option( 'addify_atq_page_id', true ) );

			global $user, $product;

			if ( ! $product->is_in_stock() && 'yes' !== get_option('enable_o_o_s_products') ) {
				return;
			}

			$quote_button = false;

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_price      = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_price', true );
				$afrfq_hide_price_text    = get_post_meta( intval( $rule->ID ), 'afrfq_hide_price_text', true );
				$afrfq_is_hide_addtocart  = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );
				$afrfq_custom_button_link = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_link', true );

				$afrfq_apply_on_oos_products = get_post_meta( intval( $rule->ID ), 'afrfq_apply_on_oos_products', true );

				$istrue = false;

				if ( $product->is_in_stock() ) {

					if ( 'yes' == $afrfq_apply_on_oos_products ) {
						continue;
					}
				}

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				if ( $quote_button && in_array( $afrfq_is_hide_addtocart, array( 'replace', 'addnewbutton' ), true ) ) {
					continue;
				}

				if ( 'variable' === $product->get_type() ) {

					$disable_class = 'disabled wc-variation-selection-needed';
				} else {
					$disable_class = '';
				}

				$args = array(
					'afrfq_custom_button_text'  => $afrfq_custom_button_text,
					'afrfq_custom_button_link' => $afrfq_custom_button_link
				);

				if ( 'addnewbutton' === $afrfq_is_hide_addtocart || 'replace' === $afrfq_is_hide_addtocart  ) {

					$quote_button = true;

					array_push( self::$rule_applied, $rule->ID );


					if ( 'simple' === $product->get_type() ) {

						wc_get_template( 
							'product/simple.php',
							$args,
							'/woocommerce/addify/rfq/',
							AFRFQ_PLUGIN_DIR . 'templates/'
						);

					} else {

						wc_get_template( 
							'product/variable.php',
							$args,
							'/woocommerce/addify/rfq/',
							AFRFQ_PLUGIN_DIR . 'templates/'
						);
					}
					
					return;

				} elseif ( 'addnewbutton_custom' === $afrfq_is_hide_addtocart || 'replace_custom' === $afrfq_is_hide_addtocart ) {

					array_push( self::$rule_applied, $rule->ID );

					if ( ! empty( $afrfq_custom_button_text ) ) {

						wc_get_template( 
							'product/custom-button.php',
							$args,
							'/woocommerce/addify/rfq/',
							AFRFQ_PLUGIN_DIR . 'templates/'
						);
					}
					
					return;
				}
			}
		}

		public function afrfq_custom_button_add_replacement() {

			if ( ! apply_filters( 'afrfq_user_rfq_enabled', true, get_current_user_id() ) ) return;

			$pageurl = get_page_link( get_option( 'addify_atq_page_id', true ) );

			global $user, $product;
			
			$quote_button = false;

			if ( did_action('addify_after_add_to_quote_button') ) {
				$quote_button = true;
			}

			foreach ( $this->quote_rules as $rule ) {

				$afrfq_is_hide_addtocart  = get_post_meta( intval( $rule->ID ), 'afrfq_is_hide_addtocart', true );
				$afrfq_custom_button_text = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_text', true );
				$afrfq_custom_button_link = get_post_meta( intval( $rule->ID ), 'afrfq_custom_button_link', true );

				$istrue = false;

				if ( !$this->afrfq_check_rule_for_product( $product->get_id(), $rule->ID ) ) {
					continue;
				}

				if ( in_array( $rule->ID, self::$rule_applied ) ) {
					continue;
				}

				$afrfq_apply_on_oos_products = get_post_meta( intval( $rule->ID ), 'afrfq_apply_on_oos_products', true );
				
				if ( $product->is_in_stock() ) {

					if ( 'yes' == $afrfq_apply_on_oos_products ) {
						continue;
					}
				}

				if ( $quote_button && in_array( $afrfq_is_hide_addtocart, array( 'replace', 'addnewbutton' ), true ) ) {
					continue;
				}

				if ( 'variable' === $product->get_type() ) {

					$disable_class = 'disabled wc-variation-selection-needed';
				} else {
					$disable_class = '';
				}

				if ( 'addnewbutton' === $afrfq_is_hide_addtocart || 'replace' === $afrfq_is_hide_addtocart  ) {
					global $addify_rfq;
					$quote_button = true;
					$bridge_port_brand = false;
					$bridge_port_product = false;

					$current_user = wp_get_current_user();
					$admin_id = get_original_admin_id();
					$admin_user = $admin_id ? get_userdata($admin_id) : null;
    				$brand_check_condition = false;
					$triggering_role = null;
					$email_to_check = '';

					if ( is_switched_customer() ) {
						$switched_roles = (array) $current_user->roles;
						if ( in_array( 'dual_shop_manager', $switched_roles ) ) {
							$brand_check_condition = true;
							$triggering_role = 'dual_shop_manager';
							$email_to_check = strtolower( $current_user->user_email );
						} elseif ( in_array( 'shop_manager', $switched_roles ) ) {
							$brand_check_condition = true;
							$triggering_role = 'shop_manager';
						} elseif ( $admin_user ) {
							$admin_roles = (array) $admin_user->roles;
							if ( in_array( 'dual_shop_manager', $admin_roles ) ) {
								$brand_check_condition = true;
								$triggering_role = 'dual_shop_manager';
								$email_to_check = strtolower( $admin_user->user_email );
							} elseif ( in_array( 'shop_manager', $admin_roles ) ) {
								$brand_check_condition = true;
								$triggering_role = 'shop_manager';
							}
						}
					} else {
						$user_roles = (array) $current_user->roles;
						if ( in_array( 'dual_shop_manager', $user_roles ) ) {
							$brand_check_condition = true;
							$triggering_role = 'dual_shop_manager';
							$email_to_check = strtolower( $current_user->user_email );
						} elseif ( in_array( 'shop_manager', $user_roles ) ) {
							$brand_check_condition = true;
							$triggering_role = 'shop_manager';
						}
					}
					$context_key = get_current_user_contextual_quote_type_key();
					if ( $brand_check_condition ) {
						$product_brand = $product->get_meta('product_brand');
						if ( strtolower( $product_brand ) === 'bridgeport' ) {
							$bridge_port_product = true;
						}
						if ( 'dual_shop_manager' === $triggering_role ) {
							$dsm_allowed_brands_option = get_option( 'dsm_allowed_brands' );
							$domains = $dsm_allowed_brands_option['data']['dsm-domain'] ?? array();
							$brands = $dsm_allowed_brands_option['data']['dsm-brands'] ?? array();

							if ( ! empty( $domains ) && ! empty( $brands ) && ! empty( $email_to_check ) ) {
								foreach ( $domains as $index => $domain ) {
									$lowercase_domain = strtolower( $domain );

									if ( str_contains( $email_to_check, trim($lowercase_domain) ) ) {
										$available_brands = isset( $brands[ $index ] ) ? array_map( 'trim', explode( ',', $brands[ $index ] ) ) : array();

										if ( in_array( 'bridgeport', array_map( 'strtolower', $available_brands ), true ) ) {
											$bridge_port_brand = true;
										}
										break;
									}
								}
							}
						} elseif ( 'shop_manager' === $triggering_role ) {
							if ( $bridge_port_product ) {
								$bridge_port_brand = true;
							}
						}

						$block_bridgeport = false;
						$quote_type_bridgeport_only = '';
						$user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key);
						$session_selected_quote_type = WC()->session->get( $context_key );
						$quote_type_already_exists = (!empty($user_selected_quote_type[0]['id']) || !empty($session_selected_quote_type['id']));
						$selected_quote_type = array();
						if(!empty($user_selected_quote_type)){
							$selected_quote_type = $user_selected_quote_type;
						} elseif (!empty($session_selected_quote_type)) {
							$selected_quote_type = $session_selected_quote_type;
						}
						$quote_type_id = isset($selected_quote_type['id']) ? $selected_quote_type['id'] : 0;
						if ( $quote_type_id ) {
							$quote_type_bridgeport_only = get_post_meta( $quote_type_id, 'quote_type_bridgeport_brand', true );
						}
						if ( ! $bridge_port_product && $quote_type_bridgeport_only === 'yes' ) {
							$block_bridgeport = true;
						}
					
						// Button + Popup wrapper
						echo '<a class="button alt select-quote-type-button" data-product_id="' . intval( $product->get_ID() ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" data-block_bridgeport="' . esc_attr( $block_bridgeport ? '1' : '0' ) . '" data-quote-exists="' . ($quote_type_already_exists ? 'true' : 'false') . '">' . esc_attr( $afrfq_custom_button_text ) . '</a>';
						echo '<div class="discount-quick-view" id="discount-popup">
						<div class="popup-content">
							<p>You have selected a Discount Quote. Proceeding need to clear your current quote type.</p>
							<button class="popup-close-button" aria-label="Close alert" type="button" data-close>
							<span aria-hidden="true">&times;</span></button>
						</div>
						</div>';
						echo '<div class="bridgeport-warning-popup" id="bridgeport-popup">
								<button class="popup-close-button" id="bridgeport-close" aria-label="Close alert" type="button" data-close>
									<span aria-hidden="true">&times;</span></button>
								<div class="popup-content">
									<p>To add this product to the quote, please clear your quote and try adding this product again since its not a bridgeport product. Thank you!</p>
								</div>
							</div>';
						echo '<div class="type-already-selected-warning-popup" id="type_already_selected_popup">
							<button class="popup-close-button" id="type-already-selected-close" aria-label="Close alert" type="button" data-close>
								<span aria-hidden="true">&times;</span></button>
							<div class="popup-content">
								<p>A quote type is already selected. To change it, please clear your current quote. Thank you!</p>
							</div>
						</div>';
						echo '<div class="pdp-quick-view" id="pdp-popup"><button class="popup-close-button" aria-label="Close alert" type="button" data-close>
							<span aria-hidden="true">&times;</span></button>';

						if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
							$afrfq_field_quote_types = (array) get_post_meta( $field_id, 'afrfq_field_quote_types', true );
							$all_quote_types = $addify_rfq->quote_types_obj->afrfq_get_all_quote_types();
							$quote_types = sort_quote_types_with_job_request_first( $all_quote_types );
							?>
							<fieldset class="afrfq-quote-types-select">
								<h4>Select Quote Type</h4>
								<?php foreach ( $quote_types as $quote_type ) : 
									$quote_type_id = intval( $quote_type->ID );
									$quote_type_title = $quote_type->post_title;
									$apply_discount_rules = get_post_meta( $quote_type_id, 'quote_type_discount_rules', true );
									$quote_type_bridgeport_only = get_post_meta( $quote_type_id, 'quote_type_bridgeport_brand', true );
									if ( $apply_discount_rules === 'yes' || empty( trim( $quote_type_title ) ) ) {
										continue;
									}
									if ( $quote_type_bridgeport_only === 'yes' && (! $bridge_port_brand || ! $bridge_port_product) ) {
										continue;
									}

									$is_checked = in_array( $quote_type_id, array_map( 'intval', $afrfq_field_quote_types ), true );
									?>
									<label>
										<input 
											type="radio" 
											name="afrfq_field_quote_types"
											value="<?php echo esc_attr( $quote_type_id ); ?>" 
											data-label="<?php echo esc_attr( $quote_type_title ); ?>" 
											<?php checked( $is_checked ); ?>
										/>
										<?php echo esc_html( $quote_type_title ); ?>
									</label><br>
								<?php endforeach; ?>
							</fieldset>
							<div>
            					<p class="quote-type-not-selected" style="display:none; color:red;">Please select a quote type!</p>
        					</div>
							<?php
							echo '<a href="javascript:void(0)" rel="nofollow" data-product_id="' . intval( $product->get_ID() ) . '" data-product_sku="' . esc_attr( $product->get_sku() ) . '" class="afrfqbt_single_page single_add_to_cart_button button alt ' . esc_attr( $disable_class ) . ' product_type_' . esc_attr( $product->get_type() ) . '">Submit</a>';
						} else {
							echo esc_html( "No Quote Types Found" );
						}
						echo '</div>';
					} else {
						$default_quote_id = 0;
						$default_quote_title = '';
						$context_key = get_current_user_contextual_quote_type_key();
						if (is_object($addify_rfq) && is_object($addify_rfq->quote_types_obj)) {
							$quote_types = $addify_rfq->quote_types_obj->afrfq_get_all_quote_types();
							foreach ($quote_types as $quote_type) {
								$quote_type_id = intval($quote_type->ID);
								$quote_type_title = $quote_type->post_title;
								
								if (trim($quote_type_title) === 'Job Quote Request') {
									$default_quote_id = $quote_type_id;
									$default_quote_title = $quote_type_title;
									break;
								}
							}
						}
						echo '<a href="javascript:void(0)" 
								data-user_type = "general"
								rel="nofollow" 
								data-product_id="' . intval($product->get_ID()) . '" 
								data-product_sku="' . esc_attr($product->get_sku()) . '" 
								data-quote_id="' . esc_attr($default_quote_id) . '" 
								data-quote_title="' . esc_attr($default_quote_title) . '" 
								class="afrfqbt_single_page single_add_to_cart_button button alt ' . esc_attr($disable_class) . ' product_type_' . esc_attr($product->get_type()) . '">' 
								. esc_attr($afrfq_custom_button_text) . 
							'</a>';
					}
					array_push( self::$rule_applied, $rule->ID );

				} elseif ( 'addnewbutton_custom' === $afrfq_is_hide_addtocart || 'replace_custom' === $afrfq_is_hide_addtocart ) {

					if ( ! empty( $afrfq_custom_button_text ) ) {

						echo '<a href="' . esc_url( $afrfq_custom_button_link ) . '" rel="nofollow" class="button product_type_' . esc_attr( $product->get_type() ) . '">' . esc_attr( $afrfq_custom_button_text ) . '</a>';

					}
					array_push( self::$rule_applied, $rule->ID );
				}
			}
		}
	}

	new AF_R_F_Q_Main();
}
