(function($) {

	$(document).ready(function() {

		$(document).on('click', '.crown-field.repeater .add-field-repeater-entry', addFieldRepeaterEntry);
		$(document).on('click', '.crown-field.flex-repeater .add-flex-field-repeater-entry-options .options a', addFieldRepeaterEntry);
		$(document).on('click', '.crown-field.repeater .entry .remove-field-repeater-entry', removeFieldRepeaterEntry);

		$('.crown-field.repeater.flex-repeater').each(function(i, el) {
			var addEntryOptions = $('> .input-wrap > .add-flex-field-repeater-entry-options', el);
			var entries = $('> .input-wrap > .field-repeater-entries > .entry', el);
			entries.each(function(j, el2) {
				$('> .add-field-repeater-entry-container.before', el2).append(addEntryOptions.clone().addClass('mid-list before'));
				$('> .add-field-repeater-entry-container.after', el2).append(addEntryOptions.clone().addClass('mid-list after'));
			});
		});

		$('.crown-field.repeater .field-repeater-entries').sortable({
			items: '> .entry:not(.tpl)',
			handle: '> .sort-handle, > .entry-header'
		}).on('sortstart', function(event) {
			event.stopPropagation();
			triggerWPEditors(event, false);
		}).on('sortstop', function(event) {
			event.stopPropagation();
			triggerWPEditors(event, true);
		});

		$(document).on('click', '.crown-field.repeater .entry .entry-header', function(e) {
			var entry = $(this).closest('.entry');
			entry.toggleClass('collapsed');
		});

		$(document).on('click', '.crown-field.flex-repeater .add-flex-field-repeater-entry-options .dropdown-toggle', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var wrap = $(this).closest('.add-flex-field-repeater-entry-options');
			$('.crown-field.flex-repeater .add-flex-field-repeater-entry-options.active').not(wrap).removeClass('active');
			wrap.toggleClass('active');
			var wrapParent = wrap.is('.mid-list') ? wrap.parent() : false;
			if(wrapParent && wrapParent.length) {
				$('.crown-field.flex-repeater .entry > .add-field-repeater-entry-container.active').not(wrapParent).removeClass('active');
				wrapParent.toggleClass('active');
			} else {
				$('.crown-field.flex-repeater .entry > .add-field-repeater-entry-container.active').removeClass('active');
			}
		});
		$(document).on('click', '.crown-field.flex-repeater .add-flex-field-repeater-entry-options .dropdown', function(e) {
			e.stopPropagation();
		});
		$(document).on('click', function(e) {
			$('.crown-field.flex-repeater .add-flex-field-repeater-entry-options.active').removeClass('active');
			$('.crown-field.flex-repeater .entry > .add-field-repeater-entry-container.active').removeClass('active');
		});

		$(document).on('click', '.crown-field.repeater .field-repeater-entry-controls .collapse-expand', function(e) {
			e.preventDefault();
			var entries = $(this).closest('.field-repeater-entry-controls').siblings('.field-repeater-entries').children().not('.tpl');
			if(entries.filter('.collapsed').length == entries.length) {
				entries.removeClass('collapsed');
			} else {
				entries.addClass('collapsed');
			}
		});

	});

	function addFieldRepeaterEntry(e) {
		e.preventDefault();
		var entriesContainer = $(this).closest('.crown-field.repeater').find('> .input-wrap > .field-repeater-entries');
		var entry = null;
		var appendBeforeEntry = false;
		if($(this).closest('.crown-field.repeater').hasClass('flex-repeater')) {
			$('.crown-field.flex-repeater .add-flex-field-repeater-entry-options.active').removeClass('active');
			$('.crown-field.flex-repeater .entry > .add-field-repeater-entry-container.active').removeClass('active');
			var entryType = $(this).data('entry-type');
			entry = $('> .entry.tpl.type-' + entryType, entriesContainer).clone();
			if($(this).closest('.add-flex-field-repeater-entry-options').is('.mid-list.before')) appendBeforeEntry = $(this).closest('.entry');
		} else {
			entry = $('> .entry.tpl', entriesContainer).clone();
			if($(this).is('.mid-list.before')) appendBeforeEntry = $(this).closest('.entry');
		}
		var timestamp = new Date().getTime();

		entry.removeClass('tpl');
		$('input, select, textarea', entry).each(function(i, el) {
			if($(el).closest('.field-repeater-entries').length) {
				if($(el).hasClass('rich-textarea-settings')) {
					$(el).val($(el).val().replace('{{index}}', 'new_entry_' + timestamp));
				} else if($(el).data('tpl-name')) {
					$(el).attr('data-tpl-name', $(el).data('tpl-name').replace('{{index}}', 'new_entry_' + timestamp));
				}
			} else {
				if($(el).hasClass('rich-textarea-settings')) {
					var input = $(el);
					var data = JSON.parse(input.val());
					data.action = 'get_rich_textarea';
					data.id = data.id + timestamp;
					data.settings.textarea_name = data.settings.textarea_name.replace('{{index}}', 'new_entry_' + timestamp);
					$.get(crownFormFieldRepeaterData.ajaxUrl, data, function(response) {
						input.after(response);
						input.remove();
						var textareas = $('textarea.wp-editor-area', response);
						textareas.each(function(i, el) {
							var editorId = $(el).attr('id');
							var tinymceSettings = tinyMCEPreInit.mceInit[editorId];
							tinymceSettings.setup = function(ed) {
								ed.on('init', function(e) {
									if($('#wp-' + editorId + '-wrap').hasClass('html-active')) {
										$('#wp-' + editorId + '-wrap textarea.wp-editor-area').show();
										$('#wp-' + editorId + '-wrap .mce-tinymce').hide();
										$('#' + editorId + '-html').trigger('click');
									}
								});
							};
							tinyMCE.init(tinymceSettings);
							quicktags(tinyMCEPreInit.qtInit[editorId]);
							QTags._buttonsInit();
						});
					});
				} else if($(el).data('tpl-name')) {
					$(el).attr('name', $(el).data('tpl-name').replace('{{index}}', 'new_entry_' + timestamp));
					if($(el).data('tpl-required') == 1) $(el).attr('required', true);
				}
			}
		});
		$('.crown-gallery-input', entry).each(function(i, el) {
			$(el).attr('data-basename', $(el).attr('data-basename').replace('{{index}}', 'new_entry_' + timestamp));
		});

		$('.google-map.map-configured', entry).each(function(i, el) {
			if(!$(el).closest('.entry').hasClass('tpl')) {
				var oldId = $(el).attr('id');
				var newId = 'google-map-' + Math.floor(Math.random() * 2147483647);
				$(el).attr('id', newId);
				$(el).next('script').html($(el).next('script').html().replace(oldId, newId));
				window.googleMapSettings[newId] = $.extend({}, window.googleMapSettings[oldId], { autoInit: true });
			}
		});

		$('.crown-field.repeater .field-repeater-entries', entry).sortable({
			items: '> .entry:not(.tpl)',
			handle: '> .sort-handle'
		}).on('sortstart', function(event) {
			event.stopPropagation();
			triggerWPEditors(event, false);
		}).on('sortstop', function(event) {
			event.stopPropagation();
			triggerWPEditors(event, true);
		});

		$('.crown-checkbox-set-input.sortable > .inner', entry).sortable();

		if(appendBeforeEntry && appendBeforeEntry.length) {
			appendBeforeEntry.before(entry);
		} else {
			entriesContainer.append(entry);
		}

		$('.crown-colorpicker-input', entry).trigger('initColorpicker');

		$('.google-map.map-configured', entry).each(function(i, el) {
			if(!$(el).closest('.entry').hasClass('tpl')) {
				$(el).trigger('googleMapAutoInit');
			}
		});

		entry.trigger('repeaterEntryAdded');

	}

	function removeFieldRepeaterEntry(e) {
		e.preventDefault();
		var entry = $(this).closest('.entry');
		if(entry.hasClass('tpl')) return;
		if(confirm('Are you sure you want to remove this entry?')) {
			entry.trigger('repeaterEntryRemove');
			entry.remove();
		}
	}

	function triggerWPEditors(event, creatingEditor) {
		$('textarea.wp-editor-area', $(event.srcElement).closest('.entry')).each(function(i, el) {
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