(function($) {

	$(document).ready(function() {

		$('.meta-box-sortables').on('sortstart', function(event) {
			triggerWPEditors(event, false);
		}).on('sortstop', function(event) {
			triggerWPEditors(event, true);
		});

	});

	function triggerWPEditors(event, creatingEditor) {
		$('textarea.wp-editor-area', $(event.srcElement).closest('.postbox')).each(function(i, el) {
			var editor = tinyMCE.get(el.id);
			var isActive = $(el).parents('.tmce-active').length;
			if(creatingEditor) {
				if(!editor && isActive) {
					tinyMCE.execCommand('mceAddEditor', true, el.id);
				}
			} else {
				if(editor) {
					editor.save();
					tinyMCE.execCommand('mceRemoveEditor', true, el.id);
				}
			} 
		});
	}

})(jQuery);