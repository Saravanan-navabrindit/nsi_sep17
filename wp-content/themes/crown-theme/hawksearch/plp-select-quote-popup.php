<div class="quote-type-exists-popup" id="quote-type-exists-popup">
    <div class="popup-content">
        <p>A quote type is already selected. To change it, please clear your current quote. Thank you!</p>
        <button class="popup-close-button" type="button" data-close><span>&times;</span></button>
    </div>
</div>
<div class="discount-quick-view" id="discount-popup">
    <div class="popup-content">
        <p>You have selected a Discount Quote. Proceeding need to clear your current quote type.</p>
        <button class="popup-close-button" type="button" data-close><span>&times;</span></button>
    </div>
</div>

<div class="bridgeport-warning-popup" id="bridgeport-popup">
    <div class="popup-content">
        <p>To add this product to the quote, please clear your quote and try adding this product again since its not a bridgeport product. Thank you!</p>
        <button class="popup-close-button" type="button" data-close><span>&times;</span></button>
    </div>
</div>

<div id="plp-popup" class="pdp-quick-view woocommerce"> 
    <button id="plp-popup-close" class="popup-close-button" aria-label="Close alert" type="button" data-close>
        <span aria-hidden="true">×</span>
    </button>

    <form id="afrfq-popup-form">
        <?php 
        global $product, $addify_rfq;
        $quote_button = true;
        $bridge_port_brand   = false;
        $bridge_port_product = false;

        $current_user = wp_get_current_user();
        $admin_id     = get_original_admin_id();
        $admin_user   = $admin_id ? get_userdata($admin_id) : null;

        $is_manager          = in_array($current_user->roles[0], ['shop_manager', 'dual_shop_manager'], true);
        $is_switched_manager = is_switched_customer() && $admin_user && in_array($admin_user->roles[0], ['shop_manager','dual_shop_manager'], true);
        $context_key = get_current_user_contextual_quote_type_key();
        if ( $is_manager || $is_switched_manager ) {
            // DSM allowed brands check
            $current_user_email = $current_user->user_email;
            $admin_user_email   = $admin_user->user_email;
            $dsm_allowed_brands_option = get_option('dsm_allowed_brands');
            $domains = $dsm_allowed_brands_option['data']['dsm-domain'] ?? [];
            $brands  = $dsm_allowed_brands_option['data']['dsm-brands'] ?? [];

            if (!empty($domains) && !empty($brands)) {
                foreach ($domains as $i => $domain) {
                    $lower = strtolower($domain);
                    if ( str_contains($current_user_email, trim($lower)) || str_contains($admin_user_email, trim($lower)) ) {
                        $available_brands = isset($brands[$i]) ? array_map('trim', explode(',', $brands[$i])) : [];
                        $product_brand = isset($_POST['product_brand']) ? sanitize_text_field($_POST['product_brand']) : '';

                        if ( in_array('bridgeport', array_map('strtolower',$available_brands), true) ) {
                            $bridge_port_brand = true;
                        }
                        if ( strtolower($product_brand) === 'bridgeport' ) {
                            $bridge_port_product = true;
                        }
                    }
                }
            }
            // Bridgeport blocking
            $block_bridgeport = false;
            $quote_type_bridgeport_only = '';
            $user_selected_quote_type   = get_user_meta(get_current_user_id(), $context_key, true);
            $session_selected_quote_type= WC()->session->get($context_key);
            $selected_quote_type        = !empty($user_selected_quote_type['id'])
                                            ? $user_selected_quote_type['id']
                                            : (!empty($session_selected_quote_type) ? $session_selected_quote_type['id'] : 0);
            if ($selected_quote_type) {
                $quote_type_bridgeport_only = get_post_meta($selected_quote_type, 'quote_type_bridgeport_brand', true);
            }
            if (!$bridge_port_product && $quote_type_bridgeport_only === 'yes') {
                $block_bridgeport = true;
            }
            ?>
            <fieldset class="afrfq-quote-types-select">
                <h4>Select Quote Type</h4>
				<input type="hidden" name="product_brand" id="popup_product_brand" value="">
                <?php 
                if (is_object($addify_rfq) && is_object($addify_rfq->quote_types_obj)) {
                    $afrfq_field_quote_types = (array) get_post_meta($field_id, 'afrfq_field_quote_types', true);
                    $all_quote_types = $addify_rfq->quote_types_obj->afrfq_get_all_quote_types();
                    $quote_types = sort_quote_types_with_job_request_first( $all_quote_types );
                    foreach ($quote_types as $quote_type) {
                        $qid   = intval($quote_type->ID);
                        $title = $quote_type->post_title;
                        $apply_discount = get_post_meta($qid, 'quote_type_discount_rules', true);
                        $bridge_only    = get_post_meta($qid, 'quote_type_bridgeport_brand', true);

                        if ($apply_discount === 'yes' || empty(trim($title))) continue;

                        $is_checked = in_array($qid, array_map('intval',$afrfq_field_quote_types), true);
                        ?>
                        <label <?php if ($bridge_only === 'yes') echo 'data-bridgeport-only="true"'; ?>>
                            <input type="radio" name="afrfq_field_quote_types"
                                value="<?php echo esc_attr($qid); ?>"
                                data-label="<?php echo esc_attr($title); ?>"
                                <?php checked($is_checked); ?> />
                            <?php echo esc_html($title); ?>
                        </label>
                        <?php
                    }
                } else {
                    echo '<p>No Quote Types Found</p>';
                }
                ?>
            </fieldset>
             
            <div>
                <p class="quote-type-not-selected" style="display:none; color:red;">Please select a quote type!</p>
            </div>

            <a href="javascript:void(0)" rel="nofollow"
                class="afrfqbt button product_type_simple alt"
                data-product_id="" data-product_sku="">Submit</a>
            <?php
        } else {
            // fallback: auto-select "Job Quote Request"
            $default_quote_id = 0; $default_quote_title = '';
            if (is_object($addify_rfq) && is_object($addify_rfq->quote_types_obj)) {
                foreach ($addify_rfq->quote_types_obj->afrfq_get_all_quote_types() as $qt) {
                    if (trim($qt->post_title) === 'Job Quote Request') {
                        $default_quote_id    = $qt->ID;
                        $default_quote_title = $qt->post_title;
                        break;
                    }
                }
            }
            ?>
            <a href="javascript:void(0)" rel="nofollow"
                data-product_id="" data-product_sku=""
                class="afrfqbt_single_page single_add_to_cart_button button alt">Submit</a>
            <?php
        }
        ?>
    </form>
</div>