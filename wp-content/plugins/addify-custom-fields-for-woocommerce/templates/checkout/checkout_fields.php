<?php

defined( 'ABSPATH' ) || exit;

if ( 'radio' == $_type && !empty( $_options ) ) { ?>

	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
				<?php 
				if (!empty($_required) && 'on' == $_required) {
					?>
					*
					<?php
				}
				?>
			</span>
		</label>
			<?php foreach ($_options as $option_value => $option_label ) { ?>
			<input  <?php echo esc_html( $custom_attributes ); ?> type="radio" class="input-radio af-front-fields <?php echo esc_attr( $input_class ); ?>
				<?php 
				if (!empty($af_cf_field_css)) {
					echo esc_attr($af_cf_field_css);} 
				?>
				" name="af_c_f_<?php echo intval($field_id); ?>" id="af_c_f_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($option_value); ?>" 
				<?php 
				
					echo checked(esc_attr($value), esc_attr($option_value));
				
				?>
			/>
			<span class="af_c_f_radio">
				<?php 
				if (!empty($option_label)) {
					echo wp_kses_post( $option_label );
				} 
				?>
			</span>
		
		<?php } ?>

		<?php if (!empty($_description)) { ?>
			<br>
			<span class="af_c_f_field_message_radio">
				<?php echo wp_kses_post($_description); ?>
				
			</span>
		<?php } ?>
	</p>

<?php } elseif ( 'select' == $_type && !empty( $_options ) ) { ?>

	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
			<?php 
				echo 'on' == $_required ? '*' : '';
			?>
			</span>
		</label>

		<select <?php echo esc_attr( $custom_attributes ); ?> class="input-select af-front-fields <?php echo esc_attr( $input_class ); ?> <?php echo !empty($af_cf_field_css) ? esc_attr($af_cf_field_css) : ''; ?> " name="af_c_f_<?php echo intval($field_id); ?>" id="af_c_f_<?php echo intval($field_id); ?>">
			<?php 
			foreach ( $_options as $option_value => $option_label ) {

				$db_values = !is_array( $value ) ? explode(', ', (string) $value ) : $value;

				if ( empty( $option_value ) ) {
					continue;
				}

				if (!empty($db_values)) {
					?>
					<option value="<?php echo esc_attr($option_value); ?>" 
						<?php 
						if (in_array( $option_value, $db_values)) {
							echo 'selected';} 
						?>
					>
					<?php echo wp_kses_post( $option_label ); ?>
				<?php } else { ?>
					<option value="<?php echo esc_attr($option_value); ?>">
						<?php echo wp_kses_post( $option_label ); ?>
					</option>
					<?php 
				} 
			} 
			?>
		</select>
			<?php if (!empty($_description)) { ?>
				<br>
			<span class="af_cf_field_message"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'multiselect' == $_type && !empty( $_options ) ) { 
	?>

	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
			<?php 
				echo 'on' == $_required ? '*' : '';
			?>
			</span>
		</label>

		<select <?php echo esc_attr( $custom_attributes ); ?> class="input-select af-front-fields <?php echo esc_attr( $input_class ); ?> <?php echo !empty($af_cf_field_css) ? esc_attr($af_cf_field_css) : ''; ?> " name="af_c_f_<?php echo intval($field_id); ?>[]" id="af_c_f_<?php echo intval($field_id); ?>" multiple>
			<?php 
			foreach ( $_options as $option_value => $option_label ) {

				$db_values = !is_array( $value ) ? explode(', ', (string) $value ) : $value;

				if ( empty( $option_value ) ) {
					continue;
				}

				if (!empty($db_values)) {
					?>
					<option value="<?php echo esc_attr($option_value); ?>" 
						<?php 
						if (in_array( $option_value, $db_values)) {
							echo 'selected';} 
						?>
					>
					<?php echo wp_kses_post( $option_label ); ?>
				<?php } else { ?>
					<option value="<?php echo esc_attr($option_value); ?>">
						<?php echo wp_kses_post( $option_label ); ?>
					</option>
					<?php 
				} 
			} 
			?>
		</select>
			<?php if (!empty($_description)) { ?>
				<br>
			<span class="af_cf_field_message"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'googlecaptcha' == $_type) { 
	?>

	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>" <?php echo esc_attr( $custom_attributes ); ?> id="af_c_f_<?php echo intval($field_id); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">*</span>
		</label>
		
		<div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('af_c_f_site_key')); ?>"></div>

		<?php if (!empty($_description)) { ?>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ('multi_checkbox' == $_type && !empty( $_options ) ) {
	
	?>
	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
			<?php 
				echo 'on' == $_required ? '*' : '';
			?>
			</span>
		</label>

		<?php 
		foreach ($_options as $option_value => $option_label ) {

			$db_values = !is_array( $value ) ? explode(', ', (string) $value ) : $value;
			?>
				<input type="checkbox" <?php echo esc_attr( $custom_attributes ); ?> class="input-checkbox af-front-fields <?php echo esc_attr( $input_class ); ?> 
				<?php 
				if (!empty($af_cf_field_css)) {
					echo esc_attr($af_cf_field_css);} 
				?>
				" name="af_c_f_<?php echo intval($field_id); ?>[]" id="af_c_f_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($option_value); ?>" 
				<?php 
						
				if ( in_array( $option_value, $db_values ) ) {
					echo 'checked';
				}
				?>
				/>
				<span class="af_cf_checkbox">
				<?php 
				if (!empty($option_label)) {
					echo wp_kses_post( $option_label );} 
				?>
				</span>
		<?php } ?>
		
			<?php if (!empty($_description)) { ?>
				<br>
			<span class="af_cf_field_message"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'heading' == $_type ) {
	?>
	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<<?php echo esc_html( get_post_meta( $field_id, 'af_c_f_heading_tag', true ) ); ?>>
			<?php 
			$message = get_post_meta( $field_id, 'af_c_f_field_text', true );
			$message = wptexturize( wpautop( $message ) );
			$message = str_replace( array( '<p>', '</p>' ), array( '', '' ), $message );
			echo wp_kses_post( $message );
			?>
		</<?php echo esc_html( get_post_meta( $field_id, 'af_c_f_heading_tag', true ) ); ?>>
	</p>
		<?php
} elseif ( 'privacy' == $_type) {
	?>
	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<input type="checkbox" <?php echo esc_attr( $custom_attributes ); ?> class="input-checkbox af-front-fields" name="af_c_f_<?php echo intval($field_id); ?>[]" value="yes" required/>
		<span class="af_cf_checkbox">
			<?php 
			$message = get_post_meta( $field_id, 'af_c_f_field_text', true );
			$message = wptexturize( wpautop( $message ) );
			$message = str_replace( array( '<p>', '</p>' ), array( '', '' ), $message );
			echo wp_kses_post( $message );
			?>
			<abbr class="required" title="required">*</abbr>
		</span>
	</p>
	<?php
} elseif ( 'message' == $_type ) {
	?>
	<p class="form-row af-front-fields <?php echo esc_attr($af_cf_main_class); ?>">
		<?php 
		$message = get_post_meta( $field_id, 'af_c_f_field_text', true );
		$message = wptexturize( wpautop( $message ) );
		$message = str_replace( array( '<p>', '</p>' ), array( '', '' ), $message );
		echo wp_kses_post( $message );
		?>
	</p>
	<?php
	
} elseif ( 'color' == $_type) { 
	?>
	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
				<?php 
				if (!empty($_required) && 'on' == $_required) {
					?>
					*
					<?php
				} 
				?>
			</span>
		</label>
		<input  <?php echo esc_attr( $custom_attributes ); ?> type="color" class="input-color af-front-fields <?php echo esc_attr( $input_class ); ?> color_sepctrumm 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_<?php echo intval($field_id); ?>" id="af_c_f_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $_placeholder); ?>" />
			<?php if (!empty($_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'datepicker' == $_type) { ?>

	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
			<?php 
			if (!empty($_required) && 'on' == $_required) {
				?>
					*
					<?php
			} 
			?>
			</span>
		</label>

		<input  <?php echo esc_attr( $custom_attributes ); ?> type="date" class="input-text af-front-fields <?php echo esc_attr( $input_class ); ?>
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_<?php echo intval($field_id); ?>" id="af_c_f_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $_placeholder); ?>" />
			<?php if (!empty($_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'timepicker' == $_type) { ?>

	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>">
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
				<?php 
				if (!empty($_required) && 'on' == $_required) {
					?>
					*
					<?php
				} 
				?>
			</span>
		</label>
		<input  <?php echo esc_attr( $custom_attributes ); ?> type="time" class="input-text af-front-fields  <?php echo esc_attr( $input_class ); ?> 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_<?php echo intval($field_id); ?>" id="af_c_f_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $_placeholder); ?>" />
			<?php if (!empty($_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radiodio"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'text' == $_type || 'vat' == $_type ) {

	?>
	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>" <?php echo esc_attr( $custom_attributes ); ?> >
		<label for="af_c_f_<?php echo intval($field_id); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
			<?php 
				echo 'on' == $_required ? '*' : '';
			?>
			</span>
		</label>
		<input type="text" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $custom_attributes ); ?> class="af-front-fields input-text <?php echo esc_attr( $input_class ); ?> 
		<?php 
		if (!empty($af_cf_field_css)) {
			echo esc_attr($af_cf_field_css);} 
		?>
		" name="af_c_f_<?php echo intval( $field_id ); ?>" id="af_c_f_<?php echo intval( $field_id ); ?>" placeholder="<?php echo esc_html__($_placeholder, 'af_custom_fields'); ?>" />
		<?php if ( !empty($_description) ) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>
	<?php
} elseif ( 'fileupload' == $_type ) {

	?>
	<p class="form-row <?php echo esc_attr($af_cf_main_class); ?>" data-field_id="<?php echo intval( $field_id ); ?>" <?php echo esc_attr( $custom_attributes ); ?> >
		<label for="af_c_f_<?php echo intval($field_id); ?>" data-field_id="<?php echo intval( $field_id ); ?>">
			<?php echo wp_kses_post( $label ); ?>
			<span class="required">
			<?php 
				echo 'on' == $_required ? '*' : '';
			?>
			</span>
		</label>
		<span class="af_message<?php echo intval($field_id); ?>"></span>
		<input type="file" value="<?php echo esc_attr( $value ); ?>" data-field_id="<?php echo intval( $field_id ); ?>" <?php echo esc_attr( $custom_attributes ); ?> class="input-text af_c_f_field_fileupload af-front-fields <?php echo esc_attr( $input_class ); ?> 
			<?php 
			if (!empty($af_cf_field_css)) {
				echo esc_attr($af_cf_field_css);} 
			?>
			" name="af_c_f_<?php echo intval( $field_id ); ?>" id="af_c_f_<?php echo intval( $field_id ); ?>" placeholder="<?php echo esc_html__($_placeholder, 'af_custom_fields'); ?>"/>
			<button type="button" class="af_c_f_upload_button" title="<?php esc_html_e('Upload File', 'af_checkout_fields'); ?>" value="af_c_f_upload_button" >
				<span class="dashicons dashicons-upload"></span>
			</button>
		<?php if ( !empty($_description) ) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($_description); ?></span>
		<?php } ?>
	</p>
	<?php
}
