(function($) {

	$(document).ready(initSelects);
	$(document).on('repeaterEntryAdded', '.entry', initSelects);

	function initSelects() {
		$('select:not(.select2-hidden-accessible)').each(function(i, el) {
			if($(el).closest('.entry.tpl').length) return;

			var options = $(this).data('select2-options');
			if(!options) return;
			
			$.each(options, function(key, val) {
				if(String(val).indexOf('function(') !== -1) {
					eval('var fn = ' + val);
					options[key] = fn;
				}
			});

			var sortable = options.sortable !== undefined && options.sortable;

			var defaultOptions = {
				containerCssClass: 'crown-select2-selection',
				dropdownCssClass: 'crown-select2-dropdown',
				templateResult: function(option) {
					var matches = option.text.match(/^\s+/)
					if(matches) {
						var depth = matches[0].length / 3;
						return $('<span class="option-depth depth-' + depth + '">' + option.text.trim() + '</span>');
					}
					return option.text;
				},
				templateSelection: function(option) {
					return option.text.trim();
				}
			};

			options = $.extend({}, defaultOptions, options);

			if(options.containerCssClass != defaultOptions.containerCssClass) {
				var classes = options.containerCssClass.split(' ');
				var classNames = [];
				for(var i = 0; i < classes.length; i++) {
					var className = classes[i].trim();
					if(className != '') classNames.push(className);
				}
				if(classNames.indexOf(defaultOptions.containerCssClass) === -1) classNames.push(defaultOptions.containerCssClass);
				options.containerCssClass = classNames.join(' ');
			}

			if(options.dropdownCssClass != defaultOptions.dropdownCssClass) {
				var classes = options.dropdownCssClass.split(' ');
				var classNames = [];
				for(var i = 0; i < classes.length; i++) {
					var className = classes[i].trim();
					if(className != '') classNames.push(className);
				}
				if(classNames.indexOf(defaultOptions.dropdownCssClass) === -1) classNames.push(defaultOptions.dropdownCssClass);
				options.dropdownCssClass = classNames.join(' ');
			}

			if(sortable) {
				delete options.sortable;
				options.templateSelection = function(option) {
					var optionEl = $('<span>' + option.text.trim() + '</span>');
					optionEl.addClass('label').data('option-value', option.element.value);
					return optionEl;
				};
			}

			$(this).select2(options);

			if(sortable) {
				$(el).siblings('.select2-container').find('ul.select2-selection__rendered').sortable({
					items: '> li.select2-selection__choice',
					update: function(e, ui) {
						var list = $(e.target);
						var select = list.closest('.select2-container').siblings('select.select2-hidden-accessible');
						var selectedOptions = [];
						$('> li.select2-selection__choice', list).each(function(i, el) {
							var option = $('option', select).filter(function(j, el2) { return $(el2).val() == $('span.label', el).data('option-value'); }).first();
							if(option.length) selectedOptions.push(option);
						});
						for(var i = selectedOptions.length - 1; i >= 0; i--) {
							select.prepend(selectedOptions[i]);
						}
					}
				});
				$(el).on('select2:select', function(e) {
					var id = e.params.data.id;
					var element = $(this).children('option[value=' + id + ']');
					if(element.length) {
						element.detach();
						if($('option:selected', this).length) $('option:selected', this).last().after(element);
						else $(this).prepend(element);
					}
					$(this).trigger('change');
				});
			}

		});
	}

})(jQuery);