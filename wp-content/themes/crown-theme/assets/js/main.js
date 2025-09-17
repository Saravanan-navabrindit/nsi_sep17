"use strict";
import {activateSpinner} from "./auxiliary.js";
import {quote_change_recalculate_prices_listener} from './exports.js';

(function($) {
	var stickyHeaderScrollTracker = 0;
	var keepStickyHeaderHidden = false;

	var stickyHeaderData = {
		scrollTopDelay: 100,
		scrollUpDelay: 40,
		prevScrollTop: 0,
		furthestScrollDown: 0,
		height: 0,
		topOffset: 0
	};

	$(function() {

		$.wptheme.initHeader();
		$.wptheme.initMobileMenu();
		$.wptheme.initSliders();
		$.wptheme.initGatedContent();
		$.wptheme.initSiteAnnouncement();

		$(document).on('gform_post_render', function(event, form_id, current_page){
			setTimeout(function() { $(window).trigger('orientationchange'); }, 0);
		});

	});

	$(window).load(function() {
		// console.log('Hello from main.js');
	});

	$.wptheme = (function(wptheme) {

		wptheme.initHeader = function() {

			var header = $('#header');
			// if(first_section.is('.wp-block-crown-blocks-webinar-header.text-color-light')) header.addClass('text-color-light');
			header.addClass('loaded');

			var adjustSubMenus = function() {
				var windowWidth = $('body').width();
				var gap = 10;
				$('#header-primary-navigation-menu > li > .sub-menu-container').each(function(i, el) {
					var subMenu = $(el);
					subMenu.css({ marginLeft: 0 });
					if(subMenu.offset().left + subMenu.outerWidth() > windowWidth - gap) {
						subMenu.css({ marginLeft: (windowWidth - (subMenu.offset().left + subMenu.outerWidth()) - gap) + 'px' });
					}
				});
			};

			adjustSubMenus();
			$(window).on('load', adjustSubMenus);
			$(window).on('resize', adjustSubMenus);

			// activate sub-menus on hover
			$('#header-primary-navigation-menu > li').hover(
				function() {
					var menuItem = $(this).closest('.menu-item');
					var subMenu = $('> .sub-menu-container', menuItem);
					$('#header-primary-navigation-menu > .menu-item.active').not($(this).parents('.menu-item.active')).removeClass('active');
					if (subMenu.length && !menuItem.hasClass('active')) {
						menuItem.addClass('active');
					}
				},
				function() {
					$(this).removeClass('active');
				}
			);

			$('#header-primary-navigation-menu .industry-menu .products .menu-tree .menu a').hover(
				function(e) {
					var menuItem = $(this).closest('.menu-item');
					var tree = menuItem.closest('.menu-tree');
					var menuId = menuItem.data('menu');
					var subMenu = $('.sub-menu.parent-menu-' + menuId, tree);
					if(subMenu.length && !subMenu.hasClass('active')) {
						$('.sub-menu.active', tree).removeClass('active');
						$('.menu .menu-item.active', tree).removeClass('active');
						subMenu.addClass('active');
						menuItem.addClass('active');
					}
				}
			);

			var header_search_input = $('#header-navigation form.search-form .search-field');
			header_search_input.after('<ul class="quick-results"></ul>');
			header_search_input.on('keyup', function(e) {
				var val = $(this).val();
				$.get(crownThemeData.ajaxUrl, { action: 'search_products_by_sku', s: val }, function(response) {
					var quick_results = $('#header-navigation form.search-form .quick-results');
					var header_search_input = $('#header-navigation form.search-form .search-field');
					if(header_search_input.val() == response.query) {
						quick_results.html('');
						if(response.results.length) {
							quick_results.addClass('has-results');
						} else {
							quick_results.removeClass('has-results');
						}
						for(var i = 0; i < response.results.length; i++) {
							var item = response.results[i];
							quick_results.append('<li><a href="' + item.url + '">' + item.sku + '</a></li>');
						}
					}
				}, 'json');
			});

		};

		wptheme.initMobileMenu = function() {

			$(document).on('click', '#mobile-menu-toggle', function(e) {
				var body = $('body');
				if(body.is('.mobile-menu-active')) {
					$(document).trigger('close-mobile-menu');
				} else {
					body.addClass('mobile-menu-active');
				}
			});

			$(document).on('click', '#mobile-menu-close', function(e) {
				$(document).trigger('close-mobile-menu');
			});

			$(document).on('touchstart click', 'body.mobile-menu-active #page', function(e) {
				if($(e.target).closest('#mobile-menu-toggle').length) return;
				$(document).trigger('close-mobile-menu');
			});

			$(document).on('close-mobile-menu', function() {
				var body = $('body');
				body.removeClass('mobile-menu-active');
			});

			$('#mobile-menu-primary-navigation .menu-item').each(function(i, el) {
				var menuItem = $(this);
				var subMenu = $('> .sub-menu', menuItem);
				if(subMenu.length) {
					menuItem.addClass('menu-item-has-sub-menu');
					menuItem.append('<button type="button" class="toggle">Toggle</button>');
				}
			});

			$('#mobile-menu-primary-navigation').on('click', 'button.toggle', function(e) {
				var menuItem = $(this).closest('.menu-item');
				var subMenu = $('> .sub-menu', menuItem);
				if(!menuItem.hasClass('active')) {
					menuItem.addClass('active');
					var startHeight = subMenu.outerHeight();
					subMenu.css({ height: 'auto' });
					var endHeight = subMenu.outerHeight();
					subMenu.css({ height: startHeight });
					setTimeout(function() { subMenu.css({ height: endHeight }); }, 10);
					setTimeout(function() { subMenu.css({ height: 'auto' }); }, 210);
				} else {
					menuItem.removeClass('active');
					var startHeight = subMenu.outerHeight();
					var endHeight = 0;
					subMenu.css({ height: startHeight });
					setTimeout(function() { subMenu.css({ height: endHeight }); }, 10);
				}
			});

			$('#mobile-menu-primary-navigation .menu-item-has-sub-menu.current-menu-item, #mobile-menu-primary-navigation .menu-item-has-sub-menu.current-menu-ancestor').each(function(i, el) {
				$('> .toggle', el).trigger('click');
			});

			$('#mobile-menu-search-toggle').on('click', function(e) {
				var form = $('#mobile-menu .search-form');
				form.toggleClass('active');
				if(form.hasClass('active')) {
					setTimeout(function() {
						$('input[type=search]', form).select();
					}, 10);
				}
			});

		};

		wptheme.initSliders = function() {

				$('.wp-block-gallery').slick({
					draggable: true,
					arrows: true,
					slidesToShow: 4,
					slidesToScroll: 1,
					mobileFirst: true,
					responsive: [
						{
							breakpoint: 1024,
							settings: {
								slidesToShow: 4
							}
						},
						{
						  breakpoint: 992,
						  settings: {
							slidesToShow: 3
						  }
						},
						{
							breakpoint: 600,
							settings: {
							  slidesToShow: 2
							}
						},
						{
							breakpoint: 320,
							settings: {
							  slidesToShow: 1
							}
						}
					]
				  });


			$('.wp-block-crown-blocks-testimonial-slider > .inner > .testimonials > .inner').slick({
				arrows: true,
				dots: false,
				adaptiveHeight: true
			});

			$('.wp-block-crown-blocks-product-slider > .inner > .post-feed > .inner').on('setPosition', function(event, slick) {
				var track = $('.slick-track', slick.$slider);
				var slides = $('.slick-slide', slick.$slider);
				slides.css({ height: 'auto' });
				slides.css({ height: track.height() });
			}).slick({
				arrows: true,
				dots: false,
				slidesToShow: 2,
				slidesToScroll: 2,
				mobileFirst: true,
				responsive: [
					{
						breakpoint: 768 - 1,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3
						}
					},
					{
						breakpoint: 992 - 1,
						settings: {
							slidesToShow: 4,
							slidesToScroll: 4
						}
					}
				]
			});

			$('.wp-block-crown-blocks-portal-link-grid > .inner > .grid-columns > .inner').slick({
				arrows: false,
				dots: false,
				slidesToShow: 2,
				slidesToScroll: 2,
				mobileFirst: true,
				responsive: [
					{
						breakpoint: 768 - 1,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3
						}
					},
					{
						breakpoint: 992 - 1,
						settings: {
							slidesToShow: 4,
							slidesToScroll: 4,
							arrows: true,
						}
					}
				]
			});

			$('.wp-block-crown-blocks-tabbed-content:not(.type-grid):not(.type-accordion)').each(function(i, el) {
				var slider = $('.tabbed-content-tabs > .inner', el);
				if(slider.hasClass('slick-initialized')) return;
				var sliderNavContainer = $('<div class="slick-slider-nav"></div>');
				$('.tabbed-content-tabs', el).before(sliderNavContainer);
				slider.children().wrap('<div></div>');
				var slickSettings = {
					mobileFirst: true,
					draggable: false,
					dots: true,
					arrows: false,
					fade: true,
					appendDots: sliderNavContainer,
					adaptiveHeight: true,
					customPaging: function(slider, pageIndex) {
						var tabTitleEl = $('> .wp-block-crown-blocks-tabbed-content-tab > .inner > .tab-header > .tab-title', slider.$slides[pageIndex]);
						var tabDescEl = $('> .wp-block-crown-blocks-tabbed-content-tab > .inner > .tab-header > .tab-description', slider.$slides[pageIndex]);
						var title = tabTitleEl.length ? tabTitleEl.text() : '';
						var description = tabDescEl.length ? tabDescEl.text() : '';
						var tab = $('<button type="button"></button');
						tab.append('<span class="index">' + (pageIndex + 1) + '<span>');
						if(title != '') tab.append(' <span class="title">' + title + '<span>');
						if(description != '') tab.append(' <span class="description">' + description + '<span>');
						tab.append(' <span class="indicator"><span></span></span>');
						return tab;
					}
				};
				slider.slick(slickSettings);
			});

		};

		wptheme.initGatedContent = function() {
			var mainArticleGated = $('#main-article-gated');
			var mainArticle = $('#main-article');
			if(!mainArticleGated.length) return;

			var confirmation = $('.gform_confirmation_wrapper', mainArticleGated);

			if(confirmation.length) {
				var formId = confirmation.attr('id').replace(/^gform_confirmation_wrapper_/, '');
				setCookie('gated_content_form_' + formId, 1, 30);
				mainArticleGated.remove();
			} else {
				var form = $('.gform_wrapper form', mainArticleGated);
				var formId = form.attr('id').replace(/^gform_/, '');
				if(getCookie('gated_content_form_' + formId)) {
					mainArticleGated.remove();
				} else {
					mainArticleGated.show();
				}
			}

		};

		wptheme.initSiteAnnouncement = function() {

			$(document).on('click', '#site-announcement button.dismiss', function(e) {
				var announcement = $('#site-announcement');
				announcement.removeClass('shown');
				setTimeout(function() { announcement.addClass('active'); }, 500);
				var id = announcement.data('announcement-id');
				setCookie('site_announcement_' + id, 'dismissed', 365);
			});

			var adjustAnnouncement = function() {
				var announcement = $('#site-announcement');
				if(announcement.length && announcement.hasClass('active')) {
					var height = announcement.outerHeight();
					announcement.css({ marginTop: -height });
				}
			};

			var announcement = $('#site-announcement');
			if(announcement.length) {
				var id = announcement.data('announcement-id');
				var status = getCookie('site_announcement_' + id);
				if(status != 'dismissed') {
					announcement.addClass('active');
					setTimeout(function() { announcement.addClass('shown'); }, 500);
					adjustAnnouncement();
					$(window).on('load resize', adjustAnnouncement);
				}
			}

		};

		return wptheme;

	})({});

})(jQuery);

function setCookie(name, value, days, path) {
	path = typeof path !== 'undefined' ? path : '/';
	var expires = "";
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days*24*60*60*1000));
		expires = "; expires=" + date.toUTCString();
	}
	document.cookie = name + "=" + (value || "")  + expires + "; path=" + path;
}
function getCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

//Temporary fix for Woocommerce grammar label
const addToCartSelector = 'button.single_add_to_cart_button.button';
jQuery(document).ready(() => {
	if(!jQuery(addToCartSelector)) {
		return false;
	}
		jQuery(addToCartSelector).text("Add to Cart");
	}
)
jQuery(addToCartSelector).click({selector: addToCartSelector, classes: ['loading']}, activateSpinner);

const trimCheckoutInputsOnSubmit = () => {
	const formCheckout = document.querySelector('#main-content form.checkout.woocommerce-checkout');
	const checkoutOrderFieldsValues = document.querySelectorAll('form.checkout.woocommerce-checkout input[type="text"]');

	formCheckout && formCheckout.addEventListener('submit', () => {
			checkoutOrderFieldsValues.forEach(field => {
				field.value = field.value && field.value.trim();
			});
		}
	)
}

trimCheckoutInputsOnSubmit();

jQuery(document).ready(function($){
	const orderComments = $('#order_comments');
	const charsLeft = $('.order_comments_details_chars_left');
	const maxLength = orderComments.attr('maxlength');

	function updateCharsLeft() {
		const currentLength = orderComments.val() && orderComments.val().length;
		const charsRemaining = maxLength - currentLength;

		if (charsRemaining <= 10) {
			charsLeft.addClass('chars-left-warning');
			charsLeft.text(charsRemaining + ' characters remaining');
		} else {
			charsLeft.removeClass('chars-left-warning');
			charsLeft.text(currentLength + ' characters (maximum ' + maxLength + ' characters)');
		}
	}
	updateCharsLeft();
	orderComments.on('input', updateCharsLeft);

	$( document ).on( 'wc_update_cart added_to_cart removed_from_cart updated_cart_totals wc_cart_emptied', function (e) {
		$.ajax( {
			url: crownThemeData.ajaxUrl,
			method: 'POST',
			data: {
				'action': 'calculate_cart_items_amount',
			},
			success: response => {
				const responseObject = JSON.parse(response);
				$('li.menu-item.cart .count').text( responseObject.cart_count );
			}
		} );
	} );
});

jQuery(document).ready(function ($) {
	const disableControls = (e) => {
		$('body').addClass('disable-controls');
		$('input,select').prop('disabled', true);
		e.preventDefault();
	}
	jQuery('#myModal button.switchbtn.button-primary').click(function (e) {
		const customerId = (jQuery(this).hasClass('frompage') && jQuery(this).val()) || jQuery('#cusname1').val();
		if (customerId) {
			disableControls(e);
			const spinner = $('#loader_fme-nsi');
			spinner.css('display', 'flex');
			spinner.append(`<div id="customer_switching_message">Switching to <div>Customer ID: ${customerId}</div></div>`);
			$(`#myModal`).hide();
		}
	});
	jQuery('#divtohide > center > button').click((e) => {
		disableControls(e);
	});

	$('body').on('click', '#quote-page-add-product-profile', function(e) {
		e.preventDefault();
		const quoteLimit = crownThemeData.quote_lines_limit;
		const quantity = $('#quote-page-add-product-quantity').val();
		const product = $('#quote-page-search-products').val();
		let msg = $('.add-to-quote--message');
		msg.fadeOut().empty();

		if ( !quantity ) {
			msg.html( 'Quantity is required.' ).fadeIn('400', function() { $(this).css('display', 'block') });
			return;
		}

		if ( !Number.isInteger(Number(quantity)) || Number(quantity) <= 0 ) {
			msg.html( 'Quantity must be an integer greater than 0.' ).fadeIn('400', function() { $(this).css('display', 'block') });
			return;
		}

		if ( !product ) {
			msg.html( 'Please choose a product.' ).fadeIn('400', function() { $(this).css('display', 'block') });
			return;
		}

		let currentCount = $('.addify-quote-form-profile tbody').find('tr.woocommerce-cart-form__quote-item').length;
		if ( currentCount >= quoteLimit ) {
			msg.html( 'You can only add up to ' + quoteLimit + ' different SKUs to your quote.' ).fadeIn('400', function() { $(this).css('display', 'block') });
			return;
		}

		$('td.add-to-quote').css({'opacity': '.4', 'pointer-events': 'none'});
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'afrfq_insert_product_row',
				product_id: product,
				quantity: quantity,
				post_id: $('#post_id_profile').val(),
				nonce: crownThemeData.nonce_profile_quote,
				type: 'profile',
				form_data: $('form.addify-quote-form-profile').serialize(),
			},
			success: function (response) {
				if( response['success'] ) {
					if ( response['quote-details-table'] ) {
						$( 'form.addify-quote-form-profile table tbody' ).find('tr:not(.addify-quote-form-profile-actions)').remove();
						$( response['quote-details-table'] ).insertBefore('.addify-quote-form-profile-actions');
						$('td.add-to-quote').css({'opacity': '1', 'pointer-events': 'initial'});
						$( '.cart_totals .shop_table tbody' ).html(response['quote-totals']);
					} else {
						location.reload();
					}
				} else {
					$('td.add-to-quote').css({'opacity': '1', 'pointer-events': 'initial'});
					if( response['message'] ) {
						msg.html( response['message'] ).fadeIn('400', function() { $(this).css('display', 'block') });
					} else {
						msg.html( 'Something went wrong, please try again.' ).fadeIn('400', function() { $(this).css('display', 'block') });
					}
				}
			},
			error: function (response) {
				location.reload();
			}
		});
	});


	$('body').on('click', '#quote-page-add-pricing-profile', function(e) {
		e.preventDefault();
		
		const groupId = $('#quote-page-search-pricing-groups').val();
		const msg = $('.add-to-quote-group--message');
		const addButton = $(this);
		const form = $('form.addify-quote-discount-form-profile');
		const tableBody = form.find('table tbody');
		const actionsRow = tableBody.find('.addify-quote-discount-form-profile-actions');

		msg.fadeOut().empty();

		if (!groupId) {
			msg.html('Please choose a pricing group.').fadeIn('400');
			return;
		}

		addButton.prop('disabled', true).css('opacity', '.5');
		
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'afrfq_insert_pricing_row',
				
				add_type: 'group',
				group_id: groupId,
				form_data: form.serialize(),
				
				post_id: $('#post_id_profile').val(),
				nonce: crownThemeData.nonce_profile_quote,
				type: 'profile'
			},
			success: function (response) {
				if (response.success && response.data['quote-details-table']) {

					tableBody.html(response.data['quote-details-table']);
					
					$('#quote-page-search-pricing-groups').val(null).trigger('change');
				} else {
					let errorMessage = response.data.message || 'Something went wrong, please try again.';
					msg.html(errorMessage).fadeIn('400');
				}
			},
			error: function (response) {
				msg.html('An unexpected error occurred. Please reload and try again.').fadeIn('400');
			},
			complete: function() {
				addButton.prop('disabled', false).css('opacity', '1');
			}
		});
	});

	$(document).on('click', 'a.delete-quote-item-profile', function(event){
		event.preventDefault();
		const remove_button = $(this);
		const product_table = remove_button.closest('table');
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
				nonce      : crownThemeData.nonce_profile_quote,
				post_id    : $('#post_id_profile').val(),
				form_data  : $('form.addify-quote-form-profile').serialize(),
				quote_item_id   : remove_button.data( 'quote_item_id_profile' ),
				type: 'profile'
			},
			success: function (response) {
				if( response['success'] ) {
					$( 'form.addify-quote-form-profile table tbody' ).find('tr:not(.addify-quote-form-profile-actions)').remove();
					$( response['quote-details-table'] ).insertBefore('.addify-quote-form-profile-actions');
					$( '.cart_totals .shop_table tbody' ).html(response['quote-totals']);
				}
				product_table.css('pointer-events', 'initial').css('opacity', '1');
			},
			error: function (response) {
				remove_button.css('opacity' ,'1' );
				product_table.css('pointer-events', 'initial').css('opacity', '1');
			}
		});
	});

	$(document).on('click', 'a.remove-pricing-group', function(event) {
		event.preventDefault();
		
		const removeButton = $(this);
		const form = removeButton.closest('form.addify-quote-discount-form-profile');
		const table = form.find('table');
		const tableBody = table.find('tbody');
		const actionsRow = tableBody.find('.addify-quote-discount-form-profile-actions');

		if (removeButton.css('opacity') < 1) {
			return;
		}

		removeButton.css('opacity', '0.2');
		table.css('pointer-events', 'none').css('opacity', '0.4');

		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'afrfq_remove_pricing_row',
				
				remove_type: 'group',
				group_key_to_remove: removeButton.data('group-key'),
				form_data: form.serialize(),
				
				nonce: crownThemeData.nonce_profile_quote,
				post_id: $('#post_id_profile').val(),
				type: 'profile'
			},
			success: function(response) {
				if (response.success) {
					if (response.data['quote-details-table']) {
						tableBody.html(response.data['quote-details-table']);
					} else {
						const emptyRow = '<tr class="quote-empty-pricing-groups"><td colspan="3">No pricing groups have been added to this quote yet.</td></tr>';
						tableBody.html(emptyRow);
					}
				} else {
					alert(response.data.message || 'Could not remove item. Please try again.');
				}
			},
			error: function(response) {
				alert('An unexpected error occurred. Please reload the page and try again.');
			},
			complete: function() {
				table.css('pointer-events', 'initial').css('opacity', '1');
			}
		});
	});

	$(document).on('click', 'button.afrfq_update_quote_profile_btn', function (e) {
		e.preventDefault();
		if(!jQuery('form.addify-quote-form-profile').get(0).reportValidity()) {
			return;
		}
		$(this).addClass('loading').css({'opacity': '.4', 'pointer-events': 'none'});
		const current_button = $(this);
		$.ajax({

			url: ajaxurl,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'afrfq_update_quote_items_profile',
				nonce: crownThemeData.nonce_profile_quote,
				form_data: $('form.addify-quote-form-profile').serialize(),
				quote_id: current_button.data('quote_id'),
			},

			success: function (response) {
				location.reload();
			},

			error: function (response) {
				location.reload();
			}
		});
	});

	$(document).on('click', 'button.afrfq_update_discount_quote_profile_btn', function (e) {
		e.preventDefault();
		if(!jQuery('form.addify-quote-discount-form-profile').get(0).reportValidity()) {
			return;
		}
		$(this).addClass('loading').css({'opacity': '.4', 'pointer-events': 'none'});
		const current_button = $(this);
		$.ajax({

			url: ajaxurl,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'afrfq_update_discount_quote_items_profile',
				nonce: crownThemeData.nonce_profile_quote,
				form_data: $('form.addify-quote-discount-form-profile').serialize(),
				quote_id: current_button.data('quote_id'),
			},

			success: function (response) {
				location.reload();
			},

			error: function (response) {
				location.reload();
			}
		});
	});

	quote_change_recalculate_prices_listener(
		$,
		'.addify-quote-form-profile .offered-price-input',
		'.addify-quote-form-profile .wcmmq-qty-input-box',
		'.requested-subtotal',
		'.cart-requested-subtotal td',
		'tr.woocommerce-cart-form__quote-item'
	);
});

// show pdp quote-type popup
jQuery(document).ready(function ($) {
    var ajaxUrl  = afrfq_phpvars.admin_url;
    var nonce    = afrfq_phpvars.nonce;
    var redirect = afrfq_phpvars.redirect;
    var pageurl  = afrfq_phpvars.pageurl;

    const $popup = $('#pdp-popup'); 
    const $bridgeportPopup = $('#bridgeport-popup');
    const $popup_discount = $('#discount-popup');
	const selected_quote_type_not_selected_msg = document.querySelector('.quote-type-not-selected');

    // Open popup
    $('.select-quote-type-button').on('click', function (e) {
		selected_quote_type_not_selected_msg.style.display = 'none';
    
        e.preventDefault();
        e.stopPropagation();

        const buttonEl = $(this);
        const blockBridgeport = buttonEl.data('block_bridgeport');
        const current_button = buttonEl;

        current_button.closest('form').find('a.added_to_quote').remove();

        // Variable product
        if (current_button.is('.product_type_variable')) {
            if (current_button.hasClass('disabled')) return;
            current_button.addClass('loading');

            $.post(ajaxUrl, {
                action: 'add_to_quote_single_vari',
                form_data: current_button.closest('form').serialize(),
                product_id: current_button.data('product_id'),
                nonce: nonce
            }, function (response) {
                handleResponse(response, current_button, blockBridgeport);
            });

        } else {
            // Simple product
            const productId = current_button.data('product_id');
            current_button.addClass('loading');

            $.post(ajaxUrl, {
                action: 'add_to_quote_single',
                form_data: current_button.closest('form').serialize(),
                product_id: productId,
                nonce: nonce
            }, function (response) {
                handleResponse(response, current_button, blockBridgeport);
            });
        }
    });

    //Handle backend + frontend validation
    function handleResponse(response, current_button, blockBridgeport) {
        if (response && response.success === false && response.data && response.data.code) {
            current_button.removeClass('loading');

            switch (response.data.code) {
                case 'bridgeport':
                    $bridgeportPopup.addClass('active');
                    return;
                case 'discount':
                    $popup_discount.addClass('active');
                    return;
                case 'no_quote_type':
                    $popup.addClass('active');
                    return;
            }
        }

        if ($.trim(response) === 'success') {
            if (redirect === "yes") {
                window.location.href = pageurl;
            } else {
                window.location = location.href;
            }
        } else if ($.trim(response) === 'failed') {
            window.location = location.href;
        } else if (response && response['view_button']) {
            current_button.removeClass('loading');
            current_button.after(response['view_button']);
            $('.quote-li').replaceWith(response['mini-quote']);
        } else {
            current_button.removeClass('loading');
        }
    }

    // Close on outside click
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#pdp-popup, .select-quote-type-button').length) {
            $popup.removeClass('active');
        }
        if (!$(e.target).closest('#discount-popup, .discount-quick-view').length) {
            $popup_discount.removeClass('active');
        }
    });

    // Prevent popup itself from triggering outside click close
    $popup.on('click', function (e) {
	    e.stopPropagation();
    });
    $popup_discount.on('click', function (e) {
        e.stopPropagation();
    });

    // Close with close button
    $('.popup-close-button').on('click', function () {
        $popup.removeClass('active');
        $popup_discount.removeClass('active');
    });
    $('#bridgeport-close').on('click', function () {
        $bridgeportPopup.removeClass('active');
    });
});

document.addEventListener('DOMContentLoaded', function () {

    // STORE QUOTE TYPE when submit clicked
    document.addEventListener('click', function (e) {
        const submitBtn = e.target.closest('.afrfqbt_single_page');
        if (!submitBtn) return;

        const selectedInput = document.querySelector('input[name="afrfq_field_quote_types"]:checked');
		const selected_quote_type_not_selected_msg = document.querySelector('.quote-type-not-selected');
		 if (!selectedInput) {
            selected_quote_type_not_selected_msg.style.display = 'block';
            return;
        }
		if (selectedInput) {
            selectedId = selectedInput.value;
            selectedTitle = selectedInput.dataset.label || selectedInput.parentElement.textContent.trim();
        } 
        // Save to localStorage immediately
        localStorage.setItem('selected_quote_type', JSON.stringify({
            id: selectedId,
            title: selectedTitle
        }));


		  fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: new URLSearchParams({
                            action: "set_selected_quote_type",
                            id: selectedId,
                            title: selectedTitle
                        })
                    }).then(r => r.json())
                        .then(data => {
                        window.location.href = "<?php echo esc_url( home_url( '/request-a-quote' ) ); ?>";
                    });

    }, true); 
});
// competitor dropdown UI change
jQuery(document).ready(function($) {
    $('select[multiple]').select2({
        placeholder: "Select options",
        allowClear: true,
		width: '100%',
    });
});

 // multiselect mandatory verification color
jQuery(document).ready(function ($) {
    // Select2 styling
    $('select.select2-hidden-accessible').on('change', function () {
        let $selection = $(this).next('.select2').find('.select2-selection');
        if ($(this).val() && $(this).val().length > 0) {
            $selection.css('border-left', '2px solid #008000');
        } else {
            $selection.css('border-left', '2px solid rgb(202, 16, 16)');
        }
    }).trigger('change');
});

// tooltip
document.addEventListener("DOMContentLoaded", function () {
    const tooltips = document.querySelectorAll(".tooltip-icon");

    tooltips.forEach(icon => {
        icon.addEventListener("click", function (e) {
            e.stopPropagation();
            tooltips.forEach(i => i.classList.remove("active"));
            this.classList.toggle("active");
        });
    });
    document.addEventListener("click", function () {
        tooltips.forEach(i => i.classList.remove("active"));
    });
});