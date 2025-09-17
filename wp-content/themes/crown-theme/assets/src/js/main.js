

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
			// var first_section = $('#main-content').children().first();
			// if(first_section.is('.wp-block-crown-blocks-container.text-color-light.alignfull')) header.addClass('text-color-light');
			// if(first_section.is('.wp-block-crown-blocks-post-header.text-color-light')) header.addClass('text-color-light');
			// if(first_section.is('.wp-block-crown-blocks-resource-header.text-color-light')) header.addClass('text-color-light');
			// if(first_section.is('.wp-block-crown-blocks-event-header')) header.addClass('text-color-light');
			// if(first_section.is('.wp-block-crown-blocks-client-story-header')) header.addClass('text-color-light');
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

			// // activate sub-menus on hover
			// $('#header-primary-navigation .menu-item').on('mouseenter', function(e) {
			// 	var menuItem = $(this);
			// 	var subMenu = $('> .sub-menu', menuItem);
			// 	if(subMenu.length) {
			// 		menuItem.addClass('active');
			// 	}
			// }).on('mouseleave', function(e) {
			// 	var menuItem = $(this);
			// 	if(menuItem.hasClass('active')) {
			// 		menuItem.removeClass('active');
			// 	}
			// });

			// activate sub-menus on click
			$('#header-primary-navigation-menu > li > a').on('click', function(e) {
				var menuItem = $(this).closest('.menu-item');
				var subMenu = $('> .sub-menu-container', menuItem);
				$('#header-primary-navigation-menu > .menu-item.active').not($(this).parents('.menu-item.active')).removeClass('active');
				if(subMenu.length && !menuItem.hasClass('active')) {
					e.preventDefault();
					menuItem.addClass('active');
				}
			});
			$(document).on('click', function(e) {
				if($(e.target).closest('#header-primary-navigation-menu').length) return;
				$('#header-primary-navigation-menu > .menu-item.active').removeClass('active');
			});

			// $('#header-primary-navigation-menu > li > div > div > .sub-menu-contents > .sub-menu > li').not('.menu-item-has-children').each(function(i, el) {
			// 	var menuItem = $(this);
			// 	var description = $('> a', menuItem).data('description');
			// 	if(description && description != '') {
			// 		menuItem.append('<div class="sub-menu-container"><div class="inner"><p>' + description + '</p></div></div>');
			// 	}
			// });

			// $(document).on('mousemove', '#header-primary-navigation-menu > li > div > div > .sub-menu-contents > .sub-menu > li', function(e) {
			// 	var menuItem = $(this);
			// 	if(menuItem.hasClass('active')) return;
			// 	menuItem.siblings('.active').removeClass('active');
			// 	menuItem.addClass('active');
			// });

			// $(window).on('load resize', function() {
			// 	$('#header-primary-navigation-menu > li > .sub-menu-container').each(function(i, el) {
			// 		var subMenu = $(this);
			// 		var minHeight = 0;
			// 		$('> .inner > .sub-menu-contents > .sub-menu > li > .sub-menu-container', subMenu).each(function(j, el2) {
			// 			minHeight = Math.max(minHeight, $(el2).height());
			// 		});
			// 		$('> .inner > .sub-menu-contents > .sub-menu', subMenu).css({ minHeight: minHeight });
			// 	});
			// });

			// $('#header-search button.toggle').on('click', function(e) {
			// 	var header = $('#header');
			// 	header.toggleClass('search-active');
			// 	if(header.hasClass('search-active')) {
			// 		setTimeout(function() {
			// 			$('#header-search input[type=search]').select();
			// 		}, 350);
			// 	}
			// });

			// var updateHeaderStatus = function() {
			// 	var header = $('#header');
			// 	var scrollTop = $(window).scrollTop();
			// 	var threshold = 0;
			// 	if($('body').width() < 601 && $('#wpadminbar').length) threshold += $('#wpadminbar').outerHeight();
			// 	if($('#site-announcement.active.shown').length) threshold += $('#site-announcement.active.shown').outerHeight();
			// 	if(scrollTop > threshold && !header.hasClass('is-sticky')) {
			// 		header.addClass('is-sticky');
			// 	} else if(scrollTop <= threshold && header.hasClass('is-sticky')) {
			// 		header.removeClass('is-sticky');
			// 	}
			// 	if(scrollTop > stickyHeaderScrollTracker && scrollTop > threshold + 300 && !$('#header-primary-navigation-menu > .menu-item.active').length && !header.hasClass('is-minified')) {
			// 		header.addClass('is-minified');
			// 	} else if(scrollTop <= stickyHeaderScrollTracker && header.hasClass('is-minified') && !keepStickyHeaderHidden) {
			// 		header.removeClass('is-minified');
			// 	}
			// 	stickyHeaderScrollTracker = scrollTop;
			// };
			// updateHeaderStatus();
			// $(window).on('load scroll', updateHeaderStatus);

			$('#header-primary-navigation-menu .industry-menu .products .menu-tree .menu a').on('click', function(e) {
				var menuItem = $(this).closest('.menu-item');
				var tree = menuItem.closest('.menu-tree');
				var menuId = menuItem.data('menu');
				var subMenu = $('.sub-menu.parent-menu-' + menuId, tree);
				if(subMenu.length && !subMenu.hasClass('active')) {
					e.preventDefault();
					$('.sub-menu.active', tree).removeClass('active');
					$('.menu .menu-item.active', tree).removeClass('active');
					subMenu.addClass('active');
					menuItem.addClass('active');
				}
			});

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
			// $('.wp-block-gallery').each(function(i, el) {
				// var slider = $('.wp-block-gallery', el);
				// if(slider.hasClass('slick-initialized')) return;
				
				// $('.wp-block-gallery').each(function(i, el) {
				// 	var slider = $('.featured-image-slider > .inner', el);
				// 	if(slider.hasClass('slick-initialized')) return;
				// 	var slideCount = slider.children().length;
				// 	var slickSettings = {
				// 		draggable: true,
				// 		dots: slideCount < 1,
				// 		arrows: true,
				// 		slidesToShow: 1,
				// 		slidesToScroll: 1,
				// 		mobileFirst: true,
				// 		responsive: [
				// 			{
				// 				breakpoint: 768,
				// 				settings: {
				// 					// arrows: true
				// 				}
				// 			}
				// 		]
				// 	};
				// 	slider.on('setPosition', function(event, slick) {
				// 		var track = $('.slick-track', slick.$slider);
				// 		var slides = $('.slick-slide', slick.$slider);
				// 		slides.css({ height: 'auto' });
				// 		slides.css({ height: track.height() });
				// 	}).slick(slickSettings);
					// slider.slick(slickSettings);
				//});

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
				
				// $('.wp-block-crown-blocks-tabbed-content .inner .tabs').slick({
				// 	centerMode: true,
				// 	centerPadding: '60px',
				// 	slidesToShow: 3,
				// 	arrows: false,
				// 	responsive: [
				// 	  {
				// 		breakpoint: 768,
				// 		settings: {
				// 		  arrows: false,
				// 		  centerMode: true,
				// 		  centerPadding: '40px',
				// 		  slidesToShow: 3
				// 		}
				// 	  },
				// 	  {
				// 		breakpoint: 480,
				// 		settings: {
				// 		  arrows: false,
				// 		  centerMode: true,
				// 		  centerPadding: '40px',
				// 		  slidesToShow: 1
				// 		}
				// 	  }
				// 	]
				// }); 

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