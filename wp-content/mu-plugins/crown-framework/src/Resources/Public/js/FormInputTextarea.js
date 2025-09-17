(function($) {

	$(document).ready(initTextareas);
	$(document).on('repeaterEntryAdded', '.entry', initTextareas);

	function initTextareas() {
		$('textarea:not(.code-editor-initialized)').each(function(i, el) {
			if($(el).closest('.entry.tpl').length) return;

			var mode = $(el).data('textarea-mode');
			if(!mode) return;

			var defaultOptions = {
				mode: '',
				viewportMargin: Infinity,
				lineNumbers: true,
				indentUnit: 4,
				indentWithTabs: true
			};

			if(mode == 'html') {
				defaultOptions.mode = 'htmlmixed';
			} else if(mode == 'javascript') {
				defaultOptions.mode = 'javascript';
			} else if(mode == 'css') {
				defaultOptions.mode = 'css';
			}
			
			options = $.extend(defaultOptions, {});

			if(options.mode != '') {
				CodeMirror.fromTextArea(el, options);
			}

			$(el).addClass('code-editor-initialized');

		});
	}

})(jQuery);