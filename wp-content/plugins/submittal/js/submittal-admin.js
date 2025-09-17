jQuery(document).ready(function($) {
    $('#submittal-list-filter').click(function(event) {
        event.preventDefault();

        let urlParams = new URLSearchParams(window.location.search);
        urlParams.set('user', $('#filter-by-user').val());
        urlParams.set('domain', $('#filter-by-domain').val());
        history.pushState(
            null,
            null,
            window.location.pathname + '?' + urlParams.toString()
        );

        $(this).closest('form').submit();
    });

    $('#submittal-search-search-input').on('focus', function() {
        if (!$(this).val()) {
            $(this).attr('placeholder', 'Title or recipient mail');
        }
    });
});