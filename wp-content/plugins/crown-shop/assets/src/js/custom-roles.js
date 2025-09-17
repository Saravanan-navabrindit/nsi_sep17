'use strict';

(function($) {

    document.addEventListener('DOMContentLoaded', function () {
        const disableButtons = currentUser.disableButtons;
        const disableRoles = currentUser.disableRoles;
        const disableExtraFields = currentUser.disableExtraFields;

        $(document).on('select2:opening', '.acf-input select.disabled', '.acf-input input.disabled', (event)=> {
            const $selectInput = $(event.target);
            const $parent = $selectInput.closest('.acf-input');
            $parent.addClass('acf-disabled');
            event.preventDefault();
        });

        if (disableButtons) {
            const buttons = [...document.querySelectorAll('tr.acf-field-branch-group a')];
            buttons.map((button) => {
                button.disabled = true;
                button.classList.add('disabled');
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                });
            });
        }
        if (disableRoles) {
            $('#role').closest('tr').remove();
        }
        if (disableExtraFields) {
            $('.af_c_f_extra_fields').remove();
        }
    });

})(jQuery);
