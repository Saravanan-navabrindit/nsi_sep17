import css from '../sass/public.scss';

import 'jquery';

'use strict';

(function($) {
	
	$(document).on('ready', function() {

		$('.woocommerce-sidebar > button.sidebar-expander-toggle').on('click', function(e) {
			var sidebar = $(this).closest('.woocommerce-sidebar');
			sidebar.toggleClass('expanded');
		});

		$('.widget.product-categories, .widget.product-filters').each(function(i, el) {
			var widget = $(el);
			var menu = $('> ul', widget);
			$('> li', menu).each(function(j, el2) {
				var menuItem = $(el2);
				if($('> ul', menuItem).length) {
					menuItem.prepend('<button class="toggle">+</button>');
					if($('> ul > li.active', menuItem).length) {
						menuItem.addClass('expanded');
					}
				}
			});
			$('button.toggle', menu).on('click', function(e) {
				var menuItem = $(this).closest('li');
				menuItem.toggleClass('expanded');
			});
		});

	});

})(jQuery);
