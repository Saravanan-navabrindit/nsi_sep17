<?php
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_65144810cb7c4',
	'title' => 'Manual sync NS',
	'fields' => array(
		array(
			'key' => 'field_65144811ed708',
			'label' => 'Sync all products (inventory, quantity, price)',
			'name' => 'sync_all_products',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
        array(
            'key' => 'field_669a44bf896b9',
            'label' => 'Sync type',
            'name' => 'sync_type',
            'aria-label' => '',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'price' => 'Price',
                'inventory' => 'Inventory',
                'all' => 'All',
            ),
            'default_value' => false,
            'return_format' => 'value',
            'multiple' => 0,
            'allow_null' => 0,
            'ui' => 0,
            'ajax' => 0,
            'placeholder' => '',
        ),
		array(
			'key' => 'field_65144e1c2bef9',
			'label' => 'SKU products',
			'name' => 'sku_product_acf',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => 'Each SKU must be entered separated by a space. 
Example:	RSR-000-ND RSP-9108 WC3 RWC3Y18SH10K RWC2Y18T5K',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_65144811ed708',
						'operator' => '!=',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'rows' => '',
			'placeholder' => '',
			'new_lines' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-manual-sync-ns',
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