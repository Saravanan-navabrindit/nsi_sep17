<article id="main-article" <?php post_class(); ?>>

	<div id="main-content">

		<?php if ( class_exists( 'CrownBreadcrumbs' ) ) { ?>
			<div class="wp-block-crown-blocks-breadcrumbs">
				<?php echo CrownBreadcrumbs::getBreadcrumbs(); ?>
			</div>
		<?php } ?>

		<header class="entry-header">

			<h1 class="entry-title"><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ) { ?>
				<div class="entry-featured-image">
					<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'fullscreen' ); ?>
				</div>
			<?php } ?>

			<?php ct_social_sharing_links(); ?>

			<?php $tags = wp_get_post_tags( get_the_ID() ); ?>
			<?php if ( ! empty( $tags ) ) { ?>
				<ul class="entry-tags">
					<?php foreach ( $tags as $tag ) { ?>
						<li><?php echo $tag->name; ?></li>
					<?php } ?>
				</ul>
			<?php } ?>

		</header>

		<div class="content-sidebar-container">

			<div class="entry-content"><?php the_content( __( 'Continue reading', 'crown_theme' ) ); ?></div>

			<aside id="main-sidebar">
				<?php $related_post_ids = ct_get_related_posts( get_the_ID(), array(), array( 'fields' => 'ids' ) ); ?>
				<?php if ( ! empty( $related_post_ids ) ) { ?>
					<div class="widget">
						<h3 class="widget-title">Related Articles</h3>
						<?php $related_post_query = new WP_Query( array( 'post__in' => $related_post_ids, 'orderby' => 'post__in', 'order' => 'ASC', 'posts_per_page' => 2 ) ); ?>
						<?php while ( $related_post_query->have_posts() ) { ?>
							<?php $related_post_query->the_post(); ?>
							<?php get_template_part( 'template-parts/index-entry-content', get_post_type() ); ?>
						<?php } ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php } ?>
			</aside>

		</div>

	</div><!-- #main-content -->

	<?php if ( is_singular( array( 'post', 'client_story', 'event' ) ) ) { ?>
		<?php get_template_part( 'template-parts/entry-footer', get_post_type() ); ?>
	<?php } ?>

</article><!-- .post -->