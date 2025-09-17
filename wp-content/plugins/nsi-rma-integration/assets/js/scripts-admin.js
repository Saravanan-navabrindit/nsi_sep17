jQuery(document).ready(function($) {
    $('#add-returns-settings-group').on('click', function() {
        let type = $(this).attr('data-type');
        let html = null;

        switch(type) {
            case 'month':
                html = `<div class="months-for-return-customers-group settings-returns-group">
<input type='text' class='prefix' name='returns_settings_months_for_return_customers[data][customer-prefix][]' placeholder='Prefix' />
<input type='number' min='0' step='1' class='months' name='returns_settings_months_for_return_customers[data][customer-months][]' placeholder='Months' />
<button type='button' class='remove-returns-settings-group'>Remove</button>
</div>`;
                break;

            case 'reason':
                html = `<div class="settings-reasons-group settings-returns-group">
<input type='text' class='key' name='returns_settings_reasons[data][reason-key][]' placeholder='Key' />
<input type='text' class='label' name='returns_settings_reasons[data][reason-label][]' placeholder='Label' />
<button type='button' class='remove-returns-settings-group'>Remove</button>
</div>`;
                break;

            case 'disclaimer':
                html = `<div class="settings-disclaimers-group settings-returns-group">
<input type='text' class='key' name='returns_settings_disclaimers[data][disclaimer-key][]' placeholder='Key' />
<input type='text' class='label' name='returns_settings_disclaimers[data][disclaimer-label][]' placeholder='Label' />
<input type='text' class='text' name='returns_settings_disclaimers[data][disclaimer-text][]' placeholder='Text' />
<button type='button' class='remove-returns-settings-group'>Remove</button>
</div>`;
                break;

            default:
                break;
        }

        if(html) {
            $('.settings-returns-group-holder').append(html);
        }
    });

    $('body').on('click', '.remove-returns-settings-group', function() {
        $(this).parent().remove();
    });

    $('#RetryNsReturnSync').on('click', function(e) {
        e.preventDefault();

        const btn = $(this);
        $(btn).addClass('loading');
        $('#NSReturnSyncResponse').removeClass('show');
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'nsi_rma_retry_ns_sync',
                nonce: NSI_RMA_Admin_Settings.nonce,
                return_id: $(btn).attr('data-return-id'),
            },

            success: function (response) {
                if ( response.status === 'success' ) {
                    let message = response.message ?? 'Return successfully synchronized with NetSuite';
                    $('#NSReturnSyncResponse span').html(message);
                    $('#NSReturnSyncResponse').removeClass('error').addClass('show success')
                } else {
                    let message = response.message ?? 'Something went wrong, please try again';
                    $(btn).removeClass('loading');
                    $('#NSReturnSyncResponse span').html(message)
                    $('#NSReturnSyncResponse').removeClass('success').addClass('show error')
                }
            },

            error: function (response) {
                $(btn).removeClass('loading');
                $('#NSReturnSyncResponse span').html('Something went wrong, please try again');
                $('#NSReturnSyncResponse').removeClass('success').addClass('show error');
            }
        });
    });
});