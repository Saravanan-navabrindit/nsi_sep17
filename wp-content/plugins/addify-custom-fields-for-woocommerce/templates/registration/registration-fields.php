<?php 

if ( isset( $_POST['register']) && '' != $_POST['register']) {

	if (!empty($_REQUEST['af_c_f_nonce_field'])) {

		$retrieved_nonce = sanitize_text_field($_REQUEST['af_c_f_nonce_field']);
	} else {
			$retrieved_nonce = 0;
	}

	if (!wp_verify_nonce($retrieved_nonce, 'af_c_f_nonce_action')) {

		wp_die( esc_html__('Security Violated', 'af_custom_fields') );
	}
}

$vall = isset( $_POST[ 'af_c_f_additional_' . $field_id ] ) ? sanitize_meta( '', $_POST[ 'af_c_f_additional_' . $field_id ], '' ) : '';

if ( 'text' == $af_c_f_field_type) { 
		
	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input type="text" value="<?php echo esc_attr($vall); ?>" <?php echo esc_html( $custom_attributes ); ?> class="input-text 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if ( !empty($af_c_f_field_description) ) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'textarea' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<textarea placeholder="<?php echo esc_attr( $af_c_f_field_placeholder ); ?>"  <?php echo esc_html( $custom_attributes ); ?> class="input-text 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additional_<?php echo intval($field_id); ?>"><?php echo esc_attr($vall); ?></textarea>
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'email' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input type="email"  <?php echo esc_html( $custom_attributes ); ?> class="input-text 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'select' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
					<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" <?php echo selected($af_c_f_field_option['field_value'], $vall); ?>>
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
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'multiselect' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<select  <?php echo esc_html( $custom_attributes ); ?> class="input-select <?php echo esc_attr($af_c_f_field_css); ?>" name="af_c_f_additional_<?php echo intval($field_id); ?>[]" id="af_c_f_additional_<?php echo intval($field_id); ?>" multiple>
			<?php 
			if ( !empty( $af_c_f_field_options ) ) :
				foreach ($af_c_f_field_options as $af_c_f_field_option) {
					?>
					<option value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" >
						<?php echo esc_html__(esc_attr($af_c_f_field_option['field_text']), 'af_custom_fields'); ?>
					</option>
					<?php 
				}
			endif;
			?>
		</select>
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'multi_checkbox' == $af_c_f_field_type) { ?> 

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">
		<?php 
		if ( !empty($af_c_f_field_required) && 'on' == $af_c_f_field_required ) {
			?>
			*
			<?php
		} 
		?>
		</span></label>
		
		<?php
		if ( !empty( $af_c_f_field_options ) ) :
			foreach ($af_c_f_field_options as $af_c_f_field_option) { 
				?>
				<input  <?php echo esc_html( $custom_attributes ); ?> type="checkbox" class="input-checkbox 
				<?php 
				if (!empty($af_c_f_field_css)) {
					echo esc_attr($af_c_f_field_css);} 
				?>
				" name="af_c_f_additional_<?php echo intval($field_id); ?>[]" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" 
					<?php 
					if ( in_array($af_c_f_field_option['field_value'], (array) $vall ) ) {
						echo 'checked'; 
					} 
					?>
				/>
				<span class="af_c_f_radios">
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
		<?php } ?>
	</p>

<?php } elseif ( 'checkbox' == $af_c_f_field_type) { ?> 

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		
		<input  <?php echo esc_html( $custom_attributes ); ?> <?php echo checked('yes', esc_attr($vall)); ?> type="checkbox" class="input-checkbox 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="yes" />

		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'radio' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		if ( !empty( $af_c_f_field_options ) ) :
			foreach ($af_c_f_field_options as $af_c_f_field_option) { 
				?>
				<input  <?php echo esc_html( $custom_attributes ); ?> type="radio" class="input-radio 
				<?php 
				if (!empty($af_c_f_field_css)) {
					echo esc_attr($af_c_f_field_css);} 
				?>
				" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($af_c_f_field_option['field_value']); ?>" <?php echo checked($af_c_f_field_option['field_value'], $vall); ?> />
				<span class="af_c_f_radio">
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
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ('number' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input  <?php echo esc_html( $custom_attributes ); ?> type="number" class="input-text 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'password' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input  <?php echo esc_html( $custom_attributes ); ?> type="password" class="input-text 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'fileupload' == $af_c_f_field_type && !is_checkout() ) {

	$file_types = get_post_meta( intval($field_id), 'af_c_f_field_file_type', true );
	$file_types = explode( ',', $file_types );
	$file_types = array_map( 'add_dot_before_extension', $file_types );
	$file_types = implode( ',', $file_types );
	?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input  <?php echo esc_html( $custom_attributes ); ?> type="file" class="input-text 
		<?php
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);
		}
		?>
		" <?php echo empty( $file_types ) ? '' : 'accept="' . esc_attr( trim( $file_types ) ) . '"'; ?> name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ('color' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input  <?php echo esc_html( $custom_attributes ); ?> type="color" class="input-color color_sepctrum 
			<?php 
			if (!empty($af_c_f_field_css)) {
				echo esc_attr($af_c_f_field_css);
			}

			?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'datepicker' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input type="date"  <?php echo esc_html( $custom_attributes ); ?> class="input-text  
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'timepicker' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input type="time"  <?php echo esc_html( $custom_attributes ); ?> class="input-text  
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" value="<?php echo esc_attr($vall); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

<?php } elseif ( 'googlecaptcha' == $af_c_f_field_type) { ?>

	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
		<label for="af_c_f_additional_<?php echo intval($field_id); ?>">
			<?php 
			if (!empty(get_the_title($field_id))) {
				echo esc_html__(get_the_title($field_id) , 'af_custom_fields' );} 
			?>
		<span class="required">*</span></label>
		
		<div class="g-recaptcha" data-sitekey="<?php echo esc_attr(get_option('af_c_f_site_key')); ?>"></div>

		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message_radio"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>

	<?php 
} elseif ( 'heading' == $af_c_f_field_type) {
	?>
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
		<input type="checkbox"  <?php echo esc_html( $custom_attributes ); ?> class="input-checkbox" name="af_c_f_additional_<?php echo intval($field_id); ?>" value="yes" required/>
		<span class="af_cf_checkbox">
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
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" <?php echo esc_html( $custom_attributes ); ?> id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
	<p class="form-row <?php echo esc_attr($af_c_f_main_class); ?>" id="af_c_f_additionalshowhide_<?php echo intval($field_id); ?>">
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
		<input type="text"  <?php echo esc_html( $custom_attributes ); ?> class="input-text 
		<?php 
		if (!empty($af_c_f_field_css)) {
			echo esc_attr($af_c_f_field_css);} 
		?>
		" name="af_c_f_additional_<?php echo intval($field_id); ?>" id="af_c_f_additional_<?php echo intval($field_id); ?>" placeholder="<?php echo esc_html__($af_c_f_field_placeholder, 'af_custom_fields'); ?>" />
		<?php if (!empty($af_c_f_field_description)) { ?>
			<span class="af_c_f_field_message"><?php echo wp_kses_post($af_c_f_field_description); ?></span>
		<?php } ?>
	</p>
	<?php
}

if (!empty($field_roles)) { 
	?>

	<style>
		#af_c_f_additionalshowhide_<?php echo intval($field_id); ?> { display: none; }
	</style>

<?php } ?>

<script>
	
	jQuery(document).on('change', '#af_c_f_user_roles', function() {

		var val = this.value;
		var field_roles = new Array();
		var is_dependable = '<?php echo !empty( $field_roles ) ? 'on' : 'off'; ?>';

		<?php if ( !empty($field_roles)) { ?>
			<?php foreach ($field_roles as $key => $value) { ?>

				field_roles.push('<?php echo esc_attr($value); ?>');

			<?php } ?>

			var match_val = field_roles.includes(val);

			if ( match_val == true && is_dependable == 'on') {

				if( jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').attr('required') ){
					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').prop('required', true );
				}

				jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

			} else if (match_val == false && is_dependable == 'on') {

				if( jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').attr('required') ){
					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').prop('required', false );
				}

				jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
			} else {

				if( jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').attr('required') ){
					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').prop('required', true );
				}

				jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

			}

		<?php } ?>
	});

	jQuery(document).on('ready' , function() {

		var val = jQuery('#af_c_f_user_roles').val();
		var field_roles = new Array();
		var is_dependable = '<?php echo !empty( $field_roles ) ? 'on' : 'off'; ?>';
			
		<?php if ( !empty($field_roles)) { ?>
			<?php foreach ($field_roles as $key => $value) { ?>

				field_roles.push('<?php echo esc_attr($value); ?>');

			<?php } ?>

			var match_val = field_roles.includes(val);

			if (match_val == true && is_dependable == 'on') {

				if( jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').attr('required') ){
					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').prop('required', true );
				}

				jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

			} else if (match_val == false && is_dependable == 'on') {

				if( jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').attr('required') ){
					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').prop('required', false );
				}

				jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').hide();
			} else {

				if( jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').attr('required') ){
					jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').find('input').prop('required', true );
				}

				jQuery('#af_c_f_additionalshowhide_<?php echo intval($field_id); ?>').show();

			}

		<?php } ?>
	});

</script>
