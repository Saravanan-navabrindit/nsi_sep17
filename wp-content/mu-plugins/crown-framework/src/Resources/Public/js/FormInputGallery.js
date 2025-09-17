(function($) {

	var crownGalleryCreateFrames = new Array();
	var crownGalleryFrames = new Array();
	var targetCrownGalleryInput;

	$(document).ready(function() {

		$(document).on('click', '.crown-gallery-input a.gallery-input-add-images-button', openGalleryCreator);
		$(document).on('click', '.crown-gallery-input a.gallery-input-edit-button', openGalleryEditor);
		$(document).on('click', '.crown-gallery-input a.gallery-image-remove', removeImage);
		wp.media.frames.crownGalleryCreateFrames = new Array();
		wp.media.frames.crownGalleryFrames = new Array();

		$('.crown-gallery-input .gallery-images').sortable({});

	});

	function openGalleryCreator(e) {
		e.preventDefault();
		targetCrownGalleryInput = $(this).closest('.crown-gallery-input');
		var targetCrownGalleryInputName = targetCrownGalleryInput.data('basename');

		if(crownGalleryCreateFrames[targetCrownGalleryInputName]) {
			crownGalleryCreateFrames[targetCrownGalleryInputName].open();
			return;
		}

		crownGalleryCreateFrames[targetCrownGalleryInputName] = wp.media.frames.crownGalleryCreateFrames[targetCrownGalleryInputName] = wp.media({
			title: 'Add to Gallery',
			button: {
				text: 'Add to gallery',
			},
			library: {
				type: 'image'
			},
			multiple: true
		});

		crownGalleryCreateFrames[targetCrownGalleryInputName].on('select', function() {
			var selection = crownGalleryCreateFrames[targetCrownGalleryInputName].state().get('selection');
			
			var attachmentIds = [];
			for(var i = 0; i < selection.models.length; i++) {
				var attachment = selection.models[i].attributes;
				attachmentIds.push(attachment.id);
			}
			galleryEditor(targetCrownGalleryInput, attachmentIds);
		});

		crownGalleryCreateFrames[targetCrownGalleryInputName].open();

	}

	function openGalleryEditor(e) {
		e.preventDefault();
		targetCrownGalleryInput = $(this).closest('.crown-gallery-input');

		var attachmentIds = [];
		$('ul.gallery-images > li input[type=hidden]', targetCrownGalleryInput).each(function(i, el) {
			attachmentIds.push($(el).val());
		});

		galleryEditor(targetCrownGalleryInput, attachmentIds);
	}

	function galleryEditor(galleryInput, ids, columns, link, orberby) {
		columns = typeof columns !== 'undefined' ? columns : 6;
		link = typeof link !== 'undefined' ? link : 'file';
		orberby = typeof orberby !== 'undefined' ? orberby : 'menu_order ID';
		var targetCrownGalleryInputName = targetCrownGalleryInput.data('basename');

		var attributes = [
			'ids="' + ids.join(',') + '"',
			'columns="' + columns + '"',
			'link="' + link + '"',
			'orderby="' + orberby + '"'
		];

		crownGalleryFrames[targetCrownGalleryInputName] = wp.media.frames.crownGalleryFrames[targetCrownGalleryInputName] = wp.media.gallery.edit('[gallery ' + attributes.join(' ') + ']');
		$(crownGalleryFrames[targetCrownGalleryInputName].el).addClass('hidden-gallery-settings');
		crownGalleryFrames[targetCrownGalleryInputName].on('update', function(data) {
			setGallery(targetCrownGalleryInput, data.models, data.gallery.attributes);
		});

	}

	function setGallery(galleryInput, images, gallerySettings) {

		console.log(gallerySettings);

		$('ul.gallery-images li', galleryInput).remove();
		galleryInput.removeClass('has-media');

		for(var i = 0; i < images.length; i++) {
			var attachment = images[i].attributes;

			var previewPath = attachment.icon;
			if(attachment.type == 'image') {
				var previewPath = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.sizes.full.url;
			}

			var galleryImage = $('<li></li>');
			galleryImage.append('<input type="hidden" name="' + galleryInput.data('basename') + '[]" value="' + attachment.id + '">');
			galleryImage.append('<img class="thumbnail" src="' + previewPath + '">');
			galleryImage.append('<a class="gallery-image-remove" href="#" title="Remove Image">&times;</a>');

			$('ul.gallery-images', galleryInput).append(galleryImage);
			galleryInput.addClass('has-media');

		}

	}

	function removeImage(e) {
		e.preventDefault();
		var galleryImage = $(this).closest('li');
		var galleryInput = galleryImage.closest('.crown-gallery-input');
		if($('ul.gallery-images > li', galleryInput).length == 1) {
			galleryInput.removeClass('has-media');
		}
		galleryImage.remove();
	}

})(jQuery);