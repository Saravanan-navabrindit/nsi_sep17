<?php
/**
 * Pricing Group table for discount group quotes.
 *
 * @package addify-request-a-quote
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! isset( $quote_post_id ) ) {
	return;
}

$quote_pricing_groups = get_post_meta( $quote_post_id, 'quote_pricing_groups', true );
?>

<form class="addify-quote-discount-form-profile" method="post">
	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents addify-quote-form__contents" cellspacing="0">		
		<thead>
			<tr>
				<!-- <th class="product-remove">&nbsp;</th> -->
				<th class="product-name"><?php esc_html_e( 'Product Pricing Group', 'addify_rfq' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Discount Level', 'addify_rfq' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( ! empty( $quote_pricing_groups ) && is_array( $quote_pricing_groups ) ) :
				foreach ( $quote_pricing_groups as $group_id_key => $group_data ) :
					if ( empty( $group_data['group_name'] ) || empty( $group_data['price_name'] ) ) {
						continue;
					}
					?>
					<tr class="woocommerce-cart-form__quote-item cart_item" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">
						<!-- <td class="product-remove">
							<a href="#" class="remove remove-pricing-group" aria-label="<?php esc_attr_e( 'Remove this item', 'addify_rfq' ); ?>" data-group-key="<?php echo esc_attr( $group_id_key ); ?>">&times;</a>
						</td> -->
						<td class="product-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
							<?php echo esc_html( $group_data['group_name'] ); ?>
						</td>
						<td class="product-price" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
							<?php echo esc_html( $group_data['price_name'] ); ?>
						</td>

						<!-- <input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_name]" value="<?php echo esc_attr( $group_data['group_name'] ); ?>">
						<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][price_name]" value="<?php echo esc_attr( $group_data['price_name'] ); ?>">
						<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][group_id]" value="<?php echo esc_attr( $group_data['group_id'] ); ?>">
						<input type="hidden" name="pricing_groups[<?php echo esc_attr( $group_id_key ); ?>][ns_group_id]" value="<?php echo esc_attr( $group_data['ns_group_id'] ); ?>"> -->
					</tr>
					<?php
				endforeach;
			else :
				?>
				<tr class="quote-empty-pricing-groups">
					<td colspan="3"><?php esc_html_e( 'No pricing groups have been added to this quote yet.', 'addify_rfq' ); ?></td>
				</tr>
				<?php
			endif;
			?>
		</tbody>
        <!-- <tfoot>
            <tr class="addify-quote-discount-form-profile-actions">
				<td colspan="3" class="actions">
                    <div class="afrfq-actions-bar">
                        <div class="afrfq-actions-left">
                            <select id="quote-page-search-pricing-groups" style="width: 250px;"></select>
                            <button type="button" id="quote-page-add-pricing-profile" class="button">Add</button>
                            <span class="add-to-quote-group--message" style="display: block; margin-top: 10px;"></span>
                        </div>
                        <div class="afrfq-actions-right">
                            <button type="button" id="afrfq_import_quote_detail_pricing_btn" class="button afrfq_import_quote_detail_pricing_btn afrfq_import_quote_profile_btn" name="import_quote">
                                <?php esc_html_e( 'Import Pricing Groups', 'addify_rfq' ); ?>
                            </button>
                            <?php
                            $afrfq_update_button_text = get_option('afrfq_update_button_text', __( 'Submit', 'addify_rfq' ));
                            ?>
                            <button type="button" id="afrfq_update_discount_quote_profile_btn" class="button afrfq_update_discount_quote_profile_btn" name="update_quote" data-quote_id="<?php echo esc_attr($quote_post_id); ?>"><?php echo esc_html( $afrfq_update_button_text ); ?></button>
                        </div>
                    </div>

					<?php do_action( 'addify_quote_actions' ); ?>
					<?php wp_nonce_field( 'addify-cart', 'addify-cart-nonce' ); ?>
				</td>
			</tr>
        </tfoot> -->
	</table>
    <?php
    $afrfq_update_button_bg_color = get_option('afrfq_update_button_bg_color');
    $afrfq_update_button_fg_color = get_option('afrfq_update_button_fg_color');
    ?>
    <style type="text/css">
        .afrfq_update_quote_btn, .afrfq_import_quote_detail_pricing_btn, #afrfq_update_discount_quote_profile_btn {
            color: <?php echo esc_html( $afrfq_update_button_fg_color ); ?> !important;
            background-color: <?php echo esc_html( $afrfq_update_button_bg_color ); ?> !important;
        }
        .afrfq-actions-bar { display: flex; justify-content: space-between; align-items: center; }
    </style>
	<input type="hidden" id="post_id_profile" name="post_id_profile" value="<?php echo esc_attr($quote_post_id); ?>" />
	<?php do_action( 'addify_quote_contents' ); ?>
</form>

<?php do_action( 'addify_after_quote_contents' ); ?>
<?php do_action( 'addify_after_quote_table' ); ?>
<script>
jQuery(document).ready(function($) {

	$('#quote-page-search-pricing-groups').select2({
		ajax: {
			url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
			dataType: 'json',
			type: 'POST',
			delay: 250,
			data: function (params) {
				return {
					q: params.term, 
					action: 'afrfq_search_pricing_groups',
					nonce: '<?php echo esc_js( wp_create_nonce( 'afquote-ajax-nonce' ) ); ?>'
				};
			},
			processResults: function( data ) {
				var options = [];
				if ( data ) {
					$.each( data, function( index, text ) {
						options.push( { id: text[0], text: text[1]  } );
					});
				}
				return {
					results: options
				};
			},
			cache: true
		},
		placeholder: 'Search for a pricing group...',
		minimumInputLength: 3,
		allowClear: true
	});
});
</script>