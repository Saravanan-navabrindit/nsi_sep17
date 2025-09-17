<?php

defined( 'ABSPATH' ) || exit;

do_action( 'addify_rfq_before_email_quote_contents' );
$price_base_notice = $price_base_type === 'moq' ? 'Per Minimum Quantity' : 'Per Industry Standard';
if ( $quote_type_discount_rules === "yes" && ! empty( $saved_groups )) :
    ?>
	   <!-- === Discount Type Table === -->
    <div style="margin-top: 10px; margin-bottom: 10px;">
        <table class="quote-contents" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif" cellspacing="0" cellpadding="6" border="1">
            <thead>
                <tr>
                    <th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;text-align:left"><?php esc_html_e( 'Product Pricing Group', 'woocommerce-request-a-quote' ); ?></th>
                    <th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;text-align:left"><?php esc_html_e( 'Discount Level', 'woocommerce-request-a-quote' ); ?></th>
                </tr>
            </thead>
            <tbody>
               
                    <?php foreach ( $saved_groups as $group ) : ?>
                        <tr>
                            <td style="font-size:12px;line-height:14px;color:#636363;border:1px solid #e5e5e5;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word"><?php echo esc_html( $group['group_name'] ); ?></td>
                            <td style="font-size:12px;line-height:14px;color:#636363;border:1px solid #e5e5e5;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word"><?php echo esc_html( $group['price_name'] ); ?></td>
                        </tr>
                    <?php endforeach; ?>
            
            </tbody>
        </table>
    </div>
	
<?php else : ?>
<div style="margin-top: 10px; margin-bottom: 10px;">
	<table class="quote-contents" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif" cellspacing="0" cellpadding="6" border="1">
		<thead>
			<tr>
				<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;text-align:left">
					<?php echo esc_html__( 'Product', 'addify_rfq' ); ?>
				</th>
				<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;text-align:left">
					<?php echo esc_html__( 'Quantity', 'addify_rfq' ); ?>
				</th>
				<?php if ( $price_display ) : ?>
					<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;text-align:left">
						<?php echo esc_html__( 'Price', 'addify_rfq' ); ?>
                        <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
					</th>
				<?php endif; ?>
				<?php if ( $of_price_display ) : ?>
					<th scope="col" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;text-align:left">
						<?php if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) { ?>
							<?php echo esc_html__( 'Approved Price', 'addify_rfq' ); ?>
                            <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
						<?php } else { ?>
							<?php echo esc_html__( 'Requested Price', 'addify_rfq' ); ?>
                            <small style="display: block; opacity: .6; line-height: 1;"><?php esc_html_e( $price_base_notice, 'addify_rfq' ); ?></small>
						<?php } ?>
					</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ( (array) $quote_contents as $key => $item ) :

				$product = isset( $item['data'] ) ? $item['data'] : '';

				if ( ! is_object( $product ) ) {
					continue;
				}
                if ($price_base_type === 'moq') {
                    $price_qty_multiplier = intval( get_post_meta( $product->get_id(), 'min_quantity', true ) );
                    $price_qty_multiplier = $price_qty_multiplier < 1 ? 1 : $price_qty_multiplier;
                } else {
                    $price_qty_multiplier = get_post_meta( $product->get_id(), 'ns_price_qty_multiplier', true );
                    $price_qty_multiplier = floatval( $price_qty_multiplier ) > 0 ? floatval( $price_qty_multiplier ) : 1;
                }
				$price         = empty( $item['addons_price'] ) ? $product->get_price() : $item['addons_price'];
				$price         = empty( $item['role_base_price'] ) ? $price : $item['role_base_price'];
                $price         = $price * $price_qty_multiplier;
				$offered_price = isset( $item['offered_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['offered_price'] ) ) : $price;
				$approved_price = isset( $item['approved_price'] ) ? floatval( str_replace( wc_get_price_thousand_separator(), '', $item['approved_price'] ) ) : $price;

				?>
				<tr>
					<td style="font-size:12px;line-height:14px;color:#636363;border:1px solid #e5e5e5;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word">
						<div style="font-size:14px;line-height:16px;padding-bottom: 4px;">
							<b>SKU:</b> <?php echo esc_html( $product->get_sku() ); ?>
						</div>
						<?php 
						echo esc_html( $product->get_name() ); 
						echo wp_kses_post( wc_get_formatted_cart_item_data( $item ) ); 
						?>
					</td>

					<td style="color:#636363;border:1px solid #e5e5e5;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
					<?php echo esc_attr( $item['quantity'] ); ?>
					</td>

					<?php if ( $price_display ) : ?>
						<td style="color:#636363;border:1px solid #e5e5e5;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
						<?php
                        echo wp_kses_post( wc_price( $price ) );
                        echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
                        ?>

						</td>
					<?php endif; ?>

					<?php if ( $of_price_display ) : ?>
						<td style="color:#636363;border:1px solid #e5e5e5;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
							<?php if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) { ?>
								<?php
                                echo wp_kses_post( wc_price( $approved_price ) );
                                echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
                                ?>
							<?php } else { ?>
								<?php
                                echo wp_kses_post( wc_price( $offered_price ) );
                                echo '<small style="position: relative; display: block; opacity: .6; line-height: 1;">' . ( $price_qty_multiplier <= 1 ? 'Each' : 'per ' . $price_qty_multiplier ) . '</small>';
                                ?>
							<?php } ?>
						</td>
					<?php endif; ?>
				</tr>
				<?php endforeach; ?>
		</tbody>
		<tfoot>

			<?php if ( $price_display ) : ?>
			<tr>
				<th scope="row" colspan="<?php echo intval( $colspan ); ?>" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
					<?php echo esc_html__( 'Total (Standard)', 'addify_rfq' ); ?>:</th>
				<td style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
					<?php echo wp_kses_post( wc_price( $quote_total ) ); ?>
				</td>
			</tr>
			<?php endif; ?>

			<?php if ( $of_price_display ) : ?>
				<?php if ( in_array( $quote_status, array( 'af_accepted', 'af_in_process', 'af_converted' ), true ) ) { ?>
					<tr>
						<th scope="row" colspan="<?php echo intval( $colspan ); ?>" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
							<?php echo esc_html__( 'Total (Approved)', 'addify_rfq' ); ?>:</th>
						<td style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
							<?php echo wp_kses_post( wc_price( $approved_total ) ); ?>
						</td>
					</tr>
				<?php } else { ?>
					<tr>
						<th scope="row" colspan="<?php echo intval( $colspan ); ?>" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
							<?php echo esc_html__( 'Total (Requested)', 'addify_rfq' ); ?>:</th>
						<td style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
							<?php echo wp_kses_post( wc_price( $offered_total ) ); ?>
						</td>
					</tr>
				<?php } ?>
			<?php endif; ?>

			<?php if ( wc_tax_enabled() && $tax_display ) : ?>
				<tr>
					<th scope="row" colspan="<?php echo intval( $colspan ); ?>" style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
						<?php echo esc_html__( 'Vat (Standard)', 'addify_rfq' ); ?>:</th>
					<td style="color:#636363;border:1px solid #e5e5e5;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">
						<?php echo wp_kses_post( wc_price( $vat_total ) ); ?>
					</td>
				</tr>
			<?php endif; ?>
		</tfoot>
	</table>
</div>
<?php endif; ?>
