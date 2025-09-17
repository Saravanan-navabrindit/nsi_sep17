<?php
/**
 * Renders the table rows for the editable pricing group table on the My Account page.
 *
 * @package addify-request-a-quote
 * @version 1.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! empty( $pricing_groups ) && is_array( $pricing_groups ) ) :
	foreach ( $pricing_groups as $group_id => $group_data ) :
        if ( ! is_array( $group_data ) || ! isset( $group_data['group_name'] ) ) {
            continue;
        }
		?>
		<tr class="woocommerce-cart-form__quote-item cart_item" data-group_id_row="<?php echo esc_attr( $group_id ); ?>">
			<td class="product-remove">
				<a href="#" class="remove delete-pricing-quote-item-profile" aria-label="<?php esc_attr_e( 'Remove this item', 'addify_rfq' ); ?>" data-group_id="<?php echo esc_attr( $group_id ); ?>">&times;</a>
			</td>
			<td class="product-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
				<?php echo esc_html( $group_data['group_name'] ); ?>
			</td>
			<td class="product-price" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
				<?php echo esc_html( $group_data['price_name'] ); ?>
			</td>
			
			<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id ); ?>][group_name]" value="<?php echo esc_attr( $group_data['group_name'] ); ?>">
			<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id ); ?>][price_name]" value="<?php echo esc_attr( $group_data['price_name'] ); ?>">
            <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id ); ?>][group_id]" value="<?php echo esc_attr( $group_id ); ?>">
            <?php
            if (isset($group_data['ns_group_id'])) : ?>
                <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id ); ?>][ns_group_id]" value="<?php echo esc_attr( $group_data['ns_group_id'] ); ?>">
            <?php endif; ?>
		</tr>
		<?php
	endforeach;
endif;