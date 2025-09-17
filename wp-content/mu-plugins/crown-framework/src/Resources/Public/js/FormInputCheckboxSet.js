(function($) {

	$(document).ready(function() {

		$('.crown-checkbox-set-input.sortable > .inner').sortable()
			.on('sortstart', function(event) {
				event.stopPropagation();
			})
			.on('sortstop', function(event) {
				event.stopPropagation();
			});
			
		$('.crown-radio-set-input.sortable > .inner').sortable()
			.on('sortstart', function(event) {
				event.stopPropagation();
			})
			.on('sortstop', function(event) {
				event.stopPropagation();
			});

	});

})(jQuery);