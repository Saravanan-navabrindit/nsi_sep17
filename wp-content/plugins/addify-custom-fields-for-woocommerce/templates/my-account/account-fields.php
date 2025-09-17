<?php

defined('ABSPATH') || exit;


if ('text' == $af_c_f_field_type) { 
	?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			<span class="required">
			<?php 
			if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
				?>
				*
				<?php
			} 
			?>
			</span>
		</label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="text" class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder ); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'textarea' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
				*
				<?php
		} 
		?>
			</span></label>
		<?php 
		if ( 'on' == $af_c_f_field_read_only) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<textarea  <?php echo esc_html( $custom_attributes ); ?> class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>"  id="af_c_f_additional_<?php echo intval($field_id); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder ); ?>"><?php echo esc_attr($value); ?></textarea>
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'email' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
				*
				<?php
		} 
		?>
			</span></label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only ) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="text" class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder ); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'select' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
			*
			<?php
		} 
		?>
			</span></label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only && !empty( $af_c_f_field_options ) ) { 
			foreach ($af_c_f_field_options as $af_c_f_field_option) {
				if ( esc_attr($value) == esc_attr($af_c_f_field_option['field_value']) ) {
					echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');
				}
				
			}
		} else { 
			?>

		<select  <?php echo esc_html( $custom_attributes ); ?> class="input-select 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php
			if ( !empty( $af_c_f_field_options ) ) :
				foreach ($af_c_f_field_options as $af_c_f_field_option) { 
					?>
					<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" 
						<?php 
						
							echo selected(esc_attr($value), esc_attr($af_c_f_field_option['field_value']));
						?>
					>
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
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'multiselect' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			<span class="required">
			<?php 
			if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
				?>
				*
				<?php
			} 
			?>
			</span>
		</label>

		<?php 
		$af_c_f_field_options = ( get_post_meta(  intval($field_id) , 'af_c_f_field_option', true ) );

		if ( 'on' == $af_c_f_field_read_only && !empty( $af_c_f_field_options ) ) {

			$val_array = explode(',' , $value );
			$value     = array();

			foreach ( $val_array as $option_val ) {
				foreach ($af_c_f_field_options as $af_c_f_field_option ) { 
					if ( $af_c_f_field_option['field_value'] == $option_val ) {
						$value[] =  $af_c_f_field_option['field_text'] ;
					}
				}
			}

			echo esc_attr( empty( $value ) ? '-----' : implode(', ' , $value ) );

		} else {
			?>

		<select  <?php echo esc_html( $custom_attributes ); ?> class="input-select 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>[]" id="af_c_f_additional_<?php echo intval($field_id); ?>" multiple>
			<?php 
			if ( !empty( $af_c_f_field_options ) ) :
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
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

	<?php 
} elseif ('multi_checkbox' == $af_c_f_field_type) {
	
	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			<span class="required">
			<?php 
			if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
				?>
				*
				<?php
			} 
			?>
			</span>
		</label>

		<?php 
		$af_c_f_field_options = ( get_post_meta(  intval($field_id) , 'af_c_f_field_option', true ) );

		if ('on' == $af_c_f_field_read_only && !empty( $af_c_f_field_options ) ) { 

			$val_array = explode(',' , $value );
			$value     = array();

			foreach ( $val_array as $option_val ) {
				foreach ($af_c_f_field_options as $af_c_f_field_option ) { 
					if ( $af_c_f_field_option['field_value'] == $option_val ) {
						$value[] =  $af_c_f_field_option['field_text'] ;
					}
				}
			}

			echo esc_attr( empty( $value ) ? '-----' : implode(', ' , $value ) );

		} else {

			if ( !empty( $af_c_f_field_options ) ) :
				foreach ($af_c_f_field_options as $af_c_f_field_option) {

					$db_values = explode(',', $value);
					?>
					<input  <?php echo esc_html( $custom_attributes ); ?> type="checkbox" class="input-checkbox 
						<?php 
						if (!empty($af_c_f_field_css)) {
							echo esc_attr($af_c_f_field_css);} 
						?>
						" name="af_c_f_additional_<?php echo intval($field_id); ?>[]" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" 
						<?php 
							
						if (in_array(esc_attr($af_c_f_field_option['field_value']), $db_values)) {
							echo 'checked';
						}
							
						
						?>
					/>
					<span class="af_c_f_checkbox">
						<?php 
						if (!empty($af_c_f_field_option['field_text'])) {
							echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields');} 
						?>
					</span>
					<?php 
				}
			endif;
			
			if (!empty($af_c_f_field_description)) { 
				?>
				<br>
				<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
				<?php 
			}
		} 
		?>
	</p>

	<?php 
} elseif ('checkbox' == $af_c_f_field_type) {
	
	?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">

		<?php 
		if ('on' == $af_c_f_field_read_only) { 
			?>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
				<span class="required">
					<?php 
					if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required ) {
						?>
							*
							<?php
					} 
					?>
				</span>
			</label>
			<?php
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>
			<label class="checkbox" for="af_c_f_additional_<?php echo intval($field_id); ?>">
				<input <?php echo esc_html( $custom_attributes ); ?> <?php echo esc_html( $custom_attributes ); ?> <?php echo checked('yes', esc_attr($value)); ?> type="checkbox" class="input-checkbox 
				<?php 
				if (!empty($af_c_f_field_css)) {
					echo esc_attr($af_c_f_field_css);} 
				?>
				" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="yes" />
				<?php 
				if (!empty(get_the_title($field_id))) {
					echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
				?>
				<abbr class="required" title="required"><?php echo 'on' == $af_c_f_field_required ? '*':''; ?></abbr>
			</label>
		
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'radio' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			<span class="required">
				<?php 
				if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
					?>
					*
					<?php
				} 
				?>
			</span>
		</label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only && !empty( $af_c_f_field_options ) ) { 

			foreach ($af_c_f_field_options as $af_c_f_field_option) {
				if ( esc_attr($value) == esc_attr($af_c_f_field_option['field_value']) ) {
					echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields') ;
				}
				
			}

		} elseif ( !empty( $af_c_f_field_options ) ) {
			?>
		
			<?php foreach ($af_c_f_field_options as $af_c_f_field_option) { ?>
			<input  <?php echo esc_html( $custom_attributes ); ?> type="radio" class="input-radio 
				<?php 
				if (!empty($af_c_f_field_css)) {
					echo esc_attr($af_c_f_field_css);} 
				?>
			" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" 
				<?php 
				
					echo checked(esc_attr($value), esc_attr($af_c_f_field_option['field_value']));
				
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
			?>
		
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'number' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
												<?php 
												if (!empty(get_the_title($field_id))) {
													echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
												?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required ) {
			?>
				*
				<?php
		} 
		?>
			</span></label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="number" class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'password' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
												<?php 
												if (!empty(get_the_title($field_id))) {
													echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
												?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
				*
				<?php
		} 
		?>
			</span></label>

		<?php 
		if ('on' == $af_c_f_field_read_only ) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="password" class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'fileupload' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
			
		<?php
		$curr_image = esc_url( AF_CF_UPLOAD_URL . $value);

		if (!empty($value)) {
			?>
			<label for="af_c_f_additional_<?php echo intval($field_id); ?>"><?php echo esc_html__('Current', 'af_custom_fields'); ?> <?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			</label>
			<?php
			$ext = pathinfo($curr_image, PATHINFO_EXTENSION);
			if ( in_array( $ext, array( 'png', 'PNG', 'JPG', 'jpg', 'JPEG', 'jpeg', 'gif', 'GIF' ) ) ) {
				?>
				<img src="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" width="150" height="150" />
				<a href="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" target="_blank" class="fa fa-eye"></a>

				
			<?php } else { ?>
				<a href="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" target="_blank" class="fa fa-eye">
					<?php esc_html_e( 'Click to View', 'af_custom_fields' ); ?>
				</a>
				<?php 
			} 
		} 
		?>

		<?php 
		if ('on' != $af_c_f_field_read_only) {
			
			?>
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			<span class="required">
				<?php 
				if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
					?>
					*
					<?php
				} 
				?>
			</span>
		</label>
		<input  <?php echo esc_html( $custom_attributes ); ?> type="file" accept="" class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'color' == $af_c_f_field_type) { ?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
			<span class="required">
				<?php 
				if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
					?>
						*
						<?php
				} 
				?>
			</span>
		</label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="color" class="input-color color_sepctrumm 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'datepicker' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
												<?php 
												if (!empty(get_the_title($field_id))) {
													echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
												?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
				*
				<?php
		} 
		?>
			</span></label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="date" class="input-text  
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'timepicker' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
			*
			<?php
		} 
		?>
			</span></label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only ) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="time" class="input-text  
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message_radiodio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>

<?php } elseif ( 'googlecaptcha' == $af_c_f_field_type && !is_checkout() ) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">*</span></label>
		
		<div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('af_c_f_site_key')); ?>"></div>

		<?php if (!empty($af_c_f_field_description)) { ?>
			<br>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'heading' == $af_c_f_field_type) {
	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
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
} elseif ( 'privacy' == $af_c_f_field_type) {
	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<input type="checkbox" class="input-checkbox" <?php echo esc_attr( $custom_attributes ); ?> name="af_c_f_additional_<?php echo intval($field_id); ?>[]" value="yes" required/>
		<span class="af_c_f_checkbox">
		<?php 
			$message = get_post_meta( $field_id, 'af_c_f_field_text', true );
			$message = wptexturize( wpautop( $message ) );
			$message = str_replace( array( '<p>', '</p>' ), array( '', '' ), $message );
			echo wp_kses_post( $message );
		?>
		<span class="required">*</span>
		</span>
	</p>
	<?php
} elseif ( 'message' == $af_c_f_field_type) {
	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<?php 
		$message = get_post_meta( $field_id, 'af_c_f_field_text', true );
		$message = wptexturize( wpautop( $message ) );
		$message = str_replace( array( '<p>', '</p>' ), array( '', '' ), $message );
		echo wp_kses_post( $message );
		?>
	</p>
	<?php
} else {

	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">
		<?php 
		if (!empty($af_c_f_field_required) && 'on' == $af_c_f_field_required) {
			?>
				*
				<?php
		} 
		?>
			</span></label>

		<?php 
		if ( 'on' == $af_c_f_field_read_only) { 
			echo empty( $value ) ? '-----' : esc_attr($value);
		} else { 
			?>

		<input  <?php echo esc_html( $custom_attributes ); ?> type="text" class="input-text 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);} 
			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr( $af_c_f_field_placeholder ); ?>" />
			<?php if (!empty($af_c_f_field_description)) { ?>
				<br>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } } ?>
	</p>
	<?php
}
