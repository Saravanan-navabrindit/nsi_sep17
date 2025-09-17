<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! isset( $af_c_f_main_class ) ) {
	$af_c_f_main_class = '';
}

if ('text' == $af_c_f_field_type || 'vat' == $af_c_f_field_type ) { 
	?>
	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<input  <?php echo esc_attr( $custom_attributes ); ?> type="text" class="regular-text" value="<?php echo esc_attr($value); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" name="af_c_f_additional_<?php echo intval($field_id); ?>">
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>
<?php } elseif ( 'textarea' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  > 
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<textarea  <?php echo esc_attr( $custom_attributes ); ?> class="input-text " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>"><?php echo esc_attr($value); ?></textarea>
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'email' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<input  <?php echo esc_attr( $custom_attributes ); ?> type="email" class="regular-text" value="<?php echo esc_attr($value); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" name="af_c_f_additional_<?php echo intval($field_id); ?>">
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'select' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			
			<select  <?php echo esc_attr( $custom_attributes ); ?> class="input-select " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				$af_c_f_field_options = is_serialized( $af_c_f_field_options ) ? unserialize( $af_c_f_field_options ) :  $af_c_f_field_options ; 
				if ( ! empty( $af_c_f_field_options ) ) :
			
					foreach ( $af_c_f_field_options as $af_c_f_field_option) { 
						?>
						<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" <?php echo selected(esc_attr($value), esc_attr($af_c_f_field_option['field_value'])); ?>>
							<?php 
							if (!empty($af_c_f_field_option['field_text'])) {
								echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');} 
							?>
						</option>
						<?php 
					}
				endif;
				?>
			</select>
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'multiselect' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<select  <?php echo esc_attr( $custom_attributes ); ?> class="input-select " name="af_c_f_additional_<?php echo intval($field_id); ?>[]" id="af_c_f_additional_<?php echo intval($field_id); ?>" multiple>
				<?php 

				if ( ! empty( $af_c_f_field_options ) ) :
					foreach ($af_c_f_field_options as $af_c_f_field_option) {

						$db_values = explode(',', $value);

						if (!empty($db_values)) { 
							?>
							<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" 
								<?php 
								if (in_array(esc_attr($af_c_f_field_option['field_value']), $db_values)) {
									echo 'selected';} 
								?>
							>
								<?php echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields'); ?>
						<?php } else { ?>
							<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>">
								<?php echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields'); ?>
							</option>
							<?php 
						}
					}
				endif;
				?>
			</select>
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'multi_checkbox' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<?php 

			if ( !empty( $af_c_f_field_options ) ) :
				foreach ($af_c_f_field_options as $af_c_f_field_option) {
					$db_values = explode(',', $value);
					?>
					<input  <?php echo esc_attr( $custom_attributes ); ?> type="checkbox" class="input-checkbox " name="af_c_f_additional_<?php echo intval($field_id); ?>[]" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>"
					<?php
					if (in_array(esc_attr($af_c_f_field_option['field_value']), $db_values)) {
						echo 'checked';
					}
					?>
					/>
					<span class="af_c_f_radio">
					<?php 
					if (!empty($af_c_f_field_option['field_text'])) {
						echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');} 
					?>
					</span>
					<?php 
				}
			endif;
			?>
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'checkbox' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<input type="checkbox" class="input-checkbox " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="yes" <?php echo checked('yes', esc_attr($value)); ?>  />
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'radio' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<?php 

			if ( !empty( $af_c_f_field_options ) ) :

				foreach ($af_c_f_field_options as $af_c_f_field_option) { 
					?>
					<input  <?php echo esc_attr( $custom_attributes ); ?> type="radio" class="input-radio " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" <?php echo checked(esc_attr($value), esc_attr($af_c_f_field_option['field_value'])); ?>  />
					<span class="af_c_f_radio">
					<?php 
					if (!empty($af_c_f_field_option['field_text'])) {
						echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');} 
					?>
					</span>
					<?php 
				}
			endif;
			?>
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'number' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<input  <?php echo esc_attr( $custom_attributes ); ?> type="number" class="regular-text" value="<?php echo esc_attr($value); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" name="af_c_f_additional_<?php echo intval($field_id); ?>">
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'password' == $af_c_f_field_type) { ?>

		<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<input  <?php echo esc_attr( $custom_attributes ); ?> type="password" class="regular-text" value="<?php echo esc_attr($value); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" name="af_c_f_additional_<?php echo intval($field_id); ?>">
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'fileupload' == $af_c_f_field_type) { ?>


		<tr class="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
		<th>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
			</label>
		</th>
		<td>
			<?php
			if ( !empty( $value ) ) {
				$ext = pathinfo( AF_CF_UPLOAD_DIR . $value, PATHINFO_EXTENSION);

				if ( in_array( $ext, array( 'png', 'PNG', 'JPG', 'jpg', 'JPEG', 'jpeg', 'gif', 'GIF' ) ) ) {
					?>
						<img src="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" width="150" height="150" />
						
						<a href="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" target="_blank" class="fa fa-eye"></a>
					<?php } else { ?>

						<a href="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" target="_blank">
							<?php esc_html_e( 'Click to View', 'af_custom_fields' ); ?>
						</a>
						<?php 
					}
			}
			?>
			<br>
			<input  <?php echo esc_attr( $custom_attributes ); ?> type="file" class="input-text " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" placeholder="
				<?php 
				if (!empty($af_c_f_field_placeholder)) {
					echo esc_html__($af_c_f_field_placeholder , 'af_custom_fields' );} 
				?>
			" />
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'color' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th><label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		</label></th>
		<td>
			<input type="color"  <?php echo esc_attr( $custom_attributes ); ?> class="input-text color_sepctrumm" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="
				<?php 
				if (!empty($af_c_f_field_placeholder)) {
					echo esc_html__($af_c_f_field_placeholder , 'af_custom_fields' );} 
				?>
			" />
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>

			<script>

			jQuery(".color_sepctrumm").spectrum({
				color: "<?php echo esc_attr($value); ?>",
				preferredFormat: "hex",
			});

			</script>
		</td>
	</tr>

<?php } elseif ( 'datepicker' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th><label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		</label></th>
		<td>
			<input <?php echo esc_attr( $custom_attributes ); ?> type="date" class="input-text " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="
				<?php 
				if (!empty($af_c_f_field_placeholder)) {
					echo esc_html__($af_c_f_field_placeholder , 'af_custom_fields' );} 
				?>
			" />
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

<?php } elseif ( 'timepicker' == $af_c_f_field_type) { ?>

	<tr id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>"  >
		<th><label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		</label></th>
		<td>
			<input  <?php echo esc_attr( $custom_attributes ); ?> type="time" class="input-text " name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="
				<?php 
				if (!empty($af_c_f_field_placeholder)) {
					echo esc_html__($af_c_f_field_placeholder , 'af_custom_fields' );} 
				?>
			" />
			<br>
			<span class="description"></span>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<span class="description"><?php echo esc_html__($af_c_f_field_description, 'af_custom_fields'); ?></span>
			<?php } ?>
		</td>
	</tr>

	<?php 
}
?>


<!-- Dependable -->
<?php if ( !empty($field_roles)) { ?>

	<style>
		#af_c_f_additionalshowhide_<?php echo intval($field_id); ?> { display: none; }
		.af_c_f_additionalshowhide_<?php echo intval($field_id); ?> { display: none; }
	</style>

<?php } ?>

<script>

	jQuery(document).ready(function() {

		var val = jQuery('#role option:selected').val();
		var field_roles = new Array();
		var is_dependable = '<?php echo empty( $field_roles ) ? 'off' : 'on'; ?>';
			
			<?php if ( !empty($field_roles)) { ?>
				<?php foreach ($field_roles as $key => $value) { ?>

					field_roles.push('<?php echo esc_attr($value); ?>');

				<?php } ?>

				var match_val = field_roles.includes(val);

				if (match_val == true && is_dependable == 'on') {


					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();
					jQuery('.af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

				} else if (match_val == false && is_dependable == 'on') {

					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
					jQuery('.af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
				} else {

					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();
					jQuery('.af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

				}

			<?php } ?>

	});
	
	jQuery(document).on('change', '#role', function() {

		var val = this.value;
		var field_roles = new Array();
		var is_dependable = '<?php echo empty( $field_roles ) ? 'off' : 'on'; ?>';
			
			<?php if ( !empty($field_roles)) { ?>
				<?php foreach ($field_roles as $key => $value) { ?>

					field_roles.push('<?php echo esc_attr($value); ?>');

				<?php } ?>

				var match_val = field_roles.includes(val);

				if (match_val == true && is_dependable == 'on') {


					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();
					jQuery('.af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();


				} else if (match_val == false && is_dependable == 'on') {

					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
					jQuery('.af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();

				} else {

					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();
					jQuery('.af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();


				}

			<?php } ?>
	});

</script>
