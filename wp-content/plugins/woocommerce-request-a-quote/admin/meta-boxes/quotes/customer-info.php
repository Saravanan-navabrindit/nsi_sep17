<?php
/**
 * Addify Add to Quote
 *
 * The WooCommerce quote class stores quote data and maintain session of quotes.
 * The quote class also has a price calculation function which calls upon other classes to calculate totals.
 *
 * @package addify-request-a-quote
 * @version 1.6.0
 */

defined( 'ABSPATH' ) || exit;
global $post;
global $addify_rfq;

if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
	$afrfq_field_quote_types = (array) get_post_meta( $field_id, 'afrfq_field_quote_types', true );
	$all_quote_types             = $addify_rfq->quote_types_obj->afrfq_get_all_quote_types();
	$quote_types = sort_quote_types_with_job_request_first( $all_quote_types );
	$results                 = $quote_types;
}

$options = array();
foreach ( $results as $row ) {
	$options[ $row->ID ] = $row->post_title;
}
$user_id = get_post_meta( $post->ID, '_customer_user', true );

$user_name = 'Guest';
$id_user   = 'guest';

$user                 = get_user_by( 'id', intval( $user_id ) );
$minimum_order_amount = '';
if ( ! empty( $user_id ) && is_object( $user ) ) {

	$id_user                     = $user_id;
	$user_name                   = $user->display_name . '(' . $user->user_email . ')';
	$ns_customer_id              = get_user_meta( $user_id, 'ns_customer_internal_id', true ) ?? '';
	$ns_bridgeport_customer_id   = get_user_meta( $user_id, 'ns_bridgeport_customer_id', true ) ?? '';
	$minimum_order_amount        = get_user_meta( $user_id, 'min_order', true );
}

$are_quote_fields_readonly = apply_filters( 'are_quote_fields_readonly', false );
?>
<div class="afacr-metabox-fields">
	<table class="addify-table-optoin">

		<?php if ( ! empty( $post->ID ) ) : ?>
			<tr class="addify-option-field">
				<th>
					<div class="option-head">
						<h3>
							<?php echo esc_html__( 'Quote #:', 'addify_rfq' ); ?>
						</h3>
					</div>
				</th>
				<td>
					<p><?php echo esc_attr( $post->ID ); ?></p>
				</td>
			</tr>

			<tr class="addify-option-field">
				<th>
					<div class="option-head">
						<h3>
							<?php echo esc_html__( 'Quote Type :', 'addify_rfq' ); ?>
						</h3>
					</div>
				</th>
				<td>
					<?php
						$quote_type_value = get_post_meta( $post->ID, 'quote_type', true );
						$disabled         = ! empty( $quote_type_value ) ? 'disabled' : '';
					?>
					<?php if ( 'disabled' === $disabled ) : ?>
						<?php $quote_type_name = $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) ? $addify_rfq->quote_types_obj->afrfq_get_quote_type_name( $quote_type_value ) : '---'; ?>
						<p><?php echo esc_html( $quote_type_name ); ?></p>
						<input type="hidden" name="quote_type" value="<?php echo esc_attr( $quote_type_value ); ?>" />
					<?php else : ?>
					<select name="quote_type" required id="quote_type_select">
						<option value="">-- Select Quote Type --</option>
						<?php foreach ( $options as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $quote_type_value, $value ); ?>>
								<?php echo esc_html( $label ); ?>
							</option>
						<?php endforeach; ?>
					</select>
					<?php endif; ?>
				</td>
			</tr>
			<tr class="addify-option-field">
				<th>
					<div class="option-head">
						<h3>
							<?php echo esc_html__( 'Quote user:', 'addify_rfq' ); ?>
						</h3>
					</div>
				</th>
				<td>
					<select name="_customer_user" class="users ajax_customer_search"<?php echo $are_quote_fields_readonly ? ' disabled' : ''; ?>>
						<option value="<?php echo esc_html( $id_user ); ?>"><?php echo esc_html( $user_name ); ?></option>
					</select>
				</td>
			</tr>
		<?php endif; ?>

		<?php if ( ! empty( $ns_customer_id ) ) : ?>
			<tr class="addify-option-field">
				<th>
					<div class="option-head">
						<h3>
							<?php echo esc_html__( 'Netsuite Customer ID:', 'addify_rfq' ); ?>
						</h3>
					</div>
				</th>
				<td>
					<p><?php echo esc_attr( $ns_customer_id ); ?></p>
				</td>
			</tr>
		<?php endif; ?>

		<?php if ( ! empty( $ns_bridgeport_customer_id ) ) : ?>
			<tr class="addify-option-field">
				<th>
					<div class="option-head">
						<h3>
							<?php echo esc_html__( 'Bridgeport Customer ID:', 'addify_rfq' ); ?>
						</h3>
					</div>
				</th>
				<td>
					<p><?php echo esc_attr( $ns_bridgeport_customer_id ); ?></p>
				</td>
			</tr>
		<?php endif; ?>

		<?php
		foreach ( $quote_fields as $key => $field ) :
			$field_id = $field->ID;

			$afrfq_field_name        = get_post_meta( $field_id, 'afrfq_field_name', true );
			$afrfq_field_type        = get_post_meta( $field_id, 'afrfq_field_type', true );
			$afrfq_field_label       = get_post_meta( $field_id, 'afrfq_field_label', true );
			$afrfq_field_value       = get_post_meta( $field_id, 'afrfq_field_value', true );
			$afrfq_field_title       = get_post_meta( $field_id, 'afrfq_field_title', true );
			$afrfq_field_placeholder = get_post_meta( $field_id, 'afrfq_field_placeholder', true );
			$afrfq_field_options     = (array) get_post_meta( $field_id, 'afrfq_field_options', true );
			$afrfq_file_types        = get_post_meta( $field_id, 'afrfq_file_types', true );
			$afrfq_file_size         = get_post_meta( $field_id, 'afrfq_file_size', true );
			$afrfq_field_enable      = get_post_meta( $field_id, 'afrfq_field_enable', true );
			$afrfq_field_required    = get_post_meta( $field_id, 'afrfq_field_required', true );
			$afrfq_field_quote_types = (array) get_post_meta( $field_id, 'afrfq_field_quote_types', true );
			$field_data              = get_post_meta( $post->ID, $afrfq_field_name, true );

			if ( empty( $field_data ) && ! empty( $afrfq_field_value ) ) {
				$field_data = $quote_fields_obj->get_field_default_value( $field_id, $user_id );
			}

			$display_field = empty( $quote_type_value ) || empty( $afrfq_field_quote_types ) || in_array( intval( $quote_type_value ), array_map( 'intval', $afrfq_field_quote_types ), true );

			$required_attr  = ( 'yes' === $afrfq_field_required ) ? ' required="required"' : '';
			$required_label = ( 'yes' === $afrfq_field_required ) ? ' <span style="color:red;">*</span>' : '';

			if ( $display_field ) :
				?>
			<tr class="addify-option-field" id="field_<?php echo esc_attr( $field_id ); ?>">
				<th>
					<div class="option-head">
						<h3>
							<?php
							if ( 'Customer Shipping Account Number' === $afrfq_field_label ) {
								echo esc_html( $afrfq_field_label ) . ' (optional)';
							} else {
								echo esc_html( $afrfq_field_label ) . $required_label;
							}
							?>
						</h3>
					</div>
				</th>
				<td>
					<?php
					switch ( $afrfq_field_type ) {
						case 'terms_cond':
							echo esc_html( ucfirst( $field_data ) );
							break;
						case 'text':
							?>
									<input type="text" placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $field_data ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
							break;
						case 'time':
							?>
									<input type="time" placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $field_data ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
							break;
						case 'date':
							?>
									<input type="date" placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $field_data ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
							break;
						case 'datetime':
							?>
									<input type="datetime-local" placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $field_data ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
							break;
						case 'email':
							?>
									<input type="email" placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $field_data ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
							break;
						case 'number':
							?>
									<input type="number" placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $field_data ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
							break;
						case 'file':
							if ( ! empty( $field_data ) && file_exists( AFRFQ_PLUGIN_DIR . '/uploads/' . $field_data ) ) {
								?>
									<iframe allowfullscreen="true" src="<?php echo esc_url( AFRFQ_URL . '/uploads/' . $field_data ); ?>"></iframe>
								<?php
							} else {
								?>
									<p><?php echo esc_html__( 'No file was uploaded by user.', 'addify_rfq' ); ?></p>
								<?php
							}
							break;
						case 'textarea':
							?>
									<textarea name="<?php echo esc_html( $afrfq_field_name ); ?>"<?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?>><?php echo esc_html( $field_data ); ?></textarea>
								<?php
							break;
						case 'select':
							if ( 'afrfq_field_shipping_options' === $afrfq_field_name ) {
								$shipping_methods = crown_get_zone_shipping_methods( 0 );
								$quote_contents   = get_post_meta( $post->ID, 'quote_contents', true );
								$quote_object_tmp = new AF_R_F_Q_Quote();
								$quote_totals     = $quote_object_tmp->get_calculated_totals( $quote_contents, $post->ID );

								if ( ! isset( $quote_totals['_approved_total'] ) || $quote_totals['_approved_total'] <= $minimum_order_amount ) {
									foreach ( $shipping_methods as $id => $method ) {
										if ( 6173 === $method['title'] && 'Free Standard Shipping' === $method['label'] ) {
											unset( $shipping_methods[ $id ] );
										}
									}
								}

								?>
								<select name="<?php echo esc_html( $afrfq_field_name ); ?>"<?php echo $are_quote_fields_readonly ? ' disabled' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
								foreach ( $shipping_methods as $method_id => $method ) {
									?>
										<option value="<?php echo esc_html( $method_id ); ?>" <?php echo selected( $method_id, $field_data ); ?> ><?php echo esc_html( $method['label'] ); ?></option>
									<?php } ?>
								</select>
								<?php
							} else {
								?>
								<select name="<?php echo esc_html( $afrfq_field_name ); ?>"<?php echo $are_quote_fields_readonly ? ' disabled' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
								<?php
								foreach ( (array) $afrfq_field_options as $option ) :
									$value = strtolower( trim( $option ) );
									?>
										<option value="<?php echo esc_html( $value ); ?>" <?php echo selected( $value, $field_data ); ?> ><?php echo esc_html( $option ); ?></option>
									<?php endforeach; ?>
								</select>
								<?php
							}
							break;
						case 'multiselect':
							?>
									<select placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" class="multi-select" name="<?php echo esc_html( $afrfq_field_name ); ?>[]" multiple<?php echo $are_quote_fields_readonly ? ' disabled' : ''; ?><?php echo esc_attr( $required_attr ); ?>>
									<?php
									foreach ( (array) $afrfq_field_options as $option ) :
										$value = strtolower( trim( $option ) );
										?>
											<option value="<?php echo esc_html( $value ); ?>" <?php echo in_array( $value, (array) $field_data, true ) ? 'selected' : ''; ?> > <?php echo esc_html( $option ); ?>
											</option>
										<?php endforeach; ?>
									</select>
								<?php
							break;
						case 'radio':
							foreach ( (array) $afrfq_field_options as $option ) :
								$value = strtolower( trim( $option ) );
								?>
									<input placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" type="radio" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="<?php echo esc_html( $value ); ?>" <?php echo checked( $value, $field_data ); ?><?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?> ><?php echo esc_html( $option ); ?>
									<br>
								<?php
								endforeach;
							break;
						case 'checkbox':
							?>
									<input placeholder="<?php echo esc_html( $afrfq_field_placeholder ); ?>" type="checkbox" name="<?php echo esc_html( $afrfq_field_name ); ?>" value="yes" <?php echo checked( 'yes', $field_data ); ?><?php echo $are_quote_fields_readonly ? ' readonly' : ''; ?><?php echo esc_attr( $required_attr ); ?> >
								<?php
							break;
					}
					?>
				</td>
			</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
</div>

<script>
	jQuery(document).ready(function($) {

		const fieldsWithQuoteTypes = <?php
		echo wp_json_encode(
			array_map(
				function( $field ) {
					return array(
						'id' => $field->ID,
						'quote_types' => (array) get_post_meta( $field->ID, 'afrfq_field_quote_types', true ),
					);
				},
				$quote_fields
			)
		);
		?>;

		function updateRequiredFields() {
			$('tr.addify-option-field[id^="field_"]').each(function() {
				const isVisible = $(this).is(':visible');
				const inputElements = $(this).find('input, select, textarea');

				inputElements.each(function() {
					if (isVisible) {
						if ($(this).data('was-required')) {
							$(this).attr('required', 'required');
							$(this).removeData('was-required');
						}
					} else {
						if ($(this).attr('required')) {
							$(this).data('was-required', true);
							$(this).removeAttr('required');
						}
					}
				});
			});
		}

		function handleQuoteTypeChange() {
			const selectedQuoteType = $('#quote_type_select').val();

			if (!selectedQuoteType) {
				$('tr.addify-option-field[id^="field_"]').each(function() {
					const fieldId = $(this).attr('id').replace('field_', '');
					const fieldData = fieldsWithQuoteTypes.find(f => f.id == fieldId);
					if (fieldData && fieldData.quote_types && fieldData.quote_types.length > 0) {
						$(this).hide();
					} else {
						$(this).show();
					}
				});
			} else {
				$('tr.addify-option-field[id^="field_"]').each(function() {
					const fieldId = $(this).attr('id').replace('field_', '');
					const fieldData = fieldsWithQuoteTypes.find(f => f.id == fieldId);

					if (fieldData && fieldData.quote_types && fieldData.quote_types.length > 0) {
						const isAllowed = fieldData.quote_types.includes(selectedQuoteType);
						if (isAllowed) {
							$(this).show();
						} else {
							$(this).hide();
						}
					} else {
						$(this).show();
					}
				});
			}

			updateRequiredFields();
		}

		$('#quote_type_select').on('change', handleQuoteTypeChange);

		setTimeout(function() {
			if ($('#quote_type_select').length) {
				handleQuoteTypeChange();
			}
		}, 50);
	});
</script>