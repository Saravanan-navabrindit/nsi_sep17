<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

    $file_dir 		= wp_upload_dir();
	$folder_name 	= 'amplify-logs/amplify-products-import-auto';
	$folder_path 	= $file_dir['basedir'] . '/' . $folder_name;

	// Get all files in the folder
	$files = glob($folder_path . '/*');

	// Exclude . and .. directories
	$files = array_diff($files, array('.', '..'));

	/**
	 * Limit the number of files in the array to 10.
	 *
	 * @param array $files The array of files.
	 * @return array The modified array with a maximum of 10 files.
	 */
	$files = array_slice($files, 0, 20);

	// Sort files by modification time in descending order
	usort($files, function($a, $b) {
		return filemtime($b) - filemtime($a);
	});

    $message = '<div class="manual-sync-products-import-by-category-list-log-file">';

    if(!empty($files)){
        foreach($files as $key => $file){
            $file_name = basename($file);
            $message .= $key + 1 . '] <a href="' . $file_dir['baseurl'] . '/' . $folder_name . '/' . $file_name . '" target="_blank">' . $file_name . '</a> - [ ' . date('Y-m-d H:i:s', filectime($file)) . ' ]<br><hr>';
        }
    } else {
        $message .= 'No log files found.';
    }

    $message .= '</div>';

	acf_add_local_field_group( array(
	'key' => 'group_657f98862d081',
	'title' => 'List log files: Amplifi sync',
	'fields' => array(
		array(
			'key' => 'field_657f9886aa5a8',
			'label' => 'Files in folder ' . $folder_name . ':',
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
} );

