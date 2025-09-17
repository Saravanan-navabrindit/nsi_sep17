<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<ul class="subsubsub">
	<li>
		<a href="?page=af-custom-fields-settings&tab=tab_five&subtab=title"  data-tab_key="title" class="<?php echo 'title' === $subtab ? 'current' : ''; ?>"><?php echo esc_html__('Fields Label', 'af_custom_fields' ); ?></a> | 
	</li>
	<li>
		<a href="?page=af-custom-fields-settings&tab=tab_five&subtab=billing" data-tab_key="billing" class="<?php echo 'billing' === $subtab ? 'current' : ''; ?>"><?php echo esc_html__('Billing Fields', 'af_custom_fields' ); ?></a> | 
	</li>
	<li>
		<a href="?page=af-custom-fields-settings&tab=tab_five&subtab=shipping" data-tab_key="shipping" class="<?php echo 'shipping' === $subtab ? 'current' : ''; ?>"><?php echo esc_html__('Shipping Fields', 'af_custom_fields' ); ?></a> | 
	</li>
</ul>

<?php
if ( 'general' === $subtab ) {

	settings_fields( 'afreg_checkout_general_fields' );
	do_settings_sections( 'afreg_checkout_general_section' );

} elseif ( 'title' === $subtab ) {
	?>
	<div id="message" class="notice notice-info">
		<p class="description"><?php esc_html_e('Street address, Town / City, State / County, Postcode / ZIP fields labels are not customizable.', 'af_custom_fields' ); ?></p>
	</div>
	<?php
	settings_fields( 'afreg_checkout_title_fields' );
	do_settings_sections( 'afreg_checkout_title_section' );

} elseif ( 'billing' === $subtab ) {

	settings_fields( 'af_checkout_billing_fields' );
	do_settings_sections( 'af_checkout_billing_fields' );

	
	include_once AF_CF_PLUGIN_DIR . 'admin/settings/billing.php';

} elseif ( 'shipping' === $subtab ) {

	settings_fields( 'af_checkout_shipping_fields' );
	do_settings_sections( 'af_checkout_shipping_fields' );
	include_once AF_CF_PLUGIN_DIR . 'admin/settings/shipping.php';
}



