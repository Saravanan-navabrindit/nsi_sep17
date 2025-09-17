<?php
/**
 * Orders
 *
 * Show order selection form on the RMA creation page.
 */

defined( 'ABSPATH' ) || exit; ?>
<form method="post" action="">
    <h3><?php esc_html_e( 'Select Order', 'nsi-rma' ); ?></h3><div></div>
    <table class="woocommerce-orders-table shop_table shop_table_responsive my_account_orders account-orders-table">
        <thead>
            <tr>
                <th scope="col" class="woocommerce-orders-table__header woocommerce-orders-table__header-select-order"><span class="nobr"></span></th>
                <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) : ?>
                    <th scope="col" class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
                <?php endforeach; ?>
            </tr>
        </thead>

        <tbody>
            <?php
            $data = WC()->session->get('return_request_data') ?: [];
            $selected_order_id = $data['order_id'] ?? 0;
            foreach ( $customer_orders as $order ) {
                $order_id = $order->ID;
                $tooltip_attr = $disabled_class = $disabled = '';
                if ( ! NSI_RMA_Multistep_Form::is_order_available_for_return( $order ) ) {
                    $tooltip_attr = 'data-tooltip="' . esc_html__($tooltip_text, 'nsi-rma') . '"';
                    $disabled_class = 'item-disabled rma-tooltip';
                    $disabled = 'disabled';
                }
                $item_count = $order->get_item_count() - $order->get_item_count_refunded();
                ?>
                <tr class="woocommerce-orders-table__row order <?php echo esc_attr( $disabled_class ); ?> " <?php echo ' ' . $tooltip_attr; ?> >
                    <?php $checked = ($order_id == $selected_order_id) ? 'checked' : ''; ?>
                    <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-select-order">
                        <input type="radio" name="selected_order" value="<?php echo esc_attr($order_id); ?>" <?php echo esc_attr($checked); echo esc_attr($disabled); ?> >
                    </td>
                    <?php foreach ( wc_get_account_orders_columns() as $column_id => $column_name ) :
                        $is_order_number = 'order-number' === $column_id;
                        ?>
                        <?php if ( $is_order_number ) : ?>
                        <th class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>" scope="row">
                    <?php else : ?>
                        <td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
                    <?php endif; ?>

                        <?php if ( has_action( 'woocommerce_my_account_my_orders_column_' . $column_id ) ) : ?>
                        <?php do_action( 'woocommerce_my_account_my_orders_column_' . $column_id, $order ); ?>

                    <?php elseif ( $is_order_number ) : ?>
                        <?php /* translators: %s: the order number, usually accompanied by a leading # */ ?>
                        <?php echo esc_html( _x( '#', 'hash before order number', 'woocommerce' ) . $order->get_order_number() ); ?>

                    <?php elseif ( 'order-date' === $column_id ) : ?>
                        <time datetime="<?php echo esc_attr( $order->get_date_created()->date( 'c' ) ); ?>"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></time>

                    <?php elseif ( 'order-status' === $column_id ) : ?>
                        <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?>

                    <?php elseif ( 'order-type' === $column_id ) : ?>
                        <?php echo Crown_Order_Types::get_order_type( $order->get_id() )['name'] ?? ''; ?>

                    <?php elseif ( 'order-total' === $column_id ) : ?>
                        <?php
                        /* translators: 1: formatted order total 2: total order items */
                        echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce' ), $order->get_formatted_order_total(), $item_count ) );
                        ?>

                    <?php endif; ?>

                        <?php if ( $is_order_number ) : ?>
                        </th>
                    <?php else : ?>
                        </td>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div></div>
    <?php wp_nonce_field( 'rma_order_selection_nonce', 'rma_order_selection_nonce' ); ?>
    <div class="wc-add-rma">
        <button name="next_step" class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button" type="submit" disabled><?php esc_html_e( 'Next', 'nsi-rma' ); ?></button>
    </div>
</form>
