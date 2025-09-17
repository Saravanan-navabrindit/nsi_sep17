<tbody>
    <?php
    $offered_price_subtotal = 0;
    $approved_price_subtotal = 0;
    foreach ( (array) $quote_contents as $item_id => $item ) {

        if ( isset( $item['data'] ) ) {

            $product = $item['data'];

        } else {

            continue;
        }

        if ( ! is_object( $product ) ) {
            continue;
        }
         $is_pricing_group = false;
    if (isset($product->group_name)) {
        // It's a pricing group
		$is_pricing_group = true;
    }
    if (!$is_pricing_group){

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
        $offered_price_per_each = isset( $item['offered_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', ($item['offered_price_per_each']) ) ) : $price;
        $approved_price_per_each = isset( $item['approved_price_per_each'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', ($item['approved_price_per_each']) ) ) : $offered_price_per_each;

        $price         = $price * $price_qty_multiplier;
        $qty_display   = $item['quantity'];
        $offered_price = isset( $item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['offered_price'] ) ) : $offered_price_per_each * $price_qty_multiplier;
        $approved_price = isset( $item['approved_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['approved_price'] ) ) : $approved_price_per_each * $price_qty_multiplier;
        $product_link  = $product ? admin_url( 'post.php?post=' . $product->get_id() . '&action=edit' ) : '';
        $thumbnail     = $product ? apply_filters( 'woocommerce_admin_order_item_thumbnail', $product->get_image( 'thumbnail', array( 'title' => '' ), false ), $item_id, $item ) : '';

        $offered_price_subtotal += floatval( $offered_price ) * intval( $qty_display ) / $price_qty_multiplier;
        $approved_price_subtotal += floatval( $approved_price ) * intval( $qty_display ) / $price_qty_multiplier;
  }
    }

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
                $total = $total;
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
                <td colspan=""><?php echo esc_html__('Shipping Cost', 'addify_rfq' ); ?></td>
                <td colspan="2" class="afrfq_shipping_cost">
                    <input type="number" step="any" min="0" name="afrfq_shipping_cost" value="<?php echo esc_html( $total ); ?>">
                </td>
            </tr>
            <?php
            continue;
        }

        ?>
        <tr class="row-<?php echo $key;?>">
            <td scope="row"><?php echo esc_html( $label ); ?></td>
            <th colspan="2"><?php echo wp_kses_post( wc_price( $total ) ); ?></th>
        </tr>
        <?php
    }
    ?>

    <tr>
        <td colspan="3"><?php echo esc_html__('Note: Tax/Vat will be calculated on quote conversion to order but it is visible to customers.', 'addify_rfq' ); ?></td>
    </tr>

</tbody>