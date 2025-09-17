jQuery(document).ready(function($) {
    if (document.cookie.indexOf('submittal_user_key=') === -1) {
        return;
    }

    const submittalButton = $('#submittal-button');

    const data = {
        'action': 'is_in_submittal',
        'product_id': submittalButton.data('product-id')
    };

    $.post(SubmittalData.ajaxUrl, data, function(response) {
        if (response.in_submittal) {
            submittalButton.data('action', 'remove').text('Remove from submittal');
        } else {
            submittalButton.data('action', 'add').text('Add to submittal');
        }
    }).fail(function(response) {
        console.error('Checking product presence in submittal: ', response);
    });
});