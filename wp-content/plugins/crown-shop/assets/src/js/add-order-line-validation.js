'use strict';

(function($) {

    $(document.body).on('wc_backbone_modal_loaded', function(event, target) {

        const cartLimit = order_params.order_lines_limit;
        if (target === 'wc-modal-add-products') {
            let modal = $('.wc-backbone-modal-content');
            let item_table_body = modal.find('tbody');

            let currentCount = $('#order_line_items').find('tr.item').length;
            let remainingSlots = cartLimit - currentCount;

            modal.find('.wc-product-search').off('change').on('change', function() {
                let rows = item_table_body.find('tr').length;

                if (rows < remainingSlots) {
                    let newRow = item_table_body.data('row').replace(/\[0\]/g, '[' + rows + ']');
                    item_table_body.append('<tr>' + newRow + '</tr>');
                    $(document.body).trigger('wc-enhanced-select-init');
                }
            });

            let observer = new MutationObserver(function(mutations) {
                let rows = modal.find('tbody tr');
                if (remainingSlots === 0) {
                    rows.slice(remainingSlots + 1).remove();
                }
                else if (rows.length > remainingSlots && rows.length > 1) {
                    rows.slice(remainingSlots).remove();
                }
            });

            observer.observe(item_table_body[0], { childList: true, subtree: true });
        }
    });

})(jQuery);
