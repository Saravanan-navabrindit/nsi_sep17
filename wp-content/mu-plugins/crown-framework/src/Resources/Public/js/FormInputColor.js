(function($) {

	$(document).on('initColorpicker', '.crown-colorpicker-input', function(e) {
		if($(this).attr('name') == '' || $(this).attr('name') == undefined) return;
		var options = $(this).data('colorpicker-options');
		$.each(options, function(key, val) {
			if(String(val).indexOf('function(') !== -1) {
				eval('var fn = ' + val);
				options[key] = fn;
			}
		});

		options = $.extend({
			mode: 'hsl',
			palettes: false
		}, options);

		if(typeof(options.palettes) == 'object') {
			options.palettes = Object.keys(options.palettes).map(function(key) { return options.palettes[key] });
		}

		$(this).wpColorPicker(options);
	});

	$(document).ready(function() {
		$('.crown-colorpicker-input').trigger('initColorpicker');
	});

})(jQuery);