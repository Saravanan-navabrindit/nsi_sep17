jQuery(document).ready( function( $ ) {

    $('#seo_favicon_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#seo_favicon').val(image_url);
        });
    });

});
jQuery(document).ready( function( $ ) {

    $('#smmgk_logo_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#smmgk_logo').val(image_url);
        });
    });

});
jQuery(document).ready( function( $ ) {

    $('#smmgk_background_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function(e){
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.toJSON().url;
            $('#smmgk_background').val(image_url);
        });
    });

});