/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************************!*\
  !*** ./blocks/sales-rep-locator/src/public.js ***!
  \************************************************/
(function ($) {
  $(document).on('ready', function () {
    var block = $('.wp-block-crown-blocks-sales-rep-locator');
    if (!block.length) return;
    var svgMap = $('.map svg');
    $('.modal.sales-rep-region.has-sales-reps', block).each(function (i, el) {
      var country = $(el).data('country');
      var region = $(el).data('region');
      $('.map.' + country.toLowerCase() + ' svg #' + region).addClass('has-sales-reps');
    });
    setTimeout(function () {
      $('.modal.sales-rep-region.queried-region', block).modal('show');
    }, 100);
  });
  $(document).on('click', '.wp-block-crown-blocks-sales-rep-locator .tabs button', function (e) {
    var block = $(this).closest('.wp-block-crown-blocks-sales-rep-locator');
    var button = $(this);

    if (!button.hasClass('active')) {
      $('.tabs button', block).removeClass('active');
      button.addClass('active');
      var country = button.data('country');
      var map = $('.map-container .map.' + country, block);
      $('.map-container .map').not(map).removeClass('active');
      map.addClass('active');
      $('.location-search-form input[name=country]', block).val(country);

      if (history.replaceState != null) {
        var baseUrl = window.location.href.replace(/\?.*/, '');
        var queriedZip = getQueryStringValue('zip');
        history.replaceState('', document.title, baseUrl + '?country=' + country + (queriedZip ? '&zip=' + queriedZip : ''));
      }
    }
  });
  $(document).on('click', '.wp-block-crown-blocks-sales-rep-locator .map svg .has-sales-reps', function (e) {
    var block = $(this).closest('.wp-block-crown-blocks-sales-rep-locator');
    var country = $(this).parent().attr('id').toUpperCase();
    var region = $(this).attr('id');
    $('#sales-rep-region-' + country.toLowerCase() + '-' + region.toLowerCase() + '-modal', block).modal('show');
  });

  var getQueryStringValue = function (key) {
    return unescape(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + escape(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
  };
})(jQuery);
/******/ })()
;
//# sourceMappingURL=public.js.map