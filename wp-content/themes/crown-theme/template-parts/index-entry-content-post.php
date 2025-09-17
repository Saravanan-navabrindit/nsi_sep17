<article <?php post_class( 'index-entry-post' ); ?>>

	<div class="entry-header">

		<div class="entry-featured-image">
			<a href="<?php the_permalink(); ?>">
				<?php if ( has_post_thumbnail() ) { ?>
					<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large' ); ?>
				<?php } ?>
			</a>
		</div>

		<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<p class="entry-date"><?php the_date(); ?></p>

	</div>

	<div class="entry-excerpt">
		<?php ct_the_excerpt( 20 ); ?>
	</div>

	<p class="entry-link">
		<a href="<?php the_permalink(); ?>" class="btn btn--link btn--link-pure-black btn--md link-arrow">Read More <span class="btn__arrow"></span></a>
	</p>

</article>