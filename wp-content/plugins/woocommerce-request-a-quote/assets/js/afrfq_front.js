jQuery(document).ready(function () {

	"use strict";
	var ajaxUrl  = afrfq_phpvars.admin_url;
	var nonce    = afrfq_phpvars.nonce;
	var redirect = afrfq_phpvars.redirect;
	var pageurl  = afrfq_phpvars.pageurl;

	jQuery('div.menu ul').append( '<li>' + jQuery('li.quote-li a:eq(1)').text() + '</li>' );

	jQuery(document).on( 'change', '.variation_id', function (e) {

		jQuery(this).closest('form').find('button.afrfq_single_page_atc').remove();
		jQuery( '.afrfqbt_single_page' ).addClass( 'disabled wc-variation-is-unavailable' );
		jQuery( '.afrfqbt_single_page' ).show();

		if( !jQuery(this).val() ){
			return;
		}

		var variation_id = parseInt( jQuery(this).val() );
		var current_button = jQuery(this);

		jQuery.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: {
				action       : 'check_availability_of_quote',
				nonce        : nonce,
				variation_id : variation_id,
			},
			success: function ( response ) {

				if( 'disabled' == response['display'] ) {
					jQuery( '.afrfqbt_single_page' ).addClass( 'disabled wc-variation-is-unavailable' );
					jQuery( '.afrfqbt_single_page' ).show();

					if( jQuery('button.single_add_to_cart_button').length < 1 ){
						jQuery( '.afrfqbt_single_page' ).before( response['button'] );
					}

				} else if( 'disabled_swap' == response['display'] ){
					jQuery( '.afrfqbt_single_page' ).addClass( 'disabled wc-variation-is-unavailable' );
					jQuery( '.afrfqbt_single_page' ).show();
					if( jQuery('button.single_add_to_cart_button').length < 1  ){
						jQuery( '.afrfqbt_single_page' ).before( response['button'] );
					}
				} else if( 'hide' == response['display'] ){
					jQuery( '.afrfqbt_single_page' ).addClass( 'disabled wc-variation-is-unavailable' );
					jQuery( '.afrfqbt_single_page' ).hide();
					if( jQuery('button.single_add_to_cart_button').length < 1  ){
						jQuery( '.afrfqbt_single_page' ).before( response['button'] );
					}
				} else if( 'hide_swap' == response['display'] ){
					jQuery( '.afrfqbt_single_page' ).addClass( 'disabled wc-variation-is-unavailable' );
					jQuery( '.afrfqbt_single_page' ).hide();

					console.log( jQuery('button.single_add_to_cart_button').length  );

					if( jQuery('button.single_add_to_cart_button').length < 1 ){
						jQuery( '.afrfqbt_single_page' ).before( response['button'] );
					}
				} else {
					jQuery( '.afrfqbt_single_page' ).removeClass( 'disabled' );
					jQuery( '.afrfqbt_single_page' ).show();
					if( jQuery('button.single_add_to_cart_button').length < 1  ){
						jQuery( '.afrfqbt_single_page' ).before( response['button'] );
					}
				}
			},
			error: function (response) {
				current_button.removeClass('loading');
				current_button.css('opacity', '1' );
				current_button.css('border', '1px solid red' );
			}
		});

	});
	
	jQuery('.addify_converty_to_order_button button').click( function (e) {
		jQuery(this).addClass('loading');
		jQuery('table.quote_details').css( 'opacity', '0.67' );
	});

	jQuery('div.af_quote_fields input:not([type="submit"]), div.af_quote_fields textarea, div.af_quote_fields select').each( function(){

		var current_button = jQuery(this);

		if( !current_button.val() || current_button.val().length < 1 ){

			if( 'required' === current_button.attr('required')  ) {
				current_button.css('border-left', '2px solid #ca1010');
			}
		} else {
			current_button.css('border-left', '2px solid green');
		}
	});

	jQuery( document ).on( 'focusout', 'div.af_quote_fields input, div.af_quote_fields textarea, div.af_quote_fields select', function(ev) {

		var current_button = jQuery(this);

		if( !current_button.val() || current_button.val().length < 1 ){

			if( 'required' === current_button.attr('required')  ) {
				current_button.css('border-left', '2px solid #ca1010');
			}

			return;
		}

		jQuery.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: {
				action   : 'cache_quote_fields',
				nonce    : nonce,
				form_data : jQuery(this).closest('form').serialize(),
			},
			success: function (response) {
				current_button.css('border-left', '2px solid green');
			},
			error: function (response) {
				current_button.css('border-left', '2px solid #ca1010');
			}
		});
	});

	jQuery('.my_account_quotes a.download').click( function (e) {
		e.preventDefault();
		if( jQuery(this).hasClass('disabled') ){
			return;
		}
		jQuery(this).addClass('loading');
		jQuery(this).css('opacity', '0.7' );
		var current_button = jQuery(this);
		jQuery.ajax({
			url: ajaxUrl,
			type: 'POST',
			data: {
				action   : 'download_quote_in_pdf',
				nonce    : nonce,
				quote_id : current_button.data('quote_id'),
			},
			success: function (response) {
				current_button.removeClass('loading');
				current_button.addClass('loaded disabled');
				current_button.css('border', '1px solid green' );
				window.open( response );	
			},
			error: function (response) {
				current_button.removeClass('loading');
				current_button.css('opacity', '1' );
				current_button.css('border', '1px solid red' );
				
			}
		});
	});

	jQuery(document) .on('click', 'button.afrfq_update_quote_btn', function (e) {
		e.preventDefault();
		var quote_fields = jQuery('.af_quote_fields');
		/* Commented purposefully : This is causing the competitors dropdown to not load after clicking the 'Update Quote' button. */
		// quote_fields.remove();
		// if(!jQuery('form.addify-quote-form').get(0).reportValidity()) {
		// 	jQuery('form.addify-quote-form').append(quote_fields);
		// 	return;
		// }
		// jQuery('form.addify-quote-form').append(quote_fields);
		// if(!jQuery('form.addify-quote-form').get(0).reportValidity()) {
		// 	return;
		// }
		jQuery(this).addClass('loading');
		var current_button = jQuery(this);
		jQuery.ajax({

			url: ajaxUrl,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action   : 'update_quote_items',
				nonce    : nonce,
				form_data : jQuery('form.addify-quote-form').serialize(),
				quote_id : current_button.data('quote_id'),
			},

			success: function (response) {
				
				current_button.removeClass('loading');
				current_button.addClass('disabled');

				if( response['quote_empty'] ){
					localStorage.removeItem('selected_quote_type');
                    localStorage.setItem('open_myaccount_popup', '1');
					fetch(my_ajax_obj.ajax_url, {
						method: "POST",
						body: new URLSearchParams({
							action: "unset_selected_quote_type"
						}),
					}).then(response => response.json())
						.then(data => {
							window.location.href = '../my-account/';
					});
				}

				jQuery('div.woocommerce-notices-wrapper').html(response['message'] );
				jQuery('table.addify-quote-form__contents').replaceWith( response['quote-table'] );
				jQuery('table.table_quote_totals').replaceWith( response['quote-totals'] );
				jQuery('li.quote-li').replaceWith( response['mini-quote'] );
				jQuery('li.menu-item.quote .count').text( response['quote-count'] );
				jQuery('table.addify-quote-form__contents select[multiple]').select2({
					placeholder: "Select options",
					allowClear: true,
					width: '100%'
				});
				jQuery('body').animate({
			        scrollTop: jQuery('div.woocommerce-notices-wrapper').offset().top,
			    	}, 500
			    );
				
			},

			error: function (response) {
				current_button.removeClass('loading');	
				current_button.addClass('disabled');
			}
		});
	});

	jQuery(document).on('click', '.afrfqbt', function () {

		jQuery(this).closest('li').find('a.added_to_quote').remove();

		if (jQuery(this).is('.product_type_simple')) {

			var productId = jQuery(this).attr('data-product_id');
			var quantity  = 1;

			jQuery(this).addClass('loading');
			var current_button = jQuery(this);
			jQuery.ajax({
				url: ajaxUrl,
				type: 'POST',
				data: {
					action: 'add_to_quote',
					product_id: productId,
					quantity: quantity,
					nonce: nonce
				},
				success: function (response) {

					if ( 'success' == jQuery.trim(response) ) {
						if ( "yes" == redirect ) {

							window.location.href = pageurl;
						} else {

							window.location = location.href;
						}
						
					} else if( 'failed' == jQuery.trim(response) ){

						window.location = location.href;
						
					}else {

						current_button.removeClass('loading');
						current_button.after( response['view_button'] );
						jQuery('.quote-li').replaceWith(response['mini-quote']);

					}	
				}
			});

		}
		return false;
	});

});

jQuery(document).ready(function () {

	"use strict";
	var ajaxUrl  = afrfq_phpvars.admin_url;
	var nonce    = afrfq_phpvars.nonce;
	var redirect = afrfq_phpvars.redirect;
	var pageurl  = afrfq_phpvars.pageurl;
	var required = false;

	document.addEventListener('click', function (e) {
		const buttonEl = e.target.closest('.afrfqbt_single_page');

		if (!buttonEl) return;

		e.preventDefault(); // stop <a> default navigation
		
		var current_button = jQuery(buttonEl);
		current_button.closest('form').find('a.added_to_quote').remove();

		if (current_button.is('.product_type_variable')) {
			if (current_button.hasClass('disabled')) {
				return;
			}

			current_button.addClass('loading');
			jQuery.ajax({
				url: ajaxUrl,
				type: 'POST',
				data: {
					action: 'add_to_quote_single_vari',
					form_data: current_button.closest('form').serialize(),
					product_id: current_button.data('product_id'),
					nonce: nonce
				},
				success: function (response) {
					handleResponse(response, current_button);
				}
			});

		} else {
			var productId = current_button.data('product_id');
			var quantity = jQuery('.qty').val();

			current_button.addClass('loading');
			jQuery.ajax({
				url: ajaxUrl,
				type: 'POST',
				data: {
					action: 'add_to_quote_single',
					form_data: current_button.closest('form').serialize(),
					product_id: productId,
					nonce: nonce,
					source: "afrfqbt_single_page"
				},
				success: function (response) {
					handleResponse(response, current_button);
				}
			});
		}
	}, true); 	
	function handleResponse(response, current_button) {
		const user_type = current_button.data('user_type');
	    if (response && response.success === false && response.data && response.data.code) {
            current_button.removeClass('loading');

            switch (response.data.code) {
                case 'type_already_selected':
                    jQuery('.pdp-quick-view').removeClass('active');
                    jQuery('#type_already_selected_popup').addClass('active');
                    return;
            }
        }
		if (jQuery.trim(response) === 'success') {
			if(user_type && user_type == "general") {
				fetch(my_ajax_obj.ajax_url, {
					method: "POST",
					body: new URLSearchParams({
						action: "set_selected_quote_type",
						id:  current_button.data('quote_id'),
						title: current_button.data('quote_title')
					}),
				})
				.then(response => response.json())
				.then(data => {
					if (redirect === "yes") {
						window.location.href = pageurl;
					} else {
						window.location = location.href;
					}
				});
			}else {
				if (redirect === "yes") {
					window.location.href = pageurl;
				} else {
					window.location = location.href;
				}
			}
        } else if (jQuery.trim(response) === 'failed') {
            window.location = location.href;
        } else if (response && response['view_button']) {
            current_button.removeClass('loading');
            current_button.after(response['view_button']);
			jQuery('.quote-li').replaceWith(response['mini-quote']);
        } else {
            current_button.removeClass('loading');
        }
    }
	jQuery('.popup-close-button').on('click', function () {
        jQuery('#type_already_selected_popup').removeClass('active');
    });
});

jQuery(document).on('click', '.remove-quote-item', function (e) {
	"use strict";
	e.preventDefault();
	var quoteKey = jQuery(this).data('cart_item_key');
	var ajaxUrl = afrfq_phpvars.admin_url;
	var nonce   = afrfq_phpvars.nonce;
	
	jQuery(this).closest('tr').css('opacity', '0.5' );

	jQuery.ajax({
		url: ajaxUrl,
		type: 'POST',

		data: {
			action: 'remove_quote_item',
			quote_key: jQuery(this).data('cart_item_key'),
			nonce: nonce
		},
		success: function (response) {

			if( response['quote_empty'] ){
				localStorage.removeItem('selected_quote_type');
                localStorage.setItem('open_myaccount_popup', '1');
				location.reload();
			}

			jQuery('div.woocommerce-notices-wrapper').html(response['message'] );
			jQuery('table.addify-quote-form__contents').replaceWith( response['quote-table'] );
			jQuery('table.table_quote_totals').replaceWith( response['quote-totals'] );
			jQuery('li.quote-li').replaceWith( response['mini-quote'] );
			jQuery('li.menu-item.quote .count').text( response['quote-count'] );
			jQuery('body').animate({
		        scrollTop: jQuery('div.woocommerce-notices-wrapper').offset().top,
		    	}, 500
		    );
		}
	});
});

jQuery(document).on('click', '.quote-remove', function (event) {
	"use strict";
	event.preventDefault();
	var quoteKey = jQuery(this).data('cart_item_key');
	var ajaxUrl = afrfq_phpvars.admin_url;
	var nonce   = afrfq_phpvars.nonce;
	
	jQuery(this).closest('li.mini_quote_item').css('opacity', '0.5' );

	jQuery.ajax({
		url: ajaxUrl,
		type: 'POST',
		data: {
			action: 'remove_quote_item',
			quote_key: jQuery(this).data('cart_item_key'),
			nonce: nonce
		},
		success: function (response) {

			jQuery('div.woocommerce-notices-wrapper').html(response['message'] );
			jQuery('table.addify-quote-form__contents').replaceWith( response['quote-table'] );
			jQuery('table.table_quote_totals').replaceWith( response['quote-totals'] );
			jQuery('li.quote-li').replaceWith( response['mini-quote'] );
			jQuery('li.menu-item.quote .count').text( response['quote-count'] );
		}
	});
});
