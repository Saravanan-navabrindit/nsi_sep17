<article id="main-article" <?php post_class(); ?>>
	<div <?php echo is_singular() ? 'id="main-content"' : ''; ?> class="entry-content">
		<div class="entry-content">

            <div class="inner">
                <div>
                    <?php if ( has_post_thumbnail() ) { ?>
                        <span class="logo-wrap"><?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium' ); ?></span>
                    <?php }  ?>
                </div>

                <div>
                    <p><?php echo get_the_content(); ?></p>
                </div>
            </div>

			<!-- <div class="wp-block-crown-blocks-page-section text-color-dark full-width" style="background-color:#f9f8f7;">
				<div class="section-bg"></div>
                    <div class="inner">
                        <div class="container">
                            <div class="inner">
                                <div class="entry-overview">
                                    <div class="inner">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?php //if ( has_post_thumbnail() ) { ?>
                                                    <span class="logo-wrap"><?php //echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium' ); ?></span>
                                                <?php //}  ?>
                                            </div>
                                            <div class="col-sm-8">
                                            <header class="entry-header">
                                                <div class="inner">

                                                <div class="contents">

                                                    <h3 class="entry-title"><?php //the_title(); ?></h3>
                                                    <div class="entry-content"><p><?php //echo get_the_content(); ?></p></div>

                                                </div>


                                                </div>
                                            </a>

                                            </header>


                                        </div>
                                    </div>
								
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			 -->
			
		</div>
	</div><!-- #main-content -->
</article><!-- main-article -->
