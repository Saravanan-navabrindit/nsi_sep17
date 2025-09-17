<?php
class Af_C_F_General_Functions {


	public static function empty_all_data_before_updation( $customer_id ) {
		$customer_id        = (int) $customer_id;
		$af_cf_args         = array(
			'posts_per_page'   => -1,
			'post_type'        => 'af_c_fields',
			'post_status'      => 'publish',
			'orderby'          => 'menu_order',
			'suppress_filters' => false,
			'order'            => 'ASC',
			'fields'           => 'ids',
		);
		$af_cf_extra_fields = get_posts($af_cf_args);

		foreach ($af_cf_extra_fields as $field_id ) {
			$field_id = (int) $field_id;
			delete_user_meta( $customer_id, 'af_c_f_additional_' . $field_id );
		}
	}//end empty_all_data_before_updation()
}//end class

new Af_C_F_General_Functions();
