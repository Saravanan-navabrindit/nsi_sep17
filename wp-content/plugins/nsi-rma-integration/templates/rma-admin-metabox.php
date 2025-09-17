<div id="woocommerce-order-items">
    <div class="woocommerce_order_items_wrapper wc-order-items-editable">
        <table cellpadding="0" cellspacing="0" class="woocommerce_order_items">
            <thead>
            <tr>
                <th class="item" colspan="2" data-sort="string-ins"><?php esc_html_e( 'Item', 'woocommerce' ); ?></th>
                <th class="item_cost" data-sort="float"><?php esc_html_e( 'Cost', 'woocommerce' ); ?></th>
                <th class="quantity" data-sort="int"><?php esc_html_e( 'Qty', 'woocommerce' ); ?></th>
                <th class="line_cost" data-sort="float"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
                <th class="wc-order-edit-line-item" width="1%">&nbsp;</th>
            </tr>
            </thead>
            <tbody id="order_line_items">
            <?php
            foreach ( $return_items as $return_item_id => $product_data ) {
                if ( isset($product_data['product_id']) ) {
                    $product_id = $product_data['product_id'];
                    $product = wc_get_product( $product_id );
                } else {
                    $product_id = wc_get_product_id_by_sku( $product_data['sku'] );
                    $product = wc_get_product( $product_id );
                }
                $product_link = $product ? admin_url( 'post.php?post=' . $product_id . '&action=edit' ) : '';
                $thumbnail    = $product ? apply_filters( 'woocommerce_admin_order_item_thumbnail', $product->get_image( 'thumbnail', array( 'title' => '' ), false ), $product_id, $product ) : '';
                $row_class    =! empty( $class ) ? $class : '';
                ?>
                <tr class="item <?php echo esc_attr( $row_class ); ?>" data-order_item_id="<?php echo esc_attr( $product_id ); ?>">
                    <td class="thumb">
                        <?php echo '<div class="wc-order-item-thumbnail">' . wp_kses_post( $thumbnail ) . '</div>'; ?>
                    </td>
                    <td class="name">
                        <?php
                        echo $product_link ? '<a href="' . esc_url( $product_link ) . '" class="wc-order-item-name">' . wp_kses_post( $product->get_name() ) . '</a>' : '<div class="wc-order-item-name">' . wp_kses_post( $product->get_name() ) . '</div>';

                        if ( $product && $product->get_sku() ) {
                            echo '<div class="wc-order-item-sku"><strong>' . esc_html__( 'SKU:', 'woocommerce' ) . '</strong> ' . esc_html( $product->get_sku() ) . '</div>';
                        }

                        ?>
                    </td>

                    <td class="item_cost" width="1%">
                        <div class="view">
                            <?php
                            echo wc_price( $product_data['rate'], array( 'currency' => $order->get_currency() ) );
                            ?>
                        </div>
                    </td>
                    <td class="quantity" width="1%">
                        <div class="view">
                            <?php
                            echo '<small class="times">&times;</small> ' . esc_html( $product_data['qty'] );
                            ?>
                        </div>
                    </td>
                    <td class="line_cost" width="1%">
                        <div class="view">
                            <?php
                            echo wc_price( ($product_data['rate'] * $product_data['qty']), array( 'currency' => $order->get_currency() ) );
                            ?>
                        </div>
                    </td>
                    <td class="wc-order-edit-line-item" width="1%">
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>