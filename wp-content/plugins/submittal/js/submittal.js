jQuery(document).ready(function($) {

    function isValidationCheckFailed() {
        return $('#submittal-emails').val().length < 5 || $('.js-cover-letter.is-invalid').length > 0;
    }
    function isSubmitAllowed() {
        return !isValidationCheckFailed() && grecaptcha.getResponse();
    }
    window.handleRecaptchaSuccess = function() {
        $('.js-send-submittal-email').prop(
            'disabled', isValidationCheckFailed());
    }

    const displayNotification = function(message, place, fadeOut = 3000, type = 'success') {
        const classes = {
            'success': 'woocommerce-message',
            'error': 'woocommerce-error'
        };

        let notification = $(
            `<div class="woocommerce-notices-wrapper">
                <div class="${classes[type]}" role="alert">${message}</div>
            </div>`
        );

        $(place).first().prepend(notification);
    
        if (fadeOut) {
            setTimeout(function() {
                notification.fadeOut('slow', function() {
                    $(this).remove();
                });
            }, fadeOut);
        }
    }

    const hideNotification = function() {
        $('.woocommerce-notices-wrapper').remove();
    }

    const productPageContainer = '#main-content .inner';
    const submittalPageContainer = '#main .container';

    $('#submittal-button').click(function(event) {
        event.preventDefault();
        let that = $(this);

        if (that.data('action') == 'add') {
            let data = {
                'action': 'add_to_submittal',
                'product_id': that.data('product-id')
            };
    
            $.post(SubmittalData.ajaxUrl, data, function(response) {
                that.data('action', 'remove').text('Remove from submittal');
                displayNotification('Product added to submittal list', productPageContainer);
            }).fail(function(response) {
                if (response.status == 409) {
                    that.data('action', 'remove').text('Remove from submittal');
                    displayNotification('Product is already in submittal list', productPageContainer);
                }
            });
        } else {
            let data = {
                'action': 'remove_from_submittal',
                'product_id': that.data('product-id')
            };
    
            $.post(SubmittalData.ajaxUrl, data, function(response) {
                that.data('action', 'add').text('Add to submittal');
                displayNotification('Product removed from submittal list', productPageContainer);
            });
        }
    });

    $('.js-remove-from-submittal-page').click(function(event) {
        event.preventDefault();
        let that = $(this);

        let data = {
            'action': 'remove_from_submittal',
            'product_id': that.data('product-id')
        };

        let message = 'Product ' + that.data('product-title') + ' removed from submittal list';
        displayNotification(message, submittalPageContainer);

        $.post(SubmittalData.ajaxUrl, data, function(response) { // @TODO add checking response 
            that.closest('.row').remove();

            // change value of total products counter
            let counter = $('#products-counter');
            let totalProducts = counter.data('total');
            counter.data('total', totalProducts - 1);
            counter.text(totalProducts - 1);

            // show/hide empty submittal placeholder
            if (counter.data('total') == 0) {
                $('#empty-submittal, #main-submittal').toggleClass('d-none');
            }
        });

    });

    $('.js-send-submittal-email').click(function(event) { 
        event.preventDefault();

        let data = {
            'action': 'send_submittal_email',
            'emails': $('#submittal-emails').val(),
            'coverLetter': {
                'include': $('#include-cover-letter').prop('checked'),
                'date': $('#cover-letter-date').val(),
                'projectName': $('#cover-letter-project-name').val(),
                'generalContractor': $('#cover-letter-general-contractor').val(),
                'electricalContractor': $('#cover-letter-electrical-contractor').val(),
                'engineer': $('#cover-letter-engineer').val(),
                'salesContact': $('#cover-letter-sales-contact').val()
            }
        };

        $.post(SubmittalData.ajaxUrl, data, function(response) {
            window.location.href = SubmittalData.specificationPageUrl;
        }).fail(function(response) {
            displayNotification(
                response.responseJSON.data || 'Something went wrong',
                submittalPageContainer,
                5000,
                'error'
            );
        });
    });

    $('#include-cover-letter').on('change', function() {
        $('#cover-letter-fields').toggleClass('d-none');
    });

    $('#submittal-emails').on('input', function() {
        $('.js-send-submittal-email').prop(
            'disabled', !isSubmitAllowed()
        );
    });

    $('#submittal-title').on('input', function() {
        let isInvalid = $(this).val().length > 255;
    
        $('#add-submittal').prop(
            'disabled',
            $(this).val().length === 0 || isInvalid
        );

        $(this).toggleClass('is-invalid', isInvalid);
        $('#title-validation-feedback').toggleClass('d-block', isInvalid);
    });

    $('.js-cover-letter').on('input', function() {
        let isInvalid = $(this).val().length > 255;
        $(this).toggleClass('is-invalid', isInvalid);
        $('.js-send-submittal-email').prop(
            'disabled',
            !isSubmitAllowed()
        );
    });

    $('#submittals-list').on('change', function() {
        let data = {
            'action': 'set_submittal',
            'id': $(this).val()
        };

        $.post(SubmittalData.ajaxUrl, data, function(response) {
            location.reload();
        });

        displayNotification(
            'Switching to ' + $('#submittals-list option:selected').text() + ' submittal...',
            submittalPageContainer,
            false
        );
    });

    $('#add-submittal').click(function(event) { 
        event.preventDefault();

        let data = {
            'action': 'create_submittal',
            'title': $('#submittal-title').val()
        };

        $.post(SubmittalData.ajaxUrl, data, function(response) {
            location.reload();
        }).fail(function(response) {
            hideNotification();
            displayNotification(
                response.responseJSON.data || 'Something went wrong',
                submittalPageContainer,
                5000,
                'error'
            );
        });

        displayNotification(
            'New submittal ' + data.title + ' is creating...',
            submittalPageContainer,
            false
        );
    });

    $('#remove-submittal').click(function(event) { 
        event.preventDefault();
        $(this).prop('disabled', true);

        let data = {
            'action': 'remove_submittal'
        };

        $.post(SubmittalData.ajaxUrl, data, function(response) {
            location.reload();
        });
    });
});