
<header id="header" role="banner">

	<div class="inner">
		<div class="container">
			<div class="inner">
				<div id="site-branding">
					<div id="site-logo">
						<a href="<?php echo home_url( '/' ); ?>">
							<?php $img_src = wp_get_attachment_image_url( get_option( 'theme_config_site_logo_color' ) , 'large'); ?>
							<?php if ($img_src) { ?>
								<img alt="NSI Logo" src="<?php echo $img_src; ?>" />
							<?php } ?>
						</a>
					</div>
				</div>
				<div id="header-navigation">
          <div class="search-navigation">

            <?php echo get_search_form(); ?>

            <nav id="header-secondary-navigation">
              <ul class="menu">
                <li class="menu-item cross-reference"><a href="<?php echo get_home_url(); ?>/resources/cross-reference/">Cross Reference</a></li>
              </ul>
            </nav>
          </div>

				  <nav id="header-primary-navigation">
				  	<?php
				  		wp_nav_menu( array(
				  			'theme_location' => 'header_primary',
				  			'container' => '',
				  			'menu_id' => 'header-primary-navigation-menu',
				  			'depth' => PRIMARY_MENU_MAX_DEPTH,
				  			'fallback_cb' => false,
				  			'walker' => new Crown_Theme_Walker_Nav_Menu_Header()
				  		) );
				  	?>
				  </nav>
							
				</div>

        <div id="header-buttons">
          <nav id="header-primary-cta-links">
            <div class="contact-us">
              <button id="contact-us-button"><a href="<?php echo get_home_url(); ?>/contact-us-main/">Contact Us</a></button>
            </div>
            <ul id="account-menu">
              <!-- <li class="menu-item log-in"><a href="https://salesportal.nsiindustries.com/account/signin">Log In</a></li> -->
                <?php // if ( function_exists( 'WC' ) && ! empty( WC()->cart->get_cart_contents_count() ) ) { ?>
                <?php
                $display_cart_in_header = apply_filters( 'display_cart_in_header', true );
                if ( is_user_logged_in() && $display_cart_in_header ) { ?>
                <li class="menu-item cart">
                  <a href="<?php echo wc_get_cart_url(); ?>">
                        <span class="icon">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                          </svg>
                        </span>
                    <span class="count"><?php echo WC()->cart instanceof \WC_Cart? WC()->cart->get_cart_contents_count() : '0'; ?></span>
                  </a>
                </li>
                <?php } ?>
                <?php // } ?>

                <?php

                $wc_session = WC()->session;
                $quote_item_count = 0;
                if ($wc_session) {
                    $quotes = (array)$wc_session->get('quotes');
                    $pricing_quotes = (array)$wc_session->get('quote_pricing_groups');
                    $context_key = get_current_user_contextual_quote_type_key();
                    $user_id = get_current_user_id();
                    $user_pricing = get_user_meta( $user_id, 'quote_pricing_groups', true );

                    if ( ! empty( $user_pricing ) ) {
                        $pricing_quotes = (array) $user_pricing;
                    }

                    $quote_url = get_page_link(get_option('addify_atq_page_id', true));
                    foreach ($quotes as $qoute_item) {
                        $quote_item_count += $qoute_item['quantity'] ?? 0;
                    }
                    $meta_data = get_user_meta( $user_id, $context_key, true );
                    $session   = WC()->session ? WC()->session->get( $context_key ) : null;

                    if ( ! empty( $meta_data['id'] ) ) {
                        $selected_quote_type = $meta_data['id'];
                    } elseif ( ! empty( $session['id'] ) ) {
                        $selected_quote_type = $session['id'];
                    } else {
                        $selected_quote_type = 0;
                    }
                    $quote_type_id = $selected_quote_type;
                    $has_discount_rules = ( get_post_meta( $quote_type_id, 'quote_type_discount_rules', true ) === 'yes' );

                    $quote_pricing_group_count = count( $pricing_quotes );
                } else {
                    $logger = wc_get_logger();
                    $logger->error('WC session was not created for getting quotes', array('source' => 'db_issues'));
                }
                ?>
                <?php if ( is_user_logged_in() && ( $quote_item_count > 0 || $has_discount_rules ) ) { ?>
                  <li class="menu-item quote">
                    <a href="<?php echo $quote_url; ?>">
											<span class="icon">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tag-fill" viewBox="0 0 16 16">
													<path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1H2zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
												</svg>
											</span>
                      <?php if ($has_discount_rules) { ?>
                        <span class="pricing-group-count"><?php echo $quote_pricing_group_count; ?></span>
                      <?php } ?>
                      <?php if ($quote_item_count > 0) { ?>
                      <span class="count"><?php echo $quote_item_count; ?></span>
                      <?php } ?>
                    </a>
                  </li>
                <?php } ?>
              <li class="menu-item cart">
                <a href="<?php echo get_site_url() . '/submittals'; ?>">Submittals</a>
              </li>

                <?php if ( ! is_user_logged_in() ) { ?>
                  <li class="menu-item cart"><a href="<?php echo get_site_url() . '/my-account/'; ?>">Log In</a></li>
                <?php } else { ?>
                  <li class="menu-item cart">
                    <a href="<?php echo get_site_url() . '/my-account'; ?>">Profile</a>
                  </li>
                  <?php
                  $current_url = home_url( add_query_arg( array(), $wp->request ) );

                  // Check if current page is /request-a-quote
                  if ( untrailingslashit( $current_url ) === untrailingslashit( home_url( '/request-a-quote' ) ) ) {
                      $redirect_url = wc_get_page_permalink( 'myaccount' ); // My Account page
                  } else {
                      $redirect_url = $current_url; // Default: current page
                  }
                  ?>
                  <li class="menu-item cart">
                    <a href="<?php echo esc_url( wp_logout_url( $redirect_url ) ); ?>">Log Out</a>
                  </li>
                <?php } ?>
            </ul>
          </nav>

        </div>

				<button id="mobile-menu-toggle" type="button">
					<span class="label">Menu</span>
					<span class="icon"></span>
				</button>
        <div class="header-logo-line"></div>
			</div>
		</div>
	</div>

</header>
