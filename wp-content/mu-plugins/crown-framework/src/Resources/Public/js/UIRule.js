(function($) {

	$(document).ready(function() {

		initPostParentListener();
		initPostFormatListener();
		initTaxonomyTermListener();
		initPageTemplateListener();
		initInputListeners();

		initMetaBoxPrefs();

		refreshConditionalUIFields();

		$(document).on('repeaterEntryAdded', initInputListeners);

	});

	$.crownUIRule = (function(crownUIRule) {

		crownUIRule.initMetaBox = function(id, rules) {
			$('#' + id).data('conditional-ui-rules', rules);
		};

		return crownUIRule;

	})({});

	function refreshConditionalUIFields() {

		$('.crown-field.conditional-ui, .postbox.conditional-ui').each(function(i, el) {
			var rules = $(el).data('conditional-ui-rules');
			for(var j in rules) {
				if(!rules[j].passed) {
					$(el).removeClass('conditional-ui-active');
					return true;
				}
			}
			$(el).addClass('conditional-ui-active');
		});

		$('.crown-field.group.conditional-ui').each(function(i, el) {
			if($(el).parent().hasClass('group-set-field-group')) {
				var group = $(el).parent();
				var tab = group.closest('.group-set-wrap').find('> .group-set-nav > li:eq(' + group.index() + ')');
				if($(el).hasClass('conditional-ui-active')) {
					group.removeClass('disabled');
					tab.removeClass('disabled');
				} else {
					group.addClass('disabled');
					tab.addClass('disabled');
					if(tab.hasClass('active')) {
						tab.next().find('> a').trigger('click');
					}
				}
			}
		});

	}

	function initPostParentListener() {
		$('#parent_id').on('change', function(e) {
			var parentId = parseInt($('option:selected', this).val());
			$('.conditional-ui-property-postParent').each(function(i, el) {
				var rules = $(el).data('conditional-ui-rules');
				for(var j in rules) {
					if(rules[j].property == 'postParent') {
						switch(rules[j].compare.toLowerCase()) {

							case '!=':
							case 'not in':
								rules[j].passed = $.inArray(parentId, rules[j].value) < 0;
								break;
							
							default:
								rules[j].passed = $.inArray(parentId, rules[j].value) >= 0;
								break;

						}
					}
				}
				$(el).data('conditional-ui-rules', rules);
			});
			refreshConditionalUIFields();
		});
	}

	function initPostFormatListener() {
		$('#post-formats-select input.post-format').on('change', function(e) {
			var postFormat = $('#post-formats-select input.post-format:checked').val();
			$('.conditional-ui-property-postFormat').each(function(i, el) {
				var rules = $(el).data('conditional-ui-rules');
				for(var j in rules) {
					if(rules[j].property == 'postFormat') {
						switch(rules[j].compare.toLowerCase()) {

							case '!=':
							case 'not in':
								rules[j].passed = $.inArray(postFormat, rules[j].value) < 0;
								break;
							
							default:
								rules[j].passed = $.inArray(postFormat, rules[j].value) >= 0;
								break;

						}
					}
				}
				$(el).data('conditional-ui-rules', rules);
			});
			refreshConditionalUIFields();
		});
	}

	function initTaxonomyTermListener() {
		$('.categorydiv .categorychecklist').on('change', 'input[type=checkbox]', function(e) {
			var checklist = $(this).closest('ul.categorychecklist');
			var taxonomy = checklist.attr('id').replace(/checklist(-pop)?$/, '');
			var terms = [];
			$('li input[type=checkbox]:checked', checklist).each(function(i, el) {
				terms.push(parseInt($(el).val()));
			});

			$('.conditional-ui-property-taxonomyTerm').each(function(i, el) {
				var rules = $(el).data('conditional-ui-rules');
				for(var j in rules) {
					if(rules[j].property == 'taxonomyTerm' && rules[j].options.taxonomy == taxonomy) {
						var matches = $(rules[j].value).filter(terms);
						switch(rules[j].compare.toLowerCase()) {

							case '!=':
							case 'not in':
								rules[j].passed = !matches.length;
								break;
							
							default:
								rules[j].passed = matches.length;
								break;

						}
					}
				}
				$(el).data('conditional-ui-rules', rules);
			});
			refreshConditionalUIFields();
		});
	}

	function initPageTemplateListener() {
		$('#page_template').on('change', function(e) {
			var pageTemplate = $('option:selected', this).val();
			$('.conditional-ui-property-pageTemplate').each(function(i, el) {
				var rules = $(el).data('conditional-ui-rules');
				for(var j in rules) {
					if(rules[j].property == 'pageTemplate') {
						switch(rules[j].compare.toLowerCase()) {

							case '!=':
							case 'not in':
								rules[j].passed = $.inArray(pageTemplate, rules[j].value) < 0;
								break;
							
							default:
								rules[j].passed = $.inArray(pageTemplate, rules[j].value) >= 0;
								break;

						}
					}
				}
				$(el).data('conditional-ui-rules', rules);
			});
			refreshConditionalUIFields();
		});
	}

	function initInputListeners() {
		$('.conditional-ui-property-input').not('.conditional-ui-property-input-initialized').each(function(i, el) {
			if($(el).closest('.entry.tpl').length) return;
			initInputListener($(el));
			$(el).addClass('conditional-ui-property-input-initialized');
		});
	}

	function initInputListener(element) {
		var rules = element.data('conditional-ui-rules');
		for(var i in rules) {
			if(rules[i].property == 'input') {
				var inputName = rules[i].options.inputName;
				var container = element.closest('.entry-fields');
				var inputs = [];
				while(container.length && !inputs.length) {
					inputs = findInputs(inputName, container);
					container = container.parent().closest('.entry-fields');
				}
				if(!inputs.length) {
					inputs = findInputs(inputName, $('body'));
				}
				inputs.each(function(j, el) {
					var targetElements = $(el).data('conditional-ui-target-elements');
					if(targetElements === undefined) targetElements = [];
					targetElements.push({ element: element, ruleIndex: i });
					$(el).data('conditional-ui-target-elements', targetElements);
				});
				inputs.on('change', handleConditionalInputChange).trigger('change');
			}
		}
	}

	function findInputs(targetInputName, container) {
		var inputs = $('input, textarea, select', container).filter(function(i, el) {
			if($(el).attr('name') === undefined) return false;
			var inputName = $(el).attr('name').replace(/\[\]$/, '').replace(/^.+\[/g, '').replace(/\]$/, '').trim();
			return inputName == targetInputName.trim();
		});
		if(inputs.length > 1) {
			var inputName = null;
			var valid = true;
			inputs.each(function(i, el) {
				var type = $(el).attr('type') !== undefined ? $(el).attr('type').trim() : 'text';
				if(type != 'checkbox' && type != 'radio') valid = false;
				if(inputName === null) inputName = $(el).attr('name').trim();
				if($(el).attr('name').trim() != inputName) valid = false;
				if(!valid) return false;
			});
			if(!valid) inputs = $();
		}
		return inputs;
	}

	function handleConditionalInputChange(e) {
		var input = $(e.target);

		var value = input.val();
		if(input.attr('type') == 'checkbox' || input.attr('type') == 'radio') {
			var inputs = $('input[type=' + input.attr('type') + ']').filter(function(i, el) { return $(el).attr('name') == input.attr('name'); });
			if(input.attr('type') == 'radio') {
				value = inputs.filter(':checked').length ? inputs.filter(':checked').first().val() : null;
			} else {
				value = [];
				inputs.filter(':checked').each(function(i, el) { value.push($(el).val()); });
			}
		}
		if(!Array.isArray(value)) value = [value];

		var targetElements = input.data('conditional-ui-target-elements');
		for(i in targetElements) {
			var element = $(targetElements[i].element);
			var rules = element.data('conditional-ui-rules');
			var rule = rules[targetElements[i].ruleIndex];
			var ruleValues = rule.value.map(function(n) { return String(n); });
			var valueIntersect = $(value).filter(ruleValues);
			var passed = false;
			if(rule.compare.toLowerCase() == '!=' || rule.compare.toLowerCase() == 'not in') {
				rule.passed = !valueIntersect.length;
			} else {
				rule.passed = valueIntersect.length;
			}
		};

		refreshConditionalUIFields();
	}

	function initMetaBoxPrefs() {
		$('.postbox.conditional-ui').each(function(i, el) {
			var elId = $(el).attr('id');
			$('#adv-settings .metabox-prefs label[for="' + elId + '-hide"]').hide();
		});
	}

})(jQuery);