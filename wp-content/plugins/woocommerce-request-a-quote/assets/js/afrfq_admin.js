import {quote_change_recalculate_prices_listener} from "../../../../../themes/crown-theme/assets/js/exports.js";

jQuery(function($) {

	"use strict";

	if( jQuery('input#afrfq_redirect_after_submission').is(':checked') ){
		jQuery('input#afrfq_redirect_url').closest('tr').show();
	} else {
		jQuery('input#afrfq_redirect_url').closest('tr').hide();
	}

	jQuery('input#afrfq_redirect_after_submission').change(function(){

		if( jQuery(this).is(':checked') ){
			jQuery('input#afrfq_redirect_url').closest('tr').show();
		} else {
			jQuery('input#afrfq_redirect_url').closest('tr').hide();
		}

	});
	
	var ajaxurl = afrfq_php_vars.admin_url;
	var nonce   = afrfq_php_vars.nonce;

	$('.multi-select').select2({
	});

	$(document).on('click', 'a.delete-quote-item', function(event){
		const remove_button = $(this);
		const product_table = remove_button.closest('table');
		event.preventDefault();
		if( remove_button.css('opacity') == 0.2 ){
			return;
		}
		remove_button.css('opacity' ,'0.2' );
		product_table.css('pointer-events', 'none').css('opacity', '0.4');
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action     : 'afrfq_remove_product_row',
				nonce      : nonce,
				post_id    : $('input#post_ID').val(),
				form_data  : $('#addify_quote_items_table :input').serialize(),
				quote_item_id   : remove_button.data( 'quote_item_id' ),
			},
			success: function (response) {
				if( response['success'] ) {
					remove_button.closest('tr').remove();
					$( '#addify_quote_total_table' ).html(response['quote-totals']);
					$( '#addify_quote_items_table tbody' ).html(response['quote-details-table']);
				}
				product_table.css('pointer-events', 'initial').css('opacity', '1');
			},
			error: function (response) {
				remove_button.css('opacity' ,'1' );
				product_table.css('pointer-events', 'initial').css('opacity', '1');
			}
		});
	});

	$(document).on('click', '.add_option_button', function(event){
		event.preventDefault();

		var html = '<div class="option_row"><input type="text" name="afrfq_field_options[]" value=""><span type="button" title="Add Option" id="afrfq_field_add_option" class="dashicons dashicons-plus-alt2 add_option_button"></span><span type="button" title="Remove Option" class="dashicons dashicons-no-alt remove_option_button"></span></div>';
		$( html ).insertAfter( $(this).closest('div.option_row') );
	});

	$(document).on('click', '.remove_option_button', function(event){
		event.preventDefault();

		if( $(document).find( 'div.option_row' ).length > 1 ){
			$(this).closest( 'div.option_row').remove();
		}
		
	});
	
	$(document).ready( function(event) {
		var value = $('select[name="afrfq_field_type"]').val();
		$('select[name="afrfq_field_value"]').closest('tr').show();
		$('input[name="afrfq_field_placeholder"]').closest('tr').show();

		if( 'select' == value || 'multiselect' == value || 'radio' == value ) {
			$('tr.options-field').show();
			$('input[name="afrfq_file_types"]').closest('tr').hide();
			$('input[name="afrfq_file_size"]').closest('tr').hide();		
			$('textarea[name="afrfq_field_terms"]').closest('tr').hide();
		} else if( 'file' == value ) {
			$('textarea[name="afrfq_field_terms"]').closest('tr').hide();
			$('input[name="afrfq_file_types"]').closest('tr').show();
			$('input[name="afrfq_file_size"]').closest('tr').show();
			$('tr.options-field').hide();

		} else if( 'terms_cond' == value ){
			$('textarea[name="afrfq_field_terms"]').closest('tr').show();
			$('tr.options-field').hide();
			$('input[name="afrfq_file_types"]').closest('tr').hide();
			$('input[name="afrfq_file_size"]').closest('tr').hide();
			$('select[name="afrfq_field_value"]').closest('tr').hide();
			$('input[name="afrfq_field_placeholder"]').closest('tr').hide();
		} else {
			$('textarea[name="afrfq_field_terms"]').closest('tr').hide();
			$('tr.options-field').hide();
			$('input[name="afrfq_file_types"]').closest('tr').hide();
			$('input[name="afrfq_file_size"]').closest('tr').hide();
		}
	});

	$(document).on('change', 'select[name="afrfq_field_type"]', function(event){
		var value = $(this).val();

		$('select[name="afrfq_field_value"]').closest('tr').show();
		$('input[name="afrfq_field_placeholder"]').closest('tr').show();

		if( 'select' == value || 'multiselect' == value || 'radio' == value ) {
			$('tr.options-field').show();
			$('input[name="afrfq_file_types"]').closest('tr').hide();
			$('input[name="afrfq_file_size"]').closest('tr').hide();		
			$('textarea[name="afrfq_field_terms"]').closest('tr').hide();
		} else if( 'file' == value ) {
			$('textarea[name="afrfq_field_terms"]').closest('tr').hide();
			$('input[name="afrfq_file_types"]').closest('tr').show();
			$('input[name="afrfq_file_size"]').closest('tr').show();
			$('tr.options-field').hide();

		} else if( 'terms_cond' == value ){
			$('textarea[name="afrfq_field_terms"]').closest('tr').show();
			$('tr.options-field').hide();
			
			$('input[name="afrfq_file_types"]').closest('tr').hide();
			$('input[name="afrfq_file_size"]').closest('tr').hide();
			$('select[name="afrfq_field_value"]').closest('tr').hide();
			$('input[name="afrfq_field_placeholder"]').closest('tr').hide();
		} else {
			$('textarea[name="afrfq_field_terms"]').closest('tr').hide();
			$('tr.options-field').hide();
			$('input[name="afrfq_file_types"]').closest('tr').hide();
			$('input[name="afrfq_file_size"]').closest('tr').hide();
		}
		
	});

	$('#addify_add_item').click(function() {
		$('div#af-backbone-add-product-modal').show();
		$('.af-single_select-product').select2({
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				type: 'POST',
				delay: 250,
				data: function(params) {
					return {
						q: params.term,
						action: 'afrfqsearchProduct_and_variation',
						nonce: nonce
					};
				},
				processResults: function(data) {
					var options = [];
					if (data) {
						$.each(data, function(index, text) {
							options.push({ id: text[0], text: text[1] });
						});
					}
					return {
						results: options
					};
				},
				cache: true
			},
			multiple: false,
			placeholder: 'Choose Product',
			minimumInputLength: 3
		});
	});

	$('div#af-backbone-add-product-modal button#btn-ok').click( function(event){

		event.preventDefault();
		if( $(this).css('opacity') == 0.2 ){
			return;
		}
		var current_button = $(this);
		$(this).css('opacity' ,'0.2' );
		$('p.af-backbone-message').remove();

		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action     : 'afrfq_insert_product_row',
				nonce      : nonce,
				post_id    : current_button.val(),
				product_id : $('div#af-backbone-add-product-modal select.af-single_select-product').val(),
				quantity   : $('div#af-backbone-add-product-modal input[name="afacr_product_quantity"]').val(),
				form_data  : $('#addify_quote_items_table :input').serialize()
			},
			success: function (response) {
				if( response['success'] ) {
					$('div#af-backbone-add-product-modal').hide();
					current_button.removeClass('loading');
					current_button.css('opacity', '1');
					$( '#addify_quote_items_table tbody' ).html(response['quote-details-table']);
					$( '#addify_quote_total_table' ).html(response['quote-totals']);
				} else {
					$('div#af-backbone-add-product-modal table.widefat').after("<p class='af-backbone-message'>" + response['message'] + "</p>");
					current_button.removeClass('loading');
					current_button.css('opacity', '1');
				}
			},
			error: function (response) {
				jQuery(this).removeClass('loading');
				console.log( response );	
			}
		});
	});

	$(document).on('click', 'button.afrfq_update_quote_admin_btn', function (e) {
		e.preventDefault();
		let valid = true;
		$('#addify_quote_items_table input').each((elem, val) => {
			if ( !$(val).get(0).reportValidity() ) {
				valid = false;
			}
		});

		if ( !valid ) {
			return;
		}

		const current_button = $(this);
		current_button.addClass('loading').css({'opacity': '.4', 'pointer-events': 'none'});
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'afrfq_update_quote_items_profile',
				nonce: nonce,
				form_data: $('#addify_quote_items_table :input').serialize(),
				quote_id: current_button.data('quote_id'),
				type: 'admin',
			},

			success: function (response) {
				location.reload();
			},

			error: function (response) {
				location.reload();
			}
		});
	});

	$('span.af-backbone-close').click( function(){
		$('div#af-backbone-add-product-modal').hide();
	});

	$(".accordion").accordion({
		active: 'none',
		collapsible: true
	});
	
	$('.ajax_customer_search').select2({
        ajax: {
            url: ajaxurl, // AJAX URL is predefined in WordPress admin.
            dataType: 'json',
            type: 'POST',
            delay: 250, // Delay in ms while typing when to perform a AJAX search.
            data: function (params) {
                return {
                    q: params.term, // Search query.
                    action: 'afrfq_search_users', // AJAX action for admin-ajax.php.
                    nonce: nonce // AJAX nonce for admin-ajax.php.
                };
            },
            processResults: function ( data ) {
                var options = [];
                if (data ) {

                    // Data is the array of arrays, and each of them contains ID and the Label of the option.
                    $.each(
                        data, function ( index, text ) {
                            // Do not forget that "index" is just auto incremented value.
                            options.push({ id: text[0], text: text[1]  });
                        }
                    );

                }
                return {
                    results: options
                };
            },
            cache: true
        },
        multiple: false,
        placeholder: 'Choose User',
        minimumInputLength: 3 // The minimum of symbols to input before perform a search.

    });

	$('.afrfq_hide_products').select2({

		ajax: {
			url: ajaxurl, // AJAX URL is predefined in WordPress admin
			dataType: 'json',
			type: 'POST',
			delay: 250, // delay in ms while typing when to perform a AJAX search
			data: function (params) {
				return {
					q: params.term, // search query
					action: 'af_r_f_q_search_products', // AJAX action for admin-ajax.php
					nonce: nonce // AJAX nonce for admin-ajax.php
				};
			},
			processResults: function( data ) {
				var options = [];
				if ( data ) {
   
					// data is the array of arrays, and each of them contains ID and the Label of the option
					$.each( data, function( index, text ) { // do not forget that "index" is just auto incremented value
						options.push( { id: text[0], text: text[1]  } );
					});
   
				}
				return {
					results: options
				};
			},
			cache: true
		},
		multiple: true,
		placeholder: 'Choose Products',
		minimumInputLength: 3 // the minimum of symbols to input before perform a search
		
	});

	$(".namediv").click(function(){
		$(".fieldsdiv").toggle();
	});

	$(".emaildiv").click(function(){
		$(".emailfieldsdiv").toggle();
	});

	$(".companydiv").click(function(){
		$(".companyfieldsdiv").toggle();
	});

	$(".phonediv").click(function(){
		$(".phonefieldsdiv").toggle();
	});

	$(".filediv").click(function(){
		$(".filefieldsdiv").toggle();
	});

	$(".messagediv").click(function(){
		$(".messagefieldsdiv").toggle();
	});

	$(".field1div").click(function(){
		$(".field1fieldsdiv").toggle();
	});

	$(".field2div").click(function(){
		$(".field2fieldsdiv").toggle();
	});

	$(".field3div").click(function(){
		$(".field3fieldsdiv").toggle();
	});

	$('.afrfq_hide_urole').select2();

	$('#afrfq_apply_on_all_products').change(function () {
		if (this.checked) { 
			//  ^
			$('.hide_all_pro').fadeOut('fast');
		} else {
			$('.hide_all_pro').fadeIn('fast');
		}
	});

	if ($("#afrfq_apply_on_all_products").is(':checked')) {
		$(".hide_all_pro").hide();  // checked
	} else {
		$(".hide_all_pro").show();
	}

	$(".child").on("click",function() {
		$parent = $(this).prevAll(".parent");
		if ($(this).is(":checked")) {
			$parent.prop("checked",true);
		} else {
			var len = $(this).parent().find(".child:checked").length;
			$parent.prop("checked",len>0);
		}
	});
	$(".parent").on("click",function() {
		$(this).parent().find(".child").prop("checked",this.checked);
	});

	var value = $("#afrfq_rule_type option:selected").val();
	if (value == 'afrfq_for_registered_users') {
		$('#quteurr').show();
	} else {
		$('#quteurr').hide();
	}

	var value1 = $("#afrfq_is_hide_price option:selected").val();
	if (value1 == 'yes') {
		$('#hpircetext').show();
	} else {
		$('#hpircetext').hide();
	}

	var value2 = $("#afrfq_is_hide_addtocart option:selected").val();
	if (value2 == 'replace_custom' || value2 == 'addnewbutton_custom') {
		jQuery('#afcustom_link').show();
	} else {
		jQuery('#afcustom_link').hide();
	}


});

jQuery(document).ready(function($){
	
	if ( $("#afrfq_redirect_after_submission").is(':checked') ) {
		$(".URL_Quote_Submitted").show();  // checked
	} else {
		$(".URL_Quote_Submitted").hide();
	}

	$("#afrfq_redirect_after_submission").on('click' , function(){
		console.log('clicked');
		if ( $(this).is(':checked') ) {
			$(".URL_Quote_Submitted").show();  // checked
		} else {
			$(".URL_Quote_Submitted").hide();
		}
	});

	quote_change_recalculate_prices_listener(
		$,
		'#addify_quote_items_container input[name^="approved_price"]',
		'#addify_quote_items_container .quote-qty-input',
		'.approved-total',
		'.row-_approved_total th',
		'tr.item'
	);

});

function afrfq_getUserRole(value) {

	"use strict";
	if (value == 'afrfq_for_registered_users') {
		jQuery('#quteurr').show();
	} else {
		jQuery('#quteurr').hide();
	}
}

function afrfq_HidePrice(value) {

	"use strict";
	if (value == 'yes') {
		jQuery('#hpircetext').show();
	} else {
		jQuery('#hpircetext').hide();
	}
}

function getCustomURL(value) {

	"use strict";
	if (value == 'replace_custom' || value == 'addnewbutton_custom') {
		jQuery('#afcustom_link').show();
	} else {
		jQuery('#afcustom_link').hide();
	}

}

jQuery( function() {
	"use strict";
	jQuery( "#addify_settings_tabs" ).tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
});

// PRICING GROUP SECTION LOGIC
jQuery(function($) {
	function togglePricingGroupSection() {
		var quoteTypeId = '';
		var select = $('select[name="quote_type"]');
		if (select.length) {
			quoteTypeId = select.val();
		} else {
			quoteTypeId = window.quote_type_id || $('input[name="quote_type"]').val() || '';
		}
		if (!quoteTypeId) {
			$('#quote-pricing-group-section').hide();
			$('#add-product-section').show();
			$('#add-product-modal-section').show();
			return;
		}
		$.post(ajaxurl, {
			action: 'check_quote_type_discount_rule',
			quote_type_id: quoteTypeId
		}, function(response) {
			if (response.success && response.data.has_discount) {
				$('#quote-pricing-group-section').show().css('display', 'block');
				$('#quote-pricing-group-section').removeAttr('style');
				$('#add-product-section').hide();
				$('#add-product-modal-section').hide();
			} else {
				$('#quote-pricing-group-section').hide();
				$('#add-product-section').show();
				$('#add-product-modal-section').show();
			}
		});
    }
    $(document).on('change', 'select[name="quote_type"]', togglePricingGroupSection);
	$(document).ready(function() {
		togglePricingGroupSection();
	});

	$(document).ready(function() {
		var $modalWrapper = $('#af-backbone-add-pricing-group-modal-wrapper');
		if ($modalWrapper.length && !$modalWrapper.parent().is('body')) {
			$('body').append($modalWrapper);
		}
	});

	$(document).on('click', '#addify_add_pricing_group, #add-pricing-group-modal-btn', function(e) {
		e.preventDefault();
		var $modalWrapper = $('#af-backbone-add-pricing-group-modal-wrapper');
		if ($modalWrapper.length === 0) {
			console.error('Pricing group modal wrapper not found in DOM!');
			return;
		}
		$modalWrapper.css('display', 'block');
		$modalWrapper.find('.af-backbone-modal').css('display', 'block');

		$('#af-single_select-pricing-group').select2({
			ajax: {
				url: ajaxurl,
				dataType: 'json',
				type: 'POST',
				delay: 250,
				data: function(params) {
					return {
						q: params.term,
						action: 'afrfq_search_pricing_groups',
						nonce: afrfq_php_vars.nonce
					};
				},
				processResults: function(data) {
					var options = [];
					if (data) {
						$.each(data, function(index, text) {
							options.push({ id: text[0], text: text[1] });
						});
					}
					return { results: options };
				},
				cache: true
			},
			minimumInputLength: 1,
			placeholder: 'Select a group',
			allowClear: true
		});
		console.log('Pricing group modal opened');
	});

	$(document).on('click', '#af-backbone-add-pricing-group-modal .af-backbone-close', function(e) {
		e.preventDefault();
		var $modalWrapper = $('#af-backbone-add-pricing-group-modal-wrapper');
		$modalWrapper.css('display', 'none');
		$modalWrapper.find('.af-backbone-modal').css('display', 'none');
		$('#af-single_select-pricing-group').val('').trigger('change');
	});

	$(document).on('click', '.af-backbone-close', function(e) {
		e.preventDefault();
		$(this).closest('.af-backbone-modal').hide();
		$('#af-single_select-pricing-group').val('').trigger('change');
	});

	// Add pricing group to table and save via AJAX (from modal)
	$(document).on('click', '#btn-ok-pricing-group', function(e) {
		e.preventDefault();
		var select = $('#af-single_select-pricing-group');
		var groupId = select.val();
		var quoteId = window.quote_id || $('input#post_ID').val();
		if (!groupId || !quoteId) return;
		$.post(ajaxurl, {
			action: 'afrfq_insert_pricing_group_row',
			group_id: groupId,
			post_id: quoteId,
			nonce: afrfq_php_vars.nonce
		}, function(response) {
			if (response.success) {
				$('#pricing-group-list').append(response.row_html);
				select.val('').trigger('change');
				$('div#af-backbone-add-pricing-group-modal').hide();
			} else {
				alert(response.message || 'Error saving group');
			}
		});
	});

    // Add pricing group to table and save via AJAX
    $('#add-pricing-group-btn').on('click', function(e) {
        e.preventDefault();
        var select = $('#pricing-group-select');
        var groupId = select.val();
        var quoteId = window.quote_id || $('input#post_ID').val();
        if (!groupId || !quoteId) return;
		$.post(ajaxurl, {
			action: 'afrfq_insert_pricing_group_row',
			group_id: groupId,
			post_id: quoteId,
			nonce: afrfq_php_vars.nonce
		}, function(response) {
            if (response.success) {
                $('#pricing-group-list').append(response.row_html);
                select.val('').trigger('change');
            } else {
                alert(response.message || 'Error saving group');
            }
        });
    });

    // Delete pricing group row (UI and DB)
    $(document).on('click', '.delete-pricing-group', function(e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var groupId = row.data('group_id');
        var quoteId = window.quote_id || $('input#post_ID').val();
        if (!groupId || !quoteId) return;
        $.post(ajaxurl, {
            action: 'afrfq_delete_pricing_group_row',
            group_id: groupId,
            post_id: quoteId,
			nonce: afrfq_php_vars.nonce
        }, function(response) {
            if (response.success) {
                row.remove();
            } else {
                alert(response.message || 'Error deleting group');
            }
        });
    });

});

