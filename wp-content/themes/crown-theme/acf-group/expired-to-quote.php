<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_646114fd5b223',
	'title' => 'Setting to change Quote status to Expired',
	'fields' => array(
		array(
			'key' => 'field_646117596e224',
			'label' => 'Time for Expired status (days)',
			'name' => 'acf_expired_to_quote',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => 'The time after which the Quote will change to the "Expired" status.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '60',
			'maxlength' => '',
			'placeholder' => '30',
			'prepend' => '',
			'append' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-settings-expired-status',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );