<table class="rma-details">
    <tbody>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'Return Request status:', 'nsi-rma' ); ?></th>
        <td><?php echo NSI_RMA_Post_Type::$rma_statuses[$return_status] ?? $return_status; ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'Original WC order ID:', 'nsi-rma' ); ?></th>
        <td><?php echo $order_id; ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'Sales Order#:', 'nsi-rma' ); ?></th>
        <td><?php echo $return_post_meta['ns_order_tran_id'][0] ?? ''; ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'PO#:', 'nsi-rma' ); ?></th>
        <td><?php echo $return_post_meta['customer_po_number'][0] ?? ''; ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'Return reason:', 'nsi-rma' ); ?></th>
        <td><?php echo $reason_label ?? ''; ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'Restocking fees:', 'nsi-rma' ); ?></th>
        <td><?php echo NSI_RMA_Post_Type::get_restocking_fees_display_value( $return_post_meta['restocking_fees'][0] ?? null ); ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'Customer note:', 'nsi-rma' ); ?></th>
        <td><?php echo esc_html($return_post_meta['customer_note'][0] ?? ''); ?></td>
    </tr>
    <tr class="admin-return-detail">
        <th><?php esc_html_e( 'NS Return Internal ID:', 'nsi-rma' ); ?></th>
        <td><?php echo $return_post_meta['ns_return_internal_id'][0] ?? ''; ?></td>
    </tr>
    </tbody>
</table>