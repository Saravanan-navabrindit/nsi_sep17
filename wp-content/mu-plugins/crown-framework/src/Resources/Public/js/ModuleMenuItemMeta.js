

/*
(function($) {

	$(document).ready(function() {
		
		// initThickbox();

	});

	$.moduleMenuItemMeta = (function(moduleMenuItemMeta) {

		moduleMenuItemMeta.tbShow = function(caption, url, imageGroup) {
			old_tb_show(caption, url, imageGroup);
			
			var modal = $('#TB_window');
			var editorEl = $('#nav-menu-item-content-editor-field', modal);
			if(editorEl.length) {

				modal.addClass('menu-item-content-editor-modal');

				var editorId = editorEl.attr('id');
				var editor = tinyMCE.get(editorId);
				var isActive = editorEl.closest('.wp-editor-wrap').hasClass('.tmce-active');
				console.log(editor);
				if(true) {
					if(!editor && isActive) {
						console.log(editorId);
						tinyMCE.execCommand('mceAddEditor', true, editorId);
					}
				} else {
					if(editor) {
						editor.save();
						tinyMCE.execCommand('mceRemoveEditor', true, editorId);
					}
				}

				// tinyMCE.get(editorId).setContent('test');

			}

		};

		return moduleMenuItemMeta;
		
	})({});

})(jQuery);



var old_tb_show = window.tb_show;
var tb_show = jQuery.moduleMenuItemMeta.tbShow;
*/