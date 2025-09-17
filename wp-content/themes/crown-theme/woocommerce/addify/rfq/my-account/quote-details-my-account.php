<?php
/**
 * Quote details in my Account.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/addify/rfq/my-account/quote-details-my-account.php.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;

$quote_contents = get_post_meta( $afrfq_id, 'quote_contents', true );
$quote_status   = get_post_meta( $afrfq_id, 'quote_status', true );
$quote_coverter = get_post_meta( $afrfq_id, 'converted_by', true );
$quote_type     = get_post_meta( $afrfq_id, 'quote_type', true );
$user_role = wp_get_current_user()->roles[0];
$quote_type_id  = get_post_meta( $afrfq_id, 'quote_type', true );
$conv_enable = 'yes' === get_option( 'afrfq_enable_converted_by' ) ? true : false;
$statuses    = array(
	'af_pending'    => __( 'Pending', 'addify_rfq' ),
	'af_in_process' => __( 'In Process', 'addify_rfq' ),
	'af_accepted'   => __( 'Accepted', 'addify_rfq' ),
	'af_converted'  => __( 'Converted to Order', 'addify_rfq' ),
	'af_declined'   => __( 'Declined', 'addify_rfq' ),
	'af_cancelled'  => __( 'Cancelled', 'addify_rfq' ),
	'af_expired'    => __( 'Expired', 'addify_rfq' ),
);

if ( ! isset( $af_quote ) ) {
	$af_quote = new AF_R_F_Q_Quote();
}

$quote_totals = $af_quote->get_calculated_totals( $quote_contents, $afrfq_id );

$price_display    = 'yes' === get_option( 'afrfq_enable_pro_price' ) ? true : false;
$of_price_display = 'yes' === get_option( 'afrfq_enable_off_price' ) ? true : false;
$tax_display      = 'yes' === get_option( 'afrfq_enable_tax' ) ? true : false;

$has_discount_rules = ( get_post_meta( $quote->ID, 'quote_type_discount_rules', true ) === 'yes' );
$discount_rule = (get_post_meta($quote_type_id, 'quote_type_discount_rules', true));

$quote_pricing_groups = get_post_meta( $afrfq_id, 'quote_pricing_groups', true );

$customer_info   = array();
$field_label_map = array();
$quote_fiels_obj = new AF_R_F_Q_Quote_Fields();
$quote_fields    = (array) $quote_fiels_obj->afrfq_get_fields_enabled();
foreach ( $quote_fields as $key => $field ) {
	$afrfq_field_name  = get_post_meta( $field->ID, 'afrfq_field_name', true );
	$afrfq_field_type  = get_post_meta( $field->ID, 'afrfq_field_type', true );
	$afrfq_field_label = get_post_meta( $field->ID, 'afrfq_field_label', true );
	$field_data        = get_post_meta( $afrfq_id, $afrfq_field_name, true );

	$field_label_map[ $afrfq_field_label ] = $field->ID;

	if ( is_array( $field_data ) ) $field_data = implode( ', ', $field_data );
	if ( 'terms_cond' == $afrfq_field_type || 'Email attachment format' === $afrfq_field_label ) continue;
	if ( in_array( $afrfq_field_type, array( 'select', 'radio', 'mutliselect' ), true ) ) $field_data = ucwords( $field_data );
	if ( 'file' == $afrfq_field_type && ! empty( $field_data ) ) {
		$style      = 'display: block; width: 100%; text-decoration:none; background-color: #129FE0; color: white; text-align: center; width: 100%; max-width: 125px; margin: 0 auto; padding: 5px 10px; font-size: 16px; line-height: 26px; height: 25px; max-height: 25px; border-radius: 3px;';
		$field_data = sprintf( '<a class="button" style="%s" href="%s">%s</a>', esc_attr( $style ), esc_url( AFRFQ_URL . '/uploads/' . $field_data ), esc_html__( 'View File', 'addify_rfq' ) );
	}
	if ( 'date' == $afrfq_field_type ) $field_data = date_i18n( get_option( 'date_format' ), strtotime( $field_data ) );
	$customer_info[ $afrfq_field_label ] = $field_data;
	if ( 'PO Number' == $afrfq_field_label && empty( $field_data ) ) $customer_info[ $afrfq_field_label ] = '==BLANK==';
}

$readonly_inputs = defined('AFRFQ_READONLY_FIELDS_INPUT') ? AFRFQ_READONLY_FIELDS_INPUT : [];

$frontend_quote_fields_editable = apply_filters( 'frontend_quote_fields_editable', true );

?>
<section class="woocommerce-order-details addify-quote-details">
	<?php do_action( 'addify_before_quote_table' ); ?>

	<form class="mb-5" method="post">
		<table class="shop_table order_details quote_details" cellspacing="0">
			<tr>
				<th class="quote-number"><?php esc_html_e( 'Quote Type', 'addify_rfq' ); ?></th>
				<?php
					global $addify_rfq;
					$quote_type_value = get_post_meta( $quote->ID, 'quote_type', true );
					$quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) ? $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) : '---'; 
				?>
				<td class="quote-number"><?php echo esc_html( $quote_type_name ); ?> </td>
			</tr>
			<tr>
				<th class="quote-number"><?php esc_html_e( 'Quote #', 'addify_rfq' ); ?></th>
				<td class="quote-number"><?php echo esc_html( $afrfq_id ); ?> </td>
			</tr>
			<tr>
				<th class="quote-date"><?php esc_html_e( 'Quote Date', 'addify_rfq' ); ?></th>
				<td class="quote-date"><?php echo esc_attr( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $quote->post_date ) ) ); ?> </td>
			</tr>
			<tr>
				<th class="quote-status"><?php esc_html_e( 'Current Status', 'addify_rfq' ); ?></th>
				<td class="quote-status"><?php echo isset( $statuses[ $quote_status ] ) ? esc_html( $statuses[ $quote_status ] ) : 'Pending'; ?> </td>
			</tr>
			<?php foreach ( $customer_info as $label => $value ) { ?>
				<?php
                $quote_fields = array('PO Number', 'Address line 1', 'Address line 2', 'City', 'State/Province', 'Postcode',
                                    'Distributor', 'Distributor Contact Name', 'Distributor Contact Number or Email', 'Your Email Address',
                                    'Customer Shipping Account Number', 'Shipping options', 'Ship to Company Name' );

				if ( ! isset( $field_label_map[ $label ] ) ) {
					$display_field = true;
				} else {
					$field_id = $field_label_map[ $label ];
					
					$afrfq_field_quote_types = (array) get_post_meta( $field_id, 'afrfq_field_quote_types', true );

					$display_field = ! $quote_type_id || empty( $afrfq_field_quote_types ) || in_array( (string) $quote_type_id, $afrfq_field_quote_types, true );
				}
				if ( ! $display_field ) {
					?>
					<input type="hidden" 
						name="<?php echo preg_replace( '/-+/', '_', sanitize_title( $label ) ); ?>" 
						value="<?php echo esc_attr( $value ); ?>">
					<?php
					continue;
				}

                if ( in_array( $label, $quote_fields) ) {
                    if ( $label == 'Shipping options' ) {
                        $value = strtolower( $value );
                        $shipping_methods = crown_get_zone_shipping_methods( 0 );
                        $quote_user_id = get_post_meta( $quote->ID, '_customer_user', true );
                        $minimum_order_amount = get_user_meta( $quote_user_id, 'min_order', true );

                        if ( !isset($quote_totals['_approved_total']) || $quote_totals['_approved_total'] <= $minimum_order_amount ) {
                            foreach ( $shipping_methods as $id => $method ) {
                                if ( $method['title'] == 6173 && $method[ 'label' ] == 'Free Standard Shipping' ) {
                                    unset( $shipping_methods[$id] );
                                }
                            }
                        }

                        ?>
                        <tr>
                            <th class="quote-field">
                                <?php echo $label; ?>
                            </th>
                            <td class="quote-field">
                                <select name="<?php echo preg_replace( '/-+/', '_', sanitize_title( $label ) ); ?>"
                                        class="" required
                                        <?php if ( !$frontend_quote_fields_editable ) echo "readonly";?>>
                                    <?php
                                    foreach ( $shipping_methods as $method_id => $method ) { ?>
                                        <option value="<?php echo esc_html( $method_id ); ?>"
                                        <?php if ( $value == $method_id ) echo ' selected' ?> >
                                        <?php echo esc_html( $method['label'] ); ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <?php
                    } else if ( in_array( $label, $readonly_inputs ) ) {
                        echo Crown_Shop_Display::render_field_as_readonly( $label, $value );
                    } else {
                        $type = $label === 'Your Email Address' ? 'email' : 'text';
                        ?>
                        <?php $value = $value == '==BLANK==' ? '' : $value; ?>
                        <tr>
                            <th class="quote-field">
                                <?php
                                echo $label;
                                echo $label === 'Customer Shipping Account Number' ? ' (optional)' : '';
                                echo $label === 'PO Number' ? '<br /><small>Required for converting to Order</small>' : '';
                                echo $label === 'Ship to Company Name' ? ' (if different from Distributor)' : '';
                                ?>
                            </th>
                            <td class="quote-field">
                                <input type="<?php echo $type ?>" name="<?php echo preg_replace( '/-+/', '_', sanitize_title( $label ) ); ?>"
                                       class="form-control form-control-sm mb-3" value="<?php echo esc_attr( $value ); ?>"
                                       <?php if ( ! in_array( $label, array('Customer Shipping Account Number', 'Ship to Company Name') ) ) echo ' required';?>
                                    <?php if ( !$frontend_quote_fields_editable ) echo " readonly";?>>
                            </td>
                        </tr>
                    <?php
                    }
				} else { ?>
					<tr>
						<th class="quote-field"><?php echo $label; ?></th>
						<td class="quote-field"><?php echo wp_kses_post( $value ); ?></td>
					</tr>
				<?php } ?>
			<?php } ?>
			<?php if ( $conv_enable && 'af_converted' === $quote_status ) : ?>
				<tr>
					<th class="quote-converter"><?php esc_html_e( 'Converted by', 'addify_rfq' ); ?></th>
					<td class="quote-converter"><?php echo esc_html( $quote_coverter ); ?> </td>
				</tr>
			<?php endif; ?>
		</table>
        <?php
        if ( $frontend_quote_fields_editable && ($discount_rule !== 'yes') && 'af_accepted' === $quote_status ) { ?>
		    <button type="submit" class="btn btn-dark ml-2">Update</button>
        <?php } ?>
		<?php wp_nonce_field( 'update-rfq-fields' ); ?>
	</form>
	<h2><?php echo esc_html__( 'Quote Details', 'addify_rfq' ); ?></h2>
	<?php
	$quote_status = get_post_meta( $quote->ID, 'quote_status', true );
	$not_editable_statuses = ['af_converted', 'af_cancelled', 'af_declined', 'af_expired', 'af_pending', 'af_in_process'];
	$not_editable_roles = ['branch_employee_viewer'];
	$price_base_type = get_post_meta( $quote->ID, '_price_base_type', true );

	if ( empty($price_base_type) ) {
		$price_base_type = defined('QUOTE_PRICE_BASE_TYPE') ? QUOTE_PRICE_BASE_TYPE : 'industry';
	}
	$price_base_notice = $price_base_type === 'moq' ? '' : 'Per Industry Standard';
	if ( in_array($quote_status, $not_editable_statuses) || in_array($user_role, $not_editable_roles) ) {
		$notice = WC()->session->get('notice_message');
		if ( isset($notice) ) {
			echo '<div class="woocommerce-message" role="alert">' . $notice . '</div>';
			WC()->session->__unset('notice_message');
		}
		$warnings = WC()->session->get('warning_messages');
		if ( isset($warnings) && is_array($warnings) && !empty($warnings) ) {
			echo '<div class="woocommerce-notices-wrapper">';
			echo '<div class="woocommerce-error" role="alert">';
			foreach ( $warnings as $warning ) {
				echo '<p>' . $warning . '</p>';
			}
			echo '</div>';
			echo '</div>';
			WC()->session->__unset('warning_messages');
		}
		if ( $has_discount_rules === "yes" || !empty( $quote_pricing_groups ) ) {
		?>
		<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents addify-quote-form__contents" cellspacing="0">
			<thead>
				<tr>
					<th class="product-name"><?php esc_html_e( 'Product Pricing Group', 'addify_rfq' ); ?></th>
					<th class="product-price"><?php esc_html_e( 'Discount Level', 'addify_rfq' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ( $quote_pricing_groups  as $group ) :
						if ( ! empty( $group['group_name'] ) && ! empty( $group['price_name'] ) ) : ?>
							<tr class="pricing-group-item">
								<td class="group-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
									<?php echo esc_html( $group['group_name'] ); ?>
								</td>
								<td class="discount-level" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
									<?php echo esc_html( $group['price_name'] ); ?>
								</td>
							</tr>
						<?php endif;
					endforeach;
				?>
			</tbody>
		</table>
		<?php
			} else {
		?>
		<table class="shop_table shop_table_responsive cart order_details quote_details" cellspacing="0">
			<thead>
				<tr>
					<th class="product-thumbnail">&nbsp;</th>
					<th class="product-name"><?php esc_html_e( 'Product', 'addify_rfq' ); ?></th>
					<?php if ( $price_display ) : ?>
						<th class="product-price">
							<?php esc_html_e( 'Price', 'addify_rfq' ); ?>
							<small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
						</th>
					<?php endif; ?>
					<?php if ( $of_price_display ) : ?>
						<?php if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) { ?>
							<th class="product-price">
								<?php esc_html_e( 'Approved Price', 'addify_rfq' ); ?>
								<small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
							</th>
						<?php } else { ?>
							<th class="product-price">
								<?php esc_html_e( 'Requested Price', 'addify_rfq' ); ?>
								<small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
							</th>
						<?php } ?>
					<?php endif; ?>
					<th class="product-quantity"><?php esc_html_e( 'Quantity', 'addify_rfq' ); ?></th>
					<?php if ( $price_display ) : ?>
						<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'addify_rfq' ); ?></th>
					<?php endif; ?>
					<?php if ( $of_price_display ) : ?>
						<?php if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) { ?>
							<th class="product-subtotal"><?php esc_html_e( 'Approved Subtotal', 'addify_rfq' ); ?></th>
						<?php } else { ?>
							<th class="product-subtotal"><?php esc_html_e( 'Requested Subtotal', 'addify_rfq' ); ?></th>
						<?php } ?>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'addify_before_quote_contents' ); ?>

				<?php
				$quote_totals['_subtotal'] = 0;
				$quote_totals['_total'] = 0;
				foreach ( $quote_contents as $quote_item_key => $quote_item ) {

					if ( ! isset( $quote_item['data'] ) || ! is_object( $quote_item['data'] ) ) {
						continue;
					}

					$_product      = apply_filters( 'addify_quote_item_product', $quote_item['data'], $quote_item, $quote_item_key );
					$product_id    = apply_filters( 'addify_quote_item_product_id', $quote_item['product_id'], $quote_item, $quote_item_key );
					if ($price_base_type === 'moq') {
						$price_qty_multiplier = intval( get_post_meta( $product_id, 'min_quantity', true ) );
						$price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
					} else {
						$price_qty_multiplier = get_post_meta( $product_id, 'ns_price_qty_multiplier', true );
						$price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
					}
					$price         = empty( $quote_item['addons_price'] ) ? $_product->get_price() : $quote_item['addons_price'];
					$offered_Price = isset( $quote_item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $quote_item['offered_price'] ) ) / $price_qty_multiplier : $price;

					if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) {
						$offered_Price = isset( $quote_item['approved_price'] ) ? floatval( $quote_item['approved_price'] ) / $price_qty_multiplier : $offered_Price;
					}

					// $price = $offered_Price > 0 ? $offered_Price : $price;
					$quote_totals['_subtotal'] += $price * $quote_item['quantity'];
					$quote_totals['_total'] += $price * $quote_item['quantity'];

					if ( $_product && $_product->exists() && $quote_item['quantity'] > 0 && apply_filters( 'addify_quote_item_visible', true, $quote_item, $quote_item_key ) ) {
						$product_permalink = apply_filters( 'addify_quote_item_permalink', $_product->is_visible() ? $_product->get_permalink( $quote_item ) : '', $quote_item, $quote_item_key );
						?>
						<tr class="addify__quote-item <?php echo esc_attr( apply_filters( 'addify_quote_item_class', 'cart_item', $quote_item, $quote_item_key ) ); ?>">

							<td class="product-thumbnail">
							<?php
							$thumbnail = apply_filters( 'addify_quote_item_thumbnail', $_product->get_image(), $quote_item, $quote_item_key );

							if ( ! $product_permalink ) {
								echo wp_kses_post( $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) ); // phpcs:ignore WordPress.Security.EscapeOutput
							}
							?>
							</td>

							<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'addify_rfq' ); ?>">
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( apply_filters( 'addify_quote_item_name', $_product->get_name(), $quote_item, $quote_item_key ) . '&nbsp;' );
							} else {
								echo wp_kses_post( apply_filters( 'addify_quote_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $quote_item, $quote_item_key ) );
							}
							?>
							<br>
							<?php
								echo '<div class="wc-order-item-sku"><strong>' . esc_html__( 'SKU:', 'woocommerce' ) . '</strong> ' . esc_html( $_product->get_sku() ) . '</div>';

							do_action( 'addify_after_quote_item_name', $quote_item, $quote_item_key );

							// Meta data.
							echo wp_kses_post( wc_get_formatted_cart_item_data( $quote_item ) ); // phpcs:ignore WordPress.Security.EscapeOutput

							// Backorder notification.
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $quote_item['quantity'] ) ) {
								echo wp_kses_post( apply_filters( 'addify_quote_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'addify_rfq' ) . '</p>', $product_id ) );
							}
							?>
							</td>

							<?php if ( $price_display ) : ?>
								<td class="product-price" data-title="<?php esc_attr_e( 'Price ' . $price_base_notice, 'addify_rfq' ); ?>">
									<?php
									if ($price_base_type === 'industry') {
										$multiplied_price = $price_qty_multiplier <= 1 ? $price : $price * $price_qty_multiplier;
										echo wp_kses_post( wc_price( $multiplied_price ) );
										echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
									} else {
										echo wp_kses_post( wc_price( $price ) );
									}
									?>
								</td>
							<?php endif; ?>
							
							<?php if ( $of_price_display ) : ?>
								<td class="product-price" data-title="<?php esc_attr_e( 'Offered Price ' . $price_base_notice, 'addify_rfq' ); ?>">
									<?php
									$multiplied_offered_price = $price_qty_multiplier <= 1 ? $offered_Price : $offered_Price * $price_qty_multiplier;
									echo wp_kses_post( wc_price( $multiplied_offered_price ) );
									if ($price_base_type === 'industry') {
										echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
									}
									?>
								</td>
							<?php endif; ?>
							
							<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'addify_rfq' ); ?>">
								<?php
								$qty_display = $quote_item['quantity'];
								// phpcs:ignore WordPress.Security.EscapeOutput
								echo wp_kses_post( apply_filters( 'addify_rfq_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf( '&nbsp;%s', $qty_display ) . '</strong>', $quote_item ) );
								?>
							</td>

							<?php if ( $price_display ) : ?>
								<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>">
									<?php echo wp_kses_post( wc_price( $price * $qty_display ) ); ?>
								</td>
							<?php endif; ?>
							<?php if ( $of_price_display ) : ?>	
								<td class="product-subtotal" data-title="<?php esc_attr_e( 'Offered Subtotal', 'addify_rfq' ); ?>">
									<?php echo wp_kses_post( wc_price( $offered_Price * $qty_display ) ); ?>
								</td>
							<?php endif; ?>
						</tr>
						<?php
					}
				}
				?>
				</tbody>
			</table>

		<?php }
	} else {
		if ( 'yes' === $has_discount_rules || ! empty( $quote_pricing_groups ) ) {

			ob_start();

			wc_get_template(
				'quote/quote-discount-table-profile.php',
				array(
					'quote_post_id' => $afrfq_id,
				),
				'/woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);

			$quote_table = ob_get_clean();
			echo $quote_table;

		} else {

			ob_start();

			wc_get_template(
				'quote/quote-table-profile.php',
				array(
					'price_base_type'   => $price_base_type,
					'price_base_notice' => $price_base_notice,
					'quote_contents'    => $quote_contents,
					'quote_post_id'     => $afrfq_id,
				),
				'/woocommerce/addify/rfq/',
				AFRFQ_PLUGIN_DIR . 'templates/'
			);

			$quote_table = ob_get_clean();
			echo $quote_table;
		}
	} ?>
	<?php do_action( 'addify_after_quote_contents' ); ?>

	<?php do_action( 'addify_after_quote_table' ); ?>


	<?php do_action( 'addify_before_quote_collaterals' ); ?>
	
	<?php if ( $has_discount_rules === "no" || empty( $quote_pricing_groups ) ) { ?>
	<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked addify_cross_sell_display
		 * @hooked addify_quote_totals - 10
		 */
		do_action( 'addify_quote_collaterals' );
	?>
	<?php if ( $price_display || $of_price_display ) : ?>
		<div class="cart_totals">

			<?php do_action( 'woocommerce_before_cart_totals' ); ?>

			<h2><?php esc_html_e( 'Quote totals', 'addify_rfq' ); ?></h2>

			<table cellspacing="0" class="shop_table shop_table_responsive">
				<?php if ( $price_display ) : ?>
					<tr class="cart-subtotal">
						<th><?php esc_html_e( 'Subtotal (Standard)', 'addify_rfq' ); ?></th>
						<td data-title="<?php esc_attr_e( 'Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_subtotal'] ) ); ?></td>
					</tr>
					<?php
				endif;

				if ( isset( $quote_totals['_offered_total'] ) && $of_price_display ) {
					?>
					<tr class="cart-subtotal cart-requested-subtotal">
						<th><?php esc_html_e( 'Requested Price Subtotal', 'addify_rfq' ); ?></th>
						<td data-title="<?php esc_attr_e( 'Offered Price Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_offered_total'] ) ); ?></td>
					</tr>
					<?php if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) { ?>
						<tr class="cart-subtotal">
							<th><?php esc_html_e( 'Approved Price Subtotal', 'addify_rfq' ); ?></th>
							<td data-title="<?php esc_attr_e( 'Approved Price Subtotal', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_approved_total'] ) ); ?></td>
						</tr>
					<?php }
				}

				if ( wc_tax_enabled() && $tax_display ) {
					?>
					<tr class="tax-rate">
						<th><?php echo esc_html__( 'Vat (Standard)', 'addify_rfq' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?php echo esc_html__( 'Vat', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_tax_total'] ) ); ?></td>
					</tr>
					<?php
				}
				?>

				<?php if ( $quote_totals['_shipping_total'] ) : ?>
					<tr class="shipping-cost">
						<th><?php echo esc_html__( 'Shipping Cost', 'addify_rfq' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?php echo esc_html__( 'Shipping', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_shipping_total'] ) ); ?></td>
					</tr>
				<?php endif; ?>
				
				<?php if ( $price_display ) : ?>
					<tr class="order-total">
						<th><?php esc_html_e( 'Total (Standard)', 'addify_rfq' ); ?></th>
						<td data-title="<?php esc_attr_e( 'Total', 'addify_rfq' ); ?>"><?php echo wp_kses_post( wc_price( $quote_totals['_total'] ) ); ?></td>
					</tr>
				<?php endif; ?>
			</table>				
		</div>
	<?php endif; ?>
	<?php
	$afrfq_enable = 'yes' === get_option( 'afrfq_enable_convert_order' ) ? true : false;
	$disable_convert_order_button = false;
		if ($quote_type_id) {
			if ('yes' === get_post_meta($quote_type_id, 'quote_type_disable_convert_order', true)) {
			$disable_convert_order_button = true;
			}
		}
	$afrfq_enable = apply_filters( 'enable_convert_to_order_in_users_profile', $afrfq_enable );
	$af_fields_obj = new AF_R_F_Q_Quote_Fields();
	$fields = (array) $af_fields_obj->afrfq_get_fields_enabled();
	$exp_date = '';
	foreach ($fields as $key => $field ) {
		$field_id = $field->ID;
		$field_label = get_post_meta( $field_id, 'afrfq_field_label', true );
		if ( $field_label === 'Expiration Date' ) {
			$exp_date_field_name = get_post_meta( $field->ID, 'afrfq_field_name', true );
			if ( ! empty( $exp_date_field_name ) ) {
				$exp_date = get_post_meta( $afrfq_id, $exp_date_field_name, true );
			}
		}
	}

		if ( ( in_array( $quote_status, array( 'af_accepted', 'af_in_process' ), true ) || ( in_array( $quote_status, array( 'af_converted' ), true ) && ( empty( $exp_date ) || strcmp( date( 'Y-m-d' ), $exp_date ) <= 0  ) ) ) && $afrfq_enable && ! $disable_convert_order_button ) :
			?>
			<form method="post">
                <?php wp_referer_field(); ?>
				<div class="addify_converty_to_order_button">
					<button type="submit" value="<?php echo intval( $afrfq_id ); ?>" name="addify_convert_to_order_customer" class="button button-primary button-large" >
						<?php echo esc_html__( 'Convert to Order', 'addify_rfq' ); ?>
					</button>
				</div>
			</form>
		<?php endif; ?>
	</div>
	<?php } ?>
</section>
