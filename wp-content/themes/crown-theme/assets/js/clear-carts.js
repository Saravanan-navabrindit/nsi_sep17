"use strict";
jQuery(document).ready(function($) {

    $('body').on('click', '#afrfq_clear_quote__cart_btn', function(e) {
        e.preventDefault();
        $.post(
            afrfq_ajax_obj.ajaxurl,
            {
                action: 'clear_quotes_cart',
                nonce: afrfq_ajax_obj.afrfq_clear_cart_nonce
            },
            function (response) {
                if (response.success) {
                    localStorage.removeItem('selected_quote_type');
                    localStorage.setItem('open_myaccount_popup', '1');
                    window.location.href = '../my-account/';
                } else {
                    console.error('clear quotes call is not successfully');
                }
            }
        );
    });

    $('body').on('click', '#clear_shopping_cart__btn', function(e) {
        e.preventDefault();
        $.post(afrfq_ajax_obj.ajaxurl, {
            action: 'clear_shopping_carts',
            nonce: afrfq_ajax_obj.clear_shopping_cart_nonce
        }, function(response) {
            if (response.success) {
                location.reload();
            } else {
                console.error('clear cart call is not successfully');
            }
        });
    });
    if (localStorage.getItem('open_myaccount_popup') === '1') {
        $('#myaccount-popup').css('display', 'block');
        localStorage.removeItem('open_myaccount_popup');
    }

});
