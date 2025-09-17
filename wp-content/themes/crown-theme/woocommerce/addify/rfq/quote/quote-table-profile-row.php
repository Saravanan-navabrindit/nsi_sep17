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
$colspan          = $of_price_display ? $colspan + 2 : $colspan;
$price_base_type = get_post_meta( $quote_post_id, '_price_base_type', true );
if ( empty($price_base_type) ) {
    $price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
}
$price_base_notice = $price_base_type === 'moq' ? 'Per Minimum Quantity' : 'Per Industry Standard';

do_action( 'addify_before_quote_contents' );
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
            <input type="hidden" name="added_product_id[<?php echo esc_attr( $quote_item_key ); ?>]" value="<?php echo $product_id;?>" />
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
<?php
