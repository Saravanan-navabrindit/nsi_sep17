<?php

defined( 'ABSPATH' ) || exit;

?>
<table cellpadding="0" cellspacing="0" class="woocommerce_order_items addify-checkout-fields">

	<?php foreach ( $checkout_data as $label => $value ) { ?>
		<tr>
			<th>
				<?php echo esc_html( $label ); ?>
			</th>
			<td>
				<?php echo empty( $value ) ? '-----' : wp_kses_post( $value ); ?>
			</td>
		</tr>
	<?php } ?>
</table>
