(function($) {

	$(document).ready(function() {

		$(document).on('repeaterEntryAdded', '.crown-field.repeater.field-table-columns > .input-wrap > .field-repeater-entries > .entry', addColumnFieldRepeaterEntry);
		$(document).on('repeaterEntryRemove', '.crown-field.repeater.field-table-columns > .input-wrap > .field-repeater-entries > .entry', removeColumnFieldRepeaterEntry);
		$(document).on('keyup', '.crown-field.repeater.field-table-columns input.field-table-column-title-input', updateColumnTitle);
		$(document).on('sortupdate', '.crown-field.repeater.field-table-columns > .input-wrap > .field-repeater-entries', updateColumnOrder);
		$(document).on('repeaterEntryAdded', '.crown-field.repeater.field-table-rows > .input-wrap > .field-repeater-entries > .entry', addRowFieldRepeaterEntry);

		initFieldTables();

	});

	function addColumnFieldRepeaterEntry(e) {
		var entry = $(e.target);
		var fieldTable = entry.closest('.crown-field.group-set.field-table');

		var entryIdInput = $('input[type=hidden]', entry).filter(function(i, el) { return $(el).attr('name') !== undefined && $(el).attr('name').match(/\[new_entry_\d+\]\[crown_repeater_entry_id\]$/); }).first();
		entry.data('crown-field-table-column-title', '');
		
		var columnCellEntries = $();

		var rowFieldRepeaterEntryIdInputName = entryIdInput.data('tpl-name').replace(/(\[?[^\]]+_)columns(\]?\[{{index}}\])/, '$1rows$2');
		rowFieldRepeaterEntryIdInputName = rowFieldRepeaterEntryIdInputName.replace(/\[new_entry_\d+\]/, '[{{index}}]');
		var rowFieldRepeaterEntryContainer = $('.entry.tpl input[type=hidden]', fieldTable).filter(function(i, el) { return $(el).data('tpl-name') == rowFieldRepeaterEntryIdInputName; }).first().closest('.field-repeater-entries');
		$('> .entry:not(.tpl)', rowFieldRepeaterEntryContainer).each(function(i, el) {
			var rowEntry = $(el);
			var cellFieldRepeaterEntryContainer = $('> .entry-fields > .crown-field.repeater.field-table-cells', rowEntry);
			$('> .input-wrap > .field-repeater-entries', cellFieldRepeaterEntryContainer).one('repeaterEntryAdded', '> .entry', function(e) {
				var cellEntry = $(e.target);
				$('> .entry-fields > fieldset.crown-field.group > legend', cellEntry).text('');
				columnCellEntries = $.merge(columnCellEntries, cellEntry);
			});
			$('> .input-wrap > button.add-field-repeater-entry', cellFieldRepeaterEntryContainer).trigger('click');
		});

		entry.data('crown-field-table-column-cell-entries', columnCellEntries);

	}

	function removeColumnFieldRepeaterEntry(e) {
		var columnEntry = $(e.target);
		var columnCellEntries = columnEntry.data('crown-field-table-column-cell-entries');
		columnCellEntries.remove();
	}

	function updateColumnTitle(e) {
		var input = $(e.target);
		var columnEntry = input.closest('.entry');
		var columnTitle = input.val();
		columnEntry.data('crown-field-table-column-title', columnTitle);
		var columnCellEntries = columnEntry.data('crown-field-table-column-cell-entries');
		columnCellEntries.each(function(i, el) {
			var cellEntry = $(el);
			$('> .entry-fields > fieldset.crown-field.group > legend', cellEntry).text(columnTitle);
		});
	}

	function updateColumnOrder(e, ui) {
		$('> .entry:not(.tpl)', e.target).each(function(i, el) {
			var columnEntry = $(el);
			var columnCellEntries = columnEntry.data('crown-field-table-column-cell-entries');
			columnCellEntries.each(function(j, el2) {
				var cellEntry = $(el2);
				var cellEntryContainer = cellEntry.closest('.field-repeater-entries');
				cellEntryContainer.append(cellEntry);
				cellEntryContainer.sortable('refreshPositions');
			});
		});
	}

	function addRowFieldRepeaterEntry(e) {
		var entry = $(e.target);
		var fieldTable = entry.closest('.crown-field.group-set.field-table');
		var cellFieldRepeaterEntryContainer = $('> .entry-fields > .crown-field.repeater.field-table-cells', entry);
		var entryIdInput = $('input[type=hidden]', entry).filter(function(i, el) { return $(el).attr('name') !== undefined && $(el).attr('name').match(/\[new_entry_\d+\]\[crown_repeater_entry_id\]$/); }).first();

		var columnFieldRepeaterEntryIdInputName = entryIdInput.data('tpl-name').replace(/(\[?[^\]]+_)rows(\]?\[{{index}}\])/, '$1columns$2');
		columnFieldRepeaterEntryIdInputName = columnFieldRepeaterEntryIdInputName.replace(/\[new_entry_\d+\]/, '[{{index}}]');
		var columnFieldRepeaterEntryContainer = $('.entry.tpl input[type=hidden]', fieldTable).filter(function(i, el) { return $(el).data('tpl-name') == columnFieldRepeaterEntryIdInputName; }).first().closest('.field-repeater-entries');
		$('> .entry:not(.tpl)', columnFieldRepeaterEntryContainer).each(function(i, el) {
			var columnEntry = $(el);
			var columnTitle = columnEntry.data('crown-field-table-column-title');
			var columnCellEntries = columnEntry.data('crown-field-table-column-cell-entries');
			$('> .input-wrap > .field-repeater-entries', cellFieldRepeaterEntryContainer).one('repeaterEntryAdded', '> .entry', function(e) {
				var cellEntry = $(e.target);
				$('> .entry-fields > fieldset.crown-field.group > legend', cellEntry).text(columnTitle);
				columnCellEntries = $.merge(columnCellEntries, cellEntry);
			});
			$('> .input-wrap > button.add-field-repeater-entry', cellFieldRepeaterEntryContainer).trigger('click');
			columnEntry.data('crown-field-table-column-cell-entries', columnCellEntries);
		});
	}

	function initFieldTables() {
		$('.crown-field.repeater.field-table-columns > .input-wrap > .field-repeater-entries').each(function(i, el) {
			var columnFieldRepeaterEntryContainer = $(el);
			var fieldTable = columnFieldRepeaterEntryContainer.closest('.crown-field.group-set.field-table');

			var columnEntryTpl = $('> .entry.tpl', columnFieldRepeaterEntryContainer).first();
			var columnEntryTplIdInput = $('input[type=hidden]', columnEntryTpl).filter(function(j, el2) { return $(el2).data('tpl-name').match(/_columns\]?\[{{index}}\]\[crown_repeater_entry_id\]$/); }).first();
			var rowFieldRepeaterEntryIdInputName = columnEntryTplIdInput.data('tpl-name').replace(/(\[?[^\]]+_)columns(\]?\[{{index}}\])/, '$1rows$2');
			var rowFieldRepeaterEntryContainer = $('.entry.tpl input[type=hidden]', fieldTable).filter(function(j, el2) { return $(el2).data('tpl-name') == rowFieldRepeaterEntryIdInputName; }).first().closest('.field-repeater-entries');

			$('> .entry:not(.tpl)', columnFieldRepeaterEntryContainer).each(function(j, el2) {
				var columnEntry = $(el2);

				var entryIdInput = $('input[type=hidden]', columnEntry).filter(function(k, el3) { return $(el3).attr('name') !== undefined && $(el3).attr('name').match(/\[entry_\d+\]\[crown_repeater_entry_id\]$/); }).first();
				var columnTitle = entryIdInput.next().find('> .input-wrap > input').val();
				columnEntry.data('crown-field-table-column-title', columnTitle);

				var columnCellEntries = $();

				$('> .entry:not(.tpl)', rowFieldRepeaterEntryContainer).each(function(k, el3) {
					var rowEntry = $(el3);
					var cellEntries = $('> .entry-fields > .crown-field.repeater.field-table-cells > .input-wrap > .field-repeater-entries > .entry:not(.tpl)', rowEntry);
					var columnCellEntry = cellEntries.eq(j);
					$('> .entry-fields > fieldset.crown-field.group > legend', columnCellEntry).text(columnTitle);
					columnCellEntries = $.merge(columnCellEntries, columnCellEntry);
				});

				columnEntry.data('crown-field-table-column-cell-entries', columnCellEntries);
			});
		});
	}

})(jQuery);