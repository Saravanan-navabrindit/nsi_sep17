(function($) {

	$(document).ready(initDatePickers);
	$(document).on('repeaterEntryAdded', '.entry', initDatePickers);

	function initDatePickers() {
		$('.crown-datepicker-input').each(function(i, el) {
			if($(el).closest('.entry.tpl').length) return;

			var options = $(this).data('datepicker-options');
			$.each(options, function(key, val) {
				if(String(val).indexOf('function(') !== -1) {
					eval('var fn = ' + val);
					options[key] = fn;
				}
			});

			options = $.extend({
				defaultDate: +1,
				dateFormat: 'm/d/yy'
			}, options);

			$(this).datepicker(options);

			if(options.defaultDate !== null && $(this).datepicker('getDate') === null) {
				// var selectedDate = new Date();
				// selectedDate.setDate(selectedDate.getDate() + $(this).datepicker('option', 'defaultDate'));
				// $(this).datepicker('setDate', selectedDate);
			}

		});
	}

})(jQuery);