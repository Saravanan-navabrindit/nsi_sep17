<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$file_dir 		= wp_upload_dir();
	$folder_name 	= 'amplify-logs/amplify-products-import-manual-by-category';
	$folder_path 	= $file_dir['basedir'] . '/' . $folder_name;

	// Get all files in the folder
	$files = glob($folder_path . '/*');

	// Exclude . and .. directories
	$files = array_diff($files, array('.', '..'));

	// Sort files by modification time in descending order
	usort($files, function($a, $b) {
		return filemtime($b) - filemtime($a);
	});

	// Get the first file (which is the newest one)
	$newest_file = reset($files);
	$final_file_name = basename($newest_file);

	acf_add_local_field_group( array(
	'key' => 'group_64a975fc1d6aa',
	'title' => 'Product Category Import',
	'fields' => array(
		array(
			'key' => 'field_65a977e1e4e97',
			'label' => 'Enable categories sync',
			'name' => 'enabled_categories_sync',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'Update Amplifi categories before category synchronization.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
		array(
			'key' => 'field_64a977a1e4e77',
			'label' => 'ID category',
			'name' => 'id_category',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => 'You can view category IDs on this website <a href="https://nsi.amplifi.io/portal" target="_blank">Amplifi</a>',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_64a984101b9b8',
			'label' => 'Batch size',
			'name' => 'batch_size',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => 'Default batch size 100 items. Min 50, max 250.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'min' => 50,
			'max' => 250,
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
        array(
			'key' => 'field_64a984101b9x1',
			'label' => 'Offset',
			'name' => 'offset',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => 'Amount to skip from the array start',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_64a99acafc6d4',
			'label' => 'Created start date',
			'name' => 'created_start_date',
			'aria-label' => '',
			'type' => 'date_picker',
			'instructions' => 'Start date of created_date in YYYY-MM-DD format',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'Y-m-d',
			'return_format' => 'Y-m-d',
			'first_day' => 1,
		),
		array(
			'key' => 'field_64a99ca72de30',
			'label' => 'Created end date',
			'name' => 'created_end_date',
			'aria-label' => '',
			'type' => 'date_picker',
			'instructions' => 'End date of create date in YYYY-MM-DD format',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'Y-m-d',
			'return_format' => 'Y-m-d',
			'first_day' => 1,
		),
		array(
			'key' => 'field_64a99ccb2de31',
			'label' => 'Updated start date',
			'name' => 'updated_start_date',
			'aria-label' => '',
			'type' => 'date_picker',
			'instructions' => 'Start date of updated date in YYYY-MM-DD format',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'Y-m-d',
			'return_format' => 'Y-m-d',
			'first_day' => 1,
		),
		array(
			'key' => 'field_64a99d1f2de32',
			'label' => 'Updated end date',
			'name' => 'updated_end_date',
			'aria-label' => '',
			'type' => 'date_picker',
			'instructions' => 'End date of updated date in YYYY-MM-DD format',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'Y-m-d',
			'return_format' => 'Y-m-d',
			'first_day' => 1,
		),
		array(
			'key' => 'field_64a98cd7af906',
			'label' => 'Notice:',
			'name' => '',
			'aria-label' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '<div class="manual-sync-products__settings__logs"> <a href="' .wp_upload_dir()['baseurl'] . '/'.$folder_name.'/' . $final_file_name . '" target="_blank">View log file - ' . $final_file_name . '</a>' . file_get_contents(wp_upload_dir()['basedir'] . '/'.$folder_name.'/' . $final_file_name) . '</div>',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-product-category-import',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );

