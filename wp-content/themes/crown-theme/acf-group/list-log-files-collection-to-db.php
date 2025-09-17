<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

    $file_dir 		= wp_upload_dir();
	$folder_name_manual_sku = 'amplify-logs/amplify-products-import-manual-by-sku';
	$folder_name_manual_category = 'amplify-logs/amplify-products-import-manual-by-category';
	$folder_path_sku = $file_dir['basedir'] . '/' . $folder_name_manual_sku;
	$folder_path_category = $file_dir['basedir'] . '/' . $folder_name_manual_category;

	// Get all files in the folder
	$files_sku = glob($folder_path_sku . '/*');
	$files_category = glob($folder_path_category . '/*');

	// Exclude . and .. directories
	$files_sku = array_diff($files_sku, array('.', '..'));
	$files_category = array_diff($files_category, array('.', '..'));

    //limit number of files to 10 per type
	$files_sku = array_slice($files_sku, 0, 10);
	$files_category = array_slice($files_category, 0, 10);

	// Sort files by modification time in descending order
	usort($files_sku, function($a, $b) {
		return filemtime($b) - filemtime($a);
	});
    usort($files_category, function($a, $b) {
		return filemtime($b) - filemtime($a);
	});

    $message = '<div class="products-import-from-collection-to-db-list-log-file">';
    $message_content = '';
    foreach($files_sku ?? [] as $key => $file){
        $file_name = basename($file);
        $message_content .= 'SKU import ' . $key + 1 . '] <a href="' . $file_dir['baseurl'] . '/' . $folder_name_manual_sku . '/' . $file_name . '" target="_blank">' . $file_name . '</a> - [ ' . date('Y-m-d H:i:s', filectime($file)) . ' ]<br><hr>';
    }

    foreach($files_category ?? [] as $key => $file){
        $file_name = basename($file);
        $message_content .= 'Category import ' . $key + 1 . '] <a href="' . $file_dir['baseurl'] . '/' . $folder_name_manual_category . '/' . $file_name . '" target="_blank">' . $file_name . '</a> - [ ' . date('Y-m-d H:i:s', filectime($file)) . ' ]<br><hr>';
    }

    if ( empty($message_content) ) {
        $message = 'No log files found.';
    }

    $message .= $message_content;
    $message .= '</div>';

	acf_add_local_field_group( array(
	'key' => 'group_657f597671d081',
	'title' => 'List log files: Collections to DB import',
	'fields' => array(
		array(
			'key' => 'field_657r9409aa3a1',
			'label' => 'Files in folders ' . $folder_name_manual_sku . ' & ' . $folder_name_manual_category . ':',
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
			'message' => $message,
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
	'menu_order' => 2,
	'position' => 'normal',
	'style' => 'closed',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
	) );

	acf_add_local_field_group( array(
		'key' => 'group_657f597671d082',
		'title' => 'List log files: Collections to DB import',
		'fields' => array(
			array(
				'key' => 'field_657r9409aa3a2',
				'label' => 'Files in folders ' . $folder_name_manual_sku . ' & ' . $folder_name_manual_category . ':',
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
				'message' => $message,
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-setting-import-with-aplifi',
				),
			),
		),
		'menu_order' => 2,
		'position' => 'normal',
		'style' => 'closed',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	) );
} );

