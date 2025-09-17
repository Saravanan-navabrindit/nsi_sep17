<p class="form-row form-row-wide">
	<label for="af_c_f_user_role"><?php echo esc_html__($role_field_label, 'af_custom_fields'); ?><span class="required">*</span></label>
	<select class="input-select" name="af_c_f_user_roles" id="af_c_f_user_roles">
		<option value=""><?php echo esc_html__('---Select---', 'af_custom_fields'); ?></option>
		<?php
		$user_roles = get_option('af_c_f_user_roles');
		global $wp_rolesss;
		if ( !isset( $wp_rolesss ) ) {
			$wp_rolesss = new WP_Roles();
		}

		if ( !empty( $user_roles)) {
			foreach ( $user_roles as $key => $value) {
				?>
		<option value="<?php echo esc_attr($value); ?>" <?php echo selected($value, $vall); ?>>
				<?php echo esc_attr(translate_user_role( $wp_rolesss->roles[ $value ]['name'], 'default' )); ?>
		</option>
		<?php } } ?>
	</select>
</p>
