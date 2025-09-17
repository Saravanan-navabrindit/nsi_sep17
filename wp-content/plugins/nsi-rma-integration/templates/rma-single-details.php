<?php
/**
 * Return Order
 *
 * Shows the details of a single Return Order on the account page
 */

defined( 'ABSPATH' ) || exit;

$return_items = maybe_unserialize( $rma_postmeta['items'][0] ) ?? array();
$return_status = $rma_postmeta['rma_status'][0] ?? '';
$order_id = $rma_postmeta['order_id'][0] ?? '';
$order = wc_get_order($order_id);
$order_items = $order->get_items();

?>
<p>
    <?php
    printf(
        esc_html__( 'Return Request #%1$s for Order #%2$s was placed on %3$s and is currently %4$s.', 'nsi-rma' ),
        '<mark class="order-number">' . $rma_id . '</mark>',
        '<mark class="order-number">' . $order_id . '</mark>',
        '<mark class="order-date">' . $return_order->post_date . '</mark>',
        '<mark class="order-status">' . NSI_RMA_Post_Type::$rma_statuses[$return_status] ?? $return_status . '</mark>'
    );
    ?>
</p>
<section class="woocommerce-order-details">
    <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Return details', 'nsi-rma' );?></h2>
    <table class="return-details">
        <tbody>
        <tr>
            <th><?php esc_html_e( 'Sales Order#:', 'nsi-rma' ); ?></th>
            <td><?php echo $rma_postmeta['ns_order_tran_id'][0] ?? ''; ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'PO#:', 'nsi-rma' ); ?></th>
            <td><?php echo $rma_postmeta['customer_po_number'][0] ?? ''; ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Return reason:', 'nsi-rma' ); ?></th>
            <td><?php echo NSI_RMA_Post_Type::get_return_reason_displayed_label( $rma_postmeta ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Restocking fees:', 'nsi-rma' ); ?></th>
            <td><?php echo NSI_RMA_Post_Type::get_restocking_fees_display_value( $rma_postmeta['restocking_fees'][0] ?? null ); ?></td>
        </tr>
        <tr>
            <th><?php esc_html_e( 'Customer note:', 'nsi-rma' ); ?></th>
            <td><?php echo esc_html( $rma_postmeta['customer_note'][0] ?? '' ); ?></td>
        </tr>
        </tbody>
    </table>
    <?php
    if ( isset($rma_postmeta['ns_return_internal_id'][0]) ) {
        echo NSI_RMA_Listings::get_return_pdf_button( $rma_id );
    } ?>
    <table class="shop_table shop_table_responsive order_details" cellspacing="0">
        <thead>
            <tr>
                <th class="product-name"><?php esc_html_e( 'Product', 'nsi-rma' ); ?></th>
                <th class="product-price"><?php esc_html_e( 'Price', 'nsi-rma' ); ?></th>
                <th class="product-quantity"><?php esc_html_e( 'Quantity', 'nsi-rma' ); ?></th>
                <th class="product-total"><?php esc_html_e( 'Total', 'nsi-rma' ); ?></th>
            </tr>
        </thead>
        <tbody>

        <?php
        foreach ( $return_items as $return_item_id => $product_data ) {
            if ( isset($product_data['product_id']) ) {
                $product_id = $product_data['product_id'];
                $product = wc_get_product( $product_id );
            } else {
                $product_id = wc_get_product_id_by_sku( $product_data['sku'] );
                $product = wc_get_product( $product_id );
            }

            $product_permalink = $product->get_permalink();
            ?>
            <tr class="woocommerce-table__line-item order_item">
                <td class="woocommerce-table__product-name product-name" data-title="<?php esc_attr_e( 'Product', 'nsi-rma' ); ?>">
                    <?php
                    echo '<a href="' . esc_url( $product_permalink ) . '">' . $product->get_name() . '</a>';
                    echo '<div class="sku">' . $product_data['sku'] . '</div>';
                    ?>
                </td>

                <td class="woocommerce-table__product-total product-total" data-title="<?php esc_attr_e( 'Price', 'nsi-rma' ); ?>">
                    <?php echo wc_price( $product_data['rate'], array( 'currency' => $order->get_currency() ) ); ?>
                </td>

                <td class="woocommerce-Price-amount amount" data-title="<?php esc_attr_e( 'Quantity', 'nsi-rma' ); ?>">
                    <?php
                    echo '&times; ' . $product_data['qty'];
                    ?>
                </td>

                <td class="woocommerce-table__product-total product-total" data-title="<?php esc_attr_e( 'Total', 'nsi-rma' ); ?>">
                    <?php echo wc_price( ($product_data['rate'] * $product_data['qty']), array( 'currency' => $order->get_currency() ) ); ?>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</section>
