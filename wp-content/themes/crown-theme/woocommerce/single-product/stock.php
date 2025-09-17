<?php
/**
 * Single Product stock.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/stock.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$locations = get_post_meta( $product->get_id(), 'locations_stock' );
$display_msg = $hide_ns_inventory = false;
$locations_quantity = '';
$low_quantity_notice =
    '<span class="location--info">' .
    '<span class="location--info__name">' . __( 'Please contact customer service for availability', 'crown_theme' ) . '</span>' .
    '</span>';
if ( Crown_Shop_Display::is_dropship_item_inventory( $product ) ) {
    $product_sku = $product->get_sku();
    $sku_inventory = Crown_Shop_Products::get_dropship_inventory_by_sku( $product_sku );
    if ( empty( $sku_inventory ) ) {
        $display_msg = true;
        $locations_quantity = $low_quantity_notice;
    } else {
        $stock_quantity = intval($sku_inventory['stock_quantity']);
        if ( $stock_quantity > 0 ) {
            $class = 'in-stock';
            $availability = $stock_quantity . ' in stock';
            $locations_quantity =
                '<span class="location--info">' .
                '<span class="location--info__name">' . wp_kses_post( $sku_inventory['location_name'] ) . '</span>: ' .
                '<span class="location--info__stock">' . wp_kses_post( $stock_quantity ) . '</span>' .
                '</span>';
        } else {
            $display_msg = true;
            $locations_quantity = $low_quantity_notice;
        }
    }
} elseif ( !empty( $locations ) ) {
    $user_division = get_user_meta( get_current_user_id(), 'ns_division_name', true );

    if ( !empty($user_division) && strtolower($user_division) == 'electrical' ) {
        $user_ns_main_location = json_decode( get_user_meta(get_current_user_id(), 'ns_main_location', true) );
        $check_backup = $display_msg = true;

        if (
            !empty($user_ns_main_location->id) && isset($locations[0][$user_ns_main_location->id]['location_reorder'])
        ) {
            $reorder_point = intval( $locations[0][$user_ns_main_location->id]['location_reorder'] );
            if ( ($reorder_point * 0.25) <= $locations[0][$user_ns_main_location->id]['location_quantity'] ) {
                $check_backup = $display_msg = false;
                $locations_quantity =
                    '<span class="location--info">' .
                    '<span class="location--info__name">' . wp_kses_post( $locations[0][$user_ns_main_location->id]['location_name'] ) . '</span>: ' .
                    '<span class="location--info__stock">' . wp_kses_post( $locations[0][$user_ns_main_location->id]['location_quantity'] ) . '</span>' .
                    '</span>';
            }
        }

        if ( $check_backup && !empty($user_ns_main_location->id) ) {
            $backup_location_id = Crown_Shop_Products::get_backup_location_for_main_location( $user_ns_main_location->id )[0]['backup_location'] ?? [];

            if (
                !empty($backup_location_id) && isset($locations[0][$backup_location_id]['location_reorder']) &&
                (intval($locations[0][$backup_location_id]['location_reorder']) * 0.25) <= $locations[0][$backup_location_id]['location_quantity']
            ) {
                $display_msg = false;
                $locations_quantity =
                    '<span class="location--info">' .
                    '<span class="location--info__name">' . wp_kses_post( $locations[0][$backup_location_id]['location_name'] ) . '</span>: ' .
                    '<span class="location--info__stock">' . wp_kses_post( $locations[0][$backup_location_id]['location_quantity'] ) . '</span>' .
                    '</span>';
            }
        }

        if ( $display_msg ) {
            $locations_quantity = $low_quantity_notice;
        }
    } else {
        foreach( $locations[0] ?? [] as $location ) {
            if ( $location['location_quantity'] > 0 ) {
                $locations_quantity .=
                    '<span class="location--info">' .
                        '<span class="location--info__name">' . wp_kses_post( $location['location_name'] ) . '</span>: ' .
                        '<span class="location--info__stock">' . wp_kses_post( $location['location_quantity'] ) . '</span>' .
                    '</span>';
            }
        }
    }
}

if ( !empty( $locations_quantity ) ) {
    $locations_header = !$display_msg ? 'Locations:' : '';
    $locations_html = '<p class="stock">' . $locations_header . $locations_quantity . '</p>';
}

if ( !$display_msg ) { ?>
    <p class="stock <?php echo esc_attr( $class ); ?>"><?php echo wp_kses_post( $availability ); ?></p>
<?php }

if ( !empty($locations_html) ) {
    echo $locations_html;
}