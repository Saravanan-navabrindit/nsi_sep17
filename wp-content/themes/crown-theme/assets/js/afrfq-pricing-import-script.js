"use strict";
import {cart_data_ajax_import} from "./exports.js";

jQuery(document).ready(function($) {
    if ( $('body.page .addify-quote-form .afrfq_import_quote_pricing_btn').length > 0 ) {
        if ( jQuery('div.woocommerce-notices-wrapper').length > 1 ) {
            jQuery('div.woocommerce-notices-wrapper')[0].remove();
        }
    }
    $('body').on('click', '#afrfq_import_quote_pricing_btn', function() {
        $('#afrfq_pricing_import_modal').fadeIn();
    });

    $('.afrfq-close').on('click', function() {
        $('#afrfq_pricing_import_modal').fadeOut();
    });

    function makeNoticesDismissible() {
        $('.notice.is-dismissible').each(function() {
            const $el = $(this);
            if ($el.find('.notice-dismiss').length) {
                return;
            }

            const $button = $('<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>');

            $button.on('click', function(event) {
                event.preventDefault();
                $el.fadeTo(100, 0, function() {
                    $el.slideUp(100, function() {
                        $el.remove();
                    });
                });
            });

            $el.append($button);
        });
    }

    $('#afrfq_pricing_parse_btn').on('click', function() {
        const formData = new FormData();
        const fileInput = $('#import_pricing_xls_file')[0].files[0];
        const postId = $(this).val();
        const typeValue = $(this).data('type');
        const btnModal = $('#afrfq_import_quote_pricing_btn');

        const isProfileQuote = btnModal.hasClass('afrfq_import_quote_profile_btn');
        const isAdminQuote = btnModal.hasClass('afrfq_import_quote_admin_btn');

        if (!fileInput) {
            alert('Please choose a file.');
            return;
        }

        formData.append('import_pricing_xls_file', fileInput);
        formData.append('action', 'afrfq_parse_pricing_xls');
        formData.append('nonce', afrfq_ajax_obj.afrfq_import_nonce);
        formData.append('is_profile', isProfileQuote);
        formData.append('is_admin', isAdminQuote);
        if (postId) {
            formData.append('post_id', postId);
        }

        $('#afrfq_pricing_import_status').html('Processing file...').show();

        $.ajax({
            url: afrfq_ajax_obj.ajaxurl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    if (isAdminQuote && response.data.pricing_groups_html) {
                        $('#pricing-group-list').html(response.data.pricing_groups_html);
                    } 
                    
                    else if (isProfileQuote && response.data.pricing_groups_html) {
                        $('table.addify-quote-form__contents tbody').html(response.data.pricing_groups_html);
                    } 
                    
                    else {
                        // location.reload();
                    }

                    if (response.data.warnings && response.data.warnings.length > 0) {
                        let warningsHtml = response.data.message ? '<p>' + response.data.message + '</p>' : '';
                        $(response.data.warnings).each(function(index, message) {
                            warningsHtml += '<p>' + message + '</p>';
                        });
                        $('#afrfq_pricing_import_status').html(warningsHtml).show();
                    } else {
                        const successMessage = response.data.message || 'Import successful! The page will now reload.';
                        $('#afrfq_pricing_import_status').html(successMessage).show();
                        setTimeout(function() {
                            location.reload();
                        }, 2000); 
                    }

                } else {
                    $('#afrfq_pricing_import_status').html('Error: ' + (response.data.message || 'An unknown error occurred.') ).show();
                }
            },
            error: function(xhr, status, error) {
                $('#afrfq_pricing_import_status').html('An error occurred: ' + error).show();
            }
        });
    });

    cart_data_ajax_import($, $('#create-quote-from-copypaste'), $('#create-new-quote'), $('.create-quote--errors'), 'import_quote_copypaste', afrfq_ajax_obj.afrfq_import_nonce);
});