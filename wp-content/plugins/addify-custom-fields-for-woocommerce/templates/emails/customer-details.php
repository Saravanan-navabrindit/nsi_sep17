<?php 

defined('ABSPATH') || exit;


$user = get_user_by( 'id', $user_id );

?>
<div class="af_c_f_extra_fields">
	<h3><?php echo esc_html__(get_option('af_c_f_additional_fields_section_title'), 'af_custom_fields'); ?></h3>
	<table>
		<?php
		$af_c_f_args = array( 
			'posts_per_page' => -1,
			'post_type'      => 'af_c_fields',
			'post_status'    => 'publish',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		);

		$af_c_f_extra_fields = get_posts($af_c_f_args);

		if ( !empty($af_c_f_extra_fields) ) {

			foreach ( $af_c_f_extra_fields as $af_c_f_field ) {

				$value   = get_user_meta( $user_id, 'af_c_f_additional_' . intval($af_c_f_field->ID), true );
				$_type   = get_post_meta( intval($af_c_f_field->ID), 'af_c_f_field_type', true );
				$options = ( get_post_meta( intval($af_c_f_field->ID), 'af_c_f_field_option', true ) ); 
				$roles   = get_post_meta( $af_c_f_field->ID, 'af_c_f_field_user_roles', true );

				$roles       = get_post_meta( $af_c_f_field->ID, 'af_c_f_field_user_roles', true );
				$field_pages = get_post_meta( $af_c_f_field->ID, 'af_c_f_field_pages', true );

				if ( !empty( $roles ) && ! in_array( current( $user->roles ), $roles ) ) {
					continue;
				}

				if ( !empty( $page ) && !empty( $field_pages ) && ! in_array( $page, $field_pages ) ) {
					continue;
				}

				if ( empty( $value ) ) {
					continue;
				}

				if ( in_array( $_type, array( 'heading', 'message', 'googlecaptcha', 'privacy' ) ) ) {
					continue;
				}

				?>
				<tr>
					<th>
						<?php echo esc_html( get_the_title( $af_c_f_field->ID ) ); ?> 
					</th>
					<td>
						<?php
						
						if ( !empty( $value ) ) {

							if ( in_array( $_type, array( 'text', 'textarea', 'checkbox', 'email', 'number', 'password', 'color', 'datepicker', 'timepicker', 'vat' ) ) ) {

								echo wp_kses_post( $value );

							} elseif ( in_array( $_type, array( 'select', 'multiselect', 'multi_checkbox', 'radio' ) ) ) {

								$val_array = explode(',' , $value );
								$value     = array();

								foreach ( $val_array as $option_val ) {
									foreach ($options as $af_c_f_field_option ) { 
										if ( $af_c_f_field_option['field_value'] == $option_val ) {
											$value[] =  $af_c_f_field_option['field_text'] ;
										}
									}
								}

								echo esc_attr( implode(', ' , $value ) );

							} elseif ( 'fileupload' == $_type  ) {

								$curr_image = esc_url( AF_CF_UPLOAD_URL . $value );
								?>
									<a href="<?php echo esc_url( AF_CF_UPLOAD_URL . $value ); ?>" target="_blank">
										<?php esc_html_e( 'Click to View', 'af_custom_fields'); ?>
									</a>
								<?php
							}
						}
						?>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
</div>
