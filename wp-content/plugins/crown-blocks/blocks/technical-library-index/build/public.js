/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************************!*\
  !*** ./blocks/technical-library-index/src/public.js ***!
  \******************************************************/
(function ($) {
  var crownBlockData = crownBlockTechnicalLibraryIndexData;

  var submitForm = function (e) {
    $(this).closest('form').trigger('submit', [e]);
  };

  $(document).on('change', '.' + crownBlockData.blockClassName + ' form.post-feed-filters input', submitForm);
  $(document).on('change', '.' + crownBlockData.blockClassName + ' form.post-feed-filters select', submitForm);

  var updateBlockPostFeed = function (block, url) {
    if (url.match(/^\//)) url = crownBlockData.baseUrl + url;
    var blockId = block.attr('id');
    $('.ajax-loader', block).addClass('loading');
    if ($('.pagination-wrapper.infinite', block).length && url.match(/\/page\/\d+\//)) $('.ajax-loader', block).addClass('loading-page');

    if (history.replaceState != null) {
      history.replaceState('', document.title, url);
    }

    if ((!$('.pagination-wrapper.infinite', block).length || !url.match(/\/page\/\d+\//)) && block.offset().top < $(window).scrollTop()) {
      var offset = $('body').offset().top + $('#header').outerHeight();
      window.scrollTo({
        top: block.offset().top - offset,
        behavior: 'smooth'
      });
    }

    $.ajax({
      url: url,
      blockId: blockId,
      dataType: 'html',
      success: function (response) {
        var blockId = this.blockId;
        var block = $('#' + blockId);
        var newBlock = $('#' + blockId, response);

        if (block.length && newBlock.length) {
          var content = $('.ajax-content', newBlock);

          if (content.length) {
            if ($('.pagination-wrapper.infinite', block).length && this.url.match(/\/page\/\d+\//)) {
              $('.ajax-content .post-feed > .inner', block).append($('.post-feed > .inner', content).children());
              $('.pagination-wrapper', block).remove();

              if ($('.pagination-wrapper.infinite .pagination', content).length) {
                $('.ajax-content', block).append($('.pagination-wrapper.infinite', content));
              }
            } else {
              $('.ajax-content', block).html(content.html());
            }
          }

          $('.ajax-loader', block).removeClass('loading loading-page');
        }
      }
    });
  };

  $(document).on('submit', '.' + crownBlockData.blockClassName + ' form.post-feed-filters', function (e, triggeringEvent) {
    if (!$(triggeringEvent.target).is('select, input[type=text]')) {
      e.preventDefault();
      var queryString = $(this).serialize();
      var url = $(this).attr('action');
      if (queryString != '') url += ($(this).attr('action').match(/\?/) ? '&' : '?') + queryString;
      updateBlockPostFeed($(this).closest('.' + crownBlockData.blockClassName), url);
    }
  });
  $(document).on('click', '.' + crownBlockData.blockClassName + ' form.post-feed-filters a.reset', function (e) {
    e.preventDefault();
    var form = $(this).closest('form');
    $('input[type=text], select', form).val('');
    $('input[type=checkbox], input[type=radio]', form).prop('checked', false);
    $('.filter', form).each(function (i, el) {
      var filter = $(el);
      var defaultValue = filter.data('default-value');
      var defaultValue = Array.isArray(defaultValue) ? defaultValue : JSON.parse(defaultValue);

      if (defaultValue !== null) {
        defaultValue = Array.isArray(defaultValue) ? defaultValue : [defaultValue];
        $('input[type=text]', filter).val(defaultValue[0]);
        $('select option', filter).filter(function (i, el2) {
          return defaultValue.includes($(el2).val());
        }).prop('selected', true);
        $('input[type=checkbox], input[type=radio]', filter).filter(function (i, el2) {
          return defaultValue.includes($(el2).val());
        }).prop('checked', true);
      }
    });
    updateBlockPostFeed($(this).closest('.' + crownBlockData.blockClassName), $(this).attr('href'));
  });
  $(document).on('click', '.' + crownBlockData.blockClassName + ' .pagination a', function (e) {
    e.preventDefault();
    updateBlockPostFeed($(this).closest('.' + crownBlockData.blockClassName), $(this).attr('href'));
  });
  $(document).on('click', '.' + crownBlockData.blockClassName + ' form.post-feed-filters .filter-title', function (e) {
    e.preventDefault();
    var filter = $(this).closest('.filter');
    if (!filter.hasClass('expandable')) return;
    var fieldsContainer = $('.filter-fields', filter);
    fieldsContainer.css({
      height: fieldsContainer.height()
    });
    filter.toggleClass('expanded');
    setTimeout(function () {
      if (!filter.hasClass('expanded')) {
        fieldsContainer.css({
          height: 0
        });
      } else {
        fieldsContainer.css({
          height: $('> .inner', fieldsContainer).outerHeight()
        });
        setTimeout(function () {
          fieldsContainer.css({
            height: 'auto'
          });
        }, 200);
      }
    }, 0);
  });
  $(document).on('click', '.' + crownBlockData.blockClassName + ' article.product > a', function (e) {
    e.preventDefault();
    var article = $(this).closest('article.product');
    var postId = article.data('post-id');
    $('#product-' + postId + '-docs-modal').modal('show');
  });
})(jQuery);
/******/ })()
;
//# sourceMappingURL=public.js.map