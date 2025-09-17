"use strict";

(function($) {

    document.addEventListener("DOMContentLoaded", function() {
        const nextButton = document.querySelector('button[name="next_step"]');
        const submitButton = document.querySelector('button[name="submit_final"]');
        const selectAll = document.getElementById("select-all-items");
        const reasonSelect = document.getElementById("order-return-reason");

        if (selectAll) {
            const checkboxes = document.querySelectorAll("input[name='selected_items[]']:not([disabled])");

            if (checkboxes.length === 0) {
                selectAll.disabled = true;
            }
            const updateSelectAllState = () => {
                const checked = Array.from(checkboxes).filter(cb => cb.checked);
                selectAll.checked = (checked.length === checkboxes.length && checked.length > 0);
            };
            updateSelectAllState();

            selectAll.addEventListener("change", function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            checkboxes.forEach(cb => {
                cb.addEventListener("change", updateSelectAllState);
            });
        }

        if (nextButton && document.querySelector('input[name="selected_order"]')) {
            const radios = document.querySelectorAll('input[name="selected_order"]');

            const updateOrderSelectStep = () => {
                const anySelected = Array.from(radios).some(r => r.checked);
                nextButton.disabled = !anySelected;
            };

            radios.forEach(r => r.addEventListener("change", updateOrderSelectStep));
            updateOrderSelectStep();
        }

        if (nextButton && document.querySelector('input[name="selected_items[]"]')) {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:not([disabled])');
            const reasonSelect = document.getElementById('order-return-reason');
            const customerNoteField = document.getElementById('customer-note');

            const updateItemsSelectStep = () => {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                const reasonFilled = reasonSelect && reasonSelect.value !== '';
                const noteFilled = customerNoteField && customerNoteField.value.trim() !== '';
                nextButton.disabled = !(anyChecked && reasonFilled && noteFilled);
            };

            checkboxes.forEach(cb => cb.addEventListener("change", updateItemsSelectStep));
            if (reasonSelect) reasonSelect.addEventListener("change", updateItemsSelectStep);
            if (customerNoteField) customerNoteField.addEventListener("input", updateItemsSelectStep);
            if (selectAll) selectAll.addEventListener("change", updateItemsSelectStep);

            updateItemsSelectStep();
        }

        if (submitButton && document.getElementById('agree-policy')) {
            const form = document.getElementById('return-request-confirmation');
            const policyCheckbox = document.getElementById('agree-policy');

            const updateSubmit = () => {
                submitButton.disabled = !policyCheckbox.checked;
            };

            policyCheckbox.addEventListener("change", updateSubmit);
            updateSubmit();

            form.addEventListener('submit', function () {
                submitButton.disabled = true;
            }, { once: true });
        }
    });
})(jQuery);

jQuery(document).ready(function ($) {
    $('#DownloadRmaDoc').on('click', function(e) {
        e.preventDefault();
        const btn = $(this);
        const wc_return_id = btn.attr('data-wc-return-id');

        btn.css({'pointer-events': 'none', "opacity": "0.5"});

        const pdfWindow = window.open('', '_blank');
        pdfWindow.document.write(`
                <html>
                    <head>
                        <title>Document</title>
                        <style>
                            body { font-family: Arial, sans-serif; text-align: center; margin-top: 20%; }
                            .spinner { border: 4px solid rgba(0, 0, 0, 0.1); width: 40px; height: 40px; border-radius: 50%; border-left-color: #000; animation: spin 1s ease infinite; margin: 0 auto; }
                            @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
                            .loading-text { margin-top: 10px; font-size: 18px; color: #333; }
                        </style>
                    </head>
                    <body>
                        <div class="spinner"></div>
                        <div class="loading-text">Loading your document...</div>
                    </body>
                </html>
            `);

        fetch(NSI_RMA_Settings.ajaxurl, {
            method: 'POST',
            body: new URLSearchParams({
                action: 'nsi_rma_get_return_document',
                wc_return_id: wc_return_id,
                rma_pdf_nonce: NSI_RMA_Settings.rma_pdf_nonce
            })
        })
            .then(response => {
                let contentType = response.headers.get('Content-Type');

                if (contentType.includes('application/json')) {
                    return response.json().then(json => {
                        throw new Error(json.message || 'Error generating PDF');
                    });
                } else if (contentType.includes('application/pdf')) {
                    return response.blob();
                } else {
                    throw new Error('Unexpected response type');
                }
            })
            .then(blob => {
                pdfWindow.location.href = URL.createObjectURL(blob);
                btn.css({'pointer-events': 'initial', "opacity": "1"});
            })
            .catch(error => {
                btn.css({'pointer-events': 'initial', "opacity": "1"});
                pdfWindow.alert(error.message);
                pdfWindow.close();
            });
    });
});