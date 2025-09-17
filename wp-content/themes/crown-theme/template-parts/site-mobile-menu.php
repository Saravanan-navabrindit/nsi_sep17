<div id="mobile-menu">
	<div class="scrollable">
		<div class="inner">
			<div class="menu-contents">

				<header id="mobile-menu-header">
					<div class="upper">

						<button id="mobile-menu-search-toggle">
							<span class="icon"><?php ct_icon( 'search' ); ?></span>
							<span class="label">Search</span>
						</button>

						<button id="mobile-menu-close" type="button">
							<span class="label">Close</span>
							<span class="icon"></span>
						</button>

					</div>
					<div class="lower">

						<nav id="mobile-menu-primary-cta-links">
							<ul class="menu">
								<?php if ( ! is_user_logged_in() ) { ?>
									<li class="menu-item log-in"><a href="<?php echo get_site_url() . '/my-account/'; ?>">Log In</a></li>
								<?php } else { ?>
									<?php $current_url = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) ); ?>
									<li class="menu-item log-in"><a href="<?php echo esc_url( wp_logout_url( $current_url ) ); ?>">Log Out</a></li>
								<?php } ?>
								<li class="menu-item contact"><a href="<?php echo get_home_url(); ?>/contact-us-main/">Contact Us</a></li>
							</ul>
						</nav>

					</div>
				</header>

				<?php echo get_search_form(); ?>
	
				<nav id="mobile-menu-primary-navigation">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'mobile_menu_primary',
							'container' => '',
							'menu_id' => 'mobile-menu-primary-navigation-menu',
							'depth' => 3,
							'fallback_cb' => false,
							'walker' => new Crown_Theme_Walker_Nav_Menu_Mobile_Menu()
						) );
					?>
				</nav>

			</div>
		</div>
	</div>
</div>
