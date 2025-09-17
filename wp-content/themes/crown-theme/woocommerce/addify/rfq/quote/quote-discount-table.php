<?php
/**
 * Pricing Group table for discount group quotes.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/addify/rfq/quote/quote-discount-table.php.
 *
 * @package addify-request-a-quote
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$price_display    = 'yes' === get_option( 'afrfq_enable_pro_price' ) ? true : false;
$of_price_display = 'yes' === get_option( 'afrfq_enable_off_price' ) ? true : false;
$colspan          = 4;
$colspan          = $price_display ? $colspan + 2 : $colspan;
$colspan          = $of_price_display ? $colspan + 2 : $colspan;
// Get the selected pricing groups from the session. Default to an empty array.
$pricing_groups = WC()->session->get( 'quote_pricing_groups', array() );
if(!empty(get_user_meta(get_current_user_id(), 'quote_pricing_groups'))) {
    $pricing_groups = get_user_meta(get_current_user_id(), 'quote_pricing_groups')[0];
}
?>

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents addify-quote-form__contents" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>
			<th class="product-name"><?php esc_html_e( 'Product Pricing Group', 'addify_rfq' ); ?></th>
			<th class="product-price"><?php esc_html_e( 'Discount Level', 'addify_rfq' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		if ( ! empty( $pricing_groups ) ) :
			foreach ( $pricing_groups as $group_id => $group_data ) :
				?>
				<tr class="woocommerce-cart-form__quote-item cart_item" data-group_id_row="<?php echo esc_attr( $group_id ); ?>">
					<td class="product-remove">
						<a href="#" class="remove remove_pricing_group_from_quote" aria-label="<?php esc_attr_e( 'Remove this item', 'addify_rfq' ); ?>" data-group_id="<?php echo esc_attr( $group_id ); ?>">&times;</a>
					</td>
					<td class="product-name" data-title="<?php esc_attr_e( 'Product Pricing Group', 'addify_rfq' ); ?>">
						<?php echo esc_html( $group_data['group_name'] ); ?>
					</td>
					<td class="product-price" data-title="<?php esc_attr_e( 'Discount Level', 'addify_rfq' ); ?>">
                        <?php echo esc_html( $group_data['price_name'] ); ?>
                        <input 
                            type="hidden" 
                            name="pricing_group_discount[<?php echo esc_attr( $group_id ); ?>]" 
                            value="<?php echo isset( $group_data['price_name'] ) ? esc_attr( $group_data['price_name'] ) : '0'; ?>" 
                        />
					</td>
				</tr>
				<?php
			endforeach;
		endif;
		?>
	</tbody>
	<tfoot>
        <td colspan="<?php echo esc_attr( ($colspan/2) ); ?>" class="actions add-to-quote-group left-cell" style="text-align: left;">
			 <div class="afrfq-actions-bar">
                        <div class="afrfq-actions-left">
            <select id="quote-page-search-pricing-groups" style="width: 250px;"></select>
            <button type="button" id="quote-page-add-pricing-group" class="button">Add</button>
            <span class="add-to-quote-group--message" style="display: block;"></span>
            <?php
            $afrfq_update_button_bg_color = get_option('afrfq_update_button_bg_color');
            $afrfq_update_button_fg_color = get_option('afrfq_update_button_fg_color');
            ?>
            <style type="text/css">
                .afrfq_update_quote_btn, .afrfq_import_quote_pricing_btn {
                    color: <?php echo esc_html( $afrfq_update_button_fg_color ); ?> !important;
                    background-color: <?php echo esc_html( $afrfq_update_button_bg_color ); ?> !important;
                }
            </style>
			</div>
			<div class="afrfq-actions-right">
            <!-- </td>
			<td colspan="<?php echo esc_attr( $colspan/2 ); ?>" class="actions extra-quote-actions right-cell"> -->
            <button type="button" id="afrfq_clear_discount_quote_btn" name="clear_discount_quotes_cart" class="button" value="Clear Quote">
                <?php esc_html_e( 'Clear Quote', 'addify_rfq' ); ?>
            </button>

            <button type="button" id="afrfq_import_quote_pricing_btn" class="button afrfq_import_quote_pricing_btn afrfq_import_quote_profile_btn" name="import_quote" value="Import Product List">
                <?php esc_html_e( 'Import Pricing Group List', 'addify_rfq' ); ?>
            </button>

            <span class="update-quote-message" style="display: block; margin-top: 10px;"></span>
			</div>
		</div>
            <?php do_action( 'addify_quote_actions' ); ?>
            <?php wp_nonce_field( 'addify-cart', 'addify-cart-nonce' ); ?>
        </td>
	</tfoot>
</table>

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

	// Handle Add Group button click
	$('body').on('click', '#quote-page-add-pricing-group', function(e) {
		e.preventDefault();
		const group_id = $('#quote-page-search-pricing-groups').val();
		const button = $(this);
		let msg = $('.add-to-quote-group--message');
		msg.fadeOut().empty();

		if (!group_id) {
			msg.html('Please select a pricing group to add.').fadeIn();
			return;
		}

		button.prop('disabled', true).text('Adding...');

		$.ajax({
			url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
			type: 'POST',
			data: {
				action: 'afrfq_add_pricing_group_to_quote',
				group_id: group_id,
				nonce: '<?php echo esc_js( wp_create_nonce( 'afquote-ajax-nonce' ) ); ?>'
			},
			success: function (response) {
				if (response.success) {
					location.reload();
				} else {
					msg.html(response.data.message || 'An error occurred.').css('color', 'red').fadeIn();
					button.prop('disabled', false).text('Add Group');
				}
			},
			error: function () {
				msg.html('A server error occurred. Please try again.').css('color', 'red').fadeIn();
				button.prop('disabled', false).text('Add Group');
			}
		});
	});

	// Handle Remove Group link click
	$('body').on('click', '.remove_pricing_group_from_quote', function(e) {
		e.preventDefault();
		const group_id = $(this).data('group_id');
        $(this).closest('tr').css('opacity', '0.5' );
		// link.closest('tr').css('opacity', '0.5');

		$.ajax({
			url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
			type: 'POST',
			data: {
				action: 'afrfq_remove_pricing_group_from_quote',
				group_id: group_id,
				nonce: '<?php echo esc_js( wp_create_nonce( 'afquote-ajax-nonce' ) ); ?>'
			},
			success: function(response) {
                 if (response.quote_empty) {
                    localStorage.removeItem('selected_quote_type');
                    localStorage.setItem('open_myaccount_popup', '1');
					location.reload();
                }

                $('div.woocommerce-notices-wrapper').html(response.message);
                $('table.addify-quote-form__contents').replaceWith(response['quote-table']);
                
                $('table.table_quote_totals').replaceWith(response['quote-totals']);
                $('li.quote-li').replaceWith(response['mini-quote']);
                
                $('li.menu-item.quote .count').text(response['quote-count']);
                
                $('body').animate({
                    scrollTop: $('div.woocommerce-notices-wrapper').offset().top - 100
                }, 500);
            },
			error: function() {
                $(this).closest('tr').css('opacity', '1');
                $('div.woocommerce-notices-wrapper').html('<div class="woocommerce-error" role="alert">An error occurred while removing the item.</div>');
            }
		});
	});

	// Handle "Clear Quote" button click for Discounts.
	$('body').on('click', '#afrfq_clear_discount_quote_btn', function() {

		const button = $(this);
		button.prop('disabled', true).addClass('loading');

		$.ajax({
			url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
			type: 'POST',
			data: {
				action: 'afrfq_clear_pricing_groups_cart',
				nonce: '<?php echo esc_js( wp_create_nonce( 'afrfq-clear-discounts-nonce' ) ); ?>'
			},
			success: function (response) {
				if (response.success) {
					localStorage.removeItem('selected_quote_type');
                    localStorage.setItem('open_myaccount_popup', '1');
                window.location.href = '../my-account/';
                    // window.location.href = '<?php echo esc_url( wc_get_page_permalink( "myaccount" ) ); ?>';
				} else {
					alert('Could not clear the quote. Please try again.');
					button.prop('disabled', false).removeClass('loading');
				}
			},
			error: function() {
				alert('A server error occurred.');
				button.prop('disabled', false).removeClass('loading');
			}
		});
	});
});
</script>