(function($) {

	$(document).ready(function() {

		$(document).on('click', '.crown-field.group-set .group-set-nav a', function(e) {
			e.preventDefault();

			var li = $(this).parent();
			if(li.hasClass('active')) return;

			var tabIndex = li.index();

			li.siblings('.active').removeClass('active');
			li.addClass('active');

			var groupsContainer = li.closest('.group-set-wrap').children('.group-set-field-groups');
			groupsContainer.children('.active').removeClass('active');
			groupsContainer.children(':eq(' + tabIndex + ')').addClass('active');

		});

	});

})(jQuery);