'use strict';

(function($) {

    $(document).on('ready', function() {
        $('label[for="customer_note"]').text('Special LTL instructions');
        $('p[class="order_note"] strong').text('Special LTL instructions:');

        $('textarea[name="customer_note"]').attr('maxlength', '150').attr('placeholder', 'Receiving hours; Reference#');

        if (!$('textarea[name="customer_note"] + .description').length) {
            $('<span class="description"><b>Note: </b>Any other comments regarding the order will not be processed.</span>').insertAfter('textarea[name="customer_note"]');
        }
    });

})(jQuery);
