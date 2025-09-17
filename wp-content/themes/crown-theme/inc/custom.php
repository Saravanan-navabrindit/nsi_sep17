<?php

add_action( 'add_meta_boxes', 'crown_add_quote_metaboxes' );
add_action( 'init', 'crown_create_additional_tables' );

function crown_add_quote_metaboxes() {
    crown_add_remove_quote_metabox();
}

function crown_add_remove_quote_metabox() {
    add_meta_box(
        'crown-quote-delete-post',
        esc_html__('Remove quote', 'crown-theme'),
        'crown_remove_quote_post_callback',
        'addify_quote',
        'side',
        'low'
    );
}

function crown_remove_quote_post_callback( $post ) {
    ?>
    <label for="crown-quote-delete-post-confirm"><input type="checkbox" id="crown-quote-delete-post-confirm" value="yes" /> Confirm that you want to remove quote</label>
    <div class="button" id="crown-quote-delete-post-button"
         data-quote-id="<?php echo $post->ID; ?>"
         style="margin-top: 25px; background-color: #b32d2e; border-color: #b32d2e; color: #fff;"
    >REMOVE</div>
    <p class="crown-quote-delete-post-messages" style="display: none; color: #f00; font-weight: 600;"></p>
    <?php
}

add_action( 'wp_ajax_crown_remove_quote', 'crown_remove_quote' );
add_action( 'wp_ajax_nopriv_crown_remove_quote', 'crown_remove_quote' );
function crown_remove_quote() {
    if ( !isset($_POST['quote_id']) ) {
        echo json_encode( [
            'status' => 'error',
            'message' => 'Quote ID missing'
        ] );
        die();
    }

    $quote_id = sanitize_text_field( $_POST['quote_id'] );
    if ( get_post_type($quote_id) != 'addify_quote' ) {
        echo json_encode( [
            'status' => 'error',
            'message' => 'Wrong Quote ID'
        ] );
        die();
    }

    $result = wp_delete_post( $quote_id, true );

    echo $result
        ? json_encode( ['status' => 'success', 'redirect' => admin_url('edit.php?post_type=addify_quote')] )
        : json_encode( ['status' => 'error','message' => 'Something went wrong, please try again'] );

    die();
}

add_filter( 'woocommerce_my_account_my_orders_actions', 'crown_remove_unwanted_order_listing_actions', 10, 2 );
function crown_remove_unwanted_order_listing_actions( $actions, $order ) {
    if ( array_key_exists('pay', $actions) ) {
        unset( $actions['pay'] );
    }

    if ( array_key_exists('cancel', $actions) ) {
        unset( $actions['cancel'] );
    }

    return $actions;
}

add_action( 'admin_menu', 'crown_init_admin_menu_additional_pages' );

function crown_init_admin_menu_additional_pages() {
    if ( is_user_logged_in() && wp_get_current_user()->roles[0] === 'administrator' ) {
        add_submenu_page(
            'edit.php?post_type=product',
            'Display Attributes',
            'Display Attributes',
            'edit_posts',
            'display_attributes',
            'crown_product_attributes_to_display_callback',
            99
        );
    }
}

function crown_product_attributes_to_display_callback() {
    if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set-attributes-to-display']) ) {
        $attributes_settings = crown_get_product_attributes_settings();
        $post_active = $_POST['attributes_active'];
        $post_names = $_POST['attributes_names'];
        foreach ( $attributes_settings as $label => $data ) {
            if ( empty($post_active[$label]) ) {
                continue;
            }

            $is_active = $post_active[$label] == 'active' ? 1 : 0;
            $display_name = $post_names[$label] ?? '';

            if ( $is_active != $data->is_active || $display_name != $data->display_name ) {
                crown_update_product_attribute_setting( $label, $is_active, $display_name );
            }

            unset( $post_active[$label] );
            unset( $post_names[$label] );
        }

        $atts_to_insert = [];
        foreach ( $post_active as $label => $status ) {
            if ( !empty($status) ) {
                $atts_to_insert[$label] = [
                    'is_active' => $status == 'active' ? 1 : 0,
                ];
            }
        }

        foreach ( $post_names as $attrib => $name ) {
            if ( !empty($name) ) {
                $atts_to_insert[$attrib] = [
                    'display_name' => $name,
                ];
            }
        }

        foreach ( $atts_to_insert as $label => $value ) {
            crown_insert_product_attribute_setting( $label, $value['is_active'] ?? 0, $value['display_name'] ?? '' );
        }
    }

    $attributes_settings = crown_get_product_attributes_settings();
    $attributes = wc_get_attribute_taxonomies();
    crown_render_attributes_form( $attributes, $attributes_settings );
}

function crown_render_attributes_form( $attributes, $attributes_settings ) {
    $replacements = array(
        '/^Gtin$/' => 'GTIN',
        '/^Upc$/' => 'UPC',
        '/^Ean$/' => 'EAN',
        '/^Unspsc$/' => 'UNSPSC',
        '/^Poe$/' => 'POE'
    );

    ?>
    <div class="wrap">
        <h1>Attributes to Display</h1>
        <div class="page--display-attributes">
            <form method="post" action="">
                <ul class="row row--header">
                    <li class="col--select">Display</li>
                    <li class="col--name-raw">Attribute label</li>
                    <li class="col--default-name">Default display name</li>
                    <li class="col--display-name">Display name</li>
                </ul>

                <?php
                foreach( $attributes as $id => $attrib ) {
                    $display_name = ucwords( preg_replace( '/\s*_\s*/', ' ', $attrib->attribute_label ) );
                    $display_name = preg_replace( array_keys( $replacements ), array_values( $replacements ), $display_name );
                    $attribute_label = strtolower($attrib->attribute_label);
                    $is_active = '';
                    if ( isset($attributes_settings[$attribute_label]->is_active) ) {
                        if ( $attributes_settings[$attribute_label]->is_active == 1 ) {
                            $is_active = 'active';
                        } else if ( $attributes_settings[$attribute_label]->is_active == 0 ) {
                            $is_active = 'inactive';
                        }
                    }
                    ?>
                    <ul class="row">
                        <li class="col--select">
                            <select name="attributes_active[<?php echo $attribute_label;?>]">
                                <option></option>
                                <option value="active"<?php echo $is_active == 'active' ? ' selected' : '';?>>Visible</option>
                                <option value="inactive"<?php echo $is_active == 'inactive' ? ' selected' : '';?>>Hidden</option>
                            </select>
                        </li>
                        <li class="col--name-raw"><?php echo $attribute_label;?></li>
                        <li class="col--default-name"><?php echo $display_name;?></li>
                        <li class="col--display-name">
                            <input type="text" name="attributes_names[<?php echo $attribute_label;?>]"
                                   value="<?php echo $attributes_settings[$attribute_label]->display_name ?? '';?>"
                            />
                        </li>
                    </ul>
                <?php } ?>

                <input type="submit" name="set-attributes-to-display" id="submit" class="button button-primary" value="Set attributes to display">
            </form>
        </div>
    </div>
    <?php
}

function crown_get_product_attributes_settings() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'product_attributes_settings';
    $attribute_settings = $wpdb->get_results( "SELECT * FROM $table_name" );

    $return = array();
    foreach( $attribute_settings as $setting ) {
        $return[$setting->attribute_name] = $setting;
    }

    return $return;
}

function crown_update_product_attribute_setting( $attribute_name, $is_active = 1, $display_name = '' ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'product_attributes_settings';
    $wpdb->query( $wpdb->prepare( "UPDATE $table_name SET is_active = %d, display_name = %s WHERE attribute_name = %s",
        $is_active, $display_name, $attribute_name )
    );
}

function crown_insert_product_attribute_setting( $attribute_name, $is_active = 1, $display_name = '' ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'product_attributes_settings';
    $wpdb->query( $wpdb->prepare( "INSERT INTO $table_name
        (`attribute_name`, `is_active`, `display_name`) VALUES ('%s', %d, '%s')",
        $attribute_name, $is_active, $display_name
    ));
}

function crown_create_additional_tables() {
    global $wpdb;

    $product_attributes_settings_table = get_option( 'product_attributes_settings_table_created' );
    if( !$product_attributes_settings_table ) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "product_attributes_settings (
                    `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                    `attribute_name` varchar(255) NOT NULL,
                    `is_active` tinyint(1) NOT NULL,
                    `display_name` varchar(255) NOT NULL,
                    PRIMARY KEY (id)
                ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        update_option( 'product_attributes_settings_table_created', true );
    }
}

function crown_get_zone_shipping_methods( $zone_id ) {
    $zone = new WC_Shipping_Zone( $zone_id );
    $methods_zone   = $zone->get_shipping_methods();
    $shipping_methods = array();
    foreach ( $methods_zone as $method ) {
        $shipping_methods[ $method->get_rate_id() ] = [
            'title' => $method->get_title(),
            'label' => $method->instance_settings['title_override'],
        ];
    }

    return $shipping_methods;
}

function do_replace_category_pages_with_hawksearch() {
    $is_replace_categories = defined( 'HAWKSEARCH_ENABLE_CATEGORY_HIERARCHY_LINKS' ) ? HAWKSEARCH_ENABLE_CATEGORY_HIERARCHY_LINKS : false;
    return $is_replace_categories;

    //checkbox in wp-admin if needed - import acf file first
//    $is_replace_categories = get_field( 'nsi_replace_category_pages_with_hawksearch', 'option' );
//    return isset( $is_replace_categories[0] ) && $is_replace_categories[0] === 'yes';
}