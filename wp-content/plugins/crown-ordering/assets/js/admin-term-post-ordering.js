(function($) {

	$(document).ready(function() {
		
		$('.sortable-taxonomy-posts-list > ol').sortable({
			items: 'li',
			toleranceElement: '> div.sortable-post',
			handle: 'div.sortable-post',
			start: startSort
		});

	});

	function startSort(e, ui) {
		ui.placeholder.append('<div class="outline"></div>');
		$('.outline', ui.placeholder).height(ui.placeholder.height() - 2);
	}

})(jQuery);