<?php
/**
 * Return orders
 *
 * Shows return orders on the RMA creation page.
 */

defined( 'ABSPATH' ) || exit;

if ( ! empty( $return_orders ) ) {
    ?>
    <table class="shop_table shop_table_responsive my_account_orders my_account_returns">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Sales Order#', 'nsi-rma' ); ?></th>
                <th><?php esc_html_e( 'PO#', 'nsi-rma' ); ?></th>
                <th><?php esc_html_e( 'Return Confirmation#', 'nsi-rma' ); ?></th>
                <th><?php esc_html_e( 'Return Status', 'nsi-rma' ); ?></th>
                <th><?php esc_html_e( 'Restocking Fees', 'nsi-rma' ); ?></th>
                <th><?php esc_html_e( 'Action', 'nsi-rma' ); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $return_orders as $rma ) {
                $rma_id = $rma->ID;
                $post_meta = get_post_meta( $rma_id );
                $order_id = $post_meta['order_id'][0] ?? '';
                $order = wc_get_order($order_id);
                $return_status = $post_meta['rma_status'][0] ?? '';
                ?>
                <tr>
                    <td data-title="Sales Order#">
                        <?php echo $post_meta['ns_order_tran_id'][0] ?? ''; ?>
                    </td>
                    <td data-title="PO#">
                        <?php echo $post_meta['customer_po_number'][0] ?? ''; ?>
                    </td>
                    <td data-title="Return Confirmation#">
                        <?php echo $post_meta['ns_return_internal_id'][0] ?? ''; ?>
                    </td>
                    <td data-title="Status">
                        <?php echo NSI_RMA_Post_Type::$rma_statuses[$return_status] ?? $return_status; ?>
                    </td>
                    <td data-title="Restocking fees">
                        <?php echo NSI_RMA_Post_Type::get_restocking_fees_display_value( $post_meta['restocking_fees'][0] ?? null ); ?>
                    </td>
                    <td data-title="Action">
                        <a href="<?php echo esc_url( wc_get_endpoint_url( 'returns', $rma_id ) ); ?>"
                           class="woocommerce-button button view">
                            <?php esc_html_e( 'View', 'nsi-rma' ); ?>
                        </a>
                    </td>
                </tr>
        <?php } ?>
        </tbody>
    </table>
<?php }