"use strict";
import {cart_data_ajax_import} from "./exports.js";

jQuery(document).ready(function($) {
    if ( $('body.page .addify-quote-form .afrfq_import_quote_detail_pricing_btn').length > 0 ) {
        if ( jQuery('div.woocommerce-notices-wrapper').length > 1 ) {
            jQuery('div.woocommerce-notices-wrapper')[0].remove();
        }
    }
    $('body').on('click', '#afrfq_import_quote_detail_pricing_btn', function() {
        $('#afrfq_detail_pricing_import_modal').fadeIn();
    });

    $('.afrfq-close').on('click', function() {
        $('#afrfq_detail_pricing_import_modal').fadeOut();
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

    $('#afrfq_detail_pricing_parse_btn').on('click', function() {
        const $button = $(this);
        const $statusDiv = $('#afrfq_pricing_import_status');
        const $form = $('form.addify-quote-discount-form-profile');
        const $tableBody = $form.find('table.addify-quote-form__contents tbody');

        const formData = new FormData();
        const fileInput = $('#import_pricing_xls_file')[0].files[0];
        const postId = $(this).val();
        const typeValue = $(this).data('type');

        const nonce = $(this).data('nonce');

        if (!fileInput) {
            alert('Please choose a file.');
            return;
        }

        if (!nonce) {
            alert('Security token is missing. Please reload the page and try again.');
            return;
        }

        $statusDiv.html('Processing file...').show();
        $button.prop('disabled', true);

        formData.append('import_file', fileInput);
        formData.append('action', 'afrfq_import_groups_for_html_preview');
        formData.append('nonce', nonce);
        formData.append('post_id', postId);
        formData.append('type', typeValue);
        formData.append('form_data', $form.serialize());

        $.ajax({
            url: afrfq_ajax_obj.ajaxurl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    if (response.data.quote_details_table) {
                        $tableBody.html(response.data.quote_details_table);
                    } else {
                        $tableBody.html('<tr class="quote-empty-pricing-groups"><td colspan="3">No pricing groups have been added to this quote yet.</td></tr>');
                    }

                    let messagesHtml = '<p class="success-message">' + (response.data.message || 'Import successful!') + '</p>';
                    if (response.data.warnings && response.data.warnings.length > 0) {
                        messagesHtml += '<strong>Warnings:</strong><ul>';
                        $.each(response.data.warnings, function(index, warning) { messagesHtml += '<li>' + warning + '</li>'; });
                        messagesHtml += '</ul>';
                    }
                    $statusDiv.html(messagesHtml).show();

                    setTimeout(function() {
                        $('#afrfq_detail_pricing_import_modal').fadeOut();
                    }, 4000);
                } else {
                    $statusDiv.html('<p class="error-message">Error: ' + (response.data.message || 'An unknown error occurred.') + '</p>').show();
                }
            },
            error: function(xhr, status, error) {
                $statusDiv.html('<p class="error-message">An error occurred: ' + error + '</p>').show();
            },
            complete: function() {
                $button.prop('disabled', false);
            }
        });
    });

    cart_data_ajax_import($, $('#create-quote-from-copypaste'), $('#create-new-quote'), $('.create-quote--errors'), 'import_quote_copypaste', afrfq_ajax_obj.afrfq_import_nonce);
});