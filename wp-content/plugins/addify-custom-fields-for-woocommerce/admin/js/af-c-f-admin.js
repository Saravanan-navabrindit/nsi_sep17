	var ajaxurl = af_c_f_php_vars.admin_url;
	var nonce = af_c_f_php_vars.nonce;
	var url = af_c_f_php_vars.url;
	jQuery(document).ready(function ($) {

		jQuery( '.af_c_f_field_products' ).select2({
			ajax: {
							url: ajaxurl, // AJAX URL is predefined in WordPress admin.
							dataType: 'json',
							type: 'POST',
							delay: 20, // Delay in ms while typing when to perform a AJAX search.
							data: function (params) {
								return {
									q: params.term, // search query
									action: 'afcf_search_products', // AJAX action for admin-ajax.php.//aftaxsearchUsers(is function name which isused in adminn file)
									nonce: nonce // AJAX nonce for admin-ajax.php.
								};
							},
							processResults: function ( data ) {
								var options = [];
								if (data ) {
									 // data is the array of arrays, and each of them contains ID and the Label of the option.
									$.each(
										data,
										function ( index, text ) {
											// do not forget that "index" is just auto incremented value.
											options.push( { id: text[0], text: text[1]  } );
										}
										);
								}
								return {
									results: options
								};
							},
							cache: true
						},
						multiple: true,
						placeholder: 'Choose Products',
						minimumInputLength: 3 // the minimum of symbols to input before perform a search.
					});


		$('.af_c_f_field_categories').select2({
			ajax: {
			url: ajaxurl, // AJAX URL is predefined in WordPress admin
			dataType: 'json',
			type: 'POST',
			delay: 250, // delay in ms while typing when to perform a AJAX search
			data: function (params) {
				return {
					q: params.term, // search query
					action: 'afcf_search_product_categories', // AJAX action for admin-ajax.php
					nonce: nonce // AJAX nonce for admin-ajax.php
				};
			},
			processResults: function (data) {
				var options = [];
				if (data) {

					// data is the array of arrays, and each of them contains ID and the Label of the option
					$.each(data, function (index, text) { // do not forget that "index" is just auto incremented value
						options.push({ id: text[0], text: text[1] });
					});

				}
				return {
					results: options
				};
			},
			cache: true
		},
		multiple: true,
		minimumInputLength: 3 // the minimum of symbols to input before perform a search

	});

		$('.af_c_f_field_tags').select2();

		function is_element_dependent(element) {

			if (element.closest('p').hasClass('af_c_f_is_dependable')) {
				return true;
			}

			return false;
		}

		function is_element_visible(element) {

			if (element.closest('p').is(':visible') && element.is(':visible')) {
				return true;
			}

			return false;
		}

		function multiple_items_dependent_fields(elements) {

			if (!Array.isArray(elements)) {
				return is_element_has_dependent_fields(elements);
			}

			let child_elements = [];

			$.each(elements, function (index, element) {

				let next_level_elements = is_element_has_dependent_fields(element);

				if (next_level_elements && Array.isArray(next_level_elements)) {
					child_elements = child_elements.concat(next_level_elements);
				}
			});

			return child_elements;
		}

		function is_element_has_dependent_fields(element) {

			let id_of_element = '';

			if (Array.isArray(element)) {

				id_of_element = [];

				$.each(element, function (index, elem) {

					id_of_element.push(elem.attr('id'));
				});

			} else {

				id_of_element = element.attr('id');
			}

			let child_elements = [];

			$('p.af_c_f_is_dependable').find('input:first, select, textarea, label.checkbox').each(function () {

				let dependent_on = $(this).data('dependent_on');

				if (Array.isArray(id_of_element)) {

					if (id_of_element.includes(dependent_on)) {
						child_elements.push($(this));
					}

				} else {

					if (dependent_on == id_of_element) {
						child_elements.push($(this));
					}
				}
			});

			if (child_elements.length < 1) {

				return false;
			}

			return child_elements;
		}

		function hide_multilevel_dependendent_fields(element) {

			while (element = is_element_has_dependent_fields(element)) {

				if (Array.isArray(element)) {

					$.each(element, function (index, child_element) {
						child_element.closest('tr').hide();
						child_element.trigger('change');

						if (child_element.prop('required')) {
							child_element.attr('data-required', 'required');
							child_element.prop('required', false);
						}
					});

				} else {

					element.closest('tr').hide();

					if (element.prop('required')) {
						element.attr('data-required', 'required');
						element.prop('required', false);
					}

					element.trigger('change');
				}
			}
		}

		function show_multilevel_dependendent_fields(element) {

			while (element = is_element_has_dependent_fields(element)) {

				if (Array.isArray(element)) {

					$.each(element, function (index, child_element) {
						child_element.closest('tr').show();
						child_element.trigger('change');

						if (child_element.data('required')) {
							child_element.prop('required', true);
						}
					});

				} else {

					element.closest('tr').show();

					if (element.data('required')) {
						element.prop('required', true);
					}

					element.trigger('change');
				}
			}
		}

		$('tr.af_c_f_is_dependable').find('input:first, select, textarea, label.checkbox').each(function () {

			var field_name = $(this).data('dependent_on');
			var field_value = $(this).data('dependent_val');

			var radio = false;

			if (!field_value || field_value.length < 1) {
				return;
			}

			if (!document.getElementById(field_name)) {

				if (document.getElementById(field_name + '_1')) {

					field_name = field_name + '_1';

					radio = true;
				}
			}

			if ('string' != typeof field_value) {
				field_value = field_value.toString();
			}

			var current_element = $(this);

			var parent_element = $(document).find('#' + field_name);

			var values = parent_element.val();

			if ('checkbox' == parent_element.attr('type')) {

				var parent_elements = parent_element.closest('tr').find('input[type="checkbox"]');

				if (parent_elements.length > 1) {

					values = [];

					var selected_elements = parent_element.closest('tr').find('input[type="checkbox"]:checked');

					selected_elements.each(function () {

						values.push($(this).val());
					});

				} else {

					if (parent_element.is(':checked')) {
						current_element.closest('tr').show();

						if (is_element_has_dependent_fields(current_element)) {
							show_multilevel_dependendent_fields(current_element);
						}
					} else {
						current_element.closest('tr').hide();
					}
				}

			} else if ('radio' == parent_element.attr('type')) {

				var parent_elements = parent_element.closest('tr').find('input[type="radio"]');

				if (parent_elements.length > 1) {

					values = parent_element.closest('tr').find('input[type="radio"]:checked').val();

				} else {

					if (parent_element.is(':checked')) {
						current_element.closest('tr').show();
						if (is_element_has_dependent_fields(current_element)) {
							show_multilevel_dependendent_fields(current_element);
						}
					} else {
						current_element.closest('tr').hide();
					}
				}
			}

			var values_array = field_value.split(',');

			if (values_array.length < 1) {
				current_element.closest('tr').hide();
				return;
			}

			if (Array.isArray(values)) {

				let intersection = values_array.filter(x => values.includes(x));

				if (intersection.length < 1) {

					current_element.closest('tr').hide();

					if (current_element.prop('required')) {
						current_element.attr('data-required', 'required');
						current_element.prop('required', false);
					}

				} else {

					if (current_element.data('required')) {

						current_element.prop('required', true);
					}

					current_element.closest('tr').show();

					if (is_element_has_dependent_fields(current_element)) {
						show_multilevel_dependendent_fields(current_element);
					}
				}

			} else {

				if (values_array.includes(values)) {

					if (current_element.data('required')) {

						current_element.prop('required', true);
					}

					current_element.closest('tr').show();

					if (is_element_has_dependent_fields(current_element)) {
						show_multilevel_dependendent_fields(current_element);
					}

				} else {

					if (current_element.prop('required')) {
						current_element.attr('data-required', 'required');
						current_element.prop('required', false);
					}

					current_element.closest('tr').hide();
				}
			}

			if (!parent_element.is(':visible')) {

				current_element.closest('tr').hide();
			}

			if (radio) {

				$('#' + field_name).closest('tr').find('input').each(function () {

					field_name += ',#' + $(this).attr('id');
				});
			}

			$(document).on('change', '#' + field_name, function () {

				var values = $(this).val();

				var parent_element = $(this);

				var values_array = field_value.split(',');

				if ('checkbox' == parent_element.attr('type')) {

					var parent_elements = parent_element.closest('tr').find('input[type="checkbox"]');

					if (parent_elements.length > 1) {

						values = [];

						var selected_elements = parent_element.closest('tr').find('input[type="checkbox"]:checked');

						selected_elements.each(function () {

							values.push($(this).val());
						});

					} else {

						if (parent_element.is(':checked')) {
							current_element.closest('tr').show();
							if (is_element_has_dependent_fields(current_element)) {
								show_multilevel_dependendent_fields(current_element);
							}
						} else {
							current_element.closest('tr').hide();

							if (is_element_has_dependent_fields(current_element)) {

								hide_multilevel_dependendent_fields(current_element);
							}
						}

						return;
					}

				} else if ('radio' == parent_element.attr('type')) {

					var parent_elements = parent_element.closest('tr').find('input[type="radio"]');

					if (parent_elements.length > 1) {

						values = parent_element.closest('tr').find('input[type="radio"]:checked').val();

					} else {

						if (parent_element.is(':checked')) {
							current_element.closest('tr').show();
							if (is_element_has_dependent_fields(current_element)) {
								show_multilevel_dependendent_fields(current_element);
							}
						} else {
							current_element.closest('tr').hide();
							if (is_element_has_dependent_fields(current_element)) {

								hide_multilevel_dependendent_fields(current_element);
							}
						}
					}
				}

				if (values_array.length < 1) {
					current_element.hide();
					if (is_element_has_dependent_fields(current_element)) {

						hide_multilevel_dependendent_fields(current_element);
					}
					return;
				}

				if (Array.isArray(values)) {

					let intersection = values_array.filter(x => values.includes(x));

					if (intersection.length < 1) {

						current_element.closest('tr').hide();

						if (current_element.prop('required')) {
							current_element.attr('data-required', 'required');
							current_element.prop('required', false);
						}

						if (is_element_has_dependent_fields(current_element)) {

							hide_multilevel_dependendent_fields(current_element);
						}

					} else {

						if (current_element.data('required')) {

							current_element.prop('required', true);
						}

						current_element.closest('tr').show();

						if (is_element_has_dependent_fields(current_element)) {
							show_multilevel_dependendent_fields(current_element);
						}
					}

				} else {

					if (values_array.includes(values)) {

						if (current_element.data('required')) {

							current_element.prop('required', true);
						}

						current_element.closest('tr').show();

						if (is_element_has_dependent_fields(current_element)) {
							show_multilevel_dependendent_fields(current_element);
						}

					} else {

						if (current_element.prop('required')) {
							current_element.attr('data-required', 'required');
							current_element.prop('required', false);
						}

						current_element.closest('tr').hide();

						if (is_element_has_dependent_fields(current_element)) {

							hide_multilevel_dependendent_fields(current_element);
						}

					}
				}
			});
		});
});

	jQuery(document).ready(function ($) {

		"use strict";

		var form_enc = jQuery('form').attr("enctype");
		if (form_enc != 'multipart/form-data') {
			jQuery('form').attr("enctype", "multipart/form-data");
		}

		$('.af_cf_accordion').accordion({
			collapsible: true
		});

		$('.af_cf_accordion table.droppable tbody').sortable();

		$(document).on('click', '.af_cf_accordion span.dashicons-remove', function () {

			$(this).prop('disabled', true);

			var current_row = $(this).closest('tr');
			var field_key = $(this).closest('tr').data('field_key');
			var draggable_row = $(this).closest('.af_ac_role_container').find('table.draggable').find('.' + field_key);
			var text = $(this).closest('.af_ac_role_container').find('span.click-to-select').text();

			var click_to_select = '<span title="' + text + '" class="dashicons dashicons-plus-alt"></span>';

			$(this).closest('tr').css('opacity', 0.5);

			draggable_row.fadeOut(2000, function (current_row) {

				$(this).find('span.dashicons-yes').replaceWith(click_to_select);
				$(this).fadeIn(2000);
			});

			$(this).fadeOut(2000, function () {
				$(this).closest('tr').remove();
			});
		});

		var type = $('select.af_c_f_dep_fields').find('option:selected').data('field_type');

		if (!$('select.af_c_f_dep_fields').is(':visible')) {

			$('input.af_c_f_dependable_values').attr('value', '');
			$('div.af_c_f_dependable_values').hide();

		} else if (['select', 'multiselect', 'multi_checkbox', 'radio'].includes(type)) {

			if ($('input.af_c_f_dependable_values').val().length < 1) {

				$('input.af_c_f_dependable_values').val($(this).find('option:selected').data('field_options'));
			}

			$('div.af_c_f_dependable_values').show();

		} else {

			$('input.af_c_f_dependable_values').attr('value', '');
			$('div.af_c_f_dependable_values').hide();
		}

		$(document).on('change', 'select.af_c_f_dep_fields', function () {

			var type = $(this).find('option:selected').data('field_type');
			$('input.af_c_f_dependable_values').attr('value', '');
			$('div.af_c_f_dependable_values').hide();

			if (['select', 'multiselect', 'multi_checkbox', 'radio'].includes(type)) {

				$('input.af_c_f_dependable_values').val($(this).find('option:selected').data('field_options'));

				$('div.af_c_f_dependable_values').show();
			}
		});

		$(document).on('click', '.af_cf_accordion span.dashicons-plus-alt', function () {

			$(this).prop('disabled', true);

			var current_row = $(this).closest('tr');
			var field_key = $(this).closest('tr').data('field_key');
			var sort_text = $(this).closest('.af_ac_role_container').find('span.drag-to-sort').text();
			var select_text = $(this).closest('.af_ac_role_container').find('span.click-to-select').text();
			var remove_text = $(this).closest('.af_ac_role_container').find('span.click-to-remove').text();
			var field_label = $(this).closest('tr').find('p.field_name').text();
			var role_key = $(this).closest('.af_ac_role_container').data('role_key');
			var sel_text = $(this).closest('.af_ac_role_container').find('span.selected').text();
			var selected = '<span title="' + sel_text + '" class="dashicons dashicons-yes"></span>';

			var tab = $('ul.subsubsub').find('.current').data('tab_key');

			if ('billing' == tab) {
				var name = 'af_checkout_billing_fields[' + role_key + '][]';
			} else {
				var name = 'af_checkout_shipping_fields[' + role_key + '][]';
			}

			var row_to_insert = `<tr class="` + field_key + `" data-field_key="` + field_key + `" >
			<td class="checkbox_col">
			<span title="` + sort_text + `" class="dashicons dashicons-sort"></span>
			</td>
			<td class="field_name">
			<input type="hidden" class="hidden_field" value="` + field_key + `" name="` + name + `">
			<p class="field_name">` + field_label + `</p>
			</td>
			<td class="remove">
			<span title="` + remove_text + `" class="dashicons dashicons-remove"></span>
			</td>
			</tr>`;


			$(this).closest('.af_ac_role_container').find('table.droppable tbody').append(row_to_insert);

			$(this).closest('.af_ac_role_container').find('table.droppable tbody').sortable();

			current_row.fadeOut(2000, function (draggable_row) {
				$(this).find('span.dashicons-plus-alt').replaceWith(selected);
				$(this).fadeIn(2000);
			});
		});

		$('.af_c_f_dep_fields').select2();

		var value = $("#af_c_f_field_type option:selected").val();

		af_c_f_show_options(value);

		var value = $('.af_c_f_dependable input[type="radio"]:checked').val();

		if ('yes' == value) {

			jQuery('div.dependent').show();

			var $_type = $('select.af_c_f_dep_fields').find('option:selected').data('field_type');

			if ($.inArray($_type, ['select', 'multiselect', 'multi_checkbox', 'radio']) >= 0) {

				if ($('input.af_c_f_dependable_values').val().length < 1) {

					$('input.af_c_f_dependable_values').val($('select.af_c_f_dep_fields').find('option:selected').data('field_options'));
				}

				$('div.af_c_f_dependable_values').show();
			}

		} else {

			$('div.af_c_f_dependable_values').hide();

			jQuery('div.independent').show();

			af_c_f_show_on_pages(jQuery('div.af_c_f_show_on_pages input[type="checkbox"]:checked').map((_, el) => el.value).get());
		}

		dependable_field_show(value);

		jQuery('.af_c_f_dependable input').change(function () {

			var value = $('.af_c_f_dependable input[type="radio"]:checked').val();

			jQuery('div.dependent').hide();

			jQuery('div.independent').hide();

			$('div.af_c_f_dependable_values').hide();

			if ('yes' == value) {

				jQuery('div.dependent').show();

				$('div.af_c_f_dependable_values').hide();

				var $_type = $('select.af_c_f_dep_fields').find('option:selected').data('field_type');

				if ($.inArray($_type, ['select', 'multiselect', 'multi_checkbox', 'radio']) >= 0) {

					$('input.af_c_f_dependable_values').val($('select.af_c_f_dep_fields').find('option:selected').data('field_options'));

					$('div.af_c_f_dependable_values').show();
				}

			} else {

				jQuery('div.independent').show();

				af_c_f_show_on_pages(jQuery('div.af_c_f_show_on_pages input[type="checkbox"]:checked').map((_, el) => el.value).get());
			}

		});

		jQuery('div.af_c_f_show_on_pages input[type="checkbox"]').click(function () {



			if ($(this).is(':checked')) {

				if ('checkout' == $(this).val()) {

					jQuery('div.af_c_f_checkout_position').show();

				}

			} else {

				if ('checkout' == $(this).val()) {
					jQuery('div.af_c_f_checkout_position').hide();
				}
			}
		});

		jQuery('select.af_c_f_vat_type').change(function () {

			jQuery('div#af_c_f_vat_length').hide();

			if ('length' == jQuery(this).val()) {
				jQuery('div#af_c_f_vat_length').show();
			}

		});
	});


var maxField = 10000; //Input fields increment limitation

function af_c_f_add_option() {

	"use strict";
	var fieldHTML  = '';
	fieldHTML     += '<tr id="maxrow'+maxField+'">';
	fieldHTML += '<td><input type="text" name="af_c_f_field_option['+maxField+'][field_value]" id="af_c_f_field_option_value'+maxField+'" class="option_field" /></td>';
	fieldHTML += '<td><input type="text" name="af_c_f_field_option['+maxField+'][field_text]" id="af_c_f_field_option_text'+maxField+'" class="option_field" /></td>';
	fieldHTML += '<td><input type="number" min="0" name="af_c_f_field_option['+maxField+'][option_price]" id="af_c_f_field_option_price'+maxField+'" class="option_field" /></td>';
	fieldHTML += '<td><input type="checkbox" name="af_c_f_field_option['+maxField+'][option_price_taxable]" value="yes" id="af_c_f_field_option_price_taxable'+maxField+'" class="" /></td>';
	fieldHTML += '<td><button type="button" class="button button-danger" onclick="jQuery(\'#maxrow' + maxField + '\').remove();">Remove Option</button></td>';
	fieldHTML     += '</tr>'; //New input field html 
	jQuery('#NewField').before(fieldHTML);
	maxField++;
}

function dependable_field_show(value) {

	jQuery('div.dependent').hide();
	jQuery('div.independent').hide();

	if ('yes' == value) {
		jQuery('div.dependent').show();
	} else {
		jQuery('div.independent').show();
		af_c_f_show_on_pages(jQuery('div.af_c_f_show_on_pages input[type="checkbox"]:checked').map((_, el) => el.value).get());
	}

}

function af_c_f_show_on_pages(value) {

	jQuery('div.af_c_f_checkout_position').hide();

	if (jQuery.inArray("checkout", value) != -1) {
		jQuery('div.af_c_f_checkout_position').show();
	}
}

function af_c_f_show_options(value) {

	"use strict";

	jQuery('div.af_c_f_field_text').hide();
	jQuery('div.af_c_f_heading').hide();
	jQuery('#af_c_f_field_options').hide();
	jQuery('.af_c_f_recaptchahide').hide();
	jQuery('#af_c_f_recaptcha').hide();
	jQuery('.af_c_f_fileupload').hide();
	jQuery('#af_c_f_field_options').hide();
	jQuery('.af_c_f_description').hide();
	jQuery('div.af_c_f_vat').hide();
	jQuery('div.af_c_f_field_price').hide();
	jQuery('div.af_c_f_user_roles').show();

	if (value == 'select' || value == 'multiselect' || value == 'radio' || value == 'multi_checkbox') {

		jQuery('#af_c_f_field_options').show();
		jQuery('.af_c_f_recaptchahide').show();
		jQuery('.af_c_f_description').show();

	} else if (value == 'googlecaptcha') {

		jQuery('#af_c_f_recaptcha').show();
		jQuery('.af_c_f_description').show();
		jQuery('div.af_c_f_user_roles').hide();

	} else if (value == 'fileupload') {

		jQuery('div.af_c_f_field_price').show();
		jQuery('.af_c_f_recaptchahide').show();
		jQuery('.af_c_f_fileupload').show();
		jQuery('.af_c_f_description').show();

	} else if (value == 'heading') {

		jQuery('div.af_c_f_heading').show();
		jQuery('div.af_c_f_field_text').show();

	} else if (value == 'privacy' || value == 'message') {

		jQuery('div.af_c_f_field_text').show();

	} else if ('vat' == value) {

		jQuery('div.af_c_f_vat').show();
		jQuery('.af_c_f_description').show();
		jQuery('.af_c_f_recaptchahide').show();
		if ('length' != jQuery('select.af_c_f_vat_type').val()) {
			jQuery('div#af_c_f_vat_length').hide();
		}
		jQuery('div.af_c_f_field_price').show();

	} else {

		jQuery('.af_c_f_description').show();
		jQuery('.af_c_f_recaptchahide').show();
		jQuery('div.af_c_f_field_price').show();
	}

}

function afregsaveFields() {


	jQuery('#df_form').find(':checkbox:not(:checked)').attr('value', '0').prop('checked', true);
	var data2 = jQuery('#df_form').serialize();


	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: data2 + '&action=af_c_f_save_df_form&nonce=' + nonce,
		success: function (res) {

			window.location.reload(true);

		}
	});
}


