'use strict';

(function($) {

    $(document).on('ready', function() {

        /**
         * Customer specific order Table
         */

        /**
         * Function to initialize autocomplete on a specific element
         */
        function initAutocomplete($element) {
            $element.autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: csSettings.ajax_url,
                        dataType: "json",
                        method: 'POST',
                        data: {
                            action: 'search_customers',
                            term: request.term,
                            nonce: csSettings.nonce,
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.label, // Label to display in the autocomplete dropdown
                                    value: item.label, // Value to display in the input field upon selection
                                    id: item.value // Actual user ID to store in the hidden input
                                };
                            }));
                        }
                    });
                },
                minLength: 3,
                select: function(event, ui) {
                    $(this).val(ui.item.value);
                    $(this).next('.customer-id-hidden-input').val(ui.item.id);
                    return false;
                }
            });
        }

        // Initialize autocomplete on any existing fields
        $('.customer-autocomplete').each(function() {
            initAutocomplete($(this));
        });

        // Handler for "Add More" button
        $('#add-more-users').on('click', function() {
            const index = $('.custom-shipping-user-field-group').length; // Determine new index based on existing number of groups
            const newGroup = $('<div class="custom-shipping-user-field-group">' +
                '<input required type="text" class="customer-autocomplete" name="custom_shipping_settings[user_data][' + index + '][user_name]" placeholder="Type to search customers..." />' +
                '<input type="hidden" class="customer-id-hidden-input" name="custom_shipping_settings[user_data][' + index + '][user_id]" />' +
                '<input required type="number" name="custom_shipping_settings[user_data][' + index + '][min_order]" value="" placeholder="Min order amount ($)" />' +
                '<button type="button" class="remove-custom-shipping-user-field-group">Remove</button>' +
                '</div>');

            $('#custom-shipping-user-fields').append(newGroup);
            initAutocomplete(newGroup.find('.customer-autocomplete'));
        });

        // Handler for "Remove" button
        $('#custom-shipping-user-fields').on('click', '.remove-custom-shipping-user-field-group', function() {
            $(this).closest('.custom-shipping-user-field-group').remove();
        });

        /**
         * City specific order Table
         */

        // Handler for "Add More" button
        $('#add-more-city').on('click', function() {
            const index = $('.city-order-field-group').length; // Determine new index based on existing number of groups
            const newGroup = $('<div class="city-order-field-group">' +
                '<input required type="text" class="state" name="city_order_settings[city_data][' + index + '][city_name]" placeholder="Write city..." />' +
                '<input required type="number" name="city_order_settings[city_data][' + index + '][min_order]" value="" placeholder="Min order amount ($)" />' +
                '<button type="button" class="remove-city-order-field-group">Remove</button>' +
                '</div>');
                $('#city-order-fields').append(newGroup);
        });

        // Handler for "Remove" button
        $('#city-order-fields').on('click', '.remove-city-order-field-group', function() {
            $(this).closest('.city-order-field-group').remove();
        });

        /**
         * State specific order Table
         */

        // Handler for "Add More" button
        $('#add-more-state').on('click', function() {
            const index = $('.state-order-field-group').length; // Determine new index based on existing number of groups
            const newGroup = $('<div class="state-order-field-group">' +
                '<input required type="text" class="state" name="state_order_settings[state_data][' + index + '][state_name]" placeholder="Write state..." />' +
                '<input required type="number" name="state_order_settings[state_data][' + index + '][min_order]" value="" placeholder="Min order amount ($)" />' +
                '<button type="button" class="remove-state-order-field-group">Remove</button>' +
                '</div>');
                $('#state-order-fields').append(newGroup);
        });

        // Handler for "Remove" button
        $('#state-order-fields').on('click', '.remove-state-order-field-group', function() {
            $(this).closest('.state-order-field-group').remove();
        });

        /**
         * Prefix/Suffix specific order Table
         */

        // Handler for "Add More" button
        $('#add-more-prefix-suffix').on('click', function() {
            const index = $('.prefix-suffix-order-field-group').length; // Determine new index based on existing number of groups
            const newGroup = $('<div class="prefix-suffix-order-field-group">' +
                '<input type="text" class="prefix" name="suffix_prefix_order_settings[suffix_prefix_data][' + index + '][name-prefix]" placeholder="Prefix ..." />' +
                '<input type="text" class="suffix" name="suffix_prefix_order_settings[suffix_prefix_data][' + index + '][name-suffix]" placeholder="Suffix ..." />' +
                '<input required type="number" class="suffix" name="suffix_prefix_order_settings[suffix_prefix_data][' + index + '][min_order]" placeholder="Min order amount ($)" />' +
                '<button type="button" class="remove--prefix-suffix-order__field-group">Remove</button>' +
                '</div>');
                $('#prefix-suffix-order-fields').append(newGroup);
        });

        // Handler for "Remove" button
        $('#prefix-suffix-order-fields').on('click', '.remove--prefix-suffix-order__field-group', function() {
            $(this).closest('.prefix-suffix-order-field-group').remove();
        });

        // Handler for "Save" button for Prefix/Suffix Table
        $('.woocommerce_page_custom-shipping-settings #suffix_prefix_specific_order input#submit').on('click', function() {
            let domain  = window.location.origin;
            let data = [];

            $('#prefix-suffix-order-fields .prefix-suffix-order-field-group').each(function() {
                let prefix = $(this).find('.prefix').val();
                let suffix = $(this).find('.suffix').val();
                let min_order = $(this).find('[name$="[min_order]"]').val();
        
                data.push({
                    prefix: prefix,
                    suffix: suffix,
                    min_order: min_order
                });
            });

            let dataParam = encodeURIComponent(JSON.stringify(data));
            let pathApi = domain + '/wp-json/custom-shipping-settings/v2/create-arr-prefix-suffix-order-option?pageSlug=custom-shipping-settings&tab=suffix_prefix_specific_order&data=' + dataParam;

            $.get(pathApi, function(response, status){
                //TODO: remove after the logic validation
                console.info("Data: " + response + "\nStatus: " + status);
            });
        });
    });

})(jQuery);
