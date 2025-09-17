<?php
 global $addify_rfq;
 ?>
<div class="search-results-list__item search-results-list__item--{{type}}" data-product-id="{{id}}" data-brand="{{attributes.brand}}">
    {{#if pinned}}
        <span class="search-results-list__item__pin">
            <hawksearch-icon name="star"></hawksearch-icon>
        </span>
    {{/if}}
    {{#if (eq type "product")}}
        <div class="search-results-list__item__wrapper">
            <a hawksearch-link href="{{url}}" class="search-results-list__item__image" aria-label="{{title}}">
                <img hawksearch-image src="{{imageUrl}}" alt="" />
            </a>
            <div class="search-results-list__item__title">
                <a hawksearch-link href="{{url}}">{{title}}</a>
            </div>
            <div class="search-results-list__item__sku">
                <span class="sku">#{{sku}}</span>
            </div>
        </div>

	    <?php
        $allow_restricted_items = false;
        if ( get_user_meta( get_current_user_id(), 'ns_allow_restricted_items', true ) ) {
            $allow_restricted_items = true;
        }
        $display_hawksearch_action_buttons = apply_filters( 'display_hawksearch_action_buttons', true );
        if ( is_user_logged_in() && $display_hawksearch_action_buttons ) {
            $add_to_cart_button = '';
            $current_user = wp_get_current_user();
            $user_role    = $current_user->roles[0] ?? '';
            $admin_id     = get_original_admin_id();
            $admin_user   = $admin_id ? get_userdata( $admin_id ) : null;
            $is_manager = in_array( $current_user->roles[0] ?? '', [ 'shop_manager', 'dual_shop_manager' ], true );
            $is_switched_manager = is_switched_customer() && $admin_user && in_array( $admin_user->roles[0] ?? '', [ 'shop_manager', 'dual_shop_manager' ], true );

            $context_key = get_current_user_contextual_quote_type_key();
            if ( $user_role === 'customer' ) {
                $add_to_cart_button = '<a href="javascript:void(0)" rel="nofollow" data-quantity="{{attributes.min_quantity}}" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="{{id}}" data-price="0" data-product_sku="{{sku}}" aria-label="Add to cart: “{{title}}”" aria-describedby="" title="Minimum qty is {{attributes.min_quantity}}">Add to cart</a>';
            }

            $check_if_sales_rep_domain_brands_restricted = false;
            $check_if_dual_shop_manager_brands_allowed   = false;
            $switched_user = Crown_Shop_Display::get_original_switched_user( $current_user->ID );
            $brand_names   = array();
			if ( $current_user->roles[0] == 'dual_shop_manager' ) {
                $check_if_dual_shop_manager_brands_allowed = true;
                $brand_names = get_dual_shop_manager_allowed_brands( $current_user );
            } elseif ( $switched_user && isset( $switched_user->roles[0] ) && $switched_user->roles[0] === 'dual_shop_manager' ) {
                $check_if_dual_shop_manager_brands_allowed = true;
                $brand_names = get_dual_shop_manager_allowed_brands( $switched_user );
            } elseif ( $current_user->roles[0] == 'shop_manager' ) {
                $check_if_shop_manager_popup = true;
            } elseif ( $switched_user && isset( $switched_user->roles[0] ) && $switched_user->roles[0] === 'shop_manager' ) {
                $check_if_shop_manager_popup = true;
            } else {
                $restricted_brands_condition = add_hawksearch_restricted_brands_condition( $current_user, $check_if_sales_rep_domain_brands_restricted );
            }

            if ( $check_if_dual_shop_manager_brands_allowed ) {
                $dsm_allowed_brands_condition = build_hawksearch_brands_condition( $brand_names );
            }
			if ( $check_if_shop_manager_popup ) {
                $shop_manager_condition = 'true';
            }
            ?>

            {{#unless (eq (lookup attributes._disable_purchase 0) "yes")}}
                <?php if ( ! $allow_restricted_items ) { ?>
                    {{#unless (eq (lookup attributes.ns_restricted_item_flag 0) "yes")}}
                <?php } ?>

                <div class="search-results-list__item__buttons">
                    {{#if attributes.min_quantity}}
                        <?php if ( $check_if_sales_rep_domain_brands_restricted ) {
                            $default_quote_id  = 0;
                            $default_quote_title = '';

                            if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
                                foreach ( $addify_rfq->quote_types_obj->afrfq_get_all_quote_types() as $qt ) {
                                    if ( trim( $qt->post_title ) === 'Job Quote Request' ) {
                                        $default_quote_id    = $qt->ID;
                                        $default_quote_title = $qt->post_title;
                                        break;
                                    }
                                }
                            }
                            ?>
                            {{#unless (or <?php echo $restricted_brands_condition; ?> )}}
                                <?php echo $add_to_cart_button; ?>
                                <a href="javascript:void(0)" rel="nofollow" data-product_id="{{id}}" data-quantity="{{attributes.min_quantity}}" data-price="0" data-product_sku="{{sku}}" data-brand="{{attributes.brand}}"  data-quote_id="<?php echo esc_attr( $default_quote_id ); ?>" 
                               data-quote_title="<?php echo esc_attr( $default_quote_title ); ?>" 
                               class="afrfqbt button product_type_simple">Add to Quote</a>
                            {{/unless}}
                        <?php } elseif ( $check_if_dual_shop_manager_brands_allowed || $check_if_shop_manager_popup ) {
                            // DSM logic with bridgeport + quote type check
                            $quote_type_already_exists = false;
                            $is_bridgeport_only = false;
                            $is_discount_type = false;

                            // Get the currently selected quote type ID
                            $user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key, true);
                            $session_selected_quote_type = WC()->session->get($context_key);
                            $selected_quote_type = !empty($user_selected_quote_type['id']) ? $user_selected_quote_type : (!empty($session_selected_quote_type['id']) ? $session_selected_quote_type : null);

                            if ($selected_quote_type && !empty($selected_quote_type['id'])) {
                                $quote_type_id = intval($selected_quote_type['id']);
                                $quote_type_already_exists = true;

                                // Check its properties using post meta
                                $is_bridgeport_only = (get_post_meta($quote_type_id, 'quote_type_bridgeport_brand', true) === 'yes');
                                $is_discount_type = (get_post_meta($quote_type_id, 'quote_type_discount_rules', true) === 'yes');
                            }
                            ?>
							{{#if (or <?php echo $dsm_allowed_brands_condition; ?> <?php echo $shop_manager_condition; ?>)}}
                                <?php echo $add_to_cart_button; ?>
                                <a href="javascript:void(0)"
                                data-user_type = "general" 
                                   rel="nofollow" 
                                   data-product_id="{{id}}" 
                                   data-quantity="{{attributes.min_quantity}}" 
                                   data-price="0" 
                                   data-product_sku="{{sku}}" 
                                   data-brand="{{attributes.brand}}" 
                                   data-quote-exists="<?php echo esc_attr($quote_type_already_exists ? 'true' : 'false'); ?>"
                                    data-quote-is-bridgeport="<?php echo esc_attr($is_bridgeport_only ? 'true' : 'false'); ?>"
                                    data-quote-is-discount="<?php echo esc_attr($is_discount_type ? 'true' : 'false'); ?>"
                                   class="<?php echo esc_attr( $quote_type_already_exists ? 'afrfqbt product_type_simple alt' : 'plp-select-quote-type-button' ); ?> button">
                                   Add to Quote
                                </a>
                            {{/if}}
                        <?php } else {
                            // Default user fallback
                            $default_quote_id  = 0;
                            $default_quote_title = '';

                            if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
                                foreach ( $addify_rfq->quote_types_obj->afrfq_get_all_quote_types() as $qt ) {
                                    if ( trim( $qt->post_title ) === 'Job Quote Request' ) {
                                        $default_quote_id    = $qt->ID;
                                        $default_quote_title = $qt->post_title;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?php echo $add_to_cart_button; ?>
                            <a href="javascript:void(0)" 
                             data-user_type = "general"
                               rel="nofollow" 
                               data-product_id="{{id}}" 
                               data-quantity="{{attributes.min_quantity}}" 
                               data-price="0" 
                               data-product_sku="{{sku}}" 
                               data-brand="{{attributes.brand}}" 
                               data-quote_id="<?php echo esc_attr( $default_quote_id ); ?>" 
                               data-quote_title="<?php echo esc_attr( $default_quote_title ); ?>" 
                               class="afrfqbt button product_type_simple">
                               Add to Quote
                            </a>
                        <?php } ?>
                    {{else}}
                        <?php if ( $check_if_sales_rep_domain_brands_restricted ) {
                            $default_quote_id  = 0;
                            $default_quote_title = '';

                            if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
                                foreach ( $addify_rfq->quote_types_obj->afrfq_get_all_quote_types() as $qt ) {
                                    if ( trim( $qt->post_title ) === 'Job Quote Request' ) {
                                        $default_quote_id    = $qt->ID;
                                        $default_quote_title = $qt->post_title;
                                        break;
                                    }
                                }
                            }
                            ?>
                            {{#unless (or <?php echo $restricted_brands_condition; ?> )}}
                                <?php echo $add_to_cart_button; ?>
                                <a href="javascript:void(0)" rel="nofollow" data-product_id="{{id}}" data-quantity="1" data-price="0" data-product_sku="{{sku}}" data-brand="{{attributes.brand}}" class="afrfqbt button product_type_simple">Add to Quote</a>
                            {{/unless}}
                        <?php } elseif ( $check_if_dual_shop_manager_brands_allowed || $check_if_shop_manager_popup ) {
                            // DSM logic with bridgeport + quote type check
                             $quote_type_already_exists = false;
                            $is_bridgeport_only = false;
                            $is_discount_type = false;

                            // Get the currently selected quote type ID
                            $user_selected_quote_type = get_user_meta(get_current_user_id(), $context_key, true);
                            $session_selected_quote_type = WC()->session->get($context_key);
                            $selected_quote_type = !empty($user_selected_quote_type['id']) ? $user_selected_quote_type : (!empty($session_selected_quote_type['id']) ? $session_selected_quote_type : null);

                            if ($selected_quote_type && !empty($selected_quote_type['id'])) {
                                $quote_type_id = intval($selected_quote_type['id']);
                                $quote_type_already_exists = true;

                                // Check its properties using post meta
                                $is_bridgeport_only = (get_post_meta($quote_type_id, 'quote_type_bridgeport_brand', true) === 'yes');
                                $is_discount_type = (get_post_meta($quote_type_id, 'quote_type_discount_rules', true) === 'yes');
                            }
                            ?>
							{{#if (or <?php echo $dsm_allowed_brands_condition; ?> <?php echo $shop_manager_condition; ?>)}}
                                <?php echo $add_to_cart_button; ?>
                                <a href="javascript:void(0)"
                                data-user_type = "general" 
                                   rel="nofollow" 
                                   data-product_id="{{id}}" 
                                    data-quantity="1"
                                   data-price="0" 
                                   data-product_sku="{{sku}}" 
                                   data-brand="{{attributes.brand}}" 
                                    data-quote-exists="<?php echo esc_attr($quote_type_already_exists ? 'true' : 'false'); ?>"
                                    data-quote-is-bridgeport="<?php echo esc_attr($is_bridgeport_only ? 'true' : 'false'); ?>"
                                    data-quote-is-discount="<?php echo esc_attr($is_discount_type ? 'true' : 'false'); ?>"
                                   class="<?php echo esc_attr( $quote_type_already_exists ? 'afrfqbt product_type_simple alt' : 'plp-select-quote-type-button' ); ?> button">
                                   Add to Quote
                                </a>
                            {{/if}}
                        <?php } else {
                            $default_quote_id  = 0;
                            $default_quote_title = '';

                            if ( is_object( $addify_rfq ) && is_object( $addify_rfq->quote_types_obj ) ) {
                                foreach ( $addify_rfq->quote_types_obj->afrfq_get_all_quote_types() as $qt ) {
                                    if ( trim( $qt->post_title ) === 'Job Quote Request' ) {
                                        $default_quote_id    = $qt->ID;
                                        $default_quote_title = $qt->post_title;
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?php echo $add_to_cart_button; ?>
                            <a href="javascript:void(0)" rel="nofollow" data-product_id="{{id}}" data-quantity="1" data-price="0" data-product_sku="{{sku}}" data-brand="{{attributes.brand}}" class="afrfqbt button product_type_simple">Add to Quote</a>
                        <?php } ?>
                    {{/if}}
                </div>

                <?php if ( ! $allow_restricted_items ) { ?>
                    {{/unless}}
                <?php } ?>
            {{/unless}}
        <?php } ?>
    {{else}}
        <div class="row">
            {{#if imageUrl}}
                <div class="column column--12 column-sm--4">
                    <a hawksearch-link href="{{url}}">
                        <img hawksearch-image src="{{imageUrl}}" alt="" />
                    </a>
                </div>
            {{/if}}
            <div class="column column--12 column-sm--8 flex-align-self-sm-center">
                <div class="search-results-list__item__title">
                    <a hawksearch-link href="{{url}}">{{title}}</a>
                </div>
                {{#if description}}
                    <p>{{description}}</p>
                {{/if}}
            </div>
        </div>
    {{/if}}
</div>
