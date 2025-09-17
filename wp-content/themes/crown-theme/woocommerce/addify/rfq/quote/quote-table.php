<?php
/**
 * Customer information table for email.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/addify/rfq/quote/quote-table.php.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $af_quote ) ) {
	$af_quote = new AF_R_F_Q_Quote();
}

$price_display    = 'yes' === get_option( 'afrfq_enable_pro_price' ) ? true : false;
$of_price_display = 'yes' === get_option( 'afrfq_enable_off_price' ) ? true : false;
$tax_display      = 'yes' === get_option( 'afrfq_enable_tax' ) ? true : false;
$price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
$price_base_notice = $price_base_type === 'moq' ? 'Per Minimum Quantity' : 'Per Industry Standard';
$colspan          = 4;
$colspan          = $price_display ? $colspan + 2 : $colspan;
$colspan          = $of_price_display ? $colspan + 2 : $colspan;

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
                        <?php esc_html_e( 'Requested Price', 'addify_rfq' ); ?>
                        <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
                    </th>
				<?php endif; ?>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'addify_rfq' ); ?></th>
				<?php if ( $price_display ) : ?>
					<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'addify_rfq' ); ?></th>
				<?php endif; ?>
				<?php if ( $of_price_display ) : ?>
					<th class="product-subtotal"><?php esc_html_e( 'Requested Subtotal', 'addify_rfq' ); ?></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'addify_before_quote_contents' ); ?>

			<?php
			foreach ( WC()->session->get( 'quotes' ) as $quote_item_key => $quote_item ) {

				if (  !isset( $quote_item['data'] ) || !is_object( $quote_item['data'] ) ) {
					continue;
				}

				$_product      = apply_filters( 'addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key );
				$product_id    = apply_filters( 'addify_quote_item_product_id', $quote_item['product_id'], $quote_item, $quote_item_key );
				if ( $_product && $_product->exists() && $quote_item['quantity'] > 0 && apply_filters( 'addify_quote_item_visible', true, $quote_item, $quote_item_key ) ) {
                    $min_qty = intval( get_post_meta( $product_id, 'min_quantity', true ) );
                    if ($price_base_type === 'moq') {
                        $price_qty_multiplier = $min_qty;
                        $price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
                    } else {
                        $price_qty_multiplier = get_post_meta( $product_id, 'ns_price_qty_multiplier', true );
                        $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
                    }

                    $price = empty( $quote_item['addons_price'] ) ? $_product->get_price() : $quote_item['addons_price'];
                    $price = ! empty( $quote_item['role_base_price'] ) ? $quote_item['role_base_price'] : $price;
                    $offered_price_per_each = isset( $quote_item['offered_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', ($quote_item['offered_price_per_each']) ) ) : $price;
                    $offered_price = !empty( $offered_price_per_each ) ? $offered_price_per_each * $price_qty_multiplier : (isset( $quote_item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $quote_item['offered_price'] ) ) : $price);

                    $product_permalink = apply_filters( 'addify_quote_item_permalink', $_product->is_visible() ? $_product->get_permalink( $quote_item ) : '', $quote_item, $quote_item_key );
					?>
					<tr class="woocommerce-cart-form__quote-item <?php echo esc_attr( apply_filters( 'addify_quote_item_class', 'cart_item', $quote_item, $quote_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								echo wp_kses_post( apply_filters( 
									'addify_quote_item_remove_link',
									sprintf(
										'<a href="%s" class="remove remove-cart-item remove-quote-item" aria-label="%s" data-cart_item_key="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
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
							<td class="product-price offered-price" data-title="<?php esc_attr_e( 'Offered Price ' . $price_base_notice, 'addify_rfq' ); ?>">
								<input type="number" min="0.01" class="input-text offered-price-input text" step="any" name="offered_price[<?php echo esc_attr( $quote_item_key ); ?>]" value="<?php echo esc_attr( ! empty( $offered_price ) ? number_format( $offered_price, 2, '.', '' ) : '' ); ?>">
                                <?php
                                echo '<small style="display: block; opacity: .6; line-height: 1.2; bottom: initial;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
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
									'min_value'    => '0',
                                    'step' => $min_qty,
									'product_name' => $_product->get_name(),
								),
								$_product,
								true
							);
                            echo '<small style="display: block; opacity: .6; line-height: 1.2;">' . 'Min Qty ' . $min_qty . '</small>';
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
                                    echo wp_kses_post( apply_filters( 'addify_quote_item_subtotal', wc_price( $offered_price * $quote_item['quantity'] / $price_qty_multiplier ), $quote_item, $quote_item_key ) ); // phpcs:ignore WordPress.Security.EscapeOutput
								?>
							</td>
						<?php endif; ?>
						
					</tr>
					<?php
				}
			}
			?>
			<td colspan="<?php echo esc_attr( ($colspan/2) ); ?>" class="actions add-to-quote left-cell" style="text-align: left;">
                <select id="quote-page-search-products"></select>
                <label>
                    Quantity: <input type="number" id="quote-page-add-product-quantity" step="1" min="1" value="1" />
                </label>
                <button type="submit" id="quote-page-add-product" class="button">Add</button>
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

                        $('body').on('click', '#quote-page-add-product', function(e) {
                            const quoteLimit = crownThemeData.quote_lines_limit;
                            e.preventDefault();
                            const quantity = $('#quote-page-add-product-quantity').val();
                            const product = $('#quote-page-search-products').val();
                            let msg = $('.add-to-quote--message');
                            msg.fadeOut().empty();

                            if ( !quantity ) {
                                msg.html( 'Quantity is required.' ).fadeIn('400', function() { $(this).css('display', 'block') });
                                return;
                            }

                            if ( !Number.isInteger(Number(quantity)) || Number(quantity) <= 0 ) {
                                msg.html( 'Quantity must be an integer greater than 0.' ).fadeIn('400', function() { $(this).css('display', 'block') });
                                return;
                            }

                            if ( !product ) {
                                msg.html( 'Please choose a product.' ).fadeIn('400', function() { $(this).css('display', 'block') });
                                return;
                            }

                            let currentCount = $('.addify-quote-form tbody').find('tr.woocommerce-cart-form__quote-item').length;
                            if ( currentCount >= quoteLimit ) {
                                msg.html( 'You can only add up to ' + quoteLimit + ' different SKUs to your quote.' ).fadeIn('400', function() { $(this).css('display', 'block') });
                                return;
                            }

                            $('td.add-to-quote').css({'opacity': '.4', 'pointer-events': 'none'});
                            $.ajax({
                                url: ajaxurl,
                                type: 'POST',
                                data: {
                                    action: 'afrfq_quote_page_add_product',
                                    product_id : product,
                                    quantity : quantity,
                                    nonce: crownThemeData.nonce_profile_quote,
                                    type: 'profile',
                                },
                                success: function (response) {
                                    if ( response.success == false ) {
                                        msg.html( response.message ).fadeIn('400', function() { $(this).css('display', 'block') });
                                        $('td.add-to-quote').css({'opacity': '1', 'pointer-events': 'initial'});
                                    } else {
                                        location.reload();
                                    }
                                },
                                error: function (response) {
                                    location.reload();
                                }
                            });
                        });
                    });

                </script>
            </td>
			<td colspan="<?php echo esc_attr( $colspan/2 ); ?>" class="actions extra-quote-actions right-cell">

					<?php
					$afrfq_update_button_text     = get_option('afrfq_update_button_text');
					$afrfq_update_button_bg_color = get_option('afrfq_update_button_bg_color');
					$afrfq_update_button_fg_color = get_option('afrfq_update_button_fg_color');
					$afrfq_update_button_text     = empty( $afrfq_update_button_text ) ? __( 'Update Quote', 'addify_rfq' ) : $afrfq_update_button_text;
					?>

					<style type="text/css">
						.afrfq_update_quote_btn, .afrfq_import_quote_btn {
							color: <?php echo esc_html( $afrfq_update_button_fg_color ); ?> !important;
							background-color: <?php echo esc_html( $afrfq_update_button_bg_color ); ?> !important;
						}
					</style>
                    <button type="button" id="afrfq_clear_quote__cart_btn" name="clear_quotes_cart" class="button" value="Clear Quote Cart">
                        Clear Quote
                    </button>

                    <button type="button" type="submit" id="afrfq_import_quote_btn" class="button afrfq_import_quote_btn" name="import_quote" value="Import Product List">
                        <?php echo 'Import Product List'; ?>
                    </button>

					<button type="button" type="submit" id="afrfq_update_quote_btn" class="button afrfq_update_quote_btn" name="update_quote" value="<?php esc_html( $afrfq_update_button_text ); ?>"><?php echo esc_html( $afrfq_update_button_text ); ?></button> 

					<?php do_action( 'addify_quote_actions' ); ?>

					<?php wp_nonce_field( 'addify-cart', 'addify-cart-nonce' ); ?>
				</td>
			</tbody>
			<?php do_action( 'addify_quote_contents' ); ?>
			</tbody>
		</table>
			<?php do_action( 'addify_after_quote_contents' ); ?>

	<?php do_action( 'addify_after_quote_table' ); ?>
