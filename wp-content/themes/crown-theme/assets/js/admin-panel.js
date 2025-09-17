const convertToOrderButtonExtraStyles = `
.right-buttons > button.button-primary.button-large.disable {
    background: rgb(246, 247, 247);
    color: rgb(167, 170, 173);        
    pointer-events: none;
    cursor: not-allowed;
    border-color: rgb(220, 220, 222);
    border-width: 2px;
   } 
`
const styleExtraElement = document.createElement("style");

const addStylesToHead = (styles) => {
    styleExtraElement.textContent = Array.isArray(styles) && styles.length > 1 ? styles.join('\n') : styles;
    document.head.appendChild(styleExtraElement);
}
const handleConvertToOrderLock = () => {
    const convertButtonElement = document.querySelector('button[name="addify_convert_to_order"].button.button-primary.button-large');

    if (convertButtonElement) {
        addStylesToHead(convertToOrderButtonExtraStyles);
        const parentConvertButton = convertButtonElement.parentNode;
        const spinnerElement = document.createElement('div');
        spinnerElement.classList.add('spinner');
        spinnerElement.style.marginTop = convertButtonElement.offsetHeight / 3.3 + 'px';
        parentConvertButton.appendChild(spinnerElement);

        convertButtonElement && convertButtonElement.addEventListener("click", () => {
            convertButtonElement.classList.add('disable');
            convertButtonElement.textContent = 'Converting to order'
            spinnerElement.style.visibility = 'visible';
        });
    }
}

const trimAdminInputsOnSubmit = () => {
    const form = document.querySelector('.wp-admin form#post');
    const customFieldsValues = document.querySelectorAll('form div#postcustom.postbox td>textarea');
    const customFieldsQuote = document.querySelectorAll('#afrfq-user-info > div.inside > div > table > tbody > tr > td > input[type=text],' +
        '#afrfq-user-info > div.inside > div > table > tbody > tr > td > input[type=email]');

    form && form.addEventListener('submit', () => {
            [customFieldsValues, customFieldsQuote].forEach(elem => elem.forEach(field => {
                field.value = field.value && field.value.trim();
            }));
        }
    )
}

jQuery(document).ready(function ($) {
    jQuery('#myModal button.switchbtn.button-primary').click(function (e) {
        const customerId = (jQuery(this).hasClass('frompage') && jQuery(this).val()) || jQuery('#cusname1').val();
        if (customerId) {
            const spinner = $('#loader_fme-nsi');
            spinner.css('display', 'flex');
            $('body').addClass('disable-controls');
            $('input,select').prop('disabled', true);
            spinner.append(`<div id="customer_switching_message">Switching to <div>Customer ID: ${customerId}</div></div>`);
            $(`#myModal`).hide();
            e.preventDefault();
        }
    });

    $('#crown-quote-delete-post-button').on('click', function(e) {
        e.preventDefault();
        const quote_id = $(this).attr('data-quote-id');
        const is_confirm = $('#crown-quote-delete-post-confirm').is(':checked');
        let msg_box = $('.crown-quote-delete-post-messages');

        if ( !is_confirm ) {
            msg_box.html('Please confirm quote deletion').fadeIn();
            return;
        }

        msg_box.fadeOut().html('');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'crown_remove_quote',
                quote_id : quote_id,
            },
            success: function (response) {
                let responseObj = JSON.parse(response);
                if ( responseObj.status === 'success' ) {
                    window.location.href = responseObj.redirect;
                } else {
                    let message = responseObj.message ?? 'Something went wrong, please try again';
                    msg_box.html(message).fadeIn();
                }
            },
            error: function () {
                msg_box.html('Something went wrong, please try again').fadeIn();
            }
        });
    });

    function admin_order_details_change_columns_order() {
        const header = $('.woocommerce_order_items_wrapper.wc-order-items-editable .header-shipped-qty');
        const cell = $('.woocommerce_order_items_wrapper.wc-order-items-editable .value-shipped-qty');

        header.insertAfter(header.next()).insertAfter(header.next());
        $(cell).each((k, elem) => {
            $(elem).insertAfter($(elem).next()).insertAfter($(elem).next());
        });
    }
    admin_order_details_change_columns_order();
});

trimAdminInputsOnSubmit();
handleConvertToOrderLock();