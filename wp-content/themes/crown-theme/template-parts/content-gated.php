<article id="main-article-gated" <?php post_class( 'gated-content' ); ?>>

	<div id="main-content-gated" class="entry-content">

		<div class="wp-block-crown-blocks-page-section full-width restricted-content-width content-align-center text-align-left">
			<div class="section-bg"></div>
			<div class="inner">
				<div class="container">
					<div class="inner" style="max-width:960px">

						<?php $gated_content_form = get_post_meta( get_the_ID(), 'page_content_gating_form', true ); ?>
						<?php gravity_form( $gated_content_form, true, true, false, null, false ); ?>

					</div>
				</div>
			</div>
		</div>

	</div><!-- .entry-content -->

</article><!-- .post -->