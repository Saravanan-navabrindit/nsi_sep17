(function($) {

	var isHierarchical = crownOrderingAdminTermOrderingData.isHierarchical;

	$(document).ready(function() {
		
		$('#sortable-terms-list > ol').nestedSortable({
			items: 'li',
			toleranceElement: '> div.sortable-term',
			handle: 'div.sortable-term',
			start: startSort,
			isTree: true,
			expandOnHover: 700,
			startCollapsed: false
		});
		$('#sortable-terms-list .collapse-toggle').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		});

		$('.save-sortable-terms-list').on('click', saveTermOrder);

	});

	function startSort(e, ui) {
		ui.placeholder.append('<div class="outline"></div>');
		$('.outline', ui.placeholder).height(ui.placeholder.height() - 2);
	}

	function saveTermOrder(e) {
		var button = $(this);
		button.addClass('button-primary-disabled');
		button.next('.spinner').addClass('is-active');
		var terms = $('#sortable-terms-list > ol').nestedSortable('toHierarchy');
		var updatedTerms = getTermOrderData(terms, 0);
		$.post(crownOrderingAdminTermOrderingData.ajaxUrl, { action: 'update_term_order_meta_data', 'taxonomy': crownOrderingAdminTermOrderingData.taxonomy, updatedTerms: updatedTerms }, function() {
			button.removeClass('button-primary-disabled');
			button.next('.spinner').removeClass('is-active');
		});
	}
	function getTermOrderData(terms, termParent) {
		var updatedTerms = new Array();
		for(var i = 0; i < terms.length; i++) {
			var termData = {
				term_id: terms[i].id,
				menu_order: i + 1,
				parent: termParent
			};
			updatedTerms.push(termData);
			if(terms[i].children) {
				updatedTerms = updatedTerms.concat(getTermOrderData(terms[i].children, terms[i].id));
			}
		}
		return updatedTerms;
	}

})(jQuery);