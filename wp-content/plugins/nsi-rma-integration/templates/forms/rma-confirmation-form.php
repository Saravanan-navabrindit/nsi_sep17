<?php
/**
 * Confirmation
 *
 * Shows confirmation form on the RMA creation page.
 */

defined( 'ABSPATH' ) || exit;

$user_id = get_current_user_id();
$submission_token = wp_generate_uuid4();
set_transient( 'rma_form_token_' . $user_id, $submission_token, 5 * MINUTE_IN_SECONDS );
?>

<h2><?php esc_html_e( 'Review and Submit', 'nsi-rma' ); ?></h2>
<p><strong><?php esc_html_e( 'Order:', 'nsi-rma' ); ?></strong> #<?php echo $order->get_order_number(); ?></p>
<p><strong><?php esc_html_e( 'Reason for return:', 'nsi-rma' ); ?></strong> <?php echo esc_html($return_reason); ?></p>
<p><strong><?php esc_html_e( 'Customer note:', 'nsi-rma' ); ?></strong> <?php echo esc_html($data['customer_note']); ?></p>

<strong><?php esc_html_e( 'Selected items:', 'nsi-rma' ); ?></strong>
<table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
    <thead>
        <tr>
            <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'nsi-rma' ); ?></th>
            <th class="woocommerce-table__product-total product-total"><?php esc_html_e( 'Total', 'nsi-rma' ); ?></th>
            <th class="woocommerce-table__product-table product-qty-shipped"><?php esc_html_e( 'Quantity Shipped', 'nsi-rma' ); ?></th>
            <th class="woocommerce-table__product-table product-qty-ordered"><?php esc_html_e( 'Quantity Ordered', 'nsi-rma' ); ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $shipping_data = get_post_meta( $order_id, 'shipping_data', true );
    $shipping_data = json_decode( $shipping_data, true );
    $rma_total = 0;
    foreach ( $order->get_items() as $item_id => $item ) {
        if (!in_array($item_id, $data['items'])) continue;
        $product = $item->get_product();
        if ( ! $product || ! $product->exists() ) {
            continue;
        }
        $item_subtotal = $order->get_line_subtotal( $item );
        $rma_total += $item_subtotal;
        $quantity = $item->get_quantity(); ?>
        <tr>
            <td class="product-name"><?php echo esc_html( $product->get_name() );
            do_action( 'woocommerce_order_item_meta_start', $item_id, $item, $order, false ); ?>
            </td>
            <td class="product-total"><?php echo wc_price( $item_subtotal, array( 'currency' => $order->get_currency() ) ); ?></td>
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
<?php if ( $rma_total <= get_option( 'returns_settings_max_amount_no_returns_available', 250 ) && 1 == get_option( 'returns_settings_no_returns_available_enabled', false ) ) { ?>
    <div class="woocommerce-message" style="margin-top: 1em;">
        <?php esc_html_e( get_option( 'returns_settings_no_returns_available_notice', '' ), 'nsi-rma' ); ?>
    </div>
<?php } ?>
<form id="return-request-confirmation" method="post">
    <div class="form-row form-row-wide">
        <p>
            <label class="agree-policy">
                <input type="checkbox" id="agree-policy" name="agree_policy"><?php esc_html_e( ' I have read and agree to the ', 'nsi-rma' ); ?><a href="<?php echo esc_url( $return_policy_url ); ?>" target="_blank"><?php esc_html_e( 'return policy', 'nsi-rma' ); ?></a>.
            </label>
        </p>
        <input type="hidden" name="rma_submission_token" value="<?php echo esc_attr($submission_token); ?>" />
    </div>
    <div class="wc-add-rma">
        <?php wp_nonce_field( 'rma_confirmation_nonce', 'rma_confirmation_nonce' ); ?>
        <a href="<?php echo esc_url( add_query_arg('step', 2) ); ?>" class="woocommerce-button--next back-button woocommerce-button button"><?php esc_html_e( 'Back', 'nsi-rma' ); ?></a>
        <button type="submit" name="submit_final" class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" disabled><?php esc_html_e( 'Submit', 'nsi-rma' ); ?></button>
    </div>
</form>