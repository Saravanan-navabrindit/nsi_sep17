
						</div><!-- .inner -->
					</div><!-- .container -->
				</div><!-- .inner -->
			</div><!-- #main -->

			<?php get_template_part( 'template-parts/site-pre-footer' ); ?>
			<?php get_template_part( 'template-parts/site-footer' ); ?>
		
		</div><!-- #page -->

		<?php get_template_part( 'template-parts/site-mobile-menu' ); ?>
		<?php get_template_part( 'template-parts/lightbox-gallery' ); ?>

		<?php get_template_part( 'template-parts/modal-subscribe' ); ?>
		<?php get_template_part( 'template-parts/modal-video' ); ?>

		<?php $modal_forms = ct_get_footer_modal_forms(); ?>
		<?php foreach( $modal_forms as $modal_form ) { ?>
			<?php get_template_part( 'template-parts/modal-form', null, array( 'form' => $modal_form ) ); ?>
		<?php } ?>

		<script>
			ctSetVw();
		</script>

		<?php wp_footer(); ?>

<script type="text/javascript"> _linkedin_partner_id = "4575020";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id); </script>
<script type="text/javascript"> (function (l) {
    if (!l) {
        window.lintrk = function (a, b) {
            window.lintrk.q.push([a, b])
        };
        window.lintrk.q = []
    }
    var s = document.getElementsByTagName("script")[0];
    var b = document.createElement("script");
    b.type = "text/javascript";
    b.async = true;
    b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
    s.parentNode.insertBefore(b, s);
})(window.lintrk); </script>
<noscript><img alt="" height="1" src="https://px.ads.linkedin.com/collect/?pid=4575020&fmt=gif" style="display:none;"
               width="1"/></noscript>

                        <!-- Start of HubSpot Embed Code -->
                        <script type="text/javascript" id="hs-script-loader" async defer
                                src="//js.hs-scripts.com/20940542.js"></script>
                        <!-- End of HubSpot Embed Code -->
	</body>

</html>
