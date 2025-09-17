<?php
/**
 * Order items
 *
 * Shows order items selection form on the RMA creation page.
 */

defined( 'ABSPATH' ) || exit; ?>


<h2><?php echo sprintf( __( 'Select Items from Order #%s', 'nsi-rma' ), $order->get_order_number() ); ?></h2>
<form method="post" action="">
    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
        <thead>
            <tr>
                <th><input type="checkbox" id="select-all-items" title="Select all"></th>
                <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'nsi-rma' ); ?></th>
                <th class="woocommerce-table__product-total product-total"><?php esc_html_e( 'Total', 'nsi-rma' ); ?></th>
                <th class="woocommerce-table__product-table product-qty-shipped"><?php esc_html_e( 'Quantity Shipped', 'nsi-rma' ); ?></th>
                <th class="woocommerce-table__product-table product-qty-ordered"><?php esc_html_e( 'Quantity Ordered', 'nsi-rma' ); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ( $order->get_items() as $item_id => $item ) {
            $product = $item->get_product();
            if ( ! $product || ! $product->exists() ) {
                continue;
            }
            $item_class_attr = $disabled = $tooltip_attr = '';
            $quantity = $item->get_quantity();
            $tooltip = NSI_RMA_Multistep_Form::get_tooltip_attr_if_item_disabled( $item_id, $product, $quantity, $shipping_data );
            if ( ! empty( $tooltip ) ) {
                $tooltip_attr = 'data-tooltip="' . esc_html__($tooltip, 'nsi-rma') . '"';
                $item_class_attr = 'class="item-disabled rma-tooltip"';
                $disabled = 'disabled';
            }
            $checked = in_array( $item_id, $selected_items ) ? 'checked' : ''; ?>
            <tr <?php echo $item_class_attr; ?> <?php echo $tooltip_attr; ?>>
                <td><input type="checkbox" name="selected_items[]" value="<?php echo esc_attr( $item_id ); ?>" <?php echo $checked; ?> <?php echo $disabled; ?>></td>
                <td class="product-name"><?php echo esc_html( $product->get_name() );
                do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false ); ?>
                </td>
                <td class="product-total"><?php echo $order->get_formatted_line_subtotal( $item ) ?></td>
                <?php if ( ! empty( $shipping_data ) ) {
                    $quantity_billed = $shipping_data[$product->get_sku()]['quantity_billed'] ?? 0; ?>
                    <td class="value-shipped-qty" data-sort-value="<?php echo $quantity_billed; ?>"><small class="times">×</small><?php echo $quantity_billed; ?></td>
                <?php } else { ?>
                    <td class="value-shipped-qty" data-sort-value="0"><small class="times">×</small>0</td>
                <?php } ?>
                <td class="woocommerce-table__product-qty-ordered product-qty-ordered">
                <?php echo apply_filters( 'woocommerce_order_item_quantity_html', sprintf( '&times;&nbsp;%s', esc_html( $quantity ) ), $item ); ?>
                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

    <p class="form-row form-row-wide validate-required">
        <label for="order_return_reason" class="required_field"><?php esc_html_e( 'Return Reason', 'nsi-rma' ); ?>
            <span class="required" aria-hidden="true">*</span>
        </label>
        <select name="order_return_reason" id="order-return-reason" required="required">
            <?php $returns_settings_reasons = get_option( 'returns_settings_reasons' );
            $reasons_for_returns = $returns_settings_reasons['data'] ?? array();
            if( !empty( $reasons_for_returns ) ){
                $rows = count( $reasons_for_returns['reason-key'] );
                for( $i = 0; $i <= $rows; $i++ ) {
                    $key = $reasons_for_returns['reason-key'][$i];
                    $reason = $reasons_for_returns['reason-label'][$i];
                    if ( empty($key) || empty($reason) ) {
                        continue;
                    } ?>
                    <option value="<?php echo $key; ?>" <?php echo selected($order_return_reason, $key, false); ?>><?php echo $reason; ?></option>
                <?php }
            } ?>
        </select>
    </p>
    <div id="return-fees-warning" class="woocommerce-message" style="margin-top: 1em;">
        <?php esc_html_e( NSI_RMA_Multistep_Form::$rma_disclaimer_settings['return_fees_notice'], 'nsi-rma' ); ?>
    </div>
    <p class="form-row form-row-wide validate-required">
        <label for="customer_note" class="required_field"><?php esc_html_e( 'Customer Note', 'nsi-rma' ); ?>
            <span class="required" aria-hidden="true">*</span>
        </label>
        <textarea name="customer_note" id="customer-note" rows="3" required="required" class="input-text" placeholder="Return reason details" rows="3" cols="5" maxlength="256"><?php echo esc_textarea($customer_note); ?></textarea></p><br>
    <div class="wc-add-rma">
        <?php wp_nonce_field( 'rma_order_items_selection_nonce', 'rma_order_items_selection_nonce' ); ?>
        <a href="<?php echo esc_url( add_query_arg('step', 1) ); ?>" class="woocommerce-button--next back-button woocommerce-button button"><?php esc_html_e( 'Back', 'nsi-rma' ); ?></a>
        <button name="next_step" class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" type="submit" disabled><?php esc_html_e( 'Next', 'nsi-rma' ); ?></button>
    </div>
</form>