"use strict";

jQuery(document).ready(function ($) {
    $('.order-acknowledgement, .order-invoice').on('click', function(e) {
        e.preventDefault();
        const order_id = $(this).attr('data-order-id');
        const invoice_tran_id = $(this).attr('data-invoice-tran-id') || '';
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

        fetch(order_document.ajaxurl, {
            method: 'POST',
            body: new URLSearchParams({
                action: 'get_order_pdf_document',
                order_id: order_id,
                invoice_tran_id: invoice_tran_id,
                security: order_document.nonce
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
            })
            .catch(error => {
                pdfWindow.alert(error.message);
                pdfWindow.close();
            });
    });
});