(function ($) {
  'use strict';

  function getEventPath(e) {
    if (e.composedPath) return e.composedPath();
    var path = [], el = e.target;
    while (el) { path.push(el); el = el.parentNode; }
    path.push(window);
    return path;
  }

  function openPlpPopup(fromBtn) {
    var productId = fromBtn.getAttribute('data-product_id') || fromBtn.dataset.product_id || '';
    var productSku = fromBtn.getAttribute('data-product_sku') || fromBtn.dataset.product_sku || '';
    var productBrand = fromBtn.getAttribute('data-brand') || fromBtn.dataset.brand || '';

    var popup = document.getElementById('plp-popup');
    if (!popup) return;

    var submitBtn = popup.querySelector('.afrfqbt.button');
    if (submitBtn) {
      submitBtn.setAttribute('data-product_id', productId);
      submitBtn.setAttribute('data-product_sku', productSku);
      submitBtn.setAttribute('data-brand', productBrand);
      if (!submitBtn.getAttribute('data-quantity')) {
          submitBtn.setAttribute('data-quantity', fromBtn.getAttribute('data-quantity') || '1');
      }
      if (!submitBtn.getAttribute('data-price')) submitBtn.setAttribute('data-price', '0');
    }

    var brandInput = popup.querySelector('#popup_product_brand');
    if (brandInput) {
      brandInput.value = productBrand;
    }

    var productBrandLower = (productBrand || '').toLowerCase();
    var isBridgeportProduct = productBrandLower === 'bridgeport';

    popup.querySelectorAll('.afrfq-quote-types-select label').forEach(function(label) {
        var isBridgeportOnly = label.getAttribute('data-bridgeport-only') === 'true';
        if (isBridgeportOnly && !isBridgeportProduct) {
            label.style.display = 'none';
        } else {
            label.style.display = ''; 
        }
    });

    popup.classList.add('active');
  }

  function closePlpPopup() {
    var popup = document.getElementById('plp-popup');
    if (popup) popup.classList.remove('active');
  }

  // OPEN popup
  function addProductToQuote(btn) {
      var productId = btn.getAttribute('data-product_id');
      var quantity  = btn.getAttribute('data-quantity') || 1;
      
      var postData = {
          action: 'add_to_quote',
          product_id: productId,
          quantity: quantity,
          nonce: afrfq_phpvars.nonce
      };
      
      if (btn.hasAttribute('data-quote_id')) {
          postData.afrfq_field_quote_types = btn.getAttribute('data-quote_id');
      }

      $.post(afrfq_phpvars.admin_url, postData, function(response) {
          if (response && response.mini_quote) {
              $('.quote-li').replaceWith(response.mini_quote);
          }
          
          if (afrfq_phpvars.redirect === 'yes') {
              window.location.href = afrfq_phpvars.pageurl;
          } else {
              window.location.reload();
          }
      });
  }

  document.addEventListener('click', function (e) {
    var path = getEventPath(e);
    var btn = path.find(n => n && n.matches && n.matches('.search-results-list__item .button') && n.getAttribute('data-product_id'));
    const selected_quote_type_not_selected_msg = document.querySelector('.quote-type-not-selected');
    if (!btn || (!btn.classList.contains('afrfqbt') && !btn.classList.contains('plp-select-quote-type-button'))) {
      return;
    }
    if (selected_quote_type_not_selected_msg) {
        selected_quote_type_not_selected_msg.style.display = 'none';
    }
    e.preventDefault();
    e.stopImmediatePropagation();
    
    var $btn = $(btn).addClass('loading');
    var isNormalUserButton = btn.hasAttribute('data-quote_id');

    if (isNormalUserButton) {
        addProductToQuote(btn);
    } else {
        $.post(plp_quote_vars.ajax_url, {
            action: 'check_hawksearch_plp_current_quote_status',
            nonce: plp_quote_vars.nonce
        }, function(response) {
            $btn.removeClass('loading');
            if (!response.success) {
                alert('An error occurred. Please try again.');
                return;
            }

            var productBrand = (btn.getAttribute('data-brand') || '').toLowerCase();
            var quoteStatus = response.data;

            if (!quoteStatus.has_quote_type) {
                openPlpPopup(btn);
            } 
            else {
                if (quoteStatus.is_bridgeport_only && productBrand !== 'bridgeport') {
                    $('#bridgeport-popup').addClass('active');
                } else if (quoteStatus.is_discount_type) {
                    $('#discount-popup').addClass('active');
                } else {
                    addProductToQuote(btn);
                }
            }
        }).fail(function() {
            $btn.removeClass('loading');
            alert('Could not connect to the server. Please check your connection and try again.');
        });
    }

  }, true);
  
  document.addEventListener('click', function (e) {
    var path = getEventPath(e);
    var submitBtn = path.find(n => n && n.matches && n.matches('#plp-popup .afrfqbt.button'));
    const selected_quote_type_not_selected_msg = document.querySelector('.quote-type-not-selected');
    if (!submitBtn) return;
    if (selected_quote_type_not_selected_msg) {
        selected_quote_type_not_selected_msg.style.display = 'none';
    }
    e.preventDefault();
    e.stopImmediatePropagation();
    var $btn = $(submitBtn).addClass('loading');
    var productId = $btn.attr('data-product_id');
    var quantity  = $btn.attr('data-quantity') || 1;
    var price     = $btn.attr('data-price') || 0;

    if (!productId) {
      console.warn('[PLP Popup] Missing product_id on submit button');
      $btn.removeClass('loading');
      return;
    }

    var selectedInput = document.querySelector('#afrfq-popup-form input[name="afrfq_field_quote_types"]:checked');
   
    if (!selectedInput) {
        selected_quote_type_not_selected_msg.style.display = 'block';
        $btn.removeClass('loading');
        return;
    }

    var quoteId = selectedInput.value;
    
    var formData = {
        action: 'add_to_quote',
        product_id: productId,
        quantity: quantity,
        price: price,
        nonce: afrfq_phpvars.nonce,
        afrfq_field_quote_types: quoteId,
        source: 'submit_plp_popup'
    };

    $.post(afrfq_phpvars.admin_url, formData, function (response) {
      $btn.removeClass('loading');
      closePlpPopup();

      if (response && response.success === false && response.data && response.data.code) {
        switch (response.data.code) {
          case 'bridgeport':
            $('#bridgeport-popup').addClass('active');
            return;
          case 'discount':
            $('#discount-popup').addClass('active');
            return;
          case 'quote_type_exists':
            $('#quote-type-exists-popup').addClass('active');
            return;
        }
      }
      
      if (response && response.mini_quote) {
        $('.quote-li').replaceWith(response.mini_quote);

        if (window.HawkSearch?.services?.tracking) {
          HawkSearch.services.tracking.trackAddToCart(productId, quantity, price, 'USD');
        }

        if (afrfq_phpvars.redirect === 'yes') {
          window.location.href = afrfq_phpvars.pageurl;
        } else {
          window.location.reload();
        }
      } else {
        var trimmed = $.trim(response);
        if (trimmed === 'success') {
          if (afrfq_phpvars.redirect === 'yes') {
            window.location.href = afrfq_phpvars.pageurl;
          } else {
            window.location.reload();
          }
        } else {
          window.location.reload();
        }
      }
      
    }).fail(function () {
      $btn.removeClass('loading');
      closePlpPopup();
      alert('An error occurred while adding the product to the quote.');
    });
  }, true);
  
  document.addEventListener('click', function (e) {
    var path = getEventPath(e);
    var closeBtn = path.find(n => n && n.id === 'plp-popup-close');
    if (!closeBtn) return;
    e.preventDefault();
    closePlpPopup();
  }, true);
  
  $('#plp-popup').on('click', function (e) {
    if (e.target === this) closePlpPopup();
  });

  $(document).on('click', '.popup-close-button', function () {
    $('#plp-popup, #discount-popup, #bridgeport-popup, #quote-type-exists-popup').removeClass('active');
  });

})(jQuery);
