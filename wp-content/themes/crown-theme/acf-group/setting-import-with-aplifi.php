<?php

function apply_limitations_based_on_admin_user_list(array $enable_disabling_products_auto_sync): array
{
    $allow_user_email = [
        'ruslan.nemashkalo@eleks.com',
        'vitalii.nikitchyn@eleks.com',
        'zoia.rashevska@eleks.com',
        'daria.tikka@eleks.com'
    ];

    $current_user = wp_get_current_user();
    $user_email = $current_user->user_email;
    $is_input_disabled = false;
    $class_input = 'enabled';

    if (!in_array($user_email, $allow_user_email)) {
        $enable_disabling_products_auto_sync = [];
        $is_input_disabled = true;
        $class_input = 'disabled';
    }
    return array($is_input_disabled, $enable_disabling_products_auto_sync, $class_input);
}

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

    $enable_disabling_products_auto_sync = array(
		'key' => 'field_64b4f626c869a',
		'label' => 'Enable disabling products (optional)',
		'name' => 'enable_disabling_products_auto_sync',
		'aria-label' => '',
		'type' => 'true_false',
		'instructions' => 'Disabling all products that have not been added to the NSI Region.',
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_64b4f626d768a',
					'operator' => '==',
					'value' => '1',
				),
			),
		),
		'wrapper' => array(
			'width' => '33',
			'class' => '',
			'id' => '',
		),
		'message' => '',
		'default_value' => 1,
		'ui_on_text' => '',
		'ui_off_text' => '',
		'ui' => 1,
	);

    list($is_input_disabled, $enable_disabling_products_auto_sync, $class_input) = apply_limitations_based_on_admin_user_list($enable_disabling_products_auto_sync);

    acf_add_local_field_group( array(
	'key' => 'group_64b4f621d157b',
	'title' => 'Setting import with Aplifi',
	'fields' => [
		array(
			'key' => 'field_64b4f626d768a',
			'label' => 'Enabled sync',
			'name' => 'enabled__auto_sync',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => 'Enable automatic synchronization with Amplify. The settings you save below in the form are used.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
		$enable_disabling_products_auto_sync,
		array(
			'key' => 'field_64b4faa7d768b',
			'label' => 'Get collections parameters',
			'name' => 'get_collections_parameters',
			'aria-label' => '',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_64b4f626d768a',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_64b4fba8d768c',
					'label' => 'Parent ID',
					'name' => 'parent_id',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'default_value' => '9d7c4d99-4408-4b53-8df9-70ff10cc5670',
					'maxlength' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'disabled' => $is_input_disabled,
                    'class' => $class_input,
				),
				array(
					'key' => 'field_64b4fbced768d',
					'label' => 'ID NSI Default region',
					'name' => 'nsi_default_region_id',
					'aria-label' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
						'class' => '',
						'id' => '',
					),
					'default_value' => get_amplify_region_id(),
					'maxlength' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'disabled' => $is_input_disabled,
                    'class' => $class_input,
                ),
				array(
					'key' => 'field_64b4fffed7690',
					'label' => 'Updated start date',
					'name' => 'updated_start_date',
					'aria-label' => '',
					'type' => 'date_picker',
					'instructions' => 'Start date of updated date in YYYY-MM-DD format.<br>
                        Default updated dates interval is no more than 1 days.',
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
					'key' => 'field_64b50079d7691',
					'label' => 'Updated end date',
					'name' => 'updated_end_date',
					'aria-label' => '',
					'type' => 'date_picker',
					'instructions' => 'End date of updated date in YYYY-MM-DD format.<br>
Default updated dates interval is no more than 1 days.',
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
			),
		),
	],
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-setting-import-with-aplifi',
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