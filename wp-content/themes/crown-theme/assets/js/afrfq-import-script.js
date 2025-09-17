"use strict";
import {cart_data_ajax_import} from "./exports.js";

jQuery(document).ready(function($) {
    if ( $('body.page .addify-quote-form .afrfq_import_quote_btn').length > 0 ) {
        if ( jQuery('div.woocommerce-notices-wrapper').length > 1 ) {
            jQuery('div.woocommerce-notices-wrapper')[0].remove();
        }
    }
    $('body').on('click', '#afrfq_import_quote_btn', function() {
        $('#afrfq_import_modal').fadeIn();
    });

    $('.afrfq-close').on('click', function() {
        $('#afrfq_import_modal').fadeOut();
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

    $('#afrfq_parse_btn').on('click', function() {
        const formData = new FormData();
        const fileInput = $('#import_xls_file')[0].files[0];
        const postId = $(this).val();
        const typeValue = $(this).data('type');
        const quoteTable = $('#addify_quote_items_container');
        const importForm = $('#afrfq_import_form')[0];
        const btnModal = $('#afrfq_import_quote_btn');
        const isProfileQuote = btnModal.hasClass('afrfq_import_quote_profile_btn');
        const isAdminQuote = btnModal.hasClass('afrfq_import_quote_admin_btn');

        if (!fileInput) {
            alert('Please choose a file.');
            return;
        }

        formData.append('import_xls_file', fileInput);
        formData.append('action', 'afrfq_parse_xls');
        formData.append('nonce', afrfq_ajax_obj.afrfq_import_nonce);
        formData.append('is_profile', isProfileQuote);
        formData.append('is_admin', isAdminQuote);
        if (postId) {
            formData.append('post_id', postId);
        }
        if (typeValue) {
            formData.append('type', typeValue);
        }
        if ( isProfileQuote ) {
            formData.append('form_data', $('form.addify-quote-form-profile').serialize());
        }
        if ( isAdminQuote ) {
            formData.append('form_data', $('#addify_quote_items_table :input').serialize());
        }

        $('#afrfq_import_status').html('Processing file...').show();

        $.ajax({
            url: afrfq_ajax_obj.ajaxurl,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    if ( postId && quoteTable && response['quote-details-table'] && isAdminQuote ) {
                        if ( response['quote-details-table'] !== "placeholder" ) {
                            $( '#addify_quote_items_table tbody' ).html(response['quote-details-table']);
                        }
                        $( '#addify_quote_total_table' ).html(response['quote-totals']);
                        $('#afrfq_import_status').html('');
                        if ( response.warnings.length > 0 ) {
                            let warnings = '';
                            $(response.warnings).each(function(e, v) {
                                warnings += '<p>' + v + '</p>';
                            });

                            $('#afrfq_import_status').html(warnings).show();
                        }
                    } else if ( postId && quoteTable && response['quote-details-table'] && isProfileQuote ) {
                        if ( response['quote-details-table'] !== "placeholder" ) {
                            $( 'form.addify-quote-form-profile table tbody' ).find('tr:not(.addify-quote-form-profile-actions)').remove();
                            $( response['quote-details-table'] ).insertBefore('.addify-quote-form-profile-actions');
                            $( '.cart_totals .shop_table tbody' ).html(response['quote-totals']);
                        }
                        if ( response.warnings.length > 0 ) {
                            let warnings = '';
                            $(response.warnings).each(function(e, v) {
                                warnings += '<p>' + v + '</p>';
                            });

                            $('#afrfq_import_status').html(warnings).show();
                        }
                    } else {
                        location.reload();
                    }

                    if ( typeof response['change-status'] != 'undefined' && response['change-status'] ) {
                        jQuery('#quote_status').val('af_pending');
                    }
                } else {
                    $('#afrfq_import_status').html('Error: ' + response.data.message).show();
                }
            },
            error: function(xhr, status, error) {
                $('#afrfq_import_status').html('An error occurred: ' + error).show();
            }
        });
    });

    cart_data_ajax_import($, $('#create-quote-from-copypaste'), $('#create-new-quote'), $('.create-quote--errors'), 'import_quote_copypaste', afrfq_ajax_obj.afrfq_import_nonce);
});