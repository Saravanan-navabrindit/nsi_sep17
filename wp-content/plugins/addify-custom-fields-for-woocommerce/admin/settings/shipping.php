<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$fields = wc()->checkout()->get_checkout_fields( 'shipping' );

global $wp_roles;
$roles          = $wp_roles->get_names();
$roles['guest'] = __( 'Guest', 'af_custom_fields');

$billing_fields = get_option( 'af_checkout_shipping_fields' );

?>
<h3><?php esc_html_e('Shipping fields by user roles', 'af_custom_fields'); ?></h3>
<div id="message" class="notice notice-info">
	<p class="description"><?php esc_html_e('Street address, Town / City, State / County, Postcode / ZIP are not sortable', 'af_custom_fields' ); ?></p>
</div>
<div class="af_cf_accordion">
	<?php
	foreach ( $roles as $role_key => $role_name ) { 

		$selected_fields = isset( $billing_fields[ $role_key ] ) ? $billing_fields[ $role_key ] : array_keys( $fields );

		?>
		<h3><span class="dashicons dashicons-arrow-down"></span><?php echo esc_html( $role_name ); ?></h3>
		<div class="af_ac_role_container" data-role_key="<?php echo esc_html( $role_key ); ?>">
			<table class="draggable">
				<tr class="heading" >
					<th colspan="2">
						<?php echo esc_html__('All Shipping Fields', 'af_custom_fields'); ?>
					</th>
				</tr>
				<?php 
				foreach ( $fields as $field_key => $field ) {
					$field_label = $field['label'];
					?>
					<tr class="<?php echo esc_attr( $field_key ); ?>" data-field_key="<?php echo esc_attr( $field_key ); ?>">
						<td class="checkbox_col">
							<?php if ( in_array( $field_key, $selected_fields ) ) { ?>

								<span title="<?php echo esc_html__('Selected', 'af_custom_fields'); ?>" class="dashicons dashicons-yes"></span>
							<?php } else { ?>

								<span title="<?php echo esc_html__('Click to select', 'af_custom_fields'); ?>" class="dashicons dashicons-plus-alt"></span>
							<?php } ?>
						</td>
						<td class="field_name">
							<p class="field_name"><?php echo esc_attr( $field_label ); ?></p>
						</td>
					</tr>
				<?php } ?>
			</table>
			<table class="droppable">
				<tr class="heading">
					<th colspan="3">
						<?php echo esc_html__('Selected Fields ( Drag to sort )', 'af_custom_fields'); ?>
					</th>
				</tr>
				<?php

				foreach ( $selected_fields as $field_key ) {

					$field_label = isset( $fields[ $field_key ]['label'] ) ? $fields[ $field_key ]['label'] : '';
					?>
					<tr class="<?php echo esc_attr( $field_key ); ?>" data-field_key="<?php echo esc_attr( $field_key ); ?>">
						<td class="checkbox_col">
							<span title="<?php echo esc_html__('Drag to sort', 'af_custom_fields'); ?>" class="dashicons dashicons-sort"></span>
						</td>
						<td class="field_name">
							<input type="hidden" class="hidden_field" value="<?php echo esc_html( $field_key ); ?>" name="af_checkout_shipping_fields[<?php echo esc_html( $role_key ); ?>][]">
							<p class="field_name"><?php echo esc_attr( $field_label ); ?></p>
						</td>
						<td class="remove">
							<span title="<?php echo esc_html__('Click to Remove', 'af_custom_fields'); ?>" class="dashicons dashicons-remove"></span>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>
		<?php
	}
	?>
</div>
