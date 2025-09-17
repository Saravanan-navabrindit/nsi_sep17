export function quote_change_recalculate_prices_listener($, price_input, quantity_input, subtotal_row, subtotal_quote, product_row) {
    $(document).on('change', price_input + ', ' + quantity_input, function() {
        const row = $(this).closest('tr');
        recalculate_quote_prices($, row, price_input, quantity_input, subtotal_row, subtotal_quote, product_row);
    });

}

export function cart_data_ajax_import($, textarea, action_button, errorbox, action, nonce) {
    action_button.on('click', function(e) {
        e.preventDefault();
        const textareaValue = textarea.val();
        errorbox.empty().hide();

        if(textareaValue.length < 1) {
            errorbox.html('Field above can not be empty.').show();
            return;
        }

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                'action': action,
                'import_data': textareaValue,
                'datatype': 'copypaste',
                'nonce': nonce
            },
            beforeSend: function() {
                action_button.addClass('loading');
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    errorbox.html('Error: ' + response.data.message).fadeIn(250);
                    action_button.removeClass('loading');
                }
            },
            error: function(xhr, status, error) {
                $('#cart_import_status').html('An error occurred: ' + error).show();
                action_button.removeClass('loading');
            }
        });
    });
}

function recalculate_quote_prices($, row, price_input, quantity_input, subtotal_row, subtotal_quote, product_row) {
    recalculate_quote_row($, row, price_input, quantity_input, subtotal_row);
    recalculate_quote_totals($, row, price_input, quantity_input, subtotal_row, subtotal_quote, product_row);
}

function recalculate_quote_row($, row, price_input, quantity_input, subtotal_row) {
    const requested_price = $(price_input.split(' ')[1], row).val();
    const requested_qty = $(quantity_input.split(' ')[1], row).val();
    const price_per_qty = $(price_input.split(' ')[1], row).attr('data-price-qty');
    const requested_subtotal = parseFloat((requested_price * requested_qty) / price_per_qty).toFixed(2);
    const subtotal_html =
        '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>' +
            requested_subtotal +
        '</span>';

    $(subtotal_row, row).html(subtotal_html);
}

function recalculate_quote_totals($, row, price_input, quantity_input, subtotal_row, subtotal_quote, product_row) {
    let subtotal = 0;
    $(row).parent().find(product_row).each(function (k, v) {
        const row_price = parseFloat($(subtotal_row, v).html().replace(',', '').match(/-?(?:\d+(?:\.\d*)?|\.\d+)/)[0]);
        subtotal += row_price;
    });

    const requested_total =
        '<span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>' +
        parseFloat(subtotal).toFixed(2) +
        '</span>';

    $(subtotal_quote).html(requested_total);
}