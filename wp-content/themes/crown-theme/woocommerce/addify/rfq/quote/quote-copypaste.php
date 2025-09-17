<?php
/**
 * Textarea for adding items to quote's cart from copypaste value
 */
?>
<h4><?php echo __( 'Paste SKUs & Quantities to Create a Quote.', 'crown-theme' ); ?></h4>
<label for="create-quote-from-copypaste">
                            <textarea class="create-quote--textarea"
                                      placeholder="SKU QUANTITY
SKU QUANTITY
SKU QUANTITY"
                                      id="create-quote-from-copypaste"></textarea>
</label>
<span style="font-size: 14px;">* Each SKU and Quantity pair must be in a new line.</span>
<div class="create-quote--actions">
    <div class="create-quote--errors"></div>
    <?php
    $quotes = WC()->session->get( 'quotes' );
    $show_clear_btn = true;

    if ( ! empty( $quotes ) && is_array( $quotes ) ) {
        foreach ( $quotes as $quote_item ) {
            if ( isset( $quote_item['quantity'] ) && intval( $quote_item['quantity'] ) !== 0 ) {
                $show_clear_btn = false;
                break;
            }
        }
    }

    if ( $show_clear_btn ) : ?>
        <button type="button"
                id="afrfq_clear_quote__cart_btn_quote_alt"
                name="request_page_clear_quotes_cart"
                class="button"
                value="Clear Quote Cart">
            <?php esc_html_e( 'Cancel Quote', 'crown-theme' ); ?>
        </button>
    <?php endif; ?>
    <button class="btn btn-primary" id="create-new-quote"><?php
        echo __( 'Add to quote', 'crown-theme' );
    ?></button>
</div>

<script>
jQuery(document).ready(function($) {

    $('body').on('click', '#afrfq_clear_quote__cart_btn_quote_alt', function() {

		const button = $(this);
		button.prop('disabled', true).addClass('loading');

		$.ajax({
			url: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
			type: 'POST',
			data: {
				action: 'request_page_clear_quotes_cart',
				nonce: '<?php echo esc_js( wp_create_nonce( 'request-page-clear-quotes-nonce' ) ); ?>'
			},
			success: function (response) {
				if (response.success) {
					localStorage.removeItem('selected_quote_type');
                    localStorage.setItem('open_myaccount_popup', '1');
                    window.location.href = '../my-account/';
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