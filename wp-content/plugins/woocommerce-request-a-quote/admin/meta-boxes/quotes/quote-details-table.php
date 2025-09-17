<?php
/**
 * Quote details in Meta box
 *
 * It shows the details of quotes items in meta box.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

// Ensure required globals and variables are available
global $addify_rfq, $price_base_type;

// Ensure quote_contents is available
if ( ! isset( $quote_contents ) || ! is_array( $quote_contents ) ) {
	$quote_contents = array();
}

// Ensure quote_totals is available
if ( ! isset( $quote_totals ) || ! is_array( $quote_totals ) ) {
	$quote_totals = array();
}

// Ensure quote_id is available
if ( ! isset( $quote_id ) && isset( $post ) && $post ) {
	$quote_id = $post->ID;
}

// Retrieve the discount rules setting
$quote_type_discount_rules = 'no'; // Default value
if ( isset( $quote_id ) ) {
    $quote_type_value = get_post_meta( $quote_id, 'quote_type', true );
    if ( ! empty( $quote_type_value ) ) {
        $quote_type_discount_rules_meta = get_post_meta( $quote_type_value, 'quote_type_discount_rules', true );
        $quote_type_discount_rules = ( $quote_type_discount_rules_meta === 'yes' ) ? 'yes' : 'no';
    }
}
?>
<div id="addify_quote_items_container">
	<?php
	// Session handling with error checking
	if ( class_exists( 'WC' ) && WC()->session ) {
		$wc_session = WC()->session;
		if ( isset( $wc_session ) ) {
			echo '<div class="woocommerce-notices-wrapper">';
			$notice = $wc_session->get( 'notice_message' );
			if ( ! empty( $notice ) ) {
				echo '<div class="notice notice-success is-dismissible updated"><p>' . esc_html( $notice ) . '</p></div>';
				$wc_session->__unset( 'notice_message' );
			}
			$warnings = $wc_session->get( 'warning_messages' );
			if ( isset( $warnings ) && is_array( $warnings ) && ! empty( $warnings ) ) {
				echo '<div class="notice notice-error is-dismissible">';
				foreach ( $warnings as $warning ) {
					echo '<p>' . esc_html( $warning ) . '</p>';
				}
				echo '</div>';
				$wc_session->__unset( 'warning_messages' );
			}
			echo '</div>';
		}
	}

	if ( isset( $post ) && $post ) {
		$update_warnings_meta = get_post_meta( $post->ID, 'quote_update_warnings', true );
		if ( ! empty( $update_warnings_meta ) ) {
			$update_warnings = json_decode( $update_warnings_meta, true );
			if ( is_array( $update_warnings ) ) {
				echo '<div class="notice notice-error is-dismissible">';
				foreach ( $update_warnings as $update_warning ) {
					echo '<p>' . esc_html( $update_warning ) . '</p>';
				}
				echo '</div>';
			}
			update_post_meta( $post->ID, 'quote_update_warnings', '' );
		}
	}

	$price_base_type = '';
	if ( isset( $post ) && $post ) {
		$price_base_type = get_post_meta( $post->ID, '_price_base_type', true );
	}
	if ( empty( $price_base_type ) ) {
		$price_base_type = defined( 'QUOTE_PRICE_BASE_TYPE' ) ? QUOTE_PRICE_BASE_TYPE : 'industry';
	}
	$price_base_notice = $price_base_type === 'moq' ? '' : 'Per Industry Standard';

	$quote_type      = '---';
	$quote_type_name = '---';
	if ( isset( $quote_id ) ) {
		$quote_type = get_post_meta( $quote_id, 'quote_type', true );
		$quote_type = $quote_type ? $quote_type : '---';

		if ( isset( $addify_rfq ) && isset( $addify_rfq->quote_types_obj ) && method_exists( $addify_rfq->quote_types_obj, 'afrfq_get_quote_type_name' ) ) {
			$quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type );
		} else {
			$quote_type_name = $quote_type;
		}
	}
	?>
	<table cellpadding="0" cellspacing="0" id="addify_quote_items_table" class="woocommerce_order_items addify_quote_items">
		<thead>
			<tr>
				<?php
				$has_pricing_group = false;
				foreach ( (array) $quote_contents as $item_id => $item ) {
					if ( isset( $item['data']->group_name ) ) {
						$has_pricing_group = true;
						break;
					}
				}

				if ($quote_type_discount_rules !== 'yes') : ?>
					<th class="thumb sortable" data-sort="string-ins"><?php esc_html_e( 'Thumbnail', 'addify_rfq' ); ?></th>
					<th class="item sortable" data-sort="string-ins"><?php esc_html_e( 'Item', 'addify_rfq' ); ?></th>
					<th class="item_cost sortable" data-sort="float" style="text-align: right;">
						<?php esc_html_e( 'Cost', 'addify_rfq' ); ?>
						<small style="display: block; opacity: .6; line-height: 1;"><?php echo esc_html( $price_base_notice ); ?></small>
					</th>
					<th class="item_cost sortable" data-sort="float" style="text-align: right;">
						<?php esc_html_e( 'Requested Price', 'addify_rfq' ); ?>
						<small style="display: block; opacity: .6; line-height: 1;"><?php echo esc_html( $price_base_notice ); ?></small>
					</th>
					<th class="item_cost sortable" data-sort="float" style="text-align: right;">
						<?php esc_html_e( 'Approved Price', 'addify_rfq' ); ?>
						<small style="display: block; opacity: .6; line-height: 1;"><?php echo esc_html( $price_base_notice ); ?></small>
					</th>
					<th class="quantity sortable" data-sort="int" style="text-align: right;"><?php esc_html_e( 'Qty', 'addify_rfq' ); ?></th>
					<th class="line_cost sortable" data-sort="float" style="text-align: right;"><?php esc_html_e( 'Quote Type', 'addify_rfq' ); ?></th>
					<th class="line_cost sortable" data-sort="float" style="text-align: right;"><?php esc_html_e( 'Subtotal', 'addify_rfq' ); ?></th>
					<th class="line_cost sortable" data-sort="float" style="text-align: right;"><?php esc_html_e( 'Requested Subtotal', 'addify_rfq' ); ?></th>
					<th class="line_cost sortable" data-sort="float" style="text-align: right;"><?php esc_html_e( 'Approved Subtotal', 'addify_rfq' ); ?></th>
					<th class="line_actions"></th>
				<?php else : ?>
                    <th class="item sortable" data-sort="string-ins"><?php esc_html_e( 'Product Pricing Group', 'addify_rfq' ); ?></th>
					<th class="item sortable" data-sort="string-ins"><?php esc_html_e( 'Discount Level', 'addify_rfq' ); ?></th>
					<th class="line_actions"></th>

				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php
			// Action hooks with error checking
			if ( isset( $post ) ) {
				do_action( 'addify_rfq_order_details_before_order_table_items', $post );
			}

			$offered_price_subtotal  = 0;
			$approved_price_subtotal = 0;

			foreach ( (array) $quote_contents as $item_id => $item ) {
				if ( ! isset( $item['data'] ) || ! is_object( $item['data'] ) ) {
					continue;
				}

				$data = $item['data'];

				// Check if it's a pricing group or product
				$is_pricing_group = false;
				$group_name       = '';
				$price_name       = '';
				$product          = null;

				if ( isset( $data->group_name ) ) {
					// It's a pricing group
					$group_name       = sanitize_text_field( $data->group_name );
					$price_name       = isset( $data->price_name ) ? sanitize_text_field( $data->price_name ) : '';
					$is_pricing_group = true;
				} else {
					// It's a product
					$product = $data;
					if ( ! ( $product instanceof WC_Product ) ) {
						continue;
					}
				}

				// Initialize variables for products
				$min_qty             = 1;
				$price_qty_multiplier = 1;
				$price               = 0;
				$offered_price       = 0;
				$approved_price      = 0;
				$qty_display         = isset( $item['quantity'] ) ? intval( $item['quantity'] ) : 1;
				$thumbnail           = '';

				if ( ! $is_pricing_group && $product instanceof WC_Product ) {
					try {
						// Product-specific calculations with error handling
						$min_qty = intval( get_post_meta( $product->get_id(), 'min_quantity', true ) );
						$min_qty = $min_qty < 1 ? 1 : $min_qty;

						if ( $price_base_type === 'moq' ) {
							$price_qty_multiplier = $min_qty;
						} else {
							$price_qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
							$price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
						}

						$price = empty( $item['addons_price'] ) ? $product->get_price() : $item['addons_price'];
						$price = empty( $item['role_base_price'] ) ? $price : $item['role_base_price'];
						$price = floatval( $price );

						$offered_price_per_each  = isset( $item['offered_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['offered_price_per_each'] ) ) : $price;
						$approved_price_per_each = isset( $item['approved_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['approved_price_per_each'] ) ) : $offered_price_per_each;

						$price         = $price * $price_qty_multiplier;
						$offered_price = isset( $item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['offered_price'] ) ) : $offered_price_per_each * $price_qty_multiplier;
						$approved_price = isset( $item['approved_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['approved_price'] ) ) : $approved_price_per_each * $price_qty_multiplier;

						// Get thumbnail with error handling
						if ( function_exists( 'apply_filters' ) ) {
							$thumbnail = apply_filters( 'woocommerce_admin_order_item_thumbnail', $product->get_image( 'thumbnail', array( 'title' => '' ), false ), $item_id, $item );
						} else {
							$thumbnail = $product->get_image( 'thumbnail', array( 'title' => '' ), false );
						}

						// Calculate subtotals
						$offered_price_subtotal  += floatval( $offered_price ) * intval( $qty_display ) / $price_qty_multiplier;
						$approved_price_subtotal += floatval( $approved_price ) * intval( $qty_display ) / $price_qty_multiplier;

					} catch ( Exception $e ) {
						// Log error and continue with default values
						error_log( 'Quote item calculation error: ' . $e->getMessage() );
						continue;
					}
				}
				?>

				<tr class="item" data-order_item_id="<?php echo esc_attr( $item_id ); ?>">

					<?php if ( isset( $quote_contents[$item_id]['data']->group_name ) ) : ?>
						<td class="woocommerce-table__product-total product-total" style="text-align: left;">
							<?php echo esc_html( $group_name ); ?>
						</td>
						<td class="woocommerce-table__product-total product-total" style="text-align: left;">
							<?php echo esc_html( $price_name ); ?>
						</td>
						<td>
							<?php
							$delete_title = '';
							$delete_title = 'Delete ' . esc_attr( $group_name ? $group_name : 'Pricing Group' );
							?>
							<a class="delete-quote-item tips" title="<?php echo $delete_title; ?>"  data-quote_item_id="<?php echo esc_attr( $item_id ); ?>"></a>
						</td>
					<?php else : ?>
						<input type="hidden" name="added_product_id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $product->get_id() ); ?>" />

						<td class="thumb">
							<?php if ( $thumbnail ) : ?>
								<div class="wc-order-item-thumbnail"><?php echo wp_kses_post( $thumbnail ); ?></div>
							<?php endif; ?>
						</td>

						<td class="woocommerce-table__product-name product-name">
							<?php if ( $product instanceof WC_Product ) : ?>
								<?php
								$is_visible      = $product->is_visible();
								$product_permalink = '';

								if ( function_exists( 'apply_filters' ) && isset( $post ) ) {
									$product_permalink = apply_filters( 'addify_rfq_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $post );
								}

								$product_name = $product->get_name();
								if ( $product_permalink && function_exists( 'apply_filters' ) ) {
									$product_display = apply_filters( 'addify_rfq_order_item_name', sprintf( '<a href="%s">%s</a>', $product_permalink, $product_name ), $item, $is_visible );
								} else {
									$product_display = $product_name;
								}

								echo wp_kses_post( $product_display );

								// Action hooks with error checking
								if ( function_exists( 'do_action' ) && isset( $post ) ) {
									do_action( 'addify_rfq_order_item_meta_start', $item_id, $item, $post, false );
								}

								// Meta data with error checking
								if ( function_exists( 'wc_get_formatted_cart_item_data' ) ) {
									echo wp_kses_post( wc_get_formatted_cart_item_data( $item ) );
								}

								if ( function_exists( 'do_action' ) && isset( $post ) ) {
									do_action( 'addify_rfq_order_item_meta_end', $item_id, $item, $post, false );
								}
								?>
								<br>
								<?php
								$sku = $product->get_sku();
								if ( $sku ) {
									echo wp_kses_post( '<div class="wc-quote-item-sku"><strong>' . esc_html__( 'SKU:', 'addify_rfq' ) . '</strong> ' . esc_html( $sku ) . '</div>' );
								}
								?>
							<?php endif; ?>
						</td>

						<td class="woocommerce-table__product-total product-total" style="text-align: right;">
							<?php
							if ( function_exists( 'wc_price' ) ) {
								echo wp_kses_post( wc_price( $price ) );
							} else {
								echo esc_html( '$' . number_format( $price, 2 ) );
							}
							if ( $price_base_type === 'industry' ) {
								echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . esc_html( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
							}
							?>
						</td>
						<td class="woocommerce-table__product-total product-total" style="text-align: right;">
							<input type="number" class="input-text offered-price-input text" step="any" name="offered_price[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( ! empty( $offered_price ) ? number_format( $offered_price, 2, '.', '' ) : '' ); ?>" readonly>
						</td>

						<td class="woocommerce-table__product-total product-total" style="text-align: right;">
							<?php
							$current_user = wp_get_current_user();
							$readonly     = '';
							if ( isset( $current_user->roles[0] ) && in_array( $current_user->roles[0], array(
								'customer_service',
								'internal_sales_rep',
								'branch_employee_viewer',
								'branch_admin',
							), true ) ) {
								$readonly = ' readonly';
							}
							?>
							<label class="screen-reader-text" for="approved_price_<?php echo esc_attr( $item_id ); ?>">
								<?php echo esc_html( $product->get_name() ); ?> approved price
							</label>
							<input type="number" class="input-text offered-price-input text" step="any"
									id="approved_price_<?php echo esc_attr( $item_id ); ?>" aria-label="Product approved price"
									name="approved_price[<?php echo esc_attr( $item_id ); ?>]"
									value="<?php echo esc_attr( number_format( $approved_price, 2, '.', '' ) ); ?>"
									data-price-qty="<?php echo esc_attr( max( $price_qty_multiplier, 1 ) ); ?>"
									min="0"
								<?php echo $readonly; ?>>
						</td>

						<td style="text-align: right;">
							<?php
							$readonly_qty = '';
							if ( isset( $current_user->roles[0] ) && in_array( $current_user->roles[0], array( 'branch_employee_viewer', 'branch_admin' ), true ) ) {
								$readonly_qty = ' readonly';
							}
							?>
							<input type="number" class="input-text quote-qty-input text" min="<?php echo esc_attr( $min_qty ); ?>" step="<?php echo esc_attr( $min_qty ); ?>" name="quote_qty[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $qty_display ); ?>"<?php echo $readonly_qty; ?>>
							<small style="display: block; opacity: .6; line-height: 1.2;">Min Qty <?php echo esc_html( $min_qty ); ?></small>
						</td>
						<td class="woocommerce-table__product-total product-total" style="text-align: right;">
							<?php echo esc_html( $quote_type_name ); ?>
						</td>

						<td class="woocommerce-table__product-total product-total" style="text-align: right;">
							<?php
							$subtotal_price = 0;
							if ( $price_base_type === 'industry' ) {
								$subtotal_price = $price * $qty_display / $price_qty_multiplier;
							} else {
								$subtotal_price = $price * $qty_display;
							}

							if ( function_exists( 'wc_price' ) ) {
								echo wp_kses_post( wc_price( $subtotal_price ) );
							} else {
								echo esc_html( '$' . number_format( $subtotal_price, 2 ) );
							}
							?>
						</td>

						<td class="woocommerce-table__product-total product-total" style="text-align: right;">
							<?php
							$offered_subtotal = $offered_price * $qty_display / $price_qty_multiplier;
							if ( function_exists( 'wc_price' ) ) {
								echo wp_kses_post( wc_price( $offered_subtotal ) );
							} else {
								echo esc_html( '$' . number_format( $offered_subtotal, 2 ) );
							}
							?>
						</td>

						<td class="woocommerce-table__product-total product-total approved-total" style="text-align: right;">
							<?php
							$approved_subtotal = $approved_price * $qty_display / $price_qty_multiplier;
							if ( function_exists( 'wc_price' ) ) {
								echo wp_kses_post( wc_price( $approved_subtotal ) );
							} else {
								echo esc_html( '$' . number_format( $approved_subtotal, 2 ) );
							}
							?>
						</td>

						<td>
							<?php
							$delete_title = '';
							$delete_title = 'Delete ' . esc_attr( $product->get_name() );
							?>
							<a class="delete-quote-item tips" title="<?php echo $delete_title; ?>"  data-quote_item_id="<?php echo esc_attr( $item_id ); ?>"></a>
						</td>
					<?php endif; ?>
				</tr>
				<?php
			}

			// Action hooks with error checking
			if ( function_exists( 'do_action' ) && isset( $post ) ) {
				do_action( 'addify_rfq_order_details_after_order_table_items', $post );
			}
			?>
		</tbody>
	</table>
    <?php if ($quote_type_discount_rules !== 'yes') : ?>
	<table cellpadding="0" cellspacing="0" id="addify_quote_total_table" class="woocommerce_order_items addify_quote_items_total">
		<?php
		foreach ( $quote_totals as $key => $total ) {
			$label = '';
			switch ( $key ) {
				case '_subtotal':
					$label = 'Subtotal (Standard)';
					break;
				case '_tax_total':
					$label = 'Vat (Standard)';
					break;
				case '_total':
					$label = 'Total (Standard)';
					break;
				case '_offered_total':
					$label = 'Requested Subtotal';
					$total = $offered_price_subtotal;
					break;
				case '_approved_total':
					$label = 'Approved Subtotal';
					$total = $approved_price_subtotal;
					break;
				case '_shipping_total':
					$label = 'Shipping Cost';
					$total = floatval( $total );
					break;
				default:
					$label = '';
					break;
			}

			if ( empty( $label ) ) {
				continue;
			}

			if ( '_tax_total' == $key ) {
				continue;
			}
			if ( '_shipping_total' == $key ) {
				?>
				<tr>
					<td colspan=""><?php echo esc_html__( 'Shipping Cost', 'addify_rfq' ); ?></td>
					<td colspan="2" class="afrfq_shipping_cost">
						<input type="number" step="any" min="0" name="afrfq_shipping_cost" value="<?php echo esc_attr( $total ); ?>">
					</td>
				</tr>
				<?php
				continue;
			}
			?>
				<tr class="row-<?php echo esc_attr( $key ); ?>">
					<td scope="row"><?php echo esc_html( $label ); ?></td>
					<th colspan="2">
						<?php
						if ( function_exists( 'wc_price' ) ) {
							echo wp_kses_post( wc_price( $total ) );
						} else {
							echo esc_html( '$' . number_format( floatval( $total ), 2 ) );
						}
						?>
					</th>
				</tr>
			<?php
		}
		?>
		<tr>
			<td colspan="3"><?php echo esc_html__( 'Note: Tax/Vat will be calculated on quote conversion to order but it is visible to customers.', 'addify_rfq' ); ?></td>
		</tr>
	</table>
        <?php endif; ?>
</div>