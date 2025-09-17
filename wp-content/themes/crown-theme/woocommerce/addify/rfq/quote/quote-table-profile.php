<?php
/**
 * Editable quote table on my-account page
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $af_quote ) ) {
	$af_quote = new AF_R_F_Q_Quote();
}

$price_display    = 'yes' === get_option( 'afrfq_enable_pro_price' ) ? true : false;
$of_price_display = 'yes' === get_option( 'afrfq_enable_off_price' ) ? true : false;
$tax_display      = 'yes' === get_option( 'afrfq_enable_tax' ) ? true : false;
$colspan          = 4;
$colspan          = $price_display ? $colspan + 2 : $colspan;
$colspan          = $of_price_display ? $colspan + 4 : $colspan;
$quote_status     = get_post_meta( $quote_post_id, 'quote_status', true );
$price_title_origin = 'Requested';
$disabled = '';
if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) {
    $disabled = 'disabled';
    $price_title_origin = 'Approved';
}
$price_base_type = get_post_meta( $quote_post_id, '_price_base_type', true );
if ( empty($price_base_type) ) {
    $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
}

do_action( 'addify_before_quote_table' );
$notice = WC()->session->get( 'notice_message');
if (isset($notice)) {
    echo '<div class="woocommerce-message" role="alert">' . $notice . '</div>';
    WC()->session->__unset( 'notice_message');
}
$warnings = WC()->session->get( 'warning_messages');
if (isset($warnings) && is_array($warnings) && !empty($warnings)) {
    echo '<div class="woocommerce-notices-wrapper">';
    echo '<div class="woocommerce-error" role="alert">';
    foreach ($warnings as $warning) {
        echo '<p>' . $warning . '</p>';
    }
    echo '</div>';
    echo '</div>';
    WC()->session->__unset( 'warning_messages');
}
?>
    <form class="addify-quote-form-profile">
	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents  addify-quote-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php esc_html_e( 'Product', 'addify_rfq' ); ?></th>
				<?php if ( $price_display ) : ?>
					<th class="product-price">
                        <?php esc_html_e( 'Price', 'addify_rfq' ); ?>
                        <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
                    </th>
				<?php endif; ?>
				<?php if ( $of_price_display ) : ?>
					<th class="product-price">
                        <?php esc_html_e( 'Approved Price', 'addify_rfq' ); ?>
                        <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
                    </th>
                    <th class="product-price">
                        <?php esc_html_e( 'Requested Price', 'addify_rfq' ); ?>
                        <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
                    </th>
				<?php endif; ?>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'addify_rfq' ); ?></th>
				<?php if ( $price_display ) : ?>
					<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'addify_rfq' ); ?></th>
				<?php endif; ?>
				<?php if ( $of_price_display ) : ?>
					<th class="product-subtotal"><?php esc_html_e( 'Approved Subtotal', 'addify_rfq' ); ?></th>
					<th class="product-subtotal"><?php esc_html_e( 'Requested Subtotal', 'addify_rfq' ); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'addify_before_quote_contents' ); ?>

			<?php
			foreach ( $quote_contents as $quote_item_key => $quote_item ) {

				if (  !isset( $quote_item['data'] ) || !is_object( $quote_item['data'] ) ) {
					continue;
				}

				$_product      = apply_filters( 'addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key );
				$product_id    = apply_filters( 'addify_quote_item_product_id', $quote_item['product_id'], $quote_item, $quote_item_key );
				$price         = empty( $quote_item['addons_price'] ) ? $_product->get_price() : $quote_item['addons_price'];
				$price         = empty( $quote_item['role_base_price'] ) ? $_product->get_price() : $quote_item['role_base_price'];
				$offered_price = isset( $quote_item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $quote_item['offered_price'] ) ) : $price;
                $approved_price = isset( $quote_item['approved_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $quote_item['approved_price'] ) ) : '';

				if ( $_product && $_product->exists() && $quote_item['quantity'] > 0 && apply_filters( 'addify_quote_item_visible', true, $quote_item, $quote_item_key ) ) {
					$product_permalink = apply_filters( 'addify_quote_item_permalink', $_product->is_visible() ? $_product->get_permalink( $quote_item ) : '', $quote_item, $quote_item_key );
					?>
					<tr class="woocommerce-cart-form__quote-item <?php echo esc_attr( apply_filters( 'addify_quote_item_class', 'cart_item', $quote_item, $quote_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo wp_kses_post( apply_filters( 
									'addify_quote_item_remove_link',
									sprintf(
										'<a href="%s" class="remove remove-cart-item delete-quote-item-profile" aria-label="%s" data-quote_item_id_profile="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_attr( $quote_item_key ),
										esc_html__( 'Remove this item', 'addify_rfq' ),
										esc_attr( $quote_item_key ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$quote_item_key
								) );
							?>
						</td>

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'addify_quote_item_thumbnail', $_product->get_image(), $quote_item, $quote_item_key );

						if ( ! $product_permalink ) {
							echo wp_kses_post( $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) ); // phpcs:ignore WordPress.Security.EscapeOutput
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'addify_rfq' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'addify_quote_item_name', $_product->get_name(), $quote_item, $quote_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'addify_quote_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $quote_item, $quote_item_key ) );
						}

						do_action( 'addify_after_quote_item_name', $quote_item, $quote_item_key );

						// Meta data.
						echo wp_kses_post( wc_get_formatted_cart_item_data( $quote_item ) ); // phpcs:ignore WordPress.Security.EscapeOutput

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $quote_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'addify_quote_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'addify_rfq' ) . '</p>', $product_id ) );
						}

						echo wp_kses_post( sprintf( '<p><small>SKU:%s</small></p>', esc_attr( $_product->get_sku() ) ) );
						?>
						</td>

						<?php
                        $min_qty = intval( get_post_meta( $_product->get_id(), 'min_quantity', true ) );
                        $min_qty = $min_qty < 1 ? 1 : $min_qty;

                        if ($price_base_type === 'moq') {
                            $price_qty_multiplier = $min_qty;
                        } else {
                            $price_qty_multiplier = get_post_meta( $_product->get_id(), 'ns_price_qty_multiplier', true );
                            $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
                        }
                        if ( $price_display ) : ?>
							<td class="product-price" data-title="<?php esc_attr_e( 'Price ' . $price_base_notice, 'addify_rfq' ); ?>">
								<?php
									$args['qty']   = 1;
									$args['price'] = empty( $quote_item['addons_price'] ) ? $_product->get_price() : $quote_item['addons_price'];
									$args['price'] = empty( $quote_item['role_base_price'] ) ? $_product->get_price() : $quote_item['role_base_price'];

									$price_html = $af_quote->get_product_price( $_product, $args );

									if ( $price_qty_multiplier > 1 && preg_match( '/>(\d+(?:\.\d+)?)/', $price_html, $matches ) ) {
										$product_price = wc_get_price_excluding_tax( $_product );
										$price_html = preg_replace( '/>\d+(\.\d+)?/', '>' . number_format( $product_price * $price_qty_multiplier, 2 ), $price_html );
									}
									echo wp_kses_post( apply_filters( 'addify_quote_item_price', $price_html, $quote_item, $quote_item_key ) ); // phpcs:ignore WordPress.Security.EscapeOutput
									echo '<small style="position: relative; display: block; opacity: .6; line-height: 1.2;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
								?>
							</td>
						<?php endif; ?>
						
						<?php if ( $of_price_display ) : ?>
							<td class="product-price" data-title="<?php esc_attr_e( 'Approved Price ' . $price_base_notice, 'addify_rfq' ); ?>">
                                <?php echo !empty( $approved_price ) ? wp_kses_post( wc_price( $approved_price ) ) : ''; ?>
                                <?php
                                echo '<small style="position: relative; display: block; opacity: .6; line-height: 1.2;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
                                ?>
							</td>
                            <td class="product-price offered-price" data-title="<?php esc_attr_e( 'Offered Price ' . $price_base_notice, 'addify_rfq' ); ?>">
                                <label class="screen-reader-text" for="offered_price_<?php echo esc_attr( $quote_item_key ); ?>">
                                    <?php echo $_product->get_name();?> requested price
                                </label>
								<input type="number" min="0.01" class="input-text offered-price-input text" step="any"
                                       id="offered_price_<?php echo esc_attr( $quote_item_key ); ?>" aria-label="Product requested price"
                                       name="offered_price[<?php echo esc_attr( $quote_item_key ); ?>]"
                                       value="<?php echo esc_attr( ! empty( $offered_price ) ? number_format( $offered_price, 2, '.', '' ) : '' ); ?>"
                                       data-price-qty="<?php echo max($price_qty_multiplier, 1);?>"
                                >
                                <?php
                                echo '<small style="position: relative; display: block; opacity: .6; line-height: 1.2; bottom: initial;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
                                ?>
							</td>
						<?php endif; ?>	

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'addify_rfq' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '<input type="hidden" name="quote_qty[%s]" value="1" />', $quote_item_key );
						} else {
                            echo '<div class="product-quantity_wrapper">';
							woocommerce_quantity_input(
								array(
									'input_name'   => "quote_qty[{$quote_item_key}]",
									'input_value'  => $quote_item['quantity'],
									'max_value'    => $_product->get_max_purchase_quantity(),
									'min_value'    => $min_qty,
                                    'step' => $min_qty,
									'product_name' => $_product->get_name(),
								),
								$_product,
								true
							);
                            echo '<small style="position: relative; display: block; opacity: .6; line-height: 1.2;">' . 'Min Qty ' . $min_qty . '</small>';
                            echo '</div>';
						}
						?>
						</td>

						<?php if ( $price_display ) : ?>
							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>">
								<?php
									$args['qty']   = $quote_item['quantity'];
									$args['price'] = empty( $quote_item['addons_price'] ) ? $_product->get_price() : $quote_item['addons_price'];
									$args['price'] = empty( $quote_item['role_base_price'] ) ? $args['price'] : $quote_item['role_base_price'];

									echo wp_kses_post( apply_filters( 'addify_quote_item_subtotal', $af_quote->get_product_subtotal( $_product, $quote_item['quantity'], $args ), $quote_item, $quote_item_key ) ); // phpcs:ignore WordPress.Security.EscapeOutput
								?>
							</td>
						<?php endif; ?>	

						<?php if ( $of_price_display ) : ?>
							<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>">
								<?php
                                    echo !empty( $approved_price )
                                        ? wp_kses_post( apply_filters( 'addify_quote_item_subtotal', wc_price( $approved_price * $quote_item['quantity'] / $price_qty_multiplier ), $quote_item, $quote_item_key ) )
                                        : '';
								?>
							</td>
                            <td class="product-subtotal requested-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>">
								<?php
                                    echo wp_kses_post( apply_filters( 'addify_quote_item_subtotal', wc_price( $offered_price * $quote_item['quantity'] / $price_qty_multiplier ), $quote_item, $quote_item_key ) ); // phpcs:ignore WordPress.Security.EscapeOutput
								?>
							</td>
						<?php endif; ?>
						
					</tr>
					<?php
				}
			}
			?>
            <tr class="addify-quote-form-profile-actions">
                <td colspan="<?php echo esc_attr( ($colspan/2) ); ?>" class="actions add-to-quote" style="text-align: left;">
                    <select id="quote-page-search-products"></select>
                    <label>
                        Quantity:  <input type="number" id="quote-page-add-product-quantity" step="1" min="1" value="1" />
                    </label>
                    <button type="submit" id="quote-page-add-product-profile" class="button">Add</button>
                    <span class="add-to-quote--message"></span>
                    <script>
                        jQuery(document).ready(function($) {
                            $('#quote-page-search-products').select2({
                                ajax: {
                                    url: ajaxurl,
                                    dataType: 'json',
                                    type: 'POST',
                                    delay: 500,
                                    data: function (params) {
                                        return {
                                            q: params.term,
                                            action: 'afrfqsearchProduct_and_variation',
                                            nonce: crownThemeData.nonce_profile_quote,
                                            type: 'profile',
                                        };
                                    },
                                    processResults: function( data ) {
                                        var options = [];
                                        if ( data ) {
                                            $.each( data, function( index, text ) {
                                                options.push( { id: text[0], text: text[1]  } );
                                            });
                                        }
                                        return {
                                            results: options
                                        };
                                    },
                                    success: function( $data ){},
                                    cache: true
                                },
                                multiple: false,
                                placeholder: 'Search products...',
                                minimumInputLength: 3

                            });
                        });
                    </script>
                </td>

                <td colspan="<?php echo esc_attr( $colspan/2 ); ?>" class="actions">

                        <?php
                        $afrfq_update_button_text     = get_option('afrfq_update_button_text');
                        $afrfq_update_button_bg_color = get_option('afrfq_update_button_bg_color');
                        $afrfq_update_button_fg_color = get_option('afrfq_update_button_fg_color');
                        $afrfq_update_button_text     = empty( $afrfq_update_button_text ) ? __( 'Submit', 'addify_rfq' ) : $afrfq_update_button_text;
                        ?>

                        <style type="text/css">
                            .afrfq_update_quote_btn, .afrfq_import_quote_btn {
                                color: <?php echo esc_html( $afrfq_update_button_fg_color ); ?> !important;
                                background-color: <?php echo esc_html( $afrfq_update_button_bg_color ); ?> !important;
                            }
                        </style>

                        <button type="button" type="submit" id="afrfq_import_quote_btn" class="button afrfq_import_quote_btn afrfq_import_quote_profile_btn" name="import_quote" value="Import Product List">
                            <?php echo 'Import Product List'; ?>
                        </button>

                        <button type="button" type="submit" id="afrfq_update_quote_profile_btn" class="button afrfq_update_quote_profile_btn" name="update_quote" value="<?php esc_html( $afrfq_update_button_text ); ?>" data-quote_id="<?php echo $quote_post_id;?>"><?php echo esc_html( $afrfq_update_button_text ); ?></button>

                        <?php do_action( 'addify_quote_actions' ); ?>

                        <?php wp_nonce_field( 'addify-cart', 'addify-cart-nonce' ); ?>
                    </td>
                </tr>
			</tbody>
            <input type="hidden" id="post_id_profile" name="post_id_profile" value="<?php echo $quote_post_id;?>" />
			<?php do_action( 'addify_quote_contents' ); ?>
			</tbody>
		</table>
    </form>
			<?php do_action( 'addify_after_quote_contents' ); ?>

	<?php do_action( 'addify_after_quote_table' ); ?>
<?php
