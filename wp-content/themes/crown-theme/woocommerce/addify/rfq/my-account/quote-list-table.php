<?php
/**
 * Quote details in my Account.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/addify/rfq/my-account/quote-list-table.php.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

$af_fields_obj = new AF_R_F_Q_Quote_Fields();
$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
$exp_date_field_name = '';
$po_number_field_name = '';
$field_id = '';
foreach ($fields as $key => $field ) {
	$field_id = $field->ID;
	$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
	if ( $field_label === 'Expiration Date' ) {
		$exp_date_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
	}

    if ( $field_label === 'PO Number' ) {
        $po_number_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
    }
}
if ( ! empty( $exp_date_field_name ) ) {
	$expiration_date = get_post_meta( $field_id, $exp_date_field_name, true );
	if ( empty( $expiration_date ) ) {
		$expiration_date = date( 'Y-m-d', strtotime( '+30 days' ) );
		update_post_meta( $field_id, $exp_date_field_name, $expiration_date );
	}
}

if ( ! empty( $customer_quotes ) ) {
	$statuses['af_expired'] = __( 'Expired', 'addify_rfq' );
	?>
	<table class="shop_table shop_table_responsive cart my_account_orders my_account_quotes">
		<thead>
			<tr>
				<th data-title=""><?php echo esc_html__( 'Quote', 'addify_rfq' ); ?></th>
				<th><?php echo esc_html__( 'Status', 'addify_rfq' ); ?></th>
				<th><?php echo esc_html__( 'Type', 'addify_rfq' ); ?></th>
				<th><?php echo esc_html__( 'Date', 'addify_rfq' ); ?></th>
				<th><?php echo esc_html__( 'Action', 'addify_rfq' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( $customer_quotes as $quote ) {
				global $addify_rfq;
				$quote_type_value = get_post_meta( $quote->ID, 'quote_type', true );
				$quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) ? $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) : '---'; 
				$quote_status = get_post_meta( $quote->ID, 'quote_status', true );
                $po_number = $po_number_field_name ? get_post_meta($quote->ID, $po_number_field_name, true) : '';
				?>
				<tr>
					<td data-title="ID">
						<a href="<?php echo esc_url( wc_get_endpoint_url( 'request-quote', $quote->ID ) ); ?>">
							<?php echo esc_html__( '#', 'addify_rfq' ) . intval( $quote->ID ); ?>
						</a>
					</td>
					<td data-title="Status">
						<?php echo isset( $statuses[ $quote_status ] ) ? esc_html( $statuses[ $quote_status ] ) : 'Pending'; ?>
						<?php if ( $quote_status == 'af_accepted' && ! empty( $exp_date_field_name ) ) { ?>
							<?php $expiration_date = get_post_meta( $quote->ID, $exp_date_field_name, true ); ?>
							<?php if ( ! empty( $expiration_date ) ) { ?>
								(exp. <?php echo date( 'n/j/Y', strtotime( $expiration_date ) ); ?>)
							<?php } ?>
						<?php } ?>
					</td>
					<td data-title="Type">
						<?php echo esc_html( $quote_type_name ); ?>
					</td>
					<td data-title="Date">
						<time datetime="<?php echo esc_attr( gmdate( 'Y-m-d', strtotime( $quote->post_date ) ) ); ?>" title="<?php echo esc_attr( strtotime( $quote->post_date ) ); ?>"><?php echo esc_attr( date_i18n( get_option( 'date_format' ), strtotime( $quote->post_date ) ) ); ?></time>
					</td>							
					<td data-title="Action">
						<a href="<?php echo esc_url( wc_get_endpoint_url( 'request-quote', $quote->ID ) ); ?>" class="woocommerce-button button view">
							<?php echo esc_html__( 'View', 'addify_rfq' ); ?>
						</a>
						<?php
						$afrfq_enable = 'yes' === get_option( 'afrfq_enable_convert_order' ) ? true : false;
						$quote_type_id  = get_post_meta( $quote->ID, 'quote_type', true );
						$disable_convert_order_button = false;
						if ($quote_type_id) {
							if ('yes' === get_post_meta($quote_type_id, 'quote_type_disable_convert_order', true)) {
							$disable_convert_order_button = true;
							}
						}
                        $afrfq_enable = apply_filters( 'enable_convert_to_order_in_users_profile', $afrfq_enable );
						if (in_array( $quote_status, array( 'af_accepted', 'af_in_process' ), true ) && $afrfq_enable && ! $disable_convert_order_button) :
							?>
							<form class="quote-convert-to-order" method="post">
								<button type="submit" value="<?php echo intval($quote->ID); ?>" name="addify_convert_to_order_customer" class="button button-primary button-large"><?php echo esc_html__( 'Convert to Order', 'addify_rfq'); ?></button>
							</form>
						<?php endif; ?>
						
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

<?php } else { ?>

	<div class="woocommerce-MyAccount-content">
		<div class="woocommerce-notices-wrapper"></div>
		<div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
			<a class="woocommerce-Button button" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php echo esc_html__( 'Go to shop', 'addify_rfq' ); ?></a><?php echo esc_html__( 'No quote has been made yet.', 'addify_rfq' ); ?></div>
	</div>
	<?php
}

