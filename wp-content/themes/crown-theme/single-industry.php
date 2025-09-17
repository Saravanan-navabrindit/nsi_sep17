<?php get_header(); ?>

<article id="main-article" <?php post_class(); ?>>
	<div <?php echo is_singular() ? 'id="main-content"' : ''; ?> class="entry-content">
		<div class="entry-content">

            <div class="inner">

				<?php 
					global $post;
					$post_slug = $post->post_name;
				
                    $args = array(
                        'post_type' => 'brand',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'brand_industry',
                                'field'    => 'slug',
                                'terms'    => $post_slug,
                            ),
                        ),
                    );
        
                    $query = new WP_Query( $args );

                ?>
                <?php if ($query->have_posts() ) { ?>
                    <div class="">
                       <?php while ( $query->have_posts() ) { 
                            $query->the_post(); ?>
                           
                        <?php if ( has_post_thumbnail() ) { ?>
                            <span class="logo-wrap"><?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'medium' ); ?></span>
                        <?php }  ?>

                        <p><?php the_title(); ?></p>

						<p><?php the_excerpt(); ?></p>

                        <?php } ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                <?php } ?>

            </div>

						
		</div>
	</div><!-- #main-content -->
</article><!-- main-article -->


<?php get_footer(); ?>
