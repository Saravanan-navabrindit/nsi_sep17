<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$target_blank_endpoints = array('stock-price-spa-request');

$has_quote_items_in_session = false;
if ( WC()->session ) {
	$quote_items = WC()->session->get( 'quotes' );
	$has_quote_items_in_session = ! empty( $quote_items ) && is_array( $quote_items );
}
?>

<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
	<ul>
		<?php
		global $addify_rfq;
		$current_user = wp_get_current_user();
		$user_roles = (array) $current_user->roles;
		$admin_id = get_original_admin_id();
		$admin_user = $admin_id ? get_userdata($admin_id) : null;
		$admin_user_roles = $admin_user ? (array) $admin_user->roles : [];

		foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<?php
				$is_manager = in_array( 'dual_shop_manager', $user_roles, true ) || in_array( 'shop_manager', $user_roles, true );
				$is_switched_manager = is_switched_customer() && ( in_array( 'dual_shop_manager', $admin_user_roles, true ) || in_array( 'shop_manager', $admin_user_roles, true ) );
				$has_selected_quote_type = get_current_user_quote_type_value();
				if ( $endpoint === 'request-a-quote' && ( $is_manager || $is_switched_manager ) && ! $has_quote_items_in_session && ! $has_selected_quote_type ) : ?>
					<a href="javascript:void(0);" class="open-new-quote-popup">
						<?php echo esc_html( $label ); ?>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"
						<?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>
						<?php if ( in_array( $endpoint, $target_blank_endpoints ) ) echo ' target="_blank"'; ?>>
						<?php echo esc_html( $label ); ?>
					</a>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
