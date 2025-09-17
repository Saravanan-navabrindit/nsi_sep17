<?php

defined('ABSPATH') || exit;

class AF_CF_Ajax {

	public function __construct() {

		add_action('wp_ajax_get_states', array( $this, 'get_states' ));
		add_action('wp_ajax_nopriv_get_states', array( $this, 'get_states' ));

		add_action('wp_ajax_afcf_search_products', array( $this, 'get_products' ) );
		add_action('wp_ajax_afcf_search_product_categories', array( $this, 'get_categories' ) );

		add_action('wp_ajax_afcf_file_upload', array( $this, 'upload_file' ) );
		add_action('wp_ajax_nopriv_afcf_file_upload', array( $this, 'upload_file' ) );
	}//end __construct()


	public function upload_file() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $nonce, 'afcf_nonce' ) ) {
			die( 'Failed Ajax security check!' );
		}

		$file     = isset( $_FILES['file'] ) ? sanitize_meta( '', $_FILES['file'], '' ) : '';
		$field_id = isset( $_POST['field_id'] ) ? sanitize_meta( '', $_POST['field_id'], '' ) : '';

		$file_size      = isset( $file['size'] ) ? $file['size'] : '';
		$file_extension = isset( $file['name'] ) ? explode('.', $file['name'] ) : '';
		$file_extension = end( $file_extension );

		$allowed_size = (int) get_post_meta($field_id, 'af_c_f_field_file_size', true );
		$allowed_ext  = get_post_meta($field_id, 'af_c_f_field_file_type', true ) ?  get_post_meta($field_id, 'af_c_f_field_file_type', true ) : ',' . $file_extension;
		$allowed_ext  = strtolower( $allowed_ext );


		$allowed_ext = explode(',', $allowed_ext );
		$allowed_ext = array_map('trim', $allowed_ext);

		if ( !empty( $allowed_size ) && $file_size > ( $allowed_size * 1024 * 1024 ) ) {
			ob_start();
			wc_print_notice(__('File is too large', 'af_checkout_fields' ), 'error' );
			$failed_message = ob_get_clean();
			wp_send_json(
				array(
					'success' => false,
					'message' => $failed_message,
				)
			);
		}


		if ( !empty( $allowed_ext ) &&  !in_array( $file_extension, $allowed_ext ) ) {
			ob_start();
			wc_print_notice(__('File with given Extension is not allowed. Allowed extensions are ', 'af_checkout_fields' ) . implode(',', $allowed_ext), 'error' );
			$failed_message = ob_get_clean();
			wp_send_json(
				array(
					'success' => false,
					'message' => $failed_message,
				)
			);
		}

		if ( realpath( $file['tmp_name'] ) !== $file['tmp_name'] ) {
			ob_start();
			wc_print_notice(__('Invalid file path.', 'af_checkout_fields' ), 'error' );
			$failed_message = ob_get_clean();
			wp_send_json(
				array(
					'success' => false,
					'message' => $failed_message,
				)
			);
		}
		

		if ( $file && isset( $file['tmp_name'] ) ) {

			$file_name = time() . '_' . $file['name'];

			copy($file['tmp_name'], AF_CF_UPLOAD_DIR . $file_name);

			ob_start();
			?>
			<input type="hidden" name="af_c_file_uploaded_<?php echo intval( $field_id ); ?>" value="<?php echo esc_html($file_name); ?>">
			<?php
			$hidden_field = ob_get_clean();
			ob_start();
			wc_print_notice(__('File has been uploaded successfully!', 'af_checkout_fields' ), 'success' );
			$message = ob_get_clean();
			wp_send_json(
				array(
					'success'      => true,
					'message'      => $message,
					'hidden_field' => $hidden_field,
				)
			);
		}

		ob_start();
		wc_print_notice(__('Failed to upload file', 'af_checkout_fields' ), 'error' );
		$failed_message = ob_get_clean();
		wp_send_json(
			array(
				'success' => false,
				'message' => $failed_message,
			)
		);
	}//end upload_file()


	public function get_products() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $nonce, 'afreg-ajax-nonce' ) ) {
			die( 'Failed Ajax security check!' );
		}

		$s = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';

		$args = array(
			'post_type'   => array( 'product' ),
			'post_status' => 'publish',
			'numberposts' => 50,
			's'           => $s,
			'orderby'     => 'relevance',
			'order'       => 'ASC',
		);

		$products   = get_posts( $args );
		$data_array = array();

		if ( ! empty( $products ) ) {

			foreach ( $products as $product ) {

				$title        = ( mb_strlen( $product->post_title ) > 50 ) ? mb_substr( $product->post_title, 0, 49 ) . '...' : $product->post_title;
				$data_array[] = array( $product->ID, $title ); // array( Post ID, Post Title )
			}
		}

		wp_send_json( $data_array );
		die();
	}//end get_products()


	public function get_categories() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( $nonce, 'afreg-ajax-nonce' ) ) {
			die( 'Failed Ajax security check!' );
		}

		$s = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';

		$args = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'name__like' => $s,
			'orderby'    => 'relevance',
			'order'      => 'ASC',
		);

		$categories = get_terms( $args );
		$data_array = array();

		if ( ! empty( $categories ) ) {

			foreach ( $categories as $category ) {

				$title        = ( mb_strlen( $category->name ) > 50 ) ? mb_substr( $category->name, 0, 49 ) . '...' : $category->name;
				$data_array[] = array( $category->term_id, $title ); // array( Post ID, Post Title )
			}
		}

		wp_send_json( $data_array );
		die();
	}//end get_categories()


	public function get_states() {

		if (isset($_POST['nonce']) && '' != $_POST['nonce']) {

			$nonce = sanitize_text_field( $_POST['nonce'] );
		} else {
			$nonce = 0;
		}

		if ( ! wp_verify_nonce( $nonce, 'afreg-ajax-nonce' ) ) {

			wp_die( esc_html__('Security Violated', 'af_custom_fields') );
		}

		if (!empty($_POST['country'])) {

			$country = sanitize_text_field($_POST['country']);
		}

		if (!empty($_POST['width'])) {

			$width = sanitize_text_field($_POST['width']);
		}

		if (!empty($_POST['name'])) {

			$name = sanitize_text_field($_POST['name']);
		}

		if (!empty($_POST['label'])) {

			$label = sanitize_text_field($_POST['label']);
		}

		if (!empty($_POST['message'])) {

			$message = sanitize_text_field($_POST['message']);
		}

		if (!empty($_POST['required'])) {

			$required = sanitize_text_field($_POST['required']);
		}

		if (!empty($_POST['af_state'])) {

			$af_state = sanitize_text_field($_POST['af_state']);
		}
		

		global $woocommerce;
		$countries_obj = new WC_Countries();
		$states        = $countries_obj->get_states( $country );
		
		if (!empty($states) && !empty($country)) {
			?>

			<p id="dropdown_state" class="form-row <?php echo esc_attr($width); ?>">
				<label for="<?php echo esc_attr($name); ?>"><?php echo esc_html__( $label, 'af_custom_fields' ); ?> 
				<?php 
				if (1 == $required) {
					?>
					<span class="required">*</span> <?php } ?>
				</label>

				<select class="js-example-basic-single af-front-fields" name="billing_state">
					<option value=""><?php echo esc_html__('Select a county / state...', 'af_custom_fields'); ?></option>

					<?php foreach ($states as $key => $value) { ?>
						<option value="<?php echo esc_attr($key); ?>" <?php echo selected($af_state, $key); ?>><?php echo esc_attr($value); ?></option>
					<?php } ?>
				</select>

				<?php if (isset($message) && ''!=$message) { ?>
					<span style="width:100%;float: left"><?php echo esc_html__($message, 'af_custom_fields'); ?></span>
				<?php } ?>
			</p>
		<?php } else { ?>
			<p id="dropdown_state" class="form-row <?php echo esc_attr($width); ?>">
				<input type="hidden" name="billing_state" value="<?php echo esc_attr($country); ?>" />
			</p>

		<?php } ?>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('.js-example-basic-single').select2();
			});
		</script>

		<?php 
		die();
	}//end get_states()
}//end class


new AF_CF_Ajax();
