jQuery(document).ready(function($){
	"user strict";
	jQuery('form#registerform').attr('enctype','multipart/form-data');
	jQuery('.woocommerce-form-register').attr('enctype','multipart/form-data');
	jQuery('.woocommerce-EditAccountForm').attr('enctype','multipart/form-data');

	jQuery(document).on('click', '.af_c_f_field_price', function(){
		jQuery(document.body).trigger('update_checkout');
	});

	var selected_fiels = '';

	$('.af_c_f_upload_button').prop('disabled', true );

	jQuery(document).on('focusout', 'input.af_c_f_field_price', function(){

		if( 'checkbox' == $(this).attr('type') ) {
			return;
		}

		if( 'radio' == $(this).attr('type') ) {
			return;
		}

		jQuery(document.body).trigger('update_checkout');
	});

	$(document).on('change', '.af_c_f_field_fileupload', function(e){

		let form_data = new FormData();

		if( e.target.files && e.target.files.length > 0 ) {

			selected_fiels = e.target.files;

			$(this).closest('p').find('.af_c_f_upload_button').prop('disabled', false );

		} else {

			$(this).closest('p').find('.af_c_f_upload_button').prop('disabled', true );
		}
	});

	$(document).on('click', '.af_c_f_upload_button', function(e){

		$(this).addClass('loading');

		var current_button = $(this);

		let form_data = new FormData();

		let file_data = current_button.closest('p').find('.af_c_f_field_fileupload').prop('files')[0];

		let field_id = current_button.closest('p').find('.af_c_f_field_fileupload').attr('data-field_id');
		
		current_button.closest('p').find('.af_message'+field_id).html(null);

		form_data.append( 'file', file_data );
		form_data.append( 'action', 'afcf_file_upload' );
		form_data.append( 'nonce', php_info.nonce );
		form_data.append( 'field_id', field_id );

		$.ajax({
			
			url: php_info.admin_url,
			dataType: 'JSON',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(response) {

				if( response.success ) {
					current_button.closest('p').find('.af_c_f_field_fileupload').prop('disabled', true);
					current_button.closest('p').append(response.hidden_field);
					current_button.removeClass('loading');
					current_button.addClass('loaded');
					current_button.html('<span class="dashicons dashicons-yes-alt"></span>');
					current_button.css('color', 'green');
					current_button.closest('p').find('.af_message'+field_id).html(response.message);
					
				} else {

					jQuery('input[name=af_c_f_' +field_id+ ']').load(' >* ');
					current_button.removeClass('loading');
					current_button.closest('p').find('ul.woocommerce-error').remove();
					current_button.closest('p').find('.af_message'+field_id).html(response.message);
				}
			},
			error: function(response){


				current_button.closest('p').find('.af_c_f_field_fileupload').val(null);
				jQuery('input[name=af_c_f_' +field_id+ ']').load(' >* ');
				current_button.removeClass('loading');
				current_button.closest('p').find('ul.woocommerce-error').remove();
				current_button.closest('p').find('.af_c_f_field_fileupload').before(response.message);
			}
		});
	});
});


jQuery(document).ready(function( $ ){
	"user strict";

	function is_element_dependent( element ){

		if( element.closest('p').hasClass('af_c_f_is_dependable') ) {
			return true;
		}

		return false;
	}

	function is_element_visible( element ){

		if( element.closest('p').is(':visible') && element.is(':visible') ) {
			return true;
		}

		return false;
	}

	function multiple_items_dependent_fields( elements ) {

		if( !Array.isArray( elements ) ) {
			return is_element_has_dependent_fields( elements );
		}

		let child_elements = [];

		$.each( elements, function( index, element ){

			let next_level_elements = is_element_has_dependent_fields( element );

			if( next_level_elements && Array.isArray( next_level_elements ) ) {
				child_elements = child_elements.concat( next_level_elements );
			}
		});

		return child_elements;
	}

	function is_element_has_dependent_fields( element ){

		let id_of_element = '';

		if( Array.isArray( element ) ) {

			id_of_element = [];

			$.each( element, function( index, elem ){

				id_of_element.push( elem.attr('id') );
			});

		} else {

			id_of_element = element.attr('id');
		}

		let child_elements = [];

		$('p.af_c_f_is_dependable').find('input:first, select, textarea, label.checkbox').each( function(){

			let dependent_on  = $(this).data('dependent_on');

			if( Array.isArray( id_of_element ) ) {

				if( id_of_element.includes( dependent_on ) ) {
					child_elements.push( $(this) );
				}

			} else {

				if( dependent_on == id_of_element ) {
					child_elements.push( $(this) );
				}
			}				
		});

		if( child_elements.length < 1 ) {

			return false;
		} 

		return child_elements;
	}

	function hide_multilevel_dependendent_fields( element ) {

		while( element = is_element_has_dependent_fields( element ) ) {

			if( Array.isArray( element ) ) {

				$.each(element, function( index, child_element ){
					child_element.closest('p.form-row').hide();
					child_element.trigger('change');

					if( child_element.prop('required') ) {
						child_element.attr( 'data-required', 'required');
						child_element.prop('required', false );
					}
				});

			} else {

				element.closest('p.form-row').hide();

				if( element.prop('required') ) {
					element.attr( 'data-required', 'required');
					element.prop('required', false );
				}

				element.trigger('change');
			}
		}
	}

	function show_multilevel_dependendent_fields( element ) {

		while( element = is_element_has_dependent_fields( element ) ) {

			if( Array.isArray( element ) ) {

				$.each(element, function( index, child_element ){
					child_element.closest('p.form-row').show();
					child_element.trigger('change');

					if( child_element.data('required') ) {
						child_element.prop('required', true );
					}
				});

			} else {

				element.closest('p.form-row').show();

				if( element.data('required') ) {
					element.prop('required', true );
				}

				element.trigger('change');
			}
		}
	}

	jQuery('.woocommerce-account-fields div.create-account').append(jQuery('div.af_c_f_extra_fields'));

	activate_fields_dependency();

	function activate_fields_dependency(){

		$('p.af_c_f_is_dependable').find('input:first, select, textarea, label.checkbox').each( function(){

			var field_name  = $(this).data('dependent_on');
			var field_value = $(this).data('dependent_val');

			var radio = false;

			if( ! field_value || field_value.length < 1 ) {
				return;
			}

			if( ! document.getElementById( field_name ) ) {

				if( document.getElementById( field_name + '_1' ) ) {

					field_name = field_name + '_1';

					radio = true;
				}	
			}

			if( 'string' != typeof field_value ){
				field_value = field_value.toString();
			}

			var current_element = $(this);
			
			var parent_element = $(document).find( '#' + field_name );

			var values  = parent_element.val();

			var single_checkbox = false;
			
			if( 'checkbox' == parent_element.attr('type') ) {

				var parent_elements = parent_element.closest('p.form-row').find( 'input[type="checkbox"]' );

				if( parent_elements.length > 1 ) {

					values = [];
					
					var selected_elements = parent_element.closest('p.form-row').find( 'input[type="checkbox"]:checked' );

					selected_elements.each( function(){

						values.push( $(this).val() );
					});

				} else {

					console.log('I am here');

					single_checkbox = true;

					if( parent_element.is(':checked') && parent_element.is(':visible') ) {

						current_element.closest('p.form-row').show();

						if( is_element_has_dependent_fields(current_element ) ) {
							show_multilevel_dependendent_fields( current_element );
						}

						current_element.trigger('change');

					} else {

						current_element.closest('p.form-row').hide();

						if( is_element_has_dependent_fields(current_element ) ) {

							hide_multilevel_dependendent_fields( current_element );
						}
					}
				}	

			} else if( 'radio' == parent_element.attr('type') ) {

				var parent_elements = parent_element.closest('p.form-row').find( 'input[type="radio"]' );

				if( parent_elements.length > 1 ) {
					
					values = parent_element.closest('p.form-row').find( 'input[type="radio"]:checked' ).val();

				} else {

					if( parent_element.is(':visible') && parent_element.is(':checked') ) {

						current_element.closest('p.form-row').show();

						if( is_element_has_dependent_fields(current_element ) ) {
							show_multilevel_dependendent_fields( current_element );
						}

						current_element.trigger('change');

					} else {

						if( is_element_has_dependent_fields(current_element ) ) {
							hide_multilevel_dependendent_fields( current_element );
						}

						current_element.closest('p.form-row').hide();
					}
				}
			}

			var values_array = field_value.split(',');

			if( values_array.length < 1 ) {
				current_element.closest('p.form-row').hide();
				if( is_element_has_dependent_fields(current_element ) ) {
					hide_multilevel_dependendent_fields( current_element );
				}
				return;
			}

			if ( Array.isArray( values ) ) {

				let intersection = values_array.filter(x => values.includes(x));

				if( intersection.length < 1 || !parent_element.is(':visible') ){

					current_element.closest('p.form-row').hide();

					if( is_element_has_dependent_fields(current_element ) ) {
						hide_multilevel_dependendent_fields( current_element );
					}

					if( current_element.prop('required') ) {
						current_element.attr( 'data-required', 'required');
						current_element.prop('required', false );
					}

				} else {

					if( current_element.data('required') ) {
						current_element.prop('required', true );
					}

					current_element.closest('p.form-row').show();

					if( is_element_has_dependent_fields(current_element ) ) {
						show_multilevel_dependendent_fields( current_element );
					}

					current_element.trigger('change');
				}

			} else if( ! single_checkbox ) {

				if( values_array.includes( values ) && parent_element.is(':visible') ) {

					if( current_element.data('required') ) {

						current_element.prop('required', true );
					}

					current_element.closest('p.form-row').show();

					if( is_element_has_dependent_fields(current_element ) ) {
						show_multilevel_dependendent_fields( current_element );
					}

					current_element.trigger('change');
					
				} else {

					if( current_element.prop('required') ) {
						current_element.attr( 'data-required', 'required');
						current_element.prop('required', false );
					}

					current_element.closest('p.form-row').hide();

					if( is_element_has_dependent_fields(current_element ) ) {
						hide_multilevel_dependendent_fields( current_element );
					}
				}
			}

			if( radio ) {

				$( '#' + field_name ).closest( 'p.form-row' ).find( 'input').each( function(){

					field_name +=  ',#' + $(this).attr('id');
				});
			}
			
			$(document).on( 'change' , '#' + field_name , function(){
				var values = $(this).val();

				var parent_element = $(this);

				var values_array = field_value.split(',');

				if( 'checkbox' == parent_element.attr('type') ) {

					var parent_elements = parent_element.closest('p.form-row').find( 'input[type="checkbox"]' );

					if( parent_elements.length > 1 ) {

						values = [];
						
						var selected_elements = parent_element.closest('p.form-row').find( 'input[type="checkbox"]:checked' );

						selected_elements.each( function() {

							values.push( $(this).val() );
						});

					} else {

						console.log('I am here');

						if( parent_element.is(':checked') ) {
							current_element.closest('p.form-row').show();

							if( is_element_has_dependent_fields(current_element ) ) {
								show_multilevel_dependendent_fields( current_element );
							}

							current_element.trigger('change');

						} else {

							current_element.closest('p.form-row').hide();

							if( is_element_has_dependent_fields(current_element ) ) {
								hide_multilevel_dependendent_fields( current_element );
							}
						}
						return;
					}

				} else if( 'radio' == parent_element.attr('type') ) {

					var parent_elements = parent_element.closest('p.form-row').find( 'input[type="radio"]' );

					if( parent_elements.length > 1 ) {
						
						values = parent_element.closest('p.form-row').find( 'input[type="radio"]:checked' ).val();

					} else {

						if( parent_element.is(':checked') ) {
							current_element.closest('p.form-row').show();

							if( is_element_has_dependent_fields(current_element ) ) {
								show_multilevel_dependendent_fields( current_element );
							}

							current_element.trigger('change');

						} else {

							current_element.closest('p.form-row').hide();

							if( is_element_has_dependent_fields(current_element ) ) {
								hide_multilevel_dependendent_fields( current_element );
							}
						}
					}
				}

				if( values_array.length < 1 ) {
					current_element.hide();
					return;
				}

				if ( Array.isArray( values ) ) {

					let intersection = values_array.filter(x => values.includes(x));

					if( intersection.length < 1 ){

						current_element.closest('p.form-row').hide();

						if( is_element_has_dependent_fields(current_element ) ) {
							hide_multilevel_dependendent_fields( current_element );
						}

						if( current_element.prop('required') ) {
							current_element.attr( 'data-required', 'required');
							current_element.prop('required', false );
						}

					} else {

						if( current_element.data('required') ) {

							current_element.prop('required', true );
						}

						current_element.closest('p.form-row').show();

						if( is_element_has_dependent_fields(current_element ) ) {
							show_multilevel_dependendent_fields( current_element );
						}

						current_element.trigger('change');

					}

				} else {

					if( values_array.includes( values ) ) {

						if( current_element.data('required') ) {

							current_element.prop('required', true );
						}

						current_element.closest('p.form-row').show();

						if( is_element_has_dependent_fields(current_element ) ) {
							show_multilevel_dependendent_fields( current_element );
						}

						current_element.trigger('change');
						
					} else {

						if( current_element.prop('required') ) {
							current_element.attr( 'data-required', 'required');
							current_element.prop('required', false );
						}

						current_element.closest('p.form-row').hide();

						if( is_element_has_dependent_fields(current_element ) ) {
							hide_multilevel_dependendent_fields( current_element );
						}
					}
				}
			});
		});
}

jQuery(document.body).on('updated_checkout', function(){
	// activate_fields_dependency();
});

jQuery('p.form-row').find('input:first, select').each( function(){

	if( !$(this).closest('p').hasClass('af_c_f_is_dependable') ) {

		$(this).trigger('change');
	}
});


jQuery(document).on('change','.af-front-fields',function(){
	update_checkout();
});
jQuery(document).on('keyup','.af-front-fields',function(){
	update_checkout();
});
jQuery(document).on('click','.af-front-fields',function(){
	update_checkout();
});
	
jQuery(document).on('click','.af_c_f_upload_button',function(){
	update_checkout();
});



});


function update_checkout(){
	jQuery(document.body).trigger('update_checkout');

	setTimeout(function(){ jQuery(document.body).trigger('update_checkout'); },5000);
}