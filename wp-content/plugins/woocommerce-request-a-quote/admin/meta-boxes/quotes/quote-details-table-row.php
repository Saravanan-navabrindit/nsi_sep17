<?php
/**
 * Quote details in Meta box
 *
 * It shows the details of quotes items in meta box.
 */

defined( 'ABSPATH' ) || exit;
global $price_base_type;

// Retrieve matched pricing groups from session.
$session_matched = WC()->session->get( 'afrfq_matched_pricing_groups' );
$pricing_group_warnings = WC()->session->get( 'afrfq_pricing_warnings' );

if ( ! empty( $session_matched ) && is_array( $session_matched ) ) {
    foreach ( $session_matched as $m ) {
        $quote_contents[] = array(
            'data' => (object) array(
                'group_name' => isset( $m['group_name'] ) ? $m['group_name'] : '',
                'price_name' => isset( $m['price_name'] ) ? $m['price_name'] : '',
            ),
            'quantity' => 1,
        );
    }
}

if ( ! empty( $pricing_group_warnings ) ) {
    echo '<div class="woocommerce-message woocommerce-error">';
    foreach ( $pricing_group_warnings as $warning ) {
        echo '<p>' . esc_html( $warning ) . '</p>';
    }
    echo '</div>';

    WC()->session->set( 'afrfq_pricing_warnings', null );
}

foreach ( (array) $quote_contents as $item_id => $item ) {

    if ( isset( $item['data'] ) ) {

        $data = $item['data'];

    } else {

        continue;
    }

    $is_pricing_group = false;
    if (isset($data->group_name)) {
        // It's a pricing group
        $group_name = $data->group_name;
        $price_name = $data->price_name;
        $is_pricing_group = true;
    } else {
         // It's a product
        $product = $data;
    }
    
    ?>

    <tr class="item <?php echo $is_pricing_group ? 'pricing-group-item' : ''; ?>" data-order_item_id="<?php echo esc_attr( $item_id ); ?>">
        <?php if ( ! $is_pricing_group && $product instanceof WC_Product ) {?>
             <input type="hidden" name="added_product_id[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo $product->get_id();?>" />
            <td class="thumb">
                 <?php if ( $product instanceof WC_Product ) {
                    $thumbnail = apply_filters( 'woocommerce_admin_order_item_thumbnail', $product->get_image( 'thumbnail', array( 'title' => '' ), false ), $item_id, $item );
                    echo '<div class="wc-order-item-thumbnail">' . wp_kses_post( $thumbnail ) . '</div>';
                } ?>
            </td>

            <td class="woocommerce-table__product-name product-name">
               <?php
                if ( $product instanceof WC_Product ) {
                    $is_visible        = $product && $product->is_visible();
                    $product_permalink = apply_filters( 'addify_rfq_order_item_permalink', $is_visible ? $product->get_permalink( $item ) : '', $item, $post );

                    echo wp_kses_post( apply_filters( 'addify_rfq_order_item_name', $product_permalink ? sprintf( '<a href="%s">%s</a>', $product_permalink, $product->get_name() ) : $product->get_name(), $item, $is_visible ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    do_action( 'addify_rfq_order_item_meta_start', $item_id, $item, $post, false );

                    echo wp_kses_post( wc_get_formatted_cart_item_data( $item ) );

                    do_action( 'addify_rfq_order_item_meta_end', $item_id, $item, $post, false );
                    ?>
                    <br>
                    <?php
                        echo wp_kses_post( '<div class="wc-quote-item-sku"><strong>' . esc_html__( 'SKU:', 'addify_rfq' ) . '</strong> ' . esc_html( $product->get_sku() ) . '</div>' );
                    ?>
                    <?php
                }
                ?>
            </td>
            <td class="woocommerce-table__product-total product-total" style="text-align: right;">
                <?php
                    if ( $product instanceof WC_Product ) {
                        $min_qty = intval( get_post_meta( $product->get_id(), 'min_quantity', true ) );
                        $min_qty = $min_qty < 1 ? 1 : $min_qty;
                        if ($price_base_type === 'moq') {
                            $price_qty_multiplier = $min_qty;
                        } else {
                            $price_qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
                            $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
                        }
                        $price         = empty( $item['addons_price'] ) ? $product->get_price() : $item['addons_price'];
                        $price         = empty( $item['role_base_price'] ) ? $price : $item['role_base_price'];
                        $qty_display   = $item['quantity'];

                        $offered_price_per_each = isset( $item['offered_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', ($item['offered_price_per_each']) ) ) : $price;
                        $approved_price_per_each = isset( $item['approved_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', ($item['approved_price_per_each']) ) ) : $offered_price_per_each;

                        $price         = $price * $price_qty_multiplier;
                        $offered_price = isset( $item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['offered_price'] ) ) : $offered_price_per_each * $price_qty_multiplier;
                        $approved_price = isset( $item['approved_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['approved_price'] ) ) : $approved_price_per_each * $price_qty_multiplier;

                        echo wp_kses_post( wc_price( $price ) );
                        echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
                    }
                ?>
            </td>
            <td class="woocommerce-table__product-total product-total" style="text-align: right;">
                <input type="number" class="input-text offered-price-input text" step="any" name="offered_price[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( ! empty( $offered_price ) ? $offered_price : '' ); ?>" readonly>
            </td>

            <td class="woocommerce-table__product-total product-total" style="text-align: right;">
                <?php
                $current_user = wp_get_current_user();
                $readonly = ( isset($current_user->roles[0]) && in_array( $current_user->roles[0], array('customer_service', 'internal_sales_rep', 'branch_employee_viewer', 'branch_admin') ) ) ? ' readonly' : '';
                ?>
                <label class="screen-reader-text" for="approved_price_<?php echo esc_attr( $item_id ); ?>">
                    <?php if ( $product instanceof WC_Product ) { echo $product->get_name(); }?> approved price
                </label>
                <input type="number" class="input-text offered-price-input text" step="any"
                       id="approved_price_<?php echo esc_attr( $item_id ); ?>" aria-label="Product approved price"
                       name="approved_price[<?php echo esc_attr( $item_id ); ?>]"
                       value="<?php echo esc_attr( $approved_price ); ?>"
                       data-price-qty="<?php echo max($price_qty_multiplier, 1);?>"
                       min="0"
                    <?php echo $readonly;?>
                >
            </td>

            <td style="text-align: right;">
                <?php
                $readonly_qty = ( isset($current_user->roles[0]) && in_array( $current_user->roles[0], array('branch_employee_viewer', 'branch_admin') ) ) ? ' readonly' : '';
                ?>
                <input type="number" class="input-text quote-qty-input text" min="<?php echo $min_qty; ?>" step="<?php echo $min_qty; ?>" name="quote_qty[<?php echo esc_attr( $item_id ); ?>]" value="<?php echo esc_attr( $item['quantity'] ); ?>"<?php echo $readonly_qty;?>>
                <small style="display: block; opacity: .6; line-height: 1.2;">Min Qty <?php if ( $product instanceof WC_Product ) { echo $min_qty; } ?></small>
            </td>

            <td class="woocommerce-table__product-total product-total" style="text-align: right;">
                <?php echo wp_kses_post( wc_price( $price * $qty_display / $price_qty_multiplier ) ); ?>
            </td>

            <td class="woocommerce-table__product-total product-total" style="text-align: right;">
                <?php echo wp_kses_post( wc_price( $offered_price * $qty_display / $price_qty_multiplier ) ); ?>
            </td>

            <td class="woocommerce-table__product-total product-total approved-total" style="text-align: right;">
                <?php echo wp_kses_post( wc_price( $approved_price * $qty_display / $price_qty_multiplier ) ); ?>
            </td>
            <td>
                <?php
                    $delete_title = '';
                    $delete_title = 'Delete ' . esc_attr( $product->get_name() );
                ?>
                <a class="delete-quote-item tips" title="<?php echo $delete_title; ?>"  data-quote_item_id="<?php echo esc_attr( $item_id ); ?>"></a>

            </td>
            
        <?php } else { ?>
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
       <?php } ?>
    </tr>
    <?php
}
?>