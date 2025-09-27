<?php
/**
 * Addify Add to Quote
 *
 * The WooCommerce quote class stores quote data and maintain session of quotes.
 * The quote class also has a price calculation function which calls upon other classes to calculate totals.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

use Crown\Exceptions\DuplicatePONumberException;
use Crown\Exceptions\EmptyPONumberException;

/**
 * AF_R_F_Q_Quote class.
 */
class AF_R_F_Q_Quote {

	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	public $quote_contents = array();

	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	public $quote_subtotal = 0;

	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	public $quote_tax_total = 0;

	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	public $offered_total = 0;

	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	public $quote_total = 0;
	/**
	 * Total defaults used to reset.
	 *
	 * @var array
	 */
	protected $default_totals = array(
		'subtotal'            => 0,
		'subtotal_tax'        => 0,
		'shipping_total'      => 0,
		'shipping_tax'        => 0,
		'shipping_taxes'      => array(),
		'discount_total'      => 0,
		'discount_tax'        => 0,
		'cart_contents_total' => 0,
		'cart_contents_tax'   => 0,
		'cart_contents_taxes' => array(),
		'fee_total'           => 0,
		'fee_tax'             => 0,
		'fee_taxes'           => array(),
		'total'               => 0,
		'total_tax'           => 0,
	);
	/**
	 * Store calculated totals.
	 *
	 * @var array
	 */
	protected $totals = array();

	/**
	 * Constructor for the Add_To_Quote class. Loads quote contents.
	 */
	public function __construct( $quote_contents_arr = array() ) {

		$this->quote_contents = $quote_contents_arr;

		if ( empty( $this->quote_contents ) && isset( WC()->session ) ) {
			$this->quote_contents = (array) WC()->session->get( 'quotes' );
		}

	}

	/**
	 * Get subtotal.
	 *
	 * @since 3.2.0
	 * @return float
	 */
	public function get_subtotal_tax() {
		return apply_filters( 'addify_quote_' . __FUNCTION__, $this->get_totals_var( 'subtotal_tax' ) );
	}

	/**
	 * Get a total.
	 *
	 * @since 3.2.0
	 * @param string $key Key of element in $totals array.
	 * @return mixed
	 */
	protected function get_totals_var( $key ) {
		return isset( $this->totals[ $key ] ) ? $this->totals[ $key ] : $this->default_totals[ $key ];
	}

	/**
	 * Returns 'incl' if tax should be included in cart, otherwise returns 'excl'.
	 *
	 * @return string
	 */
	public function get_tax_price_display_mode() {
		if ( WC()->customer && WC()->customer->get_is_vat_exempt() ) {
			return 'excl';
		}

		return get_option( 'woocommerce_tax_display_cart' );
	}

	/**
	 * Return whether or not the cart is displaying prices including tax, rather than excluding tax.
	 *
	 * @since 3.3.0
	 * @return bool
	 */
	public function display_prices_including_tax() {
		return apply_filters( 'addify_quote_' . __FUNCTION__, 'incl' === $this->get_tax_price_display_mode() );
	}

	/**
	 * Get the product row price per item.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get_product_price( $product, $args = array(), $view = 'view' ) {

		if ( $this->display_prices_including_tax() ) {
			$product_price = wc_get_price_including_tax( $product, $args );
		} else {
			$product_price = wc_get_price_excluding_tax( $product, $args );
		}

		if ( 'edit' == $view ) {
			return $product_price;
		}

		$price_suffix = 'incl' === get_option( 'woocommerce_tax_display_cart' ) ? wc()->countries->inc_tax_or_vat() : '';

		$price_suffix = '<small>' . $price_suffix . '</small>';
		
		return apply_filters( 'addify_quote_product_price', wc_price( $product_price ) . ' ' . $price_suffix, $product );
	}

	/**
	 * Get the quote subtotal.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function calculate_totals() {

		if ( is_admin() ) {
			return;
		}

		$this->quote_subtotal  = 0;
		$this->quote_tax_total = 0;
		$this->quote_total     = 0;
		$this->_offered_total  = 0;

		if ( empty( $this->quote_contents ) && isset( WC()->session ) ) {
			$this->quote_contents = WC()->session->get( 'quotes' );
		}

		foreach ( (array) $this->quote_contents as $quote_item_key => $quote_item ) {

			if ( ! isset( $quote_item['data'] ) || ! is_object( $quote_item['data'] ) ) {
				return;
			}

			$product       = apply_filters( 'addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key );
			$quantity      = $quote_item['quantity'];
			$price         = $product->get_price();
			$offered_price = isset( $quote_item['offered_price'] ) ? floatval( $quote_item['offered_price'] ) : $price;

			$this->_offered_total += $offered_price * intval( $quantity );

			if ( $product->is_taxable() ) {

				if ( ! wc_prices_include_tax() ) {
					$product_subtotal = wc_get_price_including_tax( $product, array( 'qty' => $quantity ) );
				} else {
					$product_subtotal = wc_get_price_excluding_tax( $product, array( 'qty' => $quantity ) );

				}

				$difference_price = ( $price * $quantity ) - $product_subtotal;

				if ( $difference_price < 0 ) {

					$difference_price = $difference_price * -1;
				}

				$this->quote_subtotal  += $price * $quantity;
				$this->quote_tax_total += $difference_price;

			} else {
				$product_subtotal       = $price * $quantity;
				$this->quote_subtotal  += $product_subtotal;
				$this->quote_tax_total += 0;
			}
		}

		$this->quote_total = $this->quote_subtotal + $this->quote_tax_total;
	}

	/**
	 * Get the quote subtotal.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get_calculated_totals( $contents = array(), $quote_id = 0 ) {

	$_shipping_cost = 0;
	if ( !empty( $quote_id ) ) {
		$_shipping_cost = get_post_meta( $quote_id, 'afrfq_shipping_cost', true );
	}

	$quote_totals = array(
		'_subtotal'       => 0,
		'_offered_total'  => 0,
		'_approved_total'  => 0,
		'_tax_total'      => 0,
		'_shipping_total' => floatval( $_shipping_cost ),
		'_total'          => 0,
	);

	if ( empty( $contents ) ) {

		if ( isset( WC()->session ) ) {
			$contents = WC()->session->get( 'quotes' );
		}

		if ( empty( $contents ) ) {
			return $quote_totals;
		}
	}

	foreach ( $contents as $quote_item_key => $quote_item ) {

		if ( ! isset( $quote_item['data'] ) ) {
			continue;
		}

		$product = apply_filters( 'addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key );
		$quantity = $quote_item['quantity'];

		if ( $product instanceof WC_Product ) { // Check if it's a product

			$price         = empty( $quote_item['addons_price'] ) ? $product->get_price() : $quote_item['addons_price'];
			$price         = empty( $quote_item['role_base_price'] ) ? $price : $quote_item['role_base_price'];
			$offered_price_per_each = isset( $quote_item['offered_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $quote_item['offered_price_per_each'] ) ) : $price;
			$approved_price_per_each = isset( $quote_item['approved_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $quote_item['approved_price_per_each'] ) ) : $offered_price_per_each;

			 $quote_totals['_offered_total'] += $offered_price_per_each * intval( $quantity );
			 $quote_totals['_approved_total'] += $approved_price_per_each * intval( $quantity );

			if ( $product->is_taxable() ) {

				if ( ! wc_prices_include_tax() ) {
					$product_subtotal = wc_get_price_including_tax( $product, array( 'qty' => $quantity, 'price' => $price ) );
				} else {
					$product_subtotal = wc_get_price_excluding_tax( $product, array( 'qty' => $quantity, 'price' => $price ) );
				}

				$difference_price = ( $price * $quantity ) - $product_subtotal;

				if ( $difference_price < 0 ) {

					$difference_price = $difference_price * -1;
				}

				$quote_totals['_subtotal']  += $price * $quantity;
				$quote_totals['_tax_total'] += $difference_price;

			} else {
				$product_subtotal            = $price * $quantity;
				$quote_totals['_subtotal']  += $product_subtotal;
				$quote_totals['_tax_total'] += 0;
			}
		} else {
			// It's a pricing group (stdClass object)
             // Set default values
            $group_price = 0;  // No inherent price for the group
            $tax = 0;

            // Add 0 to those parameters, without this some math can be broken
            $quote_totals['_subtotal'] += $group_price;
            $quote_totals['_offered_total'] += $group_price;
            $quote_totals['_approved_total'] += $group_price;
            $quote_totals['_tax_total'] += $tax;
		}
	}

	$quote_totals['_total'] = $quote_totals['_subtotal'] + $quote_totals['_tax_total'] + $quote_totals['_shipping_total'];

	return $quote_totals;
}

	/**
	 * Get the product row price per item.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get_quote_subtotal() {

		$quote_subtotal = wc_price( $this->quote_subtotal );

		return apply_filters( 'addify_quote_subtotal', $quote_subtotal, $this->quote_contents );
	}

	/**
	 * Get the product row price per item.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get_quote_offered_subtotal() {

		$quote_subtotal = wc_price( $this->_offered_total );

		return apply_filters( 'addify_quote__offered_total', $quote_subtotal, $this->quote_contents );
	}

	/**
	 * Get the product row price per item.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get_quote_total() {

		$quote_total = wc_price( $this->quote_total );

		return apply_filters( 'addify_quote_total', $quote_total, $this->quote_contents );
	}

	/**
	 * Get the product row price per item.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get_quote_tax_total() {

		$quote_tax_total = wc_price( $this->quote_tax_total );

		return apply_filters( 'addify_quote_tax_total', $quote_tax_total, $this->quote_contents );
	}

	/**
	 * Get the product row price per item.
	 *
	 * @param WC_Product $product Product object.
	 * @return string formatted price
	 */
	public function get__offered_total() {

		$offered_total = wc_price( $this->_offered_total );

		return apply_filters( 'addify_quote_tax_total', $offered_total, $this->quote_contents );
	}

	public function add_tax_product_price( $price, $product ) {

		$return_price = $price;

		if ( wc_tax_enabled() ) {

			if ( 'no' === get_option( 'woocommerce_prices_include_tax' ) ) {

				$tax_rates = WC_Tax::get_rates( $product->get_tax_class() );
				$taxes     = WC_Tax::calc_tax( $price, $tax_rates, false );

				if ( 'yes' === get_option( 'woocommerce_tax_round_at_subtotal' ) ) {
					$taxes_total = array_sum( $taxes );
				} else {
					$taxes_total = array_sum( array_map( 'wc_round_tax_total', $taxes ) );
				}

				$return_price = round( $price + $taxes_total, wc_get_price_decimals() );

				return $return_price;
			}
		}

		return $return_price;
	}

	/**
	 * Get the product row subtotal.
	 *
	 * Gets the tax etc to avoid rounding issues.
	 *
	 * When on the checkout (review order), this will get the subtotal based on the customer's tax rate rather than the base rate.
	 *
	 * @param WC_Product $product Product object.
	 * @param int        $quantity Quantity being purchased.
	 * @return string formatted price
	 */
	public function get_product_offered_subtotal( $product, $price, $quantity ) {

		if ( $product->is_taxable() ) {

			if ( $this->display_prices_including_tax() ) {
				$row_price        = $this->add_tax_product_price( $price, $product );
				$product_subtotal = wc_price( $row_price );

				if ( ! wc_prices_include_tax() && $this->quote_tax_total > 0 ) {
					$product_subtotal .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
				}
			} else {
				$row_price        = wc_get_price_excluding_tax( $product, array( 'qty' => $quantity ) );
				$product_subtotal = wc_price( $row_price );

				if ( wc_prices_include_tax() && $this->quote_tax_total > 0 ) {
					$product_subtotal .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
				}
			}
		} else {
			$row_price        = $price * $quantity;
			$product_subtotal = wc_price( $row_price );
		}

		return apply_filters( 'addify_quote_product_subtotal', $product_subtotal, $product, $quantity, $this );
	}


	/**
	 * Get the product row subtotal.
	 *
	 * Gets the tax etc to avoid rounding issues.
	 *
	 * When on the checkout (review order), this will get the subtotal based on the customer's tax rate rather than the base rate.
	 *
	 * @param WC_Product $product Product object.
	 * @param int        $quantity Quantity being purchased.
	 * @return string formatted price
	 */
	public function get_product_subtotal( $product, $quantity, $args = array() ) {
		$price = empty( $args['price'] ) ? $product->get_price() : $args['price'];

		if ( $product->is_taxable() ) {

			if ( $this->display_prices_including_tax() ) {
				$row_price        = wc_get_price_including_tax( $product, $args );
				$product_subtotal = wc_price( $row_price );

				if ( ! wc_prices_include_tax() && $this->quote_tax_total > 0 ) {
					$product_subtotal .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
				}
			} else {
				$row_price        = wc_get_price_excluding_tax( $product, $args );
				$product_subtotal = wc_price( $row_price );

				if ( wc_prices_include_tax() && $this->quote_tax_total > 0 ) {
					$product_subtotal .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
				}
			}
		} else {
			$row_price        = $price * $quantity;

			$product_subtotal = wc_price( $row_price );
		}

		return apply_filters( 'addify_quote_product_subtotal', $product_subtotal, $product, $quantity, $this );
	}

	public function check_quote_availability_for_variation( $variation_id  ) {

		if ( empty( $variation_id ) ) {
			return true;
		}

		$variation_avaiable = get_post_meta( $variation_id, 'disable_rfq', true );

		if ( !empty( $variation_avaiable ) && 'show' !== $variation_avaiable ) {
			return false;
		}

		$variation = wc_get_product( $variation_id );

		if ( ! $variation->is_in_stock() && 'yes' !== get_option( 'enable_o_o_s_products' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Add a product to the Quote.
	 *
	 * @throws Exception Plugins can throw an exception to prevent adding to quote.
	 * @param int   $product_id contains the id of the product to add to the quote.
	 * @param int   $quantity contains the quantity of the item to add.
	 * @param int   $variation_id ID of the variation being added to the quote.
	 * @param array $variation attribute values.
	 * @param array $quote_item_data extra quote item data we want to pass into the item.
	 * @return string|bool $quote_item_key
	 */
	public function add_to_quote( $form_data, $product_id = 0, $quantity = 1, $variation_id = 0, $variation = array(), $quote_item_data = array(), $return_contents = false ) {
		try {
            $rfq_lines_limit = defined('AFRFQ_MAX_ROWS_ALLOWED') ? AFRFQ_MAX_ROWS_ALLOWED : 200;
			$product_id   = absint( $product_id );
			$variation_id = absint( $variation_id );

			// Ensure we don't add a variation to the quote directly by variation ID.
			if ( 'product_variation' === get_post_type( $product_id ) ) {
				$variation_id = $product_id;
				$product_id   = wp_get_post_parent_id( $variation_id );
			}

			$product_data = wc_get_product( $variation_id ? $variation_id : $product_id );
			$quantity     = apply_filters( 'addify_add_to_quote_quantity', $quantity, $product_id );

			if ( $quantity <= 0 || ! $product_data || 'trash' === $product_data->get_status() ) {
				return false;
			}

			if ( $product_data->is_type( 'variation' ) ) {
				$missing_attributes = array();
				$parent_data        = wc_get_product( $product_data->get_parent_id() );

				$variation_attributes = $product_data->get_variation_attributes();
				// Filter out 'any' variations, which are empty, as they need to be explicitly specified while adding to quote.
				$variation_attributes = array_filter( $variation_attributes );

				// Gather posted attributes.
				$posted_attributes = array();
				foreach ( $parent_data->get_attributes() as $attribute ) {
					if ( ! $attribute['is_variation'] ) {
						continue;
					}
					$attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );

					if ( isset( $variation[ $attribute_key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						if ( $attribute['is_taxonomy'] ) {
							// Don't use wc_clean as it destroys sanitized characters.
							$value = sanitize_title( wp_unslash( $variation[ $attribute_key ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						} else {
							$value = html_entity_decode( wc_clean( wp_unslash( $variation[ $attribute_key ] ) ), ENT_QUOTES, get_bloginfo( 'charset' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						}

						// Don't include if it's empty.
						if ( ! empty( $value ) || '0' === $value ) {
							$posted_attributes[ $attribute_key ] = $value;
						}
					}
				}

				// Merge variation attributes and posted attributes.
				$posted_and_variation_attributes = array_merge( $variation_attributes, $posted_attributes );

				// If no variation ID is set, attempt to get a variation ID from posted attributes.
				if ( empty( $variation_id ) ) {
					$data_store   = WC_Data_Store::load( 'product' );
					$variation_id = $data_store->find_matching_product_variation( $parent_data, $posted_attributes );
				}

				// Do we have a variation ID?
				if ( empty( $variation_id ) ) {
					throw new Exception( __( 'Please choose product options&hellip;', 'addify_rfq' ) );
				}

				// Do we have a variation ID?
				if ( ! $this->check_quote_availability_for_variation( $variation_id  ) ) {
					throw new Exception( __( 'Quote is not permitted for selected variation &hellip;', 'addify_rfq' ) );
				}

				// Check the data we have is valid.
				$variation_data = wc_get_product_variation_attributes( $variation_id );
				$attributes     = array();

				foreach ( $parent_data->get_attributes() as $attribute ) {
					if ( ! $attribute['is_variation'] ) {
						continue;
					}

					// Get valid value from variation data.
					$attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );
					$valid_value   = isset( $variation_data[ $attribute_key ] ) ? $variation_data[ $attribute_key ] : '';

					/**
					 * If the attribute value was posted, check if it's valid.
					 *
					 * If no attribute was posted, only error if the variation has an 'any' attribute which requires a value.
					 */
					if ( isset( $posted_and_variation_attributes[ $attribute_key ] ) ) {
						$value = $posted_and_variation_attributes[ $attribute_key ];

						// Allow if valid or show error.
						if ( $valid_value === $value ) {
							$attributes[ $attribute_key ] = $value;
						} elseif ( '' === $valid_value && in_array( $value, $attribute->get_slugs(), true ) ) {
							// If valid values are empty, this is an 'any' variation so get all possible values.
							$attributes[ $attribute_key ] = $value;
						} else {
							/* translators: %s: Attribute name. */
							throw new Exception( sprintf( __( 'Invalid value posted for %s', 'addify_rfq' ), wc_attribute_label( $attribute['name'] ) ) );
						}
					} elseif ( '' === $valid_value ) {
						$missing_attributes[] = wc_attribute_label( $attribute['name'] );
					}

					$variation = $attributes;
				}
				if ( ! empty( $missing_attributes ) && ! is_admin() ) {
					/* translators: %s: Attribute name. */
					throw new Exception( sprintf( _n( '%s is a required field', '%s are required fields', count( $missing_attributes ), 'addify_rfq' ), wc_format_list_of_items( $missing_attributes ) ) );
				}
			}

			// Load quote item data - may be added by other plugins.
			$quote_item_data = (array) apply_filters( 'addify_add_quote_item_data', $quote_item_data, $product_id, $variation_id, $quantity, $form_data );

			// Generate a ID based on product ID, variation ID, variation data, and other quote item data.
			$quote_id = $this->generate_quote_id( $product_id, $variation_id, $variation, $quote_item_data );

			// Find the quote item key in the existing quote.
			$quote_item_key = $this->find_product_in_quote( $quote_id );

			// Force quantity to 1 if sold individually and check for existing item in quote.
			if ( $product_data->is_sold_individually() ) {
				$quantity       = apply_filters( 'addify_add_to_quote_sold_individually_quantity', 1, $quantity, $product_id, $variation_id, $quote_item_data );
				$found_in_quote = apply_filters( 'addify_add_to_quote_sold_individually_found_in_quote', $quote_item_key && $this->quote_contents[ $quote_item_key ]['quantity'] > 0, $product_id, $variation_id, $quote_item_data, $quote_id );

				if ( $found_in_quote ) {
					/* translators: %s: product name */
					$message = sprintf( __( 'You cannot add another "%s" to your quote.', 'addify_rfq' ), $product_data->get_name() );

					/**
					 * Filters message about more than 1 product being added to quote.
					 *
					 * @since 4.5.0
					 * @param string     $message Message.
					 * @param WC_Product $product_data Product data.
					 */
					$message = apply_filters( 'addify_quote_product_cannot_add_another_message', $message, $product_data );

					throw new Exception( sprintf( '<a href="%s" class="button wc-forward">%s</a> %s', '', __( 'View Quote', 'addify_rfq' ), $message ) );
				}
			}

			if ( ! $product_data->is_purchasable() ) {
				$message = __( 'Sorry, this product cannot be purchased.', 'addify_rfq' );
				/**
				 * Filters message about product unable to be purchased.
				 *
				 * @since 3.8.0
				 * @param string     $message Message.
				 * @param WC_Product $product_data Product data.
				*/

				$message = apply_filters( 'addify_quote_product_cannot_be_purchased_message', $message, $product_data );
				throw new Exception( $message );
			}

			// If quote_item_key is set, the item is already in the quote.
			if ( ! empty( $quote_item_key ) ) {

                $this->quote_contents[$quote_item_key]['quantity'] += intval($quantity);
            } elseif ( count( $this->quote_contents ) >= $rfq_lines_limit ) {
                $message = sprintf( __('You can only add up to %d different SKUs to the quote.', 'addify_rfq'), $rfq_lines_limit );
                wc_add_notice( $message, 'error' );
                die('failed');
			} else {
				$quote_item_key = $quote_id;

				$incr_offered_price = floatval( get_option( 'afrfq_enable_off_price_increase' ) );

                $offered_price_per_each = $product_data->get_price();

				$args          = array(
					'qty'   => 1,
					'price' => $offered_price_per_each,
				);
                $offered_price_per_each = $this->get_product_price( $product_data, $args, 'edit' );

				if ( !empty( $incr_offered_price ) ) {

                    $offered_price_per_each += ( $incr_offered_price * $product_data->get_price() ) / 100;
				}
                if ( !empty($form_data['quote_id']) ) {
                    $price_base_type = get_post_meta( $form_data['quote_id'], '_price_base_type', true );
                } else {
                    $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
                }
                $price_qty_multiplier = $this->get_price_qty_multiplier($price_base_type, $product_data->get_id());
                $offered_price = $offered_price_per_each * $price_qty_multiplier;
				$offered_price = number_format( $offered_price, 2 );

				// Add item after merging with $quote_item_data - hook to allow plugins to modify quote item.
				$this->quote_contents[ $quote_item_key ] = apply_filters(
					'addify_add_quote_item',
					array_merge(
						$quote_item_data,
						array(
							'key'           => $quote_item_key,
							'product_id'    => $product_id,
							'variation_id'  => $variation_id,
							'variation'     => $variation,
							'quantity'      => $quantity,
							'offered_price' => $offered_price,
                            'offered_price_per_each' => $offered_price_per_each,
							'role_base_price' => $product_data->get_price(),
							'data'          => $product_data,
							'data_hash'     => wc_get_cart_item_data_hash( $product_data ),
						)
					),
					$quote_item_key
				);
			}

			$this->quote_contents = apply_filters( 'addify_quote_contents_changed', $this->quote_contents );

			if ( $return_contents ) {
				return $this->quote_contents;
			} else {

                if ( is_user_logged_in() ) {
                    Nsi_Helper::update_addify_quote_user_meta( $this->quote_contents );
                }

				wc()->session->set( 'quotes', $this->quote_contents );

				do_action('addify_quote_session_changed');
			}

			do_action( 'addify_add_to_quote', $quote_item_key, $product_id, $quantity, $variation_id, $variation, $quote_item_data );

			return $quote_item_key;

		} catch ( Exception $e ) {
			if ( $e->getMessage() && ! is_admin() ) {
				wc_add_notice( $e->getMessage(), 'error' );
			}
			return false;
		}
	}

	/**
	 * Generate a unique ID for the quote item being added.
	 *
	 * @param int   $product_id - id of the product the key is being generated for.
	 * @param int   $variation_id of the product the key is being generated for.
	 * @param array $variation data for the quote item.
	 * @param array $quote_item_data other quote item data passed which affects this items uniqueness in the quote.
	 * @return string quote item key
	 */
	public function generate_quote_id( $product_id, $variation_id = 0, $variation = array(), $quote_item_data = array() ) {
		$id_parts = array( $product_id );

		if ( $variation_id && 0 !== $variation_id ) {
			$id_parts[] = $variation_id;
		}

		if ( is_array( $variation ) && ! empty( $variation ) ) {
			$variation_key = '';
			foreach ( $variation as $key => $value ) {
				$variation_key .= trim( $key ) . trim( $value );
			}
			$id_parts[] = $variation_key;
		}

		if ( is_array( $quote_item_data ) && ! empty( $quote_item_data ) ) {
			$quote_item_data_key = '';
			foreach ( $quote_item_data as $key => $value ) {
				if ( is_array( $value ) || is_object( $value ) ) {
					$value = http_build_query( $value );
				}
				$quote_item_data_key .= trim( $key ) . trim( $value );

			}
			$id_parts[] = $quote_item_data_key;
		}

		return apply_filters( 'addify_quote_id', md5( implode( '_', $id_parts ) ), $product_id, $variation_id, $variation, $quote_item_data );
	}

	/**
	 * Check if product is in the quote and return quote item key.
	 *
	 * Cart item key will be unique based on the item and its properties, such as variations.
	 *
	 * @param mixed $quote_id id of product to find in the quote.
	 * @return string quote item key
	 */
	public function find_product_in_quote( $quote_key = false ) {
		if ( false !== $quote_key ) {
			if ( is_array( $this->quote_contents ) && isset( $this->quote_contents[ $quote_key ] ) ) {
				return $quote_key;
			}
		}
		return '';
	}

	/**
	 * Convert quote to order.
	 *
	 * @param mixed $quote_id id of quote to convert.
	 */
	public function convert_quote_to_order( $quote_id = false ) {

		if ( false === $quote_id ) {
			wc_add_notice( __( 'Quote ID is required to convert a quote to order.', 'addify_rfq' ), 'error' );
			return false;
		}

		$quote_contents = get_post_meta( $quote_id, 'quote_contents', true );

		if ( empty( $quote_contents ) ) {
			wc_add_notice( __( 'Quote Contents are empty.', 'addify_rfq' ), 'error' );
			return false;
		}
        $price_base_type = get_post_meta( $quote_id, '_price_base_type', true );
        if ( empty($price_base_type) ) {
            $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
        }
		$quotes      = $quote_contents;
        $customer_id = get_post_meta( $quote_id, '_customer_user', true );

        try {
            $po_number = get_post_meta($quote_id, 'afrfq_field_6453540', true);
            Crown_Shop_Rfq::validate_po_number($customer_id, $po_number);
        } catch (DuplicatePONumberException|EmptyPONumberException $exc) {
            Crown_Shop_Rfq::render_error_exception($exc->getMessage(), 'addify_rfq');
            wp_safe_redirect(wp_get_referer());
            return false;
        }

		$quote_order = wc_create_order();
        $shipping_products_data = array();
		foreach ( $quote_contents as $quote_item_key => $quote_item ) {

			if ( isset( $quote_item['data'] ) ) {
				$product = $quote_item['data'];
			} else {
				continue;
			}

			if ( ! is_object( $product ) ) {
				continue;
			}
            $price_qty_multiplier = $this->get_price_qty_multiplier($price_base_type, $product->get_id());
			$price         = $product->get_price();
            $price         = $price * $price_qty_multiplier;
			$qty_display   = $quote_item['quantity'];
			$offered_price = isset( $quote_item['offered_price'] ) ? floatval( $quote_item['offered_price'] ) : $price;
			$approved_price = isset( $quote_item['approved_price'] ) ? floatval( $quote_item['approved_price'] ) : $offered_price;

            $product->set_price( $approved_price / $price_qty_multiplier );

			$item_id = $quote_order->add_product( $product, $qty_display );
			$item    = $quote_order->get_item( $item_id );

			if ( method_exists( $item, 'set_subtotal' ) ) $item->set_subtotal( ( $approved_price / $price_qty_multiplier ) * $qty_display );
			if ( method_exists( $item, 'set_total' ) ) $item->set_total( ( $approved_price / $price_qty_multiplier ) * $qty_display );
			$item->save();
			$quote_order->add_item( $item );

			if ( ! empty( $quote_item['addons'] ) && class_exists('WC_Product_Addons_Helper') ) {
				foreach ( $quote_item['addons'] as $addon ) {
					$key           = $addon['name'];
					$price_type    = $addon['price_type'];
					$product       = $item->get_product();
					$product_price = $product->get_price();

					/*
					 * For percentage based price type we want
					 * to show the calculated price instead of
					 * the price of the add-on itself and in this
					 * case its not a price but a percentage.
					 * Also if the product price is zero, then there
					 * is nothing to calculate for percentage so
					 * don't show any price.
					 */
					if ( $addon['price'] && 'percentage_based' === $price_type && 0 != $product_price ) {
						$addon_price = $product_price * ( $addon['price'] / 100 );
					} else {
						$addon_price = $addon['price'];
					}
					$price = html_entity_decode(
						wp_strip_all_tags( wc_price( WC_Product_Addons_Helper::get_product_addon_price_for_display( $addon_price, $product ) ) ),
						ENT_QUOTES,
						get_bloginfo( 'charset' )
					);

					/*
					 * If there is an add-on price, add the price of the add-on
					 * to the label name.
					 */
					if ( $addon['price'] && apply_filters( 'woocommerce_addons_add_price_to_name', true ) ) {
						$key .= ' (' . $price . ')';
					}

					if ( 'custom_price' === $addon['field_type'] ) {
						$addon['value'] = $addon['price'];
					}

					$item->add_meta_data( $key, $addon['value'] );
					$item->save();
				}
			}

            $shipping_products_data[] = $product->get_name() . ' &times; ' . $quote_item['quantity'];
		}

        $shipping_method = get_post_meta( $quote_id, 'afrfq_field_shipping_options', true );
        $shipping_methods = crown_get_zone_shipping_methods(0);
        if ( isset($shipping_methods[$shipping_method]) ) {
            $shipping_item = new WC_Order_Item_Shipping();
            $shipping_item->set_method_title( $shipping_methods[$shipping_method]['title'] );
            $shipping_item->set_method_id( $shipping_method );
            $shipping_item->add_meta_data( __('Items', 'woocommerce'), implode(', ', $shipping_products_data) );
            $quote_order->add_item( $shipping_item );
        }

		$quote_user = get_user_by( 'id', $customer_id );

		$af_fields_obj = new AF_R_F_Q_Quote_Fields();

		$billing_address  = $af_fields_obj->afrfq_get_billing_data( $quote_id );
		$shipping_address = $af_fields_obj->afrfq_get_shipping_data( $quote_id );

		$quote_order->set_address( $billing_address, 'billing' );
		$quote_order->set_address( $shipping_address, 'shipping' );
		$quote_order->set_customer_id( intval( $customer_id ) );
		$quote_order->calculate_totals(); // updating totals.

		$quote_order->save(); // Save the order data.

        $customer_shipping_account_number = get_post_meta( $quote_id, 'afrfq_field_cust_ship_acc_num', true );
        if ( !empty($customer_shipping_account_number) ) {
            $args = [
                'post_type' => 'af_c_fields'
            ];
            $posts = get_posts ( $args );
            foreach ( $posts ?? [] as $post ) {
                if ( strtolower($post->post_title) == 'customer shipping account number' ) {
                    update_post_meta( $quote_order->get_id(), 'af_c_f_' . $post->ID, $customer_shipping_account_number );
                    break;
                }
            }
        }

		$current_user = wp_get_current_user();

		$current_user = isset( $current_user->ID ) ? (string) $current_user->user_login : get_post_meta( $quote_id, 'afrfq_name_field', true );

		update_post_meta( $quote_id, 'quote_status', 'af_converted' );
		update_post_meta( $quote_id, 'converted_by_user', $current_user );
		update_post_meta( $quote_id, 'converted_by', __( 'Distributor', 'addify_rfq' ) );

		do_action('addify_rfq_quote_converted_to_order', $quote_order->get_id(), $quote_id );
		
		do_action( 'addify_rfq_send_quote_email_to_customer', $quote_id );
		do_action( 'addify_rfq_send_quote_email_to_admin', $quote_id );

		/* translators: %1$s: Customer billing full name */
		/* translators:%2$s: Customer billing full name */
		wc_add_notice( sprintf( __( 'Your Quote# %1$s has been converted to Order# %2$s.', 'addify_rfq' ), $quote_id, $quote_order->get_id() ), 'success' );
		wp_safe_redirect( $quote_order->get_view_order_url() );
		exit;
	}

	/**
	 * Convert quote to order.
	 *
	 * @param mixed $quote_id id of quote to convert.
	 */
	public function insert_new_quote( $post_data = array() ) {

		if ( empty( $post_data ) || ! is_array( $post_data ) ) {
			if ( ! is_admin() ) {
				wc_add_notice( __( 'Post data should not be empty to create a quote.', 'addify_rfq' ), 'error' );
			}
			return;
		}

		if ( empty( wc()->session->get('quotes') ) ) {
			if ( ! is_admin() ) {
				wc_add_notice( __( 'No item found in quote basket.', 'addify_rfq' ), 'error' );
			}
			return;
		}
		
		$af_fields_obj = new AF_R_F_Q_Quote_Fields();
		$validation    = $af_fields_obj->afrfq_validate_fields_data( $post_data );

		if ( is_array( $validation ) ) {

			foreach ( $validation as $key => $message ) {

				if ( empty( $message ) ) {
					continue;
				}
				wc_add_notice( $message, 'error' );
			}
			return;
		}

		try {

			$quotes = WC()->session->get( 'quotes' );
            $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
			foreach ( WC()->session->get( 'quotes' ) as $quote_item_key => $quote_item ) {
                $price_qty_multiplier = $this->get_price_qty_multiplier($price_base_type, $quote_item['product_id']);
                if ( isset( $post_data['quote_qty'][ $quote_item_key ] ) ) {
					$quotes[ $quote_item_key ]['quantity'] = intval( $post_data['quote_qty'][ $quote_item_key ] );
				}
                if ( isset( $post_data['offered_price'][ $quote_item_key ] ) ) {
                    $offered_price = floatval( $post_data['offered_price'][ $quote_item_key ] );
                    $quotes[ $quote_item_key ]['offered_price'] = $offered_price;
                    $quotes[ $quote_item_key ]['offered_price_per_each'] = $offered_price / $price_qty_multiplier;
                }

                if ( isset( $post_data['approved_price'][ $quote_item_key ] ) ) {
                    $approved_price = floatval( $post_data['approved_price'][ $quote_item_key ] );
                    $quotes[ $quote_item_key ]['approved_price'] = $approved_price;
                    $quotes[ $quote_item_key ]['approved_price_per_each'] = $approved_price / $price_qty_multiplier;
                }
			}

			WC()->session->set( 'quotes', $quotes );

			do_action('addify_quote_session_changed');

			$quote = WC()->session->get( 'quotes' );

			$quote_args = array(
				'post_title'   => '',
				'post_content' => '',
				'post_status'  => 'publish',
				'post_type'    => 'addify_quote',
			);

			$quote_id = wp_insert_post( $quote_args );

			$user = wp_get_current_user();

			if ( is_a( $user, 'WP_User' ) ) {
				$customer_name = isset( $data['afrfq_name_field'] ) ? $data['afrfq_name_field'] : $user->display_name;
			} else {
				$customer_name = isset( $data['afrfq_name_field'] ) ? $data['afrfq_name_field'] : 'Guest';
			}

			$post_title = $customer_name . '( ' . $quote_id . ' )';
			$my_post    = array(
				'ID'         => $quote_id,
				'post_title' => $post_title,
			);

			wp_update_post( $my_post );

			// Save Quote Meta
			$selected_quote_type = get_post_meta( $quote_id, 'quote_type', true );
			$context_key = get_current_user_contextual_quote_type_key();
			// Save Quote Meta
			add_post_meta( $quote_id, 'quote_contents', WC()->session->get( 'quotes' ) );
			add_post_meta( $quote_id, '_customer_user', get_current_user_id() );
			add_post_meta( $quote_id, 'quote_status', 'af_pending' );

			if(!empty($selected_quote_type)){
				global $addify_rfq;
				if ( ! $addify_rfq->quote_types_obj ) {
					$addify_rfq->quote_types_obj = new AFRFQ_Quote_Types();
				}
				$quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $selected_quote_type );
					add_post_meta( $quote_id, 'quote_type', $selected_quote_type );
			}else {
				add_post_meta( $quote_id, 'quote_type', get_selected_quote_type_id() );
			}
			$quote_fields = $af_fields_obj->afrfq_get_fields_enabled();

			if ( !empty( $quote_fields ) && is_array( $quote_fields ) ) {
				
				foreach ( $quote_fields as $key => $field ) {

					$field_id          = $field->ID;
					$afrfq_field_name  = get_post_meta( $field_id, 'afrfq_field_name', true );
					$afrfq_field_type  = get_post_meta( $field_id, 'afrfq_field_type', true );
					$afrfq_field_label = get_post_meta( $field_id, 'afrfq_field_label', true );

					if ( isset( $post_data[ $afrfq_field_name ] ) && ! empty( $post_data[ $afrfq_field_name ] ) ) {

						if ( 'file' === $afrfq_field_type ) {

							$file        = isset( $post_data[ $afrfq_field_name ]['name'] ) ? time() . sanitize_text_field( $post_data[ $afrfq_field_name ]['name'] ) : time() ;
							$target_path = AFRFQ_PLUGIN_DIR . 'uploads/';
							$target_path = $target_path . $file;

							if ( isset( $post_data[ $afrfq_field_name ]['tmp_name'] ) ) {

								if ( move_uploaded_file( sanitize_text_field( $post_data[ $afrfq_field_name ]['tmp_name'] ), $target_path ) ) {

									update_post_meta( $quote_id, $afrfq_field_name, $file );
								}
							}
						} else {

							update_post_meta( $quote_id, $afrfq_field_name, $post_data[ $afrfq_field_name ] );
						}
					}
				}
			}

            if ( is_user_logged_in() ) {
                Nsi_Helper::update_addify_quote_user_meta( '' );
                $unique_id = Eleks_Carts_Management::get_user_unique_session_id($user->ID);
                Eleks_Carts_Management::clear_quotes_carts(0, $unique_id);
            }

			WC()->session->set( 'quotes', null );
			wc()->session->set( 'quote_fields_data', null );

			do_action( 'addify_quote_created', $quote_id );

			do_action( 'addify_rfq_send_quote_email_to_customer', $quote_id );
			do_action( 'addify_rfq_send_quote_email_to_admin', $quote_id );

			if ( !empty( get_option('afrfq_success_message') ) ) {
				wc_add_notice( __( get_option('afrfq_success_message'), 'addify_rfq'), 'success');
			} else {
				wc_add_notice( __('Your quote has been submitted successfully.', 'addify_rfq'), 'success');
			}

			if ( 'yes' === get_option('afrfq_redirect_after_submission') && !empty( get_option('afrfq_redirect_url') ) ) {
				$my_account_url = wc_get_page_permalink( 'myaccount' );
				wc()->session->set( $context_key, null );
				update_user_meta( get_current_user_id(), $context_key, null );
				if ( $my_account_url ) {
					wp_redirect( $my_account_url );
				} else {
					wp_redirect( esc_url( get_option('afrfq_redirect_url') ) );
				}
				exit;
			}

		} catch ( Exception $e ) {
			echo esc_html( $e->getMessage() );
		}
	}

    public function get_price_qty_multiplier($price_base_type, $product_id) {
        if ($price_base_type === 'moq') {
            $price_qty_multiplier = intval(get_post_meta($product_id, 'min_quantity', true));
            $price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
        } else {
            $price_qty_multiplier = get_post_meta($product_id, 'ns_price_qty_multiplier', true);
            $price_qty_multiplier = floatval($price_qty_multiplier) > 0 ? floatval($price_qty_multiplier) : 1;
        }
        return $price_qty_multiplier;
    }

	//Custom function to insert a new "Discount Pricing Group" quote.
	function insert_new_discount_quote( $post_data = array() ) {

		if ( empty( $post_data ) || ! is_array( $post_data ) ) {
			wc_add_notice( __( 'Form data is missing.', 'addify_rfq' ), 'error' );
			return;
		}

		$pricing_groups = WC()->session->get( 'quote_pricing_groups', array() );

		if ( empty( $pricing_groups ) ) {
			wc_add_notice( __( 'No pricing groups found in your quote request.', 'addify_rfq' ), 'error' );
			return;
		}

		$af_fields_obj = new AF_R_F_Q_Quote_Fields();
    	$all_quote_fields = (array) $af_fields_obj->quote_fields;
		$context_key = get_current_user_contextual_quote_type_key();
		$quote_type_id = get_selected_quote_type_id();
		foreach ( $all_quote_fields as $field ) {
			$field_id = $field->ID;
			$is_required = ( 'yes' === get_post_meta( $field_id, 'afrfq_field_required', true ) );

			if ( ! $is_required ) {
				continue;
			}

			$afrfq_field_quote_types = (array) get_post_meta( $field_id, 'afrfq_field_quote_types', true );
			$should_be_displayed = ! $quote_type_id || empty( $afrfq_field_quote_types ) || in_array( (string) $quote_type_id, $afrfq_field_quote_types, true );

			if ( $should_be_displayed ) {
				$field_name = get_post_meta( $field_id, 'afrfq_field_name', true );
				$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );

				if ( empty( $post_data[ $field_name ] ) ) {
					wc_add_notice( sprintf( esc_html__( '%s is a required field', 'addify_rfq' ), '<strong>' . esc_html( $field_label ) . '</strong>' ), 'error' );
				}
			}
		}
		if ( wc_notice_count( 'error' ) > 0 ) {
			return;
		}

		$quote_args = array(
			'post_title'   => '',
			'post_content' => '',
			'post_status'  => 'publish',
			'post_type'    => 'addify_quote',
		);
		$quote_id = wp_insert_post( $quote_args );

		if ( is_wp_error( $quote_id ) ) {
			wc_add_notice( __( 'There was an error creating your quote. Please try again.', 'addify_rfq' ), 'error' );
			return;
		}

		$user = wp_get_current_user();
		$customer_name = ( is_a( $user, 'WP_User' ) && !empty($user->display_name) ) ? $user->display_name : 'Guest';
		$post_title = $customer_name . '( ' . $quote_id . ' )';
		wp_update_post( array( 'ID' => $quote_id, 'post_title' => $post_title ) );
		add_post_meta( $quote_id, '_is_discount_rule_quote', 'yes' );
		add_post_meta( $quote_id, 'quote_type', $quote_type_id );
		add_post_meta( $quote_id, 'quote_pricing_groups', $pricing_groups );
		add_post_meta( $quote_id, '_customer_user', get_current_user_id() );
		add_post_meta( $quote_id, 'quote_status', 'af_pending' );

		$quote_fields = $af_fields_obj->afrfq_get_fields_enabled();
		if ( !empty( $quote_fields ) && is_array( $quote_fields ) ) {
			foreach ( $quote_fields as $key => $field ) {
				$field_id         = $field->ID;
				$afrfq_field_name = get_post_meta( $field_id, 'afrfq_field_name', true );
				if ( isset( $post_data[ $afrfq_field_name ] ) && ! empty( $post_data[ $afrfq_field_name ] ) ) {
					update_post_meta( $quote_id, $afrfq_field_name, $post_data[ $afrfq_field_name ] );
				}
			}
		}

		WC()->session->set( 'quote_pricing_groups', null );
		WC()->session->set( $context_key, null );
		if ( is_user_logged_in() ) {
			update_user_meta(get_current_user_id(),'quote_pricing_groups',null);
			update_user_meta( get_current_user_id(), $context_key ,null );
		}
		wc()->session->set( 'quote_fields_data', null );
		do_action( 'addify_discount_quote_created', $quote_id );
		do_action( 'addify_rfq_send_quote_email_to_customer', $quote_id );
		do_action( 'addify_rfq_send_quote_email_to_admin', $quote_id );

		$success_message = get_option('afrfq_success_message') ? get_option('afrfq_success_message') : __('Your quote has been submitted successfully.', 'addify_rfq');
		wc_add_notice( $success_message, 'success' );

		if ( 'yes' === get_option('afrfq_redirect_after_submission') && !empty( get_option('afrfq_redirect_url') ) ) {
			$my_account_url = wc_get_page_permalink( 'myaccount' );
			if ( $my_account_url ) {
				wp_redirect( $my_account_url );
			} else {
				wp_redirect( esc_url( get_option('afrfq_redirect_url') ) );
			}
			exit;
		}
	}

}
