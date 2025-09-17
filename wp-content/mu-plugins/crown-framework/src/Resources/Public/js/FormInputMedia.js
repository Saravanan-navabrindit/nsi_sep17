(function($) {

	var crownMediaFrames = new Array()
	var targetCrownMediaInput;
	var crownMediaInputInDialog;

	$(document).ready(function() {

		$(document).on('click', '.crown-media-input a.media-input-button', openMediaUploader);
		$(document).on('click', '.crown-media-input a.media-input-remove', removeFile);
		wp.media.frames.crownMediaFrames = new Array();

	});

	function openMediaUploader(e) {
		e.preventDefault();
		crownMediaInputInDialog = false;
		targetCrownMediaInput = $(this).closest('.crown-media-input');
		targetCrownMediaInputName = $('input[type=hidden]', targetCrownMediaInput).attr('name');

		if(targetCrownMediaInput.parents('.ui-dialog').length) {
			$('.ui-widget-overlay, .ui-dialog').hide();
			crownMediaInputInDialog = true;
		}

		// If the media frame already exists, reopen it.
		if(crownMediaFrames[targetCrownMediaInputName]) {
			crownMediaFrames[targetCrownMediaInputName].open();
			return;
		}

		// Create the media frame.
		crownMediaFrames[targetCrownMediaInputName] = wp.media.frames.crownMediaFrames[targetCrownMediaInputName] = wp.media({
			title: 'Select File',
			button: {
				text: 'Continue',
			},
			library: {
				type: targetCrownMediaInput.data('media-mime-type')
			},
			multiple: false
		});

		// When an image is selected, run a callback.
		crownMediaFrames[targetCrownMediaInputName].on('select', function(html) {
			var selection = crownMediaFrames[targetCrownMediaInputName].state().get('selection');
			selection.map(function(attachment) {
				selectFile(targetCrownMediaInput, attachment.toJSON());
			});
		});

		// Finally, open the modal
		crownMediaFrames[targetCrownMediaInputName].open();
	}

	function selectFile(mediaInput, attachment) {
		mediaInput.addClass('has-media');
		$('input[type=hidden]', mediaInput).val(attachment.id);
		var previewPath = attachment.icon;
		if(attachment.type == 'image') {

			// check for existence of sizes property, use url if absent
			if (attachment.hasOwnProperty('sizes')){
				var previewPath = attachment.sizes.medium ? attachment.sizes.medium.url : attachment.sizes.full.url;
			} else if (attachment.hasOwnProperty('url')) {
				var previewPath = attachment.url;
			} else {
				var previewPath = '';
			}

		}
		$('.media-input-preview', mediaInput).html('<img src="' + previewPath + '" />');
		$('span.media-input-name', mediaInput).html(String(attachment.url.match(/\/[^\/]+$/)).substr(1));
		if(crownMediaInputInDialog) {
			$('.ui-widget-overlay, .ui-dialog').show();
			$('.ui-dialog > .ui-dialog-content').dialog('option', 'position', { my: 'center', at: 'center', of: window });
		}
	}

	function removeFile(e) {
		e.preventDefault();
		var mediaInput = $(this).closest('.crown-media-input');
		mediaInput.removeClass('has-media');
		$('input[type=hidden]', mediaInput).val('');
		$('span.media-input-preview, span.media-input-name', mediaInput).html('');
		if(crownMediaInputInDialog) {
			$('.ui-dialog > .ui-dialog-content').dialog('option', 'position', { my: 'center', at: 'center', of: window });
		}
	}

})(jQuery);