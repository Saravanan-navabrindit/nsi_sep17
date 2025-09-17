<footer id="footer" role="contentinfo">
	<div class="container">
		
		<div class="upper">

			<div id="footer-company">

				<div class="contact-info">

					<?php if ( ( $image_id = get_option( 'theme_config_footer_logo' ) ) ) { ?>
						<a href="<?php echo home_url(); ?>" class="logo">
							<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
						</a>
					<?php } ?>

					<p class="adress"><?php echo nl2br( get_option( 'theme_config_contact_address' ) ); ?></p>

					<p class="phone"><?php echo get_option( 'theme_config_contact_phone' ); ?></p>

					<p class="email"><a href="mailto:<?php echo esc_attr( get_option( 'theme_config_contact_email' ) ); ?>"><?php echo get_option( 'theme_config_contact_email' ); ?></a></p>
					
				</div>

				<?php ct_social_links(); ?>

			</div>

			<nav id="footer-primary-navigation">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_primary',
						'container' => '',
						'menu_id' => 'footer-primary-navigation-menu',
						'depth' => 3,
						'fallback_cb' => false
					) );
				?>
			</nav>

		</div>

		<div class="lower">

			<p id="site-copyright"><?php echo str_replace( '%%year%%', date( 'Y' ), get_option( 'theme_config_footer_copyright' ) ); ?></p>

			<nav id="footer-legal-links">
				<?php
					wp_nav_menu( array(
						'theme_location' => 'footer_legal_links',
						'container' => '',
						'menu_id' => 'footer-legal-links-menu',
						'depth' => 1
					) );
				?>
			</nav>

		</div>

	</div>
    <app-version id="app-version" value=<?php
    echo App_Version::get_app_version('STD');
    ?>
    ></app-version>
</footer>
