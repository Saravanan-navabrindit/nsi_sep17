"use strict";

import {cart_data_ajax_import} from "./exports.js";

jQuery(document).ready(function($) {
    $('body').on('click', '#xls_to_cart_import_btn', function() {
        $('#xls_to_cart_import_modal').fadeIn();
    });

    $('.xls-to-cart-close').on('click', function() {
        $('#xls_to_cart_import_modal').fadeOut();
    });

    $('#cart_parse_btn').on('click', function() {
        const formData = new FormData();
        const fileInput = $('#import_cart_xls_file')[0].files[0];

        if (!fileInput) {
            alert('Please choose a file.');
            return;
        }

        formData.append('import_cart_xls_file', fileInput);
        formData.append('action', 'cart_data_import');
        formData.append('nonce', afrfq_ajax_obj.nonce);
        formData.append('datatype', 'file');

        $('#cart_import_status').html('Processing file...').show();

        $.ajax({
            url: afrfq_ajax_obj.ajaxurl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    $('#cart_import_status').html('Error: ' + response.data.message).show();
                }
            },
            error: function(xhr, status, error) {
                $('#cart_import_status').html('An error occurred: ' + error).show();
            }
        });
    });

    cart_data_ajax_import($, $('#create-cart-from-copypaste'), $('#create-new-cart'), $('.create-cart--errors'), 'cart_data_import', afrfq_ajax_obj.nonce);
});
