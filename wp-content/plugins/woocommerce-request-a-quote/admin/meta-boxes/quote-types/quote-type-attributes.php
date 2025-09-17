<?php
global $post;

$quote_type_is_enabled = get_post_meta($post->ID, 'quote_type_is_enabled', true);
$quote_type_disable_convert_order = get_post_meta($post->ID, 'quote_type_disable_convert_order', true);
$quote_type_discount_rules = get_post_meta($post->ID, 'quote_type_discount_rules', true);
$quote_type_min_value_restrictions = get_post_meta($post->ID, 'quote_type_min_value_restrictions', true);
$quote_type_min_value_number = get_post_meta($post->ID, 'quote_type_min_value_number', true);
$quote_type_bridgeport_brand = get_post_meta($post->ID, 'quote_type_bridgeport_brand', true);
$default_quote_expiry_date = get_post_meta($post->ID, 'default_quote_expiry_date', true);

$quote_type_is_enabled = ($quote_type_is_enabled === 'yes') ? 'yes' : 'no';
$quote_type_disable_convert_order = ($quote_type_disable_convert_order === 'yes') ? 'yes' : 'no';
$quote_type_discount_rules = ($quote_type_discount_rules === 'yes') ? 'yes' : 'no';
$quote_type_min_value_restrictions = ($quote_type_min_value_restrictions === 'yes') ? 'yes' : 'no';
$quote_type_bridgeport_brand = ($quote_type_bridgeport_brand === 'yes') ? 'yes' : 'no';
$default_quote_expiry_date = ($default_quote_expiry_date === 'yes') ? 'yes' : 'no';
?>

<div class="afrfq-metabox-fields">
	<table class="addify-table-optoin">
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable this Quote Type', 'addify_rfq' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<input type="checkbox" name="quote_type_is_enabled" value="yes" <?php checked( $quote_type_is_enabled, 'yes' ); ?>>
				<p class="description"><?php esc_html_e('Check this box to enable this quote type.', 'addify_rfq'); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Disable "Convert to Order" Button', 'addify_rfq' ); ?>
					</h3>
				</div>
			</th>
			<td>
                <input type="checkbox" name="quote_type_disable_convert_order" value="yes" <?php checked( $quote_type_disable_convert_order, 'yes' ); ?>>
				<p class="description"><?php esc_html_e('Check this box to disable the "Convert to Order" button for quotes of this type.', 'addify_rfq'); ?></p>
			</td>
		</tr>
        <tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Apply Discount Rules', 'addify_rfq' ); ?>
					</h3>
				</div>
			</th>
			<td>
                <input type="checkbox" name="quote_type_discount_rules" value="yes" <?php checked( $quote_type_discount_rules, 'yes' ); ?>>
				<p class="description"><?php esc_html_e('Check this box to apply discount rules to quotes of this type.', 'addify_rfq'); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Enable Min. Value Restriction', 'addify_rfq' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<?php
				$quote_type_min_value_number = get_post_meta($post->ID, 'quote_type_min_value_number', true);
				?>
				<input type="checkbox" id="quote_type_min_value_restrictions" name="quote_type_min_value_restrictions" value="yes" <?php checked( $quote_type_min_value_restrictions, 'yes' ); ?>>
				
				<p class="description">
					<?php esc_html_e('Check this box to apply min. value restriction rules to quotes of this type.', 'addify_rfq'); ?>
				</p>

				<div id="min_value_input_wrap" style="<?php echo ($quote_type_min_value_restrictions === 'yes') ? '' : 'display:none;'; ?>">
					<input type="number" name="quote_type_min_value_number" value="<?php echo esc_attr($quote_type_min_value_number); ?>" min="0" step="0.01" style="width:120px;">
					<p class="description"><?php esc_html_e('Enter the minimum value in dollars($) required for this quote type.', 'addify_rfq'); ?></p>
				</div>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Bridgeport Brand Only', 'addify_rfq' ); ?>
					</h3>
				</div>
			</th>
			<td>
				<input type="checkbox" name="quote_type_bridgeport_brand" value="yes" <?php checked( $quote_type_bridgeport_brand, 'yes' ); ?>>
				<p class="description"><?php esc_html_e('Check this box if this Quote Type should be available only to Bridgeport brand users.', 'addify_rfq'); ?></p>
			</td>
		</tr>
		<tr class="addify-option-field">
			<th>
				<div class="option-head">
					<h3>
						<?php echo esc_html__( 'Default Quote Expiry Date', 'addify_rfq' ); ?>
					</h3>
				</div>
			</th>
			<td>
                <input type="checkbox" name="default_quote_expiry_date" value="yes" <?php checked( $default_quote_expiry_date, 'yes' ); ?>>
				<p class="description"><?php esc_html_e('Check this box to set the quote expiration date as 31st Dec.', 'addify_rfq'); ?></p>
			</td>
		</tr>
	</table>
</div>

<?php wp_nonce_field( 'afrfq_quote_type_nonce', 'afrfq_quote_type_nonce_field' ); ?>


<script>
document.addEventListener('DOMContentLoaded', function () {
	const checkbox = document.getElementById('quote_type_min_value_restrictions');
	const inputWrap = document.getElementById('min_value_input_wrap');

	checkbox.addEventListener('change', function () {
		if (this.checked) {
			inputWrap.style.display = '';
		} else {
			inputWrap.style.display = 'none';
		}
	});
});
</script>
