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

/**
 * AF_R_F_Q_Quote class.
 */
class AF_R_F_Q_Ajax_Controller {
	/**
	 * AJAX: Check if quote type has discount rule enabled
	 */
	public function check_quote_type_discount_rule() {
		$quote_type_id = isset($_POST['quote_type_id']) ? intval($_POST['quote_type_id']) : 0;
		if (!$quote_type_id) {
			wp_send_json_error(['message' => 'No quote type ID provided', 'has_discount' => false]);
		}
		$has_discount = get_post_meta($quote_type_id, 'quote_type_discount_rules', true) === 'yes';
		wp_send_json_success(['has_discount' => $has_discount]);
	}
	/**
	 * AJAX: Delete pricing group from quote
	 */
	public function afrfq_delete_pricing_group_row() {
		check_ajax_referer( 'afquote-ajax-nonce', 'nonce' );
		$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
		$group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
		$groups = get_post_meta($post_id, 'quote_pricing_groups', true);
		if (!is_array($groups)) $groups = [];
		$groups = array_filter($groups, function($g) use ($group_id) {
			return isset($g['group_id']) && $g['group_id'] != $group_id;
		});
		update_post_meta($post_id, 'quote_pricing_groups', array_values($groups));
		wp_send_json(['success' => true]);
	}

	/**
	 * AJAX: Update pricing group in quote
	 */
	public function afrfq_update_pricing_group_row() {
		check_ajax_referer( 'afquote-ajax-nonce', 'nonce' );
		$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
		$group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
		$group_name = isset($_POST['group_name']) ? sanitize_text_field($_POST['group_name']) : '';
		$price_name = isset($_POST['price_name']) ? sanitize_text_field($_POST['price_name']) : '';
		$groups = get_post_meta($post_id, 'quote_pricing_groups', true);
		if (!is_array($groups)) $groups = [];
		foreach ($groups as &$g) {
			if ($g['group_id'] == $group_id) {
				$g['group_name'] = $group_name;
				$g['price_name'] = $price_name;
			}
		}
		update_post_meta($post_id, 'quote_pricing_groups', $groups);
		wp_send_json(['success' => true]);
	}

	/**
	 * AJAX: Search pricing groups for select2 dropdown
	 */
	public function afrfq_search_pricing_groups() {
		check_ajax_referer( 'afquote-ajax-nonce', 'nonce' );
		global $wpdb;
		$q = isset($_POST['q']) ? sanitize_text_field($_POST['q']) : '';
		$results = [];
		if ($q) {
			$groups = $wpdb->get_results( $wpdb->prepare(
				"SELECT id, group_name, price_name FROM {$wpdb->prefix}ns_groups_pricings WHERE group_name LIKE %s OR price_name LIKE %s LIMIT 20",
				'%' . $wpdb->esc_like($q) . '%',
				'%' . $wpdb->esc_like($q) . '%'
			));
		} else {
			$groups = $wpdb->get_results( "SELECT id, group_name, price_name FROM {$wpdb->prefix}ns_groups_pricings LIMIT 20" );
		}
		foreach ($groups as $group) {
			$results[] = [
				$group->id,
				$group->group_name . ' (' . $group->price_name . ')'
			];
		}
		wp_send_json($results);
	}

	/**
	 * AJAX: Add pricing group to quote (no price/qty)
	 */
	public function afrfq_insert_pricing_group_row() {
		check_ajax_referer( 'afquote-ajax-nonce', 'nonce' );
		$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
		$group_id = isset($_POST['group_id']) ? intval($_POST['group_id']) : 0;
		global $wpdb;
		$group = $wpdb->get_row($wpdb->prepare("SELECT group_name, price_name FROM {$wpdb->prefix}ns_groups_pricings WHERE id = %d", $group_id));
		if (!$group) {
			wp_send_json(['success' => false, 'message' => 'Group not found']);
		}
		$existing = get_post_meta($post_id, 'quote_pricing_groups', true);
		if (!is_array($existing)) $existing = [];
		$existing[] = [
			'group_id' => $group_id,
			'ns_group_id' => $group_id,
			'group_name' => $group->group_name,
			'price_name' => $group->price_name
		];
		update_post_meta($post_id, 'quote_pricing_groups', $existing);
		// Return the new row HTML for the table
		ob_start();
		echo '<tr><td>' . esc_html($group->group_name) . '</td><td>' . esc_html($group->price_name) . '</td></tr>';
		$row_html = ob_get_clean();
		wp_send_json(['success' => true, 'row_html' => $row_html]);
	}
	/**
	 * Contains an array of quote items.
	 *
	 * @var array
	 */
	public $quote_contents = array();

    public $rfq_lines_limit = 200;

	/**
	 * Constructor for the AF_R_F_Q_Ajax_Controller class. Loads quote contents.
	 */
	public function __construct() {
	add_action( 'wp_ajax_check_quote_type_discount_rule', array( $this, 'check_quote_type_discount_rule' ) );
	add_action( 'wp_ajax_afrfq_delete_pricing_group_row', array( $this, 'afrfq_delete_pricing_group_row' ) );
	add_action( 'wp_ajax_afrfq_update_pricing_group_row', array( $this, 'afrfq_update_pricing_group_row' ) );
		if ( defined( 'AFRFQ_MAX_ROWS_ALLOWED' ) ) {
			$this->rfq_lines_limit = AFRFQ_MAX_ROWS_ALLOWED;
		}

	// Register AJAX for pricing group search and add
	add_action( 'wp_ajax_afrfq_search_pricing_groups', array( $this, 'afrfq_search_pricing_groups' ) );
	add_action( 'wp_ajax_afrfq_insert_pricing_group_row', array( $this, 'afrfq_insert_pricing_group_row' ) );
	add_action( 'wp_ajax_nopriv_afrfq_insert_pricing_group_row', array( $this, 'afrfq_insert_pricing_group_row' ) );

		add_action( 'wp_ajax_add_to_quote', array( $this, 'afrfq_add_to_quote_callback_function' ) );
		add_action( 'wp_ajax_nopriv_add_to_quote', array( $this, 'afrfq_add_to_quote_callback_function' ) );

		add_action( 'wp_ajax_add_to_quote_single', array( $this, 'afrfq_add_to_quote_single_callback_function' ) );
		add_action( 'wp_ajax_nopriv_add_to_quote_single', array( $this, 'afrfq_add_to_quote_single_callback_function' ) );

		add_action( 'wp_ajax_add_to_quote_single_vari', array( $this, 'afrfq_add_to_quote_single_vari_callback_function' ) );
		add_action( 'wp_ajax_nopriv_add_to_quote_single_vari', array( $this, 'afrfq_add_to_quote_single_vari_callback_function' ) );

		add_action( 'wp_ajax_remove_quote_item', array( $this, 'afrfq_remove_quote_item_callback_function' ) );
		add_action( 'wp_ajax_nopriv_remove_quote_item', array( $this, 'afrfq_remove_quote_item_callback_function' ) );

		add_action( 'wp_ajax_update_quote_items', array( $this, 'afrfq_update_quote_items' ) );
		add_action( 'wp_ajax_nopriv_update_quote_items', array( $this, 'afrfq_update_quote_items' ) );

		add_action( 'wp_ajax_download_quote_in_pdf', array( $this, 'afrfq_download_quote_in_pdf' ) );
		add_action( 'wp_ajax_nopriv_download_quote_in_pdf', array( $this, 'afrfq_download_quote_in_pdf' ) );

		add_action( 'wp_ajax_check_availability_of_quote', array( $this, 'check_availability_of_quote' ) );
		add_action( 'wp_ajax_nopriv_check_availability_of_quote', array( $this, 'check_availability_of_quote' ) );

		add_action( 'wp_ajax_cache_quote_fields', array( $this, 'cache_quote_fields' ) );
		add_action( 'wp_ajax_nopriv_cache_quote_fields', array( $this, 'cache_quote_fields' ) );

		// Admin Ajax Hooks.
		add_action( 'wp_ajax_af_r_f_q_search_products', array( $this, 'af_r_f_q_search_products' ) );
		add_action( 'wp_ajax_afrfqsearchProduct_and_variation', array( $this, 'afrfqsearchProduct_and_variation' ) );
		add_action( 'wp_ajax_afrfq_insert_product_row', array( $this, 'afrfq_insert_product_row' ) );
		add_action( 'wp_ajax_afrfq_remove_product_row', array( $this, 'afrfq_remove_product_row' ) );
		add_action( 'wp_ajax_afrfq_delete_quote_item', array( $this, 'afrfq_delete_quote_item' ) );
		add_action( 'wp_ajax_afrfq_search_users', array( $this, 'afrfq_search_users' ) );

		add_action( 'wp_ajax_afrfq_insert_pricing_row', array( $this, 'afrfq_insert_pricing_row' ) );
		add_action( 'wp_ajax_afrfq_remove_pricing_row', array( $this, 'afrfq_remove_pricing_row' ) );
        add_action( 'wp_ajax_afrfq_update_discount_quote_items_profile', array( $this, 'afrfq_update_discount_quote_items_profile' ) );
		add_action( 'wp_ajax_nopriv_afrfq_update_discount_quote_items_profile', array( $this, 'afrfq_update_discount_quote_items_profile' ) );

        add_action( 'wp_ajax_afrfq_quote_page_add_product', array( $this, 'afrfq_quote_page_add_product' ) );
        add_action( 'wp_ajax_afrfq_update_quote_items_profile', array( $this, 'afrfq_update_quote_items_profile' ) );
		add_action( 'wp_ajax_nopriv_afrfq_update_quote_items_profile', array( $this, 'afrfq_update_quote_items_profile' ) );

		// frontend side discount hooks
		add_action( 'wp_ajax_afrfq_add_pricing_group_to_quote', array( $this, 'afrfq_add_pricing_group_to_quote' ) );
		add_action( 'wp_ajax_nopriv_afrfq_add_pricing_group_to_quote', array( $this, 'afrfq_add_pricing_group_to_quote' ) );
		add_action( 'wp_ajax_afrfq_remove_pricing_group_from_quote', array( $this, 'afrfq_remove_pricing_group_from_quote' ) );
		add_action( 'wp_ajax_nopriv_afrfq_remove_pricing_group_from_quote', array( $this, 'afrfq_remove_pricing_group_from_quote' ) );
		add_action( 'wp_ajax_afrfq_clear_pricing_groups_cart', array( $this, 'afrfq_clear_pricing_groups_cart' ) );
		add_action( 'wp_ajax_request_page_clear_quotes_cart', array( $this, 'request_page_clear_quotes_cart' ) );
	}
	

	public function cache_quote_fields() {

		$nonce = isset( $_POST['nonce'] ) && '' !== $_POST['nonce'] ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( !empty( $_POST['nonce'] ) && ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {
			die( 'Failed ajax security check!' );
		}

		if ( isset( $_POST['form_data'] ) ) {
			parse_str( sanitize_meta('', $_POST['form_data'], ''), $form_data );
		}

		$quote_fields_obj = new AF_R_F_Q_Quote_Fields();
		$quote_fields     = (array) $quote_fields_obj->quote_fields;
		$fields_data      = array();

		foreach ( $quote_fields as $key => $value ) {

			$field_id         = $value->ID;
			$afrfq_field_name = get_post_meta( $field_id, 'afrfq_field_name', true );

			if ( isset( $form_data[ $afrfq_field_name ] ) ) {
				$fields_data[$afrfq_field_name] = $form_data[ $afrfq_field_name ];
			}
		}

		wc()->session->set('quote_fields_data', $fields_data);
	}

	/**
	 * Search users by Ajax.
	 */
	public function check_availability_of_quote() {

		$nonce = isset( $_POST['nonce'] ) && '' !== $_POST['nonce'] ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( !empty( $_POST['nonce'] ) && ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {
			die( 'Failed ajax security check!' );
		}

		$variation_id = isset( $_POST['variation_id'] ) ? sanitize_text_field( wp_unslash( $_POST['variation_id'] ) ) : '';

		if ( empty( $variation_id ) ) {
			die();
		}

		$variation = wc_get_product( $variation_id );

		$variation_avaiable = get_post_meta( $variation_id, 'disable_rfq', true );

		ob_start();

		if ( in_array( $variation_avaiable, array( 'disabled_swap', 'hide_swap' ) ) ) : ?>

			<button type="submit" class="single_add_to_cart_button afrfq_single_page_atc button alt">
				<?php echo esc_html( $variation->single_add_to_cart_text() ); ?>
			</button>

			<?php 
		endif;

		$button = ob_get_clean();

		wp_send_json(
			array(
				'display' => $variation_avaiable,
				'button'  => $button,
			)
		);
	}


	/**
	 * Search users by Ajax.
	 */
	public function afrfq_search_users() {

		$nonce = isset( $_POST['nonce'] ) && '' !== $_POST['nonce'] ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( isset( $_POST['q'] ) && '' !== $_POST['q'] ) {
			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {
				die( 'Failed ajax security check!' );
			}
			$pro = sanitize_text_field( wp_unslash( $_POST['q'] ) );
		} else {
			$pro = '';
		}

		$data_array  = array();
		$users       = new WP_User_Query(
			array(
				'search'         => '*' . esc_attr( $pro ) . '*',
				'search_columns' => array(
					'user_login',
					'user_nicename',
					'user_email',
					'user_url',
				),
			)
		);
		$users_found = $users->get_results();

		if ( ! empty( $users_found ) ) {
			foreach ( $users_found as $user ) {
				$title        = $user->display_name . '(' . $user->user_email . ')';
				$data_array[] = array( $user->ID, $title ); // array( User ID, User name and email ).
			}
		}

		wp_send_json( $data_array );
		die();
	}

	public function afrfq_delete_quote_item() {

		if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
		} else {
			$nonce = 0;
		}

        if ( isset( $_POST['type'] ) && $_POST['type'] == 'profile' ) {
            $nonce_name = 'afrfq-profile-quote';
        } else {
            $nonce_name = 'afquote-ajax-nonce';
        }

		if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
			die( 'Failed ajax security check!' );
		}

		$quote_item_key = isset( $_POST['quote_key'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_key'] ) ) : '';
		$post_id        = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;

		$post = get_post( intval( $post_id ) );

		if ( ! $post ) {
			die( 'Quote Item not found' );
		}

		$quote_contents = get_post_meta( $post->ID, 'quote_contents', true );

		if ( isset( $quote_contents[ $quote_item_key ] ) ) {
			unset( $quote_contents[ $quote_item_key ] );
		}

		update_post_meta( $post->ID, 'quote_contents', $quote_contents );

		$af_quote       = new AF_R_F_Q_Quote( $quote_contents );
		$quote_contents = get_post_meta( $post->ID, 'quote_contents', true );
		$quote_totals   = $af_quote->get_calculated_totals( $quote_contents, $post->ID );

        $current_status = get_post_meta( $post_id, 'quote_status', true );
        $do_refresh = false;
        if ( $current_status == 'af_accepted' ) {
            $do_refresh = true;
            update_post_meta( $post_id, 'old_status', 'af_pending' );
            update_post_meta( $post_id, 'quote_status', 'af_pending' );
            do_action( 'addify_rfq_quote_status_updated', $post_id, 'af_pending', $current_status );
        }

		ob_start();
		include AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-details-table.php';
		$quote_table = ob_get_clean();

		wp_send_json(
			array(
				'quote-details-table' => $quote_table,
                'do-refresh' => $do_refresh,
			)
		);

		die();

	}

	public function afrfq_insert_product_row() {

		if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
            $nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
        } else {
            $nonce = 0;
        }

        if ( isset( $_POST['type'] ) && $_POST['type'] == 'profile' ) {
            $nonce_name = 'afrfq-profile-quote';
        } else {
            $nonce_name = 'afquote-ajax-nonce';
        }

        if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
            die( 'Failed ajax security check!' );
        }

        if ( isset( $_POST['form_data'] ) ) {
            parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $quote_form_data );
        } else {
            $quote_form_data = array();
        }

		$product_id = isset( $_POST['product_id'] ) ? intval( wp_unslash( $_POST['product_id'] ) ) : 0;
		$quantity   = isset( $_POST['quantity'] ) ? intval( wp_unslash( $_POST['quantity'] ) ) : 0;
		$post_id    = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
        $is_profile = isset($_POST['type']) && $_POST['type'] == 'profile';

		$post = get_post( intval( $post_id ) );

		if ( ! $post ) {
			die( 'post not found' );
		}
        $price_base_type = $this->get_price_base_type($post_id);
        $form_data['product_id'] = $product_id;
		$form_data['quantity']   = $quantity;
		$form_data['quote_id']   = $post_id;

        $min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
        if ( $min_qty != 0 && $min_qty != 1 && $min_qty != $quantity && $quantity % $min_qty != 0 ) {
            wp_send_json(
                array(
                    'success' => false,
                    'message' => 'Minimum allowed quantity is ' . $min_qty . '. Product quantity has to be equal to ' . $min_qty . ' or a multiple of it.'
                )
            );

            die();
        }

		$product = wc_get_product( $product_id );

		$quote_contents = (array) get_post_meta( $post->ID, 'quote_contents', true );
        foreach ( $quote_contents ?? [] as $quote_item_key => $quote_content ) {
            if ( !isset($quote_form_data['quote_qty'][$quote_item_key]) ) {
                unset($quote_contents[$quote_item_key]);
            }
        }
        if ( count( (array) ( $quote_form_data['quote_qty'] ?? array() ) ) >= $this->rfq_lines_limit ) {
            wp_send_json(
                array(
                    'success'  => false,
                    'message'  => sprintf( __('You can only add up to %d different SKUs to the quote.', 'addify_rfq'), $this->rfq_lines_limit ),
                )
            );
            die();
        }

        $af_quote = new AF_R_F_Q_Quote( $quote_contents );
        if ( empty($quote_contents) && !empty($af_quote->quote_contents) ) {
            $af_quote->quote_contents = array();
        }

        foreach ( $quote_form_data['quote_qty'] ?? [] as $quote_item_key => $value ) {
            if ( !isset($quote_contents[$quote_item_key]) ) {
                $quote_contents = $af_quote->add_to_quote(
                    $quote_form_data,
                    $quote_form_data['added_product_id'][$quote_item_key],
                    $quote_form_data['quote_qty'][$quote_item_key],
                    0, array(), array(), true
                );
            }
        }
        $quote_contents_orig = $quote_contents;
		$quote_contents = $af_quote->add_to_quote( $form_data, $product_id, $quantity, 0, array(), array(), true );

        $quote_contents = $this->update_quote_values( $quote_contents, $quote_form_data, $price_base_type );

		if ( is_array( $quote_contents ) ) {
			$quote_totals = $af_quote->get_calculated_totals( $quote_contents, $post_id );
			ob_start();

            if ( count($quote_contents) > count($quote_contents_orig) ) {
                if ( $is_profile ) {
                    wc_get_template(
                        'quote/quote-table-profile-row.php',
                        array(
                            'quote_contents' => $quote_contents,
                            'quote_post_id' => $post_id,
                        ),
                        '/woocommerce/addify/rfq/',
                        AFRFQ_PLUGIN_DIR . 'templates/'
                    );
                } else {
                    include AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-details-table-row.php';
                }
            } else {
                wp_send_json(
                    array(
                        'success'  => false,
                        'message'  => sprintf( __('Something went wrong, product “%s” was not added to the quote. Please check if product is not already added to the quote.', 'addify_rfq'), $product->get_name() ),
                    )
                );
                die();
            }

			$quote_table = ob_get_clean();
            ob_start();
            if ( $is_profile ) { ?>
                <tr class="cart-subtotal">
                    <th><?php esc_html_e( 'Subtotal (Standard)', 'addify_rfq' ); ?></th>
                    <td data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_subtotal'] ) ); ?></td>
                </tr>

                <tr class="cart-subtotal cart-requested-subtotal">
                    <th><?php esc_html_e( 'Requested Price Subtotal', 'addify_rfq' ); ?></th>
                    <td data-title="<?php esc_attr_e( 'Offered Price Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_offered_total'] ) ); ?></td>
                </tr>
                <?php
            } else {
                wc_get_template(
                    'quote/quote-table-totals.php',
                    array(
                        'quote_totals' => $quote_totals,
                        'price_base_type' => $price_base_type,
                        'quote_contents' => $quote_contents,
                    ),
                    '/woocommerce/addify/rfq/',
                    AFRFQ_PLUGIN_DIR . 'templates/'
                );
            }
            $quote_totals_html = ob_get_clean();

			wp_send_json(
				array(
					'success'             => true,
					'quote-details-table' => $quote_table,
                    'quote-totals'        => $quote_totals_html,
				)
			);

			die();

		} else {

			wp_send_json(
				array(
					'success'  => false,
					'message'  => sprintf( __('There are no products with SKUs “%s” or products are not purchasable .', 'addify_rfq'), $product->get_name() ),
				)
			);
			die();
		}
	}

	public function afrfq_insert_pricing_row() {
		if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
		} else {
			$nonce = 0;
		}
		if ( isset( $_POST['type'] ) && 'profile' === $_POST['type'] ) {
			$nonce_name = 'afrfq-profile-quote';
		} else {
			$nonce_name = 'afquote-ajax-nonce';
		}
		if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
			wp_send_json_error( array( 'message' => 'Failed ajax security check!' ) );
		}
		$post_id = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;

		if ( isset( $_POST['add_type'] ) && 'group' === $_POST['add_type'] ) {
			if ( isset( $_POST['form_data'] ) ) {
				parse_str( wp_unslash( $_POST['form_data'] ), $form_data );
			} else {
				$form_data = array();
			}

			$current_groups = $form_data['pricing_groups'] ?? array();

			$group_id_to_add = isset( $_POST['group_id'] ) ? intval( $_POST['group_id'] ) : 0;
			if ( empty( $group_id_to_add ) ) {
				wp_send_json_error( array( 'message' => 'Invalid pricing group ID provided.' ) );
			}

			if ( isset( $current_groups[ 'group_' . $group_id_to_add ] ) ) {
				wp_send_json_error( array( 'message' => 'This pricing group has already been added to the quote.' ) );
			}

			global $wpdb;
			$new_group_details = $wpdb->get_row( $wpdb->prepare(
				"SELECT group_name, price_name FROM {$wpdb->prefix}ns_groups_pricings WHERE id = %d",
				$group_id_to_add
			) );

			if ( ! $new_group_details ) {
				wp_send_json_error( array( 'message' => 'Could not find details for this pricing group.' ) );
			}

			$group_key = 'group_' . $group_id_to_add;
			$current_groups[ $group_key ] = array(
				'group_id'   => $group_id_to_add,
				'ns_group_id'=> $group_id_to_add,
				'group_name' => $new_group_details->group_name,
				'price_name' => $new_group_details->price_name,
			);

			ob_start();

			foreach ( $current_groups as $group_id_key => $group_data ) {
				?>
				<tr class="woocommerce-cart-form__quote-item cart_item" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">
					<td class="product-remove">
						<a href="#" class="remove remove-pricing-group" aria-label="<?php esc_attr_e( 'Remove this item', 'addify_rfq' ); ?>" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">&times;</a>
					</td>
					<td class="product-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
						<?php echo esc_html( $group_data['group_name'] ); ?>
					</td>
					<td class="product-price" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
						<?php echo esc_html( $group_data['price_name'] ); ?>
					</td>

					<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_name]" value="<?php echo esc_attr( $group_data['group_name'] ); ?>">
					<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][price_name]" value="<?php echo esc_attr( $group_data['price_name'] ); ?>">
					<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_id]" value="<?php echo esc_attr( $group_data['group_id'] ); ?>">
					<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][ns_group_id]" value="<?php echo esc_attr( $group_data['ns_group_id'] ); ?>">
				</tr>
				<?php
			}

			$all_rows_html = ob_get_clean();

			wp_send_json_success( array(
				'quote-details-table' => $all_rows_html,
			) );

		} else {
			if ( isset( $_POST['form_data'] ) ) {
				parse_str( sanitize_meta( '', wp_unslash( $_POST['form_data'] ), '' ), $quote_form_data );
			} else {
				$quote_form_data = array();
			}

				$product_id = isset( $_POST['product_id'] ) ? intval( wp_unslash( $_POST['product_id'] ) ) : 0;

				$price_base_type = $this->get_price_base_type( $post_id );
				$form_data['product_id'] = $product_id;
				$form_data['quote_id']   = $post_id;

				$product = wc_get_product( $product_id );

				$quote_contents = (array) get_post_meta( $post->ID, 'quote_contents', true );

				if ( count( (array) ( $quote_form_data['quote_qty'] ?? array() ) ) >= $this->rfq_lines_limit ) {
					wp_send_json_error( array( 'message' => sprintf( __( 'You can only add up to %d different SKUs to the quote.', 'addify_rfq' ), $this->rfq_lines_limit ) ) );
				}

				$af_quote = new AF_R_F_Q_Quote( $quote_contents );
				if ( empty( $quote_contents ) && ! empty( $af_quote->quote_contents ) ) {
					$af_quote->quote_contents = array();
				}

				foreach ( $quote_form_data['quote_qty'] ?? [] as $quote_item_key => $value ) {
					if ( ! isset( $quote_contents[ $quote_item_key ] ) ) {
						$quote_contents = $af_quote->add_to_quote(
							$quote_form_data,
							$quote_form_data['added_product_id'][ $quote_item_key ],
							0, array(), array(), true
						);
					}
				}
				$quote_contents_orig = $quote_contents;
				$quantity = 0;
				$quote_contents = $af_quote->add_to_quote( $form_data, $product_id, $quantity, array(), array(), true );
				$quote_contents = $this->update_quote_values( $quote_contents, $quote_form_data, $price_base_type );

				if ( is_array( $quote_contents ) ) {
					$quote_totals = $af_quote->get_calculated_totals( $quote_contents, $post_id );
					ob_start();

					if ( count( $quote_contents ) > count( $quote_contents_orig ) ) {
						if ( $is_profile ) {
							wc_get_template(
								'quote/quote-table-profile-row.php',
								array(
									'quote_contents' => $quote_contents,
									'quote_post_id' => $post_id,
								),
								'/woocommerce/addify/rfq/',
								AFRFQ_PLUGIN_DIR . 'templates/'
							);
						} else {
							include AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-details-table-row.php';
						}
					} else {
						wp_send_json_error( array( 'message' => sprintf( __( 'Something went wrong, product “%s” was not added. Check if it is already in the quote.', 'addify_rfq' ), $product->get_name() ) ) );
					}

					$quote_table = ob_get_clean();
					ob_start();
					if ( $is_profile ) {
						?>
						<tr class="cart-subtotal">
							<th><?php esc_html_e( 'Subtotal (Standard)', 'addify_rfq' ); ?></th>
							<td data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_subtotal'] ) ); ?></td>
						</tr>

						<tr class="cart-subtotal cart-requested-subtotal">
							<th><?php esc_html_e( 'Requested Price Subtotal', 'addify_rfq' ); ?></th>
							<td data-title="<?php esc_attr_e( 'Offered Price Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_offered_total'] ) ); ?></td>
						</tr>
						<?php
					} else {
						wc_get_template(
							'quote/quote-table-totals.php',
							array(
								'quote_totals' => $quote_totals,
								'price_base_type' => $price_base_type,
								'quote_contents' => $quote_contents,
							),
							'/woocommerce/addify/rfq/',
							AFRFQ_PLUGIN_DIR . 'templates/'
						);
					}
					$quote_totals_html = ob_get_clean();

					wp_send_json_success( array(
						'quote-details-table' => $quote_table,
						'quote-totals'        => $quote_totals_html,
					) );

				} else {
					wp_send_json_error( array( 'message' => sprintf( __( 'There are no products with SKUs “%s” or products are not purchasable.', 'addify_rfq' ), $product->get_name() ) ) );
				}
			}
		}

		public function afrfq_remove_product_row() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( isset( $_POST['type'] ) && $_POST['type'] == 'profile' ) {
				$nonce_name = 'afrfq-profile-quote';
			} else {
				$nonce_name = 'afquote-ajax-nonce';
			}

			if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
				die( 'Failed ajax security check!' );
			}

			if ( isset( $_POST['form_data'] ) ) {
				parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $quote_form_data );
			} else {
				$quote_form_data = array();
			}

			$post_id    = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
			$is_profile = isset($_POST['type']) && $_POST['type'] == 'profile';
			if ( isset( $_POST['quote_item_id'] )  ) {
				$quote_item_key_to_remove = $_POST['quote_item_id'];
			} else {
				die( 'Quote item key missing' );
			}

			$post = get_post( intval( $post_id ) );

			if ( ! $post ) {
				die( 'post not found' );
			}
			$price_base_type = $this->get_price_base_type($post_id);

			$quote_contents = (array) get_post_meta( $post->ID, 'quote_contents', true );
			foreach ( $quote_contents ?? [] as $quote_item_key => $quote_content ) {
				if ( !isset($quote_form_data['quote_qty'][$quote_item_key]) ) {
					unset($quote_contents[$quote_item_key]);
				}
			}

			$af_quote = new AF_R_F_Q_Quote( $quote_contents );
			if ( empty($quote_contents) && !empty($af_quote->quote_contents) ) {
				$af_quote->quote_contents = array();
			}

			foreach ( $quote_form_data['quote_qty'] ?? [] as $quote_item_key => $value ) {
				if ( $quote_item_key == $quote_item_key_to_remove ) {
					continue;
				}
				if ( !isset($quote_contents[$quote_item_key]) ) {
					$quote_contents = $af_quote->add_to_quote(
						$quote_form_data,
						$quote_form_data['added_product_id'][$quote_item_key],
						$quote_form_data['quote_qty'][$quote_item_key],
						0, array(), array(), true
					);
				}
			}

			if ( isset($quote_contents[$quote_item_key_to_remove]) ) {
				unset($quote_contents[$quote_item_key_to_remove]);
			}

			$quote_contents = $this->update_quote_values( $quote_contents, $quote_form_data, $price_base_type );

			if ( is_array( $quote_contents ) ) {
				//if quote_contents is empty, function takes quote from session - clear it before & restore after the function
				$quotes_session_tmp = WC()->session->get( 'quotes' );
				WC()->session->set( 'quotes', array() );
				$quote_totals = $af_quote->get_calculated_totals( $quote_contents, $post_id );
				WC()->session->set( 'quotes', $quotes_session_tmp );
				ob_start();
				if ( $is_profile ) { ?>
					<tr class="cart-subtotal">
						<th><?php esc_html_e( 'Subtotal (Standard)', 'addify_rfq' ); ?></th>
						<td data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_subtotal'] ) ); ?></td>
					</tr>

					<tr class="cart-subtotal cart-requested-subtotal">
						<th><?php esc_html_e( 'Requested Price Subtotal', 'addify_rfq' ); ?></th>
						<td data-title="<?php esc_attr_e( 'Offered Price Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_offered_total'] ) ); ?></td>
					</tr>
					<?php
				} else {
					wc_get_template(
						'quote/quote-table-totals.php',
						array(
							'quote_totals' => $quote_totals,
							'price_base_type' => $price_base_type,
							'quote_contents' => $quote_contents
						),
						'/woocommerce/addify/rfq/',
						AFRFQ_PLUGIN_DIR . 'templates/'
					);
				}
				$quote_totals_html = ob_get_clean();

				ob_start();
				if ( $is_profile ) {
					wc_get_template(
						'quote/quote-table-profile-row.php',
						array(
							'quote_contents' => $quote_contents,
							'quote_post_id' => $post_id,
						),
						'/woocommerce/addify/rfq/',
						AFRFQ_PLUGIN_DIR . 'templates/'
					);
				} else {
					include AFRFQ_PLUGIN_DIR . 'admin/meta-boxes/quotes/quote-details-table-row.php';
				}
				$quote_table = ob_get_clean();

				wp_send_json(
					array(
						'success'             => true,
						'quote-details-table' => $quote_table,
						'quote-totals'        => $quote_totals_html,
					)
				);

				die();

			} else {
				wp_send_json(
					array(
						'success'  => false,
						'message'  => 'Something went wrong, please try again',
					)
				);
				die();
			}
		}

		public function afrfq_remove_pricing_row() {

			// --- Step 1: Common validation ---
			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}
			if ( isset( $_POST['type'] ) && 'profile' === $_POST['type'] ) {
				$nonce_name = 'afrfq-profile-quote';
			} else {
				$nonce_name = 'afquote-ajax-nonce';
			}
			if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
				wp_send_json_error( array( 'message' => 'Failed ajax security check!' ) );
			}

			$post_id    = isset( $_POST['post_id'] ) ? intval( wp_unslash( $_POST['post_id'] ) ) : 0;
			$is_profile = isset( $_POST['type'] ) && 'profile' === $_POST['type'];

			if ( ! get_post( $post_id ) ) {
				wp_send_json_error( array( 'message' => 'Quote not found.' ) );
			}

			if ( isset( $_POST['form_data'] ) ) {
				parse_str( wp_unslash( $_POST['form_data'] ), $form_data );
			} else {
				wp_send_json_error( array( 'message' => 'Form data is missing.' ) );
			}

			if ( isset( $_POST['remove_type'] ) && 'group' === $_POST['remove_type'] ) {

				$group_key_to_remove = isset( $_POST['group_key_to_remove'] ) ? sanitize_text_field( $_POST['group_key_to_remove'] ) : null;
				if ( is_null( $group_key_to_remove ) || $group_key_to_remove === '' ) {
					wp_send_json_error( array( 'message' => 'Group key to remove is missing.' ) );
				}

				$current_groups = $form_data['pricing_groups'] ?? array();

				if ( isset( $current_groups[ $group_key_to_remove ] ) ) {
					unset( $current_groups[ $group_key_to_remove ] );
				}

				ob_start();

				if ( ! empty( $current_groups ) ) {
					foreach ( $current_groups as $group_id_key => $group_data ) {
						?>
						<tr class="woocommerce-cart-form__quote-item cart_item" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">
							<td class="product-remove">
								<a href="#" class="remove remove-pricing-group" aria-label="<?php esc_attr_e( 'Remove this item', 'addify_rfq' ); ?>" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">&times;</a>
							</td>
							<td class="product-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
								<?php echo esc_html( $group_data['group_name'] ); ?>
							</td>
							<td class="product-price" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
								<?php echo esc_html( $group_data['price_name'] ); ?>
							</td>

							<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_name]" value="<?php echo esc_attr( $group_data['group_name'] ); ?>">
							<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][price_name]" value="<?php echo esc_attr( $group_data['price_name'] ); ?>">
							<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_id]" value="<?php echo esc_attr( $group_data['group_id'] ); ?>">
							<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][ns_group_id]" value="<?php echo esc_attr( $group_data['ns_group_id'] ); ?>">
						</tr>
						<?php
					}
				}

				$all_rows_html = ob_get_clean();

				wp_send_json_success( array(
					'quote-details-table' => $all_rows_html,
				) );

			} else {
				$quote_item_key_to_remove = isset( $_POST['quote_item_id'] ) ? sanitize_text_field( $_POST['quote_item_id'] ) : '';
				if ( empty( $quote_item_key_to_remove ) ) {
					die( 'Quote item key missing' );
				}

				$price_base_type = $this->get_price_base_type( $post_id );

				$quote_contents = array();
				$af_quote       = new AF_R_F_Q_Quote();

				if ( isset( $form_data['quote_qty'] ) && is_array( $form_data['quote_qty'] ) ) {
					foreach ( $form_data['quote_qty'] as $quote_item_key => $value ) {
						if ( $quote_item_key == $quote_item_key_to_remove ) {
							continue;
						}
						$quote_contents = $af_quote->add_to_quote(
							$form_data,
							$form_data['added_product_id'][ $quote_item_key ],
							$form_data['quote_qty'][ $quote_item_key ],
							0, array(), array(), true
						);
					}
				}

				$quote_contents = $this->update_quote_values( $quote_contents, $form_data, $price_base_type );

				if ( is_array( $quote_contents ) ) {
					$quote_totals      = $af_quote->get_calculated_totals( $quote_contents, $post_id );
					$quote_totals_html = afrfq_get_quote_totals_html( $quote_totals, $price_base_type, $quote_contents, $is_profile );
					$quote_table_html  = afrfq_get_quote_table_html( $quote_contents, $post_id, $is_profile );

					wp_send_json_success( array(
						'quote-details-table' => $quote_table_html,
						'quote-totals'        => $quote_totals_html,
					) );

				} else {
					wp_send_json_error( array( 'message' => 'Something went wrong, please try again' ) );
				}
			}
		}

		public function afrfqsearchProduct_and_variation() {
			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( isset( $_POST['type'] ) && $_POST['type'] == 'profile' ) {
				$nonce_name = 'afrfq-profile-quote';
			} else {
				$nonce_name = 'afquote-ajax-nonce';
			}

			if ( isset( $_POST['q'] ) && ! empty( $_POST['q'] ) ) {

				if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
					die( 'Failed ajax security check!' );
				}

				$pro = sanitize_text_field( wp_unslash( $_POST['q'] ) );

			} else {

				$pro = '';

			}

			$data_array = array();

			$current_user = wp_get_current_user();
			$selected_quote_type_id = get_selected_quote_type_id();
            $quote_type_bridgeport_req = get_post_meta($selected_quote_type_id, 'quote_type_bridgeport_brand', true);

			$args = array(
				'post_type'   => array( 'product', 'product_variation' ),
				'post_status' => 'publish',
				'numberposts' => -1,
				's'           => $pro,
				'fields'      => 'ids',
			);
			$pros = get_posts( $args );
			$quote_obj = new AF_R_F_Q_Quote();

			if ( ! empty( $pros ) ) {

				foreach ( $pros as $proo ) {
					$product = wc_get_product( $proo->ID );
					$quote_item_key = $quote_obj->add_to_quote(array(), $proo->ID, 1, 0, array(), array(), true);

					if ( $quote_item_key === false ) {
						continue;
					}
					$sku = get_post_meta($proo->ID, '_sku', true);
					$title = '(' . $sku . ') ';
					$title .= ( mb_strlen( $proo->post_title ) > 50 ) ? mb_substr( $proo->post_title, 0, 49 ) . '...' : $proo->post_title;
					if ( is_manager_or_switched_manager( $current_user ) && $quote_type_bridgeport_req === 'yes' ) {
						if ( has_term( 'bridgeport', 'product_brand', $product->ID ) ) {
							$data_array[] = array( $product->ID, $title );
						}
					} else {
						$data_array[] = array( $product->ID, $title );
					}
				}
			}

			$args_sku = array(
				'post_type'   => array( 'product', 'product_variation' ),
				'numberposts' => -1,
				'meta_query' => array(
					array(
						'key' => '_sku',
						'value' => $pro,
						'compare' => 'LIKE',
					)
				)
			);

			$products_sku = get_posts( $args_sku );
			foreach ( $products_sku ?? [] as $product ) {
				$sku = get_post_meta($product->ID, '_sku', true);
				$title = '(' . $sku . ') ';
				$title .= ( mb_strlen( $product->post_title ) > 50 ) ? mb_substr( $product->post_title, 0, 49 ) . '...' : $product->post_title;
				if ( is_manager_or_switched_manager( $current_user ) && $quote_type_bridgeport_req === 'yes' ) {
					if ( has_term( 'bridgeport', 'product_brand', $product->ID ) ) {
						$data_array[] = array( $product->ID , $title );
					}
				} else {
					$data_array[] = array( $product->ID, $title );
				}
			}

			wp_send_json( $data_array );

			die();
		}

		public function afrfq_quote_page_add_product() {
			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afrfq-profile-quote' ) ) {
				die( 'Failed ajax security check!' );
			}

			if ( isset( $_POST['quantity'] ) ) {
				$quantity = intval( sanitize_text_field( wp_unslash( $_POST['quantity'] ) ) ) ?? 1;
			}

			if ( isset( $_POST['product_id'] ) ) {
				$product_id = intval( sanitize_text_field( wp_unslash( $_POST['product_id'] ) ) );
			}

			$ajax_add_to_quote = new AF_R_F_Q_Quote();

			$passed_validation = apply_filters( 'addify_add_to_quote_validation', true, $product_id, $quantity, array() );
			if ( !$passed_validation ) {
				die('failed');
			}

			$min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
			if ( $min_qty != 0 && $min_qty != 1 && $min_qty != $quantity && $quantity % $min_qty != 0 ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => 'Minimum allowed quantity is ' . $min_qty . '. Product quantity has to be equal to ' . $min_qty . ' or a multiple of it.'
					)
				);

				die();
			}

			$quote_item_key = $ajax_add_to_quote->add_to_quote(array(), $product_id, $quantity );

			$quote_contents = wc()->session->get( 'quotes' );

			if ( is_user_logged_in() ) {
				Nsi_Helper::update_addify_quote_user_meta( $quote_contents );
			}

			if ( isset( $quote_contents[ $quote_item_key ] ) ) {
				$product = $quote_contents[ $quote_item_key ]['data'];
			} else {
				$product = wc_get_product( $product_id );
			}

			$product_name = 'Product';

			if ( is_object( $product ) ) {
				$product_name = $product->get_name();
			}

			if ( false === $quote_item_key ) {
				wc_add_notice( sprintf( __( 'Quote is not available for “%s”.', 'addify_rfq' ), $product_name ), 'error' );
			} else {
				$button = '<a href="' . esc_url( get_page_link( get_option( 'addify_atq_page_id') ) ) . '" class="button wc-forward">' . __( 'View quote', 'addify_rfq' ) . '</a>';
				wc_add_notice( sprintf( __( '“%1$s” has been added to your quote. %2$s', 'addify_rfq' ), $product_name, wp_kses_post	( $button ) ), 'success' );
			}

			die();
		}

		public function af_r_f_q_search_products() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {

				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( isset( $_POST['q'] ) && ! empty( $_POST['q'] ) ) {

				if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {

					die( 'Failed ajax security check!' );
				}

				$pro = sanitize_text_field( wp_unslash( $_POST['q'] ) );

			} else {

				$pro = '';

			}

			$data_array = array();
			$args       = array(
				'post_type'   => 'product',
				'post_status' => 'publish',
				'numberposts' => -1,
				's'           => $pro,
			);
			$pros       = get_posts( $args );

			if ( ! empty( $pros ) ) {

				foreach ( $pros as $proo ) {

					$title        = ( mb_strlen( $proo->post_title ) > 50 ) ? mb_substr( $proo->post_title, 0, 49 ) . '...' : $proo->post_title;
					$data_array[] = array( $proo->ID, $title ); // array( Post ID, Post Title )
				}
			}

			wp_send_json( $data_array );

			die();
		}

		// AJAX handler to Add a pricing group from a discount quote.
		function afrfq_add_pricing_group_to_quote() {
			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {
				wp_send_json_error( array( 'message' => 'Failed security check.' ) );
			}

			if ( ! isset( $_POST['group_id'] ) || empty( $_POST['group_id'] ) ) {
				wp_send_json_error( array( 'message' => 'Invalid pricing group ID provided.' ) );
			}
			$group_id = intval( $_POST['group_id'] );

			$groups_in_session = WC()->session->get( 'quote_pricing_groups', array() );

			if ( isset( $groups_in_session[ $group_id ] ) ) {
				wp_send_json_error( array( 'message' => 'This pricing group has already been added to the quote.' ) );
			}

			global $wpdb;
			$group_details = $wpdb->get_row( $wpdb->prepare(
				"SELECT group_name, price_name FROM {$wpdb->prefix}ns_groups_pricings WHERE id = %d",
				$group_id
			) );

			if ( ! $group_details ) {
				wp_send_json_error( array( 'message' => 'Could not find details for this pricing group.' ) );
			}

			$groups_in_session[ $group_id ] = array(
				'group_id'       => $group_id,
				'ns_group_id'       => $group_id,
				'group_name'     => $group_details->group_name,
				'price_name' => $group_details->price_name,
			);

			WC()->session->set( 'quote_pricing_groups', $groups_in_session );
			update_user_meta(get_current_user_id(),'quote_pricing_groups',$groups_in_session);

			if ( is_user_logged_in() ) {
				update_user_meta( get_current_user_id(), 'addify_quote_pricing_groups', $groups_in_session );
			}

			wp_send_json_success( array( 'message' => 'Pricing group added successfully.' ) );
			die();
		}

		/**
		 * AJAX handler to REMOVE a pricing group from a discount quote.
		 */
		function afrfq_remove_pricing_group_from_quote() {
			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {
				wp_send_json_error( array( 'message' => 'Failed security check.' ) );
				die();
			}

			if ( ! isset( $_POST['group_id'] ) ) {
				wp_send_json_error( array( 'message' => 'Invalid pricing group ID.' ) );
				die();
			}
			$group_id = intval( $_POST['group_id'] );
			$groups_in_session = WC()->session->get( 'quote_pricing_groups', array() );
			$removed_group_name = 'The group';

			if ( isset( $groups_in_session[ $group_id ] ) ) {
				$removed_group_name = $groups_in_session[ $group_id ]['group_name'];
				unset( $groups_in_session[ $group_id ] );
			}

			WC()->session->set( 'quote_pricing_groups', $groups_in_session );
			update_user_meta(get_current_user_id(),'quote_pricing_groups',$groups_in_session);
			if ( is_user_logged_in() ) {
				update_user_meta( get_current_user_id(), 'addify_quote_pricing_groups', $groups_in_session );
			}

			$is_quote_empty = empty(WC()->session->get( 'quote_pricing_groups' ));

			ob_start();
			wc_get_template(
				'quote/quote-discount-table.php',
				array(),
				'woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);
			$new_quote_table_html = ob_get_clean();

			$message_html = '<div class="woocommerce-message" role="alert">' . sprintf( esc_html__( '“%s” has been removed from your quote.', 'addify_rfq' ), esc_html($removed_group_name) ) . '</div>';

			wp_send_json( array(
				'quote_empty'  => $is_quote_empty,
				'quote-table'  => $new_quote_table_html,
				'message'      => $message_html,
				'mini-quote'   => '',
				'quote-totals' => '',
				'quote-count'  => count(WC()->session->get( 'quote_pricing_groups', array() )),
			) );
			die();
		}

		/**
		 * AJAX handler to CLEAR all pricing groups from the quote.
		 */
		function afrfq_clear_pricing_groups_cart() {
			check_ajax_referer( 'afrfq-clear-discounts-nonce', 'nonce' );
			$context_key = get_current_user_contextual_quote_type_key();
			$user_id = get_current_user_id();

			if ( WC()->session->get( 'quote_pricing_groups' ) ) {
				WC()->session->__unset( 'quote_pricing_groups' );
			}

			if ( WC()->session->get( $context_key ) ) {
				WC()->session->__unset( $context_key );
			}

			if ( is_user_logged_in() ) {
				update_user_meta($user_id, 'quote_pricing_groups', null);
				update_user_meta($user_id, $context_key, null );
			}

			wp_send_json_success();
			die();
		}
		/**
		 * AJAX handler to CLEAR all pricing groups from the quote.
		 */
		function request_page_clear_quotes_cart() {
			check_ajax_referer( 'request-page-clear-quotes-nonce', 'nonce' );
			$context_key = get_current_user_contextual_quote_type_key();
			$user_id = get_current_user_id();

			if ( WC()->session->get( $context_key ) ) {
				WC()->session->__unset( $context_key );
			}

			if ( is_user_logged_in() ) {
				delete_user_meta( $user_id, $context_key , null );
			}

			wp_send_json_success();
			die();
		}


		/**
		 * Ajax add to quote controller.
		 */
		public function afrfq_download_quote_in_pdf() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {

				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {

				die( 'Failed ajax security check!' );
			}

			$quote_id = isset( $_POST['quote_id'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_id'] ) ) : 0;

			$quote = get_post( $quote_id );

			$email_controller = new AF_R_F_Q_PDF_Controller();

			echo esc_url( $email_controller->process_pdf_print( intval( $quote_id ) ) );

			die();

		}

		/**
		 * Ajax add to quote controller.
		 */
		public function afrfq_update_quote_items() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {

				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {

				die( 'Failed Ajax security check!' );
			}

			if ( isset( $_POST['form_data'] ) ) {
				parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $form_data );
			} else {
				$form_data = '';
			}

			$quotes = WC()->session->get( 'quotes' );
			$price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
			foreach ( WC()->session->get( 'quotes' ) as $quote_item_key => $quote_item ) {

				if ( isset( $form_data['quote_qty'][ $quote_item_key ] ) ) {

					if ( 0 == $form_data['quote_qty'][ $quote_item_key ] ) {

						unset( $quotes[ $quote_item_key ] );

					} else {

						$quotes[ $quote_item_key ]['quantity'] = intval( $form_data['quote_qty'][ $quote_item_key ] );
					}
				}

				if ( isset( $form_data['offered_price'][ $quote_item_key ] ) ) {
					$quote_price_base = $this->get_quote_price_base($price_base_type, $quote_item, $quote_item_key);
					$offered_price = floatval( $form_data['offered_price'][ $quote_item_key ] );
					$quotes[ $quote_item_key ]['offered_price'] = number_format( $offered_price, 2 );
					$quotes[ $quote_item_key ]['offered_price_per_each'] = $offered_price /  $quote_price_base;
				}
			}

			WC()->session->set( 'quotes', $quotes );

			$quotes = WC()->session->get( 'quotes' );

			foreach ( WC()->session->get( 'quotes' ) as $quote_item_key => $quote_item ) {

				if ( isset( $quote_item['quantity'] ) && empty( $quote_item['quantity'] ) ) {

					unset( $quotes[$quote_item_key] );
				}

				if ( !isset( $quote_item['data'] ) ) {
					unset( $quotes[$quote_item_key] );
				}
			}

			WC()->session->set( 'quotes', array_filter( $quotes ) );

			do_action('addify_quote_session_changed');

            if ( is_user_logged_in() ) {
                Nsi_Helper::update_addify_quote_user_meta( WC()->session->get( 'quotes' ) );
            }

			$af_quote = new AF_R_F_Q_Quote();

			ob_start();

				wc_get_template(
					'quote/quote-table.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);

			$quote_table = ob_get_clean();

			ob_start();
				wc_get_template(
					'quote/mini-quote.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);
			$mini_quote = ob_get_clean();

			$message = wp_kses_post( '<div class="woocommerce-message" role="alert">' . esc_html__( 'Quote updated', 'addify_rfq' ) . '</div>' );

			ob_start();

				wc_get_template(
					'quote/quote-totals-table.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);

			$quote_totals = ob_get_clean();

			if ( empty( $quote_totals ) ) {
				$quote_totals = '';
			}

			$quotes_for_cart_count = WC()->session->get('quotes') ?? [];
			$quote_item_count = 0;
			foreach ( $quotes_for_cart_count as $quote_for_cart_count ) {
				$quote_item_count += $quote_for_cart_count['quantity'] ?? 0;
			}

			wp_send_json(
				array(
					'quote_empty'  => empty( WC()->session->get('quotes') ) ? true : false,
					'quote-table'  => $quote_table,
					'message'      => $message,
					'mini-quote'   => $mini_quote,
					'quote-totals' => $quote_totals,
					'quote-count'  => $quote_item_count,
				)
			);
		}

		public function afrfq_update_quote_items_profile() {
			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( isset( $_POST['type'] ) && $_POST['type'] == 'admin' ) {
				$nonce_name = 'afquote-ajax-nonce';
				$type = 'admin';
			} else {
				$nonce_name = 'afrfq-profile-quote';
				$type = 'profile';
			}

			if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
				die( 'Failed Ajax security check!' );
			}

			if ( isset( $_POST['form_data'] ) ) {
				parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $form_data );
			} else {
				$form_data = '';
			}

			$post_id    = isset( $_POST['quote_id'] ) ? intval( wp_unslash( $_POST['quote_id'] ) ) : 0;
			$post = get_post( $post_id );
			if ( ! $post ) {
				die( 'post not found' );
			}
			$price_base_type = $this->get_price_base_type($post_id);
			$quote_contents = (array) get_post_meta( $post->ID, 'quote_contents', true );
			$af_quote       = new AF_R_F_Q_Quote( $quote_contents );
			foreach ( $form_data['quote_qty'] ?? [] as $quote_item_key => $value ) {
				if ( !isset($quote_contents[$quote_item_key]) ) {
					$quote_contents = $af_quote->add_to_quote(
							$form_data,
							$form_data['added_product_id'][$quote_item_key],
							$form_data['quote_qty'][$quote_item_key],
							0, array(), array(), true
					);
				}
			}

			foreach ( $quote_contents as $quote_item_key => $quote_item ) {
				if ( isset( $form_data['quote_qty'][ $quote_item_key ] ) ) {
					if ( 0 == $form_data['quote_qty'][ $quote_item_key ] ) {
						unset( $quote_contents[ $quote_item_key ] );
						continue;
					} else {
						$quote_contents[ $quote_item_key ]['quantity'] = intval( $form_data['quote_qty'][ $quote_item_key ] );
					}
				} else {
					unset( $quote_contents[ $quote_item_key ] );
					continue;
				}
				$quote_price_base = $this->get_quote_price_base($price_base_type, $quote_item, $quote_item_key);
				if ( isset( $form_data['offered_price'][ $quote_item_key ] ) ) {
					$offered_price = floatval( $form_data['offered_price'][ $quote_item_key ]);
					$quote_contents[ $quote_item_key ]['offered_price'] = number_format( $offered_price, 2 );
					$quote_contents[ $quote_item_key ]['offered_price_per_each'] = $offered_price /  $quote_price_base;
				}

				if ( isset( $form_data['approved_price'][ $quote_item_key ] ) ) {
					$approved_price = floatval( $form_data['approved_price'][ $quote_item_key ]);
					$quote_contents[ $quote_item_key ]['approved_price'] = number_format( $approved_price, 2 );
					$quote_contents[ $quote_item_key ]['approved_price_per_each'] = $approved_price /  $quote_price_base;
				}
			}

			update_post_meta( $post_id, 'quote_contents', $quote_contents );

			$current_status = get_post_meta( $post_id, 'quote_status', true );
			$quote_totals = $af_quote->get_calculated_totals( $quote_contents, $post_id );
			if ( $current_status == 'af_accepted' ) {
				update_post_meta( $post_id, 'old_status', 'af_pending' );
				update_post_meta( $post_id, 'quote_status', 'af_pending' );
				do_action( 'addify_rfq_quote_status_updated', $post_id, 'af_pending', $current_status );

				if ( $type == 'profile' ) {
					add_filter( 'filter_admin_quote_email_subject', function( $email_subject ) use ($post_id) {
						$new_email_subject = 'Revised Quote';
						return $new_email_subject;
                	} );
					add_filter( 'filter_customer_quote_email_subject', function( $email_subject ) use ($post_id, $quote_totals) {
						$distributor_name = get_post_meta( $post_id, 'afrfq_field_5822579', true );

						if ( $distributor_name && $quote_totals ) {
							$new_email_subject = 'Revised Quote: ' . $distributor_name . ': $' . number_format($quote_totals['_subtotal'], 2);
						} elseif ( $distributor_name ) {
							$new_email_subject = 'Revised Quote: ' . $distributor_name;
						} else {
							$new_email_subject = 'Revised Quote';
						}
						return $new_email_subject;
					} );
					do_action( 'addify_rfq_send_quote_email_to_admin', $post_id );
					do_action( 'addify_rfq_send_quote_email_to_customer', $post_id );
				}
			}

			wp_send_json(
				array(
					'success' => true
				)
			);
		}

		public function afrfq_update_discount_quote_items_profile() {
		if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
		} else {
			$nonce = 0;
		}

		if ( isset( $_POST['type'] ) && 'admin' === $_POST['type'] ) {
			$nonce_name = 'afquote-ajax-nonce';
			$type = 'admin';
		} else {
			$nonce_name = 'afrfq-profile-quote';
			$type = 'profile';
		}

		if ( ! wp_verify_nonce( $nonce, $nonce_name ) ) {
			wp_send_json_error( array( 'message' => 'Failed Ajax security check!' ) );
		}

		if ( isset( $_POST['form_data'] ) ) {
			parse_str( wp_unslash( $_POST['form_data'] ), $form_data );
		} else {
			wp_send_json_error( array( 'message' => 'Form data is missing.' ) );
		}

		$post_id = isset( $_POST['quote_id'] ) ? intval( wp_unslash( $_POST['quote_id'] ) ) : 0;
		$post    = get_post( $post_id );
		if ( ! $post ) {
			wp_send_json_error( array( 'message' => 'Quote not found.' ) );
		}

		if ( isset( $form_data['pricing_groups'] ) && is_array( $form_data['pricing_groups'] ) ) {
			$sanitized_pricing_groups = array();
			foreach ( $form_data['pricing_groups'] as $group_key => $group_data ) {
				$sanitized_pricing_groups[ sanitize_text_field( $group_key ) ] = array(
					'group_name'  => sanitize_text_field( $group_data['group_name'] ),
					'price_name'  => sanitize_text_field( $group_data['price_name'] ),
					'group_id'    => intval( $group_data['group_id'] ),
					'ns_group_id' => intval( $group_data['ns_group_id'] ),
				);
			}
			update_post_meta( $post_id, 'quote_pricing_groups', $sanitized_pricing_groups );
		} else {
			delete_post_meta( $post_id, 'quote_pricing_groups' );
		}

		$price_base_type = $this->get_price_base_type( $post_id );
		$quote_contents  = (array) get_post_meta( $post->ID, 'quote_contents', true );
		$af_quote        = new AF_R_F_Q_Quote( $quote_contents );

		foreach ( $form_data['quote_qty'] ?? [] as $quote_item_key => $value ) {
			if ( !isset( $quote_contents[ $quote_item_key ] ) ) {
				$quote_contents = $af_quote->add_to_quote(
					$form_data,
					$form_data['added_product_id'][ $quote_item_key ],
					$form_data['quote_qty'][ $quote_item_key ],
					0, array(), array(), true
				);
			}
		}
		foreach ( $quote_contents as $quote_item_key => $quote_item ) {
			if ( isset( $form_data['quote_qty'][ $quote_item_key ] ) ) {
				if ( 0 == $form_data['quote_qty'][ $quote_item_key ] ) {
					unset( $quote_contents[ $quote_item_key ] );
					continue;
				} else {
					$quote_contents[ $quote_item_key ]['quantity'] = intval( $form_data['quote_qty'][ $quote_item_key ] );
				}
			} else {
				unset( $quote_contents[ $quote_item_key ] );
				continue;
			}
			$quote_price_base = $this->get_quote_price_base( $price_base_type, $quote_item, $quote_item_key );
			if ( isset( $form_data['offered_price'][ $quote_item_key ] ) ) {
				$offered_price = floatval( $form_data['offered_price'][ $quote_item_key ] );
				$quote_contents[ $quote_item_key ]['offered_price'] = number_format( $offered_price, 2 );
				$quote_contents[ $quote_item_key ]['offered_price_per_each'] = $offered_price /  $quote_price_base;
			}
			if ( isset( $form_data['approved_price'][ $quote_item_key ] ) ) {
				$approved_price = floatval( $form_data['approved_price'][ $quote_item_key ] );
				$quote_contents[ $quote_item_key ]['approved_price'] = number_format( $approved_price, 2 );
				$quote_contents[ $quote_item_key ]['approved_price_per_each'] = $approved_price /  $quote_price_base;
			}
		}
		update_post_meta( $post_id, 'quote_contents', $quote_contents );

			$current_status = get_post_meta( $post_id, 'quote_status', true );
			$quote_totals = $af_quote->get_calculated_totals( $quote_contents, $post_id );

			if ( $current_status == 'af_accepted' ) {
				update_post_meta( $post_id, 'old_status', 'af_pending' );
				update_post_meta( $post_id, 'quote_status', 'af_pending' );
				do_action( 'addify_rfq_quote_status_updated', $post_id, 'af_pending', $current_status );

				if ( $type == 'profile' ) {
					add_filter( 'filter_admin_quote_email_subject', function( $email_subject ) use ($post_id) {
						$new_email_subject = 'Revised Quote';
						return $new_email_subject;
                	} );
					add_filter( 'filter_customer_quote_email_subject', function( $email_subject ) use ($post_id, $quote_totals) {
						$distributor_name = get_post_meta( $post_id, 'afrfq_field_5822579', true );

						if ( $distributor_name && $quote_totals ) {
							$new_email_subject = 'Revised Quote: ' . $distributor_name . ': $' . number_format($quote_totals['_subtotal'], 2);
						} elseif ( $distributor_name ) {
							$new_email_subject = 'Revised Quote: ' . $distributor_name;
						} else {
							$new_email_subject = 'Revised Quote';
						}
						return $new_email_subject;
					} );
					do_action( 'addify_rfq_send_quote_email_to_admin', $post_id );
					do_action( 'addify_rfq_send_quote_email_to_customer', $post_id );
				}
			}

			wp_send_json(
				array(
					'success' => true
				)
			);
		}

		/**
		 * Ajax add to quote controller.
		 */
		public function afrfq_add_to_quote_callback_function() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {
				die( 'Failed ajax security check!' );
			}

			if ( isset( $_POST ) ) {
				$form_data = sanitize_meta('', wp_unslash( $_POST), '' );
			} else {
				$form_data = '';
			}
			$_POST      = $form_data;
			$product_id = isset( $form_data['product_id'] ) ? intval( $form_data['product_id'] ) : '';
			$quantity   = isset( $form_data['quantity'] ) ? intval( $form_data['quantity'] ) : 1;
			$source	 = isset( $form_data['source'] ) ? sanitize_text_field( $form_data['source'] ) : '';
			if ( isset( $form_data['afrfq_field_quote_types'] ) ) {

				$context_key = get_current_user_contextual_quote_type_key();
				if ($source === 'submit_plp_popup') {
					$existing_quote_type = WC()->session->get($context_key);
					if ( empty($existing_quote_type['id']) && is_user_logged_in() ) {
						$existing_quote_type = get_user_meta( get_current_user_id(), $context_key, true );
					}

					if ( !empty($existing_quote_type['id']) ) {
						wp_send_json_error(['code' => 'quote_type_exists']);
						die();
					}
				}
				global $addify_rfq;
				if ( !is_object($addify_rfq) || !is_object($addify_rfq->quote_types_obj) ) {
					wp_send_json_error(['code' => 'plugin_error', 'message' => 'Addify RFQ plugin not available.']);
					die();
				}

				$quote_type_id   = intval($form_data['afrfq_field_quote_types']);
				$quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name($quote_type_id);

				$selected_quote_type = array(
					'id'    => $quote_type_id,
					'title' => $quote_type_name ? $quote_type_name : '---'
				);

				WC()->session->set($context_key, $selected_quote_type);
				if ( is_user_logged_in() ) {
					update_user_meta(get_current_user_id(), $context_key, $selected_quote_type);
				}

				$current_user = wp_get_current_user();

				if ( is_manager_or_switched_manager( $current_user ) && $quote_type_id > 0 ) {
					$quote_type_bridgeport_only = get_post_meta($quote_type_id, 'quote_type_bridgeport_brand', true);
					$quote_type_discount_rules  = get_post_meta($quote_type_id, 'quote_type_discount_rules', true);

					if ( $quote_type_discount_rules === 'yes' ) {
						wp_send_json_error(['code' => 'discount']);
						die();
					}

					$product = wc_get_product($product_id);
					if ( is_object($product) ) {
						$product_brand         = strtolower((string) $product->get_meta('product_brand'));
						$is_bridgeport_product = ($product_brand === 'bridgeport');

						if ( $quote_type_bridgeport_only === 'yes' && !$is_bridgeport_product ) {
							wp_send_json_error(['code' => 'bridgeport']);
							die();
						}
					}
				}
			}
			$ajax_add_to_quote = new AF_R_F_Q_Quote();

			if ( count( (array) ( $ajax_add_to_quote->quote_contents ?? array() ) ) >= $this->rfq_lines_limit ) {
				die('failed');
			}

			$quote_item_key = $ajax_add_to_quote->add_to_quote($form_data, $product_id, $quantity );

			if ( is_user_logged_in() ) {
				Nsi_Helper::update_addify_quote_user_meta( WC()->session->get( 'quotes' ) );
			}

			$quote_contents = wc()->session->get( 'quotes' );
			$product        = '';
			$product_name   = 'Product';

			if ( isset( $quote_contents[ $quote_item_key ] ) ) {
				$product = $quote_contents[ $quote_item_key ]['data'];
			}

			if ( is_object( $product ) ) {
				$product_name = $product->get_name();
			}

			if ( 'yes' === get_option( 'enable_ajax_shop' ) && false !== $quote_item_key  ) {

				ob_start();

				wc_get_template(
					'quote/mini-quote.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);

				$mini_quote = ob_get_clean();

				ob_start();
				?>
					<a href="<?php echo esc_url( get_page_link( get_option( 'addify_atq_page_id' ) ) ); ?>" class="added_to_cart added_to_quote wc-forward" title="View Quote"><?php echo esc_html( get_option( 'afrfq_view_button_message' ) ); ?></a>
				<?php
				$view_quote_btn = ob_get_clean();

				wp_send_json(
					array(
						'mini-quote'   => $mini_quote,
						'view_button'  => $view_quote_btn,
					)
				);
			} else {

				if ( false === $quote_item_key ) {

					wc_add_notice( sprintf( __( '“%s” has not been added to your quote.', 'addify_rfq' ), $product_name ), 'error' );
					echo 'success';
				} else {
					$button = '<a href="' . esc_url( get_page_link( get_option( 'addify_atq_page_id') ) ) . '" class="button wc-forward">' . __( 'View quote', 'addify_rfq' ) . '</a>';
					wc_add_notice( sprintf( __( '“%1$s” has been added to your quote. %2$s', 'addify_rfq' ), $product_name, wp_kses_post	( $button ) ), 'success' );
					echo 'success';
				}

			}

			die();

		}

		/**
		 * Ajax add to quote controller for variable.
		 */
		public function afrfq_add_to_quote_single_vari_callback_function() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {

				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {

				die( 'Failed ajax security check!' );
			}

			if ( isset( $_POST['form_data'] ) ) {
				parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $form_data );
			} else {
				$form_data = '';
			}

			$_POST        = $form_data;
			$product_id   = isset( $form_data['add-to-cart'] ) ? intval( $form_data['add-to-cart'] ) : '';
			$quantity     = isset( $form_data['quantity'] ) ? intval( $form_data['quantity'] ) : 1;
			$variation_id = isset( $form_data['variation_id'] ) ? intval( $form_data['variation_id'] ) : '';
			$variation    = array();

			foreach ( $form_data as $key => $value ) {

				if ( ! in_array( $key, array( 'add-to-cart', 'quantity', 'variation_id', 'product_id' ), true ) ) {

					$variation[ $key ] = $value;
				}
			}
			$context_key = get_current_user_contextual_quote_type_key();
			$selected_quote_type = wc()->session->get($context_key);
			if (empty($selected_quote_type) && is_user_logged_in()) {
				$selected_quote_type = get_user_meta(get_current_user_id(), $context_key, true);
			}

			$is_bridgeport = get_post_meta($product_id, '_is_bridgeport', true);

			if ($is_bridgeport) {
				wp_send_json_error(array('code' => 'bridgeport'));
				die();
			}

			if (!empty($selected_quote_type['title']) && stripos($selected_quote_type['title'], 'Discount') !== false) {
				wp_send_json_error(array('code' => 'discount'));
				die();
			}

			if (empty($selected_quote_type) || empty($selected_quote_type['id'])) {
				wp_send_json_error(array('code' => 'no_quote_type'));
				die();
			}

			$ajax_add_to_quote = new AF_R_F_Q_Quote();

			$passed_validation = apply_filters( 'addify_add_to_quote_validation', true, $product_id, $quantity, $form_data );

			if ( !$passed_validation ) {
				echo 'failed';
				die();
			}

			$quote_item_key = $ajax_add_to_quote->add_to_quote($form_data, $product_id, $quantity, $variation_id, $variation );

			$quote_contents = wc()->session->get( 'quotes' );

			if ( is_user_logged_in() ) {
				Nsi_Helper::update_addify_quote_user_meta( WC()->session->get( 'quotes' ) );
			}

			$product = '';

			if ( isset( $quote_contents[ $quote_item_key ] ) ) {
				$product = $quote_contents[ $quote_item_key ]['data'];
			} else {
				$product = wc_get_product( $variation_id );
			}

			$product_name = 'Product';
			if ( is_object( $product ) ) {
				$product_name = $product->get_name();
			}

			if ( 'yes' === get_option( 'enable_ajax_product' ) && false !== $quote_item_key ) {

				ob_start();

				wc_get_template(
					'quote/mini-quote.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);

				$mini_quote = ob_get_clean();

				ob_start();
				?>
					<a href="<?php echo esc_url( get_page_link( get_option( 'addify_atq_page_id' ) ) ); ?>" class="added_to_cart added_to_quote wc-forward" title="View Quote"><?php echo esc_html( get_option( 'afrfq_view_button_message' ) ); ?></a>
				<?php
				$view_quote_btn = ob_get_clean();

				wp_send_json(
					array(
						'mini-quote'   => $mini_quote,
						'view_button'  => $view_quote_btn,
					)
				);
			} else {

				if ( false === $quote_item_key ) {
					/* translators: %s: Product name */
					wc_add_notice( __( 'Quote is not available for selected variation.', 'addify_rfq' ), 'error' );
					echo 'success';
				} else {
					$button = '<a href="' . esc_url( get_page_link( get_option( 'addify_atq_page_id') ) ) . '" class="button wc-forward">' . __( 'View quote', 'addify_rfq' ) . '</a>';
					/* translators: %s: Product name */
					wc_add_notice( sprintf( __( '“%1$s” has been added to your quote. %2$s', 'addify_rfq' ), $product_name, wp_kses_post	( $button ) ), 'success' );
					echo 'success';
				}
			}

			die();

		}

		/**
		 * Ajax add to quote controller for single products.
		 */
		public function afrfq_add_to_quote_single_callback_function() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {

				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {

				die( 'Failed ajax security check!' );
			}

			if ( isset( $_POST['form_data'] ) ) {
				parse_str( sanitize_meta('', wp_unslash( $_POST['form_data'] ), '' ), $form_data );
				if ( isset( $_POST['product_id'] ) ) {
					$form_data['add-to-cart'] = sanitize_text_field( wp_unslash( $_POST['product_id'] ) );
				}
			} else {
				$form_data = array();
			}
			$source = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : '';
			$_POST        = $form_data;
			$product_id   = isset( $form_data['add-to-cart'] ) ? intval( $form_data['add-to-cart'] ) : '';
			$quantity     = isset( $form_data['quantity'] ) ? $form_data['quantity'] : 1;
			$variation_id = isset( $form_data['variation_id'] ) ? intval( $form_data['variation_id'] ) : '';
			$variation    = array();
			$context_key = get_current_user_contextual_quote_type_key();
			if(isset($form_data['afrfq_field_quote_types'])){
				global $addify_rfq;
				if ( ! $addify_rfq->quote_types_obj ) {
					$addify_rfq->quote_types_obj = new AFRFQ_Quote_Types();
				}
				$quote_type_value = $form_data['afrfq_field_quote_types'];
				$quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) ? $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) : '---';
				$selected_quote_type = array(
					'id' => $quote_type_value,
					'title' => $quote_type_name
				);
				if ( $source === 'afrfqbt_single_page' ) {
					$existing_quote_type = wc()->session->get( $context_key );
					if ( empty( $existing_quote_type ) && is_user_logged_in() ) {
						$existing_quote_type = get_user_meta( get_current_user_id(), $context_key, true );
					}

					if ( ! empty( $existing_quote_type ) && intval( $existing_quote_type['id'] ) !== intval( $quote_type_value ) ) {
						wp_send_json_error( array( 'code' => 'type_already_selected' ) );
						die();
					}
				}

				$existing_quote_type = wc()->session->get( $context_key );
				if ( empty( $existing_quote_type ) ) {
					wc()->session->set( $context_key, $selected_quote_type );
					update_user_meta( get_current_user_id(), $context_key, $selected_quote_type );
				}
			}

			$selected_quote_type = wc()->session->get($context_key);
			if (empty($selected_quote_type) && is_user_logged_in()) {
				$selected_quote_type = get_user_meta(get_current_user_id(), $context_key, true);
			}

			$quote_type_id = !empty($selected_quote_type['id']) ? intval($selected_quote_type['id']) : 0;
			$current_user = wp_get_current_user();
			$allowed_roles = [ 'shop_manager', 'dual_shop_manager' ];
			if ( is_manager_or_switched_manager( $current_user ) ) {
				if (!$quote_type_id) {
					wp_send_json_error(array('code' => 'no_quote_type'));
					die();
				}

				$quote_type_bridgeport_only = get_post_meta($quote_type_id, 'quote_type_bridgeport_brand', true);
				$quote_type_discount_rules  = get_post_meta($quote_type_id, 'quote_type_discount_rules', true);

				if ($quote_type_discount_rules === 'yes') {
					wp_send_json_error(array('code' => 'discount'));
					die();
				}

				$brand_product  = $variation_id ? wc_get_product($variation_id) : wc_get_product($product_id);
				$product_brand  = is_object($brand_product) ? strtolower((string) $brand_product->get_meta('product_brand')) : '';
				$is_bridgeport_product = ($product_brand === 'bridgeport');

				if ($quote_type_bridgeport_only === 'yes' && !$is_bridgeport_product) {
					wp_send_json_error(array('code' => 'bridgeport'));
					die();
				}
			}

			$ajax_add_to_quote = new AF_R_F_Q_Quote();

			$product        = wc_get_product( $product_id );
			$added_products = array();

			if ( $product->is_type('simple') ) {

				$passed_validation = apply_filters( 'addify_add_to_quote_validation', true, $product_id, $quantity, $form_data );

				if ( !$passed_validation ) {
					die('failed');
				}

				$min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
				if ( $min_qty != 0 && $min_qty != 1 && $min_qty != $quantity && $quantity % $min_qty != 0 ) {
					wc_add_notice( 'Minimum allowed quantity is ' . $min_qty . '. Product quantity has to be equal to ' . $min_qty . ' or a multiple of it.', 'error' );
					die('failed');
				}

				$quote_item_key = $ajax_add_to_quote->add_to_quote($form_data, $product_id, $quantity );

			} elseif ( $product->is_type('grouped') ) {

				foreach ( $quantity as $product_id => $qty ) {

					if ( empty( $qty ) ) {
						continue;
					}

					$passed_validation = apply_filters( 'addify_add_to_quote_validation', true, $product_id, $qty, $form_data );

					if ( !$passed_validation ) {
						die('failed');
					}

					$quote_item_key = $ajax_add_to_quote->add_to_quote($form_data, $product_id, $qty );

					if ( $quote_item_key ) {
						$added_products[] = $product_id;
					}
				}
			}

			$quote_contents = wc()->session->get( 'quotes' );

			if ( is_user_logged_in() ) {
				Nsi_Helper::update_addify_quote_user_meta( WC()->session->get( 'quotes' ) );
			}

			$product = '';
			if ( isset( $quote_contents[ $quote_item_key ] ) ) {
				$product = $quote_contents[ $quote_item_key ]['data'];
			} else {
				$product = wc_get_product( $product_id );
			}

			$product_name = 'Product';

			if ( !empty( $added_products ) ) {

				$product_name = array();
				foreach ( $added_products as $product_id ) {
					$product        = wc_get_product( $product_id );
					$product_name[] = $product->get_name();
				}

				$product_name = implode(', ', $product_name );

			} elseif ( is_object( $product ) ) {

				$product_name = $product->get_name();
			}

			if ( 'yes' === get_option( 'enable_ajax_product' ) && false !== $quote_item_key ) {

				ob_start();

				wc_get_template(
					'quote/mini-quote.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);

				$mini_quote = ob_get_clean();

				ob_start();
				?>
					<a href="<?php echo esc_url( get_page_link( get_option( 'addify_atq_page_id' ) ) ); ?>" class="added_to_cart added_to_quote wc-forward" title="View Quote"><?php echo esc_html( get_option( 'afrfq_view_button_message' ) ); ?></a>
				<?php
				$view_quote_btn = ob_get_clean();

				wp_send_json(
					array(
						'mini-quote'   => $mini_quote,
						'view_button'  => $view_quote_btn,
					)
				);
			} else {

				if ( false === $quote_item_key ) {
					/* translators: %s: Product name */
					wc_add_notice( sprintf( __( 'Quote is not available for “%s”.', 'addify_rfq' ), $product_name ), 'error' );
					echo 'success';
				} else {
					$button = '<a href="' . esc_url( get_page_link( get_option( 'addify_atq_page_id') ) ) . '" class="button wc-forward">' . __( 'View quote', 'addify_rfq' ) . '</a>';
					/* translators: %s: Product name */
					wc_add_notice( sprintf( __( '“%1$s” has been added to your quote. %2$s', 'addify_rfq' ), $product_name, wp_kses_post	( $button ) ), 'success' );
					echo 'success';
				}
			}

			die();

		}

		/**
		 * Ajax remove item from quote.
		 */
		public function afrfq_remove_quote_item_callback_function() {

			if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {

				$nonce = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			} else {
				$nonce = 0;
			}

			if ( ! wp_verify_nonce( $nonce, 'afquote-ajax-nonce' ) ) {

				die( 'Failed ajax security check!' );
			}

			$quote_key = isset( $_POST['quote_key'] ) ? sanitize_text_field( wp_unslash( $_POST['quote_key'] ) ) : '';

			if ( empty( $quote_key ) ) {
				die( 'Quote key is empty' );
			}

			$quotes = WC()->session->get( 'quotes' );

			$product = $quotes[ $quote_key ]['data'];

			unset( $quotes[ $quote_key ] );

			WC()->session->set( 'quotes', $quotes );

			do_action('addify_quote_session_changed');

			if ( is_user_logged_in() ) {
				if ( empty( $quotes ) ) {
					$user_id = get_current_user_id();

					if ( Crown_Shop_Custom_Roles::is_switched_user() ) {
						$id_for_usermeta = Eleks_Carts_Management::get_user_unique_session_id( $user_id );
					} else {
						$id_for_usermeta = $user_id;
					}

					delete_user_meta( $user_id, 'addify_quote' );
					delete_user_meta( $user_id, '_addify_quote-cart_' . $id_for_usermeta );
				} else {
					Nsi_Helper::update_addify_quote_user_meta( $quotes );
				}
			}

			do_action( 'addify_quote_item_removed', $quote_key, $product );

			ob_start();

			if ( file_exists( get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-table.php' ) ) {

				include get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-table.php';

			} else {

				wc_get_template(
					'quote/quote-table.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);
			}

			$quote_table = ob_get_clean();

			ob_start();

			wc_get_template(
				'quote/mini-quote.php',
				array(),
				'/woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);

			$mini_quote = ob_get_clean();

			/* translators: %s: Product name */
			$message      = sprintf( __( '“%s” has been removed from quote basket.', 'addify_rfq' ), $product->get_name() );
			$message_html = '<div class="woocommerce-message" role="alert">' . $message . '</div>';

			ob_start();

			if ( file_exists( get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-totals-table.php' ) ) {

				include get_stylesheet_directory() . '/woocommerce/addify/rfq/front/quote-totals-table.php';

			} else {

				wc_get_template(
					'quote/quote-totals-table.php',
					array(),
					'/woocommerce/addify/rfq/',
					AFRFQ_PLUGIN_DIR . 'templates/'
				);
			}

			$quote_totals = ob_get_clean();

			if ( empty( $quote_totals ) ) {
				$quote_totals = '';
			}

			$quotes_for_cart_count = WC()->session->get('quotes') ?? [];
			$quote_item_count = 0;
			foreach ( $quotes_for_cart_count as $quote_for_cart_count ) {
				$quote_item_count += $quote_for_cart_count['quantity'] ?? 0;
			}

			wp_send_json(
				array(
					'quote_empty'  => empty( WC()->session->get('quotes') ) ? true : false,
					'quote-table'  => $quote_table,
					'message'      => $message_html,
					'mini-quote'   => $mini_quote,
					'quote-totals' => $quote_totals,
					'quote-count'  => $quote_item_count,
				)
			);

			die();
		}

		public function get_quote_price_base($price_base_type, $quote_item, $quote_item_key) {
			$product = apply_filters('addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key);
			if ($price_base_type === 'moq') {
				$quote_price_base = intval(get_post_meta($product->get_id(), 'min_quantity', true));
				$quote_price_base = $quote_price_base < 1 ? 1 : $quote_price_base;
			} else {
				$quote_price_base = get_post_meta($product->get_id(), 'ns_price_qty_multiplier', true);
				$quote_price_base = floatval($quote_price_base) > 0 ? floatval($quote_price_base) : 1;
			}
			return $quote_price_base;
		}

		public function get_price_base_type($post_id) {
			$price_base_type = get_post_meta($post_id, '_price_base_type', true);
			if (empty($price_base_type)) {
				$price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
			}
			return $price_base_type;
		}

		public function update_quote_values( $quote_contents, $quote_form_data, $price_base_type ) {
			foreach ( $quote_contents as $quote_item_key => $quote_item ) {
				$quote_price_base = $this->get_quote_price_base( $price_base_type, $quote_item, $quote_item_key );
				if ( isset( $quote_form_data['offered_price'][ $quote_item_key ] ) ) {
					$offered_price = floatval( $quote_form_data['offered_price'][ $quote_item_key ]);
					$quote_contents[ $quote_item_key ]['offered_price'] = number_format( $offered_price, 2 );
					$quote_contents[ $quote_item_key ]['offered_price_per_each'] = $offered_price /  $quote_price_base;
				}

				if ( isset( $quote_form_data['approved_price'][ $quote_item_key ] ) ) {
					$approved_price = floatval( $quote_form_data['approved_price'][ $quote_item_key ]);
					$quote_contents[ $quote_item_key ]['approved_price'] = number_format( $approved_price, 2 );
					$quote_contents[ $quote_item_key ]['approved_price_per_each'] = $approved_price /  $quote_price_base;
				}

				if ( isset( $quote_form_data['quote_qty'][ $quote_item_key ] ) ) {
					$quote_contents[ $quote_item_key ]['quantity'] = $quote_form_data['quote_qty'][ $quote_item_key ];
				}
			}

			return $quote_contents;
		}

	}

new AF_R_F_Q_Ajax_Controller();
